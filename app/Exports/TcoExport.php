<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;
use Maatwebsite\Excel\Facades\Excel;

class TcoExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting, WithProperties, WithEvents, WithPreCalculateFormulas
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $cuentafilas;

    public function __construct(String $nomprov)
    {
        $this->nomprov = $nomprov;
    }

    public function headings(): array
    {
        return [
            ['Liquidación de Servicios Logisticos'],
            ['Del 21 May al 20 Jun'],
            ['Proveedor',
            'Division',
            'Fecha Proceso',
            'Documento',
            'Marca',
            'Tipo despacho',
            'Tipo Producto',
            'Tarifa Verde',
            'Unidades Cross',
            'Unidades Pick',
            'Unidades Dev',
            'Unidades Verde',
            'Val Cross S/',
            'Val Pick S/',
            'Val Dev S/',
            'Costolog Verde S/',
            '% Aplicado',
            'Costo Logistico S/']          
        ];
    }

    public function collection()    
    {      
        $nomprov = $this->nomprov;
        
        $provporcentajes = DB::table('pn_coblog_tco')
            ->select('Proveedor', 
                'Division', 
                'Fecha_Proceso',
                'Documento', 
                'Marca',
                'Tipo_despacho',
                'Tipo_Producto',
                'tarifa_s_verdes',
                'unidades_cross',
                'unidades_pick',
                'unidades_dev',
                'unidades_verdes',
                'stock_s_cross', 
                'stock_s_pick', 
                'stock_s_dev', 
                'costolog_s_verdes', 
                'descuento_aplicado', 
                'monto_aplicado')                    
            ->where('tipo_proveedor','cobro%')
            ->where('Tipo_Marca','TERCERAS')
            ->where('id_descripcion','Junio2022')
            //->wherein('id_descripcion',['Junio2021_aldeas','Julio2021_aldeas'])
            ->where('Proveedor','like','%'.$nomprov.'%')                    
            ->get();

        $this->cuentafilas = count($provporcentajes);

        return $provporcentajes;
    }

    public function styles(Worksheet $sheet)
    {        
        $filafin = $this->cuentafilas + 3;
        $celdafinal = $filafin + 1;        
        $sheet->setCellValue("Q{$celdafinal}", "TOTAL");
        $sheet->setCellValue("R{$celdafinal}", "=SUM(R4:R{$filafin})");
        
        return [
            // Style the first row as bold text.
            3    => ['font' => ['bold' => true, 'size' => 12]],            
            'A' => ['font' => ['bold' => true]],
            'A1'    => ['font' => ['bold' => true, 'size' => 16]],
            'A2'    => ['font' => ['bold' => true, 'size' => 12]],

        ];
    }

    public function columnFormats(): array
    {
        return [
            
            
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Harry Carreño',            
            'title'          => 'Liquidación Servicios Logisticos',
        ];
    }

    public function registerEvents(): array
    {
        return [            
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle(
                    'A3:N3',
                    [
                        'borders' => [
                            'outline' => [      
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,                         
                                'color' => ['argb' => 'FFFF0000'],
                            ],
                        ]
                    ]
                );
            },
        ];
    }
}