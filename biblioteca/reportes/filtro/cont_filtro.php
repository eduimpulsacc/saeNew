<? session_start();
require("../../../util/header.php");
require("mod_filtro.php");

$funcion=$_POST['funcion'];
$obj_filtro = new Filtro();

if($funcion==1){
$rs_listado = $obj_filtro->libro($conn,$_INSTIT);
?>
<script type="text/javascript" src="../../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
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
     
	  $("#idLBR").val(ui.item.value);
	  
	//  veors();
	  
      }
	  
	  
      });
	  
	  
	 
  });
	</script>
    <select id="combobox"   >
              <option value=""></option>
              <?php for($l=0;$l<pg_numrows($rs_listado);$l++){
            $fila = pg_fetch_array($rs_listado,$l);?>
              <option value="<?php echo $fila['id_libro'] ?>"><?php echo $fila['titulo'] ?></option>
              <? }?>   
            </select>
            <input type="hidden" name="idLBR" id="idLBR">
<?
}
if($funcion==2){
	$rs_emp = $obj_filtro->traeEmp($conn,$_INSTIT);
	?>
<select name="cmb_usuario" id="cmb_usuario">
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
	$rs_cur = $obj_filtro->traeCurso($conn,$_ANO);
?>
<select name="cmb_curso" id="cmb_curso" onChange="traeNombre()">
<option value="0">Seleccione Curso</option>
<?php  for($e=0;$e<pg_numrows($rs_cur);$e++){
$fila_e = pg_fetch_array($rs_cur,$e); ?>
<option value="<?php echo $fila_e['id_curso'] ?> "><?php echo CursoPalabra($fila_e['id_curso'],0,$conn) ?> </option>
<?php }?>
</select>
<?
}if($funcion==4){
if($tipo==2){
	$rs_listado = $obj_filtro->traeApoCurso($conn,$curso);	
	}
elseif($tipo==3){
	$rs_listado = $obj_filtro->traeAluCurso($conn,$curso);	
	}
	
	?>
    <select name="cmb_usuario" id="cmb_usuario">
            <option value="0">Seleccione</option>
            <?php  for($e=0;$e<pg_numrows($rs_listado);$e++){
$fila_e = pg_fetch_array($rs_listado,$e); ?>
<option value="<?php echo $fila_e['rut'] ?> "><?php echo strtoupper($fila_e['nombre']) ?> </option>
<?php }?>
    </select>
    <?
}
if($funcion==5){

	if($tipo==1){
		$rs_listado = $obj_filtro->catego($conn,$_INSTIT);		
	}
	if($tipo==2){
		$rs_listado = $obj_filtro->editorial($conn,$_INSTIT);
	}
	if($tipo==3){
		$rs_listado = $obj_filtro->autor($conn,$_INSTIT);
	}
	
	?>
    <select name="cmb_fil" id="cmb_fil">
    <?php if($tipo>0){?>
    
     <?php  for($i=0;$i<pg_numrows($rs_listado);$i++){
		 $fila = pg_fetch_array($rs_listado,$i);
		 ?>
     <option value="<?php echo $fila['id'] ?>"><?php echo strtoupper($fila['nombre']) ?></option>
      <?php }?>
      
	  <?php }else{?>
       <option value="0" selected="selected">Todos</option>
      <?php }?>
    </select>
    <?
}

?>
 