<?php 
require "../../../../../util/header.php";
include_once('mod_ficha_alumno.php');

//echo pg_dbname($conn);

$ract = base64_decode($ract);

?>

<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>
<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.r2,'Ingresar RUT.')){
					return false;
				};

				if(!nroOnly(form.r2,'Se permiten sólo numeros en el RUT.')){
					return false;
				};
				
				 if(!chkVacio(form.dig,'Ingresar dígito verificador del RUT.')){
					return false;
			    };
				
			    if(!chkCod(form.r2,form.dig,'RUT inválido.')){
					return false;
			    };
			
				return true;
			}
		</SCRIPT>
<?php 

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP          =5;
	$_bot           =5;
	$alumno =$_ALUMNO;	
	
if ($sw == 1){
 
if($r2!=$r){   

echo "Modificando<br/>";
   
   // verificar si el rut ya existe en la tabla alumnos
   $q1 = "select * from alumno where rut_alumno = '".trim($r2)."'; ";
   $r1 = @pg_Exec($conn,$q1);

   
   /*asistencia+
   asiste_actividad+
   asistencia_mensual
   becas_benef+
   vitacora_alumno+
   vitacora_destaca+
   vitacora_nota+
   tiene_taller*/
   
   if( pg_num_rows($r1) ==0 ){ 

   // el rut nuevo no existe en base 
	  
	    $tablas = "
        alumno+
        anotacion+
        concentracion_detalle+
        concentracion_notas+
        evaluacion_detalle_nin+
        evaluacion_detalle_sup+
        evaluacion_nin+
        ficha_deportiva+
        ficha_medica+
        hermanos+
        inasistencia_asignatura+
        informe_evaluacion2+
        justifica_inasistencia+
        matricula+
        notas2002+
        notas2003+
        notas2004+
        notas2005+
        notas2006+
        notas2007+
        notas2008+
        notas2009+
        notas2010+
        notas2011+
		notas2012+
		notas2013+
		notas2014+
		notas2015+
		notas2016+
		notas2017+
		notas2018+
        notas_examen+
        notas_taller+
        observacion_evaluacion+
        orden_concentracion+
        promedio_alumno+
        promedio_examen+
        promedio_sub_alumno+
        promocion+
        relacion_hermanos+
        situacion_final+
        situacion_periodo+
        tiene2+
        tiene2002+
        tiene2003+
        tiene2004+
        tiene2005+
        tiene2006+
        tiene2007+
        tiene2008+
        tiene2009+
        tiene2010+
        tiene2011+
		tiene2012+
		tiene2013+
		tiene2014+
		tiene2015+
		tiene2016+
		tiene2017+
		tiene2018+
        tiene_taller";

         $a = explode('+',$tablas);
                  
          for($x=0; $x < count($a); $x++){
           
           $sql_select_1 = "SELECT * FROM ".$a[$x]." WHERE rut_alumno = '".trim($r)."'; ";
           $result_select_1 = pg_Exec($conn,$sql_select_1); // or die( pg_last_error($conn))
           
           $sql_select_2 = "SELECT * FROM ".$a[$x]." WHERE rut_alumno = '".trim($r2)."'; ";
           $result_select_2 = pg_Exec($conn,$sql_select_2);// or die( pg_last_error($conn))
          
		   if(pg_numrows($result_select_1)!=0){ //Que El Rut Actual Exista.
          
           if(pg_numrows($result_select_2)==0){ //Que el Rut Nuevo no Exita.
		
           // actualizamos las tablas correspondientes
           $sql_update = "update ".$a[$x]." set rut_alumno = '".trim($r2)."' WHERE rut_alumno = '".trim($r)."' ";
           $result_update = pg_Exec($conn,$sql_update) or die( pg_last_error($conn));
                
                if(!$result_update){
                  echo "Error en Actualizacion".pg_last_error($conn) ;
                }
             
             }else{ // ELIMINAR RUT NUEVO. PORQUE EXISTE. PARA ACTUALIZAR EL RUT ANTIGUO
                
                                
                $sql_delete = "DELETE FROM ".$a[$x]." WHERE  rut_alumno = '".trim($r2)."'";                  
                $result_update = pg_Exec($conn,$sql_delete) or die( pg_last_error($conn));
                
                //Actualizamos las tablas correspondientes del rut Antiguo.
                $sql_update = "update ".$a[$x]." set rut_alumno = '".trim($r2)."' WHERE rut_alumno = '".trim($r)."' ";
                $result_update = pg_Exec($conn,$sql_update) or die( pg_last_error($conn));
                
                if(!$result_update){
                  echo "Error en Actualizacion".pg_last_error($conn) ;
                }
                
                
              }  
             
             }
                      
           }
      
      
	  $exito = 1;
	  
	 
   }else{
	   echo "dentro else";
	   
	   echo "El Rut Nuevo Existe.";
	   
	   }
   
  }else{
	  
	  
	   //actualizamos las tablas correspondientes
                $sql_update = "UPDATE alumno SET rut_alumno = '".trim($r2)."',dig_rut='".trim($dig)."' 
				WHERE rut_alumno = '".trim($r)."' ";
                $result_update = pg_Exec($conn,$sql_update) or die( pg_last_error($conn));
                
                if(!$result_update){
                  echo "Error en Actualizacion".pg_last_error($conn) ;
                }
				
				echo "Rut y Dig Actualizados...";
				
				$exito = 1;
	  
	  } 
  
}
?>  
   

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Actualiza Rut Alumno</title>
<style type="text/css">
<!--
.Estilo4 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_callJS(jsStr) { //v2.0
return eval(jsStr)
}
//-->
</script>
</head>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body topmargin="0" leftmargin="0" rightmargin="0">
<script language=JavaScript>
<!--
var message="";
function clickIE() {if (document.all) {(message);return false;}}
function clickNS(e) {if 
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(message);return false;}}}
if (document.layers) 
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
document.oncontextmenu=new Function("return false")
// --> 
</script>
<? if ($exito == 1){
  
   ?>
   
   <!--body onload="form.submit()">
    <form method="post" action="javascript:opener.self.location='alumno.php3?alumno=<?=$r ?>&sw=1';window.close()" name="form">
    </form-->
	<script language="JavaScript" type="text/JavaScript">
		opener.self.location='alumno.php3?alumno=<?=$r2 ?>&sw=1';
		window.close();
	</script>


<? }else{ ?>

<form name="form1" method="post" action="vmrut.php">


<table width="300" height="250" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
     <tr>
      <td valign="top" bgcolor="#FFFFFF">	
        <table width="100%" height="200" border="0" cellpadding="3" cellspacing="0">
      <tr>
        <td height="50" colspan="2" class="tableindex"><div align="center">ACTUALIZACION DE RUT
          <input name="sw" type="hidden" id="sw" value="1" />
          <input name="r" type="hidden" id="r" value="<?=$ract?>" />
	      <input name="ract" type="hidden" id="ract" value="<?=$ract?>" />
          <input name="dact" type="hidden" id="dact" value="<?=$dact?>" />
        </div>
          </td>
        </tr>
      <tr>
        <td width="35%"><span class="Estilo4">RUT ACTUAL </span></td>
        <td><strong><?=$ract ?> - <?=$dact ?></strong></td>
      </tr>
      <tr>
        <td><span class="Estilo4">NUEVO RUT </span></td>
        <td><table width="70" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><label>
              <input name="r2" type="text" id="r2" size="8" maxlength="9" />
            </label></td>
            <td>-</td>
            <td><label>
              <input name="dig" type="text" id="dig" size="1" maxlength="1" />
            </label></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><div align="center">
          <label>
          <input type="submit" name="Submit" value="ACTUALIZAR" class="BotonXX" onClick="return valida(this.form);"/>
          </label>
          <label>
          <input type="button" name="Submit2" value="CERRAR" class="BotonXX" onClick="MM_callJS('window.close()')" />
          </label>
        </div></td>
        </tr>
    </table></td>
  </tr>
</table>
</form>
<? }?>

<? pg_close($conn); ?>
</body>
</html>
