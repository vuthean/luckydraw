<?php

namespace App\Console\Commands;

use App\Events\CustomerImported;
use App\Services\CBSDataImportService;
use App\Traits\LuckyDrawDate;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class dataImport extends Command
{
    use LuckyDrawDate;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data-from-cbs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used for sync data from cbs to lucky draw';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /** log cron information */
        $currentDate = Carbon::now();
        Log::channel('cbs_connection')->info("Schedule run on date :{$currentDate} successfully.");

        /** import data from CBS */
        $success = $this->importDataFromCBS();
        if (!$success) {
            $setting = config('setting');
            $tryTime = $setting['cbs_import_retry_times'];
            $success = $this->retryToImportDataFromCBSFor($tryTime);
        }

        /** generate tikets by dispatch one event to listener for generating ticked*/
        if ($success) {
            $luckyDrawDate = $this->getLuckyDrawDate();
            $month = $luckyDrawDate->month;
            CustomerImported::dispatch($month);
        } else {
            Log::channel('cbs_connection')->info("Schedule run on date: {$currentDate} is successfully but failed to import data from cbs. Please go to check operationFaileLog database for more details.");
        }
    }

    private function importDataFromCBS()
    {
        $cbsService = new CBSDataImportService();
        $customers  = $cbsService->importCustomer();
        return collect($customers)->isNotEmpty();
    }

    private function retryToImportDataFromCBSFor($retryTimes)
    {
        $customers = $this->importDataFromCBS();
        if (collect($customers)->isNotEmpty()) {
            return true;
        }

        /** retry to import again */
        $tryTime = 1;
        do {
            $customers = $this->importDataFromCBS();
            if (collect($customers)->isEmpty()) {
                $tryTime += 1;
            } else {
                break;
            }
        } while ($tryTime < $retryTimes);

        return collect($customers)->isNotEmpty();
    }
}
