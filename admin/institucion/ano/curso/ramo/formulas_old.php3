<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$formula		=$_FORMULA;
	$frmModo		=$_FRMMODO;
	$docente		=5; //Codigo Docente

	
	//-------
	$sqlCurso = "select institucion.nombre_instit, ano_escolar.nro_ano, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto from ((institucion inner join ano_escolar on institucion.rdb=ano_escolar.id_institucion)inner join curso on ano_escolar.id_ano=curso.id_ano)inner join tipo_ensenanza on curso.ensenanza = tipo_ensenanza.cod_tipo where curso.id_curso=".$curso;
	$rsCurso =@pg_Exec($conn,$sqlCurso);												
	$fCurso = @pg_fetch_array($rsCurso,0);		
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
		$Rs_Hijo = @pg_exec($conn,$qry1);
	}
	
?>
<html>
	<head>
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
</script>

		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
	
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">
<?php if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../../periodo/listarPeriodo.php3"><img src="../../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../feriado/listaFeriado.php3"><img src="../../../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../../../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../planEstudio/listarPlanesEstudio.php3"><img src="../../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../atributos/listarTiposEnsenanza.php3"><img src="../../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../../botones/cursos_roll.gif" name="Image6" width="81" height="30" border="0" id="Image6"></a></td>
          <td width="81" height="30"><a href="../../matricula/listarMatricula.php3"><img src="../../../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../../../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../../../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../../../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../../../ano/reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../periodo/listarPeriodo.php3"><img src="../../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table>
<?php } ?>
<center>
<form method="post" name="form" action="procesoFormula.php3">
		
    <table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
      <TR height=15> 
        <TD colspan=5> <TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
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
          </TABLE></TD>
      </TR>
      <tr> 
        <td colspan=5 align=right> 
          <?php if($_PERFIL!=17){?>
          <?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
          <?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
								if (($plan!=461987) and ($plan!=1901975) and ($plan!=771982) and ($plan!=121987)){?>
			<? if($frmModo=="ingresar"){?>
          <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="AGREGAR"> 
		  <? } ?>
          <?php }?>
          <?php }?>
          <?php }?>
          <?php }?>
		  <? if($frmModo=="mostrar"){?>
		    <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="PROCESAR" onClick=document.location="formulaSubsector.php3?formula=<? echo $fila_Form['id_formula'];?>"> 
		    <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="MODIFICAR" onClick=document.location="seteaFormula.php3?formula=<? echo $fila_Form['id_formula'];?>&caso=3"> 			
		    <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ELIMINAR" onClick="Confirmacion()"> 						
			<? } 
			if($frmModo=="modificar"){?>
			 <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"> 			
			<? } ?>
			          <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="listarFormulas.php3"> 

        </td>
      </tr>
      <tr height="20" bgcolor="#003b85"> 
        <td align="middle" colspan="5"> <font face="arial, geneva, helvetica" size="2" color="#ffffff"> 
          <strong>TOTAL DE SUBSECTORES</strong> </font> </td>
      </tr>
      <tr bgcolor="#48d1cc"> 
        <td align="center" width="40"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>PADRE</strong></font></td>
        <td align="center" width="33"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>HIJO</strong></font></td>
        <td align="center" width="322"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>NOMBRE</strong></font></td>
        <td align="center" width="74"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>PORCENTAJE</strong></font></td>
        <td align="center" width="74"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>POSICIÓN 
          NOTA</strong></font></td>
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
		<? if($frmModo=="ingresar"){?>
		<input name="nota[]" type="text" size="5" maxlength="2">
		<? }
		   if($frmModo=="modificar"){
		    if($fila['id_ramo']==$fila_Form['id_ramo']) $Fnota=$fila_Form['nota']; else $Fnota=""; ?>
		 	 <input name="nota[]" type="text" size="5" maxlength="2"   value="<? echo $Fnota?>">
		  <? } ?>
		</td>
      </tr>
      <?php
	  
		$k++;?>
		 <input name="cont" type="hidden" size="5" maxlength="2"   value="<? echo $k;?>">
	 <?	}
		}
		 } //-- FIN MODO INGRESAR O MODIFICAR
		if($frmModo=="mostrar"){
		$qry="SELECT ramo.id_ramo, subsector.nombre, id_formula, nota FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula ON ramo.id_ramo=formula.id_ramo WHERE (((formula.id_formula)=".$formula.")) order by ramo.id_orden";
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
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
			?>
   	<tr>
	  <td align="center">&nbsp;<img src="tic.gif" width="16" height="15"></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;<font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $fila['nombre'];?></font></td>
	  <td>&nbsp;</td>
	  <td align="center">&nbsp;<font size="1" face="arial, geneva, helvetica"><? echo $fila['nota'];?></font></td>
	</tr>	
    <?php
						
						$qry="SELECT ramo.id_ramo, subsector.nombre, formula_hijo.id_formula, porcentaje FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula_hijo ON formula_hijo.id_hijo=ramo.id_ramo WHERE (((formula_hijo.id_formula)=" . $fila['id_formula'] ."))";
						$Rs_Hijo   =@pg_Exec($conn,$qry);
						if (!$Rs_Hijo) {
							error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
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
						      <td align="center">&nbsp; <img src="tic.gif" width="16" height="15"></td>
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
      <tr> 
        <td colspan="5"> <hr width="100%" color="#003b85"> </td>
      </tr>
      <tr> 
        <td colspan=5 align=center> <table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
            <tr> 
              <td> <table WIDTH="100%" BORDER="0" CELLSPACING="3" CELLPADDING="3" bgcolor=white>
                  <tr> 
                    <td> <font face="arial, geneva, helvetica" size="1" color=black> 
                      - Seleccionar presionando con el puntero del mouse sobre 
                      el subsector que corresponda.<br>
                      - Para anexar otro subsector presione "AGREGAR". <br>
                      </font> </td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
      </tr>
    </table>
</form>
	</center>
</body>
</html>