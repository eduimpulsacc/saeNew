<?php 
require('../../../../../../util/header.inc');

header ("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); //la pagina expira en una fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache");


$institucion	=$_INSTIT;
$ano			=$_ANO;
$curso			=$_CURSO;
$ramo			=$_RAMO;
$_ALUMNO		=$alumno;

if(!session_is_registered('_ALUMNO'))
	session_register('_ALUMNO');

$docente		=5; //Codigo Docente
$periodo		=$_PERIODORAMO;
$_POSP          =6;
$_bot           = 5;


/// verificar si el perfil está bloqueado para modificar notas  //
 if($_PERFIL==0){
     $ingreso = 1;
     $modifica =1;
     $elimina =1;
     $ver =1;
 }else{
     if($nw==1){
         $_MENU =$menu;
         session_register('_MENU');
         $_CATEGORIA = $categoria;
         session_register('_CATEGORIA');
         $_ITEM =$item;
         session_register('_ITEM');
     }
     $sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item = ".$_ITEM;
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


function fn(form,field,m)

		{
			var next=0, found=false, x, y, g;
			var f=frm;

			if(event.keyCode==37)  // codigo ascii de la flecha hacia la izquierda <---
			{
						next=m+1;
						found=true;
			}
			if(event.keyCode==38)  // codigo ascii de la flecha hacia arriba 
			{
						next=m-19;
						found=true
			}
			if(event.keyCode==39)  // codigo ascii de la flecha hacia la derecha --->
			{
						next=m+3;
						found=true
			}
			if(event.keyCode==40)  // codigo ascii de la flecha hacia abajo
			{
						next=m+23;
						found=true
			}


			while(found){
				if( f.item(next).disabled==false &&  f.item(next).type!='hidden'){
					
				    f.item(next).focus();
					break;
				}
			}

		}



        function chequear(form, field, m){
		   
			if (field>0 || field!=null){
				
							
				    //aqui la funcion de arriva modificada
					var next=0, found=false, x, y, g;
					var f=frm;
		
					next=m+3;
					found=true
					
					while(found){
						if( f.item(next).disabled==false &&  f.item(next).type!='hidden'){							
							f.item(next).focus();
							break;
						}
					}				
				
			}
		
		}
		
</SCRIPT>





		
		<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>

		<?php if($_MODOEVAL==1){ //EVALUACION NUMERICA?>
			<SCRIPT language="JavaScript">

				
				function validaNota(box){
					if(box.value.length==0)	
						return true; // acepta longitud 0
					if(!notaNroOnly(box,'Nota inválida. 1')) 
						return false;	
					return true;
				}
				
				
				function validaNotaNumerica(box){
					if(box.value.length==0)	
						return true; // acepta longitud 0
					if(!notaNroOnly(box,'Nota inválida. 2')) 
						return false;
					if (box.value>70){
					    alert('Nota inválida. 3');
						return false;
					}
							
					return true;
				}

                
				function validaNotaConceptual(box){
					if(box.value.length==0)	
						return true; // acepta longitud 0
					if(!notaConOnly(box,'Nota inválida. Usar letras MAYUSCULAS  1'))
						return false;
					return true;
				}


				function round(number,X) {
					// rounds number to X decimal places, defaults to 2
					X = (!X ? 0 : X);
					return Math.round(number*Math.pow(10,X))/Math.pow(10,X);
				}

		function valida(instit, grado, ensenanza){ 

				var trun = frm.truncado.value;
					//VALIDA NOTAS
					for (var zz=3;zz<document.frm.elements.length;zz++) //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(!validaNota(document.frm.elements[zz]))
								return false;
            
					
						var suma = 0;
						var cant;
						//OBTENER PROMEDIOS
						for (var ff=23;ff<document.frm.elements.length;ff=ff+21){
						
							cant = 0;
							for (var xx=(ff-20);xx<(ff);xx++){
								if (document.frm.elements[xx].value!=''){
								
									suma=(parseInt(suma)+parseInt(document.frm.elements[xx].value));
									cant++;
								}
							}
							if(cant!=0){
								if(trun==1){
								    a=suma/cant;
									document.frm.elements[ff].value=round((suma/cant),0);
							
									
								}else if (trun!=1){
									document.frm.elements[ff].value=parseInt((suma/cant),0);			
								}
							}else{
									document.frm.elements[ff].value='';
							}
							suma=0;
						
					}
				}
				
				
		function valida1(instit, grado, ensenanza){ 
				var trun = frm.truncado.value;
					//VALIDA NOTAS
					for (var zz=3;zz<document.frm.elements.length;zz++) //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(!validaNota(document.frm.elements[zz]))
								return false;
					var suma = 0;
						var cant;
						//OBTENER PROMEDIOS
						for (var ff=23;ff<document.frm.elements.length;ff=ff+21){
							cant = 0;
							for (var xx=(ff-20);xx<(ff);xx++){
								if (document.frm.elements[xx].value!=''){
									suma=(parseInt(suma)+parseInt(document.frm.elements[xx].value));
									cant++;
								}
							}
							if(cant!=0){
								if(trun==1){
								    /*a=suma/cant;*/
									prom=round((suma/cant),0);
									if (prom>=65 && prom<=70)
										prom_nuevo = 70;
									if (prom>=60 && prom<=64)
										prom_nuevo = 60;
									if (prom>=55 && prom<=59)
										prom_nuevo = 55;
									if (prom>=50 && prom<=54)
										prom_nuevo = 50;								
									if (prom>=45 && prom<=49)
										prom_nuevo = 45;
									if (prom>=40 && prom<=44)
										prom_nuevo = 40;
									if (prom>=0 && prom<=39)
										prom_nuevo = 35;
										document.frm.elements[ff].value = prom_nuevo;		
								}else if (trun!=1){
									prom=parseInt((suma/cant),0);
									if (prom>=65 && prom<=70)
										prom_nuevo = 70;
									if (prom>=60 && prom<=64)
										prom_nuevo = 60;
									if (prom>=55 && prom<=59)
										prom_nuevo = 55;
									if (prom>=50 && prom<=54)
										prom_nuevo = 50;								
									if (prom>=45 && prom<=49)
										prom_nuevo = 45;
									if (prom>=40 && prom<=44)
										prom_nuevo = 40;
									if (prom>=0 && prom<=39)
										prom_nuevo = 35;
										document.frm.elements[ff].value = prom_nuevo;	
								}
							}else{
									document.frm.elements[ff].value='';
							}
							suma=0;
						
					}
				}
/************       promedio prueba de nivel  de tipo numerica  ***********/
				function valida_prueba_nivel(pct_nivel,truncado_pnivel){ 				
				var trun = frm.truncado.value;
				var trun_pnivel = truncado_pnivel;
				
							
				
					//VALIDA NOTAS
					for (var zz=3;zz<document.frm.elements.length;zz++) //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(!validaNota(document.frm.elements[zz]))
								return false;

					var suma = 0;
					var prom=0;
					var cant;
					var prueba_nivel;
					
					
					//OBTENER PROMEDIOS
					for (var ff=23;ff<document.frm.elements.length;ff=ff+21){
						cant = 0;
						for (var xx=(ff-20);xx<(ff-1);xx++){ // (ff-1) para k calcule hasta la nota 19
							if (document.frm.elements[xx].value!=''){
								suma=(parseInt(suma)+parseInt(document.frm.elements[xx].value));
							
								cant++;
							}
						}
						prueba_nivel=document.frm.elements[xx].value; 

						if(prueba_nivel=='' && suma>0){
							prueba_nivel=0;
							porcentaje=0;
						}
						if(prueba_nivel!='' && suma>0){
							porcentaje=pct_nivel;
						}
						
										

						// calcular la nota con el porcentaje de la prueba de nivel 
//						prom=(round(suma/cant)*(100-pct_nivel)/100) + (parseInt(prueba_nivel)*pct_nivel/100);
						if(trun==1){
						    prom=(round(suma/cant)*(100-porcentaje)/100) + (parseInt(prueba_nivel)*porcentaje/100);
						}else{						    
							prom=(parseInt(suma/cant)*(100-porcentaje)/100) + (parseInt(prueba_nivel)*porcentaje/100);
										
						}
						if(cant!=0){
							if(trun==1){
								document.frm.elements[ff].value=round(prom,0);
							}else{
							      if (trun!=1){
								      if (trun_pnivel==1){
									      document.frm.elements[ff].value=round(prom,0);
									  }else{							
								          document.frm.elements[ff].value=parseInt(prom,0);
									  }	  
								  }	  			
							}
						}else{
								document.frm.elements[ff].value='';
						}
						suma=0;
						prom=0;
					}
				}


/************       promedio prueba de nivel  de tipo conceptual  ***********/
				function valida_prueba_nivel_conceptual(pct_nivel){ 
				var trun = frm.truncado.value;
					//VALIDA NOTAS
					for (var zz=3;zz<document.frm.elements.length;zz=zz+1){ //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(zz==3){
							var i=zz+19;
						}
						if(zz==i){
							if(!validaNotaConceptual(document.frm.elements[i]))
										return false;	
							i=i+21;
						}
						else{
							if(!validaNota(document.frm.elements[zz]))
										return false;
						}
					}

					var suma = 0;
					var prom=0;
					var cant;
					var nueva_nota;
					//OBTENER PROMEDIOS
					for (var ff=23;ff<document.frm.elements.length;ff=ff+21){
						cant = 0;
						for (var xx=(ff-20);xx<(ff-1);xx++){ // (ff-1) para k calcule hasta la nota 19
							if (document.frm.elements[xx].value!=''){
								suma=(parseInt(suma)+parseInt(document.frm.elements[xx].value));
								cant++;
							}
						}
						
						if (document.frm.elements[xx].value == "MB")
							nueva_nota = 65;
						if (document.frm.elements[xx].value == "B")
							nueva_nota = 55;			
						if (document.frm.elements[xx].value == "S")
							nueva_nota = 45;
						if (document.frm.elements[xx].value == "I")
							nueva_nota = 35;						
						// calcular la nota con el porcentaje de la prueba de nivel 
						prom=((suma/cant)*(100-pct_nivel)/100) + (parseInt(nueva_nota)*pct_nivel/100);
						if(cant!=0){
							if(trun==1){
								document.frm.elements[ff].value=round(prom,0);
							}else if (trun!=1){
								document.frm.elements[ff].value=parseInt(prom,0);			
							}
						}else{
								document.frm.elements[ff].value='';
						}
						suma=0;
						prom=0;
					}
				}


			</SCRIPT>
		<?php }?>

		<?php if($_MODOEVAL==2){ //EVALUACION CONCEPTUAL ?>
			<SCRIPT language="JavaScript">
			
				function validaNota(box){
					if(box.value.length==0)	
						return true; // acepta longitud 0		
					
						
					if(!notaConOnly(box,'Nota inválida. Usar letras MAYUSCULAS. '))
					    return false;
					return true;
				}
		
				function validaNotaNumerica(box){
					if(box.value.length==0)	
						return true; // acepta longitud 0
					if(!notaNroOnly(box,'Nota inválida.')) 
						return false;	
					return true;
				}

				function valida(instit, grado, ensenanza){ 
					//VALIDA NOTAS
					for (var zz=3;zz<document.frm.elements.length;zz++){ //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(!validaNota(document.frm.elements[zz]))
								return false;
					}			
                      
					 // alert(zz);
					
						var suma = 0;
						var cant;
						var nuevo;
						var prom;
						var letra = 'Z';
						//OBTENER PROMEDIOS
						
						for (var ff=23;ff<document.frm.elements.length;ff=ff+21){
							cant = 0;
							for (var xx=(ff-20);xx<(ff);xx++){
							
								if (document.frm.elements[xx].value!=''){
								
									if (document.frm.elements[xx].value == "MB")
										nuevo = 65;
									if (document.frm.elements[xx].value == "B")
										nuevo = 55;			
									if (document.frm.elements[xx].value == "S")
										nuevo = 45;
									if (document.frm.elements[xx].value == "I")
										nuevo = 35;						
								
									suma=(parseInt(suma)+parseInt(nuevo));
									cant++;
								
								}
							}
							
							if(cant!=0){
							
									prom = suma/cant;
							
									if (prom>=60 && prom<=70)
										letra = 'MB';
									if (prom>=50 && prom<=59)
										letra = 'B';
									if (prom>=40 && prom<=49)
										letra = 'S';
									if (prom>=0 && prom<=39)
										letra = 'I';
									document.frm.elements[ff].value=letra;
							
							}else{
							
									document.frm.elements[ff].value='';
							
							}
							suma=0;
						}
					
				}


/************       promedio prueba de nivel  de tipo numerica  ***********/
				function valida_prueba_nivel(pct_nivel){ 
				   
					//VALIDA NOTAS
					for (var zz=3;zz<document.frm.elements.length;zz=zz+1){ //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(zz==3){
							var i=zz+19;
						}
						if(zz==i){
							if(!validaNotaNumerica(document.frm.elements[i]))
										return false;	
							i=i+21;
						}
						else{
							if(!validaNota(document.frm.elements[zz]))
										return false;
						}
					}

					var suma = 0;
					var prom=0;
					var cant;
					var prueba_nivel;
					//OBTENER PROMEDIOS
					for (var ff=23;ff<document.frm.elements.length;ff=ff+21){
						cant = 0;
						for (var xx=(ff-20);xx<(ff-1);xx++){ // (ff-1) para k calcule hasta la nota 19
							if (document.frm.elements[xx].value!=''){
								if (document.frm.elements[xx].value == "MB")
									nueva_nota = 65;
								if (document.frm.elements[xx].value == "B")
									nueva_nota = 55;			
								if (document.frm.elements[xx].value == "S")
									nueva_nota = 45;
								if (document.frm.elements[xx].value == "I")
									nueva_nota = 35;						
								suma=(parseInt(suma)+parseInt(nueva_nota));
								cant++;
							}
						}
						prueba_nivel=document.frm.elements[xx].value; 

/*						if(prueba_nivel=='' && suma>0){
							prueba_nivel=0;
						}
*/						
						
						if(prueba_nivel=='' && suma>0){
							prueba_nivel=0;
							porcentaje=0;
						}
						if(prueba_nivel!='' && suma>0){
							porcentaje=pct_nivel;
						}						

						// calcular la nota con el porcentaje de la prueba de nivel 
//						prom=((suma/cant)*(100-pct_nivel)/100) + (parseInt(prueba_nivel)*pct_nivel/100);
						prom=(round(suma/cant)*(100-porcentaje)/100) + (parseInt(prueba_nivel)*porcentaje/100);

						if(cant!=0){
								if (prom>=60 && prom<=70)
									letra = 'MB';
								if (prom>=50 && prom<=59)
									letra = 'B';
								if (prom>=40 && prom<=49)
									letra = 'S';
								if (prom>=0 && prom<=39)
									letra = 'I';
								document.frm.elements[ff].value=letra;
						}else{
								document.frm.elements[ff].value='';
						}
						suma=0;
						prom=0;
					}
				}


/************       promedio prueba de nivel  de tipo conceptual  ***********/
				function valida_prueba_nivel_conceptual(pct_nivel){ 
					//VALIDA NOTAS
					for (var zz=3;zz<document.frm.elements.length;zz++) //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(!validaNota(document.frm.elements[zz]))
								return false;

					var suma = 0;
					var prom=0;
					var cant;
					var nueva_nota;
					var prueba_nivel;
					var letra;
					//OBTENER PROMEDIOS
					for (var ff=23;ff<document.frm.elements.length;ff=ff+21){
						cant = 0;
						for (var xx=(ff-20);xx<(ff-1);xx++){ // (ff-1) para k calcule hasta la nota 19
							if (document.frm.elements[xx].value!=''){
								if (document.frm.elements[xx].value == "MB")
									nueva_nota = 65;
								if (document.frm.elements[xx].value == "B")
									nueva_nota = 55;			
								if (document.frm.elements[xx].value == "S")
									nueva_nota = 45;
								if (document.frm.elements[xx].value == "I")
									nueva_nota = 35;						
								suma=(parseInt(suma)+parseInt(nueva_nota));
								cant++;
							}
						}
						prueba_nivel = document.frm.elements[xx].value;
						if (prueba_nivel == "MB")
							prueba_nivel = 65;
						if (prueba_nivel == "B")
							prueba_nivel = 55;			
						if (prueba_nivel == "S")
							prueba_nivel = 45;
						if (prueba_nivel == "I")
							prueba_nivel = 35;						
						// calcular la nota con el porcentaje de la prueba de nivel 
						prom=((suma/cant)*(100-pct_nivel)/100) + (parseInt(prueba_nivel)*pct_nivel/100);
						if(cant!=0){
							if (prom>=60 && prom<=70)
								letra = 'MB';
							if (prom>=50 && prom<=59)
								letra = 'B';
							if (prom>=40 && prom<=49)
								letra = 'S';
							if (prom>=0 && prom<=39)
								letra = 'I';
							document.frm.elements[ff].value=letra;
						}else{
								document.frm.elements[ff].value='';
						}
						suma=0;
						prom=0;
					}
				}

			</SCRIPT>
		<?php }?>

		<?php if($_MODOEVAL==3){ //EVALUACION NUMÉRICO CONCEPTUAL ?>
			<SCRIPT language="JavaScript">

				function validaNota(box){
					if(box.value.length==0)	
						return true; // acepta longitud 0
					if(!NotaNroPromCon(box,'Nota inválida.')) 
						return false;
					return true;
				}

				function round(number,X) {
					// rounds number to X decimal places, defaults to 2
					X = (!X ? 0 : X);
					return Math.round(number*Math.pow(10,X))/Math.pow(10,X);
				}

				function valida(instit, grado, ensenanza){ 
					var trun = frm.truncado.value;
					//VALIDA NOTAS
					for (var zz=3;zz<document.frm.elements.length;zz++){ //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(!validaNota(document.frm.elements[zz]))
								return false;
					}			

					if(instit==1517 && grado<5 && grado>=1 && ensenanza==110){
						var nada=1;
					} // fin if instit
					else{
						var suma = 0;
						var cant;
						var prom;
						var letra;
						//OBTENER PROMEDIOS
						for (var ff=23;ff<document.frm.elements.length;ff=ff+21){
							cant = 0;
							for (var xx=(ff-20);xx<(ff);xx++){
								if (document.frm.elements[xx].value!=''){
									suma=(parseInt(suma)+parseInt(document.frm.elements[xx].value));
									cant++;
								}
							}
							if(cant!=0){
									if(trun==1){
										prom = round((suma/cant),0);
									}
									if (trun!=1){
										prom = parseInt((suma/cant),0);
									}
									if(instit==999999999){
										if (prom>=61 && prom<=70)
											letra = 'MB';
										if (prom>=51 && prom<=60)
											letra = 'B';
										if (prom>=40 && prom<=50)
											letra = 'S';
										if (prom>=0 && prom<=39)
											letra = 'I';
											document.frm.elements[ff].value=letra;
									}else{
										if (prom>=60 && prom<=70)
											letra = 'MB';
										if (prom>=50 && prom<=59)
											letra = 'B';
										if (prom>=40 && prom<=49)
											letra = 'S';
										if (prom>=0 && prom<=39)
											letra = 'I';
									document.frm.elements[ff].value=letra;
									}
									
							}else{
									document.frm.elements[ff].value='';
							}
							suma=0;
						}
					} // fin else
				}
			</SCRIPT>
		<?php }?>


		<?php if($_MODOEVAL==4){ //EVALUACION CONCEPTUAL NUMÉRICO  ?>
			<SCRIPT language="JavaScript">

            //EVALUACION CONCEPTUAL NUMÉRICO 

				function validaNota(box){
					if(box.value.length==0)	
						return true; // acepta longitud 0
					if(!NotaNroPromCon(box,'Nota inválida.')) 
						return false;
					return true;
				}

				function valida(instit, grado, ensenanza){ 
					//VALIDA NOTAS
					for (var zz=3;zz<document.frm.elements.length;zz++){ //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(!validaNota(document.frm.elements[zz]))
								return false;
					}			

					if(instit==1517 && grado<5 && grado>=1 && ensenanza==110){
						var nada=1;
					} // fin if instit
					else{
						var suma = 0;
						var cant;
						var nueva_nota;
						var prom;
						//OBTENER PROMEDIOS
						for (var ff=23;ff<document.frm.elements.length;ff=ff+21){
							cant = 0;
							for (var xx=(ff-20);xx<(ff);xx++){
								if (document.frm.elements[xx].value!=''){
									if (document.frm.elements[xx].value == "MB")
										nueva_nota = 65;
									if (document.frm.elements[xx].value == "B")
										nueva_nota = 55;			
									if (document.frm.elements[xx].value == "S")
										nueva_nota = 45;
									if (document.frm.elements[xx].value == "I")
										nueva_nota = 35;						
									suma=(parseInt(suma)+parseInt(nueva_nota));
									cant++;
								}
							}
							if(cant!=0){
									prom = parseInt((suma/cant),0);
									if (prom>=65 && prom<=70)
										prom_nuevo = 70;
									if (prom>=60 && prom<=64)
										prom_nuevo = 60;
									if (prom>=55 && prom<=59)
										prom_nuevo = 55;
									if (prom>=50 && prom<=54)
										prom_nuevo = 50;								
									if (prom>=45 && prom<=49)
										prom_nuevo = 45;
									if (prom>=40 && prom<=44)
										prom_nuevo = 40;
									if (prom>=0 && prom<=39)
										prom_nuevo = 35;
									document.frm.elements[ff].value = prom_nuevo;			
							}else{
									document.frm.elements[ff].value='';
							}
							suma=0;
						}
					}	// fin else
				}
			</SCRIPT>
		<?php }?>
		
		<?php if($_MODOEVAL==5){ //EVALUACION CONCEPTUAL NUMÉRICO  ?>
			<SCRIPT language="JavaScript">

				function validaNota(box){
					if(box.value.length==0)	
						return true; // acepta longitud 0
					if(!NotaNroPromCon(box,'Nota inválida.')) 
						return false;
					return true;
				}

				function valida(instit, grado, ensenanza){ 
					//VALIDA NOTAS
					for (var zz=2;zz<document.frm.elements.length;zz++){ //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(!validaNota(document.frm.elements[zz]))
								return false;
					}
					
				}
			</SCRIPT>
		<?php }?>

<?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../../index.php";
		 </script>

<? } ?>
	
</head>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style>
.tachado {
    text-decoration: line-through;
}
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <? $menu_lateral="3_1";  include("../../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  
								  <!-- inicio codigo antiguo -->
								  
								  


	<?php //echo tope("../../../../../../util/");?>
	
	<FORM method="post" name="frm" id="frm" action="new_procesoIngreso.php3"  enctype="multipart/form-data" >
	  
		<TABLE WIDTH=90% BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>INSTITUCION</strong>
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
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
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
													$ano_act = trim($fila1['nro_ano']);
													echo $ano_act;
													$_ANOACTUAL = $ano_act;
												
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
									<strong>CURSO</strong>
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
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, tipo_ensenanza.cod_tipo FROM curso INNER JOIN 
											tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {

												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													$grado = $fila1['grado_curso'];
													$ensenanza = $fila1['cod_tipo'];
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
											$qry="SELECT subsector.nombre, modo_eval, truncado, prueba_nivel, pct_nivel, modo_eval_pnivel, truncado_pnivel,aprox_entero 
											FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
											$result =@pg_Exec($conn,$qry);
											if (pg_numrows($result)!=0){
												$fila10 = @pg_fetch_array($result,0);	
												echo trim($fila10['nombre']);
												$modo_eval_p_nivel = $fila10['modo_eval_pnivel'];
												$truncado_pnivel   = $fila10['truncado_pnivel'];
												$aprox_entero		=$fila10["aprox_entero"];
											}
										?>
										<?
										
										 if ($fila10[modo_eval]==1 || $fila10[modo_eval]==3){ ?>
											  <input name="truncado" type="hidden" value="<?php echo $fila10['truncado']; ?>">			
									<?  }else{ ?>
											  <input name="xxxxxxxx" type="hidden" value="0">
									<?  } ?>

									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>PERIODO</strong>
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
											$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$periodo;
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
													echo trim($fila1['nombre_periodo']);
												}
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
						 <?
						  $sql_busca = "SELECT * FROM notas$ano_act n INNER JOIN  ramo r ON r.id_ramo=n.id_ramo 
						  WHERE n.id_ramo=".$ramo." 
						  AND n.id_periodo=".$periodo." 
						  AND n.nota20 is not null AND n.nota20<>'0'";
						  $result_busca =@pg_Exec($conn,$sql_busca);
						  $p_nivel = @pg_numrows($result_busca);
					        ?>
						<TABLE>
							<TR>
								<TD>	
								<div id="botonguardar">	
								<INPUT class="botonXX" TYPE="button" value="GUARDAR" name="btnGUARDAR" onClick="return enviardatos(<?=$ramo.",".$periodo?>)" >
								</div>
								</TD>
								<TD>
								<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name="btnCancelar" onClick=document.location="new_mostrarNotas.php3">&nbsp;
								</TD>
							</TR>
						</TABLE>
						</TD>
						</TR>
						<TR height=20>
							<TD align=middle colspan=2 class="tableindex">INGRESO NOTAS</TD>
						</TR>
						<TR>
							<TD>
								<TABLE BORDER=1 CELLSPACING=2 CELLPADDING=2 width=100%>
								<?php
									//ALUMNOS DEL CURSO
//                                    $qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$ano_act.id_curso FROM (alumno INNER JOIN tiene$ano_act ON alumno.rut_alumno = tiene$ano_act.rut_alumno) WHERE tiene$ano_act.id_ramo=".$ramo."  ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc";
    	                                $qry="SELECT matricula.rut_alumno,alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$ano_act.id_curso, 
										matricula.nro_lista, matricula.bool_ar "; 
										$qry = $qry . " FROM alumno INNER JOIN tiene$ano_act ON alumno.rut_alumno = tiene$ano_act.rut_alumno ";
										$qry = $qry . " INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno AND matricula.id_curso=".$curso."";
										$qry = $qry . " WHERE tiene$ano_act.id_ramo=".$ramo." AND matricula.id_ano=".$ano." ";
										$qry = $qry . " AND matricula.bool_ar=0 ";
										$qry = $qry . " ORDER BY  matricula.nro_lista, ape_pat, ape_mat, nombre_alu, rut_alumno asc";
										$result =@pg_Exec($conn,$qry);

//echo $qry;
										//matricula.nro_lista asc,

									if(!$result)
										error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>');
									else{
										
if(pg_numrows($result)!=0){
										
											$fila1 = @pg_fetch_array($result,0);  // asigno el ultimo result a la variable fila 
											
												echo "<TR>";
												echo "<TD align=center>Nº";
												echo "</TD>";
												echo "<TD align=center >ALUMNO";
												echo "</TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(1º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(2º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(3º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(4º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(5º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(6º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(7º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(8º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(9º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(10º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(11º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(12º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(13º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(14º)</STRONG></FONT></TD>";

												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(15º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(16º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(17º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(18º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(19º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(20º)</STRONG></FONT></TD>";
												echo "<TD align=center>PROM";
												echo "</TD>";
												echo "</TR>";

//////////////////////////////////////////////////////////////////////////////////******************************************************////////////////////////////////
// CICLO X //
												$X=0;
												$m = 0;
												$n = 0;
											for($i=0 ; $i < @pg_numrows($result) ; $i++){   // el mismo resul lo recorro en ciclo 
												
												$X++;   // INICIO DE CONTADOR X 
												$Y=0;
												$fila1 = @pg_fetch_array($result,$i);
												
												if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
													if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
														?>
															<TR>
														<?php
													}else{
														echo "<TR class=textolink>";
													}
												}else{
													echo "<TR class=textolink>";
												}
												
												
			/////********** NUMERO DE LISTA RUT DE CASA ALUMNO ****/////////////////////////////////////////////
			//************************************************************************************************//
												
			echo "<TD align=left width=20 class=textolink>";
			if ($fila1["nro_lista"] != ""){
			echo  "<div id='nro_lista".$fila1["nro_lista"]."' >".$fila1["nro_lista"]."</div>";
			}else {
			echo  "<div id='nro_lista_".$X."' >".$X."</div>"; }
												 
			///////////////////////////////////////////////////////////////////////////////////////									 
			echo '<div id="'.$X.'" style="display:none;" >'.$fila1["rut_alumno"].'</div>'; 
			//PRENCENTO EL RUT EN UN DIV OCULTO PARA TOMARLO CON JAVASRIPT Y ENVIARLO POR $_POST
			 
																							
			echo "</TD>";
												
			if ($fila1['bool_ar'] == 1){
			echo "<TD align=left width=400  class=tachado>";
			echo  trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_alu"]);
													
			echo "</TD>";  
													  
			}else{	  
			echo "<TD align=left width=400 class=textolink>";
			echo  trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_alu"]);
			
			echo "</TD>";
			
			}
												
?>    

<?
//////////////////////////////////////////////////////////////////////////////////******************************************************////////////////////////////////
// CICLO Y //
		
												//NOTAS ALUMNO POR RAMO Y PERIODO   // buscando por rut alumno en el ARREGLO $FILA1
												$qry2="SELECT * FROM notas$ano_act WHERE 
												(((notas$ano_act.rut_alumno)=".$fila1['rut_alumno'].")  
												AND ((notas$ano_act.id_periodo)=".$periodo.") 
												AND ((notas$ano_act.id_ramo)=".$ramo."))"; 

												$result2 =@pg_Exec($conn,$qry2);
												
if (!$result2) 
		error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>');
else{
			if (pg_numrows($result2)!=0){
			$fila2 = @pg_fetch_array($result2,0);	
			
			if (!$fila2){
				error('<B> ERROR :</b>Error al acceder a la BD. (86)</B>');
				exit();
				};
														
// INICIO DE CICLO FOR J ///////////////////////////////////////////////////////////////
														
for($j=1;$j<22;$j++){  //  *** INICIO DE FOR ***  //
														
$Y++;  // INICIO DE Y
															
		$fila2 = @pg_fetch_array($result2,0);
		$var="nota"."$j";
		echo "<TD align=center width=100 >";
	
	if($m>0){
	   $n = $n+$m+1;
	   $m =0; 
	}else{
	   $n = $n+1; 
	  }	

				
		if ($Y==21){
		
		if ($fila10['modo_eval']==2){

if ((trim($fila2['promedio'])==MB) OR (trim($fila2['promedio'])==B) OR (trim($fila2['promedio'])==S) OR (trim($fila2['promedio'])==I) ){
echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") value=\"".trim($fila2['promedio'])."\" size=2  maxlength=2;>";
																		  }
																		  else{
																		     
echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") size=2  maxlength=2;>";
																		  }
																	}
																	if ($fila10['modo_eval']==1){
																		  if ($fila2['promedio']!=0){ 											
echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") value=\"".trim($fila2['promedio'])."\" size=2  maxlength=2;>";   
																		  }
																		  else{
																		     
echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.")  size=2  maxlength=2;>";
																		  }
																	}
																	if ($fila10['modo_eval']==3){
 if ((trim($fila2['promedio'])==MB) OR (trim($fila2['promedio'])==B) OR (trim($fila2['promedio'])==S) OR (trim($fila2['promedio'])==I)){
echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") value=\"".trim($fila2['promedio'])."\" size=2  maxlength=2;>";   
																		  }
																		  else{
																		     
echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.")  size=2  maxlength=2;>";

																		  }
																	}
										if ($fila10['modo_eval']==4){
    									  if ($fila2['promedio']!=0){
echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") value=\"".trim($fila2['promedio'])."\" size=2  maxlength=2;>";   
																		  }
else{
echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.")  size=2  maxlength=2;>";
																		  }
																	}
																	
                                          if ($fila10['modo_eval']==5){
                                            if (trim($fila2['promedio'])!="0"){
echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") value=\"".trim($fila2['promedio'])."\" size=2  maxlength=2;>";   
																		  }
																		  else{
																		     
echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.")  size=2  maxlength=2;>";
																		  }
																	}
															}
															
															
															else{

if ($fila10['modo_eval']==2){
																	
if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I) OR trim($fila2["$var"])!=0){  ?>

<INPUT TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($modifica==0 or $modifica==NULL){ ?>onFocus="chequear(this.form,this,<?=$n?>);" onClick="chequear(this.form,this,<?=$n?>);" style="color:#003366; background-color:#EC9282; " <? } ?>>

<? }else{  ?>

<INPUT TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)"  size="2"  maxlength="2" >

<? 
	   }
	}
																	if ($fila10['modo_eval']==1){
																		if(!strcmp($var,'nota20')){
																			 if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I)){
																				echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") value=\"".trim($fila2["$var"])."\"  size=2  maxlength=2;>";
																			 }
																			 else{
																				 if (trim($fila2["$var"])!=0){
																				     ?>
																					<INPUT TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)" value="<?=trim($fila2["$var"])?>"  size="2"  maxlength="2" <? if ($modifica==0 or $modifica==NULL){ ?> onFocus="chequear(this.form,this,<?=$n?>);" onClick="chequear(this.form,this,<?=$n?>);" style="color:#003366; background-color:#EC9282; " <? } ?>>
																					 <? 
																				 }
																				 else{
																					echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") size=2  maxlength=2;>";
																				}
																			 }
																		}
																		else{
																			 if (trim($fila2["$var"])!=0){
																			      ?>
																				  <INPUT TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)" value="<?=trim($fila2["$var"]) ?>"  size="2"  maxlength="2" <? if ($modifica==0 or $modifica==NULL){ ?> onFocus="chequear(this.form,this,<?=$n?>);" onClick="chequear(this.form,this,<?=$n?>);" style="color:#003366; background-color:#EC9282; " <? } ?>>
																				  <? 
																			 }
																			 else{
																			      ?>
																				   <INPUT TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)" size="2"  maxlength="2">
																				  <?
																			 }
																		}
																	 }
																	if ($fila10['modo_eval']==3){
																		  if (trim($fila2["$var"])!=0){ ?>
																		     
																			 <INPUT TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($modifica==0 or $modifica==NULL){ ?>onFocus="chequear(this.form,this,<?=$n?>);" onClick="chequear(this.form,this,<?=$n?>);" style="color:#003366; background-color:#EC9282; " <? } ?>>
																			 <?
																		  }else{  ?>
																		     <INPUT TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)"  size="2"  maxlength="2">
																			 <? 
																		  }
																	}
if ($fila10['modo_eval']==4){

if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I)){

																		       ?>

<INPUT TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)"  
value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if($modifica==0 or $modifica==NULL)
{ ?> onFocus="chequear(this.form,this,<?=$n?>);" onClick="chequear(this.form,this,<?=$n?>);" 
style="color:#003366; background-color:#EC9282; " <? } ?> >
				   <?  } else {  ?> 
<INPUT TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)"  size="2"  maxlength="2">
				   <?  }
					}
if ($fila10['modo_eval']==5){
if (trim($fila2["$var"])!="0"){ ?>

<INPUT TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)"  
value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($modifica==0 or $modifica==NULL){ ?> onFocus="chequear(this.form,this,<?=$n?>);" 
onClick="chequear(this.form,this,<?=$n?>);" style="color:#003366; background-color:#EC9282; " <? } ?>>

				 <? } else{ ?>

<INPUT TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)"  size="2"  maxlength="2">

<?
			 }
    	}
    }  

echo "\n";
echo "</TD>";   ///////////////////////////////////////////////////
               //*****CIERRE DE TD ATERIOR******// 

															
				}  // fin for j
	}	// fin if

else{   // CUANDO SE INSERTAN NOTAS POR PRIMERA VEZ
	
	if($n>0){
	  $m = $m+$n+1;
	  $n =0; 
	}else{
	   $m = $m+1; 
	  }
	
	echo "<TD align=center>";
	echo "<INPUT TYPE=text id=\"a_".$X."_1\"  NAME=\"a_".$X."_1\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_2\" NAME=\"a_".$X."_2\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_3\" NAME=\"a_".$X."_3\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_4\" NAME=\"a_".$X."_4\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_5\" NAME=\"a_".$X."_5\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_6\" NAME=\"a_".$X."_6\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_7\" NAME=\"a_".$X."_7\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_8\" NAME=\"a_".$X."_8\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_9\" NAME=\"a_".$X."_9\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_10\" NAME=\"a_".$X."_10\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_11\" NAME=\"a_".$X."_11\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_12\" NAME=\"a_".$X."_12\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_13\" NAME=\"a_".$X."_13\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_14\" NAME=\"a_".$X."_14\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_15\" NAME=\"a_".$X."_15\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_16\" NAME=\"a_".$X."_16\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_17\" NAME=\"a_".$X."_17\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_18\" NAME=\"a_".$X."_18\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_19\" NAME=\"a_".$X."_19\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_20\" NAME=\"a_".$X."_20\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";
	echo "<TD align=center>";
	$m = $m+1;
	echo "<INPUT TYPE=text id=\"a_".$X."_21\" NAME=\"a_".$X."_21\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=2;>";
	echo "</TD>";

													}
												};
										
												echo "</TD>";
												echo "</TR>";
												
											};

										};
								
								//**********************************OBTENGO LA CANTIDAD DE ALUMNOS EN LA LISTA *******************************************
								echo '<div id="cantidad_alumnos" style="display:none;" >'.$X.'</div>'; 
								//*************************************************************************************************************************	
                                					
									
									};
								?>
								</TABLE>							</TD>
						</TR>
						<!-- TR>
							<TD align=right>
								<?php 
									if($_MODOEVAL==1){ //EVALUACION NUMERICA
								?>
									<!--INPUT TYPE="button" value="PROM" name=btnPromedio onClick="document.frm.NP.value=promedio(this.form);"-->&nbsp;
								<?php }?>
							<!-- </TD> -->
						<!--</TR > -->
						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color=#003b85>										</TD>
									</TR>
								</TABLE>							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>
	<!--a href="promedio/proceso_promedio.php"> Promedios</a-->


 <? pg_close($conn);?>
								  
								  <!-- fin codigo antiguo -->
								
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?> </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>

<script language="javascript" src="../../../../../clases/ajax.js" ></script>
<script language="javascript" >

// FUNCION PARA TOMAR TODOS LOS DATOS DEL ALUMNO Y SUS NOTAS Y ENVIARLAS POR AJAX A UN ARCHIVO DE PROCESO PHP PARA 
// GUARDAR O MODIFICAR LA INFORMACION.

function enviardatos(ramo,periodo)  {   // inicio super funcion

<? 

echo "var dfer4433e = 'x';\n";

echo "dfer4433e = ";
// llamar a la nueva funcion para calcular el promedio, enviar $fila10['pct_nivel']	
if($fila10['prueba_nivel']==1 && $_MODOEVAL==1 && $p_nivel>0){	 

	if($modo_eval_p_nivel==2){ //prueba de nivel del tipo conceptual 

      echo "valida_prueba_nivel_conceptual(".$fila10['pct_nivel'].");\n";

        }else if($modo_eval_p_nivel==1){  /*prueba de nivel del tipo numerico*/	 

      echo "valida_prueba_nivel(".$fila10['pct_nivel'].",".$truncado_pnivel.");\n";
	
	  }
  
  }
  
// Modificar para el tipo conceptual
   
else if($fila10['prueba_nivel']==1 && $_MODOEVAL==2 && $p_nivel>0){	 

     if($modo_eval_p_nivel==2){	//prueba de nivel del tipo conceptual 
   
        echo "valida_prueba_nivel_conceptual(".$fila10['pct_nivel'].");\n";

        }else{ //prueba de nivel del tipo numerico	

          echo "valida_prueba_nivel(".$fila10['pct_nivel'].");\n";
        } 
	
	} else  /*if($_MODOEVAL==3 || $_MODOEVAL==4) */ {	 

			   if($aprox_entero!=null){
				$aprox_entero=$aprox_entero;
   			   }else{
				$aprox_entero=0;
				} 

		if($_MODOEVAL==1){ //EVALUACION NUMERICA 


		if ($aprox_entero == 1){ 
		echo "valida1"; }else{ echo "valida"; }
		echo "(".$institucion.",".$grado.",".$ensenanza.");\n";

			 }else{ 

		if ($aprox_entero == 1)
		{ echo "valida1"; }else{echo "valida";} 
		echo "(".$institucion.",".$grado.",".$ensenanza.");\n";
	

	 } 

	}
	
	echo "if (dfer4433e == true){
	
	//alert('Correcto');
	
	}else{
	
	//alert('Error');
	
	}\n";	

?>


if( dfer4433e != false ){ // INICIO


   dfer4433e = 'x';


   // INICIO DE VARIABLES
   var numramo = ramo;

   var numperiodo = periodo;
   var Formulario = document.getElementById('frm');
   var longitudFormulario = Formulario.elements.length;
   var cadenaFormulario = "";
   var sepCampos;
   sepCampos = "";
   var cant_alums = document.getElementById('cantidad_alumnos').firstChild.nodeValue;
   ajax = nuevoAjax();
   var Xreg = cant_alums;
   var cont = 0;
   var y = 0;
   var i = 0;
   var z = 0;
   // FIN VARIABLES


    var botonguardar = document.getElementById('botonguardar');
	botonguardar.innerHTML = '<img src="../../../../../clases/img_jquery/loading.gif">';
	
 
    var long = longitudFormulario ;

       for (var y=1;y<=cant_alums;y++) {  // INICIO FOR 1
	   	         
		   var rut = document.getElementById(y).firstChild.nodeValue;
			   
		   cadenaFormulario += sepCampos+"Xreg="+Xreg +"&rut_alumno"+y+"="+rut+"&numramo"+y+"="+numramo+"&numperiodo"+y+"="+periodo;
           sepCampos="&"; 
		      
			  for ( var e=1;e<=long;e++ ) { // INICIO FOR 2 " 
	
			   z++;
			   
				   if( cont != 21 ){ 
				   
					   if ( Formulario.elements[z].type != 'button' && Formulario.elements[z].type != 'submit' &&  Formulario.elements[z].type != 'hidden' ) {
						
cadenaFormulario += sepCampos+Formulario.elements[z].name+'='+encodeURI(Formulario.elements[z].value);
														
							cont++;
					
							}
							
							
							if (cont == 21){
							cont = 0; 
							break;
							}
							
					}
								
				} // TERMINO FOR 2*/
		
       } // TERMINO FOR 1		


		//alert(cadenaFormulario);
									  
			   ajax.open("POST","procesador_notas.php",true);
			   ajax.onreadystatechange = function() {
			   if (ajax.readyState == 4){
					  
				 document.getElementById('divrespuesta').innerHTML = ajax.responseText;
				 
				 //botonguardar.innerHTML  = '<INPUT class="botonXX" TYPE="button" value="Datos Guardados" name="Datos Guardados" >';
				 
				 window.location = 'new_mostrarNotas.php3?periodo='+periodo+'';
						  						  
					}
				}
		ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=ISO-8859-1');
		ajax.send(cadenaFormulario);
		cadenaFormulario = "";	   	
		// window.location = 'new_mostrarNotas.php3?periodo='+periodo+'';
	} // fin super funcion
} // FIN FIN 
</script>
<div id="divrespuesta"></div>  
</body>
</html>
