<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Blamable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerUpload extends Model
{
    use HasFactory;
    use Blamable;

    protected $table = 'customer_uploads';
    protected $fillable = [
        'status',
        'file_name'
    ];

    public static function insertData($filename, $userId){
        $customer = new CustomerUpload();
        $customer->file_name = $filename;
        $customer->created_by = $userId;
        $customer->updated_by = $userId;
        $customer->save();
    }
}
