<?php require('../../../../../../../util/header.inc');
//header( 'Content-Type: text/html;charset=utf-8' ); 

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

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$taller			=$_TALLER;
	$_POSP          =6;
	$_bot           =5; 
	$docente		=5; //Codigo Docente
	
	if($aux!=1)	{//HACER LA CONSULTA Y DESPLEGAR EL PRIMER PERIODO
		$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY NOMBRE_PERIODO";
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
			}else{
				echo "NO EXISTEN PERIODOS INGRESADOS PARA ESTE AÑO";
			}
		};
	}

	$_PERIODORAMO	=	$periodo;
	if(!session_is_registered('_PERIODORAMO')){
		session_register('_PERIODORAMO');
	};

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link rel="stylesheet" type="text/css" href="../../../../../../clases/jqueryui/jquery-ui-1.8.6.custom.css"/>
<link href="../../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<script src="../../../../../../clases/jqueryui/jquery-1.4.2.min.js" ></script>
<script src="../../../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js" ></script>
<script type="text/javascript" src="../../../../../../clases/jqueryui/jquery.ui.core.js"></script>
<script type="text/javascript" src="../../../../../../clases/jqueryui/jquery.ui.widget.js"></script>
<script language="JavaScript" src="../grilla_notas_jscrip/funcionesvalidacionypromedio.js"></script>
<script language="JavaScript" src="../../../../../../../../util/chkform.js"></script>


		<SCRIPT language="JavaScript">

			function enviapag(form){
			if (form.cmbPERIODO.value!=0){
				form.cmbPERIODO.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'mostrarnotastaller.php?aux=1&periodo='+ form.cmbPERIODO.value;
				form.submit(true);
				}
			}


var cant_alumnos = 0;
var total_table = 0;
cargatable();

function cargatable(){

	var id_periodo=<?=$periodo?>;
	var id_taller=<?=$taller?>;
	var id_ano=<?=$ano?>; 
	var rdb=<?=$institucion?>;
										
	//var ont = 0; 
	var parametros = "id_periodo="+id_periodo+"&id_taller="+id_taller+"&id_ano="+id_ano+"&rdb="+rdb;
	//alert(parametros);

     $.ajax({
			url: 'cargadatostaller.php',
			type: 'post',
			dataType: "html",
			data: parametros,
			success: function(data){

			  $("#tablitas").html(data);
			  
			  cant_alumnos = $('#Xreg').val();
              
			  total_table = parseInt(cant_alumnos * 20); // cantidad de las notas a ingresar modificacion manual
			  
			  $("#botoncito").html('<INPUT class="botonXX"  TYPE="button" id="botoncito1" value="..::EDITAR::.." onClick="editatable()" >');
			  //$("#loading").html('');  
			  $('#loading').dialog('close');
			       		  
			}
        })	
      
  }  // fin funcion carga table	
   
 
 //*********************************************///

/*VARIABLES GLOBALES*/
	var index_tr_1=1; 
	var index_actual_1=0;
	var cont_1=0;
	var keycode;
	var z="";  

/*************************************************EDITAR TABLE**/
function editatable(a){

	var largo_notas = 20;
	var cant_notas = 20;
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
							  
					   }else{
							 					 
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
						 
						}else{
								
						$("#paises td:eq("+index+")").empty().html('<input name="nota" type="text" id="nota" size="2" maxlength="2" value="'+text+'" onKeyUp=apromediar("'+nombrehiddennota+'") /><input id="index_nota" type="hidden" value="'+index+'" />'+inputhidden+'');
								
						index = index_actual;
								
						$("#nota").select();
						$("#nota").focus();
						  
						}
						  
				}
				
					 index_tr_1=index_tr; 
	                 index_actual_1=index;
	                 cont_1=cont;
				
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

/**************************************************/
/**************************************************/


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
				   var patron1 = /(^[iIsSbB]{1}$)/;
				   var patron2 = /(^[mM][bB]{1}$)/;
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
					        
							var patron1 = /(^[mM][bB]{1}$)/;
					        
							if ( patron1.test(n) == true ){
							
									if(nomhidden!=""){ $('#'+nomhidden+'').val(n); }
								    
									promedio(index_tr_1,index_actual_1,cont_1);
							    
								}else{
								
								datovalido( $("#nota").val() );
								
								}
							
							}else if ( n.length==1 ){ 
							    
								var patron1 = /(^[mM]{1}$)/;
					        
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
								   valor = desifranotaconseptual(valor);
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
					url: "procesarnotastaller.php",
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
					   
					/*   alert(datos);*/
					   
					   cargatable();
					    
						/*$('#loading').dialog('close');
						$("#tablitas2").html(datos);*/
					
					},
					timeout: 6000,
					type: "POST"
			});
		  
       }
/***************************************************/

   



</SCRIPT>


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


</head>
<body>

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="53" height="722" align="left" valign="top" background="../../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
<td width="894" align="left" valign="top" bgcolor="f7f7f7"> 
<? include ("../../../../../../../cabecera/menu_superior.php"); ?>
</td>
</tr>
<tr align="left" valign="top"> 
<td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">

<tr> 
<td width="27%" height="363" align="left" valign="top"> 
<? $menu_lateral="3_1"; include ("../../../../../../../menus/menu_lateral.php"); ?></td>
<td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr> 
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr> 
<td height="395" align="left" valign="top"> 
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
<tr> 
<td height="390">

    <!-- inicio codigo antiguo -->
								  
	    <FORM method=post name="frm">
		
        <TABLE WIDTH=90% BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
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
			<strong>TALLER</strong>
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
				$qry="SELECT * FROM TALLER WHERE (((taller.id_taller)=".$taller."))";
				$result =@pg_Exec($conn,$qry);
				if (pg_numrows($result)!=0){
				$fila10 = @pg_fetch_array($result,0);	
				echo trim($fila10['nombre_taller']);
				
				$modo_eval=$fila10['modo_eval'];
				
				echo "<input id='modo_eval' type='hidden' value='".$modo_eval."' >";
				
				   }
				?>
			</strong>
			</FONT>
			</TD>
			</TR>
	    </TABLE>
        
		</TD>
		</TR>
		
        <TR height=15>
        <TD>
		
    <TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
	<TR height="50">
	<TD align=right colspan=2>

<?php if(($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>

<div id="botoncito" >
<INPUT class="botonXX"  TYPE="button"  id="botoncito1" value="..::EDITAR::.." onClick="editatable(0)" >
</div>
    
<?php }?>	
	
<INPUT class="botonXX"  TYPE="button" value="..::VOLVER::.." name=btnCancelar onClick=document.location="../../seteaTaller.php3?caso=4">&nbsp;
	
    </TD>
	</TR>
	
    <TR height=20>
	<TD align=middle colspan=2 class="tableindex">
	Notas del Taller
	</TD>
	</TR>
	
    <TR height=20 bgcolor=white>
	<TD align=middle colspan=2 align=center>
    <?
	$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano."))  order by id_periodo";
	$result =@pg_Exec($conn,$qry);
	?>
	<select name="cmbPERIODO" onChange="enviapag(this.form)">
	<?php
		if (!$result) 
			error('<B> ERROR :</b>Error al acceder a la BD. (74)</B>');
		else{
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
	};
	?>
    </Select>
	</TD>
	</TR>
    </TABLE>
        			
	    </TD>
        </TR>

        </TABLE>
        </FORM>
     

<!--DESARROLLO-->

<div id="tablitas"></div>


<div id="tablitas2"></div>
<!--FIN--> 
                                  
                                  
<!-- fin codigo antiguo -->
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
<tr align="center" valign="middle"> 
<td height="45" colspan="2" class="piepagina"><? include("../../../../../../../cabecera/menu_inferior.php"); ?></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
<td width="54" align="left" valign="top" background="../../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
</tr>
</table>
</td>
</tr>
</table>
<div id="loading" style="width:auto" ></div>
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
