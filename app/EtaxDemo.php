<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtaxDemo extends Model
{
    //
    protected $table = 'etax_demo';

    protected $fillable = [
        'corporate_id',
        'reference_code',
        'document_code',
        'document_type',
        'invoice_number',
        'batch_name',
        'branch_code',
        'name',
        'email',
        'status',
        'pdf_file',
        'xml_file',
        'total_amount',
        'due_date',
        'export_date',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
