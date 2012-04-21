<?
include('./enca.inc.php');

$bus=$_GET['bus'];
$fecha1=$_GET['fecha1'];
$fecha2=$_GET['fecha2'];
$usuario1=$_GET['usuario1'];
$placa1=$_GET['placa1'];
$usuario = $_SESSION[user_acceso];
$borr=$_GET['borr'];
$det=$_GET['det'];

if($borr=='1')
{

  $delete="DELETE FROM DATOS_GPS WHERE ID='$det'";
  $mysql_resul_dele=mysql_query($delete,$mysql_link);
}


if($usuario1<>"")
{
  $add.=" and USUARIO LIKE '%$usuario1%'";
}

if($fecha1<>"")
{
  $add.=" and FECHA >='$fecha1'";
}

if($fecha2<>"")
{
  $add.=" and FECHA <='$fecha1'";
}

$query="SELECT ID ,OT , NUM , NOMBRE , X , Y , Z , FECHA , HORA , USUARIO,mts
FROM DATOS_GPS 
WHERE 1 $add order by FECHA,USUARIO,OT,NUM,HORA";
//echo $query;
$mysql_result=mysql_query($query,$mysql_link);
$rows=mysql_num_rows($mysql_result);
?>
<script language="javascript"> 
   function borrar(det)
    { 
	 
	 res = confirm("Está seguro que desea eliminar este Registro ?"); 
	 if (res==true) 
	  location.href = "elimina_resul_ipo.php"  
	}
</script>
<html>
<head>
<link rel="stylesheet" type="text/css" href="./JSCal2/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="./JSCal2/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="./JSCal2/css/steel/steel.css"/>
    <script src="./JSCal2/js/jscal2.js"></script>
    <script src="./JSCal2/js/lang/es.js"></script>

<title>Documento sin t&iacute;tulo</title>
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

<body>
<BR/>
<table width="495" align="center">
 	    <tr>  
    <td><div align="center"><font size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong>CAPTURA 
        GPS DESDE PDA</strong></font> 
        <?
	  if($_SESSION[addm]=='1')
	  {
	  ?>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="2"></font></font></strong></font></strong> 
        <?
	   }
	   ?>
      </div>
  </td>
  	    
  </tr>
  
</table>

<form name="form1" action="" method="get">
  <table width="50%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#336666" > 
      <td height="19" colspan="3"><div align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>&nbsp;BUSQUEDA 
          </strong></font></div></td>
    </tr>
    <tr> 
      <td width="25%" ><font size="1" face="Geneva, Arial, Helvetica, sans-serif"><strong>&nbsp;FECHA:</strong> 
        </font></td>
      <TD> <input type="text" size="12" id="fecha1" name="fecha1" readonly="true" value="<?php echo $fecha1; ?>" />
        <button id="f_btn1">...</button>
        <script type="text/javascript">//<![CDATA[
      Calendar.setup({
        inputField : "fecha1",
        trigger    : "f_btn1",
        onSelect   : function() { this.hide() },
        showTime   : 12,
        dateFormat : "%Y-%m-%d"
      });
    //  %I:%M %p]]></script></TD>
      <td width="50%" valign="top"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"><strong>&nbsp;HASTA 
        :</strong></font> <input type="text" size="12" id="fecha2" name="fecha2" readonly="true" value="<?php echo $fecha2; ?>" />
        <button id="f_btn2">...</button>
        <script type="text/javascript">//<![CDATA[
      Calendar.setup({
        inputField : "fecha2",
        trigger    : "f_btn2",
        onSelect   : function() { this.hide() },
        showTime   : 12,
        dateFormat : "%Y-%m-%d"
      });
    //  %I:%M %p]]></script></td>
    </tr>
	
	    <tr> 
      <td width="25%"><font size="1" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<strong>OT</strong></font></td>
      <td colspan="3"><input name="ot1" type="text" class="estilo" id="ot1" value="<? echo $ot1; ?>" size="24">
        &nbsp;</td>
    </tr>
	    <tr> 
      <td width="25%"><font size="1" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<strong>CD, PF, SECC</strong></font></td>
      <td colspan="3"><input name="pf1" type="text" class="estilo" id="pf1" value="<? echo $pf1; ?>" size="24">
        &nbsp;</td>
    </tr>
    <tr> 
      <td width="25%"><font size="1" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<strong>USUARIO</strong></font></td>
      <td colspan="3"><input name="usuario1" type="text" class="estilo" id="usuario1" value="<? echo $usuario1; ?>" size="24">
        &nbsp;</td>
    </tr>
    <tr align="center"> 
      <td colspan="3" bgcolor="#999999" ><input type="submit" name="Submit" value="BUSCAR" class="estilo"> 
        &nbsp;&nbsp; <input type="button" name="limp" value="LIMPIAR" class="estilo" onClick="Javascript:document.location.replace('ipo.php')"> 
      </td>
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
<?
if($bus=='1')
{
?>
<p align="center">&nbsp;</p>
<?
if($rows<>'0')
{
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td align="left"><font size="2" face="Geneva, Arial, Helvetica, sans-serif"><strong>Total Registros <? echo $rows; ?></strong></font></td>
</tr>
</table>
<br>
<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
  <tr bgcolor="#336666"> 
    <td align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>ID</strong></font></td>
    <td align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>	
      OT</strong></font></td>
    <td align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>	
      CONSEC</strong></font></td>
    <td align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>	
      CD, PF, SECC</strong></font></td>
    <td align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>	
      X</strong></font></td>
    <td align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>	
      Y</strong></font></td>
    <td align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>	
      Z</strong></font></td>
    <td align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>	
      Mts2</strong></font></td>
	  <td align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>	
      FECHA </strong></font></td>
    <td align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>	
      HORA</strong></font></td>
    <td align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>	
      USUARIO</strong></font></td>
    <?php if($_SESSION[addm]=='1')
	  {
	  ?>
    <td align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>Eliminar</strong></font></td>
    <?php 
  }
  ?>
  </tr>
  <?
while($datos=mysql_fetch_row($mysql_result))
{

?>
  <tr onMouseOver="this.style.background='#D5D5D5'; this.style.color='black'" onMouseOut="this.style.background='#eeeeee'; this.style.color='black'" bgcolor="#eeeeee"> 
    <td align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
      <?  echo $datos[0]; ?>
      </font></td>
    <td><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
      <?  echo $datos[1]; ?>
      </font></td>
    <td><font size="1" face="Geneva, Arial, Helvetica, sans-serif">
      <?  echo $datos[2]; ?>
      </font></td>
    <td><font size="1" face="Geneva, Arial, Helvetica, sans-serif">
      <?  echo $datos[3]; ?>
      </font></td>
    <td><font size="1" face="Geneva, Arial, Helvetica, sans-serif">
      <?  echo $datos[4]; ?>
      </font></td>
    <td><font size="1" face="Geneva, Arial, Helvetica, sans-serif">
      <?  echo $datos[5]; ?>
      </font></td>
    <td><font size="1" face="Geneva, Arial, Helvetica, sans-serif">
      <?  echo $datos[6]; ?>
      </font></td>
    <td><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
      <?  echo $datos[10]; ?>
      </font></td>
	<td><font size="1" face="Geneva, Arial, Helvetica, sans-serif">
      <?  echo $datos[7]; ?>
      </font></td>
    <td><font size="1" face="Geneva, Arial, Helvetica, sans-serif">
      <?  echo $datos[8]; ?>
      </font></td>
    <td><font size="1" face="Geneva, Arial, Helvetica, sans-serif">
      <?  echo $datos[9]; ?>
      </font></td>
    <?php if($_SESSION[addm]=='1')
	  {
	  ?>
    <td align="center"> <div align="center"><a href="listado_gps.php?det=<?php echo $datos[0]; ?>&bus=<? echo $bus; ?>&usuario1=<? echo $usuario1; ?>&fecha1=<? echo $fecha1; ?>&fecha2=<? echo $fecha2; ?>&placa1=<? echo $placa1; ?>&borr=1" onClick="return confirmar()"><img src="img/btn_trash_norm.gif" width="22" height="22" border="0"></a></div></td>
    <script language="javascript" type="text/javascript">
 function confirmar(){
 var confirma=confirm(" Esta seguro que desea ELIMINAR el registro ?");
 return confirma;
   }
  </script>
    <?php 
}
 ?>
  </tr>
  <?
  }
  ?>
</table>

<?
}
else
{
?>
<BR>
<p align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">No hay resultados para esta BUSQUEDA</font></p>
<?
}

}
?>

</body>
</html>