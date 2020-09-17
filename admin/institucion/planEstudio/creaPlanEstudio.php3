<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$_POSP = 3;
	
	
    $qryIns="select tipo_instit from institucion where rdb=".$institucion;
	$resultIns = @pg_exec($conn,$qryIns);
	$filaIns	= @pg_fetch_array($resultIns,0);
	$Tipo_Ins = $filaIns['tipo_instit'];

	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		
<?php if($frmModo!="mostrar"){?>
		

	<?php if($Tipo_Ins==1){//COLEGIO?>
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
				if(!chkVacio(form.txtGRA,'Ingresar GRADO del curso.')){
					return false;
				};
				if(!nroOnly(form.txtGRA,'Se permiten sólo números para el GRADO del curso.')){
					return false;
				};
				//if(!chkVacio(form.txtLETRA,'Ingresar LETRA del curso.')){
				//	return false;
				//};
				//if(!letraOnly(form.txtLETRA,'Se permiten sólo letras para la LETRA del curso.')){
				//	return false;
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

				if(!chkSelect(form.cmbSUP,'Seleccionar SUPERVISOR del curso.')){
					return false;
				};
				//VALIDACION TIPO DE ENSEÑANZA
				if(form.cmbENS.value==110){
					if(form.txtGRA.value>8){
						alert('TIPO DE ENSENANZA no corresponde al grado del curso.');
						return false;
					}
				}else{
					if(form.txtGRA.value>5){
						alert('TIPO DE ENSENANZA no corresponde al grado del curso.');
						return false;
					};
				};
				//FIN VALIDACION TPO DE ENSEÑANZA

				if(!form.cmbEVAL.disabled){
					//VALIDACION DECRETO EVALUACION
					if(form.cmbEVAL.value==5111997){
						if((form.txtGRA.value>8)||(form.txtGRA.value<1)){
							alert('DECRETO DE EVALUACION no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value!=110)){
								alert('DECRETO DE EVALUACION no corresponde al curso.');
								return false;
							};
						};
					};
					if(form.cmbEVAL.value==1121999){
						if((form.txtGRA.value!=1)&&(form.txtGRA.value!=2)){
							alert('DECRETO DE EVALUACION no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value==110)){
								alert('DECRETO DE EVALUACION no corresponde al curso.');
								return false;
							};
						};
					};
					if(form.cmbEVAL.value==832001){
						if((form.txtGRA.value!=4)&&(form.txtGRA.value!=3)){
							alert('DECRETO DE EVALUACION no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value==110)){
								alert('DECRETO DE EVALUACION no corresponde al curso.');
								return false;
							};
						};
					};
					if(form.cmbEVAL.value==1461988){
						if((form.txtGRA.value!=8)&&(form.txtGRA.value!=4)){
							alert('DECRETO DE EVALUACION no corresponde al curso.');
							return false;
						}else{
							if((form.txtGRA.value==8)){
								if(form.cmbENS.value!=110){
									alert('DECRETO DE EVALUACION no corresponde al curso.');
									return false;
								};
							};
							if((form.txtGRA.value==4)){
								if(form.cmbENS.value==110){
									alert('DECRETO DE EVALUACION no corresponde al curso.');
									return false;
								};
							};

						};
					};
				};
				//FIN VALIDACION DECRETO EVALUACION

				if(!form.cmbPLAN.disabled){
					//VALIDACION DECRETO PLAN ESTUDIO
					if(form.cmbPLAN.value==5451996){
						if((form.txtGRA.value!=1)&&(form.txtGRA.value!=2)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value!=110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
				  			};
						};
					};

					if(form.cmbPLAN.value==5521997){
						if((form.txtGRA.value!=3)&&(form.txtGRA.value!=4)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value!=110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};

					if(form.cmbPLAN.value==2201999){
						if((form.txtGRA.value!=5)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value!=110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};
					
					if(form.cmbPLAN.value==812000){
						if((form.txtGRA.value!=6)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value!=110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};

					if(form.cmbPLAN.value==4812000){
						if((form.txtGRA.value!=7)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value!=110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};				

					if(form.cmbPLAN.value==922002){
						if((form.txtGRA.value!=8)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value!=110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};

					if(form.cmbPLAN.value==771999){
						if((form.txtGRA.value!=1)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value==110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};				

					if(form.cmbPLAN.value==832000){
						if((form.txtGRA.value!=2)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value==110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};				

					if(form.cmbPLAN.value==272001){
						if((form.txtGRA.value!=3)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value==110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};				
					
					if(form.cmbPLAN.value==1022002){
						if((form.txtGRA.value!=4)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value==110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};				

					if(form.cmbPLAN.value==4592002){
						if((form.txtGRA.value!=4)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value==110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};

					//FIN VALIDACION DECRETO PLAN ESTUDIO
				}
				if(!chkFecha2(form.txtFECHARES,'Fecha inválida.')){
					        return false;
				        };
				return true;
			}
		</SCRIPT>
	<?php }//FIN COLEGIO?>
	<?php if(($Tipo_Ins==2)||($Tipo_Ins==3)){//JARDIN O SALA CUNA?>
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

<?
if ($frmModo == "ingresar"){ ?>
<script language="javascript">
function valida(form){
  if(!chkVacio(form.txtNRESOL,'Debe ingresar NRO. RESOLUCION.')){
	   return false;
   };
      
   if(!nroOnly(form.txtNRESOL,'Se permiten sólo números para NRO. RESOLUCION.')){
	   return false;
	};
	
   if(!chkFecha2(form.txtFECHARES,'Fecha Inválida.')){
	   return false;
   };
   if(!chkVacio(form.txtFECHARES,'Debe ingresar FECHA.')){
	   return false;
   };   
   
   if(!chkVacio(form.txtNOMDECRE,'Ingrese NOMBRE DECRETO.')){
	   return false;
   };

   
   if (form.cmbENS.value==0){
	  alert ('Debe elegir un TIPO DE ENSEÑANZA')	;
		 return false;
   }
   
   if(!chkVacio(form.txtDRES,'Ingrese DESCRIPCION.')){
	   return false;
   };
   
   if(!nroOnly(form.sub1,'Ingrese valor numérico.')){ return false;  };
   if(!nroOnly(form.sub2,'Ingrese valor numérico.')){ return false;  };   
   if(!nroOnly(form.sub3,'Ingrese valor numérico.')){ return false;  };
   if(!nroOnly(form.sub4,'Ingrese valor numérico.')){ return false;  };
   if(!nroOnly(form.sub5,'Ingrese valor numérico.')){ return false;  };
   if(!nroOnly(form.sub6,'Ingrese valor numérico.')){ return false;  };
   if(!nroOnly(form.sub7,'Ingrese valor numérico.')){ return false;  };
   if(!nroOnly(form.sub8,'Ingrese valor numérico.')){ return false;  };
   if(!nroOnly(form.sub9,'Ingrese valor numérico.')){ return false;  };
   if(!nroOnly(form.sub10,'Ingrese valor numérico.')){ return false;  };

	if(!revisa_duplicado()){return false;}
	
	return true;	


}
</script>
<? } ?>

<script language="javascript">
  function fechas(caja)
  { 
   if (caja)
   {  
      borrar = caja;
      if ((caja.substr(2,1) == "-") && (caja.substr(5,1) == "-"))
      {      
         for (i=0; i<10; i++)
	     {	
            if (((caja.substr(i,1)<"0") || (caja.substr(i,1)== " ") || (caja.substr(i,1)>"9")) && (i != 2) && (i != 5))
			{
               borrar = '';
               break;  
			}  
         }
	     if (borrar)
	     { 
	        a = caja.substr(6,4);
		    m = caja.substr(3,2);
		    d = caja.substr(0,2);
		    if((a < 1900) || (a > 2050) || (m < 1) || (m > 12) || (d < 1) || (d > 31))
		       borrar = '';
		    else
		    {
		       if((a%4 != 0) && (m == 2) && (d > 28))	   
		          borrar = ''; // Año no viciesto y es febrero y el dia es mayor a 28
			   else	
			   {
		          if ((((m == 4) || (m == 6) || (m == 9) || (m==11)) && (d>30)) || ((m==2) && (d>29)))
			         borrar = '';	      				  	 
			   }  // else
		    } // fin else
         } // if (error)
      } // if ((caja.substr(2,1) == \"/\") && (caja.substr(5,1) == \"/\"))			    			
	  else
	     borrar = '';		 
	  if (borrar == '')
	     alert('Fecha erronea');  
   }  // if (caja)       
} // FUNCION

function revisa_duplicado(){

	for(x=1;x<21;x++){
		valor=eval("document.frm.sub"+x+".value")
		n=0

		for(y=0;y<document.frm.elements.length;y++){
			if((document.frm.elements[y].name.substring(0,3)=="sub")&&(document.frm.elements[y].value==valor)&&(document.frm.elements[y].value!="")){
				n++;
			}
		}
		if(n>1){
			alert("No puede repetir valor en subsectores");
			return false;
		}
	}
	return true;
}

</script>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../Sea/cortes/b_ayuda_r.jpg','../../../Sea/cortes/b_info_r.jpg','../../../Sea/cortes/b_mapa_r.jpg','../../../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                       <? $menu_lateral=2 ;include("../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390"><!-- nuevo codigo -->
								    
								  
								  
								  
								  
								  

	<?php //echo tope("../../../util/");?>
	<FORM method=post name="frm" action="procesoPlanEstudio.php3">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=ano value=".$ano.">";
	?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
          <TR> 
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>INSTITUCION</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> 
              <?php
										 
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (31)</B>');
											}else{

												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (41)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												}
 											}
										?>
              </strong> </FONT> </TD>
          </TR>
        </TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							
            <TD align=right colspan=2> 
              <?php if($frmModo=="ingresar"){ ?>
              <input class="botonXX"  type="submit"  value="GUARDAR"   name=btnGuardar2 onClick="return valida(this.form);" > 
              &nbsp; 
              <INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarPlanesEstudio.php3">&nbsp;
								<?php };?>
								<?php if($frmModo=="mostrar"){ ?>
									<!--PENDIENTE POR MUCHO ENRREDO-->
									<!--INPUT TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaCurso.php3?curso=<?php echo $curso?>&caso=3"-->&nbsp;
									<?php if($_PERFIL!=17){?>
										<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
											<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaCurso.php3?caso=9">&nbsp;
											<?php }?>
										<?php }?>
										<INPUT class="botonXX"  TYPE="button" value="LISTADO" onClick=document.location="listarCursos.php3">
              &nbsp; 
              <?php }?>
              <?php };?>
              <?php if($frmModo=="modificar"){ ?>
              <input class="botonXX"  type="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >
              &nbsp; 
              <INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaPlanEstudio.php3?caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20 >
							
            <TD align=middle colspan=2 class="tableindex"> CREAR PLAN DE ESTUDIO PROPIO </TD>
						</TR>
						<TR>
							<TD width=40></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2>
									<TR>
										<TD width="166">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>Nº RES. O DECRETO</STRONG>
											</FONT>
										</TD>
										<TD width="170">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>FECHA</STRONG>
											</FONT>
										</TD>
										
                  <TD width="183"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>NOMBRE DECRETO ej.( 10 de 2000)</strong> </FONT> </TD>
									</TR>
									<TR>
										<TD align=left>
											<?php if($frmModo=="ingresar"){ 
												 ?>
												<INPUT type="text" name=txtNRESOL size=10 maxlength=10 align="top">
												
                    						<?php };?>
                    						<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['grado_curso']);
												};
											?>
                    <?php if($frmModo=="modificar"){ ?>
                    <INPUT type="text" name=txtNRESOL size=10 maxlength=10 value="<?php echo trim($fila['grado_curso'])?>">
											<?php };?>
										</TD>
										<TD align=left>
											
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name="txtFECHARES" size="10" maxlength="10" onChange='fechas(this.value); this.value=borrar'>
												<br><strong><font face="Arial, Helvetica, sans-serif" size="1">DD-MM-AAAA</font></strong>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['grado_curso']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtFECHARES size=10 maxlength=10 value="<?php echo trim($fila['grado_curso'])?>">
												<br>
												<strong><font face="Arial, Helvetica, sans-serif" size="1">DD-MM-AAAA</font></strong>
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtNOMDECRE size=15 maxlength=20>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['nombre_decreto']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtNOMDECRE size=10 maxlength=10 value="<?php echo trim($fila['nombre_decreto'])?>">
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
	<?php if($Tipo_Ins==1){//COLEGIO?>
		<?php
			//TIPO DE ENSEÑANZA AL QUE CORRESPONDE
			$qry="SELECT curso.id_curso, tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
			$result =@pg_Exec($conn,$qry);
			$fila4= @pg_fetch_array($result,0);
		?>
		<?php					if(($fila4["cod_tipo"]!=10)&&($fila4["cod_tipo"]!=20)&&($fila4["cod_tipo"]!=30)&&($fila4["cod_tipo"]!=40)&&($fila4["cod_tipo"]!=50)&&($fila4["cod_tipo"]!=60)){//ENSEÑANZA KINDER U OTRO CABRO CHICO
		?>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width=100%>
									<TR>
										
                  <TD width="44%"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>TIPOS DE ENSEÑANZA</STRONG> 
                    </FONT> </TD>
										
                  <TD width="56%" align="left"> <FONT face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; 
                    DESCRIPCION (RANGO ENTRE CURSOS) ej. 1 A 2 Medio </FONT> </TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<?php if($Tipo_Ins==1){//COLEGIO?>
													<Select name="cmbENS" onChange="chkENS(this.form);">
												<?php }else{ ?>
													<Select name="cmbENS">
												<?php }?>
													<option value=0 selected></option>;
													<?php
													
														$qry="SELECT * FROM TIPO_ENSENANZA WHERE COD_TIPO<>0";
														$result =@pg_Exec($conn,$qry);
														if (!$result) 
															error('<B> ERROR :</b>Error al acceder a la BD. (71)</B>');
														else{
															if (pg_numrows($result)!=0){
																$fila = @pg_fetch_array($result,0);	
																if (!$fila){
																	error('<B> ERROR :</b>Error al acceder a la BD. (81)</B>');
																	exit();
																};
																for($i=0 ; $i < @pg_numrows($result) ; $i++){
																	$fila = @pg_fetch_array($result,$i);
																	if($Tipo_Ins==1){//COLEGIO
																	//	if($fila["cod_tipo"]>100) PARA QUE MUESTRE TODO
																			echo  "<option value=".$fila["cod_tipo"].">".$fila["nombre_tipo"]."</option>";
																	}
																	if($Tipo_Ins==2){//JARDIN INFANTIL
																		//if(($fila["cod_tipo"]<100)&&($fila["cod_tipo"]>40)) AGREGANDO LAS SC
																		if(($fila["cod_tipo"]<100))
																			echo  "<option value=".$fila["cod_tipo"].">".$fila["nombre_tipo"]."</option>";
																	}
																	if($Tipo_Ins==3){//SALACUNA
																		if($fila["cod_tipo"]<=40) // SOLO SALACUNA
																			echo  "<option value=".$fila["cod_tipo"].">".$fila["nombre_tipo"]."</option>";
																	}
																}
															}
														};
													?>
												</Select>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													$qry="SELECT * FROM TIPO_ENSENANZA ";
													$result =@pg_Exec($conn,$qry);
													if (!$result) {
														error('<B> ERROR :</b>Error al acceder a la BD. (32)</B>');
													}else{
														if (pg_numrows($result)!=0){
															$fila1 = @pg_fetch_array($result,0);	
															if (!$fila1){
																error('<B> ERROR :</b>Error al acceder a la BD. (42)</B>');
																exit();
															}
															echo trim($fila1['nombre_tipo']);
														}
													}
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<?php if($Tipo_Ins==1){//COLEGIO?>
													<Select name="cmbENS" onChange="chkENS(this.form);">
												<?php }else{ ?>
													<Select name="cmbENS">
												<?php }?>
													<option value=0></option>;
													<?php
														//TIPO DE ENSEÑANZA AL QUE CORRESPONDE
														$qry="SELECT curso.id_curso, tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
														$result =@pg_Exec($conn,$qry);
														$fila4= @pg_fetch_array($result,0);

														//TIPOS DE ENSENANZA
														$qry="SELECT * from tipo_ensenanza  WHERE COD_TIPO<>0";
														$result =@pg_Exec($conn,$qry);
														if (!$result) 
															error('<B> ERROR :</b>Error al acceder a la BD. (91)</B>');
														else{
															if (pg_numrows($result)!=0){
																$fila1 = @pg_fetch_array($result,0);	
																if (!$fila1){
																	error('<B> ERROR :</b>Error al acceder a la BD. (101)</B>');
																	exit();
																};
																for($i=0 ; $i < @pg_numrows($result) ; $i++){
																	$fila1 = @pg_fetch_array($result,$i);
																	if($fila4["cod_tipo"]!=$fila1["cod_tipo"]){
																		echo "<option value=".$fila1["cod_tipo"].">".$fila1["nombre_tipo"]."</option>";
																	}else{
																		echo "<option value=".$fila1["cod_tipo"]." selected >".$fila1["nombre_tipo"]."</option>";
																	}
																}
															}
														};
													?>

												</Select>
											<?php };?>
											
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ 
												 ?>
												<INPUT type="text" name=txtDRES size=35 maxlength=35>
                    						<?php };?>
                    						<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['grado_curso']);
												};
											?>
                   							 <?php if($frmModo=="modificar"){ ?>
                   								 <INPUT type="text" name=txtDRES size=35 maxlength=35 value="<?php echo trim($fila['grado_curso'])?>">
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
		<?php }//FIN ENSEÑANZA CURSO?>
	<?php }//COLEGIO?>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										
                  <TD class="tablatit2-1">GRADOS PARA EL TIPO DE ENSEÑANZA</TD>
				
					
					</TR>
									<TR>
										<TD>
										<input name="PA" type="checkbox" value="1"><strong><font face="arial, genova, helvetica" size=1>PRIMER AÑO</font></strong>
										<input name="SA" type="checkbox" value="1"><strong><font face="arial, genova, helvetica" size=1>SEGUNDO AÑO</font></strong>
										<input name="TA" type="checkbox" value="1"><strong><font face="arial, genova, helvetica" size=1>TERCER AÑO</font></strong>&nbsp; 
					                    <input name="CU" type="checkbox" value="1"><strong><font face="arial, genova, helvetica" size=1>CUARTO AÑO</font></strong> 
										<br><br>
										<input name="PA" type="checkbox" value="1"><strong><font face="arial, genova, helvetica" size=1>QUINTO AÑO</font></strong>
										<input name="SA" type="checkbox" value="1"><strong><font face="arial, genova, helvetica" size=1>SEXTO AÑO</font></strong>&nbsp;&nbsp;&nbsp;&nbsp;
										<input name="TA" type="checkbox" value="1"><strong><font face="arial, genova, helvetica" size=1>SEPTIMO AÑO</font></strong> 
					                    <input name="CU" type="checkbox" value="1"><strong><font face="arial, genova, helvetica" size=1>OCTAVO AÑO</font></strong> 
									
						<?php if($frmModo=="mostrar"){ ?>
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ 
													$qry55="SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM curso INNER JOIN (empleado INNER JOIN supervisa ON empleado.rut_emp = supervisa.rut_emp) ON curso.id_curso = supervisa.id_curso WHERE (((curso.id_curso)=".$fila['id_curso']."))";
													$result55 =@pg_Exec($conn,$qry55);
													$fila55 = @pg_fetch_array($result55,0);
													imp($fila55["ape_pat"]." ".$fila55["ape_mat"].", ".$fila55["nombre_emp"]);
												};
											?>
                    <?php if($frmModo=="modificar"){ ?>
                    <?php };?>
                  </TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
					<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										
                  <TD class="tablatit2-1">AGREGAR SUBSECTORES PARA PLAN PROPIO</TD>
					</TR>
					<TR>
				    <TD><table width="534" border="0">
                      <tr>
									
									    <td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 1</font></strong></td>
	  									<td width="%"><input name="sub1" type="text" size="6" maxlength="6"></td>
	  									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 2 </font></strong></td>
	  									<td width="%"><input name="sub2" type="text" size="6" maxlength="6"></td>
										<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 3</font></strong></td>
	  									<td width="%"><input name="sub3" type="text" size="6" maxlength="6"></td>
										<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 4</font></strong></td>
										<td width="%"><input name="sub4" type="text" size="6" maxlength="6"></td>
										<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 5</font></strong></td>
	  									<td width="%"><input name="sub5" type="text" size="6" maxlength="6"></td>
								  </tr>
								  <tr>
									<td colspan="8">&nbsp;</td>
								  </tr>
								  <tr>
										<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 6</font></strong></td>
	  									<td width="%"><input name="sub6" type="text" size="6" maxlength="6"></td>
										<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 7</font></strong></td>
	  									<td width="%"><input name="sub7" type="text" size="6" maxlength="6"></td>
										<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 8</font></strong></td>
	  									<td width="%"><input name="sub8" type="text" size="6" maxlength="6"></td>
										<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 9</font></strong></td>
	  									<td width="%"><input name="sub9" type="text" size="6" maxlength="6"></td>
										<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 10</font></strong></td>
	  									<td width="%"><input name="sub10" type="text" size="6" maxlength="6"></td>
								  </tr>
								  <tr>
									<td colspan="8">&nbsp;</td>
								  </tr>
								  <tr>
										<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 11</font></strong></td>
	  									<td width="%"><input name="sub11" type="text" size="6" maxlength="6"></td>
										<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 12</font></strong></td>
	  									<td width="%"><input name="sub12" type="text" size="6" maxlength="6"></td>
										<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 13</font></strong></td>
										<td width="%"><input name="sub13" type="text" size="6" maxlength="6"></td>
										<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 14</font></strong></td>
	  									<td width="%"><input name="sub14" type="text" size="6" maxlength="6"></td>
										<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 15</font></strong></td>
	  									<td width="%"><input name="sub15" type="text" size="6" maxlength="6"></td>
								  </tr>	
								   <tr>
									
                        <td height="22" colspan="8">&nbsp;</td>
								  </tr> 
								   <tr>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 16</font></strong></td>
	  									<td width="%"><input name="sub16" type="text" size="6" maxlength="6"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 17</font></strong></td>
	  									<td width="%"><input name="sub17" type="text" size="6" maxlength="6"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 18</font></strong></td>
	  									<td width="%"><input name="sub18" type="text" size="6" maxlength="6"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 19</font></strong></td>
	  									<td width="%"><input name="sub19" type="text" size="6" maxlength="6"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR 20</font></strong></td>
	  									<td width="%"><input name="sub20" type="text" size="6" maxlength="6"></td>
								  </tr>	 
								  
								</table> </TD>
					</TR>
					</TABLE>
					</TD>
					</TR>

						
						<TR height=15>
							
            <TD width="100%" height="58" colspan=2> 
              <?php if($frmModo=="mostrar"){?>
              <INPUT class="botonXX"  TYPE="button" value="ALUMNOS" onClick=document.location="alumno/listarAlumnos.php3?_url=0">
									<?php if($fila['ensenanza']>100){// PREBASICA NO TIENE SUBSECTORES?>
										<INPUT class="botonXX"  TYPE="button" value="SUBSECTORES" onClick=document.location="ramo/listarRamos.php3">
										<INPUT class="botonXX"  TYPE="button" value="HORARIO" onClick=document.location="horario/listarHorario.php">
									<?php }?>
									<?php /************* MODIFICACION 11-02-2003 *******************/ 
											/*----------- Boton Situacion Alumno ----------------*/  
												if (TieneNotas($institucion,$ano,$curso,$conn)==true){ ?>
													<INPUT class="botonXX"  TYPE="button" value="PROMOCION" onClick=document.location="promocion/promocion.php">
									<?php		};
											/*---------------------------------------------------*/  
										  /************* FIN MODIFICACION 11-02-2003 ***************/ ?>
								<?php }else{?>
										<!--<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ALUMNOS" disabled>-->
										<?php if($fila['ensenanza']>100){// PREBASICA NO TIENE SUBSECTORES?>
											<!--<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="SUBSECTORES" disabled>-->
										<?php }?>
										<?php /************* MODIFICACION 11-02-2003 *******************/ 
												/*----------- Boton Situacion Alumno ----------------*/  ?>
													<!--<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="PROMOCION" disabled>-->
										<?php	/*---------------------------------------------------*/  
											  /************* FIN MODIFICACION 11-02-2003 ***************/ ?>
								<?php }?>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>		
		</TABLE>
	</FORM>

								  
								  
								  <!--fin nuevo codigo--> </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><div align="center">SAE 
                          Sistema de Administraci&oacute;n Escolar - 2005 - Desarrolla 
                          Colegio Interactivo</div></td>
                    </tr>
                  </table>
                  <table width="739" height="30" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <? include("../../../cabecera/menu_inferior.php"); ?></td>
  </tr>
</table>
                  </td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
