<?php

namespace App\Http\Controllers;

use App\Exports\TcoExport;
use App\Exports\TcoExportNormal;
use App\Exports\NsExport;
use App\Exports\FillrateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;


class ReporteController extends Controller
{
    //
    public function generareporte(){

         $provporcentajes = DB::table('pn_coblog_tco')
            ->select('Proveedor')
            ->distinct()
            ->where('tipo_proveedor','cobro%')
            ->where('Tipo_Marca','TERCERAS')
            ->where('id_descripcion','Diciembre2023')  
            ->where('sis_vigencia',1)
            //->wherein('id_descripcion',['Junio2021_aldeas','Julio2021_aldeas'])
            // ->where('Proveedor','like','%full bik%')                                    
            ->get();
       
        foreach ($provporcentajes as $provporcentaje) {
            
            $reporte = new TcoExport($provporcentaje->Proveedor);

            Excel::store($reporte, $provporcentaje->Proveedor.'.xlsx','public');
        }

          return 'Listo reportes %';        
    }

    public function generareportenormal(){

       $provcobrototales = DB::table('pn_coblog_tco')
            ->select('Proveedor')
            ->distinct()
            ->where('tipo_proveedor','tarifario')
            ->where('Tipo_Marca','TERCERAS')
            ->where('id_descripcion','Diciembre2023')
            ->where('sis_vigencia',1)
            //->wherein('id_descripcion',['Junio2021_aldeas','Julio2021_aldeas'])
            //->where('Proveedor','like','%day of%')                                    
            ->get();
       
       foreach ($provcobrototales as $provcobrototal) {
           
           $reporte = new TcoExportNormal($provcobrototal->Proveedor);

           Excel::store($reporte, $provcobrototal->Proveedor.'.xlsx','public');
       }

       return 'Listo reportes normal';       
       
   }

   public function generareportefr(){

    $provfillrate = DB::table('pn_fillrate_temp')
        ->select('CODPROVEEDOR','PROVEEDOR')
        ->distinct() 
        ->where('id_descripcion','Diciembre2023')                
        ->where('FLAG_OCABIERTA','NO')                
        ->where('ESTADO','Recepcion Completa')             
        //->where('PROVEEDOR','like','%NEWELL%')         
        ->get();
    
    foreach ($provfillrate as $provfr) {
        
        $reporte = new FillrateExport($provfr->CODPROVEEDOR);

        Excel::store($reporte, $provfr->PROVEEDOR.'.xlsx','public');
    }

    return 'Listo Reportes FR';       
    
    }

    public function generareportens(){

        $mes = [12];
        $semana = 20;

        //$provnivelservicio = DB::table('pn_nivelservicio_temp_lrvl')
        $provnivelservicio = DB::table('pn_nivelservicio_temp')
            ->select('RUC','RAZON_SOCIAL')
            ->distinct() 
            //->where('id_descripcion','cargainicial')
            //->where('SEMANA','18')
            ->whereIn('mes',$mes)
            //->where('PROVEEDOR','like','%NEWELL%')         
            ->get();
        
        foreach ($provnivelservicio as $provns) {
            
            $reporte = new NsExport($provns->RUC,$mes,$semana);//RUCPROVEEDOR, MES, SEMANA
    
            Excel::store($reporte, $provns->RAZON_SOCIAL.'.xlsx','public');
        }
    
        return 'Listo Reportes NS';       
        
        }
    
}