<?php 
require("../../../util/header.php");
session_start();
$_POSP=3; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<link  rel="shortcut icon" href="../../../images/icono_sae_33.png">
<link href="../../../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../../../cabecera_new/css2.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../../menu_new/css/styles.css">
<link href="../../../cortes/0/estilos.css" rel="stylesheet" type="text/css"> 
<link href="../../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="../../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script>
$(document).ready(function(){
	//cambia_curso();
	cambia_periodo();
	cambia_grado();
	
});

function cambia_curso(){
 var ano =$("#cmbANO").val();
 var parametros="funcion=1&ano="+ano;
 
 $.ajax({
	  url:'cont_motor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#curso").html(data);

		  }
	  })		
}

function cambia_ramo(){
 var ano =$("#cmbANO").val();
 var curso = $("#cmbCURSO").val();
 var codramo = $("#codramo").val();
 var parametros="funcion=2&ano="+ano+"&curso="+curso+"&codramo="+codramo;
 $.ajax({
	  url:'cont_motor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //console.log(data);
		 //alert(data);
	    $("#ramo").html(data);

		  }
	  })		
}

function cambia_unidad(cur,ram){
 var ano =$("#cmbANO").val();
 var parametros="funcion=3&ano="+ano+"&curso="+cur+"&ramo="+ram;
 
 
 $.ajax({
	  url:'cont_motor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		 //alert(data);
	    $("#unidad"+cur).html(data);

		  }
	  })
 
}

function cambia_clase(uni,cur){
 var ano =$("#cmbANO").val();
 var curso = cur;
 var ramo = $("#idramo"+cur).val();
 var unidad = uni;
 
 var parametros="funcion=4&ano="+ano+"&curso="+curso+"&ramo="+ramo+"&unidad="+unidad;
 
 //alert(parametros);
 $.ajax({
	  url:'cont_motor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //console.log(data);
		 //alert(data);
	    $("#clase"+cur).html(data);

		  }
	  })		
}

function cambia_periodo(){
var ano =$("#cmbANO").val();

var parametros="funcion=5&ano="+ano;
 $.ajax({
	  url:'cont_motor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //console.log(data);
		 //alert(data);
	    $("#per").html(data);

		  }
	  })		

}

function cambiotipo(opt){
	if(opt==1){
		//reporte
		$("#tipografico").html('');
	
}
else{
	//grafico
	$("#tipografico").append('<td class="textonegrita">TIPO GR�FICO</td><td class="textonegrita">:</td><td><input name="tipo" type="radio" value="0" />BARRAS <input name="tipo" type="radio" value="1" />PUNTOS <input name="tipo" type="radio" value="2" />TORTA</td>');
}
}

function enviar(){
//var opt = $('input:radio[name=formato]:checked').val();
//var opt = 1;

	//if(opt==1){
	var ruta ="printReporteNivel.php";
	//}else 
	//{
	//var ruta ="printGraficoNotasCursoAsig.php";	
	//}	
	
	
	form.target="_blank";
	form.action = ruta;
		//form.submit(true);
}

function cambia_grado(){
 var ano =$("#cmbANO").val();
 var parametros="funcion=6&ano="+ano;
 
 $.ajax({
	  url:'cont_motor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#grado").html(data);

		  }
	  })		
}

function cursogrado(){
var ano =$("#cmbANO").val();
var str = $("#cmbGRADOS").val();
var ram = $("#cmbRAMO").val();
var res = str.split("_");
var ense = res[0];
var grado = res[1];

var parametros="funcion=7&ano="+ano+"&ense="+ense+"&grado="+grado;
 
 
 $.ajax({
	  url:'cont_motor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//console.log(data);
		// alert(data);
		
	    $("#cursos").html(data);
		
		  }
	  })	
 
}

function ramogrado(){
var ano =$("#cmbANO").val();
var str = $("#cmbGRADOS").val();
var res = str.split("_");
var ense = res[0];
var grado = res[1];

var parametros="funcion=9&ano="+ano+"&ense="+ense+"&grado="+grado;
 
 $.ajax({
	  url:'cont_motor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
		if(ano!=0){
	    $("#ramos").html(data);
		}else{
		 $("#ramos").html('');
		}
		  }
	  })	
}

function limpia_curso(){
 $("#cursos").html('');
}

function ramocur(cur){
var codramo =$("#cmbRAMO").val();
var parametros="funcion=10&cur="+cur+"&codramo="+codramo;
//alert(parametros);
 $.ajax({
	  url:'cont_motor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//console.log(data);
		// alert(data);
		
	    $("#idramo"+cur).val(data);
		
		cambia_unidad(cur,$("#idramo"+cur).val())
		
		  }
	  })
}

function cargadata(cur){
var ramo = $("#idramo"+cur).val(); 
var unidad = $("#cmbUNIDAD"+cur).val(); 
var clase = (parseInt($("#cmbCLASE"+cur).val())> 0 )?$("#cmbCLASE"+cur).val():0;



if(unidad > 0){
var valor = cur+"_"+ramo+"_"+unidad+"_"+clase;

$("#dataclase"+cur).html('<input type="hidden" name="datos[]" value="'+valor+'">');
}else{
$("#dataclase"+cur).html('');
}


}


</script>
<title>SISTEMA SAE:====> PLANIFICACION</title>
</head>

<body leftmargin="0" marginheight="0" rightmargin="0" marginwidth="0">
<table width="1280" border="0" cellpadding="0" cellspacing="0">
  <tr>
   	<td rowspan="3" valign="top" background="../../../cortes/<?=$_INSTIT;?>/fondo_01_reca.jpg" width="50"  height="900"></td>
   	<td colspan="2" align="left" valign="top" height="70"><? include("../../../cabecera_new/head_plani_p.php");?></td>
    <td rowspan="3" background="../../../cortes/<?=$_INSTIT;?>/fomdo_02_reca.jpg" width="53" height="900"></td>
  </tr>
  <tr>
    <td valign="top" align="left"><? include("../../../menu_new/index.php");?></td>
    <td valign="top" align="center"><br />
    <table width="890" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
      <tr>
        <td width="5%" colspan="4"><br />
        <form method ="post"  name="form" target="_blank">
        <table width="90%" border="0" align="center" class="cajaborde">
          <tr>
            <td colspan="3" class="tableindexredondo">Buscador Notas por Grado</td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr>
            <td width="29%" class="textonegrita">A&Ntilde;O</td>
            <td width="3%" class="textonegrita">:</td>
            <td width="68%">
            <? 	$sql="SELECT id_ano, nro_ano,situacion FROM ano_escolar WHERE id_institucion=".$_INSTIT." ORDER BY nro_ano ASC";
                $rs_ano = pg_exec($conn,$sql);
            ?>
            <div id="ano">
            <select name="cmbANO" id="cmbANO" onchange="cambia_periodo();cambia_grado();limpia curso()" class="select_redondo">
                <option value="0">seleccione...</option>
                <? for($i=0;$i<pg_numrows($rs_ano);$i++){
                        $fila=pg_fetch_array($rs_ano,$i);
                        if($fila['situacion']==1){
                            $estado="(abierto)";
                        }else{
                            $estado="(cerrado)";
                        }
                ?>
                <option value="<?=$fila['id_ano'];?>" <? if($fila['situacion']==1) echo "selected";?>><?=$fila['nro_ano']." ".$estado;?></option>
                <? } ?>	
             </select>
             </div>
            </td>
          </tr>
          <tr>
            <td class="textonegrita">GRADO</td>
            <td class="textonegrita">:</td>
            <td>
              <div id="grado">
                <select name="cmbGRADOS" id="cmbGRADOS" class="select_redondo">
                  <option value="0">seleccione...</option>
                  
                </select>
            </div></td>
          </tr>
          <tr>
            <td class="textonegrita">RAMO</td>
            <td class="textonegrita">:</td>
            <td>
            <div id="ramos">
              <select name="cmbRAMO" id="cmbRAMO" class="select_redondo">
                <option value="0">seleccione...</option>
              </select>
            </div></td>
          </tr>
           <tr>
            <td class="textonegrita">PERIODO</td>
            <td class="textonegrita">:</td>
            <td><div id="per">
            <select name="cmbPERIODO1" id="cmbPERIODO1" class="select_redondo">
                <option value="0">seleccione...</option>
            </select>
            </div></td>
          </tr>
          <tr>
            <td class="textonegrita">APROXIMAR NOTAS</td>
            <td class="textonegrita">:</td>
            <td><input name="aprox" type="checkbox" id="aprox" value="1" checked="checked" /></td>
          </tr>
         <!-- <tr>
            <td class="textonegrita">FORMATO</td>
            <td class="textonegrita">:</td>
            <td><input name="formato" type="radio" id="formato1" value="1" checked="checked" onclick="cambiotipo(this.value)" />
              Reporte
                <input type="radio" name="formato" id="formato0" value="0" / onclick="cambiotipo(this.value)">
              Gr&aacute;fico                                  </td>
          </tr>-->
          
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3"><div id="cursos"></div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right"><input type="submit" name="BUSCAR" id="BUSCAR" value="BUSCAR"  class="botonXX" onclick="enviar()"/>&nbsp;<input type="button" name="VOLVER" id="VOLVER" value="VOLVER" onclick="window.location='../listado_reportes.php'" class="botonXX" /></td>
          </tr>
        </table>  
        </form>
                                  <br />


        
        </td>
      </tr>
      </table>
    
    </td>
  </tr>
  <tr>
    <td colspan="2"><? include("../../../cabecera_new/footer2.html");?></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
</table>



</body>

</html>
