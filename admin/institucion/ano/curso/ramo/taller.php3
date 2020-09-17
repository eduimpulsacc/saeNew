<?php require('../../../../../util/header.inc');
       require('../../../../../util/LlenarCombo.php3');
	    require('../../../../../util/SeleccionaCombo.inc');?>
<?php 
if ($id_ano){

$_ANO=$id_ano;
	if(!session_is_registered('_ANO')){
		session_register('_ANO');
	};

}
if ($id_curso){

$_CURSO=$id_curso;
	if(!session_is_registered('_CURSO')){
		session_register('_CURSO');
	};

}
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
//	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$taller			=$_TALLER;
	$plan			=$_PLAN;
	$docente		=5; //Codigo Docente
	$_POSP          =5;
	$_bot           =5;

	
	if (($_PERFIL!=0)&&($_PERFIL!=14)){$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=14 && $_PERFIL!=17)){$whe_perfil_curso=" and curso.id_curso=$curso";}	


	
	$sql_prof_jefe = "SELECT * FROM supervisa WHERE rut_emp=".$_NOMBREUSUARIO." AND id_curso=".$curso;	
	$Rs_prof = @pg_exec($conn,$sql_prof_jefe);

?>
<?php $qryIns="select tipo_instit from institucion where rdb=".$institucion;
		 $resultIns = @pg_exec($conn,$qryIns);
		  $filaIns	= @pg_fetch_array($resultIns,0);
		    $Tipo_Ins = $filaIns['tipo_instit'];
	?>						

<SCRIPT language="JavaScript">
			/*function enviapag(form){
			if (form.cmbSEC.value!=0){
				form.cmbSEC.target="self";
				form.action = 'ramo.php3?institucion=$institucion&$frmModo=ingresar';
				form.submit(true);
				}	
			}*/

			
			function ChequearTodos(chkbox)
			{
				for (var i=0;i < document.forms[0].elements.length;i++)
				{
					var elemento = document.forms[0].elements[i];
					if (elemento.type == "checkbox")
					{
						elemento.checked = chkbox.checked
					}
				}
			}

			
			function ocultaText(form)
			{
					form.txtPCT.disabled = true
					form.txtPCT.value = ""
					form.txtNEXIM.disabled = true
					form.txtNEXIM.value = ""
			}
			
			function muestraText(form)
			{
					form.txtPCT.disabled = false
					form.txtNEXIM.disabled = false
			}
				
			function mText(form)
			{
					form.cmbSUB.disabled = false;
					if(form.cmbSECDIF){
						form.cmbSECDIF.disabled = false;
					}
					form.codSub.disabled = true;
					form.codSub.value = "";
					form.codRes.disabled = true;
					form.codRes.value = "";
					form.txtFecha.disabled = true;
					form.txtFecha.value = "";
			}
				
			function mtaText(form)
			{
					form.codSub.disabled = false;
					form.codRes.disabled = false;
					form.txtFecha.disabled = false;
					form.cmbSUB.disabled = true;
					form.cmbSUB.value = "";
					if(form.cmbSECDIF){
						form.cmbSECDIF.disabled = true;
						form.cmbSECDIF.value = "";
					}
			}	
			
			function ChequearTodos2(){
				var allInputs = document.getElementsByClassName("agr");
for (var i = 0, max = allInputs.length; i < max; i++){
    if (allInputs[i].type === 'checkbox')
        allInputs[i].checked = true;
}
				}				
</SCRIPT>


<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM taller WHERE (((taller.id_taller)=".$taller."))";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
				$modo_eval_=$fila['modo_eval'];
			}
		}
	}

	switch ($fila['modo_eval']) {
		 case 0:
			$_MODOEVAL	=	0;
			if(!session_is_registered('_MODOEVAL')){
				session_register('_MODOEVAL');
			};
			 break;
		 case 1:
			$_MODOEVAL	=	1;
			if(!session_is_registered('_MODOEVAL')){
				session_register('_MODOEVAL');
			};
			 break;
		 case 2:
			$_MODOEVAL	=	2;
			if(!session_is_registered('_MODOEVAL')){
				session_register('_MODOEVAL');
			};
			 break;
	 };

//var_dump($_SESSION);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
//-->

       function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="taller.php3?id_curso="+curso2+"&frm_modo=<? echo $frmModo;?>";
				window.location=pag;
//				form.action = pag;
//				form.submit(true);	
			}		
		 }


      function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
		
				//pag="../../seteaAno.php3?caso=11&pa=12&ano="+ano2+"&frmModo="+frmModo
				pag="taller.php3?id_ano="+ano2+"&frm_modo=<? echo $frmModo;?>";
				window.location=pag;
/*				form.action = pag;
				alert (form.action);
				form.method = "GET";
				form.submit();*/
			}		
		 }

</script>
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
	<?php if($Tipo_Ins==1){//COLEGIO ?>
	<!--AQUI DETERMINAR SI EL CURSO ES KINDER O OTRO DE LOS CABROS CHICOS-->
		<?php if(($frmModo=="ingresar") or ($frmModo=="modificar")){ ?>
				<SCRIPT language="JavaScript">
					function valida(form){
					<? if ($frmModo=="ingresar"){?>
							if (form.NomTall.value==""){
								alert ('ingrese el nombre del taller');
								return false;
							}
						<? }?>
					

						if(!chkSelect(form.cmbMODO,'Seleccionar MODO DE EVALUACION.')){
							return false;
						};

						
						if(!chkSelect(form.cmbDOC,'Seleccionar DOCENTE a Cargo.')){
							return false;
						};
						
						if(form.cmbDOCIMP.value==form.cmbDOC.value){
							alert("Seleccione un Docente Diferente o deje el Campo 'Que imparte' en blanco");
							form.cmbDOCIMP.value=0;
							return false;
						};
						
						//if (form.txtNEXIM.disabled.value!=""){
						/*if(!notaNroOnly(form.txtNEXIM,'Nota inválida.')){
							return false;
						};*/
						//}
						return true;
					}
				</SCRIPT>
		<?php }else{?>
				<SCRIPT language="JavaScript">
					function valida(form){
						if(!chkSelect(form.cmbMODO,'Seleccionar MODO DE EVALUACION.')){
							return false;
						};

						if(!chkSelect(form.cmbDOC,'Seleccionar DOCENTE a Cargo.')){
							return false;
						};
												
						if(!notaNroOnly(form.txtNEXIM,'Nota inválida.')){
							return false;
						};
						
						return true;
					}
				</SCRIPT>
		<?php }?>
	<?php }?>
	<?php if(($Tipo_Ins==2)||($Tipo_Ins==3)){//JARDIN O SALACUNA ?>
			<SCRIPT language="JavaScript">
				function valida(form){
					if(!chkSelect(form.cmbMODO,'Seleccionar MODO DE EVALUACION.')){
						return false;
					};

					if(!chkSelect(form.cmbDOC,'Seleccionar DOCENTE.')){
						return false;
					};

					return true;
				}
			</SCRIPT>
	<?php }?>
<?php }?>
	
</head>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
	<FORM method=post name="frm" action="procesoTaller.php3">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? 
						$menu_lateral="3_1";
						include ("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top">
					  
					  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td ><!-- inicio -->
								  

	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=ano value=".$ano.">";
		echo "<input type=hidden name=curso value=".$curso.">";
		
		$qryVrfyPropio="select * from plan_estudio where cod_decreto=".$_PLAN;
		$resultVrfy=@pg_Exec($conn,$qryVrfyPropio);
		$filaVrfy=@pg_fetch_array($resultVrfy,0);
	?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
<!--					<form>-->
							<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO ESCOLAR</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
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
							exit();
						}
					} ?>

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
				<? }	?>
									</strong>								</FONT>							</TD> 
						</TR><TR>
							<TD align=left>
							<?php if (($frmModo=="mostrar") or ($frmModo=="modificar")){ ?>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>TALLER</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>
							<?php }?>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											//$qry="SELECT subsector.nombre, ramo.sub_obli, ramo.sub_elect, ramo.bool_ip, ramo.bool_sar FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
											$qry="SELECT * FROM taller  WHERE (((taller.id_taller)=".$taller."))";
											$result =@pg_Exec($conn,$qry);
											if (@pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												echo trim($fila1['nombre_taller']);
											}
										?>
									</strong>								</FONT>							</TD>
						</TR>
<?     if($frmModo!="ingresar"){ 	?>
						
						<tr> 
            <td align=left> <font face="arial, geneva, helvetica" size=2> <strong>CURSO</strong> 
              </font> </td>
            <td> <font face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </font> </td>
    
		    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
		  
		     <td  valign="bottom"> <font face="arial, geneva, helvetica" size=2> <strong> 
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
					 
					$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
					$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
					$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano."))$whe_perfil_curso  ";
					$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
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
					   echo "<option value=".$fila['id_curso']." selected>".$Curso_pal."</option>";
					}else{	    
					   echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
					}
				 } ?>
			  </select> 
		  	  
			    </strong> </font> </td>
          </tr>
<?				}	?>
					<!--</form>	-->
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
				<!--	<FORM method=post name="frm" action="procesoTaller.php3">-->
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
          <TR height="50" > 
            <TD align=right colspan=2> 
              <?php if($frmModo=="ingresar"){ ?>
              <INPUT class="botonXX"  TYPE="submit" value="GUARDAR" name=btnGuardar onClick="return valida(this.form);" > 
              &nbsp; <INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarTalleres.php3?plan=<?php echo $plan ?>"> 
              &nbsp; 
              <?php };?>
              <?php if($frmModo=="mostrar"){ ?>
              <?php if($_PERFIL==17){ ?>
  <!--INPUT class="botonXX"  TYPE="button" value="INICIO" onClick=parent.location.href="../../../../../fichas/docente/index.html"--> 
              <?php }?>
              <?php if($_PERFIL!=17){?>
              <?php if(($_PERFIL!=2)&&($_PERFIL!=20)&&($_PERFIL!=4)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){ //ACADEMICO Y LEGAL?>
              <?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
              <INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaTaller.php3?taller=<?php echo $taller?>&caso=3"> 
              &nbsp; <INPUT class="botonXX"  TYPE="button" value="ELIMINAR" name=btnEliminar onClick=document.location="seteaTaller.php3?caso=9;"> 
 &nbsp; <INPUT class="botonXX"  TYPE="button" value="VOLVER" name=btnEliminar onClick=document.location="listarTalleres.php3?menu=6&categoria=3&item=4&nw=1;">              
              &nbsp; 
              <?php }?>
              <?php }?>
<!--              <INPUT class="botonXX"  TYPE="button" value="LISTADO" onClick=document.location="listarTalleres.php3?plan=<?php //echo $plan ?>"> -->
              &nbsp; 
              <?php }?>
              <?php //if($_TIPODOCENTE==1){
					if(@pg_numrows($Rs_prof)>=1 && $curso!=0 && $curso!=NULL){		  
			  ?>
              <INPUT class="botonXX"  TYPE="button" value="LISTADO" onClick=document.location="listarTalleres.php3?plan=<?php //echo $plan ?>">
              &nbsp; 
              <?php }?>
              <?php };?>
              <?php if($frmModo=="modificar"){ ?>
              <INPUT class="botonXX"  TYPE="submit" value="GUARDAR" name=btnGuardar onClick="return valida(this.form);" > 
              &nbsp; <INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaTaller.php3?taller=<?php echo $taller?>&caso=1&plan=<?php echo $plan ?>"> 
              &nbsp; 
              <?php };?>
              <?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){ //ACADEMICO Y LEGAL?>
              <?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
			  	</TD>
			  </TR>
			  <tr class="textosesion">
			  	<td colspan="2" >
				<?php if($frmModo!="ingresar"){ ?>
				*ANTES DE ELIMINAR UN TALLER. DEBE ELIMINAR TODOS LOS HORARIOS QUE ÉSTE TENGA ASOCIADO 
			  <?	}	}
				}	?>
            </TD>
          </TR>
          <TR height=20> 
            <TD align=middle colspan=2 class="tableindex"> Taller</TD>
          </TR>
          <?php if($Tipo_Ins==1){//COLEGIO
				 ?>
          <?php if (($fila3['cod_tipo']==110) or ($fila3['cod_tipo']==310) or ($fila3['cod_tipo']==410) or($fila3['cod_tipo']==510) or ($fila3['cod_tipo']==610) or ($fila3['cod_tipo']==710) or ($fila3['cod_tipo']==810)){?>
          <?php  } ?>
          <?php
					//TIPO DE ENSEÑANZA AL QUE CORRESPONDE
					$qry="SELECT curso.id_curso, tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
					$result =@pg_Exec($conn,$qry);
					$fila4= @pg_fetch_array($result,0);
					?>
					
          <?php 
		 
		  if($filaVrfy['rdb']==0){ ?>
          <TR> 
            <TD width=6></TD>
            <TD width="571"> <table border=0 cellspacing=2 cellpadding=2>
                <tr> 
                  <td width="542"> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>NOMBRE DE TALLER :</strong> </font> </td>
                  <?php //if ((($fila3['grado_curso']==3) or ($fila3['grado_curso']==4)) and ($fila3['cod_tipo']==310) and ($frmModo=="ingresar")and ($filaVrfy['rdb']==0)) { ?>
                </tr>
                <tr> 
                  <td height="25"><FONT face="arial, geneva, helvetica" size=2><strong>
				   <?php 
												if(($frmModo=="mostrar")||($frmModo=="modificar")){ 
													imp($fila1['nombre_taller']);
												};
											?>
						 <?php 
												if($frmModo=="ingresar"){  ?>					 
                    <input name="NomTall" type="text" maxlength="450" width="450"> 
					 <?php } ?>
                     </strong></font> 
                  </td>
                </tr>
              </table></TD>
          </TR>
          <?php  }?>
		  
          <?php// if ((($fila3['grado_curso']==3) or ($fila3['grado_curso']==4)) and ($fila3['cod_tipo']==310)) { ?>
          <TR> 
            <TD width=6></TD>
            <TD> <table border=0 cellspacing=2 cellpadding=2>
              </table>
              <table width="100%" border="0">
              </table>
              <table width="100%" border="0">
                <tr> 
                  <td><font size="1" face="Arial, Helvetica, sans-serif">APROXIMAR 
                    NOTAS</font> 
                    <?php if ($frmModo=="ingresar"){
					//echo $qry7;
					//exit;?>
                    <input name="truncado" type="checkbox" id="truncado"> 
                    <?php } ?>
                    <?php 
						if($frmModo=="mostrar"){ ?>
                    <FONT face="arial, geneva, helvetica" size=2><strong> 
                    <?php
							imp( ($fila1['truncado']==0)?"NO":"SI");?>
                    </strong></font> 
                    <?php };?>
                    <?php if($frmModo=="modificar"){ ?>
                    <input type="checkbox" name="truncado" size=83 maxlength=50 value=1 
					<?php 
					echo ($fila1['truncado']==1)?"checked":"";
					?>> 
                    <?php };?>
                  </td>
                </tr>
              </table></TD>
          </TR>
          <?php }else{?>
          <input type=hidden name=cmbSUB value=0>
          <!--SUBSECTOR INDETERMINADO-->
          <?php // }//FIN ENSEÑANZA CURSO?>
          <?php }//FIN TIPO ENSEÑANZA COLEGIO?>
          <?php if(($Tipo_Ins==2)||($Tipo_Ins==3)){//JARDIN O SALACUNA ?>
          <input type=hidden name=cmbSUB value=0>
          <!--SUBSECTOR INDETERMINADO-->
          <?php }?>
          <TR> 
            <TD width=6></TD>
            <TD> <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width=100%>
                <TR> 
                  <TD colspan="2"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>MODO DE EVALUACION<FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp; 
                    &nbsp; <font face="Courier New, Courier, mono">&nbsp;</font></STRONG></FONT></STRONG></FONT> 
                  </TD>
                </TR>
                <TR> 
                  <TD width="39%"> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <Select name="cmbMODO" >
                      <option value=0 selected></option>
                      <option value=1 >Numérico</option>
                      <option value=2 >Conceptual</option>
                      <option value=3 >Numérico -Conceptual</option>
                    </Select> 
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ ?>
                    <FONT face="arial, geneva, helvetica" size=2><strong> 
                    <?php
													switch ($fila1['modo_eval']) {
														 case 0:
															 imp('INDETERMINADO');
															 break;
														 case 1:
															 imp('Numérico');
															 break;
														 case 2:
															 imp('Conceptual');
															 break;
														 case 3:
															 imp('Numérico - Conceptual');
															 break;
													 };?>
                    </strong></font> 
                    <?php };
											?>
                    <?php if($frmModo=="modificar"){ ?>
					
                    <Select name="cmbMODO" >
                      <option value=0></option>
                      <option value=1 <?php echo ($modo_eval_)==1?"selected":"" ?>>Numérico</option>
                      <option value=2 <?php echo ($modo_eval_)==2?"selected":"" ?>>Conceptual</option>
                      <option value=3 <?php echo ($modo_eval_)==3?"selected":"" ?>>Numérico -Conceptual</option>
                    </Select> 
                    <?php };?>
                  </TD>
                </TR>
                
                
                  <TR> 
                  <TD colspan="2"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>ALUMNO ESCOGE TALLER<FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp; 
                    &nbsp; <font face="Courier New, Courier, mono">&nbsp;</font></STRONG></FONT></STRONG></FONT> 
                  </TD>
                </TR>
                <TR> 
                  <TD width="39%"> 
                    <?php if($frmModo=="ingresar"){ ?>
                   <INPUT type="checkbox" name="alumno_taller" value="1">
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ ?>
                    <FONT face="arial, geneva, helvetica" size=2><strong> 
                    <?php
					if($fila1['alumno_elige_taller']==1){
					echo "SI";
				   }else{
				   echo "NO";
				 };?>
                    </strong></font> 
                    <?php };
											?>
                    <?php if($frmModo=="modificar"){ 
					if($fila1['alumno_elige_taller']==1){ ?>
						 <INPUT type="checkbox" name="alumno_taller" value="1" checked>
                        
						<?
						}else{ ?>
							<INPUT type="checkbox" name="alumno_taller" value="1">
                            <?
							}
					?>
					
                   
                    <?php };?>
                  </TD>
                </TR>
                
                
              </TABLE></TD>
          </TR>
          <TR> 
            <TD width=6></TD>
            <TD> <TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width=100%>
                <TR> 
                  <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>DOCENTE A CARGO</STRONG> </FONT> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>
                    
                  <TD>&nbsp; <font face="arial, geneva, helvetica" size=1 color=#000000> <strong>DOCENTE QUE IMPARTE</strong></font></TD>
                  
                </TR>
                
                <TR> 
                  <TD> 
				  <?php
                			$qry="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((trabaja.cargo)=".$docente.") AND ((trabaja.rdb)=".$institucion.")) order by empleado.ape_pat, empleado.ape_mat";
							$result5 =@pg_Exec($conn,$qry);
							if (!$result5) 
								error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
							else{
								if (pg_numrows($result5)!=0){
									$fila5 = @pg_fetch_array($result5,0);	
									if(!$fila5){
										error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
										exit();
									};
								}
				
					 if($frmModo=="ingresar"){?>
                    <Select name="cmbDOC">
                      <option value="0" selected>Seleccionar 1</option>
                      <?php
								for($i=0 ; $i < @pg_numrows($result5) ; $i++){
									$fila5 = @pg_fetch_array($result5,$i);
									echo  "<option value=".$fila5["rut_emp"].">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
								}
							
						?>
                    </Select> 
                    <? };?>
                
                    
                    <?php };?>
					<?php 
						 $qry2="SELECT empleado.rut_emp,empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, dicta_taller.acargo FROM (dicta_taller INNER JOIN empleado ON dicta_taller.rut_emp = empleado.rut_emp) INNER JOIN taller ON dicta_taller.id_taller = taller.id_taller WHERE (((taller.id_taller)=".$taller.")) ORDER BY empleado.ape_mat,empleado.ape_mat ASC";
						$result2 =@pg_Exec($conn,$qry2);
						for ($q=0; $q < @pg_numrows($result2); $q++){
							$fila2=pg_fetch_array($result2,$q);	
							$acargo=$fila2['acargo'];
							if($acargo==1){
								$rut_cargo=$fila2['rut_emp'];
								$emp_cargo =$fila2['ape_pat']." ".$fila2["ape_mat"].", ".$fila2["nombre_emp"];
							}else{
								$rut_imparte=$fila2['rut_emp'];
								$emp_imparte =$fila2['ape_pat']." ".$fila2["ape_mat"].", ".$fila2["nombre_emp"];
							}
						}
						
				if($frmModo=="mostrar"){ ?>
                   <FONT face="arial, geneva, helvetica" size=1><strong> 
                    <?php echo	$emp_cargo;?>
                    </strong></font>
				<? };
					 ?>
                     
                    <?php if($frmModo=="modificar"){	?>
                    <Select name="cmbDOC">
                      <option value=0 selected>seleccione</option>
				 <?php
						for($i=0 ; $i < @pg_numrows($result5) ; $i++){
							$fila5 = @pg_fetch_array($result5,$i);
							if(trim($rut_cargo)!=trim($fila5["rut_emp"])){
								echo "<option value=".$fila5["rut_emp"].">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
							}else{
								echo "<option value=".$fila5["rut_emp"]." selected>".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";							
							}
						}
					
					?>
                    </Select>
                    <? 	}?>
		         </TD>
                  <TD>
				  <?php 
				  if($frmModo=="ingresar"){
					  ?>
					   </Select> 
                    
                    <Select name="cmbDOCIMP" >
                      <option value="0" selected>Seleccionar 2</option>
                      <?php
								for($e=0 ; $e < @pg_numrows($result5) ; $e++){
									$fila5 = @pg_fetch_array($result5,$e);
									echo  "<option value=".$fila5["rut_emp"].">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
								}
							};
						?>
                    </Select>   
					  
					  <? 
				  
				  if($frmModo=="mostrar"){
				  ?>
						<FONT face="arial, geneva, helvetica" size=1><strong> <? 
					echo $emp_imparte;?>
					 </strong></font><?
				  }
				  if($frmModo=="modificar"){	?>
				  <select name="cmbDOCIMP">
                    <option value=0 selected>seleccione</option>
                    <?php
						for($i=0 ; $i < @pg_numrows($result5) ; $i++){
							$fila5 = pg_fetch_array($result5,$i);
							if(trim($rut_imparte)!=trim($fila5["rut_emp"])){
								echo "<option value=".$fila5["rut_emp"].">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
							}else{
								echo  "<option value=".$fila5["rut_emp"]." selected>".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
							}
						}
					
					?>
                  </select>
				 <? } ?>
				 </TD>
                </TR>
              </TABLE></TD>
          </TR>
          <TR> 
            <TD colspan=4> <TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
                <TR> 
                  <TD> <HR width="100%" color=#003b85> </TD>
                </TR>
              </TABLE></TD>
          </TR>
          <TR> 
            <TD colspan=4> <TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
                <TR> 
                  <td> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>ALUMNOS INSCRITOS EN EL TALLER</strong></font> </td>
                </TR>
                <tr class="tablatit2-1"> 
                  <td align="left" width="289"> 
                    <?php    if($frmModo=="modificar"){  ?>
                    ELIMINAR &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;  
                    <?php  }  ?>
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; NOMBRE </td>
                </tr>
                <?php    if(($frmModo=="modificar")||($frmModo=="mostrar")) {  ?>
                <?php
				 $qryP="SELECT tiene_taller.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno INNER JOIN tiene_taller ON alumno.rut_alumno = tiene_taller.rut_alumno)   WHERE (((tiene_taller.id_taller)=".$taller.")) order by ape_pat, ape_mat, nombre_alu asc ";
				$resultP =@pg_Exec($conn,$qryP);			
				if (pg_numrows($resultP)!=0){
					$filaP = @pg_fetch_array($resultP,0);	
					}
				?>
                <?php if ($frmModo=="modificar"){ ?>
                <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"><strong> 
                <td> 
                  <!--input type="checkbox" name="checkbox11" value="checkbox" onClick="ChequearTodos(this);"-->
                </td>
                </strong></font> 
					<input name="ins" type="hidden" value="<? echo @pg_numrows($resultP)?>">
                <?php  }?>
                <?php
					for($i=0 ; $i < @pg_numrows($resultP) ; $i++){
						$filaP = @pg_fetch_array($resultP,$i);
                           
			?>
                <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='cursor' onmouseout=this.style.background='transparent'> 
                  <td align="left"> 
                    <?php if ($frmModo=="modificar"){ ?>
<!--                    <input type="checkbox" name="alum[]" value=<?php echo $filaP["rut_alumno"];?>> -->
                    <input type="checkbox" name="alum<? echo $i;?>" value=<?php echo $filaP["rut_alumno"];?>> 
                    <?php } ?>
                    <?php    // }  ?>
                    &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    <?php    if(($frmModo=="modificar")or($frmModo=="mostrar")) {  ?>
                    <font face="arial, geneva, helvetica" size="1" color="#000000"> 
                    <strong><?php echo $filaP["ape_pat"]." ".$filaP["ape_mat"].", ".$filaP["nombre_alu"];?></strong> 
                    </font> 
                    <?php     } } ?>
                  </td>
                </tr>
                <?php
					}
                  
                  
//				}
			?>
                <tr> 
                  <td colspan="3"> <hr width="100%" color="#003b85"> </td>
                </tr>
                <tr> 
                  <td> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>ALUMNOS NO INSCRITOS DEL CURSO</strong></font> </td>
                </TR>
                <tr class="tablatit2-1"> 
                  <td align="left" width="289"> 
                    <?php    if($frmModo=="modificar"){  ?>
                    INSCRIBIR &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;  
                    <?php    }  ?>
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;  NOMBRE </td>
                </tr>
                <?php    if(($frmModo=="modificar")|| ($frmModo=="mostrar")){  ?>
                <?php
                     $qryA="SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno inner join matricula on alumno.rut_alumno=matricula.rut_alumno) inner join curso on curso.id_curso=matricula.id_curso WHERE  matricula.id_curso='".$curso."' and  alumno.rut_alumno NOT IN (SELECT rut_alumno FROM tiene_taller WHERE tiene_taller.id_taller='".$taller."')order by ape_pat, ape_mat, nombre_alu asc"; 
				    $resultA =@pg_Exec($conn,$qryA);
  					$filaA = @pg_fetch_array($resultA,0);
			                   ?>
                <?php if ($frmModo=="modificar"){ ?>
                <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"><strong> 
                <td> 
               <!-- <input type="checkbox" name="checkbox11" value="checkbox" onClick="ChequearTodos(this);">-->
               
                    <input type="checkbox" name="checkbox11" value="checkbox" onClick="ChequearTodos2();">
                   
				<font face="arial, geneva, helvetica" size="1" color="#000000"> 
				<strong>TODOS</strong></font>
			    </td>
                </strong></font> 

				<input name="des" type="hidden" value="<? echo @pg_numrows($resultA)?>">				

                <?php  }?>
                <?php
					for($i=0 ; $i < @pg_numrows($resultA) ; $i++){
						$filaA = @pg_fetch_array($resultA,$i);
			                ?>
                <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='cursor' onmouseout=this.style.background='transparent'>	
                  <td align="left"> 
                    <?php if ($frmModo=="modificar"){ ?>
                    <input type="checkbox" name="alu<? echo $i;?>" value=<?php echo $filaA["rut_alumno"];?> class="agr"> 					
                    <?php } ?>
                    <?php  //  }  ?>
                    &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    <?php   // if(($frmModo=="modificar")or($frmModo=="mostrar")) {  ?>
                    <font face="arial, geneva, helvetica" size="1" color="#666666"> 
                    <strong><?php echo $filaA["ape_pat"]." ".$filaA["ape_mat"].", ".$filaA["nombre_alu"];?></strong> 
                    </font> 
                    <?php  }  ?>
                  </td>
                </tr>
                <?php
					}
//				}
			?>
                <tr> 
                  <td colspan="3"> <hr width="100%" color="#003b85"> </td>
              </TABLE></TD>
          </TR>
          <TR height=15> 
            <TD colspan=2> 
              <?php if($frmModo=="mostrar"){?>
              <? if($_PERFIL==0 OR $_PERFIL==14 OR $_PERFIL==17 OR $_PERFIL==25){?>
<INPUT class="botonXX"  TYPE="button" value="EVALUACION" onClick=document.location="notas_taller/grilla_notas_jscrip/new_mostrarNotas.php?truncado=<?= $fila1['truncado'];?>"> <? }?>	 
              <?php 
				$qry="SELECT periodo.id_periodo, ano_escolar.id_ano FROM ano_escolar INNER JOIN periodo ON ano_escolar.id_ano = periodo.id_ano WHERE (((ano_escolar.id_ano)=".$ano."))";
				$result =@pg_Exec($conn,$qry);
				if (pg_numrows($result)!=0){
					$sql="SELECT * from dicta_taller dt where dt.id_taller=".$_TALLER." and dt.rut_emp=".$_NOMBREUSUARIO." and acargo=1"; 				
					$rst=@pg_Exec($conn,$sql);
					for($k=0;$k<@pg_numrows($rst);$k++){
						$filat=@pg_fetch_array($rst,$k);
						$acargo=$filat['acargo'];
					//if($acargo==1){
					?>
 <INPUT class="botonXX"  TYPE="button" value="EVALUACION" onClick=document.location="notas_taller/grilla_notas_jscrip/new_mostrarNotas.php?truncado=<?= $fila1['truncado'];?>"> 
 
              <?php //}
				}if ($fila1['conex']==1) { ?>
              <input class="botonXX"  name="button" type="button" onClick=document.location="situacionFinal.php3?frmModo=mostrar" value="SITUACION FINAL ALUMNOS"> 
              <?php } ?>
              <?php
												}else{
											?>
              <!--INPUT TYPE="button" value="EVALUACION" disabled-->
              <?php
												}
											?>
              <?php if($_PLAN>=2){ //PLUS O +?>
            <!--   <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CONTENIDO" onClick=document.location="contenido/listarContenidos.php3">  -->
              <?php }?>
              <?php }else{?>
              <!--INPUT TYPE="button" value="EVALUACION" disabled>
									<?php if($_PLAN>=2){ //PLUS O +?>
										<INPUT TYPE="button" value="CONTENIDO" disabled-->
              <?php }?>
              <?php }?>
            </TD>
          </TR>
        </TABLE></form>
				</TD>
			</TR>
			
			
			
		
		</TABLE>
	</FORM>

								  
								  
								  
								  <!-- fin --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
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
</body>
</html>
