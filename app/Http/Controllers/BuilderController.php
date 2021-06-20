<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Middleware\AuthToken;
use Illuminate\Support\Facades\Validator;
use PDF;

class BuilderController extends Controller
{
    public function create()
    {
        return view('builder.create');
    }

    public function pdf_report()
    {
        $pdf = PDF::loadView('builder.pdf');
        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true , 'dpi' => 150]);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('PDF.pdf');
    }
}
