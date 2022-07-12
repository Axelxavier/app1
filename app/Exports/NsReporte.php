<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;


class NsReporte implements FromCollection, 
WithHeadings, 
WithColumnFormatting, 
ShouldAutoSize, 
WithTitle,
WithStyles,
WithPreCalculateFormulas

{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $cuentafilas;

    public function __construct(String $ruc, $semana)
    {
        $this->ruc = $ruc;
        $this->semana = $semana;
    }

    public function headings(): array
    {
        return [            
            ['Mes',
            'Semana',
            'Flujo',
            'CUDs a tiempo',
            'CUDs con retraso',
            'CUDs Observados',
            'CUDs No considerdos',
            'Nivel de servicio',
            'Penalidad Generada'                   
            ]          
        ];
    }

    public function collection()
    {
        $ruc = $this->ruc;
        $semana = $this->semana;

        $reporteNS = DB::table('pn_nivelservicio_temp_lrvl')
        ->select('MES',
                'SEMANA',
                'FLUJOS_PROV_VERDE', 
                DB::raw('SUM(ATIEMPO)'), 
                DB::raw('SUM(RETRASADO)'),
                DB::raw('SUM(OBSERVADO)'),
                DB::raw('SUM(NOCONSIDERADO)'),
                DB::raw('SUM(ATIEMPO)/(SUM(ATIEMPO)+SUM(RETRASADO)+SUM(OBSERVADO))'),
                DB::raw('SUM(MONTO_A_FACTURAR)')
                )

        //->where('id_descripcion','cargainicial')                                            
        ->where('RUC',$ruc)
        //->where('SEMANA',$semana)
        ->where('MES',2)
        ->groupBy('MES')
        ->groupBy('SEMANA')
        ->groupBy('FLUJOS_PROV_VERDE')
        ->orderBy('SEMANA','DESC')
        ->get();

        $this->cuentafilas = count($reporteNS);

        return $reporteNS;

    }

    public function title(): string
    {
        return 'Reporte';
    }

    public function styles(Worksheet $sheet)
    {
        $filafin = $this->cuentafilas + 1;
        $celdafinal = $filafin + 1;        
        $sheet->setCellValue("D{$celdafinal}", "=SUM(D2:D{$filafin})");
        $sheet->setCellValue("E{$celdafinal}", "=SUM(E2:E{$filafin})");
        $sheet->setCellValue("F{$celdafinal}", "=SUM(F2:F{$filafin})");
        $sheet->setCellValue("G{$celdafinal}", "=SUM(G2:G{$filafin})");
        $sheet->setCellValue("H{$celdafinal}", "=D{$celdafinal}/(D{$celdafinal}+E{$celdafinal}+F{$celdafinal})");
        $sheet->setCellValue("I{$celdafinal}", "=SUM(I2:I{$filafin})");

        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true, 'size' => 12]],            
            //'{$celdafinal}' => ['font' => ['bold' => true]],
            //'A1'    => ['font' => ['bold' => true, 'size' => 16]],
            //'A2'    => ['font' => ['bold' => true, 'size' => 12]],
            //'H' => ['font' => ['0%']]            
        ];

    }

    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_PERCENTAGE_00,      
        ];
    }
    
}
