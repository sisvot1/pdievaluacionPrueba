<?php
require_once '../base.php';
//echo DP_BASE_DIR."<br>";
include('../includes/config.php');
//echo $dPconfig['dbname'];
include ("jpgraph/jpgraph.php");
//include ("jpgraph/jpgraph_line.php");
include ("jpgraph/jpgraph_bar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />

    <link rel="stylesheet" type="text/css" href="./JSCal2/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="./JSCal2/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="./JSCal2/css/steel/steel.css"/>
    <script src="./JSCal2/js/jscal2.js"></script>
    <script src="./JSCal2/js/lang/es.js"></script>
<script>
function cerrarse(){
window.close()
}
</script> 
<title>1. Reporte por Dimensiones</title>
<STYLE type=text/css>
INPUT,textarea, select {
    BORDER-RIGHT: #666666 1px solid;
    BORDER-TOP: #666666 1px solid;
    BORDER-LEFT: #666666 1px solid;
    BORDER-BOTTOM: #666666 1px solid;	
    FONT-SIZE: 11px;
    BACKGROUND-IMAGE: url(img/input_bg.gif);
    FONT-FAMILY: "Trebuchet MS","Times New Roman", Times, serif;
    BACKGROUND-REPEAT: repeat-x
}
</STYLE>
</head>

<body bgcolor="#CCCCCC">   
<BR/>
<table width="495" align="center">
  <tr> 
    <td><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>1. 
          Reporte por Dimensiones</strong></font> 
      
      </div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">
<form>
<input type=button value="Cerrar" onClick="cerrarse();">
</form></font></div></td>
  </tr>
</table>
        <?php
            
            //$fecha1 = $_POST['fecha1'];
			$fecha1 = $_POST['ano4']."-".$_POST['mes4']."-31";
            $fechacom = substr($fecha1,0,20)." 23:59:59";
			$fechaing = substr($fecha1,0,20);
            $anocom = substr($fecha1,0,4)."-01-01 00:00:00"; 
            $ano1 = substr($fecha1,0,4);
            $mes1 = substr($fecha1,0,7);
            require_once("../modules/tasks/consulta_tarea/class/class.php");  
            $obj6 = new Consulta();  
            //form1
            
        ?>
<script> function validar() { document.form1.submit();}</script>

<form name="form1" action="" method="POST">
  <table width="30%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#336666" > 
      <td height="19" colspan="3"><div align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>&nbsp;BUSQUEDA 
          </strong></font></div></td>
    </tr>
    <tr> 
      <td width="25%" align = "center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"><strong>&nbsp;FECHA 
        </strong></font></td>
      <TD align = "center">
		
			<select name="ano4" >  
				<OPTION value="">A&ntildeo:</OPTION> 
				<option value ="2012">2012</option> </class>
				<option value ="2013">2013</option>
				<option value ="2014">2014</option>
				<option value ="2015">2015</option>
				<option value = "2016">2016</option>
			</select>
			<select name="mes4">
				<OPTION value="">Seleccione Mes: </OPTION>
				<option value ="01">Enero</option>
				<option value ="02">Febrero</option>
				<option value ="03">Marzo</option>
				<option value ="04">Abril</option>
				<option value = "05">Mayo</option>
				<option value = "06">Junio</option>
				<option value = "07">Julio</option>
				<option value = "08">Agosto</option>
				<option value = "09">Septiembre</option> 
				<option value ="10">Octubre</option>
				<option value = "11">Noviembre</option>
				<option value ="12">Diciembre</option>
		   </select>
	
	
	<!-- <TD align = "center"> <input type="text" size="10" id="fecha1" name="fecha1"  value="<?php //echo $fecha1; ?>"  readonly="readonly" /> 
        <button id="f_btn1">...</button>
        <script type="text/javascript">//<![CDATA[
      Calendar.setup({
        inputField : "fecha1",
        trigger    : "f_btn1",
        onSelect   : function() { this.hide() },
        showTime   : 12,
        dateFormat : "%Y-%m-%d"
      });
    //  %I:%M %p]]></script>--></TD>
      
    </tr>
    
    <tr align="center"> 
      <input type="hidden" name="grabar" value="si" />  
      <td colspan="3" bgcolor="#999999" ><input type="button" name="consultar" value="BUSCAR" class="estilo" onclick="validar()">
        &nbsp;&nbsp; </td>
    </tr>
  </table>
<BR>
<table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td align="center">
<input name="bus" type="hidden" value="1">
</td>
</tr>
</table>
</form>
<br>
<?php

if (isset($_POST["grabar"]) and $_POST["grabar"]=="si")
            {
            
   $mesactual = date("Y-m");
if (!empty ($_POST['ano4']) && !empty ($_POST['mes4']) &&  $ano1 > 2011 && $mes1 < $mesactual )  
{
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td align="left"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;</font></td>
</tr>
</table>
<br>
<table width="30%" border="1" cellspacing="0" cellpadding="0" align="center">
  <tr bgcolor="#336666"> 
    <td width="75%" align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF">Dimensi&oacute;n</font></td>
    <td width="25%" align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>	
      Avance</strong></font></td>
  
  </tr>
   <?php 
        $suma = 0;
        $promedio1 = array();  //$fechacom, $anocom)
        $prom_dimension=$obj6->prom_dimension($mes1); 
        for ($i=0;$i<count($prom_dimension);$i++)    
        {
            $prom_dimension1[] = $prom_dimension [$i]["promedio"];
			//$dim1 = substr($prom_dimension1[2],0,3)."%"; 
			$dim1 = $prom_dimension1[2]; 
			$suma = $suma + $dim1;
              
           // echo $prom_dimension1 = $prom_dimension [$i]["dimension"];
            
            /*$prome_d = $prome_mejoram [$i]["progreso_objetivo"];
            if (isset ($prome_d)){
            $prome_prom[0] = $prome_mejoram [$i]["progreso_objetivo"]; 
            $suma = $prome_d;
            $prome_va[0] = $prome_mejoram [$i]["nombre_dimension"]; 
            echo substr($prome_d,0,4)."%";
            }
            else
            {
              echo $fechacom;
              echo "No hay nada";
            }*/
             }
             
          
        ?> 
		  <?php if ($suma > 0 ) { ?>
  <tr onMouseOver="this.style.background='#D5D5D5'; this.style.color='black'" onMouseOut="this.style.background='#eeeeee'; this.style.color='black'" bgcolor="#eeeeee"> 
    <td align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
    Compromiso terceros
      </font></td><td align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"><?php  printf( "%.1f%%",$dim1); $suma; //echo $dim1; ?></font></td>
      </tr>														
   <tr onMouseOver="this.style.background='#D5D5D5'; this.style.color='black'" onMouseOut="this.style.background='#eeeeee'; this.style.color='black'" bgcolor="#eeeeee"> 
    <td align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
    Mejoramiento
      </font></td> <td align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"><?php $dim2 = $prom_dimension1[1]; printf( "%.1f%%",$dim2);  $suma = $suma + $dim2; //echo $dim2 = substr($prom_dimension1[1],0,3)."%";?></font></td>
      </tr>
   <tr onMouseOver="this.style.background='#D5D5D5'; this.style.color='black'" onMouseOut="this.style.background='#eeeeee'; this.style.color='black'" bgcolor="#eeeeee"> 
    <td align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
    Estrat&eacutegico
      </font></td><td align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"><?php  $dim3 = $prom_dimension1[0]; printf( "%.1f%%",$dim3); $suma = $suma + $dim3; //$dim3 = substr($prom_dimension1[0],0,3)."%";?></font></td>
      </tr>																								
  
  <tr onMouseOver="this.style.background='#D5D5D5'; this.style.color='black'" onMouseOut="this.style.background='#eeeeee'; this.style.color='black'" bgcolor="#eeeeee"> 
    <td align="center"><div align="center"><strong><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
    Total </font></strong></div></td>
    <td><div align="center"><strong><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 

    <?php 
         $promedio_dim = $suma /3;    
         //$promedio_dim1 = substr($promedio_dim,0,3);
         printf( "%.1f%%",$promedio_dim);
    ?>
    </font></strong></div></td>
  </tr>
</table>
<?php  


$prom_dimension1[3] = $promedio_dim;
$dimensiones = array ("Estratetegico","Mejoramiento","Compromiso terceros","Total");
$promedios = array ($prom_dimension1[0],$prom_dimension1[1],$prom_dimension1[2],$prom_dimension1[3]);    
//$dimensiones = "Total";
?>    

<?php
// grafica
$rand=rand(5, 15)."-".date("Y-m-d");
//$ydata = array(11,3,8,12,5,1,9,13,5,7);
//$ydata=$arrg;
// Create the graph. These two calls are always required
$graph = new Graph(850,350,"auto");    

$graph->SetScale("textlin");

// Adjust the margin
$graph->img->SetMargin(80,80,40,40);
$graph->SetMarginColor('white'); 
$graph->SetShadow();



//$datay=array(12,8,19,3,10,5);

// Create the graph. These two calls are always required
//$graph = new Graph(300,200,"auto");    
$graph->SetScale("textlin");
$graph->yaxis->scale->SetGrace(20);

// Add a drop shadow
$graph->SetShadow();

// Adjust the margin a bit to make more room for titles
//$graph->img->SetMargin(40,30,20,40);
$prome_es1 = array (9,5,6,7,);
// Create a bar pot
$bplot = new BarPlot($promedios); 

// Adjust fill color
$bplot->SetFillColor('orange');
$bplot->value->Show();

//$bplot->value->SetFont(FF_FONT1,FS_BOLD,10);
//$bplot->value->SetAngle(45);
//$bplot->value->SetFormat('%0.1f');
$graph->Add($bplot);

// Setup the titles
$graph->title->Set("AVANCE OBJETIVOS PLAN DE ACCION  $mes1 "); 
$graph->xaxis->title->Set("Dimensiones de la Gestion");  
$graph->yaxis->title->Set("Promedio");
$graph->xaxis->SetTickLabels($dimensiones);
$logo_empresa="ean.jpg";
$graph->SetBackgroundImage($logo_empresa,BGIMG_COPY);

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->SetMargin(60,40,70,50);
$graph->yscale-> ticks->Set(20 ,10);


$imgg2="img/img2_".$rand.".jpg";
//echo $imgg2."<br>";
echo "<br><br><center>";
if (file_exists($imgg2))
{
   unlink($imgg2);
}

// Display the graph
$graph->Stroke($imgg2);
//echo "img/img_".$rand.".jpg";
?>
<img src="<?php echo $imgg2; ?>"></center> 



<?php
}
else
{
?>
<BR>
<p align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">No hay resultados para esta BUSQUEDA</font></p>
<?php
}
?>
<?php
}
else
{
?>
<BR>
<p align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">No hay resultados para esta BUSQUEDA</font></p>
<?php
}

}
?>

</body>
</html>

