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

    public function __construct(String $ruc, $semana)
    {
        $this->ruc = $ruc;
        $this->semana = $semana;
    }

    public function sheets(): array
    {
        $ruc = $this->ruc;
        $semana = $this->semana;

        $sheets = [];
        
        $sheets[0] = New NsReporte ($ruc,$semana);

        $sheets[1] = New NsBdatos ($ruc,$semana);       
       
        return $sheets;
    }
}
