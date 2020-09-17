<?php  
require("../../../util/header.php");
session_start(); 
?>
<script>
$(document).ready(function(){
$("#f1,#f2,#f3,#f4").hide();

<?php if($tipof==2){?>
$("#f5").hide();
<?php }?>

<?php if($tipof==3){?>
$("#f6").hide();
var d = new Date();
    var dd = (d<10)?("0"+d.getDate()):d.getDate();
	var mm = (d.getMonth()+1);
	

$("#txtFECHADEV").datepicker({
			showOn: 'both',
			changeYear:false,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			minDate: new Date(''+mm+'/'+dd+'/'+<?php echo $_NANO ?>+''),
			maxDate: new Date('12/31/'+<?php echo $_NANO ?>+''),
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		    firstDay: 1
			
		});

<?php }?>

});



function filtra(tipo){
	$("#cur").html('');
	$("#us").html('');
	$("#tit").html('');
	
	if(tipo==0){
		$('#cmb_tipou').val($('#cmb_tipou > option:first').val());
		tipu(0);
		$("#f2").hide();
		$("#f1").show();
		

	}
	
	if(tipo==1){
		$("#f2").show();
		$("#f1,#f3,#f4").hide();
		cargaLibro();
		
		 
		
	}
	
	
	<?php if($tipof==2){?>
	$("#f5").show();
	<?php }?>
	
	<?php if($tipof==3){?>
	$("#f6").show();
	$("#txtFECHADEV").val('');
	<?php }?>
	
	if(tipo==2){
		
		$("#f1,#f2,#f3,#f4,#f5,#f6").hide();
		
		
		 
		
	}
	

}
function tipu(tipo){
if(tipo!=0){
	 if(tipo==1){
		 $("#f3").hide();
		 $("#f4").show();
		 $("#us").html('');
		 cargaEmp();
		 
	}
	if(tipo==2){
		 $("#f3,#f4").show();
		 $("#us").html('');
		 cargaCurso();
	}
	if(tipo==3){
		$("#f3,#f4").show();
		$("#us").html('');
		cargaCurso();
	}
	
}
else{
	$("#f3,#f4").hide();
}

}

function cargaLibro(){
var funcion=1;
 var parametros="funcion="+funcion;
 
 $.ajax({
	  url:'../filtro/cont_filtro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#tit").html(data);

		  }
	  })		
}

function cargaEmp(){
var funcion=2;
 var parametros="funcion="+funcion;
 
 $.ajax({
	  url:'../filtro/cont_filtro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#us").html(data);

		  }
	  })		
}

function cargaCurso(){
var funcion=3;
 var parametros="funcion="+funcion;
 
 $.ajax({
	  url:'../filtro/cont_filtro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#cur").html(data);

		  }
	  })		
}
function traeNombre(){
	
	var funcion =4;
	var tipo = $("#cmb_tipou").val();
	var curso =$("#cmb_curso").val();
	var parametros = "funcion="+funcion+"&curso="+curso+"&tipo="+tipo;
	$.ajax({
	  url:'../filtro/cont_filtro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#us").html(data);
		  }
	  })
}


function limpia(){

	$("#idLBR").val('');
	
}

function valf(){
	 var tipo = $("input[name='radio']:checked").val();
	 var val = $("#cmb_tipou").val();
	  
	  var paso=0;
	  
	  if(!tipo){
	  	alert("DEBE SELECCIONAR TIPO DE BUSQUEDA");
		paso=1;
	  }else{
		if(tipo==0 && val==0){
			alert("DEBE SELECCIONAR TIPO DE USUARIO");
			paso=1;
		}  
	  }
	  
	 
	 if(val ==2 || val==3){
		 var c = $("#cmb_curso").val(); 
		 if(c==0){
		 	alert("DEBE SELECCIONAR CURSO");
			paso=1;
		 }
		 else{
		paso=0;
		}
	
	 }
	 
	 if(tipo==1){
	 	var cad = $("#idLBR").val(); 
		if(cad==""){
			alert("DEBE SELECCIONAR TITULO");
			paso=1;
		}else{
			paso=0;
		}
	 }
	 
	 <?php if($tipof==3){?>
	if(	$("#txtFECHADEV").val()==""){
		alert("DEBE SELECCIONAR FECHA");
		paso=1;
	}else{
		paso=0;
	}
	<?php }?>
	 
	 if(paso==0){
		act(0);
	 }

}

</script>

            <table width="100%" border="0" cellpadding="3" align="center">
              
           
            <tr>
              <td width="22%" class="cuadro02">FILTRAR POR</td>
              <td width="4%" align="center" class="cuadro02">:</td>
              <td width="74%" class="cuadro01"><input type="radio" name="radio" id="op0" value="0" onClick="filtra(0)">Usuario <input name="radio" type="radio" id="op1" value="1" onClick="filtra(1)">
              T&iacute;tulo <?php if ($tipof==2){?><input name="radio" type="radio" id="op2" onClick="filtra(2)" value="2">
              Mostrar todo <? } ?></td>
            </tr>
            <tr id="f1">
              <td class="cuadro02">TIPO DE USUARIO</td>
              <td align="center" class="cuadro02">:</td>
              <td class="cuadro01"><div id="tipou">
              <select name="cmb_tipou" id="cmb_tipou" onChange="tipu(this.value)">
                <option value="0">Seleccione</option>
                <option value="1">Empleado</option>
                <option value="2">Apoderado</option>
                <option value="3">Alumno</option>
              </select></div></td>
            </tr>
            <tr id="f2">
              <td class="cuadro02">T&Iacute;TULO</td>
              <td align="center" class="cuadro02">:</td>
              <td class="cuadro01">
              <div id="tit"></div>
              </td>
            </tr>
            <tr id="f3">
              <td class="cuadro02">CURSO</td>
              <td align="center" class="cuadro02">:</td>
              <td class="cuadro01">
              <div id="cur"></div></td>
            </tr>
            <tr id="f4">
              <td class="cuadro02">USUARIO</td>
              <td align="center" class="cuadro02">:</td>
              <td class="cuadro01">
              <div id="us"></div></td>
            </tr>
             <?php if($tipof==2){?>
            <tr id="f5">
              <td class="cuadro02">MOSTRAR</td>
              <td align="center" class="cuadro02">: </td>
              <td class="cuadro01"><input name="radiopres" type="radio" id="radiopres0" value="0" checked="checked" />
                Todos 
                <input type="radio" name="radiopres" id="radiopres1" value="1" />
                Pr&eacute;stamos activos</td>
            </tr> <?php }?>
             <?php if($tipof==3){?>
            <tr id="f6">
              <td class="cuadro02">DEVOLUCIONES HASTA</td>
              <td align="center" class="cuadro02">:</td>
              <td class="cuadro01"><input type="text" name="txtFECHADEV" id="txtFECHADEV" /></td>
            </tr>
           <?php }?>
            
            <tr>
              <td colspan="3" >&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" align="right"><input type="button" name="button" id="button" value="Enviar Datos" onClick="valf()"></td>
              </tr>
            </table>
