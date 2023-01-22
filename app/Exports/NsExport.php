<?php

namespace App\Exports;

use App\Exports\NsBdatos;
use App\Exports\NsReporte;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class NsExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */    

    public function __construct(String $ruc, $mes, $semana)
    {
        $this->ruc = $ruc;
        $this->mes = $mes;
        $this->semana = $semana;
    }

    public function sheets(): array
    {
        $ruc = $this->ruc;
        $mes = $this->mes;
        $semana = $this->semana;

        $sheets = [];
        
        $sheets[0] = New NsReporteMes ($ruc,$mes,$semana);

        $sheets[1] = New NsReporteSem ($ruc,$mes,$semana);

        $sheets[2] = New NsBdatos ($ruc,$mes,$semana);       
       
        return $sheets;
    }
}
