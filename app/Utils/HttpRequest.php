<?php

namespace App\Utils;

use App\Models\Configuration;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HttpRequest
{
    protected static $baseUri;


    protected static $defaultHeaders = [
        'Content-Type' => 'application/json',
    ];
    protected static function baseUri($type)
    {
        if ($type == 'dapv2') {
            return  Config::get('dapv2.' . env('APP_ENV') . '.API_DOMAIN');
        } else if ($type == 'edc-internal') {
            return  Config::get('edc-internal.' . env('APP_ENV') . '.API_DOMAIN');
        } else if ($type == 'pcore') {
            return  Config::get('pcore.' . env('APP_ENV') . '.API_DOMAIN');
        }
    }

    public static function get($endpoint, $headers = [], $type = 'dapv2')
    {
        $config = Configuration::where('service_type', 'timeout')->first();
        $setting = $config['setting'];
        $time = json_decode($setting);
        $timeout = $time->timeout;
        $headers = array_merge(self::$defaultHeaders, $headers);
        $url = self::baseUri($type) . '/' . ltrim($endpoint, '/');
        return Http::withHeaders($headers)->withOptions([
            'verify' => false,
        ])->timeout($timeout)->get($url);
    }

    public static function post($endpoint, $data = [], $headers = [], $type = 'dapv2', $timeoutInSeconds = 30, $trustSelfSigned = false)
    {
        $config = Configuration::where('service_type', 'timeout')->first();
        if ($config != null && $config['setting'] != null) {
            $setting = $config['setting'];
            $time = json_decode($setting);
            $timeout = $time->timeout;
        } else {
            $timeout = $timeoutInSeconds;
        }
        $headers = array_merge(self::$defaultHeaders, $headers);
        $url = self::baseUri($type) . '/' . ltrim($endpoint, '/');

        if ($trustSelfSigned) {
            return Http::withHeaders($headers)->withOptions([
                'verify' => false,
            ])->timeout($timeout)->withoutVerifying()->post($url, $data);
        }
        return Http::withHeaders($headers)->timeout($timeout)->post($url, $data);
    }
    public static function postPool($endpoint, $data = [], $headers = [], $type = 'dapv2')
    {
        $config = Configuration::where('service_type', 'timeout')->first();
        $setting = $config['setting'];
        $time = json_decode($setting);
        $timeout = $time->timeout;
        $headers = array_merge(self::$defaultHeaders, $headers);
        $url = self::baseUri($type) . '/' . ltrim($endpoint, '/');

        $response = Http::pool(function (Pool $pool) use ($url, $data, $headers, $timeout) {
            return $pool->withHeaders($headers)
                ->timeout($timeout)
                ->post($url, $data);
        });

        // Process the responses
        foreach ($response as $singleResponse) {
            // Handle the individual response
            if ($singleResponse->successful()) {
                return $singleResponse;
            } else {
                return $singleResponse;
            }
        }
    }

    public static function postForm($url, $data, $headers = [])
    {
        $response = Http::withHeaders($headers)->withOptions([
            'verify' => false,
        ])->asForm()->post($url, $data);
        return self::handleResponse($response);
    }

    public static function postJson($url, $payload = [], $headers = [])
    {
        $response = Http::withHeaders($headers)->withOptions([
            'verify' => false,
        ])->post($url, $payload);
        return self::handleResponse($response);
    }

    public static function getJson($url, $headers = [])
    {
        $response = Http::withHeaders($headers)->withOptions([
            'verify' => false,
        ])->get($url);
        return self::handleResponse($response);
    }

    public static function putJson($url, $payload = [], $headers = [])
    {
        $response = Http::withHeaders($headers)->withOptions([
            'verify' => false,
        ])->put($url, $payload);
        return self::handleResponse($response);
    }

    public static function deleteJson($url,  $headers = [], $payload = [])
    {
        $response = Http::withHeaders($headers)->withOptions([
            'verify' => false,
        ])->delete($url, $payload);

        return self::handleResponse($response);
    }

    private static function handleResponse($response)
    {
        if ($response->successful()) {
            return $response;
        }

        // If the response is not successful, throw an exception with a JSON-formatted message
        $body = json_decode($response->body(), true);

        if (json_last_error() === JSON_ERROR_NONE && isset($body['errors'])) {
            $errorMessage = json_encode(['errors' => $body['errors']]);
        } else {
            $errorMessage = 'Error: ' . $response->body();
        }

        throw new \Exception($errorMessage, $response->status());
    }
}
