<?
require_once '../base.php';
//echo DP_BASE_DIR."<br>";
include('../includes/config.php');
//echo $dPconfig['dbname'];
include ("jpgraph/jpgraph.php");
//include ("jpgraph/jpgraph_line.php");
include ("jpgraph/jpgraph_bar.php");
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
}


if($SELECT1<>"")
{
  $add.=" and companies.company_id ='$SELECT1'";
}

//project_departments
//and  projects.project_id = project_departments.project_id
//and   project_departments.department_id = departments.dept_id
?>
<html>
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
<title>2. Reporte Avance Objetivos Plan de Accion</title>
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
    <td><div align="center"><font size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2">2. 
        Reporte Avance Objetivos Plan de Accion</font></strong></font> <font size="2"> 
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
      <td width="25%" ><font size="1" face="Geneva, Arial, Helvetica, sans-serif"><strong>&nbsp;FECHA 
        </strong></font></td>
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
<table width="30%" border="1" cellspacing="0" cellpadding="0" align="center">
  <tr bgcolor="#336666"> 
    <td width="73%" align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF">Procesos</font></td>
    <td width="27%" align="center"><font size="2" face="Geneva, Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>	
      Avance</strong></font></td>
    <?php if($_SESSION[addm]=='1')
	  {
	  ?>
    <?php 
  }
  ?>
  </tr>
  <?
$queryA="SELECT  departments.dept_name,departments.dept_id
FROM tasks,projects ,  companies ,departments,project_departments 
where 1 
and tasks.task_project = projects.project_id
and  projects.project_company = companies.company_id

and project_departments.project_id=projects.project_id
and project_departments.department_id=departments.dept_id


 $add 
GROUP BY  departments.dept_id

order by  departments.dept_name";
//echo $queryA;
//companies.company_name,
//and  projects.project_departments = departments.dept_id
$mysql_resultA=mysql_query($queryA,$mysql_link);
$rowsA=mysql_num_rows($mysql_resultA);

  $prome1=0;
  $sum1=0;
  $conta1=0;

while($datosA=mysql_fetch_row($mysql_resultA))
{

?>
  <tr onMouseOver="this.style.background='#D5D5D5'; this.style.color='black'" onMouseOut="this.style.background='#eeeeee'; this.style.color='black'" bgcolor="#eeeeee"> 
    <td align="center"><div align="left"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
        <? 

$datosA[0]=str_replace("ón","�n",$datosA[0]);
$datosA[0]=str_replace("ía ","�a",$datosA[0]);
$datosA[0]=str_replace("ías","�as",$datosA[0]);
$datosA[0]=str_replace("ía","�a",$datosA[0]);
	  $arrgx[]=substr($datosA[0],0,50);				
		
		 echo $datosA[0]; 
		
		?>
        </font></div></td>

  
  <?

$query="SELECT  departments.dept_name, Avg(tasks.task_percent_complete) AS PromedioDetask_percent_complete, Count(tasks.task_id) AS CuentaDetask_id,tasks.task_id
FROM tasks,projects ,  companies ,departments,project_departments 
where 1 
and tasks.task_project = projects.project_id
and  projects.project_company = companies.company_id
and  departments.dept_id='$datosA[1]'
and project_departments.project_id=projects.project_id
and project_departments.department_id=departments.dept_id


 $add 
GROUP BY  projects.project_id,departments.dept_name
order by  departments.dept_name";
//echo $query;
//companies.company_name,
//and  projects.project_departments = departments.dept_id
$mysql_result=mysql_query($query,$mysql_link);
$rows=mysql_num_rows($mysql_result);

  $prome=0;
  $sum=0;
  $conta=0;
while($datos=mysql_fetch_row($mysql_result))
{

?>

  <?

  $sum=$sum+$datos[1];
	  $conta=$conta+1;

  }
  $prome= $sum/$conta;
    $arrg[]=$prome;
?>
<td><div align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif">    <?  echo substr($prome,0,5); ?></font></div></td></tr>
<?


  $prome1=0;
  $sum1=0;
  $conta1=0;
$sum1=$sum1+$prome;
$conta1=$conta1+1;


  
  }
    $prome1= $sum1/$conta1;
  $arrg[]=$prome1;
  $arrgx[]="Total";
  ?>
  <tr onMouseOver="this.style.background='#D5D5D5'; this.style.color='black'" onMouseOut="this.style.background='#eeeeee'; this.style.color='black'" bgcolor="#eeeeee"> 
    <td align="center"><div align="left"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
        Total </font></div></td>
    <td><div align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"> 
        <?  echo substr($prome,0,5); ?>
        </font></div></td>
  </tr>
</table>

<?
// grafica
$rand=rand(5, 15)."-".date("Y-m-d");
//$ydata = array(11,3,8,12,5,1,9,13,5,7);
//$ydata=$arrg;


//echo "arr: ".$arrg[0]."<br>";
//echo "arr: ".$arrg[1]."<br>";
//echo "arr: ".$arrg[2]."<br>";
//echo "arr: ".$arrg[3]."<br>";
//echo "arr: ".$arrg[4]."<br>";
// Create the graph. These two calls are always required
$graph = new Graph(1200,700,"auto");    

$graph->SetScale("textlin");

// Adjust the margin
$graph->img->SetMargin(60,40,70,340);
$graph->SetMarginColor('white'); 
$graph->SetShadow();

$logo_empresa="ean.jpg";
$graph->SetBackgroundImage($logo_empresa,BGIMG_COPY);


//$datay=array(12,8,19,3,10,5);

// Create the graph. These two calls are always required
//$graph = new Graph(300,200,"auto");    
$graph->SetScale("textlin");
$graph->yaxis->scale->SetGrace(20);

// Add a drop shadow
$graph->SetShadow();

// Adjust the margin a bit to make more room for titles
//$graph->img->SetMargin(40,30,20,40);

// Create a bar pot
$bplot = new BarPlot($arrg);

// Adjust fill color
$bplot->SetFillColor('orange');
$bplot->value->Show();

//$bplot->value->SetFont(FF_FONT1,FS_BOLD,10);
//$bplot->value->SetAngle(45);
//$bplot->value->SetFormat('%0.1f');
$graph->Add($bplot);

// Setup the titles
$graph->title->Set("AVANCE OBJETIVOS PLAN DE ACCI?N PROCESOS    $fecha1   $fecha2");
//$graph->xaxis->title->Set("Dimensiones");
$graph->yaxis->title->Set("Promedio");
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD,14);

$graph->xaxis->SetTickLabels($arrgx);
$graph->xaxis->SetLabelAngle(90);

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->SetMargin(60,20,10,50);
$graph->yscale-> ticks->Set(20 ,10);
//$graph->SetScale('intlin',65,100,0,0);

//$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
// Create the linear plot
//$lineplot=new LinePlot($arrg);
//$lineplot->mark->SetType(MARK_UTRIANGLE);
//$lineplot->value->show();

// Add the plot to the graph
//$graph->Add($lineplot);

//$datax=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov");
//echo "arr: ".$arrgx[0]."<br>";
//echo "arr: ".$arrgx[1]."<br>";
//echo "arr: ".$arrgx[2]."<br>";
//echo "arr: ".$arrgx[3]."<br>";
//echo "arr: ".$arrgx[4]."<br>";

// $graph->SetScale('intlin',65,100,0,0);

//$graph->xaxis->SetTickLabels($arrgx);
//$graph->yaxis->SetScale("linlin",65,100);
//$graph->title->Set($ANO." - ".$CICLO. "\n".$VAR1. ": ".$SELECT1." \n " ."");
//$graph->xaxis->title->Set("Preguntas");
//$graph->yaxis->title->Set("Promedio");

//$graph->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);


//$graph->SetBackgroundImage($logo_empresa,BGIMG_COPY);

//$graph ->AdjBackgroundImage ("watercolor");
//$graph->img->SetAntiAliasing("watercolor");
//$graph->img->SetAntiAliasing("white");
//$graph->SetColor('white');
//$graph->SetBackgroundImage("blanco.jpg",1);
//$graph->legend->SetBackground(white);
//$graph->legend->SetLineWeight(0);
//$graph->img->SetFillColor('white');
//$lineplot->SetColor("green");
//$lineplot->SetWeight(2);

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
<img src="<? echo $imgg2; ?>"></center> 



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

