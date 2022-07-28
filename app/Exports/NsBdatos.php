<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class NsBdatos implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(String $ruc, $semana)
    {
        $this->ruc = $ruc;
        $this->semana = $semana;
    }

    public function headings(): array
    {
        return [            
            ['CUD',
            'Orden de Compra',
            'Descripcion Producto',
            'Fecha Venta',
            'Flujo',
            'Fecha programada (DVR,DVO)',
            'Fecha despacho / recepcion (DVR,DVO)',
            'Fecha programada (Sólo DDC)',
            'Fecha Entrega cliente (Sólo DDC)',
            'Unidades',
            'Estado B2B',
            'Penalidad Generada',
            'Status NS',
            'Mes',
            'Semana'          
            ]          
        ];
    }

    public function collection()
    {
        $ruc = $this->ruc;
        $semana = $this->semana;

        $dataNS = DB::table('pn_nivelservicio_temp_lrvl')
        ->select('CUD',
                'OC_PMM',
                'DESCRIPCION_PRODUCTO', 
                'FECHA_VENTA', 
                'FLUJOS_PROV_VERDE', 
                'FECHA_PROGRAMADA_INGRESO_CD',
                'FECHA_RECIBIDO_RIPLEY', 
                'FECHA_DESPACHO_PROMETIDA', 
                'FECHA_ENTREGADO_CONFORME_HORA', 
                'UNIDADES',
                'ESTADO_FLUJO',
                'MONTO_A_FACTURAR',
                'STATUS',
                'MES',
                'SEMANA')                    
        //->where('id_descripcion','cargainicial')                                            
        ->where('RUC',$ruc)
        ->where('MES',3)
        //->where('SEMANA',$semana)
        ->orderBy('MES','DESC')
        ->orderBy('SEMANA','DESC')
        ->get();

        return $dataNS;

    }

    public function title(): string
    {
        return 'Datos';
    }
}
