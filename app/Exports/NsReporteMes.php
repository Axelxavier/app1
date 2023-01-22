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


class NsReporteMes implements FromCollection, 
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

    public function __construct(String $ruc, $mes, $semana)
    {
        $this->ruc = $ruc;
        $this->mes = $mes;
        $this->semana = $semana;
    }

    public function headings(): array
    {
        return [            
            ['Mes',            
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
        $mes = $this->mes;
        $semana = $this->semana;

        //$reporteNS = DB::table('pn_nivelservicio_temp_lrvl')
        $reporteNS = DB::table('pn_nivelservicio_temp')
        ->select('MES',
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
        ->whereIn('MES',$mes)
        ->groupBy('MES')        
        ->orderBy('MES','DESC')
        ->get();

        $this->cuentafilas = count($reporteNS);

        return $reporteNS;

    }

    public function title(): string
    {
        return 'Reporte Mes';
    }

    public function styles(Worksheet $sheet)
    {
        $filafin = $this->cuentafilas + 1;
        $celdafinal = $filafin + 1;        
        $sheet->setCellValue("B{$celdafinal}", "=SUM(B2:B{$filafin})");
        $sheet->setCellValue("C{$celdafinal}", "=SUM(C2:C{$filafin})");
        $sheet->setCellValue("D{$celdafinal}", "=SUM(D2:D{$filafin})");
        $sheet->setCellValue("E{$celdafinal}", "=SUM(E2:E{$filafin})");
        $sheet->setCellValue("F{$celdafinal}", "=B{$celdafinal}/(B{$celdafinal}+C{$celdafinal}+D{$celdafinal})");
        $sheet->setCellValue("G{$celdafinal}", "=SUM(G2:G{$filafin})");

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
            'F' => NumberFormat::FORMAT_PERCENTAGE_00,      
        ];
    }
    
}
