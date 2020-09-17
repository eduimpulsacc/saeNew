<?php 	require('../../../../util/header.inc');
		require('../../../../util/LlenarCombo.php3');
		require('../../../../util/SeleccionaCombo.inc');
?>
<?php 
    
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	$ext1			=$ext;
	$_PERFIL;
	$_POSP          =4;
	$_MDINAMICO     =1;
	if($_PERFIL==26)
	{
		$_MDINAMICO     =0;		
	}
	if($_PERFIL==0){
		echo $curso;
		}

	//-------
	$sqlCurso = "select institucion.nombre_instit, ano_escolar.nro_ano from institucion, ano_escolar where institucion.rdb = '$institucion' and ano_escolar.id_ano = '$ano'";
	$rsCurso =  @pg_Exec($conn,$sqlCurso);												
	$fCurso2 =  @pg_fetch_array($rsCurso,0);		
	//-------		
	
 $qryIns="select tipo_instit from institucion where rdb=".$institucion;
		 $resultIns = @pg_exec($conn,$qryIns);
		  $filaIns	= @pg_fetch_array($resultIns,0);
		    $Tipo_Ins = $filaIns['tipo_instit'];
		
		//ano
		 $sql_y="select nro_ano from ano_escolar where id_ano=$ano";	
		 $resultY = @pg_exec($conn,$sql_y);
		  $nro_ano=pg_result($resultY,0);
/************ PERMISOS DEL PERFIL *************************/
if($_PERFIL==0){
	$ingreso = 1;
	$modifica =1;
	$elimina =1;
	$ver =1;
}else{
	/*if($nw==1){
		$_MENU =$menu;
		session_register('_MENU');
		$_CATEGORIA = $categoria;
		session_register('_CATEGORIA');
	}*/
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}

	?>
<script type="text/javascript" src="../../../clases/jquery/jquery.js"></script>
<script language="javascript">
$(document).ready(function() {
	
	
	
$( "#fecha_inicio,#fecha_termino" ).datepicker({
    'dateFormat':'dd/mm/yy',
	firstDay: 1,
	changeMonth: true,
	//changeYear: true,
	showOn: "both",
    buttonImage: "../../../clases/img_jquery/Calendario.PNG",
   // buttonImageOnly: true,
	//yearRange: "<?php echo $nro_ano ?>:<?php echo $nro_ano ?>",
	minDate: new Date('<?php echo $nro_ano ?>/01/01'),
	maxDate: new Date('<?php echo $nro_ano ?>/12/31'),
	dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    // Dias cortos en castellano
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    // Nombres largos de los meses en castellano
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    // Nombres de los meses en formato corto 
    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec" ]
	
});

//$.datepicker.regional['es']	


});

</script>
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
					if (form.cmbPLAN.value!=0){
						form.cmbPLAN.target="self";
						//form.action = form.cmbPERIODO.value;
						form.action = 'curso.php3?institucion=<?php echo $institucion ?>';
						form.submit(true);
					 }	
			      }
			
			function enviapagENS(form){
					if (form.cmbENS.value!=0){
						form.cmbENS.target="self";
						//form.action = form.cmbPERIODO.value;
						form.action = 'curso.php3?institucion=<?php echo $institucion ?>';
						form.submit(true);
						}	
					}
			
			function enviapagSEC(form){
			if (form.cmbSEC.value!=0){
				form.cmbSEC.target="self";
                //form.action = form.cmbPERIODO.value;
				form.action = 'curso.php3?institucion=<?php echo $institucion ?>';
				form.submit(true);
			  }	
			}
	
	function Confirmacion(){
		if(confirm('¿ESTA SEGURO DE ELIMINAR ESTOS DATOS?') == false){ return; };
			document.location="seteaCurso.php3?caso=9"
		};
	function Abrir_ventana (pagina) {
	var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=300, height=266, top=85, left=140";
	window.open(pagina,"",opciones);
	}
</SCRIPT>
<?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../index.php";
		 </script>

<? } ?>			

<?php
	if($frmModo!="ingresar"){
		//EL MISMO PROBLEMA QUE PASA AL LISTAR -- TIPO_ENSENANZA WHERE COD_TIPO=".$fila['ensenanza'];
		 $qry="select curso.*, plan_estudio.*, tipo_ensenanza.* from curso, plan_estudio, tipo_ensenanza where curso.id_curso = ".$_CURSO." and plan_estudio.cod_decreto = curso.cod_decreto and curso.ensenanza = tipo_ensenanza.cod_tipo ";
		/*$qry ="select curso.*, plan_estudio.*, tipo_ensenanza.* from curso, plan_estudio, tipo_ensenanza , plan_inst 
where curso.id_curso = ".$_CURSO." and plan_estudio.cod_decreto = curso.cod_decreto 
and curso.ensenanza = tipo_ensenanza.cod_tipo and plan_estudio.rdb=plan_inst.rdb
and plan_estudio.cod_decreto=plan_inst.cod_decreto
and plan_inst.rdb=".$institucion;*/

		/*if($_PERFIL==0)
			echo $qry;*/
			
		$result =@pg_Exec($conn,$qry);
		$fila = @pg_fetch_array($result,0);	
		$fCurso = @pg_fetch_array($result,0);	
	}
?>

<?php 	function TieneNotas($id_insti,$id_ano,$id_curso,$conn){
			$SQL="select max(id_periodo)as id_periodo from periodo where id_ano=".$id_ano ;
			$rs_existenota = @pg_exec($conn,$SQL);
			$fila = @pg_fetch_array($rs_existenota,0);
			if (!$rs_existenota){
				error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>');
				exit();
			};
			$SQLE="select fecha_termino from periodo where id_periodo=".$fila['id_periodo'] ;
			$existenota = @pg_exec($conn,$SQLE);
			$filaE = @pg_fetch_array($existenota,0);
			if (!$existenota){
				error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>');
				exit();
			};
			
			$actual=strftime("%Y-%m-%d");
			if ($actual>=$filaE['fecha_termino']){
			return true;
			}else{
				return false;
			};

			
			/*$SQL="select distinct(id_periodo) as id_periodo from notas where id_periodo IN (select id_periodo from periodo where id_ano=".$id_ano.") and rut_alumno IN (select rut_alumno from matricula where rdb=".$id_insti." and id_ano=".$id_ano." and id_curso=".$id_curso.")";
			$rs_existenota = @pg_exec($conect,$SQL);
			if (!$rs_existenota){
				error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>');
				exit();
			};
			
			$contper = 0; /*--- Contador de periodos en la tabla califica ---*/
		/*	if (@pg_numrows($rs_existenota)!=0){
				$fila = @pg_fetch_array($rs_existenota,0);
				if (!$fila){
						error('<B> ERROR :</b>Error al acceder a la BD. (22)</B>');
						exit();
				}
				for($i=0;$i<@pg_numrows($rs_existenota);$i++){
					$fila = @pg_fetch_array($rs_existenota,$i);
					$contper = $contper + 1;
				};
			};
			$SQL = "SELECT Count(periodo.id_periodo) AS periodo FROM periodo WHERE (((periodo.id_ano)=" . $id_ano . ")) GROUP BY periodo.id_ano";
			$rs_periodo = @pg_exec($conect,$SQL);
			if (!$rs_periodo){
				error('<B> ERROR :</b>Error al acceder a la BD. (23)</B>');
				exit();
			};
			$cuentper = 0; /*--- Cuenta los periodos de la tabla original ---*/
		/*	if (@pg_numrows($rs_periodo)!=0){
				$fila1 = @pg_fetch_array($rs_periodo,0);
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (24)</B>');
					exit();
				};
				$cuentper = intval(trim($fila1['periodo']));
			};

			//echo($contper."-".$cuentper);
			//exit();
			if ((intval($contper)==intval($cuentper)) && ($contper!=0 && $cuentper!=0)){
				return true;
			}else{
				return false;
			};*/
		}; 

?>

		<!--<LINK REL="STYLESHEET" HREF="../../../../util/td.css" TYPE="text/css">-->
		
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>

	<?php if($Tipo_Ins==1 ||($Tipo_Ins==3)){//COLEGIO oo escuela?>
		<SCRIPT language="JavaScript">
			function chkENS(form){
				tipo=form.cmbENS.value;
				if((tipo==10)||(tipo==20)||(tipo==30)||(tipo==40)||(tipo==50)||(tipo==60)){//SALA CUNA MENOR A KINDER
					form.cmbEVAL.disabled=true;
					form.cmbPLAN.disabled=true;
					form.cmbEVAL.value=0;
					form.cmbPLAN.value=0;
					}else{
					form.cmbEVAL.disabled=false;
					form.cmbPLAN.disabled=false;
					form.cmbEVAL.selectedIndex=0;
					form.cmbPLAN.selectedIndex=0;
				};
			};
		</SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
			
			if(!chkSelect(form.cmbPLAN,'Seleccionar PLAN del curso.')){
				return false;
			};
			if(!chkSelect(form.cmbENS,'Seleccionar TIPO DE ENSEÑANZA del curso.')){
				return false;
			};
			if(!chkSelect(form.cmbLETRA,'Seleccionar LETRA del curso.')){
				return false;
			};
			if(!chkSelect(form.cmbGRA,'Seleccionar GRADO del curso.')){
				return false;
			};

			if(!chkSelect(form.cmbSEC,'Seleccionar SECTOR ECONOMICO.')){
				return false;
			};
			if(!chkSelect(form.cmbESP,'Seleccionar ESPECIALIDAD.')){
				return false;
			};
			if(!chkSelect(form.cmbSUP,'Seleccionar SUPERVISOR del curso.')){
				return false;
			};
			if(!chkVacio(form.txtGRA,'Ingresar GRADO del curso.')){
				return false;
			};
			if(!nroOnly(form.txtGRA,'Se permiten sólo números para el GRADO del curso.')){
				return false;
			};
			if(!nroOnly(form.txtPCT,'Se permiten sólo números para el Porcentaje de Exámen.')){
				return false;
			};
			if(!nroOnly(form.txtNEXIM,'Se permiten sólo números para la Nota de Eximición.')){
				return false;
			};
			
			//if(!chkVacio(form.txtLETRA,'Ingresar LETRA del curso.')){
				//return false;
			//};
			//if(!letraOnly(form.txtLETRA,'Se permiten sólo letras para la LETRA del curso.')){
			   //return false;
			//};
			if(!chkSelect(form.cmbENS,'Seleccionar TIPO DE ENSEÑANZA del curso.')){
				return false;
			};

			if(!form.cmbPLAN.disabled){
				if(!chkSelect(form.cmbPLAN,'Seleccionar DECRETO DE PLAN DE ESTUDIO del curso.')){
					return false;
				};
			};
			if(!form.cmbEVAL.disabled){
				if(!chkSelect(form.cmbEVAL,'Seleccionar DECRETO DE EVALUACION del curso.')){
					return false;
				};
			};
			
			
			if(!chkVacio(form.fecha_inicio,'Ingresar FECHA INICIO del curso.')){
				return false;
			};
			
			if(!chkVacio(form.fecha_termino,'Ingresar FECHA TERMINO del curso.')){
				return false;
			};

			if(!chkSelect(form.cmbSUP,'Seleccionar SUPERVISOR del curso.')){
				return false;
			};
				return true;
			}
			
			
			
		</SCRIPT>
	<?php }//FIN COLEGIO?>
	<?php if(($Tipo_Ins==2)){//JARDIN O SALA CUNA?>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtGRA,'Ingresar GRADO del curso.')){
					return false;
				};
				if(!nroOnly(form.txtGRA,'Se permiten sólo números para el GRADO del curso.')){
					return false;
				};
				if(!chkSelect(form.cmbENS,'Seleccionar TIPO DE ENSEÑANZA del curso.')){
					return false;
				};
				if(!chkSelect(form.cmbSUP,'Seleccionar SUPERVISOR del curso.')){
					return false;
				};
				return true;
			}
		</SCRIPT>
	<?php }//FIN JARDIN O SALA CUNA?>
<?php }?>
	
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FF0000;
}
.Estilo3 {color: #FF0000}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral=2; include ("../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390"><!-- inicio codigo nuevo -->
								  
             <div id="gif_sige" style="text-align:right"><img src="../../../clases/soap/gif_sige.gif"></div>                     
                                  
                                  
			 <FORM method=post name="frm" action="procesoCurso.php3">
	
	        <input type="hidden" value="<?=$institucion ?>" name="rdb">
			<input type="hidden" value="<?=$ano ?>" name="ano">
	         
			<TABLE WIDTH=100% BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
			<TR>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
                      <TR>
                        <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>A&Ntilde;O ESCOLAR</strong> </FONT> </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> </TD>
                        <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> <?php echo trim($fCurso2['nro_ano']); ?> </strong> </FONT> </TD>
                      </TR>
                    </TABLE></TD>
			</TR>
			<TR height=15>
				
      <TD> 
        <TABLE WIDTH="100%" height="100%" BORDER=0 align="center" CELLPADDING=5 CELLSPACING=5>
						<TR height="50" >
							<TD align=right colspan=2>
								<?php if($frmModo=="ingresar"){ 
										if($ingreso==1 || $_PERFIL==0){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
                                    <INPUT class="botonXX"  TYPE="submit" value="GUARDAR EN SIGE"  name="btnGuardarSige" onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarCursos.php3">&nbsp;
								<?php 	}
									  };//FIN INGRESAR	?>
								
								
								<?php if($frmModo=="mostrar"){ ?>
									<!--PENDIENTE POR MUCHO ENRREDO-->
									<?
									if ($_PERFIL==19 and $_INSTIT != 516){ ?>
									     <input class="botonXX" type="button" value="ASISTENCIA" onClick=parent.location.href="asistencia/asistencia.php3">
								  <? } ?>							
									
									
									<?php if($_PERFIL==17){ ?>
									
              		<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=parent.location.href="../../../../session/perfilDocente.php3">
              <?php }?>
              <?php if($modifica==1)if($_PERFIL!=17 ){?>
              		<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaCurso.php3?curso=<?php echo $curso?>&caso=3">
              &nbsp; 
              <?php } ?>
              
              <?php if($elimina==1 and $_PERFIL==0){ //ACADEMICO Y LEGAL ?> 
            		<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick="Confirmacion()">&nbsp;
			  
			        <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarCursos.php3">
                    
              &nbsp;
					<?php }?>	
                   <?php  if($_PERFIL==14){?>
                    <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarCursos.php3">
                    <?php }?>
              &nbsp;		
								<?php };//FIN MOSTRAR	?>
								
								
								<?php if($frmModo=="modificar"){ 
										if($modifica==1 || $_PERFIL==0){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="listarCursos.php3">&nbsp;
								<?php 	}
									  };?>							</TD>
						</TR>
						<TR height=20>
							<TD align=middle colspan=2 class="tableindex">
								CURSO							</TD>
						</TR>
						<TR>
							
						<TD width="100%" colspan="2">
			<TABLE width="100%" BORDER=0 CELLPADDING=2 CELLSPACING=2>
                <TR>
					
                  <TD width="298" class="cuadro02">&nbsp;PLAN DE ESTUDIO&nbsp;				  </TD>
					<TD width="241" class="cuadro02">&nbsp;TIPO DE ENSEÑANZA&nbsp; 
						</FONT>					</TD>
				</TR>
				<TR>
                 	 <TD class="datosb"> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <select name="cmbPLAN" onChange="enviapag(this.form);">
                      <option value=0 selected>Selecione Plan de Estudio</option>
                      <?php 
							$sql="select distinct plan_inst.cod_decreto, plan_estudio.cursos, plan_estudio.nombre_decreto from (plan_estudio inner join plan_inst on plan_inst.cod_decreto=plan_estudio.cod_decreto) where plan_inst.rdb =" . $institucion;
							$result= @pg_Exec($conn,$sql);
								for($i=0 ; $i < @pg_numrows($result) ; $i++){
									$fila = @pg_fetch_array($result,$i);
										if ($fila["cod_decreto"]==$cmbPLAN){
											echo  "<option selected value=".$fila["cod_decreto"]." >".$fila["nombre_decreto"]."</option>";
										}else{
											echo  "<option value=".$fila["cod_decreto"]." >".$fila["nombre_decreto"]."</option>";
										}
													
								}
						?>
                    </select> 
                    <?php 

																	if($Tipo_Ins==2){//JARDIN INFANTIL
																		if(($fila["cod_tipo"]<100))
																			echo  "<option value=".$fila["cod_tipo"].">".$fila["nombre_tipo"]."</option>";
																	}
																	if($Tipo_Ins==3){//SALACUNA
																		if($fila["cod_tipo"]<=40) // SOLO SALACUNA
																			echo  "<option value=".$fila["cod_tipo"].">".$fila["nombre_tipo"]."</option>";
																	}

													?>
												</Select>
                    <?php };?>
                    <?php 
										if($frmModo=="mostrar"){ ?> <FONT face="arial, geneva, helvetica" size=2><strong> <?php 
													echo trim($fCurso['nombre_decreto'])." (".trim($fCurso['cursos']).")";
											};
											?></strong></font>
                    <?php  if($frmModo=="modificar"){ ?> <FONT face="arial, geneva, helvetica" size=2><strong> <?php 
							echo trim($fCurso['nombre_decreto'])." (".trim($fCurso['cursos']).")";
						?>
						</strong></font>
						<?php
						};

						?>                  </TD>
				  <TD class="datosb">
                    <?php if($frmModo=="ingresar"){?>
					<FONT face="arial, geneva, helvetica" size=1 color=#000000>
					<select name="cmbENS" onChange="enviapagENS(this.form);">
						<option value=0 selected>Seleccione Tipo de Enseñanza</option>
                      <?php 
							$sqlENS="select distinct tipo_ensenanza.cod_tipo, tipo_ensenanza.nombre_tipo from (tipo_ensenanza inner join tipo_ense_inst on tipo_ensenanza.cod_tipo=tipo_ense_inst.cod_tipo) where tipo_ense_inst.cod_decreto=".$cmbPLAN." and tipo_ense_inst.estado<>2 and tipo_ense_inst.rdb=".$institucion;
							$resultENS= @pg_Exec($conn,$sqlENS);
								for($i=0 ; $i < @pg_numrows($resultENS) ; $i++){
									$filaENS = @pg_fetch_array($resultENS,$i);
										if ($filaENS["cod_tipo"]==$cmbENS){
											echo  "<option selected value=".$filaENS["cod_tipo"]." >".$filaENS["cod_tipo"]." - ".$filaENS["nombre_tipo"]."</option>";
										}else{
											echo  "<option value=".$filaENS["cod_tipo"]." >".$filaENS["cod_tipo"]." - ".$filaENS["nombre_tipo"]."</option>";
										}
													
								}
						?>
                    </select>	
					</font>
					<?php 
					
						};
						
						if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
							echo trim($fCurso['cod_tipo']);
							echo " - ";
							
							echo trim($fCurso['nombre_tipo']);
						};?>
					</strong></font>
					<?php

					if($frmModo=="modificar"){ ?> <FONT face="arial, geneva, helvetica" size=2><strong> <?php
							echo trim($fCurso['nombre_tipo']);
							}?>
							
					</strong>
                    </font>
                    </TD>
				    </TR>
					</TABLE>	
                    </TD>
					</TR>
                    
	<?php if($Tipo_Ins==1){//COLEGIO?>
		<?php
			//TIPO DE ENSEÑANZA AL QUE CORRESPONDE
			$qry="SELECT curso.*, tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
			$result =@pg_Exec($conn,$qry);
			$fila4= @pg_fetch_array($result,0);
		?>
		<?php //if(($fila4["cod_tipo"]!=10)&&($fila4["cod_tipo"]!=20)&&($fila4["cod_tipo"]!=30)&&($fila4["cod_tipo"]!=40)&&($fila4["cod_tipo"]!=50)&&($fila4["cod_tipo"]!=60)){//ENSEÑANZA KINDER U OTRO CABRO CHICO
		  ?>
						
			<?php if ((($cmbENS>310) or ($fila['ensenanza']>310)) and ($cmbENS!=360) and ($cmbENS!=361) and ($cmbENS!=960) and ($cmbENS!=363) ) { ?>
						<TR>
				
		<TD>
			<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width=100%>
				<TR>
										
                  <TD width="27%" height="15" class="cuadro02"> SECTOR ECONOMICO</TD>
				
				  <TD width="35%" class="cuadro02">ESPECIALIDAD</TD>
				</TR>
				<TR>
										
                  <TD class="datosb"> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <select name="cmbSEC" onChange="enviapagSEC(this.form);">
                      <option value=0 selected>Seleccione Sector Economico</option>
                      <?php  
							$sqlSEC="select * from (sector_eco inner join rama on sector_eco.cod_rama=rama.cod_rama) where rama.cod_tipo=".$cmbENS;
							$resultSEC= @pg_Exec($conn,$sqlSEC);
								for($i=0 ; $i < @pg_numrows($resultSEC) ; $i++){
									$filaSEC = @pg_fetch_array($resultSEC,$i);
										if ($filaSEC["cod_sector"]==$cmbSEC){
											echo  "<option selected value=".$filaSEC["cod_sector"]." >".$filaSEC["nombre_sector"]."</option>";
										}else{
											echo  "<option value=".$filaSEC["cod_sector"]." >".$filaSEC["nombre_sector"]."</option>";
										}
									$rama=$filaSEC["cod_rama"];		
								}
						?>
                    </select>
                    <?php echo "<input type=hidden name=txtRAMA  value=".$filaSEC["cod_rama"].">"; ?> 
                    <?php }?>
                    <?php $qry9="SELECT * FROM sector_eco WHERE cod_sector=".$fila4["cod_sector"]." AND cod_rama=".$fila4["cod_rama"];
							$result9= @pg_Exec($conn,$qry9);
							$fila9= @pg_fetch_array($result9,0);
					?>
                    <?php if($frmModo=="mostrar"){ ?>
                    <FONT face="arial, geneva, helvetica" size=2><strong> 
                    <?php
							imp($fila9['nombre_sector']);
						};?>
                    </strong></font> 
                    <?php 
						
						if($frmModo=="modificar"){ ?>
                    <FONT face="arial, geneva, helvetica" size=2><strong> 
                    <?php
							imp($fila9['nombre_sector']);?>
                    </strong></font> 
                    <?php 	};
					?>                  </TD>
				  <TD class="datosb"> 
				    <? 	$qry7="SELECT * FROM especialidad WHERE cod_sector=".$fila4["cod_sector"]." AND cod_rama=".$fila4["cod_rama"]." AND cod_esp=".$fila['cod_es'];
						$result7= @pg_Exec($conn,$qry7);
						$fila7= @pg_fetch_array($result7,0);
					?>

                    <?php if($frmModo=="ingresar"){ ?>
                   
                    <select name="cmbESP">
                      <option value=0 selected>Seleccione Especialidad</option>
                      <?php 
							$sqlESP="select * from especialidad where cod_sector =".$cmbSEC." and cod_rama=".$rama;
							$resultESP= @pg_Exec($conn,$sqlESP);
								for($i=0 ; $i < @pg_numrows($resultESP) ; $i++){
									$filaESP = @pg_fetch_array($resultESP,$i);
										if ($filaESP["cod_esp"]==$cmbESP){
											echo  "<option selected value=".$filaESP["cod_esp"]." >".$filaESP["nombre_esp"]."</option>";
										}else{
											echo  "<option value=".$filaESP["cod_esp"]." >".$filaESP["nombre_esp"]."</option>";
										}
								}
						?>
                    </select> 
                    <?php };?>
					
                    <?php if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
						imp($fila7['nombre_esp']);
						};?>
						</strong></font>
						<?php
						
						if($frmModo=="modificar"){?> <FONT face="arial, geneva, helvetica" size=2><strong> <?php 
						imp($fila7['nombre_esp']);?>
						</strong></font>
						<?php };
						?>                  </TD>
				</TR>
			  </TABLE>						  </TD>
						</TR>
						<?php } ?>
						
						
						<TR>
							
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width=100%>
                <TR> <?php  if($frmModo=="mostrar"){ ?>
				  <TD width="50%" class="cuadro02">DECRETO DE EVALUACION </TD>
                  <?php }?>
				<?php //if ($cmbPLAN!=1000){?>
                <TD width="22%" class="cuadro02">GRADO				</TD>
				<?php //} ?>
				<TD width="28%" class="cuadro02">LETRA				</TD>
				</TR>
				<TR>
					<?php if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong>
                  <TD class="datosb"> <font face="arial, geneva, helvetica" size=2><strong>
                    <?php
						imp($fila['cod_eval']);
						?>
                    </strong></font></TD>
                  </strong></font>
				      <?php }; ?>
					  
					  <?php //if($cmbPLAN!=1000){?>
				  <TD class="datosb"> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <?php
						$sql2="select * from cursos_plan where cod_decreto=". $cmbPLAN;
						$result2=@pg_Exec($conn,$sql2);
						$fila2= @pg_fetch_array($result2,0);
						
					?>
                    <select name="cmbGRA">
						<option value=0 selected>Seleccione Grado</option>
                      <?php if ( (($fila2['pa']==1) and ($cmbPLAN==461987)) or (($fila2['pa']==1) and ($cmbPLAN==771982)) ){ ?>
                      <option value=1>PRIMER NIVEL</option>
                      <?php }else if ( (($fila2['pa']==1) and ($cmbPLAN==121987)) or (($fila2['pa']==1) and ($cmbPLAN==1521989)) ){ ?>
                      <option value=1>PRIMER CICLO</option>
					  <?php }else if (($fila2['pa']==1) and ($cmbPLAN==1000)){ ?>
                      <option value=1>SALA CUNA</option>
                      <?php
					  }elseif($fila2['pa']==1 and ($cmbPLAN==832015 and $cmbENS==212)){?>
							<option value=1>PRIMER AÑO</option>
						<? 
					  }else if ($fila2['pa']==1) { ?>
                      <option value=1>PRIMER AÑO</option>
                      <?php }
					  if ( (($fila2['sa']==1) and ($cmbPLAN==461987)) or (($fila2['sa']==1) and ($cmbPLAN==771982)) ){ ?>
                      <option value=2>SEGUNDO NIVEL</option>
                      <?php }else if (($fila2['sa']==1) and ($cmbPLAN==121987)){ ?>
                      <option value=2>SEGUNDO CICLO</option>
					  <?php }else if (($fila2['sa']==1) and ($cmbPLAN==1000)){ ?>
                      <option value=2>NIVEL MEDIO MENOR</option>
                      <?php }else if (($fila2['sa']==1) and ($cmbPLAN==871990 and ($cmbENS==212))){ ?>
                      <option value=2>PREBÁSICO 1º-2</option>
                      <?php }else if($fila2['sa']==1 and ($cmbPLAN==832015 and $cmbENS==212)){?>
							<option value=2>SEGUNDO AÑO</option>
                      <?php }else if ($fila2['sa']==1){ ?>
                      <option value=2>SEGUNDO AÑO</option>
                      <?php }
					  if ( (($fila2['ta']==1) and ($cmbPLAN==461987)) or (($fila2['ta']==1) and ($cmbPLAN==771982)) ){ ?>
                      <option value=3>TERCER NIVEL</option>
					  <?php }else if (($fila2['ta']==1) and ($cmbPLAN==1000)){ ?>
                      <option value=3>NIVEL MEDIO MAYOR</option>
                      
					  <?php }else if ($fila2['ta']==1 and ($cmbPLAN==871990 AND $cmbENS==212)){ ?>
                      <option value=3>PREBASICO 2º-3</option>
                      <?php }else if ($fila2['ta']==1 and ($cmbPLAN==2119999 AND $cmbENS==211)){ ?>
                      <option value=3>PREBASICO 1º-2</option>
                      <?php }else if ($fila2['ta']==1 and ($cmbPLAN==2119999 AND $cmbENS==214)){ ?>
                      <option value=3>PRIMER NIVEL DE TRANSICIÓN</option>
                      <?php }else if ($fila2['ta']==1){ ?>
                      <option value=3>TERCER AÑO</option>
                      <?php }
					  if($fila2['qu']==1 and ($cmbPLAN==2169999 AND $cmbENS==216)){ ?>
                        <option value=5>Básico 1º -5</option>
                       <? }
					   if($fila2['d18']==1 and ($cmbPLAN==2169999 AND $cmbENS==216)){ ?>
					  <option value=18>Pre-Básico 2º -4</option>
                      <? } 
					  if ( (($fila2['cu']==1) and ($cmbPLAN==771982)) ){ ?>
                      <option value=4>CUARTO NIVEL</option>
					 <?php
					                         
					  }else if ($fila2['cu']==1 and ($cmbPLAN==871990 AND $cmbENS==212)){ ?>
                      <option value=4>PREBASICO 2º-4</option>
                      <?php
					 }else if ($fila2['cu']==1 and ($cmbPLAN==2119999 AND $cmbENS==211)){ ?>
                      <option value=4>PREBASICO 1º-3</option>
                     <?php
					 }else if ($fila2['cu']==1 and ($cmbPLAN==2119999 AND $cmbENS==214)){ ?>
                      <option value=4>SEGUNDO NIVEL TRANSICIÓN</option>
                  <? }elseif (($fila2['cu']==1) and ($cmbPLAN==1000) ){ ?>
                      <option value=4>TRANSICIÓN 1er NIVEL</option>
                  <? }elseif (($fila2['cu']==1) and ($cmbPLAN==891990 AND $cmbENS==213) ){ ?>
                      <option value=4>ESTIMULACION TEMPRANA</option>
			   <?php }else if($fila2['cu']==1) { ?>
                      <? if  ($cmbPLAN!=771982){?><option value=4>CUARTO AÑO</option><?php }
					  }
					if (($fila2['qu']==1) and ($cmbPLAN==1000)){ ?>
                      <option value=5>TRANSICIÓN 2do NIVEL</option>
					<?php }else if($fila2['qu']==1 and ($cmbPLAN==871990)) { ?>
                  	<option value=5>BÁSICO 1º-5</option>
                    <?php }else if($fila2['qu']==1 and ($cmbPLAN==871990 AND $cmbENS==216)) { ?>
                  	<option value=5>BÁSICO 1º-5</option>
                    <?php }else if($fila2['qu']==1 and ($cmbPLAN==891990 AND $cmbENS==213)) { ?>
                  	<option value=5>PREBASICO 1º - 2</option>
				  <?php }else if($fila2['qu']==1) { ?>
                  <option value=5>QUINTO AÑO</option>
                  <?php }
				  	if ($fila2['sx']==1 and  ($cmbPLAN==871990 AND $cmbENS==212)){?>
					<option value=6>BÁSICO 1º-6</option>
                   <? }elseif ($fila2['sx']==1 and  ($cmbPLAN==2119999 AND $cmbENS==211)){?>
					<option value=6>PREBÁSICO 2º-5</option>
                    <? }else if ($fila2['sx']==1){ ?>
                      <option value=6>SEXTO AÑO</option>
                      <?php }
					 if ($fila2['sp']==1 and ($cmbPLAN==871990 AND $cmbENS==212)){ ?>
                      <option value=7>BÁSICO 1º-7</option>
                      <?php } 
					elseif ($fila2['sp']==1){ ?>
                      <option value=7>SEPTIMO AÑO</option>
                      <?php }
					  if ($fila2['oc']==1 and ($cmbPLAN==871990 AND $cmbENS==212)){ ?>
                      <option value=8>BÁSICO 2º-8</option>
                      <?php }
					else if ($fila2['oc']==1){ ?>
                      <option value=8>OCTAVO AÑO</option>
                      <?php }
					  
                      if ($fila2['nv']==1 and ($cmbPLAN==871990 AND $cmbENS==212)){ ?>
                      <option value=9>BÁSICO 2º-9</option>
                      <?php } elseif ($fila2['nv']==1 and ($cmbPLAN==2119999 AND $cmbENS==211)){ ?>
                      <option value=9>BÁSICO 1º-3</option>
                      <?php } 
                       if ($fila2['dc']==1 and ($cmbPLAN==871990 AND $cmbENS==212)){ ?>
                      <option value=10>BÁSICO 2º-10</option>
                      <?php } 
					  if ($fila2['dc']==1 and ($cmbPLAN==2119999 AND $cmbENS==211)){ ?>
                      <option value=10>BÁSICO 1º-4</option>
                      <?php } 
                        if ($fila2['d1']==1 and ($cmbPLAN==871990 AND $cmbENS==212)){ ?>
                      <option value=11>LABORAL 1</option>
                      <?php }
					    else if ($fila2['d1']==1 and ($cmbPLAN==871990 AND $cmbENS==216)){ ?>
                      <option value=11>LABORAL 1</option>
                      <?php }
					   if ($fila2['d6']==1 and ($cmbPLAN==871990 AND $cmbENS==216)){ ?>
                      <option value=16>PRE-BASICO 1º-2</option>
                      <?php }
					    if ($fila2['d2']==1 and ($cmbPLAN==871990 AND $cmbENS==212)){ ?>
                      <option value=12>LABORAL 2</option>
                      <?php }elseif ($fila2['d2']==1 and ($cmbPLAN==2119999 AND $cmbENS==211)){ ?>
                      <option value=12>BÁSICO 2º -6</option>
                      <?php }
					  if ($fila2['d3']==1 and ($cmbPLAN==2119999 AND $cmbENS==211)){ ?>
                      <option value=12>BÁSICO 2º -77</option>
                      <?php }
					  
					    if ($fila2['d3']==1 and ($cmbPLAN==871990 AND $cmbENS==212)){ ?>
                      <option value=13>LABORAL 3</option>
                      <?php }
					   if ($fila2['d3']==1 and ($cmbPLAN==871990 AND $cmbENS==216)){ ?>
                      <option value=14>PRÉBASICO MATERNO 1</option>
                      <?php }
					  if ($fila2['d4']==1 and ($cmbPLAN==2119999 AND $cmbENS==211)){ ?>
                      <option value=14>BÁSICO 2º-8</option>
                      <?php }
					  	if($fila2['d6']==1 and ($cmbPLAN==8151990 and $cmbENS==299)){?>
							<option value=16>LABORAL 1</option>
						 <?php }
					  	if($fila2['l33']==1 and ($cmbPLAN==8151990 and $cmbENS==299)){?>
							<option value=33>LABORAL 33</option>
						<? }
						if($fila2['v3']==1 and ($cmbPLAN==125 and $cmbENS==214)){?>
							<option value=23>NIVEL MEDIO MAYOR</option>
						<? }
						else if($fila2['v3']==1 and ($cmbPLAN==832015 and $cmbENS==212)){?>
							<option value=23>NIVEL MEDIO MAYOR</option>
                         <? }
						 else if($fila2['v3']==1 and ($cmbPLAN==832015 and $cmbENS==216)){?>
							<option value=23>NIVEL MEDIO MAYOR</option>
                         <? }
						 if($fila2['v4']==1 and ($cmbPLAN==125 and $cmbENS==214)){?>
							<option value=24>NIVEL TRANSICIÓN 1</option>
						<? }
						else if($fila2['v4']==1 and ($cmbPLAN==832015 and $cmbENS==212)){?>
							<option value=24>NIVEL TRANSICIÓN 1</option>
						<? }
						else if($fila2['v4']==1 and ($cmbPLAN==832015 and $cmbENS==216)){?>
							<option value=24>NIVEL TRANSICIÓN 1</option>
						<? }
						if($fila2['v5']==1 and ($cmbPLAN==125 and $cmbENS==214)){?>
							<option value=25>NIVEL TRANSICIÓN 2</option>
						<? }
						 else if($fila2['v5']==1 and ($cmbPLAN==832015 and $cmbENS==212)){?>
							<option value=25>NIVEL TRANSICIÓN 2</option>
						<? }
						else if($fila2['v5']==1 and ($cmbPLAN==832015 and $cmbENS==216)){?>
							<option value=25>NIVEL TRANSICIÓN 2</option>
						<? }
						 if($fila2['t1']==1 and ($cmbPLAN==832015 and $cmbENS==212)){?>
							<option value=31>LABORAL 1</option>
						<? } 
						 else if($fila2['t1']==1 and ($cmbPLAN==832015 and $cmbENS==216)){?>
							<option value=31>LABORAL 1</option>
						<? } 
						if($fila2['t2']==1 and ($cmbPLAN==832015 and $cmbENS==212)){?>
							<option value=32>LABORAL 2</option>
						<? }
						else if($fila2['t2']==1 and ($cmbPLAN==832015 and $cmbENS==216)){?>
							<option value=32>LABORAL 2</option>
						<? }
						 if($fila2['t3']==1 and ($cmbPLAN==832015 and $cmbENS==212)){?>
							<option value=33>LABORAL 3</option>
						<? }
						else if($fila2['t3']==1 and ($cmbPLAN==832015 and $cmbENS==216)){?>
							<option value=33>LABORAL 3</option>
						<? }
						
					   ?>
                       
                    </select>
                    <?php 
					
					
					
					};?>
                    <?php 
						if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong>
						<?php
							if (($fila['grado_curso']==1) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "PRIMER NIVEL";
							}else if (($fila['grado_curso']==1) and (($fila['cod_decreto']==121987) or ($fila['cod_decreto']==1521989)) ){
								echo "PRIMER CICLO";
							}else if (($fila['grado_curso']==1) and ($fila['cod_decreto']==1000)){
								echo "SALA CUNA";
							}else if (($fila['grado_curso']==2) and ($fila['cod_decreto']==1000)){
								echo "NIVEL MEDIO MENOR";
							}else if (($fila['grado_curso']==3) and ($fila['cod_decreto']==1000)){
								echo "NIVEL MEDIO MAYOR";
							}else if (($fila['grado_curso']==4) and ($fila['cod_decreto']==1000)){
								echo "TRANSICIÓN 1er NIVEL";
							}else if (($fila['grado_curso']==5) and ($fila['cod_decreto']==1000)){
								echo "TRANSICIÓN 2do NIVEL";
							}else if ( ($fila['grado_curso']==2) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "SEGUNDO NIVEL";
							}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==121987) ){
								echo "SEGUNDO CICLO";
							}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "TERCER NIVEL";
							}else if ( ($fila['grado_curso']==4) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==771982)) ){
								echo "CUARTO NIVEL";
							}else if ( ($fila['grado_curso']==3) and ($fila['ensenanza']==363) AND $fila['cod_decreto']==2392004 ){
								echo "SEGUNDO NIVEL";
							}else{
								imp($fila['grado_curso']);
							}?>
						</strong></font>
						<?php 
						};
						if($frmModo=="modificar"){ ?> <FONT face="arial, geneva, helvetica" size=2><strong> <?php
							if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "PRIMER NIVEL";
							}else if (($fila['grado_curso']==1) and ($fila['cod_decreto']==1000)){
								echo "SALA CUNA";
							
							}else if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==121987) or ($fila['cod_decreto']==1521989)) ){
								echo "PRIMER CICLO";
							}else if ( ($fila['grado_curso']==2) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "SEGUNDO NIVEL";
							}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==121987) ){
								echo "SEGUNDO CICLO";
							}else if (($fila['grado_curso']==2) and ($fila['cod_decreto']==1000)){
								echo "NIVEL MEDIO MENOR";
							}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
								echo "TERCER NIVEL";
							}else if (($fila['grado_curso']==3) and ($fila['cod_decreto']==1000)){
								echo "NIVEL MEDIO MAYOR";
							}else if (($fila['grado_curso']==4) and ($fila['cod_decreto']==1000)){
								echo "TRANSICIÓN 1er NIVEL";
							}else if (($fila['grado_curso']==5) and ($fila['cod_decreto']==1000)){
								echo "TRANSICIÓN 2do NIVEL";
								
							}else if (($fila['grado_curso']==4) and ($fila['cod_decreto']==771982)){
								echo "CUARTO NIVEL";	
								
							
							}
							
							else{
								imp($fila['grado_curso']);
							}?>
						</strong></font>	
					<?php	};
					?>                  </TD><?php //} ?>
						 <TD class="datosb">
				  <?php if($frmModo=="ingresar"){ ?>
						<Select name="cmbLETRA">
						    <option value=0 selected >Seleccione Letra</option>
							<option value=A >A</option>
							<option value=B >B</option>
							<option value=C >C</option>
							<option value=D >D</option>
							<option value=E >E</option>
							<option value=F >F</option>
							<option value=G >G</option>
							<option value=H >H</option>
							<option value=I >I</option>
							<option value=J >J</option>
							<option value=K >K</option>
							<option value=L >L</option>
							<option value=M >M</option>
							<option value=N >N</option>
							<option value=Ñ >Ñ</option>
							<option value=O >O</option>
							<option value=P >P</option>
							<option value=Q >Q</option>
							<option value=R >R</option>
							<option value=S >S</option>
							<option value=T >T</option>
							<option value=U >U</option>
							<option value=V >V</option>
							<option value=W >W</option>
							<option value=X >X</option>
							<option value=Y >Y</option>
							<option value=Z >Z</option>
                            <option value=EB >EB</option>
                            <option value=FB >FB</option>
						</Select>
				<?php };?>
				<?php if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
						imp($fila['letra_curso']);?>
						</strong></font>
						<?php
						};
						if($frmModo=="modificar"){?><FONT face="arial, geneva, helvetica" size=2><strong><?php
						imp($fila['letra_curso']);?>
						</strong></font>
					<?php	};
						?>				  </TD>				
								  </TR>
								  <TR>
				  <TD colspan="3" class="cuadro02">APROXIMACIONES
                  
				
				:</TD>
				  </TR>
								  
				                  <TR>
				                    <TD colspan="3" class="cuadro02">APROXIMAR PROMEDIOS PERIODO 
				                      <?php
				   if ($frmModo=="ingresar"){
					    ?>
                                      <input name="bool_psemestral" type="checkbox" id="bool_psemestral0" value="1">
                                      
                                      <? }
                     
				   if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2> <strong>
                                      <?
						if ($fila['bool_psemestral']==0){
						     echo "NO";
					    }else{
						     echo "SI";
						}
						?>
                                      </strong></font>
                                      <? } 
				
				   if($frmModo=="modificar"){ ?>
                                      <input type="checkbox" name="bool_psemestral" size="83" maxlength="50" value="1" <? if ($fila['bool_psemestral']==1){ ?> checked="checked" <? } ?>>
                                      <? } ?></TD>
				                    </TR>
				                  <TR>
				  <TD colspan="3" class="cuadro02">APROXIMAR PROMEDIOS FINALES
                   <?php
				   if ($frmModo=="ingresar"){
					    ?>
                        <input name="truncado_per" type="checkbox" id="truncado_per" value="1">
                <? }
                     
				   if($frmModo=="mostrar"){ ?>
                        <FONT face="arial, geneva, helvetica" size=2>
						<strong>
                        <?
						if ($fila['truncado_per']==0){
						     echo "NO";
					    }else{
						     echo "SI";
						}
						?>						
						</strong>						</font>
                <? } 
				
				   if($frmModo=="modificar"){ ?>
                        <input type="checkbox" name="truncado_per" size="83" maxlength="50" value="1" <? if ($fila['truncado_per']==1){ ?> checked="checked" <? } ?>>
                <? } ?>				</TD>
				  </TR>
				  <!---////comienzo de aproximacion Final--->
<TR>
				  <tr>
				  <TD colspan="3" class="cuadro02">APROXIMAR PROMEDIO GENERAL <?php
				   if ($frmModo=="ingresar"){
					    ?>
                        <input name="truncado_final" type="checkbox" id="truncado_final" value="1">
                <? }
                     
				   if($frmModo=="mostrar"){ ?>
                        <FONT face="arial, geneva, helvetica" size=2>
						<strong>
                        <?
						if ($fila['truncado_final']==0){
						     echo "NO";
					    }else{
						     echo "SI";
						}
						?>						
						</strong>						</font>
                <? } 
				
				   if($frmModo=="modificar"){ ?>
                        <input type="checkbox" name="truncado_final" size="83" maxlength="50" value="1" <? if ($fila['truncado_final']==1){ ?> checked="checked" <? } ?>>
                <? } ?>				</TD>
				  </TR>
				  
				  <!-----SI APROXIMO SEMESTRAL MAS EXAMEN--->
				  <!-- <tr>
				  <TD colspan="3" class="cuadro02">APROXIMAR PROMEDIO PERIODOS + EXAMEN -->
                  
				    <?php
				  /* if ($frmModo=="ingresar"){
					    ?>
                        <input name="truncado_sf" type="checkbox" id="truncado_sf" value="1">
                <? }
                     
				   if($frmModo=="mostrar"){ ?>
                        <FONT face="arial, geneva, helvetica" size=2>
						<strong>
                        <?
						if ($fila['truncado_sf']==0){
						     echo "NO";
					    }else{
						     echo "SI";
						}
						?>						
						</strong>						</font>
                <? } 
				
				   if($frmModo=="modificar"){ ?>
                        <input type="checkbox" name="truncado_sf" size="83" maxlength="50" value="1" <? if ($fila['truncado_sf']==1){ ?> checked="checked" <? } ?>>
                <? } */?>	
                  
                <!--  </TD>
				  </TR>-->
				   <tr>
				     <TD colspan="3" class="cuadro02">BLOQUEAR NOTAS DESPUES DE GUARDADAS
                     
                  <?php
				   if ($frmModo=="ingresar"){
					    ?>
                        <input name="bloq_ramos" type="checkbox" id="bloq_ramos" value="1">
                <? }
                     
				   if($frmModo=="mostrar"){ ?>
                        <FONT face="arial, geneva, helvetica" size=2>
						<strong>
                        <?
							if($fila['bloq_ramos']==0){
							  echo "NO";
							}else{
							  echo "SI";
							}
						?>						
						</strong>
                        </font>
                <? } 
				
				   if($frmModo=="modificar"){ ?>
                        <input type="checkbox" name="bloq_ramos" size="83" maxlength="50" value="1" <? if ($fila['bloq_ramos']==1){ ?> checked="checked" <? } ?>>
                <? } ?>	
                     
                     
                     </TD>
				     </TR>
				   <tr>
				     <TD colspan="3" class="cuadro02">FECHA INICIO CURSO <?php  if ($frmModo=="ingresar"){?><input name="fecha_inicio" type="text" id="fecha_inicio" size="10">
					 <?php
						 } if($frmModo=="modificar"){ ?><input name="fecha_inicio" type="text" id="fecha_inicio" value="<?php echo ($fila['fecha_inicio']!='1111-11-11')?CambioFD($fila['fecha_inicio']):''; ?>" size="10">
					 <?php } if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2>
						<strong> <? echo ($fila['fecha_inicio']!='1111-11-11')?CambioFD($fila['fecha_inicio']):'';}?></strong></FONT></TD>
				     </TR>
				   <tr>
				     <TD colspan="3" class="cuadro02">FECHA TERMINO CURSO <?php  if ($frmModo=="ingresar"){?><input name="fecha_termino" type="text" id="fecha_termino" size="10">
					 <?php } if($frmModo=="modificar"){?><input name="fecha_termino" type="text" id="fecha_termino" value="<?php echo ($fila['fecha_termino']!='1111-11-11')?CambioFD($fila['fecha_termino']):'' ?>" size="10">
					 <?php } if($frmModo=="mostrar"){?> <FONT face="arial, geneva, helvetica" size=2>
						<strong><? echo ($fila['fecha_termino']!='1111-11-11')?CambioFD($fila['fecha_termino']):'';}?></strong></FONT></TD>
				     </TR>
				   <tr>
				     <TD colspan="3" class="cuadro02">AUTOEVALUACI&Oacute;N INFORME PERSONALIDAD: <?php
				   if ($frmModo=="ingresar"){
					    ?>
                        <input name="autoev_ip" type="checkbox" id="autoev_ip" value="1">
                <? }
                     
				   if($frmModo=="mostrar"){ ?>
                        <FONT face="arial, geneva, helvetica" size=2>
						<strong>
                        <?
						if ($fila['autoev_ip']==0){
						     echo "NO";
					    }else{
						     echo "SI";
						}
						?>						
						</strong>						</font>
                <? } 
				
				   if($frmModo=="modificar"){ ?>
                        <input type="checkbox" name="autoev_ip" size="83" maxlength="50" value="1" <? if ($fila['autoev_ip']==1){ ?> checked="checked" <? } ?>>
                <? } ?>				</TD>
				     </TR>
                     
				   <tr>
				     <TD colspan="3" class="cuadro02">BLOQUEO NOTAS PROFESOR JEFE
				       <?php
				   if ($frmModo=="ingresar"){
					    ?>
                       <input name="pj_edita" type="checkbox" id="pj_edita" value="1">
                       
                       <? }
                     
				   if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2> <strong>
                       <?
						if ($fila['pj_edita']==0){
						     echo "NO";
					    }else{
						     echo "SI";
						}
						?>
                       </strong></font>
                       <? } 
				
				   if($frmModo=="modificar"){ ?>
                       <input type="checkbox" name="pj_edita" size="83" maxlength="50" value="1" <? if ($fila['pj_edita']==1){ ?> checked="checked" <? } ?>>
                       <? } ?></TD>
				     </TR>
                    
				                </TABLE>
				  </TD>
					</TR>
						
						
		<?php // }//FIN ENSEÑANZA CURSO?>
	<?php }//COLEGIO?>
						<TR>
							
							
            <TD> <table width=100% height="43" border=0 cellpadding=0 cellspacing=0>
                <tr> 
                  <td width="53%" class="cuadro02"> PROFESOR JEFE </td>
                  <td width="39%" class="cuadro02">JORNADA</td>
                </tr>
                <tr> 
                  <td class="datosb"> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <select name="cmbSUP">
                      <option value=0 selected>Seleccione Profesor Jefe</option>
                      <?php
													$qry="SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp, empleado.rut_emp, trabaja.cargo, institucion.rdb FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (institucion.rdb=".$institucion.") order by empleado.ape_pat,empleado.ape_mat,empleado.nombre_emp asc";
												
														$result =@pg_Exec($conn,$qry);
														if (!$result) 
															error('<B> ERROR :</b>Error al acceder a la BD. (19)</B>');
														else{
															if (pg_numrows($result)!=0){
																$fila1 = @pg_fetch_array($result,0);
																if (!$fila1){
																	error('<B> ERROR :</b>Error al acceder a la BD. (20)</B>');
																	//exit();
																};
																for($i=0 ; $i < @pg_numrows($result) ; $i++){
																	$fila1 = @pg_fetch_array($result,$i);
																	echo  "<option value=".trim($fila1["rut_emp"]).">".trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_emp"])."</option>\n";
																}
															}
														};
													?>
                    </select> 
                    <?php };?>
                    <?php 
					if($frmModo=="mostrar"){ ?>
					
					           <?php
								 $qry55="select * from supervisa where id_curso=".$fila['id_curso'];
							//	$qry55="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from (supervisa inner join empleado on supervisa.rut_emp = empleado.rut_emp) where((supervisa.id_curso)=".$fila['id_curso'].")";
								$result55 =@pg_Exec($conn,$qry55);
								$fila55 = @pg_fetch_array($result55,0);
								
								 $qry5="select empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from empleado where rut_emp=".$fila55['rut_emp'];
							//	$qry5="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from (supervisa inner join empleado on supervisa.rut_emp = empleado.rut_emp) where((supervisa.id_curso)=".$fila['id_curso'].")";
								$result5 =@pg_Exec($conn,$qry5);
								$fila5 = @pg_fetch_array($result5,0);
								
								if ($fila5["ape_pat"]==NULL){ ?>
								     <FONT face="arial, geneva, helvetica" size=2  color="FF0000" ><strong>
									  ¡Falta Asignar Profesor Jefe!
									 </strong></font>
									 <?    
								}else{  ?>
								     <FONT face="arial, geneva, helvetica" size=2  color="000000" ><strong>
									 <? imp($fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]); ?>
									 </strong></font>
							<?	}  ?>
								
								
			  <?php  }; ?>
			
			
			
                    <?php if($frmModo=="modificar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong>
                    <select name="cmbSUP">
                      <option value=0></option>
													
                      <?php
														//SUPERVISOR ACTUAL
														$qry="SELECT curso.id_curso, empleado.rut_emp FROM (empleado INNER JOIN supervisa ON empleado.rut_emp = supervisa.rut_emp) INNER JOIN curso ON supervisa.id_curso = curso.id_curso WHERE (((curso.id_curso)=".$curso.")) order by empleado.ape_pat,empleado.ape_mat,empleado.nombre_emp asc";
														$result =@pg_Exec($conn,$qry);
														$fila4= @pg_fetch_array($result,0);

														//DOCENTES DE LA INSTITUCION
														$qry="SELECT empleado.rut_emp,empleado.nombre_emp,empleado.ape_pat,empleado.ape_mat, trabaja.rdb, trabaja.cargo FROM empleado INNER JOIN (institucion INNER JOIN trabaja ON institucion.rdb = trabaja.rdb) ON empleado.rut_emp = trabaja.rut_emp WHERE ((trabaja.rdb=".$_INSTIT.")) order by empleado.ape_pat,empleado.ape_mat,empleado.nombre_emp asc";
														$result =@pg_Exec($conn,$qry);
														if (!$result) 
															error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>');
														else{
															if (pg_numrows($result)!=0){
																$fila1 = @pg_fetch_array($result,0);	
																if (!$fila1){
																	error('<B> ERROR :</b>Error al acceder a la BD. (22)</B>');
																	exit();
																};
																for($i=0 ; $i < @pg_numrows($result) ; $i++){
																	$fila1 = @pg_fetch_array($result,$i);
																	if($fila4["rut_emp"]!=$fila1["rut_emp"]){
																		echo "<option value=".$fila1["rut_emp"]."> ".trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_emp"])."</option>\n";
																	}else{
																		echo "<option value=".$fila1["rut_emp"]." selected> ".trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_emp"])."</option>\n";
																	}
																}
															}
														};
													?>
                    </select>
					</strong></font> 
                    <?php };?>                  </td>
                  <td class="datosb">                    <?php if($frmModo=="ingresar"){ ?>
                    <p align="justify"> 
                      <label> 
                      <input name="jornada" type="radio" value="1" checked >
                      <font size="1" face="Arial, Helvetica, sans-serif">MA&Ntilde;ANA</font></label>
                      <br>
                      <label> 
                      <input type="radio" name="jornada" value="2">
                     <font size="1" face="Arial, Helvetica, sans-serif"> TARDE</font></label>
                      <br>
                      <label> 
                      <input type="radio" name="jornada" value="3">
                     <font size="1" face="Arial, Helvetica, sans-serif"> MA&Ntilde;ANA Y TARDE</font></label>
                      <br>
                      <label> 
                      <input type="radio" name="jornada" value="4">
                      <font size="1" face="Arial, Helvetica, sans-serif">VESPERTINO</font></label>
                      <br>
                    </p>
                    <?php };
					if($frmModo=="mostrar"){ ?>
                    <FONT face="arial, geneva, helvetica" size=2><strong>
                    <?php
						$jor = $fila['bool_jor'];
						switch ($jor){
						   case 1;
						      echo "MAÑANA";
						   break;	  
						   case 2;
						       echo "TARDE";
						   break;
						   case 3;
						       echo "MAÑANA Y TARDE";	   
						   break;
						   case 4;
						       echo "VESPERTINO";	   
						   break;
						   } ?>	   
                    </strong></font> 
                    <?php };?>
					
										<?php	if($frmModo=="modificar"){ ?>
                    <?php
						$jor = $fila['bool_jor'];
						 ?>
					 <p>
                      <label>
						<font size="1" face="Arial, Helvetica, sans-serif">
							<input name="jornada" type="radio" value=1 
					 <?php 
						echo ($jor==1)?"checked":"";
					  ?>> MAÑANA </font>					   </label>
                      <br>
                      <label>
						<font size="1" face="Arial, Helvetica, sans-serif">
                      <input name="jornada" type="radio" value=2 
						<?php 
							echo ($jor==2)?"checked":"";
						?>>TARDE </font></label>
                      <br>
                      <label>
						<font size="1" face="Arial, Helvetica, sans-serif">
                      <input name="jornada" type="radio" value=3 
					    <?php 
							echo ($jor==3)?"checked":"";
						?>>
                      MAÑANA Y TARDE</font></label>
                      <br>
                      <label>
						<font size="1" face="Arial, Helvetica, sans-serif">
                      <input name="jornada" type="radio" value=4 
						<?php 
							echo ($jor==4)?"checked":"";
						?>>VESPERTINO</font></label>
                      <br>
					</p> 
                    <?php };?> </td>
                </tr>
              </table></TD>
						</TR>
			<TR>
			  <TD colspan=4 ><div id="simce" >  
			
			
			  <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr>
                    <td width="25%" class="cuadro02">PUNTAJE SIMCE  </td>
                    <td width="75%" class="datosb"> 
					    <label><strong>
						<?
						$simce = $fila['simce'];
						
						
						if ($frmModo=="ingresar"){ ?>
                             <input name="simce" type="text" size="5" maxlength="5">
                     <? }
					 
					    if ($frmModo=="modificar"){ ?>
                             <input name="simce" type="text" size="5" maxlength="5" value="<?=$simce ?>">
                     <? }
					 
					    if ($frmModo=="mostrar"){
						    if ($simce==0){
							    echo "";
							}else{							
                                echo "$simce";
							}	
                        }
					 
					     ?>						
						</strong>						</label>					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td class="cuadro02" >ENCARGADO CONFECCION DE ACTA</td>
					<td  class="datosb"><?php if($frmModo=="modificar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong>
                    <select name="cmbACTA">
                      <option value=0></option>
													
                      <?php
														//SUPERVISOR ACTA
														$qry="SELECT curso.id_curso, curso.acta, empleado.rut_emp FROM (empleado INNER JOIN supervisa ON empleado.rut_emp = supervisa.rut_emp) INNER JOIN curso ON supervisa.id_curso = curso.id_curso WHERE (((curso.id_curso)=".$curso.")) order by empleado.ape_pat,empleado.ape_mat,empleado.nombre_emp asc";
														$result =@pg_Exec($conn,$qry);
														$fila4= @pg_fetch_array($result,0);

														//DOCENTES DE LA INSTITUCION
														$qry="SELECT empleado.rut_emp,empleado.nombre_emp,empleado.ape_pat,empleado.ape_mat, trabaja.rdb, trabaja.cargo FROM empleado INNER JOIN (institucion INNER JOIN trabaja ON institucion.rdb = trabaja.rdb) ON empleado.rut_emp = trabaja.rut_emp WHERE ((trabaja.rdb=".$_INSTIT.")) order by empleado.ape_pat,empleado.ape_mat,empleado.nombre_emp asc";
														$result =@pg_Exec($conn,$qry);
														if (!$result) 
															error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>');
														else{
															if (pg_numrows($result)!=0){
																$fila1 = @pg_fetch_array($result,0);	
																if (!$fila1){
																	error('<B> ERROR :</b>Error al acceder a la BD. (22)</B>');
																	exit();
																};
																for($i=0 ; $i < @pg_numrows($result) ; $i++){
																	$fila1 = @pg_fetch_array($result,$i);
																	if($fila4["acta"]!=$fila1["rut_emp"]){
																		echo "<option value=".$fila1["rut_emp"]."> ".trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_emp"])."</option>\n";
																	}else{
																		echo "<option value=".$fila1["rut_emp"]." selected> ".trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_emp"])."</option>\n";
																	}
																}
															}
														};
													?>
                    </select>
					</strong></font> 
                    <?php };?>
					      <?php 
								if($frmModo=="mostrar"){ ?>
								    <?php

									$qry55="select * from curso where id_curso=".$fila['id_curso'];
								//	$qry55="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from (supervisa inner join empleado on supervisa.rut_emp = empleado.rut_emp) where((supervisa.id_curso)=".$fila['id_curso'].")";
									$result55 =@pg_Exec($conn,$qry55);
									$fila55 = @pg_fetch_array($result55,0);
									
									$qry5="select empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from empleado where rut_emp=".$fila55['acta'];
								//	$qry5="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from (supervisa inner join empleado on supervisa.rut_emp = empleado.rut_emp) where((supervisa.id_curso)=".$fila['id_curso'].")";
									$result5 =@pg_Exec($conn,$qry5);
									$fila5 = @pg_fetch_array($result5,0);
	
									if ($fila5["ape_pat"]==NULL){ ?>
										 <FONT face="arial, geneva, helvetica" size=2  color="FF0000" ><strong>
										  ¡Falta Asignar Encargado de Confeccionar Acta!
										 </strong></font>
										 <?    
									}else{  ?>
										 <FONT face="arial, geneva, helvetica" size=2  color="000000" ><strong>
										 <? imp($fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]); ?>
										 </strong></font>
								<?	}  ?>
													
						<?php	};	?>
											
				<?php if($frmModo=="ingresar"){ ?>
									<select name="cmbACTA">
									  <option value=0 selected>Seleccione Encargado de Acta</option>
									  <?php
													$qry="SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp, empleado.rut_emp, trabaja.cargo, institucion.rdb FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (institucion.rdb=".$institucion.") order by empleado.ape_pat,empleado.ape_mat,empleado.nombre_emp asc";
												
														$result =@pg_Exec($conn,$qry);
														if (!$result) 
															error('<B> ERROR :</b>Error al acceder a la BD. (19)</B>');
														else{
															if (pg_numrows($result)!=0){
																$fila1 = @pg_fetch_array($result,0);
																if (!$fila1){
																	error('<B> ERROR :</b>Error al acceder a la BD. (20)</B>');
																	//exit();
																};
																for($i=0 ; $i < @pg_numrows($result) ; $i++){
																	$fila1 = @pg_fetch_array($result,$i);
																	echo  "<option value=".trim($fila1["rut_emp"]).">".trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_emp"])."</option>\n";
																}
															}
														};
													?>
                    </select> 
                    <?php };?>					</td>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td class="cuadro02" >OBSERVACIONES DEL ACTA</td>
					<td class="datosb">
						<?php if($frmModo=="ingresar"){ ?>
						<textarea name="observaciones" cols="70" rows="3"></textarea>
						<? } ?>
					<?php if($frmModo=="modificar"){ 
								$qry_observacion="select * from curso where id_curso=".$fila['id_curso'];
								$result_observacion =@pg_Exec($conn,$qry_observacion);
								$fila_observacion = @pg_fetch_array($result_observacion,0);?>
								<textarea name="observaciones" cols="70" rows="3"><?=$fila_observacion['observaciones']?></textarea>						
						<? } ?>	
						<?php 
						if($frmModo=="mostrar"){ ?>
							<FONT face="arial, geneva, helvetica" size=2><strong><?php
							$qry_observacion="select * from curso where id_curso=".$fila['id_curso'];
							$result_observacion =@pg_Exec($conn,$qry_observacion);
							$fila_observacion = @pg_fetch_array($result_observacion,0);
							echo $fila_observacion['observaciones'];							
								}?>
								</strong></FONT>					</td>				
                  </tr>
				<tr>
				  <td class="cuadro02" >&nbsp;</td>
				  <td class="datosb">&nbsp;</td>
				  </tr>
				<tr>
				  <td class="cuadro02" >SEDE</td>
				  <td class="datosb">
                  <?php if($frmModo=="modificar"){?>
				    <select name="sede" id="sede">
                    <option value="0">Seleccione</option>
				      <option value="1" <?php echo ($fila['sede']==1)?"selected":"" ?>>Principal</option>
				      <option value="2" <?php echo ($fila['sede']==2)?"selected":"" ?>>Anexo</option>
				      </select>
                      <?php }
                      if($frmModo=="mostrar"){
						  switch($fila['sede']){
							case 1:
							echo "Sede Principal";  
							break;
							case 2:
							echo "Sede Anexo";
							break;
							default:
							echo "";
							break;
						  }
							
						 }?>
                         <?php if($frmModo=="ingresar"){?>
				    <select name="sede" id="sede">
                    <option value="0">Seleccione</option>
				      <option value="1">Principal</option>
				      <option value="2">Anexo</option>
				      </select>
                      <?php } ?>
                      </td>
				  </tr>
				<tr>
				  <td class="cuadro02" >&nbsp;</td>
				  <td class="datosb">&nbsp;</td>
				  </tr>
				<tr>
				  <td class="cuadro02" >MONTO MENSUAL DE SUBVENCI&Oacute;N POR ALUMNO </td>
				  <td class="datosb"><label>
				    $ 					
					<?
					if ($frmModo=="mostrar"){ 
					     echo $fila_observacion['val_sub'];
					}
					
					if ($frmModo=="modificar"){  ?>				
				         <input name="val_sub" type="text" id="val_sub" value="<?=$fila_observacion['val_sub']?>"> 
				         Ej: 24918.82
				<?  } 
				
				    if ($frmModo=="ingresar"){  ?>
					     <input name="cap_curso" type="text" id="cap_curso" > 
					     Ej: 24918.82
				<?  } ?></label></td>
				  </tr>
				<tr>
				  <td class="cuadro02" >CAPACIDAD M&Aacute;XIMA DEL CURSO </td>
				  <td class="cuadro02" >
				&nbsp; <?
					if ($frmModo=="mostrar"){ 
					     echo $fila_observacion['cap_curso'];
					}
					
					if ($frmModo=="modificar"){  ?>				
				             <input name="cap_curso" type="text" id="cap_curso" value="<?=$fila_observacion['cap_curso']?>">
				         <?  } 
				
				    if ($frmModo=="ingresar"){  ?>
					     <input name="cap_curso" type="text" id="cap_curso" value="" >
					     <?  } ?> <br>
					     <br>
					     <span class="Estilo1">*Requerido Solo para la Generaci&oacute;n del Archivo de Subvenciones </span></td>
				</tr>
				<tr>
				  <td colspan="2" class="cuadro02 Estilo1" >&nbsp;</td>
				  </tr>
              </table>
			</div>  
	  
		</TD>
		 	</TR>
			
			<TR>
			  <TD colspan=4></TD>
		 	</TR>
		
			<TR height=15>
			  <TD height="60" colspan=2></TD>
			</TR>
		</TABLE>
	  </TD>
	</TR>
			
			
			
	  </TABLE>
	</FORM>
								  
								  
								  
								  
								  <!-- fin codigo nuevo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<? pg_close($conn); ?>
</body>
</html>
