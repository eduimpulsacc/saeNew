<?php 
session_start();
require("../../util/header.php");
 require("mod_reserva.php");
 
 $funcion=$_POST['funcion'];
 
 $ob_reserva = new Reserva();
 
if($funcion==1){
?>
<script>
$( document ).ready(function() {
   $('.tp1').hide();
	  $('.tp2').hide();
	   $('#nr').hide();
 
   
});
</script>
 <table width="95%" border="0" align="center">
        <tr>
          <td colspan="3" align="center" class="titulos-respaldo"><p>RESERVA DE LIBROS</p></td>
        </tr>
        <tr>
          <td width="10%">&nbsp;</td>
          <td width="2%" align="center">&nbsp;</td>
          <td width="88%">&nbsp;</td>
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
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
   </tr>
        <tr class="tp2">
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="right"><input type="button" id="nr"  value="Nueva Reserva" onclick="creares()" class="botonXX"/></td>
   </tr>
<!--        <tr>
          <td class="cuadro02">Libro</td>
          <td align="center" class="cuadro02">:</td>
          <td class="cuadro01"> 
            <select id="combobox" >
              <option value=""></option>
              <?php for($l=0;$l<pg_numrows($rs_listado);$l++){
            $fila = pg_fetch_array($rs_listado,$l);?>
              <option value="<?php echo $fila['id_libro'] ?>"><?php echo $fila['titulo'] ?></option>
              <? }?>   
            </select>
            <input type="hidden" name="idLBR" id="idLBR">
          </td>
   </tr>
-->
        <tr>
          <td class="">&nbsp;</td>
          <td align="center" class="">&nbsp;</td>
          <td class="">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" class=""><div id="lista"></div></td>
        </tr>
        <tr>
          <td colspan="3" class="">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" class=""><div id="rr"></div></td>
        </tr>
    </table>
<?
} if($funcion==2){
$rs_emp = $ob_reserva->traeEmp($conn,$rdb);
?>
<select name="cmbRUT" id="cmbRUT"  onchange="rsv()">
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
	$rs_cur = $ob_reserva->traeCurso($conn,$ano);
?>
<select name="cmbCurso" id="cmbCurso" onChange="traeNombre()">
<option value="0">Seleccione Curso</option>
<?php  for($e=0;$e<pg_numrows($rs_cur);$e++){
$fila_e = pg_fetch_array($rs_cur,$e); ?>
<option value="<?php echo $fila_e['id_curso'] ?> "><?php echo CursoPalabra($fila_e['id_curso'],0,$conn) ?> </option>
<?php }?>
</select>
<?
}
if($funcion==4){
if($tipo==2){
	$rs_listado = $ob_reserva->traeApoCurso($conn,$curso);	
	}
elseif($tipo==3){
	$rs_listado = $ob_reserva->traeAluCurso($conn,$curso);	
	}
	
	?>
    <select name="cmbRUT" id="cmbRUT" onchange="rsv()">
            <option value="0">Seleccione</option>
            <?php  for($e=0;$e<pg_numrows($rs_listado);$e++){
$fila_e = pg_fetch_array($rs_listado,$e); ?>
<option value="<?php echo $fila_e['rut'] ?>"><?php echo strtoupper($fila_e['nombre']) ?> </option>
<?php }?>
    </select>
    <?
}
if($funcion==5){
	$restric = $ob_reserva->traeRes($conn,$_INSTIT);
	$f_restric = pg_fetch_array($restric,0);
	$rs_listado = $ob_reserva->listaReserva($conn,$rut,$_INSTIT,$_ANO);
	if(pg_numrows($rs_listado)>0){
		if(pg_numrows($rs_listado)<$f_restric['lim_reservas']){
			?>
            <script>
			 $('#nr').show();
			</script>
            <?
			}
		else{
			?>
<script>
			$('#nr').hide();
			alert("USUARIO ALCANZO LIMITE DE RESERVAS SIMULTANEAS.");
			 
			</script>
            <?
		}
		
	?>
    
    <table width="95%" align="center">
 <tr>
    <td colspan="7" class="titulos-respaldo" align="center"><p>RESERVAS PENDIENTES</p></td>
    </tr>
  <tr class="cuadro02">
    <td width="4%" align="center">#</td>
    <td width="15%" align="center">Nro. Reserva</td>
    <td width="31%" align="center">T&iacute;tulo</td>
    <td width="14%" align="center">Fecha Reserva</td>
    <td width="25%" align="center">Usuario</td>
    <td width="11%" colspan="2" align="center">Acciones</td>
    </tr>
    <?php for($r=0;$r<pg_numrows($rs_listado);$r++){
		$fr = pg_fetch_array($rs_listado,$r);
		
		//$ob_reserva->traeEmpUno($conn,$fr['rut_usuario']);
		
		if($fr['tipo_usuario']==1){
			$r_us = $ob_reserva->traeEmpUno($conn,$fr['rut_usuario']);
		}
		elseif($fr['tipo_usuario']==2){
			$r_us = $ob_reserva->traeApoUno($conn,$fr['rut_usuario']);
		}
		elseif($fr['tipo_usuario']==3){
			$r_us = $ob_reserva->traeAluUno($conn,$fr['rut_usuario']);
			
		}
		$fusu = pg_fetch_array($r_us,0);
		
		?>
  <tr class="cuadro01">
    <td align="center"><?php echo $r+1?></td>
    <td align="center"><?php echo $fr['id_reserva'] ?></td>
    <td align="center"><?php echo $fr['titulo'] ?></td>
    <td align="center"><?php echo CambioFD($fr['fecha_reserva']) ?></td>
    <td align="center"><?php echo $fusu['nombre'] ?></td>
    <td align="center"><input type="button" name="button2" class="bp botonXX" id="bpre_<?php echo $fr['id_reserva'] ?>" value="P" title="EFECTUAR PRESTAMO" onclick="prestar(<?php echo $fr['id_reserva'] ?>)" /></td>
    <td align="center"><input type="button" name="button2" id="button2" value="A" title="ANULAR RESERVA" onclick="anular(<?php echo $fr['id_reserva'] ?>)" class="botonXX"/></td>
  </tr>
  <?php }?>
    </table>
    <?
}else{
	?>
    
<script>
			 $('#nr').show();
			</script>
            
    <div class="titulos-respaldo" align="center"><p>SIN RESERVAS PENDIENTES</p></div>
    <?
	}
}

if ($funcion==7){
	//$r_dup = $ob_reserva->reservaDuplicada($conn,$rut_usuario,$id_libro,$id_ano);
	
    	$rs_listado = $ob_reserva->libro($conn,$_INSTIT);
?>
<script>
$(document).ready(function(){
	
	var d = new Date();
    var dd = (d<10)?("0"+d.getDate())+1:d.getDate()+1;
	var mm = (d.getMonth()+1);
	$("#buttonr").hide();
	$("#ffe").hide();
	
	
	$("#txtFECHARES").datepicker({
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
			beforeShowDay: $.datepicker.noWeekends,
			   onSelect: function(dateText, inst) {
				$("#buttonr").show();
                }
   
			
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
	 $("#idLBR").val(ui.item.value);
	  dsp(ui.item.value);
      }
	  
	  
      });
	  
	  
	 
  });
  
  
  
	</script>
    <table width="98%"  align="center">
  
   <tr>
          <td width="16%" class="cuadro02">Libro</td>
          <td align="center" class="cuadro02">:</td>
          <td width="82%" class="cuadro01"> 
          <span id="cmb">
            <select id="combobox" >
              <option value=""></option>
              <?php for($l=0;$l<pg_numrows($rs_listado);$l++){
            $fila = pg_fetch_array($rs_listado,$l);?>
              <option value="<?php echo $fila['id_libro'] ?>"><?php echo $fila['titulo'] ?></option>
              <? }?>   
            </select>
            </span>
            <input type="hidden" name="idLBR" id="idLBR">
     </td>
   </tr>
   <tr id="ffe">
    
    <td class="cuadro02">Fecha de Reserva</td>
    <td align="center" class="cuadro02">:</td>
    <td class="cuadro01"><input type="text" name="txtFECHARES" class="" id="txtFECHARES" readonly placeholder="Seleccione Fecha" ></td>
    
    </tr>
   <tr>
    
     <td colspan="3">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="3" align="right" ><input type="button" name="buttonr" id="buttonr" value="Reservar libro" onclick="reserva()"  class="botonXX"/></td>
    
   </tr>
 
</table>
  </td></tr>
    </table>
    <?
}if($funcion==8){
//ver si tiene reservas duplicadas con ese libro
$rs_dup = $ob_reserva->reservaDuplicada($conn,$rut,$lbr,$_ANO);
$rs_stck = $ob_reserva->stockLibro($conn,$lbr);
if(pg_numrows($rs_dup)>0){
	echo 2;
}
elseif(pg_numrows($rs_stck)==0){
	$rs_fd = $ob_reserva->minprestamo($conn,$lbr);
	$fecha = pg_result($rs_fd,4);
	echo CambioFD($fecha);
	//echo 3;
}
else {echo 0;}
}
if($funcion==9){
$rs_guarda = $ob_reserva->guardaReserva($conn,$lbr,$rut,$_ANO,$_INSTIT,$fecha_reserva,$tip);
}
if($funcion==10){
	$rs_anula =$ob_reserva->anula($conn,$idr);
}
if($funcion==11){
	$rs_reserva = $ob_reserva->reservaUno($conn,$idr);
	$fila_r = pg_fetch_array($rs_reserva,0);
	$rs_stck = $ob_reserva->stockLibro($conn,$fila_r['id_libro']); // stock disponible
	$rs_pres = $ob_reserva->prestamosUsu($conn,$fila_r['rut_usuario'],$_ANO); //prestamos activos
	$restric = $ob_reserva->traeRes($conn,$_INSTIT);
	$f_restric = pg_fetch_array($restric,0);
	
if(pg_numrows($rs_stck)==0){
	$rs_fd = $ob_reserva->minprestamo($conn,$fila_r['id_libro']);
	$fecha = pg_result($rs_fd,4);
	echo CambioFD($fecha);
	//echo 3;
}
elseif($f_restric['lim_prestamo']>0){
		echo 2;
}
elseif(pg_numrows($rs_stck)>0 && pg_numrows($rs_pres)< 3){
	echo 0;
	?>

    <?
}
}
if($funcion==12){
	$rs_reserva = $ob_reserva->reservaUno($conn,$idr);
	$fila_r = pg_fetch_array($rs_reserva,0);
	$rs_ejm =  $ob_reserva->minejemplar($conn,$fila_r['id_libro']);
	$fila_e = pg_fetch_array($rs_ejm,0);
?>
<input type="hidden" name="id_libr" id="id_libr" value="<?php echo $fila_r['id_libro'] ?>" />
<input type="hidden" name="id_rss" id="id_rss" value="<?php echo $fila_r['id_reserva'] ?>" />
<input name="" type="hidden" id="id_ejmp" value="<?php echo $fila_e['id_ejemplar'] ?>" />
<input name="" type="hidden" id="rut_us" value="<?php echo $fila_r['rut_usuario'] ?>" />
<input name="" type="hidden" id="ti_us" value="<?php echo $fila_r['tipo_usuario'] ?>"/>
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

<table>
<tr>
<td class="cuadro02">Fecha devoluci&oacute;n</td><td class="cuadro02">:</td>
<td><input type="text" name="txtFECHADEV2" class="" id="txtFECHADEV2" readonly placeholder="Seleccione Fecha" ></td>
</tr>
</table>
<?
}
if($funcion==13){
	 
	$rs_pres = $ob_reserva->guardaPrestamo($conn,$ejemplar,$libro,CambioFE($fecha),$rut,$tipo);
	
	$rs_cmb = $ob_reserva->cambiores($conn,$res);
}
?>