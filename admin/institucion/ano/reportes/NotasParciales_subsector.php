<? 
require('../../../../util/header.inc');
//setlocale("LC_ALL","es_ES");
function envia_mes2($mes){
	$mes = $mes;
	
	if ($mes=="01"){
	   $mes = "Enero";
	}
	if ($mes=="02"){
	   $mes = "Febrero";
	}
	if ($mes=="03"){
	   $mes = "Marzo";
	}
	if ($mes=="04"){
	   $mes = "Abril";
	}
	if ($mes=="05"){
	   $mes = "Mayo";
	}
	if ($mes=="06"){
	   $mes = "Junio";
	}
	if ($mes=="07"){
	   $mes = "Julio";
	}
	if ($mes=="08"){
	   $mes = "Agosto";
	}
	if ($mes=="09"){
	   $mes = "Septiembre";
	}
	if ($mes=="10"){
	   $mes = "Octubre";
	}
	if ($mes=="11"){
	   $mes = "Noviembre";
	}
	if ($mes=="12"){
	   $mes = "Diciembre";
	}	
	
	return $mes;
}


    
	
?>
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'NotasParciales_subsector.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>



<script>
<!--
function imprimir() 
{

	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';	

}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno		    =$c_alumno;
	$periodo		=$c_periodos;
	$id_periodo		=$c_periodos;
	$sw				=0;
	$rdb = $institucion;
	$ramo_religion = 0;
	if ($curso==0) $sw = 1;
	if ($periodo==0) $sw = 1;
	if ($sw != 1){
	    $sql = "select  * from periodo where id_ano = ".$ano." and id_periodo = ".$periodo." order by fecha_inicio" ;
	    $result1 =@pg_Exec($conn,$sql);
	    if (!$result1){
	         error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
	    }else{
		     if (pg_numrows($result1)!=0){
		        $fila1 = @pg_fetch_array($result1,0);	
		        if (!$fila1){
			         error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
			         exit();
		        }
	        }
	    }
	}	
	//-----------------------
	$sql = "select count(id_periodo) as num_periodos from periodo where id_ano = $ano";
	$resultPeri =@pg_Exec($conn,$sql);	
    $fila1Peri = @pg_fetch_array($resultPeri,0);		
	$num_periodos = $fila1Peri['num_periodos'];
	if ($num_periodos==2) $tipo_per = "SE";
	if ($num_periodos==3) $tipo_per = "TR";	
	//-----------------------
	$sql_ano = "select * from ano_escolar where id_ano = ". $ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	//-----------------------

	function Nombre($paterno,$materno,$nombres){
		$Nombres = strtoupper($nombres." ".$paterno." ".$materno);
		echo $Nombres;
	}
	
	
	
	$q1 = "select * from trabaja where rdb = '".trim($institucion)."' and (cargo=1 OR cargo=23)";
	$r1 = @pg_Exec($conn,$q1);
	$n1 = @pg_numrows($r1);
	//echo "n1 es: $n1 <br>";
	
	$f1 = @pg_fetch_array($r1,0);
	$cargo = $f1['cargo'];
	//echo "c: $cargo <br>";
	
	if ($cargo==1){
		$cargo_dir  = "director(a)";
		$cargo_dir2 = "Director(a)";
	}
	if ($cargo==23){
		$cargo_dir  = "rector(a)";
		$cargo_dir2 = "Rector(a)";
	}
	
	if ($institucion==770){
	    // DATOS CURSO //
		//--------------------------------------------------------------------------	
		$sql_curso = "SELECT plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.truncado_per ";
		$sql_curso = $sql_curso . "FROM (curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
		$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso."));";
		$result_curso = @pg_Exec($conn, $sql_curso);
		$fila_curso = @pg_fetch_array($result_curso ,0);
		$decreto_eval = $fila_curso['nombre_decreto_eval'];
		$planes = $fila_curso['nombre_decreto'];
		$truncado_per = $fila_curso['truncado_per'];
		//----------------------------------------------------------------------------
	}	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>&nbsp;</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
.Estilo2 {font-size: 9px}
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; font-weight: bold; }
</style>
 
<!-- CODIGO DE DISEÑO NUEVO -->
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><!-- DESDE ACÁ DEBE IR CON INCLUDE -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"><?
				include("../../../../cabecera/menu_superior.php");
				?>                </td>
              </tr>
          </table></td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top">
				<?
				$menu_lateral=3;
				include("../../../../menus/menu_lateral.php");
				?>
			  </td>
              <td width="73%" align="left" valign="top">
			  
			  
			  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
				  
				  <div id="capa0">
					<div align="right">
					  <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printNotasParciales_subsector.php?c_curso=<?=$curso ?>&c_periodos=<?=$periodo ?>&c_alumno=<?=$alumno ?>','','scrollbars=yes,resizable=yes,width=790,height=1000')" value="IMPRIMIR">
					</div>
				  </div>
				  
				  
			<?
			if ($periodo>0){			
			
			
			
			
			if (empty($alumno))
				$sql_alu = "select * from matricula, alumno where id_curso =" . $curso . " and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";
			else
				$sql_alu = "select * from matricula where rut_alumno ='" . $alumno ."' and id_ano = " . $ano;
				
				
			$result_alu =@pg_Exec($conn,$sql_alu);
			$cont_alumnos = @pg_numrows($result_alu);
			
			for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++){
				$prome_general_pro = 0;
				$cont_general_pro = 0;
				$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
				$alumno = $fila_alu['rut_alumno'] ;
				$bool_ed = $fila_alu['bool_ed'];
			
				//---------------------------
				$sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.truncado_per, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit, curso.ensenanza  ";
				$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
				$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";
				$result =@pg_Exec($conn,$sql);
				$fila = @pg_fetch_array($result,0);	
				$truncado_per = $fila['truncado_per'];
				$ensenanza = $fila['ensenanza'];
				$grado_curso = $fila['grado_curso'];
				
				?>			  
				  
				  <table width="100%" border="0" cellpadding="0" cellspacing="0">
				  <tr>
				  <? if ($institucion!="770"){ ?>
					<td width="114"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>INSTITUCI&Oacute;N</strong></font></div></td>
					<td width="9"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
					<td width="361"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo strtoupper(trim($fila['nombre_instit'])) ?></font></div></td>			 
					<td width="161" rowspan="7" align="center" valign="top" >
					<?
					$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto = @pg_fetch_array($result,0);
					## código para tomar la insignia
			
				  if($institucion!=""){
					   echo "<img src='".$d."../tmp/".$fila_foto['rdb']."insignia". "' >";
				  }else{
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?>	
		  
		        </td>
			<? } ?>
				  <tr>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>AÑO ESCOLAR</strong></font></div></td>
					<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo trim($fila['nro_ano']) ?></font></div></td>
					</tr>
				  <tr>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>CURSO</strong></font></div></td>
					<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
					<? 
					$Curso_pal = CursoPalabra($curso, 0, $conn);
					echo $Curso_pal; 
					?>
					</font></div></td>
					</tr>	
				  <tr>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>ALUMNO</strong></font></div></td>
					<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? if($institucion==8930){ Nombre($fila['ape_pat'],$fila['ape_mat'],$fila['nombre_alu']);}else{echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']))); $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']))); }?></font></div></td>
					</tr>
				  <tr>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>PROFESOR JEFE</strong></font></div></td>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></div></td>
					<td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
					<?
					$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
					$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
					$result =@pg_Exec($conn,$sql4);
					if (!$result) 
					{
						error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
					}
					else
					{
						if (pg_numrows($result)!=0)
						{
							$fila = @pg_fetch_array($result,0);	
							if (!$fila)
							{
								error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
								exit();
							}
						}
					}
					
					echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
					$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
					$nombre_profesor = ucwords(strtoupper(trim($fila['nombre_emp']) . " " . trim($fila['ape_pat']) . " " . trim($fila['ape_mat'])));				
					
					?>
					</font></div></td>
					</tr>
				  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td width="4" rowspan="5" align="center">&nbsp;</td>
				  </tr>		  
				</table>
				
				<table align="center" width="300">
				  <tr>
				    <td height="20" ><div align="center"><font face='verdana' size='1'>INFORME  DE NOTAS </font></div></td>
			      </tr>
			   
			      <tr>
				     <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtoupper($fila1['nombre_periodo'] . "DEL " . $nro_ano))?></strong></font></div></td>
			      </tr>
			    </table>
				<br>	  
				
				
				  <table width="750" border="1" align="center" cellpadding="2" cellspacing="1">
                    <tr>
                      <td width="30%" class="Estilo1">Subsector del Aprendizaje (Formacion General) </td>
                      <td width="50%" class="Estilo1"><div align="center">NOTAS</div></td>
                      <td width="5%" class="Estilo1"><div align="center">Prom Sem</div></td>
                     <!--
					  <td width="5%" class="Estilo1"><div align="center">2&ordm; SE </div></td>-->
					  <?
					  if ($ensenanza==110 and $grado_curso < 5){
					          /// nada
					  }else{
					        /// muestro columna
						    ?>
                            <td width="5%" class="Estilo1"><div align="center">N.E.</div></td>
					<? } ?> 		
                      <td width="5%" class="Estilo1"><div align="center">Gral.</div></td>
                    </tr>
					
					<?
					
					
					/*$sql2 = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip
FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector)
INNER JOIN tiene$nro_ano ON (ramo.id_curso = tiene$nro_ano.id_curso) INNER JOIN formula ON (formula.id_ramo = ramo.id_ramo)
AND (ramo.id_ramo = tiene$nro_ano.id_ramo)
WHERE (((ramo.id_curso)=".$curso.") AND ((tiene$nro_ano.rut_alumno)='".$alumno."'))
ORDER BY ramo.id_orden";*/			
					$sql2 = "SELECT formula.id_formula, ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip ";
		            $sql2 = $sql2 . "FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector) INNER JOIN tiene$nro_ano ON (ramo.id_curso = tiene$nro_ano.id_curso) AND (ramo.id_ramo = tiene$nro_ano.id_ramo) LEFT JOIN formula ON (formula.id_ramo = ramo.id_ramo)";
   		          $sql2 = $sql2 . "WHERE (((ramo.id_curso)=".$curso.") AND ((tiene$nro_ano.rut_alumno)='".$alumno."')) order by ramo.id_orden; ";
					
		            $result =@pg_Exec($conn,$sql2);
					$num_subsec = pg_numrows($result);
				   
					for($e=0 ; $e < @pg_numrows($result) ; $e++){
					    $fila = @pg_fetch_array($result,$e);
						$formula = $fila['id_formula'];
						$id_ramo = $fila['id_ramo'];
						$modo_eval = $fila['modo_eval'];
															
						
						$fila_anterior = @pg_fetch_array($result,$e-1);						
						$id_ramo_anterior = $fila_anterior['id_ramo'];						
						
						
						/// para sacar los hijos
						////************* aqui veo si el subsector pertenece a un subsector formula
						$qryaux2="SELECT * from formula_hijo where id_hijo = '$id_ramo'";
						$resaux2   =@pg_Exec($conn,$qryaux2);
						$numaux2   =@pg_numrows($resaux2);
						////////////// fin  ************************************************
						
						
						/// para sacar los padres
						////************* aqui veo si el subsector pertenece a un subsector formula
						$qryaux3="SELECT * from formula where id_ramo ='$id_ramo'";
						$resaux3   =@pg_Exec($conn,$qryaux3);
						$numaux3   =@pg_numrows($resaux3);
						////////////// fin  ************************************************
						
						?>		
					
<? /**************************************************************************************************************************/?>                  
                    
                    
                      	<? if ($numaux2 == 0) {
						
							if ($id_ramo!=$id_ramo_anterior or $e==0){
						
						?>
                    
                    
						<tr>
						  <td class="Estilo1">&nbsp;
						  <?
						  //// nombre de los subsectores 	
						  if ($numaux2 > 0){
							   // es un subsector padre o hijo
							   $nombre_subsector = $fila['nombre'];
							   echo "(<em>$nombre_subsector</em>)";				 
						  }else{
							   if ($numaux3 > 0){
									// es un subsector padre o hijo
									$nombre_subsector = $fila['nombre'];
									echo '<b><font color="#0099FF">'.$nombre_subsector.'</font></b>';				 
							   }else{
									echo "<b><font color='#0099FF'>".$fila['nombre']."</font></b>"; 
							   }
						  }
						  ?>
						  </td>
						  <td>
						   <?
						   $sql3 = "SELECT notas$nro_ano.nota1, notas$nro_ano.nota2, notas$nro_ano.nota3, notas$nro_ano.nota4, notas$nro_ano.nota5, notas$nro_ano.nota6, notas$nro_ano.nota7, notas$nro_ano.nota8, notas$nro_ano.nota9, notas$nro_ano.nota10, notas$nro_ano.nota11, notas$nro_ano.nota12, notas$nro_ano.nota13, notas$nro_ano.nota14, notas$nro_ano.nota15, notas$nro_ano.nota16, notas$nro_ano.nota17, notas$nro_ano.nota18, notas$nro_ano.nota19, notas$nro_ano.nota20, notas$nro_ano.promedio ";						   
						   $sql3 = $sql3 . "FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."') AND ((notas$nro_ano.id_ramo)=".$id_ramo.") AND ((notas$nro_ano.id_periodo)=".$id_periodo.")); ";				
						   $result2 =@pg_Exec($conn,$sql3);						   
			               $fila_notas = @pg_fetch_array($result2,0); 
						  
						   $nota1 = $fila_notas['nota1'];
						   $nota2 = $fila_notas['nota2'];
						   $nota3 = $fila_notas['nota3'];
						   $nota4 = $fila_notas['nota4'];
						   $nota5 = $fila_notas['nota5'];
						   $nota6 = $fila_notas['nota6'];
						   $nota7 = $fila_notas['nota7'];
						   $nota8 = $fila_notas['nota8'];
						   $nota9 = $fila_notas['nota9'];
						   $nota10 = $fila_notas['nota10'];
						   $nota11 = $fila_notas['nota11'];
						   $nota12 = $fila_notas['nota12'];
						   $nota13 = $fila_notas['nota13'];
						   $nota14 = $fila_notas['nota14'];
						   $nota15 = $fila_notas['nota15'];
						   $nota16 = $fila_notas['nota16'];
						   $nota17 = $fila_notas['nota17'];
						   $nota18 = $fila_notas['nota18'];
						   $nota19 = $fila_notas['nota19'];
						   $nota20 = $fila_notas['nota20'];
						   $promedio_semestre = $fila_notas['promedio'];
						   
						   
						   if (trim($nota1)=="0"){ $nota1=""; }
						   if (trim($nota2)=="0"){ $nota2=""; }
						   if (trim($nota3)=="0"){ $nota3=""; }
						   if (trim($nota4)=="0"){ $nota4=""; }
						   if (trim($nota5)=="0"){ $nota5=""; }
						   if (trim($nota6)=="0"){ $nota6=""; }
						   if (trim($nota7)=="0"){ $nota7=""; }
						   if (trim($nota8)=="0"){ $nota8=""; }
						   if (trim($nota9)=="0"){ $nota9=""; }
						   if (trim($nota10)=="0"){ $nota10=""; }
						   if (trim($nota11)=="0"){ $nota11=""; }
						   if (trim($nota12)=="0"){ $nota12=""; }
						   if (trim($nota13)=="0"){ $nota13=""; }
						   if (trim($nota14)=="0"){ $nota14=""; }
						   if (trim($nota15)=="0"){ $nota15=""; }
						   if (trim($nota16)=="0"){ $nota16=""; }
						   if (trim($nota17)=="0"){ $nota17=""; }
						   if (trim($nota18)=="0"){ $nota18=""; }
						   if (trim($nota19)=="0"){ $nota19=""; }
						   if (trim($nota20)=="0"){ $nota20=""; } 
						   
						   if ($nota1<40 && $nota1>0){ $color1="#FF0000"; }else{ $color1="#000000"; }
						   if ($nota2<40 && $nota2>0){ $color2="#FF0000"; }else{ $color2="#000000"; }
						   if ($nota3<40 && $nota3>0){ $color3="#FF0000"; }else{ $color3="#000000"; }
						   if ($nota4<40 && $nota4>0){ $color4="#FF0000"; }else{ $color4="#000000"; }
						   if ($nota5<40 && $nota5>0){ $color5="#FF0000"; }else{ $color5="#000000"; }
						   if ($nota6<40 && $nota6>0){ $color6="#FF0000"; }else{ $color6="#000000"; }
						   if ($nota7<40 && $nota7>0){ $color7="#FF0000"; }else{ $color7="#000000"; }
						   if ($nota8<40 && $nota8>0){ $color8="#FF0000"; }else{ $color8="#000000"; }
						   if ($nota9<40 && $nota9>0){ $color9="#FF0000"; }else{ $color9="#000000"; }
						   if ($nota10<40 && $nota10>0){ $color10="#FF0000"; }else{ $color10="#000000"; }
						   if ($nota11<40 && $nota11>0){ $color11="#FF0000"; }else{ $color11="#000000"; }
						   if ($nota12<40 && $nota12>0){ $color12="#FF0000"; }else{ $color12="#000000"; }
						   if ($nota13<40 && $nota13>0){ $color13="#FF0000"; }else{ $color13="#000000"; }
						   if ($nota14<40 && $nota14>0){ $color14="#FF0000"; }else{ $color14="#000000"; }
						   if ($nota15<40 && $nota15>0){ $color15="#FF0000"; }else{ $color15="#000000"; }
						   if ($nota16<40 && $nota16>0){ $color16="#FF0000"; }else{ $color16="#000000"; }
						   if ($nota17<40 && $nota17>0){ $color17="#FF0000"; }else{ $color17="#000000"; }
						   if ($nota18<40 && $nota18>0){ $color18="#FF0000"; }else{ $color18="#000000"; }
						   if ($nota19<40 && $nota19>0){ $color19="#FF0000"; }else{ $color19="#000000"; }
						   if ($nota20<40 && $nota20>0){ $color20="#FF0000"; }else{ $color20="#000000"; }
						   
						   if (trim($promedio_semestre)>0){
						       if ($promedio_semestre<40 && $promedio_semestre>0){ $color21="#FF0000"; }else{ $color21="#000000"; }
						   }
						   ?>
						   <table width="100%" border="1" cellpadding="0" cellspacing="1">
							<tr>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color1 ?>"><? echo $nota1 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color2 ?>"><? echo $nota2 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color3 ?>"><? echo $nota3 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color4 ?>"><? echo $nota4 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color5 ?>"><? echo $nota5 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color6 ?>"><? echo $nota6 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color7 ?>"><? echo $nota7 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color8 ?>"><? echo $nota8 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color9 ?>"><? echo $nota9 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color10 ?>"><? echo $nota10 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color11 ?>"><? echo $nota11 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color12 ?>"><? echo $nota12 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color13 ?>"><? echo $nota13 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color14 ?>"><? echo $nota14 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color15 ?>"><? echo $nota15 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color16 ?>"><? echo $nota16 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color17 ?>"><? echo $nota17 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color18 ?>"><? echo $nota18 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color19 ?>"><? echo $nota19 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color20 ?>"><? echo $nota20 ?></font></td>
							</tr>
						  </table>
						  
					    </td>
						  <td class="Estilo1"><div align="center">&nbsp;<font color="<?=$color21 ?>"><? if (trim($promedio_semestre)>0){ ?><?=$promedio_semestre ?> <? }else{ echo "$promedio_semestre"; } ?></font></div></td>
						  
						  
						 
						  <td class="Estilo1"><div align="center">&nbsp;</div></td>
						 <!--
						  <? if ($ensenanza==110 and $grado_curso < 5){
									  /// nada
							  }else{
									/// muestro columna
									?>
						           <td class="Estilo1"><div align="center">&nbsp;</div></td>
						  <? } ?>
						  -->
						  		   
						  <td class="Estilo1"><div align="center">&nbsp;
						   <?
						   //// nombre de los subsectores 	
						   if ($numaux2 == 0){ 
						         // Acomulo los promedios
								 if ($promedio_semestre>0){
								     $suma_prom = $suma_prom + $promedio_semestre;
								     $cuenta_prom = $cuenta_prom + 1;
								 }	 
								
						         ?>
						        <font color="<?=$color21 ?>"><?  if (trim($promedio_semestre)>0){ ?><?=$promedio_semestre ?><? }else{ echo "$promedio_semestre"; } ?></font>
						<? } ?>		
						  </div></td>
						</tr>
                        
                        
                        <?
						
						 }
						
						 }?>
                        
              <?        if ($formula != NULL) {
			  
			  			$sql3 = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip
FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector)
INNER JOIN formula_hijo ON (formula_hijo.id_hijo= ramo.id_ramo)
WHERE (((ramo.id_curso)=".$curso.") AND formula_hijo.id_formula = ".$formula.") 
ORDER BY ramo.id_orden";
						
						$result3 =@pg_Exec($conn,$sql3);
						$num_subsec3 = pg_numrows($result3);
						
						for($e3=0 ; $e3 < @pg_numrows($result3) ; $e3++){
							$fila3 = @pg_fetch_array($result3,$e3);
							$id_ramo3 = $fila3['id_ramo'];
							$modo_eval3 = $fila3['modo_eval'];
						
						
						
							
						 ?>
                    
                    
						<tr>
						  <td class="Estilo1">&nbsp;
						  <?
						  
							   echo "(<em>".$fila3['nombre']."</em>)";				 
						 
						  ?>						  </td>
						  <td>
						   <?
						   $sql4 = "SELECT notas$nro_ano.nota1, notas$nro_ano.nota2, notas$nro_ano.nota3, notas$nro_ano.nota4, notas$nro_ano.nota5, notas$nro_ano.nota6, notas$nro_ano.nota7, notas$nro_ano.nota8, notas$nro_ano.nota9, notas$nro_ano.nota10, notas$nro_ano.nota11, notas$nro_ano.nota12, notas$nro_ano.nota13, notas$nro_ano.nota14, notas$nro_ano.nota15, notas$nro_ano.nota16, notas$nro_ano.nota17, notas$nro_ano.nota18, notas$nro_ano.nota19, notas$nro_ano.nota20, notas$nro_ano.promedio ";						   
						   $sql4 = $sql4 . "FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."') AND ((notas$nro_ano.id_ramo)=".$id_ramo3.") AND ((notas$nro_ano.id_periodo)=".$id_periodo.")); ";				
						   $result4 =@pg_Exec($conn,$sql4);						   
			               $fila_notas4 = @pg_fetch_array($result4,0); 
						  
						   $nota1 = $fila_notas4['nota1'];
						   $nota2 = $fila_notas4['nota2'];
						   $nota3 = $fila_notas4['nota3'];
						   $nota4 = $fila_notas4['nota4'];
						   $nota5 = $fila_notas4['nota5'];
						   $nota6 = $fila_notas4['nota6'];
						   $nota7 = $fila_notas4['nota7'];
						   $nota8 = $fila_notas4['nota8'];
						   $nota9 = $fila_notas4['nota9'];
						   $nota10 = $fila_notas4['nota10'];
						   $nota11 = $fila_notas4['nota11'];
						   $nota12 = $fila_notas4['nota12'];
						   $nota13 = $fila_notas4['nota13'];
						   $nota14 = $fila_notas4['nota14'];
						   $nota15 = $fila_notas4['nota15'];
						   $nota16 = $fila_notas4['nota16'];
						   $nota17 = $fila_notas4['nota17'];
						   $nota18 = $fila_notas4['nota18'];
						   $nota19 = $fila_notas4['nota19'];
						   $nota20 = $fila_notas4['nota20'];
						   $promedio_semestre = $fila_notas4['promedio'];
						   
						   
						   if (trim($nota1)=="0"){ $nota1=""; }
						   if (trim($nota2)=="0"){ $nota2=""; }
						   if (trim($nota3)=="0"){ $nota3=""; }
						   if (trim($nota4)=="0"){ $nota4=""; }
						   if (trim($nota5)=="0"){ $nota5=""; }
						   if (trim($nota6)=="0"){ $nota6=""; }
						   if (trim($nota7)=="0"){ $nota7=""; }
						   if (trim($nota8)=="0"){ $nota8=""; }
						   if (trim($nota9)=="0"){ $nota9=""; }
						   if (trim($nota10)=="0"){ $nota10=""; }
						   if (trim($nota11)=="0"){ $nota11=""; }
						   if (trim($nota12)=="0"){ $nota12=""; }
						   if (trim($nota13)=="0"){ $nota13=""; }
						   if (trim($nota14)=="0"){ $nota14=""; }
						   if (trim($nota15)=="0"){ $nota15=""; }
						   if (trim($nota16)=="0"){ $nota16=""; }
						   if (trim($nota17)=="0"){ $nota17=""; }
						   if (trim($nota18)=="0"){ $nota18=""; }
						   if (trim($nota19)=="0"){ $nota19=""; }
						   if (trim($nota20)=="0"){ $nota20=""; } 
						   
						   if ($nota1<40 && $nota1>0){ $color1="#FF0000"; }else{ $color1="#000000"; }
						   if ($nota2<40 && $nota2>0){ $color2="#FF0000"; }else{ $color2="#000000"; }
						   if ($nota3<40 && $nota3>0){ $color3="#FF0000"; }else{ $color3="#000000"; }
						   if ($nota4<40 && $nota4>0){ $color4="#FF0000"; }else{ $color4="#000000"; }
						   if ($nota5<40 && $nota5>0){ $color5="#FF0000"; }else{ $color5="#000000"; }
						   if ($nota6<40 && $nota6>0){ $color6="#FF0000"; }else{ $color6="#000000"; }
						   if ($nota7<40 && $nota7>0){ $color7="#FF0000"; }else{ $color7="#000000"; }
						   if ($nota8<40 && $nota8>0){ $color8="#FF0000"; }else{ $color8="#000000"; }
						   if ($nota9<40 && $nota9>0){ $color9="#FF0000"; }else{ $color9="#000000"; }
						   if ($nota10<40 && $nota10>0){ $color10="#FF0000"; }else{ $color10="#000000"; }
						   if ($nota11<40 && $nota11>0){ $color11="#FF0000"; }else{ $color11="#000000"; }
						   if ($nota12<40 && $nota12>0){ $color12="#FF0000"; }else{ $color12="#000000"; }
						   if ($nota13<40 && $nota13>0){ $color13="#FF0000"; }else{ $color13="#000000"; }
						   if ($nota14<40 && $nota14>0){ $color14="#FF0000"; }else{ $color14="#000000"; }
						   if ($nota15<40 && $nota15>0){ $color15="#FF0000"; }else{ $color15="#000000"; }
						   if ($nota16<40 && $nota16>0){ $color16="#FF0000"; }else{ $color16="#000000"; }
						   if ($nota17<40 && $nota17>0){ $color17="#FF0000"; }else{ $color17="#000000"; }
						   if ($nota18<40 && $nota18>0){ $color18="#FF0000"; }else{ $color18="#000000"; }
						   if ($nota19<40 && $nota19>0){ $color19="#FF0000"; }else{ $color19="#000000"; }
						   if ($nota20<40 && $nota20>0){ $color20="#FF0000"; }else{ $color20="#000000"; }
						   
						   if (trim($promedio_semestre)>0){
						       if ($promedio_semestre<40 && $promedio_semestre>0){ $color21="#FF0000"; }else{ $color21="#000000"; }
						   }
						   ?>
						   <table width="100%" border="1" cellpadding="0" cellspacing="1">
							<tr>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color1 ?>"><? echo $nota1 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color2 ?>"><? echo $nota2 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color3 ?>"><? echo $nota3 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color4 ?>"><? echo $nota4 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color5 ?>"><? echo $nota5 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color6 ?>"><? echo $nota6 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color7 ?>"><? echo $nota7 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color8 ?>"><? echo $nota8 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color9 ?>"><? echo $nota9 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color10 ?>"><? echo $nota10 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color11 ?>"><? echo $nota11 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color12 ?>"><? echo $nota12 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color13 ?>"><? echo $nota13 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color14 ?>"><? echo $nota14 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color15 ?>"><? echo $nota15 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color16 ?>"><? echo $nota16 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color17 ?>"><? echo $nota17 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color18 ?>"><? echo $nota18 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color19 ?>"><? echo $nota19 ?></font></td>
							  <td class="Estilo1" width="22">&nbsp;<font color="<?=$color20 ?>"><? echo $nota20 ?></font></td>
							</tr>
						  </table>
						  
					    </td>
						  <td class="Estilo1">
						  <? if ($institucion != 26080) {?>
						             <div align="center">&nbsp;<font color="<?= $color21 ?>">
									 <? if (trim($promedio_semestre)>0){ ?>
									          <?=$promedio_semestre ?>
									 <? }else{ 
									           echo "$promedio_semestre"; 
									   } ?></font></div>
                          <? } else {?>
						  			<div align="center">&nbsp;</div>
						  <? }?>
						  
						  </td>
						  
						  
						  <td class="Estilo1"><div align="center">&nbsp;</div></td>
						  
						  <!--
						  <? if ($ensenanza==110 and $grado_curso < 5){
									  /// nada
							  }else{
									/// muestro columna
									?>
						           <td class="Estilo1"><div align="center">&nbsp;</div></td>
						  <? } ?>
						  -->
						  
						  		   
						  <td class="Estilo1">
						  <?
						  if ($institucion != 26080) { ?>
						         <div align="center">&nbsp;
								 <? 
								 //// nombre de los subsectores 	
								 if ($numaux2 == 0){ 
									 // Acomulo los promedios
									if ($promedio_semestre>0){
										 $suma_prom = $suma_prom + $promedio_semestre;
										 $cuenta_prom = $cuenta_prom + 1;
									} ?>
						            <font color="<?=$color21 ?>">
									<?
									if (trim($promedio_semestre)>0){ 
									     ?><?=$promedio_semestre ?><?
									}else{ 
									     echo "$promedio_semestre"; 
									}
									?></font>
						     <? }?>		
						     </div>
                       <? }else {?>
                                <div align="center">&nbsp;</div>
                       <? }?>
					   </td>
					   </tr>			
						
						
						
						
<?						
						}
						}
?>                        
                        
<? /************************************************************************************************************************/?>                        
                        
						<?
				   } 
				   ?>		
									
                    <tr>
                      <td>&nbsp;</td>
                      <td><div align="right" class="Estilo4">Promedios</div></td>
                      <td class="Estilo1" align="center">&nbsp;<? echo @round(($suma_prom/$cuenta_prom)); ?></td>
                      
                      <? if ($ensenanza==110 and $grado_curso < 5){
					          /// nada
					  }else{
					        /// muestro columna
						    ?>				  
					        <td>&nbsp;</td>
					<? } ?>		
                      <td class="Estilo1" align="center">&nbsp;<? echo @round(($suma_prom/$cuenta_prom)); ?></td>
                    </tr>
                  </table>
				  
				  <!-- TALLERES -->
		 <?
		 
		 $sql2 = "SELECT t.* FROM taller as t INNER JOIN tiene_taller as tt ON t.id_taller=tt.id_taller WHERE rut_alumno=".$alumno." and t.id_ano = '".$ano."' ";
          $result =@pg_Exec($conn,$sql2);
		  if (!$result) 
		  {
			  error('<B> ERROR :</b>Error al acceder a la BD. (SUBSECTOR)</B>');
    		}
		  else
    		{
    			if (pg_numrows($result)!=0)
			  {
				  $fila = @pg_fetch_array($result,0);	
				  if (!$fila)
				  {
					  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					  exit();
				  }
			  }
		  }
		  $num_subsec = pg_numrows($result);

		if($num_subsec>0){	?>	  
				  
				  
				  
				  <table width="650" border="1" cellpadding="0" cellspacing="0">
		  <tr>
            <td width="231" align="left">
			  <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TALLERES </strong></font></div></td>
            <td colspan="20" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">NOTAS</font></strong></td>
			<? 
			$sql_p = "select  * from periodo where id_ano = ".$ano." order by fecha_inicio" ;
			$result_p = pg_Exec($conn,$sql_p);
			$fila_p = pg_num_rows($result_p);
			$p1 = pg_fetch_array($result_p,0);
			$p1=$p1['id_periodo'];
			$p2 = pg_fetch_array($result_p,1);
			$p2 = $p2['id_periodo']; 
			if($fila_p > 2){
				$p3 = pg_fetch_array($result_p,2);
				$p3 = $p3['id_periodo'];			
			}						
			if($p1==$periodo){?>
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>
			<? }			
			if($p2==$periodo){?>			
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>			
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2º<? echo $tipo_per ?></strong></font></td>
			<?	}		
			if($p3==$periodo){?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1º<? echo $tipo_per ?></strong></font></td>			
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2º<? echo $tipo_per ?></strong></font></td>						
            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3º<? echo $tipo_per ?></strong></font></td>						
			<? }?>				         
            </tr>
		  <?
		  $cont_prom = 0;
		  $promedio = 0;


		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
				$fila_taller = @pg_fetch_array($result,$e);
				$id_taller = $fila_taller['id_taller'];
				$sql_taller = "select * from taller where id_taller=".$id_taller." and id_ano = '".$ano."'";
				$result_taller =@pg_Exec($conn,$sql_taller);
				$fila = @pg_fetch_array($result_taller,0);		  

				$modo_eval = $fila['modo_eval'];
				$nom_taller = $fila['nombre_taller'];
			?>		
          <tr>
		  <?
            if ($id_taller==NULL){
			    $id_taller = 0;
			}		
            
			
			// NOTAS TALLER
		  	$sql3 = "SELECT notas_taller.nota1, notas_taller.nota2, notas_taller.nota3, notas_taller.nota4, notas_taller.nota5, notas_taller.nota6, notas_taller.nota7, notas_taller.nota8, notas_taller.nota9, notas_taller.nota10, notas_taller.nota11, notas_taller.nota12, notas_taller.nota13, notas_taller.nota14, notas_taller.nota15, notas_taller.nota16, notas_taller.nota17, notas_taller.nota18, notas_taller.nota19, notas_taller.nota20, notas_taller.promedio ";
			$sql3 = $sql3 . "FROM notas_taller WHERE (((notas_taller.rut_alumno)='".$alumno."') AND ((notas_taller.id_taller)=".$id_taller.") AND ((notas_taller.id_periodo)=".$id_periodo.")); ";
			
			
			$result2 =@pg_Exec($conn,$sql3);
		  	if (!$result2){
				   error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
    		}else{
	    			if (pg_numrows($result2)!=0)
				  {
					  $fila2 = @pg_fetch_array($result2,0);	
					  if (!$fila2)
					  {
						  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						  exit();
					  }
				  }
			  }
				$fila2 = @pg_fetch_array($result2,$f);
				if ($modo_eval == 1){
					if ($fila2['nota1']>0) $nota1 = $fila2['nota1']; else $nota1 = "&nbsp;";
					if ($fila2['nota2']>0) $nota2 = $fila2['nota2']; else $nota2 = "&nbsp;";
					if ($fila2['nota3']>0) $nota3 = $fila2['nota3']; else $nota3 = "&nbsp;";
					if ($fila2['nota4']>0) $nota4 = $fila2['nota4']; else $nota4 = "&nbsp;";
					if ($fila2['nota5']>0) $nota5 = $fila2['nota5']; else $nota5 = "&nbsp;";
					if ($fila2['nota6']>0) $nota6 = $fila2['nota6']; else $nota6 = "&nbsp;";
					if ($fila2['nota7']>0) $nota7 = $fila2['nota7']; else $nota7 = "&nbsp;";
					if ($fila2['nota8']>0) $nota8 = $fila2['nota8']; else $nota8 = "&nbsp;";
					if ($fila2['nota9']>0) $nota9 = $fila2['nota9']; else $nota9 = "&nbsp;";
					if ($fila2['nota10']>0) $nota10 = $fila2['nota10']; else $nota10 = "&nbsp;";
					if ($fila2['nota11']>0) $nota11 = $fila2['nota11']; else $nota11 = "&nbsp;";
					if ($fila2['nota12']>0) $nota12 = $fila2['nota12']; else $nota12 = "&nbsp;";
					if ($fila2['nota13']>0) $nota13 = $fila2['nota13']; else $nota13 = "&nbsp;";
					if ($fila2['nota14']>0) $nota14 = $fila2['nota14']; else $nota14 = "&nbsp;";
					if ($fila2['nota15']>0) $nota15 = $fila2['nota15']; else $nota15 = "&nbsp;";
					if ($fila2['nota16']>0) $nota16 = $fila2['nota16']; else $nota16 = "&nbsp;";
					if ($fila2['nota17']>0) $nota17 = $fila2['nota17']; else $nota17 = "&nbsp;";
					if ($fila2['nota18']>0) $nota18 = $fila2['nota18']; else $nota18 = "&nbsp;";
					if ($fila2['nota19']>0) $nota19 = $fila2['nota19']; else $nota19 = "&nbsp;";
					if ($fila2['nota20']>0) $nota20 = $fila2['nota20']; else $nota20 = "&nbsp;";																																																																																															
				} else {
					if (chop($fila2['nota1'])=="0" or chop($fila2['nota1'])=="") $nota1 = "&nbsp;";  else $nota1 = $fila2['nota1'];
					if (chop($fila2['nota2'])=="0" or chop($fila2['nota2'])=="")  $nota2 = "&nbsp;"; else $nota2 = $fila2['nota2'];
					if (chop($fila2['nota3'])=="0" or chop($fila2['nota3'])=="")  $nota3 = "&nbsp;"; else $nota3 = $fila2['nota3'];
					if (chop($fila2['nota4'])=="0" or chop($fila2['nota4'])=="")  $nota4 = "&nbsp;"; else $nota4 = $fila2['nota4'];
					if (chop($fila2['nota5'])=="0" or chop($fila2['nota5'])=="")  $nota5 = "&nbsp;"; else $nota5 = $fila2['nota5'];
					if (chop($fila2['nota6'])=="0" or chop($fila2['nota6'])=="")  $nota6 = "&nbsp;"; else $nota6 = $fila2['nota6'];
					if (chop($fila2['nota7'])=="0" or chop($fila2['nota7'])=="")  $nota7 = "&nbsp;"; else $nota7 = $fila2['nota7'];
					if (chop($fila2['nota8'])=="0" or chop($fila2['nota8'])=="")  $nota8 = "&nbsp;"; else $nota8 = $fila2['nota8'];
					if (chop($fila2['nota9'])=="0" or chop($fila2['nota9'])=="")  $nota9 = "&nbsp;"; else $nota9 = $fila2['nota9'];
					if (chop($fila2['nota10'])=="0" or chop($fila2['nota10'])=="")  $nota10 = "&nbsp;"; else $nota10 = $fila2['nota10'];
					if (chop($fila2['nota11'])=="0" or chop($fila2['nota11'])=="")  $nota11 = "&nbsp;"; else $nota11 = $fila2['nota11'];
					if (chop($fila2['nota12'])=="0" or chop($fila2['nota12'])=="")  $nota12 = "&nbsp;"; else $nota12 = $fila2['nota12'];
					if (chop($fila2['nota13'])=="0" or chop($fila2['nota13'])=="")  $nota13 = "&nbsp;"; else $nota13 = $fila2['nota13'];
					if (chop($fila2['nota14'])=="0" or chop($fila2['nota14'])=="")  $nota14 = "&nbsp;"; else $nota14 = $fila2['nota14'];
					if (chop($fila2['nota15'])=="0" or chop($fila2['nota15'])=="")  $nota15 = "&nbsp;"; else $nota15 = $fila2['nota15'];
					if (chop($fila2['nota16'])=="0" or chop($fila2['nota16'])=="")  $nota16 = "&nbsp;"; else $nota16 = $fila2['nota16'];
					if (chop($fila2['nota17'])=="0" or chop($fila2['nota17'])=="")  $nota17 = "&nbsp;"; else $nota17 = $fila2['nota17'];
					if (chop($fila2['nota18'])=="0" or chop($fila2['nota18'])=="")  $nota18 = "&nbsp;"; else $nota18 = $fila2['nota18'];
					if (chop($fila2['nota19'])=="0" or chop($fila2['nota19'])=="")  $nota19 = "&nbsp;"; else $nota19 = $fila2['nota19'];
					if (chop($fila2['nota20'])=="0" or chop($fila2['nota20'])=="")  $nota20 = "&nbsp;"; else $nota20 = $fila2['nota20'];
				}
			?>
            <td height="25"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $nom_taller; ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota1<40 && $nota1>0){ ?><font color="#FF0000"><? echo $nota1 ?></font><? } else { echo $nota1; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota2<40 && $nota2>0){ ?><strong><font color="#FF0000"><? echo $nota2 ?></font></strong><? } else { echo $nota2; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota3<40 && $nota3>0){ ?><strong><font color="#FF0000"><? echo $nota3 ?></font></strong><? } else { echo $nota3; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota4<40 && $nota4>0){ ?><strong><font color="#FF0000"><? echo $nota4 ?></font></strong><? } else { echo $nota4; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota5<40 && $nota5>0){ ?><strong><font color="#FF0000"><? echo $nota5 ?></font></strong><? } else { echo $nota5; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota6<40 && $nota6>0){ ?><strong><font color="#FF0000"><? echo $nota6 ?></font></strong><? } else { echo $nota6; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota7<40 && $nota7>0){ ?><strong><font color="#FF0000"><? echo $nota7 ?></font></strong><? } else { echo $nota7; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota8<40 && $nota8>0){ ?><strong><font color="#FF0000"><? echo $nota8 ?></font></strong><? } else { echo $nota8; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota9<40 && $nota9>0){ ?><strong><font color="#FF0000"><? echo $nota9 ?></font></strong><? } else { echo $nota9; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota10<40 && $nota10>0){ ?><strong><font color="#FF0000"><? echo $nota10 ?></font></strong><? } else { echo $nota10; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota11<40 && $nota11>0){ ?><strong><font color="#FF0000"><? echo $nota11 ?></font></strong><? } else { echo $nota11; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota12<40 && $nota12>0){ ?><strong><font color="#FF0000"><? echo $nota12 ?></font></strong><? } else { echo $nota12; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota13<40 && $nota13>0){ ?><strong><font color="#FF0000"><? echo $nota13 ?></font></strong><? } else { echo $nota13; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota14<40 && $nota14>0){ ?><strong><font color="#FF0000"><? echo $nota14 ?></font></strong><? } else { echo $nota14; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota15<40 && $nota15>0){ ?><strong><font color="#FF0000"><? echo $nota15 ?></font></strong><? } else { echo $nota15; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota16<40 && $nota16>0){ ?><strong><font color="#FF0000"><? echo $nota16 ?></font></strong><? } else { echo $nota16; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota17<40 && $nota17>0){ ?><strong><font color="#FF0000"><? echo $nota17 ?></font></strong><? } else { echo $nota17; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota18<40 && $nota18>0){ ?><strong><font color="#FF0000"><? echo $nota18 ?></font></strong><? } else { echo $nota18; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota19<40 && $nota19>0){ ?><strong><font color="#FF0000"><? echo $nota19 ?></font></strong><? } else { echo $nota19; } ?></font></div></td>
			<td width="17"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($nota20<40 && $nota20>0){ ?><strong><font color="#FF0000"><? echo $nota20 ?></font></strong><? } else { echo $nota20; } ?></font></div></td>
			<? 
			if(Trim($fila2['promedio'])=="0" or empty($fila2['nota20'])){
				$prom = "&nbsp;";
			}else{
				$prom = $fila2['promedio'];}  
				
			if (number_format($prom) > 0 and ($fila['nombre']<>"RELIGION")) 
			  {
				  $cont_prom=$cont_prom+1;
				  $promedio = ($promedio + $prom);
			} else {
				$ramo_religion = $fila['id_ramo'];
			}
			$sqlperiodos = "Select * from periodo where id_ano = $ano order by fecha_inicio";
			$resultPer =@pg_Exec($conn,$sqlperiodos);			
	        for($per=0 ; $per < @pg_numrows($resultPer) ; $per++)
			{
				$filaperi = @pg_fetch_array($resultPer,$per);			
				$periodos = $filaperi['id_periodo'];
				//-------
			  	$sql_peri = "SELECT notas_taller.promedio ";
				$sql_peri = $sql_peri . "FROM notas_taller WHERE (((notas_taller.rut_alumno)='".$alumno."') and id_taller = ".$id_taller." and id_periodo = ".$periodos." ) order by id_periodo; ";

				$result_peri =@pg_Exec($conn,$sql_peri);
				if (pg_numrows($result_peri)>0){
					$fila_peri = @pg_fetch_array($result_peri,0);
					if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio'])){
						$prome_1 = "&nbsp;";
					} else {
						if ($fila_peri['promedio']>0){
							$prome_1 = round($fila_peri['promedio'],0);					
						} else {
							$prome_1 = $fila_peri['promedio'];					
						}
					}
				} else {
					$prome_1 = "&nbsp;";
				}
				if($periodos <= $periodo){
				?>
	            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? 
					if($prome_1<40 && $prome_1>0){ ?><strong><font color="#FF0000"><?
						echo $prome_1; ?></font></strong><? 
					}
					else {
						echo $prome_1; 
					} ?></font></td>								
				<? }
			}
?>
		  </tr>
 <? } ?>		  
          <tr>
            <td height="25" colspan="21" align="right"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Promedio &nbsp;&nbsp;&nbsp;</font></strong></font></td>
			<?
			$sqlperiodos = "Select * from periodo where id_ano = $ano order by fecha_inicio";
			$resultPer =@pg_Exec($conn,$sqlperiodos);			
	        for($per=0 ; $per < @pg_numrows($resultPer) ; $per++)
			{
				$filaperi = @pg_fetch_array($resultPer,$per);			
				$periodos = $filaperi['id_periodo'];
				//-------
			  	$sql_peri = "SELECT notas_taller.promedio ";
				$sql_peri = $sql_peri . "FROM notas_taller, tiene_taller WHERE (((notas_taller.rut_alumno)='".$alumno."') and id_periodo = ".$periodos." )  and tiene_taller.rut_alumno = notas_taller.rut_alumno and tiene_taller.id_taller = notas_taller.id_taller order by id_periodo; ";


				$result_peri =@pg_Exec($conn,$sql_peri);
				$prome_abajo = 0;
				$cont_abajo = 0;
		        for($pm=0 ; $pm < @pg_numrows($result_peri) ; $pm++)
				{
					$filapm = @pg_fetch_array($result_peri,$pm);							
					if ($filapm['promedio']>0){
						$prome_abajo = $prome_abajo + $filapm['promedio'];
						$cont_abajo = $cont_abajo + 1;
					}
				}
				if ($prome_abajo>0){
					$prome_abajo = round($prome_abajo/$cont_abajo,0);
					$prome_general_pro = $prome_general_pro + $prome_abajo;
					$cont_general_pro = $cont_general_pro + 1;
				}
/*				if ($periodos<>$periodo)
					 $prome_abajo = 0;
				else
					 $promedio_periodo_aux = $prome_abajo;
*/					 
				if($periodos <= $periodo){
				?>
	            <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($prome_abajo>0) echo $prome_abajo; else  echo "&nbsp;"; ?></font></td>								
				<? }
			}
			if ($prome_general_pro>0)// keo la caga... muy wuena la wuea
				$prome_general_pro = round($prome_general_pro/$cont_general_pro);

			?>
          </tr>
        </table>

           <?
		   
		   }
		   
		   ?>
           <!-- FIN TALLERES -->	
			       <? 
					///////////
					$id_periodo = $fila1['id_periodo'];
					$dias_habiles = $fila1['dias_habiles'];
					$fecha_ini = $fila1['fecha_inicio'];
					$fecha_fin = $fila1['fecha_termino'];
					//--
					$sql13 = "select count(*) as cantidad from asistencia where rut_alumno = '" . $alumno . "' and ano = ". $ano . " and id_curso = " . $curso . " and fecha >= to_date('" . $fecha_ini ."','YYYY MM DD') and fecha <= to_date('" . $fecha_fin . "','YYYY MM DD')";
					$result13 =@pg_Exec($conn,$sql13);
					if (!$result13) 
					{
					  error('<B> ERROR :</b>Error al acceder a la BD. (ASISTENCIA)</B>');
					}
					else
					{
						if (pg_numrows($result13)!=0)
						{
						  $fila13 = @pg_fetch_array($result13,0);	
						  if (!$fila13)
						  {
							  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							  exit();
							}
						}
					}
					$inasistencia = $fila13['cantidad'];
					$dias_asistidos = $dias_habiles - $fila13['cantidad'];
					//////////
				  ?>				  
				  <HR width="100%" color=#003b85>
					<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
					  <tr>
						<td width="153"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS PERIODO </strong></font></td>
						<td width="237"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $dias_habiles ?> </font></td>
						<td width="172"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS INASISTENTES</strong></font></td>
						<td width="78"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $inasistencia ?> </font></td>
					  </tr>
					  
					  <tr>
						<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ASISTENCIAS (%)</strong></font></td>
						<td><font size="1" face="Arial, Helvetica, sans-serif">
			    		   
						  <?
						   					   
							if ($dias_habiles>0)
							{
								$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
								$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
								$prom_cont_asis = $prom_cont_asis + 1;
							}
							echo $promedio_asistencia . "%" ;
							?>
						
						</font></td>
						<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ATRASOS</strong></font></td>
						<td><font size="1" face="Arial, Helvetica, sans-serif">
					<?
					$sql_atraso = "select count(*) as cantidad from anotacion where rut_alumno = '".$alumno."' and tipo = 2 and (fecha >= to_date('" . $fecha_ini ."','YYYY MM DD') and fecha <= to_date('" . $fecha_fin . "','YYYY MM DD'))";
					$result_atraso =@pg_Exec($conn,$sql_atraso);
					$fila_atraso = @pg_fetch_array($result_atraso,0);
					if (empty($fila_atraso['cantidad']))
						echo "0";
					else
						echo $fila_atraso['cantidad'];
					?>
			</font></td>
		  </tr>
		  
		</table>
		
		<table width="750"  border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
			<td ><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Observaciones:</font></strong></font></div></td>
		  </tr>
		  <!--tr>
		    <td height="22"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
			<? 
				$sql_observa = "select * from observa_informe where rut_alumno = '".$alumno."'";
				$result_observa =@pg_Exec($conn,$sql_observa);
				$fila_observa = @pg_fetch_array($result_observa,0);	
				if (!empty($fila_observa['observacion']))
					echo $fila_observa['observacion'];
				else
					echo "&nbsp;";
			
			?></font></div></td>
		    </tr-->
		</table>
			
		<table width="750" height="72" border="0" cellpadding="0" cellspacing="0" align="center">
		 <? if ($bool_ed==1) { ?>
		  <tr>
			<td height="27"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif"><? echo "ALUMNO EVALUADO DIFERENCIADAMENTE ";?> 
               </font></strong></font></div></td>
		  </tr>
		  <? } ELSE{ ?>
		  <tr>
			<td height="27"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif"> 
                        <!--Academias:-->
                        </font><font size="1"><strong><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font><font face="Arial, Helvetica, sans-serif"></font></strong></font></strong></font></div></td>
		  </tr>
		  <? } ?>
		  <tr>
		    <td height="27"><div align="left"><font size="1"><strong><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font><font face="Arial, Helvetica, sans-serif"></font></strong></font></div></td>
		    </tr>
			
		  
		</table>			  
		        <table width="750" align="center" border="0" cellpadding="0" cellspacing="0">
				  <?
				  for($e=0 ; $e < 4 ; $e++)
				  {
				  ?>			 
                  <tr> 
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
				  <? }?>
                  <tr>
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">________________________________</font></strong></div></td>
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">________________________________</font></strong></div></td>
                  </tr>
				  
				
				  
                  <tr>
                    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="1">Profesor(a) Jefe. </font></div></td>
                    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="1"><?=$cargo_dir2 ?> Establecimiento</font></div></td>
                  </tr>
                  <tr>
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1"><? if(($institucion==8930)OR($institucion==770)){  echo $nombre_profesor; }else{ echo $nombre_profe;} ?></font></strong></div></td>
                    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1">
                        <?
			$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
			$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
			$sql = $sql . "WHERE trabaja.rdb=".$institucion." AND (trabaja.cargo=1 OR trabaja.cargo=23) ";
			$result =@pg_Exec($conn,$sql);
			if (!$result) 
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
			}
			else
			{
				if (pg_numrows($result)!=0)
				{
					$fila = @pg_fetch_array($result,0);	
					if (!$fila)
					{
						error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						exit();
					}
				}
			}
				echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
			    $cargo_dir    = $fila['cargo'];	
		
		
				if ($cargo_dir==1){
					$cargo_dir  = "director";
					$cargo_dir2 = "Director";
				}
				if ($cargo_dir==23){
					$cargo_dir  = "rector(a)";
					$cargo_dir2 = "Rector(a)";
				}
		
			?>
                    </font></strong></div></td>
                  </tr>
                </table>
						  
		 <? 
		 $suma_prom = 0;
		 $cuenta_prom = 0;
		 $promedio_semestre = "";		 
		 
		 }
		 
		 
		 }  ?>  
		 
		
		<table width="100%" border="0">
		  <tr><td align="left"><?					
					## si el campo esta vacío poner la fecha actual
					$dia  = strftime("%d",time());
					$mes  = strftime("%m",time());
					$mes  = envia_mes2($mes);
					$ano2  = strftime("%Y",time()); 
					
					$sql_inst = "SELECT comuna.nom_com FROM comuna INNER JOIN institucion ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) WHERE institucion.rdb = ".$rdb;
					$res_inst =@pg_Exec($conn,$sql_inst);
					$arr_inst = @pg_fetch_array($res_inst);
					   
					echo "<font face='verdana' size='1'>".$arr_inst['nom_com'].", $dia de $mes del $ano2</font>";
					?>
				</td>
				</tr>
		</table>				
					
			  
			  
			  
<form method="post" action="">
<input type="hidden" name="flag" value="<? echo $flag;?>">
<? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
//------------------
$sql_peri = "select * from periodo where id_ano = ".$ano;
$result_peri = pg_exec($conn,$sql_peri);

//------------------
?>
<center>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="5" class="textosmediano"><span class="textosimple">Per&iacute;odo</span><br>
      <select name="cmb_periodos" class="ddlb_9_x">
        <option value=0 selected>(Seleccione Periodo)</option>
        <?
		  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_peri,$i); 
		  if ($fila['id_periodo']==$cmb_periodos)
   			echo  "<option selected value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
		  else
   			echo  "<option value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
		  ?>
        <? } ?>
          </select></td>
    </tr>
  <tr>
    <td colspan="5" class="textosmediano"><span class="textosimple">Curso</span>
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	      <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
	        <option value=0 selected>(Seleccione Curso)</option>
	        <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
		  if ($fila["id_curso"]==$cmb_curso){
				if (($fila['grado_curso']==1) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987))){
					echo "<option selected value=".$fila['id_curso'].">"."PN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==121987) or ($fila['cod_decreto']==1521989)) ){
					echo "<option selected value=".$fila['id_curso'].">"."PC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."SL - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
					echo "<option selected value=".$fila['id_curso'].">"."SN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==121987) ){
					echo "<option selected value=".$fila['id_curso'].">"."SC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."NMME - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
					echo "<option selected value=".$fila['id_curso'].">"."TN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."NMMA - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."T1N - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==5) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."T2N  - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else{
				echo "<option selected value=".$fila['id_curso'].">".$fila["grado_curso"] . "-" . $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}		  
  		  }else{
		  		if (($fila['grado_curso']==1) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987))){
					echo "<option value=".$fila['id_curso'].">"."PN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==121987) or ($fila['cod_decreto']==1521989)) ){
					echo "<option value=".$fila['id_curso'].">"."PC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."SL - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
					echo "<option value=".$fila['id_curso'].">"."SN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==121987) ){
					echo "<option value=".$fila['id_curso'].">"."SC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."NMME - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
					echo "<option value=".$fila['id_curso'].">"."TN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."NMMA - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."T1N - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==5) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."T2N  - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else{
				echo "<option value=".$fila['id_curso'].">".$fila["grado_curso"] . "-" . $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}		
		  }
          } ?>
	        </select>
</font>	  </div>
	  
      </td>
    </tr>
  <tr>
    <td colspan="5" class="textosmediano"><span class="textosimple">Alumno</span>
	  <div align="left">
	    
	    <select name="cmb_alumno" class="ddlb_9_x">
	      <option value=0 selected>(Todos los Alumnos)</option>
	      <?
		$sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
		$result= @pg_Exec($conn,$sql);
		for($i=0 ; $i < @pg_numrows($result) ; $i++){
			$fila = @pg_fetch_array($result,$i);?>
	      <?
			if ($fila["rut_alumno"] == $cmb_alumno){
			   ?>
	      <option value="<? echo $fila["rut_alumno"]; ?>" selected><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
	      <?
			}else{
			   ?>
	      <option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>   	
	      <?
		    }		
			
		}
		?>
	      </select>
	      </div></td>
    </tr>
  <tr>
    <td width="39" class="textosmediano">&nbsp;</td>
    <td width="498" colspan="4"><div align="right">
       <input name="cb_ok" type="button" class="botonXX"  id="cb_ok" onClick="MM_goToURL('parent','NotasParciales_subsector.php?c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;c_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;c_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value+'&amp;cmb_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;cmb_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;cmb_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value);return document.MM_returnValue" value="Buscar"></div></td>
    </tr>
</table>
</center>
</form>
			  
			  
			  
			  
			  
			  
			  
			  
			  </td>
            </tr>
            <tr align="center" valign="middle">
              <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
      </table>
</td>
  </tr>
</table>
</body>
</html>