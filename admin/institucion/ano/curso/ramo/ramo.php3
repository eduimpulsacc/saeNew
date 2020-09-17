<?php require('../../../../../util/header.inc');  ?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	 $ano			=$_ANO;
//	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO;
	$plan			=$_PLAN;
	$docente		=5; //Codigo Docente
	$_POSP         = 5;
	
	
//-------
	$sqlCurso = "select institucion.nombre_instit, ano_escolar.nro_ano, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto ";
	$sqlCurso = $sqlCurso . " from institucion, ano_escolar, curso, tipo_ensenanza ";
	$sqlCurso = $sqlCurso . " where institucion.rdb = $institucion and ano_escolar.id_ano = $ano and curso.id_curso = $curso";
	$sqlCurso = $sqlCurso . "and curso.ensenanza = tipo_ensenanza.cod_tipo";
	$rsCurso =@pg_Exec($conn,$sqlCurso);												
	$fCurso = @pg_fetch_array($rsCurso,0);		
	//-------		


	 $qryIns="select tipo_instit from institucion where rdb=".$institucion;
	 $resultIns = @pg_exec($conn,$qryIns);
	 $filaIns	= @pg_fetch_array($resultIns,0);
	 $Tipo_Ins = $filaIns['tipo_instit'];
	 
	 if($frmModo=="mostrar"){
	 	$sql ="SELECT * FROM ramo WHERE id_ramo=".$ramo;
		$rs_ramo = @pg_exec($conn,$sql) or die ("SELECT RAMO:".$sql);
		$fila_ramo =@pg_fetch_array($rs_ramo,0);
	 }
	?>

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
</script>

<SCRIPT language="JavaScript">
					
			function enviapag(form){
			if (form.cmbSECDIF.value!=0){
				form.cmbSECDIF.target="self";
				form.action = 'ramo.php3?institucion=$institucion&$frmModo=ingresar';
				form.submit(true);
				}	
			}
			
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
					form.pct_ex_escrito.disable = true
					form.pct_ex_escrito.value = ""
					form.pct_ex_oral.disable = true
					form.pct_ex_oral.value = ""

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
					form.codSub.disabled = true;
					form.codSub.value = "";
					form.codRes.disabled = true;
					form.codRes.value = "";
					form.txtFecha.disabled = true;
					form.txtFecha.value = "";
					
					form.nombresubsector.disabled=false
			}					
			function mtaTextt(form)
			{
					form.codSub.disabled = false;
					form.codRes.disabled = false;
					form.txtFecha.disabled = false;
					
					form.nombresubsector.disabled=true;
					form.nombresubsector.value = "";
			}					
			
			

			function muestraTextPNivel(form)
			{
					form.txtPCTNIV.disabled = false;
					form.cmbMODOpruebaNivel.disabled = false; 
					form.cmbMODOpruebaNivel.value = "";
			}

			function ocultaTextNivel(form)
			{
					form.txtPCTNIV.disabled = true
					form.txtPCTNIV.value = ""
					if(form.cmbMODOpruebaNivel){
						form.cmbMODOpruebaNivel.disabled = true
						form.cmbMODOpruebaNivel.value = ""
					}
			}
			function insRow(tabla)
			{
				largo=document.getElementById(tabla).rows.length;
				var x=document.getElementById(tabla).insertRow(largo);
				var y=x.insertCell(0);
				var w=x.insertCell(1);
				//y.id="td"+j;
				y.innerHTML="<input name=nombre2[] type=text>";
				w.innerHTML="<input name=sigla[] type=text>";
						}
			function delRow(tabla)
			{
				largo=document.getElementById(tabla).rows.length;
				largo=largo-1
				var x=document.getElementById(tabla).deleteRow(largo);
				
			}

function eliminar(id){
	var id;
	
	if(confirm("¿Esta seguro de eliminar el examen?")==false){
		return false;
	}
	alert("Recuerde revisar la suma de los porcentaje; Este debe dar 100%");
	window.location='examen/eliminaExamen.php?id_examen='+id;
}


function textpruebadenivel(form){
		
if(form.prueba_niv.checked ==0){
	
	form.txtPCTNIV.disabled=true;
	form.txtPCTNIV.value="";
	form.truncado_pnivel.disabled=true;
	form.truncado_pnivel.checked=false
	form.cmbMODOpruebaNivel.disabled=true;
	form.cmbMODOpruebaNivel.value=0;
	
	
	
}else{
	form.txtPCTNIV.disabled=false;
	form.txtPCTNIV.focus();
	form.truncado_pnivel.disabled=false;
	form.cmbMODOpruebaNivel.disabled=false;
}
}

function textquiz(form){
		
	if(form.conexquiz.checked ==0){
		
		form.porc_examen_quiz.disabled=true;
		form.porc_examen_quiz.value="";
		form.truncado_examen_quiz.disabled=true;
		form.truncado_examen_quiz.checked=false;
		form.nota_exim_quiz.disabled=true;
		form.nota_exim_quiz.value="";
	}else{
		form.porc_examen_quiz.disabled=false;
		form.porc_examen_quiz.focus();
		form.truncado_examen_quiz.disabled=false;
		form.nota_exim_quiz.disabled=false;
		
	}
}


function textpu(form){
		
	if(form.conex_pu.checked ==0){
		
		form.porc_examen_pu.disabled=true;
		form.porc_examen_pu.value="";
		form.aprox_entero_pu.disabled=true;
		form.aprox_entero_pu.checked=false;
		form.nota_exim_pu.disabled=true;
		form.nota_exim_pu.value="";
	}else{
		form.porc_examen_pu.disabled=false;
		form.porc_examen_pu.focus();
		form.aprox_entero_pu.disabled=false;
		form.nota_exim_pu.disabled=false;
		
	}
}

function textcoef(form){
	if(form.coef2.checked==0){
		form.aprox_coef2.disabled=true;	
		form.aprox_coef2.checked=false;	
	}else{
		form.aprox_coef2.disabled=false;
	}
}

//pruebas sintesis
function ps(form){
	if(form.bool_psintesis.checked==0){
		form.porc_psintesis.disabled=true;	
		form.porc_psintesis.value=0;	
	}else{
		form.porc_psintesis.disabled=false;	
	}
}

//pruebas sintesis
function ng(form){
	if(form.notagrupo.checked==0){
		form.bool_aprgrp.disabled=true;	
		form.bool_aprgrp.checked=false;		
	}else{
		form.bool_aprgrp.disabled=false;	
	}
}

function textexamen(form){
	
if(form.conexper.checked ==0){
	
	form.pct_ex_semestral.disabled=true;
	form.pct_ex_semestral.value=""
	form.nota_ex_semestral.disabled=true;
	form.nota_ex_semestral.value=""
	form.truncado_ex_semestral.disabled=true;
	form.truncado_ex_semestral.checked=false;
	form.txtPCTEX.disabled=false;
	form.agrega.disabled=false;
	form.aprox_prom.disabled=false;
	form.conEX.disabled=false;
	
}else{
	form.pct_ex_semestral.disabled=false;
	form.pct_ex_semestral.focus();
	form.pct_ex_semestral.value=""
	form.nota_ex_semestral.disabled=false;
	form.truncado_ex_semestral.disabled=false;
	form.txtPCTEX.disabled=true;
	form.agrega.disabled=true;
	form.aprox_prom.disabled=true;
	form.conEX.disabled=true;
	
	delrow('mytable');	
	
}
}

function jexamenfinal(form){
	
if(form.conEX.checked ==0){
	form.truncado_ex_final.disabled=true;
	form.truncado_ex_final.checked=false;
	form.txtPCT.disabled=true;
	form.txtPCT.value=""
	form.txtNEXIM.disabled=true;
	form.txtNEXIM.value=""
	form.pct_escrito.disabled=true;
	form.pct_escrito.value=""
	form.pct_oral.disabled=true;
	form.pct_oral.value=""
	form.conexper.disabled=false;
	form.agrega.disabled=false;
	form.aprox_prom.disabled=false;
	form.txtPCTEX.disabled=false;
	
}else{
	form.txtPCT.disabled=false;
	form.txtPCT.focus();
	form.txtPCT.value=""
	form.txtNEXIM.disabled=false;
	form.pct_escrito.disabled=false;
	form.pct_oral.disabled=false;
	form.truncado_ex_final.disabled=false;
	form.conexper.disabled=true;
	form.agrega.disabled=true;
	form.aprox_prom.disabled=true;
	form.txtPCTEX.disabled=true;
	
	}
}

	
		function valida1(form){
			
		if(form.cmbDOC.value==0){
			alert("Seleccione Docente");
			return false;
			}
			
		 if(form.conEX.checked ==1){
			if(form.txtPCT.value=="")
			{
				alert("Ingrese porcentaje nota examen");
				form.txtPCT.focus();
				return false;
			}
			else if(form.txtNEXIM.value==0){
				alert("Ingrese nota eximicion");
				form.txtNEXIM.focus();
				return false;
			}
			//return false;
		}
			
		}

</SCRIPT>
<style type="text/css">
<!--
.EstiloMODO {color: #FF0000 ; font-size: 10px;}
-->
</style>

<?php
	if($frmModo!="ingresar"){
		 $qry="SELECT * FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
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
			}
		}
		?>
       
		<?
		
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
		 case 3:
			$_MODOEVAL	=	3;
			if(!session_is_registered('_MODOEVAL')){
				session_register('_MODOEVAL');
			};
			 break;
		 case 4:
			$_MODOEVAL	=	4;
			if(!session_is_registered('_MODOEVAL')){
				session_register('_MODOEVAL');
			};
			 break;
	 };
	 
	 
	 

?>
<HTML>
	<HEAD>
	<link  rel="shortcut icon" href="/images/icono_sae_33.png">	
<?php if($frmModo!="mostrar"){?>
	<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></script>
	<?php if($Tipo_Ins==1){//COLEGIO ?>
	<!--AQUI DETERMINAR SI EL CURSO ES KINDER O OTRO DE LOS CABROS CHICOS-->
	<script language="JavaScript">
			function valida(form){
				if(!chkVacio(form.cmbSUBS,'Ingresar CODIGO del subsector.')){
					return false;
				};
				
				if(form.cmbSUBS.value==""){
					
					alert("Seleccione subsector");
					}
				/*if(!nroOnly(form.codSub,'Se permiten sólo números para el CODIGO del subsector.')){
					return false;
				};*/
				//if (document.frm.cmbSUBS[0].checked==false && document.frm.cmbSUBS[1].checked==false ){
					//alert("Debe seleccionar Subsector");
					//document.frm.cmbSUBS[0].focus();
					//return false;
				//};
				
				 	/*if(!chkVacio(form.codSub,'Ingresar Codigo SubSector.')){
						return false;
					};*/
					if(!nroOnly(form.codSub,'Se permiten sólo números para el CODIGO del subsector.')){
						return false;
					};
				
				/*if(document.frm.cmbSUBS[1].checked==true){
					if(!chkSelect(frm.cmbSECDIF,'Seleccionar SubSector.')){
						return false;
					};
				};*/
				if(!chkSelect(form.cmbDOC,'Seleccionar DOCENTE.')){
					return false;
				};
				return true;
			}
			
			</SCRIPT>
		
				
		
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
					/*if(!chkSelect(form.cmbSUB,'Seleccionar DOCENTE.')){
						return false;
					};*/


					return true;
				}
			</SCRIPT>
	<?php }?>
<?php }?>
	
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
--> 
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayudaza_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
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
						 $menu_lateral= "3_1";
						include ("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390">
								  
								  

<?php if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>

<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      </td>
  </tr>
</table>

 <!-- AQUÍ CODIGO NUEVO -->

<?php } ?>
	<?php //echo tope("../../../../../util/");?>
	
	<FORM method="post" name="frm" action=<? /*if ($_PERFIL==0){ echo "procesoRamo_dav.php"; }else{ */ echo "procesoRamo.php3"; //} ?>>
	
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=ano value=".$ano.">";
		echo "<input type=hidden name=curso value=".$curso.">";
		
		$qryVrfyPropio="select * from plan_estudio where cod_decreto=".$_PLAN;
		$resultVrfy=@pg_Exec($conn,$qryVrfyPropio);
		$filaVrfy=@pg_fetch_array($resultVrfy,0);
	
$qry="SELECT curso.*, tipo_ensenanza.cod_tipo, tipo_ensenanza.nombre_tipo FROM curso INNER JOIN tipo_ensenanza ON      curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
	$result25 =@pg_Exec($conn,$qry);
	
	if (!$result25) {
	error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
	}else{
	if (pg_numrows($result25)!=0){
		$fila3 = @pg_fetch_array($result25,0);	
		if (!$fila3){
			error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
			exit();
		}
	}
	}
		
		
		$nro_ano_notas = trim($fCurso['nro_ano']);
		
	?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
                      <TR>
                        <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>INSTITUCI&Oacute;N</strong></FONT> </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> <?php echo trim($fCurso['nombre_instit']); ?> </strong> </FONT> </TD>
                      </TR>
                      <TR>
                        <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>A&Ntilde;O ESCOLAR</strong> </FONT> </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> <?php echo trim($fCurso['nro_ano']); ?> </strong> </FONT> </TD>
                      </TR>
                      <TR>
                        <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>CURSO</strong> </FONT> </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>
                          <?php
													if ( ($fCurso['grado_curso']==1) and (($fCurso['cod_decreto']==771982) or ($fCurso['cod_decreto']==461987)) ){
														echo "PRIMER NIVEL"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
													
													}else if ( ($fCurso['grado_curso']==1) and (($fCurso['cod_decreto']==121987) or ($fCurso['cod_decreto']==1521989)) ){
														echo "PRIMER CICLO"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
													
													}else if ( ($fCurso['grado_curso']==2) and (($fCurso['cod_decreto']==771982) or ($fCurso['cod_decreto']==461987)) ){
														echo "SEGUNDO NIVEL"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
													
													}else if ( ($fCurso['grado_curso']==2) and ($fCurso['cod_decreto']==121987) ){
														echo "SEGUNDO CICLO"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
													
													}else if ( ($fCurso['grado_curso']==3) and (($fCurso['cod_decreto']==771982) or ($fCurso['cod_decreto']==461987)) ){
														echo "TERCER NIVEL"." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
													
													}else{
														echo $fCurso['grado_curso']." - ".trim($fCurso['letra_curso'])." ".trim($fCurso['nombre_tipo']);
													}
										?>
                        </strong> </FONT> </TD>
                      </TR>
                      <TR>
                        <TD align=left>
                          <?php if (($frmModo=="mostrar") or ($frmModo=="modificar")){ ?>
                          <FONT face="arial, geneva, helvetica" size=2> <strong>ASIGNATURA</strong> </FONT> </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT>
                            <?php }?>
                        </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>
                          <?php
								if (@pg_numrows($result)!=0){
									$fila1 = @pg_fetch_array($result,0);	
									echo trim($fila1['nombre']);
								}
							?>
                        </strong> </FONT> </TD>
                      </TR>
                    </TABLE></TD>
			</TR>
			<TR height=15>
				<TD>
					
					
					<!-- aqui tabla nueva -->
					<!-- fin tabla nueva --></TD>
			</TR>		
			
		</TABLE>
	
	    <br>
		
		<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td><div align="right">
			  <?php if($frmModo=="ingresar"){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name="btnGuardar" onClick="return valida(this.form);">
									&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name="btnCancelar" onClick=document.location="listarRamos.php3?plan=<?php echo $plan ?>">&nbsp;
								<?php };?>
								<?php if($frmModo=="mostrar"){ ?>
								<?php if($_PERFIL==17){ ?>
									<!--INPUT class="botonXX"  TYPE="button" value="INICIO" onClick=parent.location.href="../../../../../fichas/docente/index.html"-->
								<?php }?>
									<?php if($_PERFIL!=17){?> 
										<?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=6)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=26)){ //ACADEMICO Y LEGAL?>
												<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
												<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaRamo.php3?ramo=<?php echo $ramo?>&caso=3">&nbsp;
												
												<? 
												
											//SABEMOS SI EL RAMO TIENE NOTAS , PARA NO MOSTRAR EL BOTON ELIMINAR...*******************	
		 $qry_tiene_notas="select count (*) as cantidad from notas$nro_ano_notas where id_ramo=$ramo";
		$tiene_notas_1=@pg_Exec($conn,$qry_tiene_notas);
		$filanotitas=@pg_fetch_array($tiene_notas_1,0);
		
		$notitas= $filanotitas['cantidad'];	
		
		?> 
		
		<? if ($notitas == 0){?>
		<INPUT class="botonXX"  TYPE="button" value="ELIMINAR" name= btnEliminar onClick=document.location="seteaRamo.php3?caso=9;">
		&nbsp;
		<?php }
		}?>
		<?php }?>
										<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarRamos.php3?plan=<?php echo $plan ?>">&nbsp;
									<?php }?>
								<?php if($_TIPODOCENTE==1){?>
										<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarRamos.php3?plan=<?php echo $plan ?>">&nbsp;
									<?php }?>
								<?php };?>
								<?php if($frmModo=="modificar"){ ?>
	<INPUT class="botonXX"  TYPE="submit" value="GUARDAR" name="btnGuardar" onClick="return valida1(this.form);" >
									&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaRamo.php3?ramo=<?php echo $ramo?>&caso=1&plan=<?php echo $plan ?>">&nbsp;
								<?php };?>
								
					<!--	<?php if($_PERFIL==17){?>
								<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarRamos.php3?plan=<?php echo $plan ?>">
							<? } ?>  -->
			  </div></td>
		  </tr>
		</table>
		<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
		<TR height=20>
			<TD align="middle" colspan="2" class="tableindex">ASIGNATURA</TD>
		</TR>
		</table>
		<br>
  <?php if($frmModo=="ingresar"){ ?>        
 <table width="600" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" align="center">
 <tr>
 <td>
 <table width="590" border="0" cellspacing="0" cellpadding="3" align="center">
<tr> 
<td width="22">&nbsp;</td>
<td width="201" class="textosimple">COD. ASIGNATURA</td>
<td width="142" class="textosimple">RESOLUCI&Oacute;N</td>
<td width="173" class="textosimple"> FECHA</td>
</tr>
<tr> 
<td><input type="radio" name="cmbSUBS" value="1"onClick="mtaTextt(this.form);">
</td>
<td> 
<input type="text" name="codSub" width="60"> 
<FONT face="arial, geneva, helvetica" size=2><strong> 

</strong></font> </td>
<td> 
<input type="text" name="codRes"> </td>
<td align="top"> <input type="text" name="txtFecha" > 

</td>
</tr>				
</table>
</td>
</tr>
</table>  
  <br>
<table width="600" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" align="center">
<tr>
<td>
<table width="590" border="0" cellspacing="0" cellpadding="3" align="center">
<tr> 
<td width="22"> <font face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; 
</font> </td>
<td><strong><font color="#000000" size="1" face="arial, geneva, helvetica">NOMBRE SUBSECTOR<br>
</font><font size="2" face="arial, geneva, helvetica"><span class="Estilo1">(solo para crear subsectores hijos que no est&eacute;n en la lista de los subsectores entregados por el ministerio de educaci&oacute;n).</span> </font></strong></td>

</tr>
<tr> 
              
<td><input type="radio" name="cmbSUBS" value="3"onClick="mtaText(this.form);">						  </td>
<td> 

<input name="nombresubsector" type="text" id="nombresubsector" size="50" width="60"> 

<FONT face="arial, geneva, helvetica" size=2><strong> 

</strong></font> </td>
</tr>				
</table>
</td>
</tr>
</table>       <?php }  ?> 
        <br>
		<table width="600" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" align="center">
		<tr>
		  <td>
			<table width="590" border="0" cellspacing="0" cellpadding="3" align="center">
			  <tr>
				<td colspan="3" class="textonegrita">DATOS GENERALES </td>
				</tr>
			  <tr>
			  </tr>
			  <TR>
                <TD align=left>
                
                <?php if (($frmModo=="mostrar") or ($frmModo=="modificar")){ ?>
                <FONT face="arial, geneva, helvetica" size=2> <strong>Nombre</strong> </FONT> 
                 <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT>
                <?php }?>
               
                <FONT face="arial, geneva, helvetica" size=2> <strong>
                <?php
                if (@pg_numrows($result)!=0){
                $fila = @pg_fetch_array($result,0);	
                echo trim($fila1['nombre']);
                }
                ?>
                </strong> </FONT> 
                </TD>
                </TR>
			  <tr>
				<td class="textosimple">Asignatura Obligatoria </td>
				<td class="textosimple">Asignatura Electiva </td>
				<td class="textosimple">Asignatura Art&iacute;stica </td>
			  </tr>
			  <tr>
				<td class="textonegrita">
<?php 
        //exit;
       if($frmModo=="ingresar"){ ?>
        <input name="sub_ob" type="radio" value="1" checked> 
        <?php };?>
        <?php 
       if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
        echo($fila['sub_obli']==1)?"SI":"NO";?>
        </strong></font>
        <?php };
        ?>
        <?php if($frmModo=="modificar"){ ?>
        <input name="sub_ob" type="radio" value=1 
        <?php 
        echo ($fila['sub_obli']==1)?"checked":"";
        ?>>
 <?php };?>
				</td>
				<td class="textonegrita">
				  <?php if($frmModo=="ingresar"){ ?>
                    <input type="radio" name="sub_ob" value="0"> 
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
													echo ($fila['sub_elect']==1)?"SI":"NO";?>
													</strong></font>
												<?php };
											?>
                    <?php if($frmModo=="modificar"){ ?>
                    <input type="radio" name="sub_ob" value="0"
											<?php 
											  echo ($fila['sub_elect']==1)?"checked":"";
											?>>
											
											<?php };?>
				</td>
				<td class="textonegrita">
	<?php if($frmModo=="ingresar"){ ?><INPUT type="checkbox" name="artis" size=83 maxlength=50 id="artis" >
    <?php };?>
    <?php 
    if($frmModo=="mostrar"){ ?>
    <FONT face="arial, geneva, helvetica" size=2><strong>
    <?php
    imp( ($fila['bool_artis']==0)?"NO":"SI");?>
    </strong></font>
    <?php };
     ?>
    <?php if($frmModo=="modificar"){ ?>
    <INPUT type="checkbox" name=artis size=83 maxlength=50 value=1 
     <?php 
      echo ($fila['bool_artis']==1)?"checked":"";
      ?>>
    <?php };?>
				</td>
			  </tr>
			  <tr>
				<td class="textosimple">Incide en Promoci&oacute;n </td>
				<td class="textosimple">Asignatura Asociada a Religi&oacute;n </td>
				<td class="textosimple">Edici&oacute;n de Notas</td>
			  </tr>
			  <tr>
			    <td class="textonegrita">
				<?php if($frmModo=="ingresar"){ ?>
                <INPUT type="checkbox" name="ip" size=83 maxlength=50 id="ip">
                <?php };?>
                
                <?php 
                if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
                imp( ($fila['bool_ip']==0)?"NO":"SI");?>
                </strong></font>
                <?php };
                ?>
                <?php if($frmModo=="modificar"){ ?>
                <INPUT type="checkbox" name="ip" size=83 maxlength=50 value=1 
                <?php 
                echo ($fila['bool_ip']==1)?"checked":"";
                ?>>
                <?php };?>
				</td>
			    <td class="textonegrita">
 
 <?php if($frmModo=="ingresar"){ ?>
    <input type="checkbox" name="sar" size=83 maxlength=50 > 
    <?php };?>
    <?php 
 
   if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong>
   <?php   imp( ($fila['bool_sar']==0)?"NO":"SI");?>
                                 </strong></font>
                             <?php };
                            ?>
    <?php if($frmModo=="modificar"){ ?>
    <INPUT type="checkbox" name=sar size=83 maxlength=50 value=1 
       <?php echo ($fila['bool_sar']==1)?"checked":""; ?>>
       <?php };?>
				</td>
                
                
			    <td class="textonegrita">
				 <?php if($frmModo=="ingresar"){ ?>
                    <input type="checkbox" name="bloq" size=83 maxlength=50 > 
                    <?php };?>
                    <?php 
                      if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
                          imp( ($fila['bool_bloq']==0)?"SI":"NO");?>
                        </strong></font>
                     <?php };
                     ?>
    <?php if($frmModo=="modificar"){ ?>
    <INPUT type="checkbox" name="bloq" size=83 maxlength=50 value=1 
                            <?php 
                              echo ($fila['bool_bloq']==1)?"checked":"";
                            ?>>
                            <?php };?>
				</td>
			    </tr>
			  <tr>
			    <td class="textosimple">Notas Quiz</td>
			    <td class="textosimple">Prueba de Unidad</td>
			    <td class="textosimple">Incide en Promedio General</td>
			    </tr>
			  <tr>
			    <td class="textonegrita">
                <?php if($frmModo=="ingresar"){ ?><INPUT type="checkbox" name="nquiz" size=83 maxlength=50 id="nquiz" >
    <?php };?>
    <?php 
    if($frmModo=="mostrar"){ ?>
    <FONT face="arial, geneva, helvetica" size=2><strong>
    <?php
    imp( ($fila['bool_nquiz']==0)?"NO":"SI");?>
    </strong></font>
    <?php };
     ?>
    <?php if($frmModo=="modificar"){ ?>
    <INPUT type="checkbox" name=nquiz size=83 maxlength=50 value=1 
     <?php 
      echo ($fila['bool_nquiz']==1)?"checked":"";
      ?>>
    <?php };?>
                </td>
			    <td class="textonegrita">
                 <?php if($frmModo=="ingresar"){ ?><INPUT type="checkbox" name="bool_pu" size=83 maxlength=50 id="bool_pu" >
    <?php };?>
    <?php 
    if($frmModo=="mostrar"){ ?>
    <FONT face="arial, geneva, helvetica" size=2><strong>
    <?php
    imp( ($fila['bool_pu']==0)?"NO":"SI");?>
    </strong></font>
    <?php };
     ?>
    <?php if($frmModo=="modificar"){ ?>
    <INPUT type="checkbox" name="bool_pu" id="bool_pu" value="1" 
     <?php 
      echo ($fila['bool_pu']==1)?"checked":"";
      ?>>
    <?php };?>
                
                
                </td>
			    <td class="textonegrita"><?php if($frmModo=="ingresar"){ ?>
			      <INPUT type="checkbox" name="bool_pgeneral" size=83 maxlength=50 id="bool_pgeneral" >
                  <?php };?>
                  <?php 
    if($frmModo=="mostrar"){ ?>
                  <FONT face="arial, geneva, helvetica" size=2><strong>
                  <?php
    imp( ($fila['bool_pgeneral']==0)?"NO":"SI");?>
                  </strong></font>
                  <?php };
     ?>
                  <?php if($frmModo=="modificar"){ ?>
                  <INPUT type="checkbox" name="bool_pgeneral" id="bool_pgeneral" value="1" 
     <?php 
      echo ($fila['bool_pgeneral']==1)?"checked":"";
      ?>>
                  <?php };?></td>
			    </tr>
			  <tr>
			    <td class="textosimple">Prueba S&iacute;ntesis</td>
			   
                <td class="textosimple">Notas Agrupadas</td>
			    <td class="textosimple">&nbsp;</td>
			    </tr>
			  <tr>
			    <td class="textonegrita"><?php if($frmModo=="ingresar"){ ?>
			      <INPUT type="checkbox" name="bool_psintesis" size=83 maxlength=50 id="bool_psintesis" onClick="ps(this.form)" value="1" >
                  <?php };?>
                  <?php 
    if($frmModo=="mostrar"){ ?>
                  <FONT face="arial, geneva, helvetica" size=2><strong>
                  <?php
    imp( ($fila['bool_psintesis']==0)?"NO":"SI");?>
                  </strong></font>
                  <?php };
     ?>
                  <?php if($frmModo=="modificar"){ ?>
                  <INPUT type="checkbox" name="bool_psintesis" id="bool_psintesis" size="83" maxlength="50" value="1" 
     <?php 
      echo ($fila['bool_psintesis']==1)?"checked":"";
      ?> onClick="ps(this.form)">
                  <?php };?></td>
			    <td class="textonegrita"><?php if($frmModo=="ingresar"){ ?>
                  <INPUT type="checkbox" name="notagrupo" size=83 maxlength=50 id="notagrupo" value="1"  onClick="ng(this.form)">
                  <?php };?>
                  <?php 
    if($frmModo=="mostrar"){ ?>
                  <FONT face="arial, geneva, helvetica" size=2><strong>
                  <?php
    imp( ($fila['notagrupo']==0)?"NO":"SI");?>
                  </strong></font>
                  <?php };
     ?>
                  <?php if($frmModo=="modificar"){ ?>
                  <INPUT type="checkbox" name="notagrupo" id="notagrupo" size="83" maxlength="50" value="1" 
     <?php 
      echo ($fila['notagrupo']==1)?"checked":"";
      ?>  onClick="ng(this.form)">
                  <?php };?></td>
			    <td class="textonegrita">&nbsp;</td>
			    </tr>
			</table>
		</td></tr>
		</table>
		<br>
		<table width="600" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" align="center">
		<tr>
		  <td>
		<table width="590" border="0" cellspacing="0" cellpadding="3" align="center">
		  <tr>
			<td colspan="3" class="textonegrita">APROXIMACIONES</td>
			</tr>
		  <tr>
			<td class="textosimple">Aproximar Notas </td>
			<td class="textosimple">Aproximar promedio a Entero </td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td class="textonegrita">
          
          <?php if ($frmModo=="ingresar"){
					//echo $qry7;
					//exit;?>
                    <input name="truncado" type="checkbox" id="truncado"> 
                    <?php } ?>
                    <?php 
						if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
							imp( ($fila['truncado']==0)?"NO":"SI");?>
							</strong></font>
						<?php };?>
                    <?php if($frmModo=="modificar"){ ?>
                    <input type="checkbox" name="truncado" size=83 maxlength=50 value=1 
					<?php 
					echo ($fila['truncado']==1)?"checked":"";
					?>> 
                    <?php };?>
			</td>
			<td class="textonegrita">
			<? 	if($frmModo=="mostrar"){
					echo ($fila['aprox_entero']==0)?"NO":"SI";
				}
				if($frmModo=="modificar"){ ?>
					<input type="checkbox" name="aprox_entero" value="1" <? echo ($fila['aprox_entero']==1)?"checked":"&nbsp;";?>>
			<?	}
				if($frmModo=="ingresar"){  ?>
					<input type="checkbox" name="aprox_entero">
			<? 	} ?>
			</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td class="textosimple">Aproximar Examen Semestral </td>
			<td class="textosimple">Aproximar Examen Final </td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td class="textonegrita">
			<? 	if($frmModo=="mostrar"){
					echo ($fila['truncado_ex_semestral']!=1)?"NO":"SI";
				}
		if($frmModo=="modificar"){ 
		
		if($fila['conexper']==1){
		?>
	<input name="truncado_ex_semestral" type="checkbox" id="truncado_ex_semestral" value="1" <? echo ($fila['truncado_ex_semestral']==1)?"checked":"&nbsp;";?>>
			<?	}else{?>
	<input name="truncado_ex_semestral" type="checkbox" id="truncado_ex_semestral" disabled value="1" <? echo ($fila['truncado_ex_semestral']==1)?"checked":"&nbsp;";?>>
			<?	}}
				if($frmModo=="ingresar"){
				if($fila['conexper']==1){	
					?>
			<input name="truncado_ex_semestral" type="checkbox" id="truncado_ex_semestral" >		
			<? 	}else{?>
			<input name="truncado_ex_semestral" type="checkbox" disabled id="truncado_ex_semestral" >		
				
			<?	} }?>
			</td>
			<td class="textonegrita">
			<? 	if($frmModo=="mostrar"){
		echo ($fila['truncado_ex_final']!=1)?"NO":"SI";
				}
				if($frmModo=="modificar"){
				if($fila['conex']==1){
				?>
	<input name="truncado_ex_final" type="checkbox" id="truncado_ex_final" value="1" <? echo ($fila['truncado_ex_final']==1)?"checked":"&nbsp;";?>>
			<?	}else{
				?>
    <input name="truncado_ex_final" type="checkbox" id="truncado_ex_final" disabled value="1" <? echo ($fila['truncado_ex_final']==1)?"checked":"&nbsp;";?>>
				<? }}
				
				
				if($frmModo=="ingresar"){
				if($fila['conex']==1){	
				?>
					<input name="truncado_ex_final" type="checkbox" id="truncado_ex_final">
			<? 	}else{?>
				<input name="truncado_ex_final" type="checkbox" id="truncado_ex_final" disabled>
			<?	}} ?>		
			</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td class="textosimple">Aproximar Prueba de Nivel </td>
			<td class="textosimple">Aproximar examen Quiz</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
		    <td class="textonegrita">
			<? 	if($frmModo=="mostrar"){
					echo ($fila['truncado_pnivel']==0)?"NO":"SI";
				}
				if($frmModo=="modificar"){ 
				if($fila['prueba_nivel']==1){ ?>
				
		<input name="truncado_pnivel" type="checkbox" id="truncado_pnivel" value="1"  <? echo ($fila['truncado_pnivel']==1)?"checked":"&nbsp;";?>>
			<?	}else{?>
				<input name="truncado_pnivel" type="checkbox" id="truncado_pnivel" value="1" disabled  <? echo ($fila['truncado_pnivel']==1)?"checked":"&nbsp;";?>>
				<? }}
				if($frmModo=="ingresar"){  ?>		
					<input name="truncado_pnivel" type="checkbox" disabled id="truncado_pnivel">
			<? 	} ?>
			</td>
		    <td class="textonegrita">
            <? 	if($frmModo=="mostrar"){
					echo ($fila['truncado_examen_quiz']==0)?"NO":"SI";
				}
				if($frmModo=="modificar"){ 
				if($fila['truncado_examen_quiz']==1){ ?>
				
		<input name="truncado_examen_quiz" type="checkbox" id="truncado_examen_quiz" value="1" <?php echo ($fila['conexquiz']==1)?"":"disabled" ?>  <? echo ($fila['truncado_examen_quiz']==1)?"checked":"";?>>
			<?	}else{?>
				<input name="truncado_examen_quiz" type="checkbox" id="truncado_examen_quiz" value="1" <?php echo ($fila['conexquiz']==1)?"":"disabled" ?>  <? echo ($fila['truncado_examen_quiz']==1)?"checked":"&nbsp;";?>>
				<? }}
				if($frmModo=="ingresar"){  ?>		
					<input name="truncado_examen_quiz" type="checkbox" disabled id="truncado_examen_quiz">
			<? 	} ?>
            </td>
		    <td>&nbsp;</td>
		    </tr>
		  <tr>
		    <td class="textosimple">Aproximar Examen Coef 2</td>
		    <td class="textosimple">Aproximar  notas Pruebas de Unidad</td>
		    <td>&nbsp;</td>
		    </tr>
		  <tr>
		    <td class="textonegrita">
				<? 	if($frmModo=="mostrar"){
					echo ($fila['aprox_coef2']==0)?"NO":"SI";
				}
				if($frmModo=="modificar"){ 
					if($fila['aprox_coef2']==1){ ?>
						<input name="aprox_coef2" type="checkbox" id="aprox_coef2" value="1" <?php echo ($fila['aprox_coef2']==1)?"":"disabled" ?>  <? echo ($fila['aprox_coef2']==1)?"checked":"";?>>
			<?	}else{?>
				<input name="aprox_coef2" type="checkbox" id="aprox_coef2" value="1" <?php echo ($fila['aprox_coef2']==1)?"":"disabled" ?>  <? echo ($fila['aprox_coef2']==1)?"checked":"&nbsp;";?>>
				<? }}
				if($frmModo=="ingresar"){  ?>		
					<input name="aprox_coef2" type="checkbox" disabled id="aprox_coef2">
			<? 	} ?></td>
		    <td class="textonegrita">
             <? 	if($frmModo=="mostrar"){
					echo ($fila['truncado_pu']==0)?"NO":"SI";
				}
				if($frmModo=="modificar"){ 
				if($fila['truncado_pu']==1){ ?>
				
		<input name="truncado_pu" type="checkbox" id="truncado_pu" value="1"  <? echo ($fila['truncado_pu']==1)?"checked":"";?>>
			<?	}else{?>
				<input name="truncado_pu" type="checkbox" id="truncado_pu" value="1"   <? echo ($fila['truncado_pu']==1)?"checked":"&nbsp;";?>>
				<? }}
				if($frmModo=="ingresar"){  ?>		
					<input name="truncado_pu" type="checkbox"  id="truncado_pu">
			<? 	} ?>
            
            
            </td>
		    <td>&nbsp;</td>
		    </tr>
             <tr>
		    <td class="textosimple">Aproximar Notas grupales</td>
		    <td class="textosimple">&nbsp;</td>
		    <td>&nbsp;</td>
		    </tr>
		  <tr>
		    <td class="textonegrita">
				<? 	if($frmModo=="mostrar"){
					echo ($fila['bool_aprgrp']==0)?"NO":"SI";
				}
				if($frmModo=="modificar"){ 
					if($fila['notagrupo']==1){ ?>
						<input name="bool_aprgrp" type="checkbox" id="bool_aprgrp" value="1" <?php echo ($fila['notagrupo']==1)?"":"disabled" ?>  <? echo ($fila['bool_aprgrp']==1)?"checked":"";?>>
			<?	}else{?>
				<input name="bool_aprgrp" type="checkbox" id="bool_aprgrp" value="1" <?php echo ($fila['bool_aprgrp']==1)?"":"disabled" ?>  <? echo ($fila['bool_aprgrp']==1)?"checked":"&nbsp;";?>>
				<? }}
				if($frmModo=="ingresar"){  ?>		
					<input name="bool_aprgrp" type="checkbox" disabled id="bool_aprgrp">
			<? 	} ?></td>
		    <td class="textonegrita">&nbsp;</td>
		    <td>&nbsp;</td>
		    </tr>
		</table>

		</td></tr>
		</table>
		<br>
		<table width="600" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" align="center">
		<tr>
		  <td>
		<table width="590" border="0" cellspacing="0" cellpadding="3" align="center">
		  <tr>
			<td colspan="3" class="textonegrita">EXAMENES</td>
			</tr>
		  <tr>
			<td class="textosimple">Examen de Periodo </td>
			<td class="textosimple">% de Examen </td>
			<td class="textosimple">Nota de Eximisi&oacute;n </td>
		  </tr>
		  <tr>
			<td class="textonegrita">
			<? if($frmModo=="mostrar"){
			   	 echo($fila['conexper']!=1)?"NO":"SI";
				}
				
			if($frmModo=="modificar"){ ?>		
				
            <input type="checkbox" name="conexper" id="conexper" value="1"  onClick="textexamen(this.form);" <? echo ($fila['conexper']==1)?"checked":"&nbsp;";?>>
			
			<?	
			}
			
			if($frmModo=="ingresar"){  ?>
			<input type="checkbox" name="conexper" id="conexper" onClick="textexamen(this.form);">				
			<? } ?>
			
            </td>
			
            <td class="textonegrita">
			<? 	if($frmModo=="mostrar"){
					echo $fila['pct_ex_semestral'];
				}
				if($frmModo=="modificar"){
					if($fila['conexper']==1){	
					?>	
               	<input name="pct_ex_semestral" type="text" id="pct_ex_semestral"  size="10" maxlength="2" value="<? echo $fila['pct_ex_semestral'];?>">
			<?	}else{ ?>
				<input name="pct_ex_semestral" type="text" id="pct_ex_semestral"  size="10" maxlength="2" disabled value="<? echo $fila['pct_ex_semestral'];?>">
				<? } }
				if($frmModo=="ingresar"){  ?>
					<input name="pct_ex_semestral" type="text" id="pct_ex_semestral" size="10" maxlength="2" disabled>	
			<? } ?>	
			</td>
			<td class="textonegrita">
			<? 	if($frmModo=="mostrar"){
					echo $fila['nota_ex_semestral'];
				}
				if($frmModo=="modificar"){ 
					if($fila['conexper']==1){?>
					<input name="nota_ex_semestral" type="text" id="nota_ex_semestral" size="10" maxlength="2"  value="<?=$fila['nota_ex_semestral'];?>">
			<?	}else{?>
				<input name="nota_ex_semestral" type="text" id="nota_ex_semestral" size="10" maxlength="2"  disabled value="<?=$fila['nota_ex_semestral'];?>">
				<? } }
				if($frmModo=="ingresar"){  ?>	
					<input name="nota_ex_semestral" type="text" id="nota_ex_semestral" size="10" maxlength="2" disabled>
			<? 	} ?>
			</td>
		  </tr>
		  <tr>
			<td class="textosimple">Examen Final </td>
			<td class="textosimple">% de Examen </td>
			<td class="textosimple">Nota de Eximisi&oacute;n </td>
		  </tr>
		  <tr>
            <td class="textonegrita">
			<? 	if($frmModo=="mostrar"){
					echo ($fila['conex']!=1)?"NO":"SI";
				}
				if($frmModo=="modificar"){ ?>
					<input name="conEX" type="checkbox" id="conEX" value="1" onClick="jexamenfinal(this.form)" <? echo ($fila['conex']==1)?"checked":"&nbsp;";?>>
			<?	}
				if($frmModo=="ingresar"){  ?>	
					<input name="conEX" type="checkbox" id="conEX" onClick="jexamenfinal(this.form)">
			<? 	} ?>
			</td>
            <td class="textonegrita">
			<? 	if($frmModo=="mostrar"){
					echo $fila['pct_examen'];
				}
				if($frmModo=="modificar"){ 
				if($fila['conex']==1){
				?>
					<input name="txtPCT" type="text" id="txtPCT" size="10" maxlength="2"  value="<?=$fila['pct_examen'];?>">
			<?	}else{?>
				<input name="txtPCT" type="text" id="txtPCT" size="10" maxlength="2"  disabled value="<?=$fila['pct_examen'];?>">
				<? }}
				if($frmModo=="ingresar"){  ?>		
					<input name="txtPCT" type="text" id="txtPCT" size="10"  maxlength="2" disabled>
			<? 	} ?>
			</td>
		    <td class="textonegrita">
			<? 	if($frmModo=="mostrar"){
					echo $fila['nota_exim'];
				}
				if($frmModo=="modificar"){
					if($fila['conex']==1){
					?>
					<input name="txtNEXIM" type="text" id="txtNEXIM" size="10" maxlength="2"  value="<?=$fila['nota_exim'];?>">
			<?	}else{?>
				<input name="txtNEXIM" type="text" id="txtNEXIM" size="10" maxlength="2" disabled value="<?=$fila['nota_exim'];?>">
				<? }}
				if($frmModo=="ingresar"){  ?>
	<input name="txtNEXIM" type="text" id="txtNEXIM" size="10"  maxlength="2" disabled>
			<? 	} ?>
			</td>
		    </tr>
		  <tr>
			<td>&nbsp;</td>
			<td class="textosimple">% Examen Escrito </td>
			<td class="textosimple">% Examen Oral </td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td class="textonegrita">
			<? 	if($frmModo=="mostrar"){
					echo $fila['pct_ex_escrito'];
				}
				if($frmModo=="modificar"){ 
				if($fila['conex']==1){
				?>
					<input name="pct_escrito" type="text" id="pct_escrito" size="10"  maxlength="2" value="<?=$fila['pct_ex_escrito'];?>">
			<?	}else{?>
		<input name="pct_escrito" type="text" id="pct_escrito" size="10"  maxlength="2" disabled value="<?=$fila['pct_ex_escrito'];?>">
				<? }}
				if($frmModo=="ingresar"){  ?>	
					<input name="pct_escrito" type="text" id="pct_escrito" size="10" disabled maxlength="2">
			<? 	} ?>
			</td>
			<td class="textonegrita">
			<? 	if($frmModo=="mostrar"){
					echo $fila['pct_ex_oral'];
				}
				if($frmModo=="modificar"){
					if($fila['conex']==1){
					?>
					<input name="pct_oral" type="text" id="pct_oral" size="10" maxlength="2"  value="<?=$fila['pct_ex_oral'];?>">
			<?	}else{?>
				<input name="pct_oral" type="text" id="pct_oral" size="10" maxlength="2" disabled value="<?=$fila['pct_ex_oral'];?>">
				
				<? }}
				if($frmModo=="ingresar"){  ?>	
					<input name="pct_oral" type="text" id="pct_oral" size="10" maxlength="2" disabled>
			<? 	} ?>
			</td>
		  </tr>
		  <tr>
			<td class="textosimple">Prueba de Nivel </td>
			<td class="textosimple">% Prueba de Nivel </td>
			<td class="textosimple">Prueba Especial</td>
		  </tr>
		  <tr>
			<td class="textonegrita">
			<? 	if($frmModo=="mostrar"){
					echo ($fila['prueba_nivel']==0)?"NO":"SI";
				}
				if($frmModo=="modificar"){ ?>
					<input name="prueba_niv" type="checkbox" id="prueba_niv" value="1" onClick="textpruebadenivel(this.form)" <? echo ($fila['prueba_nivel']==1)?"checked":"&nbsp;";?>>
			<?	}
				if($frmModo=="ingresar"){  ?>		
<input name="prueba_niv" type="checkbox" id="prueba_niv" onClick="textpruebadenivel(this.form)">
			<? 	} ?>
			</td>
			<td class="textonegrita">
			<? 	if($frmModo=="mostrar"){
					echo $fila['pct_nivel'];
				}
				if($frmModo=="modificar"){ 
				if($fila['prueba_nivel']==1){
				?>
				<input name="txtPCTNIV" type="text" id="txtPCTNIV" size="10" maxlength="2" value="<?=$fila['pct_nivel'];?>">
			<?	}else{?>
				<input name="txtPCTNIV" type="text" id="txtPCTNIV" size="10" maxlength="2" disabled value="<?=$fila['pct_nivel'];?>">
				<? }}
				if($frmModo=="ingresar"){  ?>	
					<input name="txtPCTNIV" type="text" id="txtPCTNIV" size="10" maxlength="2" disabled>
			<? 	} ?>
			</td>
			<td class="textonegrita">
            <? 	if($frmModo=="mostrar"){
					echo ($fila['prueba_especial']==0)?"NO":"SI";
				}
				if($frmModo=="modificar"){ 
				if($fila['prueba_especial']==1){
				?>
				<input name="prueba_especial" type="checkbox" id="prueba_especial" value="1" checked>

				<? } else { ?>
					<input name="prueba_especial" type="checkbox" id="prueba_especial" value="1" >
				<?	}
				 }
				if($frmModo=="ingresar"){  ?>	
				<input name="prueba_especial" type="checkbox" id="prueba_especial" value="1">

			<? 	} ?>
            </td>
		  </tr>
		  <tr>
		    <td class="textosimple">Examen Quiz</td>
		    <td class="textosimple">% Examen Quiz</td>
		    <td class="textosimple">Nota de Eximisi&oacute;n Examen Quiz</td>
		    </tr>
		  <tr>
		    <td class="textonegrita">
            <? 	if($frmModo=="mostrar"){
					echo ($fila['conexquiz']==0)?"NO":"SI";
				}
				if($frmModo=="modificar"){ ?>
					<input name="conexquiz" type="checkbox" id="conexquiz" value="1" onClick="textquiz(this.form)" <? echo ($fila['conexquiz']==1)?"checked":"";?>>
			<?	}
				if($frmModo=="ingresar"){  ?>		
<input name="conexquiz" type="checkbox" id="conexquiz" onClick="textquiz(this.form)">
			<? 	} ?>
            </td>
		    <td class="textonegrita">
            <? 	if($frmModo=="mostrar"){
					echo $fila['porc_examen_quiz'];
				}
				if($frmModo=="modificar"){ 
				if($fila['conexquiz']==1){
				?>
					<input name="porc_examen_quiz" type="text" id="porc_examen_quiz" size="10" maxlength="2"  value="<?=$fila['porc_examen_quiz'];?>">
			<?	}else{?>
				<input name="porc_examen_quiz" type="text" id="porc_examen_quiz" size="10" maxlength="2"  disabled value="<?=$fila['porc_examen_quiz'];?>">
				<? }}
				if($frmModo=="ingresar"){  ?>		
					<input name="porc_examen_quiz" type="text" id="porc_examen_quiz" size="10"  maxlength="2" disabled>
			<? 	} ?>
            </td>
		    <td class="textonegrita">
            <? 	if($frmModo=="mostrar"){
					echo $fila['nota_exim_quiz'];
				}
				if($frmModo=="modificar"){
					if($fila['conexquiz']==1){
					?>
					<input name="nota_exim_quiz" type="text" id="nota_exim_quiz" size="10" maxlength="2"  value="<?=$fila['nota_exim_quiz'];?>">
			<?	}else{?>
				<input name="nota_exim_quiz" type="text" id="nota_exim_quiz" size="10" maxlength="2" disabled value="<?=$fila['nota_exim_quiz'];?>">
				<? }}
				if($frmModo=="ingresar"){  ?>
	<input name="nota_exim_quiz" type="text" id="nota_exim_quiz" size="10"  maxlength="2" disabled>
			<? 	} ?>
            
            </td>
		    </tr>
		  <tr>
		    <td class="textosimple">Examen Coef. 2</td>
		    <td class="textosimple">Nota Eximision Coef 2</td>
		    <td class="textosimple">&nbsp;</td>
		    </tr>
		  <tr>
		    <td class="textonegrita">
            	<? 
				if($frmModo=="mostrar"){
					echo ($fila['coef2']==0)?"NO":"SI";
				}
				if($frmModo=="modificar"){ ?>
					<input name="coef2" type="checkbox" id="coef2" value="1" onClick="textcoef(this.form)" <? echo ($fila['coef2']==1)?"checked":"";?>>
			<?	}
				if($frmModo=="ingresar"){  ?>		
					<input name="coef2" type="checkbox" id="coef2" onClick="textcoef(this.form)">
			<? 	} ?>
            
            </td>
		    <td class="textonegrita">
            <? 
				if($frmModo=="mostrar"){
					echo $fila['nota_exim_coef'];
				}
				if($frmModo=="modificar"){ ?>
					<input name="nota_exim_coef" type="text" id="nota_exim_coef"  size="10" maxlength="2" value="<?=$fila['nota_exim_coef'];?>">
			<?	}
				if($frmModo=="ingresar"){  ?>		
					<input name="nota_exim_coef" type="text" id="nota_exim_coef" size="10" maxlength="2" >
			<? 	} ?>
            </td>
		    <td class="textonegrita">&nbsp;</td>
		    </tr>
		  <tr>
		    <td class="textosimple">% Nota Prueba de Unidad</td>
		    <td class="textosimple">% Prueba S&iacute;ntesis</td>
		    <td class="textosimple">&nbsp;</td>
		    </tr>
		  <tr>
		    <td class="textonegrita">
            <? 
				if($frmModo=="mostrar"){
					echo intval($fila['porc_nota_pu']>0)?$fila['porc_nota_pu']:"";
				}
				if($frmModo=="modificar"){ ?>
					<input name="porc_nota_pu" type="text" id="porc_nota_pu"  size="10" maxlength="2" value="<?=$fila['porc_nota_pu'];?>">
			<?	}
				if($frmModo=="ingresar"){  ?>		
					<input name="porc_nota_pu" type="text" id="porc_nota_pu" size="10" maxlength="2" >
			<? 	} ?>
            </td>
		    <td class="textonegrita"><? 
				if($frmModo=="mostrar"){
					echo intval($fila['porc_psintesis']>0)?$fila['porc_psintesis']:"";
				}
				if($frmModo=="modificar"){ ?>
              <input name="porc_psintesis" type="text" id="porc_psintesis"  size="10" maxlength="2" value="<?=$fila['porc_psintesis'];?>">
              <?	}
				if($frmModo=="ingresar"){  ?>
              <input name="porc_psintesis" type="text" id="porc_psintesis" size="10" maxlength="2" >
              <? 	} ?></td>
		    <td class="textonegrita">&nbsp;</td>
		    </tr>
		</table>

		</td></tr>
		</table>
		<br>
		<table width="600" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" align="center">
		<tr><td>
		<table width="590" border="0" cellspacing="0" cellpadding="3">
		  <tr>
			<td colspan="3" class="textonegrita">MODO EVALUACI&Oacute;N </td>
			</tr>
		  <tr>
			<td class="textosimple">General</td>
			<td class="textosimple">Prueba de Nivel </td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td class="textonegrita"><?php if($frmModo=="ingresar"){ ?>
												<Select name="cmbMODO" >
												<option value=0 selected>Seleccionar Modo</option>
													<option value=1 selected>Numérico</option>
													<option value=2 >Conceptual (I,S,B,MB)</option>
													<option value=3 >Numérico-Conceptual (I,S,B,MB)</option>
													<option value=4 >Conceptual (I,S,B,MB)-Numérico</option>
													<option value=5 >Conceptual Especial (SIGLAS) </option>
												</Select>
											<?php };?>
											<?php if($frmModo=="mostrar"){ 
											 $qry="SELECT ramo.modo_eval FROM ramo WHERE id_ramo =".$_RAMO;
				  								$result =@pg_Exec($conn,$qry);
												for($i=0 ; $i < @pg_numrows($result) ; $i++){
												$fila = pg_fetch_array($result,$i);?>
												<FONT face="arial, geneva, helvetica" size=2><strong>
												<?php
													switch ($fila['modo_eval']) {
														 case 0:
															 imp('<span class="EstiloMODO">ADVERTENCIA: DEBE DEFINIR MODO DE EVALUACIÓN</spam>');
															 break;
														 case 1:
															 imp('Numérico');
															 break;
														 case 2:
															 imp('Conceptual (I,S,B,MB)');
															 break;
														 case 3:
															 imp('Numérico-Conceptual (I,S,B,MB)');
															 break;
														 case 4:
															 imp('Conceptual (I,S,B,MB)-Numérico');
															 break;
														 case 5:
															 imp('Conceptual Especial (SIGLAS)');
															 break;	 
													 };?>
												</strong></font>
												<?php }
														}?>
											<?php if($frmModo=="modificar"){ ?>
												<Select name="cmbMODO" >
											<option value=0 <?php echo ($fila['modo_eval'])==0?"selected":"" ?>>Seleccione Modo</option>		
											<option value=1 <?php echo ($fila['modo_eval'])==1?"selected":"" ?>>Numérico</option>
											<option value=2 <?php echo ($fila['modo_eval'])==2?"selected":"" ?>>Conceptual (I,S,B,MB)</option>
											<option value=3 <?php echo ($fila['modo_eval'])==3?"selected":"" ?>>Numérico-Conceptual (I,S,B,MB)</option>
											<option value=4 <?php echo ($fila['modo_eval'])==4?"selected":"" ?>>Conceptual (I,S,B,MB) -Numérico</option>
											<option value=5 <?php echo ($fila['modo_eval'])==5?"selected":"" ?>>Conceptual Especial (SIGLAS)</option>
												</Select>
											    <?php };?>
			</td>
			<td class="textonegrita"><?php if($frmModo=="ingresar"){ ?>						
                      <Select name="cmbMODOpruebaNivel" disabled >
								<option value=0 selected></option>
								<option value=1 >Numérico</option>
								<option value=2 >Conceptual</option>
					  </Select>
						<?php };?>
						<?php 
							if($frmModo=="mostrar" AND $fila1['prueba_nivel']==1){ ?>
							<strong><FONT face="arial, geneva, helvetica" size=2><?php
								switch ($fila1['modo_eval_pnivel']) {
									 case 0:
										 imp('INDETERMINADO');
										 break;
									 case 1:
										 imp('Numérico');
										 break;
									 case 2:
										 imp('Conceptual');
										 break;
								 };?>
							</font></strong>
							<?php };
						?>
						<?php if($frmModo=="modificar"){
							if($fila['prueba_nivel']==1){ ?>
							<Select name="cmbMODOpruebaNivel">
								<option value=0 ></option>
						<option value=1 <?php echo ($fila['modo_eval_pnivel'])==1?"selected":"" ?>>Numérico</option>
						<option value=2 <?php echo ($fila['modo_eval_pnivel'])==2?"selected":"" ?>>Conceptual</option>
							</Select>
				  <?php }else{;?>	
                  <Select name="cmbMODOpruebaNivel" disabled >
								<option value=0></option>
						<option value=1 <?php echo ($fila['modo_eval_pnivel'])==1?"selected":"" ?>>Numérico</option>
						<option value=2 <?php echo ($fila['modo_eval_pnivel'])==2?"selected":"" ?>>Conceptual</option>
							</Select>		
						 
							
				  <?php }};?>			
				  	  </TD>
                      
				
         <? //	}	// fin if para restringir prueba de nivel  ?>
			
			<td>&nbsp;</td>
		  </tr>
		</table>

		</td></tr>
		</table>
		<br>
<table width="600" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" align="center">
		<tr>
		  <td>
		<table width="590" border="0" cellspacing="0" cellpadding="3">
		  <tr>
			<td colspan="3" class="textonegrita">PROFESOR </td>
			</tr>
		  <tr>
			<td class="textosimple">Docente</td>
			<td class="textosimple">Ayudante</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td class="textonegrita">
			<?php 
												$qry5="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM empleado,trabaja, institucion   WHERE (((institucion.rdb)=".$institucion.") AND (empleado.rut_emp = trabaja.rut_emp) AND (trabaja.rdb = institucion.rdb)) ORDER BY empleado.ape_pat,empleado.ape_mat ASC";
												//if($_PERFIL==0){echo $qry5;}
												$result5 =@pg_Exec($conn,$qry5);
												if (!$result5) 
													error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
												else{
													if (pg_numrows($result5)!=0){
														$fila5 = @pg_fetch_array($result5,0);
														if (!$fila5){
															error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
															exit();
														};
													}
												}
												if($frmModo=="ingresar"){?>
												<Select name="cmbDOC" id="cmbDOC">
											<option value=0>SELECCIONE DOCENTE</option>
													

											<?php
															for($i=0 ; $i < @pg_numrows($result5) ; $i++){
																$fila1 = @pg_fetch_array($result5,$i);
																echo  "<option value=".$fila1["rut_emp"].">".$fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_emp"]."</option>";
															}
														};
													?>
												</Select>
											
											<?php 
																	
											 	$qry2="SELECT empleado.rut_emp,empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM empleado, dicta, ramo  WHERE (((ramo.id_ramo)=".$ramo.") AND dicta.rut_emp = empleado.rut_emp AND dicta.id_ramo = ramo.id_ramo) ORDER BY empleado.ape_pat,empleado.ape_mat ASC";
											 	$result2 =@pg_Exec($conn,$qry2);
												$fila2 = @pg_fetch_array($result2,0);	

												

	if($frmModo=="mostrar"){ 
												
if ($fila2["ape_pat"]==NULL or trim($fila2["ape_pat"])==""){ ?>
<FONT face="arial, geneva, helvetica" size=2  color="FF0000" ><strong>
¡Falta Asignar Docente de Asignatura!
</strong></font>
<?    
}else{  ?>
<FONT face="arial, geneva, helvetica" size=2  color="000000" ><strong>
<? echo ($fila2["ape_pat"]." ".$fila2["ape_mat"].", ".$fila2["nombre_emp"]); ?>
</strong></font>
<?	}  

}				
												
	
	?>
	<?php if($frmModo=="modificar"){?>
	<Select name="cmbDOC">
	<option value="0">SELECCIONE DOCENTE</option>
	
	<?php
	for($i=0 ; $i < @pg_numrows($result5) ; $i++){
	$fila5 = @pg_fetch_array($result5,$i);
	if($fila2['rut_emp']!=$fila5['rut_emp']){
		echo  "<option value=".$fila5["rut_emp"].">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
	}else{
		echo  "<option value=".$fila5["rut_emp"]." selected>".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
	}
	}
	};
	?>
	</Select>							
			
			
			</td>
			<td class="textonegrita">
		<?php if($frmModo=="ingresar"){ ?>
<Select name="cmbAYU">
<option value=0 selected></option>
<?php
for($i=0 ; $i < @pg_numrows($result5) ; $i++){
    $fila1 = @pg_fetch_array($result5,$i);
    echo  "<option value=".$fila1["rut_emp"].">".$fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_emp"]."</option>";
}
};
?>
</Select>

<?php if($frmModo=="mostrar"){
	
$qry="SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, ayuda.id_ramo FROM ayuda INNER JOIN empleado ON ayuda.rut_emp = empleado.rut_emp WHERE (((ayuda.id_ramo)=".$ramo.")) ORDER BY empleado.ape_pat,empleado.ape_mat ASC";
	$result =@pg_Exec($conn,$qry);
	if (!$result) 
	error('<B> ERROR :</b>Error al acceder a la BD. (13)</B>');
	else{
	if (pg_numrows($result)!=0){
	$fila1 = @pg_fetch_array($result,0);	
	if (!$fila1){
	error('<B> ERROR :</b>Error al acceder a la BD. (14)</B>');
	exit();
	};
	
	?>
	<FONT face="arial, geneva, helvetica" size=2  color="000000" ><strong>
	 <? echo ($fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_emp"]); ?>
	</strong></font>
	<?
	
	
	};
	};
	?>
													
											<?php };?>
											<?php if($frmModo=="modificar"){?>
											<select name="cmbAYU" id="cmbAYU" >
											  <option value=0 ></option>
											  ;
													
<?php 
// ACTAL AYUDANTE DEL RAMO
$qry8="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, ayuda.id_ramo FROM ayuda INNER JOIN empleado ON ayuda.rut_emp = empleado.rut_emp WHERE (((ayuda.id_ramo)=".$ramo.")) ORDER BY empleado.ape_pat,empleado.ape_mat ASC";
$result8 =@pg_Exec($conn,$qry8);
$fila8  = @pg_fetch_array($result8,0);

for($i=0 ; $i < @pg_numrows($result5) ; $i++){
	$fila5 = @pg_fetch_array($result5,$i);
	if($fila8["rut_emp"]!=$fila5["rut_emp"]){
                                                                   
echo  "<option value=".$fila5["rut_emp"].">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
	}else{
echo  "<option value=".$fila5["rut_emp"]." selected>".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";

					}
				}
		};
		
		?>
		</select></td>
			<td>&nbsp;</td>
		  </tr>
		</table>

		</td></tr>
		</table>
		<br>



	    <? if($frmModo=="modificar"){
	  		$sql = "SELECT * FROM examen_semestral WHERE id_ramo=".$_RAMO;
			$rs_examen = pg_exec($conn,$sql)or die("Fallo 400".$sql);
			
			?>
	  <table width="560" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#333333" style="border-collapse:collapse;;display:none">
	  <tr>
		<td><table width="100%" id="examenes_semestrales" border="0" align="center" bordercolor="#000000">
			  <tr>
				<td colspan="2"><strong><font face="Verdana, Arial, Helvetica, sans-serif" size="1">CONFIGURACI&Oacute;N ESPECIAL </font></strong></td>
				</tr>
			  <tr>
				<td colspan="2">&nbsp;</td>
				</tr>
			  <tr>
				<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">PORCENTAJE PROMEDIO NOTAS PARCIALES </font></td>
				<td width="44%" colspan="2"><input name="txtPCTEX" type="text" id="txtPCTEX" value="<? if($fila['porc_examen']==NULL) echo "100"; else echo $fila['porc_examen'];?>" size="10" maxlength="3"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">%</font></td>
			  </tr>
			  <tr>
				<td colspan="2"><hr></td>
				</tr>
			  <tr>
				<td colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">EXAMENES SEMESTRALES </font></td>
				</tr>
			  <tr>
				<td width="56%">&nbsp;</td>
				<td colspan="2">
					<? if(@pg_numrows($rs_examen)==0){ ?> <input name="agrega" id="agrega" type="button" value="Agregar" class="botonXX" onClick="insRow('mytable')">
					 <input name="elimina" type="button" value="Eliminar" class="botonXX" onClick="delRow('mytable')">
					<? }else{ 
						echo "&nbsp;";
					} ?> 
				</td>
				</tr>
			  <tr>
				<td colspan="2">
				<? if(@pg_numrows($rs_examen)==0){?>
				<table width="95%" >
						  <tr>
							<td width="33%" class="Estilo5"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">NOMBRE</font></td>
							<td width="33%" class="Estilo5"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">PORCENTAJE(%)</font></td>
						  </tr>
						  <tr>
								<td colspan="3"><table id="mytable" width="100%">
								</table></td>
						  </tr>
						  <tr>
							<td colspan="2">&nbsp;</td>
						  </tr>
				   </table>
				  <? } ?>
				   <? if(pg_numrows($rs_examen)!=0){?>
				   <table width="95%" >
						  <tr>
							<td width="33%" class="Estilo5"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">NOMBRE</font></td>
							<td width="33%" class="Estilo5"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">PORCENTAJE(%)</font></td>
						    <td width="33%" class="Estilo5">&nbsp;</td>
						  </tr>
						  <? for($v=0;$v<pg_numrows($rs_examen);$v++){
						  		$fils_examen=@pg_fetch_array($rs_examen,$v);?>
						  <tr>
								<td><input name="nombre2[<? echo $v;?>]" value="<?=$fils_examen['nombre'];?>" type="text"></td>
								<td><input name="sigla[<? echo $v;?>]" value="<?=$fils_examen['porc'];?>" type="text"></td>
								<td><input type="button" name="elim" value="E" onClick="javascript:eliminar(<? echo $fils_examen['id_examen'];?>);"></td>
								<input type="hidden" name="id_examen<?=$v;?>" value="<?=$fils_examen['id_examen'];?>">
						  </tr>
						  <? } ?>
						  <tr>
							<td colspan="3">&nbsp;</td>
						  </tr>
				   </table>
				   <? } ?>
					</td>
			   </tr>
			  <tr>
				<td colspan="2"><hr></td>
				</tr>
			  <tr>
				<td colspan="2"><input name="aprox_prom" type="checkbox" id="aprox_prom" value="1">
				  <font face="Verdana, Arial, Helvetica, sans-serif" size="1">APROXIMA PROMEDIO FINAL </font></td>
				</tr>			  
			</table></td>
	  </tr>
	</table>
					
				
				<? }?>
 <? if($frmModo=="mostrar"){
	  		$sql = "SELECT * FROM examen_semestral WHERE id_ramo=".$_RAMO;
			$rs_examen = pg_exec($conn,$sql)or die("Fallo 4000".$sql);
			$Aprox = @pg_result($rs_examen,5);
			
			?>
	  <table width="600" border="1" align="center" cellpadding="0" cellspacing="0"  style="border-collapse:collapse">
	  <tr>
		<td><table width="100%" border="0" align="center" bordercolor="#000000">
			  <tr>
				<td colspan="2"><strong><font face="Verdana, Arial, Helvetica, sans-serif" size="1">CONFIGURACI&Oacute;N ESPECIAL </font></strong></td>
				</tr>
			  <tr>
				<td colspan="2">&nbsp;</td>
				</tr>
			  <tr>
              
<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">PORCENTAJE PROMEDIO NOTAS PARCIALES </font></td>
<td width="44%" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?=$fila_ramo['porc_examen'];?>%</font></td>
			  </tr>
              
			  <tr>
				<td colspan="2"><hr></td>
				</tr>
			  <tr>
				<td colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">EXAMENES SEMESTRALES </font></td>
				</tr>
			  <tr>
				<td width="56%">&nbsp;</td>
				<td colspan="2">&nbsp;</td>
				</tr>
			  <tr>
				<td colspan="2"><table width="95%" >
						  <tr>
							<td width="33%" class="Estilo5"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">NOMBRE</font></td>
							<td width="33%" class="Estilo5"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">PORCENTAJE(%)</font></div></td>
						  </tr>
						  <? for($i=0;$i<@pg_numrows($rs_examen);$i++){
						  		$fils_examen = @pg_fetch_array($rs_examen,$i);
						?>
						  <tr>
							<td align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?=$fils_examen['nombre'];?></font></td>
							<td align="right"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
							  <?=$fils_examen['porc'];?>
							  %</font></div></td>
						   </tr>
						 <? } ?>
			  <tr>
				<td colspan="2"><hr></td>
				</tr>
			  <tr>
				<td colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">APROXIMA PROMEDIO FINAL <b> <? if($Aprox==1) echo "SI"; else echo "NO";?></b></font></td>
				</tr>
			  
			</table></td>
	  </tr>
	</table>
</form>
					
					
				
				<? }?>
<? 

pg_close($conn);
?>

                        <!-- FIN CODIGO ANTIGUO -->
						        </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"> <? include("../../../../../cabecera/menu_inferior.php"); ?></td>
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