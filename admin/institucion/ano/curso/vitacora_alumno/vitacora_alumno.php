<?php 

require('../../../../../util/header.inc');
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');
require('../../../../../util/funciones_new.php'); 

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO; 
	$frmModo		=$_FRMMODO;
	$empleado		=$_EMPLEADO;
    $_POSP = 5;
	$_bot           =5;
	$_MDINAMICO     = 1;


		// REGISTRO DE HISTORIAL DE NAVEGACION
	registrarnavegacion($_USUARIO,'LISTADO DE ALUMNOS',1,0,$_SERVER[REMOTE_ADDR],pg_dbname($conn),ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),$_INSTIT,$_NOMBREUSUARIO,$_CURSO,$conn);
	//******************************************************//
		

		if(($frmModo=="ingresar")or($frmModo==""))
		{
			$frmModo = "mostrar";
		}
	
		
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=25)&&($_PERFIL!=20)&&($_PERFIL!=28)&&($_PERFIL!=21)){$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=25)&&($_PERFIL!=2)&&($_PERFIL!=32)&&($_PERFIL!=19)&&($_PERFIL!=31)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=28)&&($_PERFIL!=8)&&($_PERFIL!=2)&&($_PERFIL!=35)&&($_PERFIL!=29)&&($_PERFIL!=1)){$whe_perfil_curso=" and curso.id_curso=$curso";}	
		
			
	if (trim($_url)=="") $_url=0;
	
	
/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
			$_ITEM =$item;
			session_register('_ITEM');
		}
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}


        function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="../seteaCurso.php3?caso=50&curso="+curso2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
		 function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../../seteaAno.php3?caso=50&pa=1&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }

//-->
</script>		

<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
	


<?php if($frmModo=="modificar"){?>
		<SCRIPT language="JavaScript">
			function valida(form){
				if( !nroOnly(form.txtNro_Lista,'Se permiten sólo números en el Número de Lista.') || !chkVacio(form.txtNro_Lista,'Se permite que este vacio el campo')  ){
					return false;
				};
				return true;
			}
		</SCRIPT>
<?php }?>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="" align="left" valign="top"> 
                        <? $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="" valign="top">
								  <!--inicio codigo nuevo -->
								  
								  
							<table width="" height="30" border="0" cellpadding="0" cellspacing="0">
                              <tr> 
                                 <td height="30" align="center" valign="top">								  
                                    <?php if(($_PERFIL!=15)and ($_PERFIL!=16)and ($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>
                                    
	                               <?php } ?>
	                                </td>
                              </tr>
                            </table>
								  
								  
								  
								  
 
	<?php //echo tope("../../../../../util/");?>
	<center>
  <table width="650" border="0" cellspacing="1" cellpadding="3">
    <tr height=15> 
      <td colspan=6> <table border=0 cellspacing=1 cellpadding=1>
          <tr valign="top"> 
            <td align=left class="textonegrita"> AÑO ESCOLAR </td>
            <td> <font face="arial, geneva, helvetica" size=2> <strong>:</strong> </font> </td>
            <td> 
                <?php				
											
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion." $whe_perfil_ano ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						if (!$filann){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							//exit();
						}
					} ?>
					<form name="form"   action="" method="post">
		    	    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
						<select name="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
                           <option value=0 selected>(Seleccione un Año)</option> <?
						   for($i=0;$i < @pg_numrows($result);$i++){
						      $filann = @pg_fetch_array($result,$i); 
							  $id_ano  = $filann['id_ano'];  
   		                      $nro_ano = $filann['nro_ano'];
							  $situacion = $filann['situacion'];
							  if ($situacion == 0){
							     $estado = "Cerrado";
							  }
							  if ($situacion == 1){
							     $estado = "Abierto";
							  }	 	 
			                  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
		                          echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
                              }
							} ?>
							</select>
					</form>
				<? }	?>               </td>
          </tr>
          <tr valign="top"> 
            <td height="35" align=left class="textonegrita">  CURSO               </td>
            <td> <font face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </font> </td>
          <form name="form"   action="" method="post">
		    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
		  
		     <td> <font face="arial, geneva, helvetica" size=2> <strong> 
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
 $sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  
FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo 
WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso
ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		        {  
		        $fila = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		        
		        if (($fila['id_curso'] == $cmb_curso) or ($fila['id_curso'] == $curso)){
		           echo "<option value=".$fila['id_curso']." selected>".$Curso_pal." </option>";
		        }else{	    
		           echo "<option value=".$fila['id_curso'].">".$Curso_pal." </option>";
                }
		     } ?>
          </select> 
		  	  
		 
			    </strong> </font> </td></form>  
          </tr>
          <tr valign="top">
            <td height="30" align=left class="textonegrita">PROFESOR JEFE </td>
            <td valign="top"><font face="arial, geneva, helvetica" size=2> <strong> : </strong></font></td>
            <td valign="top"><font face="arial, geneva, helvetica" size=2> <strong>
			
			<?
				$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
				$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
				$result =@pg_Exec($conn,$sql4);
				if (!$result) 
				{
					//error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
				}
				else
				{
					if (pg_numrows($result)!=0)
					{
						$fila = @pg_fetch_array($result,0);	
						if (!$fila)
						{
							//error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							//exit();
						}
					}
				}
				
				echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
				//$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
				
				?>
			
			
			
			</strong>
			</font></td>
          </tr>
        </table></td>
    </tr>
	 <FORM method=post name="form1" action="<? if ($om==1){ ?>GuardaMatricula.php     <? }else{ ?> GuardaLista.php <? } ?>">
    <tr> 
      <td colspan=6 align=right> 
        <!--<input name="button" type="button" onClick=document.location="situacionFinal.php3?caso=1" value="SITUACION FINAL ALUMNOS"> -->
        <!--AGREGAR UN ALUMNO, OSEA INSCRIBIRLO EN UN CURSO SE REALIZA AL MOMENTO DE MATRICULARLO-->
      <?
	  if ($curso != NULL){ ?>
	  
	  
	    <?php if ($frmModo=="mostrar") { ?>
				<?php if($modifica==1 || $ingreso==1) { ?>
					
				
				<?php /*if ($_PERFIL==17 && $institucion==9071 or $institucion==1756 and $om!= 1) { ?>
								<input name="buttonX" type="button" class="botonXX" onclick=document.location="seteaAlumno.php3?caso=6"  value="ORDENAR LISTA"> 
				<?php }*/
					
					}
				} ?>
		
      
		
      <? } ?>      </td>
    </tr>
	
	<? if ($curso != NULL){
	   ?>
	
    <tr height="20"> 
      <td align="middle" colspan="7" class="tableindex"> Total de Alumnos = <b>
        <?php
											$qry="SELECT COUNT(*) AS SUMA FROM MATRICULA WHERE ID_ANO=(".$ano.")  AND ID_CURSO=(".$curso.")";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>'.$qry);
											}else{
												if (pg_numrows($result)!=0){
													$fila7 = @pg_fetch_array($result,0);	
													if (!$fila7){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														//exit();
													}
													echo trim($fila7['suma']);
												}
											}
										?>
        </b> 
		
		&nbsp; &nbsp;
		(H: <?
		    $qry="SELECT COUNT(*) AS SUMA FROM MATRICULA INNER JOIN ALUMNO ON MATRICULA.rut_alumno = ALUMNO.rut_alumno WHERE (MATRICULA.ID_ANO=(".$ano.")  AND MATRICULA.ID_CURSO=(".$curso.") AND SEXO = '2')";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila5 = @pg_fetch_array($result,0);	
													if (!$fila5){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														//exit();
													}
													echo trim($fila5['suma']);
													$totalhombres = $fila5['suma'];
												}
											} ?> 
											
		&nbsp; &nbsp;
		
		M: <?
		     	$qry="SELECT COUNT(*) AS SUMA FROM MATRICULA INNER JOIN ALUMNO ON MATRICULA.rut_alumno = ALUMNO.rut_alumno WHERE (MATRICULA.ID_ANO=(".$ano.")  AND MATRICULA.ID_CURSO=(".$curso.") AND SEXO = '1')";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila5 = @pg_fetch_array($result,0);	
													if (!$fila5){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														//exit();
													}
													echo trim($fila5['suma']);
													$totalmujeres = $fila5['suma'];
												}
											} ?>)		
		&nbsp; &nbsp;
		
		Matrícula Real: (
		<?php
			$qry="SELECT COUNT(*) AS SUMA FROM MATRICULA WHERE ID_ANO=(".$ano.")  AND ID_CURSO=(".$curso.") AND bool_ar = '0'";
			$result =@pg_Exec($conn,$qry);
			if (!$result) {
				error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>'.$qry);
			}else{
				if (pg_numrows($result)!=0){
					$fila7 = @pg_fetch_array($result,0);	
					if (!$fila7){
						error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
						//exit();
					}
					echo trim($fila7['suma']);
				}
			}
		?>)		</td>
    </tr>
    <tr > 
	<script language="javascript" type="text/javascript">
		function coloca_lista(){
			alert ('si los registros ya tienen numero de lista ,se volveran a enumerar');
			largo=document.form1.elements.length;
			//alert (largo);
			cont=1;
			for (i=0;i<largo;i++){
				if (document.form1.elements[i].type=="text"){
					document.form1.elements[i].value=cont;
				cont=cont +1;
				}
			}
		}
	</script>
      <?php if(($_PERFIL!=16)and($_PERFIL!=15) or ($institucion != "12838")){	?> 
      
		<?	if($_PERFIL!=15 and $institucion != "12838" and $_PERFIL!=16){	?>
 	 	<td align="center" width="75" class="tabla01"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
        	<strong>RUT</strong> </font>		</td>
		<?	}	?>
		
		<? //	if($_PERFIL!=15 and $institucion != "12838" and $_PERFIL!=16){	?>
 	 	
		
		
		
      <?php } ?>
      <td align="center" width="224" class="tabla01"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
        <strong>NOMBRE</strong> </font> </td>
      
	  <? if ($_PERFIL!=16 and $_PERFIL!=15){  // no muestro para alumno y apoderado ?>
	  	     <td align="center" width="179" class="tabla01"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
             <strong>DIRECCION</strong> </font> </td>
	 <? } ?>	
		
	  <? if ((trim($_PERFIL)!="16") && (trim($_PERFIL)!="15")){  // no muestro para alumno y apoderado ?>	
             <td align="center" width="73" class="tabla01"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
             <strong>TELEFONO</strong> </font> </td>
     <? } ?>
	</tr>
    <?php
//				$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat,alumno.telefono, alumno.calle, alumno.nro, alumno.depto, alumno.region, alumno.ciudad, alumno.comuna, matricula.id_curso, matricula.nro_lista FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) order by ape_pat, ape_mat, nombre_alu asc ";
				if (($_INSTIT!=1653) AND ($_INSTIT!=1579) AND ($_INSTIT!=770)){
				     
					 $qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat,alumno.telefono, alumno.calle, alumno.nro, alumno.depto, alumno.region, alumno.ciudad, alumno.comuna, matricula.id_curso, matricula.nro_lista, matricula.bool_ar, matricula.num_mat FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) AND nro_lista is not NULL order by nro_lista asc, ape_pat, ape_mat, nombre_alu ";}
				else {
				     
				    $qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat,alumno.telefono, alumno.calle, alumno.nro, alumno.depto, alumno.region, alumno.ciudad, alumno.comuna, matricula.id_curso, matricula.nro_lista, matricula.bool_ar, matricula.num_mat FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) AND nro_lista is not NULL order by ape_pat, ape_mat, nombre_alu ";}
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
				}else{
				if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
					$fila = @pg_fetch_array($result,0);	
					if (!$fila){
						error('<B> ERROR :</b>Error al acceder a la BD. (8) No hay alumnos inscritos en este curso</B>');
						//exit();
					}
				}
				
			
			?>
            
						
			<?php
						
			$total = @pg_numrows($result);
						
			for($i=0 ; $i < @pg_numrows($result) ; $i++){
				$fila = @pg_fetch_array($result,$i);
			?>
			<?php if(($_PERFIL!=15)and($_PERFIL!=16)) { ?>
					<?	if($frmModo=="mostrar"){
					        if ($fila['bool_ar'] == 1){
							     ?>				           	
					            <tr bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='ffffff'  <? if ($om !=1) {?> onClick=go('setea_vitacoraalumno.php?alumno=<?php echo trim($fila["rut_alumno"]);?>&_url=<?php echo $_url ?>&caso=1') <? } ?>>             <?
						   }else{
							     ?>				           	
					             <tr bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='ffffff'  <? if ($om !=1) {?> onClick=go('setea_vitacoraalumno.php?alumno=<?php echo trim($fila["rut_alumno"]);?>&_url=<?php echo $_url ?>&caso=1') <? } ?>>               <?
							} 		 
							   				
								
						}	?>
			  <?php }
			  		else{ ?>
			<tr> 
			  <?php } ?>
			  <?php if(($_PERFIL!=16)and($_PERFIL!=15) or ($institucion != "12838")){	
			  ?>
						
						
					<?	if(($_PERFIL!=15)AND($institucion != "12838")AND($_PERFIL!=16)){	?>	
						  <td align="left" class="textosimple" > <font face="arial, geneva, helvetica" size="1" color="#000000"> 
							<strong>&nbsp;<?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></strong> 
							</font> </td>
					<?	}	?>					
					
			  <?php } ?>		
			  
				 
			    
			  
			
				  <td align="left" <? if ($fila['bool_ar'] == 1){?>class="tachado"<? }else{?>class="textosimple"<? }?>> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
					<strong><?php echo $fila["ape_pat"]." ".$fila["ape_mat"].", ".$fila["nombre_alu"].$fila5["sexo"];?></strong> 
					</font> </td>
					<? $qryC="select nom_com from comuna where cod_reg= ".$fila["region"]." and cor_pro=".$fila["ciudad"]." and cor_com=".$fila["comuna"];
						$resultC=@pg_Exec($conn,$qryC);
					/*	 if (!$resultC) {
								error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
								exit();
						   }*/
						   $filaC= @pg_fetch_array($resultC,0);
					 ?>
					 
					 <? if ((trim($_PERFIL)!="16") && (trim($_PERFIL)!="15")){  // no muestro para alumno y apoderado ?>
					 		<td align="left" <? if ($fila['bool_ar'] == 1){?>class="tachado"<? }else{?>class="textosimple"<? }?> > <font face="arial, geneva, helvetica" size="1" color="#000000"> 
							<strong><? 
									if($fila1['depto']!=""){
										  echo strtoupper(trim($fila['calle']) . " " . trim($fila['nro']) . " depto" . " ".  trim($fila['depto']) . " ". trim($fila['nom_com']));
									}
									else{
										  echo strtoupper(trim($fila['calle']) . " " . trim($fila['nro']) . " ". trim($fila['nom_com']));
									}
										  ?></strong> 
							</font></td>
					        <? } ?>		
					
					
					<? if ((trim($_PERFIL)!="16") && (trim($_PERFIL)!="15")){  // no muestro para alumno y apoderado ?>					
					      <td align="left" <? if ($fila['bool_ar'] == 1){?>class="tachado"<? }else{?>class="textosimple"<? }?> > <font face="arial, geneva, helvetica" size="1" color="#000000"> 
				         	<strong><?php echo $fila["telefono"];?></strong> 
					      </font> </td>
				    <? } ?>		  
				</tr>
    <?php
					}
					
				} 
			$total3= $i;

				// fin FOR 
//*************************************

				$qry2="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat,alumno.telefono, alumno.calle, alumno.nro, alumno.depto, alumno.region, alumno.ciudad, alumno.comuna, matricula.id_curso, matricula.nro_lista, matricula.bool_ar, matricula.num_mat FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) AND nro_lista is NULL order by ape_pat, ape_mat, nombre_alu asc ";
				$result2 =@pg_Exec($conn,$qry2);
				if (!$result2) {
					error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
				}else{
				if (pg_numrows($result2)!=0){//En caso de estar el arreglo vacio.
					$fila = @pg_fetch_array($result2,0);	
					if (!$fila){
						error('<B> ERROR :</b>Error al acceder a la BD. (8) No hay alumnos inscritos en este curso</B>');
						//exit();
					}
				}
			?>
    <?php	echo "<input type='hidden' name='total3' value='".$total3."'>";
			$total2=@pg_numrows($result2);
			for($i=0 ; $i < @pg_numrows($result2) ; $i++){
				$j=$total+$i;
				$fila = @pg_fetch_array($result2,$i);
			?>
			<?php if(($_PERFIL!=15)and($_PERFIL!=16)) { ?>
					<?	if($frmModo=="mostrar"){	
					
					        if ($fila['bool_ar'] == 1){
							   ?>
							   
						       <tr bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='ffffff' onClick=go('setea_vitacoraalumno.php?alumno=<?php echo trim($fila["rut_alumno"]);?>&_url=<?php echo $_url ?>&caso=1')>             <?
							}else{
							
							   if ($om!=1){  ?>	  
							  <tr bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='ffffff' onClick=go('setea_vitacoraalumno.php?alumno=<?php echo trim($fila["rut_alumno"]);?>&_url=<?php echo $_url ?>&caso=1')>     <?
							}
						}	   
							   
						}	?>
				
			  <?php }
			  		else{ ?>
			<tr> 
			  <?php } ?>
			  
			  
			  
			  
			  
			  <?php if($_PERFIL!=16) { ?>
			  
						
 						   <?
						   if (($_PERFIL!=16) and ($_PERFIL!=15) and ($_INSTIT!=12838)){ ?>						   	
					     	  <td align="left" class="textosimple" > <font face="arial, geneva, helvetica" size="1" color="#000000"> 
							<strong><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></strong> 
							</font> </td>
						<? } ?>	
						
						
							
			             
			             <?php 
			  } ?>
			  
			  
			  
			  
			  
				  <td align="left"<? if ($fila['bool_ar'] == 1){?>class="tachado"<? }else{?>class="textosimple"<? }?>> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
					<strong><?php echo $fila["ape_pat"]." ".$fila["ape_mat"].", ".$fila["nombre_alu"];?></strong> 
					</font> </td>
					<? $qryC="select nom_com from comuna where cod_reg= ".$fila["region"]." and cor_pro=".$fila["ciudad"]." and cor_com=".$fila["comuna"];
						$resultC=@pg_Exec($conn,$qryC);
					/*	 if (!$resultC) {
								error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
								exit();
						   }*/
						   $filaC= @pg_fetch_array($resultC,0);
					 ?>
					 
					 <? if ((trim($_PERFIL)!="16") && (trim($_PERFIL)!="15")){  // no muestro para alumno y apoderado ?>					 
					 
							<td align="left" <? if ($fila['bool_ar'] == 1){?>class="tachado"<? }else{?>class="textosimple"<? }?> > <font face="arial, geneva, helvetica" size="1" color="#000000"> 
							<strong><? 
									if($fila1['depto']!=""){
										  echo strtoupper(trim($fila['calle']) . " " . trim($fila['nro']) . " depto" . " ".  trim($fila['depto']) . " ". trim($fila['nom_com']));
									}
									else{
										  echo strtoupper(trim($fila['calle']) . " " . trim($fila['nro']) . " ". trim($fila['nom_com']));
									}
										  ?></strong> 
							</font></td>
					        <? } ?>		
					
					
					<? if ((trim($_PERFIL)!="16") && (trim($_PERFIL)!="15")){  // no muestro para alumno y apoderado ?>
					      <td align="left" <? if ($fila['bool_ar'] == 1){?>class="tachado"<? }else{?>class="textosimple"<? }?> > <font face="arial, geneva, helvetica" size="1" color="#000000"> 
					      <strong><?php echo $fila["telefono"];?></strong> 
					      </font> </td>
				    <? } ?>		  
				</tr>
    <?php			
			 $total3= $j;
					} 
				}// fin FOR
//**************************
				
			?>
			<input type="hidden" name="total3" value="<?=$total3?>">
    <tr> 
      <td colspan="6"> <hr width="100%" color="#003b85"> </td>
    </tr>
    <?php if(($_PERFIL!=15)and($_PERFIL!=16)) { ?>
    <tr> 
      <td align="left" colspan="6"> <font face="arial, geneva, helvetica" size="1" color="#666666"> 
        <strong>ALUMNOS DE SEXO MASCULINO = <?=$totalhombres ?> <b> 
        </b></strong> </font> </td>
    </tr>
    <tr> 
      <td align="left" colspan="6"> <font face="arial, geneva, helvetica" size="1" color="#666666"> 
        <strong>ALUMNOS DE SEXO FEMENINO = <?=$totalmujeres ?> <b> 
        </b></strong> </font> </td>
    </tr>
    <tr> 
      <td align="left" colspan="6"> <font face="arial, geneva, helvetica" size="1" color="#666666"> 
        <strong>ALUMNAS EMBARAZADAS = <b> 
        <?php
				 
											$qry="SELECT COUNT(*) AS SUMA FROM MATRICULA INNER JOIN ALUMNO ON MATRICULA.rut_alumno = ALUMNO.rut_alumno WHERE (MATRICULA.ID_ANO=(".$ano.")  AND MATRICULA.ID_CURSO=(".$curso.") AND matricula.bool_ae = '1')";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila5 = @pg_fetch_array($result,0);	
													if (!$fila5){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														//exit();
													}
													echo trim($fila5['suma']);
												}
											}
										?>
        </b></strong> </font> </td>
    </tr>
    <td align="left" colspan="6"> <font face="arial, geneva, helvetica" size="1" color="#666666"> 
      <strong>ALUMNOS DE ORIGEN INDIGENA DE SEXO MASCULINO= <b> 
      <?php
											$qry="SELECT COUNT(*) AS SUMA FROM MATRICULA INNER JOIN ALUMNO ON MATRICULA.rut_alumno = ALUMNO.rut_alumno WHERE (MATRICULA.ID_ANO=(".$ano.")  AND MATRICULA.ID_CURSO=(".$curso.") AND matricula.bool_aoi= '1' AND SEXO='2')";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila5 = @pg_fetch_array($result,0);	
													if (!$fila5){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														//exit();
													}
													echo trim($fila5['suma']);
												}
											}
										?>
      </b></strong> </font> </td>
    </tr>
    <td align="left" colspan="6"> <font face="arial, geneva, helvetica" size="1" color="#666666"> 
      <strong>ALUMNOS DE ORIGEN INDIGENA DE SEXO FEMENINO= <b> 
      <?php
											$qry="SELECT COUNT(*) AS SUMA FROM MATRICULA INNER JOIN ALUMNO ON MATRICULA.rut_alumno = ALUMNO.rut_alumno WHERE (MATRICULA.ID_ANO=(".$ano.")  AND MATRICULA.ID_CURSO=(".$curso.") AND matricula.bool_aoi= '1' AND SEXO='1')";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila5 = @pg_fetch_array($result,0);	
													if (!$fila5){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														//exit();
													}
													echo trim($fila5['suma']);
												}
											}
										?>
      </b></strong> </font> </td>
    </tr>
    
    <?php } ?>
  </table>
</center>
</FORM> 
	<?
	}else{
	     ?>
		 </td>
		 </tr>
		 </table>
	     <?
    } ?>		 							  
								  
								  <!-- fin codigo nuevo --></td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr>
                            <td height="" align="left" valign="top">&nbsp;</td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"> <? include("../../../../../cabecera/menu_inferior.php") ;?> </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<? pg_close($conn); ?>
</body>
</html>
