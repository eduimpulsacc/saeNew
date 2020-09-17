<? 
require('../util/header.inc');
require('../util/LlenarCombo.php3');
require('../util/SeleccionaCombo.inc');

$ano			= $_ANO;

$curso			= $c_curso;
$alumno 		= $c_alumno;

 $institucion	 = $_INSTIT;
$usuarioensesion = $_USUARIOENSESION;
$empleado		 = $_EMPLEADO;


$perfil_user = $_PERFIL;
$idusuario   = $_USUARIO;
$ano		 = $_ANO;
$contador    = 0;

// tengo el perfil debo ver que perfil tiene seleccionado para enviar mensajes:
  $q1 = "select * from config_mensajeria where rdb=".$institucion." AND id_perfil = '$_PERFIL'";
$r1 = pg_Exec($conn,$q1);
$n1 = pg_numrows($r1);
if ($n1==0){
    echo "No hay perfil en session. Sistema detenido";
	exit();
}else{
    $f1    = pg_fetch_array($r1,0);
	$p_19  = $f1['p_19'];
	$p_25  = $f1['p_25'];
	$p_20  = $f1['p_20'];
	$p_6   = $f1['p_6'];
	$p_21  = $f1['p_21'];
	$p_15  = $f1['p_15'];
	$p_16  = $f1['p_16'];
	$p_17  = $f1['p_17'];
	$p_1   = $f1['p_1'];
	$p_14  = $f1['p_14'];
	$p_27  = $f1['p_27'];
	$p_31  = $f1['p_31'];
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="javascript">  
   function MM_preloadImages() { //v3.0
      var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
      var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
      if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
   }   
   
  function envia() {
    document.form1.target=top.opener.name;
    document.form1.submit();
    self.close();
   }  
   
   function envia2() {
       document.form.submit();       
   }  
   
   function enviapag(form){
		if (form.cmb_curso.value!=0){
			form.cmb_curso.target="self";
			form.action = 'v_buscapara.php';
			form.submit(true);
	
		}	
	}
</script>
<SCRIPT LANGUAGE="JavaScript">


function ChequearTodos(chkbox)
{
	for (var i=0;i < document.forms[1].elements.length;i++)
	{
		var elemento = document.forms[1].elements[i];		
		if (elemento.type == "checkbox")
		{
			elemento.checked = chkbox.checked
		}
	}
}
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../Sea/cortes/b_ayuda_r.jpg','../Sea/cortes/b_info_r.jpg','../Sea/cortes/b_mapa_r.jpg','../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="100%" align="left" valign="top"><table width="600" height="250" border="0" cellpadding="3" cellspacing="0">
      <tr>
        <td class="tableindex">BUSQUEDA DE RECEPTOR DE MENSAJER&Iacute;A </td>
      </tr>
      <tr>
        <td><div align="center">          
		 <!-- Aqui las opciones según perfil -->	
		  <form name="form" id="form" action="v_buscapara.php" method="post">
		  <table width="100%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td class="cuadro01">APELLIDO</td>
              <td class="cuadro02"><label>
                <input name="Apellido" type="text" id="Apellido">
              </label></td>
            </tr>
			
			<tr>
              <td class="cuadro01">GRUPOS</td>
              <td class="cuadro02"><label>
			  <?
			  // llenar el combox con los grupos disponibles para la institucion
			  $q3 = "select * from grupos where rdb = '".trim($_INSTIT)."'order by nombre";
			  $r3 = @pg_Exec($conn,$q3);
			  $n3 = @pg_numrows($r3);
			  
			  ?>  
			  
              <select name="grupos" id="grupos" onChange="envia2();">
                <option value="0" selected="selected">Seleccione Grupo del Receptor</option>
				<?
				$j = 0;
				while ($j < $n3){
				    $f3 = pg_fetch_array($r3,$j);
				    $nombre   = $f3['nombre'];
					$id_grupo = $f3['id_grupo'];
					?>
				    <option value="<?=$id_grupo ?>" <? if ($grupos==$id_grupo){ ?> selected="selected" <? } ?>><?=$nombre ?></option>
                    <?
					$j++;					
				}
				?>				
				</select>
              </label></td>
            </tr>
			
            <tr>
              <td class="cuadro01">PERFIL</td>
              <td class="cuadro02"><label>
              <select name="perfilseleccionado" id="perfilseleccionado" onChange="envia2();">
                <option value="no" selected="selected">Seleccione Perfil del Receptor</option>
                <? if ($p_19==1){ ?>
                <option value="19" <? if ($perfilseleccionado==19){ ?> selected="selected" <? } ?>>INSPECTOR</option>
                <?   }   
			       if ($p_25==1){ ?>
                <option value="25" <? if ($perfilseleccionado==25){ ?> selected="selected" <? } ?>>JEFE DE UTP</option>
                <?   }
			       if ($p_20==1){ ?>
                <option value="20" <? if ($perfilseleccionado==20){ ?> selected="selected" <? } ?>>ORIENTADOR</option>
                <?   }
			       if ($p_6==1){ ?>
                <option value="6" <? if ($perfilseleccionado==6){ ?> selected="selected" <? } ?>>ENFERMERIA</option>
                <?   }
			       if ($p_21==1){ ?>
                <option value="21" <? if ($perfilseleccionado==21){ ?> selected="selected" <? } ?>>PSICOLOGO</option>
                <?   }		  		  	  
			  	   if ($p_15==1){ ?>
                <option value="15" <? if ($perfilseleccionado==15){ ?> selected="selected" <? } ?>>APODERADO</option>
                <?   }
			       if ($p_16==1){ ?>
                <option value="16" <? if ($perfilseleccionado==16){ ?> selected="selected" <? } ?>>ALUMNO</option>
                <?   }
			       if ($p_17==1){ ?>
                <option value="17" <? if ($perfilseleccionado==17){ ?> selected="selected" <? } ?>>DOCENTE</option>
                <?   }
			  	   if ($p_1==1){ ?>
                <option value="1" <? if ($perfilseleccionado==1){ ?> selected="selected" <? } ?>>DIRECTOR GENERAL</option>
                <?   }
			       
			       if ($p_14==1){ ?>
                <option value="14" <? if ($perfilseleccionado==14){ ?> selected="selected" <? } ?>>ADMINISTRADOR WEB COLEGIO</option>
                <?   } 
				
				if ($p_27==1){ ?>
                <option value="27" <? if ($perfilseleccionado==27){ ?> selected="selected" <? } ?>>ADMINISTRATIVO WEB</option>
                <?   }  
                if ($p_31==1){ ?>
                <option value="31" <? if ($perfilseleccionado==31){ ?> selected="selected" <? } ?>>SECRETARIA</option>
                <?   }  ?>
              </select>
              </label></td>
            </tr>		
			
	   
	     <? if (($perfilseleccionado==15) OR ($perfilseleccionado==16)){ 
		 
				$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
				$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
				$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
				$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
				
				$resultado_query_cue = pg_exec($conn,$sql_curso);
				//------------------
				$sql_peri = "select * from periodo where id_ano = ".$ano;
				$result_peri = pg_exec($conn,$sql_peri);	 
		 
		 ?> 
	            <tr>
                  <td class="cuadro01">CURSO</td>
                   <td class="cuadro02"><label>
				     
				  <?  
				  
				  if ($_PERFIL=="17") { // debo seleccionar solo los cursos que le corresponde a este profesor
				         //echo $qry="SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ano_escolar.nro_ano, institucion.nombre_instit, supervisa.rut_emp, ano_escolar_1.id_ano, institucion.rdb FROM institucion INNER JOIN (((tipo_ensenanza INNER JOIN (curso INNER JOIN supervisa ON curso.id_curso = supervisa.id_curso) ON tipo_ensenanza.cod_tipo = curso.ensenanza) INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) INNER JOIN ano_escolar AS ano_escolar_1 ON curso.id_ano = ano_escolar_1.id_ano) ON institucion.rdb = ano_escolar_1.id_institucion WHERE (((supervisa.rut_emp)=".$empleado.")) ORDER BY curso.grado_curso ASC";
						//$qry ="SELECT DISTINCT curso.id_ano,curso.id_curso,grado_curso ||'-'|| letra_curso ||' '|| nombre_tipo as curso FROM dicta INNER JOIN ramo ON dicta.id_ramo=ramo.id_ramo INNER JOIN curso ON ramo.id_curso=curso.id_curso INNER JOIN tipo_ensenanza te ON te.cod_tipo=curso.ensenanza WHERE rut_emp=".$empleado." and id_ano=".$ano." ORDER BY curso ASC";
						$qry="SELECT DISTINCT curso.id_ano,curso.id_curso,grado_curso ||'-'|| letra_curso ||' '|| nombre_tipo as curso FROM dicta INNER JOIN ramo ON dicta.id_ramo=ramo.id_ramo INNER JOIN curso ON ramo.id_curso=curso.id_curso INNER JOIN tipo_ensenanza te ON te.cod_tipo=curso.ensenanza WHERE rut_emp=".$empleado." and id_ano=".$ano." UNION SELECT DISTINCT curso.id_ano,curso.id_curso, grado_curso ||'-'|| letra_curso ||' '|| nombre_tipo as curso FROM supervisa INNER JOIN curso ON supervisa.id_curso=curso.id_curso INNER JOIN tipo_ensenanza ON tipo_ensenanza.cod_tipo=curso.ensenanza WHERE rut_emp=".$empleado." and id_ano=".$ano." ORDER BY curso ASC" ;
						
                         $result =@pg_Exec($conn,$qry);
						 if (!$result) {
							error('<B> ERROR :</b>Error al acceder a la BD. (52)</B>');
						}else{
							if (pg_numrows($result)!=0){ ?>
							    <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
								<option value=0 selected>(Seleccione Curso)</option> <?
								for($i=0 ; $i < @pg_numrows($result) ; $i++){
									$fila = @pg_fetch_array($result,$i);
									$id_curso = $fila['id_curso']; 
									$sql="SELECT situacion FROM ano_escolar WHERE id_ano=" . $fila['id_ano'];
									$Rs_Ano = @pg_exec($conn,$sql);
									$fils = @pg_fetch_array($Rs_Ano,0);

									if($fils['situacion']==1){
									       $Curso_pal =  $fila["curso"];
										   									   
										   ?> <option value="<?=$id_curso ?>" <? if ($id_curso == $cmb_curso){ ?> selected="selected" <? } ?>><?=$Curso_pal ?></option> <?
									}	   
								} ?>
					  </select>
					      <? }
						 }			  
				  
				     }else{
					       					 
					       if ($_PERFIL=="15"){  // Debo seleccionar el curso en que esta actualmente  ?>
						       <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
								<option value=0 selected>(Seleccione Curso)</option>
								<?
								for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
								   {
									$fila = @pg_fetch_array($resultado_query_cue,$i); 
								   if (trim($fila["id_curso"])==trim($_CURSO)){
										$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
										echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
								   }else{
										//$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
										//echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
								   }
								} ?>
						       </select>
						<? }else{
						
						       if ($_PERFIL=="16"){  // debo mostrar solo su curso actual  ?>
							        <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
								    <option value=0 selected>(Seleccione Curso)</option>
								    <?
								    for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
									   {
									    $fila = @pg_fetch_array($resultado_query_cue,$i); 
									    if (trim($fila["id_curso"])==trim($_CURSO)){
										 	$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
											echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
									    }else{
											//$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
											//echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
									    }
								    } ?>
						            </select>
						    <? }else{ ?>					 
							        <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
								      <option value=0 selected>(Seleccione Curso)</option>
								      <?
								      for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
									     {
									     $fila = @pg_fetch_array($resultado_query_cue,$i); 
									     if (trim($fila["id_curso"])==trim($cmb_curso)){
											$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
											echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
									     }else{
											$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
											echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
									     }
								     } ?>
		              </select>
						    <? } ?>			 
					    <? } ?>		   
				   <? } ?>			 
                  </label></td>
                </tr>			    
		<? } ?>				
		
	  		
		       <tr>
                 <td class="cuadro01">&nbsp;</td>
                  <td class="cuadro02"><input name="BUSCAR" type="submit" id="BUSCAR" value="BUSCAR"></td>
               </tr>			   
          </table>
		  </form>
		  
		  <form name="form1" id="form1" method="post" action="envio2.php?llave=3">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
			
			 <? if ($perfilseleccionado==15){ ?>
					  <td >
					  <?    if ($perfilseleccionado==17){
							   $nombrecargo="DOCENTE";
							}
							if ($perfilseleccionado==19){
							   $nombrecargo="INSPECTOR";
							}
							if ($perfilseleccionado==25){
							   $nombrecargo="JEFE DE UTP";
							}
							if ($perfilseleccionado==20){
							   $nombrecargo="ORIENTADOR";
							}
							if ($perfilseleccionado==21){
							   $nombrecargo="PSICOLOGO";
							}
							if ($perfilseleccionado==22){
							   $nombrecargo="PSICOPEDAGOGO";
							}
							if ($perfilseleccionado==1){
							   $nombrecargo="DIRECTOR GENERAL";
							} 
							if ($perfilseleccionado==8){
							   $nombrecargo="PROFESOR JEFE";
							} 
							if ($perfilseleccionado==14){
							   $nombrecargo="ADMINISTRADOR WEB";
							}				 	   
						    if ($perfilseleccionado==31){
							   $nombrecargo="SECRETARIA";
							}				 	   
						 
						 echo "$nombrecargo";
						 
						 ?></td>
			 <? } ?>			 
              <td ><table width="100%" border="0" cellspacing="0" cellpadding="3">
                <? if ($perfilseleccionado==15){ ?>
				      <tr>
                        <td width="40%" class="cuadro01">Apoderado</td>
				        <td width="40%" class="cuadro01">Alumno</td>
                        <td width="10%" class="cuadro01"><div align="right">Seleccionar</div></td>
                      </tr>
				<? }else{ ?>
					  <tr>
                        <td width="80%" class="cuadro01">Nombre</td>
				        <td width="20%" class="cuadro01"><div align="right">Seleccionar</div></td>
                      </tr>
                <? }
				
			   /// PROCESO INDEPENDIENTE DEL PERFIL SELECCIONADO O QUE ES.
			   /// BUSCAMOS POR EL TIPO DE GRUPO SELECCIONADO
			   if ($perfilseleccionado=="no"){
			      if ($grupos!=0){
				  /* CONDICION ELIMINADA PARA QUE NO CONSIDERE EL AÑO AL MOMENTO DE BUSCAR LOS ADERIDOS A UN GRUPO and id_ano = '".trim($_ANO)."'*/
				      	$q1 = "select * from relacion_grupo where id_grupo = '".trim($grupos)."'"; 
						 
						$r1 = pg_Exec($conn,$q1);
						$n1 = pg_numrows($r1);
						
						$i = 0;
						while ($i < $n1){
						    $f1 = pg_fetch_array($r1,$i);
							$rut_integrante = $f1['rut_integrante'];
							
							
							// busco el rut en la tabla alumnos para tomar sus datos
						 $qn = "select * from alumno where rut_alumno in (select rut_alumno from matricula where  rdb = '".trim($_INSTIT)."') and rut_alumno = '".trim($rut_integrante)."' ORDER BY nombre_alu, ape_pat, ape_mat ASC";
						
							 $rn = @pg_Exec($conn,$qn);
							 $nn = @pg_numrows($rn);
																 
							 if ($nn==0){
								// no hay datos que ingresar
							 }else{
							      $fn = pg_fetch_array($rn,0);
								  $nombre_emp = strtoupper($fn['nombre_alu']);
								  $ape_pat    = strtoupper($fn['ape_pat']);
								  $ape_mat    = strtoupper($fn['ape_mat']);
								  $id_usuario = $fn['rut_alumno'];
								  $rut_alumno = $fn['rut_alumno'];
						 
								  
								  if ($rut_alumno!=NULL){
								     ?>
								     <tr>
								     <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat "; ?></td>
								     <td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$rut_alumno ?>"></label></div></td>
								     </tr>
								     <?
								  }	 
									 
							 }	
							 //
														     
								 // busco en empleado
								 $qn = "select * from empleado where rut_emp in (select rut_emp from trabaja where rdb = '".trim($_INSTIT)."' and rut_emp = '".trim($rut_integrante)."')";
						         $rn = pg_Exec($conn,$qn);
								 $nn = pg_numrows($rn);
								 
								 if ($nn>0){
								     $fn = pg_fetch_array($rn,0);
							         $nombre_emp = strtoupper($fn['nombre_emp']);
							         $ape_pat    = strtoupper($fn['ape_pat']);
							         $ape_mat    = strtoupper($fn['ape_mat']);
							         $id_usuario = $fn['rut_emp'];	  
				                     
									 if ($id_usuario!=NULL){
									     ?>
								          <tr>
										  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
										  <td class="cuadro02"><div align="center"><label>				  
										  <input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
										 </tr> 
								         <?
									 }	 
								 }
								 
								  // busco en empleado
								 $qn = "select * from apoderado where rut_apo in (select rut_apo from apoderado where  rut_apo = '".trim($rut_integrante)."')";
						         $rn = pg_Exec($conn,$qn);
								 $nn = pg_numrows($rn);
								 
								 if ($nn>0){
								     $fn = pg_fetch_array($rn,0);
							         $nombre_emp = strtoupper($fn['nombre_apo']);
							         $ape_pat    = strtoupper($fn['ape_pat']);
							         $ape_mat    = strtoupper($fn['ape_mat']);
							         $id_usuario = $fn['rut_apo'];	  
				                     
									 if ($id_usuario!=NULL){
									     ?>
								          <tr>
										  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
										  <td class="cuadro02"><div align="center"><label>				  
										  <input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
										 </tr> 
								         <?
									 }	 
								 }
							
							 //
							 $i++;
						}
				   }
			  }			 
							 	 	 
			
			  /// FIN PROCESO INDEPENDIENTE DEL PERFIL SELECCIONADO O QUE ES.   ////
			  
			  //////////////////////////////////////////////////////////////////////	
			
			
				////// proceso para administradores web
				
				  if ($perfilseleccionado==14){				  
				     $Apellido = strtolower($Apellido);				     				     				/*  
			         $q1 = "select * from empleado where  ((lower(nombre_emp) like '%$Apellido%') OR (lower(ape_pat) like '%$Apellido%') OR (lower(ape_mat) like '%$Apellido%')) AND rut_emp in (select cast(nombre_usuario as integer) from usuario where id_usuario in (select id_usuario from accede where id_perfil = '14' and estado = '1' and rdb = '$_INSTIT'))";
					 $r1 = pg_Exec($conn,$q1);*/
					 $q1 = "select a.id_usuario,u.nombre_usuario from accede a, usuario u where a.id_usuario = u.id_usuario and a.id_perfil = '14' and a.estado = '1' and a.rdb = '$_INSTIT' ";
				
					 				 
					 $r1 = pg_Exec($connection,$q1);
					 $n1 = pg_numrows($r1);
					 					 				 
					 if ($n1==0){
					    // no hay datos que ingresar
					 }else{
					     $i = 0;
						 while ($i < $n1){
						     $f1 = pg_fetch_array($r1,$i);
							  $qq2 ="select * from empleado where 
((lower(nombre_emp) like '%%') OR (lower(ape_pat) like '%%') OR (lower(ape_mat) like '%%')) 
AND rut_emp in (".trim($f1['nombre_usuario']).")" ;
							$rr2 = @pg_Exec($conn,$qq2);
							 $ff2 = pg_fetch_array($rr2,0);
							 

								 $nombre_emp = $ff2['nombre_emp'];
								 $ape_pat    = $ff2['ape_pat'];
								 $ape_mat    = $ff2['ape_mat'];
								 $id_usuario = $ff2['rut_emp'];	  
							/* $nombre_emp = $f1['nombre_emp'];
							 $ape_pat    = $f1['ape_pat'];
							 $ape_mat    = $f1['ape_mat'];
							 $id_usuario = $f1['rut_emp'];	  */
				             
							 if ($grupos!=0){
							     // quiere decir que se ha seleccionado un grupo y perfil 17, Docente
							 	 // verificamos si este personal esta en la lista del grupo
								 $q2 = "select * from relacion_grupo where rut_integrante = '".trim($id_usuario)."' and id_grupo = '".trim($grupos)."'";
								 $r2 = pg_Exec($conn,$q2);
								 $n2 = pg_numrows($r2);
								 
								 if ($n2==1){
							 		 ?>
									 <tr>
									  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
									  <td class="cuadro02"><div align="center"><label>				  
									  <input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
									 </tr>
									 <?
								 }
						    }else{
							     ?>									 
								 <tr>
								  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
								  <td class="cuadro02"><div align="center"><label>				  
								  <input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
								 </tr>
                         <? } 
						    
							$i++;
						 }
					 }
				  }
				  
				
				////// proceso para ADMINISTRATIVO WEB
				
				  if ($perfilseleccionado==27){				  
				     $Apellido = strtolower($Apellido);				     				     				  
			     /*    $q1 = "select * from empleado where  ((lower(nombre_emp) like '%$Apellido%') OR (lower(ape_pat) like '%$Apellido%') OR (lower(ape_mat) like '%$Apellido%')) AND rut_emp in (select cast(nombre_usuario as integer) from usuario where id_usuario in (select id_usuario from accede where id_perfil = '27' and estado = '1' and rdb = '$_INSTIT'))";
					 $r1 = pg_Exec($conn,$q1);*/
					 	$q1 = "select a.id_usuario,u.nombre_usuario from accede a, usuario u where a.id_usuario = u.id_usuario and a.id_perfil = '19' and a.estado = '1' and a.rdb = '$_INSTIT' ";
				
					 				 
					 $r1 = pg_Exec($connection,$q1);
					 $n1 = pg_numrows($r1);
					 					 				 
					 if ($n1==0){
					    // no hay datos que ingresar
					 }else{
					     $i = 0;
						 while ($i < $n1){
						     $f1 = pg_fetch_array($r1,$i);
							/* $nombre_emp = $f1['nombre_emp'];
							 $ape_pat    = $f1['ape_pat'];
							 $ape_mat    = $f1['ape_mat'];
							 $id_usuario = $f1['rut_emp'];	 */ 
							 $qq2 ="select * from empleado where 
((lower(nombre_emp) like '%%') OR (lower(ape_pat) like '%%') OR (lower(ape_mat) like '%%')) 
AND rut_emp in (".trim($f1['nombre_usuario']).")" ;
							$rr2 = @pg_Exec($conn,$qq2);
							 $ff2 = pg_fetch_array($rr2,0);
							 

								 $nombre_emp = $ff2['nombre_emp'];
								 $ape_pat    = $ff2['ape_pat'];
								 $ape_mat    = $ff2['ape_mat'];
								 $id_usuario = $ff2['rut_emp'];	  
				             
							 if ($grupos!=0){
							     // quiere decir que se ha seleccionado un grupo y perfil 17, Docente
							 	 // verificamos si este personal esta en la lista del grupo
								 $q2 = "select * from relacion_grupo where rut_integrante = '".trim($id_usuario)."' and id_grupo = '".trim($grupos)."'";
								 $r2 = pg_Exec($conn,$q2);
								 $n2 = pg_numrows($r2);
								 
								 if ($n2==1){
							 		 ?>
									 <tr>
									  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
									  <td class="cuadro02"><div align="center"><label>				  
									  <input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
									 </tr>
									 <?
								 }
						    }else{
							     ?>									 
								 <tr>
								  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
								  <td class="cuadro02"><div align="center"><label>				  
								  <input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
								 </tr>
                         <? } 
						    
							$i++;
						 }
					 }
				  }  
				  
				  		
				
				
				
				
				////// proceso para docentes
				
				  if ($perfilseleccionado==17){	

				     if (($_PERFIL==15) OR ($_PERFIL==16)){ 		  
						 //--------------------------------
						 $institucion	=$_INSTIT;
						 $ano			=$_ANO;
						 $alumno		=$_ALUMNO;
						 $curso			=$_CURSO;
						 //-------------------------------
						 $qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
						 $result =@pg_Exec($conn,$qry);
						 $fila = @pg_fetch_array($result,0);	
						 $nro_ano=$fila['nro_ano'];
									 
						 $sqlProfesores = "select matricula.rut_alumno, ramo.id_ramo, subsector.nombre, ramo.cod_subsector, ramo.modo_eval, empleado.rut_emp, empleado.dig_rut, empleado.ape_pat, empleado.ape_mat,empleado.nombre_emp ";
						 $sqlProfesores = $sqlProfesores . "from matricula, ramo, subsector, dicta, empleado, tiene$nro_ano ";
						 $sqlProfesores = $sqlProfesores . "where matricula.rut_alumno = ".$alumno." and matricula.id_ano = ".$ano." ";
						 $sqlProfesores = $sqlProfesores . "and ramo.id_curso = matricula.id_curso ";
						 $sqlProfesores = $sqlProfesores . "and subsector.cod_subsector = ramo.cod_subsector ";
						 $sqlProfesores = $sqlProfesores . "and dicta.id_ramo = ramo.id_ramo ";
						 $sqlProfesores = $sqlProfesores . "and empleado.rut_emp = dicta.rut_emp " ;
						 $sqlProfesores = $sqlProfesores . "and tiene$nro_ano.id_curso = matricula.id_curso and tiene$nro_ano.rut_alumno = matricula.rut_alumno and tiene$nro_ano.id_ramo = ramo.id_ramo ";
						 //$rsProfesores  = @pg_Exec($conn,$sqlProfesores);			     				     				  
						 //$q1 = "select * from empleado where  ((lower(nombre_emp) like '%$Apellido%') OR (lower(ape_pat) like '%$Apellido%') OR (lower(ape_mat) like '%$Apellido%')) AND rut_emp in (select nombre_usuario from usuario where id_usuario in (select id_usuario from accede where id_perfil = '17' and estado = '1' and rdb = '$_INSTIT'))";
						
						
						 $r1 = pg_Exec($conn,$sqlProfesores);
						 $n1 = pg_numrows($r1);
						 
											 				 				 
						 if ($n1==0){
							 ////// no hay datos que ingresar
						 }else{
							 $i = 0;
							 while ($i < $n1){
								 $f1 = pg_fetch_array($r1,$i);
								 $nombre_emp = $f1['nombre_emp'];
								 $ape_pat    = $f1['ape_pat'];
								 $ape_mat    = $f1['ape_mat'];
								 $id_usuario = $f1['rut_emp'];	
								 
								 
								 if ($grupos!=0){
							         // quiere decir que se ha seleccionado un grupo y perfil 17, Docente
							 	     // verificamos si este personal esta en la lista del grupo
								     $q2 = "select * from relacion_grupo where rut_integrante = '".trim($id_usuario)."' and id_grupo = '".trim($grupos)."'";
								     $r2 = pg_Exec($conn,$q2);
								     $n2 = pg_numrows($r2);
								 
								     if ($n2==1){
								         ?>
										 <tr>
										   <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
										   <td class="cuadro02"><div align="center"><label>				  
										   <input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
										 </tr>
										 <?
									 }
							    }else{						 
								 
									 ?>
									 <tr>
									   <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
									   <td class="cuadro02"><div align="center"><label>				  
									   <input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
									 </tr>
									 <?
								 }	 
								 $i++;
							  }
						 }
					 
					 }else{
					     // buscamos al profesor para toda la institucion
						 $Apellido = strtolower($Apellido);					 
					 /*  echo   $q1 = "select * from empleado where  ((lower(nombre_emp) like '%$Apellido%') OR (lower(ape_pat) like '%$Apellido%') OR (lower(ape_mat) like '%$Apellido%')) AND rut_emp in (select cast(nombre_usuario as integer) from usuario where id_usuario in (select id_usuario from accede where id_perfil = '17' and estado = '1' and rdb = '$_INSTIT'))";*/
					$q1 = "select a.id_usuario,u.nombre_usuario from accede a, usuario u where a.id_usuario = u.id_usuario and a.id_perfil = '17' and a.estado = '1' and a.rdb = '$_INSTIT' ";
					     $r1 = @pg_Exec($connection,$q1);
						 $n1 = @pg_numrows($r1); 
						 
						 
						 if ($n1==0){
							//echo "no hay datos que ingresar";
						 }else{
							 $i = 0;
							 while ($i < $n1){
								 $f1 = pg_fetch_array($r1,$i);
								 
								 $qq2 ="select * from empleado where 
((lower(nombre_emp) like '%%') OR (lower(ape_pat) like '%%') OR (lower(ape_mat) like '%%')) 
AND rut_emp in (".trim($f1['nombre_usuario']).")" ;
							$rr2 = @pg_Exec($conn,$qq2);
							 $ff2 = pg_fetch_array($rr2,0);
							 

								 $nombre_emp = $ff2['nombre_emp'];
								 $ape_pat    = $ff2['ape_pat'];
								 $ape_mat    = $ff2['ape_mat'];
								 $id_usuario = $ff2['rut_emp'];	  
								 
								 
								 if ($grupos!=0){
									 // quiere decir que se ha seleccionado un grupo y perfil 17, Docente
									 // verificamos si este personal esta en la lista del grupo
									 $q2 = "select * from relacion_grupo where rut_integrante = '".trim($id_usuario)."' and id_grupo = '".trim($grupos)."'";
									 $r2 = pg_Exec($conn,$q2);
									 $n2 = pg_numrows($r2);
								 
								     if ($n2==1){
								         ?>					
									     <tr>
								         <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat "; ?></td>
								         <td class="cuadro02"><div align="center"><label>				  
								         <input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
								         </tr>
								         <?
								     }
								 }else{	 							 
									 ?>												
									 <tr>
									 <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
									 <td class="cuadro02"><div align="center"><label>				  
									 <input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
									 </tr>
									 <?
								}
								$i++;
								
							 }	  
						 }
					 }
				  }
				  
				  //// proceso para perfil 19, inspector
				  
				  if ($perfilseleccionado==19){			  
				     $Apellido = strtolower($Apellido);					 
					// $q1 = "select * from empleado where  ((lower(nombre_emp) like '%$Apellido%') OR (lower(ape_pat) like '%$Apellido%') OR (lower(ape_mat) like '%$Apellido%')) AND rut_emp in (select cast(nombre_usuario as integer) from usuario where id_usuario in (select id_usuario from accede where id_perfil = '19' and estado = '1' and rdb = '$_INSTIT'))";
				$q1 = "select a.id_usuario,u.nombre_usuario from accede a, usuario u where a.id_usuario = u.id_usuario and a.id_perfil = '19' and a.estado = '1' and a.rdb = '$_INSTIT' ";
				
					 				 
					 $r1 = pg_Exec($connection,$q1);
					 $n1 = pg_numrows($r1);
					 
										 					 				 
					 if ($n1==0){
					    // no hay datos que ingresar
					 }else{
					     $i = 0;
						 while ($i < $n1){
						   /*  $f1 = pg_fetch_array($r1,$i);
							 $nombre_emp = $f1['nombre_emp'];
							 $ape_pat    = $f1['ape_pat'];
							 $ape_mat    = $f1['ape_mat'];
							 $id_usuario = $f1['rut_emp'];	*/
							 $f1 = pg_fetch_array($r1,$i);
								 
								 $qq2 ="select * from empleado where 
((lower(nombre_emp) like '%%') OR (lower(ape_pat) like '%%') OR (lower(ape_mat) like '%%')) 
AND rut_emp in (".trim($f1['nombre_usuario']).")" ;
							$rr2 = @pg_Exec($conn,$qq2);
							 $ff2 = pg_fetch_array($rr2,0);
							 

								 $nombre_emp = $ff2['nombre_emp'];
								 $ape_pat    = $ff2['ape_pat'];
								 $ape_mat    = $ff2['ape_mat'];
								 $id_usuario = $ff2['rut_emp'];	  
							 
							 if ($grupos!=0){
							     // quiere decir que se ha seleccionado un grupo y perfil 19, inspector
								 // verificamos si este personal esta en la lista del grupo
								 $q2 = "select * from relacion_grupo where rut_integrante = '".trim($id_usuario)."' and id_grupo = '".trim($grupos)."'";
								 $r2 = pg_Exec($conn,$q2);
								 $n2 = pg_numrows($r2);
															 
								 if ($n2==1){
								     // el integrante existe, se despliega
									  ?>
									 <tr>
										<td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
										<td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
									 </tr>
									  <?
								 }
							}else{							 	  
								 ?>
								 <tr>
									<td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
									<td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
								 </tr>
								  <?
							}
									  
							 $i++;
						 }
					 }
				  }

				  /// proceso para perfil JEFE DE UTP
				  
				  if ($perfilseleccionado==25){				    
				  
				     $Apellido = strtolower($Apellido);				     				     				  
			       //  $q1 = "select * from empleado where  ((lower(nombre_emp) like '%$Apellido%') OR (lower(ape_pat) like '%$Apellido%') OR (lower(ape_mat) like '%$Apellido%')) AND rut_emp in (select cast(nombre_usuario as integer) from usuario where id_usuario in (select id_usuario from accede where id_perfil = '25' and estado = '1' and rdb = '$_INSTIT'))";
					  //$q1 = "select * from empleado where  rut_emp in (select nombre_usuario from usuario where id_usuario in (select accede.id_usuario from accede where id_perfil = '17' and rdb = '$_INSTIT')) and nombre_emp like '%$nombre%'";
					  
					  	$q1 = "select a.id_usuario,u.nombre_usuario from accede a, usuario u where a.id_usuario = u.id_usuario and a.id_perfil = '25' and a.estado = '1' and a.rdb = '$_INSTIT' ";
				
					 				 
					 $r1 = pg_Exec($connection,$q1);
					 //$r1 = pg_Exec($conn,$q1);
					 $n1 = pg_numrows($r1);
					 					 				 
					 if ($n1==0){
					    // no hay datos que ingresar
					 }else{
					     $i = 0;
						 while ($i < $n1){
						   /*  $f1 = pg_fetch_array($r1,$i);
							 $nombre_emp = $f1['nombre_emp'];
							 $ape_pat    = $f1['ape_pat'];
							 $ape_mat    = $f1['ape_mat'];
							 $id_usuario = $f1['rut_emp'];	  */
							 
							 $f1 = pg_fetch_array($r1,$i);
								 
								 $qq2 ="select * from empleado where 
((lower(nombre_emp) like '%%') OR (lower(ape_pat) like '%%') OR (lower(ape_mat) like '%%')) 
AND rut_emp in (".trim($f1['nombre_usuario']).")" ;
							$rr2 = @pg_Exec($conn,$qq2);
							 $ff2 = pg_fetch_array($rr2,0);
							 

								 $nombre_emp = $ff2['nombre_emp'];
								 $ape_pat    = $ff2['ape_pat'];
								 $ape_mat    = $ff2['ape_mat'];
								 $id_usuario = $ff2['rut_emp'];	  
				             						 
							 
							 if ($grupos!=0){
							     // quiere decir que se ha seleccionado un grupo y perfil 20, Orientador
								 // verificamos si este personal esta en la lista del grupo
								 $q2 = "select * from relacion_grupo where rut_integrante = '".trim($id_usuario)."' and id_grupo = '".trim($grupos)."'";
								 $r2 = pg_Exec($conn,$q2);
								 $n2 = pg_numrows($r2);
								 
								 if ($n2==1){
								     // existe, lo mostramos
									 ?>
									 <tr>
									  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
									  <td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
									 </tr>
									 <?
								 }
								 	 
							 }else{
							      ?>	 
								  <tr>
								  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
								  <td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
								  </tr>
								 <?
							  }
								 
								 	
							 $i++;
						 }
					 }
				  }
				  
				  
				  
				  /// proceso para perfil orientador
				  
				  if ($perfilseleccionado==20){				    
				  
				     $Apellido = strtolower($Apellido);				     				     				  
			       //  $q1 = "select * from empleado where  ((lower(nombre_emp) like '%$Apellido%') OR (lower(ape_pat) like '%$Apellido%') OR (lower(ape_mat) like '%$Apellido%')) AND rut_emp in (select cast(nombre_usuario as integer) from usuario where id_usuario in (select id_usuario from accede where id_perfil = '20' and estado = '1' and rdb = '$_INSTIT'))";
					  //$q1 = "select * from empleado where  rut_emp in (select nombre_usuario from usuario where id_usuario in (select accede.id_usuario from accede where id_perfil = '17' and rdb = '$_INSTIT')) and nombre_emp like '%$nombre%'";
					// $r1 = pg_Exec($conn,$q1);
					 	$q1 = "select a.id_usuario,u.nombre_usuario from accede a, usuario u where a.id_usuario = u.id_usuario and a.id_perfil = '20' and a.estado = '1' and a.rdb = '$_INSTIT' ";
				
					 				 
					 $r1 = pg_Exec($connection,$q1);
					 $n1 = pg_numrows($r1);
					 					 				 
					 if ($n1==0){
					    // no hay datos que ingresar
					 }else{
					     $i = 0;
						 while ($i < $n1){
						     $f1 = pg_fetch_array($r1,$i);
							/* $nombre_emp = $f1['nombre_emp'];
							 $ape_pat    = $f1['ape_pat'];
							 $ape_mat    = $f1['ape_mat'];
							 $id_usuario = $f1['rut_emp'];	  */
							  $qq2 ="select * from empleado where 
((lower(nombre_emp) like '%%') OR (lower(ape_pat) like '%%') OR (lower(ape_mat) like '%%')) 
AND rut_emp in (".trim($f1['nombre_usuario']).")" ;
							$rr2 = @pg_Exec($conn,$qq2);
							 $ff2 = pg_fetch_array($rr2,0);
							 

								 $nombre_emp = $ff2['nombre_emp'];
								 $ape_pat    = $ff2['ape_pat'];
								 $ape_mat    = $ff2['ape_mat'];
								 $id_usuario = $ff2['rut_emp'];	  
				             						 
							 
							 if ($grupos!=0){
							     // quiere decir que se ha seleccionado un grupo y perfil 20, Orientador
								 // verificamos si este personal esta en la lista del grupo
								 $q2 = "select * from relacion_grupo where rut_integrante = '".trim($id_usuario)."' and id_grupo = '".trim($grupos)."'";
								 $r2 = pg_Exec($conn,$q2);
								 $n2 = pg_numrows($r2);
								 
								 if ($n2==1){
								     // existe, lo mostramos
									 ?>
									 <tr>
									  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
									  <td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
									 </tr>
									 <?
								 }
								 	 
							 }else{
							      ?>	 
								  <tr>
								  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
								  <td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
								  </tr>
								 <?
							  }
								 
								 	
							 $i++;
						 }
					 }
				  }
				  
				  
				  // proceso para enfermería
				  if ($perfilseleccionado==6){	
				    		  
				     $Apellido = strtolower($Apellido);				     				     				  
			      /*   $q1 = "select * from empleado where  ((lower(nombre_emp) like '%$Apellido%') OR (lower(ape_pat) like '%$Apellido%') OR (lower(ape_mat) like '%$Apellido%')) AND rut_emp in (select cast(nombre_usuario as integer) from usuario where id_usuario in (select id_usuario from accede where id_perfil = '6' and estado = '1' and rdb = '$_INSTIT'))";
					 $r1 = pg_Exec($conn,$q1);*/
					 	$q1 = "select a.id_usuario,u.nombre_usuario from accede a, usuario u where a.id_usuario = u.id_usuario and a.id_perfil = '6' and a.estado = '1' and a.rdb = '$_INSTIT' ";
				
					 				 
					 $r1 = pg_Exec($connection,$q1);
					 $n1 = pg_numrows($r1);					 					 				 
					 if ($n1==0){
					    // no hay datos que ingresar
					 }else{
					     $i = 0;
						 while ($i < $n1){
						     $f1 = pg_fetch_array($r1,$i);
							 /*$nombre_emp = $f1['nombre_emp'];
							 $ape_pat    = $f1['ape_pat'];
							 $ape_mat    = $f1['ape_mat'];
							 $id_usuario = $f1['rut_emp'];	 */ 
							 								 $qq2 ="select * from empleado where 
((lower(nombre_emp) like '%%') OR (lower(ape_pat) like '%%') OR (lower(ape_mat) like '%%')) 
AND rut_emp in (".trim($f1['nombre_usuario']).")" ;
							$rr2 = @pg_Exec($conn,$qq2);
							 $ff2 = pg_fetch_array($rr2,0);
							 

								 $nombre_emp = $ff2['nombre_emp'];
								 $ape_pat    = $ff2['ape_pat'];
								 $ape_mat    = $ff2['ape_mat'];
								 $id_usuario = $ff2['rut_emp'];	  
				             
							 if ($grupos!=0){
							    // quiere decir que se ha seleccionado un grupo y perfil 6, Enfermero
								// verificamos si este personal esta en la lista del grupo
								$q2 = "select * from relacion_grupo where rut_integrante = '".trim($id_usuario)."' and id_grupo = '".trim($grupos)."'";
								$r2 = pg_Exec($conn,$q2);
								$n2 = pg_numrows($r2);
								 
								if ($n2==1){
								    ?>
									<tr>
									  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
									  <td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
									</tr>
									<?
								}
							}else{				
								?>
								<tr>
								  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
								  <td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
								</tr>
								<?
							}
								
							 $i++;
						 }
					 }
				  }
				  
				  
				  //// proceso para psicologo 21
				  if ($perfilseleccionado==21){
				     				  
				     $Apellido = strtolower($Apellido);				     				     				  
			        /* $q1 = "select * from empleado where  ((lower(nombre_emp) like '%$Apellido%') OR (lower(ape_pat) like '%$Apellido%') OR (lower(ape_mat) like '%$Apellido%')) AND rut_emp in (select cast(nombre_usuario as integer) from usuario where id_usuario in (select id_usuario from accede where id_perfil = '21' and estado = '1' and rdb = '$_INSTIT'))";
					 $r1 = pg_Exec($conn,$q1);*/
					 	$q1 = "select a.id_usuario,u.nombre_usuario from accede a, usuario u where a.id_usuario = u.id_usuario and a.id_perfil = '21' and a.estado = '1' and a.rdb = '$_INSTIT' ";
				
					 				 
					 $r1 = pg_Exec($connection,$q1);
					 $n1 = pg_numrows($r1);
					 					 				 
					 if ($n1==0){
					    // no hay datos que ingresar
					 }else{
					     $i = 0;
						 while ($i < $n1){
						     $f1 = pg_fetch_array($r1,$i);
							/* $nombre_emp = $f1['nombre_emp'];
							 $ape_pat    = $f1['ape_pat'];
							 $ape_mat    = $f1['ape_mat'];
							 $id_usuario = $f1['rut_emp'];	  */
							 $qq2 ="select * from empleado where 
((lower(nombre_emp) like '%%') OR (lower(ape_pat) like '%%') OR (lower(ape_mat) like '%%')) 
AND rut_emp in (".trim($f1['nombre_usuario']).")" ;
							$rr2 = @pg_Exec($conn,$qq2);
							 $ff2 = pg_fetch_array($rr2,0);
							 

								 $nombre_emp = $ff2['nombre_emp'];
								 $ape_pat    = $ff2['ape_pat'];
								 $ape_mat    = $ff2['ape_mat'];
								 $id_usuario = $ff2['rut_emp'];	  
				             
							 if ($grupos!=0){
								 // quiere decir que se ha seleccionado un grupo y perfil 17, Docente
								 // verificamos si este personal esta en la lista del grupo
								 $q2 = "select * from relacion_grupo where rut_integrante = '".trim($id_usuario)."' and id_grupo = '".trim($grupos)."'";
								 $r2 = pg_Exec($conn,$q2);
								 $n2 = pg_numrows($r2);
								 
								 if ($n2==1){
							          ?>
									  <tr>
									  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
									  <td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
									  </tr>
									  <?
								 }
						     }else{						 
								 ?>
								 <tr>
								  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
								  <td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
								 </tr>
								<?
							 }
							 	
							 $i++;
						 }
					 }
				  }
				  
				  
				  ///// proceso para director general
				  if ($perfilseleccionado==1){
				     				  
				     $Apellido = strtolower($Apellido);				     				     				  
			    /*     $q1 = "select * from empleado where  ((lower(nombre_emp) like '%$Apellido%') OR (lower(ape_pat) like '%$Apellido%') OR (lower(ape_mat) like '%$Apellido%')) AND rut_emp in (select cast(nombre_usuario as integer) from usuario where id_usuario in (select id_usuario from accede where id_perfil = '1' and estado = '1' and rdb = '$_INSTIT'))";
					 $r1 = pg_Exec($conn,$q1);*/
					 	$q1 = "select a.id_usuario,u.nombre_usuario from accede a, usuario u where a.id_usuario = u.id_usuario and a.id_perfil = '1' and a.estado = '1' and a.rdb = '$_INSTIT' ";
				
					 				 
					 $r1 = pg_Exec($connection,$q1);
					 $n1 = pg_numrows($r1);
					 					 				 
					 if ($n1==0){
					    // no hay datos que ingresar
					 }else{
					     $i = 0;
						 while ($i < $n1){
						     $f1 = pg_fetch_array($r1,$i);
							/* $nombre_emp = $f1['nombre_emp'];
							 $ape_pat    = $f1['ape_pat'];
							 $ape_mat    = $f1['ape_mat'];
							 $id_usuario = $f1['rut_emp'];	 */ 
							  $qq2 ="select * from empleado where 
((lower(nombre_emp) like '%%') OR (lower(ape_pat) like '%%') OR (lower(ape_mat) like '%%')) 
AND rut_emp in (".trim($f1['nombre_usuario']).")" ;
							$rr2 = @pg_Exec($conn,$qq2);
							 $ff2 = pg_fetch_array($rr2,0);
							 

								 $nombre_emp = $ff2['nombre_emp'];
								 $ape_pat    = $ff2['ape_pat'];
								 $ape_mat    = $ff2['ape_mat'];
								 $id_usuario = $ff2['rut_emp'];	  
				             
							 
							 if ($grupos!=0){
								 // quiere decir que se ha seleccionado un grupo y perfil 17, Docente
								 // verificamos si este personal esta en la lista del grupo
								 $q2 = "select * from relacion_grupo where rut_integrante = '".trim($id_usuario)."' and id_grupo = '".trim($grupos)."'";
								 $r2 = pg_Exec($conn,$q2);
								 $n2 = pg_numrows($r2);
								 
								 if ($n2==1){
								      ?>
								      <tr>
									  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
									  <td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
									  </tr>
									  <?
								 }
							}else{	 		 
							 	 ?>
								 <tr>
								  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
								  <td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$id_usuario ?>"></label></div></td>
								 </tr>
								 <?
							}
								 
							 $i++;
						 }
					 }
				  }
				  
				  
				  
				  
				  
				  ///// proceso para apoderado
				  
				  if ($perfilseleccionado==15){	
				     
					 if (($cmb_curso!=NULL) and ($cmb_curso!=0)){		    
				  
							 $Apellido = strtolower($Apellido);				     				  
							   $q1 = "select * from apoderado where ((lower(nombre_apo) like '%$Apellido%') OR (lower(ape_pat) like '%$Apellido%') OR (lower(ape_mat) like '%$Apellido%')) AND rut_apo in (select rut_apo from tiene2 where rut_alumno in (select rut_alumno from matricula where id_curso = '$cmb_curso'))";
							 //$q1 = "select * from empleado where  rut_emp in (select nombre_usuario from usuario where id_usuario in (select accede.id_usuario from accede where id_perfil = '17' and rdb = '$_INSTIT')) and nombre_emp like '%$nombre%'";
							 $r1 = pg_Exec($conn,$q1);
							 $n1 = pg_numrows($r1);
																 
							 if ($n1==0){
								// no hay datos que ingresar
							 }else{
								 $i = 0;
								 while ($i < $n1){
									 $f1 = pg_fetch_array($r1,$i);
									 $nombre_apo = $f1['nombre_apo'];
									 $ape_pat    = $f1['ape_pat'];
									 $ape_mat    = $f1['ape_mat'];
									 //$id_usuario = $f1['id_usuario'];
									 $rut_apo    = $f1['rut_apo'];
									 
									 // Aqui debo consultar si tiene acceso al sistema
									 $q2 = "select * from accede where id_usuario in (select id_usuario from usuario where nombre_usuario = '".trim($rut_apo)."') and id_perfil = '15' and estado = '1'";
									 $r2 = @pg_Exec($connection,$q2);
									 $n2 = @pg_numrows($r2);
									 $id_usuario = pg_result($r2,0);
									 if ($n2==0){
									     //  no listo este apoderado por que no tiene acceso al sistema
									 }else{							
									     // tenemos el apoderado ahora debo rescatar al alumno
										 $q3 = "select * from alumno where rut_alumno in (select rut_alumno from tiene2 where rut_apo = '".trim($rut_apo)."' and rut_alumno in (select rut_alumno from matricula where id_curso='$cmb_curso'))"; 
										 $r3 = pg_Exec($conn,$q3);
										 $n3 = pg_numrows($r3);
										 if ($n3==0){
										     // no hay alumno encontrado
										 }else{
										     $f3 = pg_fetch_array($r3,0);
											 $nombre_alu  = $f3['nombre_alu'];
											 $ape_pat_alu = $f3['ape_pat'];
											 $ape_mat_alu = $f3['ape_mat'];
										 }									 
									 	 	  
										 // Aqui consulto si se ha selecionado que busque por un GRUPO específico
										 if ($grupos!=0){						 
										 
											 $q3 = "select * from relacion_grupo, grupos where relacion_grupo.rut_integrante = '".trim($rut_apo)."' and relacion_grupo.id_ano = '".trim($_ANO)."' and grupos.id_grupo = '".trim($grupos)."' and grupos.rdb = '".trim($_INSTIT)."'";
											 $r3 = pg_Exec($conn,$q3);
											 $n3 = pg_numrows($r3);
											 
											 if ($n3==1){ // Muestro al alumno encontrado ya que participa del curso
												  ?>
												 <tr>
											      <td class="cuadro02"><? echo "$nombre_apo $ape_pat $ape_mat "; ?></td>
											      <td class="cuadro02"><? echo "$nombre_alu $ape_pat_alu $ape_mat_alu"; ?></td>
											      <td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$rut_apo ?>"></label></div></td>
											     </tr>
												 <?
											  }	 
										   
										 }else{
									 
											 ?>
										     <tr>
											  <td class="cuadro02"><? echo "$nombre_apo $ape_pat $ape_mat "; ?></td>
											  <td class="cuadro02"><? echo "$nombre_alu $ape_pat_alu $ape_mat_alu"; ?></td>
											  <td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$rut_apo ?>"></label></div></td>
											 </tr>
										     <?
										 }	 
									 }	  
									 $i++;
								 }
							 }
					  }		 
				  }
				  
				  
				  
				  
				  //// proceso para alumno
				  if ($perfilseleccionado==16){
				     $Apellido = strtolower($Apellido);	
					 
					 if (($grupos!=NULL)  and ($cmb_curso==0)){
					     // busco sin importar el curso
						 $q1 = "select * from alumno where ((lower(nombre_alu) like '%$Apellido%') OR (lower(ape_pat) like '%$Apellido%') OR (lower(ape_mat) like '%$Apellido%')) AND rut_alumno in (select rut_alumno from matricula where rdb = '".trim($_INSTIT)."' and id_ano = '$_ANO') ORDER BY nombre_alu, ape_pat, ape_mat ASC";

					 }else{		 
					 				     				  
				         $q1 = "select * from alumno where ((lower(nombre_alu) like '%$Apellido%') OR (lower(ape_pat) like '%$Apellido%') OR (lower(ape_mat) like '%$Apellido%')) AND rut_alumno in (select rut_alumno from matricula where id_curso = '".trim($cmb_curso)."' and rdb = '".trim($_INSTIT)."') ORDER BY nombre_alu, ape_pat, ape_mat ASC";
					 
					 }
					 $r1 = @pg_Exec($conn,$q1);
					 $n1 = @pg_numrows($r1);
					 					 				 
					 if ($n1==0){
					    // no hay datos que ingresar
					 }else{
					     $i = 0;
						 while ($i < $n1){
						     $f1 = pg_fetch_array($r1,$i);
							 $nombre_emp = $f1['nombre_alu'];
							 $ape_pat    = $f1['ape_pat'];
							 $ape_mat    = $f1['ape_mat'];
							 $id_usuario = $f1['id_usuario'];
							 $rut_alumno = $f1['rut_alumno'];
							 
							 						 
							 // Aqui debo consultar si tiene acceso al sistema
							 $q2 = "select * from accede where id_usuario in (select id_usuario from usuario where nombre_usuario = '".trim($rut_alumno)."') and id_perfil = '16' and estado = '1'";
							 $r2 = pg_Exec($connection,$q2);
							 $n2 = pg_numrows($r2);
							 
							 if ($n2==0){
							     //  no listo este apoderado por que no tiene acceso al sistema
							 }else{	
							    
								 // Aqui consulto si se ha selecionado que busque por un GRUPO específico
								 if ($grupos!=0){								 
								 
								     $q3 = "select * from relacion_grupo, grupos where relacion_grupo.rut_integrante = '".trim($rut_alumno)."' and relacion_grupo.id_ano = '".trim($_ANO)."' and grupos.id_grupo = '".trim($grupos)."' and grupos.rdb = '".trim($_INSTIT)."'";
								     $r3 = pg_Exec($conn,$q3);
								     $n3 = pg_numrows($r3);
									 
									 if ($n3==1){ // Muestro al alumno encontrado ya que participa del curso
									      ?>
										 <tr>
										  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
										  <td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$rut_alumno ?>"></label></div></td>
										 </tr>
										 <?
									  }	 
								   
							     }else{
							 
									 ?>
									 <tr>
									  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
									  <td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$rut_alumno ?>"></label></div></td>
									 </tr>
			
									 <?
								 }	 
							 }	 
							 $i++;
						 }
					 }
				  }
				  //// proceso para secretaria  (boris)
				  if ($perfilseleccionado==31){
				     $Apellido = strtolower($Apellido);	
					 
					 if (($grupos!=NULL)  and ($cmb_curso==0)){
					     // busco sin importar el curso
						 $q1 = "select * from alumno where ((lower(nombre_alu) like '%$Apellido%') OR (lower(ape_pat) like '%$Apellido%') OR (lower(ape_mat) like '%$Apellido%')) AND rut_alumno in (select rut_alumno from matricula where rdb = '".trim($_INSTIT)."' and id_ano = '$_ANO') ORDER BY nombre_alu, ape_pat, ape_mat ASC";

					 }else{		 
					 				     				  
				         $q1 = "select * from alumno where ((lower(nombre_alu) like '%$Apellido%') OR (lower(ape_pat) like '%$Apellido%') OR (lower(ape_mat) like '%$Apellido%')) AND rut_alumno in (select rut_alumno from matricula where id_curso = '".trim($cmb_curso)."' and rdb = '".trim($_INSTIT)."') ORDER BY nombre_alu, ape_pat, ape_mat ASC";
					 
					 }
					 $r1 = @pg_Exec($conn,$q1);
					 $n1 = @pg_numrows($r1);
					 					 				 
					 if ($n1==0){
					    // no hay datos que ingresar
					 }else{
					     $i = 0;
						 while ($i < $n1){
						     $f1 = pg_fetch_array($r1,$i);
							 $nombre_emp = $f1['nombre_alu'];
							 $ape_pat    = $f1['ape_pat'];
							 $ape_mat    = $f1['ape_mat'];
							 $id_usuario = $f1['id_usuario'];
							 $rut_alumno = $f1['rut_alumno'];
							 
							 						 
							 // Aqui debo consultar si tiene acceso al sistema
							 $q2 = "select * from accede where id_usuario in (select id_usuario from usuario where nombre_usuario = '".trim($rut_alumno)."') and id_perfil = '16' and estado = '1'";
							 $r2 = pg_Exec($conn,$q2);
							 $n2 = pg_numrows($r2);
							 
							 if ($n2==0){
							     //  no listo este apoderado por que no tiene acceso al sistema
							 }else{	
							    
								 // Aqui consulto si se ha selecionado que busque por un GRUPO específico
								 if ($grupos!=0){								 
								 
								    $q3 = "select * from relacion_grupo, grupos where relacion_grupo.rut_integrante = '".trim($rut_alumno)."' and relacion_grupo.id_ano = '".trim($_ANO)."' and grupos.id_grupo = '".trim($grupos)."' and grupos.rdb = '".trim($_INSTIT)."'";
								     $r3 = pg_Exec($conn,$q3);
								     $n3 = pg_numrows($r3);
									 
									 if ($n3==1){ // Muestro al alumno encontrado ya que participa del curso
									      ?>
										 <tr>
										  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
										  <td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$rut_alumno ?>"></label></div></td>
										 </tr>
										 <?
									  }	 
								   
							     }else{
							 
									 ?>
									 <tr>
									  <td class="cuadro02"><? echo "$nombre_emp $ape_pat $ape_mat"; ?></td>
									  <td class="cuadro02"><div align="center"><label><input name="id_usuario<?=$i + 1 ?>" type="checkbox" id="id_usuario<?=$i + 1 ?>" value="<?=$rut_alumno ?>"></label></div></td>
									 </tr>
			
									 <?
								 }	 
							 }	 
							 $i++;
						 }
					 }
				  }
				  
				  
				?> 
			 <tr>
				 <td align="right"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>TODOS</strong></font></td>
		         <td align="center"><input type="checkbox" name="checkbox11" value="checkbox" onClick="ChequearTodos(this);"></td>
			 </tr>								 			
              </table></td>
            </tr>						
          </table>		  
		  <input name="llave" type="hidden" id="llave" value="2">
		  <input name="Apellido" type="hidden" id="Apellido" value="<?=$Apellido ?>">
		  <input name="encontrados" type="hidden" id="encontrados" value="<?=$n1 ?>">
		  <input name="perfilseleccionado" type="hidden" id="perfilseleccionado" value="<?=$perfilseleccionado ?>">
		  <br>
		  <br>
		  
		      <label>
		         <input name="guardar" type="button" id="guardar" value="GUARDAR DESTINATARIOS SELECCIONADOS" onClick="envia(); ">
		      </label>
	    
		 </form>
		 
		  
		  <!-- fin de las opciones según perfil -->		  
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
