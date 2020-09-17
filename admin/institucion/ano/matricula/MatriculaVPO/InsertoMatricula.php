<?php 
require('../../../../../util/header.inc');


	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 6;
	
	
	//nro año
	$sql_ano_actual = "select nro_ano from ano_escolar where id_ano = ".$ano;
	$res_ano_actual = @pg_Exec($conn,$sql_ano_actual);
	$fil_ano_actual = @pg_fetch_array($res_ano_actual,0);
	$nro_ano = $fil_ano_actual['nro_ano'];

	
	
	function CambioFecha($fecha)   //    cambia fecha del tipo  dd/mm/aaaa  ->  aaaa/mm/dd    para poder hacer insert y update
{
	$retorno="";
	if(strlen($fecha) !=10)
		return $retorno;
	$d=substr($fecha,0,2);
	$m=substr($fecha,3,2);
	$a=substr($fecha,6,4);
	if (checkdate($m,$d,$a))
		$retorno=$a."-".$m."-".$d;
	else
		$retorno="";
	return $retorno;
}

foreach($_GET as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   }
   
   foreach($_POST as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	
	 "asignacion=$asignacion<br>";
   } 
   
   $agua=trim($_POST["agua"]);
			 	if($agua=="")
				$agua="no";
   				else
				$agua="si";
				
				
	$luz=trim($_POST["luz"]);
			 	if($luz=="")
				$luz="no";
   				else
				$luz="si";
	
	$bano=trim($_POST["bano"]);
			 	if($bano=="")
				$bano="no";
   				else
				$bano="si";	
				
	$wc=trim($_POST["wc"]);
			 	if($wc=="")
				$wc="no";
   				else
				$wc="si";
	
	$alcantarillado=trim($_POST["alcantarillado"]);
			 	if($alcantarillado=="")
				$alcantarillado="no";
   				else
				$alcantarillado="si";		
		
		
	$pozoseptico=trim($_POST["pozoseptico"]);
			 	if($pozoseptico=="")
				$pozoseptico="no";
   				else
				$pozoseptico="si";
				
	$rep=trim($_POST["rep"]);
			 	if($rep=="")
				$rep="no";
   				else
				$rep="si";
				
	$rel=trim($_POST["rel"]);
			 	if($rel=="")
				$rel="no";
   				else
				$rel="si";
				
	$pviv=trim($_POST["pviv"]);
			 	if($pviv=="")
				$pviv="no";
   				else
				$pviv="si";
				
	$madviv=trim($_POST["madviv"]);
			 	if($madviv=="")
				$madviv="no";
   				else
				$madviv="si";
				
	$tie_unif=trim($_POST["tie_unif"]);
			 	if($tie_unif=="")
				$tie_unif="no";
   				else
				$tie_unif="si";
				
	//	busco la region, cuidad y comuna segun el combo alumno
	$sql_com="select * from comuna where nom_com='".$comuna."'";		
	$res_com = @pg_Exec($conn,$sql_com);
	$fil_com = @pg_fetch_array($res_com,0);
	
	$region=$fil_com['cod_reg'];
	$provincia=$fil_com['cor_pro'];
	$comuna=$fil_com['cor_com'];
	
	
	//	busco la region, cuidad y comuna segun el combo apoderado
	$sql_com_apo="select * from comuna where nom_com='".$comuna_apo."'";		
	$res_com_apo = @pg_Exec($conn,$sql_com_apo);
	$fil_com_apo = @pg_fetch_array($res_com_apo,0);
	
	$region_apo=$fil_com_apo['cod_reg'];
	$provincia_apo=$fil_com_apo['cor_pro'];
	$comuna_apo=$fil_com_apo['cor_com'];
	
	
 //actualizo alumno
$sql_up_alu="update alumno set nombre_alu='$nombre_alu' ,ape_pat='$ape_pat' ,ape_mat='$ape_mat',calle='$calle',nro='$nro',region=$region,ciudad=$provincia,comuna=$comuna,telefono='$telefono',sexo=$sexo,fecha_nac='".CambioFecha($fecha_nacimiento)."',salud='$salud',religion='$religion',cursosrep='$cusrsosrep',colegioprocedencia='$colegioprocedencia',cerro='$cerro',lugar='$lugar',contacto_emergencia='$contacto_emer',fono_contacto='fono_emer' where rut_alumno=$rut_alu";
 $up_alu=@pg_exec($conn,$sql_up_alu);
 
 
   
   
   //veo si esta en matricula, sino, inserto
    $sql_mat="select * from matricula where rut_alumno=$rut_alu and id_ano=$ano and id_curso=$curso";
   $res_mat=@pg_exec($conn,$sql_mat);
   if (pg_numrows($res_mat)==0)
   {
		  $sql_ins_mat="insert into matricula(rut_alumno,rdb,id_ano,id_curso,fecha,num_mat,bool_ar) values(".$rut_alu.",".$institucion.",".$ano.",".$curso.",'".CambioFecha($fecha_mat)."',$num_mat,0)";
		$res_ins_mat = @pg_Exec($conn,$sql_ins_mat) or die ('no inserte');
		
		 $sql_ins_mat="insert into matricula".$nro_ano." (rut_alumno,rdb,id_ano,id_curso,fecha,num_mat,bool_ar) values(".$rut_alu.",".$institucion.",".$ano.",".$curso.",'".CambioFecha($fecha_mat)."',$num_mat,0)";
		$res_ins_mat = @pg_Exec($conn,$sql_ins_mat) or die ('no inserte matricula$nro_ano');
	}
	else
	{
	?>
	<script>
  alert('Alumno ya esistente en matrícula');
   window.open('FormMatricula.php','_self');
   </script>
	<?
	
	}
	
	//datos apoderado
			 $sql_apo="SELECT * FROM apoderado INNER JOIN tiene2 ON (apoderado.rut_apo = tiene2.rut_apo)
WHERE (tiene2.responsable = 1) AND (tiene2.rut_alumno =".$rut.")";
			$res_apo=@pg_exec($conn,$sql_apo);
			if (pg_numrows($res_apo==0))
			{
				if(strlen($rut_apoderado)>0)
				{
					$sql_ins_apo="insert into apoderado_prueba(rut_apo,dig_rut,nombre_apo,ape_pat,ape_mat,calle,nro,region,ciudad,comuna,telefono,relacion,nivel_edu,cerro) values (".$rut_apoderado.",'".$dig_apoderado."','".$nom_apo."','".$ape_pat_apo."','".$ape_mat_apo."','".$dom_apo."','".$nro_apo."',".$region_apo.",".$provincia_apo.",".$comuna_apo.",'".$fon_apo."',".$parent_apo.",'".$n_educ_apo."','".$cerro_apo."')";
					$res_ins_apo = @pg_Exec($conn,$sql_ins_apo);
				}
			
			}
			else
			{
				 $up_apo="update apoderado set nombre_apo='$nom_apo',ape_pat='$ape_pat_apo',ape_mat='$ape_mat_apo',calle='$dom_apo',nro='$nro_apo',region=$region_apo,ciudad=$provincia_apo,comuna=$comuna_apo,telefono='$fon_apo',relacion=$parent_apo=,nivel_edu='$n_educ_apo',cerro='$cerro_apo' where rut_apo=$rut_apoderado";
				 $res_up=@pg_exec($conn,$up_apo);
			}
			
			
			
			
			//madre
			$sql_mad="SELECT * FROM public.apoderado INNER JOIN tiene2 ON (apoderado.rut_apo = tiene2.rut_apo) WHERE (apoderado.sexo = 1) and (tiene2.rut_alumno =".$rut.")";
			$res_mad=@pg_exec($conn,$sql_mad);
			if (pg_numrows($res_mad==0))
			{
				if(strlen($rut_madre)>0)
				{
					$sql_ins_pad="insert into apoderado (rut_apo,dig_rut,nombre_apo,ape_pat,ape_mat,nivel_edu,sexo) values (".$rut_madre.",'".$dig_madre."','".$nom_mad."','".$ape_pat_mad."','".$ape_mat_mad."','".$n_educ_madre."',1)";
$res_ins_pad = @pg_Exec($conn,$sql_ins_pad);

$ins_tiene2="insert into tiene2 values(".$rut_madre.",".$rut_alu.",0,1)";
$res_ins_tiene2 = @pg_Exec($conn,$ins_tiene2);
				}
			}
			else
			{
					 $up_madre="update apoderado set nombre_apo='$nom_mad',ape_pat='$ape_pat_mad',ape_mat='$ape_mat_mad',nivel_edu='$n_educ_madre',edad=$mad_edad where rut_apo=$rut_madre";
					$res_up_m=@pg_exec($conn,$up_madre);
				}
			
			
			//padre
			$sql_pad="SELECT * FROM public.apoderado INNER JOIN tiene2 ON (apoderado.rut_apo = tiene2.rut_apo) WHERE (apoderado.sexo = 2) and (tiene2.rut_alumno =".$rut.")";
			$res_pad=@pg_exec($conn,$sql_pad);
			if (pg_numrows($res_pad==0))
			{
				if(strlen($rut_padre)>0)
				{
					$sql_ins_pad="insert into apoderado (rut_apo,dig_rut,nombre_apo,ape_pat,ape_mat,nivel_edu,sexo,edad) values (".$rut_padre.",'".$dig_padre."','".$nom_pad."','".$ape_pat_pad."','".$ape_mat_pad."','".$n_educ_padre."',2,'$pad_edad')";
$res_ins_pad = @pg_Exec($conn,$sql_ins_pad);

$ins_tiene2="insert into tiene2 values(".$rut_padre.",".$rut_alu.",0,1)";
$res_ins_tiene2 = @pg_Exec($conn,$ins_tiene2);
				}
			}
			else
			{	
			
			 $up_padre="update apoderado set nombre_apo='$nom_pad',ape_pat='$ape_pat_pad',ape_mat='$ape_mat_pad',nivel_edu='$n_educ_padre',edad=$pad_edad where rut_apo=$rut_padre";
			$res_up_m=@pg_exec($conn,$up_padre);
			}
			
	
	
//busco si tiene antecedentes socio economicos... insertar o actualizar
$sql_sel_socio="select * from alumno_socioeconomico where rut_alumno=$rut_alu";
$res_sel_socio = @pg_Exec($conn,$sql_sel_socio);
if(pg_numrows($res_sel_socio)==0)
{

$sql_ins_socio="insert into alumno_socioeconomico values($rut_alu,'$tipo_vivienda',$n_hab,$n_pie,'$agua','$luz','$bano','$wc','$alcantarillado','$pozoseptico',$tot_entradas,'$tie_unif',$nrohijo,'$p_viv_jun',$cant_hijos,'$alu_cqv')";
$res_ins_socio = @pg_Exec($conn,$sql_ins_socio);
}
else
{
$sql_up_socio="update alumno_socioeconomico set tipo_vivienda='$tipo_vivienda',num_habi_viv=$n_hab,num_piezas=$n_pie,agua='$agua',luz='$luz',bano='$bano',wc='$wc',alcantarillado='$alcantarillado',pozoseptico='$pozoseptico',tot_ing_fam=$tot_entradas,tiene_unif='$tie_unif',hijo_num=$nrohijo,estado_padres='$p_viv_jun',cant_hijos=$cant_hijos,alu_conquienvive='$alu_cqv' where rut_alumno=$rut_alu";
$res_up_socio = @pg_Exec($conn,$sql_up_socio);

}

 
   ?>
   <script>
  alert('Matrícula Insertada Exitosamente');
 window.open('FormMatricula.php','_self');
   </script>