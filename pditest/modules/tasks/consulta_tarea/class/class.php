<?php
/**
*Conexion bases de datos
*/
class Conexion
    {
        public static function con()
        {
          $con=  mysql_connect("localhost","root","");
          mysql_query("SET NAMES 'UTF8'");
          mysql_select_db("dotprojecttest");  
          return $con;
        }
    }
class Consulta
{
/**
     *Declaracion variables de la clase consulta
    */
    private $his_metas= array();
    private $vali_guar = array();    
    private $conteo_reg;
    private $conteo_reg1;
	private $conteo_reg3;
  private $consul_meta= array();
    private $prom_metas = array();
    private $hist_proceso = array();
    private $prom_dimension = array();
	private $hist_dim2 = array();
	private $consulta_nuevo_ano = array();
	
//*****************************************************************************************//	
     /**
       *Este metodo permite realizar una consulta a la base de datos
       * en donde se pueden obtener id_meta, nombre, id_project, porcentaje_meta, fecha, estado,projecto, id_compania 
      */       	
           
    public function consulta_metas()
            {   
               $fecha = $_POST["fecha1"]; 
               $fecha1 = substr($fecha,0,7);//fecha seleccionada por el usuario
               $ano1 = substr($fecha,0,4);//ano seleccionado
	
               $sql = "SELECT tasks.task_id, tasks.task_name, tasks.task_project, tasks.task_start_date, tasks.task_percent_complete, task_log.task_log_task, task_log.task_log_name, task_log.task_log_description, task_log.task_log_date, projects.project_id, projects.project_name, departments.dept_id, task_departments.task_id, projects.project_status, departments.dept_name, projects.project_company, companies.company_id, companies.company_name
                    FROM  `tasks` 
                    LEFT JOIN task_log ON tasks.task_id = task_log.task_log_task
                    INNER JOIN projects ON projects.project_id = tasks.task_project
                    INNER JOIN task_departments ON tasks.task_id = task_departments.task_id
                    INNER JOIN departments ON departments.dept_id = task_departments.department_id
                    INNER JOIN companies ON projects.project_company = companies.company_id
                    WHERE tasks.task_start_date LIKE  '%$ano1%'
                    AND task_log.task_log_date LIKE  '%$fecha1%'"; 
                 //echo $sql;
                 $res = mysql_query($sql, Conexion::con());
               
                    $this->conteo_reg = mysql_num_rows($res); //conteo registros consulta anterior

                 while ($result = mysql_fetch_assoc($res))
                     {
                         //echo $result["task_id"]." ".$result["task_name"]."<br />"; 
                        $this->consul_meta[]= $result;
                     }
                         return $this->consul_meta;
                      
                   
            }   
//*****************************************************************************************//
/**
 * Este metodo permite seleccionar los datos de las tareas, si es un nuevo año, por el primer mes 
 */            
public function consulta_nuevo_ano() 
            {   
				$ano5= date ("Y");
				   $fecha = $_POST["fecha1"]; 
				   $fecha1 = substr($fecha,0,7);//fecha seleccionada por el usuario
				   $ano1 = substr($fecha,0,4);//ano seleccionado
	
               $sql = "SELECT tasks.task_id, tasks.task_name, tasks.task_project, tasks.task_start_date, tasks.task_percent_complete, projects.project_id, projects.project_name, departments.dept_id, task_departments.task_id, projects.project_status, departments.dept_name, projects.project_company, companies.company_id, companies.company_name
				FROM  `tasks` 
				INNER JOIN projects ON projects.project_id = tasks.task_project
				INNER JOIN task_departments ON tasks.task_id = task_departments.task_id
				INNER JOIN departments ON departments.dept_id = task_departments.department_id
				INNER JOIN companies ON projects.project_company = companies.company_id
				WHERE tasks.task_start_date LIKE  '%$ano5-01%'"; 
                 //echo $sql;
                 $res = mysql_query($sql, Conexion::con());
               
                    $this->conteo_reg3 = mysql_num_rows($res); //conteo registros consulta anterior

                 while ($result = mysql_fetch_assoc($res))
                     {
                         //echo $result["task_id"]." ".$result["task_name"]."<br />"; 
                        $this->consulta_nuevo_ano[]= $result;
                     }
                         return $this->consulta_nuevo_ano;
                   
            }  


//*****************************************************************************************//
/**
  *Este metodo permite realizar el llamado  al metodo consulta_nuevo_ano, y
  *el resultado lo insertamos a la tabla historicos
 */            
     public function add_meta_mes_nuevo()
                 {
                   $dia = date("j"); 
                   $mes = date("m");
                   $ano = date("Y");     
			             
                    $consulta_nuevo_ano = $this->consulta_nuevo_ano();
              // echo $consult_met;
                    $this->conteo_reg3;//conteo de registros segun la consulta $sql5
               
                 for ($i=0; $i < $this->conteo_reg3; $i++)
                 {
                   for ($i= 0; $i < count($consulta_nuevo_ano);$i++)
                   {
                       $id_meta = $this->consulta_nuevo_ano [$i]["task_id"];
                       $nmeta = $this->consulta_nuevo_ano [$i]["task_name"];    
                       $nproyecto = $this->consulta_nuevo_ano [$i]["project_name"];   
                       $por_tarea = $this->consulta_nuevo_ano [$i]["task_percent_complete"]; 
                       $fecha_modifica = $this->consulta_nuevo_ano [$i]["task_start_date"];  
                       $id_meta = $this->consulta_nuevo_ano [$i]["task_id"];
                       $vigencia = $this->consulta_nuevo_ano[$i]["company_name"];
                       $dimension1 = $this->consulta_nuevo_ano [$i]["project_status"];
                       $proceso1= $this->consulta_nuevo_ano [$i]["dept_name"];
                    
                    // echo  $i." ".$id_meta.$nmeta.$nproyecto.$por_tarea.$vigencia."<br />";
                        
                   $sql ="INSERT INTO  `historicos` (
                            `id_historico` ,
                            `vigencia` , 
                            `dimension` ,
                            `proceso` ,
                            `objetivo` ,
                            `id_meta` ,
                            `meta` ,
                            `avance_meta` ,
                            `progreso_objetivo` ,
                            `ano` ,  
                            `mes` ,
                            `dia` ,
                            `fecha_modifi` 
                            )
                          VALUES (
                          NULL ,  '$vigencia',  '$dimension1',  '$proceso1', '$nproyecto ', '$id_meta','$nmeta', '$por_tarea', '','$ano', '$mes', '$dia','$fecha_modifica'
                          )";
                //echo $sql;
                         $res=mysql_query($sql, Conexion::con());
                  
                         //header ('Location: index.php?m=projects');
                   } 
                 }
                     
             }

//*****************************************************************************************//
/**
 *Este metodo realiza una llamada al metodo consulta_metas, en donde se pueden
 *ingresar los datos a la tabla historico, la diferencia a los anteriores metodos
 *es que puede ser cualquier mes 
 */             
                 public function add_meta_mes()
                 {
                   $dia = date("j"); 
                   $mes = date("m");
                   $ano = date("Y");     
			             
                    $consult_met = $this->consulta_metas();
              // echo $consult_met;
                    $this->conteo_reg;//conteo de registros segun la consulta $sql5
               
                 for ($i=0; $i < $this->conteo_reg; $i++)
                 {
                   for ($i= 0; $i < count($consult_met);$i++)
                   {
                       $id_meta = $this->consul_meta [$i]["task_id"];
                       $nmeta = $this->consul_meta [$i]["task_name"];    
                       $nproyecto = $this->consul_meta [$i]["project_name"];   
                       $por_tarea = $this->consul_meta [$i]["task_percent_complete"]; 
                       $fecha_modifica = $this->consul_meta [$i]["task_log_date"];  
                       $id_meta = $this->consul_meta [$i]["task_id"];
                       $vigencia = $this->consul_meta [$i]["company_name"];
                       $dimension1 = $this->consul_meta [$i]["project_status"];
                       $proceso1= $this->consul_meta [$i]["dept_name"];
                    
                    // echo  $i." ".$id_meta.$nmeta.$nproyecto.$por_tarea.$vigencia."<br />";
                        
                   $sql ="INSERT INTO  `historicos` (
                            `id_historico` ,
                            `vigencia` , 
                            `dimension` ,
                            `proceso` ,
                            `objetivo` ,
                            `id_meta` ,
                            `meta` ,
                            `avance_meta` ,
                            `progreso_objetivo` ,
                            `ano` ,  
                            `mes` ,
                            `dia` ,
                            `fecha_modifi` 
                            )
                          VALUES (
                          NULL ,  '$vigencia',  '$dimension1',  '$proceso1', '$nproyecto ', '$id_meta','$nmeta', '$por_tarea', '','$ano', '$mes', '$dia','$fecha_modifica'
                          )";
                
                         $res=mysql_query($sql, Conexion::con());
                  
                         //header ('Location: index.php?m=projects');
                   } 
                 }
                     
             }
//*****************************************************************************************// 
/**
 *Este metodo permite realizar una consulta a la tabla fecha_modifi, pasando como parametro 
  *una fecha
 */              
                  function vali_guar($fecha6)
                  {
                      $sql ="SELECT ano, mes
                              FROM  `historicos` 
                               WHERE 
                                 fecha_modifi like  '%$fecha6%'"; 

                               $res = mysql_query($sql, Conexion::con());
                               
                            //echo   "ss".$this->conteo_reg = mysql_num_rows($res); //conteo 
                            
                            while ($result = mysql_fetch_assoc($res))
                             {
                                $this->vali_guar[]= $result;
                             }
                                 return $this->vali_guar; 
                                
                  }
//*****************************************************************************************//                   
/**
 *Este metodo permite realizar una consulta a la tabla historicos en donde, puedo seleccionar 
 *los avances de las metas de acuerdo a los paramestros que recibe que son fecha inicial, fecha final 
 */                                    
                  function his_metas($fechacom, $anocom )
                  {
                     $sql = "SELECT MAX( fecha_modifi )AS fecha_actuali , MAX( avance_meta ) AS avance_meta1, objetivo, id_meta, meta, AVG( avance_meta ) , fecha_modifi, proceso, objetivo, meta, avance_meta, dimension
                                FROM  `historicos` 
                                WHERE fecha_modifi >=  '$anocom'
                                AND fecha_modifi <=  '$fechacom'
                                GROUP BY id_meta";  
                     //echo  $sql;
                     $res = mysql_query($sql, Conexion::con());
                     
                    $this->conteo_reg1 = mysql_num_rows($res); //conteo registros consulta anterior
                     
                     $sql_con_pro = "SELECT fecha_actuali
                                            FROM  `historico_proceso` 
                                            WHERE fecha_actuali LIKE  '%2012-02%'";
                        
                        $res3 = mysql_query($sql_con_pro, Conexion::con());
                        
                        
                            while ($result = mysql_fetch_assoc($res))
                            {
                                
                                $this->his_metas[]=$result;

                            }
                                return $this->his_metas;
                        
                  }
//*****************************************************************************************//                                     
/**
 *El metodo permite realizar el promedio de las metas de acuerdo a los parametros 
 *de acuedo a la fcha inicial y fecha final 
 */                                                                       
                  function prom_metas($fechacom, $anocom)
                  {
                        $fecha = $_POST["fecha1"]; 
                        $fecha1 = substr($fecha,0,7);//fecha seleccionada por el usuario
                        $ano1 = substr($fecha,0,4);//ano seleccionado
                                
                      $sql = "SELECT MAX( fecha_modifi ) , objetivo, id_meta, meta, MAX( avance_meta ) AS avance_meta1, fecha_modifi, proceso, objetivo, meta, AVG( avance_meta ) AS promedio_meta
                                FROM  `historicos` 
                                WHERE fecha_modifi >=  '$anocom'
                                AND fecha_modifi <=  '$fechacom'"; 
                 //echo $sql;
                 $res = mysql_query($sql, Conexion::con());
               
                    $this->conteo_reg = mysql_num_rows($res); //conteo registros consulta anterior

                 while ($result = mysql_fetch_assoc($res))
                     {
                         //echo $result["task_id"]." ".$result["task_name"]."<br />"; 
                        $this->prom_metas[]= $result;
                     }
                         return $this->prom_metas;
                   }
//*********************************************************************************************//                  				   
/**
 * Este metodo permite realizar el promedio de las dimensiones
 */                   				   
        public function prom_dimension($mes1)
        {
            $sql = "SELECT dimension, AVG( avance_meta1 ) AS promedio
						FROM  `historico_proceso` 
						WHERE fecha_ingre LIKE  '%$mes1%'
						GROUP BY dimension";
            
            $res = mysql_query($sql, Conexion::con());
            
            while ($result = mysql_fetch_assoc($res))
            {
                $this->prom_dimension[] = $result;
            }
                return $this->prom_dimension;
            
        } 

        //Mejoramiento (15) 1
        
                        
            //Estratégico 0
            
            // 'Compromiso terceros (13)' 2
//*********************************************************************************************//                  
/**
 * Este metodo permite seleccionar por fecha inicial y fecha final el historicos de los procesos
 */
        public function hist_proceso($fechacom1, $anocom)
         {
        $sql= "SELECT proceso, COUNT( meta ) AS conteo_metas, id_historico, vigencia, dimension, objetivo, id_meta meta, AVG( avance_meta ) AS promedio, progreso_objetivo, MAX( fecha_modifi ) 
                FROM historicos
                WHERE fecha_modifi >=  '$anocom'
                AND fecha_modifi <=  '$fechacom1'
                GROUP BY proceso";
        
               $res2=mysql_query($sql, Conexion::con());
        
               while ($result2 = mysql_fetch_assoc($res2))
                {
                   
                //echo $result2["proceso"];
                $this->hist_proceso[]=$result2;
                }
                return $this->hist_proceso;       
         }
//*********************************************************************************************//
      /**
       * Este metodo permite realizar la inserccion de datos a la tabla historico_proceso, para luego
	*tener los reportes del proceso de acuerdo al ano y al mes
      */                   
         public function hist_dim($fechacom, $anocom, $mes3, $mes1,$mesactual, $fechaing)
         {
               $his_metas1 = $this->his_metas($fechacom, $anocom);
              // echo $consult_met;
               $this->conteo_reg1;//conteo de registros segun la consulta $sql5
               
                 //for ($i=0; $i < $this->conteo_reg; $i++)
                 //{
               
                $sql = "SELECT fecha_actuali
                            FROM  `historico_proceso` 
                            WHERE fecha_actuali LIKE  '%$mes3%'";        
                
                $res = mysql_query($sql, Conexion::con());
                
                if (mysql_num_rows($res)== 0 && $mes1 < $mesactual )
                {
                        for ($i= 0; $i < count($his_metas1);$i++)
                        {
                            $proceso3 = $this->his_metas [$i]["proceso"];
                            $dimension3 = $this->his_metas [$i]["dimension"];  
                            $objetivo3 = $this->his_metas [$i]["objetivo"];
                            $meta3 = $this->his_metas [$i]["meta"];
                            $avance_meta3 = $this->his_metas [$i]["avance_meta1"];
                            $fecha_actuali3 = $this->his_metas [$i] ["fecha_actuali"];
                            $id_meta3 = $this->his_metas [$i] ["id_meta"];

                            $sqlinser = "INSERT INTO `historico_proceso` (
                                                        `id_historico_proc` ,
                                                        `proceso` ,
                                                        `objetivo` ,
                                                        `dimension` ,
                                                        `id_meta` ,
                                                        `meta` ,
                                                        `avance_meta1` ,
                                                        `fecha_actuali` ,
							`fecha_ingre`
                                                        )
                                                        VALUES (
                                                        NULL ,  '$proceso3',  '$objetivo3',  '$dimension3',  '$id_meta3',  '$meta3',  '$avance_meta3',  '$fecha_actuali3', '$fechaing'
                                                        )";
                            $res1 = mysql_query($sqlinser, Conexion::con());
                                
                        }
                     }
                    
           }
//*********************************************************************************************//                  		   
/**
 *Este metodo realiza el promedio de los procesos de acuerdo al parametro que se le pasa al metodo hist_dim2
 */           		   
			public function hist_dim2($mes1)
			{
			$sql = "SELECT proceso, AVG( avance_meta1 ) AS promedio
					 FROM  `historico_proceso` 
					 WHERE fecha_ingre LIKE  '%$mes1%'
					 GROUP BY proceso";
			$res = 	mysql_query($sql, Conexion::con());
			
				while ($result = mysql_fetch_assoc($res)) 
				{
					$this->hist_dim2[] = $result;
				}
					return $this->hist_dim2;
			}	
    }
?>            