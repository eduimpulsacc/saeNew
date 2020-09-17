<?php require('../../../util/header.inc');?>
<?php 
    if ($_FRMMODO == NULL){
	   $_FRMMODO = "mostrar";
	}   

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	if ($md==1){
	   $empleado = $_NOMBREUSUARIO;
	   $_EMPLEADO = $_NOMBREUSUARIO;
	}else{	
	   $empleado		=$_EMPLEADO;
	   $_POSP          =3;
	}   
	//$empleado="88888888";


	$qry="SELECT * FROM INSTITUCION WHERE RDB=".$_INSTIT;
	$result =pg_Exec($conn,$qry);
	$fila = @pg_fetch_array($result,0);	
	$regINS = $fila['region'];
	$proINS = $fila['ciudad'];
	$comINS = $fila['comuna'];
	
	if ($usr==1){
	    $empleado  = $_NOMBREUSUARIO2;
		$_EMPLEADO = $_NOMBREUSUARIO2;
	}
	//echo  $empleado	;

?>
<? 

function chekear($num){
   global $fila;
   //echo "entro";
   //echo $num;
	if (($num==1)&&($fila[habilitado]==1)){echo " checked";}
	if (($num==2)&&($fila[titulado]==1)){echo " checked";}
	if (($num==3)&&($fila[tit_otras]==1)){echo " checked";}

}

?>
<?php
		$qryV ="select * from (supervisa inner join trabaja on supervisa.rut_emp=trabaja.rut_emp) where trabaja.rdb=".trim($institucion)." and supervisa.rut_emp='".trim($empleado)."'";
		$resultV = @pg_Exec($conn,$qryV);
		$filaV = @pg_fetch_array($resultV,0);
		/*echo $filaV["id_curso"];
		exit;*/
		if (@pg_numrows($resultV)>0){
			$qryVV="select * from (curso inner join ano_escolar on curso.id_ano=ano_escolar.id_ano) where ano_escolar.id_institucion=".$institucion." and curso.id_curso=".$filaV["id_curso"];
			$resultVV = pg_Exec($conn,$qryVV);
			if (pg_numrows($resultVV)>0){?>
				<SCRIPT language="JavaScript">///$resV=1;
				  if (document.frm.m1!=0 and document.frm.m2!=0 and document.frm.m3!=0){
				          window.alert("ESTE EMPLEADO ES PROFESOR JEFE. SI DESEA ELIMINARLO PRIMERO DEBE ASIGNAR UN NUEVO PROFESOR JEFE AL CURSO")
				  } 	</SCRIPT>
			<!--?php }else{ ?>
					<SCRIPT language="JavaScript">///$resV=1;
						document.location="seteaEmpleado.php3?caso=9";
					</SCRIPT-->
				
		<?php }}?>
	
	<?php
	if($frmModo!="ingresar"){
	    	
		$qry="SELECT trabaja.fecha_ingreso, trabaja.fecha_retiro, trabaja.cargo, empleado.*, empleado.rut_emp, empleado.foto FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((trabaja.rdb)=".trim($institucion).") AND ((empleado.rut_emp)=".trim($empleado)."))";
		$result = pg_Exec($conn,$qry);
		if (!$result) {
		    echo $qry;
			exit();
			 //error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
			}
		}
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
	}*/
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
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
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

<? if ($frmModo!="ingresar"){ ?>

<!--
function muestra_tabla(tabla,span){
	t=document.getElementById(tabla);
	span2=document.getElementById(span);
	temp=document.getElementById(tabla);
	document.getElementById('personal').style.display='none';
	document.getElementById('docente').style.display='none';
	document.getElementById('curriculum').style.display='none';
	document.getElementById('accesoweb').style.display='none';
	document.getElementById('grupos').style.display='none';
	document.getElementById('habilitado').style.display='none';
	document.getElementById('autorizacion').style.display='block';
	document.getElementById('pesta1').className='span_normal';
	document.getElementById('pesta2').className='span_normal';
	document.getElementById('pesta3').className='span_normal';
	document.getElementById('pesta4').className='span_normal';
	document.getElementById('pesta5').className='span_normal';
	t.style.display="";
	span2.className='span_seleccionado';
	

}

<? } ?>


function uno(span){
	
	document.getElementById('habilitado').style.display='block';
	document.getElementById('autorizacion').style.display='none';	

}

function dos(span){
	
	document.getElementById('habilitado').style.display='none';
	document.getElementById('autorizacion').style.display='block';	

}




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
<SCRIPT LANGUAGE="JavaScript"> 
		function confirmDelete() {  
			if(confirm("¿Esta seguro que desea eliminar?, ya que es sostenedor de la corporación"))
				{
					location.href="seteaEmpleado.php3?caso=9";
			}       
			}
    </SCRIPT>
<?php 
include('../../../util/rpc.php3');
?>


<?php if($frmModo!="mostrar"){?>

   <SCRIPT language="JavaScript">
         function valida3(form){
		 	  if(!chkVacio(form.h_fecha,'Ingresar Fecha.')){
					return false;
			  };

			  if(!chkFecha(form.h_fecha,'Fecha invalida.')){
					return false;
			  };
	           
			  if(!chkVacio(form.h_resolucion,'Ingresar número de resolucón.')){
					return false;
			  };
			
			  if(!chkVacio(form.h_inscripcion,'Ingresar número de inscripción.')){
					return false;
			  };	 
			 
			  if(form.cmb_subsector.value=='0'){
				alert ('Seleccionar Subsector.')
				form.cmb_subsector.focus();
				return false;
			  };
			  
			  if(form.cmb_tipoensenanza.value=='0'){
				 alert ('Seleccionar tipo de enseñanza.')
				 form.cmb_tipoensenanza.focus();
				 return false;
			  };			   
			   
			 document.form.Accion.value = "3";
			 document.form.submit();
		
		  }
	</script>
		  


		
	<?php if($frmModo=="modificar"){ ?>
		<SCRIPT language="JavaScript">
	
		function valida(form){
		
			if(form.cmbCARGO0.value=='0'){
				alert ('Seleccionar CARGO.')
				form.cmbCARGO0.focus();
				return false;
			};
			
				if(form.cmbCARGO0.value==form.cmbCARGO1.value){
					alert('Cargo 2 no puede ser igual a Cargo 1')
					form.cmbCARGO1.focus();
					return false;
				};

             if(!nroOnly(form.txtEXPERIENCIA,'Se permiten sólo números en el campo Años de Experiencia.')){
				  return false;
			  }; 

             if(!nroOnly(form.horasxclase,'Se permiten sólo números en el campo Nro. Horas por Contrato.')){
				  return false;
			  }; 
  
             if(!nroOnly(form.horasxcontrato,'Se permiten sólo números en el campo Nro. Horas por Clase.')){
				  return false;
			  };
			  			  
             if(!nroOnly(form.txtNROres,'Se permiten sólo números en el campo Nº RESOLUCION.')){
				  return false;
			  };
			  
                if(!chkVacio(form.txtFECHA,'Ingresar FECHA.')){
					return false;
				};
							  
				if(!chkFecha(form.txtFECHA,'Fecha invalida.')){
					return false;
				};			  

	   		  if(!chkVacio(form.txtRUT,'Ingresar RUT.')){
					return false;
			  };

			  if(!nroOnly(form.txtRUT,'Se permiten sólo números en el RUT.')){
					return false;
			  };
				
			  if(!chkVacio(form.txtDIGRUT,'Ingresar dígito verificador del RUT.')){
					return false;
			  };
				
			  if(!chkCod(form.txtRUT,form.txtDIGRUT,'RUT inválido.')){
					return false;
			  };
				
			  if (form.cmb.value==0){
					alert ('Ingrese por lo menos el primer cargo')	;
					return false;
			   } 
				
 				if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE.')){
					return false;
				};
				
				if(form.horasxclase.value!=''){
					if(!phoneOnly(form.horasxclase,'Se permiten sólo números en el campo Horas por Clase.')){
						return false;
					};
				};
				
				
				if(form.horasxcontrato.value!=''){
					if(!phoneOnly(form.horasxcontrato,'Se permiten sólo números en el campo Horas por Contrato.')){
						return false;
					};
				};
				
				
				if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
					return false;
				};
				if(!chkVacio(form.txtAPEPAT,'Ingresar APELLIDO PATERNO.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEPAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO PATERNO.')){
					return false;
				};

				if(!chkVacio(form.txtAPEMAT,'Ingresar APELLIDO MATERNO.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEMAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO MATERNO.')){
					return false;
				};

				if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
					return false;
				};

				if(form.txtTELEF.value!=''){
					if(!phoneOnly(form.txtTELEF,'Se permiten sólo números telefónicos en el campo TELEFONO.')){
						return false;
					};
				};

				if(form.txtEMAIL.value!=''){
					if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
						return false;
					};
				};
						/*
						if(!chkSelect2(f1.m1,'Seleccionar REGION.')){
							return false;
						};
						*/
						if(!chkSelect2(f2.m2,'Seleccionar PROVINCIA.')){
							return false;
						};

						if(!chkSelect2(f3.m3,'Seleccionar COMUNA.')){
							return false;
						};
			//alert ('hola');
				/*if(!alfaOnly(form.txtTITULO,'Se permiten sólo caracteres alfanuméricos en el campo TITULO.')){
					return false;
				};*/

				if(!chkSelect2(form.cmbSEXO,'Seleccionar SEXO.')){
					return false;
				};

				if(!chkSelect2(form.cmbCIVIL,'Seleccionar ESTADO CIVIL.')){
					return false;
				};

					
		   /*		if(!chkSelect2(form.cmb,'Seleccionar CARGO.')){
					return false;
				};  */

			
                if(!chkVacio(form.txtFECHA,'Ingresar FECHA.')){
					return false;
				};

				if(!chkFecha(form.txtFECHA,'Fecha invalida.')){
					return false;
				};



				if(!nroOnly(form.txtEXPERIENCIA,'Se permiten sólo números en el campo AÑOS DE EXPERIENCIA.')){
					return false;
				};				
				return true;
			}
		   function valida2(form){
		      if(!nroOnly(form.horasxclase,'Se permiten sólo números en el campo Horas x clase.')){
					return false;
			   };
			   
			   
			   if(!nroOnly(form.horasxcontrato,'Se permiten sólo números en el campo Horas x contrato.')){
					return false;
			   };
	   
			   
			   document.form.Accion.value = "3";
			   document.form.submit();
		
		
		   }		 
		  
		</SCRIPT>	
	<?php }?>
	
<?php }?>




<script language="javascript">
function valida3(form){
		      
	  if(!chkVacio(form.h_fecha,'Ingresar Fecha.')){
			return false;
	  };

	  if(!chkFecha(form.h_fecha,'Fecha invalida.')){
			return false;
	  };
	   
	  if(!chkVacio(form.h_resolucion,'Ingresar número de resolucón.')){
			return false;
	  };
	  
	  if(!nroOnly(form.h_resolucion,'Se permiten sólo numeros en el numero de resolucion.')){
		    return false;
	  };
	
	  if(!chkVacio(form.h_inscripcion,'Ingresar número de inscripción.')){
			return false;
	  };	 
	 
	  if(!nroOnly(form.h_inscripcion,'Se permiten sólo numeros en el numero de inscripción.')){
		    return false;
	  };
	  
	  if(!checkRadios(form.h_tipo_aut,'Debe elegir tipo de autorización.')){
		    return false;
	  };
	 
	  if(form.cmb_subsector.value=='0'){
		alert ('Seleccionar Subsector.')
		form.cmb_subsector.focus();
		return false;
	  };
	  
	  if(form.cmb_tipoensenanza.value=='0'){
		 alert ('Seleccionar tipo de enseñanza.')
		 form.cmb_tipoensenanza.focus();
		 return false;
	  }; 
	   
	   
	 document.form.Accion.value = "3";
	 document.form.submit();

}
</script>



<?
if ($frmModo!="ingresar"){ ?>

    <script language="javascript" type="text/javascript">
       function getElementObject(elementID) {
         var elemObj = null;
         if (document.getElementById) {
            elemObj = document.getElementById(elementID);
         }
         return elemObj;
       } 

       function mostrar_ocultar(obj){
          a=getElementObject(obj);
	      if (a.style.display==""){
		     a.style.display="none";
	      }else{
		     a.style.display="";
	      }
	   }

       function chekear(obj){
	     //a=getElementObject(obj);
	     a=window.document.frm.cod_subsector;
	     largo=	window.document.frm.cod_subsector.length;
		for (i=0;i<largo;i++)	{
	       if (a[i].checked==true){
		      a[i].checked=false;
	       }else{
		      a[i].checked=true;
		   }
        }
       }	

     function posicion(valor,nombre)
       {
        form=window.document.frm;
        largo=form.elements.length;	
	    for (i=0;i<largo;i++)	{
		   if ((form.elements[i].type=="checkbox")&&(form.elements[i].value==valor)&&(form.elements[i].name==nombre)){
		   return i;
		   }
	    }
     }

     function  titulado(obj,valor,nombre){
	    pos=posicion(valor,nombre);
	    pos++;
	    form=window.document.frm;
	    if (obj.checked==true){
		   form.elements[pos].checked=false;
	   }
	 }
    function tit_otras(obj,valor,nombre){
	    pos=posicion(valor,nombre);
    	pos--;
	    form=window.document.frm;
	    if (obj.checked==true){
		   form.elements[pos].checked=false;
	   }
    }
</script>
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>


<? } ?>
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
<?php if($frmModo=="ingresar"){ ?>
		<SCRIPT language="JavaScript">
			function valida(form){

				if(!nroOnly(form.txtNROres,'Se permiten sólo números en el campo Nº RESOLUCION.')){
					return false;
				};				
				
				if(!chkVacio(form.txtRUT,'Ingresar RUT.')){
					return false;
			    };

			    if(!nroOnly(form.txtRUT,'Se permiten sólo números en el RUT.')){
					return false;
			    };


			    if(!chkVacio(form.txtDIGRUT,'Ingresar dígito verificador del RUT.')){
					return false;
			    };
				
			    if(!chkCod(form.txtRUT,form.txtDIGRUT,'RUT inválido.')){
					return false;
			    };
				
				if(!chkSelect(form.cmbNac,'Seleccionar NACIONALIDAD.')){
						return false;
				};
				
				if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE.')){
					return false;
				};

				if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
					return false;
				}; 
				
				
				if(!chkVacio(form.txtAPEPAT,'Ingresar APELLIDO PATERNO.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEPAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO PATERNO.')){
					return false;
				};

				if(!chkVacio(form.txtAPEMAT,'Ingresar APELLIDO MATERNO.')){
					return false;
				};

			    if(!alfaOnly(form.txtAPEMAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO MATERNO.')){
					return false;
				};
				
				
				if(form.txtTELEF.value!=''){
						if(!phoneOnly(form.txtTELEF,'Se permiten sólo numeros telefónicos en el campo TELEFONO.')){
							return false;
						};
				};
				
				if(form.txtTELEF2.value!=''){
						if(!phoneOnly(form.txtTELEF2,'Se permiten sólo numeros telefónicos en el campo TELEFONO 2.')){
							return false;
						};
				};
				
				if(form.txtTELEF3.value!=''){
						if(!phoneOnly(form.txtTELEF3,'Se permiten sólo numeros telefónicos en el campo TELEFONO 3.')){
							return false;
						};
				};					
					
				
				if(form.txtEMAIL.value!=''){
					if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
						return false;
					};
				};
				
				
				
				if(!chkVacio(form.fecha_nacimiento,'Ingresar fecha de Nacimiento.')){
					 return false;
				}else{				    
					/* var fechanac0 = form.fecha_nacimiento.value;
					 if ((fechanac0.indexOf("-"))==-1){
						 alert('Error, Ingrese fecha en formato (ddformato de fecha puede no ser válido');
						 form.fecha_nacimiento.focus();
						 return false;						 
					 }	*/			
				}
				
				
				
				if(!chkVacio(form.fecha_ingreso,'Ingresar fecha de Ingreso a la institución.')){
					return false;
				}else{
				     var fechanac0 = form.fecha_ingreso.value;
					 /*if ((fechanac0.indexOf("-"))==-1){
						 alert('Error, formato de fecha puede no ser válido');
						 form.fecha_ingreso.focus();
						 return false;
					 }*/				
				}				
							
				
				if(!chkVacio(form.prevision,'Ingresar Previsión.')){
					return false;
				};				
				
				if(!chkVacio(form.sistema_salud,'Ingresar sistema de salud.')){
					return false;
				};
				
				if(!chkVacio(form.horas_presente_ano,'Ingresar horas de trabajo.')){
					return false;
				};
				
				
				if(form.cmbCIVIL.value=='0'){
					alert ('Seleccionar ESTADO CIVIL.')
					form.cmbCIVIL.focus();
					return false;
				};
				
				
				if(form.cmbSEXO.value=='0'){
					alert ('Seleccionar SEXO.')
					form.cmbSEXO.focus();
					return false;
				};
				
				

				if(form.cmbCARGO1.value=='0'){
					alert ('Seleccionar CARGO.')
					form.cmbCARGO1.focus();
					return false;
				};


				if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
					return false;
				};

				if(form.txtTELEF.value!=''){
					if(!phoneOnly(form.txtTELEF,'Se permiten sólo números telefónicos en el campo TELEFONO.')){
						return false;
					};
				};

				if(!nroOnly(form.txtEXPERIENCIA,'Se permiten sólo números en el campo AÑOS DE EXPERIENCIA.')){
					return false;
				};
				
				if(form.horasxclase.value!=''){
					if(!phoneOnly(form.horasxclase,'Se permiten sólo números en el campo Horas por Clase.')){
						return false;
					};
				};
				
				
				if(form.horasxcontrato.value!=''){
					if(!phoneOnly(form.horasxcontrato,'Se permiten sólo números en el campo Horas por Contrato.')){
						return false;
					};
				};							

				

				if(!alfaOnly(form.txtTITULO,'Se permiten sólo caracteres alfanuméricos en el campo TITULO.')){
					return false;
				};
				 
				

				
				function Confirmacion()
				{
					if(confirm('¿Esta seguro de querer realizar esta operación?') == false) 
					{
						return; 
					}
						document.form.Accion.value = "3";
						document.form.submit();
				}

				return true;
			}
		</SCRIPT>
	<?php }?>
	
	
<script language="javascript1.1">
function enviapag(form){
    form.action = 'empleado.php3?pesta=2&m1=1';
	form.submit(true);
}


function SwitchMenuAnotacion(obj){  
   
	var el = document.getElementById(obj);
	var ar = document.getElementById("masterdiv3").getElementsByTagName("span"); //DynamicDrive.com change
		
	   
	    if (el.className=="habilitado"){
	       el.style.display = "block";		   
		   for (var i=0; i<ar.length; i++){
				if (ar[i].className=="autorizacion") //DynamicDrive.com change
				ar[i].style.display = "none";			
				
			}
		   
		   
	    }
	
	    if (el.className=="autorizacion"){
	       el.style.display = "block";		   
		   for (var i=0; i<ar.length; i++){
				if (ar[i].className=="habilitado") //DynamicDrive.com change
				ar[i].style.display = "none";			   
				   
			}
	    }	
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.Estilo2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>
<SCRIPT LANGUAGE="JavaScript">


function ChequearTodos(chkbox)
{
	for (var i=0;i < document.forms[1].elements.length;i++)
	{
		var elemento = document.forms[1].elements[i];		
		if (elemento.type == "checkbox")
		{
			elemento.checked = chkbox.checked
		}
	}
}
</script>
<script language="javascript">
//**********************************************************************************************************//
//-------------------------------------- CARGA ARREGLO PROVINCIA, COMUNA -----------------------------------//
//**********************************************************************************************************//
        //------------------------ PROVINCIA -----------------------------------//
                var ArrayProvincia = new Array();
                var contador_provincia;
                <?php        $SQL = "SELECT cor_pro,cod_reg,nom_pro FROM provincia ORDER BY nom_pro";
                                $Conexion = @pg_exec($conn,$SQL);
                                $i=0;
                                if (!$Conexion)
                                {
                                        echo("</script><br><center><table><tr><td><b>No se pudo establecer comunicación con la base de datos 1 </b></td></tr></table></center>");
                                        exit();
                                }
                                if (@pg_numrows($Conexion)!=0)
                                { 
                                        $filsprov = @pg_fetch_array($Conexion,0);
                                        for ($i=0;$i<@pg_numrows($Conexion);$i++)
                                        {
                                                $filsprov = @pg_fetch_array($Conexion,$i); ?>
                                                var ArrayFilProv = new Array(3);
                                                ArrayFilProv[0] = '<?php echo Trim($filsprov["cor_pro"])?>';
                                                ArrayFilProv[1] = '<?php echo Trim($filsprov["cod_reg"])?>';
                                                ArrayFilProv[2] = '<?php echo Trim($filsprov["nom_pro"])?>';
                                                ArrayProvincia[<?php echo $i?>] = ArrayFilProv;
                <?php                }
                                }
                                @pg_close($Conexion); ?>
                                contador_provincia = <?php echo $i?>;
        //---------------------- FIN PROVINCIA ---------------------------------//

        //-------------------------- COMUNA ------------------------------------//
                var ArrayComuna = new Array();
                var contador_comuna;
                <?php        $SQL = "SELECT cor_com,cor_pro,cod_reg,nom_com FROM comuna ORDER BY nom_com";
                                $Conexion = @pg_exec($conn,$SQL);
                                $i=0;
                                if (!$Conexion){
                                        echo("</script><br><center><table><tr><td><b>No se pudo establecer comunicación con la base de datos 2 </b></td></tr></table></center>");
                                        exit();
                                };
                                if (@pg_numrows($Conexion)!=0){
                                        $filscom = @pg_fetch_array($Conexion,0);
                                        for ($i=0;$i<@pg_numrows($Conexion);$i++){
                                                $filscom = @pg_fetch_array($Conexion,$i); ?>
                                                var ArrayFilCom = new Array(4);
                                                ArrayFilCom[0] = '<?php echo Trim($filscom["cor_com"])?>';
                                                ArrayFilCom[1] = '<?php echo Trim($filscom["cor_pro"])?>';
                                                ArrayFilCom[2] = '<?php echo Trim($filscom["cod_reg"])?>';
                                                ArrayFilCom[3] = '<?php echo Trim($filscom["nom_com"])?>';
                                                ArrayComuna[<?php echo $i?>] = ArrayFilCom;
                <?php                };
                                };
                                @pg_close($Conexion); ?>
                                contador_comuna = <?php echo $i; ?>;

        //----------------------- FIN COMUNA -----------------------------------//

//**********************************************************************************************************//
//-------------------------------------------- FIN ARREGLOS ------------------------------------------------//
//**********************************************************************************************************//

//**********************************************************************************************************//
//-------------------------------------------- LLENA COMBO -------------------------------------------------//
//**********************************************************************************************************//

        //----------------------- PROVINCIA-----------------------------------//
function LlenaProvincia(){
        var id_search;
        if (document.frm.Region.options.selectedIndex!=-1 || document.frm.Region.options[document.frm.Region.options.selectedIndex].value!="null"){
                id_search = document.frm.Region.options[document.frm.Region.options.selectedIndex].value;
                if (id_search!=""){
                        document.frm.Provincia.length = 0;
                        document.frm.Provincia.options[document.frm.Provincia.options.length++] = new Option("Seleccionar Provincia");
                        document.frm.Provincia.options[document.frm.Provincia.options.length - 1].value = "null";
                        document.frm.Comuna.length = 0;
                        document.frm.Comuna.options[document.frm.Comuna.options.length++] = new Option("Seleccionar Comuna");
                        document.frm.Comuna.options[document.frm.Comuna.options.length - 1].value = "null";
                        for(i=0;i<=contador_provincia-1;i++){
                                if (id_search==ArrayProvincia[i][1]){
                                        document.frm.Provincia.options[document.frm.Provincia.options.length++] = new Option(ArrayProvincia[i][2]);
                                        document.frm.Provincia.options[document.frm.Provincia.options.length - 1].value = ArrayProvincia[i][0];
                                };
                        };
                };
        };
};
        //--------------------- FIN PROVINCIA---------------------------------//

        //------------------------- COMUNA ------------------------------------//
                function LlenaComuna(){
                        var id_search,id_search_aux;
                        if (document.frm.Provincia.options.selectedIndex!=-1 || document.frm.Provincia.options[document.frm.Provincia.options.selectedIndex].value!="null"){
                                id_search = document.frm.Region.options[document.frm.Region.options.selectedIndex].value; 
                                id_search_aux = document.frm.Provincia.options[document.frm.Provincia.options.selectedIndex].value;
                                if (id_search!=""){
                                        document.frm.Comuna.length = 0;
                                        document.frm.Comuna.options[document.frm.Comuna.options.length++] = new Option("Seleccionar Comuna");
                                        document.frm.Comuna.options[document.frm.Comuna.options.length - 1].value = "null";
                                        for(i=0;i<=contador_comuna-1;i++){
                                                if (id_search==ArrayComuna[i][2] && id_search_aux==ArrayComuna[i][1]){
                                                        document.frm.Comuna.options[document.frm.Comuna.options.length++] = new Option(ArrayComuna[i][3]);
                                                        document.frm.Comuna.options[document.frm.Comuna.options.length - 1].value = ArrayComuna[i][0];
                                                };
                                        };
                                };
                        };
                };
        //----------------------- FIN COMUNA -----------------------------------//

//**********************************************************************************************************//
//----------------------------------------- FIN LLENA COMBO ------------------------------------------------//
//**********************************************************************************************************//
  
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="
<?

if ($frmModo!="ingresar"){ 
   if (($pesta == "") or ($pesta == NULL) or ($pesta == " ") or ($pesta == 1) or (!isset($pesta))){ ?>
      muestra_tabla('personal','pesta1'); <?
   } 
   if ($pesta == 2){ ?>
      muestra_tabla('docente','pesta2');
	  <?
	  if ($m1==1){ ?>
	       uno();
		   
	<? }else{ ?>
	       dos();
	<? }
		  
   }
   if ($pesta == 3){ ?>
      muestra_tabla('curriculum','pesta3'); <?
	  
   }	   
   
   
   if ($pesta == 4){ ?>
      muestra_tabla('accesoweb','pesta4'); <?
   }
   if ($pesta == 5){ ?>
      muestra_tabla('grupos','pesta5'); <?
   }   
}
 ?>
MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top">	
	  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="90%"  align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3">
				<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
					
                      <td width="27%" height="363" align="left" valign="top"> 
                      <?  include("../../../menus/menu_lateral.php"); ?>  </td>
                      <td width="100%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td width="700" height="395" align="left" valign="top"> 
                              <table width="700" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!-- inicio codigo antiguo -->
								  
								  


<? if ($frmModo == "ingresar"){ ?>
			
	<FORM method="post" name="frm" action="procesoEmpleado.php3">
	  <INPUT type="hidden" name="txtREG">
	  <INPUT type="hidden" name="txtCIU">
	  <INPUT type="hidden" name="txtCOM">
				          
     <table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td colspan="4" class="tableindex">PERSONAL</td>
  </tr>
  <tr>
    <td colspan="4"><div align="right">
		<? if($ingreso==1){?>
	   <INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
	   <INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarEmpleado.php3">
	   <? } ?>
       </div>	</td>
  </tr>		
	
	
	<table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolor="#666666">	
  <tr>
    <td width="25%" class="cuadro02"><b>RUT (*)</b> </td>
    <td width="25%"><table width="100" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="cuadro01">
          <input name="txtRUT" type="text" id="txtRUT" size="10" maxlength="10">
        </td>
        <td width="2" class="cuadro01">-</td>
        <td class="cuadro01">
          <input type="text" name="txtDIGRUT" size="1" maxlength="1" />
        </td>
      </tr>
    </table></td>
    <td width="25%" class="cuadro02"><b>NACIONALIDAD</b></td>
    <td width="25%" class="cuadro01">
      <select name="cmbNac">
        <option value=0 selected></option>
        <option value=2>Chilena</option>
        <option value=1>Extranjera</option>
      </select>
    </td>
  </tr>
  <tr>
    <td class="cuadro02"><b>NOMBRES (*)</b> </td>
    <td class="cuadro01"><input type="text" name=txtNOMBRE size=25 maxlength=50 /></td>
    <td class="cuadro02"><b>APELLIDO PATERNO (*)</b></td>
    <td class="cuadro01"><input type="text" name=txtAPEPAT size=25 maxlength=50 /></td>
  </tr>
  <tr>
    <td class="cuadro02"><b>APELLIDO MATERNO (*)</b></td>
    <td class="cuadro01">
      <input type="text" name=txtAPEMAT size=25 maxlength=50 />
    </td>
    <td class="cuadro02"><b>TELEFONO</b></td>
    <td class="cuadro01">
      <input type="text" name="txtTELEF" size="20" maxlength="30" />
    </td>
  </tr>
  <tr>
    <td class="cuadro02"><b>TELEFONO2</b></td>
    <td class="cuadro01">
      <input type="text" name="txtTELEF2" size="20" maxlength="30" />
    </td>
    <td class="cuadro02"><b>TELEFONO3</b></td>
    <td class="cuadro01"><input type="text" name="txtTELEF3" size="20" maxlength="30" /></td>
  </tr>
  <tr>
    <td class="cuadro02"><b>EMAIL</b></td>
    <td class="cuadro01">
      <input type="text" name=txtEMAIL size=40 maxlength=50 />
    </td>
    <td class="cuadro02"><b>ESTADO CIVIL</b> </td>
    <td class="cuadro01">
      <select name="cmbCIVIL" >
        <option value=0 selected></option>
        <option value=1 >Soltero(a)</option>
        <option value=2 >Casado(a)</option>
        <option value=3 >Viudo(a)</option>
      </select>
    </td>
  </tr>
  
  
  <tr>
    <td class="cuadro02"><b>FECHA DE NACIMIENTO</b></td>
    <td class="cuadro01">
      <input type="text" name=fecha_nacimiento size=15 maxlength=15 /> ej.(dd-mm-aaaa)
    </td>
    <td class="cuadro02"><b>FECHA DE INGRESO</b> </td>
    <td class="cuadro01">
      <input type="text" name=fecha_ingreso size=15 maxlength=15 /> ej.(dd-mm-aaaa)
    </td>
  </tr>
  
  <tr>
    <td class="cuadro02"><b>PREVISION (AFP)</b></td>
    <td class="cuadro01">
      <input type="text" name=prevision size=15 maxlength=15 />
    </td>
    <td class="cuadro02"><b>SISTEMA DE SALUD</b> </td>
    <td class="cuadro01">
      <input type="text" name=sistema_salud size=15 maxlength=15 />
    </td>
  </tr>
  
  <tr>
    <td class="cuadro02"><b>HORAS PRESENTE AÑO</b></td>
    <td class="cuadro01">
      <input type="text" name=horas_presente_ano size=15 maxlength=15 />
    </td>
    <td class="cuadro02"><b>&nbsp;</b> </td>
    <td class="cuadro01">&nbsp; </td>
  </tr>
  
  
  
  <tr>
    <td class="cuadro02"><b>SEXO</b></td>
    <td class="cuadro01">
      <select name="cmbSEXO" >
        <option value=0 selected></option>
        <option value=1 >Masculino</option>
        <option value=2 >Femenino</option>
      </select>
    </td>
    <td class="cuadro02"><b>CARGO 1</b></td>
    <td class="cuadro01">
	  <select name="cmbCARGO1">
      <option value=0 selected></option>
      <option value=1 >Director(a)</option>
      <option value=2 >Jefe UTP</option>
      <option value=3 >Enfermeria</option>
      <option value=4 >Contador(a)</option>
      <option value=5 >Docente</option>
      <option value=6 >Sub-Director</option>
      <option value=7 >Inspector General</option>
      <option value=8 >Titulaci&oacute;n</option>
      <option value=9 >Curriculista</option>
      <option value=10 >Evaluador</option>
      <option value=11 >Orientador(a)</option>
      <option value=12 >Sicopedagogo(a)</option>
      <option value=13 >Sic&oacute;logo(a)</option>
      <option value=14 >Inspector(a)</option>
      <option value=15 >Auxiliar</option>
      <option value=16 >Coordinaci&oacute;n CRA</option>
      <option value=17 >Coordinaci&oacute;n Pastoral</option>
      <option value=18 >Coordinaci&oacute;n ACLE</option>
      <option value=19 >Secretaria</option>
      <option value=20 >Tesorero(a)</option>
      <option value=21 >Asistente Social</option>
      <option value=22 >Coordinaci&oacute;n Mantenimiento</option>
	  <option value=23 >Rector</option>
	  <option value=24 >Administrativo</option>
	  <option value=27 >Jefe de Departamento</option>
	  <option value=28 >Asistente de Parvulos</option>
	  <option value=29 >Bibliotecologo</option>
	  <option value=30 >Coordinador Acad&eacute;mico</option>
	  <option value=31 >Asistente Social</option>
	  <option value=32 >Capellan</option>
      <option value=33 >Educador Diferencial</option>
      <option value=34 >Educador de Parvulos</option>
	  <option value=35 >Director Básica</option>
	  <option value=36 >Director Media</option>
	  <option value=37 >Director Pre-Básica</option>
    </select></td>
  </tr>
  <tr>
    <td class="cuadro02"><b>CARGO 2 </b></td>
    <td class="cuadro01">
      <select name="cmbCARGO2">
        <option value=0 selected></option>
        <option value=1 >Director(a)</option>
        <option value=2 >Jefe UTP</option>
        <option value=3 >Enfermeria</option>
        <option value=4 >Contador(a)</option>
        <option value=5 >Docente</option>
        <option value=6 >Sub-Director</option>
        <option value=7 >Inspector General</option>
        <option value=8 >Titulaci&oacute;n</option>
        <option value=9 >Curriculista</option>
        <option value=10 >Evaluador</option>
        <option value=11 >Orientador(a)</option>
        <option value=12 >Sicopedagogo(a)</option>
        <option value=13 >Sic&oacute;logo(a)</option>
        <option value=14 >Inspector(a)</option>
        <option value=15 >Auxiliar</option>
        <option value=16 >Coordinaci&oacute;n CRA</option>
        <option value=17 >Coordinaci&oacute;n Pastoral</option>
        <option value=18 >Coordinaci&oacute;n ACLE</option>
        <option value=19 >Secretaria</option>
        <option value=20 >Tesorero(a)</option>
        <option value=21 >Asistente Social</option>
        <option value=22 >Coordinaci&oacute;n Mantenimiento</option>
		<option value=23 >Rector</option>
		<option value=24 >Administrativo</option>
		<option value=27 >Jefe de Departamento</option>
		<option value=28 >Asistente de Parvulos</option>
   	    <option value=29 >Bibliotecologo</option>
	    <option value=30 >Coordinador Acad&eacute;mico</option>
	    <option value=31 >Asistente Social</option>
    	<option value=32 >Capellan</option>
        <option value=33 >Educador Diferencial</option>
      	<option value=34 >Educador de Parvulos</option>
		<option value=35 >Director Básica</option>
		<option value=36 >Director Media</option>
		<option value=37 >Director Pre-Básica</option>
      </select>
   </td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02"><b>MANEJO DE IDIOMAS</b></td>
    <td class="cuadro01"><input name="txtIDIOMAS" type="text" id="txtIDIOMAS" size="30" maxlength="100" />
    </td>
    <td class="cuadro02"><b>A&Ntilde;OS DE EXPERIENCIA </b></td>
    <td class="cuadro01"><input name="txtEXPERIENCIA" type="text" id="txtEXPERIENCIA" size="5" maxlength="5" /></td>
  </tr>
  <tr>
    <td class="cuadro02"><b>DIA Y HORARIO DE ATENCI&Oacute;N</b></td>
    <td class="cuadro01"><input name="txtAtencion" type="text" size="30" maxlength="100" /></td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
  </tr>
</table>


<br /><br>
<table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolor="#666666">
  <tr>
    <td colspan="4" class="tableindex"><b>AUTORIZACION EJERCICIO DOCENTE</b> </td>
  </tr>
  <tr>
    <td width="20%" class="cuadro02"><b>N&ordm; RESOLUCION </b></td>
    <td width="25%" class="cuadro01"><input type="text" name="txtNROres" size="20" maxlength="10" onChange="nroOnly(form.txtNROres,'Número Invalido.');" /></td>
    <td width="20%" class="cuadro02"><b>NIVEL</b></td>
    <td width="30%" class="cuadro01"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="cuadro01"><label>
          <input type="checkbox" name="hab" value="1" />
        </label></td>
        <td><font face="Geneva, Arial, Helvetica, sans-serif" size="1"><b>HABILIDADO</b></font></td>
        <td class="cuadro01"><input type="checkbox" name="te" value="1" /></td>
        <td><font face="Geneva, Arial, Helvetica, sans-serif" size="1"><b>TITULADO EN EDUCACION</b> </font> </td>
        <td class="cuadro01"><input type="checkbox" name="to" value="1" /></td>
        <td><font face="Geneva, Arial, Helvetica, sans-serif" size="1"><b>TITULADO EN OTRAS AREAS</b> </font></td>
      </tr>
    </table></td>
  </tr>

  <tr>
    <td class="cuadro02"><b>FECHA</b></td>
    <td class="cuadro01"><input type="text" name="txtFECHA" size="20" maxlength="10" onChange="chkFecha(form.txtFECHA,'Fecha invalida.');" /></td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02"><b>TITULO</b></td>
    <td class="cuadro01"><input type="text" name="txtTITULO_1" size=30 maxlength=1000 /></td>
    <td class="cuadro02"><b>INSTITUCION</b></td>
    <td class="cuadro01"><input name="institucion_1" type="text" id="institucion1" /></td>
  </tr>
  <tr>
    <td class="cuadro02"><b>AÑO</b></td>
    <td class="cuadro01"><input name="a&ntilde;o_1" type="text" id="a&ntilde;o1" size="5" maxlength="4" />
    </td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02"><b>TITULO2</b></td>
    <td class="cuadro01"><input type="text" name="txtTITULO_2" size=30 maxlength=1000 /></td>
    <td class="cuadro02"><b>INSTITUCION 2</b></td>
    <td class="cuadro01"><input name="institucion_2" type="text" id="institucion2" /></td>
  </tr>
  <tr>
    <td class="cuadro02"><b>AÑO</b></td>
    <td class="cuadro01"><input name="a&ntilde;o_2" type="text" id="a&ntilde;o2" size="5" maxlength="4" /></td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02"><b>TITULO2</b></td>
    <td class="cuadro01"><input type="text" name="txtTITULO_3" size=30 maxlength=1000 /></td>
    <td class="cuadro02"><b>INSTITUCION 3</b></td>
    <td class="cuadro01"><input name="institucion_3" type="text" id="institucion3" /></td>
  </tr>
  <tr>
    <td class="cuadro02"><b>A&Ntilde;O</b></td>
    <td class="cuadro01"><input name="a&ntilde;o_3" type="text" id="a&ntilde;o3" size="5" maxlength="4" /></td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02"><b>POSTITULO 1 </b></td>
    <td class="cuadro01"><input name="txtPOSTITULO_1" type="text" size=30 maxlength=1000 />
    </td>
    <td class="cuadro02"><b>POSTITULO 2  </b></td>
    <td class="cuadro01"><input name="txtPOSTITULO_2" type="text" size=30 maxlength=1000 />
    </td>
  </tr>
  <tr>
    <td class="cuadro02"><b>POSTGRADO 1 </b></td>
    <td class="cuadro01"><input name="txtPOSTGRADO_1" type="text" size=30 maxlength=1000 />
    </td>
    <td class="cuadro02"><b>POSTGRADO 2 </b></td>
    <td class="cuadro01"><input name="txtPOSTGRADO_2" type="text" size=30 maxlength=1000 />
    </td>
  </tr>
  <tr>
    <td class="cuadro02"><b>CURSOS RECONOCIDOS 1 </b></td>
    <td class="cuadro01"><input name="txtCURSO_1" type="text" size=30 maxlength=1000 /></td>
    <td class="cuadro02"><b>AÑO</b></td>
    <td class="cuadro01"><input name="ano_curso_1" type="text" id="ano_curso1" size="5" maxlength="4" />
    </td>
  </tr>
  <tr>
    <td class="cuadro02"><b>HORAS</b></td>
    <td class="cuadro01"><input name="horas_curso_1" type="text" id="horas_curso1" size="5" maxlength="4" />
    </td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02"><b>CURSOS RECONOCIDOS 2 </b></td>
    <td class="cuadro01"><input name="txtCURSO_2" type="text" size=30 maxlength=1000 />
    </td>
    <td class="cuadro02"><b>ANO</b></td>
    <td class="cuadro01"><input name="ano_curso_2" type="text" id="ano_curso2" size="5" maxlength="4" />
    </td>
  </tr>
  <tr>
    <td class="cuadro02"><b>HORAS</b></td>
    <td class="cuadro01"><input name="horas_curso_2" type="text" id="horas_curso2" size="5" maxlength="4" />
    </td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02"><b>CURSOS RECONOCIDOS 3 </b></td>
    <td class="cuadro01"><input name="txtCURSO_3" type="text" size=30 maxlength=1000 />
    </td>
    <td class="cuadro02"><b>A&Ntilde;O </b></td>
    <td class="cuadro01"><input name="ano_curso_3" type="text" id="ano_curso3" size="5" maxlength="4" />
    </td>
  </tr>
  <tr>
    <td class="cuadro02"><b>HORAS </b></td>
    <td class="cuadro01"><input name="horas_curso_3" type="text" id="horas_curso3" size="5" maxlength="4" /></td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02"><b>CURSOS RECONOCIDOS 4 </b></td>
    <td class="cuadro01"><input name="txtCURSO_4" type="text" size=30 maxlength=1000 /></td>
    <td class="cuadro02"><b>AÑO</b></td>
    <td class="cuadro01"><input name="ano_curso_4" type="text" id="ano_curso4" size="5" maxlength="4" /></td>
  </tr>
  <tr>
    <td class="cuadro02"><b>HORAS </b></td>
    <td class="cuadro01"><input name="horas_curso_4" type="text" id="horas_curso4" size="5" maxlength="4" /></td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02"><b>RESUMEN DE ESTUDIOS </b> </td>
    <td class="cuadro01"><textarea name="txtESTUDIOS" cols="25" rows="3"></textarea></td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
  </tr>
</table>
<br>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td colspan="4" class="tableindex">DIRECCION</td>
  </tr>
</table>
  
<table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolor="#666666">
  <tr>
    <td width="25%" class="cuadro02"><b>CALLE (*) </b> </td>
    <td width="25%" class="cuadro01"><input type="text" name=txtCALLE size=30 maxlength=50 />    </td>
    <td width="25%" class="cuadro02"><b> NRO.</b></td>
    <td width="25%" class="cuadro01"><input type="text" name=txtNRO size=10 maxlength=5 /></td>
  </tr>
  <tr>
    <td class="cuadro02"><b>DEPTO (OPCIONAL)</b></td>
    <td class="cuadro01"><input type="text" name=txtDEP size=12 maxlength=10 />    </td>
    <td class="cuadro02"><b>BLOCK (OPCIONAL)</b></td>
    <td><input type="text" name=txtBLO size=12 maxlength=10 /></td>
  </tr>
  <tr>
    <td class="cuadro02"><b>VILLA / POBL. (OPCIONAL)</b></td>
    <td class="cuadro01"><input type="text" name=txtVIL size=34 maxlength=50 /></td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
  </tr>

  
  
  <tr>
    <td colspan="4" >
		<TABLE width=100% height=100% bgcolor=White BORDER=0  CELLSPACING=0 CELLPADDING=0>
			<TR>
				<TD><TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
					<TR>
						<TD><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>REGION</STRONG></FONT></TD>
					</TR>
					<TR>
						<TD>
							<?php if($frmModo=="ingresar"){ ?>
							<select name="Region" class="ingreso2" onChange="javascript:LlenaProvincia();"  >
								<option value="0" selected="selected">Seleccione Region</option>
								<?php 
									$sql = "SELECT cod_reg,nom_reg FROM region ORDER BY cod_reg";
									$Rs_Region= pg_exec($conn,$sql);
									for($i=0 ; $i < pg_numrows($Rs_Region) ; $i++){
										$fila = pg_fetch_array($Rs_Region,$i);
										if ($fila["cod_reg"]==$Region){
											echo  "<option selected value=".$fila["cod_reg"]." >".$fila["nom_reg"]."</option>";
										}else{
											echo  "<option value=".$fila["cod_reg"]." >".$fila["nom_reg"]."</option>";
										}
									}
									?>
							</select>							
							<?php };
							if($frmModo=="mostrar"){ 
								$qryREG		="SELECT * FROM REGION WHERE COD_REG=".$fila['region'];
								$resultREG	=@pg_Exec($conn,$qryREG);
								$filaREG	= @pg_fetch_array($resultREG,0);?>
									<font face="Arial, Helvetica, sans-serif" size="2"><strong><? echo ($filaREG['nom_reg']);?> </strong></font>
						<? 	};?>
							<?php 
								if($frmModo=="modificar"){ ?>
									<select name="Region" class="ingreso2" onChange="javascript:LlenaProvincia();"  >
										<option value="0" selected="selected">Seleccione Region</option>
								<?php 
									$sql = "SELECT cod_reg,nom_reg FROM region ORDER BY cod_reg";
									$Rs_Region= pg_exec($conn,$sql);
									for($i=0 ; $i < pg_numrows($Rs_Region) ; $i++){
										$fila = pg_fetch_array($Rs_Region,$i);
										if ($fila["cod_reg"]==$Region){
											echo  "<option selected value=".$fila["cod_reg"]." >".$fila["nom_reg"]."</option>";
										}else{
											echo  "<option value=".$fila["cod_reg"]." >".$fila["nom_reg"]."</option>";
										}
									}
									?>
								</select>	
							<?php };?>
						</TD>
					</TR>
				</TABLE>
				</TD>
				<TD><TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
					<TR>	
						<TD><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>PROVINCIA</STRONG></FONT></TD>
					</TR>
					<TR>
						<TD>
						<?php if($frmModo=="ingresar"){ ?>
						<select name="Provincia" class="ingreso2" onChange="javascript:LlenaComuna();">
							<option value="">Seleccionar Provincia</option>
						</select>
						<?php };?>
						<?php 
						if($frmModo=="mostrar"){ 
							$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad'];
							$resultPRO	=@pg_Exec($conn,$qryPRO);
							$filaPRO	= @pg_fetch_array($resultPRO,0);
							?><font face="Arial, Helvetica, sans-serif" size="2"><strong><? echo ($filaPRO['nom_pro']);?> </strong></font><?
						};
						?>
						<?php if($frmModo=="modificar"){ ?>
						<select name="Provincia" class="ingreso2" onChange="javascript:LlenaComuna();">
							<option value="">Seleccionar Provincia</option>
						</select>
						<?php };?>
					</TD>
				</TR>
			</TABLE>
			</TD>
			<TD><TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
				<TR>
					<TD><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>COMUNA</STRONG></FONT></TD>
				</TR>
				<TR>
					<TD>
						<?php if($frmModo=="ingresar"){ ?>
						 <select name="Comuna" class="ingreso2" onFocus="siguienteCampo ='txtFono1';">
                          <option value="">Seleccionar Comuna</option>
                        </select>   
						<?php };?>
						<?php 
						if($frmModo=="mostrar"){ 
							$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad']." AND COR_COM=".$fila['comuna'];
							$resultCOM	=@pg_Exec($conn,$qryCOM);
							$filaCOM	= @pg_fetch_array($resultCOM,0);
							?><font face="Arial, Helvetica, sans-serif" size="2"><strong><? echo ($filaCOM['nom_com']);?></strong> </font><?
						};
						?>
						<?php if($frmModo=="modificar"){ ?>
							<select name="Comuna" class="ingreso2" onFocus="siguienteCampo ='txtFono1';">
	                          <option value="">Seleccionar Comuna</option>
	                        </select>   
						<?php };?>
					</TD>
				</TR>
			</TABLE>
			</TD>
		</TR>
	</TABLE>
	
	
	</td>
  </tr>
</table>
						  
 </form>		  
						  
			
			    <? }else{ ?>	
							  
  <?php //echo tope("../../../util/");?>
	
		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
		
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=5 CELLPADDING=5 width="100%">
						<TR height="50" >
							<TD align=left>
								
							</TD>
							<TD>
								
							</TD>
							<TD>
								
							</TD>
							<td align="right" >
							
							<?
							if ($frmModo != "ingresar"){ 
							   // codigo para insertar la foto
							   $remple = pg_Exec($conn,"select * from empleado where rut_emp=".trim($_EMPLEADO));
							   $arr=pg_fetch_array($remple,0);
							   $nombrefoto = $arr['nom_foto2'];
							   ?>
							   <img src="../../../tmp/<?=$nombrefoto ?>" ALT= "NO INGRESADA"  width="90" height="100" border="1">
							   <?
							} ?>   
							   						
							 
							 </td>					
						</TR>
					</TABLE>
				</TD>
			</TR>
			
			<TR height=15>
			<TD>
			
			
				<!-- Aquí muestro siempre el nombre del empleado -->
				<table width="100%">
				  <tr>
					<td width="100"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Empleado: </b></font></td>
					<td><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><? imp($fila['nombre_emp']); echo " "; imp($fila['ape_pat']); echo " "; imp($fila['ape_mat']); ?></b></font></td>
				  </tr>
				</table> 
				<br> 	
				<!-- fin nombre del empleado -->
           	
			
			
		     <TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0 height="100%">
				<tr>
				
				<td colspan="6" valign="top">
				
						  
				 <table width="" border="0" cellspacing="0" cellpadding="0" align="left">
                    <tr> 
                      
                      <td class="bot1">&nbsp;</td>
                      <td width="150" class="bot2"><a href="javascript:;" onClick="muestra_tabla('personal','pesta1');"><span id="pesta1" class="span_normal" >Datos Personales</span></a></td>
                      <td class="bot3">&nbsp;</td>
                      <td width="150" class="bot2"><a href="javascript:;" onClick="muestra_tabla('docente','pesta2');"><span id="pesta2" class="span_normal" >Autorizaci&oacute;n Docencia</span></a></td>
                      <td class="bot3">&nbsp;</td>
                      <td width="80" class="bot2"><a href="javascript:;" onClick="muestra_tabla('curriculum','pesta3');"><span id="pesta3" class="span_normal" >Curriculum</span></a></td>
                      <td class="bot3">&nbsp;</td>
					  <td width="80" class="bot2"><a href="javascript:;" onClick="muestra_tabla('accesoweb','pesta4');"><span id="pesta4" class="span_normal" >Acceso web</span></a></td>
					  <td class="bot3">&nbsp;</td>
					  <td width="80" class="bot2"><a href="javascript:;" onClick="muestra_tabla('grupos','pesta5');"><span id="pesta5" class="span_normal" >Grupos</span></a></td>
					  <td width="21" class="bot4">&nbsp;</td>
                    </tr>
                  </table>
						
						
						
						</td></tr>
						
						
						<tr  id="personal">
						
						<td valign="top">
					
		   <FORM method="post" name="frm" action="procesoEmpleado.php3">
	       <input type="hidden" name="rdb" value="<?=$institucion?>">
	       <INPUT type="hidden" name="txtREG" value="<?=$fila['region']?>">
           <INPUT type="hidden" name="txtCIU" value="<?=$fila['ciudad']?>">
           <INPUT type="hidden" name="txtCOM" value="<?=$fila['comuna']?>">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
					  <tr>
					    <TD colspan=2 class="tableindex"><font color="<?=$colortxt ?>">Personal</font></TD>
					  </tr>				  
					  
					
					
					  <!-- codigo de los botones -->
					  
					     <TR height="50" >
							<TD align=right colspan=2>
								<?php if($frmModo=="ingresar"){
										if($ingreso==1){ ?>
											<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
											<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarEmpleado.php3">&nbsp;								
										<? } ?>
								<?php };?>
								
								<?php if($frmModo=="mostrar"){ 
										if($modifica==1){?>																		
                                    <INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name="btnModificar"  onClick="document.location='seteaEmpleado.php3?empleado=<?php echo $empleado?>&caso=3'">&nbsp;
									<?	}
									/*$sql="select id_usuario from usuario where nombre_usuario=$empleado";
									$res = pg_Exec($conn,$sql);
							   		$usuario=pg_fetch_array($res,0);
									$sql2="select id_perfil from accede where id_usuario=".$usuario["id_usuario"];
									$res2 = pg_Exec($conn,$sql2);
							   		for($i=0 ; $i < @pg_numrows($res2) ; $i++){
										$perfil=pg_fetch_array($res2,$i);
										if($perfil["id_perfil"]==26){
											$mostrar=$perfil["id_perfil"];
										}
									}
									if($mostrar==26){?>
									<? if ($_PERFIL==0 || $_PERFIL==14){?>
										<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick="confirmDelete();">&nbsp;
									<? } ?>
								<?	}else{ ?>
									<? if ($_PERFIL==0 || $_PERFIL==14){?>
												<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaEmpleado.php3?caso=9">&nbsp;<? } ?>
									<?php }
									}*/?>
									<? if($elimina==1){?>
										<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick="confirmDelete();">&nbsp;
									<? } ?>
								<!--	<INPUT class="botonXX"  TYPE="button" value="LISTADO" onClick=document.location="listarEmpleado.php3">&nbsp; -->
								<?php };?>


								<?php if($frmModo=="modificar"){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name="btnGuarda" onClick="return valida(this.form);">&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name="btnCancelar" onClick="document.location='seteaEmpleado.php3?empleado=<?php echo $empleado?>&caso=1'">&nbsp;
								<?php };?>
								
								
								<?php if($frmModo=="mostrar"){?>
									<?php if($ingreso==1){ //ACADEMICO Y LEGAL?>
									<!--	<INPUT class="botonXX"  TYPE="button" value="ACCESO WEB" onClick=document.location="usuario/usuario.php3">  -->
									<!--	<INPUT class="botonXX"  TYPE="button" value="ANOTACIONES" onClick=document.location="anotacion/listarAnotacion.php3"> -->
									<input name="Submit" class="botonXX" type="button" onClick="MM_openBrWindow('frmFoto.php3?rut=<?=$empleado ?>','','width=380,height=200')" value="FOTO" />
									
									<!--	<INPUT class="botonXX"  TYPE="button" value="FOTO" onClick="MM_openBrWindow('frmFoto.php3?rut=<?=$empleado ?>','CodigoProducto','height=200,width=380,scrollbar='no',location='no',resizable='no')"> -->
										
									<?php }?>
								<?php } ?>
								
								
							</TD>
						</TR>
						
						<!-- fin codigo de los botones -->
						
					  
					  
					  
					  
					  
					  <tr><td>
					  
					   
					   
					   
					    <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="666666">
                    <tr>
                      <td width="25%" class="cuadro02"><strong>RUT</strong></td>
                      <td width="25%" class="cuadro01">&nbsp;				  
					       <?php if($frmModo=="ingresar"){ ?>
                              <input type="text" name=txtRUT size=10 maxlength=10 />
                        <?php };?>
                        <?php 
									if($frmModo=="mostrar"){ 
											imp($fila['rut_emp']);
									};
									?>
                        <?php 
									if($frmModo=="modificar"){ 
										imp(trim($fila['rut_emp']));
									};
								?>
&nbsp;-
<?php if($frmModo=="ingresar"){ ?>
&nbsp;
<input type="text" name=txtDIGRUT size=1 maxlength=1 />
<?php };?>
<?php
								  if($frmModo=="mostrar"){ 
									   imp($fila['dig_rut']);
								  };
								 ?>
<?php
								  if($frmModo=="modificar"){ 
									 imp($fila['dig_rut']);
								  };
								?>
                      </span></td>
                      <td width="25%" class="cuadro02"><b>NACIONALIDAD</b></td>
                      <td width="25%" class="cuadro01">&nbsp;
                        <?php if ($frmModo=="ingresar"){ ?>
                        <select name="cmbNac">
                          <option value=0 selected></option>
                          <option value=2>Chilena</option>
                          <option value=1>Extranjera</option>
                        </select>
                        <?php }; ?>
                        <?php if ($frmModo=="mostrar"){ ?>
                        <?php
														switch ($fila['nacionalidad']){
															case 0:
																imp('INDETERMINADO');
																break;
															case 1:
																imp('Extranjera');
																break;
															case 2:
																imp('Chilena');
																break;
														};?>
                        <?php }; 
												  
											 if($frmModo=="modificar"){ ?>
                        <select name="cmbNac">
                          <?php if ($fila['nacionalidad']==0){?>
                          <option value=0 selected>Indeterminada</option>
                          <?php }else{?>
                          <option value=0></option>
                          <?php }if ($fila['nacionalidad']==1){?>
                          <option value=1 selected>Extranjera</option>
                          <?php }else{?>
                          <option value=1>Extranjera</option>
                          <?php }if ($fila['nacionalidad']==2){?>
                          <option value=2 selected>Chilena</option>
                          <?php }else{?>
                          <option value=2 >Chilena</option>
                        </select>
                        <?php }?>
                        <?php } ?>
                      </td>
                    </tr>
                  </table>
                  <br />
                  <tr><td>
				    <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#666666">
                      <tr>
                        <td width="25%" class="cuadro02"><b>NOMBRES</b></td>
                        <td width="25%" class="cuadro01">&nbsp;
                          <?php if($frmModo=="ingresar"){ ?>
                          <input type="text" name=txtNOMBRE size=25 maxlength=50 />
                          <?php };?>
                          <?php
												if($frmModo=="mostrar"){ 
													imp($fila['nombre_emp']);
												};
											?>
                          <?php if($frmModo=="modificar"){ ?>
                          <input type="text" name=txtNOMBRE size=25 maxlength=50 value="<?php echo trim($fila['nombre_emp'])?>" />
                          <?php };?>
                        </td>
                        <td width="25%" class="cuadro02"><b>APELLIDO PATERNO</b></td>
                        <td width="25%" class="cuadro01">&nbsp;
                          <?php if($frmModo=="ingresar"){ ?>
                          <input type="text" name=txtAPEPAT size=25 maxlength=50 />
                          <?php };?>
                          <?php
												if($frmModo=="mostrar"){ 
													imp($fila['ape_pat']);
												};
											?>
                          <?php if($frmModo=="modificar"){ ?>
                          <input type="text" name=txtAPEPAT size=25 maxlength=50 value="<?php echo trim($fila['ape_pat'])?>" />
                          <?php };?>
                        </td>
                      </tr>
                      <tr>
                        <td class="cuadro02"><b>APELLIDO MATERNO</b></td>
                        <td class="cuadro01">&nbsp;
                          <?php if($frmModo=="ingresar"){ ?>
                          <input type="text" name=txtAPEMAT size=25 maxlength=50 />
                          <?php };?>
                          <?php
												if($frmModo=="mostrar"){ 
													imp($fila['ape_mat']);
												};
											?>
                          <?php if($frmModo=="modificar"){ ?>
                          <input type="text" name=txtAPEMAT size=25 maxlength=50 value="<?php echo trim($fila['ape_mat'])?>" />
                          <?php };?>
                        </td>
                        <td class="cuadro02"><b>TELEFONO</b></td>
                        <td class="cuadro01">&nbsp;
                          <?php if($frmModo=="ingresar"){ ?>
                          <input type="text" name=txtTELEF size=20 maxlength=30 />
                          <?php };?>
                          <?php
															if($frmModo=="mostrar"){ 
																echo trim($fila['telefono']), "&nbsp;";
															};
														?>
                          <?php if($frmModo=="modificar"){ ?>
                          <input type="text" name="txtTELEF" size=20 maxlength=30 value="<?php echo trim($fila['telefono']); ?>" />
                          <?php };?>
                        </td>
                      </tr>
                      <tr>
                        <td class="cuadro02"><b>TELEFONO 2 </b></td>
                        <td class="cuadro01">&nbsp;
                          <?php if($frmModo=="ingresar"){ ?>
                          <input type="text" name=txtTELEF2 size=20 maxlength=30 />
                          <?php };?>
                          <?php
															if($frmModo=="mostrar"){ 
																imp($fila['telefono2']);
															};
														?>
                          <?php if($frmModo=="modificar"){ ?>
                          <input type="text" name=txtTELEF2 size=20 maxlength=30 value="<?php echo trim($fila['telefono2']); ?>" />
                          <?php };?>
                        </td>
                        <td class="cuadro02"><b>TELEFONO 3 </b></td>
                        <td class="cuadro01">&nbsp;
                          <?php if($frmModo=="ingresar"){ ?>
                          <input type="text" name=txtTELEF3 size=20 maxlength=30 />
                          <?php };?>
                          <?php
															if($frmModo=="mostrar"){ 
																imp($fila['telefono3']);
															};
														?>
                          <?php if($frmModo=="modificar"){ ?>
                          <input type="text" name=txtTELEF3 size=20 maxlength=30 value="<?php echo trim($fila['telefono3']); ?>" />
                          <?php };?>
                        </td>
                      </tr>
					  
					  
                      <tr>
                        <td class="cuadro02"><b>EMAIL</b></td>
                        <td class="cuadro01">&nbsp;
                          <?php if($frmModo=="ingresar"){ ?>
                          <input type="text" name=txtEMAIL size=30 maxlength=50 />
                          <?php };?>
                          <?php
															if($frmModo=="mostrar"){ 
																echo trim($fila['email']),"&nbsp;";
															};
														?>
                          <?php if($frmModo=="modificar"){ ?>
                          <input type="text" name=txtEMAIL size=40 maxlength=50 value="<?php echo trim($fila['email'])?>" />
                          <?php };?>
                        </td>
                        <td class="cuadro02"><b>SEXO </b></td>
                        <td class="cuadro01">&nbsp;
                          <?php if($frmModo=="ingresar"){ ?>
                          <select name="cmbSEXO" >
                            <option value=0 selected></option>
                            <option value=1 >Masculino</option>
                            <option value=2 >Femenino</option>
                          </select>
                          <?php };?>
                          <?php
															if($frmModo=="mostrar"){ 
																switch ($fila['sexo']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Masculino');
																		 break;
																	 case 2:
																		 imp('Femenino');
																		 break;
																 };
															};
														?>
                          <?php if($frmModo=="modificar"){ ?>
                          <select name="cmbSEXO" >
                            <option value=1 <?php echo ($fila['sexo'])==1?" selected ":"" ?>>Masculino</option>
                            <option value=2 <?php echo ($fila['sexo'])==2?" selected ":"" ?>>Femenino</option>
                          </select>
                          <?php };?>
                        </td>
                      </tr>
					  <?
					  /// aqui doy vuelta las fechas
					  $dd = substr($fila['fecha_nacimiento'],8,2);
					  $mm = substr($fila['fecha_nacimiento'],5,2);
					  $aa = substr($fila['fecha_nacimiento'],0,4);
					  $fecha_nacimiento = "$dd-$mm-$aa";
					  
					  $dd = substr($fila['fecha_ingreso'],8,2);
					  $mm = substr($fila['fecha_ingreso'],5,2);
					  $aa = substr($fila['fecha_ingreso'],0,4);
					  $fecha_ingreso = "$dd-$mm-$aa";
					  
					  ?>
					  <tr>
						<td class="cuadro02"><b>FECHA DE NACIMIENTO</b></td>
						<td class="cuadro01">&nbsp;
						   <? 
						   if ($frmModo=="mostrar"){
						        echo $fecha_nacimiento;
						   }						   
						   if ($frmModo=="modificar"){
						        ?>
						        <input type="text" name=fecha_nacimiento size=15 maxlength=15 value="<? echo $fecha_nacimiento; ?>" />
						        
						 <? } ?>						
						</td>
						<td class="cuadro02"><b>FECHA DE INGRESO</b> </td>
						<td class="cuadro01">&nbsp;
						   <?
						   if ($frmModo=="mostrar"){
						       echo $fecha_ingreso;
						   }
						   if ($frmModo=="modificar"){
						       ?>					   	   
						       <input type="text" name=fecha_ingreso size=15 maxlength=15 value="<? echo $fecha_ingreso; ?>" />
							   <?
						   }
						   ?>	   
						</td>
					  </tr>
					  
					  <tr>
						<td class="cuadro02"><b>PREVISION (AFP)</b></td>
						<td class="cuadro01">&nbsp;
						   <?
						   if ($frmModo=="mostrar"){
						       echo $fila['prevision'];
						   }
						   if ($frmModo=="modificar"){
						       ?>	   
						       <input type="text" name=prevision size=15 maxlength=15 value="<? echo $fila['prevision']; ?>" />
							   <?
						   }
						   ?>	   
						</td>
						<td class="cuadro02"><b>SISTEMA DE SALUD</b> </td>
						<td class="cuadro01">&nbsp;
						   <?
						   if ($frmModo=="mostrar"){
						       echo $fila['sistema_salud'];
						   }
						   if ($frmModo=="modificar"){
						       ?>	   
						       <input type="text" name=sistema_salud size=15 maxlength=15 value="<? echo $fila['sistema_salud']; ?>" />
						       <?
						   }
						   ?>						
						</td>
					  </tr>
					  
					  <tr>
						<td class="cuadro02"><b>HORAS PRESENTE AÑO</b></td>
						<td class="cuadro01">&nbsp;
						   <?
						   if ($frmModo=="mostrar"){
						       echo $fila['horas_presente_ano'];
						   }
						   if ($frmModo=="modificar"){
						       ?>	   
						       <input type="text" name=horas_presente_ano size=15 maxlength=15 value="<? echo $fila['horas_presente_ano']; ?>" />
							   <?
						   }
						   ?>	   
						</td>
						<td class="cuadro02"><b>&nbsp;</b> </td>
						<td class="cuadro01">&nbsp; </td>
					  </tr>
					  
					 				  
                      <tr>
                        <td class="cuadro02"><b>ESTADO CIVIL </b></td>
                        <td class="cuadro01">&nbsp;
                          <?php if($frmModo=="ingresar"){ ?>
                          <select name="cmbCIVIL" >
                            <option value=0 selected></option>
                            <option value=1 >Soltero(a)</option>
                            <option value=2 >Casado(a)</option>
                            <option value=3 >Viudo(a)</option>
                          </select>
                          <?php };?>
                          <?php
								if($frmModo=="mostrar"){ 
									switch ($fila['estado_civil']) {
										 case 0:
											 imp('INDETERMINADO');
											 break;
										 case 1:
											 imp('Soltero(a)');
											 break;
										 case 2:
											 imp('Casado(a)');
											 break;
										 case 3:
											 imp('Viudo(a)');
											 break;
									 };
								};
							?>
                          <?php if($frmModo=="modificar"){ ?>
                          <select name="cmbCIVIL" >
                            <option value=1 <?php echo ($fila['estado_civil'])==1?" selected ":"" ?>>Soltero(a)</option>
                            <option value=2 <?php echo ($fila['estado_civil'])==2?" selected ":"" ?>>Casado(a)</option>
                            <option value=3 <?php echo ($fila['estado_civil'])==3?" selected ":"" ?>>Viudo(a)</option>
                          </select>
                          <?php };?>
                        </td>
                        <td class="cuadro02"><b>DIA Y HORARIO DE ATENCI&Oacute;N </b></td>
                        <td class="cuadro01">&nbsp;
                          <?php if($frmModo=="ingresar"){ ?>
                          <input name="txtAtencion" type="text" size="30" maxlength="100" />
                          <?php };?>
                          <?
				if($frmModo=="mostrar"){ 
						echo imp(trim($fila['atencion']));
				};
				?>
                          <?php if($frmModo=="modificar"){ ?>
                          <input name="txtAtencion" type="text" value="<?php echo trim($fila['atencion'])?>" size="30" maxlength="100" />
                          <? } ?>
                        </td>
                      </tr>
                    </table>
				  
				  </td>
                  </tr>
						
						<tr><td>
						
						
						
						
						
						</td></tr>						
						</table>
						
						
						
						
						<!-- aqui inserto ficha de dirección -->
						
                        <table width="100%" border="0" cellspacing="0" cellpadding="1">
                          <tr>
                            <td class="tableindex">Direccion</td>
                          </tr>
                          <tr>
                            <td><table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#666666">
                              <tr>
                                <td width="25%" class="cuadro02"><b>CALLE</b></td>
                                <td width="25%" class="cuadro01">&nbsp;
                                  <?php if($frmModo=="ingresar"){ ?>
                                  <input type="text" name=txtCALLE size=35 maxlength=50 />
                                  <?php };?>
                                  <?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['calle']);
																	};
																?>
                                  <?php if($frmModo=="modificar"){ ?>
                                  <input type="text" name=txtCALLE size=35 maxlength=50 value="<?php echo trim($fila['calle'])?>" />
                                  <?php };?>
                                </td>
                                <td width="25%" class="cuadro02"><b>NRO</b>
                                    <?php 
																						if($frmModo=="mostrar"){
																						 
																	$qryREG		="SELECT * FROM REGION WHERE COD_REG=".$fila['region'];
																	$resultREG	=@pg_Exec($conn,$qryREG);
																	$filaREG	= @pg_fetch_array($resultREG,0);
																	//imp($filaREG['nom_reg']);
																						};
																					?>
                               </td>
                                <td width="25%" class="cuadro01">&nbsp;
                                  <?php if($frmModo=="ingresar"){ ?>
                                  <input type="text" name=txtNRO size=10 maxlength=5 />
                                  <?php };?>
                                  <?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['nro']);
																	};
																?>
                                  <?php if($frmModo=="modificar"){ ?>
                                  <input type="text" name=txtNRO size=10 maxlength=5 value=<?php echo trim($fila['nro']); ?> />
                                  <?php };?>
                                </td>
                              </tr>
                              <tr>
                                <td class="cuadro02"><b>DEPTO&nbsp;&nbsp;&nbsp;(OPCIONAL) </b></td>
                                <td class="cuadro01">&nbsp;
                                  <?php if($frmModo=="ingresar"){ ?>
                                  <input type="text" name=txtDEP size=12 maxlength=10 />
                                  <?php };?>
                                  <?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['depto']);
																	};
																?>
                                  <?php if($frmModo=="modificar"){ ?>
                                  <input type="text" name=txtDEP size=12 maxlength=10 value="<?php echo trim($fila['depto']) ?>" />
                                  <?php };?>
                                </td>
                                <td class="cuadro02"><b>VILLA/POBL&nbsp;&nbsp;&nbsp;(OPCIONAL) </b></td>
                                <td class="cuadro01">&nbsp;
                                  <?php if($frmModo=="ingresar"){ ?>
                                  <input type="text" name=txtVIL size=34 maxlength=50 />
                                  <?php };?>
                                  <?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['villa']);
																	};
																?>
                                  <?php if($frmModo=="modificar"){ ?>
                                  <input type="text" name=txtVIL size=34 maxlength=50 value="<?php echo trim($fila['villa'])?>" />
                                  <?php };?>
                                </td>
                              </tr>
                              <tr>
                                <td class="cuadro02"><b>BLOCK&nbsp;&nbsp;&nbsp;(OPCIONAL) </b></td>
                                <td class="cuadro01">&nbsp;
                                  <?php if($frmModo=="ingresar"){ ?>
                                  <input type="text" name=txtBLO size=12 maxlength=10 />
                                  <?php };?>
                                  <?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['block']);
																	};
																?>
                                  <?php if($frmModo=="modificar"){ ?>
                                  <input type="text" name=txtBLO size=12 maxlength=10 value="<?php echo trim($fila['txtBLO']) ?>" />
                                  <?php };?>
                                </td>
                                <td class="cuadro02" ><b>COMUNA</b></td>
								<td class="cuadro01">&nbsp;
								
								
								<? // aqui tomo solamente la comuna 
								
								if($frmModo=="mostrar"){ 
									$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad']." AND COR_COM=".$fila['comuna'];
									$resultCOM	=@pg_Exec($conn,$qryCOM);
									$filaCOM	= @pg_fetch_array($resultCOM,0);
									?><? echo ($filaCOM['nom_com']);?><?
							    };	?>
			                   
							   
				        
						
						  <?php if($frmModo=="modificar"){ ?>



								  <SELECT name="m3" onChange="cambia_comuna(document.frm.m3.value)"> 
									  <OPTION value="0" selected="selected">Seleccione Comuna</OPTION>
								  <?php
								  	//SELECCIONAR TODAS LAS COMUNAS
								  	$qryCOM		="SELECT * FROM COMUNA order by nom_com"; 
								  	$resultCOM	=@pg_Exec($connRPC,$qryCOM);
								  	for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
									  $filaCOM = @pg_fetch_array($resultCOM,$i);
								      if (($filaCOM['cor_com']==$fila['comuna'])&&($filaCOM['cor_pro']==$fila['ciudad'])&&($filaCOM['cod_reg']==$fila['region'])){
									      echo "<OPTION value=\"".trim($filaCOM['cor_com'])."_".trim($filaCOM['cor_pro'])."_".trim($filaCOM['cod_reg'])."\" selected >".trim($filaCOM['nom_com'])." </OPTION>\n";
									  }else{	    
								          echo "<OPTION value=\"".trim($filaCOM['cor_com'])."_".trim($filaCOM['cor_pro'])."_".trim($filaCOM['cod_reg'])."\" >".trim($filaCOM['nom_com'])." </OPTION>\n";
							          }
									} ?>
								</SELECT> 

								<script language="javascript">
									function cambia_comuna(datos){
										com_pro_reg=datos.split("_");
										document.frm.txtREG.value=com_pro_reg[2];
										document.frm.txtCIU.value=com_pro_reg[1];
										document.frm.txtCOM.value=com_pro_reg[0];
									}
								</script>						  


				                   <!--FORM  method="post" name="f3" onSubmit="return false;">
	                                  <SELECT class="saveHistory" id="m3" name="m3" onChange="document.frm.txtCOM.value=document.f3.m3.value;"> 
	                                  <?php
									  //SELECCIONAR TODAS LAS COMUNAS
									  $qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$fila['region']; //." AND COR_PRO=".$fila['ciudad'];
									  $resultCOM	=@pg_Exec($connRPC,$qryCOM);
									  for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
										  $filaCOM = @pg_fetch_array($resultCOM,$i);
										      if (($filaCOM['cor_com']==$fila['comuna'])&&($filaCOM['cor_pro']==$fila['ciudad'])&&($filaCOM['cod_reg']==$fila['region'])){
											      echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\" selected >".trim($filaCOM['nom_com'])." </OPTION>\n";
											  }else{	    
										          echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\" >".trim($filaCOM['nom_com'])." </OPTION>\n";
									          }
									  }//for resultPRO
									 ?>
									</SELECT> 
								</FORM-->
								
								
						<?php };?>
								
								
								</td>
                                </tr> 
							  
                            </table></td>
                          </tr>
                        </table>
			</form>		   
					   
					   
					   
						
						
						<!-- fin ficha de dirección -->					
						
						
						
			</td></tr>
			<TR id="docente">
			<TD>	
			
		   <div id="masterdiv3">	
		   <FORM name="form2" method="post" action="procesoEmpleado.php3?pesta=2&h=1">		
			
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
			    <td>
				<!-- Aquí codigo de habilitaciones -->
				
				   <table width="100%" height="40" border="0" cellpadding="0" cellspacing="0">
						 <tr>
						   <td width="50%">							      
							 <div class="Estilo9" onClick="SwitchMenuAnotacion('habilitado')">
							  <div align="center">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td class="cuadro02">
										<? if($_PERFIL!=26){?>
										<center><a href="#"><input type="button" value="HABILITACIONES" class="botonXX"></a></center>
										<? } ?>
									</td>									
								  </tr>
								</table>
							  </div>
							 </div>
						  </td>
						  <td width="50%">							
							 <div class="Estilo9" onClick="SwitchMenuAnotacion('autorizacion')">
							   <div align="center">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td class="cuadro02">
										<? if($_PERFIL!=26){?>
										<center><a href="#"><input type="button" value="AUTORIZACION EJERCICIO DOCENTE" class="botonXX"></a></center>
										<? } ?>
									</td>
								  </tr>
								</table>
							   </div>
							 </div>
						  </td>
						  </tr>
						</table>  	 
					
				   
				   	
					<!-- codigo de los botones -->
					  <span class="habilitado" id="habilitado">
					  <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=1 width=100% >
                       <TR class="fondo"> 
                         <TD class="tableindex" >Habilitaciones</TD>
                       </TR>
					  </TABLE>
					  
					 <? if ($_PERFIL!=25){ ?>
					  
					   <table width="100%" border="0" cellspacing="0" cellpadding="3">
                         <tr>
                           <td colspan="2"><div align="right">
                               <label>
                               <input type="submit" name="Submit322" value="GUARDAR" class="botonXX" onClick="return valida3(this.form);">
                               </label>                               
                               <label></label>
                           </div></td>
                         </tr>
						<?
						$q1 = "select * from habilitaciones where id_ano = '".trim($_ANO)."' and rut_emp = '".trim($_EMPLEADO)."'"; 
						$r1 = pg_Exec($conn,$q1);
						$n1 = pg_numrows($r1);
						
						if ($n1>0){   ?>
						
						
							 <tr>
							   <td colspan="2">
							   <table width="100%" border="0" cellspacing="1" cellpadding="3">
								 <tr>
								   <td colspan="7" class="tableindex">HABILITACIONES INGRESADAS </td>
								   </tr>
								 <tr>
								   <td width="12%" class="cuadro02"><div align="center">Fecha</div></td>
								   <td width="7%" class="cuadro02"><div align="center">Nro. Resol. </div></td>
								   <td width="7%" class="cuadro02"><div align="center">Nro. Insc. </div></td>
								   <td width="14%" class="cuadro02"><div align="center">Tipo Autriz. </div></td>
								   <td width="10%" class="cuadro02"><div align="center">Subsector</div></td>
								   <td width="40%" class="cuadro02"><div align="center">Cursos</div></td>
								   <td width="10%" class="cuadro02"><div align="center">Eliminar</div></td>
								 </tr>
								 <?
								$arreglo_temp=array();					 
								 
								 $i = 0;
								 while ($i < $n1){ 
								     $f1 = pg_fetch_array($r1,$i);
									 $id_aux        =  $f1['id_aux'];
									 $fecha2        =  $f1['fecha'];
									 $resolucion    =  $f1['resolucion'];
									 $inscripcion   =  $f1['inscripcion'];
									 $tipo_aut      =  $f1['tipo_aut'];
									 $cod_subsector =  $f1['cod_subsector'];
									 $tipo_ense     =  $f1['tipo_ense'];
									 $c1            =  $f1['c1'];
									 $c2            =  $f1['c2'];
									 $c3            =  $f1['c3'];
									 $c4            =  $f1['c4'];
									 $c5            =  $f1['c5'];
									 $c6            =  $f1['c6'];
									 $c7            =  $f1['c7'];
									 $c8            =  $f1['c8'];
									 $EP            =  $f1['EP'];
									 $EDA           =  $f1['EDA'];
									 $EDM           =  $f1['EDM'];
									 $EDV           =  $f1['EDV'];
									 $EAL           =  $f1['EAL'];
									 $ETM           =  $f1['ETM'];
									 $EA            =  $f1['EA'];
									 
									 
									 $dd = substr($fecha2,8,2);
									 $mm = substr($fecha2,5,2);
									 $aa = substr($fecha2,0,4);
									 
									 $fecha2 = "$dd-$mm-$aa";
									 
									 
									 if ($tipo_aut==1){
									     $tipo_aut="Indefinida";
									 }else{
									     $tipo_aut="Temporal";
									 } 
									 	 								
									
									 ?>
									 <tr>
									   <td class="cuadro01">&nbsp;
									     
									       <div align="center">
									         <?=$fecha2 ?>
									         </div></td>
									   <td class="cuadro01">&nbsp;
									     
									       <div align="center">
									         <?=$resolucion ?>
									         </div></td>
									   <td class="cuadro01">&nbsp;
									     
									       <div align="center">
									         <?=$inscripcion ?>
									         </div></td>
									   <td class="cuadro01">&nbsp;
									     
									       <div align="center">
									         <?=$tipo_aut ?>
									         </div></td>
											 
											 
										<?
										// aqui agrego los subsectores asociados para esta institucion, para este año.
										$b2 = "select * from subsector where cod_subsector = '$cod_subsector'"; 
										$r2 = @pg_Exec($conn,$b2);
										$f2 = @pg_fetch_array($r2);
										$nombre_subsector = $f2['nombre'];
										?>											 
											 
									   <td class="cuadro01">&nbsp;									     
									       <div align="center">
									         <? echo "$cod_subsector - $nombre_subsector"; ?>
									         </div></td>
									   <td class="cuadro01">
									   <div align="center">&nbsp;
									   
										  <table width="100%" border="1" cellspacing="0" cellpadding="0">
										   <tr>
										   	<? if ($c1==1){ ?>
											     <td class="cuadro02"><div align="center">1&ordm; </div></td>											 
											<? } ?>
											<? if ($c2==1){ ?> 
											     <td class="cuadro02"><div align="center">2&ordm;</div></td>											
											<? } ?>
											<? if ($c3==1){ ?>
											     <td class="cuadro02"><div align="center">3&ordm;</div></td>											 
										    <? } ?>
											<? if ($c4==1){ ?> 
											     <td class="cuadro02"><div align="center">4&ordm;</div></td>											
											<? } ?>
											<? if ($c5==1){ ?>
											     <td class="cuadro02"><div align="center">5&ordm;</div></td>												
											<? } ?>
											<? if ($c6==1){ ?>
											     <td class="cuadro02"><div align="center">6&ordm;</div></td>
											<? } ?>
											<? if ($c7==1){ ?>
											     <td class="cuadro02"><div align="center">7&ordm;</div></td>
											<? } ?>
											<? if ($c8==1){ ?>
											     <td class="cuadro02"><div align="center">8&ordm;</div></td>												 											 		 		 		 
										    <? } ?>
											
											
											
											<? if ($EP==1){ ?>
											     <? } ?>
											<? if ($EDA==1){ ?>
											     <? } ?>
											<? if ($EDM==1){ ?>
											     <? } ?>
											<? if ($EDV==1){ ?>
											     <? } ?>
											<? if ($EAL==1){ ?>
											     <? } ?>
											<? if ($ETM==1){ ?>
											     <? } ?>
											<? if ($EA==1){ ?>
											     <? } ?>
										   </tr>
										 </table>
									    </div></td>
									   <td class="cuadro01"><div align="center">
									     <label>
									     <input name="Submit3" type="submit" onClick="MM_goToURL('parent','procesoEmpleado.php3?id_aux=<?=$id_aux ?>&eli=1&pesta=2');return document.MM_returnValue" value="E">
									     </label>
									   </div></td>
									 </tr>
							         <?
									 //// codigo nuevo para llenar el arreglo cod_subsecto[]
									 $arreglo_temp[]=$cod_subsector;									 
									 
									 $i++;
								 } 
								 ?>									  		 
							   </table>
							   <br></td>
							 </tr>
					  
					  <?
					   /// nuevo codigo para campo habilitado_para
					 $habilitado_para=serialize($arreglo_temp);				 					 			 
					 
					 $q1 = "update empleado set habilitado_para = '$habilitado_para', habilitado = '1' where rut_emp = '".trim($_EMPLEADO)."'";
					 $r1 = pg_Exec($conn,$q1);	
					  
					  
					   } ?>	   
					   
					   

                         <tr>
                           <td>						   
						   
						   <table width="100%" border="0" cellspacing="1" cellpadding="5">
                             <tr>
                               <td class="cuadro02" >FECHA</td>
                               <td class="cuadro01"><input name="h_fecha" type="text" id="h_fecha" value="<?=$h_fecha ?>" size="10" maxlength="10"> 
                                 <span class="Estilo1">(dd-mm-aaaa)</span> <span class="Estilo2">(*)</span> <input name="rut_emp" type="hidden" id="rut_emp" value="<?=$_EMPLEADO ?>"></td>
                               </tr>
                             <tr>
                               <td class="cuadro02">RESOLUCION</td>
                               <td class="cuadro01"><input name="h_resolucion" type="text" id="h_resolucion" value="<?=$h_resolucion ?>"> <span class="Estilo2">(*)</span> </td>
                               </tr>
                             <tr>
                               <td class="cuadro02">NRO. INSCRIPCI&Oacute;N </td>
                               <td class="cuadro01"><input name="h_inscripcion" type="text" id="h_inscripcion" value="<?=$h_inscripcion ?>"> <span class="Estilo2">(*)</span> </td>
                               </tr>
                             
							<?
							// aqui agrego los subsectores asociados para esta institucion, para este año.
							$q1 = "select cod_subsector, nombre from subsector where cod_subsector in (select cod_subsector from ramo where id_curso in (select id_curso from curso where id_ano = '".trim($_ANO)."' )) order by nombre"; 
														
							
                            $r1 = @pg_Exec($conn,$q1);
							$n1 = @pg_numrows($r1);
							?>							   
                             <tr>
                               <td class="cuadro02">SUBSECTOR</td>
                               <td class="cuadro01">
							   <select name="cmb_subsector">
							        <option value="0">Seleccione subsector </option>
							   <?
							   $i = 0;
							   while ($i < $n1){
							        $f1 = @pg_fetch_array($r1,$i);
									$cod_subsector = $f1['cod_subsector'];
									$nombre        = $f1['nombre'];
									?>
									<option value="<?=$cod_subsector ?>" <? if ($cod_subsector==$cmb_subsector){ ?> selected="selected" <? } ?>><? echo "$nombre - $cod_subsector"; ?></option>
									<?
									$i++;
								}
								?>						   
							    </select> <span class="Estilo2">(*)</span>								</td>
                               </tr>
							 <?
							 // aqui tomo los tipos de enseñanza 
							 $q1 = "select * from tipo_ensenanza where cod_tipo in (select cod_tipo from plan_tipo where cod_decreto in (select cod_decreto from plan_estudio where cod_decreto in (select cod_decreto from plan_inst where rdb = '".trim($_INSTIT)."')))";        
							 $r1 = @pg_Exec($conn,$q1);
							 $n1 = @pg_numrows($r1);
							 ?>  
							   
                             <tr>
                               <td class="cuadro02">TIPO DE ENSE&Ntilde;ANZA</td>
                               <td class="cuadro01">
							   <select name="cmb_tipoensenanza" onChange="enviapag(this.form);">
							       <option value="0">Seleccione tipo de enseñanza</option>
								   <?
								   $i = 0;
								   while ($i < $n1){
									   $f1 = @pg_fetch_array($r1,$i);
									   $cod_tipo    = $f1['cod_tipo'];
									   $nombre_tipo = $f1['nombre_tipo'];
									   
									   if (($cod_tipo!=10) AND ($cod_tipo!=211) AND ($cod_tipo!=212) AND ($cod_tipo!=213) AND ($cod_tipo!=214) AND ($cod_tipo!=215) AND ($cod_tipo!=216)){
									   								   
										   ?>
										   <option value="<?=$cod_tipo ?>" <? if ($cod_tipo == $cmb_tipoensenanza){ ?> selected="selected" <? } ?>><?=$nombre_tipo ?></option>
										   <?
									   }
									   
									   $i++;
								   }
								   ?>						   
							   </select> <span class="Estilo2">(*)</span>							   </td>
                               </tr>
                             <tr>
                               <td colspan="2" class="cuadro02"><div align="center">CURSOS</div></td>
                               </tr>
                             <tr>
                               <td colspan="2">
							   <div align="center">                                
								 
					      <? if ($cmb_tipoensenanza!=0){ ?>
						  							
							    <table width="100%" border="1" cellpadding="0" cellspacing="0" height="30">
								  <tr>
									<td align="right" ><input type="checkbox" name="checkbox11" value="checkbox" onClick="ChequearTodos(this);"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Todos</font></td>
								  </td>
								</table>  
							
							
							    <? /// muestro la tabla para básica de 1º a 8º								
								if (($cmb_tipoensenanza=="110") OR ($cmb_tipoensenanza=="160") OR ($cmb_tipoensenanza=="163")){ ?>	
								    																		 
									 <table width="100%" border="1" cellspacing="0" cellpadding="0">
									   <tr>
										 <td class="cuadro02"><div align="center">1&ordm; </div></td>
										 <td class="cuadro01"><label>
											 <div align="center">
											   <input name="c1" type="checkbox" id="c1" value="1">
											 </div>
											 </label>                                     </td>
										 <td class="cuadro02"><div align="center">2&ordm;</div></td>
										 <td class="cuadro01">
											 <div align="center">
											   <input name="c2" type="checkbox" id="c2" value="1">
												 </div></td>
										 <td class="cuadro02"><div align="center">3&ordm;</div></td>
										 <td class="cuadro01">
											 <div align="center">
											   <input name="c3" type="checkbox" id="c3" value="1">
												 </div></td>
										 <td class="cuadro02"><div align="center">4&ordm;</div></td>
										 <td class="cuadro01">
										     <div align="center">
										       <input name="c4" type="checkbox" id="c4" value="1">
											     </div></td>											 
										<td class="cuadro02"><div align="center">5&ordm;</div></td>
										 <td class="cuadro01">
											 <div align="center">
											   <input name="c5" type="checkbox" id="c5" value="1">
												 </div></td>
										<td class="cuadro02"><div align="center">6&ordm;</div></td>
										 <td class="cuadro01">
											 <div align="center">
											   <input name="c6" type="checkbox" id="c6" value="1">
												 </div></td>
										<td class="cuadro02"><div align="center">7&ordm;</div></td>
										 <td class="cuadro01">
											 <div align="center">
											   <input name="c7" type="checkbox" id="c7" value="1">
												 </div></td>
										  <td class="cuadro02"><div align="center">8&ordm;</div></td>
										 <td class="cuadro01">
											 <div align="center">
											   <input name="c8" type="checkbox" id="c8" value="1">
												 </div></td>																		 
									   </tr>
									 </table>								 
							<? } ?>	
							
							
							 <? /// muestro la tabla para Media de 1º a 4º								
								if (($cmb_tipoensenanza=="761") OR ($cmb_tipoensenanza=="410") OR ($cmb_tipoensenanza=="510") OR ($cmb_tipoensenanza=="610") OR ($cmb_tipoensenanza=="710") OR ($cmb_tipoensenanza=="360") OR ($cmb_tipoensenanza=="362") OR ($cmb_tipoensenanza=="361") OR ($cmb_tipoensenanza=="460") OR ($cmb_tipoensenanza=="461") OR ($cmb_tipoensenanza=="560") OR ($cmb_tipoensenanza=="561") OR ($cmb_tipoensenanza=="660") OR ($cmb_tipoensenanza=="661") OR ($cmb_tipoensenanza=="760") OR ($cmb_tipoensenanza=="860") OR ($cmb_tipoensenanza=="861") OR ($cmb_tipoensenanza=="810") OR ($cmb_tipoensenanza=="310") ){ ?>	
							         <table width="100%" border="1" cellspacing="0" cellpadding="0">
									   <tr>
										 <td class="cuadro02"><div align="center">1&ordm; </div></td>
										 <td class="cuadro01"><label>
											 <div align="center">
											   <input name="c1" type="checkbox" id="c1" value="1">
											 </div>
											 </label>                                     </td>
										 <td class="cuadro02"><div align="center">2&ordm;</div></td>
										 <td class="cuadro01">
											 <div align="center">
											   <input name="c2" type="checkbox" id="c2" value="1">
												 </div></td>
										 <td class="cuadro02"><div align="center">3&ordm;</div></td>
										 <td class="cuadro01">
											 <div align="center">
											   <input name="c3" type="checkbox" id="c3" value="1">
												 </div></td>
										 <td class="cuadro02"><div align="center">4&ordm;</div></td>
										 <td class="cuadro01">
										     <div align="center">
										       <input name="c4" type="checkbox" id="c4" value="1">
											     </div></td>																										 
									   </tr>
									 </table>
							 <? } ?>							 
						
						<? } ?>	 
							
                               
							 </div>				   
							   </td>
                               </tr>
							   <tr>
                               <td class="cuadro02">TIPO DE AUTORIZACION </td>
                               <td class="cuadro01">
							   
							   <table width="100%" border="1" cellspacing="0" cellpadding="0">
                                 
                                 <tr>
                                   <td class="cuadro02">INDEFINIDA</td>
                                   <td class="cuadro02">TEMPORAL</td>
                                 </tr>
                                 <tr>
                                   <td class="cuadro01"><div align="center">
                                           <input name="h_tipo_aut" type="radio" value="1" checked="checked">								
							       </div></td>
                                   <td class="cuadro01"><div align="center">								     
                                           <input name="h_tipo_aut" type="radio" value="2">										 								   
								   </div></td>
                                 </tr>
                               </table></td>
                               </tr>
                           </table>                             
                            </td>
                           </tr>
                       </table>
					  <? } ?> 
					   
					   </span>
				
				
				<!-- fin codigo de habilitaciones -->
				</td>
			  </tr>
			
			<tr>
			<td>
			
	    </form> 
			
		<FORM name="form2" method="post" action="procesoEmpleado.php3?pesta=2&h=2">	
		 <span class="autorizacion" id="autorizacion">		   
			 <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=1 width=100% >
              <TR class="fondo"> 
                 <TD colspan="4" class="tableindex" >Autorización Ejercicio Docente</TD>
               </TR>
			   
			   
			  <!-- codigo de los botones -->					  
					     <TR height="50" >
							<TD align=right colspan=4>
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name="btnGuardar" onClick="return valida(this.form);">&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name="btnCancelar" onClick=document.location="listarEmpleado.php3">&nbsp;
								<?php };?>
								
								<?php if($frmModo=="mostrar"){ ?>
								              <!--  <script language="javascript" type="text/javascript">
												function abre_pop_empleado(){
														valor=<? echo trim($fila['rut_emp']);?>;
														 var opciones="left=100,top=100,width=540,height=300,scrollbars=yes,resizable =yes"
														url='pop_nivel.php?rut_empleado='+valor;
													window.open(url,"a",opciones)
												}
												</script>  
                                          <input name=btn_nivel type="button" class="botonXX" id="btn_nivel"  onClick="abre_pop_empleado();"  value="NIVEL"> -->
									<?php if($modifica==1){ //ACADEMICO Y LEGAL?>
                                  									
                                    <INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaEmpleado.php3?empleado=<?php echo $empleado?>&caso=3&pesta=2">&nbsp;
									<!--	<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaEmpleado.php3?caso=9">&nbsp;  -->
										
									<?php }//ACADEMICO Y LEGAL?>
								<!--	<INPUT class="botonXX"  TYPE="button" value="LISTADO" onClick=document.location="listarEmpleado.php3">&nbsp;  -->
								<?php };?>


								<?php if($frmModo=="modificar"){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name="btnGuardar" onClick="return valida(this.form);">&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaEmpleado.php3?empleado=<?php echo $empleado?>&caso=1">&nbsp;
								<?php };?>
								
								
								<?php if($frmModo=="mostrar"){?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=25)&&($_PERFIL!=26)){ //ACADEMICO Y LEGAL?>
									<!--	<INPUT class="botonXX"  TYPE="button" value="ACCESO WEB" onClick=document.location="usuario/usuario.php3">  -->
									<!--	<INPUT class="botonXX"  TYPE="button" value="ANOTACIONES" onClick=document.location="anotacion/listarAnotacion.php3"> -->
										<?php
											echo "<INPUT class='botonXX'  TYPE=button value=FOTO onClick=window.open('frmFoto.php3?rut=",$empleado,"','CodigoProducto','height=200,width=380,scrollbar=no,location=no,resizable=no')			
											>";
										?>
									<?php }?>
								<?php } ?>
								
								
							</TD>
						</TR>
						
						<!-- fin codigo de los botones -->
						
						
						
						 
   <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="666666">
   <tr>
     <td class="cuadro02"><b>Nº RESOLUCION</b></td>
     <td class="cuadro01">
       <?php if($frmModo=="ingresar"){ ?>
       <input type="text" name="txtNROres" size="20" maxlength="10" />
       <?php };?>
       <?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['nu_resol']);
																	};
																?>
       <?php if($frmModo=="modificar"){ ?>
       <input type="text" name="txtNROres" size="20" maxlength="10" onKeyPress="nroOnly(form.txtNROres,'Número InvalidoB." value=<?php echo $fila['nu_resol']?> />
       <?php };?>
     </td>
     <td class="cuadro02"><b>FECHA </b></td>
     <td class="cuadro01">
       <?php if($frmModo=="ingresar"){ ?>
       <input type="text" name="txtFECHA" size=20 maxlength=10 onChange="chkFecha(form.txtFECHA,'Fecha invalida.');" />
       <?php };?>
       <?php 
																	if($frmModo=="mostrar"){ 
																		impF($fila['fecha_resol']);
																	};
																?>
       <?php if($frmModo=="modificar"){ ?>
       <input type="text" name="txtFECHA" size=20 maxlength=10  value=<?php impF ($fila['fecha_resol'])?> />
       <?php };?>
     </td>
   </tr>
   
   
   <tr>
     <td class="cuadro02"><b>NIVEL</b></td>
     <td class="cuadro01" colspan="3">
	            <? 
				$query_tipo_titulo="select * from tipo_titulo order by codigo";
				$result_tipo_titulo=pg_exec($conn,$query_tipo_titulo);
				$num_tipo_titulo=pg_numrows($result_tipo_titulo);
				?>
			    <table >
				 <tr>
				   <td>		   
					 <table>
					     <tr>
						 <? for ($iii=0;$iii<$num_tipo_titulo;$iii++){
								$row_tipo_tit=pg_fetch_array($result_tipo_titulo)?>
						       <td>
							    <?  if ($row_tipo_tit[codigo]=='1'){$var_click="mostrar_ocultar('tabla_sub_sector');";}
								   if ($row_tipo_tit[codigo]=='2'){$var_click="titulado(this,this.value,this.name);";}
								   if ($row_tipo_tit[codigo]=='3'){$var_click="tit_otras(this,this.value,this.name);";}
								?>
							    <input name="tipo_titulo[]" value="<? echo $row_tipo_tit[codigo];?>" type="checkbox" onClick="<? echo $var_click;?>" <? if ($frmModo=="mostrar"){echo "disabled";}?> <? chekear($row_tipo_tit[codigo]);?> /></td>
					            <td nowrap="nowrap"><font face="arial, geneva, helvetica" size=1 color=#000000><strong> <? echo $row_tipo_tit['nombre'];?> </strong></font> </td>
					     <? } ?>
					     </tr>
				     </table>
				   </td>
				 </tr>
			    </table>   
	  </td>
     <td>
	 
	 <!--<? 
						$query_plan="select plan2.rdb,plan2.cod_decreto
								from plan_inst as plan,plan_estudio as plan2
								where plan.rdb='$institucion'  and plan.cod_decreto=plan2.cod_decreto
								Group by plan2.rdb,plan2.cod_decreto"; 
/*					$query_sub="select sub.cod_subsector,sub.nombre
								from plan_inst as plan,subsector as sub
								where plan.rdb='$institucion' and sub.cod_subsector=incluye.cod_subsector
								Group by sub.cod_subsector,sub.nombre"; 
*/								
/*						$query_sub="select sub.cod_subsector,sub.nombre
								from plan_inst as plan,incluye ,subsector as sub
								where rdb='$institucion' and incluye.cod_decreto=plan.cod_decreto and sub.cod_subsector=incluye.cod_subsector
								Group by sub.cod_subsector,sub.nombre";*/ 
																
//								plan_estudio

					$result_plan=pg_exec($conn,$query_plan);
					$num_plan=pg_numrows($result_plan);
					?>
       <table>
         <tr>
           <? 
				/*	$arreglo_temp=array();
					$jj=1 ;
					for ($yy=0;$yy<$num_plan;$yy++){
						$row_plan=pg_fetch_array($result_plan);
							if (($row_plan[rdb]==0)||($row_plan[rdb]==NULL)){
								$query_sub="select sub.nombre,sub.cod_subsector 
									from incluye as incluye,subsector as sub 
									where incluye.cod_decreto='$row_plan[cod_decreto]' and sub.cod_subsector=incluye.cod_subsector";
							}else{
								$query_sub="select * 
									from incluye_propio as incluye,subsector as sub 
									where incluye.cod_decreto='$row_plan[cod_decreto]' and sub.cod_subsector=incluye.cod_subsector";
							}
							//echo "<br><br>".$query_sub."<br><br>";
							$result_sub=pg_exec($conn,$query_sub);
							$num_sub=pg_numrows($result_sub);
						
				
						
					?>
           <? $cod_subsector=unserialize($fila[habilitado_para]);

					?>
           <? 
						for ($xx=0;$xx<$num_sub;$xx++){
						$row_sub=pg_fetch_array($result_sub);
						
						if (!in_array($row_sub[cod_subsector],$arreglo_temp)){
								$arreglo_temp[]=$row_sub[cod_subsector]
						?>
           <td class="cuadro01"><input name="cod_subsector[]" type="checkbox" value="<? echo $row_sub[cod_subsector];?>" id="cob_subsector" <? if ($frmModo=="mostrar"){echo "disabled";}?>  <? if ((is_array($cod_subsector))&&(in_array ($row_sub[cod_subsector], $cod_subsector))){echo "checked";}?> /></td>
           <td nowrap><font face="arial, geneva, helvetica" size=1 color=#000000><strong> <? echo $row_sub['nombre'];?> </strong></font> </td>
           <? if ($jj==2){ echo "</tr><tr>";$jj=1;}else{$jj++;}?>
           <? }?>
           <? }?>
           <? } */?>
         </tr>
       </table>     </td>
     <td>&nbsp;</td>
   </tr>
   
   -->
   <?php
   $sql_postit  = "SELECT * FROM empleado_estudios WHERE rut_empleado='".$empleado."' AND tipo=1 order by orden"; 
   $res_postit  = @pg_exec($conn, $sql_postit);
   $cant_postit = @pg_numrows($res_postit);
   ?>   
   
   <tr>
     <td class="cuadro02"><b>TITULO 1</b> </td>
     <td class="cuadro01"><?php $row_tit_0 = @pg_fetch_array($res_postit,0); 
			 
		?>
       <?php if($frmModo=="ingresar"){ ?>
<!--                  <input type="text" name="txtTITULO[1]" size=30 maxlength=1000 />-->
                  <input type="text" name="txtTITULO_1" size=30 maxlength=1000 />
       <?php };?>
       <?php if($row_tit_0!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_0['nombre']);
					};
				}//fin if($row_tit_0!=""){?>
       <?php if($frmModo=="modificar"){ ?>
<!--       <input type="text" name="txtTITULO[1]" size=30 maxlength=1000 value="<? // echo trim($row_tit_0['nombre'])?>" />-->
       <input type="text" name="txtTITULO_1" size=30 maxlength=1000 value="<?php echo trim($row_tit_0['nombre'])?>" />
       <?php };?>
     &nbsp;</td>
     <td class="cuadro02"><b>INSTITUCION</b></td>
     <td class="cuadro01"><?php 
			  
	  if($frmModo=="ingresar"){ ?>
       <input name="institucion_1" type="text" id="institucion1" />
       <?php };?>
       <?php if($row_tit_0!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_0['institucion']);
					};
				}//fin if($row_tit_0!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input name="institucion_1" type="text" id="institucion1" value="<?php echo trim($row_tit_0['institucion'])?>" />
       <?php };?>
     &nbsp;</td>
   </tr>
   <tr>
     <td class="cuadro02"><b>A&Ntilde;O</b></td>
     <td class="cuadro01"><?php 
			  
			  if($frmModo=="ingresar"){ ?>
       <input name="c_ano_1" type="text" id="c_ano_1" size="5" maxlength="4" />
       <?php };?>
       <?php if($row_tit_0!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_0['ano']);
					};
				}//fin if($row_tit_0!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input name="c_ano_1" type="text" id="c_ano_1" size="5" maxlength="4" value="<?php echo trim($row_tit_0['ano'])?>" />
       <?php };?>
     &nbsp; </td>
     <td class="cuadro02">&nbsp;</td>
     <td class="cuadro02">&nbsp;</td>
   </tr>
   <tr>
     <td class="cuadro02"><b>TITULO 2</b> </td>
     <td class="cuadro01"><?php $row_tit_1 = @pg_fetch_array($res_postit,1); ?>
       <?php 
				
				if($frmModo=="ingresar"){ ?>
       <input type="text" name="txtTITULO_2" size=30 maxlength=1000 />
       <?php };?>
       <?php if($row_tit_1!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_1['nombre']);
					};
				}//fin if($row_tit_1!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input type="text" name="txtTITULO_2" size=30 maxlength=1000 value="<?php echo trim($row_tit_1['nombre'])?>" />
       <?php };
				?></td>
     <td class="cuadro02"><b>INSTITUCION</b></td>
     <td class="cuadro01"><?php 
				
				if($frmModo=="ingresar"){ ?>
       <input name="institucion_2" type="text" id="institucion2" />
       <?php };?>
       <?php if($row_tit_1!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_1['institucion']);
					};
				}//fin if($row_tit_1!=""){)?>
       <?php if($frmModo=="modificar"){ ?>
       <input name="institucion_2" type="text" id="institucion2" value="<?php echo trim($row_tit_1['institucion'])?>" />
       <?php };?>
     &nbsp; </td>
   </tr>
   <tr>
     <td class="cuadro02"><b>A&Ntilde;O</b></td>
     <td class="cuadro01"><?php 
				
				if($frmModo=="ingresar"){ ?>
       <input name="c_ano_2" type="text" id="c_ano_2" size="5" maxlength="4" />
       <?php };?>
       <?php if($row_tit_1!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_1['ano']);
					};
				}//fin if($row_tit_1!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input name="c_ano_2" type="text" id="c_ano_2" size="5" maxlength="4" value="<?php echo trim($row_tit_1['ano'])?>" />
       <?php };?>
     &nbsp; </td>
     <td class="cuadro02">&nbsp;</td>
     <td class="cuadro02">&nbsp;</td>
   </tr>
   <tr>
     <td class="cuadro02"><b>TITULO 3 </b></td>
     <td class="cuadro01">
       <?php 
			  
		 $row_tit_2 = @pg_fetch_array($res_postit,2); ?>
       <?php if($frmModo=="ingresar"){ ?>
       <input type="text" name="txtTITULO_3" size=30 maxlength=1000 />
       <?php };?>
       <?php if($row_tit_2!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_2['nombre']);
					};
				}//fin if($row_tit_2!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input type="text" name="txtTITULO_3" size=30 maxlength=1000 value="<?php echo trim($row_tit_2['nombre'])?>" />
       <?php };
				?>
     &nbsp;</td>
     <td class="cuadro02"><b>INSTITUCION</b></td>
     <td class="cuadro01">
       <?php 
				
				if($frmModo=="ingresar"){ ?>
       <input name="institucion_3" type="text" id="institucion3" />
       <?php };?>
       <?php if($row_tit_2!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_2['institucion']);
					};
				}//fin if($row_tit_2!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input name="institucion_3" type="text" id="institucion3" value="<?php echo trim($row_tit_2['institucion'])?>" />
       <?php };?>
     &nbsp; </td>
   </tr>
   <tr>
     <td class="cuadro02"><b>A&Ntilde;O</b></td>
     <td class="cuadro01">
       <?php 
				
				if($frmModo=="ingresar"){ ?>
       <input name="c_ano_3" type="text" id="c_ano_3" size="5" maxlength="4" />
       <?php };?>
       <?php if($row_tit_2!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_2['ano']);
					};
				}//fin if($row_tit_2!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input name="c_ano_3" type="text" id="c_ano_3" value="<?php echo trim($row_tit_2['ano'])?>" size="5" maxlength="4" />
       <?php };?>
     &nbsp; </td>
     <td class="cuadro02">&nbsp;</td>
     <td class="cuadro02">&nbsp;</td>
   </tr>
   <?php
   
   
    	$sql_postit="SELECT * FROM empleado_estudios WHERE rut_empleado='".$empleado."' AND tipo=2 order by orden"; 
					$res_postit = @pg_exec($conn, $sql_postit);
					$cant_postit = @pg_numrows($res_postit);

			?>
   
   
   <tr>
     <td class="cuadro02"><b>POSTITULO 1 </b></td>
     <td class="cuadro01"><?php $row_postit_0 = @pg_fetch_array($res_postit,0); ?>
       <?php 
				
				if($frmModo=="ingresar"){ ?>
       <input name="txtPOSTITULO_1" type="text" size=30 maxlength=1000 />
       <?php };?>
       <?php if($row_postit_0!=""){
					if($frmModo=="mostrar"){ 
						imp($row_postit_0['nombre']);
					};
				}//fin if($row_postit_0!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input type="text" name="txtPOSTITULO_1" size=30 maxlength=1000 value="<?php echo trim($row_postit_0['nombre'])?>" />
       <?php };?>
&nbsp;</td>
     <td class="cuadro02"><b>POSTITULO 2  </b></td>
     <td class="cuadro01">
       <?php $row_postit_1 = @pg_fetch_array($res_postit,1); ?>
       <?php 
				
				if($frmModo=="ingresar"){ ?>
       <input name="txtPOSTITULO_2" type="text" size=30 maxlength=1000 />
       <?php };?>
       <?php if($row_postit_1!=""){
					if($frmModo=="mostrar"){ 
						imp($row_postit_1['nombre']);
					};
				}//fin if($row_postit_0!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input type="text" name="txtPOSTITULO_2" size=30 maxlength=1000 value="<?php echo trim($row_postit_1['nombre'])?>" />
       <?php };?>
&nbsp;</td>
   </tr>
   
   <?php 	
   
   $sql_posgra="SELECT * FROM empleado_estudios WHERE rut_empleado='".$empleado."' AND tipo=3 order by orden"; 
   $res_posgra = @pg_exec($conn, $sql_posgra);
   $cant_posgra = @pg_numrows($res_posgra);
					
    ?>
   
   
   <tr>
     <td class="cuadro02"><b>POSTGRADO 1 </b></td>
     <td class="cuadro01"><?php $row_posgra_0 = @pg_fetch_array($res_posgra,0); ?>
       <?php 
				
				if($frmModo=="ingresar"){ ?>
       <input name="txtPOSTGRADO_1" type="text" size=30 maxlength=1000 />
       <?php };?>
       <?php if($row_posgra_0!=""){
					if($frmModo=="mostrar"){ 
						imp($row_posgra_0['nombre']);
					};
				}//fin if($row_posgra_0!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input type="text" name="txtPOSTGRADO_1" size=30 maxlength=1000 value="<?php echo trim($row_posgra_0['nombre'])?>" />
       <?php };?>
&nbsp;&nbsp;</td>
     <td class="cuadro02"><b>POSTGRADO 2 </b> </td>
     <td class="cuadro01">
       <?php $row_posgra_1 = @pg_fetch_array($res_posgra,1); ?>
       <?php
				
				 if($frmModo=="ingresar"){ ?>
       <input name="txtPOSTGRADO_2" type="text" size=30 maxlength=1000 />
       <?php };?>
       <?php if($row_posgra_1!=""){
					if($frmModo=="mostrar"){ 
						imp($row_posgra_1['nombre']);
					};
				}//fin if($row_posgra_0!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input type="text" name="txtPOSTGRADO_2" size=30 maxlength=1000 value="<?php echo trim($row_posgra_1['nombre'])?>" />
       <?php };?>
&nbsp;&nbsp;</td>
   </tr>
   
   <?php 	
   $sql_cu="SELECT * FROM empleado_estudios WHERE rut_empleado='".$empleado."' AND tipo=4 order by orden"; 
   $res_cu = @pg_exec($conn, $sql_cu);
   $cant_cu = @pg_numrows($res_cu);

	?>
   
   <tr>
     <td class="cuadro02"><b>CURSO 1 </b></td>
     <td class="cuadro01"><?php $row_cu_0 = @pg_fetch_array($res_cu,0); ?>
       <?php 
				
				if($frmModo=="ingresar"){ ?>
       <input name="txtCURSO_1" type="text" size=30 maxlength=1000 />
       <?php };?>
       <?php if($row_cu_0!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_0['nombre']);
					};
				}//fin row_cu_0?>
       <?php if($frmModo=="modificar"){ ?>
       <input type="text" name="txtCURSO_1" size=30 maxlength=1000 value="<?php echo trim($row_cu_0['nombre'])?>" />
       <?php };?>
&nbsp;&nbsp;&nbsp;</td>
     <td class="cuadro02"><b>A&Ntilde;O</b></td>
     <td class="cuadro01"><?php 
				
				if($frmModo=="ingresar"){ ?>
       <input name="ano_curso_1" type="text" id="ano_curso_1" size="5" maxlength="4" />
       <?php };?>
       <?php if($row_cu_0!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_0['ano']);
					};
				}//fin if($row_cu_0!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input name="ano_curso_1" type="text" id="ano_curso_2" value="<?php echo trim($row_cu_0['ano'])?>" size="5" maxlength="4" />
       <?php };?></td>
   </tr>
   <tr>
     <td class="cuadro02"><b>HORAS</b></td>
     <td class="cuadro01"><?php 
				
				if($frmModo=="ingresar"){ ?>
       <input name="horas_curso_1" type="text" id="horas_curso_1" size="5" maxlength="4" />
       <?php };?>
       <?php if($row_cu_0!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_0['horas']);
					};
				}//fin if($row_cu_0!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input name="horas_curso_1" type="text" id="horas_curso_1" value="<?php echo trim($row_cu_0['horas'])?>" size="5" maxlength="4" />
       <?php };?></td>
     <td class="cuadro02">&nbsp;</td>
     <td class="cuadro02">&nbsp;</td>
   </tr>
   <tr>
     <td class="cuadro02"><b>CURSO 2 </b></td>
     <td class="cuadro01"><?php $row_cu_1 = @pg_fetch_array($res_cu,1); ?>
       <?php 
				
				if($frmModo=="ingresar"){ ?>
       <input name="txtCURSO_2" type="text" size=30 maxlength=1000 />
       <?php };?>
       <?php if($row_cu_1!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_1['nombre']);
					};
				}//fin if($row_cu_0!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input type="text" name="txtCURSO_2" size=30 maxlength=1000 value="<?php echo trim($row_cu_1['nombre'])?>" />
       <?php };?>
&nbsp;&nbsp;&nbsp;</td>
     <td class="cuadro02"><b>A&Ntilde;O</b></td>
     <td class="cuadro01"><?php 
				
				if($frmModo=="ingresar"){ ?>
       <input name="ano_curso_2" type="text" id="ano_curso_2" size="5" maxlength="4" />
       <?php };?>
       <?php if($row_cu_1!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_1['ano']);
					};
				}//fin if($row_cu_1!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input name="ano_curso_2" type="text" id="ano_curso_2" value="<?php echo trim($row_cu_1['ano'])?>" size="5" maxlength="4" />
       <?php };?></td>
   </tr>
   <tr>
     <td class="cuadro02"><b>HORAS</b></td>
     <td class="cuadro01"><?php 
				
				if($frmModo=="ingresar"){ ?>
       <input name="horas_curso_2" type="text" id="horas_curso_2" size="5" maxlength="4" />
       <?php };?>
       <?php if($row_cu_1!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_1['horas']);
					};
				}//fin if($row_cu_1!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input name="horas_curso_2" type="text" id="horas_curso_2" value="<?php echo trim($row_cu_1['horas'])?>" size="5" maxlength="4" />
       <?php };?></td>
     <td class="cuadro02">&nbsp;</td>
     <td class="cuadro02">&nbsp;</td>
   </tr>
   <tr>
     <td class="cuadro02"><b>CURSO 3 </b></td>
     <td class="cuadro01"><?php $row_cu_2 = @pg_fetch_array($res_cu,2); ?>
       <?php 
				
				if($frmModo=="ingresar"){ ?>
       <input type="text" name="txtCURSO_3" size=30 maxlength=1000 />
       <?php };?>
       <?php if($row_cu_2!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_2['nombre']);
					};
				}//fin if($row_cu_1!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input type="text" name="txtCURSO_3" size=30 maxlength=1000 value="<?php echo trim($row_cu_2['nombre'])?>" />
       <?php };?></td>
     <td class="cuadro02"><b>A&Ntilde;O</b></td>
     <td class="cuadro01"><?php 
				
				if($frmModo=="ingresar"){ ?>
       <input name="ano_curso_3" type="text" id="ano_curso_3" size="5" maxlength="4" />
       <?php };?>
       <?php if($row_cu_2!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_2['ano']);
					};
				}//fin if($row_cu_2!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input name="ano_curso_3" type="text" id="ano_curso_3" value="<?php echo trim($row_cu_2['ano'])?>" size="5" maxlength="4" />
       <?php };?></td>
   </tr>
   <tr>
     <td class="cuadro02"><b>HORAS</b></td>
     <td class="cuadro01"><?php 
				
				if($frmModo=="ingresar"){ ?>
       <input name="horas_curso_3" type="text" id="horas_curso[3]" size="5" maxlength="4" />
       <?php };?>
       <?php if($row_cu_2!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_2['horas']);
					};
				}//fin if($row_cu_2!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input name="horas_curso_3" type="text" id="horas_curso[3]" value="<?php echo trim($row_cu_2['horas'])?>" size="5" maxlength="4" />
       <?php };?></td>
     <td class="cuadro02">&nbsp;</td>
     <td class="cuadro02">&nbsp;</td>
   </tr>
   <tr>
     <td class="cuadro02"><b>CURSO 4 </b></td>
     <td class="cuadro01">
       <?php $row_cu_3 = @pg_fetch_array($res_cu,3); ?>
       <?php 
				
				if($frmModo=="ingresar"){ ?>
       <input type="text" name="txtCURSO_4" size=30 maxlength=1000 />
       <?php };?>
       <?php if($row_cu_3!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_3['nombre']);
					};
				}//fin if($row_cu_3!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input type="text" name="txtCURSO_4" size=30 maxlength=1000 value="<?php echo trim($row_cu_3['nombre'])?>" />
       <?php };?>
&nbsp;&nbsp;&nbsp;</td>
     <td class="cuadro02"><b>A&Ntilde;O</b></td>
     <td class="cuadro01">
       <?php 
				if($frmModo=="ingresar"){ ?>
       <input name="ano_curso_4" type="text" id="ano_curso_4" size="5" maxlength="4" />
       <?php };?>
       <?php if($row_cu_3!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_3['ano']);
					};
				}//fin if($row_cu_3!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input name="ano_curso_4" type="text" id="ano_curso_4" value="<?php echo trim($row_cu_3['ano'])?>" size="5" maxlength="4" />
       <?php };?>
     &nbsp; </td>
   </tr>
   <tr>
     <td class="cuadro02"><b>HORAS</b></td>
     <td class="cuadro01">
	        <?php
				 
				if($frmModo=="ingresar"){ ?>
       <input name="horas_curso_4" type="text" id="horas_curso_4" size="5" maxlength="4" />
       <?php };?>
       <?php if($row_cu_3!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_3['horas']);
					};
				}//fin if($row_cu_3!=""){?>
       <?php if($frmModo=="modificar"){ ?>
       <input name="horas_curso_4" type="text" id="horas_curso_4" value="<?php echo trim($row_cu_3['horas'])?>" size="5" maxlength="4" />
       <?php };?>
     &nbsp; </td>
     <td class="cuadro02">&nbsp;</td>
     <td class="cuadro02">&nbsp;</td>
   </tr>
   
   <?php 	$sql_cu="SELECT * FROM empleado_estudios WHERE rut_empleado='".$empleado."' AND tipo=4 order by orden"; 
					$res_cu = @pg_exec($conn, $sql_cu);
					$cant_cu = @pg_numrows($res_cu);
			?>
			
			
   <tr>
     <td class="cuadro02"><b>RESUMEN DE ESTUDIOS</b></td>
     <td class="cuadro01">
       <?php if($frmModo=="ingresar"){ ?>
       <textarea name="txtESTUDIOS" cols="25" rows="3"></textarea>
       <?php };?>
       <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['estudios']);
												};
											?>
       <?php if($frmModo=="modificar"){ ?>
       <textarea name="txtESTUDIOS" cols="25" rows="3"> <?php echo trim($fila['estudios'])?></textarea>
       <?php };?>
     </td>
     <td class="cuadro02">&nbsp;</td>
     <td class="cuadro02">&nbsp;</td>
   </tr>
 </table>	   
    </spam>
	
	
 
     </td>
	 </tr>
 </table>		
</form>
</div>
 
   
</TD>
</TR>
		
		
								
			<TR  id="curriculum">
			   <TD>
			    			 
				  <TABLE width=100%  height=30 Border=0 cellpadding=1 cellspacing=0>
					<TR>
					  <TD  align=left class="tableindex"><font color="<?=$colortxt ?>">Curriculum</font></TD>
					</TR>
				   </TABLE>				
				   
				   	
					<!-- codigo de los botones -->					  				  
					
					<FORM name="form2" method="post" action="procesoEmpleado.php3?pesta=3" enctype="multipart/form-data">			   
							
					  
						 <TABLE width=100%  height=100 Border=0 cellpadding=1 cellspacing=0>
					         <TR >
							  <TD align=right colspan=0>							
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarEmpleado.php3">&nbsp;
								<?php };?>
								
								<?php if($frmModo=="mostrar"){ ?>
								              <!--  <script language="javascript" type="text/javascript">
												function abre_pop_empleado(){
														valor=<? echo trim($fila['rut_emp']);?>;
														 var opciones="left=100,top=100,width=540,height=300,scrollbars=yes,resizable =yes"
														url='pop_nivel.php?rut_empleado='+valor;
													window.open(url,"a",opciones)
												}
												</script>
                               <input name=btn_nivel type="button" class="botonXX" id="btn_nivel"  onClick="abre_pop_empleado();"  value="NIVEL"> -->
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=25)&&($_PERFIL!=26)){ //ACADEMICO Y LEGAL?>
                                    <?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>										
                                    <INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaEmpleado.php3?empleado=<?php echo $empleado?>&caso=3&pesta=3">&nbsp;
								<!--		<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaEmpleado.php3?caso=9">&nbsp;  -->
											<?php }?>
									<?php }//ACADEMICO Y LEGAL?>
								<!--	<INPUT class="botonXX"  TYPE="button" value="LISTADO" onClick=document.location="listarEmpleado.php3">&nbsp;   -->
								<?php };?>


								<?php if($frmModo=="modificar"){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name="btnGuardar" onClick="return valida(this.form);">&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaEmpleado.php3?empleado=<?php echo $empleado?>&caso=1">&nbsp;
								<?php };?>
								
								
								<?php if($frmModo=="mostrar"){?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=25)&&($_PERFIL!=26)){ //ACADEMICO Y LEGAL?>
									<!--	<INPUT class="botonXX"  TYPE="button" value="ACCESO WEB" onClick=document.location="usuario/usuario.php3">  -->
									<!--	<INPUT class="botonXX"  TYPE="button" value="ANOTACIONES" onClick=document.location="anotacion/listarAnotacion.php3"> -->
										<?php
											echo "<INPUT class='botonXX'  TYPE=button value=FOTO onClick=window.open('frmFoto.php3?rut=",$empleado,"','CodigoProducto','height=200,width=380,scrollbar=no,location=no,resizable=no')			
											>";
										?>
									<?php }?>
								<?php } ?>							
							</TD>
						</TR>					
						<!-- fin codigo de los botones -->
						<TR>
					   <TD>		
				
					 
					    <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#666666">
					     <tr>
						<td width="15%" class="cuadro02"><b>CARGO 1</b></td>
						<td width="30%" class="cuadro01">						
						<?							 
											 
					  $query_trabaja="select * from trabaja  where rut_emp='".trim($_EMPLEADO)."' and rdb='".trim($_INSTIT)."' order by identificador";
					  $result_trabaja=@pg_exec($conn,$query_trabaja);
					  $num_trabaja=@pg_numrows($result_trabaja);
					//  echo "|||||".$num_trabaja;
					  $j = 0; $x = 0;
					  for ($i=1;$i<=1;$i++){
						  $row_trabaja=@pg_fetch_array($result_trabaja,$j);
						   ?>
						   <?php if($frmModo=="ingresar"){ ?>
                                 <select name="cmbCARGO<? echo $j ?>">
                                    <option value="0" selected></option>
                                    <option value="1" >Director(a)</option>
                                    <option value="2" >Jefe UTP</option>
                                    <option value="3" >Enfermeria</option>
									<option value="4" >Contador(a)</option>
									<option value="5" >Docente</option>
									<option value="6" >Sub-Director</option>
									<option value="7" >Inspector General</option>
									<option value="8" >Titulaci&oacute;n</option>
									<option value="9" >Curriculista</option>
									<option value="10" >Evaluador</option>
									<option value="11" >Orientador(a)</option>
									<option value="12" >Sicopedagogo(a)</option>
									<option value="13" >Sic&oacute;logo(a)</option>
									<option value="14" >Inspector(a)</option>
									<option value="15" >Auxiliar</option>
									<option value="16" >Coordinaci&oacute;n CRA</option>
									<option value="17" >Coordinaci&oacute;n Pastoral</option>
									<option value="18" >Coordinaci&oacute;n ACLE</option>
									<option value="19" >Secretaria</option>
									<option value="20" >Tesorero(a)</option>
									<option value="21" >Asistente Social</option>
									<option value="22" >Coordinaci&oacute;n Mantenimiento</option>
									<option value="23" >Rector</option>
									<option value="24" >Administrativo</option>
									<option value="27" >Jefe de Departamento</option>
									<option value="28" >Asistente de Parvulos</option>
								    <option value="29" >Bibliotecologo</option>
								    <option value="30" >Coordinador Acad&eacute;mico</option>
								    <option value="31" >Asistente Social</option>
									<option value="32" >Capellan</option>
                                    <option value=33 >Educador Diferencial</option>
      								<option value=34 >Educador de Parvulos</option>	
									<option value=35 >Director Básica</option>
									<option value=36 >Director Media</option>
									<option value=37 >Director Pre-Básica</option>
									<option value=38 >Jefe UTP Media</option>							
                                 </select>
                     <?php };?>
                     <?php
					 if($frmModo=="mostrar"){ 
							switch ($row_trabaja[cargo]) {
								 case 0:
									imp('&nbsp;');
									 break;
								 case 1:
									 imp('Director(a)');
									 break;
								 case 2:
									 imp('Jefe UTP');
									 break;
								 case 3:
									 imp('Enfermeria');
									 break;
								 case 4:
									 imp('Contador');
									 break;
								 case 5:
									 imp('Docente');
									 break;
								 case 6:
									 imp('Sub-Director');
									 break;
								 case 7:
									 imp('Inspector General');
									 break;
								 case 8:
									 imp('Titulacion');
									 break;
								 case 9:
									 imp('Curriculista');
									 break;
								 case 10:
									 imp('Evaluador');
									 break;
								 case 11:
									 imp('Orientador(a)');
									 break;
								 case 12:
									 imp('Sicopedagogo(a)');
									 break;
								 case 13:
									 imp('Sicologo(a)');
									 break;
								 case 14:
									 imp('Inspector(a)');
									 break;
								 case 15:
									 imp('Auxiliar');
									 break;
								 case 16:
									 imp('Coordinaci&oacute;n CRA');
									 break;
								 case 17:
									 imp('Coordinaci&oacute;n Pastoral');
									 break;
								 case 18:
									 imp('Coordinaci&oacute;n ACLE');
									 break;
								 case 19:
									 imp('Secretaria');
									 break;
								 case 20:
									 imp('Tesorero(a)');
									 break;
								 case 21:
									 imp('Asistente Social');
									 break;
								 case 22:
									 imp('Coordinaci&oacute;n Mantenimiento');
									 break;
								 case 23:
									 imp('Rector');
									 break;
								 case 24:
									 imp('Administrativo');	 
									 break;	 
								 case 27:
									 imp('Jefe de Departamento');	 
									 break;	 
								 case 28:
									 imp('Asistente de Parvulos');	 
									 break;	
								 case 29:
									 imp('Bibliotecologo');	 
									 break;	 
								 case 30:
									 imp('Coordinador Acad&eacute;mico');
								 case 31:
									 imp('Asistente Social');	 
									 break;	 
								 case 32:
									 imp('Capellan');													
									 break;																
								 case 33: 
									 imp('Educador Diferencial');
									 break;
								 case 34:
									imp('Educador de Parvulos');					
									break;	
								 case 35:
									imp('Director(a) Básica');					
									break;
								 case 36:
									imp('Director(a) Media');					
									break;		
								 case 37:
									imp('Director(a) Pre-Básica');					
									break;	
								 case 38:
									imp('Jefe UTP Media');					
									break;													
																	
							      };
							};  ?>
                           
				<?php if($frmModo=="modificar"){ ?>
                              <select name="cmbCARGO0">
                                <option value="0">Seleccione Cargo</option>
                                <option value="1" <?php echo ($row_trabaja['cargo'])==1?" selected ":"" ?>>Director(a)</option>
                                <option value="2" <?php echo ($row_trabaja['cargo'])==2?" selected ":"" ?>>Jefe UTP</option>
                                <option value="3" <?php echo ($row_trabaja['cargo'])==3?" selected ":"" ?>>Enfermeria</option>
                                <option value="4" <?php echo ($row_trabaja['cargo'])==4?" selected ":"" ?>>Contador(a)</option>
                                <option value="5" <?php echo ($row_trabaja['cargo'])==5?" selected ":"" ?>>Docente</option>
                                <option value="6" <?php echo ($row_trabaja['cargo'])==6?" selected ":"" ?>>Sub-Director</option>
                                <option value="7" <?php echo ($row_trabaja['cargo'])==7?" selected ":"" ?>>Inspector General</option>
                                <option value="8" <?php echo ($row_trabaja['cargo'])==8?" selected ":"" ?>>Titulaci&oacute;n</option>
                                <option value="9" <?php echo ($row_trabaja['cargo'])==9?" selected ":"" ?>>Curriculista</option>
                                <option value="10" <?php echo ($row_trabaja['cargo'])==10?" selected ":"" ?>>Evaluador</option>
                                <option value="11" <?php echo ($row_trabaja['cargo'])==11?" selected ":"" ?>>Orientador(a)</option>
                                <option value="12" <?php echo ($row_trabaja['cargo'])==12?" selected ":"" ?>>Sicopedagogo(a)</option>
                                <option value="13" <?php echo ($row_trabaja['cargo'])==13?" selected ":"" ?>>Sic&oacute;logo(a)</option>
                                <option value="14" <?php echo ($row_trabaja['cargo'])==14?" selected ":"" ?>>Inspector(a)</option>
                                <option value="15" <?php echo ($row_trabaja['cargo'])==15?" selected ":"" ?>>Auxiliar</option>
                                <option value="16" <?php echo ($row_trabaja['cargo'])==16?" selected ":"" ?>>Coordinaci&oacute;n CRA</option>
                                <option value="17" <?php echo ($row_trabaja['cargo'])==17?" selected ":"" ?>>Coordinaci&oacute;n Pastoral</option>
                                <option value="18" <?php echo ($row_trabaja['cargo'])==18?" selected ":"" ?>>Coordinaci&oacute;n ACLE</option>
                                <option value="19" <?php echo ($row_trabaja['cargo'])==19?" selected ":"" ?>>Secretaria</option>
                                <option value="20" <?php echo ($row_trabaja['cargo'])==20?" selected ":"" ?>>Tesorero(a)</option>
                                <option value="21" <?php echo ($row_trabaja['cargo'])==21?" selected ":"" ?>>Asistente Social</option>
                                <option value="22" <?php echo ($row_trabaja['cargo'])==22?" selected ":"" ?>>Coordinaci&oacute;n Mantenimiento</option>
								<option value="23" <?php echo ($row_trabaja['cargo'])==23?" selected ":"" ?>>Rector</option>
								<option value="24" <?php echo ($row_trabaja['cargo'])==24?" selected ":"" ?>>Administrativo</option>
								<option value="27" <?php echo ($row_trabaja['cargo'])==27?" selected ":"" ?>>Jefe de Departamento</option>
								<option value="28" <?php echo ($row_trabaja['cargo'])==28?" selected ":"" ?>>Asistente de Parvulos</option>
								<option value="29" <?php echo ($row_trabaja['cargo'])==29?" selected ":"" ?>>Bibliotecologo</option>
								<option value="30" <?php echo ($row_trabaja['cargo'])==30?" selected ":"" ?>>Coordinador Acad&eacute;mico</option>
	  							<option value="31" <?php echo ($row_trabaja['cargo'])==31?" selected ":"" ?>>Asistente Social</option>
	  							<option value="32" <?php echo ($row_trabaja['cargo'])==32?" selected ":"" ?>>Capellan</option>
                                <option value="33" <? echo ($row_trabaja['cargo'])==33?" selected ":"" ?>>Educador Diferencial</option>
      							<option value="34" <? echo ($row_trabaja['cargo'])==34?" selected ":"" ?>>Educador de Parvulos</option>	
								<option value="35" <? echo ($row_trabaja['cargo'])==35?" selected ":"" ?>>Director(a) Básica</option>	
								<option value="36" <? echo ($row_trabaja['cargo'])==36?" selected ":"" ?>>Director(a) Media</option>	
								<option value="37" <? echo ($row_trabaja['cargo'])==37?" selected ":"" ?>>Director(a) Pre-Básica</option>
								<option value="38" <? echo ($row_trabaja['cargo'])==38?" selected ":"" ?>>Jefe UTP Media</option>							
                              </select>
          <?php }
						  
			 }  ?>
	
	
	</td>
    <td width="15%" class="cuadro02"><b>CARGO 2</b></td>
    <td width="30%" class="cuadro01"> 
	
	   <? 
								  
				  $query_trabaja="select * from trabaja  where rut_emp='".trim($_EMPLEADO)."' and rdb='".trim($_INSTIT)."' order by identificador";
				  $result_trabaja=@pg_exec($conn,$query_trabaja);
				  $num_trabaja=@pg_numrows($result_trabaja);
				   ?>
				  
				   <input type="hidden" name="cargos" value="<?=$num_trabaja ?>">
				  
				  <?			 
				  $j = 1; $x = 0;
				  for ($i=2;$i<=2;$i++){
				  $row_trabaja=@pg_fetch_array($result_trabaja,$j);
				  	?>	
							
							
                          <?php if($frmModo=="ingresar"){
								  ?>
                                  <select name="cmbCARGO<? echo $j?>">
                                  <option value="0" selected></option>
                                  <option value="1" >Director(a)</option>
                                  <option value="2" >Jefe UTP</option>
                                  <option value="3" >Enfermeria</option>
                                  <option value="4" >Contador(a)</option>
                                  <option value="5" >Docente</option>
                                  <option value="6" >Sub-Director</option>
                                  <option value="7" >Inspector General</option>
                                  <option value="8" >Titulaci&oacute;n</option>
                                <option value="9" >Curriculista</option>
                                <option value="10" >Evaluador</option>
                                <option value="11" >Orientador(a)</option>
                                <option value="12" >Sicopedagogo(a)</option>
                                <option value="13" >Sic&oacute;logo(a)</option>
                                <option value="14" >Inspector(a)</option>
                                <option value="15" >Auxiliar</option>
                                <option value="16" >Coordinaci&oacute;n CRA</option>
                                <option value="17" >Coordinaci&oacute;n Pastoral</option>
                                <option value="18" >Coordinaci&oacute;n ACLE</option>
                                <option value="19" >Secretaria</option>
                                <option value="20" >Tesorero(a)</option>
                                <option value="21" >Asistente Social</option>
                                <option value="22" >Coordinaci&oacute;n Mantenimiento</option>
								<option value="23" >Rector</option>
								<option value="24" >Administrativo</option>
								<option value="27" >Jefe de Departamento</option>
								<option value="28" > Asistente de Parvulos</option>
							    <option value="29" >Bibliotecologo</option>
							    <option value="30" >Coordinador Acad&eacute;mico</option>	
								<option value="31" >Asistente Social</option>
								<option value="32" >Capellan</option>
                                <option value="33" >Educador Diferencial</option>
      							<option value="34" >Educador de Parvulos</option>	
								<option value=35 >Director Básica</option>
								<option value=36 >Director Media</option>
								<option value=37 >Director Pre-Básica</option>
								<option value=38 >Jefe UTP Media</option>																							
                              </select>
                            <?php };?>
                           <?php
									if($frmModo=="mostrar"){
										    																														
																switch ($row_trabaja[cargo]) {
																	 case 0:
																		 imp('&nbsp;');
																		 break;
																	 case 1:
																		 imp('Director(a)');
																		 break;
																	 case 2:
																		 imp('Jefe UTP');
																		 break;
																	 case 3:
																		 imp('Enfermeria');
																		 break;
																	 case 4:
																		 imp('Contador');
																		 break;
																	 case 5:
																		 imp('Docente');
																		 break;
																	 case 6:
																		 imp('Sub-Director');
																		 break;
																   	 case 7:
																		 imp('Inspector General');
																		 break;
																 	 case 8:
																		 imp('Titulacion');
																		 break;
																	 case 9:
																		 imp('Curriculista');
																		 break;
																	 case 10:
																		 imp('Evaluador');
																		 break;
																	 case 11:
																		 imp('Orientador(a)');
																		 break;
																	 case 12:
																		 imp('Sicopedagogo(a)');
																		 break;
																	 case 13:
																		 imp('Sicologo(a)');
																		 break;
																	 case 14:
																		 imp('Inspector(a)');
																		 break;
																	 case 15:
																		 imp('Auxiliar');
																		 break;
																	 case 16:
																		 imp('Coordinaci&oacute;n CRA');
																		 break;
																	 case 17:
																		 imp('Coordinaci&oacute;n Pastoral');
																		 break;
																	 case 18:
																		 imp('Coordinaci&oacute;n ACLE');
																		 break;
																	 case 19:
																		 imp('Secretaria');
																		 break;
															 		 case 20:
																		 imp('Tesorero(a)');
																		 break;
																	 case 21:
																		 imp('Asistente Social');
																		 break;
															    	 case 22:
																		 imp('Coordinaci&oacute;n Mantenimiento');
																		 break;
																	 case 23:
																		 imp('Rector');
																	 case 24:
																		 imp('Administrativo');	 
																		 break;
																	case 27:
																		 imp('Jefe de Departamento');	 
																		 break;	 
																      case 28:
																		 imp('Asistente de Parvulos');	 
																		 break;	
																	case 29:
																		 imp('Bibliotecologo');	 
																		 break;	 																		 
																      case 30:
																		 imp('Coordinador Acad&eacute;mico');	 
																		 break;	
																     case 31:
																		 imp('Asistente Social');	 
																		 break;	 
																	 case 32:
																		 imp('Capellan');
																		 break;	
																	case 33: 
																		 imp('Educador Diferencial');
																		 break;
      																 case 34:
																	 	imp('Educador de Parvulos');
																		break;	 
																	 case 35:
																		imp('Director(a) Básica');					
																		break;
																	 case 36:
																		imp('Director(a) Media');					
																		break;		
																	 case 37:
																		imp('Director(a) Pre-Básica');					
																		break;	
																	 case 38:
																		imp('Jefe UTP Media');					
																		break;	
																 };
															};
														?>
                              <?php if($frmModo=="modificar"){ ?>
                             
                              <select name="cmbCARGO1">
                                <option value="0">Seleccione Cargo</option>
                                <option value="1" <?php echo ($row_trabaja['cargo'])==1?" selected ":"" ?>>Director(a)</option>
                                <option value="2" <?php echo ($row_trabaja['cargo'])==2?" selected ":"" ?>>Jefe UTP</option>
                                <option value="3" <?php echo ($row_trabaja['cargo'])==3?" selected ":"" ?>>Enfermeria</option>
                                <option value="4" <?php echo ($row_trabaja['cargo'])==4?" selected ":"" ?>>Contador(a)</option>
                                <option value="5" <?php echo ($row_trabaja['cargo'])==5?" selected ":"" ?>>Docente</option>
                                <option value="6" <?php echo ($row_trabaja['cargo'])==6?" selected ":"" ?>>Sub-Director</option>
                                <option value="7" <?php echo ($row_trabaja['cargo'])==7?" selected ":"" ?>>Inspector General</option>
                                <option value="8" <?php echo ($row_trabaja['cargo'])==8?" selected ":"" ?>>Titulaci&oacute;n</option>
                                <option value="9" <?php echo ($row_trabaja['cargo'])==9?" selected ":"" ?>>Curriculista</option>
                                <option value="10" <?php echo ($row_trabaja['cargo'])==10?" selected ":"" ?>>Evaluador</option>
                                <option value="11" <?php echo ($row_trabaja['cargo'])==11?" selected ":"" ?>>Orientador(a)</option>
                                <option value="12" <?php echo ($row_trabaja['cargo'])==12?" selected ":"" ?>>Sicopedagogo(a)</option>
                                <option value="13" <?php echo ($row_trabaja['cargo'])==13?" selected ":"" ?>>Sic&oacute;logo(a)</option>
                                <option value="14" <?php echo ($row_trabaja['cargo'])==14?" selected ":"" ?>>Inspector(a)</option>
                                <option value="15" <?php echo ($row_trabaja['cargo'])==15?" selected ":"" ?>>Auxiliar</option>
                                <option value="16" <?php echo ($row_trabaja['cargo'])==16?" selected ":"" ?>>Coordinaci&oacute;n CRA</option>
                                <option value="17" <?php echo ($row_trabaja['cargo'])==17?" selected ":"" ?>>Coordinaci&oacute;n Pastoral</option>
                                <option value="18" <?php echo ($row_trabaja['cargo'])==18?" selected ":"" ?>>Coordinaci&oacute;n ACLE</option>
                                <option value="19" <?php echo ($row_trabaja['cargo'])==19?" selected ":"" ?>>Secretaria</option>
                                <option value="20" <?php echo ($row_trabaja['cargo'])==20?" selected ":"" ?>>Tesorero(a)</option>
                                <option value="21" <?php echo ($row_trabaja['cargo'])==21?" selected ":"" ?>>Asistente Social</option>
                                <option value="22" <?php echo ($row_trabaja['cargo'])==22?" selected ":"" ?>>Coordinaci&oacute;n Mantenimiento</option>
								<option value="23" <?php echo ($row_trabaja['cargo'])==23?" selected ":"" ?>>Rector</option>
								<option value="24" <?php echo ($row_trabaja['cargo'])==24?" selected ":"" ?>>Administrativo</option>
								<option value="27" <?php echo ($row_trabaja['cargo'])==27?" selected ":"" ?>>Jefe de Departamento</option>
								<option value="28" <?php echo ($row_trabaja['cargo'])==28?" selected ":"" ?>>Asistente de Parvulos</option>
							    <option value="29" <?php echo ($row_trabaja['cargo'])==29?" selected ":"" ?>>Bibliotecologo</option>
							    <option value="30" <?php echo ($row_trabaja['cargo'])==30?" selected ":"" ?>>Coordinador Acad&eacute;mico</option>
	  							<option value="31" <?php echo ($row_trabaja['cargo'])==31?" selected ":"" ?>>Asistente Social</option>
	  							<option value="32" <?php echo ($row_trabaja['cargo'])==32?" selected ":"" ?>>Capellan</option>
                                <option value="33" <? echo ($row_trabaja['cargo'])==33?" selected ":"" ?>>Educador Diferencial</option>
      							<option value="34" <? echo ($row_trabaja['cargo'])==34?" selected ":"" ?>>Educador de Parvulos</option>	
								<option value="35" <? echo ($row_trabaja['cargo'])==35?" selected ":"" ?>>Director(a) Básica</option>	
								<option value="36" <? echo ($row_trabaja['cargo'])==36?" selected ":"" ?>>Director(a) Media</option>	
								<option value="37" <? echo ($row_trabaja['cargo'])==37?" selected ":"" ?>>Director(a) Pre-Básica</option>
								<option value="38" <? echo ($row_trabaja['cargo'])==38?" selected ":"" ?>>Jefe UTP Media</option>																	
                              </select>
                              <?php }
							  
						} ?>
	
	
	
    </td>
  </tr>
  <tr>
    <td class="cuadro02"><b>IDIOMAS </b></td>
    <td class="cuadro01">
      <?php if($frmModo=="ingresar"){ ?>
      <input name="txtIDIOMAS" type="text" id="txtIDIOMAS" size="30" maxlength="100" />
      <?php };?>
      <?php
					if($frmModo=="mostrar"){ 
						echo trim($fila['idiomas']);
					};
				?>
      <?php if($frmModo=="modificar"){ ?>
      <input name="txtIDIOMAS" type="text" id="txtIDIOMAS" value="<?php echo trim($fila['idiomas'])?>" size="30" maxlength="100" />
      <?php };?>
    </td>
    <td class="cuadro02"><b>A&Ntilde;OS DE EXPERIENCIA</b></td>
    <td class="cuadro01">
      <?php if($frmModo=="ingresar"){ ?>
      <input name="txtEXPERIENCIA" type="text" id="txtEXPERIENCIA" size="5" maxlength="5" />
      <?php };?>
      <?php
					if($frmModo=="mostrar"){ 
						echo trim($fila['anos_exp']);
					};
				?>
      <?php if($frmModo=="modificar"){ ?>
      <input name="txtEXPERIENCIA" type="text" onChange="" id="txtEXPERIENCIA" value="<?php echo trim($fila['anos_exp'])?>" size="5" maxlength="5" />
      <?php };?>
    </td>
  </tr>
  <tr>
    <td class="cuadro02"><b>NRO. HORAS POR CONTRATO</b></td>
    <td class="cuadro01">
    <?
							 if (($frmModo == "modificar") or ($frmModo == "ingresar")){ ?>
    <input name="horasxcontrato" id="horasxcontrato" type="text"  size="5" maxlength="5" value="<?php echo trim($fila['hxcontrato'])?>" />
    <?
						     }
							 if ($frmModo == "mostrar"){
							     echo trim($fila['hxcontrato']);
							 }	 
							 		 
							  ?>
    </td>
    <td class="cuadro02"><b>NRO. HORAS POR CLASE</b></td>
    <td class="cuadro01">
      <?
							if (($frmModo == "modificar") or ($frmModo == "ingresar")){ ?>
      <input name="horasxclase" type="text" id="horasxclase"  size="5" maxlength="5" value="<?php echo trim($fila['hxclase'])?>"/>
      <? }
								
							if ($frmModo == "mostrar"){
							    echo trim($fila['hxclase']);
							}
							?>
    </td>
  </tr>
  <tr>
  	<td class="cuadro02"><strong>RESPONSABLE DE ANOTACIONES</strong></td>
	<td class="cuadro01">
      <?
		if (($frmModo == "modificar") or ($frmModo == "ingresar")){ ?>
	      <input name="anotacion"  type="checkbox" id="anotacion" value="1"/>
      <? }
		if ($frmModo == "mostrar"){
		   echo "SI";
		}
	  ?>
    </td>
	<td class="cuadro02">CURRICULUM</td>
	<td>
	<?	if (($frmModo == "modificar") or ($frmModo == "ingresar")){ ?>
			<input name="archivo" type="file" id="archivo">
	<? }
	  		if ($frmModo == "mostrar"){?>
				<a onMouseOver="this.style.cursor='hand'" title="Descargar" href="../../../../tmp/<?php echo trim($fila['curriculum'])?>">
			  		<img src="../../../images/logo_word.jpg" border="0" height="20" width="20">
			  	</a>
	<?	}  ?>
    		
	</td>
  </tr>
</table>
     <!-- nuevos campos -->
	 <br>
	 <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#666666">
	    <tr>
		  <td colspan="4" class="cuadro02">TRABAJA EN OTRA INSTITUCION </td>
		</tr>
		
		<tr>
		   <td width="20%" class="cuadro02">INSTITUCION </td>
		   <td width="60%" class="cuadro01">&nbsp;
		   <?
		   if ($frmModo=="mostrar"){
		       echo trim($fila['t_institucion1']);
		   }
		   if ($frmModo=="modificar"){ ?>			   	   
		        <input type="text" name="t_institucion1" size="50">
	    <? } ?>				
		   </td>
		   <td width="10%" class="cuadro02">HORAS </td>
		   <td width="10%" class="cuadro01">&nbsp;
		   <?
		   if ($frmModo=="mostrar"){
		       echo trim($fila['t_hora1']);
		   }
		   if ($frmModo=="modificar"){ ?>
		        <input type="text" name="t_hora1" size="3"></td>
		<? } ?>
		 
		</tr>
		
		<tr>
		   <td width="20%" class="cuadro02">INSTITUCION </td>
		   <td width="60%" class="cuadro01">&nbsp;
		   <?
		   if ($frmModo=="mostrar"){
		       echo trim($fila['t_institucion2']);
		   }
		   if ($frmModo=="modificar"){ ?>
		       <input type="text" name="t_institucion2" size="50">
		<? } ?> 
		   </td>  
		   <td width="10%" class="cuadro02">HORAS </td>
		   <td width="10%" class="cuadro01">&nbsp;
		   <?
		   if ($frmModo=="mostrar"){
		       echo trim($fila['t_hora2']);
		   }
		   if ($frmModo=="modificar"){ ?>		   
		       <input type="text" name="t_hora2" size="3">
		<? } ?>
		   </td>
		</tr>
		
		<tr>
		   <td width="20%" class="cuadro02">INSTITUCION </td>
		   <td width="60%" class="cuadro01">&nbsp;
		   <?
		   if ($frmModo=="mostrar"){
		       echo trim($fila['t_institucion3']);
		   }
		   if ($frmModo=="modificar"){ ?>
		        <input type="text" name="t_institucion3" size="50">
		<? } ?>	
		   </td>	   
		   <td width="10%" class="cuadro02">HORAS </td>
		   <td width="10%" class="cuadro01">&nbsp;
		   <?
		   if ($frmModo=="mostrar"){
		       echo trim($fila['t_hora3']);
		   }
		   if ($frmModo=="modificar"){ ?>
		       <input type="text" name="t_hora3" size="3">
		<? } ?>	   
		   </td>
		</tr>     
	 </table>
	 
	 
				
						</TD>
						</TR>
				</TABLE>				
				</FORM>			
				
				
				
	<!--- pestaña nueva de acceso web -->
			
			<tr  id="accesoweb">
			  	<td valign="top">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
					  <tr><TD colspan=2 class="tableindex"> <font color="<?=$colortxt ?>">Acceso Web </font></TD>
					  </tr>
					  <?
					  if (($_PERFIL == 0) || ($_PERFIL == 14) || ($_PERFIL == 1)){
					    ?>
					     <TR height=15>
							<TD width="100%" colspan=2 align=right>
							<? if($_PERFIL == 0){?> 
							 <INPUT class="BotonXX"  TYPE="button" value="AGREGAR EXPIRACION" onClick=document.location="usuario/expiracion.php">
							<? } ?>
							 <INPUT class="BotonXX"  TYPE="button" value="CAMBIAR CLAVE" onClick=document.location="usuario/claveAcceso.php3">
							  
							 <INPUT class="BotonXX"  TYPE="button" value="AGREGAR PERFIL" onClick=document.location="usuario/addPerfil.php3">
							 
							</TD>
						</TR>
						<?
						} ?>			  
					  
					  			  
					  <tr><td>
					  <?
					  $qry="select * from usuario where nombre_usuario='".trim($empleado)."'";
	                  $result =@pg_Exec($conn,$qry);
		              if (!$result) {
		                  error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	                  }else{
		                  if (pg_numrows($result)!=0){
			                  $fila1 = @pg_fetch_array($result,0);	
			                  if (!$fila1){
				                  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				                  exit();
			                  }else{
				                  $idUsuario=trim($fila1['id_usuario']);
			                  };
		                 };
	                  };

	                  $_ID_USER	=	$idUsuario;
	                  if(!session_is_registered('_ID_USER')){
		                  session_register('_ID_USER');
	                  };
					  ?>
					  
					  
					
					  
					  <TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0 height="100%">
						
					<?php if($idUsuario!="") {//SI EL NOMBRE DE USUARIO YA ESTA REGISTRADO COMO USUARIO DE COE?> 
						    
						<TR>
							
							<TD align="center">
								<TABLE BORDER=1 CELLSPACING=0 CELLPADDING=3 width=100% align="center" bordercolor="#666666">
									<TR>
										<TD width="30%" class="cuadro02">
												<STRONG>NOMBRE USUARIO</STRONG></TD>
									    <TD class="cuadro01"><?php 
												imp(trim($empleado));
											?></TD>
									</TR>					
									
									
								</TABLE>							</TD>
						</TR>
						<TR>
							<TD align="center">
								<TABLE BORDER=1 CELLSPACING=0 CELLPADDING=3 width=100% bordercolor="#666666">
									<TR>
										<TD width="30%" class="cuadro02">
												<STRONG>PERFILES DE ACCESO</STRONG>	</TD>
									    <TD class="cuadro01"><?php
													$qry="SELECT usuario.id_usuario, usuario.nombre_usuario, accede.estado, accede.rdb, perfil.id_perfil, perfil.nombre_perfil FROM (accede INNER JOIN perfil ON accede.id_perfil = perfil.id_perfil) INNER JOIN usuario ON accede.id_usuario = usuario.id_usuario WHERE (((usuario.id_usuario)=".$idUsuario.") AND ((accede.rdb)=".$_INSTIT.")) ORDER BY NOMBRE_PERFIL ASC;";
													$result =@pg_Exec($conn,$qry);
													if (!$result){ 
														error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>');
													}else{
														if (pg_numrows($result)!=0){
															$fila1 = @pg_fetch_array($result,0);	
															if (!$fila1){
																error('<B> ERROR :</b>Error al acceder a la BD. (10)</B>');
																exit();
															};
															for($i=0 ; $i < @pg_numrows($result) ; $i++){
																$fila1 = @pg_fetch_array($result,$i);
																echo "- ".$fila1["nombre_perfil"];
																 if(($_PERFIL=="0")||($_PERFIL=="14")){
																	if($fila1["estado"]==1){?>
&nbsp;&nbsp;&nbsp;&nbsp;
<input name="button"  type=button class='BotonXX' onclick=document.location='usuario/onoffPerfil.php3?estado=1&perfil=<? echo $fila1["id_perfil"]; ?>&usuario=<? echo $fila1["id_usuario"]; ?>' value=DESACTIVAR />
<input name="button2"  type=button class='BotonXX' onclick=document.location='usuario/onoffPerfil.php3?accion=3&perfil=<? echo $fila1["id_perfil"]; ?>&usuario=<? echo $fila1["id_usuario"]; ?>' value=ELIMINAR />
<br />
<?																	}else{	?>
&nbsp;&nbsp;&nbsp;&nbsp;
<input name="button2"  type=button class='BotonXX' onclick=document.location='usuario/onoffPerfil.php3?estado=0&perfil=<? echo $fila1["id_perfil"]; ?>&usuario=<? echo $fila1["id_usuario"]; ?>' value=ACTIVAR />
<input name="button2"  type=button class='BotonXX' onclick=document.location='usuario/onoffPerfil.php3?accion=3&perfil=<? echo $fila1["id_perfil"]; ?>&usuario=<? echo $fila1["id_usuario"]; ?>' value=ELIMINAR />
<br />
<?																	}
																}
															}
														}
												};
											?></TD>
									</TR>
									
								</TABLE>							</TD>
						</TR>
						
						
		<?php }else{ //EMPLEADO SIN ACCESO WEB?>
						<TR>
							<TD colspan=3 class="cuadro02">
								<center><BR><BR><BR><BR>
									<b>USUARIO SIN ACCESO WEB</b> <BR>
									
									<INPUT class="BotonXX"  TYPE="button" value="CREAR CUENTA" onClick=document.location="usuario/creaAcceso.php3" <?php if(($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL==1)){echo " disabled ";}?>>&nbsp;
								</center>							</TD>
						</TR>
						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color=#003b85>										</TD>
									</TR>
									<TR>
										<TD align=right>
											<INPUT class="BotonXX"  TYPE="button" value="VOLVER" onClick=document.location="empleado.php3">										</TD>
									</TR>
								</TABLE>							</TD>
						</TR>
					<?php }?>
					</TABLE>  
				  	  
		           
			</TD>
		    </TR>			
			<!-- fin pestaña acceso web -->
															
				 </TD>
				 </TR>
				  </TABLE>
				  
				  
				  
				  
				  <!--- Pestaña grupos -->		
			
			<tr  id="grupos">
			  	<td valign="top">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
					  <tr><TD colspan=2 class="tableindex"> <font color="<?=$colortxt ?>">Grupos </font></TD>
					  </tr>	
					  		  
					  
					  <tr>
					     <td>
							
						 <?
						if ($agregarg==1){
							   $q1 = "select * from grupos where rdb = '".trim($institucion)."' order by nombre";
							   $r1 = pg_Exec($conn,$q1);
							   $n1 = pg_numrows($r1);
									
								 ?>
								<FORM method=post name="frm" action="procesoEmpleado.php3?pesta=5&graba=1">
                                <input name="pesta" type="hidden" value="5">
								<table width="100%" border="0" cellspacing="0" cellpadding="3">
								  <tr>
									<td colspan="3"><div align="right">
									  <label>
									  <input name="GRABAR" type="submit" id="GRABAR" value="GRABAR">
									  <input name="Submit" type="button" onClick="MM_goToURL('parent','empleado.php3?pesta=5');return document.MM_returnValue" value="VOLVER">
									  </label>
									</div></td>
									</tr>
									<tr>
									<td width="45%" class="cuadro02"><div align="left">Nombre</div></td>
									<td width="45%" class="cuadro02"><div align="left">Descripci&oacute;n</div></td>
									<td width="10%" class="cuadro02"><div align="center">&nbsp;</div></td>
									</tr>
									<?
									$i = 0;
									while ($i < $n1){
										 $f1 = pg_fetch_array($r1,$i);
										 $nombre      = $f1['nombre'];
										 $descripcion = $f1['descripcion'];
										 $id_grupo    = $f1['id_grupo'];
										 
										 // busco este grupo en la relacion_grupo
										 $q2 = "select * from relacion_grupo where id_grupo = '$id_grupo' and rut_integrante = '".trim($_EMPLEADO)."'";
										 $r2 = pg_Exec($conn,$q2);
										 $n2 = pg_numrows($r2);
											 
										 ?>
										 <?
										 if ($n2==0){ ?>
											 <tr>
											 <td class="cuadro01"><?=$nombre ?></td>
											 <td class="cuadro01"><?=$descripcion ?></td>
											 <td class="cuadro01"><div align="center">
											   <label></label>
											   <label><input type="checkbox" name="chg<?=$i ?>" value="<?=$id_grupo ?>">
											   </label>
											 </div></td>
											 </tr>
											 <?
										 }
										 
										 
										 $i++;
									}
									?>	 
								</table>
								</FORM>
								<?	
							  
							
						}else{					 
						 
						    $q1 = "select * from grupos, relacion_grupo where grupos.id_grupo = relacion_grupo.id_grupo and relacion_grupo.rut_integrante = '".trim($_EMPLEADO)."' and grupos.rdb = '".trim($institucion)."'";
							$r1 = pg_Exec($conn,$q1);
							$n1 = pg_numrows($r1);
							?>
								 
							 <table width="100%" border="0" cellspacing="0" cellpadding="3">
							    <?
								if (($_PERFIL == 14) OR ($_PERFIL == 0)){  ?>							
									<tr>
									<td colspan="3"><div align="right">
									  <label>
									  <input name="AGREGARGRUPO" type="submit" id="AGREGARGRUPO" onClick="MM_goToURL('parent','empleado.php3?pesta=5&agregarg=1');return document.MM_returnValue" value="AGREGAR" class="botonXX">
									  </label>
									</div></td>
									</tr>
							<? } ?>
								
								
								<tr>
								<td width="45%" class="cuadro02"><div align="left">Nombre</div></td>
								<td width="45%" class="cuadro02"><div align="left">Descripci&oacute;n</div></td>
								<?
								if (($_PERFIL==14) OR ($_PERFIL==0)){ ?>								
								    <td width="10%" class="cuadro02"><div align="center">Borrar</div></td>
							 <? } ?>	
								</tr>
								<?
								$i = 0;
								while ($i < $n1){
									 $f1 = pg_fetch_array($r1,$i);
									 $nombre      = $f1['nombre'];
									 $descripcion = $f1['descripcion'];
									 $id_aux      = $f1['id_aux'];
									 $id_grupo    = $f1['id_grupo'];
									 ?>
									 <tr>
									 <td class="cuadro01"><?=$nombre ?></td>

									 <td class="cuadro01"><?=$descripcion ?></td>
									 <?
									 if (($_PERFIL==14) OR ($_PERFIL==0)){ ?>									 
									     <td class="cuadro01"><div align="center">
									       <input name="Submit2" type="button" onClick="MM_goToURL('parent','procesoEmpleado.php3?pesta=5&borrar=1&id_grupo=<?=$id_grupo ?>');return document.MM_returnValue" value="B">
									     </div></td>
								 <? } ?>		 
									 </tr>
									 <?
									 $i++;
								}
								?>	 
							</table>
						 
						 <? } ?>				 
						 
						 </TD>
		              </TR>			
										 
			         </TABLE>
				 </TD>
		   </TR>
		   
		  <!-- fin pestaña grupos --> 
				  
				  
				  
				  
				  
														
			<!--</TD></TR>  -->

						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										
        <TD> <hr width="100%" color=#003b85></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR height=15>
							<TD width="100%" colspan=2>
								<?php if($frmModo=="mostrar"){?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){ //ACADEMICO Y LEGAL?>
									<!--	<INPUT class="botonXX"  TYPE="button" value="ACCESO WEB" onClick=document.location="usuario/usuario.php3">  -->
									<!--	<INPUT class="botonXX"  TYPE="button" value="ANOTACIONES" onClick=document.location="anotacion/listarAnotacion.php3"> -->
										<?php
									/*		echo "<INPUT class='botonXX'  TYPE=button value=FOTO onClick=window.open('frmFoto.php3?rut=",$empleado,"','CodigoProducto','height=200,width=380,scrollbar=no,location=no,resizable=no')			
											>";
										?>
									<?php }?>
								<?php }else{?>
										<!--INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ACCESO WEB" disabled>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ANOTACIONES" disabled>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="FOTO" disabled--> */
								 }
								
								 }?>
							</TD>
						</TR>
		
		</TABLE></TD></TR></Table>
	
		          
				  <? } ?>



	
		           
				

								  
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
						
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html><? pg_close($conn);?>
