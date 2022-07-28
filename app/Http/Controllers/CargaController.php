<?php

namespace App\Http\Controllers;

use App\Models\Tco;
use App\Models\Fillrate;
use App\Models\NivelServicio;
use Illuminate\Http\Request;

class CargaController extends Controller
{
    //funcion cargatco, ojo antes de usarla es necesario convertir
    //el archivo tco a csv, validar que las comas de los nros no se
    //crucen con las del archivo
    public function cargatco(){
        
        //antes es necesario copiar el archivo cargatco en la ruta public
        $path = public_path('cargatco.csv');      
            
        //$path = html_entity_decode($path, ENT_QUOTES | ENT_HTML401, "UTF-8");
        //lines nos devuelve un array por linea del archivo
        $lines = file($path);
        //utf8 para eliminar los errores con la condificación
        //array map aplica la funcion a cada elemento del array        
        $utf8_lines = array_map('utf8_encode',$lines);
        //$utf8_lines = array_map('html_entity_decode',$lines);
        //var_dump($utf8_lines);
        //str_getcsv organiza en un array cada elemento
        $array = array_map('str_getcsv',$utf8_lines);       

        //return sizeof($array);
        //return $array;

        //si el archivo está separado por puntos y comas es necesario primero reemplazar las comas x nada y luego reemplazar los puntos y comas por comas

        for ($i=1; $i < sizeof($array); $i++) { 
            $j=0;
            $tco = new Tco();
            $tco->proveedor = $array[$i][$j]; $j=$j+1;
            $tco->Ruc = $array[$i][$j]; $j=$j+1;
            $tco->Division = $array[$i][$j]; $j=$j+1;
            $tco->Departamento = $array[$i][$j]; $j=$j+1;
            $tco->Fecha_Proceso = $array[$i][$j]; $j=$j+1;
            $tco->Documento = $array[$i][$j]; $j=$j+1;
            $tco->Marca = $array[$i][$j]; $j=$j+1;
            $tco->Tipo_Producto = $array[$i][$j]; $j=$j+1;
            $tco->Tipo_Marca = $array[$i][$j]; $j=$j+1;
            $tco->sucursal_recp = $array[$i][$j]; $j=$j+1;
            $tco->Mh_orig = $array[$i][$j]; $j=$j+1;
            $tco->tipo_despacho = $array[$i][$j]; $j=$j+1;
            $tco->Tarifa_s_cross = $array[$i][$j]; $j=$j+1;
            $tco->tarifa_s_pick = $array[$i][$j]; $j=$j+1;
            $tco->tarifa_s_dev = $array[$i][$j]; $j=$j+1;
            $tco->tarifa_s_verdes = $array[$i][$j]; $j=$j+1;
            $tco->unidades_cross = $array[$i][$j]; $j=$j+1;
            $tco->unidades_pick = $array[$i][$j]; $j=$j+1;
            $tco->unidades_dev = $array[$i][$j]; $j=$j+1;
            $tco->unidades_verdes = $array[$i][$j]; $j=$j+1;
            $tco->stock_s_cross = $array[$i][$j]; $j=$j+1;
            $tco->stock_s_pick = $array[$i][$j]; $j=$j+1;
            $tco->stock_s_dev = $array[$i][$j]; $j=$j+1;
            $tco->stock_s_verdes = $array[$i][$j]; $j=$j+1;
            $tco->costolog_s_cross = $array[$i][$j]; $j=$j+1;
            $tco->costolog_s_pick = $array[$i][$j]; $j=$j+1;
            $tco->costolog_s_dev = $array[$i][$j]; $j=$j+1;
            $tco->costolog_s_verdes = $array[$i][$j]; 

            $tco->save();
            
        }
        return('Carga del TCO exitosa!');
    }

    public function cargafr(){
        
        //antes es necesario copiar el archivo cargatco en la ruta public
        $path = public_path('cargafr.csv');          
        
        //lines nos devuelve un array por linea del archivo
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);        
        //return sizeof($lines);
        //utf8 para eliminar los errores con la condificación
        //array map aplica la funcion a cada elemento del array
        //$utf8_lines = array_map('html_entity_decode',$lines);
        $utf8_lines = array_map('utf8_encode',$lines);
        //return $utf8_lines;
        //str_getcsv organiza en un array cada elemento
        $array = array_map('str_getcsv',$utf8_lines);       
        //return $array;

        //return sizeof($array);

        for ($i=1; $i < sizeof($array); $i++) { 

            $fr = new Fillrate();
            $fr->FLAG_OCABIERTA = $array[$i][0];
            $fr->DPTO = $array[$i][1];
            $fr->CODAREA = $array[$i][2];
            $fr->AREA = $array[$i][3];
            $fr->CODDIVISION = $array[$i][4];
            $fr->DIVISION = $array[$i][5];
            $fr->CODDPTO = $array[$i][6];
            $fr->CODMARCA = $array[$i][7];
            $fr->MARCA = $array[$i][8];
            $fr->CODPROVEEDOR = $array[$i][9];
            $fr->PROVEEDOR = $array[$i][10];
            $fr->CODSUC = $array[$i][11];
            $fr->SUCURSAL = $array[$i][12];
            $fr->NROORDEN = $array[$i][13];
            $fr->TIPOOC = $array[$i][14];
            $fr->COD_SKU = $array[$i][15];
            $fr->SKU = $array[$i][16];
            $fr->ESPREDISTRIBUIDA = $array[$i][17];
            $fr->FECHAEMISION = $array[$i][18];
            $fr->FECHACANCELACION = $array[$i][19];

            $fr->FECHAPROXRECEP = $array[$i][20];
            $fr->FECHAESPERADAEMBARQUE = $array[$i][21];
            $fr->FECHAREALEMBARQUE = $array[$i][22];
            $fr->FECHAREALRECEPCION = $array[$i][23];
            $fr->FECHAULTIMARECEPCION = $array[$i][24];
            $fr->FECHAINGRESO = $array[$i][25];
            $fr->FECHAACTUALIZACION = $array[$i][26];
            $fr->ESTADO = $array[$i][27];
            $fr->TEMPORADA = $array[$i][28];
            $fr->PAIS = $array[$i][29];

            $fr->PROCEDENCIA = $array[$i][30];
            $fr->CONDIFRECCANT = $array[$i][31];
            $fr->CANTIDADTOTALSOLICITADA = $array[$i][32];
            $fr->COSTOSOLICITADO = $array[$i][33];
            $fr->CANTIDADRECEPCIONADA = $array[$i][34];
            $fr->COSTORECEPCION = $array[$i][35];
            $fr->VIGENCIAOC = $array[$i][36];
            $fr->ESTADOVIGENCIAOC = $array[$i][37];
            $fr->ESTADOFILLRATE = $array[$i][38];

            $fr->DIASVENCIM = $array[$i][39];
            $fr->ESTADODIASVENCIM = $array[$i][40];
            $fr->DIFCANREC = $array[$i][41];
            $fr->FILLRATE = $array[$i][42];
            $fr->INDICADOR = $array[$i][43];
            $fr->PREBLA = $array[$i][44];
            $fr->PREBLASIGV = $array[$i][45];
            $fr->DSCTOPROM = $array[$i][46];
            $fr->CONTRUNIPY = $array[$i][47];
            $fr->FILLRATETARGET = $array[$i][48];

            $fr->UND_LUCROCESAN = $array[$i][49];
            $fr->LUCROCESAN = $array[$i][50];
            $fr->FECINI = $array[$i][51];
            $fr->FECFIN = $array[$i][52];
            $fr->IND_OC = $array[$i][53];
            $fr->GMUNIT = $array[$i][54];
            $fr->PREPROMVTA = $array[$i][55];
            $fr->GASADM = $array[$i][56];
            $fr->GMUNITSGA = $array[$i][57];
            $fr->CONTRIUNITDGA = $array[$i][58];

            $fr->DSCTOCOMP = $array[$i][59];
            $fr->LUCESUNI = $array[$i][60];
            $fr->GLOSA = $array[$i][61];
            $fr->GMPROM = $array[$i][62];
            $fr->FECINI2 = $array[$i][63];
            $fr->FECFIN2 = $array[$i][64];
            $fr->excepcion = $array[$i][65];   

            $fr->save();
            
        }
        return('Carga de Fr exitosa!');
    }

    public function cargans(){
        
        //antes es necesario copiar el archivo cargatco en la ruta public
        $path = public_path('cargaNS.csv');          
        
        //lines nos devuelve un array por linea del archivo
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);        
        //return sizeof($lines);
        //utf8 para eliminar los errores con la condificación
        //array map aplica la funcion a cada elemento del array
        $utf8_lines = array_map('utf8_encode',$lines);
        //return $utf8_lines;
        //str_getcsv organiza en un array cada elemento
        $array = array_map('str_getcsv',$utf8_lines);       
        //return $array;

        //return sizeof($array);

        for ($i=1; $i < sizeof($array); $i++) { 
            
            $j=0;
            $Ns = new NivelServicio();
            $Ns->ORDEN_COMPRA = $array[$i][$j];$j=$j+1;
            $Ns->OC_PMM = $array[$i][$j];$j=$j+1;
            $Ns->CUD = $array[$i][$j];$j=$j+1;
            $Ns->NS_RECIBIDO_RIPLEY = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_RECIBIDO_RIPLEY = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_PROGRAMADA_INGRESO_CD = $array[$i][$j];$j=$j+1;
            $Ns->SC_CUMP_DVR_DVO = $array[$i][$j];$j=$j+1;
            $Ns->RESPONSABLE = $array[$i][$j];$j=$j+1;
            $Ns->SUC_RESERVA_HOM = $array[$i][$j];$j=$j+1;
            $Ns->RUC = $array[$i][$j];$j=$j+1;
            $Ns->CLIENTE_DNI = $array[$i][$j];$j=$j+1;
            $Ns->CLIENTE_NOMBRE = $array[$i][$j];$j=$j+1;
            $Ns->ESTADO_FLUJO = $array[$i][$j];$j=$j+1;
            $Ns->ORDEN_COMPRA2 = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_VENTA = $array[$i][$j];$j=$j+1;
            $Ns->PATENTE = $array[$i][$j];$j=$j+1;
            $Ns->CODVAR = $array[$i][$j];$j=$j+1;
            $Ns->EAN13 = $array[$i][$j];$j=$j+1;
            $Ns->DESCRIPCION_PRODUCTO = $array[$i][$j];$j=$j+1;
            $Ns->SUC_RESERVA = $array[$i][$j];$j=$j+1;
            $Ns->DIVISION = $array[$i][$j];$j=$j+1;
            $Ns->COD_DEPTO = $array[$i][$j];$j=$j+1;
            $Ns->DEPARTAMENTO = $array[$i][$j];$j=$j+1;
            $Ns->CODLIN = $array[$i][$j];$j=$j+1;
            $Ns->LIN_DESCRIPCION = $array[$i][$j];$j=$j+1;
            $Ns->MARCA = $array[$i][$j];$j=$j+1;
            $Ns->DEP_CAT = $array[$i][$j];$j=$j+1;
            $Ns->UNIDADES = $array[$i][$j];$j=$j+1;
            $Ns->PRECIO_UNITARIO = $array[$i][$j];$j=$j+1;
            $Ns->VENTA_CON_IGV = $array[$i][$j];$j=$j+1;
            $Ns->NRO_GUIA = $array[$i][$j];$j=$j+1;
            $Ns->RAZON_SOCIAL_V = $array[$i][$j];$j=$j+1;
            $Ns->PAIS_REGION = $array[$i][$j];$j=$j+1;
            $Ns->PAIS_DISTRITO = $array[$i][$j];$j=$j+1;
            $Ns->NRO_BOLETA = $array[$i][$j];$j=$j+1;
            $Ns->COD_SUC_DESPACHO = $array[$i][$j];$j=$j+1;
            $Ns->SUC_DESPACHO = $array[$i][$j];$j=$j+1;
            $Ns->COD_SUC_RESERVA = $array[$i][$j];$j=$j+1;
            $Ns->COD_SUC_STOCK = $array[$i][$j];$j=$j+1;
            $Ns->SUC_STOCK = $array[$i][$j];$j=$j+1;
            $Ns->MODALIDAD_DESPACHO = $array[$i][$j];$j=$j+1;
            $Ns->TIPO_DESPACHO = $array[$i][$j];$j=$j+1;
            $Ns->SUCURSAL_RESPONSABLE = $array[$i][$j];$j=$j+1;
            $Ns->FLUJOS_PROV_VERDE = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_PENDIENTE_NC = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_NOTA_CREDITO = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_ENTREGADO_CONFORME_HORA = $array[$i][$j];$j=$j+1;
            $Ns->COD_ESTADO_DESPACHO = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_DESPACHO_PROMETIDA = $array[$i][$j];$j=$j+1;
            $Ns->CLIENTE_FONO = $array[$i][$j];$j=$j+1;
            $Ns->RECIBE_DNI = $array[$i][$j];$j=$j+1;
            $Ns->RECIBE_NOMBRE = $array[$i][$j];$j=$j+1;
            $Ns->RECIBE_DIRECCION = $array[$i][$j];$j=$j+1;
            $Ns->JORNADA_DESP = $array[$i][$j];$j=$j+1;
            $Ns->COD_MOTIVO = $array[$i][$j];$j=$j+1;
            $Ns->EMAIL = $array[$i][$j];$j=$j+1;
            $Ns->FECPRO = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_GUIA = $array[$i][$j];$j=$j+1;
            $Ns->COD_REGION = $array[$i][$j];$j=$j+1;
            $Ns->COD_COMUNA = $array[$i][$j];$j=$j+1;
            $Ns->SUCURSAL_DESP = $array[$i][$j];$j=$j+1;
            $Ns->ESTADO_DESPACHO = $array[$i][$j];$j=$j+1;
            $Ns->TIPO_DESPACHO_ORIG = $array[$i][$j];$j=$j+1;
            $Ns->TDA_RESPONSABLE = $array[$i][$j];$j=$j+1;
            $Ns->ANTIGUEDAD_TRANSITO = $array[$i][$j];$j=$j+1;
            $Ns->ANTIGUEDAD_PEDIDO = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_VENTA_ORIG = $array[$i][$j];$j=$j+1;
            $Ns->RETRASO = $array[$i][$j];$j=$j+1;
            $Ns->ESTADO_PRELIMINAR = $array[$i][$j];$j=$j+1;
            $Ns->SYSDATE = $array[$i][$j];$j=$j+1;
            $Ns->ESTADO_DESPACHO_PWBI = $array[$i][$j];$j=$j+1;
            $Ns->ESTADO_BT = $array[$i][$j];$j=$j+1;
            $Ns->CATEGORIA_ANTIGUEDAD = $array[$i][$j];$j=$j+1;
            $Ns->ANTIGUEDAD_PEDIDO_RLT = $array[$i][$j];$j=$j+1;
            $Ns->CUMPLIMIENTO_TRANSITO = $array[$i][$j];$j=$j+1;
            $Ns->CATEGORIA_FECHA_PROMETIDA = $array[$i][$j];$j=$j+1;
            $Ns->MODO_DELIVERY = $array[$i][$j];$j=$j+1;
            $Ns->RAZON_SOCIAL_V_ORIG = $array[$i][$j];$j=$j+1;
            $Ns->MODO_DELIVERY2 = $array[$i][$j];$j=$j+1;
            $Ns->CATEGORIA_FLUJO = $array[$i][$j];$j=$j+1;
            $Ns->DESCRIPCION_CANAL_VENTA = $array[$i][$j];$j=$j+1;
            $Ns->BIGT_DESPACHOS_MOTIVO = $array[$i][$j];$j=$j+1;
            $Ns->ESTADO_PROCESO = $array[$i][$j];$j=$j+1;
            $Ns->CATEGORIA_ESTADO_PROCESO = $array[$i][$j];$j=$j+1;
            $Ns->LICENCIA_DIGITAL = $array[$i][$j];$j=$j+1;
            $Ns->CORP_TIPO_DESP_ORG = $array[$i][$j];$j=$j+1;
            $Ns->LIMA_METROPOLITANA = $array[$i][$j];$j=$j+1;
            $Ns->ENTREGADO_OPL_BT = $array[$i][$j];$j=$j+1;
            $Ns->PAIS_PROVINCIA = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_ASIGNACION_LIMITE = $array[$i][$j];$j=$j+1;
            $Ns->TIPO_OC = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_ENTREGADO_CONFORME = $array[$i][$j];$j=$j+1;
            $Ns->FUENTE_STOCK = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_ESPERA_CLIENTE = $array[$i][$j];$j=$j+1;
            $Ns->FORMATO_FECHA_ESPERA_CLIENTE = $array[$i][$j];$j=$j+1;
            $Ns->LIMA_PROVINCIA = $array[$i][$j];$j=$j+1;
            $Ns->ETQ_COBERTURA = $array[$i][$j];$j=$j+1;
            $Ns->RANGO_LT_PROMESA = $array[$i][$j];$j=$j+1;
            $Ns->RANGO_LT_ESPERA_CLIENTE = $array[$i][$j];$j=$j+1;
            $Ns->TAMANIO = $array[$i][$j];$j=$j+1;
            $Ns->COD_ED_MOV = $array[$i][$j];$j=$j+1;
            $Ns->TIPO_PROMESA = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_VENTA_HORA = $array[$i][$j];$j=$j+1;
            $Ns->RANGO_LT_GUIADO = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_GUIA_HORA = $array[$i][$j];$j=$j+1;
            $Ns->FLOTA = $array[$i][$j];$j=$j+1;
            $Ns->LLAVE_OPL_DISTRITO = $array[$i][$j];$j=$j+1;
            $Ns->CF_ESTADO_TERMINO = $array[$i][$j];$j=$j+1;
            $Ns->CAT_DIAS_PROMESA = $array[$i][$j];$j=$j+1;
            $Ns->ETQ_OC_REINYECTADAS = $array[$i][$j];$j=$j+1;
            $Ns->IND_DESP_PROM = $array[$i][$j];$j=$j+1;
            $Ns->ETQ_DESFASADA = $array[$i][$j];$j=$j+1;
            $Ns->ETQ_VTA_FUERA_CORTE = $array[$i][$j];$j=$j+1;
            $Ns->ETQ_REPROGRAMADOS = $array[$i][$j];$j=$j+1;
            $Ns->ETQ_NO_CUMPLIMIENTO = $array[$i][$j];$j=$j+1;
            $Ns->MOTIVOS_ACIDOS_FINAL = $array[$i][$j];$j=$j+1;
            $Ns->K_CODDEPTO_SUCURSAL = $array[$i][$j];$j=$j+1;
            $Ns->K_CODLIN_CUDSUC = $array[$i][$j];$j=$j+1;
            $Ns->K_EAN_CODSUC = $array[$i][$j];$j=$j+1;
            $Ns->C_CONFIG_24H = $array[$i][$j];$j=$j+1;
            $Ns->ETQ_FUENTE_STOCK = $array[$i][$j];$j=$j+1;
            $Ns->ETQ_VAL_24H = $array[$i][$j];$j=$j+1;
            $Ns->DIA_VENTA = $array[$i][$j];$j=$j+1;
            $Ns->ETQ_CANAL_VENTA = $array[$i][$j];$j=$j+1;
            $Ns->RG_HORA_VTA = $array[$i][$j];$j=$j+1;
            $Ns->ETQ_ALCANCE_COBERTURA = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_ESTADO_0 = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_RECEP_PROV_DVR = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_RECEP_PROV_DVO = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_CAMBIO_NOTA_CREDITO = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_CAMBIO_PENDIENTE_NC = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_CAMBIO_D21 = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_ESTADO_C_22 = $array[$i][$j];$j=$j+1;
            $Ns->PATENTE_ORIG = $array[$i][$j];$j=$j+1;
            $Ns->KEY_BDT = $array[$i][$j];$j=$j+1;
            $Ns->ORDEN_COMPRA_TKT = $array[$i][$j];$j=$j+1;
            $Ns->ETQ_OC_QTY = $array[$i][$j];$j=$j+1;
            $Ns->LLAVE_LT = $array[$i][$j];$j=$j+1;
            $Ns->FLUJOS_RETIRO_CERCANO = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_EMPAQUE = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_CARGA_CAMION = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_RECEPCION_CD = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_GUIA_TIENDA = $array[$i][$j];$j=$j+1;
            $Ns->BATCH_NBR = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_ANCLAJE = $array[$i][$j];$j=$j+1;
            $Ns->ESTADO_DESPACHO_S2S_ORIG = $array[$i][$j];$j=$j+1;
            $Ns->ESTADO_DESPACHO_S2S = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_GUIA_TDA_2_STS = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_RECEPCION_TIENDA_S2S_2 = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_RECOJO_TIENDA = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_RECEPCION_STS = $array[$i][$j];$j=$j+1;
            $Ns->ETQ_DESPACHO = $array[$i][$j];$j=$j+1;
            $Ns->BIGT_DESPACHOS_DIVISION = $array[$i][$j];$j=$j+1;
            $Ns->CODDPTO = $array[$i][$j];$j=$j+1;
            $Ns->CODSUBLIN = $array[$i][$j];$j=$j+1;
            $Ns->TIPO_TARJETA = $array[$i][$j];$j=$j+1;
            $Ns->TIPO_PROMESA_MACRO = $array[$i][$j];$j=$j+1;
            $Ns->ANIO_MES_VENTA = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_ESPCLIENTE_MIXTA = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_HOM_VERDE = $array[$i][$j];$j=$j+1;
            $Ns->SEMANA_VTA = $array[$i][$j];$j=$j+1;
            $Ns->ETQ_FACTURACION_DDC = $array[$i][$j];$j=$j+1;
            $Ns->TIENDA_DESPACHO = $array[$i][$j];$j=$j+1;
            $Ns->COD_MOTIVO_RSV = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_COMPROMETIDA_RSV = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_VENTA_H_RSV = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_VENTA_RSV = $array[$i][$j];$j=$j+1;
            $Ns->FECHA_ENTREGADO_BT_TR = $array[$i][$j];$j=$j+1;
            $Ns->ETQ_NPS_ENCUESTA = $array[$i][$j];$j=$j+1;
            $Ns->VAL_RESPONSABLEPROV = $array[$i][$j];$j=$j+1;
            $Ns->VAL_NCDDC = $array[$i][$j];$j=$j+1;            
            $Ns->STATUS = $array[$i][$j];$j=$j+1;
            $Ns->ATIEMPO = $array[$i][$j];$j=$j+1;
            $Ns->RETRASADO = $array[$i][$j];$j=$j+1;
            $Ns->OBSERVADO = $array[$i][$j];$j=$j+1;
            $Ns->NOCONSIDERADO = $array[$i][$j];$j=$j+1;
            $Ns->DIFERENCIADIAS = $array[$i][$j];$j=$j+1;
            $Ns->PORC_PENALIDAD = $array[$i][$j];$j=$j+1;
            $Ns->MONTO_PENALIDAD = $array[$i][$j];$j=$j+1;
            $Ns->VALIDAFACTURA = $array[$i][$j];$j=$j+1;
            $Ns->MONTO_A_FACTURAR = $array[$i][$j];$j=$j+1;
            $Ns->MOTIVO_EXCLUSION = $array[$i][$j];$j=$j+1;
            $Ns->VALIDAREGISTRO = $array[$i][$j];$j=$j+1;
            $Ns->SEMANA = $array[$i][$j];$j=$j+1;
            $Ns->MES = $array[$i][$j];$j=$j+1;
            $Ns->RAZON_SOCIAL = $array[$i][$j];              

            $Ns->save();
            
        }
        return('Carga de Ns Exitosa!');
    }
}