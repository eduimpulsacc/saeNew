<?php session_start();

require('../../../../../../../util/header.inc');
$institucion=$_INSTIT;
$ano=$_ANO;

//var_dump($_SESSION);
$sql="select nro_ano from ano_escolar where id_ano=$ano";
$rs_ano=pg_Exec($conn,$sql)or die("Fallo 0 ".$sql);
 ?>
<link href="../../../../../../../cortes/<?php echo $institucion ?>/estilos.css" rel="stylesheet" type="text/css"> 
<link rel="stylesheet" type="text/css" href="../../../../../../clases/jqueryui/jquery-ui-1.8.6.custom.css">

<script type="text/javascript" src="../../../../../../clases/jquery-ui-1.9.2.custom/js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="../../../../../../clases/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="../../../../../../clases/jqueryui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../../../../../../clases/jquery-ui-1.9.2.custom/js/jquery.maskedinput-1.2.2.js"></script>
<script type="text/javascript" src="functions.js"></script>
  <style>
  div.ui-datepicker{
 font-size:12px;
}
  </style>
    
 <script type="text/javascript">
		$(document).ready(function() {
			
		
		  $("#txt_fecha").datepicker({
	showOn: 'both',
	changeYear:false,
	changeMonth:true,
	dateFormat: 'dd/mm/yy',
	minDate: new Date('01/01/'+<?php echo pg_result($rs_ano,0)?>+''),
			maxDate: new Date('12/31/'+<?php echo pg_result($rs_ano,0)?>+''),
	monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
  firstDay: 1
	//buttonImage: 'img/Calendario.PNG',
	});
		
		$("#txt_hora").mask('99:99');
		
	});
	
	function carga_ramosN(id_curso){
		
		var funcion=5;
		
		var parametros='funcion='+funcion+'&id_curso='+id_curso;
	//alert(parametros);
		$.ajax({
	  url:'../cont_cal.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// alert(data);
		//console.log(data);
	    $("#select_ramoN").html(data);
		
		  }
	  })
	}	
	
	
	
	
	</script>
<style type="text/css">
    .messages{
        /*float: left;*/
        font-family: sans-serif;
       /* display: none;*/
		width:auto;
		text-align:center;
		
    }
    .info{
        padding: 10px;
        border-radius: 10px;
        background: orange;
        color: #fff;
        font-size: 14px;
        text-align: center;
		
		
    }
    .before{
        padding: 10px;
        border-radius: 10px;
        background: blue;
        color: #fff;
        font-size: 14px;
        text-align: center;
		width:100%;
    }
    .success{
        padding: 10px;
        border-radius: 10px;
        background: green;
        color: #fff;
        font-size: 14px;
        text-align: center;
		
		
		
    }
    .error{
        padding: 3px;
        border-radius: 10px;
        background: red;
        color: #fff;
        font-size: 10px;
        text-align: center;
		
    }
</style>
<body  >

    <!--el enctype debe soportar subida de archivos con multipart/form-data-->
    <form enctype="multipart/form-data" class="formulario"  >
    <table width="95%" border="0" align="center" cellspacing="0">
  <tr class="cuadro02">
    <td colspan="2" align="center">CARGA DATOS EVALUACI&Oacute;N</td>
    </tr>
  <tr>
    <td width="24%">&nbsp;</td>
    <td width="76%">&nbsp;</td>
  </tr>
  <tr>
    <td width="90" class="cuadro02">&nbsp;Curso</td>
    <td class="cuadro01">
   <?php   $sql="select id_curso from curso where id_ano=$ano order by ensenanza,grado_curso,letra_curso";
		$rs_cur=pg_Exec($conn,$sql)or die("Fallo 0 ".$sql);?>
    <select name="select_CursoN" id="select_CursoN" onChange="carga_ramosN(this.value)" >
      <option value="0">Seleccionar</option>
      <? for($c=0;$c<pg_numrows($rs_cur);$c++){    
	  $fila = pg_fetch_array($rs_cur,$c);
		  ?>
      <option value="<?php echo $fila['id_curso'] ?>"><?php echo CursoPalabra($fila['id_curso'],1,$conn) ?></option>
      <?php }?>
    </select></td>
  </tr>
  <tr>
    <td class="cuadro02">Asignatura</td>
    <td class="cuadro01"><div id="select_ramoN">
      <select name="select_RamosN" >
        <option value="0">Seleccionar</option>
      </select>
    </div></td>
  </tr>
  <tr>
    <td class="cuadro02">Fecha</td>
    <td class="cuadro01"><input name="txt_fecha" type="text" id="txt_fecha" size="10" readonly="readonly"></td>
  </tr>
  <tr>
    <td class="cuadro02">Hora</td>
    <td class="cuadro01"><input name="txt_hora" type="text" id="txt_hora" size="6" maxlength="6"></td>
  </tr>
  <tr>
    <td class="cuadro02">Contenido</td>
    <td class="cuadro01"> <textarea name="txt_contenido" cols="50" rows="5" id="txt_contenido"></textarea></td>
  </tr>
  <tr>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">Subir un archivo</td>
    <td class="cuadro01"><input name="archivo" type="file" id="imagen" /> <span class="messages" align="center" >
     </span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="button" value="Subir Datos" id="car"  class="botonXX" /></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"> 
   
    </td>
    </tr>
    </table>

     
    </form>
  
  </body>  