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
<title>3. Avance de Metas Plan de Accion</title>
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
    <td><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>3. Avance de Metas Plan de Acci&oacute;n</strong></font> 
      
      </div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">
<form>
<input type=button value="Cerrar" onClick="cerrarse()">
</form></font></div></td>
  </tr>
</table>
        <?php  
            //$fecha1 = $_POST['fecha1'];
			$fecha1 = $_POST['ano4']."-".$_POST['mes4']."-31";   
            $fechacom = substr($fecha1,0,20)." 23:59:59";
            $anocom = substr($fecha1,0,4)."-01-01 00:00:00";     
            $fechacom1= substr($fecha1,0,4)."-01-31 23:59:59";     
            $ano1 = substr($fecha1,0,4);
            $mes1 = substr($fecha1,0,7);
            require_once("../modules/tasks/consulta_tarea/class/class.php");  
            $obj6=new Consulta();  
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
	  
	  <!-- <input type="text" size="10" id="fecha1" name="fecha1"  value="<?php //echo $fecha1; ?>"  readonly="readonly" /> 
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
if (!empty ($_POST['ano4']) && !empty ($_POST['mes4']) && $ano1 > 2011 && $mes1 < $mesactual ) 
{
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td align="left"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;</font></td>
</tr>
</table>
<br>
<table width="50%" border="1" cellspacing="0" cellpadding="0" align="center">
  <tr bgcolor="#336666"> 
    <td width="25%" align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF">Procesos</font></td>
    <td width="25%" align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF">	
      Objetivo</font></td>
    <td width="25%" align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF">Meta</font></td>
    <td width="25%" align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF">	
      Avance</font></td>  
  
  </tr>
 
    
    <?php 
        
        $his_metas=$obj6->his_metas($fechacom, $anocom); 
        for ($i=0;$i<count($his_metas);$i++)    
        {
          echo  "<tr onMouseOver=this.style.background='#D5D5D5'; this.style.color='black' onMouseOut=this.style.background='#eeeeee'; this.style.color='black' bgcolor=#eeeeee><td align=center>"."<font size=2 face=Geneva, Arial, Helvetica, sans-serif>".
                  
             $his_metas1= $his_metas[$i]["proceso"]."</font>"."</td>
                 <td align=center>"."<font size=2 face=Geneva, Arial, Helvetica, sans-serif>".
             $his_metas2= $his_metas[$i]["objetivo"]."</font>"."</td>
                 <td align=center>"."<font size=2 face=Geneva, Arial, Helvetica, sans-serif>".
             $his_metas3 = $his_metas[$i]["meta"]."</font>"."</td>
                 <td align=center>"."<font size=2 face=Geneva, Arial, Helvetica, sans-serif>".
             $his_metas4 = $his_metas[$i]["avance_meta1"]."%</font></td></tr>";  
        }    
        ?>
  <tr onMouseOver="this.style.background='#D5D5D5'; this.style.color='black'" onMouseOut="this.style.background='#eeeeee'; this.style.color='black'" bgcolor="#eeeeee"> 
    <td align="center" colspan = "3" ><div align="center"><strong><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
    PROMEDIO INSTITUCIONAL </font></strong></div></td>
    <td align="center">
  <?php 
       $prom_metas = $obj6->prom_metas($fechacom, $anocom); 
      for ($i=0;$i<count($prom_metas);$i++)
        {
       $prom_metas1 = $prom_metas[$i]["promedio_meta"];  
       //echo substr($prom_metas1 ,0,2)."%";
	   printf( "%.1f%%",$prom_metas1); ?>
	   <?php 
      
        }
        ?>
    </tr>  

</table>
<br/ ><br/ ><br/ >

<table width="40%" border="1" cellspacing="0" cellpadding="0" align="center">
  <tr bgcolor="#336666"> 
    <td width="75%" align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF">Procesos</font></td>
    <td width="25%" align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>	
      N&uacute;mero de metas </strong></font></td>  
  </tr>
  <?php
	$numero_metas = $obj6->hist_proceso($fechacom1, $anocom); 
	$contador = 0;
	$suma = 01;
	  for ($i=0;$i<count($numero_metas);$i++)
        {
        $numero_metas1= $numero_metas[$i]["conteo_metas"];  
	    $numero_metas2= $numero_metas[$i]["proceso"];  
		$contador = $contador + 1;
    	$suma = $suma + $numero_metas[$i]["conteo_metas"];  
?>	
  <tr onMouseOver="this.style.background='#D5D5D5'; this.style.color='black'" onMouseOut="this.style.background='#eeeeee'; this.style.color='black'" bgcolor="#eeeeee"> 
    <td align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
    <?php echo $numero_metas1= $numero_metas[$i]["proceso"]; ?>
      </font></td>
   
    <td><div align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
    <?php echo $numero_metas1= $numero_metas[$i]["conteo_metas"]; ?>
	</font></strong></div></td>
	
	<?php } ?>
		
  </tr>
  <tr onMouseOver="this.style.background='#D5D5D5'; this.style.color='black'" onMouseOut="this.style.background='#eeeeee'; this.style.color='black'" bgcolor="#eeeeee"> 
    <td align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
    Promedio de metas por proceso:
      </font></td>
   
    <td><div align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
    <?php echo substr($suma/$contador, 0,2)."%"; ?>
	</font></strong></div></td>

		
  </tr>
</table>
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

