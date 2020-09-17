<?php require('../../../../util/header.inc');


$ract = base64_decode($ract);


?>

<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
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
	//if ($_ALUMNO!=""){
	$alumno			=$_ALUMNO;	
	
if ($sw == 1){
   // verificar si el rut ya existe en la tabla alumnos
  	$q1 = "select * from alumno where rut_alumno = '".trim($r2)."'";
   $r1 = @pg_Exec($conn,$q1);
   
   if (@pg_numrows($r1)!=0 ){

	  // actualizamos las tablas correspondientes
      $q2  = "update matricula set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  
	  $q12 = "update asistencia set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  
	  $q13 = "update anotacion set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  
	  $q3  = "update tiene2 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	 
	  $q4  = "update tiene2002 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q5  = "update tiene2003 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q6  = "update tiene2004 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q7  = "update tiene2005 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q8  = "update tiene2006 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q9  = "update tiene2007 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q10 = "update tiene2008 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	 $q10 = "update tiene2009 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q43 = "update tiene2010 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q44 = "update tiene2011 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  
	  $q14 = "update notas2002 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q15 = "update notas2003 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q16 = "update notas2004 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q17 = "update notas2005 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q18 = "update notas2006 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q19 = "update notas2007 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q20 = "update notas2008 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q40 = "update tiene2009 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q41 = "update notas2010 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
   	  $q42 = "update notas2011 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  
	  $q21 = "update promocion set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  
	  $q22 = "update situacion_final set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  
	  $q23 = "update evaluacion_detalle_nin set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  
	  $q24 = "update evaluacion_detalle_sup set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  
	  $q25 = "update evaluacion_nin set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  
	  $q30 = "update ficha_psicologica set rut_alum = '".trim($r2)."' where rut_alum = '".trim($r)."'";
	  
	  $q31 = "update hermanos set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  
	  $q32 = "update relacion_hermanos set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  
	  $q33 = "update tiene_taller set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  
	  $q34 = "update notas_taller set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  
	  $q35 = "update informe_observaciones set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  
	  $q36 = "update observacion_evaluacion set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  
      $q37 = "update alumno set rut_alumno = '".trim($r2)."', dig_rut = '".trim($dig)."' where rut_alumno = '".trim($r)."'";
	  
	  $q39 = "update promedio_sub_alumno set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."' ";
 	  
	  
	  
	  
	  $e= "situacion periodo  informe personalidad  notas examen";
	  
	  
	  
	  $r22  = pg_Exec($conn,$q2) or die (pg_last_error);
	  $r3   = pg_Exec($conn,$q3) or die (pg_last_error);
	  $r4   = pg_Exec($conn,$q4) or die (pg_last_error);
	  $r5   = pg_Exec($conn,$q5) or die (pg_last_error);
	  $r6   = pg_Exec($conn,$q6) or die (pg_last_error);
	  $r7   = pg_Exec($conn,$q7) or die (pg_last_error);
	  $r8   = pg_Exec($conn,$q8) or die (pg_last_error);
	  $r9   = pg_Exec($conn,$q9) or die (pg_last_error);
	  $r10  = pg_Exec($conn,$q10) or die (pg_last_error);
	  $r11  = pg_Exec($conn,$q11) or die (pg_last_error);
	  $r12  = pg_Exec($conn,$q12) or die (pg_last_error);
	  $r13  = pg_Exec($conn,$q13) or die (pg_last_error);
	  $r14  = pg_Exec($conn,$q14) or die (pg_last_error);
	  $r15  = pg_Exec($conn,$q15) or die (pg_last_error);
	  $r16  = pg_Exec($conn,$q16) or die (pg_last_error);
	  $r17  = pg_Exec($conn,$q17) or die (pg_last_error);
	  $r18  = pg_Exec($conn,$q18) or die (pg_last_error);
	  $r19  = pg_Exec($conn,$q19) or die (pg_last_error);
	  $r20  = pg_Exec($conn,$q20) or die (pg_last_error);
	  $r21  = pg_Exec($conn,$q21) or die (pg_last_error);
	  $r222  = pg_Exec($conn,$q22) or die (pg_last_error);
	  $r23  = pg_Exec($conn,$q23) or die (pg_last_error);
	  $r24  = pg_Exec($conn,$q24) or die (pg_last_error);
	  $r25  = pg_Exec($conn,$q25) or die (pg_last_error);
	  $r30  = pg_Exec($conn,$q30) or die (pg_last_error);
	  $r31  = pg_Exec($conn,$q31) or die (pg_last_error);
	  $r32  = pg_Exec($conn,$q32) or die (pg_last_error);
	  $r33  = pg_Exec($conn,$q33) or die (pg_last_error);
	  $r34  = pg_Exec($conn,$q34) or die (pg_last_error);
	  $r35  = pg_Exec($conn,$q35) or die (pg_last_error);
	  $r36  = pg_Exec($conn,$q36) or die (pg_last_error);
	  $r37  = pg_Exec($conn,$q37) or die (pg_last_error);
	  $r39  = pg_Exec($conn,$q39) or die (pg_last_error);
	  $r40  = pg_Exec($conn,$q40) or die (pg_last_error);
	  $r41  = pg_Exec($conn,$q41) or die (pg_last_error);
	  $r42  = pg_Exec($conn,$q42) or die (pg_last_error);
	  $r43  = pg_Exec($conn,$q43) or die (pg_last_error);
	  $r44  = pg_Exec($conn,$q44) or die (pg_last_error);
	  
	  
	  if (!$r22){
	     echo "Error en actualizacion 22";
	  }
	  
	  if (!$r3){
	     echo "Error en actualizacion 3";
	  }
	  if (!$r4){
	     echo "Error en actualizacion 4";
	  }
	  if (!$r5){
	     echo "Error en actualizacion 5";
	  }
	  if (!$r6){
	     echo "Error en actualizacion 6";
	  }
	  if (!$r7){
	     echo "Error en actualizacion 7";
	  }
	  if (!$r8){
	     echo "Error en actualizacion 8";
	  }
	  if (!$r9){
	     echo "Error en actualizacion 9";
	  }
	  if (!$r10){
	     echo "Error en actualizacion 10";
	  }
	  if (!$r11){
	     echo "Error en actualizacion 11";
	  }
	  if (!$r12){
	     echo "Error en actualizacion 12";
	  }
	  if (!$r13){
	     echo "Error en actualizacion 13";
	  }
	  if (!$r14){
	     echo "Error en actualizacion 14";
	  }
	  if (!$r15){
	     echo "Error en actualizacion 15";
	  }
	  if (!$r16){
	     echo "Error en actualizacion 16";
	  }
	  if (!$r17){
	     echo "Error en actualizacion 17";
	  }	 
	  if (!$r18){
	     echo "Error en actualizacion 18";
	  }
	  if (!$r19){
	     echo "Error en actualizacion 19";
	  }
	  if (!$r20){
	     echo "Error en actualizacion 20";
	  }
	  if (!$r21){
	     echo "Error en actualizacion 21";
	  }
	  if (!$r222){
	     echo "Error en actualizacion 222";
	  }
	  if (!$r23){
	     echo "Error en actualizacion 23";
	  }
	  if (!$r24){
	     echo "Error en actualizacion 24";
	  }
	  if (!$r25){
	     echo "Error en actualizacion 25";
	  }
	
	  if (!$r30){
	     echo "Error en actualizacion 30";
	  }
	  if (!$r31){
	     echo "Error en actualizacion 31";
	  }
	  if (!$r32){
	     echo "Error en actualizacion 32";
	  }
	  if (!$r33){
	     echo "Error en actualizacion 33";
	  }
	  if (!$r34){
	     echo "Error en actualizacion 34";
	  }
	  if (!$r35){
	     echo "Error en actualizacion 35";
	  }
	  if (!$r36){
	     echo "Error en actualizacion 36";
	  }
	  
	  if (!$r37){
	     echo "Error en actualizacion 37";
	  } 
	
	  if (!$r39){
	     echo "Error en actualizacion 39";
	  }	  
	  
	  $exito = 1;
	  
	  
   }else{
      // actualizamos las tablas correspondientes
      $q2  = "update matricula set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q3  = "update tiene2 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q4  = "update tiene2002 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q5  = "update tiene2003 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q6  = "update tiene2004 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q7  = "update tiene2005 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q8  = "update tiene2006 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q9  = "update tiene2007 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q10 = "update tiene2008 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q11 = "update tiene_taller set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q12 = "update asistencia set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q13 = "update anotacion set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q14 = "update notas2002 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q15 = "update notas2003 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q16 = "update notas2004 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q17 = "update notas2005 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q18 = "update notas2006 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q19 = "update notas2007 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q20 = "update notas2008 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q21 = "update promocion set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q22 = "update situacion_final set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q23 = "update evaluacion_detalle_nin set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q24 = "update evaluacion_detalle_sup set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q25 = "update evaluacion_nin set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  /*$q26 = "update ficha_deportiva set rut_alumno = '$r' where rut_alumno = '$ract'";
	  $q27 = "update ficha_deportivanew rut_alumno = '$r' where rut_alumno = '$ract'";
	  $q28 = "update ficha_medica set rut_alumno = '$r' where rut_alumno = '$ract'";
	  $q29 = "update ficha_medicanew set rut_alumno = '$r' where rut_alumno = '$ract'";
	  el cambio de rut no afectará a estas tablas por no poder actualizar a la tabla
	  alumnos_oldest */
	  
	  $q30 = "update ficha_psicologica set rut_alum = '".trim($r2)."' where rut_alum = '".trim($r)."'";
	  $q31 = "update hermanos set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q32 = "update relacion_hermanos set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q33 = "update tiene_taller set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q34 = "update notas_taller set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q35 = "update informe_observaciones set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q36 = "update observacion_evaluacion set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
      $q37 = "update alumno set rut_alumno = '".trim($r2)."', dig_rut = '".trim($dig)."' where rut_alumno = '".trim($r)."'";
	  $q38 = "update usuario set nombre_usuario = '".trim($r2)."' where nombre_usuario = '".trim($r)."'";
	  $q39 = "update promedio_sub_alumno set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."' ";
	  $q40 = "update tiene2009 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q41 = "update notas2009 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q42 = "update notas2010 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q42 = "update notas2011 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  $q43  = "update tiene2009 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
  	  $q44  = "update tiene20010 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
  	  $q45  = "update tiene20011 set rut_alumno = '".trim($r2)."' where rut_alumno = '".trim($r)."'";
	  
	  
	  $r22   = pg_Exec($conn,$q2);
	  $r3   = pg_Exec($conn,$q3);
	  $r4   = pg_Exec($conn,$q4);
	  $r5   = pg_Exec($conn,$q5);
	  $r6   = pg_Exec($conn,$q6);
	  $r7   = pg_Exec($conn,$q7);
	  $r8   = pg_Exec($conn,$q8);
	  $r9   = pg_Exec($conn,$q9);
	  $r10  = pg_Exec($conn,$q10);
	  $r11  = pg_Exec($conn,$q11);
	  $r12  = pg_Exec($conn,$q12);
	  $r13  = pg_Exec($conn,$q13);
	  $r14  = pg_Exec($conn,$q14);
	  $r15  = pg_Exec($conn,$q15);
	  $r16  = pg_Exec($conn,$q16);
	  $r17  = pg_Exec($conn,$q17);
	  $r18  = pg_Exec($conn,$q18);
	  $r19  = pg_Exec($conn,$q19);
	  $r20  = pg_Exec($conn,$q20);
	  $r21  = pg_Exec($conn,$q21);
	  $r222  = pg_Exec($conn,$q22);
	  $r23  = pg_Exec($conn,$q23);
	  $r24  = pg_Exec($conn,$q24);
	  $r25  = pg_Exec($conn,$q25);
	 /* $r26  = pg_Exec($conn,$q26);
	  $r27  = @pg_Exec($conn,$q27);
	  $r28  = pg_Exec($conn,$q28);
	  $r29  = @pg_Exec($conn,$q29);  */
	  $r30  = pg_Exec($conn,$q30);
	  $r31  = pg_Exec($conn,$q31);
	  $r32  = pg_Exec($conn,$q32);
	  $r33  = pg_Exec($conn,$q33);
	  $r34  = pg_Exec($conn,$q34);
	  $r35  = pg_Exec($conn,$q35);
	  $r36  = pg_Exec($conn,$q36);
	  $r37  = pg_Exec($conn,$q37);
	  $r38  = pg_Exec($conn,$q38);
	  $r39  = pg_Exec($conn,$q39);
	  $r40  = pg_Exec($conn,$q40);
	  $r41  = pg_Exec($conn,$q41);
	  $r42  = pg_Exec($conn,$q42);
	  $r43  = pg_Exec($conn,$q43);
	  $r44  = pg_Exec($conn,$q43);
	  $r45  = pg_Exec($conn,$q43);
	  
	  
	  if (!$r22){
	     echo "Error en actualizacion 22";
	  }
	  
	  if (!$r3){
	     echo "Error en actualizacion 3";
	  }
	  if (!$r4){
	     echo "Error en actualizacion 4";
	  }
	  if (!$r5){
	     echo "Error en actualizacion 5";
	  }
	  if (!$r6){
	     echo "Error en actualizacion 6";
	  }
	  if (!$r7){
	     echo "Error en actualizacion 7";
	  }
	  if (!$r8){
	     echo "Error en actualizacion 8";
	  }
	  if (!$r9){
	     echo "Error en actualizacion 9";
	  }
	  if (!$r10){
	     echo "Error en actualizacion 10";
	  }
	  if (!$r11){
	     echo "Error en actualizacion 11";
	  }
	  if (!$r12){
	     echo "Error en actualizacion 12";
	  }
	  if (!$r13){
	     echo "Error en actualizacion 13";
	  }
	  if (!$r14){
	     echo "Error en actualizacion 14";
	  }
	  if (!$r15){
	     echo "Error en actualizacion 15";
	  }
	  if (!$r16){
	     echo "Error en actualizacion 16";
	  }
	  if (!$r17){
	     echo "Error en actualizacion 17";
	  }	 
	  if (!$r18){
	     echo "Error en actualizacion 18";
	  }
	  if (!$r19){
	     echo "Error en actualizacion 19";
	  }
	  if (!$r20){
	     echo "Error en actualizacion 20";
	  }
	  if (!$r21){
	     echo "Error en actualizacion 21";
	  }
	  if (!$r222){
	     echo "Error en actualizacion 222";
	  }
	  if (!$r23){
	     echo "Error en actualizacion 23";
	  }
	  if (!$r24){
	     echo "Error en actualizacion 24";
	  }
	  if (!$r25){
	     echo "Error en actualizacion 25";
	  }
	  /*if (!$r26){
	     echo "Error en actualizacion 26";
	  }
	  if (!$r27){
	     echo "Error en actualizacion 27";
	  }
	  if (!$r28){
	     echo "Error en actualizacion 28";
	  }
	  if (!$r29){
	     echo "Error en actualizacion 29";
	  }*/
	  if (!$r30){
	     echo "Error en actualizacion 30";
	  }
	  if (!$r31){
	     echo "Error en actualizacion 31";
	  }
	  if (!$r32){
	     echo "Error en actualizacion 32";
	  }
	  if (!$r33){
	     echo "Error en actualizacion 33";
	  }
	  if (!$r34){
	     echo "Error en actualizacion 34";
	  }
	  if (!$r35){
	     echo "Error en actualizacion 35";
	  }
	  if (!$r36){
	     echo "Error en actualizacion 36";
	  }
	  
	  if (!$r37){
	     echo "Error en actualizacion 37";
	  }
	  
	  if (!$r38){
	     echo "Error en actualizacion 38";
	  }
	  
	  if (!$r39){
	     echo "Error en actualizacion 39";
	  }
	  
	  
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

<form name="form1" method="post" action="../curso/alumno/vmrut.php">


<table width="300" height="250" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
     <tr>
      <td valign="top" bgcolor="#FFFFFF">	
        <table width="100%" height="200" border="0" cellpadding="3" cellspacing="0">
      <tr>
        <td height="50" colspan="2" class="tableindex"><div align="center">ACTUALIZACION DE RUT
          <input name="sw" type="hidden" id="sw" value="1" />
          <input name="r" type="hidden" id="r" value="<?=$ract ?>" />
	
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
