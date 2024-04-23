<?
include('enca.inc.php');
 $fact5=(30000+(date("Y")-2020)*1440);
//$dbv = mysqli_connect ("107.180.25.165", "fenix", "paquito") or die ('I cannot connect to the database.');
//mysqli_select_db ($dbv,"velae");
$hoy=date('Y-m-d'); 

$bus=$_GET['bus'];
$EMP=$_GET['EMP'];
$ASIG=$_GET['ASIG'];
$FACT=$_GET['FACT'];
$UNIDAD=$_GET['UNIDAD'];
$EDAD=$_GET['EDAD'];
$VER_REC=$_GET['VER_REC'];
$ABON=$_GET['ABON'];

$OBSERT=$_GET['OBSERT'];
$SEG=$_GET['SEG'];
$EST=$_GET['EST'];
$GRUPO=$_GET['GRUPO'];
$MON=$_GET['MON'];
$ANUL=$_GET['ANUL'];
$PRE=$_GET['PRE'];

if($PRE<>'')
{
	/*
$query2 = "SELECT LETRA,ID,INICIAL,FINAL,TEXTO,X,LETRA,RESOLUCION,TIPO,FECHA_INICIO,FECHA_FIN 
FROM RESOLUCION where tipo='F' and letra<>'' and letra='$PRE'  ORDER BY ID ";
$query2 = strtoupper($query2);
//echo $query2 ."--<br>";
$mysql_result2 = mysqli_query($mysql_link,$query2) or die("Error_4");

?>
     
      <?
$IDS_RES="";	  
while ($datos2 = mysqli_fetch_row($mysql_result2)) 
{
	$IDS_RES.="'".$datos2[1]."',";
}
$IDS_RES= substr($IDS_RES,0,(strlen($IDS_RES)-1));
//echo "".$IDS_RES."--<br>";
*/
}


$fecha_inicial=$_GET['fecha_inicial'];
$fecha_final=$_GET['fecha_final'];
if($fecha_inicial=="")
	{
	$fecha_inicial="0000-00-00";

	//$fecha_inicial=(date("Y")-5)."-".date("m-d");
	}
if($fecha_final=="")
	{
	$fecha_final="0000-00-00";
	//$fecha_final=date("Y-m-d");
}
	
$fecha_inicial2=$_GET['fecha_inicial2'];
$fecha_final2=$_GET['fecha_final2'];
if($fecha_inicial2=="")
	$fecha_inicial2="0000-00-00";
if($fecha_final2=="")
	$fecha_final2="0000-00-00";	
	
function diferenciaDias($inicio, $fin)
    {
        $inicio = strtotime($inicio);
        $fin = strtotime($fin);
        $dif = $fin - $inicio;
        $diasFalt = (( ( $dif / 60 ) / 60 ) / 24);
        return ceil($diasFalt);
    }	


////  AYUDANTE
$agre="";
//echo $cons."---<br>";
 //if($cons<>96 && $cons<>12 && $cons<>14 && $cons<>4)
   // $agre=" AND A.AYUDANTE_CARTERA='$cons' ";


if($bus==1)
{

//echo "HOLAAAAAAAAAAAAA";


$adi="";
//$adi2="";
$fe_adi="";
$fe_adi2="";
if($fecha_inicial>"2000-01-01") 
	{	

	$fe_adi.=" and FECHA >= '".$fecha_inicial."'";	
	$fe_adi2.=" and B.FECHA >= '".$fecha_inicial."'";	

	if($SEG==1){
	$adi.=" and X.FECHA_FIN >= '".$fecha_inicial."'";
	} else {
	$adi.=" and B.FECHA >= '".$fecha_inicial."'";
	//$adi2.=" and FECHA >= '".$fecha_inicial."'";
	}
	
	}
	
if($fecha_final>"2000-01-01") 
	{
$fe_adi.=" and FECHA <= '".$fecha_final."'";	
$fe_adi2.=" and B.FECHA <= '".$fecha_final."'";	

	if($SEG==1) {
	$adi.=" and X.FECHA_FIN <= '".$fecha_final."'";	
	} else {
	$adi.=" and B.FECHA <= '".$fecha_final."'";
	//$adi2.=" and FECHA <= '".$fecha_final."'";
	}

	}

/// FECHA RECAUDO
$TAB="";

if($fecha_inicial2>"2000-01-01") 
	{	
	
	$TAB=" , VALOR_RECAUDO V ";
	
	$adi.=" and V.FECHA >= '".$fecha_inicial2."' AND B.CASO=V.ID_TRAMITE AND B.NUMERO_FAC=V.N_FACT  ";
	//$adi2.=" and FECHA >= '".$fecha_inicial2."'";
	
	}
	
if($fecha_final2>"2000-01-01") 
	{	
	$adi.=" and V.FECHA <= '".$fecha_final2."'";
	//$adi2.=" and FECHA <= '".$fecha_final2."'";
	}


if($ABON<>"") 
	{	
	
	if($TAB=="")
	$TAB=" , VALOR_RECAUDO V ";
	
	$adi.=" AND V.ABONO = '1' AND B.CASO=V.ID_TRAMITE AND B.NUMERO_FAC=V.N_FACT ";	
	}

if($FACT<>"") 
	{	
	$adi.=" and B.NUMERO_FAC = '".$FACT."'";
	}

/*if($EDAD<>"") 
	{	
	$adi.=" AND B.ESTADO_CARTERA=3 AND B.NUMERO_FAC = '".$EDAD."'";
	}*/

if($ASIG<>"") 
	{	
	$adi.=" and Z.ID_TRAMITE = '".$ASIG."'";
	}
	
if($MON<>"") 
	{	
	$adi.=" AND B.MONEDA = '".$MON."'";	
	}

	

/*if($OBSERT=="") 
	{	
	$TAB=" , VALOR_RECAUDO V ";
	$adi.=" AND V.OBSERV_AYUDANTE = '".$OBSERT."' AND B.CASO=V.ID_TRAMITE AND V.VALOR<>0  ";	
	}*/


if($GRUPO<>"") 
	{	
	//$adi.=" AND A.ID_GRUPO = '".$GRUPO."'";	
	}


if($EMP<>"") 
	{
	$adi.=" and A.EMPRESA LIKE '%$EMP%'";
	//$adi.=" and B.EMPRESA LIKE '%$EMP%'";
//	$adi.=" and B.ID_EMPRESA='$EMP'";
	}

$SSE="";

if($SEG==1) 
	{	
	$adi.=" AND X.ID_ACTUACIONES='1515' AND X.FECHA_INICIO='0000-00-00' AND B.CASO=X.ID_TRAMITE ";
	$SSE=" , TRAMITE_DET X ";
	$FSEG=" , X.FECHA_FIN ";
	}

$ESTADO1="";
if($EST<>"") 
	{	
	$adi.=" and B.ESTADO_CARTERA = '".$EST."'";
	//$ESTADO1=" and ESTADO_CARTERA = '".$EST."'";
	}

if($UNIDAD<>"1") 
	{	
	$adi.=" AND CASO_MAESTRO.ID_UNIDAD_ESTRATEGICA = '".$UNIDAD."'";
	}



}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="bootstrap-453-dist/css/bootstrap.min.css">
<script src="bootstrap-453-dist/js/bootstrap.min.js"></script>
	
<title>78. CARTERA</title>
<!--<script language="JavaScript" src="calendario/javascripts.js"></script>-->

<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
	
	.sticky{
		top: 0;
		position: sticky;
	
	}	
	
	.chulo{
		
		 opacity: 1;
	}
-->
</style>
<style type="text/css">
<!--
.style3 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.style4 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold; }
INPUT, select {
    BORDER: #666666 1px solid;
   /* BORDER-TOP: #666666 1px solid;
    BORDER-LEFT: #666666 1px solid;
    BORDER-BOTTOM: #666666 1px solid;    */	
	border-radius:6px;
	background-color:#FFFFFF
    FONT-SIZE: 12px;
	padding:2px;
	outline:none;
    FONT-FAMILY: "Arial","Times New Roman", Times, serif;
    BACKGROUND-REPEAT: repeat-x;
	/*border:none; border-bottom:1px solid #666666; background-color:#F2F2F2*/
}-->
	textarea.form-control {
      border: 1px solid #ced4da;/* O cualquier otro color que desees */
	  padding: 0.375rem 0.75rem;
    }
</style>
<script>
function abrirpopup(url,ancho,alto){
	
	//Ajustar horizontalmente
	var x=(screen.width/2)-(ancho/2);
	//Ajustar verticalmente
	var y=(screen.height/2)-(alto/2);
	window.open(url, '', 'width=' + ancho + ', height=' + alto + ', left=' + x + ', top=' + y +' , status=yes, menubar=no, resizable=no, scrollbars=yes, toolbar=no, location=no, directories=no  ');
}
</script>


<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="js/jquery-1.12.4.js"></script>
<script src="js/jqueryui.js"></script>
<script>
 $.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '< Anterior',
 nextText: 'Siguiente >',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 dateFormat: 'dd/mm/yy',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);

       $(function () {
           $("#fecha_inicial").datepicker({
               dateFormat: "yy-mm-dd", changeYear: true, changeMonth: true,
           });
       });
	    $(function () {
           $("#fecha_final").datepicker({
               dateFormat: "yy-mm-dd", changeYear: true, changeMonth: true,
           });
       });
	    $(function () {
           $("#fecha_inicial2").datepicker({
               dateFormat: "yy-mm-dd", changeYear: true, changeMonth: true,
           });
       });
	    $(function () {
           $("#fecha_final2").datepicker({
               dateFormat: "yy-mm-dd", changeYear: true, changeMonth: true,
           });
       });
</script>

</head>

<body>
<h4 align="center">78. REPORTE CARTERA</h4>
	
<!--&nbsp;&nbsp;&nbsp;<a href="menu_gerencia.php" class= "btn-success"><span style="font-size:11px; font:Verdana, Arial, Helvetica, sans-serif">VOLVER </span></a>-->
	
	&nbsp;&nbsp;&nbsp;<a href="menu_gerencia.php" class="btn btn-info"><span style="font-size:11px; font:Verdana, Arial, Helvetica, sans-serif">VOLVER</span></a>
	
	
<!--<div align='right' style='position:absolute;top:3px;height:34px; color:#ccc; right:100px; z-index:999'>
<div style="float:left; position:relative;">
<button class="" style="width:34px; height:34px; background-image:url(imagenes_nuevo_mod/gmail_new.png);
background-repeat:no-repeat; background-position:center; text-decoration:none; margin-top:1px; border-radius:16px;  border:#e5e5e5 solid 1px; outline:none; background-color:#FFFFFF; box-shadow:1px 1px #aaa; cursor:pointer" onClick="abrirpopup('https://www.pinzonpinzon.co/pinzon/gmail/gmailppa1.php?ID_TRAMITE=<? //echo $ID_TRAMITE; ?>&idm=<? //echo $mid; ?>&cons=<? //echo $cons; ?>','1060','655');"></button>
</div>
</div>-->

<form method="get" name="form" id="form">
  <table align="center" width="68%" border="1" style="border-collapse:collapse" cellpadding="3"  class="table-striped table-bordered shadow p-3 mb-5 bg-white rounded">
  <tr bgcolor="#ccc">
  <td colspan="2" style="color:#000">EMPRESA FACTURAR:&nbsp;
  <INPUT TYPE="TEXT" NAME="EMP" ID="EMP" VALUE="<? ECHO $EMP; ?>" size="40" TABINDEX="1">
	  <?
	  
/*
<select name="EMP" class="tamano" id="EMP">

$query2 = "SELECT A.EMPRESA, A.ID_EMPRESA, A.ID_EMPRESA
FROM EMPRESA A, FACTURACION B where  A.EMPRESA<>'' AND A.ID_EMPRESA=B.ID_EMPRESA AND A.EMP_ACCESO  ='1' AND A.OCULTO<>'1' $agre GROUP BY B.ID_EMPRESA
ORDER BY A.EMPRESA";
$query2 = strtoupper($query2);
$mysql_result2 = mysqli_query($mysql_link,$query2) or die("Error_4");

?>
     <option value="">Seleccione</option>
      <?
while ($datos2 = mysqli_fetch_row($mysql_result2)) {
    
?>
     <option value="<?
    echo $datos2[1];
?>"<?
    if ($datos2[1] == $EMP)
        echo " selected";
?>> 
        <?
    echo substr($datos2[0], 0, 34);
?></option>
      <?
}

?>
     </select>&nbsp;&nbsp;
	<?
//ECHO $query2."<BR>";

*/
	?></td>
  </tr>
  
  
  
   
   <tr bgcolor="#DDD">
  	<td>INICIA FACTURACIÓN &nbsp; <input placeholder="aaaa-mm-dd" name="fecha_inicial" type="text" class="letras" id="fecha_inicial" value="<? echo $fecha_inicial; ?>" size="8" maxlength="10">  	  &nbsp;&nbsp;</td>
	<td>FINALIZA FACTURACIÓN: &nbsp; <input name="fecha_final" type="text" class="letras" id="fecha_final"  placeholder="aaaa-mm-dd" value="<? echo $fecha_final; ?>" size="8" maxlength="10"></td>
  </tr>
  
  <? //if($cons==96) { ?>
   <tr bgcolor="#ccc">
  	<td>INICIA RECAUDO: &nbsp; <input name="fecha_inicial2" type="text" class="letras" id="fecha_inicial2"  placeholder="aaaa-mm-dd" value="<? echo $fecha_inicial2; ?>" size="8" maxlength="10">  	  &nbsp;&nbsp;</td>
	<td>FINALIZA RECAUDO: &nbsp; <input name="fecha_final2" type="text" class="letras" id="fecha_final2"  placeholder="aaaa-mm-dd" value="<? echo $fecha_final2; ?>" size="8" maxlength="10"></td>
  </tr>
<? //} ?>

<tr bgcolor="#ccc">
  	<td>
     <label>ASIGNACION:</label>
	<input name="ASIG"  type="text" value="<? echo $ASIG; ?>" size="8" style="width: 70px;">
  	<td>
		
	
	
	PREFIJO:&nbsp;<select name="PRE" class="tamano" id="PRE">
      <?



$query2 = "SELECT LETRA,LETRA,ID,INICIAL,FINAL,TEXTO,X,LETRA,RESOLUCION,TIPO,FECHA_INICIO,FECHA_FIN 
FROM RESOLUCION where tipo='F' and letra<>'' GROUP BY LETRA ORDER BY ID DESC";
$query2 = strtoupper($query2);
$mysql_result2 = mysqli_query($mysql_link,$query2) or die("Error_4");

?>
     
      <?
while ($datos2 = mysqli_fetch_row($mysql_result2)) {
    
?>
     <option value="<?
    echo $datos2[1];
?>"<?
    if ($datos2[1] == $PRE)
        echo " selected";
?>> 
        <?
    echo substr($datos2[0], 0, 34);
?></option>
      <?
}

?>
     </select>&nbsp;&nbsp;
	<?
	
//ECHO $query2."<BR>";
	?>
	
	
	
	
	
	
	
	No.FACTURA: &nbsp; <input name="FACT" type="text" value="<? echo $FACT; ?>" size="8" maxlength="">
      </td>
  </tr>

<? //echo $EST."----"; ?>
<tr bgcolor="#ccc">
  	<td>ESTADO: &nbsp; <select name="EST" class="custom-select custom-select-sm" style="width: 170px;">
<option value="" <? if($EST=="") echo "selected";  ?>>TODOS</option>
<!--<option value="0" <? //if($EST==0) echo "selected";  ?>>NO DEFINIDO</option>
-->
<option value="1" <? if($EST==1) echo "selected";  ?>>RECAUDADO</option>
<option value="2" <? if($EST==2) echo "selected";  ?>>GESTION CARTERA</option>
<option value="3" <? if($EST==3) echo "selected";  ?>>ANULADO</option>
<option value="4" <? if($EST==4) echo "selected";  ?>>CASTIGADA</option>
</select>
    </td>
	<td><!--*SEGUIMIENTO: &nbsp;<select name="SEG">
<option value="">SELECCIONE</option>
<option value="1" <? //if($SEG==1) echo "selected";  ?>>GESTION CARTERA NO EJECUTADO</option>
<option value="2" <? //if($SEG==2) echo "selected";  ?>>GESTION CARTERA EJECUTADA</option>
<option value="3" <? //if($SEG==3) echo "selected";  ?>>TODOS</option>
</select>-->

<input type="checkbox" value="1" name="ANUL" <? if($ANUL==1) echo "checked"; ?>  >&nbsp;VER ANULADAS

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" value="1" name="VER_REC" <? if($VER_REC==1) echo "checked"; ?>  >&nbsp;COLUMNAS RECAUDO
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" value="1" name="ABON" <? if($ABON==1) echo "checked"; ?>  >&nbsp;VER ABONOS
      </td>
  </tr>
 
<tr bgcolor="#ccc">
  	<td>MONEDA &nbsp;FACT: &nbsp; <select name="MON" class="custom-select custom-select-sm" style="width: 120px;">
<option value="" <? if($MON=="") echo "selected";  ?>>TODAS</option>
<option value="PESOS" <? if($MON=="PESOS") echo "selected";  ?>>PESOS</option>
<option value="DOLARES" <? if($MON=="DOLARES") echo "selected";  ?>>DOLARES</option>
</select>
    </td>
	<td><!--GRUPO:&nbsp;<select name="GRUPO" class="tamano">
    <option value="">Seleccione</option> 

          <?

/*$query2        = "SELECT GRUPO.ID_GRUPO ,GRUPO.GRUPO FROM GRUPO,EMPRESA, TIPO_DE_CLIENTE
WHERE TIPO_DE_CLIENTE.ID_PERTENECE_A=EMPRESA.PERTENECE_A AND EMPRESA.ID_GRUPO=GRUPO.ID_GRUPO
AND TIPO_DE_CLIENTE.ID_PERTENECE_A='12'
GROUP BY GRUPO.ID_GRUPO ,GRUPO.GRUPO 
 ORDER BY GRUPO.GRUPO ";
$query2        = strtoupper($query2);
$mysql_result2 = mysqli_query($mysql_link,$query2);

while ($datos2 = mysqli_fetch_row($mysql_result2)) {
    */
?>
         <option value="<?
   // echo $datos2[0];
?>"<?
   // if ($datos2[0] == $GRUPO)
    //    echo " selected";
?>> 
          <?
   // echo substr($datos2[1], 0, 34);
?></option>
<?
//}
?>
       </select>-->
    <!-- OBSERV. TESORERIA: <input type="text" name="OBSERT" value="<? //echo $OBSERT; ?>">--> </td>
  </tr> 
  
  
  <tr bgcolor="#ccc">
  	<td>UNIDAD: &nbsp; <select name="UNIDAD" class="custom-select custom-select-sm" tabindex="4" id="UNIDAD" style="width: 320px;" >
		  
              <?
$query2= "SELECT UNIDAD_ESTRATEGICA.ID_UNIDAD_ESTRATEGICA, UNIDAD_ESTRATEGICA.UNIDAD FROM UNIDAD_ESTRATEGICA WHERE UNIDAD_ESTRATEGICA.EMP_ACCESO='$E_ACC'  ORDER BY UNIDAD_ESTRATEGICA.UNIDAD ";
$query2=strtoupper($query2);

$mysql_result2= mysqli_query($mysql_link,$query2);
//echo $mysql_link2."XXXXXXXX";
//echo $query2;
# fetch the data from the database
//print($rows1);
//echo $rows1."XXXXXX";
while ($datos2= mysqli_fetch_row($mysql_result2)){

								?>
              <option value="<? echo $datos2[0]; ?>"<? if($datos2[0]==$UNIDAD) echo " selected" ?>> 
              <? echo strtoupper($datos2[1]); ?></option>
              <? 
					}
				
				?>
        </select>
    </td>
	<td><!--EDAD:&nbsp;<select name="EDAD" class="tamano">
    <option value="">Seleccione</option> 
	<option value="30">HASTA 30</option>
		<option value="60">DE 31 A 60</option>
	<option value="90">DE 61 A 90</option>
	<option value="120">DE 91 A 120</option>
	<option value="150">DE 121 A 150</option>
	<option value="999">151+</option>
-->
          <?

/*$query2        = "SELECT GRUPO.ID_GRUPO ,GRUPO.GRUPO FROM GRUPO,EMPRESA, TIPO_DE_CLIENTE
WHERE TIPO_DE_CLIENTE.ID_PERTENECE_A=EMPRESA.PERTENECE_A AND EMPRESA.ID_GRUPO=GRUPO.ID_GRUPO
AND TIPO_DE_CLIENTE.ID_PERTENECE_A='12'
GROUP BY GRUPO.ID_GRUPO ,GRUPO.GRUPO 
 ORDER BY GRUPO.GRUPO ";
$query2        = strtoupper($query2);
$mysql_result2 = mysqli_query($mysql_link,$query2);

while ($datos2 = mysqli_fetch_row($mysql_result2)) {*/
    
?>
      <!--   <option value="<? //echo $datos2[0]; ?>"<? //if ($datos2[0] == $GRUPO) echo " selected"; ?>> 
          <? //echo substr($datos2[1], 0, 34);
?></option>
          <?
//}

?>
       </select> (NO Usar aun)
-->      </td>
  </tr> 

  
  
  
  
  <tr>
  	<td colspan="2" align="center">
	<input type="hidden" name="bus" value="1"> 
	<input type="submit" style="padding:4px" value="BUSCAR" class= "btn-success">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" style="padding:4px" value="LIMPIAR" onClick="location='cartera.php?bus=0'" class="btn-info">
	
	
	</td>
	
  </tr>
  
  
  </table>
</form>
  
  
  <? if($bus==1) { ?>
  
  <? 
$fechh=date('Y-m-d_h-m-s');

ob_start(); ?>
<P>
	&nbsp;<a href="<? echo "Cartera_".$fechh; ?>.xls" class="btn btn-success shadow"><span  style="font-size:11px; font:Verdana, Arial, Helvetica, sans-serif">EXPORTAR A EXCEL</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <a href="apoyo_cartera.php" target="_blank" class="btn btn-info shadow-lg"><span  style="font-size:11px; font:Verdana, Arial, Helvetica, sans-serif">APOYO GESTION CARTERA</span></a></P>
	
	
<table width="90%" border="1" align="center" style="border-collapse:collapse" class="table-bordered shadow p-3 mb-5 bg-white rounded" cellpadding="3">
  <tr bgcolor="#444" class="sticky" style="color:#FFFFFF; font-size:9px" align="center">
    <td colspan="" class="table-dark">EMPRESA FACT</td>
	  <td class="table-dark">UEN</td>
    <td class="table-dark">ASIGNACION</td>
    <td bgcolor="#003399">FACTURA</td>
	
	<? if($VER_REC<>1) {  ?>
	
	<td bgcolor="#003399">MONEDA</td>
    <td bgcolor="#003399">HONORARIOS</td>
 <td bgcolor="#003399">TASAS FISC.</td>
 <td bgcolor="#003399">GASTOS TERCEROS</td>
 <td bgcolor="#003399">GASTOS MENORES</td>
 <td bgcolor="#003399">CORRESPONSAL</td>	    
 <td bgcolor="#003399">TOTAL FACT</td>
     <td bgcolor="#003399">EDADES</td>
	<?  } else {  ?>
	
	<td bgcolor="#888">HONORARIOS</td>
	<td bgcolor="#888">TASAS FISC.</td>
	<td bgcolor="#888">GASTOS TERCEROS</td>
	<td bgcolor="#888">GASTOS MENORES</td>
	<td bgcolor="#888">CORRESPONSAL</td>	
	<?  }   ?>
	<td bgcolor="#888">FORMA PAGO FACT.</td>
	<td bgcolor="#888">RECAUDADO <b>PESOS</b></td>
	<td bgcolor="#888">RECAUDADO <b>DOLARES</b></td>
	<td bgcolor="#888">FECHA RECAUDO</td>
	    <td bgcolor="#888">ESTADO RECAUDO</td>
	<!-- <td>OBSERV. TESORERIA</td>-->
	 <td>OBSERV.</td>
  </tr>
  
 <?
 
  
 
 $queryWPP="
SELECT B.ID_EMPRESA, A.EMPRESA

FROM 	
EMPRESA A,
FACTURACION B,
DETALLE_FACTURA C,
GRUPO E,
UNIDAD_ESTRATEGICA G,
LINEA_NEGOCIO H,
CATEGORIAS_FAC_ING I,
ID_ITEMS F,
TRAMITE Z,
CASO_MAESTRO,
MODALIDAD
 $SSE $TAB

where A.ID_EMPRESA=B.ID_EMPRESA 
AND A.ID_EMPRESA<>''

AND B.ID_FACTURACION = C.ID_FACTURACION 
and  E.ID_GRUPO = A.ID_GRUPO 
and   F.Id = C.ID_ITEM   
and Z.ID_TRAMITE=B.CASO 
AND CASO_MAESTRO.CASON=Z.CASON
and H.id_unidad = G.ID_UNIDAD_ESTRATEGICA 
AND MODALIDAD.ID_MODALIDAD=Z.ID_MODALIDAD
and I.ID_LINEA = H.ID_LINEA_NEGOCIO 
and  I.ID_CATEGORIA = F.ID_CATEGORIA
$adi $ppais   $agre


AND C.ID_HONO_GAST IN ('1','4','11','21','7','8','13','9','10','14','2','5','12')

group by B.ID_EMPRESA

ORDER BY A.EMPRESA
";
//echo $queryWPP;

//AJUSTADO ALEJANDRO JIMENEZ Y ANDRES REYES  31072020
/*
and ( C.HONO_GAST_TOTAL_TEXTO='HONORARIOS' Or C.HONO_GAST_TOTAL_TEXTO='FEES' OR C.HONO_GAST_TOTAL_TEXTO = 'GASTOS MENORES' OR C.HONO_GAST_TOTAL_TEXTO = 'GASTOS TERCEROS' OR C.HONO_GAST_TOTAL_TEXTO='GASTOS REEMBOL. TERCEROS' OR C.HONO_GAST_TOTAL_TEXTO = 'TASAS FISCALES' OR HONO_GAST_TOTAL_TEXTO = 'MISCELANEOUS' OR HONO_GAST_TOTAL_TEXTO = 'REIMBURSABLE EXPENSES' OR HONO_GAST_TOTAL_TEXTO = 'OFFICIAL FEES') 
*/

//echo $queryWPP;

 $queryWPP=strtoupper($queryWPP);


$mysql_result1WPP= mysqli_query($mysql_link,$queryWPP);
$numPP = mysqli_num_rows($mysql_result1WPP);
$sum=0; 
$sum1=0;
$sum2=0;
$sum3=0;
$sum4=0;
$sum5=0;
$sum6=0; 

$sum21=0;
$sum23=0;
$sum24=0;
$sum25=0;
$sum26=0;
$sum27=0;
$sumrp=0;
$sumrd=0;
$sumrf=0;
$sumx=0; $sumx2=0; $sumx3=0; $sumx4=0; $sumx5=0; $sumx6=0;

$srp1=0; $srp2=0; $srp3=0; $srp4=0; $srp5=0;  
$srd1=0; $srd2=0; $srd3=0; $srd4=0; $srd5=0;  
$sum_abono_pesos=0; $sum_abono_dol=0;

while($datos1PP= mysqli_fetch_row($mysql_result1WPP))
		{ 

 $queryW="
SELECT A.ID_HONOGAST_CONJUNTAMENTE_NAL, B.EMPRESA, sum(C.CANTIDAD*B.POSITIVO), C.HONO_GAST_TOTAL_TEXTO, 
sum(B.TRM*C.CANTIDAD*C.UNITARIO), G.UNIDAD, H.LINEA_NEGOCIO, I.CATEGORIA, 
F.ITEM, B.positivo, 
E.GRUPO,  A.ID_EMPRESA, A.ID_EMPRESA, B.NUMERO_FAC, G.ID_UNIDAD_ESTRATEGICA, Z.ID_TRAMITE, CASO_MAESTRO.CASON, A.ID_EMPRESA, B.ID_FACTURACION, MODALIDAD.MODALIDAD, 
B.FECHA, CASO_MAESTRO.ID_UNIDAD_ESTRATEGICA,  CASO_MAESTRO.ID_PAIS, B.ESTADO_CARTERA , B.MONEDA, B.FORMA_PAGO $FSEG

FROM 	
EMPRESA A,
FACTURACION B,
DETALLE_FACTURA C,
GRUPO E,
UNIDAD_ESTRATEGICA G,
LINEA_NEGOCIO H,
CATEGORIAS_FAC_ING I,
ID_ITEMS F,
TRAMITE Z,
CASO_MAESTRO,
MODALIDAD
 $SSE $TAB

where A.ID_EMPRESA=B.ID_EMPRESA 

AND B.ID_FACTURACION >'$fact5' 

AND A.ID_EMPRESA<>''
AND B.ID_EMPRESA='$datos1PP[0]'
AND B.ID_FACTURACION = C.ID_FACTURACION 
and  E.ID_GRUPO = A.ID_GRUPO 
and   F.Id = C.ID_ITEM   
and Z.ID_TRAMITE=B.CASO 
AND CASO_MAESTRO.CASON=Z.CASON
and H.id_unidad = G.ID_UNIDAD_ESTRATEGICA 
AND MODALIDAD.ID_MODALIDAD=Z.ID_MODALIDAD
and I.ID_LINEA = H.ID_LINEA_NEGOCIO 
and  I.ID_CATEGORIA = F.ID_CATEGORIA
$adi $ppais 



AND C.ID_HONO_GAST IN ('1','4','11','21','7','8','13','9','10','14','2','5','12')

group by B.NUMERO_FAC 

ORDER BY A.EMPRESA, B.NUMERO_FAC , B.FECHA ASC
";
//echo $queryW;
// AJUSTADO ALEJANDRO JIMENEZ  Y ANDRES REYES 04082020 
//,B.ID_FACTURACION
// AJUSTADO ALEJANDRO JIMENEZ  Y ANDRES REYES 31072020 
/*
and ( C.HONO_GAST_TOTAL_TEXTO='HONORARIOS' Or C.HONO_GAST_TOTAL_TEXTO='FEES' 
OR C.HONO_GAST_TOTAL_TEXTO = 'GASTOS MENORES' 
OR C.HONO_GAST_TOTAL_TEXTO = 'GASTOS TERCEROS' 
OR C.HONO_GAST_TOTAL_TEXTO='GASTOS REEMBOL. TERCEROS' 
OR C.HONO_GAST_TOTAL_TEXTO = 'TASAS FISCALES' 
OR HONO_GAST_TOTAL_TEXTO = 'MISCELANEOUS' 
OR HONO_GAST_TOTAL_TEXTO = 'REIMBURSABLE EXPENSES' 
OR HONO_GAST_TOTAL_TEXTO = 'OFFICIAL FEES') 
*/
 $queryW=strtoupper($queryW);
$mysql_result1W= mysqli_query($mysql_link,$queryW);
$num = mysqli_num_rows($mysql_result1W);

//echo  $queryW."<br>";
//$num=$num+1;

 ?>
 <tr>
    <td style="padding:4px" <? //if($num>1) echo 'rowspan="'.$num.'"'; ?>><?  $VAAL=1; ?>
	<a href="empresas.php?ID_EMPRESA=<? echo $datos1PP[0]; ?>&ii=0" target="_blank" style="color:#0033CC"><b><? echo $datos1PP[1]; ?></b></a>
	<br><br>
	
	<div style="" align="center">
<a onClick="abrirpopup('https://www.pinzonpinzon.co/pinzon/gmail/gmailppa1.php?ID_TRAMITE=<? echo "e".$datos1PP[0]; ?>&idm=<? //echo $mid; ?>&cons=<? echo $cons; ?>','1060','655');"><img src="imagenes_nuevo_mod/gmail_new.png" style="cursor:pointer" title="ENVIAR MAIL: <? echo $EMPRESA; ?>"></a>
<!--<img src="imagenes_nuevo_mod/drive_new.png" style="cursor:pointer" title="DRIVE CRM: <? //echo $EMPRESA; ?>">
-->
<a href="contactos_listado.php?IDD_EMP=&ff=&ii=0&ID_EMPRESA=<? echo $datos1PP[0]; ?>&EMP=&DENON=&EMISOR=1&GRU=1&RADIC=&ASIGNA=&CASOS=&bus=1&PAI=&ACTIV=&GEREN=&FAA=&LIN_PRODU=&PRODU=&RADIC=" target="_blank">
		<img src="imagenes_nuevo_mod/user.png" width="26" height="26" title="CONTACTOS"></a>	
		<br>
</div>
<br>
	
	<a onClick="javascript:window.open('proceso_envio_avisoscobro.php?FACT=<? echo $datos1[13]; ?>&ID_TRAMITE=<? echo $datos1[15]; ?>&ID_EMPRESA=<? echo $datos1PP[0]; ?>', '_blank','top=210, left=410, height=200, width=550, status=no, menubar=no, resizable=no, scrollbars=yes, toolbar=no, location=no, directories=no');" style="cursor:pointer; color:#000066; font-size:13px"><u>Conf. Aviso</u></a><BR>
	
	<br>
	<div style="background-color:#00A19B; color:#FFFFFF; width:100%; font-size:13px; ; border-radius:5px; border:#333 solid 1px;" align="center">
	<a onClick="javascript:window.open('estado_cuenta.php?ID_EMPRESA=<? echo $datos1PP[0]; ?>', '_blank','top=150, left=280, height=340, width=580, status=no, menubar=no, resizable=yes, scrollbars=yes, toolbar=no, location=no, directories=no');" style="cursor:pointer"><i><u><b>ESTADO CUENTA</b></u></i></a></div>	</td>
 
 <!--<td width="30" align="left" >
		<?
		/*$aa="SELECT NOMBRE_COMPLETO, EMAIL_CORPORATIVO, INDICATIVO_PAIS, INDICATIVO_CIUDAD, TELEFONO1, CELULAR FROM CONTACTO WHERE ID_EMPRESA='$datos1PP[0]' AND TESORERIA='-1' ";
		$nn=mysqli_query($mysql_link,$aa);
	    $dtnn=mysqli_fetch_row($nn);
	   echo $dtnn[0]."<br>";
	   echo $dtnn[1]."<br>";
	   echo "TEL: ".$dtnn[2]." ".$dtnn[3]." ".$dtnn[4]."<br>";
	   echo "CEL: ".$dtnn[5]."<br>";*/
		?>		
		</td>-->
 
 <?


while($datos1= mysqli_fetch_row($mysql_result1W))
		{ 
		
		if($ANUL==1)
			$co=" AND TIPO_ENTRADA = 2 ";
		else
			$co=" AND TIPO_ENTRADA = 1 ";	 
		

		$fac3="SELECT NUMERO_FAC, TRM, TOTAL_PAGAR FROM FACTURACION WHERE NUMERO_FAC='$datos1[13]' $co AND ID_FACTURACION >'$fact5'
		$ESTADO1
		";
		
		//AND FECHA >='$fecha_inicial' 
		
	//	echo $fac3."<BR>";

		$rfac3=mysqli_query($mysql_link,$fac3);
		$dfact3= mysqli_fetch_row($rfac3);
		
	//	ECHO $dfact3[0]."|".$dfact3[1]."|".$dfact3[2]."<BR>";
		
				
		$fac31="SELECT COUNT(ID_EMPRESA) FROM FACTURACION WHERE NUMERO_FAC='$datos1[13]' AND TIPO_ENTRADA = 2   AND ID_FACTURACION >'$fact5'
		
		$ESTADO1
		";
	//	echo $fac31."<BR>";
	//AND FECHA >='$fecha_inicial'
		$rfac31=mysqli_query($mysql_link,$fac31);
		$dfact31= mysqli_fetch_row($rfac31);
		

		
		 if($dfact3[0]=="") { //echo $dfact3[0]." ANULADA<br>";
		 }
		 else {
		 
		 //if($ANUL==1)
		  // echo " } ";
		 
		//if($datos1[4]>0) {
 ?> 
  	<? if($VAAL==1) {  } else {  ?>
	<td style=" border-top-color:#fff">&nbsp;</td>
		<!--<td style=" border-top-color:#fff">&nbsp;</td>-->

	<? $VAAL=0; }  ?>
	
	
		
		<td align="center" ><? echo $datos1[5]; ?></td>
		
        <? //=$datos1[13]."<BR>"; ?>
<?

$fac3="SELECT A.ID_EMPRESA, A. CASON, A.NUMERO_FAC, B.CASO FROM FACTURACION A , DETALLE_FACTURA B
WHERE A.NUMERO_FAC='$datos1[13]' $co AND A.ID_FACTURACION >'$fact5'
AND A.ID_FACTURACION= B.ID_FACTURACION
		$ESTADO1
		GROUP BY A.NUMERO_FAC, B.CASO 
		ORDER BY A.NUMERO_FAC, B.CASO 
		";
		
		//AND FECHA >='$fecha_inicial' 
		
		//echo $fac3."<BR>";

		$rfac3=mysqli_query($mysql_link,$fac3);
		

		
?>
		

    <td align="center" >
	<?php
	while($dfact3= mysqli_fetch_row($rfac3))
	{
		?>
	<a href="actuaciones_nuevo_mod.php?ID_EMPRESA=<?  echo $dfact3[0]; ?>&CASON=<? echo $dfact3[1]; ?>&ID_TRAMITEE=<?  echo $dfact3[3]; ?>&ID_TRAMITE=<?  echo $dfact3[3]; ?>&llinn=fusion_19y20.php" target="_blank" ><?  echo $dfact3[3]; ?></a>
	<?
	}
	?>
	
	
	</td>
		
	 
   <?
		 $fac3="SELECT NUMERO_FAC FROM FACTURACION WHERE NUMERO_FAC='$datos1[13]' AND TIPO_ENTRADA = 2 
		 
		 AND ID_FACTURACION >'$fact5'

		 $ESTADO1
		  ";
		 
		 //AND FECHA >= '".$datos1[20]."'
		 $rfac3=mysqli_query($mysql_link,$fac3);
		$dfact3= mysqli_fetch_row($rfac3);
	//	echo $fac3."<BR>";
   ?>	
   <td align="center" <? if($dfact3[0]<>"") { echo 'bgcolor="#F8C471"'; } else { }  ?>  >
  		<?



$ID_FACTURACION=$datos1[18];


$query2yyA        = "SELECT ID_RESOLUCION FROM FACTURACION WHERE  NUMERO_FAC='".$datos1[13]."' AND TIPO_ENTRADA = 1 AND ID_FACTURACION >'$fact5'


";

//AND FECHA >='$fecha_inicial'
//ID_FACTURACION='$ID_FACTURACION'
$query2yyA        = strtoupper($query2yyA);
//echo "<br>".$query2yyA."<br>";
$mysql_result2yyA = mysqli_query($mysql_link,$query2yyA)or die("Error al consultar resolucion de facturacion: ".$mysql_error());
# fetch the data from the database
while ($datos2yyA = mysqli_fetch_row($mysql_result2yyA)) 
  {
	  //echo "entroooo";
	  //DIE();
$ID_RESOLUCION=$datos2yyA[0];
$LETRA="";
$query2yyX        = "SELECT id,INICIAL , FINAL , TEXTO, RESOLUCION, TIPO,FECHA_INICIO, FECHA_FIN, LETRA FROM RESOLUCION 
WHERE id= '$ID_RESOLUCION'  ORDER BY ID DESC LIMIT 0,1     ";
$query2yyX        = strtoupper($query2yyX);
//echo "<br>".$query2yyX."<br>";
//die();
		   $mysql_result2yyX = mysqli_query($mysql_link,$query2yyX)or die("Error al consultar resolucion de facturacion: ".$mysql_error());
		   # fetch the data from the database
		  while ($datos2yyX = mysqli_fetch_row($mysql_result2yyX)) 
		   {
		 //   $ID_RESOLUCION = $datos2yy[0];
			   //echo "<br>entro 1";
/*
			   $INICIAL= $datos2yy[1];
			   $FINAL = $datos2yy[2];
			   $TEXTO= $datos2yy[3];
			   $RESOLUCION= $datos2yy[4];
			   $TIPO= $datos2yy[5];
			   $FECHA_INICIO= $datos2yy[6];
			   $FECHA_FIN= $datos2yy[7];
*/
			   $LETRA = $datos2yyX[8];
			   //echo "<br>RES1:".$RESOLUCION."--<br>";
			   //echo $LETRA;
			   //die();
			 }
}
$NUMERO_FAC=$datos1[13];



 //ECHO "ID_FAC:".$ID_FACTURACION." res:".$ID_RESOLUCION." LETRA:".$LETRA; 




		 if($dfact3[0]<>"") { echo "<b>ANULADA</b><br>";
		 
		 $fac4="SELECT OPC_ANULACION FROM FACTURACION WHERE NUMERO_FAC='$datos1[13]' AND TIPO_ENTRADA = 1 AND ID_FACTURACION>$fact5";
		$rfac4=mysqli_query($mysql_link,$fac4);
		$dfact4= mysqli_fetch_row($rfac4);
		//echo "<br>".$fac4."<br>" ;

		 echo "<u>MOTIVO:</u> ";
		 
		 if($dfact4[0]==1)
		 echo "ANULACIÓN POR FECHA";
		 if($dfact4[0]==2)
		 echo "CAMBIOS SOLICITADOS EN LA FACTURA";
		 if($dfact4[0]==3)
		 echo "CLIENTE DESISTIO";
		 if($dfact4[0]==4)
		 echo "ANULACIÓN INTERNA";
		 
		 
		 //strtolower($dfact4[0])."<br>";
		 }		
		?>
   
   <? 
   /*
   if (file_exists("PDF/FACT_".$datos1[13]."_C.pdf")) 
	 	{
		 $image="PDF/FACT_".$datos1[13]."_C.pdf";
		 ?>
         <a href="<? ECHO $image; ?>" target="_blank"><? echo $LETRA."-".$datos1[13]; ?></a>
		 <?
		}
	else
	{
	 $image="PDF/FACT_".$datos1[13].".pdf";
	}
	*/
	$NOM_PDF="";
	$RUTA= "PDF/";
	
	if($ID_RESOLUCION > 11)
		 {
		// NUEVAS FACTURAS
		// LETRA - NUMERO_FAC.PDF
		$NOM_PDF=$LETRA."-".$NUMERO_FAC.".pdf";
	  // SI EXISTE ??
	  //ECHO "--ENTRO 1";
	  //ECHO "EXISTE:".file_exists($RUTA."".$NOM_PDF)."--<BR>";
	  if(file_exists($RUTA."".$NOM_PDF)=="1")
	  
			{
		// imprima con el hivervinculo
	
		echo "<a href='".$RUTA."".$NOM_PDF."' target='_blank'>".$LETRA."-".$datos1[13]."</a>";
		  }
	
	  }
	else
		{
		// VIEJAS FACTURAS
		// NUMERO_FAC_O.PDF
		// NUMERO_FAC_C.PDF
		$NOM_PDF="FACT_".$NUMERO_FAC."_O.pdf";
		// SI EXISTE ??
		if(file_exists($RUTA."".$NOM_PDF)=="1")
			{
			echo "<a href='".$RUTA."".$NOM_PDF."' target='_blank'>".$LETRA."-".$datos1[13]."</a>";
			}
	  else
			{
		  $NOM_PDF="FACT_".$NUMERO_FAC."_C.pdf";
	
		  if(file_exists($RUTA."".$NOM_PDF)=="1")
			  {
			  echo "<a href='".$RUTA."".$NOM_PDF."' target='_blank'>".$LETRA."-".$datos1[13]."</a>";
			  }
	
		  }
		}

	
	echo "<br><br>FECHA:<BR><b>".substr($datos1[20],0,10)."</b>";
	$sd=trim($datos1[25]);
	if($sd=="CONTADO")
		$sd=30;
		$sd=str_replace(" DIAS","",$sd);
		//echo $sd."---";
	echo "<br><br><br><i>VENCE:</i> ".date("Y-m-d",strtotime(substr($datos1[20],0,10)."+ $sd days"));
   ?></td>

	
	<? if($VER_REC<>1) {  ?>

<td  align="center"><? echo $datos1[24]; ?></td>
     <td  bgcolor="#e5e5e5"><div align="center"><span class="style3">
		 
		 <?
						
					
	 
	 //////////////// HONORARIOS
	 
	   
	 $cas="SELECT SUM(C.CANTIDAD*C.UNITARIO), ID_DFM, SUM(B.TRM*C.CANTIDAD*C.UNITARIO) FROM DETALLE_FACTURA C, FACTURACION B
	  WHERE 1
	 
	  
	 and B.NUMERO_FAC='$NUMERO_FAC'
	 AND (C.HONO_GAST_TOTAL = 'HONORARIOS' OR HONO_GAST_TOTAL = 'FEES') 
	  

	   AND C.ID_FACTURACION=B.ID_FACTURACION AND B.ID_FACTURACION>$fact5
	  $fe_adi2
	  ";
	//echo "sql: ".$cas."----<br>";

//  SE MODIFICO ALEJANDRO JIMENEZ   19082020


	 // C.CASO='$datos1[15]'   AND C.ID_FACTURACION='$datos1[18]'

//  SE MODIFICO ALEJANDRO JIMENEZ  Y ANDRES REYES 04082020
//  AND (C.HONO_GAST_TOTAL_TEXTO = 'HONORARIOS' OR HONO_GAST_TOTAL_TEXTO = 'FEES') 

// AND C.ID_HONO_GAST IN ('1','4','11','21')
	  $rescas=mysqli_query($mysql_link,$cas);
	  $datcas=mysqli_fetch_row($rescas);
	  //echo $cas."<br>";
	   
	  if($datcas[0]<>"") echo number_format($datcas[0], 0, '', ',');

//echo " ENTRA 3<br>";	 
	 if($dfact3[0]=="") {
	 //$sumx=$sumx+$datcas[2];

//MODIFICO ALEJANDRO JIMEENZ 19082020
//	 SE MODIFICO EL FINAL DEL IF
	 }
	 $sumx=$sumx+$datcas[2];
//echo " ENTRA 2<br>";
	 if(trim(strtoupper($datos1[24]))=="PESOS" )
	 {
	 $sum1=$sum1+$datcas[0];
//echo " ENTRA<br>";
	 }
	 if(trim(strtoupper($datos1[24]))=="DOLARES" )
	 {
	 $sum21=$sum21+$datcas[0];
	 
	 
$str="SELECT TRM FROM TRM WHERE FECHA='".substr($datos1[20],0,10)."'";
$rrtr=mysqli_query($mysql_link,$str);
$ddtrm=mysqli_fetch_row($rrtr);
	 
	 
	 if($ddtrm[0]==""){ ?>

<div style="background-color:#F00; border:1px #999 solid; width:100%; height:auto; color:#fff; font-weight:bold; padding:0; font-size:13px " align="center" >NO HAY TRM DEFINIDO</div>

<?
}

	 
	 }
	 //MODIFICO ALEJANDRO JIMEENZ 19082020
//  SE CAMBIO EL FIN DEL IF  if($dfact3[0]=="") { }
// DEBIDO A QUE SE COMPROMETIA EL VALOR SUMADO	 


	 

//	 echo " //".$sum1."<br>";
	   //echo number_format($datos1[4], 0, '', ','); ?></span></div>
	  
	 </td>
    
    <?
//echo $datos1[24]."|".$NUMERO_FAC."|".$datcas[0]."|".$sum1."|".$sum21."<br>";
    ?>
	
	<td align="center" >
		<strong style="background-color:#F00; border:0px #999 solid; width:100%; height:auto; color:#fff; font-weight:bold; padding:0; font-size:13px " align="center"><? include("nota_credito_estado.php");?></strong> <!-- ANDRES REYES 25/10/2023 -->
		<?  
	$cas="SELECT SUM(C.CANTIDAD * C.UNITARIO ), ID_DFM, SUM(B.TRM*C.CANTIDAD*C.UNITARIO) FROM DETALLE_FACTURA C, FACTURACION B
	  WHERE 1 
	  
	  AND C.ID_HONO_GAST IN ('2','5','12')
	  
	  
	  AND C.ID_FACTURACION=B.ID_FACTURACION
	  and B.NUMERO_FAC='$NUMERO_FAC' AND B.ID_FACTURACION>$fact5
	  $fe_adi2
	  ";	  
	 // MODIFICACION ALEJANDRO JIMENEZ 19082020
	  //C.CASO='$datos1[15]'
// AND C.ID_FACTURACION='$datos1[18]'

	  // MODIFICACION ALEJANDRO JIMENEZ Y ANDRES REYES 04082020
	  //AND (C.HONO_GAST_TOTAL_TEXTO = 'TASAS FISCALES' OR HONO_GAST_TOTAL_TEXTO = 'OFFICIAL FEES') 
	  $rescas=mysqli_query($mysql_link,$cas);
	   $datcas=mysqli_fetch_row($rescas);
	  if($datcas[0]<>"") { echo number_format($datcas[0], 0, '', ',');   
//	    if($dfact3[0]=="") {
		$sumx2=$sumx2+$datcas[2];
	   if(trim(strtoupper($datos1[24]))=="PESOS" )
	  $sum3=$sum3+$datcas[0];
	  if(trim(strtoupper($datos1[24]))=="DOLARES" )
	  $sum23=$sum23+$datcas[0];
//	   	  	 } 
	     ?><BR>
	  <a onClick="javascript:window.open('soportes_gastos.php?idg=<? echo $datcas[1]; //echo $datos1[11]; ?>&ID_TRAMITE=<? echo $datos1[15]; ?>', '_blank','top=130, left=320, height=400, width=450, status=no, menubar=no, resizable=no, scrollbars=no, toolbar=no, location=no, directories=no');" style="cursor:pointer; color:#0033FF; font-size:10px"><u>VER RECIBOS</u></a><? } ?></td>
	  
	  
	<td align="center" ><? $cas="SELECT SUM(C.CANTIDAD * C.UNITARIO ), ID_DFM, SUM(B.TRM*C.CANTIDAD*C.UNITARIO) FROM DETALLE_FACTURA C, FACTURACION B
	  WHERE 1
	  
	 
	  AND C.ID_HONO_GAST IN ('9','10','14')

	   AND C.GASTOS_TERCEROS_SEL<>'CORRESPONSAL' AND B.ID_FACTURACION>$fact5
	   
	  
	  
	  AND C.ID_FACTURACION=B.ID_FACTURACION
	   
	   and B.NUMERO_FAC='$NUMERO_FAC' AND B.ID_FACTURACION>$fact5
	  $fe_adi2
	  ";
	
	//echo $cas."--<br>";
	 // MODIFICO ALEJANDRO JIMENEZ 19082020
	  //C.CASO='$datos1[15]' 
//AND C.ID_FACTURACION='$datos1[18]' 

	 // MODIFICACION ALEJANDRO JIMENEZ Y ANDRES REYES 04082020
	 // AND (C.HONO_GAST_TOTAL_TEXTO = 'GASTOS TERCEROS' OR C.HONO_GAST_TOTAL_TEXTO='GASTOS REEMBOL. TERCEROS' OR HONO_GAST_TOTAL_TEXTO = 'REIMBURSABLE EXPENSES') 
	 
	 $rescas=mysqli_query($mysql_link,$cas);
	   $datcas=mysqli_fetch_row($rescas);
	  if($datcas[0]<>"") { echo number_format($datcas[0], 0, '', ','); 
	 // if($dfact3[0]=="") {
	  $sumx3=$sumx3+$datcas[2];
	  if(trim(strtoupper($datos1[24]))=="PESOS" )
	  $sum4=$sum4+$datcas[0];  
	  if(trim(strtoupper($datos1[24]))=="DOLARES" )
	  $sum24=$sum24+$datcas[0];
	 // }
	  ?><BR>
	  <a onClick="javascript:window.open('soportes_gastos.php?idg=<? echo $datcas[1]; //echo $datos1[11]; ?>&ID_TRAMITE=<? echo $datos1[15]; ?>', '_blank','top=130, left=320, height=400, width=450, status=no, menubar=no, resizable=no, scrollbars=no, toolbar=no, location=no, directories=no');" style="cursor:pointer; color:#0033FF; font-size:10px"><u>VER RECIBOS</u></a><? } ?></td>
	  
	<td align="center" ><?
	 $cas="SELECT SUM(C.CANTIDAD * C.UNITARIO ), ID_DFM, SUM(B.TRM*C.CANTIDAD*C.UNITARIO) FROM DETALLE_FACTURA C, FACTURACION B
	  
	  where 1 
	  AND C.ID_HONO_GAST IN ('7','8','13')
	  
	  
	   AND C.ID_FACTURACION=B.ID_FACTURACION
	  

	   and B.NUMERO_FAC='$NUMERO_FAC' AND B.ID_FACTURACION>$fact5
	  $fe_adi2
	  ";
	//MODIFICO ALEJANDRO JIMENEZ 19082020
// WHERE C.CASO='$datos1[15]' 
//AND C.ID_FACTURACION='$datos1[18]'
//echo $cas."<br>";
	//MODIFICO ALEJANDRO JIMENEZ Y ANDRES REYES
     //AND (C.HONO_GAST_TOTAL_TEXTO = 'GASTOS MENORES'  OR HONO_GAST_TOTAL_TEXTO = 'MISCELANEOUS' ) 
	  $rescas=mysqli_query($mysql_link,$cas);
	   $datcas=mysqli_fetch_row($rescas);
	  if($datcas[0]<>"") { echo number_format($datcas[0], 0, '', ','); 
	  //if($dfact3[0]=="") {
	  $sumx4=$sumx4+$datcas[2];
	  if(trim(strtoupper($datos1[24]))=="PESOS" )
	  $sum5=$sum5+$datcas[0]; 
	  if(trim(strtoupper($datos1[24]))=="DOLARES" )
	  $sum25=$sum25+$datcas[0];
	   //  }
	  ?><BR>
	  <a onClick="javascript:window.open('soportes_gastos.php?idg=<? echo $datcas[1]; //echo $datos1[11]; ?>&ID_TRAMITE=<? echo $datos1[15]; ?>', '_blank','top=130, left=320, height=400, width=450, status=no, menubar=no, resizable=no, scrollbars=no, toolbar=no, location=no, directories=no');" style="cursor:pointer; color:#0033FF; font-size:10px">
	  <u>VER RECIBOS</u></a><? } ?></td>
	  
 <td align="center" ><? $cas="SELECT SUM(C.CANTIDAD * C.UNITARIO ), ID_DFM, SUM(B.TRM*C.CANTIDAD*C.UNITARIO) FROM DETALLE_FACTURA C, FACTURACION B
	  WHERE 1
	  
	  AND (C.GASTOS_TERCEROS_SEL='CORRESPONSAL') 
	  
	   AND C.ID_FACTURACION=B.ID_FACTURACION

	   and B.NUMERO_FAC='$NUMERO_FAC' AND B.ID_FACTURACION>$fact5
	  $fe_adi2

	  ORDER BY C.HONO_GAST_TOTAL_TEXTO";
	  //echo $cas;
// MODIFICO ALEJANDRO JIMENEZ  19082020
//  	   AND C.ID_FACTURACION='$datos1[18]'	  
	  // C.CASO='$datos1[15]' 
	 
	
	  $rescas=mysqli_query($mysql_link,$cas);
	   $datcas=mysqli_fetch_row($rescas);
	   if($datcas[0]<>"") { echo number_format($datcas[0], 0, '', ',');  
	  // 	 if($dfact3[0]=="") {
		  $sumx5=$sumx5+$datcas[2];
	   if(trim(strtoupper($datos1[24]))=="PESOS" )
	   $sum6=$sum6+$datcas[0];  
	   if(trim(strtoupper($datos1[24]))=="DOLARES" )
	   $sum26=$sum26+$datcas[0];
	    //  }
	   ?><BR>
	  <a onClick="javascript:window.open('soportes_gastos.php?idg=<? echo $datcas[1]; //echo $datos1[11]; ?>&ID_TRAMITE=<? echo $datos1[15]; ?>', '_blank','top=130, left=320, height=400, width=450, status=no, menubar=no, resizable=no, scrollbars=no, toolbar=no, location=no, directories=no');" style="cursor:pointer; color:#0033FF; font-size:10px"><u>VER RECIBOS</u></a><? } ?></td>		
	
	<td align="center" bgcolor="#eee"><?  
		
		$fac4="SELECT (SUBTOTAL), SUM(TRM*SUBTOTAL) FROM FACTURACION WHERE NUMERO_FAC='$datos1[13]' AND ID_FACTURACION >'$fact5' 

$fe_adi 
		";
		$rfac4=mysqli_query($mysql_link,$fac4);
		$dfact4= mysqli_fetch_row($rfac4);
		
		    echo number_format($dfact4[0]);
		//	if($dfact3[0]=="") {
				  $sumx6=$sumx6+$dfact4[1];
 //echo "<br>sum:".$sumx6."<br>";
			echo "<br>";
			if(trim(strtoupper($datos1[24]))=="PESOS" )
		    $sum=$sum+$dfact4[0];
			if(trim(strtoupper($datos1[24]))=="DOLARES" )
			$sum27=$sum27+$dfact4[0];
	//		}
		//echo $fac4;
			 ?></td>
	
	
	<td align="center" ><? 
			
	$fff=date("Y-m-d",strtotime(substr($datos1[20],0,10)."+ $sd days"));
	 echo "<b>".diferenciaDias($hoy, $fff)."</b>"; 
$sd="";
$fff="";
 ?></td>
 
 
 <?  } else {  //echo $NUMERO_FAC."<br>";      ?>
	
	<td align="center"><?   
// AND A.ID_GAST LIKE '%$DDRh2y[1]%'
$TAT=0;
// busca los ID_GAST de la tabla recaudo

 $ssd1a="SELECT A.ID, A.MONEDA, A.ABONO, A.FECHA, A.VALOR, A.ID_GAST  FROM VALOR_RECAUDO A, FACTURACION B 
WHERE A.ID_TRAMITE='$datos1[15]' AND A.ABONO=0 AND A.N_FACT='$datos1[13]' AND A.N_FACT=B.NUMERO_FAC AND B.ESTADO_CARTERA='1' AND B.ID_FACTURACION>$fact5 ";
$RESSSD1a=mysqli_query($mysql_link,$ssd1a);
$dat1a=mysqli_fetch_row($RESSSD1a);
//echo $ssd1a."--<br>";

////******************** ABONOS HON ********************////////

$TOT_ABON=0;
 $sel_abon="SELECT SUM(B.VALOR) FROM ABONO_RECAUDO B, VALOR_RECAUDO A 
WHERE B.ID_TRAMITE='$datos1[15]'  AND B.FACTURA='$NUMERO_FAC' AND B.TIPO='HONORARIOS'
 AND A.N_FACT=B.FACTURA AND A.ABONO='1' AND B.MONEDA=2 AND B.CLASE_ABONO=1 ";
$res_abon_hon=mysqli_query($mysql_link, $sel_abon );
$dat_abon_hon=mysqli_fetch_row($res_abon_hon);
if($dat_abon_hon[0]<>""){

/// SUMA TOTAL Y CONVIERTE A PESOS
$sumx=$sumx+$dat_abon_hon[0];
$TOT_ABON=$dat_abon_hon[0]; 
	// TOTAL PESOS		
	 $sum1=$sum1+$dat_abon_hon[0];
}
//echo "holaaaaa 1";
  $ssd1a="SELECT A.ID, C.MONEDA, A.ABONO, C.FECHA, C.VALOR, A.ID_GAST  
  FROM VALOR_RECAUDO A, FACTURACION B, ABONO_RECAUDO C
WHERE A.N_FACT=C.FACTURA AND A.ID_TRAMITE='$datos1[15]' AND A.ABONO=1 AND A.N_FACT='$datos1[13]' AND A.N_FACT=B.NUMERO_FAC AND B.ESTADO_CARTERA='1' AND B.ID_FACTURACION>$fact5  AND C.MONEDA=3 AND C.TIPO='HONORARIOS' AND C.CLASE_ABONO=1";
$RESSSD1a=mysqli_query($mysql_link,$ssd1a);
while($dat1ax=mysqli_fetch_row($RESSSD1a)){

$str="SELECT TRM FROM TRM WHERE FECHA='$dat1ax[3]'";
$rrtr=mysqli_query($mysql_link,$str);
$ddtrm=mysqli_fetch_row($rrtr);

if($ddtrm[0]==""){ ?>

<div style="background-color:#F00; border:1px #999 solid; width:100%; height:auto; color:#fff; font-weight:bold; padding:0; font-size:13px " align="center" >NO HAY TRM DEFINIDO PARA LA FECHA DEL ABONO: <u><? echo $dat1ax[3]; ?></u></div>

<?
}

/// SUMA TOTAL Y CONVIERTE A DOl
$sumx=$sumx+($dat1ax[4]*$ddtrm[0]);
 //TOTAL DOLARES
	 $sum21=$sum21+($dat1ax[4]);

$TOT_ABON=$TOT_ABON+($dat1ax[4]);
}
		 
	 //echo $dat_abon_hon[0]."--".($dat_abon_hon[0]*$ddtrm[0])."<br>";
//echo "Hola 2---";	 	
 $sel_abon2="SELECT B.VALOR, B.FECHA FROM ABONO_RECAUDO B, VALOR_RECAUDO A  
WHERE B.ID_TRAMITE='$datos1[15]'  AND B.FACTURA='$NUMERO_FAC' AND B.TIPO='HONORARIOS'
AND A.ABONO=1 AND A.N_FACT=B.FACTURA ";
$res_abon_hon2=mysqli_query($mysql_link, $sel_abon2 );
while($dat_abon_hon2=mysqli_fetch_row($res_abon_hon2)){
echo "<b>ABONO</b><br>".number_format($dat_abon_hon2[0]);
echo "<br><span style='color:#666'>".$dat_abon_hon2[1]."</span><br><br>";	
}	
	if($TOT_ABON>0){
	echo "<br><b>TOTAL:</b>&nbsp;".number_format($TOT_ABON);
	$TAT="";
	}

////******************** FIN ABONOS HON ********************////////

//echo  $dat1a[5]."____";
$air=explode(",", $dat1a[5]);
    $cont=substr_count($dat1a[5], ",");
		 for($i=0;$i<$cont;$i++)	{

if($air[$i]<>"") {
// AND C.ID_FACTURACION='$datos1[18]'
//GROUP BY B.NUMERO_FAC


/************************ HONORARIOS  *******************************/

 $queryx="
SELECT C.TOTAL, C.ID_DFM
FROM FACTURACION B, DETALLE_FACTURA C
WHERE B.ID_FACTURACION = C.ID_FACTURACION
AND B.ESTADO_CARTERA='1' AND C.ID_DFM='$air[$i]'

AND (C.HONO_GAST_TOTAL='HONORARIOS' OR C.HONO_GAST_TOTAL='FEES')
 
 and B.NUMERO_FAC='$NUMERO_FAC' AND B.ID_FACTURACION>$fact5
	  $fe_adi2
GROUP BY C.ID_FACTURACION
";
// MODIFICO ALEJANDRO JIMENEZ 19082020
//AND C.CASO='$datos1[15]' 

// MODIFCADO AALEJANDRO JIMENEZ Y ANDRES REYES 06082020
//AND (C.HONO_GAST_TOTAL_TEXTO='HONORARIOS' OR C.HONO_GAST_TOTAL_TEXTO='FEES')

// AND C.ID_HONO_GAST IN ('1','4','11','21')

$honx=mysqli_query($mysql_link,$queryx);
$DDRh2y=mysqli_fetch_row($honx);


///// VALIDACION DESCARTAR FACT. ANULADAS
	
	$VAL_FACT_ANUL="SELECT NUMERO_FAC FROM FACTURACION WHERE NUMERO_FAC='$NUMERO_FAC' AND TIPO_ENTRADA=2 AND ID_FACTURACION>$fact5 ";
	$RESS_VAL=mysqli_query($mysql_link,$VAL_FACT_ANUL);
	$val_num_FACT=mysqli_num_rows($RESS_VAL);


if($DDRh2y[0]<>"" && $val_num_FACT==0 ) {

 $TAT=$TAT+$DDRh2y[0];
//echo "<br>";

if($dat1a[1]=="3"){
$str="SELECT TRM FROM TRM WHERE FECHA='$dat1a[3]'";
$rrtr=mysqli_query($mysql_link,$str);
$ddtrm=mysqli_fetch_row($rrtr);

if($ddtrm[0]==""){ ?>

<div style="background-color:#F00; border:1px #999 solid; width:100%; height:auto; color:#fff; font-weight:bold; padding:0; font-size:13px " align="center" >NO HAY TRM DEFINIDO PARA LA FECHA DEL RECAUDO: <u><? echo $dat1a[3]; ?></u></div>

<?
}
}
else 
$ddtrm[0]=1;



$sumx=$sumx+($DDRh2y[0]*$ddtrm[0]);

//echo $air[$i]."___".$DDRh2y[0]."----".$sumx."---".$dat1a[1]."---".$ddtrm[0]."<br>";

	 //if(trim(strtoupper($datos1[24]))=="PESOS" )
	 if($dat1a[1]=="2" || $dat1a[1]=="0")
	 $sum1=$sum1+$DDRh2y[0];
	 //if(trim(strtoupper($datos1[24]))=="DOLARES" )
	 if($dat1a[1]=="3")
	 $sum21=$sum21+$DDRh2y[0];
}
//else
//echo "0";


}

}

echo number_format($TAT);
/*if($dat1a[0]==""){
$ssd1a="SELECT ID, MONEDA, ABONO, FECHA, VALOR  FROM VALOR_RECAUDO WHERE ID_TRAMITE='$datos1[15]' AND ABONO='1' AND N_FACT='$datos1[13]' ";
$RESSSD1a=mysqli_query($mysql_link,$ssd1a);
$dat1a=mysqli_fetch_row($RESSSD1a);
}*/

//////////////// ABONOS
/*if($dat1a[2]==1) {  echo "<b><U>ABONO</U></b><BR>"; 

if($dat1a[1]==2){
echo number_format($dat1a[4]);
	 $sum1=$sum1+$dat1a[4];
	 $sumx=$sumx+$dat1a[4];
}
if($dat1a[1]==3){
$str="SELECT TRM FROM TRM WHERE FECHA='$dat1a[3]'";
$rrtr=mysqli_query($mysql_link,$str);
$ddtrm=mysqli_fetch_row($rrtr);
$sum21=$sum21+$dat1a[4];
echo number_format($dat1a[4]);
$sumx=$sumx+($dat1a[4]*$ddtrm[0]);

}

}*/
////////////////////////////////

//if($dat1a[2]==0) {

//}

   ?></td>
   
   <? //echo $NUMERO_FAC."___".$DDRh2y[0]."----".$sumx."---".$dat1a[1]."---".$ddtrm[0]."<br>";
      //echo $NUMERO_FAC."<br>";
   ?>
   
	<td align="center"><?   

/************************ TASAS FISC.  *******************************/
	
	
	 $queryx="
SELECT SUM(C.TOTAL), C.ID_DFM
FROM FACTURACION B, DETALLE_FACTURA C
WHERE B.ID_FACTURACION = C.ID_FACTURACION
AND C.ID_FACTURACION='$datos1[18]' AND B.ESTADO_CARTERA='1'
AND C.CASO='$datos1[15]' 

AND C.ID_HONO_GAST IN (2,5,12)

 and B.NUMERO_FAC='$NUMERO_FAC' AND B.ID_FACTURACION>$fact5
	  $fe_adi2
GROUP BY B.NUMERO_FAC
";
//echo "holaaa";
//MODIFICO ALEJANDRO JIMENEZ 19082020
// AND C.CASO='$datos1[15]' 
//AND C.ID_FACTURACION='$datos1[18]' 

// MOFICADO POR ALEJANDRO JIMENEZ Y ANDRES REYES 06082020
//AND (C.HONO_GAST_TOTAL='TASAS FISCALES' OR C.HONO_GAST_TOTAL='OFFICIAL FEES')

////AND C.ID_HONO_GAST IN ('2','5','12')


$honx=mysqli_query($mysql_link,$queryx);
$DDRh2x=mysqli_fetch_row($honx);

//echo "<br><br><br>";

 $ssd1b="SELECT ID, MONEDA, ABONO, FECHA  FROM VALOR_RECAUDO WHERE ID_TRAMITE='$datos1[15]' AND (ID_GAST LIKE '%$DDRh2x[1]%' OR N_FACT='$datos1[13]') ";
$RESSSD1b=mysqli_query($mysql_link,$ssd1b);
$dat1b=mysqli_fetch_row($RESSSD1b);

//echo  $dat1b[2]."---";


////******************** ABONOS TF ********************////////

$sel_abon="SELECT SUM(VALOR) FROM ABONO_RECAUDO WHERE ID_TRAMITE='$datos1[15]'  AND FACTURA='$NUMERO_FAC' AND TIPO='TASAS FISCALES'";
$res_abon_hon=mysqli_query($mysql_link, $sel_abon );
$dat_abon_hon=mysqli_fetch_row($res_abon_hon);

if($dat_abon_hon[0]<>""){

 $ssd1a="SELECT A.ID, A.MONEDA, A.ABONO, A.FECHA, A.VALOR, A.ID_GAST  FROM VALOR_RECAUDO A, FACTURACION B 
WHERE A.ID_TRAMITE='$datos1[15]' AND A.ABONO=1 AND A.N_FACT='$datos1[13]' AND A.N_FACT=B.NUMERO_FAC AND B.ESTADO_CARTERA='1' AND B.ID_FACTURACION>$fact5 ";
//ECHO $ssd1a."--<BR>";
$RESSSD1a=mysqli_query($mysql_link,$ssd1a);
$dat1a=mysqli_fetch_row($RESSSD1a);

if($dat1a[1]=="3"){
$str="SELECT TRM FROM TRM WHERE FECHA='$dat1a[3]'";
$rrtr=mysqli_query($mysql_link,$str);
$ddtrm=mysqli_fetch_row($rrtr);

if($ddtrm[0]==""){ ?>

<div style="background-color:#F00; border:1px #999 solid; width:100%; height:auto; color:#fff; font-weight:bold; padding:0; font-size:13px " align="center" >NO HAY TRM DEFINIDO PARA LA FECHA DEL ABONO: <u><? echo $dat1a[3]; ?></u></div>

<?
}
}
else 
$ddtrm[0]=1;

/// SUMA TOTAL Y CONVIERTE A PESOS
$sumx2=$sumx2+($dat_abon_hon[0]*$ddtrm[0]);

	// TOTAL PESOS	
	 if($dat1a[1]=="2" || $dat1a[1]=="0")
	 $sum3=$sum3+$dat_abon_hon[0];
	 //TOTAL DOLARES
	 if($dat1a[1]=="3")
	 $sum23=$sum23+$dat_abon_hon[0];
	$tsr="";
	$sel_abon2="SELECT VALOR, FECHA FROM ABONO_RECAUDO WHERE ID_TRAMITE='$datos1[15]'  AND FACTURA='$NUMERO_FAC' AND TIPO='TASAS FISCALES'";
$res_abon_hon2=mysqli_query($mysql_link, $sel_abon2 );
while($dat_abon_hon2=mysqli_fetch_row($res_abon_hon2)){
echo "<b>ABONO</b><br>".number_format($dat_abon_hon2[0]);
$tsr=number_format($dat_abon_hon2[0]);
echo "<br><span style='color:#666'>".$dat_abon_hon2[1]."</span><br><br>";	
}
	
	
	echo "<br><b>TOTAL:</b>&nbsp;".number_format($dat_abon_hon[0]);
	$TAT="";
}

////******************** FIN ABONOS TF ********************////////



//// SIN ABONOS
if($DDRh2x[0]<>"" && $val_num_FACT==0 ) {
	
if($dat1b[0]<>""  && $dat1b[2]==0)
echo number_format($DDRh2x[0]);
else {
	if($tsr=="")
echo "0";
}
if($dat1b[1]=="3"){
 $str="SELECT TRM FROM TRM WHERE FECHA='$dat1b[3]'";
$rrtr=mysqli_query($mysql_link,$str);
$ddtrm=mysqli_fetch_row($rrtr);
}
else 
$ddtrm[0]=1;

if($dat1b[0]<>""  && $dat1b[2]==0)
$sumx2=$sumx2+($DDRh2x[0] * $ddtrm[0]);
else
$sumx2=$sumx2+0;

	  if(trim(strtoupper($datos1[24]))=="PESOS" && $dat1b[2]==0 )
	  $sum3=$sum3+$DDRh2x[0];
	  if(trim(strtoupper($datos1[24]))=="DOLARES"  && $dat1b[2]==0 )
	  $sum23=$sum23+$DDRh2x[0];

} else echo "0";  ?></td>
	<td align="center"><?   
	
/************************ GASTOS TERCEROS  *******************************/
	
	
 $queryx="
SELECT SUM(C.TOTAL), C.ID_DFM
FROM FACTURACION B, DETALLE_FACTURA C
WHERE B.ID_FACTURACION = C.ID_FACTURACION
AND C.ID_FACTURACION='$datos1[18]' AND B.ESTADO_CARTERA='1'
AND C.CASO='$datos1[15]' 
and B.NUMERO_FAC='$NUMERO_FAC'
AND C.ID_HONO_GAST IN ('9','10','14')

AND C.GASTOS_TERCEROS_SEL<>'CORRESPONSAL' AND B.ID_FACTURACION>$fact5

GROUP BY B.NUMERO_FAC
";
// MODIFICADO POR ALEJANDRO JIMENEZ Y ANDRES REYES 06082020
//AND (C.HONO_GAST_TOTAL='GASTOS REEMBOL. TERCEROS' OR C.HONO_GAST_TOTAL='REIMBURSABLE EXPENSES') 
// AND C.ID_HONO_GAST IN ('9','10','14')

$honx=mysqli_query($mysql_link,$queryx);
$DDx=mysqli_fetch_row($honx);

$ssd1c="SELECT ID, MONEDA, ABONO, FECHA  FROM VALOR_RECAUDO WHERE ID_TRAMITE='$datos1[15]' AND ID_GAST LIKE '%$DDx[1]%' AND N_FACT='$datos1[13]' ";
$RESSSD1c=mysqli_query($mysql_link,$ssd1c);
$dat1c=mysqli_fetch_row($RESSSD1c);
//ECHO $ssd1a."--<BR>";


////******************** ABONOS GT ********************////////

$sel_abon="SELECT SUM(VALOR) FROM ABONO_RECAUDO WHERE ID_TRAMITE='$datos1[15]'  AND FACTURA='$NUMERO_FAC' AND TIPO='GASTOS TERCEROS'";
$res_abon_hon=mysqli_query($mysql_link, $sel_abon );
$dat_abon_hon=mysqli_fetch_row($res_abon_hon);

if($dat_abon_hon[0]<>""){

 $ssd1a="SELECT A.ID, A.MONEDA, A.ABONO, A.FECHA, A.VALOR, A.ID_GAST  FROM VALOR_RECAUDO A, FACTURACION B 
WHERE A.ID_TRAMITE='$datos1[15]' AND A.ABONO=1 AND A.N_FACT='$datos1[13]' AND A.N_FACT=B.NUMERO_FAC AND B.ESTADO_CARTERA='1' AND B.ID_FACTURACION>$fact5 ";
//ECHO $ssd1a."--<BR>";
$RESSSD1a=mysqli_query($mysql_link,$ssd1a);
$dat1a=mysqli_fetch_row($RESSSD1a);

if($dat1a[1]=="3"){
$str="SELECT TRM FROM TRM WHERE FECHA='$dat1a[3]'";
$rrtr=mysqli_query($mysql_link,$str);
$ddtrm=mysqli_fetch_row($rrtr);

if($ddtrm[0]==""){ ?>

<div style="background-color:#F00; border:1px #999 solid; width:100%; height:auto; color:#fff; font-weight:bold; padding:0; font-size:13px " align="center" >NO HAY TRM DEFINIDO PARA LA FECHA DEL ABONO: <u><? echo $dat1a[3]; ?></u></div>

<?
}
}
else 
$ddtrm[0]=1;

/// SUMA TOTAL Y CONVIERTE A PESOS
$sumx3=$sumx3+($dat_abon_hon[0]*$ddtrm[0]);

	// TOTAL PESOS	
	 if($dat1a[1]=="2" || $dat1a[1]=="0")
	 $sum4=$sum4+$dat_abon_hon[0];
	 //TOTAL DOLARES
	 if($dat1a[1]=="3")
	 $sum24=$sum24+$dat_abon_hon[0];
	
	$sel_abon2="SELECT VALOR, FECHA FROM ABONO_RECAUDO WHERE ID_TRAMITE='$datos1[15]'  AND FACTURA='$NUMERO_FAC' AND TIPO='GASTOS TERCEROS'";
$res_abon_hon2=mysqli_query($mysql_link, $sel_abon2 );
while($dat_abon_hon2=mysqli_fetch_row($res_abon_hon2)){
echo "<b>ABONO</b><br>".number_format($dat_abon_hon2[0]);
echo "<br><span style='color:#666'>".$dat_abon_hon2[1]."</span><br><br>";	
}
	
	
	echo "<br><b>TOTAL:</b>&nbsp;".number_format($dat_abon_hon[0]);
	$TAT="";
}

////******************** FIN ABONOS GT ********************////////


if($dat1c[0]<>"" && $dat1c[2]==0)
echo number_format($DDx[0]);
else
echo "0";

if($dat1c[1]=="3"){
$str="SELECT TRM FROM TRM WHERE FECHA='$dat1c[3]'";
$rrtr=mysqli_query($mysql_link,$str);
$ddtrm=mysqli_fetch_row($rrtr);
}
else 
$ddtrm[0]=1;
 $sumx3=$sumx3+($DDx[0]*$ddtrm[0]);
 
	  if(trim(strtoupper($datos1[24]))=="PESOS" )
	  $sum4=$sum4+$DDx[0];  
	  if(trim(strtoupper($datos1[24]))=="DOLARES" )
	  $sum24=$sum24+$DDx[0];

   ?></td>
   
   
	<td  align="center"><?   
	
/************************ GASTOS MENORES  *******************************/
	
	
	 $queryx="
SELECT SUM(C.TOTAL), C.ID_DFM
FROM FACTURACION B, DETALLE_FACTURA C
WHERE B.ID_FACTURACION = C.ID_FACTURACION
AND C.ID_FACTURACION='$datos1[18]' AND B.ESTADO_CARTERA='1'
AND C.CASO='$datos1[15]' 
and B.NUMERO_FAC='$NUMERO_FAC'
AND C.ID_HONO_GAST IN ('7','8','13')

 AND B.ID_FACTURACION>$fact5

GROUP BY B.NUMERO_FAC
";
// MODIFICADO POR ALEJANDRO JIMENEZ Y ANDRES REYES 06082020
//AND (C.HONO_GAST_TOTAL_TEXTO='GASTOS MENORES' OR C.HONO_GAST_TOTAL_TEXTO='MISCELANEOUS')
// AND C.ID_HONO_GAST IN ('7','8','13')
$honx=mysqli_query($mysql_link,$queryx);
$DDx2=mysqli_fetch_row($honx);

$ssd1d="SELECT ID, MONEDA, ABONO, FECHA  FROM VALOR_RECAUDO WHERE ID_TRAMITE='$datos1[15]' AND ID_GAST LIKE '%$DDx2[1]%' AND N_FACT='$datos1[13]' ";
$RESSSD1d=mysqli_query($mysql_link,$ssd1d);
$dat1d=mysqli_fetch_row($RESSSD1d);


////******************** ABONOS GM ********************////////

$sel_abon="SELECT SUM(VALOR) FROM ABONO_RECAUDO WHERE ID_TRAMITE='$datos1[15]'  AND FACTURA='$NUMERO_FAC' AND TIPO='GASTOS MENORES'";
$res_abon_hon=mysqli_query($mysql_link, $sel_abon );
$dat_abon_hon=mysqli_fetch_row($res_abon_hon);

if($dat_abon_hon[0]<>""){

 $ssd1a="SELECT A.ID, A.MONEDA, A.ABONO, A.FECHA, A.VALOR, A.ID_GAST  FROM VALOR_RECAUDO A, FACTURACION B 
WHERE A.ID_TRAMITE='$datos1[15]' AND A.ABONO=1 AND A.N_FACT='$datos1[13]' AND A.N_FACT=B.NUMERO_FAC AND B.ESTADO_CARTERA='1' AND B.ID_FACTURACION>$fact5 ";
$RESSSD1a=mysqli_query($mysql_link,$ssd1a);
$dat1a=mysqli_fetch_row($RESSSD1a);

if($dat1a[1]=="3"){
$str="SELECT TRM FROM TRM WHERE FECHA='$dat1a[3]'";
$rrtr=mysqli_query($mysql_link,$str);
$ddtrm=mysqli_fetch_row($rrtr);

if($ddtrm[0]==""){ ?>

<div style="background-color:#F00; border:1px #999 solid; width:100%; height:auto; color:#fff; font-weight:bold; padding:0; font-size:13px " align="center" >NO HAY TRM DEFINIDO PARA LA FECHA DEL ABONO: <u><? echo $dat1a[3]; ?></u></div>

<?
}
}
else 
$ddtrm[0]=1;

/// SUMA TOTAL Y CONVIERTE A PESOS
$sumx4=$sumx4+($dat_abon_hon[0]*$ddtrm[0]);

	// TOTAL PESOS	
	 if($dat1a[1]=="2" || $dat1a[1]=="0")
	 $sum5=$sum5+$dat_abon_hon[0];
	 //TOTAL DOLARES
	 if($dat1a[1]=="3")
	 $sum25=$sum25+$dat_abon_hon[0];
	
	$sel_abon2="SELECT VALOR, FECHA FROM ABONO_RECAUDO WHERE ID_TRAMITE='$datos1[15]'  AND FACTURA='$NUMERO_FAC' AND TIPO='GASTOS MENORES'";
$res_abon_hon2=mysqli_query($mysql_link, $sel_abon2 );
while($dat_abon_hon2=mysqli_fetch_row($res_abon_hon2)){
echo "<b>ABONO</b><br>".number_format($dat_abon_hon2[0]);
echo "<br><span style='color:#666'>".$dat_abon_hon2[1]."</span><br><br>";	
}
	
	
	echo "<br><b>TOTAL:</b>&nbsp;".number_format($dat_abon_hon[0])."<br>";
	$TAT="";
}

////******************** FIN ABONOS GM ********************////////



if($dat1d[0]<>"" && $dat1d[2]==0)
echo $TAT=number_format($DDx2[0]);
else
echo $TAT=0;

//echo "--".$dat1d[1];

if($dat1d[1]=="3"){
$str="SELECT TRM FROM TRM WHERE FECHA='$dat1d[3]'";
$rrtr=mysqli_query($mysql_link,$str);
$ddtrm=mysqli_fetch_row($rrtr);
}
else 
$ddtrm[0]=1;

$sumx4=$sumx4+($DDx2[0]*$ddtrm[0]);


	  if(trim(strtoupper($datos1[24]))=="PESOS" )
	  $sum5=$sum5+$DDx2[0]; 
	  if(trim(strtoupper($datos1[24]))=="DOLARES" )
	  $sum25=$sum25+$DDx2[0];
   ?></td>
	<td  align="center"><? 
	
/************************ GASTOS CORRESPONSAL  *******************************/
	
	
	   $queryx="
SELECT SUM(C.TOTAL), C.ID_DFM
FROM FACTURACION B, DETALLE_FACTURA C
WHERE B.ID_FACTURACION = C.ID_FACTURACION
AND C.ID_FACTURACION='$datos1[18]' AND B.ESTADO_CARTERA='1'
AND C.CASO='$datos1[15]' 
and B.NUMERO_FAC='$NUMERO_FAC'
 AND C.ID_HONO_GAST IN ('9','10','14')
 
 AND B.ID_FACTURACION>$fact5
 
 AND C.GASTOS_TERCEROS_SEL='CORRESPONSAL'
GROUP BY B.NUMERO_FAC
";
//MODIFICADO POR ALEJANDRO JIMENEZ Y ANDRES REYES 06082020
//AND (C.HONO_GAST_TOTAL_TEXTO='GASTOS REEMBOL. TERCEROS' OR C.HONO_GAST_TOTAL_TEXTO='REIMBURSABLE EXPENSES') 
//  AND C.ID_HONO_GAST IN ('9','10','14') 


$honx=mysqli_query($mysql_link,$queryx);
$DDx3=mysqli_fetch_row($honx);

$ssd1e="SELECT ID, MONEDA, ABONO, FECHA  FROM VALOR_RECAUDO WHERE ID_TRAMITE='$datos1[15]' AND ID_GAST LIKE '%$DDx3[1]%' AND N_FACT='$datos1[13]' ";
$RESSSD1e=mysqli_query($mysql_link,$ssd1e);
$dat1e=mysqli_fetch_row($RESSSD1e);


////******************** ABONOS CORRESPONSAL ********************////////

$sel_abon="SELECT SUM(VALOR) FROM ABONO_RECAUDO WHERE ID_TRAMITE='$datos1[15]'  AND FACTURA='$NUMERO_FAC' AND TIPO='CORRESPONSAL'";
$res_abon_hon=mysqli_query($mysql_link, $sel_abon );
$dat_abon_hon=mysqli_fetch_row($res_abon_hon);

if($dat_abon_hon[0]<>""){

 $ssd1a="SELECT A.ID, A.MONEDA, A.ABONO, A.FECHA, A.VALOR, A.ID_GAST  FROM VALOR_RECAUDO A, FACTURACION B 
WHERE A.ID_TRAMITE='$datos1[15]' AND A.ABONO=1 AND A.N_FACT='$datos1[13]' AND A.N_FACT=B.NUMERO_FAC AND B.ESTADO_CARTERA='1' AND B.ID_FACTURACION>$fact5 ";
$RESSSD1a=mysqli_query($mysql_link,$ssd1a);
$dat1a=mysqli_fetch_row($RESSSD1a);
//ECHO $ssd1a."--<BR>";
if($dat1a[1]=="3"){
$str="SELECT TRM FROM TRM WHERE FECHA='$dat1a[3]'";
$rrtr=mysqli_query($mysql_link,$str);
$ddtrm=mysqli_fetch_row($rrtr);

if($ddtrm[0]==""){ ?>

<div style="background-color:#F00; border:1px #999 solid; width:100%; height:auto; color:#fff; font-weight:bold; padding:0; font-size:13px " align="center" >NO HAY TRM DEFINIDO PARA LA FECHA DEL ABONO: <u><? echo $dat1a[3]; ?></u></div>

<?
}
}
else 
$ddtrm[0]=1;

/// SUMA TOTAL Y CONVIERTE A PESOS
$sumx5=$sumx5+($dat_abon_hon[0]*$ddtrm[0]);

	// TOTAL PESOS	
	 if($dat1a[1]=="2" || $dat1a[1]=="0")
	 $sum6=$sum6+$dat_abon_hon[0];
	 //TOTAL DOLARES
	 if($dat1a[1]=="3")
	 $sum26=$sum26+$dat_abon_hon[0];
	
	$sel_abon2="SELECT VALOR, FECHA FROM ABONO_RECAUDO WHERE ID_TRAMITE='$datos1[15]'  AND FACTURA='$NUMERO_FAC' AND TIPO='CORRESPONSAL'";
$res_abon_hon2=mysqli_query($mysql_link, $sel_abon2 );
while($dat_abon_hon2=mysqli_fetch_row($res_abon_hon2)){
echo "<b>ABONO</b><br>".number_format($dat_abon_hon2[0]);
echo "<br><span style='color:#666'>".$dat_abon_hon2[1]."</span><br><br>";	
}
	
	
	echo "<br><b>TOTAL:</b>&nbsp;".number_format($dat_abon_hon[0])."<br>";
	$TAT="";
}

////******************** FIN ABONOS CORRESPONSAL ********************////////


if($dat1e[0]<>"" && $dat1e[2]==0)
echo $TAT=number_format($DDx3[0]);
else
echo $TAT=0;

if($dat1e[1]=="3"){
$str="SELECT TRM FROM TRM WHERE FECHA='$dat1e[3]'";
$rrtr=mysqli_query($mysql_link,$str);
$ddtrm=mysqli_fetch_row($rrtr);
}
else 
$ddtrm[0]=1;

$sumx5=$sumx5+($DDx3[0]*$ddtrm[0]);


	   if(trim(strtoupper($datos1[24]))=="PESOS" )
	   $sum6=$sum6+$DDx3[0];  
	   if(trim(strtoupper($datos1[24]))=="DOLARES" )
	   $sum26=$sum26+$DDx3[0];

   ?></td>
	
	<?  }   ?>
 
  
<td height="38px" ><div align="center"><span class="style3"><? 	  

// AND (C.HONO_GAST_TOTAL_TEXTO = 'HONORARIOS' OR C.HONO_GAST_TOTAL_TEXTO = 'FEES')	  	  
	   $queryh="
SELECT C.HONO_GAST_TOTAL_TEXTO, C.ID_DFM
FROM FACTURACION B, DETALLE_FACTURA C
WHERE B.ID_FACTURACION = C.ID_FACTURACION
AND C.ID_FACTURACION='$datos1[18]'
AND C.CASO='$datos1[15]' AND B.ID_FACTURACION>$fact5
GROUP BY B.NUMERO_FAC
";
$hon=mysqli_query($mysql_link,$queryh);
$DDRh2=mysqli_fetch_row($hon);


 $queryWs="
SELECT sum(C.CANTIDAD*C.VALOR)
FROM 	
GASTOS_HISTORICO C
WHERE C.TIPO='HONORARIOS' AND ID_GAST='$DDRh2[1]' ";
$mysql_result1Ws= mysqli_query($mysql_link,$queryWs);	
$dress=mysqli_fetch_row($mysql_result1Ws);

 $queryWs2="
SELECT sum(C.CANTIDAD*C.VALOR)
FROM 	
DATOS_FACTURA_MULTIPLE C
WHERE C.TIPO='HONORARIOS' AND ID='$DDRh2[1]' ";
$mysql_result1Ws2= mysqli_query($mysql_link,$queryWs2);	
$dress2=mysqli_fetch_row($mysql_result1Ws2);
	 
	 
/*$ssd1="SELECT VALOR, FECHA, MONEDA  FROM VALOR_RECAUDO WHERE ID_TRAMITE='$datos1[15]' AND ID_GAST LIKE '%$DDRh2[1]%' ";
$RESSSD1=mysqli_query($mysql_link,$ssd1);
$dat1=mysqli_fetch_row($RESSSD1);	 	 
	 
	  echo $DDRh2[0];*/

	  $ssd21="select ID_GAST from VALOR_RECAUDO
	  WHERE ID_TRAMITE='$datos1[15]' AND N_FACT='$datos1[13]' limit 0,1";
	  $RESSSD2=mysqli_query($mysql_link,$ssd21)or die("error no grabo"); 
	  $ID_TR1="";
	  $ASSIG="";
	  //echo  "Sql1:".$ssd21;
	  while($dat_idgx1=mysqli_fetch_row($RESSSD2))
	  {
	  $ID_TR1=$dat_idgx1[0];
	  if(substr($ID_TR1,(strlen($ID_TR1)-1),1)==",")
		  $ID_TR1=substr($ID_TR1,0,strlen($ID_TR1)-1);
	  }

 $ssd1="SELECT VALOR, FECHA, MONEDA, ID_TRAMITE_DET, OBSERV, OBSERV_AYUDANTE, ID, ABONO  FROM VALOR_RECAUDO WHERE ID_TRAMITE='$datos1[15]' AND ID_GAST IN ($ID_TR1) AND N_FACT='$datos1[13]' ";
/*
 $ssd1="SELECT VALOR, FECHA, MONEDA, ID_TRAMITE_DET, OBSERV, OBSERV_AYUDANTE, ID, ABONO  FROM VALOR_RECAUDO WHERE ID_TRAMITE='$datos1[15]' AND ID_GAST LIKE '%$DDRh2[1]%' AND N_FACT='$datos1[13]' ";
 */
 $RESSSD1=mysqli_query($mysql_link,$ssd1);
$dat1=mysqli_fetch_row($RESSSD1);
//ECHO $ssd1."--<BR>";
if($dat1[0]==""){
$ssd1="SELECT VALOR, FECHA, MONEDA, ID_TRAMITE_DET, OBSERV, OBSERV_AYUDANTE, ID, ABONO  FROM VALOR_RECAUDO WHERE ID_TRAMITE='$datos1[15]' AND ABONO='1' AND N_FACT='$datos1[13]' ";
$RESSSD1=mysqli_query($mysql_link,$ssd1);


$dat1=mysqli_fetch_row($RESSSD1);
}

if($datos1[23]==1){
// AQUI
//$UUPA="UPDATE VALOR_RECAUDO SET N_FACT='$datos1[13]' WHERE ID='$dat1[6]' ";
//$RED1=mysqli_query($mysql_link,$UUPA);
}

/*if($datos1[25]==0)
echo "NO DEFINIDO";

$query2        = "SELECT HONORARIOS FROM HONORARIOS WHERE ID_HONORARIOS='$datos1[25]' ";
$mysql_result2 = mysqli_query($mysql_link,$query2);
$datos2 = mysqli_fetch_row($mysql_result2);
	 echo $datos2[0];*/
	 if(trim($datos1[25])=="CONTADO")
	 echo "30 DIAS";
	 else
	 echo $datos1[25];
	  
	  //echo number_format($datos1[4], 0, '', ','); ?></span></div></td>	 
	 
<!--<td bgcolor="#FFFF99"><div align="center"><span class="style3"><?  //if($dress[0]<>"") echo number_format($dress[0], 0, '', ','); 
//if($dress2[0]<>"") echo number_format($dress2[0], 0, '', ','); if($dress[0]=="0" && $dress2[0]=="0") echo "0";    //echo number_format($datos1[4], 0, '', ','); ?></span></div></td> -->

<td align="center"><? //echo $dat1[7]."---";
if($dat1[2]==0) { echo "<span style='color:red'><b>NO DEFINIDA</b></span><br>"; 
if($dat1[7]==1) echo "<b><U>ABONO</U></b><BR>";
echo "$ ".number_format($dat1[0]); $sumrp=$sumrp+$dat1[0]; 
if($dat1[7]==1)
$sum_abono_pesos=$sum_abono_pesos+$dat1[0];
} 
if($dat1[2]==2) { if($dat1[7]==1) echo "<b><U>ABONO</U></b><BR>";
echo "$ ".number_format($dat1[0]); $sumrp=$sumrp+$dat1[0];  

if($dat1[7]==1)
$sum_abono_pesos=$sum_abono_pesos+$dat1[0];

} 

  	//echo "<br>recaudo:".$sumrp."--<br>";
  ?>


  </td>
	
<td align="center" ><?  
if($dat1[2]==3) { //echo "<b>DOLARES</b>"; 
$s="SELECT TRM FROM TRM WHERE FECHA='$dat1[1]'";
$rr=mysqli_query($mysql_link,$s);
$ddf=mysqli_fetch_row($rr);
$sumrd=$sumrd+$dat1[0];
//echo $ddf[0]."--";
//echo $dat1[0]*$ddf[0];
$sumrf=$sumrf+($dat1[0]*$ddf[0]); 
if($dat1[7]==1)
$sum_abono_dol=$sum_abono_dol+($dat1[0]*$ddf[0]);

if($dat1[7]==1) echo "<b><U>ABONO</U></b><BR>";
echo "$ ".number_format($dat1[0]); 
}

 //$sum2=$sum2+$dat1[0]; //$sum2=$sum2+$dress[0]+$dress2[0]; ?></td>
	
	
	<?  
	/*$ssd1="SELECT VALOR, FECHA, MONEDA, ID_TRAMITE_DET, OBSERV  FROM VALOR_RECAUDO WHERE ID_TRAMITE='$datos1[15]' AND VALOR<>0 AND ID_GAST LIKE '%$DDRh2[1]%' ";
$RESSSD1=mysqli_query($mysql_link,$ssd1);
$dat1=mysqli_fetch_row($RESSSD1); */
			


//$ID_FACTURACION="55777";
//$NUMERO_FAC="3336";
$query2yy=" SELECT B.CANTIDAD, B.UNITARIO FROM FACTURACION A, DETALLE_FACTURA B 
WHERE A.ID_FACTURACION= B.ID_FACTURACION AND A.TIPO_ENTRADA='1'

and A.ID_FACTURACION >'50000'
AND NUMERO_FAC='$NUMERO_FAC'
"; 
//AND A.ID_FACTURACION= '$ID_FACTURACION'
//echo "--".$query2yy."--<br>";
$query2yy        = strtoupper($query2yy);
//echo "<br>".$query2yy."<br>";
//die();
$TOT1=0;
$mysql_result2yy = mysqli_query($mysql_link,$query2yy)or die("Error al consultar resolucion de facturacion: ".$mysql_error($mysql_link));
while ($datos2yy = mysqli_fetch_row($mysql_result2yy)) 
    {
        $TOT1=$TOT1 +$datos2yy[0]*$datos2yy[1];
    }
//echo $TOT1."--";


$query2yy=" SELECT B.CANTIDAD, B.UNITARIO FROM FACTURACION A, DETALLE_FACTURA B 
WHERE A.ID_FACTURACION= B.ID_FACTURACION AND A.TIPO_ENTRADA='2'
AND NUMERO_FAC='$NUMERO_FAC'
and A.ID_FACTURACION >'50000'
"; 
//echo "--".$query2yy."--<br>";
$query2yy        = strtoupper($query2yy);
//echo "<br>".$query2yy."<br>";
//die();
$TOT2=0;

$mysql_result2yy = mysqli_query($mysql_link,$query2yy)or die("Error al consultar resolucion de facturacion: ".$mysql_error($mysql_link));

$rows1x= mysqli_num_rows($mysql_result2yy);
if($rows1x<>0)
{
while ($datos2yy = mysqli_fetch_row($mysql_result2yy)) 
    {
        $TOT2=$TOT2 +$datos2yy[0]*$datos2yy[1];
    }
  //  echo "tot1|".$TOT1."|";
   // echo "tot2|".$TOT2."|";
$TOT2= $TOT2*-1;
$TA="";
if($TOT1==$TOT2)
    {
        $TA="N.CRED.TOT.";
    }
else    
    {
        $TA="N.CRED.PARC.";
    }

}
?>
			 
			 


	
	<td align="center"  <? if(($dat1[1]=="" || $dat1[1]=="0000-00-00") && $datos1[23]<>1 && $datos1[23]<>3) { echo "bgcolor='#FA431C'"; } else {   } ;  ?>    ><?	
	echo $dat1[1]; ?></td>	
		 
	<td align="center" <? if($datos1[23]==3) {  ?>style="background-image:url(imagenes_nuevo_mod/x.png); background-position:center; background-repeat:no-repeat; background-size:contain;opacity:0.7;" <? } ?> 
	<? if($datos1[23]==1) {  ?> style="background-image:url(imagenes_nuevo_mod/bien.png); background-position:center; background-repeat:no-repeat; background-size:contain;opacity:0.7; " <? } ?>
	<? if($datos1[23]==4) {  ?> style="background-image:url(imagenes_nuevo_mod/reloj.png); background-position:center; background-repeat:no-repeat; background-size:contain;opacity:0.7; " <? } ?> 
	
	>
    <? if($addm==1) { ?>
	<a onClick="javascript:window.open('accion_cartera.php?FACT=<? echo $datos1[13]; ?>&ID_TRAMITE=<? echo $datos1[15]; ?>&ID_EMPRESA=<? echo $datos1PP[0]; ?>&ID_FACT=<? echo $datos1[18]; ?>&ID_DET_TRAMITE=<? echo $dat1[3]; ?>&FECHA_INI=<? echo $fecha_inicial; ?>&FECHA_FIN=<? echo $fecha_final; ?>', '_blank','top=55, left=380, height=550, width=580, status=no, menubar=no, resizable=no, scrollbars=yes, toolbar=no, location=no, directories=no');" style="cursor:pointer; color:#000066; font-size:13px;">
	<u><strong><?  if($datos1[23]==1) /* <img src="imagenes_nuevo_mod/yes.png" > */ echo '<b>RECAUDADO</b>'; if($datos1[23]==2) echo "GESTION CARTERA";  if($datos1[23]==0) echo "NO DEFINIDO";  if($datos1[23]==3) echo "ANULADO"; if($datos1[23]==4) echo "CASTIGADA"; ?></u></strong></a>
	<? } else { 
	
	 if($datos1[23]==1) echo '<b>RECAUDADO</b>'; 
	 if($datos1[23]==2) echo "GESTION CARTERA";  
	 if($datos1[23]==0) echo "NO DEFINIDO";  
	 if($datos1[23]==3) echo "ANULADO";
	 if($datos1[23]==4) echo "CASTIGADA";
	
	} ?>
	<!--<div style="position:relative; margin-top:13px; width:96%; height:auto; background-color: rgba(57,53,50,.1);" align="center"> 
	<? //echo "<BR><hr>".$dat1[4]; ?></div>-->
	<? //} ?>
	</td>    
    
	<!--<td></td>-->

	<td>
	<div style="width:auto; height:105px; overflow-y:scroll">
	<? 
	$trae_observ="SELECT OBSERV FROM VALOR_RECAUDO WHERE ID_TRAMITE='$datos1[15]' AND N_FACT='$datos1[13]' ";
$resul_observ=mysqli_query($mysql_link,$trae_observ);
$dat_observ=mysqli_fetch_row($resul_observ);
	
	echo $dat_observ[0]; ?>
    </div>
    </td>
	
  </tr>
  
  <!--<tr bgcolor="#e5e5e5">-->
 
  	  <? 
	  
	 /*$cas="SELECT  HONO_GAST_TOTAL_TEXTO, GASTOS_MENORES_SEL, GASTOS_TERCEROS_SEL, ID_DFM 
	 FROM DETALLE_FACTURA 
	 WHERE CASO='$datos1[15]'  AND (HONO_GAST_TOTAL_TEXTO = 'GASTOS MENORES' OR HONO_GAST_TOTAL_TEXTO = 'GASTOS TERCEROS' OR HONO_GAST_TOTAL_TEXTO='GASTOS REEMBOL. TERCEROS' OR HONO_GAST_TOTAL_TEXTO = 'TASAS FISCALES' OR HONO_GAST_TOTAL_TEXTO = 'MISCELANEOUS' OR HONO_GAST_TOTAL_TEXTO = 'REIMBURSABLE EXPENSES' OR HONO_GAST_TOTAL_TEXTO = 'OFFICIAL FEES')
	AND ID_FACTURACION='$datos1[18]' ORDER BY HONO_GAST_TOTAL_TEXTO
";
	  $rescas=mysqli_query($mysql_link,$cas);*/
	  
	   ?>	  
	  
	   <? 
	  
	/* $cas="SELECT  HONO_GAST_TOTAL_TEXTO, GASTOS_MENORES_SEL, GASTOS_TERCEROS_SEL, ID_DFM 
	 FROM DETALLE_FACTURA 
	 WHERE CASO='$datos1[15]'  AND (HONO_GAST_TOTAL_TEXTO = 'GASTOS MENORES' OR HONO_GAST_TOTAL_TEXTO = 'GASTOS TERCEROS' OR HONO_GAST_TOTAL_TEXTO='GASTOS REEMBOL. TERCEROS' OR HONO_GAST_TOTAL_TEXTO = 'TASAS FISCALES' OR HONO_GAST_TOTAL_TEXTO = 'MISCELANEOUS' OR HONO_GAST_TOTAL_TEXTO = 'REIMBURSABLE EXPENSES' OR HONO_GAST_TOTAL_TEXTO = 'OFFICIAL FEES')
	AND ID_FACTURACION='$datos1[18]' ORDER BY HONO_GAST_TOTAL_TEXTO
";
	  $rescas=mysqli_query($mysql_link,$cas);  	 
	  */
	   ?>
	  <!--<td valign="middle"><div align="center" style="margin-top:3px"><span class="style3">--><? 
	 /* while($datcas=mysqli_fetch_row($rescas)){
	  
	  if($datcas[1]==" SELECCIONE" || $datcas[1]=="" || $datcas[1]=="0")
	  	$da1=""; 
		else
	  		$da1=$datcas[1];
		
		if($datcas[2]==" SELECCIONE" || $datcas[2]=="" || $datcas[2]=="0")
	  	$da2="";
		else
	  		$da2=$datcas[2];
			  
	  echo "<B>";*/ ?>	  
	 <!-- <a onClick="javascript:window.open('gastos.php?id_gast=<? //echo $datcas[3]; ?>&ID_TRAMITE=<? //echo $ID_TRAMITE; ?>&detalle=1&ID_EMPRESA=<? //echo $ID_EMPRESA; ?>&moda=1', '_blank','top=120, left=70, height=480, width=920, status=no, menubar=no, resizable=no, scrollbars=yes, toolbar=no, location=no, directories=no');" style="cursor:pointer"><? //echo $datcas[0]; ?></a>-->
	  <?  //echo ": </B>".$da1."".$da2;  ?>
	    
	  <!-- <BR>
	 <a onClick="javascript:window.open('soportes_gastos.php?idg=<? //echo $datcas[3]; //echo $datos1[11]; ?>&ID_TRAMITE=<? //echo $datos1[15]; ?>', '_blank','top=130, left=320, height=400, width=450, status=no, menubar=no, resizable=no, scrollbars=no, toolbar=no, location=no, directories=no');" style="cursor:pointer; color:#0033FF; font-size:10px"><u>VER RECIBOS</u></a>-->	  
	  <!--<BR><BR> 	  
	  <?
	  //}
	  ?>&nbsp;</span></div></td>-->   
  <!-- <td  align="center"><div align="center"><span class="style3"><? 
	    //$ID_TRAMITE=$datos1[2];
	/* $cas1="SELECT ID_DFM FROM DETALLE_FACTURA C, FACTURACION B
	  WHERE C.CASO='$datos1[15]' AND (C.HONO_GAST_TOTAL_TEXTO = 'GASTOS MENORES' OR C.HONO_GAST_TOTAL_TEXTO = 'GASTOS TERCEROS' OR C.HONO_GAST_TOTAL_TEXTO='GASTOS REEMBOL. TERCEROS' OR C.HONO_GAST_TOTAL_TEXTO = 'TASAS FISCALES' OR HONO_GAST_TOTAL_TEXTO = 'MISCELANEOUS' OR HONO_GAST_TOTAL_TEXTO = 'REIMBURSABLE EXPENSES' OR HONO_GAST_TOTAL_TEXTO = 'OFFICIAL FEES') 
	  AND C.ID_FACTURACION='$datos1[18]' AND C.ID_FACTURACION=B.ID_FACTURACION
	  
	  ORDER BY C.HONO_GAST_TOTAL_TEXTO ";
	  $rescas1=mysqli_query($mysql_link,$cas1);
	  while($dd2=mysqli_fetch_row($rescas1)){	  
	  $queryWs="
SELECT sum(C.CANTIDAD*C.VALOR)
FROM 	
GASTOS_HISTORICO C
WHERE C.TIPO<>'HONORARIOS' AND ID_GAST='$dd2[0]' ";
$mysql_result1Ws= mysqli_query($mysql_link,$queryWs);	
$dress=mysqli_fetch_row($mysql_result1Ws);

 $queryWs2x="
SELECT sum(C.CANTIDAD*C.VALOR)
FROM 	
DATOS_FACTURA_MULTIPLE C
WHERE C.TIPO<>'HONORARIOS' AND ID='$dd2[0]' ";
$mysql_result1Ws2x= mysqli_query($mysql_link,$queryWs2x);	
$dress2x=mysqli_fetch_row($mysql_result1Ws2x);
	 
	 
$ssd1="SELECT VALOR, FECHA, MONEDA  FROM VALOR_RECAUDO WHERE ID_TRAMITE='$datos1[15]' AND ID_GAST LIKE '%$DDRh2[1]%' ";
$RESSSD1=mysqli_query($mysql_link,$ssd1);
$dat1=mysqli_fetch_row($RESSSD1);
	  if($dress[0]<>"")
	  echo number_format($dress[0])."<BR><BR><BR><BR>";
	  //echo number_format($datos1[4], 0, '', ',');
	  if($dress2x[0]<>"")
	   echo number_format($dress2x[0])."<BR><BR><BR><BR>";
	  
	  if($dress[0]=="" && $dress2x[0]=="")
	  	echo "0"."<BR><BR><BR><BR>";
	   
	  }*/
	  
	  
	  ?></span></div></td>
   
   
  </tr>-->
  
  <?
  
  $VAAL=0;
  
  /*if($ANUL==1)
		   echo " /* ";*/
  }
  /*if($ANUL==1)
		   echo " / "; */
  }
  
  }
  ?>
  
  <? if($VER_REC<>1) $col=5;  else $col=4;  ?>
  <tr bgcolor="#666" style="color:#fff; font-size:13px">
  <td colspan="<? echo $col; ?>" align="right" ><i>TOTAL PESOS:</i>&nbsp;</td>
   <td align="center"><? echo number_format($sum1).""; ?></td>
   
    <td align="center"><? echo number_format($sum3); ?></td>
	 <td align="center"><? echo number_format($sum4); ?></td>
	  <td align="center"><? echo number_format($sum5); ?></td>
	   <td align="center"><? echo number_format($sum6); ?></td>
   
    
	    <td colspan="" align="right"><? if($VER_REC<>1) echo "<b>".number_format($sum)."</b>"; ?></td>
		
		<td colspan="4" align="right" bgcolor="#888"><i>TOTAL PESOS RECAUDO</i></td>
<td colspan="" align="right" bgcolor="#888"><? echo "<b>".number_format($sumrp)."</b>"; ?></td>
<td colspan="3" align="right" bgcolor="#888"></td>
  </tr>
  
  
  
  <tr bgcolor="#666" style="color:#fff; font-size:13px">
  <td colspan="<? echo $col; ?>" align="right"><i>TOTAL DOLARES:</i>&nbsp;</td>
   <td align="center"><? echo number_format($sum21); ?></td>
   
    <td align="center"><? echo number_format($sum23); ?></td>
	 <td align="center"><? echo number_format($sum24); ?></td>
	  <td align="center"><? echo number_format($sum25); ?></td>
	   <td align="center"><? echo number_format($sum26); ?></td>
   
    
	    <td colspan="" align="right"><? if($VER_REC<>1) echo "<b>".number_format($sum27)."</b>"; ?></td>
        
        <td align="right" bgcolor="#888">
       <i>TOTAL ABONOS</i> 
        </td>
        <td align="right" bgcolor="#888">
        <b><? echo number_format($sum_abono_pesos+$sum_abono_dol); ?></b>
        </td>
        
        
		<td colspan="2" align="right" bgcolor="#888"><i>TOTAL DOL RECAUDO</i></td>
<td colspan="" align="right" bgcolor="#888"><? echo "<b>".number_format($sumrd)."</b>"; ?></td>
<td colspan="3" align="right" bgcolor="#888"></td>
  </tr>
  
 
 <tr bgcolor="#666" style="color:#fff; font-size:13px">
  <td colspan="<? echo $col; ?>" align="right"><i><b>TOTAL&nbsp;(con Abonos):</b></i>&nbsp;</td>
   <td align="center"><? echo number_format($sumx); ?></td>
   
    <td align="center"><? echo number_format($sumx2); ?></td>
	 <td align="center"><? echo number_format($sumx3); ?></td>
	  <td align="center"><? echo number_format($sumx4); ?></td>
	   <td align="center"><? echo number_format($sumx5); ?></td>   
    
	    <td colspan="" align="right"><? if($VER_REC<>1) echo "<b>".number_format($sumx6)."</b>"; // $sumx6 ?></td>
		<td colspan="4" align="right" bgcolor="#999999"><b><i>SUMATORIA TOTAL RECAUDO CON ABONOS:</i></b></td>
<td align="right" bgcolor="#999"><? echo "<b>".number_format($sumrf+$sumrp)."</b>"; ?></td>
<td colspan="3" align="right" bgcolor="#888"></td>
  </tr> 
  
  
  <?

/// SERVICIO MIXTO

if($UNIDAD==1){
$uunn=" AND (A.ID_UNIDAD_ESTRATEGICA='2' OR A.ID_UNIDAD_ESTRATEGICA='3' OR A.ID_UNIDAD_ESTRATEGICA='4' OR A.ID_UNIDAD_ESTRATEGICA='5' OR A.ID_UNIDAD_ESTRATEGICA='7' OR A.ID_UNIDAD_ESTRATEGICA='123')";
$uunn2=" AND (C.ID_UNIDAD_ESTRATEGICA='2' OR C.ID_UNIDAD_ESTRATEGICA='3' OR C.ID_UNIDAD_ESTRATEGICA='4' OR C.ID_UNIDAD_ESTRATEGICA='5' OR C.ID_UNIDAD_ESTRATEGICA='7' OR C.ID_UNIDAD_ESTRATEGICA='123')";

} else {
$uunn="AND A.ID_UNIDAD_ESTRATEGICA='$UNIDAD'";
$uunn2="AND C.ID_UNIDAD_ESTRATEGICA='$UNIDAD'";
}


  
$aali=""; $aaliX="";
$aali2=""; $aali2X="";
$adici3="";

if(($fecha_inicial<>"0000-00-00" && $fecha_final<>"0000-00-00")){
 $aali=" AND A.FECHA >= '$fecha_inicial' AND A.FECHA <= '$fecha_final'";

}

if(($fecha_inicial2<>"0000-00-00" && $fecha_final2<>"0000-00-00")  ) {
 $aali2=" AND V.FECHA >= '$fecha_inicial2' AND V.FECHA <= '$fecha_final2' ";

}

if($FACT<>"") 
	{	
	$adici.=" and A.NUMERO_FAC = '".$FACT."'";
	$adici2.=" and A.NUM_FACTURA = '".$FACT."'";
	$adici3.=" and V.N_FACT = '".$FACT."'";
	}

if($ASIG<>"") 
	{	
	$adici.=" and D.ID_TRAMITE = '".$ASIG."'";
	$adici2.=" and A.ID_TRAMITE = '".$ASIG."'";
	$adici3.=" and T.ID_TRAMITE = '".$ASIG."'";
	}
	
	
/// SERVICIOS MIXTOS NUEVO PROCEDIMIENTO
if( $aali<>"" ) {
	/// SM FACTURADOS	
 $query_consulta="SELECT B.SUBTOTAL,  B.SERV_MIXTO_MONEDA, A.FECHA	
 FROM DATOS_FACTURA_MULTIPLE B, FACTURACION A, CASO_MAESTRO C, TRAMITE D 
 WHERE B.TRASLADADA=1 AND B.ASIG_TRASL<>'' AND A.NUMERO_FAC= B.NUM_FACT_SERV_MIXTOS AND B.ID_TRAMITE=A.CASO AND A.ID_FACTURACION>$fact5 AND C.CASON=D.CASON AND D.ID_TRAMITE=A.CASO AND B.ID_TRAMITE=D.ID_TRAMITE AND A.ESTADO_CARTERA<>3 
  $aali  $uunn2 $adici 
AND B.TIPO='SERVICIO MIXTO' AND B.NUM_FACT_SERV_MIXTOS<>''   ";
}

	/// SM RECAUDADOS
if( $aali2<>"" ) {
$query_consulta="SELECT B.SUBTOTAL, B.SERV_MIXTO_MONEDA, A.FECHA 	
 FROM DATOS_FACTURA_MULTIPLE B, FACTURACION A , VALOR_RECAUDO V, CASO_MAESTRO C, TRAMITE T
 
 WHERE B.TRASLADADA=1 AND B.ASIG_TRASL<>'' AND A.NUMERO_FAC=B.NUM_FACT_SERV_MIXTOS AND V.N_FACT= B.NUM_FACT_SERV_MIXTOS 
 AND V.ID_TRAMITE=A.CASO AND A.ESTADO_CARTERA=1 AND T.CASON=C.CASON AND B.ID_TRAMITE=T.ID_TRAMITE
 AND B.ID_TRAMITE=A.CASO AND A.ID_FACTURACION>$fact5 $aali2 $uunn2 $adici3
AND B.TIPO='SERVICIO MIXTO' AND B.NUM_FACT_SERV_MIXTOS<>''   ";

}

$mysql_result_consulta=mysqli_query($mysql_link,$query_consulta);
$dsm1=0;

while($datos_serv_m=mysqli_fetch_row($mysql_result_consulta)){

$trm=1;
if(trim(strtoupper($datos_serv_m[1]))=="2")
$trm=1;
if(trim(strtoupper($datos_serv_m[1]))=="3"){
	$str="SELECT TRM FROM TRM WHERE FECHA='".substr($datos_serv_m[2],0,10)."'";
$rrtr=mysqli_query($mysql_link,$str);
$ddtrm=mysqli_fetch_row($rrtr);
$trm=$ddtrm[0];
}

$dsm1=$dsm1+($datos_serv_m[0]*$trm);


}




/// SERVICIOS MIXTOS (ANTERIOR) TABLA DESCUENTOS (YA NO SE USA)

    $query2        = "SELECT SUM(A.VALOR)
    FROM DESCUENTOS_NOMINA A
    WHERE 1 $eepm $aali $aali2  $adici2  AND A.FECHA<>'0000-00-00'
	$uunn ORDER BY A.TIPO
    ";
   //echo $query2;
$mysql_result2z = mysqli_query($mysql_link,$query2);
$dsm2=mysqli_fetch_row($mysql_result2z);

////////////////////////

$toot_SM=0;

//echo $dsm1."_____".$dsm2[0];

$toot_SM=$dsm1;

/*if($dsm2[0]<0)
$toot_SM=$dsm1+($dsm2[0]*-1);
  
if($dsm2[0]>0)
$toot_SM=$dsm1+($dsm2[0]);*/
  


  ?>
  
  
  
 <tr bgcolor="#666" style="color:#fff; font-size:13px">
  <td colspan="<? echo $col; ?>" align="right">(<a style="color:#9F6" href="fusion_19y20.php" target="_blank">VER DETALLE EN REP.22</a>)&nbsp;&nbsp;&nbsp;<i><b>TOTAL - SERV. MIXTOS:</b></i>&nbsp;</td>
   <td align="center"><? echo number_format($sumx-$toot_SM); ?></td>
   
    <td align="center" bgcolor="#777" colspan="5"><i>TOTAL SERVICIOS MIXTOS:</i>&nbsp;&nbsp;<? echo number_format($toot_SM); ?></td>
	
	   
		<td colspan="4" align="right" bgcolor="#999999"><b><i>SUMATORIA TOTAL RECAUDO CON ABONOS - SERV. MIXTOS:</i></b></td>
<td align="right" bgcolor="#999"><? echo "<b>".number_format(($sumrf+$sumrp)-$toot_SM)."</b>"; ?></td>
<td colspan="3" align="right" bgcolor="#888"></td>
  </tr> 
  
  
  
</table>
<?

$html2= ob_get_contents();
	$html2=str_replace('<a href="fra','<a href="http://192.168.177.197/pinzon/fenix/fra',$html2);


	$html2=str_replace('<img src="imagenes/btn_edit_norm.gif">','',$html2);
$mailmsg = utf8_decode($html2);

    //$mailmsg=$html2;
	ob_end_flush();
	
$fp2 = fopen("Cartera_".$fechh.".xls", 'w');
fwrite($fp2, $mailmsg);
fclose($fp2);


?>


  <?
  }
  ?>
  <br>

</body>
</html>
