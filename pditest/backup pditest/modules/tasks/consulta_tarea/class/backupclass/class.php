<?php
class Conexion
    {
        public static function con()
        {
          $con=  mysql_connect("mysqlean.ean.edu.co","dbmanager","kr56f10qh");
          mysql_query("SET NAMES 'UTF8'");
          mysql_select_db("dotprojecttest");  
          return $con;
        }
    }
class Consulta
{
    
    private $compara_meta;
    private $conteo_reg;
    private $conteo_reg1;
    private $consul_meta= array();
    private $proceso=array();
    private $nombre_vigencia=array();
    private $porcentaje_objetivo=array();    
    private $dimension=array();
    
    //funcion para seleccionar proceso     
    public function consulta_proceso($task_id)
            {
            
            $sql ="SELECT dept_id, dept_name, dept_phone
                    FROM  departments 
                     INNER JOIN task_departments ON department_id = dept_id
                      AND task_id = $task_id";
           //echo $sql;
            $res = mysql_query($sql, Conexion::con());
            
                    while ($result = mysql_fetch_assoc($res)){ 
                    
                        $this->proceso[]=$result;
                        }
                
                        return $this->proceso;
            }
            
            
    public function insertar_historicos()
            {   
               $nombre_compania = $_POST["nombre_compania"]; 
               $porcentaje = $_POST["porcentaje"]; 
               $meta = $_POST["meta"];
               $proyecto = $_POST["proyecto"];
               $task_id = $_POST["task_id"];
               $id_proyecto = $_POST["id_proyecto"];
               $proceso = $_POST["proceso"];
               $progreso_objetivo1 = $_POST["progreso_objetivo"];
               $estado_proyecto = $_POST["estado_proyecto"];
               $dia = date("j"); 
               $mes = date("m");
               $ano = date("Y");     
               
               
               $sql5= "SELECT task_id, task_name, task_project, task_start_date, task_percent_complete, task_log_task, task_log_name, task_log_description, task_log_date, project_id, project_name
                        FROM  `tasks` 
                        LEFT JOIN task_log ON task_id = task_log_task
                        INNER JOIN projects ON project_id = task_project
                        WHERE task_start_date LIKE  '%2012-01%'
                        AND task_log_date LIKE  '%2012-02%'
                        GROUP BY task_id";
               
                 $res5 = mysql_query($sql5, Conexion::con());
               
                    $this->conteo_reg = mysql_num_rows($res5); //conteo registros consulta anterior

                 while ($result5 = mysql_fetch_assoc($res5))
                     {
                        // echo $result5["task_id"]." ".$result5["task_name"]."<br />"; 
                        $this->consul_meta[]= $result5;
                     }
                         return $this->consul_meta;
                      
                   
                 }     
                 public function add_meta_mes()
                 {
                     
                    $consult_met = $this->insertar_historicos();
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
                     
                     
                   echo  $i." ".$id_meta.$nmeta.$nproyecto.$por_tarea."<br />";
                 
                  
                      
                 $sql= "INSERT INTO  `historicos` (
                        `id_historico` ,
                        `vigencia` ,
                        `dimension` ,
                        `proceso` ,
                        `objetivo` ,
                        `id_meta` ,    
                        `meta` ,
                        `avance_meta` ,
                        `progreso_objetivo`,
                        `ano`,
                        `mes`,
                        `dia`,
                        `fecha_modifi` 
                        )
                        VALUES (
                        NULL ,  '$nombre_compania',  '$estado_proyecto',  '$proceso', '$nproyecto', '$id_meta','$nmeta', '$por_tarea', '$progreso_objetivo1', '$ano', '$mes', '$dia','$fecha_modifica'
                        )";
              
                       $res=mysql_query($sql, Conexion::con());
                       
                      
                
                       //header ('Location: index.php?m=projects');
              /* }
               else 
               {
                //echo "para modificar";
                    $query="UPDATE  `historicos` SET avance_meta =  '$porcentaje',
                             progreso_objetivo =  '$progreso_objetivo1',
                              dia =  '$dia' 
                               WHERE 
                                vigencia LIKE  '%$ano%' 
                                AND objetivo =  '$proyecto'
                                AND meta =  '$meta'
                                AND avance_meta =  '$porcentaje'
                                AND progreso_objetivo =  '$progreso_objetivo1'
                                AND ano =  $ano
                                AND mes =  $mes ";
                    
                    $resp = mysql_query($query, Conexion::con());
                    
                    //echo "modiicacion OK";
                  //header ('Location: index.php?m=tasks&a=view&task_id='.urlencode($task_id));       
          }*/    
         
                $sql6="SELECT id_meta, meta, avance_meta, fecha_modifi
                        FROM  `historicos` 
                        WHERE id_meta <> $id_meta
                        AND fecha_modifi LIKE  '%2012-01%'";
                      
                      $res6 = mysql_query($sql6, Conexion::con());
               
                //  $this->conteo_reg = mysql_num_rows($res5); //conteo registros consulta anterior
              echo  "<br />conteo: ".$conteo_reg1 = mysql_num_rows($res6)."<br />"; //conteo registros consulta anterior      
                      
                     while ($result6 = mysql_fetch_assoc($res6))
                     {
                        // echo $result5["task_id"]." ".$result5["task_name"]."<br />"; 
                     echo $result6["id_meta"]."<br />";
                     // $this->compara_meta[]= $result6;
                     }
                     
                         //return $this->compara_meta;
                         
        } 
       }
      }     
    }
?>            