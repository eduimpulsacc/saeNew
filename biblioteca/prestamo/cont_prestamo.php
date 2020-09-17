<?php 
session_start();
require("../../util/header.php");
 require("mod_prestamo.php");
 
 $funcion=$_POST['funcion'];
 
 $ob_prestamo = new Prestamo();


if($funcion==1){
	$rs_listado = $ob_prestamo->libro($conn,$_INSTIT);
	
	
	?>
    
    <script>
	(function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
		  .attr( "id", "txt" )
		  .attr( "onkeydown", "limpia()" )
		 
		  
         // .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
		   //.addClass( "select_redondo" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
       /*   .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })*/
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "Titulo", value + " no encontrado" )
          .tooltip( "open" );
		  
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.data( "ui-autocomplete" ).term = "";
		  $("#idLBR").val('');
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  $(function() {
      $( "#combobox" ).combobox({
      select: function( event, ui ) {
		 $("#idLBR").val(''); 
      //alert(ui.item.value);
	  veodisp(ui.item.value);
	  $("#idLBR").val(ui.item.value);
	  
	//  veors();
	  
      }
	  
	  
      });
	  
	  
	  $('.tp1').hide();
	  $('.tp2').hide();
	 
	  $('#bss').hide();
  });
	</script>
    
      <table width="95%" border="0" align="center">
        <tr>
          <td colspan="3" align="center" class="titulos-respaldo"><p>PRESTAMO DE LIBROS</p></td>
        </tr>
        <tr>
          <td width="11%">&nbsp;</td>
          <td width="3%" align="center">&nbsp;</td>
          <td width="86%">&nbsp;</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td class="cuadro02">Buscar</td>
          <td align="center" class="cuadro02">:</td>
          <td class="cuadro01"><select name="cmbTipo" id="cmbTipo" onChange="tipo(this.value)">
            <option value="0">Seleccione</option>
            <option value="1">Empleado</option>
            <option value="2">Apoderado</option>
            <option value="3">Alumno</option>
          </select></td>
          </tr>
        <tr class="tp1">
          <td class="cuadro02">Curso</td>
          <td align="center" class="cuadro02">:</td>
          <td class="cuadro01"><div id="cur">
            <select name="cmbCurso" id="cmbCurso">
              <option value="0">Seleccione Curso</option>
            </select>
          </div></td>
          </tr>
        <tr class="tp2">
          <td class="cuadro02">Nombre</td>
          <td align="center" class="cuadro02">:</td>
          <td class="cuadro01">
            <div id="nom">
              <select name="cmbRUT" id="cmbRUT">
                <option value="0">Seleccione</option>
              </select>
          </div></td>
          </tr>
        <tr class="tp2">
          <td class="cuadro02">RUT</td>
          <td align="center" class="cuadro02">&nbsp;</td>
          <td class="cuadro01"><label for="txt_rut"></label>
          <input type="text" name="txt_rut" id="txt_rut" onchange="existe();siBloqueo(2);" /></td>
        </tr>
        <tr >
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="right"><input type="button" name="bss" id="bss" value="Nuevo Pr&eacute;stamo" onclick="actp()" /></td>
          </tr>
        <tr class="tp2">
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
       
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td colspan="3"><div id="res"></div></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        <tr>
          <td colspan="3"><div id="lista"></div></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
        
      </table>
     

	<?
}
if($funcion==2){
$rs_emp = $ob_prestamo->traeEmp($conn,$rdb);
?>
<select name="cmbRUT" id="cmbRUT" onchange="veors();acpres();cam()">
 <option value="0">Seleccione</option>
         
<?
for($e=0;$e<pg_numrows($rs_emp);$e++){
	$fila_e = pg_fetch_array($rs_emp,$e);
	?>
 <option value="<?php echo $fila_e['rut_emp'] ?>"><?php echo strtoupper(sanear_string($fila_e['ape_pat']." ".$fila_e['ape_mat']." ".$fila_e['nombre_emp']));?></option>
    <?
	} 
	?>
	</select>
    <?
}
if($funcion==3){
	$rs_cur = $ob_prestamo->traeCurso($conn,$ano);
?>
<select name="cmbCurso" id="cmbCurso" onChange="traeNombre()">
<option value="0">Seleccione Curso</option>
<?php  for($e=0;$e<pg_numrows($rs_cur);$e++){
$fila_e = pg_fetch_array($rs_cur,$e); ?>
<option value="<?php echo $fila_e['id_curso'] ?>"><?php echo CursoPalabra($fila_e['id_curso'],0,$conn) ?> </option>
<?php }?>
</select>
<?
}
if($funcion==4){
if($tipo==2){
	$rs_listado = $ob_prestamo->traeApoCurso($conn,$curso);	
	}
elseif($tipo==3){
	$rs_listado = $ob_prestamo->traeAluCurso($conn,$curso);	
	}
	
	?>
    <select name="cmbRUT" id="cmbRUT" onchange="veors();acpres();siBloqueo(1);cam()">
            <option value="0">Seleccione</option>
            <?php  for($e=0;$e<pg_numrows($rs_listado);$e++){
$fila_e = pg_fetch_array($rs_listado,$e); ?>
<option value="<?php echo $fila_e['rut'] ?>"><?php echo strtoupper($fila_e['nombre']) ?> </option>
<?php }?>
    </select>
    <?
}
if($funcion==5){
$rdisp = $ob_prestamo->Ejemplares($conn,$id_libro);

	if(pg_numrows($rdisp)==0){
	?>
	<div class="titulos-respaldo" align="center"><p>SIN COPIAS DISPONIBLES</p></div>
	<?
	}else{
	?>
    
   <table width="60%" align="center">
  <tr class="cuadro02">
    <td width="6%">#</td>
    <td width="35%" align="center">C&oacute;digo</td>
    <td width="23%" align="center">Estado</td>
    <td width="23%" align="center">Usuario</td>
    <td width="25%" align="center">Fecha Devoluci&oacute;n</td>
    <td width="11%" align="center">Acciones</td>
    </tr>
    <?php for($l=0;$l<pg_numrows($rdisp);$l++){
		$filal = pg_fetch_array($rdisp,$l);
		if($filal['estado']==2){
		$rs_pres = $ob_prestamo->ejemplarPrestado($conn,$filal['id_ejemplar']);
		$fip = pg_fetch_array($rs_pres,0);
		$fecdev = CambioFD($fip['fecha_devolucion']);
		
		
				if($fip['tipo_usuario']==1){
					$r_us = $ob_prestamo->traeEmp1($conn,$fip['rut_usuario']);
				}
				elseif($fip['tipo_usuario']==2){
					$r_us = $ob_prestamo->traeApo1($conn,$fip['rut_usuario']);
				}
				elseif($fip['tipo_usuario']==3){
					$r_us = $ob_prestamo->traeAlu1($conn,$fip['rut_usuario']);
				}
				$us = pg_fetch_array($r_us,0);
		
		
		}
		$val = ($filal['rut_usuario']==$rut_usuario)?"R":"";
		
		?>
      <tr class="cuadro01">
        <td align="center"><?php echo ($l+1) ?></td>
        <td align="center"><?php echo $filal['codigo'] ?></td>
        <td align="center"><?php echo ($filal['estado']==1)?"Disponible":"En pr&eacute;stamo" ?></td>
        <td align="center"><?php echo ($filal['estado']==1)?"Disponible":"En pr&eacute;stamo" ?></td>
        <td align="center"><?php echo ($filal['estado']!=1)?$fecdev:""; ?></td>
        <td align="center"><?php if($filal['estado']==1)?>
         <?php if($filal['estado']==1){?>
       <input type="button" name="button" id="button" value="P" title="Efectuar Pr&eacute;stamo" onClick="prestar(<?php echo $filal['id_ejemplar'] ?>)">
       <?php  }else{?>
        
        <input type="submit" name="button3" id="button3" value="D" title="Devolver" onclick="cambio(<?php echo $fip['id_prestamo'] ?>,2)" />
        <?
        }?>
        
        </td>
        </tr>
  <?php }?>
  </table>
    <?	
	}
}
if($funcion==6){
	$rs_pres = $ob_prestamo->guardaPrestamo($conn,$id_ejemplar,$id_libro,CambioFE($fechadev),$rut,$tipou,$_ANO,1,$_INSTIT);
	echo ($rs_pres)?1:0;
	?>
    
    <?
}
if($funcion==7){
$rs_pres =$ob_prestamo->prestamoUsuario($conn,$rut_usuario,$_ANO);
$rs_reser =$ob_prestamo->reservaUsuario($conn,$rut_usuario,$_ANO);
$restric = $ob_prestamo->traeRes($conn,$_INSTIT);
$f_restric = pg_fetch_array($restric,0);
//ver si tengo cinfigurada las multas
	$rs_multa = $ob_prestamo->tengoMulta($conn,$_INSTIT);

?>

<table width="98%" align="center" class="tablaredonda">
<tr><td><br />
<br />
 <table width="80%" align="center">
 <?php if(pg_numrows($rs_pres)>0){
	 ?>
 <tr>
    <td colspan="6" class="titulos-respaldo" align="center"><p>PRESTAMOS ACTIVOS</p></td>
    </tr>
  <tr class="cuadro02">
  
    <td width="9%">#</td>
    <td width="39%" align="center">T&iacute;tulo</td>
    <td width="27%" align="center">Fecha Devoluci&oacute;n</td>
    
    <td colspan="3" align="center">Acciones</td>
    </tr>
  <?php   
  for($p=0;$p<pg_numrows($rs_pres);$p++){
	   $fila_pres = pg_fetch_array($rs_pres,$p);
	   $val = ($fila_pres['rut_usuario']==$rut_usuario)?"R":"";
	  ?>
  <tr class="cuadro01">
    <td><?php echo $p+1 ?></td>
    <td align="center"><?php echo $fila_pres['titulo'] ?></td>
    <td align="center"><?php echo CambioFD($fila_pres['fecha_devolucion']) ?></td>
    <?php if(pg_numrows($rs_multa)>0 && $fila_pres['estado_prestamo']==3){?>
    <td width="9%" align="center">
      <input name="" type="button" title="Pr&eacute;stamo multado" value="M" onClick="multa(<?php echo $fila_pres['id_prestamo'] ?>,<?php echo $fila_pres['id_ejemplar'] ?>)">
      </td>
    <?php }?>
     <td width="9%" align="center"><input type="button" name="D" class="relo" id="D" value="R" title="Renovar" onclick="cambio(<?php echo $fila_pres['id_prestamo'] ?>,1)" /></td>
    <td width="7%" align="center"><input type="submit" name="button3" id="button3" value="D" title="Devolver" onclick="cambio(<?php echo $fila_pres['id_prestamo'] ?>,2)" /></td>
    
  </tr>
  <?php }?>
  <?php }else{?>
  <tr>
    <td colspan="6" class="titulos-respaldo" align="center"><p>SIN PRESTAMOS ACTIVOS</p></td>
    </tr>
  <?php }?>
  <?php if(pg_numrows($rs_reser)>0){?>
 <tr>
    <td colspan="6" class="titulos-respaldo" align="center"><p>RESERVAS PENDIENTES</p></td>
    </tr>
  <tr class="cuadro02">
    <td width="9%">#</td>
    <td width="39%" align="center">T&iacute;tulo</td>
    <td width="27%" align="center">Fecha Reserva</td>
   
    <td colspan="2" align="center">Acciones</td>
    </tr>
     <?php  for($r=0;$r<pg_numrows($rs_reser);$r++){
		$fila_rese = pg_fetch_array($rs_reser,$r);
		 ?>
  <tr class="cuadro01">
    <td><?php echo $r+1 ?></td>
    <td align="center"><?php echo $fila_rese['titulo'] ?></td>
    <td align="center"><?php echo CambioFD($fila_rese['fecha_reserva']) ?></td>
    <td align="center"><input type="button" name="button2" class="bp" id="bpre_<?php echo $fila_rese['id_reserva'] ?>" value="P" title="EFECTUAR PRESTAMO" onclick="prestarl(<?php echo $fila_rese['id_reserva'] ?>)" /></td>
    <td align="center"><input type="button" name="button2" id="button2" value="A" title="ANULAR RESERVA" onclick="anular(<?php echo $fila_rese['id_reserva'] ?>)" /></td>
  </tr>
 <?php  }?>
   <?php }else{?>
  <tr>
    <td colspan="6" class="titulos-respaldo" align="center"><p>SIN RESERVAS PRENDIENTES</p></td>
    </tr>
  <?php }?>
    </table>
 <br />
 <br />
    </td></tr></table>
<?
}if($funcion==8){
	$rs_anula =$ob_prestamo->anula($conn,$idr);
}
if($funcion==9){
	//revisar si ya tengo prestamo
	
	$rs_reserva = $ob_prestamo->reservaUno($conn,$idr);
	$fila_r = pg_fetch_array($rs_reserva,0);
	$rs_stck = $ob_prestamo->stockLibro($conn,$fila_r['id_libro']); // stock disponible
	$rs_pres = $ob_prestamo->prestamoUsuario($conn,$usuario,$_ANO); //prestamos activos
	$rs_lpres = $ob_prestamo->libroPrestado($conn,$usuario,$_ANO,$fila_r['id_libro']);
	$restric = $ob_prestamo->traeRes($conn,$_INSTIT);
	$f_restric = pg_fetch_array($restric,0);
	
if(pg_numrows($rs_stck)==0){
	$rs_fd = $ob_prestamo->minprestamo($conn,$fila_r['id_libro']);
	$fecha = pg_result($rs_fd,4);
	echo CambioFD($fecha);
	//echo 3;
}
elseif(pg_numrows($rs_lpres)>0){
		echo 3;
}
elseif(pg_numrows($rs_pres)==3){
		echo 2;
}

elseif(pg_numrows($rs_stck)>0 && pg_numrows($rs_pres)<3){
	echo 0;
	?>

    <?
}
}
if($funcion==10){
	$rs_pres = $ob_prestamo->prestamoUsuario($conn,$usuario,$_ANO); //prestamos activos
	$rs_mul = $ob_prestamo->multaUsuario($conn,$_ANO,$usuario);
	if(pg_numrows($rs_pres)>=3){
		echo 0;
	}
	elseif(pg_numrows($rs_mul)>0){
		echo 2;
		}
	else{
	echo 1;
	}
	
	
	
}
if($funcion==11){
	$rs_listado = $ob_prestamo->libro($conn,$_INSTIT);
	$rs_listadoAutor = $ob_prestamo->autor($conn,$_INSTIT);
	$rs_listadoMateria = $ob_prestamo->categoria($conn,$_INSTIT);
	?>
    <script>
	
	$(document).ready(function(){
		
	$("#txt_cb").focus();
	
	var d = new Date();
    var dd = (d<10)?("0"+d.getDate()):d.getDate();
	var mm = (d.getMonth()+1);
	
	
	
	 $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');			
          });
	
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
		    firstDay: 1,
			beforeShowDay: $.datepicker.noWeekends 
			
		});

  });
	
	
	(function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
		  .attr( "id", "txt" )
		  .attr( "onkeydown", "limpia()" )
		  .attr( "onblur", "buscaDis()" )
         // .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
		   //.addClass( "select_redondo" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
       
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "Titulo", value + " no encontrado" )
          .tooltip( "open" );
		  
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.data( "ui-autocomplete" ).term = "";
		  $("#idLBR").val('');
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
	
	//combo 2
	
    $.widget( "custom.combobox2", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
		  .attr( "id", "txt" )
		  .attr( "onkeydown", "limpia2()" )
		  .attr( "onblur", "buscaDis()" )
         // .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
		   //.addClass( "select_redondo" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
       
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "Autor", value + " no encontrado" )
          .tooltip( "open" );
		  
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.data( "ui-autocomplete" ).term = "";
		  $("#idAUT").val('');
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
	
	
	
  //combo 3
	$.widget( "custom.combobox3", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox2" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
		  .attr( "id", "txt" )
		  .attr( "onkeydown", "limpia3()" )
		  .attr( "onblur", "buscaDis()" )
         // .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
		   //.addClass( "select_redondo" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "Materia", value + " no encontrada" )
          .tooltip( "open" );
		  
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.data( "ui-autocomplete" ).term = "";
		$("#idMAT").val('');
			  // limpia3();
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
	
  })( jQuery );
 
  $(function() {
      $( "#combobox" ).combobox({
      select: function( event, ui ) {
		 $("#idLBR").val(''); 
      	  $("#idLBR").val(ui.item.value);
	    }
	   });
	  
	  $( "#combobox2" ).combobox2({
      select: function( event, ui ) {
	 $("#idAUT").val(ui.item.value);
	  //dsp(ui.item.value);
      }
	   });

	$( "#combobox3" ).combobox3({
      select: function( event, ui ) {
	 $("#idMAT").val(ui.item.value);
	  //dsp(ui.item.value);
      }
	   });
	 
  });
	</script>
   
<table width="98%"  align="center"  class="tablaredonda">
  <tr>
    <td colspan="7" class="titulos-respaldo" align="center"><p>PRESTAMO DE LIBROS</p></td>
  </tr>
  <tr>
    <td width="8%">&nbsp;</td>
    <td width="8%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
    <td width="74%">&nbsp;</td>
    <td width="15%" colspan="3">&nbsp;</td>
  </tr>
   <tr >
     <td>&nbsp;</td>
     <td class="cuadro02">C&oacute;digo</td>
     <td align="center" class="cuadro02">:</td>
     <td class="cuadro01"><label for="txt_cb"></label>
     <input type="text" name="txt_cb" id="txt_cb" onchange="disporcod()" onblur="disporcod()" class="solo-numero"  /></td>
     <td>&nbsp;</td>
   </tr>
   <tr >
    <td>&nbsp;</td>
          <td class="cuadro02">Libro</td>
          <td align="center" class="cuadro02">:</td>
          <td class="cuadro01"> 
          <div id="nomlibro">
            <select id="combobox"   >
              <option value=""></option>
              <?php for($l=0;$l<pg_numrows($rs_listado);$l++){
            $fila = pg_fetch_array($rs_listado,$l);?>
              <option value="<?php echo $fila['id_libro'] ?>"><?php echo $fila['titulo'] ?></option>
              <? }?>   
            </select>
            </div>
            <input type="hidden" name="idLBR" id="idLBR"  >
          </td>
           <td>&nbsp;</td>
  </tr>
   <tr >
     <td>&nbsp;</td>
     <td class="cuadro02">Autor</td>
         <td align="center" class="cuadro02">:</td>
         <td class="cuadro01"><span id="cmb2">
            <select id="combobox2" >
              <option value=""></option>
              <?php for($a=0;$a<pg_numrows($rs_listadoAutor);$a++){
            $fila_a = pg_fetch_array($rs_listadoAutor,$a);?>
              <option value="<?php echo $fila_a['id_autor'] ?>"><?php echo $fila_a['nombre'] ?></option>
              <? }?>   
            </select>
            </span>
           <input type="hidden" name="idAUT" id="idAUT" ></td>
           <td>&nbsp;</td>
   </tr>
   <tr >
     <td>&nbsp;</td>
     <td class="cuadro02">Materia</td>
         <td align="center" class="cuadro02">&nbsp;</td>
         <td class="cuadro01"><span id="cmb3">
         <select id="combobox3" >
              <option value=""></option>
              <?php for($m=0;$m<pg_numrows($rs_listadoMateria);$m++){
            $fila_m = pg_fetch_array($rs_listadoMateria,$m);?>
           <option value="<?php echo $fila_m['id_categoria'] ?>"><?php echo $fila_m['nombre'] ?></option>
              <? }?>   
         </select>
            </span>
           <input type="hidden" name="idMAT" id="idMAT" ></td>
           <td>&nbsp;</td>
   </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="cuadro02">Fecha de Devoluci&oacute;n&nbsp;&nbsp;&nbsp;</td>
    <td align="center" class="cuadro02">:</td>
    <td class="cuadro01"><input type="text" name="txtFECHADEV" class="" id="txtFECHADEV" readonly placeholder="Seleccione Fecha" ></td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div id="lisbr"></div></td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;
  </td></tr>
    </table>
<?
}if($funcion==12){
	$rs_listado = $ob_prestamo->prestamoUno($conn,$idp);
	$fila = pg_fetch_array($rs_listado,0);
	
	if($tipo==2){
		$rs_ace = $ob_prestamo->dejemplar($conn,$fila['id_ejemplar']);
		$rs_acp = $ob_prestamo->dprestamo($conn,$idp);
		
		
		//si lo entregue atrasado, a calcular los dias de bloqueo, si es que está configurado el bloqueo.
		$lim = $ob_prestamo->haybloqueo($conn,$_INSTIT);
		if(pg_numrows($lim)>0 && pg_result($lim,0)>0){
		
			if($fila['fecha_devolucion']<date("Y-m-d")){
				//echo "fecha_devolucion = ".$fila['fecha_devolucion'];
				$habiles= hbl($fila['fecha_devolucion'], date("Y-m-d"));
				$rs_feriadosano = $ob_prestamo->Cuentaferiados($conn,$_ANO,$fila['fecha_devolucion'],date("Y-m-d"));
				
		for($ff=0;$ff<pg_numrows($rs_feriadosano);$ff++){
			$fila_feriadoano =pg_fetch_array($rs_feriadosano,$ff);
			
			$inciof= $fila_feriadoano['fecha_inicio'];
			
				if($fila_feriadoano['fecha_fin']==NULL)
				{
				$finf=$inciof ;
				
				}else{
				
				$finf= $fila_feriadoano['fecha_fin'];
				}
				
				$fera=$fera+$dif_dias =ddiff($inciof, $finf);
				
				}
			
			} 
			
			 $diasbloqueo = ($habiles-$fera)*pg_result($lim,0);
			
			$nuevafecha = strtotime ( '+'.$diasbloqueo.' day' , strtotime ( $fila['fecha_devolucion'] ) ) ;
			$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
			//echo $nuevafecha;
			//ahora a crear el bloqueo
			$ob_prestamo->bloquearUsuario($conn,$fila['rut_usuario'],$_INSTIT,$_ANO,$idp,$fila['fecha_devolucion'],$nuevafecha,1);
		}
		
	}
	elseif($tipo==1){
	
		?>
        <script>
$(document).ready(function(){
	
	
	
	var d = new Date();
    var dd = (d<10)?("0"+d.getDate()):d.getDate();
	var mm = (d.getMonth()+1);
	
	
	
	$("#txtFECHADEV2").datepicker({
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
		    firstDay: 1,
			beforeShowDay: $.datepicker.noWeekends 
			
		});

  });
</script>
        <input type="hidden" name="idp" id="idp" value="<?php echo $idp ?>" />
        <table>
<tr>
<td class="cuadro02">Fecha devoluci&oacute;n</td><td class="cuadro02">:</td>
<td><input type="text" name="txtFECHADEV2" class="" id="txtFECHADEV2" readonly placeholder="Seleccione Fecha" ></td>
</tr>
</table>
        <?
	}
}

if($funcion==13){
show($_POST);
$rs_listado = $ob_prestamo->prestamoUno($conn,$idp);
$fila = pg_fetch_array($rs_listado,0);
$id_ejemplar = $fila['id_ejemplar'];
$id_libro = $fila['id_libro'];
$rut_usuario = $fila['rut_usuario'];
$tipou = $fila['tipo_usuario'];
$id_ano = $fila['id_ano'];
$rs_guarda =$ob_prestamo->guardaPrestamo($conn,$id_ejemplar,$id_libro,CambioFE($fecha),$rut_usuario,$tipou,$id_ano,2);
$rs_acp = $ob_prestamo->dprestamo($conn,$idp);
}

if($funcion==14){
	$rs_reserva = $ob_prestamo->reservaUno($conn,$res);
	$fila_r = pg_fetch_array($rs_reserva,0);
	$rs_ejm =  $ob_prestamo->minejemplar($conn,$fila_r['id_libro']);
	$fila_e = pg_fetch_array($rs_ejm,0);
	
	?>
    <script>
$(document).ready(function(){
	
	var d = new Date();
    var dd = (d<10)?("0"+d.getDate()):d.getDate();
	var mm = (d.getMonth()+1);
	
	
	
	$("#txtFECHADEV2").datepicker({
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
		    firstDay: 1,
			beforeShowDay: $.datepicker.noWeekends 
			
		});

  });
</script>
       <input type="hidden" name="id_libr" id="id_libr" value="<?php echo $fila_r['id_libro'] ?>" />
<input type="hidden" name="id_rss" id="id_rss" value="<?php echo $fila_r['id_reserva'] ?>" />
<input name="" type="hidden" id="id_ejmp" value="<?php echo $fila_e['id_ejemplar'] ?>" />
<input name="" type="hidden" id="rut_us" value="<?php echo $fila_r['rut_usuario'] ?>" />
<input name="" type="hidden" id="ti_us" value="<?php echo $fila_r['tipo_usuario'] ?>"/>
        <table>
<tr>
<td class="cuadro02">Fecha devoluci&oacute;n</td><td class="cuadro02">:</td>
<td><input type="text" name="txtFECHADEV2" class="" id="txtFECHADEV2" readonly placeholder="Seleccione Fecha" ></td>
</tr>
</table>
    <?
	
	
}

if($funcion==15){
$rs_pres = $ob_prestamo->guardaPrestamo($conn,$ejemplar,$libro,CambioFE($fecha),$rut,$tipo,$_ANO,1);
	
$rs_cmb = $ob_prestamo->cambiores($conn,$res);
}
if($funcion==16){
$rs = $ob_prestamo->codigoEjemplar($conn,$cod);
$fila_eje = pg_fetch_array($rs,0);

echo $fila_eje['id_libro']."^".$fila_eje['titulo'];

}
if($funcion==17){
$rdisp = $ob_prestamo->EjemplaresUno($conn,$_POST['id_libro'],$_POST['id_ejemplar']);

	if(pg_numrows($rdisp)==0){
	?>
	<div class="titulos-respaldo" align="center"><p>SIN COPIAS DISPONIBLES</p></div>
	<?
	}else{
	?>
    
   <table width="90%" align="center">
  <tr class="cuadro02">
    <td width="6%">#</td>
    <td width="35%" align="center">T&iacute;tulo</td>
    <td width="35%" align="center">C&oacute;digo</td>
    <td width="23%" align="center">Estado</td>
    <td width="23%" align="center">Usuario</td>
    <td width="25%" align="center">Fecha Devoluci&oacute;n</td>
    <td width="11%" align="center">Acciones</td>
    </tr>
    <?php for($l=0;$l<pg_numrows($rdisp);$l++){
		$filal = pg_fetch_array($rdisp,$l);
		if($filal['estado']==2){
		$rs_pres = $ob_prestamo->ejemplarPrestado($conn,$filal['id_ejemplar']);
		$fip = pg_fetch_array($rs_pres,0);
		$fecdev = CambioFD($fip['fecha_devolucion']);
		
		
				if($fip['tipo_usuario']==1){
					$r_us = $ob_prestamo->traeEmp1($conn,$fip['rut_usuario']);
				}
				elseif($fip['tipo_usuario']==2){
					$r_us = $ob_prestamo->traeApo1($conn,$fip['rut_usuario']);
				}
				elseif($fip['tipo_usuario']==3){
					$r_us = $ob_prestamo->traeAlu1($conn,$fip['rut_usuario']);
				}
				$us = pg_fetch_array($r_us,0);
		
		
		}
		$val = ($filal['rut_usuario']==$rut_usuario)?"R":"";
		
		?>
      <tr class="cuadro01">
        <td align="center"><?php echo ($l+1) ?></td>
        <td align="center"><?php echo $filal['titulo'] ?></td>
        <td align="center"><?php echo $filal['codigo'] ?></td>
        <td align="center"><?php echo ($filal['estado']==1)?"Disponible":"En pr&eacute;stamo" ?></td>
        <td align="center"><?php echo ($filal['estado']!=1)?$us['nombre']:"" ?></td>
        <td align="center"><?php echo ($filal['estado']!=1)?$fecdev:""; ?></td>
        <td align="center"> <?php if($filal['estado']==1){?>
       <input type="button" name="button" id="button" value="P" title="Efectuar Pr&eacute;stamo" onClick="prestar(<?php echo $filal['id_ejemplar'] ?>)">
       <?php  }else{?>
        
        <input type="submit" name="button3" id="button3" value="D" title="Devolver" onclick="cambio(<?php echo $fip['id_prestamo'] ?>,2)" />
        <?
        }?></td>
        </tr>
  <?php }?>
  </table>
    <?	
	}
}
if($funcion==18){
	if($rut!=""){
	if($tipo==1){
		//empleado
		$rs_us = $ob_prestamo->existeEmp($conn,$_INSTIT,$rut);
		}
	if($tipo==2){
		//apoderadp
		$rs_us = $ob_prestamo->existeApo($conn,$_ANO,$rut);
		}
	if($tipo==3){
		//alumno
		$rs_us = $ob_prestamo->existeAlu($conn,$_ANO,$rut);
		}
		echo (pg_numrows($rs_us)>0)?1:0;
	}
}
if($funcion==19){
$conc ="";

if($lbr!="" && $aut!=""  && $mat!="" ){
	$conc = "and (e.id_libro=$lbr or a.id_autor= $aut or c.id_categoria= $mat)";
}

elseif($lbr!="" && $aut==""  && $mat!="" ){
	$conc = "and (e.id_libro=$lbr or c.id_categoria= $mat)";
}

elseif($lbr!="" && $aut==""  && $mat=="" ){
	$conc = "and (e.id_libro=$lbr)";
}

elseif($lbr!="" && $aut==""  && $mat!="" ){
	$conc = "and (e.id_libro=$lbr or c.id_categoria= $mat)";
}

elseif($lbr=="" && $aut!=""  && $mat!="" ){
	$conc = "and (or a.id_autor=$aut c.id_categoria= $mat)";
}

elseif($lbr=="" && $aut!=""  && $mat=="" ){
	$conc = "and (a.id_autor=$aut)";
}

elseif($lbr=="" && $aut==""  && $mat!="" ){
	$conc = "and (c.id_categoria= $mat)";
}
 
 //echo $conc;

$rdisp = $ob_prestamo->titDisponible($conn,$_INSTIT,$conc);
if(pg_numrows($rdisp)==0){
	?>
	<div class="titulos-respaldo" align="center"><p>SIN COPIAS DISPONIBLES</p></div>
	<?
	}else{
	?>
    
   <table width="90%" align="center">
  <tr class="cuadro02">
    <td width="6%">#</td>
    <td width="35%" align="center">T&iacute;tulo</td>
    <td width="35%" align="center">C&oacute;digo</td>
    <td width="23%" align="center">Estado</td>
    <td width="23%" align="center">Usuario</td>
    <td width="25%" align="center">Fecha Devoluci&oacute;n</td>
    <td width="11%" align="center">Acciones</td>
    </tr>
    <?php for($l=0;$l<pg_numrows($rdisp);$l++){
		$filal = pg_fetch_array($rdisp,$l);
		if($filal['estado']==2){
		$rs_pres = $ob_prestamo->ejemplarPrestado($conn,$filal['id_ejemplar']);
		$fip = pg_fetch_array($rs_pres,0);
		$fecdev = CambioFD($fip['fecha_devolucion']);
		
		
				if($fip['tipo_usuario']==1){
					$r_us = $ob_prestamo->traeEmp1($conn,$fip['rut_usuario']);
				}
				elseif($fip['tipo_usuario']==2){
					$r_us = $ob_prestamo->traeApo1($conn,$fip['rut_usuario']);
				}
				elseif($fip['tipo_usuario']==3){
					$r_us = $ob_prestamo->traeAlu1($conn,$fip['rut_usuario']);
				}
				$us = pg_fetch_array($r_us,0);
		
				//$rs_pres2 =$ob_prestamo->prestamoUsuario($conn,$us['rut_usuario'],$_ANO);	
		
		}
		$val = ($filal['rut_usuario']==$rut_usuario)?"R":"";
		
		?>
      <tr class="cuadro01">
        <td align="center"><?php echo ($l+1) ?></td>
        <td align="center"><?php echo $filal['titulo'] ?></td>
        <td align="center"><?php echo $filal['codigo'] ?></td>
        <td align="center"><?php echo ($filal['estado']==1)?"Disponible":"En pr&eacute;stamo" ?></td>
        <td align="center"><?php echo ($filal['estado']!=1)?$us['nombre']:"" ?></td>
        <td align="center"><?php echo ($filal['estado']!=1)?$fecdev:""; ?></td>
        <td align="center"><?php if($filal['estado']==1)?>
        <?php if($filal['estado']==1){?>
        <input type="button" name="button" id="button" value="P" title="Efectuar Pr&eacute;stamo" onClick="prestar2(<?php echo $filal['id_ejemplar'] ?>,<?php echo $filal['id_libro'] ?>)">
       <?php  }else{?>
        
        <input type="submit" name="button3" id="button3" value="D" title="Devolver" onclick="cambio(<?php echo $fip['id_prestamo'] ?>,2)" />
        <?
        }?></td>
        </tr>
  <?php }?>
  </table>
    <?	
	}
	
}
if($funcion==20){
	//show($_POST);
	$sib = $ob_prestamo->usuarioBloqueado($conn,$_ANO,$_INSTIT,$rut,1);
	if(pg_numrows($sib)>0){
	$filb = pg_fetch_array($sib,0);
	echo "Usuario no tiene permitido solicitar libros hasta ".CambioFD($filb['fecha_hasta']);
	}
	else{
	echo 1;
	}
}
?>