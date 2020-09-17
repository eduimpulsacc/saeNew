<?php require('../../../util/header.inc');?>

<?php 

	
	session_start();
	
	
	/****** MODIFICACION 11 DE JUNIO****************/
		//$qry="SELECT * FROM MATRICULA WHERE RDB=".$_INSTIT." AND RUT_ALUMNO='".$_ALUMNO."'  ORDER BY ID_ANO DESC";
		
		$qry="SELECT * 
FROM MATRICULA INNER JOIN ano_Escolar ON matricula.id_ano=ano_Escolar.id_ano
WHERE RDB=".$_INSTIT." AND RUT_ALUMNO=".$_ALUMNO." and situacion=1 AND bool_ar=0 ORDER BY ano_escolar.ID_ANO DESC";


		$result = @pg_Exec($conn,$qry);
		if (!$result){
			error('<b>ERROR :</b>No se puede acceder a la base de datos.4'.$qry);
		}elseif(pg_numrows($result)==0){
			
		}else{
			$fila = @pg_fetch_array($result,0);	
			$_ANO=$fila["id_ano"];
			session_register('_ANO');

			$_CURSO=$fila["id_curso"];
			session_register('_CURSO');
			
		};
		$qry="SELECT * FROM INSTITUCION WHERE RDB=".$_INSTIT;
		$result = @pg_Exec($conn,$qry);
		$fila = @pg_fetch_array($result,0);	

		$_TIPOREGIMEN=$fila["tipo_regimen"];
		session_register('_TIPOREGIMEN');
	/******* FIN MODIFICACION********************/


	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$_POSP          =1;
	
	
	
	
	$sql ="SELECT bloqueo FROM alumno WHERE rut_alumno=".$alumno;
	$rs_bloqueo =pg_exec($conn,$sql);
	$bloqueo =pg_result($rs_bloqueo,0);
	if($bloqueo==1){
		echo "<script>alert('ALUMNO SE ENCUENTRA MOROSOS EN MENSUALIDAD, FAVOR ACERCARSE A ADMINISTRACION')</script>";	
		echo "<script>window.location='http://www.colegiointeractivo.com'</script>";
	}

	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, comuna.nom_com, institucion.telefono ";
	$sql_institu = $sql_institu . "FROM institucion INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion."));";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro'] . " - " . $fila_institu['nom_com']));
	$telefono = $fila_institu['telefono'];		 
	//----------------------------------------------------------------------------
	// CURSO
	//----------------------------------------------------------------------------	
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	$sql_curso = "SELECT truncado_per,truncado_final FROM curso WHERE id_curso=".$curso;
	$result_curso =@pg_Exec($conn,$sql_curso);
	$fila_curso = @pg_fetch_array($result_curso,0);
	$truncado_per = $fila_curso['truncado_per'];
	$truncado_final = $fila_curso['truncado_final'];
	
	//----------------------------------------------------------------------------
	// ALUMNO
	//----------------------------------------------------------------------------		
	$sql_alumno = "SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, matricula.fecha, alumno.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, alumno.depto, alumno.block, alumno.villa ";
	$sql_alumno = $sql_alumno . "FROM (((matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
	$sql_alumno = $sql_alumno . "WHERE (((matricula.rut_alumno)=".$alumno.") AND ((matricula.id_ano)=".$ano.")); ";
	//echo $sql_alumno;
	$result_alumno = @pg_Exec($conn, $sql_alumno);
	$fila_alumno = @pg_fetch_array($result_alumno,0);
	$rut_alumno = strtoupper($fila_alumno['rut_alumno'] . " - " . $fila_alumno['dig_rut']);
	$nombre = ucwords(strtolower($fila_alumno['ape_pat']))." ".ucwords(strtolower($fila_alumno['ape_mat']))." ".ucwords(strtolower($fila_alumno['nombre_alu']));
	//----------------------------------------------------------------------------
	// AÑO ESCOLAR
	//----------------------------------------------------------------------------	
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano = @pg_Exec($conn, $sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);
	$nro_ano = 	$fila_ano['nro_ano'];
	//-----------------------------------------	
	//------------------FECHAS DE PERIODOS -----------------------
	$sql="";
	if($periodo==0)
	{
		 $sql_peri = "select * from periodo where id_ano = ".$ano." order by fecha_inicio";
		$result_peri = pg_exec($conn,$sql_peri);
		for($i=0;$i<pg_numrows($result_peri);$i++)
		{
			if($i==0) //primer semestre
			{
				$fila_per = pg_fetch_array($result_peri,$i);
				$fecha_inicio = $fila_per['fecha_inicio'];					
			}
			if($i==1) //segundo semestre
			{
				$fila_per = pg_fetch_array($result_peri,$i);
				$fecha_termino = $fila_per['fecha_termino'];
			}
			if($i==2)//tercer semestre en caso q haya
			{
				$fila_per = pg_fetch_array($result_peri,$i);
			 $fecha_termino = $fila_per['fecha_termino'];
			}
		}	
	}else{
	
	$sql="SELECT fecha_inicio,fecha_termino FROM periodo WHERE id_periodo=".$periodo;
	$Rs_Periodo = @pg_exec($conn,$sql);
	$fila_Periodo=@pg_fetch_array($Rs_Periodo,0);
	$fecha_inicio=$fila_Periodo['fecha_inicio'];
	$fecha_termino=$fila_Periodo['fecha_termino'];
	}
	//-----------------------------------------------------------
	
	
	/**********biblioteca*************/
	
	
	
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
<link rel="stylesheet" type="text/css" href="../../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css">
<script type="text/javascript" src="../../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>

<script type="text/javascript" src="../../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>

<script>

$( document ).ready(function() {
	filtro();
    contReservas();
	contPrestamos();
	bloqueos();
	//bloqueoReserva();
});

function limpia(){
	//if($("#combobox").val()==""){
		$("#idLBR").val('');

}

function limpia2(){
	//if($("#combobox").val()==""){
		$("#idAUT").val('');

}

function limpia3(){
	//if($("#combobox").val()==""){
		$("#idMAT").val('');

}



function filtro(){
var parametros="funcion=1";

 $.ajax({
	  url:'cont_reserva_alu.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#flt").html(data);
		  }
	  })	
}
function contReservas(){
	var parametros="funcion=2";

 $.ajax({
	  url:'cont_reserva_alu.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#res").html(data);
		  }
	  })
}
function contPrestamos(){
	var parametros="funcion=3";

 $.ajax({
	  url:'cont_reserva_alu.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#pres").html(data);
		  }
	  })
}

function anular(idr){
var funcion=4;
var parametros = "funcion="+funcion+"&idr="+idr;
if(confirm("¿SEGURO DE ANULAR RESERVA?")){
	$.ajax({
	  url:'cont_reserva_alu.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		alert("RESERVA ANULADA")
		contReservas();
		
		  }
	  })
}
}

function dsp(libro){
	var funcion =5;
	//var lbr = $("#idLBR").val();
	var lbr = libro;
	var parametros = "funcion="+funcion+"&lbr="+lbr;
	$.ajax({
	  url:'cont_reserva_alu.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  console.log(data);
		if(data==0){
			reserva(libro);
			}
		else if(data==2){
		 alert("RESERVA DUPLICADA PARA ESE TITULO");
		  $("#ble").hide();
		}
		else if(data==3){
		 alert("MAXIMO PERMITIDO DE RESERVAS ALCANZADO.");
		 $("#ble").hide();
		}
		else {
		 alert("TITULO SE ENCUENTRA SIN EJEMPLARES DISPONIBLES HASTA "+ data.trim());
		 $("#ble").hide();
		}
		  }
	  })
}

function reserva(libro){
var funcion=6;
//var lbr = $("#idLBR").val();
var lbr = libro;

var fecha_reserva = $("#txtFECHARES").val();
var parametros = "funcion="+funcion+"&lbr="+lbr+"&fecha_reserva="+fecha_reserva;

if(lbr==""){
	alert("DEBE SELECCIONAR LIBRO");
	$('#combobox').focus();
	return false;
}
else if(fecha_reserva==""){
	alert("DEBE SELECCIONAR FECHA");
	$('#txtFECHARES').focus();
	return false;
}
else{
	$.ajax({
	  url:'cont_reserva_alu.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		console.log(data);
		alert("RESERVA REALIZADA")
		contReservas();
		$('#lis').html('');
		  }
	  })
}
}

function busca(){
var funcion = 7;
var aut = $("#idAUT").val();
var mat = $("#idMAT").val();
var lbr = $("#idLBR").val();
var parametros = "funcion="+funcion+"&aut="+aut+"&mat="+mat+"&lbr="+lbr;
$.ajax({
	  url:'cont_reserva_alu.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#lis").html(data);
		
		  }
	  })
}
function bloqueoReserva(){
var funcion=8;
var rut = <?php echo $_ALUMNO ?>;
var ano = <?php echo $_ANO ?>;
var rdb = <?php echo $_INSTIT ?>;
var parametros = "funcion="+funcion+"&ano="+ano+"&rdb="+rdb+"&rut="+rut;
$.ajax({
	  url:'cont_reserva_alu.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//$("#lis").html(data);
		if(data!=1){
			$("#sm").html(data);
			}
		  }
	  })

}

function bloqueos(){
var funcion=9;
var rdb = <? echo $_INSTIT;?>;
var ano = <? echo $_ANO;?>;
var fecha = '<?php echo date("Y-m-d") ?>';
var rut = <?php echo $_ALUMNO ?>;
var parametros = "funcion="+funcion+"&rdb="+rdb+"&fecha="+fecha+"&ano="+ano+"&rut="+rut;
$.ajax({
	   url:'cont_reserva_alu.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//$("#tabla").html(data);
		console.log(data);
		bloqueoReserva();
		  }
	  })	
}

</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../cabecera/menu_superioralu.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!--inicio codigo antiguo -->							  
								  
								  
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="tableindex"><div align="center">RESERVA DE LIBROS</div></td>
  </tr>
</table>
<div align="right">
  <label><br>
  </label>
  <br>
 </div>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="650">
    
<br>
    <div id="flt">
    
    </div><br>
<br>
<div id="lis">
    
    </div><br><br>

<div id="res">

</div>
<br>
<br>
<div id="pres">

</div>
<br>
<br><br>
<br>
</td>
  </tr>
</table>
 		
</center>

								  
								  
								  
								  
								  
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2007 - Desarrolla Colegio 
                        Interactivo</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>