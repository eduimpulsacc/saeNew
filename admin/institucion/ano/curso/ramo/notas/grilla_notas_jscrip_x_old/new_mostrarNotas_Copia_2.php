<?
//header( 'Content-Type: text/html;charset=utf-8' ); 
require('../../../../../../../util/header.inc');

echo pg_dbname();
echo $_ANO;
//if($_PERFIL==0) echo "ECHO PERFIL =>".$_PERFIL;





function ObtenerNavegador($user_agent) {  
     $navegadores = array(  
          'Opera' => 'Opera', 
		  'Chrome'=> 'Chrome', 
          'Mozilla Firefox'=> '(Firebird)|(Firefox)',  
          'Galeon' => 'Galeon',  
          'Mozilla'=>'Gecko',  
          'MyIE'=>'MyIE',  
          'Lynx' => 'Lynx',  
          'Netscape' => '(Mozilla/4\.75)|(Netscape6)|(Mozilla/4\.08)|(Mozilla/4\.5)|(Mozilla/4\.6)|(Mozilla/4\.79)',  
          'Konqueror'=>'Konqueror',  
		  'Internet Explorer 8' => '(MSIE 8\.[0-9]+)',  
          'Internet Explorer 7' => '(MSIE 7\.[0-9]+)',  
          'Internet Explorer 6' => '(MSIE 6\.[0-9]+)',  
          'Internet Explorer 5' => '(MSIE 5\.[0-9]+)',  
          'Internet Explorer 4' => '(MSIE 4\.[0-9]+)',  );  

foreach($navegadores as $navegador=>$pattern){  
       if (eregi($pattern, $user_agent))  
       return $navegador;  
    }  
  return 'Desconocido';  
}  

//echo $_SERVER['HTTP_USER_AGENT'];

if ($id_ramo != NULL or $id_ramo != 0){
		$_RAMO=$id_ramo;
		session_register('_RAMO');
	}

	
if ($viene_de){
		$_VIENEPAG= "../".$viene_de;	
	}

	//if($_PERFIL==0) echo $_PERFIL;
    
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso		=$_CURSO;
	$ramo			=$_RAMO;
	$docente		=5; //Codigo Docente
	$_POSP          =6;
	$_bot           =5;
    
	
	//if($_POST['periodo_cerrado']) $periodo_cerrado = $_POST['periodo_cerrado'];

	/// AQUI CONSULTO SI ESTE RAMO ES PARTE DE ALGUNNA FORMULA (SUBSECTORRAMO)
	/// Y SI SE DEBE DAR LA OPCION DE INGRESAR NOTA O SOLO MOSTRAR
	
	$q1 = "select * from formula where id_ramo = '".trim($ramo)."' and modo = '2'";
	$r1 = @pg_Exec($conn,$q1);
	$n1 = @pg_numrows($r1);
	if ($n1>0){
	    $boton_ing = "no";
	}	
	
	//------------------------
	// Año Escolar
	//------------------------
	
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	
	if($aux!=1)	{//HACER LA CONSULTA Y DESPLEGAR EL PRIMER PERIODO
	
	$qry="SELECT * FROM periodo WHERE periodo.id_ano=".$ano." ORDER BY NOMBRE_PERIODO";
	
	$result =@pg_Exec($conn,$qry);
		
		if (!$result) 
			error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
		else{
		
			if (pg_numrows($result)!=0){
			
				$fila1 = @pg_fetch_array($result,0);	
				
				if (!$fila1){
				
					error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
					exit();
					
				};
				
				$periodo	= $fila1['id_periodo'];
				$periodo_cerrado = $fila1['cerrado'];
				
			}else{
			
				echo "NO EXISTEN PERIODOS INGRESADOS PARA ESTE AÑO";
				
			}
		};
	}


    $_PERIODORAMO	=	$periodo;
	if(!session_is_registered('_PERIODORAMO')){
		session_register('_PERIODORAMO');
	};
	
	// VERIFICO SI EL PERIODO ESTA CERRADO
	$q1 = "select * from periodo where id_periodo = ".$periodo."";
	$r1 = pg_Exec($conn,$q1);
	
	if (!$r1){
	   echo "Erro: No encontró el periodo";
	   exit();
	}else{
	   $f1 = pg_fetch_array($r1,0);
	   $cerradop = $f1['cerrado'];
	}      
	   
/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		/*if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
			$_ITEM =$item;
			session_register('_ITEM');
		}*/
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
		
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="../../../../../../clases/jqueryui/jquery-ui-1.8.6.custom.css"/>
<script src="../../../../../../clases/jqueryui/jquery-1.4.2.min.js" ></script>
<script src="../../../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js" ></script>
<script type="text/javascript" src="../../../../../../clases/jqueryui/jquery.ui.core.js"></script>
<script type="text/javascript" src="../../../../../../clases/jqueryui/jquery.ui.widget.js"></script>
<script language="JavaScript" src="funcionesvalidacionypromedio.js"></script>
<script language="JavaScript" src="../../../../../../../util/chkform.js"></script>


<script language="JavaScript">


<?
 $institucion=$_INSTIT;
 $ano =$_ANO;

  $sql = "SELECT   id,id_ano,id_rdb,nombre_concepto,valor_numerico,rango_x,rango_y  
	   FROM  public.modulo_conceptos  WHERE  id_ano = $ano AND id_rdb = $institucion ;";
	   $rs = @pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);

 

	if(pg_num_rows($rs)!=0){
	
			echo 'function desifranotaconseptual(dato){
				var nueva_nota=0;';
			echo 'alert("dentro");';
			for($r=0;$r<pg_num_rows($rs);$r++){
				$fila = pg_fetch_array($rs,$r);
				
				if($fila[3]=='MB'){	
				   echo 'var patron1 = /(^[mM][bB]{1}$)/ ;
				   if ( patron1.test(dato) == true ) nueva_nota = '.$fila[4].';';
				 }
				
				if($fila[3]=='B'){		
				   echo 'var patron2 = /(^[bB]{1}$)/; 
				   if ( patron2.test(dato) == true ) nueva_nota = '.$fila[4].';';	
				}
				
				if($fila[3]=='S'){		
				  echo 'var patron3 = /(^[sS]{1}$)/;
				  if ( patron3.test(dato) == true ) nueva_nota = '.$fila[4].';';
				}
				
				if($fila[3]=='I'){		
				   echo 'var patron4 = /(^[iI]{1}$)/;
				   if ( patron4.test(dato) == true ) nueva_nota = '.$fila[4].';';
				}
				
				if($fila[3]=='AL'){		
				   echo 'var patron5 = /(^[aA][lL]{1}$)/;
				   if ( patron5.test(dato) == true ) nueva_nota = '.$fila[4].';';
				}
				
				if($fila[3]=='NL'){		
				   echo 'var patron6 = /(^[nN][lL]{1}$)/;
				   if ( patron6.test(dato) == true ) nueva_nota = '.$fila[4].';';
				}
				
				if($fila[3]=='L'){		
				   echo 'var patron7 = /(^[lL]{1}$)/;
				   if ( patron7.test(dato) == true ) nueva_nota = '.$fila[4].';';
				}
			  
			  }
			  echo  'return nueva_nota; }';
			
			
echo 'function promedioconceptual(prom_conc){ var letra = "x";';

	for($r=0;$r<pg_num_rows($rs);$r++){
		  
	$fila = pg_fetch_array($rs,$r);
	
	if($fila[3]=='MB'){					
	    echo  "if( prom_conc >=".$fila[5]." && prom_conc <= ".$fila[6]." ) letra = 'MB';";
	}
	
	if($fila[3]=='B'){	
		echo  "if( prom_conc >=".$fila[5]." && prom_conc <= ".$fila[6]." ) letra = 'B';";
	}
	
	if($fila[3]=='S'){	
	    echo  "if( prom_conc >=".$fila[5]." && prom_conc <= ".$fila[6]." ) letra = 'S';";
	}
	
	if($fila[3]=='I'){	
		echo   "if( prom_conc >=".$fila[5]." && prom_conc <= ".$fila[6]." ) letra = 'I';";
	}
	
	if($fila[3]=='AL'){	
		echo   "if( prom_conc >=".$fila[5]." && prom_conc <= ".$fila[6]." ) letra = 'AL';";
	}
	
	if($fila[3]=='NL'){	
		echo   "if( prom_conc >=".$fila[5]." && prom_conc <= ".$fila[6]." ) letra = 'NL';";
	}
	
	if($fila[3]=='L'){	
		echo   "if( prom_conc >=".$fila[5]." && prom_conc <= ".$fila[6]." ) letra = 'L';";
	}
	
	}
	
	echo 'return letra; 	}';
			
			  
	}else{
	
	   $sql = "SELECT   id,id_ano,id_rdb,nombre_concepto,valor_numerico,rango_x,rango_y  
	   FROM  public.modulo_conceptos  WHERE  id_ano = 0 AND  id_rdb =  0;";
	   $rs = @pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);
	   if(pg_num_rows($rs)!=0){
		
			echo 'function desifranotaconseptual(dato){
				var nueva_nota=0;';
			echo 'alert("fuera");';
			for($r=0;$r<pg_num_rows($rs);$r++){
				$fila = pg_fetch_array($rs,$r);
				
				if($fila[3]=='MB'){	
				   echo 'var patron1 = /(^[mM][bB]{1}$)/ ;
				   if ( patron1.test(dato) == true ) nueva_nota = '.$fila[4].';';
				 }
				
				if($fila[3]=='B'){		
				   echo 'var patron2 = /(^[bB]{1}$)/; 
				   if ( patron2.test(dato) == true ) nueva_nota = '.$fila[4].';';	
				}
				
				if($fila[3]=='S'){		
				  echo 'var patron3 = /(^[sS]{1}$)/;
				  if ( patron3.test(dato) == true ) nueva_nota = '.$fila[4].';';
				}
				
				if($fila[3]=='I'){		
				   echo 'var patron4 = /(^[iI]{1}$)/;
				   if ( patron4.test(dato) == true ) nueva_nota = '.$fila[4].';';
				}
				
				
			  
			  }
			  echo  'return nueva_nota; }';
			  
			  
	echo 'function promedioconceptual(prom_conc){ var letra = "x";';

	for($r=0;$r<pg_num_rows($rs);$r++){
		  
	$fila = pg_fetch_array($rs,$r);
	
	if($fila[3]=='MB'){					
	    echo  "if( prom_conc >=".$fila[5]." && prom_conc <= ".$fila[6]." ) letra = 'MB';";
	}
	
	if($fila[3]=='B'){	
		echo  "if( prom_conc >=".$fila[5]." && prom_conc <= ".$fila[6]." ) letra = 'B';";
	}
	
	if($fila[3]=='S'){	
	    echo  "if( prom_conc >=".$fila[5]." && prom_conc <= ".$fila[6]." ) letra = 'S';";
	}
	
	if($fila[3]=='I'){	
		echo   "if( prom_conc >=".$fila[5]." && prom_conc <= ".$fila[6]." ) letra = 'I';";
	}
	
	if($fila[3]=='AL'){	
		echo   "if( prom_conc >=".$fila[5]." && prom_conc <= ".$fila[6]." ) letra = 'AL';";
	}
	
	if($fila[3]=='NL'){	
		echo   "if( prom_conc >=".$fila[5]." && prom_conc <= ".$fila[6]." ) letra = 'NL';";
	}
	
	if($fila[3]=='L'){	
		echo   "if( prom_conc >=".$fila[5]." && prom_conc <= ".$fila[6]." ) letra = 'L';";
	}
	
	}
	
	echo 'return letra; 	}';
	
			  
	
	    }
	
	}
?>



			function enviapag(form){
			if (form.cmbPERIODO.value!=0){
				form.cmbPERIODO.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'new_mostrarNotas.php?aux=1&periodo='+ form.cmbPERIODO.value;
				form.submit(true);
				}
			}
			
			function enviapag2(form){
			if (form.cmbPERIODO.value!=0){
				form.cmbPERIODO.target="_blank";
//				form.action = form.cmbPERIODO.value;
				form.action = '../mostrarNotasexcel.php?aux=1&periodo='+ form.cmbPERIODO.value;
				form.submit(true);
				}
			}

var cant_alumnos = 0;
var total_table = 0;
cargatable();

/****************************************MUESTRA MSJ******/
function mostrarventana(num_nota){
	
var parametros =  "num_nota="+num_nota+"&id_curso="+<?=$curso?>+"&id_ramo="+<?=$ramo?>+"&id_ano="+<?=$ano?>+"&id_periodo="+<?=$periodo?>;
	 $.ajax({
			url: 'buscadescripcionnota.php',
			type: 'post',
			dataType: "html",
			data: parametros,
			success: function(data){
			$("#res_lupas").html(data);
			   }
		 }); 			
          $("#ventanita"+num_nota+"").mouseenter(function(e){
					$("#res_lupas").css("left", e.pageX + 10 );
					$("#res_lupas").css("top", e.pageY + 10 );
					$("#res_lupas").css("display", "block");
			}); 
			$("#ventanita"+num_nota+"").mouseout(function(e){
					$("#res_lupas").css("display", "none");
			});
     }	
/****************************************CARGA TABLE******/
function cargatable(){

	var id_periodo=<?=$periodo?>;
	var id_ramo=<?=$ramo?>;
	var id_ano=<?=$ano?>; 
	var nro_ano = <?=$nro_ano?>;
	//var ont = 0; 
	var parametros = "id_periodo="+id_periodo+"&id_ramo="+id_ramo+"&id_ano="+id_ano+"&nro_ano="+nro_ano;
	alert(parametros);

     $.ajax({
		 <? if($_PERFIL==0){ $pagina_carga = "cargadata_2.php"; 
		 }else{ $pagina_carga = "cargadata_2.php"; } ?>
			url: 'cargadata_2.php',
			type: 'post',
			dataType: "html",
			data: parametros,
			success: function(data){
			  alert(data);  
			  $("#tablitas").html(data);
			  
			  cant_alumnos = $('#Xreg').val();
              total_table = parseInt(cant_alumnos * 19);
			  
			  $("#botoncito").html('<INPUT class="botonXX"  TYPE="button" id="botoncito1" value="EDITAR" onClick="editatable()" >');
			  
			  //$("#loading").html('');  
			  
			  $('#loading').dialog('close');
			       		  
			}
        })	
   }	


//*********************************************///

/*VARIABLES GLOBALES*/
	var index_tr_1=1; 
	var index_actual_1=0;
	var cont_1=0;
	var keycode;
	var z="";
		
	///***************************************************////

<? if($_PERFIL==0){ ?>							
	
//function dobleclick(y,e,i){

/*if( y != "" ){

			var index = $("#index_nota").val();
			
			if( index != 0 ){ 
			
			   var valor =  $("#nota").val();
			   $("#paises td:eq("+index+")").empty().html(''+valor+''); 
            
			 }
			 
			index = y;  // se envia el valor al dobleclick en el td
			index_tr_a = index_tr;
				 
            $("#paises tr:eq("+index_tr_a+")").css("background","");
                 
			index_tr = i+1;
            $("#paises tr:eq("+index_tr+")").css("background","#FFFF99");
			 
			var text = $("#paises td:eq("+index+")").text();
			
			$("#paises td:eq("+index+")").empty().html('<input name="nota"  type="text" id="nota" size="2" maxlength="2" value="'+text+'" /><input id="index_nota" type="hidden" value="'+index+'" />');
			
			 $("#nota").focus(); 
			 $("#nota").select();

        z=1;
        editatable(z,index_tr,index);

    }	*/

 //}

	<? } ?>

		   
/*************************************************EDITAR TABLE**/
function editatable(a){

	var largo_notas = 19;
	var cant_notas = 19;
	var teclafecha = 0;
	var index_tr_a = 0;
	var index = 0;	
	var index_tr = 1; 
	var index_actual = 0;
	var cont = 0;
	var nombrehiddennota;

	if( a != 'x' ){

        $("#botoncito").html('<INPUT class="botonXX"  TYPE="button" id="botoncito2" value="GUARDAR" onClick="guardatable()" >');
		$("#paises tr:eq(1)").css("background","#FFFF99");
			
			var text = $("#paises td:eq(0)").text();
			
			nombrehiddennota = $("#paises td:eq(0) :input").attr("name");	
			
			var inputhidden = '<input type="hidden" name="'+nombrehiddennota+'" id="'+nombrehiddennota+'" value="'+text+'" />'
		
	    var nombreclase = $("#paises td:eq(0)").attr("class");
			 
		if(nombreclase=="guardado"){
			
			$("#paises td:eq(0)").empty().html('<input name="nota" type="text" id="nota" size="2" maxlength="2" value="'+text+'" style="color:#003366; background-color:#EC9282; " onKeyUp="apromediar()" onfocus="return false" /><input id="index_nota" type="hidden" value="0" />'+inputhidden+'');
			
			$("#nota").focus(); 
			$("#nota").select();
		
		}else{

			$("#paises td:eq(0)").empty().html('<input name="nota" type="text" id="nota" size="2" maxlength="2" value="'+text+'" onKeyUp=apromediar("'+nombrehiddennota+'") /><input id="index_nota" type="hidden" value="0" />'+inputhidden+'');
			
			$("#nota").focus(); 
			$("#nota").select();

		}
	
/********************************************************/

	}else{
		
	validar(40,nombrehiddennota);
		
	}	  

		  document.onkeydown = checkKeycode;
          
		  function checkKeycode(e){
				  
				  if(window.event)keycode = window.event.keyCode; 
				  else if(e)keycode = e.which; 
					
					
					  validar(keycode,nombrehiddennota);
			        
					
					}

  //if( $("#desp_auto_Vertical").is(':checked') ) keyCode =  39;

/***************************************************/

    function validar(e,a){
	  
				var keyCode = e;
				
				if(keyCode == '13'){
					keyCode = teclafecha;
					};
       
  
	   if (keyCode == '40') { // codigo ascii de la flecha hacia abajo
	   
	   if( datovalido( $("#nota").val() )==true ){
       
	        teclafecha = '40';
					
			index_actual = index;
		    index = index_actual + largo_notas;
			
			if(index < (total_table) ){ // AQUI SE FUE
			
			var valor =  $("#nota").val();
			
			var inputhidden = '<input type="hidden" name="'+nombrehiddennota+'" id="'+nombrehiddennota+'" value="'+valor+'" />'
									
			$("#paises td:eq("+index_actual+")").empty().html(''+valor+inputhidden+'');
						
			var text = $("#paises td:eq("+index+")").text();	
			
			nombrehiddennota = $("#paises td:eq("+index+") :input").attr("name");
				
			var inputhidden = '<input type="hidden" name="'+nombrehiddennota+'" id="'+nombrehiddennota+'" value="'+text+'" />'
              
			 //alert(inputhidden); 
			
			//if(index < (total_table) ){

				 index_tr_a = index_tr;
                 $("#paises tr:eq("+index_tr_a+")").css("background","");
                 index_tr++;
                 $("#paises tr:eq("+index_tr+")").css("background","#FFFF99");
				 
 				 var nombreclase = $("#paises td:eq("+index+")").attr("class");
					 
					 if(nombreclase=="guardado"){
							 			 
						$("#paises td:eq("+index+")").empty().html('<input name="nota" readonly="readonly" type="text" id="nota" size="2" maxlength="2" value="'+text+'" style="color:#003366; background-color:#EC9282; " /><input id="index_nota" type="hidden" value="'+index+'" />'+inputhidden+'');
							 
						 $("#nota").select();
						 $("#nota").focus();
							  
					   }else{ // nota editada
							 					 
						 $("#paises td:eq("+index+")").empty().html('<input name="nota" type="text" id="nota" size="2" maxlength="2" value="'+text+'" onKeyUp=apromediar("'+nombrehiddennota+'") /><input id="index_nota" type="hidden" value="'+index+'" />'+inputhidden+'');
							 
							 $("#nota").select();
							 $("#nota").focus();	
						
						}
					
				}else{
						
						if(nombreclase=="guardado"){
								
						$("#paises td:eq("+index+")").empty().html('<input name="nota" readonly="readonly" type="text" id="nota" size="2" maxlength="2" value="'+text+'" style="color:#003366; background-color:#EC9282; " /><input id="index_nota" type="hidden" value="'+index+'" />'+inputhidden+'');
								
						index = index_actual;
								
						$("#nota").select();
						$("#nota").focus();
						 
						}else{ // nota editada
								
						$("#paises td:eq("+index+")").empty().html('<input name="nota" type="text" id="nota" size="2" maxlength="2" value="'+text+'" onKeyUp=apromediar("'+nombrehiddennota+'") /><input id="index_nota" type="hidden" value="'+index+'" />'+inputhidden+'');
								
						index = index_actual;
								
						$("#nota").select();
						$("#nota").focus();
						  
						}
						  
				}
				
					 index_tr_1=index_tr; 
	                 index_actual_1=index;
	                 cont_1=cont;
					 
					 //promedio(index_tr_1,index_actual_1,cont_1); // arreglo de promedio ?? para el wn que escribe muy rapido 
				
				}else{
				
			    $("#nota").focus();					 
				$("#nota").select();
			
			};	
				
           }  //40
	   
          if (keyCode == '38') { // codigo ascii de la flecha hacia arriba
		  
		  if( datovalido( $("#nota").val() )==true ){
	      
		       teclafecha = '38';
               
			   var index_actual = index;
                
				if(index  >= largo_notas){ 
					
							if(index_tr!=1){
								 $("#paises tr:eq("+index_tr+")").css("background","");
								  index_tr--;
								 $("#paises tr:eq("+index_tr+")").css("background","#FFFF99");
							 }
					
					index = index_actual - largo_notas;
					
					var valor =  $("#nota").val();
					
					var inputhidden = '<input type="hidden" name="'+nombrehiddennota+'" id="'+nombrehiddennota+'" value="'+valor+'" />'
											
					$("#paises td:eq("+index_actual+")").empty().html(''+valor+inputhidden+'');
								
					var text = $("#paises td:eq("+index+")").text();	
					
					nombrehiddennota = $("#paises td:eq("+index+") :input").attr("name");	
					
					var inputhidden = '<input type="hidden" name="'+nombrehiddennota+'" id="'+nombrehiddennota+'" value="'+text+'" />'
					
					//alert(inputhidden);
						  
					var nombreclase = $("#paises td:eq("+index+")").attr("class");
			
					if(nombreclase=="guardado"){
					
						$("#paises td:eq("+index+")").empty().html('<input name="nota" readonly="readonly" type="text" id="nota" size="2" maxlength="2" value="'+text+'" style="color:#003366; background-color:#EC9282; " /><input id="index_nota" type="hidden" value="'+index+'" />'+inputhidden+'');
						
						$("#nota").select();
						$("#nota").focus();
						
						}else{
						
						$("#paises td:eq("+index+")").empty().html('<input name="nota" type="text" id="nota" size="2" maxlength="2" value="'+text+'" onKeyUp=apromediar("'+nombrehiddennota+'") /><input id="index_nota" type="hidden" value="'+index+'" />'+inputhidden+'');
						
						$("#nota").select();
						$("#nota").focus();
					
					}
							 
				index_tr_1=index_tr; 
	            index_actual_1=index;
	            cont_1=cont;	 
							 
			    }
					   
			}else{
			
			    $("#nota").focus();					 
				$("#nota").select();
			
			};	 
       
	   } //38	   
		   
       if (keyCode == '39') { // codigo ascii de la flecha hacia la derecha --->
	   
		    if( datovalido( $("#nota").val() )==true ){
		
						 teclafecha = '39';
		
						 if(index != total_table-1){ 
		
						 cont++;		
						 index_actual = index;
						 index++;
		                 
						var valor =  $("#nota").val();
						
						//if(valor1=="")valor='0';
						
						var inputhidden = '<input type="hidden" name="'+nombrehiddennota+'" id="'+nombrehiddennota+'" value="'+valor+'" />'
												
						$("#paises td:eq("+index_actual+")").empty().html(''+valor+inputhidden+'');
									
						var text = $("#paises td:eq("+index+")").text();	
						
						//if(text=="")text='0';
						
						nombrehiddennota = $("#paises td:eq("+index+") :input").attr("name");	
						
						var inputhidden = '<input type="hidden" name="'+nombrehiddennota+'" id="'+nombrehiddennota+'" value="'+text+'" />'
						
						//alert(inputhidden);
						 
						 var nombreclase = $("#paises td:eq("+index+")").attr("class");
		
						if(nombreclase=="guardado"){
		
							$("#paises td:eq("+index+")").empty().html('<input name="nota" readonly="readonly" type="text" id="nota" size="2" maxlength="2" value="'+text+'" style="color:#003366; background-color:#EC9282; " /><input id="index_nota" type="hidden" value="'+index+'" />'+inputhidden+'');
		
							$("#nota").select();
							$("#nota").focus();
		
						}else{				 
		
							$("#paises td:eq("+index+")").empty().html('<input name="nota" type="text" id="nota" size="2" maxlength="2" value="'+text+'" onKeyUp=apromediar("'+nombrehiddennota+'") /><input id="index_nota" type="hidden" value="'+index+'" />'+inputhidden+'');
		
							$("#nota").select();
							$("#nota").focus();
		
						}
		
						if(index%largo_notas==0){
							 var index_tr_a = index_tr;
							 $("#paises tr:eq("+index_tr_a+")").css("background",""); 
							 index_tr++; 
							 $("#paises tr:eq("+index_tr+")").css("background","#FFFF99");
							 cont=0;
						    }	
				
					  index_tr_1=index_tr; 
	                  index_actual_1=index;
	                  cont_1=cont;
									 
						}
		
			}else{
		
			    $("#nota").focus();					 
				$("#nota").select();
		
			};		
        
		  }//39
		  
    if (keyCode == '37') {   // codigo ascii de la flecha hacia la izquierda <---
	
	      if( datovalido( $("#nota").val() )==true ){
	
		  if(index != 0){
	
		        teclafecha = '37';
    
				 if(cont==0){ cont=18; 
				 }else{ cont-=1; } 
				 
				if(index%largo_notas==0){
                      var index_tr_a = index_tr;
					  $("#paises tr:eq("+index_tr_a+")").css("background",""); 
					  index_tr--; 
					  }
                 
				var valor =  $("#nota").val();

				var inputhidden = '<input type="hidden" name="'+nombrehiddennota+'" id="'+nombrehiddennota+'" value="'+valor+'" />'
	
			$("#paises td:eq("+index+")").empty().html(''+valor+inputhidden+'');
                 
			 if(index > 0) index--;
				 
			  var text = $("#paises td:eq("+index+")").text();	

			   nombrehiddennota = $("#paises td:eq("+index+") :input").attr("name");	

               var inputhidden = '<input type="hidden" name="'+nombrehiddennota+'" id="'+nombrehiddennota+'" value="'+text+'" />'
						
				  //alert(inputhidden);

				  var nombreclase = $("#paises td:eq("+index+")").attr("class");
						
						 if(nombreclase=="guardado"){
						
								 $("#paises td:eq("+index+")").empty().html('<input name="nota" readonly="readonly" type="text" id="nota" size="2" maxlength="2" value="'+text+'" style="color:#003366; background-color:#EC9282; " /><input id="index_nota" type="hidden" value="'+index+'" />'+inputhidden+'');
						
								  $("#nota").select();
								  $("#nota").focus();
						 
						 }else{   
								 
								 $("#paises td:eq("+index+")").empty().html('<input name="nota" type="text" id="nota" size="2" maxlength="2" value="'+text+'" onKeyUp=apromediar("'+nombrehiddennota+'") /><input id="index_nota" type="hidden" value="'+index+'" />'+inputhidden+'');

								  $("#nota").select();
								  $("#nota").focus();  
								  
								  }

			         $("#paises tr:eq("+index_tr+")").css("background","#FFFF99");
				
					  index_tr_1=index_tr; 
	                  index_actual_1=index;
	                  cont_1=cont;
					 
                   }

				}else{

			    $("#nota").focus();					 
				$("#nota").select();

			};		

		 } // 37


   } // fin funcion validatecla



   };



//********MENSAJES DE ERROR EN DIALOG************
function msjerror(text){

    $("#msjerror").html('<center><h3>'+text+'</h3></center>');

	$("#msjerror").dialog({ 
       closeOnEscape:true, 
	   modal:true,
	   resizable:false,
/*	   Width:400,
	   Height:200,
	   minWidth:400,
	   minHeight:200,
	   maxWidth:400,
	   maxHeight:200,*/
	   show: "fold",
	   hide: "scale",
	   stack: true,
	   sticky: true,
	   position:"fixed",
	   position: "absolute"
	}); 
    
	//$("#nota").focus();					 
	//$("#nota").select();
	
  }
//*****************************************************



/*******************************************VALIDAR*/
function datovalido(dato){

if($("#modo_eval").val()==0) return true;	
	
		if( $("#modo_eval").val() == 1 || $("#modo_eval").val() == 3 ){ 
				if(dato!=""){
				   var patron0 = /[7][0]/;
				   var patron1 = /[1-6][0-9]/;                   
				     
					if ( patron0.test(dato) == false ) {   
					
					   if ( patron1.test(dato) == false ) {
					        alert("Dato "+dato+" No es Valido");
							//msjerror("Dato "+dato+" No es Valido");
							return false; 
						} else {
							return true;
						}
                   
				   }else {
					return true;
				  }
				
				}else{
					return true;
			   }
	    };
	
		if( $("#modo_eval").val() == 2 || $("#modo_eval").val() == 4 ){ 
				 if(dato!=""){
				   var patron1 = /(^[iIsSbBnNaAlL]{1}$)/;
				   var patron2 = /(^[mMaAnN][bBlL]{1}$)/;
					  if ( patron1.test(dato) == false ){
						  if ( patron2.test(dato) == false ){
						         alert("Dato "+dato+" No es Valido");
								 return false;
		                  }else{
						      return true;
						   }
					  }else{
						  return true;
					  }
				}else{
					return true;
			   }
		   };
	   
	};

/*******************************************A PROMEDIAR*/
function apromediar(nomhidden){

if( keycode!= 40 && keycode!= 38 && keycode!= 37 && keycode!= 39 && keycode!= 13 && keycode!=27 ){

keycode=13;

		var n = $("#nota").val();
		
		if( $("#modo_eval").val() == 1 || $("#modo_eval").val() == 3 ){
		
		if( n.length==2 ){
		
			if( datovalido( $("#nota").val() )==true ){
								
				if(nomhidden!=""){ $('#'+nomhidden+'').val(n); }
				  
     				promedio(index_tr_1,index_actual_1,cont_1);
				 
			 }else{
			 	 return false;
			  }
			 
		  }else if( n.length==0 ){

		         if(nomhidden!=""){ $('#'+nomhidden+'').val(n); }
				 
		         promedio(index_tr_1,index_actual_1,cont_1);
				 
		  }
		  
	   }
	
				if( $("#modo_eval").val() == 2 || $("#modo_eval").val() == 4 ) {
					  if( n.length!=0 ){
					        
							if( n.length==2 ){ 
					        
							var patron1 = /(^[mMaAnN][bBlL]{1}$)/;
							
					        
							if ( patron1.test(n) == true ){
							
									if(nomhidden!=""){ $('#'+nomhidden+'').val(n); }
								    
								promedio(index_tr_1,index_actual_1,cont_1);
							    
								}else{
								
								datovalido( $("#nota").val() );
								
								}
							
							}else if ( n.length==1 ){ 
							    
								var patron1 = /(^[mMaAnN]{1}$)/;
					        
									if ( patron1.test(n) == false ){
										
										if( datovalido( $("#nota").val() )==true ){
									
										     if(nomhidden!=""){ $('#'+nomhidden+'').val(n); }
								    
									         promedio(index_tr_1,index_actual_1,cont_1);
										
										}
									
									}
							}
							 
					  }else if( n.length==0 ){
					  
						if(nomhidden!=""){ $('#'+nomhidden+'').val(n); }
						
						promedio(index_tr_1,index_actual_1,cont_1);
					  
					  }
				  };

       }

  }

/**************************************************PROMEDIO*/	
function promedio(xindextr,xintextd,conttd){   
    
	<? if($_PERFIL==0){ ?>
	//alert(index_tr_1+"="+index_actual_1+"="+cont_1);
	<? } ?>
	var suma = 0;
	var suma1 = "";
	var prom = 0;
	var cant_notas = 0;
	var indextd = 0;
	
		if( xintextd < conttd ){
			indextd = 0;
		}else{
			if(xintextd!=0){
				var indextd = parseInt(xintextd) - parseInt(conttd);
			}else{
				var indextd = xintextd;
			}
		}
		
		   /*Sumo para Obtener Promedios*/
		   for(i=0;i<19;i++){  
		   
				var valor = $("#paises td:eq("+indextd+")").text();
				//alert(valor);
				
					if( valor != "" ){
						   cant_notas++;
						   if( $("#modo_eval").val() == 1 || $("#modo_eval").val() == 3 ){
								   suma = parseInt(suma) + parseInt(valor);
								}  
							if( $("#modo_eval").val() == 2 || $("#modo_eval").val() == 4 ){
								   valor = desifranotaconseptual( valor );
								   suma = parseInt(suma) + parseInt(valor);
								}  
					}
					
					indextd++;
			 }
             /*Sum Prom*/
	        
			 if( $("#modo_eval").val() == 1 || $("#modo_eval").val() == 3 ){
			           if($("#nota").val()!=""){ 
					   cant_notas++;
					   suma = suma + parseInt($("#nota").val());
					   //suma1 = suma1+"+"+$("#nota").val();
					   }
				   }
								   				   
			 if( $("#modo_eval").val() == 2 || $("#modo_eval").val() == 4 ){	
			            if($("#nota").val()!=""){ 
			           cant_notas++;  
				       suma = suma + desifranotaconseptual( $("#nota").val() );
					   }
				   }
		   
		   /*Divido para Obtener Promedios*/
		   if(cant_notas != 0){   
		   
			   if( $("#modo_eval").val() == 1 || $("#modo_eval").val() == 3 ){
				   if( $("#truncado").val() == 1 ){
					  prom =  round(suma / (cant_notas) , 0);
				   }else{
					  prom =  parseInt(suma / (cant_notas) , 0);
				   }
				}
				
				if( $("#modo_eval").val() == 3 ){
					  prom =  promedioconceptual(prom);
					  }
				
				if( $("#modo_eval").val() == 2 || $("#modo_eval").val() == 4 ){
					  
					  prom =  parseInt(suma / (cant_notas) , 0);
						   
						   if( $("#modo_eval_p_nivel") != 1 && $("#modo_eval").val() == 2 ){ 
								  prom =  promedioconceptual(prom);
								}
							
							 }
							 
		   }else{
			   prom = 0;
		   }
           /*Div Prom*/
		   	   
			   /*Aproxima a Entero*/
			   if( $("#aprox_entero").val() ==1 && $("#modo_eval").val() == 1 ){
					prom = aprox_entero(prom);
				   }
			  /************/	   

				 
        /*prueba nivel*/
		var pct_nivel = parseInt( $("#pct_nivel").val() );
				
		// si no existe prueba de nivel quedara la variable en 0;
		if($("#pruebadenivel"+xindextr+"").text()!=""){  
		   var notapruebadenivel = parseInt($("#pruebadenivel"+xindextr+"").text());
		}else{
		   var notapruebadenivel = 0;
		 }		
				 
		if( notapruebadenivel != "" && $("#modo_eval").val() == 1 &&  $("#prueba_nivel").val() ==1 ){

                 if( $("#modo_eval_p_nivel").val() == 1 ){   /*prueba de nivel del tipo numerico*/ 

					        prom  = (  parseInt(prom) * ( 100 - pct_nivel )  )  / 100; 
					        var otro = (  parseInt(notapruebadenivel)  * pct_nivel   )   / 100;
					        prom = parseInt(prom) + parseInt(otro);
			              
							  if( $("#truncado_pnivel").val()==1 ){
								prom = round(prom,0);
							  }else{
								prom = parseInt(prom,0);
							  }

				  }

		    }
		  /*prueba nivel*/
	
	cant_notas = cant_notas+1;
	//$("#prom"+xindextr+"").html( " "+suma+" / "+cant_notas+" = "+prom+ " " );
	
	$("#prom"+xindextr+"").html(""+prom+"");
	$('#a_'+xindextr+'_21').val(prom); // HIDDEN DE PROMEDIO
	
	suma=0;
	cant_notas=0;
    indextd = 0;
	prom = 0;
	
					<? if($_PERFIL==0){ ?> 
				        //editatable('x');
				 <? } ?>
	   
     } 
   
   
   
/*********************************************GUARDA TABLE*/
function loading(){

$("#loading").html('<center><img src="../../../../../../clases/img_jquery/loading51.gif"  style="margin:5px;" height="110px" width="110px" ></center>');  			
						 
			$("#loading").dialog({ 
				closeOnEscape: false, 
				open: function(event, ui) { 
				$(".ui-dialog-titlebar").hide();
				}, 
				modal:true,
				resizable: false,
				Width: 350,
				Height: 350,
				minWidth: 350,
				minHeight: 350,
				maxWidth: 350,
				maxHeight: 350,
				show: "fold",
				hide: "scale",
				position:"fixed",
				position: "absolute"
			}); 
	
   }


function guardatable(){
		
			$.ajax({
					url: "procesador_notas.php",
					async:true,
					beforeSend: function(objeto){
					   loading();
					},
					complete: function(objeto, exito){
						if(exito=="success"){
							//alert("  Datos Guardados Correctamente. ");
						}
					},
					contentType: "application/x-www-form-urlencoded",
					dataType: "html",
					error: function(objeto,quepaso,otroobj){
						alert(" Error de Sistema : "+quepaso+".  Intentelo mas tarde. ");
					},
					global: true,
					ifModified: false,
					processData:true,
					data:$('#form1_patracom').serialize(),
					success: function(datos){
					  cargatable();
					  //$("#tablitas2").html(datos);
					},
					timeout: 6000,
					type: "POST"
			});
		  
       }
/***************************************************/

  //});

</script>
<link href="../../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">	
</head>
<style type="text/css">
<!--
.guardado {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	font-variant: normal;
	color: #000099;
}
-->
<!--
.formatoth {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	font-variant: normal;
	color: #000099;
	background-color:#FFCC33;
	cursor:default;
}
-->
<!--
.formatothmsj {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	font-variant: normal;
}
-->
<!--
.guardadopruebadenivel {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	font-variant: normal;
	color: #000099;
	background-color:#FFCC33;
}
-->
<!--
.retirado{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	font-variant: normal;
	color: #000099;
	background-color:#CCFF99;
}
-->
<!-- 
 .tip{
   padding: 9px;
   display: none;
   position:absolute;
   background:#CCCCCC;
   border:#000;
   border:solid 1px;
   font-size: 8px;
  }
-->

</style>
<body style="margin:0px;">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include ("../../../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
            
            <td height="80" colspan="3">
            
            <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            
                    <tr> 
                      
                      <td width="2%" height="363" align="left" valign="top" >
  	  <? 
					   //$menu_lateral= '3_1'; include ("../../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="98%" align="left" valign="top">
                      
                      <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!-- inicio codigo antiguo -->
				  
		<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO ESCOLAR</strong>
                                    </FONT>
                             </TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
                                </FONT>
                              </TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}
													echo trim($fila1['nro_ano']);
												}
											}
										?>
									</strong>
                                    </FONT>	
                                    </TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>CURSO</strong></FONT></TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong></FONT></TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.bloq_nota FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (77)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);
													$bloq_nota = $fila1['bloq_nota'];	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila1['grado_curso'])." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
												}
											}
										?>
				</strong>
                </FONT>
                </TD>
				</TR>
				<TR>
				<TD align=left>
				<FONT face="arial, geneva, helvetica" size=2>
				<strong>SUBSECTOR</strong>
                </FONT>
                </TD>
				<TD>
				<FONT face="arial, geneva, helvetica" size=2>
				<strong>:</strong>
                </FONT>
                </TD>
				<TD>
				<FONT face="arial, geneva, helvetica" size=2>
				<strong>
				<?php
                
			$qry="SELECT * FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
                $result =@pg_Exec($conn,$qry);
                
                if (pg_numrows($result)!=0){
                
                $fila10 = @pg_fetch_array($result,0);	
                echo trim($fila10['nombre']);
                
                $_SESSION['_MODOEVAL'] = trim($fila10['modo_eval']);
				$modo_eval = trim($fila10['modo_eval']);
                $modo_eval_p_nivel = trim($fila10['modo_eval_pnivel']);
                $truncado_pnivel  = trim($fila10['truncado_pnivel']);
                $aprox_entero = trim($fila10["aprox_entero"]);
                $truncado = trim($fila10['truncado']);	
                $pct_nivel = trim($fila10['pct_nivel']);
                $prueba_nivel = trim($fila10['prueba_nivel']);
				$bool_bloq = trim($fila10['bool_bloq']);
				
                echo "<input id='truncado' type='hidden' value='".$truncado."' >";
				
                echo "<input id='modo_eval_p_nivel' type='hidden' value='".$modo_eval_p_nivel."' >";
				
                echo "<input id='aprox_entero' type='hidden' value='".$aprox_entero."' >";
				
                echo "<input id='truncado_pnivel' type='hidden' value='".$truncado_pnivel."' >";
				 
                echo "<input id='modo_eval' type='hidden' value='".$modo_eval."' >";
				
                echo "<input id='pct_nivel' type='hidden' value='".$pct_nivel."' >";
				
                echo "<input id='prueba_nivel' type='hidden' value='".$prueba_nivel."' >";
				
				echo "<input id='bool_bloq' type='hidden' value='".$bool_bloq."' >";
				
               	$sql_busca = "SELECT * FROM notas$ano_act n 
                INNER JOIN  ramo r ON r.id_ramo=n.id_ramo 
                WHERE n.id_ramo=".$ramo." AND n.id_periodo=".$periodo." AND n.nota20 is not null AND n.nota20<>'0' ";
                $result_busca =@pg_Exec($conn,$sql_busca);
                $p_nivel = @pg_numrows($result_busca);
				
				echo "<input id='p_nivel' type='hidden' value='".$p_nivel."' >";
				
                    }
                ?>
                </strong>
                </FONT>
                </TD>
                </TR>
                <TR>
     <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>PLAN 
              DE ESTUDIO</strong> </FONT> </TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
                             <TD>
                                      <FONT face="arial, geneva, helvetica" size=2>
									<strong>
                                         <?php
											$qry4="SELECT curso.id_curso, plan_estudio.cod_decreto, plan_estudio.nombre_decreto FROM curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto WHERE (((curso.id_curso)=".$curso."))";
											//if($_PERFIL==0) echo $qry4;
														$result4 =@pg_Exec($conn,$qry4);
														$fila4= @pg_fetch_array($result4,0);
													
												echo trim($fila4['nombre_decreto']);
											
										?>
                                       </strong>								</FONT>                                </TD>
						</TR>
                         <TR>
							
                   <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>DECRETO 
                                DE EVAL</strong> </FONT> </TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
                            
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
                                         
										<?php 


			$qry4="SELECT curso.id_curso, evaluacion.cod_eval FROM curso 
			INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval WHERE (((curso.id_curso)=".$curso."))";
		    $result4 =@pg_Exec($conn,$qry4);
			$fila4= @pg_fetch_array($result4,0);
                                                           

			$qry5="SELECT * FROM EVALUACION WHERE COD_EVAL=".$fila4['cod_eval'];
			$result5 =@pg_Exec($conn,$qry5);
			
			if (!$result5) {
				error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
			}else{
				if (pg_numrows($result5)!=0){
					$fila9 = @pg_fetch_array($result5,0);	
					if (!$fila9){
						error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
						exit();
						}
					echo trim($fila9['nombre_decreto_eval'])." (".trim($fila9['cursos']).")";
					
					}
					
				}
												
												
				$qry1106="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO = '$ano' AND ID_INSTITUCION=".$institucion." ORDER BY NRO_ANO";
				$result1106 =@pg_Exec($conn,$qry1106);
				
				if (!$result1106){
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result1106)!=0){
						$fila1106 = @pg_fetch_array($result1106,0);	
						if (!$fila1106){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}else{
						  $fila1106 = @pg_fetch_array($result1106,0);
					    }	  
					}
											
				}				?>	</strong>								</FONT>							</TD>
						</TR> 
						
						
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>ESTADO DE INGRESO DE NOTAS</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<? if ($bloq_nota==1){ ?>								
								      <img src="../../../../../../configuracion/cand_cerrado.jpg">
									  &nbsp; <FONT face="arial, geneva, helvetica" size=2>
									<strong>BLOQUEADO POR EL ADMINISTRADOR</strong></FONT>
							  <?  }else{ ?>
							          <img src="../../../../../../configuracion/cand_abierto.jpg">
									  &nbsp; <FONT face="arial, geneva, helvetica" size=2>
									<strong>DISPONIBLE PARA INGRESO</strong></FONT>							  
							  <? } ?>							</TD>
						</TR>
						<TR>
						  <TD align=left><FONT face="arial, geneva, helvetica" size=2>
									<strong>MANUAL DE USO</strong></FONT></TD>
						  <TD><FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong></FONT></TD>
						  <TD><a href="BOLETIN8.pdf"><img src="pdf.jpg" alt="Descargar Manual" width="45" height="35" border="0"></a></TD>
						  </TR>	
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD colspan=2>
                            
<table align="right" >
<tr>
<td>
<? if($_PERFIL==0){?>							
	<INPUT class="botonXX"  TYPE="button" value="RESPALDAR EN EXCEL" onClick="enviapag2(this.form)">
<? } ?>
</td>
<td>
<? if ( ($bloq_nota !=1 && $periodo_cerrado !=1  && $cerradop != 1 ) ){ ?>	
<div id="botoncito" >
<INPUT class="botonXX"  TYPE="button"  id="botoncito1" value="EDITAR" onClick="editatable(0)" >
</div>
<?	}	?>								
</td>
<td>
<INPUT class="botonXX"  TYPE="button" value="VOLVER"  onClick=document.location="<?=$_VIENEPAG;?>">&nbsp;
</td>
</table>

							</TD>
						</TR>
						<TR class="indextable">
							<TD colspan=2 class="fondo">
								Notas
							</TD>
						</TR>
						<TR >
							<TD colspan="2" align="middle" >
                            
<? if($_PERFIL==0){ ?>
<table width="198" border="1" align="left"  style="border-collapse:collapse" >
<tr>
<td colspan="2">							
Desplazamiento Automático</td>
<tr align="center">
<td width="160">
Horizontal_</td>
<td width="98">
<input name="desp_auto_Horizontal" id="desp_auto_Horizontal" type="checkbox" value="1"></td>
</tr>
<tr align="center" >
<td>
Vertical</td>
<td>
<input name="desp_auto_Vertical" id="desp_auto_Vertical" type="checkbox" value="1"></td>
</tr>
</table>
<? } ?>
                            
                  
        <form method="post" name="frm" >
		<select name="cmbPERIODO"  onChange="enviapag(this.form)" class="input">
		<?php
		$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano."))  order by id_periodo";
				$result =@pg_Exec($conn,$qry);
				if(!$result){ 
					error('<B> ERROR :</b>Error al acceder a la BD. (74)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila1 = @pg_fetch_array($result,0);	
							if (!$fila1){
								error('<B> ERROR :</b>Error al acceder a la BD. (84)</B>');
								exit();
							  };
								for($i=0 ; $i < @pg_numrows($result) ; $i++){
													$fila1 = @pg_fetch_array($result,$i);
								if($fila1['id_periodo']==$periodo){
				echo  "<option value=".$fila1["id_periodo"]." selected>".$fila1["nombre_periodo"]."</option>";
										}else{
				echo  "<option value=".$fila1["id_periodo"].">".$fila1["nombre_periodo"]."</option>";
										}
								}
							}
					}
			?>
			</select>
            </form>

			</TD>
			</TR>
			<TR>
			<TD>
<!--DESARROLLO-->
<div id="tablitas"></div>
<div id="tablitas2"></div>
<!--FIN-->                            
			</TD>
			</TR>
			<TR>
			<TD colspan=4 align="center">
								<table width="327" border="0" cellpadding="0" cellspacing="0" class="boton02">
                                  <tr align="center" valign="middle">
                                    <td height="23"><a href="../seteaRamo.php3?caso=4" class="boton02" > <img src="../../../../../cortes/atras.gif" width="11" height="11" border="0"> Volver</a></td>
                                    <td><a href="#arriba" class="boton02"><img src="../../../../../cortes/subir.gif" width="11" height="11" border="0">Subir</a> </td>
                                    <td><a href="javascript:;" onClick="window.print();" class="boton02"><img src="../../../../../cortes/print.gif" width="11" height="11" border="0"> Imprimir</a></td>
                                  </tr>
                                </table>
								</TD>
						</TR>
					</TABLE>
			</TR>
		</TABLE>
				<!-- fin codigo antiguo --></td>
                </tr>
                </table></td>
                </tr>
                </table></td>
                </tr>
                <tr align="center" valign="middle"> 
                <td height="45" colspan="2" class="piepagina"><? include("../../../../../../../cabecera/menu_inferior.php"); ?></td>
                </tr>
                </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<div id="loading" style="width:auto" ></div>
<div id="msjerror" style="width:auto" ></div>
</body>
</html>
<script language="JavaScript">
<?
$navegator = ObtenerNavegador($_SERVER['HTTP_USER_AGENT']);
if($navegator=='Internet Explorer 6'){
echo 'alert("Este Modulo esta Desarrollado para Trabajar en Explorer 7 o Superior Usted esta trabajando con Explorer 6");';
}
?>
</script>
