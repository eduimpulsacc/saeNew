<?php
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
 require_once('../../../../../../util/header.inc');
 require_once('../../../../../../util/registro.php');
 
 $rs_registro =RegistroUsuario($conn,3,$_NOMBREUSUARIO,$_PERFIL,$_INSTIT,'alumno',pg_dbname($conn));
 
 

function CambioFechaDisplay($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla
{
	$retorno="";
	if(strlen($fecha) <10 )
		return $retorno;
	$d=substr($fecha,8,2);
	$m=substr($fecha,5,2);
	$a=substr($fecha,0,4);
	if (checkdate($m,$d,$a))
		$retorno=$d."-".$m."-".$a;
	else
		$retorno="";
	return $retorno;
}






class FichaAlumno

{
	
	private $conect; 
	//private $conect2;        

//constructor 
public function __construct($con,$con2){ 
      $this->conect = $con;  
      $this->conect2 = $con2;
    }
	
	
	
	


	
	
	public function Ano_academico($id_ano)
	{
		$sql="select nro_ano from ano_escolar where id_ano=$id_ano";
		$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
	}
	
	public function datos_alumno($rut_alumno)
	{
		 $sql="select * from alumno where rut_alumno = ".$rut_alumno."";
			
		$result=pg_Exec($this->conect,$sql)or die("Fallo 1 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
			
		}
	}
	
	public function datosMatricula($rut_alumno,$id_ano,$id_curso,$ret){
		
		 $sql="select * from matricula where rut_alumno = ".$rut_alumno." and id_ano=".$id_ano." and id_curso=".$id_curso." and bool_ar=".$ret;
		$result=pg_Exec($this->conect,$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
			
		}
  }
  
  	public function get_region($cod_reg)
	{
		$sql="select * from region where cod_reg = ".$cod_reg."";	
		$result=pg_Exec($this->conect,$sql);
		
		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}
	}
	
	public function get_regiones()
	{
		$sql="select * from region order by cod_reg asc";	
		$result=pg_Exec($this->conect,$sql);
		
		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}
	}
	
	public function get_provincias($cod_reg)
	{
		$sql="select * from provincia where cod_reg=$cod_reg";
		$result=pg_Exec($this->conect,$sql);
		
		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}
	}
	
	public function get_provincia($cod_reg,$cod_prov)
	{
		$sql="select * from provincia where cor_pro=$cod_prov and cod_reg=$cod_reg";
		$result=pg_Exec($this->conect,$sql);
		
		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}
	}
	
	public function get_comuna($cod_com,$cod_prov,$cod_reg)
	{
		$sql="select * from comuna where cor_com=$cod_com and cor_pro=$cod_prov and cod_reg = $cod_reg";
		$result=pg_Exec($this->conect,$sql);
		
		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}
		
	}
	
	public function get_comunas($cod_reg,$cod_prov)
	{
		$sql="select * from comuna where cor_pro=$cod_prov and cod_reg = $cod_reg";
		$result=pg_Exec($this->conect,$sql);
		
		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}
		
	}
	
	
	public function get_sistema_salud()
	{
		$sql="select * from sistema_salud";	
		$result = pg_Exec($this->conect,$sql)or die("fallo sis_sal");
		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}
		
	}
	
	
	public function get_sistema_salud_ficha($id_sistema)
	{
		$sql="select * from sistema_salud where id_sistema_salud=$id_sistema";	
		$result = pg_Exec($this->conect,$sql);
		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}
		
	}
	
	
	public function update_rut($rut_antes,$dig_antes,$rut_nuevo,$dig_nuevo)
	{
		
		  $tablas = "
        alumno+
		asistencia+
        anotacion+
        concentracion_detalle+
        concentracion_notas+
        evaluacion_detalle_nin+
        evaluacion_detalle_sup+
        evaluacion_nin+
        ficha_deportiva+
        ficha_medica+
        hermanos+
        inasistencia_asignatura+
        informe_evaluacion2+
        justifica_inasistencia+
        matricula+
        notas2002+
        notas2003+
        notas2004+
        notas2005+
        notas2006+
        notas2007+
        notas2008+
        notas2009+
        notas2010+
        notas2011+
		notas2012+
		notas2013+
		notas2014+
		notas2015+
		notas2016+
		notas2017+
		notas2018+
		notas2019+
        notas_examen+
        notas_taller+
        observacion_evaluacion+
        orden_concentracion+
        promedio_alumno+
        promedio_examen+
        promedio_sub_alumno+
        promocion+
        relacion_hermanos+
        situacion_final+
        situacion_periodo+
        tiene2+
        tiene2002+
        tiene2003+
        tiene2004+
        tiene2005+
        tiene2006+
        tiene2007+
        tiene2008+
        tiene2009+
        tiene2010+
        tiene2011+
		tiene2012+
		tiene2013+
		tiene2014+
		tiene2015+
		tiene2016+
		tiene2017+
		tiene2018+
		tiene2019+
        tiene_taller";

         $a = explode('+',$tablas);
                  
          for($x=0; $x < count($a); $x++){
           
            $sql_select_1 = "SELECT * FROM ".$a[$x]." WHERE rut_alumno = '".trim($rut_antes)."'; ";
		   $result_select_1=pg_Exec($this->conect,$sql_select_1)or die("Fallo x ".$sql_select_1);
           
            "<br>".$sql_select_2 = "SELECT * FROM ".$a[$x]." WHERE rut_alumno = '".trim($rut_nuevo)."'; ";
           $result_select_2=pg_Exec($this->conect,$sql_select_2)or die("Fallo xx ".$sql_select_2);

		   if(pg_num_rows($result_select_1)!=0){ //Que El Rut Actual Exista.
           
           if(pg_num_rows($result_select_2)==0){ //Que el Rut Nuevo no Exita.

           // actualizamos las tablas correspondientes
            "<br>1".$sql_update = "update ".$a[$x]." set rut_alumno = '".trim($rut_nuevo)."' WHERE rut_alumno = '".trim($rut_antes)."' ";
           $result_update=pg_Exec($this->conect,$sql_update)or die("Fallo xxx ".$sql_update);
                if(!$result_update){
                  echo "Error en Actualizacion".pg_last_error($conn) ;
                }
             
             }else{ // ELIMINAR RUT NUEVO. PORQUE EXISTE. PARA ACTUALIZAR EL RUT ANTIGUO
                
                                
                $sql_delete = "DELETE FROM ".$a[$x]." WHERE  rut_alumno = '".trim($rut_nuevo)."'";                  
                $result_update=pg_Exec($this->conect,$sql_delete)or die("Fallo xx ".$sql_delete);

                //Actualizamos las tablas correspondientes del rut Antiguo.
               $sql_update = "update ".$a[$x]." set rut_alumno = '".trim($rut_nuevo)."' WHERE rut_alumno = '".trim($rut_antes)."' ";
                $result_update=pg_Exec($this->conect,$sql_update)or die("Fallo xx ".$sql_update);
                if(!$result_update){
                  echo "Error en Actualizacion".pg_last_error($conn) ;
                }
                
              }  
             
             }
                      
           }
		
		 $sql="update alumno set dig_rut='".$dig_nuevo."', rut_alumno=".$rut_nuevo." 
		 where rut_alumno=".$rut_nuevo."";	
		$result=pg_Exec($this->conect,$sql)or die("Fallo 5 ".$sql);
		
		if(!$result)
		{
			return 0;	
		}else{
			return 1;
		}
	}
	
	
	public function actualiza_datos_personales($rut_alumno,$dig_rut,$nombre_alum,$ape_pat,$ape_mat,$fecha_nac,$sexo,$nacionalidad,$alum_emb,$alum_ind,$proced_alum,$con_quien_vive,$txt_calle,$txt_nro,$txt_block,$txt_depto,$txt_villa,$txt_fono,$txt_email,$region,$provincia,$comuna,$curso_rep,$especialista,$al_pie,$al_sep,$al_retos,$al_puente,$al_fc,$cmbSANCION,$txtENFERMEDAD,$txtCIRUGIA,$txtMEDICAMENTO,$txtALERGIA,$txtFISICA,$txtFIEBRE,$txtSEGURO,$aut_emergencia,$rut_sinpuntos,$nombre_retira,$parentesco_retira,$telefono_retira,$cel_retira,$viaja_furgon,$nombre_tio,$fono_furgon,$fecham,$alumno_ret,$fechar,$motivo_r,$cmb_condicional,$opta_religion,$ed_diferencial,$al_integrado,$id_curso,$nro_ano,$id_ano,$datos_interes,$observacion,$observacion_salud,$ret,$cmbMOTIVO,$religion,$telefono_recado,$tipo_parto,$edad_madre_nace,$peso_nace,$talla_nace,$s_salud,$probdentales,$controldental,$famenfermo,$jefe_hogar,$ocup_jefehogar,$num_grupofamiliar,$ingresos,$tipo_vivienda,$cant_dormitorios,$cant_banos,$espacio_juego,$espacio_estudio,$hizo_jardin,$carinoso,$sociable,$curioso,$org_participa,$con_quien_estudia,$obse_general,$figura_paterna,$jefe_aporta,$controlsano,$bool_neurologo,$bool_psicopedagogo,$bool_psicologo,$bool_tieneluz,$bool_tieneagua,$bool_tienealcantarillado,$bool_retirosolo,$bool_otratamiento,$bool_tratactual,$bool_tastornosaprendizaje,$material_vivienda,$estado_vivienda,$txt_otratamiendo,$txt_tratactual,$txt_trastornosaprendizaje,$cant_hermanos,$num_hermano,$txt_eleccion,$bool_cambioropa,$bool_tomafoto,$bool_facebook,$pais_origen,$pasaporte,$estilo_aprendizaje,$celular,$enc_matricula,$rut_sinpuntos2,$nombre_retira2,$parentesco_retira2,$telefono_retira2,$cel_retira2,$rut_sinpuntos3,$nombre_retira3,$parentesco_retira3,$telefono_retira3,$cel_retira3,$txt_etnia,$bool_bautismo,$bool_pcomunion,$bool_confirmacion,$bool_psiquiatra,$bool_fonoaudiologo,$bool_pvision,$bool_paudicion,$bool_pcolumna,$bool_gdiferencial,$num_mat,$txt_subsidio,$txt_causajuzgado,$txt_fichaps,$ben_prog_prot_social,$bool_deporte,$txt_deporte)
	{
		
		
		if($proced_alum==""){$proced_alum="-";}
		if($con_quien_vive==""){$con_quien_vive="-";}
		if($txt_calle==""){$txt_calle="-";}
		if($txt_nro==""){$txt_nro="-";}
		if($txt_block==""){$txt_block="-";}
		if($txt_depto==""){$txt_depto="-";}
		if($txt_villa==""){$txt_villa="-";}
		if($txt_fono==""){$txt_fono="-";}
		if($txt_email==""){$txt_email="-";}
		
		if($rut_sinpuntos==""){$rut_sinpuntos="-";}
		if($nombre_retira==""){$nombre_retira="-";}
		if($parentesco_retira==""){$parentesco_retira="-";}
		if($telefono_retira==""){$telefono_retira="-";}
		if($cel_retira==""){$cel_retira="-";}
		if($viaja_furgon==""){$viaja_furgon="-";}
		if($nombre_tio==""){$nombre_tio="-";}
		if($fono_furgon==""){$fono_furgon="-";}
		
		if($motivo_r==""){$motivo_r='-';}
		
		if($datos_interes==""){$datos_interes='-';}
		if($observacion==""){$observacion='-';}
		if($observacion_salud==""){$observacion_salud='-';}
		
		if($religion==""){$religion='-';}
		
		if($telefono_recado==""){$telefono_recado='-';}
		if($edad_madre_nace==""){$edad_madre_nace='0';}
		
		if($peso_nace==""){$peso_nace='';}
		if($talla_nace==""){$talla_nace='';}
		if($material_vivienda==""){$material_vivienda='';}
		
		
		if($estado_vivienda==""){$estado_vivienda='';}
		
		if($txt_otratamiendo==""){$txt_otratamiendo='';}
		
			
		if($txt_tratactual==""){$txt_tratactual='';}
		
		if($txt_trastornosaprendizaje==""){$txt_trastornosaprendizaje='';}
		if($txt_eleccion==""){$txt_eleccion='-';}
		if($pasaporte==""){$pasaporte='-';}
		if($celular==""){$celular='-';}
		if($txt_etnia==""){$txt_etnia='-';}
		
		
	/*if($bool_bautismo=="") $bool_bautismo=0;
	if($bool_pcomunion=="") $bool_pcomunion=0;
	if($bool_confirmacion=="") $bool_confirmacion=0;
		*/
		
	$bool_bautismo=$_POST['bool_bautismo'];
	$bool_pcomunion=$_POST['bool_pcomunion'];
	$bool_confirmacion=$_POST['bool_confirmacion'];
		
		if ($fechar=="")
		{
			$fechar="NULL";
		}else{
				$fechar="'".$fechar."'";
		}
		
		
		//if($rut_sinpuntos2==""){$rut_sinpuntos2="-";}
		if($nombre_retira2==""){$nombre_retira2="-";}
		if($parentesco_retira2==""){$parentesco_retira2="-";}
		if($telefono_retira2==""){$telefono_retira2="-";}
		if($cel_retira2==""){$cel_retira2="-";}
		
		//if($rut_sinpuntos3==""){$rut_sinpuntos3="-";}
		if($nombre_retira3==""){$nombre_retir3="-";}
		if($parentesco_retira3==""){$parentesco_retira3="-";}
		if($telefono_retira3==""){$telefono_retira3="-";}
		if($cel_retira3==""){$cel_retira3="-";}

		
		//if($_PERFIL==0){show($_POST);}
		
		//$nombre_alumno = utf8_decode($nombre_alum);
		
		$bool_psiquiatra=$_POST['bool_psiquiatra'];
		$bool_fonoaudiologo=$_POST['bool_fonoaudiologo'];
		$bool_gdiferencial=$_POST['bool_gdiferencial'];
		$bool_pvision=$_POST['bool_pvision'];
		$bool_paudicion=$_POST['bool_paudicion'];
		$bool_pcolumna=$_POST['bool_pcolumna'];
		$aut_vacuna=$_POST['aut_vacuna'];
		
			
		
			$num_mat = $_POST['num_mat'];
		
		
		
		$txt_subsidio=(strlen($_POST['txt_subsidio'])>0)?$_POST['txt_subsidio']:"";
		
		$txt_causajuzgado=(strlen($_POST['txt_causajuzgado'])>0)?$_POST['txt_causajuzgado']:"";
		
	$txt_fichaps=(strlen($_POST['txt_fichaps'])>0)?$_POST['txt_fichaps']:"";
	
	$ben_prog_prot_social=(strlen($_POST['ben_prog_prot_social'])>0)?$_POST['ben_prog_prot_social']:"";
	
	$bool_deporte=$_POST['bool_deporte'];
	$txt_deporte=($bool_deporte!=0)?$_POST['txt_deporte']:"";
		
$sql ="update alumno set nombre_alu='$nombre_alum',ape_pat='$ape_pat',ape_mat='$ape_mat',fecha_nac='$fecha_nac',sexo=$sexo,nacionalidad='$nacionalidad',c_procedencia='$proced_alum',cq_vive='$con_quien_vive',calle='$txt_calle',nro='$txt_nro',block='$txt_block',depto='$txt_depto',villa='$txt_villa',telefono='$txt_fono',email='$txt_email',region='$region',ciudad='$provincia',comuna='$comuna',religion='$religion',telefono_recado='$telefono_recado',edad_madre_nace=$edad_madre_nace,tipo_parto=$tipo_parto,peso_nace='".trim($peso_nace)."',talla_nace='".trim($talla_nace)."',s_salud=$s_salud,cant_hermanos=$cant_hermanos,num_hermano=$num_hermano,pais_origen=$pais_origen,pasaporte='$pasaporte',celular='$celular',txt_etnia='$txt_etnia',bool_bautismo=$bool_bautismo,bool_pcomunion=$bool_pcomunion,bool_confirmacion=$bool_confirmacion,bool_deporte=$bool_deporte,txt_deporte='$txt_deporte' where rut_alumno = $rut_alumno ";

//if($_PERFIL==0){echo $sql."-1\n";exit;}
$result=pg_Exec($this->conect,$sql)or die("Fallo REG a ".$sql);

//datos del curso antes de actualizar
//$qryA="Select * from matricula where rut_alumno=".$rut_alumno ." and id_ano=".$id_ano ."and id_curso=".$id_curso;  
 $qryAn="Select * from matricula where rut_alumno=".$rut_alumno ." and id_ano=".$id_ano ." and id_curso=(select id_curso from matricula where rut_alumno=".$rut_alumno ." and id_ano=".$id_ano ." and bool_ar=$ret)";  
@$result_qryAn=pg_Exec($this->conect,$qryAn); 
$filaAn	= pg_fetch_array($result_qryAn,0);
//echo "--".$filaA['id_curso'];
if(!$result_qryAn)
$ea=1;
else
$ea=0;





     $sql_up_mat = "update matricula set bool_ae=$alum_emb, bool_aoi=$alum_ind,curso_rep='$curso_rep',trat_especialista='$especialista',ben_pie=$al_pie,ben_sep=$al_sep,bool_retos=$al_retos,ben_puente=$al_puente,bool_fci=$al_fc,sancion='$cmbSANCION',enfermedad='$txtENFERMEDAD',cirugia='$txtCIRUGIA',medicamento='$txtMEDICAMENTO',alergia='$txtALERGIA',fisica='$txtFISICA',fiebre='$txtFIEBRE',seguro='$txtSEGURO',autoriza_emergencia='$aut_emergencia',rut_retira='$rut_sinpuntos',nombre_retira='$nombre_retira',parentesco_retira='$parentesco_retira',fono_retira='$telefono_retira',celular_retira='$cel_retira',viaja_furgon='$viaja_furgon',nombre_tio='$nombre_tio',fono_furgon='$fono_furgon',fecha='$fecham',bool_ar=$alumno_ret,fecha_retiro=$fechar,motivo_retiro='$motivo_r',condicionalidad=$cmb_condicional,bool_rg=$opta_religion,bool_ed=$ed_diferencial,bool_i=$al_integrado,observacion='$observacion',datos_interes='$datos_interes',observacion_salud='$observacion_salud',tipo_retiro=$cmbMOTIVO,controlsano='$controlsano',jefe_hogar='$jefe_hogar',ocup_jefehogar='$ocup_jefehogar',num_grupofamiliar=$num_grupofamiliar,ingresos=$ingresos,tipo_vivienda=$tipo_vivienda,cant_dormitorios=$cant_dormitorios,cant_banos=$cant_banos,figura_paterna='$figura_paterna',carinoso=$carinoso,sociable=$sociable,curioso=$curioso,org_participa='$org_participa',con_quien_estudia='$con_quien_estudia',obse_general='$obse_general',bool_famenfermo=$famenfermo,bool_controldental=$controldental,bool_espacio_juego=$espacio_juego,bool_espacio_estudio=$espacio_estudio,bool_aporta_figura_paterna=$jefe_aporta,bool_hizo_jardin=$hizo_jardin,bool_neurologo=$bool_neurologo,bool_psicopedagogo=$bool_psicopedagogo,bool_psicologo=$bool_psicologo,bool_tieneluz=$bool_tieneluz,bool_tieneagua=$bool_tieneagua,bool_tienealcantarillado=$bool_tienealcantarillado,bool_retirosolo=$bool_retirosolo,bool_otratamiento=$bool_otratamiento,bool_tratactual=$bool_tratactual,bool_tastornosaprendizaje=$bool_tastornosaprendizaje,
   material_vivienda='$material_vivienda',
   estado_vivienda='$estado_vivienda',
   txt_otratamiendo='$txt_otratamiendo',
   txt_tratactual='$txt_tratactual',
   txt_tastornosaprendizaje='$txt_trastornosaprendizaje',
 txt_eleccion='$txt_eleccion', bool_cambioropa=$bool_cambioropa, bool_tomafoto=$bool_tomafoto,bool_facebook=$bool_facebook,estilo_aprendizaje=$estilo_aprendizaje,enc_matricula=$enc_matricula,rut_retira2='$rut_sinpuntos2', nombre_retira2='$nombre_retira2',parentesco_retira2='$parentesco_retira2',fono_retira2='$telefono_retira2',celular_retira2='$cel_retira2', rut_retira3='$rut_sinpuntos3',nombre_retira3='$nombre_retira3',parentesco_retira3='$parentesco_retira3', fono_retira3='$telefono_retira3',celular_retira3='$cel_retira3',bool_psiquiatra=$bool_psiquiatra,bool_fonoaudiologo=$bool_fonoaudiologo,bool_gdiferencial=$bool_gdiferencial,bool_pvision=$bool_pvision,bool_paudicion=$bool_paudicion,bool_pcolumna=$bool_pcolumna,aut_vacuna=$aut_vacuna,num_mat=$num_mat,txt_subsidio='$txt_subsidio',txt_causajuzgado='$txt_causajuzgado',txt_fichaps='$txt_fichaps',ben_prog_social='$ben_prog_prot_social'
    where rut_alumno = $rut_alumno and id_ano=$id_ano and id_curso = $id_curso and bool_ar=$ret";
  
//if($_PERFIL==0){echo $sql_up_mat."-2\n";}
  
  $result2=pg_Exec($this->conect,$sql_up_mat)or die("fm".$sql_up_mat);
  
  
 $qryA="Select * from matricula where rut_alumno=".$rut_alumno ." and id_ano=".$id_ano ." and id_curso=(select id_curso from matricula where rut_alumno=".$rut_alumno ." and id_ano=".$id_ano ." and bool_ar=$ret)";  
$result_qryA=pg_Exec($this->conect,$qryA)or die("Fallo REGu a ".$qryA); 
$filaA	= pg_fetch_array($result_qryA,0);
//echo "--".$filaA['id_curso'];


//cursos
$qry_cc="Select * from curso where id_curso=".$id_curso;  
$result_qry_cc=pg_Exec($this->conect,$qry_cc)or die("Fallo CUR ".$qry_cc); 
$fila_cc= pg_fetch_array($result_qry_cc,0);
  
  //if($_PERFIL==0){echo $qry_cc."-10\n";}
  

//if($_PERFIL==0){echo $qryA."-3\n";}

if ($fila_cc['ensenanza']>10 && ($filaAn['id_curso']!=$id_curso)){
	
	 $qryE="DELETE FROM tiene$nro_ano WHERE rut_alumno=".$rut_alumno;
	$result_qryE=pg_Exec($this->conect,$qryE)or die("Fallo REG a ".$qryE);
	//if($_PERFIL==0){echo $qryE."-4\n";}
	}
	
	if($filaAn['id_curso']!=$id_curso && $ea==0 && $fila_cc['ensenanza']>10){ 
	 $qryC="Select * from ramo where id_curso=".$id_curso;
	$result_qryC=pg_Exec($this->conect,$qryC)or die("Fallo REG a ".$qryC); 
	//if($_PERFIL==0){echo $qryC."-5\n";}
	if (!$result_qryC) {
	echo('<b> ERROR :</b>Error al acceder a la BD. (34)'.$qryC);
	}
	
	if (pg_numrows($result_qryC)!=0 || $fila_cc['ensenanza']>10  ){ 
	
	
	   for($i=0 ; $i < pg_numrows($result_qryC) ; $i++){
	   
			$filaC = pg_fetch_array($result_qryC,$i);
			$ramo=$filaC['id_ramo'];	   
			$qryE="INSERT INTO tiene$nro_ano (RUT_ALUMNO,ID_RAMO,ID_CURSO) VALUES(".trim($rut_alumno).",".$ramo.",".$id_curso.")"; 
			//if($_PERFIL==0){echo $qryE."-6\n";}
			
			$result_qryE=pg_Exec($this->conect,$qryE);
			 //----------- ULTIMO CAMBIO PARA LA ACTUALIZACION DE LAS NOTAS EN EL CASO DEL CAMBIO DE CURSO--------------
			 
			 $qry_r = "SELECT id_ramo FROM ramo WHERE id_curso=".$filaC['id_curso']." AND cod_subsector=".$filaC['cod_subsector'];
			 $result_r=pg_Exec($this->conect,$qry_r)or die("f1".$qry_r);
			 $filsNot = @pg_fetch_array($result_r,0);
			 //if($_PERFIL==0){echo $qry_r."-7\n";}
			 
			 if(pg_numrows($result_r)!=0){
				 //busco el ramo del curso anterior
				  $qry_r2 = "SELECT id_ramo FROM ramo WHERE id_curso=".$filaAn['id_curso']." AND cod_subsector=".$filaC['cod_subsector'];
				  $result_r2=pg_Exec($this->conect,$qry_r2);
			 	 // $filsNot2 = @pg_fetch_array($result_r2,0);
				  //if($_PERFIL==0){echo $qry_r2."-7b\n";}
				 
				 for($r=0;$r<pg_num_rows($result_r2);$r++){
				$filsNot2 = @pg_fetch_array($result_r2,$r);	
				$ramo_ant = $filsNot2['id_ramo'];
				//muevo los ramos que tiene inscritos
				 $qry_rama = "update tiene$nro_ano set id_ramo = $ramo, id_curso=$id_curso where rut_alumno=$rut_alumno and id_ramo=$ramo_ant and id_curso=".$filaAn['id_curso'];
				$result_rama=pg_Exec($this->conect,$qry_rama)or die("f".$qry_rama); 
				
				//muevo las notas
				$qry_n ="UPDATE notas$nro_ano SET id_ramo=".$ramo." WHERE id_ramo=".$ramo_ant." AND rut_alumno=".$rut_alumno;
				$result_qryr=pg_Exec($this->conect,$qry_n)or die("f".$qry_n); 
				 }
				
				/* $qry_n ="UPDATE notas$nro_ano SET id_ramo=".$ramo." WHERE id_ramo=".$ramo_ant." AND rut_alumno=".$rut_alumno;
				$result_qryr=pg_Exec($this->conect,$qry_n)or die("f".$qry_n);*/
				// if($_PERFIL==0){echo $qry_n."8-\n";}
			}
	   }
	   
	   // CAMBIO DE REGISTRO DE ASISTENCIA
	   $sql_asis="UPDATE asistencia SET id_curso=".$id_curso."  WHERE RUT_ALUMNO=".$rut_alumno."  AND ANO =".$id_ano." AND ID_CURSO=".$filaAn['id_curso'];
	   $rs_cambio_asistencia =pg_Exec($this->conect,$sql_asis)or die("A1".$sql_asis);
	   
	    // CAMBIO DE INFORME DE PERSONALIDAD
	   /*$sql_informe="UPDATE informe_evaluacion2 SET id_curso=".$id_curso."  WHERE RUT_ALUMNO=".$rut_alumno."  AND ANO =".$id_ano." AND ID_CURSO=".$filaAn['id_curso'];
	   $rs_cambio_informe =pg_Exec($this->conect,$sql_informe)or die("A1".$sql_informe);*/
	   
	
		$qry_up_m="UPDATE MATRICULA SET ID_CURSO=".$id_curso."  WHERE RUT_ALUMNO=".$rut_alumno."  AND ID_ANO =".$id_ano." AND ID_CURSO=".$filaAn['id_curso'];
		$result_qry_up_m=pg_Exec($this->conect,$qry_up_m)or die("f1".$qry_up_m);
	//if($_PERFIL==0){echo $qry_up_m."-9\n";}
	   }
	   
	}
	   
	   elseif($fila_cc['ensenanza']<=10){
		   $qry_up_m="UPDATE MATRICULA SET ID_CURSO=".$id_curso."  WHERE RUT_ALUMNO=".$rut_alumno."  AND ID_ANO =".$id_ano." AND ID_CURSO=".$filaAn['id_curso'];
		$result_qry_up_m=pg_Exec($this->conect,$qry_up_m)or die("f2".$qry_up_m);
	//if($_PERFIL==0){echo $qry_up_m."-9\n";}
		   }
		   
  
		if(!$result2)
		{
			return false;	
		}else{
			return $result;
		}
			
	}
	

	public function Datos_Familiar($rut_alumno)
	{
		 $sql="select * from apoderado where rut_apo in(select rut_apo from tiene2 where rut_alumno=".$rut_alumno.")";
		$result=pg_Exec($this->conect,$sql);
		
		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}	
	}
	
	public function Datos_Familiar2($rut_alumno)
	{
		 $sql="select * from apoderado where rut_apo in(select rut_apo from tiene2 where rut_apo=".$rut_alumno.")";
		$result=pg_Exec($this->conect,$sql);
		
		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}	
	}
	
	
	public function Datos_Familiar_responsable($rut_alumno)
	{
	    $sql="select * from tiene2 where rut_alumno=$rut_alumno and responsable=1";
		$result=pg_Exec($this->conect,$sql)or die("Fallo Dat_fam ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}	
	}
	
	public function Datos_Familiar_responsable2($rut_alumno,$rut_apoderado)
	{
	      $sql="select responsable,sostenedor from tiene2 where rut_alumno=$rut_alumno and rut_apo = $rut_apoderado";
		$result=pg_Exec($this->conect,$sql)or die("Fallo Dat_fam 2".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}	
	}
	
	
	
	public function Encuentra_Apo($rut_apo)
	{
		$sql="select * from apoderado where rut_apo = $rut_apo";	
		$result=pg_Exec($this->conect,$sql)or die("Fallo Dat_apo ".$sql);
		
		if(!$result)
		{
			return 0;	
		}else{
			return $result;
		}	
	}
	
	
	public function get_entrevista_apo($rut_apo,$rut_alumno,$id_ano)
	{
		 $sql="select * from entrevista where rut_apo = $rut_apo and rut_alumno=$rut_alumno and id_ano=$id_ano";	
		$result=pg_Exec($this->conect,$sql);
		
		if(!$result)
		{
			return 0;	
		}else{
			return $result;
		}	
	}
	
	
	public function Crea_relacion($rut_apo,$rut_alumno)
	{
		 $sql="insert into tiene2 (rut_apo,rut_alumno,responsable,sostenedor)
				   values (".$rut_apo.",".$rut_alumno.",1,0)";
			 $result=pg_Exec($this->conect,$sql)or die("Fallo Rel ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}		   	
	}
	
	public function Update_Apo($rut_apo,$nombre_apo,$ape_pat_apo,$ape_mat_apo,$fecha_nac_apo,$sexo_apo,$nacionalidad_apo,$txt_calle_apo,$txt_nro_apo,$txt_block_apo,$txt_depto_apo,$txt_villa_apo,$txt_fono_apo,$txt_celular_apo,$txt_email_apo,$comuna_apo,$txt_niv_edu_apo,$txt_ocupacion_apo,$txt_religion_apo,$select_sistema_salud_apo,$relacion_apo,$sistema_salud_apo,$chk_apoderado,$chk_sostenedor,$rut_alumno,$txt_profesion_apo,$edad_primer_parto,$ultimo_ano_aprobado,$estado_civil,$tipo_trabajo,$region_apo,$ciudad_apo,$pais_origen_apo)
	{
		
		if(strlen($fecha_nac_apo)>0){
		$fecha_nac_apo = "'".$fecha_nac_apo."'";
		}else{
			$fecha_nac_apo = "NULL";
		}
		
		
		 $sql="UPDATE apoderado  
			SET 
			  nombre_apo = '$nombre_apo',
			  ape_pat = '$ape_pat_apo',
			  ape_mat = '$ape_mat_apo',
			  calle = '$txt_calle_apo',
			  nro = '$txt_nro_apo',
			  depto = '$txt_depto_apo',
			  block = '$txt_block_apo',
			  villa = '$txt_villa_apo',
			  comuna = '$comuna_apo',
			  telefono = '$txt_fono_apo',
			  relacion = $relacion_apo,
			  email = '$txt_email_apo',
			  celular = '$txt_celular_apo',
			  nivel_edu = '$txt_niv_edu_apo',
			  fecha_nac = ".$fecha_nac_apo.",
			  sexo = $sexo_apo,
			  nacionalidad = $nacionalidad_apo,
			  ocupacion = '$txt_ocupacion_apo',
			  religion = '$txt_religion_apo',
			  sistema_salud = $sistema_salud_apo,
			  profesion = '$txt_profesion_apo',
			  edad_primer_parto='$edad_primer_parto',
			  ultimo_ano_aprobado='$ultimo_ano_aprobado',
			  estado_civil=$estado_civil,
			  tipo_trabajo=$tipo_trabajo,
			  region = $region_apo,
			  ciudad = $ciudad_apo,
			  pais_origen = $pais_origen_apo
			WHERE 
			  rut_apo = $rut_apo";
	
		$result=pg_Exec($this->conect,$sql)or die("Fallo Rel ".$sql);
		
 		 $sql_update_t2 ="update tiene2 set responsable=$chk_apoderado,sostenedor=$chk_sostenedor where rut_apo = $rut_apo and rut_alumno= $rut_alumno";
		$result_update_t2=pg_Exec($this->conect,$sql_update_t2)or die("Fallo rel2 ".$sql_update_t2);
		//
		if(!$result )
		{
			return false;	
		}else{
			return $result;
		}		   			  
			  
	}
	
	
	public function guarda_apoderado($rut_alumno,$rut_apo,$dig_rut_apo,$relacion,$chk_apoderado,$chk_sostenedor,$nombre_apo,$ape_pat,$ape_mat,$fecha_nac,$sexo,$nacionalidad,$calle_apo,$nro_apo,$block_apo,$depto_apo,$villa_apo,$comuna_apo,$fono_apo,$cel_apo,$mail_apo,$niv_edu_apo,$ocupacion_apo,$religion_apo,$sistema_salud,$region_apo,$prov_apo,$rdb='',$txt_profesion_apo,$edad_primer_parto,$ultimo_ano_aprobado,$estado_civil,$tipo_trabajo,$pais_origen_apo)
	{
		
		
		if(strlen($fecha_nac)>0){
		$fecha_nac = "'".CambioFecha($fecha_nac)."'";
		}else{
			$fecha_nac = "null";
		}
		
		$edp = ($edad_primer_parto=="")?0:$edad_primer_parto;
		
		
		
		  $sql="insert into apoderado (rut_apo,
		  dig_rut,
		  nombre_apo,
		  ape_pat,
		  ape_mat,
		  calle,
		  nro,
		  depto,
		  block,
		  villa,
		  region,
		  ciudad,
		  comuna,
		  telefono,
		  relacion,
		  email,
		  celular,
		  nivel_edu,
		  fecha_nac,
		  sexo,
		  nacionalidad,
		  ocupacion,
		  sistema_salud,
		  religion,
		  profesion,
		  edad_primer_parto,
		  ultimo_ano_aprobado,
		  tipo_trabajo,
		  estado_civil,
		  pais_origen) VALUES 
		
($rut_apo,
'$dig_rut_apo',
'$nombre_apo',
'$ape_pat',
'$ape_mat',
'$calle_apo',
'$nro_apo',
'$depto_apo',
'$block_apo',
'$villa_apo',
$region_apo,
$prov_apo,
$comuna_apo,
'$fono_apo',
$relacion,
'$mail_apo',
'$cel_apo',
'$niv_edu_apo',
$fecha_nac,
$sexo,
$nacionalidad,
'$ocupacion_apo',
'$sistema_salud',
'$religion_apo',
'$txt_profesion_apo',
$edp,
'$ultimo_ano_aprobado'
,$tipo_trabajo,
$estado_civil,
$pais_origen_apo)";
	$result=pg_Exec($this->conect,$sql)or die("Fallo ap ".$sql);
	
	 $sql2="insert into tiene2 (rut_apo,rut_alumno,responsable,sostenedor) values($rut_apo,$rut_alumno,$chk_apoderado,$chk_sostenedor)";	
	$result2=pg_Exec($this->conect,$sql2)or die("Fallo t2 ".$sql2);
	
	$pw = substr($rut_apo,0,5);
	
	//insertar en usuario
	  $sql3="insert into usuario (nombre_usuario,pw) values('$rut_apo','$pw')";	
	$result3=pg_Exec($this->conect2,$sql3)or die("Fallo t3 ".$sql3);
	
	//seleccionar id de usuario
	  $sql4 = "SELECT id_usuario from usuario where nombre_usuario = '$rut_apo' order by id_usuario DESC LIMIT 1";
	$result4=pg_Exec($this->conect2,$sql4)or die("Fallo t4 a ".$sql4); 
	$fila4	= pg_fetch_array($result4,0);
	
	if(count($fila4)>0){
		$id_usuario = $fila4['id_usuario'];

	 $sql5="insert into accede (id_usuario,id_perfil,rdb,id_sistema,id_base,estado) values($id_usuario,15,$rdb,1,".$_SESSION['_ID_BASE'].",1)";	
	$result5=pg_Exec($this->conect2,$sql5)or die("Fallo t5 ".$sql5);
	}
	
	
	
		if(!$result)
		{
			return 0;	
		}else{
			return 1;
			
		}		   		
	
	}
	
	
	public function Elimina_apo($rut_apo,$rut_alumno)
	{
		$sql="delete from apoderado where rut_apo=$rut_apo";	
		$result=pg_Exec($this->conect,$sql)or die("Fallo ap ".$sql);
		
		$sql2="delete from tiene2 where rut_apo=$rut_apo and rut_alumno=$rut_alumno";
		$result2=pg_Exec($this->conect,$sql2)or die("Fallo ap ".$sql2);
		
		if(!$result)
		{
			return 0;	
		}else{
			return 1;
		}		   	
	}
	
	public function Becas_ins($ano)
	{
		 $sql="select * from becas_conf where id_ano = $ano";	
		$result=pg_Exec($this->conect,$sql)or die("Fallo ap ".$sql);

		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}		   	
	}
	
	public function Becas_alumno($id_beca,$rut_alumno)
	{
		$sql = "SELECT * FROM becas_benef WHERE id_beca= $id_beca AND rut_alumno=$rut_alumno";	
		$result=pg_Exec($this->conect,$sql)or die("Fallo ap ".$sql);

		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}		   	
	}
	
	public function Update_becas($rut_alumno,$junaeb,$chile_sol,$beca_muni,$compar_inst,$cpadre,$bec_seguro,$bec_otros,$ben_pie,$ben_sep,$ben_puente,$arr_becas_alu)
	{
		$sql="update matricula set bool_baj=$junaeb,bool_bchs=$chile_sol,bool_mun=$beca_muni,bool_fci=$compar_inst,bool_cpadre=$cpadre,bool_seg=$bec_seguro,bool_otros=$bec_otros,ben_pie=$ben_pie,ben_sep=$ben_sep,ben_puente=$ben_puente where rut_alumno = $rut_alumno";	
		
		$result=pg_Exec($this->conect,$sql)or die("Fallo UP_bec ".$sql);
		
		//desarmo variable de becas institucionales
		$arr_becai= explode("-",$arr_becas_alu);
		$anio_beca = $arr_becai[1];
		$cant_becas = $arr_becai[0];
		
		//si tengo becas asociadas al colegio, hago el desarme del array
		if($cant_becas>0){
			$info_beca = $arr_becai[2];
			$ibeca = explode("/",$info_beca);
			
			//elimino datos de año y cant becas ya que no las necesito mas, y reodeno el array
			unset($ibeca[0]);
			$ibeca = array_values($ibeca);
			
			//volver a desarmar el array, para hacer el query de insert o delete becas
			for($b=0;$b<$cant_becas;$b++){
				$dbeca = explode("/",$ibeca[$b]);
				$db = explode("_",$dbeca[0]);
				$id_beca = $db[0];
				$estado_nuevo = $db[1];
				$estado_actual = $db[2];
				
				if($estado_nuevo!=$estado_actual){
					if($estado_nuevo==1)
					{
						$qry_beca = "insert into becas_benef values ($id_beca,$anio_beca,$rut_alumno,'".date("Y-m-d")."')";
					}elseif($estado_nuevo==0)
					{
						$qry_beca = "delete from becas_benef where id_beca=$id_beca and id_ano=$anio_beca and rut_alumno=$rut_alumno";
					}
					//echo $qry_beca;
					$result=pg_Exec($this->conect,$qry_beca)or die("Fallo get_grup ".$qry_beca);
				}
			}
			//exit;
		}

		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}		   	
	}
	
	public function get_grupos($rut_alumno)
	{
		  $sql="select * from grupos 
			  inner join relacion_grupo rg on grupos.id_grupo=rg.id_grupo 
			  where rut_integrante=$rut_alumno";	
		$result=pg_Exec($this->conect,$sql)or die("Fallo get_grup ".$sql);

		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}		   	
		
	}
	
	public function get_grupos_inst($rdb)
	{
		$sql="select * from grupos where rdb=$rdb";	
		$result=pg_Exec($this->conect,$sql)or die("Fallo get_grup_inst ".$sql);

		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}
	}
	
	public function get_grupos_inst_apo($rdb,$rut_apo)
	{
		//$sql="select * from grupos where rdb=$rdb";	
		
	
  $sql="select * from grupos pr 
where rdb=$rdb and pr.id_grupo not IN
(select id_grupo from relacion_grupo where rut_integrante=$rut_apo) order by pr.nombre";	

		$result=pg_Exec($this->conect,$sql)or die("Fallo get_grup_inst ".$sql);

		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}
	}
	
	public function guarda_grupo($rut_alumno,$id_grupo,$id_ano,$id_curso)
	{
		$sql="insert into relacion_grupo (rut_integrante,id_perfil,id_ano,id_grupo,id_curso)
		      VALUES ($rut_alumno,16,$id_ano,$id_grupo,$id_curso)";
			  $result=pg_Exec($this->conect,$sql)or die("Fallo get_grup_inst ".$sql);

		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}
	}
	
	public function guarda_grupo_apo($rut_apo,$id_grupo,$id_ano,$id_curso)
	{
		 $sql="insert into relacion_grupo (rut_integrante,id_perfil,id_ano,id_grupo,id_curso)
		      VALUES ($rut_apo,15,$id_ano,$id_grupo,$id_curso)";
			  $result=pg_Exec($this->conect,$sql)or die("Fallo get_grup_inst ".$sql);

		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}
	}
	
	public function Elimina_grupo($id_aux)
	{
		$sql="delete from relacion_grupo where id_aux=$id_aux";	
		$result=pg_Exec($this->conect,$sql)or die("Fallo Delete_group ".$sql);

		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}
	}
	
	public function Elimina_grupo_apo($rut_apo)
	{
		$sql="delete from relacion_grupo where rut_integrante=$rut_apo";	
		$result=pg_Exec($this->conect,$sql)or die("Fallo Delete_group ".$sql);

		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}
	}
	
	public function guarda_entrevista($rdb,$id_ano,$rut_alumno,$rut_apo,$fecha_ent,$asunto_ent,$contenido_ent,$tipo_entrevista,$id_asistencia,$acuerdo_ent,$compromiso_ent,$canal)
	{
		$sql="insert into entrevista (rdb,id_ano,rut_apo,rut_alumno,fecha,asunto,observaciones,tipo_entrevista,id_citacion,acuerdos,compromisos,canal)
		values($rdb,$id_ano,$rut_apo,$rut_alumno,'$fecha_ent','$asunto_ent','$contenido_ent','$tipo_entrevista',$id_asistencia,'$acuerdo_ent','$compromiso_ent',$canal)";
		//if($_PERFIL==0){echo $sql."-2\n";}
		$result=pg_Exec($this->conect,$sql)or die("Fallo ins_ent ".$sql);
		
		$sql2="update citacion_asistencia set estado=1 where id_asistencia=$id_asistencia";
		//if($_PERFIL==0){echo $sql."-2\n";}
		$result2=pg_Exec($this->conect,$sql2)or die("Fallo ins_ent ".$sql2);

		

		if(!$result || !$result2)
		{
			return false;	
		}else{
			return $result;
		}
    }
	
	public function elimina_ent($id_entrevista,$id_asistencia)
	{
		
		if($id_asistencia!=0){
		$sql2="update citacion_asistencia set estado=0 where id_asistencia=$id_asistencia";
		//if($_PERFIL==0){echo $sql."-2\n";}
		$result2=pg_Exec($this->conect,$sql2)or die("Fallo ins_ent ".$sql2);
		}
		$sql="delete from entrevista where id_entrevista =$id_entrevista ";	
		$result=pg_Exec($this->conect,$sql)or die("Fallo del_ent ".$sql);

		if(!$result || !$result2)
		{
			return false;	
		}else{
			return $result;
		}
	}
	
	public function get_cursos($id_ano){
	
	 $sql="select * from curso WHERE id_ano=$id_ano ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso";
	$result=pg_Exec($this->conect,$sql)or die("Fallo del_ent ".$sql);

		if(!$result)
		{
			return false;	
		}else{
			return $result;
		}
	
	}
	
	
	public function getCitacionALL($id_ano,$rut_apo){
		   $sql="select a.id_asistencia, c.id_citacion, c.fecha, 
				c.hora, c.id_asunto, a.estado, a.rut_apo,a.id_curso,
				asu.asunto
				from citacion c 
				inner join citacion_asistencia a on c.id_citacion=a.id_citacion 
				left join citacion_asunto asu on asu.id_asunto = c.id_asunto
				left join apoderado ap on ap.rut_apo = a.rut_apo
				where c.id_ano = $id_ano and a.rut_apo= $rut_apo
				and a.estado=0";	
				$sql.=" ORDER BY c.fecha,a.id_asistencia ASC";
				
				//echo $sql;
		$result=pg_Exec($this->conect,$sql);
		
		return $result;
	}
	
	public function getCitacion1($id_ano,$rut_apo,$id_citacion){
		 $sql="select id_asistencia,c.fecha,c.id_asunto,citacion_asistencia.atendido  from citacion_asistencia inner join citacion c on c.id_citacion=citacion_asistencia.id_citacion where rut_apo=$rut_apo and citacion_asistencia.id_citacion=$id_citacion";
		// if($_PERFIL==0){echo $sql;}
		 
		$result=pg_Exec($this->conect,$sql)or die("Fallo del_ent ".$sql);
		
		return $result;
	}
	
	public function institucion($institucion){
		$sql_ins = "SELECT institucion.run,institucion.dig_run,institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, region,ciudad,comuna, villa, ";
		$sql_ins.= " comuna.nom_com, institucion.telefono,institucion.fax,dig_rdb, email,letra_inst,area_geo, dependencia, nu_resolucion, fecha_resolucion,numero_inst,institucion.insignia, institucion.rdb ";
		$sql_ins.= "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON ";
		$sql_ins.= " (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ";
		$sql_ins.= " ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND ";
		$sql_ins.= "(institucion.comuna = comuna.cor_com) WHERE (((institucion.rdb)=".$institucion.")); ";
		
		//echo $sql_ins;
		$result =pg_Exec($this->conect,$sql_ins)or die("Fallo del_ent ".$sql_ins);
		
		$fila_ins 	= pg_fetch_array($result,0);
		$this->run			= $fila_ins['run'];	
		$this->dig_run		= $fila_ins['dig_run'];
		$this->dig_rdb		= $fila_ins['dig_rdb'];
		$this->ins_pal 		= ucwords(strtoupper($fila_ins['nombre_instit']));
		$this->rdb		= $fila_ins['rdb'];
		
		$this->insignia 	= $fila_ins['insignia'];
		return;
	}
	
	
	public function ProfeJefe($curso){
		
		$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
		$sql_profe = $sql_profe . "FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
		$sql_profe = $sql_profe . "WHERE (((supervisa.id_curso)=".$curso.")); ";
		
		//if($_PERFIL==0) {echo $sql_profe; }
		
		$result_profe =pg_Exec($this->conect,$sql_profe)or die("Fallo del_ent ".$sql_profe);
		$fila_profe = @pg_fetch_array($result_profe,0);	
		
		$this->profe_jefe = ucwords(strtoupper(trim($fila_profe['ape_pat'])." ".trim($fila_profe['ape_mat'])." ".trim($fila_profe['nombre_emp'])));
		
		$this->profe_nombre =ucwords(strtoupper(trim($fila_profe['nombre_emp'])." ".trim($fila_profe['ape_pat'])." ".trim($fila_profe['ape_mat'])));
		
		
		return;
	}
	
	
	public function traeNombreAsunto($asunto){
		 $sql="select id_asunto,asunto from citacion_asunto where id_asunto =".$asunto;
		$result =pg_Exec($this->conect,$sql)or die("Fallo del_ent ".$sql);
		return $result;
}

public function pOrigen(){
	 $sql="select * from paises";
		$result =pg_Exec($this->conect,$sql)or die("Fallo del_ent ".$sql);
		return $result;
}

public function pOrigen1($idp){
	 $sql="select * from paises where id=$idp";
		$result =pg_Exec($this->conect,$sql);
		return $result;
}
		
public function estilo_aprendizaje_todos(){
	  $sql="select * from estilo_aprendizaje";
		$result =pg_Exec($this->conect,$sql);
		return $result;
}

public function estilo_aprendizaje_uno($estilo){
	  $sql="select * from estilo_aprendizaje where id_estilo=$estilo";
		$result =pg_Exec($this->conect,$sql);
		return $result;
}
	
	
	public function traeNombreEnMatricula($rut_encamat){
		 $sql="select empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp from empleado where rut_emp =".$rut_encamat;
		$result =pg_Exec($this->conect,$sql) or die("Fallo del_ent ".$sql);
		return $result;
}

public function traeNombreEmp($rdb){
		 $sql="select distinct(empleado.rut_emp),empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp from empleado inner join trabaja on trabaja.rut_emp=empleado.rut_emp where trabaja.rdb =".$rdb;
		$result =pg_Exec($this->conect,$sql)or die("Fallo del_ent ".$sql);
		return $result;
}
		
public function getEtnia(){
$sql = "select * from etnia order by nombre";
	$result =pg_Exec($this->conect,$sql)or die("Fallo del_ent ".$sql);
		return $result;
}	

public function getEntrevistaDet($id_entrevista){
  $sql = "select * from entrevista where id_entrevista =$id_entrevista";
	$result =pg_Exec($this->conect,$sql)or die("Fallo del_ent ".$sql);
		return $result;	
}

public function getCitDet($id_citacion){
   $sql = "select id_asistencia,c.fecha,c.id_asunto,citacion_asistencia, citacion_asistencia.atendido
from citacion_asistencia 
inner join citacion c on c.id_citacion=citacion_asistencia.id_citacion 
where  citacion_asistencia.id_asistencia=$id_citacion";
	$result =pg_Exec($this->conect,$sql)or die("Fallo del_ent ".$sql);
		return $result;	
}

public function guardaMensajeCom($token,$rbd,$curso,$destinatario,$user,$fecha,$hora,$modo,$user_type,$texto,$tipomensaje){
 $sql="insert into sms_comu(token,rdb,id_curso,rut_destino,rut_origen,fecha,hora,modo,tipo_usuario,mensaje,tipo_mensaje,estado) values ('$token',$rbd,$curso,$destinatario,$user,'$fecha','$hora','$modo',$user_type,'$texto',$tipomensaje,0)";
$result =pg_Exec($this->conect,$sql)or die("Fallo del_ent ".$sql);
	
}

public function CargoEmpleado($usuario){
 $sql="select t.cargo,c.nombre_cargo 
from trabaja t inner join cargos c on c.id_cargo = t.cargo 
where t.rut_emp = $usuario order by identificador asc limit 1";	
//$result =pg_Exec($this->conect,$sql)or die("Fallo del_ent ".$sql);
}
	
	
public function getCanales($rbd){
	 $sql="select * from asignatura_bitacora_canal where rbd in(0,$rbd) order by id";
	$result =pg_Exec($this->conect,$sql)or die("Fallo del_ent ".$sql);
		return $result;
}

public function getCanalbyID($id){
	 $sql="select * from asignatura_bitacora_canal where id=$id";
	$result =pg_Exec($this->conect,$sql)or die("Fallo del_ent ".$sql);
		return $result;
	}		
}//fin clase
/*pg_close($conn);
pg_close($connection);*/
?>