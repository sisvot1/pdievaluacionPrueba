<?
require_once '../base.php';
//echo DP_BASE_DIR."<br>";
include('../includes/config.php');
//echo $dPconfig['dbname'];
//include ("jpgraph/jpgraph.php");
//include ("jpgraph/jpgraph_line.php");
//include ("jpgraph/jpgraph_bar.php");
include('jpgraph/jpgraph.php');
include('jpgraph/jpgraph_line.php');
$bus=$_GET['bus'];
$fecha1=$_GET['fecha1'];
$fecha2=$_GET['fecha2'];
$usuario1=$_GET['usuario1'];
$placa1=$_GET['placa1'];
$usuario = $_SESSION[user_acceso];
$borr=$_GET['borr'];
$det=$_GET['det'];
$SELECT1=$_GET['SELECT1'];

$mysql_link= mysql_connect ($dPconfig['dbhost'],$dPconfig['dbuser'],$dPconfig['dbpass']);
mysql_select_db($dPconfig['dbname'], $mysql_link);
if($usuario1<>"")
{
  $add.=" and USUARIO LIKE '%$usuario1%'";
}

if($fecha1<>"")
{
  $add.=" and tasks.task_end_date >='$fecha1'";
}

if($fecha2<>"")
{
$HORA="23:59:00";

  $add.=" and tasks.task_end_date <='$fecha2 $HORA'";

//  $add.=" and tasks.task_end_date <='$fecha2'";
}


if($SELECT1<>"")
{
  $add.=" and companies.company_id ='$SELECT1'";
}
//companies.company_name
//and  projects.project_id = project_departments.project_id
//and   project_departments.department_id = departments.dept_id
// project_departments , 
$query="SELECT  projects.project_name, tasks.task_name, Avg(tasks.task_percent_complete) AS PromedioDetask_percent_complete, Count(tasks.task_id) AS CuentaDetask_id, departments.dept_name
FROM tasks,projects ,  companies ,departments 
where 1 
and tasks.task_project = projects.project_id
and  projects.project_company = companies.company_id
and  projects.project_departments = departments.dept_id
 $add 
GROUP BY  projects.project_name, tasks.task_name,departments.dept_name
order by  projects.project_name, tasks.task_name,departments.dept_name";
/*
$query="


SELECT  departments.dept_name, Avg(tasks.task_percent_complete) AS PromedioDetask_percent_complete, Count(tasks.task_id) AS CuentaDetask_id
FROM tasks,projects ,  companies ,project_departments , departments 
where 1 
and tasks.task_project = projects.project_id
and  projects.project_company = companies.company_id
and  projects.project_id = project_departments.project_id
and   project_departments.department_id = departments.dept_id

GROUP BY  departments.dept_name
order by  departments.dept_name";
*/
//echo $query;
//companies.company_name,
$mysql_result=mysql_query($query,$mysql_link);
$rows=mysql_num_rows($mysql_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
<title>3. Avance de Metas plan de Acci�n</title>
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body bgcolor="#CCCCCC">
<BR/>
<table width="495" align="center">
  <tr> 
    <td><div align="center"><font size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2">3. 
        Avance de Metas Plan de Acci&oacute;n</font></strong></font> <font size="2"> 
        <?
	  if($_SESSION[addm]=='1')
	  {
	  ?>
        </font> </strong> 
        <?
	   }
	   ?>
    </div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
        <form>
          <input type=button value="Cerrar" onClick="cerrarse()">
        </form>
        </font></div></td>
  </tr>
</table>

<form name="form1" action="" method="get">
  <table width="50%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#336666" > 
      <td height="19" colspan="3"><div align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>&nbsp;BUSQUEDA 
          </strong></font></div></td>
    </tr>
    <tr> 
      <td width="25%" ><font size="1" face="Geneva, Arial, Helvetica, sans-serif"><strong>&nbsp;FECHA</strong></font></td>
      <TD> <input type="text" size="10" id="fecha1" name="fecha1"  value="<?php echo $fecha1; ?>" /> 
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
      <td width="50%" valign="top"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"><strong>HASTA 
        </strong></font> 
        <input type="text" size="10" id="fecha2" name="fecha2" value="<?php echo $fecha2; ?>" /> 
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
      <td width="25%" ><font size="1" face="Geneva, Arial, Helvetica, sans-serif"><strong>&nbsp;VIGENCIA 
        / DIVISION:</strong> </font></td>
      <TD colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
        <select name="SELECT1" id="SELECT1">
          <?


$query2= "SELECT company_id,company_name  FROM companies
ORDER BY company_name ";
//$query2=strtoupper($query2);
//AND A.SEMESTRE='$SEMESTRE' 
//ECHO $query2;		 
	
$mysql_result2= mysql_query($query2,$mysql_link);
//ECHO $SELECT1."--------<BR>";
# fetch the data from the database
?>
          <option value="0"<? if(0==$SELECT1) echo " selected" ?>> Seleccione</option>
          <?
	
while ($datos2= mysql_fetch_row($mysql_result2)){
$datos2[1]=str_replace("ó","�",$datos2[1]);
//$FR=$datos2[2];
								?>
          <option value="<? echo $datos2[0]; ?>"<? if($datos2[0]==$SELECT1) echo " selected" ?>> 
          <? echo strtoupper(substr($datos2[1]."            ",0,36)); ?></option>
          <?  
					}
				
				?>
        </select>
        </font> </TD>
    </tr>
    <tr align="center"> 
      <td colspan="3" bgcolor="#999999" ><input type="submit" name="Submit" value="BUSCAR" class="estilo">
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
<?
if($bus=='1')
{
?>
<?
if($rows<>'0')
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
    <td width="33%" align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF">Proceso</font></td>
    <td width="25%" align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF">Objetivo</font></td>
    <td width="25%" align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF">Meta</font></td>
    <td width="17%" align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF">Avance</font></td>
    <?php if($_SESSION[addm]=='1')
	  {
	  ?>
    <?php 
  }
  ?>
  </tr>
  <?
  $prome=0;
  $sum=0;
  $conta=0;

while($datos=mysql_fetch_row($mysql_result))
{
$datay1[$conta]=$datos[2];
$text1[$conta]=$datos[0]."  ".$datos[1];

?>
  <tr onMouseOver="this.style.background='#D5D5D5'; this.style.color='black'" onMouseOut="this.style.background='#eeeeee'; this.style.color='black'" bgcolor="#eeeeee"> 
    <td bgcolor="#eeeeee"><div align="left"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
        <?  
$datos[4]=str_replace("ón","�n",$datos[4]);
$datos[4]=str_replace("ía ","�a",$datos[4]);
$datos[4]=str_replace("ías","�as",$datos[4]);
$datos[4]=str_replace("ía","�a",$datos[4]);
		
		echo $datos[4]; ?>
        </font></div></td>
    <td align="center"><div align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
        <?  echo $datos[0]; ?>
        </font></div></td>
    <td><div align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
        <?  echo $datos[1]; ?>
        </font></div></td>
    <td><div align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
        <?  echo substr($datos[2],0,5); ?>
        </font></div></td>
  </tr>
  <?
  $arrg[]=$datos[2];
  $sum=$sum+$datos[2];
	  $conta=$conta+1;
	  $arrgx[]=substr($datos[0],0,50);
  }
  $prome= $sum/$conta;
  $arrg[]=$prome;
  $arrgx[]="Total";
  ?>
  <tr onMouseOver="this.style.background='#D5D5D5'; this.style.color='black'" onMouseOut="this.style.background='#eeeeee'; this.style.color='black'" bgcolor="#eeeeee"> 
    <td colspan="3" align="center"><div align="left"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
        PROMEDIO INSTITUCIONAL</font></div>
      <div align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
        </font></div>
      <div align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
        </font></div></td>
    <td><div align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
        <?  echo substr($prome,0,5); ?>
        </font></div></td>
  </tr>
</table>

<?
/*
$rand=rand(5, 15)."-".date("Y-m-d");
$graph = new Graph(1200,700,"auto");    
$graph->SetScale("textlin");
$graph->img->SetMargin(60,40,70,340);
$graph->SetMarginColor('white'); 
$graph->SetShadow();
$logo_empresa="ean.jpg";
$graph->SetBackgroundImage($logo_empresa,BGIMG_COPY);
$graph->SetScale("textlin");
$graph->yaxis->scale->SetGrace(20);
$graph->SetShadow();
$bplot = new BarPlot($arrg);
$bplot->SetFillColor('orange');
$bplot->value->Show();
$graph->Add($bplot);
$graph->title->Set("AVANCE OBJETIVOS PLAN DE ACCION	 PROCESOS    $fecha1   $fecha2");
$graph->yaxis->title->Set("Promedio");
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD,14);
$graph->xaxis->SetTickLabels($arrgx);
$graph->xaxis->SetLabelAngle(90);
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yscale-> ticks->Set(20 ,10);
*/

//$datay1 = array(20,15,23,15);
//$datay2 = array(12,9,42,8);
//$datay3 = array(5,17,32,24);

// Setup the graph
$graph = new Graph(1200,500,"auto");    
$graph->SetScale("textlin");
$graph->img->SetMargin(60,40,70,140);
$graph->SetMarginColor('white'); 

//$theme_class=new UniversalTheme;

//$graph->SetTheme($theme_class);
//aqui
//$graph->img->SetAntiAliasing(false);
//$graph->title->Set("Avance de Metas plan de Acci�n   $fecha1   $fecha2");
//$graph->SetBox(false);

//$logo_empresa="ean.jpg";
//$graph->SetBackgroundImage($logo_empresa,BGIMG_COPY);

//$graph->img->SetAntiAliasing();

//$graph->yaxis->HideZeroLabel();
//$graph->yaxis->HideLine(false);
//$graph->yaxis->HideTicks(false,false);

//$graph->xgrid->Show();
//$graph->xgrid->SetLineStyle("solid");
//$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
//$graph->xaxis->SetFont(FF_FONT1,FS_NORMAL,10);


//$graph->yscale-> ticks->Set(20 ,10);

//$graph->xaxis->SetTickLabels($text1);
//$graph->xaxis->SetLabelAngle(90);

//$graph->xgrid->SetColor('#E3E3E3');

// Create the first line
//$p1 = new LinePlot($datay1);

//$graph->Add($p1);
//$p1->SetColor("#6495ED");
//$p1->SetLegend('Metas');
//$graph->xaxis->title->Set("Objetivos  y  Metas");

// Create the second line
//$p2 = new LinePlot($datay2);
//$graph->Add($p2);
//$p2->SetColor("#B22222");
//$p2->SetLegend('Line 2');

// Create the third line
//$p3 = new LinePlot($datay3);
//$graph->Add($p3);
//$p3->SetColor("#FF1493");
//$p3->SetLegend('Line 3');

//$graph->legend->SetFrameWeight(1);

//$imgg2="img/img2_".$rand.".jpg";
//echo "<br><br><center>";
//if (file_exists($imgg2))
//{
//   unlink($imgg2);
//}

// Display the graph
//$graph->Stroke($imgg2);
//echo "img/img_".$rand.".jpg";
?>
<br>
<?


$query="SELECT  projects.project_name, tasks.task_name, Avg(tasks.task_percent_complete) AS PromedioDetask_percent_complete, Count(tasks.task_id) AS CuentaDetask_id, departments.dept_name, count(departments.dept_name)
FROM tasks,projects ,  companies ,project_departments , departments 
where 1 
and tasks.task_project = projects.project_id
and  projects.project_company = companies.company_id
and  projects.project_id = project_departments.project_id


and   project_departments.department_id = departments.dept_id


 $add 
GROUP BY  departments.dept_name
order by  departments.dept_name";
/*
$query="


SELECT  departments.dept_name, Avg(tasks.task_percent_complete) AS PromedioDetask_percent_complete, Count(tasks.task_id) AS CuentaDetask_id
FROM tasks,projects ,  companies ,project_departments , departments 
where 1 
and tasks.task_project = projects.project_id
and  projects.project_company = companies.company_id
and  projects.project_id = project_departments.project_id
and   project_departments.department_id = departments.dept_id

GROUP BY  departments.dept_name
order by  departments.dept_name";
*/
//echo $query;
//companies.company_name,
$mysql_result=mysql_query($query,$mysql_link);
$rows=mysql_num_rows($mysql_result);
if($rows<>'0')
{
?>
<table width="50%" border="1" cellspacing="0" cellpadding="0" align="center">
  <tr bgcolor="#336666"> 
    <td width="33%" align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF">Proceso</font></td>
    <td width="25%" align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF">N�mero de Metas</font></td>
</tr>
<?
$suum=0;
$ccont=0;
while($datos=mysql_fetch_row($mysql_result))
{
$ccont++;
$suum=$suum+$datos[5];

$datos[4]=str_replace("ón","�n",$datos[4]);
$datos[4]=str_replace("ía ","�a",$datos[4]);
$datos[4]=str_replace("ías","�as",$datos[4]);
$datos[4]=str_replace("ía","�a",$datos[4]);

?>
<tr bgcolor="#eeeeee"> 
    <td width="33%" ><font size="1" face="Geneva, Arial, Helvetica, sans-serif" ><?  echo $datos[4]; ?></font></td>
	    <td width="33%" align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif" ><?  echo $datos[5]; ?></font></td>
		</tr>
<?

}
?>
<tr bgcolor="#eeeeee"> 
    <td width="33%" align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif" >PROMEDIO DE METASPOR PROCESOS</font></td>
	    <td width="33%" align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif" ><?  echo substr(($suum/$ccont),0,5); ?></font></td>
		</tr>

<?
}

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

