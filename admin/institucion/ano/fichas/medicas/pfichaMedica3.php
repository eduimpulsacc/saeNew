<?php require('../../../../../util/header.inc');?>
<?php
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	if($tipo_hoja!=1){
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	}else{
	/****************VARIABLES PARA HOJA DE VIDA****************/
	$ano			=$_GET['c_ano'];
	$alumno			=$_GET['c_alumno'];
	$c_curso		=$_GET['c_curso'];
	/**********************************/
	}
	$idFicha		=$_FICHAM;
	$_POSP          = 5;
	
?>
<?php 
    // TOMO LOS DATOS DE LA FICHA_MEDICA, GENERAL, QUE SIEMPRE DEBO MOSTRAR
	

 		 $qry="SELECT * FROM ficha_medicanew3 WHERE id_fichamedica=$id_ficha ";
		$result =@pg_Exec($conn,$qry);
		if (!$result){
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
</script>
								<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>

		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
<!--
function valida(form){
		if(!chkVacio(form.fechacontrol,'Ingresar FECHA ATENCION.')){
			return false;
		};
		
				
		if (form.observaciones.value==0){
		   alert('Debe ingresar OBSERVACIONES');
		   return false;
		}   
		

		return true;
}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->

function fechas(caja)
{ 
  

   if (caja)
   {  
      borrar = caja;
       
      if ((caja.substr(2,1) == "-") && (caja.substr(5,1) == "-"))
      {      
         for (i=0; i<10; i++)
	     {	
            if (((caja.substr(i,1)<"0") || (caja.substr($i,1)== " ") || (caja.substr(i,1)>"9")) && (i != 2) && (i != 5))
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


</SCRIPT>
	
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.Estilo3 {font-family: Arial, Helvetica, sans-serif; font-size: -2; }
.Estilo4 {font-size: -2}
-->
</style>
</head>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="window.print(); ">
<TABLE WIDTH=650 BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
			
  <TR height=15>
				<TD valign="top">
					<table width="100%" border="0" cellspacing="0">
  <tr>
    <td width="69%"><TABLE width="98%" height="100%" BORDER=0 CELLPADDING=0 CELLSPACING=1>
						<TR>
							<TD width="17%" class="textonegrita">AÑO</TD>
							<TD width="3%" align="center" class="textonegrita">:</TD>
							<TD width="80%" class="textosimple">
								
									
										<?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nro_ano']);
												}
											}
										?>
																							<input type="hidden" name="id_ano" id="id_ano" value="<?php echo $ano ?>"></TD>
						</TR>
						<TR>
							<TD  class="textonegrita">ALUMNO</TD>
							<TD align="center"  class="textonegrita">:</TD>
							<TD class="textosimple"><?php
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													$fecha_nac = $fila1['fecha_nac'];
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_alu']);
												}
											}
										?>
										<input type="hidden" name="rut_alumno" id="rut_alumno" value="<?php echo $alumno ?>"></TD>
						</TR>
						<TR>
						  <TD  class="textonegrita">CURSO</TD>
						  <TD align="center"  class="textonegrita">:</TD>
						  <TD class="textosimple">
                          <? 				 $sqlcurso="select * from curso where id_ano=".$ano." and id_curso=".$_GET["c_curso"];
											$resultcurso =@pg_Exec($conn,$sqlcurso);
											$filacurso = @pg_fetch_array($resultcurso,0);
											
											?>
                          
                         
									
									<input type="hidden" name="id_curso" id="id_curso" value="<?php echo $c_curso ?>"><?php echo CursoPalabra($_GET["c_curso"], 1, $conn);?>
									</TD>
						  </TR>
              <tr>
                <TD  class="textonegrita">DOMICILIO</TD>
				<TD align="center"  class="textonegrita">:</TD>
                <td>
                  <?php 

                  $getComuna ="SELECT nom_com FROM COMUNA WHERE cor_com=".$fila1['ciudad'];
                      $result =@pg_Exec($conn,$getComuna);
                      if (!$result) {
                        error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
                      }else{
                        if (pg_numrows($result)!=0){
                          $comuna = @pg_fetch_array($result,0);  
                          if (!$comuna){
                            error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
                            exit();
                          }
                          
                        }
                      }



                    echo $fila1['calle']." #".$fila1['nro'].", ".$comuna['nom_com'];
                   ?>
                </td>
              </tr>
					</TABLE>
        </td>
    <td width="31%" align="center" valign="top"><?
		$sql_inst="select * from institucion where rdb=".$institucion;
		$result = @pg_Exec($conn,$sql_inst);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{ if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' width='80' height='80' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }
		}?></td>
  </tr>
</table>
<br>

					
				</TD>
			</TR>
			<TR height=15>
				<TD>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr class="tableindex">
    <td align="center">
      <input type="hidden" name="id_ficha" id="id_ficha" value="<?php echo $fila['id_fichamedica'] ?>">
      FICHA M&Eacute;DICA DEL ALUMNO</td>
  </tr>
  <tr>
    <td>
    <table width="100%">
      <td class="tableindex" width="10%;">Rut:</td><td width="20%;" style="text-align: center;"><?php echo $alumno."-".$fila1['dig_rut']?></td>  
      <td class="tableindex" width="10%;">Edad:</td><td width="10%;" style="text-align: center;"><?php echo CalcularEdad($fecha_nac); ?></td>
      <td class="tableindex" width="25%;">Fecha de Nacimiento:</td><td width="25%;" style="text-align: center;"><?php echo cambioFD($fecha_nac); ?></td>
    </table>
   </td>
  </tr>
  <tr>
    <td class="tableindex">Instituci&oacute;n Particular de Seguro Escolar (Todos los alumnos tienen Seguro Escolar p&uacute;blico por ley N&deg; 17.644 y Decreto Supremo N&deg; 313)</td>
  </tr>
  <tr class="textosimple">
    <td>
      <?php echo $fila['txt_seguropart'] ?>&nbsp;
    </td>
  </tr>
  <tr>
    <td>
    <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr class="tableindex">
        <td colspan="3" width="50%">Nombre de la Madre</td>
        <td colspan="3" width="50%">Nombre del Padre</td>
        </tr>
      <tr class="textosimple">
        <td colspan="3">
        <?php  $sqlmadre="select apoderado.* from apoderado, tiene2 where tiene2.rut_apo =apoderado.rut_apo and tiene2.rut_alumno = $alumno and apoderado.relacion=2";
		$rsmadre =@pg_Exec($conn,$sqlmadre);
		 $fila_madre = pg_fetch_array($rsmadre,0);
		 echo strtoupper($fila_madre['nombre_apo']." ".$fila_madre['ape_pat']." ".$fila_madre['ape_mat']);
		 ?>
          &nbsp;
        </td>
        <td colspan="3">
         <?php  $sqlpadre="select apoderado.* from apoderado, tiene2 where tiene2.rut_apo =apoderado.rut_apo and tiene2.rut_alumno = $alumno and apoderado.relacion=1";
		$rspadre =@pg_Exec($conn,$sqlpadre);
		 $fila_padre = pg_fetch_array($rspadre,0);
		 echo strtoupper($fila_padre['nombre_apo']." ".$fila_padre['ape_pat']." ".$fila_padre['ape_mat']);
		 ?>
        </td>
        </tr>
      <tr class="textosimple">
        <td width="17%"><?php echo $fila_madre['celular'] ?>&nbsp;</td>
        <td width="17%"><?php echo $fila_padre['fono_pega'] ?>&nbsp;</td>
        <td width="17%"><?php echo $fila_madre['telefono'] ?>&nbsp;</td>
        <td width="17%"><?php echo $fila_padre['celular'] ?>&nbsp;</td>
        <td width="17%"><?php echo $fila_padre['fono_pega'] ?>&nbsp;</td>
        <td width="17%"><?php echo $fila_padre['telefono'] ?>&nbsp;</td>
      </tr>
      <tr class="textosimple">
        <td width="17%" align="center">Celular</td>
        <td width="17%" align="center">Fono Trabajo</td>
        <td width="17%" align="center">Fono Casa</td>
        <td width="17%" align="center">Celular</td>
        <td width="17%" align="center">Fono Trabajo</td>
        <td width="17%" align="center">Fono Casa</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr>
        <td colspan="6" class="tableindex">Nombre de personas alternativas en caso de no ubicar padres (en par&eacute;ntesis indicar parentesco)</td>
        </tr>
      <tr class="textosimple">
        <td colspan="3"><?php echo $fila['nombre_alt1'] ?>&nbsp;</td>
        <td colspan="3"><?php echo $fila['nombre_alt2'] ?>&nbsp;</td>
      </tr>
      <tr class="textosimple">
        <td align="center"><?php echo $fila['celular_alt1'] ?>&nbsp;</td>
        <td align="center"><?php echo $fila['fonotrab_alt1'] ?>&nbsp;</td>
        <td align="center"><?php echo $fila['fonocasa_alt1'] ?>&nbsp;</td>
        <td align="center"><?php echo $fila['celular_alt2'] ?>&nbsp;</td>
        <td align="center"><?php echo $fila['fonotrab_alt2'] ?>&nbsp;</td>
        <td align="center"><?php echo $fila['fonocasa_alt2'] ?>&nbsp;</td>
        </tr>
      <tr class="textosimple">
        <td align="center">Celular</td>
        <td align="center">Fono Trabajo</td>
        <td align="center">Fono Casa</td>
        <td align="center">Celular</td>
        <td align="center">Fono Trabajo</td>
        <td align="center">Fono Casa</td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td class="tableindex"><p>ANTECEDENTES DE SALUD (En los casos afirmativos indicar detalles abajo en observaciones)</p></td>
    </tr>
  
  <tr>
    <td valign="top">
    <table  border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr bgcolor="#cccccc" class="textonegrita">
        
        <td width="20" align="center">SI</td>
        <td width="20" align="center">NO</td>
        <td width="170">Atenci&oacute;n</td>
        
        <td width="20" align="center">SI</td>
        <td width="20" align="center">NO</td>
        <td width="170">Atenci&oacute;n</td>
        <td width="20" align="center">SI</td>
        <td width="20" align="center">NO</td>
        <td width="170">Atenci&oacute;n</td>
        <td width="20" align="center">SI</td>
        <td width="20" align="center">NO</td>
        <td width="170">Atenci&oacute;n</td>
      </tr>
      <tr class="textosimple">
        
        <td width="20" align="center">
          <?php echo ($fila['bool_alergia']==1)?"X":"" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_alergia']==0 )?"X":"&nbsp;" ?></td>
        <td width="170">Alergias</td>
       
        <td width="20" align="center"><?php echo ($fila['bool_afeccioncardiaca']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_afeccioncardiaca']==0)?"X":"&nbsp;" ?></td>
         <td width="170">Afecciones Cardiacas</td>
        <td width="20" align="center"><?php echo ($fila['bool_alteracionmotriz']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_alteracionmotriz']==0)?"X":"&nbsp;" ?></td>
     	<td width="170">Alteraciones Motrices</td>
     	<td width="20" align="center"><?php echo ($fila['medicion_antropometrica']==1)?"X":"&nbsp;" ?></td>
     	<td width="20" align="center"><?php echo ($fila['medicion_antropometrica']==0)?"X":"&nbsp;" ?></td>
     	<td width="170">Autoriza a medici&oacute;n antropom&eacute;trica</td>
     </tr>
      <tr class="textosimple">
        
        <td width="20" align="center"><?php echo ($fila['bool_asma']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_asma']==0)?"X":"&nbsp;" ?></td>
        <td width="170">Asma</td>
        <td width="20" align="center"><?php echo ($fila['bool_afeccionrespiratoria']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_afeccionrespiratoria']==0)?"X":"&nbsp;" ?></td>
        <td width="170">Afecciones Respiratorias</td>
        <td width="20" align="center"><?php echo ($fila['bool_cirugia']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_cirugia']==0)?"X":"&nbsp;" ?></td>
        <td width="170">Interveci&oacute;n Quir&uacute;rgica</td>
        <td width="20" align="center"><?php echo ($fila['vacunas_ministeriales']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['vacunas_ministeriales']==0)?"X":"&nbsp;" ?></td>
        <td width="170">Vacunas ministeriales</td>
      </tr>
      <tr class="textosimple">
       
        <td width="20" align="center"><?php echo ($fila['bool_diabetes']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_diabetes']==0)?"X":"&nbsp;" ?></td>
         <td width="170">Diabetes</td>
        <td width="20" align="center"><?php echo ($fila['bool_afeccioncutanea']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_afeccioncutanea']==0)?"X":"&nbsp;" ?></td>
        <td width="170">Afecciones cut&aacute;neas</td>
        <td width="20" align="center"><?php echo ($fila['bool_medacamentoabitual']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_medacamentoabitual']==0)?"X":"&nbsp;" ?></td>
      <td width="170">Medicamentos Habituales</td>
      <td width="20" align="center"><?php echo ($fila['trastorno_sueno']==1)?"X":"&nbsp;" ?></td>
     	<td width="20" align="center"><?php echo ($fila['trastorno_sueno']==0)?"X":"&nbsp;" ?></td>
     	<td width="170">Trastorno de sueño</td>
      </tr>
      <tr class="textosimple">
        
        <td width="20" align="center"><?php echo ($fila['bool_epilepsia']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_epilepsia']==0)?"X":"&nbsp;" ?></td>
        <td width="170">Epilepsia</td>
        <td width="20" align="center"><?php echo ($fila['bool_alteracionsensorial']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_alteracionsensorial']==0)?"X":"&nbsp;" ?></td>
        <td width="170">Alteraciones Sensoriales</td>
        <td width="20" align="center"><?php echo ($fila['bool_otrasenfermedades']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_otrasenfermedades']==0)?"X":"&nbsp;" ?></td>
      <td width="170">Otras Enfermedades</td>
      <th colspan="2" style="background-color: #165090; color: #ffffff">G.S</th>
      <td colspan="1" width="170" align="center"><?php echo $fila['txt_sangre'] ?>&nbsp;</td>
      </tr>
      <tr class="textosimple">
        <td align="center"><?php echo ($fila['bool_desmayo3m']==1)?"X":"&nbsp;" ?></td>
        <td align="center"><?php echo ($fila['bool_desmayo3m']==0)?"X":"&nbsp;" ?></td>
        <td colspan="4">El alumno ha tenido alguna vez p&eacute;rdia de consciencia por m&aacute;s de 3 minutos</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
        <th colspan="2" style="background-color: #165090; color: #ffffff">&nbsp;</th>
        <td colspan="1" align="center">&nbsp;</td>
      </tr>
      <tr class="textosimple">
        <td colspan="6">Enfermedad m&aacute;s recurrente durante el a&ntilde;o </td>
        <td colspan="6">Qu&eacute; medicamentos toma habitualmente cuando est&aacute; enfermo</td>
        </tr>
      <tr class="textosimple">
        <td colspan="6"><?php echo $fila['enf_recurrente'] ?></td>
        <td colspan="6"><?php echo $fila['med_recurrente'] ?></td>
        </tr>
        <tr class="textosimple">
        <td colspan="6">Medicamentos tratamiento alergias</td>
        <td colspan="6">&nbsp;</td>
        </tr>
      <tr class="textosimple">
        <td colspan="6">
          <?php echo $fila['med_alergias'] ?></td>
        <td colspan="6">&nbsp;</td>
        </tr>
    </table></td>
    </tr>
    <!--<tr>
      <td>
        <span style="text-align: center">* G.S: Grupo sangu&iacute;neo.</span>
      </td>
    </tr>-->
  
   
    <tr>
    <td class="tableindex"><p>RIESGO CARDIOVASCULAR (Se&ntilde;ale si ha presentado s&iacute;ntoma extra&ntilde;os durante o inmediatamente despu&eacute;s de hacer ejercicios)</p></td>
    </tr>
  
  <tr>
    <td><table  border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr bgcolor="#cccccc" class="textonegrita">
       
        <td width="20" align="center">SI</td>
        <td width="20" align="center">NO</td>
         <td width="170">Atenci&oacute;n</td>
         <td width="440">DETALLES</td>
        </tr>
      <tr class="textosimple">
       
        <td width="20" align="center"> <?php echo ($fila['bool_mareos']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_mareos']==0 )?"X":"&nbsp;" ?> </td>
         <td width="170">Mareos</td>
         <td width="440"><?php echo $fila['txt_mareos'] ?>&nbsp;</td>
        </tr>
      <tr class="textosimple">
       
        <td width="20" align="center"><?php echo ($fila['bool_desmayos']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_desmayos']==0)?"X":"&nbsp;" ?></td>
         <td width="170">Desmayos</td>
         <td width="440"><?php echo $fila['txt_desmayos'] ?>&nbsp;</td>
        </tr>
      <tr class="textosimple">
        
        <td width="20" align="center"><?php echo ($fila['bool_dolorpecho']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_dolorpecho']==0)?"X":"&nbsp;" ?></td>
        <td width="170">Dolor al pecho</td>
        <td width="440"><?php echo $fila['txt_dolorpecho'] ?>&nbsp;</td>
        </tr>
      <tr class="textosimple">
        
        <td width="20" align="center"><?php echo ($fila['bool_difrespiratoria']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_difrespiratoria']==0)?"X":"&nbsp;" ?></td>
        <td width="170">Dificultad respiratoria grave</td>
        <td width="440"><?php echo $fila['txt_boolrespiratoria'] ?>&nbsp;</td>
        </tr>
      <tr class="textosimple">
        
        <td width="20" align="center"><?php echo ($fila['bool_antecedentefamiliar']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_antecedentefamiliar']==0)?"X":"&nbsp;" ?></td>
        <td width="170">Antecedentes familiares</td>
        <td width="440"><?php echo $fila['txt_antecedentefamiliar'] ?>&nbsp;</td>
        </tr>
    </table></td>
    </tr>
  
 <tr>
    <td class="tableindex"><p>MEDICAMENTOS (La enfermer&iacute;a del colegio no administra medicamentos salvo indicaci&oacute;n m&eacute;dica certificada. En caso de dolor mayor se podr&iacute;a administrar lo siguiente, previa autorizaci&oacute;n se&ntilde;alada en esta ficha. Dosificaci&oacute;n seg&uacute;n peso)</p></td>
    </tr>
  <tr>
    <td valign="top"><table  border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr bgcolor="#cccccc" class="textonegrita">
        
        <td width="20" align="center">SI</td>
        <td width="20" align="center">NO</td>
        <td width="170">Autorizo administrar</td>
        <td width="20" align="center">SI</td>
        <td width="20" align="center">NO</td>
        <td width="170">&nbsp;</td>
        <td width="20" align="center">SI</td>
        <td width="20" align="center">NO</td>
        <td width="170">&nbsp;</td>
      </tr>
      <tr class="textosimple">
       
        <td width="20" align="center"> <?php echo ($fila['bool_paracetamolgo']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_paracetamolgo']==0)?"X":"&nbsp;" ?></td>
         <td width="170">Paracetamol gotas</td>
        <td width="20" align="center"><?php echo ($fila['bool_ibuprofeno']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_ibuprofeno']==0)?"X":"&nbsp;" ?></td>
        <td width="170">Ibuprofeno 400 mg.</td>
        <td width="20" align="center"><?php echo ($fila['bool_salbutamol']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_salbutamol']==0)?"X":"&nbsp;" ?></td>
      <td width="170">Salbutamol Inhalador</td>
      </tr>
      <tr class="textosimple">
        
        <td width="20" align="center"><?php echo ($fila['bool_paracetamolgr']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_paracetamolgr']==0)?"X":"&nbsp;" ?></td>
        <td width="170">Paracetamol 80-160-500 mg.</td>
       
        <td width="20" align="center"><?php echo ($fila['bool_diclofenaco']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_diclofenaco']==0)?"X":"&nbsp;" ?></td>
         <td width="170">Diclofenaco 50 mg.</td>
        <td width="20" align="center"><?php echo ($fila['bool_viadil']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_viadil']==0)?"X":"&nbsp;" ?></td>
        <td width="170">Viadil gotas</td>
      </tr>
      <tr class="textosimple">
        
        <td width="20" align="center"><?php echo ($fila['bool_predual']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_predual']==0)?"X":"&nbsp;" ?></td>
        <td width="170">Predual</td>
        <td width="20" align="center"><?php echo ($fila['bool_loratadina']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_loratadina']==0)?"X":"&nbsp;" ?></td>
        <td width="170">Loratadina 10 mg.</td>
        <td width="20" align="center"><?php echo ($fila['bool_valpin']==1)?"X":"&nbsp;" ?></td>
        <td width="20" align="center"><?php echo ($fila['bool_valpin']==0)?"X":"&nbsp;" ?></td>
        <td width="170">Valpin gotas</td>
      </tr>
    </table></td>
    </tr>
 
   <tr>
    <td class="tableindex"><p>OBSERVACIONES (Anote detalle de afecciones o cualquier otro antecedente de salud que quiera agregar)</p></td>
    </tr>
  <tr class="textosimple">
    <td valign="top"><?php echo $fila['observaciones'] ?>&nbsp;</td>
    </tr>
    <tr>
    	<td>
    		<span>&nbsp;</span>
    	</td>
    </tr>
    <tr>
    	<td>
    		<span>&nbsp;</span>
    	</td>
    </tr>
    
              	</table>

                
				         </TD>
			</TR>
			
		</TABLE>

</body>
</html>
