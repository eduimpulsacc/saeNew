<?php
require('../../util/header.inc');


 	$frmModo		=$_FRMMODO;

	
	$txtREG=$Region;
	$txtCIU=$Provincia;
	$txtCOM=$Comuna;

if($txtREG=="")
	$txtREG=1;
if($txtCIU=="")
	$txtCIU=1;
if($txtCOM=="")
	$txtCOM=1;
$txt_RDB = $_INSTIT;

//show($_FILES);
//exit;

	if($cmbDATABASE){
		$sql = "SELECT * FROM base_dato WHERE id_base=".$cmbDATABASE;
		$rs_conexion =pg_Exec($connection,$sql);
		$fila_c = pg_fetch_array($rs_conexion,0);
		
		$conn=pg_connect("dbname=".$fila_c['dbname']." host=".$fila_c['host']." port=".$fila_c['port']." user=".$fila_c['user']." password=".$fila_c['password'].""); //or die ("Error de conexion $cmbDATABASE");
	}
if($url!="")//VEL
{	
	$qry_del = "delete from salida where rdb = '$txt_RDB'";
	$del_res = pg_Exec($conn,$qry_del);				
	$qry_url = "insert into salida (rdb,direccion) values('$txt_RDB','$url')";
	$qry_res = pg_Exec($conn,$qry_url);
}else{
	$qry_del = "delete from salida where rdb = '$txt_RDB'";
	$del_res = pg_Exec($conn,$qry_del);				
}
if ($frmModo=="ingresar") {

			$qry="Select * from institucion where (rdb='".$txtRDB."')";
				$result =@pg_Exec($conn,$qry);
				$result2 =@pg_Exec($connection,$qry);
		         if (pg_numrows($result)!=0 || pg_numrows($result2)!=0){ ?>
				<td align="center"> <div align="center">
    			<?php
			    echo ('<b> LA INSTITUCION YA EXISTE!</b>');
				?>
 			 	</div></td>
				<div align="center">
				<?php if($_PERFIL==0) {?>
  					<script> setTimeout("window.location='listarInstituciones.php3?modo=ini&pag=1'",2000);</script>					
				<? }?>
		<?php
					exit;} 
						else{
							
	if($txtRUN == "")
	{
		$txtRUN = 0;
	} 
	
	if($txtDIGRUN == "")
	{
		$txtDIGRUN = 0;
	} 
							
	if($info_colegio == "on")
	{
		$info_colegio = 1;
	}else{
		$info_colegio = 0;
	} 
	if($pae)	$pae=1;		else	$pae=0;
	if($CA)		$CA=1;		else	$CA=0;
	if($CP)		$CP=1;		else	$CP=0;
	if($WS)		$WS=1;		else	$WS=0;
	if($CPA)	$CPA=1;		else	$CPA=0;
	if($EX)		$EX=1;		else	$EX=0;
	$dia = substr($txtFECHARES,0,2);
	$mes = substr($txtFECHARES,3,2);
	$ano = substr($txtFECHARES,6,4);
	$txtFECHARES = "$ano-$mes-$dia";
	
	$razon_social=(strlen($razon_social)>0)?$razon_social:"";
	$rut_rl=(strlen($rut_rl)>0)?$rut_rl:0;
	$digrut_rl=(strlen($digrut_rl)>0)?$digrut_rl:'0';
	$nombre_rl=(strlen($nombre_rl)>0)?$nombre_rl:"";
	
	
	
	
	$qry="INSERT INTO INSTITUCION (RUN, DIG_RUN, RDB, DIG_RDB, NOMBRE_INSTIT, CALLE, NRO, REGION, CIUDAD, COMUNA, TIPO_INSTIT, TIPO_EDUC, IDIOMA, SEXO, METODO, FORMACION, BOOL_PAE, BOOL_CA, BOOL_CP, BOOL_WS, BOOL_CPA, BOOL_EX, NU_RESOLUCION, FECHA_RESOLUCION, DEPENDENCIA, AREA_GEO, info_colegio,modo_instit,razon_social,rut_rl,digrut_rl,nombre_rl) VALUES ('".trim($txtRUN)."','".trim($txtDIGRUN)."','".trim($txtRDB)."','".trim($txtDIGRDB)."','".trim($txtNOMBRE)."','".trim($txtCALLE)."','".trim($txtNRO)."',".$txtREG.",".$txtCIU.",".$txtCOM.",".$cmbINSTIT.",".$cmbEDUC.",".$cmbIDIOMA.",".$cmbSEXO.",".$cmbMETODO.",".$cmbFORMACION.",".$pae.",".$CA.",".$CP.",".$WS.",".$CPA.",".$EX.",'".trim($txtNRES)."','".trim($txtFECHARES)."',".$cmbDEP.",'".$txtAREAG."',".$info_colegio.",".$tipo_instit.",'$razon_social',$rut_rl,'$digrut_rl','$nombre_rl')";
	$result =@pg_Exec($conn,$qry);
	
	$qry_ins = "INSERT INTO INSTITUCION(RDB, DIG_RDB, NOMBRE_INSTIT,ESTADO_COLEGIO,BASE_DATOS,CEDE,SAEMOVIL,RECA,EVADOS,WEB,AEMAIL,TELEFONO,EMAIL) 
	                      VALUES ('".trim($txtRDB)."','".trim($txtDIGRDB)."','".trim($txtNOMBRE)."',1,".$cmbDATABASE.",0,0,0,0,0,0,'".trim($txtTELEF)."','".trim($txtEMAIL)."')";
	$result_ins =@pg_Exec($connection,$qry_ins);
	
	if (!$result) {
		error('<b> ERROR :</b>Error al acceder a la BD 1.'.$qry);
	}
	elseif (!$result_ins) {
		error('<b> ERROR :</b>Error al acceder a la BD 2.1'.$qry_ins);
	}
	else{
		if($_PERFIL==0) {
		echo "<script>window.location = 'listarInstituciones.php3?modo=ini'</script>";
		}
	}
  }
}
if($txtLETRA=='')$txtLETRA='';
if($txtDEP=='')$txtDEP=='';
if($txtBLO=='')$txtBLO=='';
if($txtVIL=='')$txtVIL=='';

if ($frmModo=="modificar") {
		if($info_colegio == "on")
		{
			$info_colegio = 1;
		}else{
			$info_colegio = 0;
		} 
	if($pae)	$pae=1;		else	$pae=0;
	if($CA)		$CA=1;		else	$CA=0;
	if($CP)		$CP=1;		else	$CP=0;
	if($WS)		$WS=1;		else	$WS=0;
	if($CPA)	$CPA=1;		else	$CPA=0;
	if($EX)		$EX=1;		else	$EX=0;
	if(!$txtRUN)	$txtRUN=0;
	if(!$txtDIGRUN)	$txtDIGRUN=0;
	if($txtNUMINST=='') $txtNUMINST="NULL";
	
	
	$razon_social=(strlen($razon_social)>0)?$razon_social:"";
	$rut_rl=(strlen($rut_rl)>0)?$rut_rl:0;
	$digrut_rl=(strlen($digrut_rl)>0)?$digrut_rl:'0';
	$nombre_rl=(strlen($nombre_rl)>0)?$nombre_rl:"";
		
	$qlimg="select timbre_ins from institucion where RDB=".$_INSTIT;
	$rimg = pg_exec($conn,$qlimg);
	$eimg = pg_result($rimg,0);
	
	
	if(pg_result($rimg)>0){
	
		if($celim == "on")
			{
				@unlink('../../timbres/'.$eimg);
				$img="";
			}
		else
		{	@unlink('timbres/'.$eimg);
			 $file = $_FILES['imga']['name'];
		 $ext = pathinfo($file, PATHINFO_EXTENSION);
		 $nom=$_INSTIT.".".$ext; 
		 if(!is_dir("../../timbres/")) 
       	 mkdir("../../timbres/", 0777);
		 else{
			 chmod("../../timbres/", 0777);
			 
		}
		 if (move_uploaded_file($_FILES['imga']['tmp_name'],"../../timbres/" .$nom))
		{
			$img=$nom;
			chmod("../../timbres/", 0755);
		}else{
			$img="";
			}
		}
	}else{
		 
		 $file = $_FILES['imga']['name'];
		 $ext = pathinfo($file, PATHINFO_EXTENSION);
		 $nom=$_INSTIT.".".$ext; 
		 if(!is_dir("../../timbres/")) 
       	 mkdir("../../timbres/", 0777);
		 else{
			 chmod("../../timbres/", 0777);
			 
		}
		 if (move_uploaded_file($_FILES['imga']['tmp_name'],"../../timbres/" .$nom))
		{
			$img=$nom;
			chmod("../../timbres/", 0755);
		}else{
			$img="";
			}
			
			
	}
	
	
     if($txtFECHARES==""){
	 	$qry="UPDATE INSTITUCION SET NOMBRE_INSTIT='$txtNOMBRE',RUN='$txtRUN',DIG_RUN='$txtDIGRUN',CALLE='$txtCALLE', NRO='$txtNRO', DEPTO='$txtDEP', BLOCK='$txtBLO', VILLA='$txtVIL', REGION=$txtREG, CIUDAD=$txtCIU, COMUNA=$txtCOM, TELEFONO='$txtTELEF', FAX='$txtFAX', EMAIL='$txtEMAIL', TIPO_INSTIT='$cmbINSTIT', TIPO_EDUC='$cmbEDUC', IDIOMA='$cmbIDIOMA', SEXO='$cmbSEXO', METODO='$cmbMETODO', FORMACION='$cmbFORMACION', BOOL_PAE='$pae',BOOL_CA='$CA', BOOL_CP='$CP',BOOL_WS='$WS',BOOL_CPA='$CPA',BOOL_EX='$EX',NU_RESOLUCION='$txtNRES',FECHA_RESOLUCION=Null,LETRA_INST='$txtLETRA',NUMERO_INST=$txtNUMINST,DEPENDENCIA='$cmbDEP',AREA_GEO='$txtAREAG', info_colegio = '$info_colegio', modo_instit=$tipo_instit,razon_social='$razon_social',rut_rl=$rut_rl,digrut_rl='$digrut_rl',nombre_rl='$nombre_rl',TIMBRE_INS='$img' where RDB=".$_INSTIT;
       }else{
		$dia = substr($txtFECHARES,0,2);
		$mes = substr($txtFECHARES,3,2);
		$ano = substr($txtFECHARES,6,4);
		$txtFECHARES = "$ano-$mes-$dia";
//		echo $txtFECHARES;
	    $qry="UPDATE INSTITUCION SET NOMBRE_INSTIT='$txtNOMBRE',RUN='$txtRUN',DIG_RUN='$txtDIGRUN',CALLE='$txtCALLE', NRO='$txtNRO', DEPTO='$txtDEP', BLOCK='$txtBLO', VILLA='$txtVIL', REGION=$txtREG, CIUDAD=$txtCIU, COMUNA=$txtCOM, TELEFONO='$txtTELEF', FAX='$txtFAX', EMAIL='$txtEMAIL', TIPO_INSTIT='$cmbINSTIT', TIPO_EDUC='$cmbEDUC', IDIOMA='$cmbIDIOMA', SEXO='$cmbSEXO', METODO='$cmbMETODO', FORMACION='$cmbFORMACION', BOOL_PAE='$pae',BOOL_CA='$CA', BOOL_CP='$CP',BOOL_WS='$WS',BOOL_CPA='$CPA',BOOL_EX='$EX',NU_RESOLUCION='$txtNRES',FECHA_RESOLUCION='$txtFECHARES',LETRA_INST='$txtLETRA',NUMERO_INST=$txtNUMINST,DEPENDENCIA='$cmbDEP',AREA_GEO='$txtAREAG', info_colegio = '$info_colegio', modo_instit=$tipo_instit,razon_social='$razon_social',rut_rl=$rut_rl,digrut_rl='$digrut_rl',nombre_rl='$nombre_rl',TIMBRE_INS='$img' where RDB=".$_INSTIT;
	   }
	   
	  // die($qry);
	   $qry_ins = "UPDATE INSTITUCION SET NOMBRE_INSTIT='$txtNOMBRE', TELEFONO='$txtTELEF',EMAIL='$txtEMAIL' WHERE RDB=".$_INSTIT;
	   $result_ins =@pg_Exec($connection,$qry_ins);
	 
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al acceder a la BD 2.2,$qry'.$qry);
	}elseif (!$result_ins) {
		error('<b> ERROR :</b>Error al acceder a la BD 2.3,$qry'.$qry_ins);
	}else{
		echo "<script>window.location = 'seteaInstitucion.php3?caso=1'</script>";
	}
}
if ($frmModo=="eliminar") {
	$qry="DELETE FROM INSTITUCION WHERE RDB=".$_INSTIT;
	$result =@pg_Exec($conn,$qry);
	
	$qry_ins="DELETE FROM INSTITUCION WHERE RDB=".$_INSTIT;
	$result_ins =@pg_Exec($connection,$qry);
	
	if (!$result) {
		error('<b> ERROR :</b>Error al eliminar.');
	}elseif (!$result_ins) {
		error('<b> ERROR :</b>Error al eliminar.');
	}else{
		 if($_PERFIL==0) {
			echo "<script>window.location = 'listarInstituciones.php3?modo=ini'</script>";
		} 
	}
}
pg_close($conn);
?>