<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$formula		=$_FORMULA;
	$frmModo		=$_FRMMODO;
	$docente		=5; //Codigo Docente
	$_POSP          = 5;

	
	//-------
	$sqlCurso = "select institucion.nombre_instit, ano_escolar.nro_ano, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto from ((institucion inner join ano_escolar on institucion.rdb=ano_escolar.id_institucion)inner join curso on ano_escolar.id_ano=curso.id_ano)inner join tipo_ensenanza on curso.ensenanza = tipo_ensenanza.cod_tipo where curso.id_curso=".$curso;
	$rsCurso =pg_Exec($conn,$sqlCurso);												
	$fCurso = pg_fetch_array($rsCurso,0);		
	//-------
	if(($frmModo=="modificar")OR($frmModo=="mostrar")){
		//--------- MODIFICA LOS SUBSECTORES  DE LA FORMULA -------
		$qry ="";
		$qry = "SELECT * FROM formula where id_formula=" . $formula;
		$Rs_Formula = @pg_exec($conn,$qry);
		$fila_Form = @pg_fetch_array($Rs_Formula,0);
		
		
		
		// --------- MODIFICA SUBSECTORES HIJOS DE LA FORMULA-------
		$qry1="";
		$qry1 = "SELECT * FROM formula_hijo WHERE id_formula = ". $formula;
		$Rs_Hijo = pg_exec($conn,$qry1);
	}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">

function uno(span){
	document.getElementById('modo1').style.display='none';
	document.getElementById('modo2').style.display='none';
	document.getElementById('modo3').style.display='none';
	document.getElementById('botones1').style.display='none';
	document.getElementById('botones2').style.display='block';
}
function m1(span){
	document.getElementById('modo1').style.display='block';
	document.getElementById('modo2').style.display='none';
	document.getElementById('modo3').style.display='none';
	document.getElementById('botones1').style.display='block';
	document.getElementById('botones2').style.display='none';
}
function m2(span){
	document.getElementById('modo1').style.display='none';
	document.getElementById('modo2').style.display='block';
	document.getElementById('modo3').style.display='none';
	document.getElementById('botones1').style.display='none';
	document.getElementById('botones2').style.display='block';
} 
function m3(span){
	document.getElementById('modo1').style.display='none';
	document.getElementById('modo2').style.display='none';
	document.getElementById('modo3').style.display='block';
	document.getElementById('botones1').style.display='none';
	document.getElementById('botones2').style.display='block';
}     



function SwitchMenuAnotacion(obj){  
 
	var el = document.getElementById(obj);
	var ar = document.getElementById("masterdiv3").getElementsByTagName("span"); //DynamicDrive.com change
	
		
	   <!-- proceso para activar lo habilitado -->
	    if (el.className=="modo1"){
	       el.style.display = "block";	   	   
		   for (var i=0; i<ar.length; i++){
				if (ar[i].className=="modo2") //DynamicDrive.com change
				ar[i].style.display = "none";

				if (ar[i].className=="modo3") //DynamicDrive.com change
				ar[i].style.display = "none";
				
				if (ar[i].className=="botones1") //DynamicDrive.com change
				   ar[i].style.display = "block";
				
				if (ar[i].className=="botones2") //DynamicDrive.com change
				   ar[i].style.display = "none";   				
		   }	   
	    }	
	
	
	    if (el.className=="modo2"){
	       el.style.display = "block";		   
		   for (var i=0; i<ar.length; i++){
				if (ar[i].className=="modo1") //DynamicDrive.com change
				ar[i].style.display = "none";

				if (ar[i].className=="modo3") //DynamicDrive.com change
				ar[i].style.display = "none";
				
				if (ar[i].className=="botones1") //DynamicDrive.com change
				   ar[i].style.display = "block";	
				
				if (ar[i].className=="botones2") //DynamicDrive.com change
				   ar[i].style.display = "none";     			   
				   
			}
	    }

	    if (el.className=="modo3"){
	       el.style.display = "block";		   
		   for (var i=0; i<ar.length; i++){
				if (ar[i].className=="modo1") //DynamicDrive.com change
				ar[i].style.display = "none";

				if (ar[i].className=="modo2") //DynamicDrive.com change
				ar[i].style.display = "none";
				
				
				if (ar[i].className=="botones1") //DynamicDrive.com change
				   ar[i].style.display = "block";	
				
				if (ar[i].className=="botones2") //DynamicDrive.com change
				   ar[i].style.display = "none";     			   
				   
			}
	    }
	
			
}

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
function Confirmacion(){
		if(confirm('¿ESTA SEGURO DE ELIMINAR ESTOS DATOS?') == false){ return; };
			document.location="seteaFormula.php3?caso=9&formula=<? echo $fila_Form['id_formula'];?>"
};
function valida(form){
		if(!chkVacio(form.txtRDB,'Ingresar RDB.')){
			return false;
		};

		if(!nroOnly(form.txtRDB,'Se permiten sólo numeros en el RDB.')){
			return false;
		};
}


function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="../seteaCurso.php3?caso=11&p=3&curso="+curso2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
</script>

<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>



<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">	

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="<? if ($modo==1){ ?> m1(); <? } ?> <? if ($modo==2){ ?> m2(); <? } ?> <? if ($modo==3){ ?> m3(); <? } ?>  <? if ($modo==NULL){ ?> uno(); <? } ?> MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
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
                        <? $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top"><!-- inicio codigo nuevo -->
								  
<center>
	<div id="masterdiv3"> 	
    <table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="3">
      <TR height=0> 
        <TD colspan=7> <TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
            <TR> 
              <TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>INSTITUCION</strong></FONT></TD>
              <TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
              <TD><FONT face="arial, geneva, helvetica" size=2><strong><?php echo trim($fCurso['nombre_instit']); ?></strong></FONT></TD>
            </TR>
            <TR> 
              <TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>AÑO 
                ESCOLAR</strong></FONT></TD>
              <TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
              <TD><FONT face="arial, geneva, helvetica" size=2><strong><?php echo trim($fCurso['nro_ano']); ?></strong></FONT></TD>
            </TR>
            <TR> 
              <TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>CURSO</strong></FONT></TD>
              <TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
              <TD><FONT face="arial, geneva, helvetica" size=2><strong> 
               
			<form name="form"   action="" method="post">
		    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
		  
		     <font face="arial, geneva, helvetica" size=2> <strong> 
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
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
			   
			   
			   
			   
                </strong> </FONT> </TD></form>
            </TR>
          </TABLE></TD>
      </TR>
	      <tr> 
        <td colspan=7 align=right> 
          <span class="botones1" id="botones1">	
			  <form method="post" name="form" action="procesoFormula.php3">
			   
			  </form>
		  </span>
		  
		  <span class="botones2" id="botones2">	
			   <table width="100%">
				 <tr>
				   <td>  
		             <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarFormulas.php3">
				   </td>
				 </tr>
			  </table>
		  </span>	  	   	  			  
	 </td>
      </tr>
	  </table>
	  <table width="100%" border="1">
      <tr height="20" class="tableindex"> 
        <td align="middle" colspan="3">TOTAL DE ASIGNATURAS</td>
      </tr>
      <tr class="tablatit2-1"> 
        <td align="center" width="33%">
		    <div class="Estilo9" onClick="SwitchMenuAnotacion('modo1')">
			<?
			if ($modo!=2){ ?>
				<table width="100%">
				   <tr>
					 <td bgcolor="#CCCCCC"><div align="center"><a href="#">MODO 1 
					   Posici&oacute;n
					   Nota </a></div></td>
				   </tr>
				</table>
           <? } ?>
		    </div></td>
           <td align="center" width="33%">
		   <div class="Estilo9" onClick="SwitchMenuAnotacion('modo2')">
		   <?
		   if ($modo!=1){ ?>
			   <table width="100%" >
				  <tr>
					 <td bgcolor="#CCCCCC"><div align="center"><a href="#">MODO 2 Notas Correlativas <br>
					  </a></div></td>
				  </tr>
			   </table>
		<? } ?>	   
		   </div></td>
		   <td align="center" width="33%">
		   <div class="Estilo9" onClick="SwitchMenuAnotacion('modo3')">
		   <?
		   if ($modo!=1){ ?>
			   <table width="100%" >
				  <tr>
					 <td bgcolor="#CCCCCC"><div align="center"><a href="#">MODO 3 Cálculo aritmético <br>
					  </a></div></td>
				  </tr>
			   </table>
		<? } ?>	   
		   </div></td>
           
       
        </tr>
	  </table>
	  
	  
	
	 <span class="modo1" id="modo1">	
	 <form method="post" name="form" action="procesoFormula.php3">
	  <table width="100%">	
	  <tr class="tablatit2-1"> 
        <td colspan="5" align="center">
		<div align="left">
		
		   <table width="100%">
				 <tr>
				   <td>  
			  <?php if($_PERFIL!=17){?>
			  <?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
			  <?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
									if (($plan!=461987) and ($plan!=1901975) and ($plan!=771982) and ($plan!=121987)){?>
				<? if($frmModo=="ingresar"){?>
			  <INPUT class="botonXX"  TYPE="submit" value="AGREGAR"> 
			  <? } ?>
			  <?php }?>
			  <?php }?>
			  <?php }?>
			  <?php }?>
			  <? if($frmModo=="mostrar"){?>
				<INPUT class="botonXX"  TYPE="button" value="PROCESAR" onClick=document.location="formulaSubsector.php3?formula=<? echo $fila_Form['id_formula'];?>"> 
				<!-- <INPUT class="botonXX"  TYPE="button" value="MODIFICAR" onClick=document.location="seteaFormula.php3?formula=<? echo $fila_Form['id_formula'];?>&caso=3&modo=<?=$modo ?>"> -->			
				<INPUT class="botonXX"  TYPE="button" value="ELIMINAR" onClick="javascript:Confirmacion()"> 						
				<? } 
				if($frmModo=="modificar"){?>
				 <INPUT class="botonXX"  TYPE="submit" value="GUARDAR"> 			
				<? } ?>
						  <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarFormulas.php3"> 
				 </td>
			   </tr>	 		  
			  </table>
		
		</div></td>
        </tr>
	  <tr class="tablatit2-1"> 
        <td colspan="5" align="center"><div align="left">MODO 1 POSICI&Oacute;N NOTA
            <input name="modo" type="hidden" id="modo" value="1">
        </div></td>
        </tr>		
	  <tr class="tablatit2-1"> 
        <td align="center" width="40">PADRE</td>
        <td align="center" width="33">HIJO</td>
        <td align="center" width="322">NOMBRE</td>
        <td align="center" width="74">PORCENTAJE</td>
        <td align="center">POSICI&Oacute;N NOTA </td>
		</tr>		
	 
      <?php	 if(($frmModo=="modificar") OR ($frmModo=="ingresar")){
				$qry="SELECT ramo.id_ramo, subsector.nombre, ramo.id_orden FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE (((ramo.id_curso)=".$curso.")) order by ramo.id_orden";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
			?>
      <?php
	  $k=0;
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
						$valor=0;
						$porcentaje="";
						for($j=0; $j<@pg_numrows($Rs_Hijo); $j++){ 
							$fila_hijo = @pg_fetch_array($Rs_Hijo,$j);
							if($fila_hijo['id_hijo']==$fila['id_ramo']){
								$porcentaje = $fila_hijo['porcentaje'];
								$valor=1;
							}
						}
			?>
      <tr> 
        <td><div align="center"> 
            <? if($frmModo=="ingresar"){?>
            <input name="padre[]" type="radio" value="<? echo $fila["id_ramo"];?>" >
            <? }
			if($frmModo=="modificar"){?>
            <input name="padre[]" type="radio" value="<? echo $fila["id_ramo"];?>"  <? echo ($fila['id_ramo']==$fila_Form['id_ramo'])?"checked":"";?>>
            <? } ?>
		</div></td>
	    <td><div align="center"> 
            <? if($frmModo=="ingresar"){?>
            <input name="hijo[]" type="checkbox" value="<? echo $fila["id_ramo"];?>">
            <? }
			if($frmModo=="modificar"){?>
            <input name="hijo[]" type="checkbox" value="<? echo $fila["id_ramo"];?>" <? echo ($valor==1)?"checked":"";?>>
            <? } ?>
		</div></td>
        <td align="left"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $fila["nombre"];?></strong> 
          </font></td>
        <td align="left"><font face="arial, geneva, helvetica" size="1" color="#000000"> 
          <? if($frmModo=="ingresar"){?>
          <input name="Porcent[<? echo $i;?>]" type="text" size="5" maxlength="3">
          <? } 
			if($frmModo=="modificar"){?>
          <input name="Porcent[<? echo $i;?>]" type="text" size="5" maxlength="3" value="<? echo $porcentaje;?>">
          <? } ?>
        %</font></td>
		<td align="CENTER">
		
		
		   <table border="1">
		      <tr>
			     <td>
			   <? if($frmModo=="ingresar"){?>
			  <input name="nota[]" type="text" size="5" maxlength="2">
			  <? }
			   if($frmModo=="modificar"){
				if($fila['id_ramo']==$fila_Form['id_ramo']) $Fnota=$fila_Form['nota']; else $Fnota=""; ?>
			  <input name="nota[]" type="text" size="5" maxlength="2"   value="<? echo $Fnota?>">
			  <? } ?></td></tr>
		   </table>			</td>
		</tr>
      <?php
	  
		$k++;?>
		 <input name="cont" type="hidden" size="5" maxlength="2"   value="<? echo $k;?>">
	 <?	}
		}
		 } //-- FIN MODO INGRESAR O MODIFICAR
		if($frmModo=="mostrar"){
		$qry="SELECT ramo.id_ramo, subsector.nombre, id_formula, nota FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula ON ramo.id_ramo=formula.id_ramo WHERE (((formula.id_formula)=".$formula.")) order by ramo.id_orden";
				$result =pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (51)</B>'.$qry);
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
			?>
    <?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
			?>
   	<tr>
	  <td align="center">&nbsp;<img src="../../../../../tic.gif" width="16" height="15"></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;<font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $fila['nombre'];?></font></td>
	  <td>&nbsp;</td>
	  <td align="center">&nbsp;<font size="1" face="arial, geneva, helvetica"><? echo $fila['nota'];?></font></td>
	  </tr>	
    <?php
						
						$qry="SELECT ramo.id_ramo, subsector.nombre, formula_hijo.id_formula, formula_hijo.porcentaje FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula_hijo ON formula_hijo.id_hijo=ramo.id_ramo WHERE (((formula_hijo.id_formula)=" . $fila['id_formula'] ."))";
						$Rs_Hijo   =pg_Exec($conn,$qry);
						if (!$Rs_Hijo) {
							error('<B> ERROR :</b>Error al acceder a la BD. (52)</B>');
						}else{
							if (pg_numrows($Rs_Hijo)!=0){
								$fila_hijo = @pg_fetch_array($Rs_Hijo,0);	
								if (!$fila_hijo){
									error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
									exit();
								}
							}
							for($j=0;$j<pg_numrows($Rs_Hijo);$j++){
								$fila_hijo = pg_fetch_array($Rs_Hijo,$j);
							?>
							  <tr> 
							  <td>&nbsp;</td>							  
						      <td align="center">&nbsp; <img src="../../../../../tic.gif" width="16" height="15"></td>
							  <td>&nbsp;<font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $fila_hijo['nombre'];?></font></td>
							  <td align="center">&nbsp;<font size="1" face="arial, geneva, helvetica"><? echo $fila_hijo['porcentaje'];?></font></td>
							</tr>
							
							<?
							}		
						}
					}
				}		
		}//-------FIN MODO MOSTRAR ------
			?>
    </table>
	</form>
	</span>
	
	
	<span class="modo2" id="modo2">	
	 <form method="post" name="form" action="procesoFormula.php3">
	  <table width="100%">
	   <tr class="tablatit2-1"> 
        <td colspan="5" align="center">
		<div align="left">
		
		   <table width="100%">
				 <tr>
				   <td>  
			  <?php if($_PERFIL!=17){?>
			  <?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
			  <?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
									if (($plan!=461987) and ($plan!=1901975) and ($plan!=771982) and ($plan!=121987)){?>
				<? if($frmModo=="ingresar"){?>
			  <INPUT class="botonXX"  TYPE="submit" value="AGREGAR"> 
			  <? } ?>
			  <?php }?>
			  <?php }?>
			  <?php }?>
			  <?php }?>
			  <? if($frmModo=="mostrar"){?>
				<INPUT class="botonXX"  TYPE="button" value="PROCESAR" onClick=document.location="formulaSubsector.php3?formula=<? echo $fila_Form['id_formula'];?>"> 
				<!-- <INPUT class="botonXX"  TYPE="button" value="MODIFICAR" onClick=document.location="seteaFormula.php3?formula=<? echo $fila_Form['id_formula'];?>&caso=3&modo=<?=$modo ?>"> --> 			
				<INPUT class="botonXX"  TYPE="button" value="ELIMINAR" onClick="javascript:Confirmacion()"> 						
				<? } 
				if($frmModo=="modificar"){?>
				 <INPUT class="botonXX"  TYPE="submit" value="GUARDAR"> 			
				<? } ?>
						  <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarFormulas.php3"> 
				 </td>
			   </tr>	 		  
			  </table>
		
		</div></td>
        </tr>
	  <tr class="tablatit2-1"> 
        <td colspan="5" align="center"><div align="left">MODO 2 NOTAS CORRELATIVAS
            <input name="modo" type="hidden" id="modo" value="2">
        </div></td>
      </tr>	
	  <tr class="tablatit2-1"> 
        <td align="center" width="40">PADRE</td>
        <td align="center" width="33">HIJO</td>
        <td align="center" width="322">NOMBRE</td>
        <td align="center" width="74">PORCENTAJE</td>
        
		</tr>	
	  
      <?php	 if(($frmModo=="modificar") OR ($frmModo=="ingresar")){
				$qry="SELECT ramo.id_ramo, subsector.nombre, ramo.id_orden FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE (((ramo.id_curso)=".$curso.")) order by ramo.id_orden";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
			?>
      <?php
	  $k=0;
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
						$valor=0;
						$porcentaje="";
						for($j=0; $j<@pg_numrows($Rs_Hijo); $j++){ 
							$fila_hijo = @pg_fetch_array($Rs_Hijo,$j);
							if($fila_hijo['id_hijo']==$fila['id_ramo']){
								$porcentaje = $fila_hijo['porcentaje'];
								$valor=1;
							}
						}
			?>
      <tr> 
        <td><div align="center"> 
            <? if($frmModo=="ingresar"){?>
            <input name="padre[]" type="radio" value="<? echo $fila["id_ramo"];?>" >
            <? }
			if($frmModo=="modificar"){?>
            <input name="padre[]" type="radio" value="<? echo $fila["id_ramo"];?>"  <? echo ($fila['id_ramo']==$fila_Form['id_ramo'])?"checked":"";?>>
            <? } ?>
		</div></td>
	    <td><div align="center"> 
            <? if($frmModo=="ingresar"){?>
            <input name="hijo[]" type="checkbox" value="<? echo $fila["id_ramo"];?>">
            <? }
			if($frmModo=="modificar"){?>
            <input name="hijo[]" type="checkbox" value="<? echo $fila["id_ramo"];?>" <? echo ($valor==1)?"checked":"";?>>
            <? } ?>
		</div></td>
        <td align="left"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $fila["nombre"];?></strong> 
          </font></td>
        <td align="left"><font face="arial, geneva, helvetica" size="1" color="#000000"> 
          <? if($frmModo=="ingresar"){?>
          <input name="Porcent2[<? echo $i;?>]" type="text" size="5" maxlength="4">
          <? } 
			if($frmModo=="modificar"){?>
          <input name="Porcent2[<? echo $i;?>]" type="text" size="5" maxlength="3" value="<? echo $porcentaje;?>">
          <? } ?>
        %</font></td>
		
		</tr>
      <?php
	  
		$k++;?>
		 <input name="cont" type="hidden" size="5" maxlength="2"   value="<? echo $k;?>">
	 <?	}
		}
		 } //-- FIN MODO INGRESAR O MODIFICAR
		if($frmModo=="mostrar"){
		$qry="SELECT ramo.id_ramo, subsector.nombre, id_formula, nota FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula ON ramo.id_ramo=formula.id_ramo WHERE (((formula.id_formula)=".$formula.")) order by ramo.id_orden";
				$result =pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (51)</B>'.$qry);
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
			?>
    <?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
			?>
   	<tr>
	  <td align="center">&nbsp;<img src="../../../../../tic.gif" width="16" height="15"></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;<font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $fila['nombre'];?></font></td>
	  <td>&nbsp;</td>
	 
	  </tr>	
    <?php
						
						$qry="SELECT ramo.id_ramo, subsector.nombre, formula_hijo.id_formula, formula_hijo.porcentaje FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula_hijo ON formula_hijo.id_hijo=ramo.id_ramo WHERE (((formula_hijo.id_formula)=" . $fila['id_formula'] ."))";
						$Rs_Hijo   =pg_Exec($conn,$qry);
						if (!$Rs_Hijo) {
							error('<B> ERROR :</b>Error al acceder a la BD. (52)</B>');
						}else{
							if (pg_numrows($Rs_Hijo)!=0){
								$fila_hijo = @pg_fetch_array($Rs_Hijo,0);	
								if (!$fila_hijo){
									error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
									exit();
								}
							}
							for($j=0;$j<pg_numrows($Rs_Hijo);$j++){
								$fila_hijo = pg_fetch_array($Rs_Hijo,$j);
							?>
							  <tr> 
							  <td>&nbsp;</td>							  
						      <td align="center">&nbsp; <img src="../../../../../tic.gif" width="16" height="15"></td>
							  <td>&nbsp;<font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $fila_hijo['nombre'];?></font></td>
							  <td align="center">&nbsp;<font size="1" face="arial, geneva, helvetica"><? echo $fila_hijo['porcentaje'];?></font></td>
							</tr>
							
							<?
							}		
						}
					}
				}		
		}//-------FIN MODO MOSTRAR ------
			?>
    </table>
	</form>
	</span>

	<!-- Modo 3 Subsector Formula -->
	<span class="modo3" id="modo3">
		<form method="post" name="form" action="procesoFormula.php3">
	  <table width="100%">
	   <tr class="tablatit2-1"> 
        <td colspan="4" align="center">
		<div align="left">
		
		   <table width="100%">
				 <tr>
				   <td>  
			  <?php if($_PERFIL!=17){?>
			  <?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
			  <?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
									if (($plan!=461987) and ($plan!=1901975) and ($plan!=771982) and ($plan!=121987)){?>
				<? if($frmModo=="ingresar"){?>
			  <INPUT class="botonXX"  TYPE="submit" value="AGREGAR"> 
			  <? } ?>
			  <?php }?>
			  <?php }?>
			  <?php }?>
			  <?php }?>
			  <? if($frmModo=="mostrar"){?>
				<INPUT class="botonXX"  TYPE="button" value="PROCESAR" onClick=document.location="formulaSubsector.php3?formula=<? echo $fila_Form['id_formula'];?>"> 
				<!-- <INPUT class="botonXX"  TYPE="button" value="MODIFICAR" onClick=document.location="seteaFormula.php3?formula=<? echo $fila_Form['id_formula'];?>&caso=3&modo=<?=$modo ?>"> --> 			
				<INPUT class="botonXX"  TYPE="button" value="ELIMINAR" onClick="javascript:Confirmacion()"> 						
				<? } 
				if($frmModo=="modificar"){?>
				 <INPUT class="botonXX"  TYPE="submit" value="GUARDAR"> 			
				<? } ?>
						  <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarFormulas.php3"> 
				 </td>
			   </tr>	 		  
			  </table>
		
		</div></td>
        </tr>
	  <tr class="tablatit2-1"> 
        <td colspan="4" align="center"><div align="left">MODO 3 C&Aacute;LCULO ARITM&Eacute;TICO
            <input name="modo" type="hidden" id="modo" value="3">
        </div></td>
      </tr>	
	  <tr class="tablatit2-1"> 
        <td align="center" width="40">PADRE</td>
        <td align="center" width="33">HIJO</td>
        <td align="center">NOMBRE</td>
        </tr>	
	  
      <?php	 if(($frmModo=="modificar") OR ($frmModo=="ingresar")){
				$qry="SELECT ramo.id_ramo, subsector.nombre, ramo.id_orden FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE (((ramo.id_curso)=".$curso.")) order by ramo.id_orden";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
			?>
      <?php
	  $k=0;
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
						$valor=0;
						$porcentaje="";
						for($j=0; $j<@pg_numrows($Rs_Hijo); $j++){ 
							$fila_hijo = @pg_fetch_array($Rs_Hijo,$j);
							if($fila_hijo['id_hijo']==$fila['id_ramo']){
								$porcentaje = $fila_hijo['porcentaje'];
								$valor=1;
							}
						}
			?>
      <tr> 
        <td><div align="center"> 
            <? if($frmModo=="ingresar"){?>
            <input name="padre[]" type="radio" value="<? echo $fila["id_ramo"];?>" >
            <? }
			if($frmModo=="modificar"){?>
            <input name="padre[]" type="radio" value="<? echo $fila["id_ramo"];?>"  <? echo ($fila['id_ramo']==$fila_Form['id_ramo'])?"checked":"";?>>
            <? } ?>
		</div></td>
	    <td><div align="center"> 
            <? if($frmModo=="ingresar"){?>
            <input name="hijo[]" type="checkbox" value="<? echo $fila["id_ramo"];?>">
            <? }
			if($frmModo=="modificar"){?>
            <input name="hijo[]" type="checkbox" value="<? echo $fila["id_ramo"];?>" <? echo ($valor==1)?"checked":"";?>>
            <? } ?>
		</div></td>
        <td align="left"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $fila["nombre"];?></strong> 
          </font><font face="arial, geneva, helvetica" size="1" color="#000000"> 
            <? if($frmModo=="ingresar"){?>
            <input name="Porcent3[<? echo $i;?>]" type="hidden" size="5" maxlength="4" value="0">
            <? } 
			if($frmModo=="modificar"){?>
            <input name="Porcent3[<? echo $i;?>]" type="hidden" size="5" maxlength="3" value="<? echo $porcentaje;?>">
            <? } ?></font></td>
        </tr>
      <?php
	  
		$k++;?>
		 <input name="cont" type="hidden" size="5" maxlength="2"   value="<? echo $k;?>">
	 <?	}
		}
		 } //-- FIN MODO INGRESAR O MODIFICAR
		if($frmModo=="mostrar"){
		$qry="SELECT ramo.id_ramo, subsector.nombre, id_formula, nota FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula ON ramo.id_ramo=formula.id_ramo WHERE (((formula.id_formula)=".$formula.")) order by ramo.id_orden";
				$result =pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (51)</B>'.$qry);
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
			?>
    <?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
			?>
   	<tr>
	  <td align="center">&nbsp;<img src="../../../../../tic.gif" width="16" height="15"></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;<font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $fila['nombre'];?></font></td>
	  </tr>	
    <?php
						
						$qry="SELECT ramo.id_ramo, subsector.nombre, formula_hijo.id_formula, formula_hijo.porcentaje FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula_hijo ON formula_hijo.id_hijo=ramo.id_ramo WHERE (((formula_hijo.id_formula)=" . $fila['id_formula'] ."))";
						$Rs_Hijo   =pg_Exec($conn,$qry);
						if (!$Rs_Hijo) {
							error('<B> ERROR :</b>Error al acceder a la BD. (52)</B>');
						}else{
							if (pg_numrows($Rs_Hijo)!=0){
								$fila_hijo = @pg_fetch_array($Rs_Hijo,0);	
								if (!$fila_hijo){
									error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
									exit();
								}
							}
							for($j=0;$j<pg_numrows($Rs_Hijo);$j++){
								$fila_hijo = pg_fetch_array($Rs_Hijo,$j);
							?>
							  <tr> 
							  <td>&nbsp;</td>							  
						      <td align="center">&nbsp; <img src="../../../../../tic.gif" width="16" height="15"></td>
							  <td>&nbsp;<font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $fila_hijo['nombre'];?></font>&nbsp;<font size="1" face="arial, geneva, helvetica"><?  $fila_hijo['porcentaje'];?></font></td>
							  </tr>
							
							<?
							}		
						}
					}
				}		
		}//-------FIN MODO MOSTRAR ------
			?>
    </table>
	</form>
	</span>	  
	 </div>
	 </center>

								  
								  <!-- fin codigo nuevo --></td>
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
