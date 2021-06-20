<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogCallbackEtax extends Model
{
    //
    protected $table = 'log_callback_etax';

    protected $fillable = [
        'success',
        'response_code',
        'invoice_number',
        'status_file',
        'document',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

}
