<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function cerrar(){ 
window.close() 
} 

</script>


<div id="capa0">
<table width="100%">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()" value="CERRAR"></td>
	<td align="right">
		  <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
	</td></tr></table></div>

<?
require('../../../../util/header.inc');
//include ("../calendario/calendario.php");


	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 6;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

function valida_ingreso(){
	if((document.frm1.BUSCARX[0].checked)&&(document.frm1.filtroRUT.value=="")){
		alert("Debe ingresar Rut");
		return;
	}
	if((document.frm1.BUSCARX[1].checked)&&(document.frm1.Apellido.value=="")){
		alert("Debe ingresar Apellido");
		return;
	}
	document.frm1.submit();
}
//-->
</script>
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
</head>



								  <!-- AQUÍ INSERTAMOS EL NUEVO CÓDIGO -->
								  
								  
								  <?php if(($_PERFIL!=17) &&  ($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>
<table width="" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
<?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../index.php";
		 </script>

<? } ?>				
      
	     <?
						 include("../../../../cabecera/menu_inferior.php");
						 ?>
	  
	  
	   </td>
  </tr>
</table>

<? } ?>
	<?php //echo tope("../../util/");?>
			<?php if($modo=="ini"){ ?>
				<form method="post" name="frm1" action="listarMatricula.php3?sw_lista=1">
				  <center>
				</center>
				</form>
			<?php }else{?>
				<form method="post" name="frm1" action="listarMatricula.php3?sw_lista=1">
					<center>
					<table  border="0" cellpadding="0" cellspacing="0" width=600>
						<tr>
						  <td align="left">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" colspan="2">
								<table>
									<tr>
	<td><a HREF="print_matricula.php3?pag=1&listar=A&sw_lista=1"><strong><h4>A</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=B&sw_lista=1"><strong><h4>B</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=C&sw_lista=1"><strong><h4>C</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=D&sw_lista=1"><strong><h4>D</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=E&sw_lista=1"><strong><h4>E</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=F&sw_lista=1"><strong><h4>F</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=G&sw_lista=1"><strong><h4>G</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=H&sw_lista=1"><strong><h4>H</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=I&sw_lista=1"><strong><h4>I</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=J&sw_lista=1"><strong><h4>J</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=K&sw_lista=1"><strong><h4>K</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=L&sw_lista=1"><strong><h4>L</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=LL&sw_lista=1"><strong><h4>LL</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=M&sw_lista=1"><strong><h4>M</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=N&sw_lista=1"><strong><h4>N</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=Ñ&sw_lista=1"><strong><h4>Ñ</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=O&sw_lista=1"><strong><h4>O</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=P&sw_lista=1"><strong><h4>P</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=Q&sw_lista=1"><strong><h4>Q</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=R&sw_lista=1"><strong><h4>R</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=S&sw_lista=1"><strong><h4>S</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=T&sw_lista=1"><strong><h4>T</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=U&sw_lista=1"><strong><h4>U</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=V&sw_lista=1"><strong><h4>V</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=W&sw_lista=1"><strong><h4>W</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=X&sw_lista=1"><strong><h4>X</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=Y&sw_lista=1"><strong><h4>Y</h4></strong></a></td>
	<td><a HREF="print_matricula.php3?pag=1&listar=Z&sw_lista=1"><strong><h4>Z</h4></strong></a></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					</center>
				</form>
				
<?php

// Evitamos la inyeccion SQL 

// Modificamos las variables pasadas por URL 
foreach( $_GET as $variable => $valor ){ 
$_GET [ $variable ] = str_replace ( "'" , "'" , $_GET [ $variable ]); 
} 
// Modificamos las variables de formularios 
foreach( $_POST as $variable => $valor ){ 
$_POST [ $variable ] = str_replace ( "'" , "'" , $_POST [ $variable ]); 
} 



	$filRUT=(trim($swrbd)=='1')?$filtroRUT:"";
	

	if ($filRUT!=''){
		if ($BUSCARX==1){
							//$qry = "SELECT matricula.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.id_curso  FROM MATRICULA, ALUMNO WHERE matricula.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matricula.rut_alumno = alumno.rut_alumno";
							//$qry2 = "SELECT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso, ALUMNO WHERE matriculatpsincurso.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matriculatpsincurso.rut_alumno = alumno.rut_alumno";		
							$qry = "SELECT matricula.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.id_curso, matricula.bool_ar  FROM MATRICULA, ALUMNO WHERE matricula.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matricula.rut_alumno = alumno.rut_alumno";
							$qry2 = "SELECT DISTINCT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso, ALUMNO WHERE matriculatpsincurso.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matriculatpsincurso.rut_alumno = alumno.rut_alumno";		
						}
} else { 
		if ($BUSCARX==2){	
		
		   
			//$qry = "SELECT matricula.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.id_curso FROM MATRICULA, ALUMNO WHERE (lower(alumno.ape_pat) LIKE '%".strtolower($Apellido)."%') and alumno.rut_alumno = matricula.rut_alumno and matricula.id_ano = ".$ano." ORDER BY alumno.ape_pat, alumno.ape_mat ";
			//$qry2 = "SELECT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso, ALUMNO WHERE (lower(alumno.ape_pat) LIKE '%".strtolower($Apellido)."%') and alumno.rut_alumno = matriculatpsincurso.rut_alumno and matriculatpsincurso.id_ano = ".$ano." ORDER BY alumno.ape_pat, alumno.ape_mat ";		
			$qry = "SELECT matricula.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.id_curso, matricula.bool_ar FROM MATRICULA INNER JOIN ALUMNO ON alumno.rut_alumno = matricula.rut_alumno WHERE (lower(alumno.ape_pat) LIKE '%".strtolower($Apellido)."%') and matricula.id_ano = ".$ano." and matricula.rdb= ".$institucion." ORDER BY alumno.ape_pat, alumno.ape_mat ";
			$qry2 = "SELECT DISTINCT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso INNER JOIN ALUMNO ON alumno.rut_alumno = matriculatpsincurso.rut_alumno WHERE (lower(alumno.ape_pat) LIKE '%".strtolower($Apellido)."%')and matriculatpsincurso.id_ano = ".$ano." and matricula.rdb= ".$institucion." ORDER BY alumno.ape_pat, alumno.ape_mat ";
		}
	 }
	 
	 
	 //------
	if ($BUSCARX==0){	 
		if ($filRUT!=''){
		   
			//$qry = "SELECT matricula.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.id_curso  FROM MATRICULA, ALUMNO WHERE matricula.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matricula.rut_alumno = alumno.rut_alumno";
			//$qry2 = "SELECT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso, ALUMNO WHERE matriculatpsincurso.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matriculatpsincurso.rut_alumno = alumno.rut_alumno";		
			$qry = "SELECT matricula.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.id_curso, matricula.bool_ar  FROM MATRICULA INNER JOIN ALUMNO ON matricula.rut_alumno=alumno.rut_alumno WHERE matricula.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matricula.rdb= ".$institucion;
			$qry2 = "SELECT DISTINCT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso INNER JOIN ALUMNO ON matriculatpsincurso.rut_alumno=alumno.rut_alumno WHERE matriculatpsincurso.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matricula.rdb= ".$institucion;		
		 } else {
		    
		    
			//$qry = "SELECT matricula.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.id_curso FROM MATRICULA, ALUMNO WHERE (alumno.ape_pat LIKE '$listar%') and alumno.rut_alumno = matricula.rut_alumno and matricula.id_ano = ".$ano." ORDER BY alumno.ape_pat, alumno.ape_mat ";
			//$qry2 = "SELECT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso, ALUMNO WHERE (alumno.ape_pat LIKE '$listar%') and alumno.rut_alumno = matriculatpsincurso.rut_alumno and matriculatpsincurso.id_ano = ".$ano." ORDER BY alumno.ape_pat, alumno.ape_mat ";		
			$qry = "SELECT matricula.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula.id_curso, matricula.bool_ar FROM MATRICULA INNER JOIN ALUMNO ON alumno.rut_alumno = matricula.rut_alumno WHERE (upper (alumno.ape_pat) LIKE '$listar%') and matricula.id_ano = ".$ano." and matricula.rdb= ".$institucion." ORDER BY alumno.ape_pat, alumno.ape_mat ";
			$qry2 = "SELECT DISTINCT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso INNER JOIN ALUMNO ON alumno.rut_alumno = matriculatpsincurso.rut_alumno WHERE (upper (alumno.ape_pat) LIKE '$listar%') and matriculatpsincurso.id_ano = ".$ano." and matricula.rdb= ".$institucion." ORDER BY alumno.ape_pat, alumno.ape_mat ";		

		 }	 
	}
	if($sw=="")
	{
		$sw_lista=1;
	}
	if ($sw_lista==1){
	    
		$result  =pg_Exec($conn,$qry);
		$result3 =pg_Exec($conn,$qry2);
	?>
	<table border="0" cellpadding="1" cellspacing="1" bgcolor="white" WIDTH=550 align=center>
		<tr>
			<td colspan=3>
				<table width="100%" cellpadding="0" cellspacing="0" >
					<tr>
					  <td align="right">                       <?php  /*$qry="SELECT * FROM (institucion INNER JOIN matricula ON institucion.rdb=matricula.rdb)INNER JOIN (curso INNER JOIN tipo_ensenanza ON cod_tipo=ensenanza ) ON matricula.id_curso=curso.id_curso WHERE (institucion.rdb=(".$institucion.") AND (cod_tipo='410' OR cod_tipo='510' OR cod_tipo='610' OR cod_tipo='710' OR cod_tipo='810' ))";*/
					   			$qry="select * from tipo_ense_inst where rdb=".$institucion." and cod_tipo>310 and estado=0";
											$result2 =@pg_Exec($conn,$qry);
												if (pg_numrows($result2)!=0){  ?>
                     <?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL !=6) ){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)&&($_PERFIL!=20)){ //FINANCIERO Y  CONTADOR?><?php }?>
					   <?php }?>
                     <?php }?>

					<?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=26)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
						<? if($institucion==24511){?>
						<? }?><?php }?>
					<?php }
					if($_PERFIL!=20){?></td> 
					<? } ?>
				  </tr>
					<tr>
						<td align=center>
							<H1><?php echo trim($listar)?></H1></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr height="20">
			<td align="center" colspan="3" class="tableindex">
				MATRICULA <? echo @pg_numrows($result)+@pg_numrows($resul3)?> ALUMNOS
			</td>
		</tr>
		<tr bgcolor="#48d1cc">
			<td ALIGN=CENTER class="tablatit2-1">
				RUT
			</td>
			<td ALIGN=CENTER class="tablatit2-1">
				NOMBRE ALUMNO </td>
			<td ALIGN=CENTER class="tablatit2-1">
				CURSO</font>
			</td>
		</tr>
		<?php
			for($i=0 ; $i < @pg_numrows($result) ; $i++){
				$fila = @pg_fetch_array($result,$i);
		
		 				if ($fila['bool_ar'] == 1){
						    $tachado = "tachado";
						    ?>
							<tr  onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' ('seteaMatricula.php3?alumno=<?php echo trim($fila["rut_alumno"]);?>&caso=1')>
		                     					
							<?
					    }else{
						     $tachado = "";
						     ?>
							 <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' ('seteaMatricula.php3?alumno=<?php echo trim($fila["rut_alumno"]);?>&caso=1')>
		                     
							 <?
					     } ?>	  
		  <td align="left" class="<?=$textosimple ?>" >
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong><?php echo $fila["rut_alumno"]."-".$fila["dig_rut"];?></strong>
			  </font>
		  </td>
		  <td align="left" class="<?=$tachado ?>">
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong><?php echo ucwords(strtolower(trim($fila["ape_pat"]." ".$fila["ape_mat"]." ".$fila["nombre_alu"])));?></strong>
			  </font>
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong>  				  </strong>
			  </font>
			  <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;</font>		    <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;
  			  </font>
		  </td>
		  <td align="left" class="<?=$tachado ?>">
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong>
				  <?php 
				  $Curso_pal = CursoPalabra($fila["id_curso"], 0, $conn);
				  if (empty($Curso_pal))
				  	$Curso_pal = "Sin Curso";
   			  	  $Curso_pal = trim(ucwords(strtolower($Curso_pal)));
				  echo $Curso_pal;
				  
				  ?>
				  </strong>
			  </font>
		  </td>
			</tr>
		<?php }?>
		<?php
			for($i=0 ; $i < @pg_numrows($result3) ; $i++){
				$fila = @pg_fetch_array($result3,$i);
		?>

		<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' ('seteaMatriculaTP.php3?alumno=<?php echo trim($fila["rut_alumno"]);?>&caso=1')>
		  <td align="left" >
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong><?php echo $fila["rut_alumno"]."-".$fila["dig_rut"];?></strong>
			  </font>
		  </td>
		  <td align="left" >
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong><?php echo ucwords(strtolower(trim($fila["ape_pat"]." ".$fila["ape_mat"]." ".$fila["nombre_alu"])));?></strong>
			  </font>
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong>  				  </strong>
			  </font>
			  <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;</font>		    <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;
  			  </font>
		  </td>
		  <td align="left">			  <font face="arial, geneva, helvetica" size="1" color="#000000">
			  <strong>
				  SIN CURSO
			  </strong>
		  </font>
		  </td>
	  </tr>
		<?php }?>		
		<tr>
			<td colspan="3">
			<hr width="100%" color="#003b85">
			</td>
		</tr>

	</table>
	<?php }?>
	<?php }?>
<?php 
	//	echo "pag:".$pag."<BR>";
	//	echo "pagOffset:".$pagOffset."<BR>";
	//	echo "pg_numrows:".pg_numrows($result)."<BR>";

if ($sw_lista==1){
  $query_mat="select count(*) as mat from matricula where rdb='$institucion' and id_ano='$ano' and bool_ar<>1";
  $filsMatriculados=pg_fetch_array(pg_exec($conn,$query_mat));
  $query_ret="select count(*) as ret from matricula where rdb='$institucion' and id_ano='$ano' and bool_ar=1";
  $filsRetirados=pg_fetch_array(pg_exec($conn,$query_ret));
  
   
?>
<table border="0" cellpadding="1" cellspacing="1" bgcolor="white" WIDTH=650 align=center>
<TR>
	<TD WIDTH="70%"> <font face="arial, geneva, helvetica" size="1">Total Alumnos Matriculados</font></TD>
	<TD> <font face="arial, geneva, helvetica" size="1" color="#000000"><? echo $filsMatriculados['mat'];?></font></TD>
</TR>
<TR>
	<TD WIDTH="30%"> <font face="arial, geneva, helvetica" size="1">Total Alumnos Retirados</font></TD>
	<TD> <font face="arial, geneva, helvetica" size="1" color="#000000"><? echo $filsRetirados['ret'];?></font></TD>
</TR>
</TABLE>
<? } ?>


     <!-- FIN DEL NUEVO CÓDIGO -->
	 
	 
								  
								  
								  
								  
								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
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
</body>
</html>
