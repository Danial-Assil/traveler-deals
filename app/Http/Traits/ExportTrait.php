<?php

namespace App\Http\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;

trait ExportTrait
{


    public function exportToPdf(Request $request)
    {
        // ini_set('display_errors', 'on');
        // ini_set('log_errors', 'on');
        // ini_set('display_startup_errors', 'on');
        // ini_set('error_reporting', E_ALL);

        set_time_limit(6400);
        ini_set('memory_limit', -1);

        $items = $this->filter()->get()->sortBy('date', null, 'asc')->reverse();

        $pdf = PDF::loadView('dash.pages.' . $this->module_name . '.data-pdf', ['items' =>  $items, 'columns' =>  $request->columns])
            ->setPaper('a4', 'landscape');
            
        $file_name = $request->file_name ?? $this->module_name . '-' . Carbon::today()->format('Y-m-d');
 
        return $pdf->download($file_name . '.pdf');
    }
}
