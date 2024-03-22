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

class FillrateExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting, WithProperties, WithEvents, WithPreCalculateFormulas
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $cuentafilas,$codprov;

    public function __construct(String $codprov)
    {
        $this->codprov = $codprov;
    }

    public function headings(): array
    {
        return [
            ['Reporte Fillrate'],
            ['Del 23 Ene al 20 Feb'],
            ['Proveedor',
            'Nro Orden',
            'Tipo OC',
            'Cod Sku',
            'SKU',
            'Unids Solicitadas',
            'Unids Recibidas',            
            'Unids Pendientes',
            '%Fillrate',
            'Penalidad Generada'
            ]          
        ];
    }

    public function collection()
    {
        $codprov = $this->codprov;
        
        $provfillrate = DB::table('pn_fillrate_temp')
                    ->select('PROVEEDOR',
                            'NROORDEN', 
                            'TIPOOC', 
                            'COD_SKU',
                            'SKU', 
                            'CANTIDADTOTALSOLICITADA',
                            'CANTIDADRECEPCIONADA',   
                            'DIFCANREC',
                            'FILLRATE',
                            'LUCROCESAN')                    
                    ->where('id_descripcion','Febrero2024')
                    ->where('FLAG_OCABIERTA','NO')                
                    ->where('ESTADO','Recepcion Completa')        
                    ->where('CODPROVEEDOR','like','%'.$codprov.'%')
                    ->where('FECHAREALRECEPCION','')              
                    ->orderBy('NROORDEN')
                    ->get();

        $this->cuentafilas = count($provfillrate);

        return $provfillrate;
    }

    public function styles(Worksheet $sheet)
    {

        $filafin = $this->cuentafilas + 3;
        $celdafinal = $filafin + 1;        
        $sheet->setCellValue("I{$celdafinal}", "TOTAL");
        $sheet->setCellValue("J{$celdafinal}", "=SUM(J4:J{$filafin})");

        return [
            // Style the first row as bold text.
            3    => ['font' => ['bold' => true, 'size' => 12]],            
            'A' => ['font' => ['bold' => true]],
            'A1'    => ['font' => ['bold' => true, 'size' => 16]],
            'A2'    => ['font' => ['bold' => true, 'size' => 12]],
            'I' => ['font' => ['0%']]

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
            'title'          => 'Reporte de Fillrate',
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