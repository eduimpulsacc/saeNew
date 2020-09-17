<? 
$posp           =$_POSP;
$perfil_user    =$_PERFIL;
$ano            =$_ANO;


/*
  if ($ano == NULL){
     $qry="SELECT * FROM ano_escolar WHERE id_institucion = '$institucion' AND situacion = 1";
     $result = @pg_Exec($conn,$qry);
     $filaaux = @pg_fetch_array($result,0);	
     $_ANO=$filaaux["id_ano"];
     $ano = $_ANO;
  }  
*/

?>

<? 
$location = dirname($_SERVER['PHP_SELF']); 
$arr = split('/', $location); 
$num = count($arr); 


$num = $num - 0; ?>


<? /////////////////////////////////////////////////////////////////////////////
		/// seccion ideas geniales///david y cristian
		// Este codigo permite al menu de la cabecera poder encontrar las imagenes en forma automatica
		
		$w = 0;
		$posp = $posp -2;
		$c = "desarrollo/";
		$e = "";
		$d = "";
		$ca = "";
		
		while ($w < $num){ // while de imagenes
		$e = $d;
		$d = $c;
		$c = $c."../";
		$ca = $c."../";
		$w++; 
		}




////////////////////////////////////////////////////////////////////////////////////////////////

?>


<style type="text/css">
<!--
.Estilo9 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.Estilo11 {font-family: Arial, Helvetica, sans-serif}
-->
</style>
<SCRIPT type=text/javascript>

/***********************************************
* Switch Menu script- by Martial B of http://getElementById.com/
* Modified by Dynamic Drive for format & NS4/IE4 compatibility
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

if (document.getElementById){ //DynamicDrive.com change
document.write('<style type="text/css">\n')
document.write('.submenu{display: none;}\n')
document.write('.submenu2{display: none;}\n')
document.write('.submenu3{display: block;}\n')
document.write('</style>\n')
}

function SwitchMenu(obj){
    if(document.getElementById){
	var el = document.getElementById(obj);
	var ar = document.getElementById("masterdiv").getElementsByTagName("span"); //DynamicDrive.com change
		if(el.style.display != "block"){ //DynamicDrive.com change
			for (var i=0; i<ar.length; i++){
				if (ar[i].className=="submenu") //DynamicDrive.com change
				ar[i].style.display = "none";
			}
			el.style.display = "block";
		}else{
			el.style.display = "none";
		}
	}
}

/*
function SwitchMenu(obj){
    if(document.getElementById){
	var el = document.getElementById(obj);
	var ar = document.getElementById("masterdiv2").getElementsByTagName("span"); //DynamicDrive.com change
		if(el.style.display != "block"){ //DynamicDrive.com change
			for (var i=0; i<ar.length; i++){
				if (ar[i].className=="submenu2") //DynamicDrive.com change
				ar[i].style.display = "none";
			}
			el.style.display = "block";
		}else{
			el.style.display = "none";
		}
	}
}*/

function SwitchMenu3(obj){
    
	if(document.getElementById){
	var el = document.getElementById(obj);
	var ar = document.getElementById("masterdiv3").getElementsByTagName("span"); //DynamicDrive.com change
		if(el.style.display != "block"){ //DynamicDrive.com change
			for (var i=0; i<ar.length; i++){
				if (ar[i].className=="submenu3") //DynamicDrive.com change
				ar[i].style.display = "none";
			}
			el.style.display = "block";
		}else{
			el.style.display = "none";
		}
	}
}

</SCRIPT>

 <table width="190" border="0" align="left">
  <tr>
    <td width="100%">
	  
      <div align="left">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="top"><div align="left">
                <!-----------------------------------------------------------perfil administrador coe---------------------------->
                <?
	 if ($perfil_user == 0) 
	 {
	 
	 ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <!-- primer boton datos institucionales -->
                    <td align="left" valign="top" class="cajamenu"><div align="left">
						<?php if($_PERFIL==0) {?>
							<a href="<? echo $c ?>admin/institucion/listarInstituciones.php3?modo=ini&pag=1" target="_self">Datos Instituci&oacute;n</a></div>
						<? }?>
					</td>
                  </tr>
                  <? if ($institucion == ""){ // define botonera con link o sin link dependiendo si hay institucion

	 // si no existe institucion el boton no aparecera en la botonera
	                          }else{ ?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/listarAno.php3" target="_self">A&ntilde;os 
                      Acad&eacute;micos</a></div></td>
                  </tr>
                  <? 	}  ?>
                  <? if ($institucion == ""){ // define botonera con link o sin link dependiendo si hay institucion

	 // si no existe institucion el boton no aparecera en la botonera
	       }else{ 
                 
				if ($_ANO != 0){
				    
				    ?>
				    <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left">
					<div id="masterdiv">					
					      <div class="Estilo9" onclick="SwitchMenu('sub0')">
                                  <table cellspacing="0" cellpadding="0" 
                     width="100%" border="0">
                                    <tbody>
                                      <tr>
                                        
                                        <td  bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Libro de Clase</a></td>
                                      </tr>
                                    </tbody>
                                  </table>
                      </div>
                              <span class="submenu" id="sub0">  
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/periodo/listarPeriodo.php3" >&nbsp;&nbsp;Per&iacute;odo</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/feriado/listaFeriado.php3" >&nbsp;&nbsp;Feriados</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/planEstudio/listarPlanesEstudio.php3" >&nbsp;&nbsp;Planes de estudio</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/listarTiposEnsenanza.php3" >&nbsp;&nbsp;Tipos de ense&ntilde;anza</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/curso/listarCursos.php3" >&nbsp;&nbsp;Cursos 1</a></td>
                                    </tr>					
									
									
									
									
									<div id="masterdiv3">	
                                    <div class="Estilo9" onclick="SwitchMenu('sub2')">
									
									  <tr onclick="SwitchMenu('sub2')">
                                      <td width="90%" class="cajamenu2"><a href="#">&nbsp;&nbsp;Cursos 2</a>
									  
			<!--  <a href="<? echo $c; ?>admin/institucion/ano/curso/listarCursos.php3" >&nbsp;&nbsp;Cursos</a> -->
									  </td>
                                       </tr>
									   
									</div>
									 <!-- AQUI NUEVO CODIGO DEL SUB-MENU DEL CURSO -->
									
									   <tr><td>
									      <span class="submenu3" id="sub2"> 
										      
										       <table width="90%" align="right" border="0">
											     <tbody>
											      <tr>
												     <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/listarAlumnos.php3?_url=0">Alumnos</a> </td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/listarRamos.php3?plan=<?php echo $fila["cod_decreto"] ?>&ext=<?php echo $ext1 ?>">Subsectores </a> </td>
												  </tr>
												  <tr> 	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/listarTalleres.php3">Taller </a> </td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/horario/listarHorario.php">Horario </a></td>
												   </tr>
												   <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/promocion/promocion_pro.php">Promoción </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/seteaAsistencia.php3?caso=2">Asistencia </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/inasistencia/inasistencia.php">Inasistencia Asignatura </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/insitucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=1">Ficha Médica </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=2">Ficha Deportiva </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/frecuencias/main_informe_rendimiento.php?cursos=<?php echo $fila['id_curso']?>">Resultados del Curso </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/Listado_Claves.php?curso=<?php echo $fila['id_curso']?>">Claves </a></td>
												  </tr>
												  
												 </tbody>
											 </table>	 
											   
											   </span>			 
									 </div>
									
									
									
									
									
									
									
									
									
									
									<tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/matricula/listarMatricula.php3" >&nbsp;&nbsp;Matricula</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/informe_planillas/plantilla/listaPlantillas.php" >&nbsp;&nbsp;Informe de Personalidad</a></td>
                                    </tr>
									<tr>
									<td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    
									<tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/informe_planillas2/listar_informe.php" >&nbsp;&nbsp;Info.de Personalidad 2</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>">&nbsp;&nbsp;Reportes</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/ActasMatricula/Menu_Actas.php" >&nbsp;&nbsp;Actas</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    
                                  </tbody>
                              </table>
                        </span>
					
					  </div></td>
                     </tr>
				    </div>
				    <?
			     }
				 ?>		
				
				
				
				
				
				
				
				<div id="masterdiv2">
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left">
					
					
					
					    <div onclick="SwitchMenu('sub1')">
                                  <table  cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Info. Colegio</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
                              <span class="submenu2" id="sub1">
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/nuestraInstitucion.php3" >&nbsp;&nbsp;Nuestra instituci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/reglamentoInterno.php3" >&nbsp;&nbsp;Reglamento interno</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/cartaDireccion.php3" >&nbsp;&nbsp;Carta direcci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/procesoAdmision.php3" >&nbsp;&nbsp;Proceso admisi&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/proyectoEducativo.php3" >&nbsp;&nbsp;Proyecto educativo</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/uniforme.php" >&nbsp;&nbsp;Uniforme</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/sede/listarSede.php" >&nbsp;&nbsp;Sede</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/mapa.php" >&nbsp;&nbsp;Mapa ubicaci&oacute;n </a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/insignia.php" >&nbsp;&nbsp;Insignia</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/biblioteca/listarLibros.php?botonera=1" >&nbsp;&nbsp;Biblioteca</a></td>
                                    </tr>
                                  </tbody>
                              </table>
                        </span>
					             
					
					
					</div>
					</td>
				 </tr>	
					
					

					
					
				 <!-- aqui fin de las nuevas opciones -->
				  
				  
				  <!-- MENU PARA LA INFORMACIÓN DE LA INSTITUCION -->
				
				  
				  
				  <!-- FIN MENU DE LA INSTITUCION -->			  
				  <tr>
                    <!-- primer boton  -->
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>agenda/lista_agenda.php?sw=1" target="_self">Agenda</a></div></td>
                  </tr>
				  
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/empleado/listarEmpleado.php3" target="_self">Personal</a></div></td>
                  </tr>
                  <? 	}  ?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/soporte/main_soporte.php3" target="_self">Soporte</a></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="http://200.2.201.33/" target="_self">Salir</a></div></td>
                  </tr>
                </table>
                <?  } ?>
                <!----------------------------------------------------------------------------------------perfil alumno     -------------->
                <?  if ($perfil_user == 16) // perfil alumno
	               { ?>
                <!------------------------------------------------------------------------procesoalumno-------------------------------->
                <?	//menu left de alumno
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$frmModosds		="mostrar";
	
	//----------------------------------------------------------------------------
	// A&Ntilde;O ESCOLAR
	//----------------------------------------------------------------------------	
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano = @pg_Exec($conn, $sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);
	$nro_ano = 	$fila_ano['nro_ano'];
	
	if($institucion==11106){
		$sql="SELECT * FROM MATRICULA WHERE RDB=".$institucion." AND RUT_ALUMNO='".$alumno."' ORDER BY ID_ANO DESC";
		$Rs_Alum = @pg_exec($conn,$sql);
		for($i=0;$i<@pg_numrows($Rs_Alum);$i++){
			$fils = @pg_fetch_array($Rs_Alum,$i);
			$sql="";
			$sql="SELECT notas$nro_ano.* FROM curso INNER JOIN ramo ON curso.id_curso=ramo.id_curso INNER JOIN notas$nro_ano ON ramo.id_ramo=notas$nro_ano.id_ramo WHERE curso.id_curso=" . $fils['id_curso'] . " AND rut_alumno=" . $alumno;
			$Rs_Curso =@pg_exec($conn,$sql);
			if(@pg_numrows($Rs_Curso)!=0){
				$_ANO=$fils["id_ano"];
				session_register('_ANO');

				$_CURSO=$fils["id_curso"];
				session_register('_CURSO');			
			}
		}
	}
		   
				   
	?>
                <!------------------------------------------------------------------fin proceso alumno------------------------------->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>&nbsp;</tr>
                  <!-----------------------------------------------------------------------menu antiguo ------------------------------->
                  <?
		$qryM="select * from periodo where id_ano=".$ano." order by id_periodo";
		$resultM=@pg_Exec($conn,$qryM);
		$filaM=pg_fetch_array($resultM,0);
 
  		if ($filaM['mostrar_notas']==1)
		{
  ?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/fichaAlumno.php3">Ficha Acad&eacute;mica</a> </div></td>
                  </tr>
                  <?
        } //fin if mostrar notas ?>
                  <!--------------------------------------------------------------------fin-------------------------------------------->
                  <? if ($institucion!=24977 and $institucion!=25478){  ?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/fichaMedica.php3">Ficha Medica</a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/fichaDeportiva.php3">Ficha Deportiva </a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/fichaApoderados.php3">Ficha Apoderados </a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/horario/listarHorario.php">Horario Curso </a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/listarAlumnos.php3">Lista Curso </a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/FichaProfesores.php">Profesores</a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/fichaContenidos.php3">Material de Estudio </a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/comunicacion/ListaComunicacion.php">Comunicaciones</a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/alumno/contenidos.php">Contenidos Digitales </a> </div></td>
                  </tr>
				  <tr>
                    <!-- primer boton  -->
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>agenda/lista_agenda.php?sw=1" target="_self">Agenda</a></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/diario/ListadoNoticias.php">Diario Mural </a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/usuario/claveAcceso.php3">Cambio Clave </a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/Colegio_restore/Reportes/Rpt18/rpt18.php?tipo=<? echo trim($tipo)?>&amp;c_curso=<? echo trim($curso)?>&amp;c_alumno=<? echo $alumno?>">Informe Educacional</a> </div></td>
                  </tr>
				  <!-- mensajero -->
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>mensajeria/mira.php">Mensajeria </a> </div></td>
                  </tr>
				  <!-- fin mensajero -->
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="http://200.2.201.33/" target="_self">Salir</a> </div></td>
                  </tr>
                </table>
                <?  } // fin if institucion
				
	          }// fin user 16 ?>
                <!----------------------------------------------------------perfil apoderado----------------------------------------->
                <?  if ($perfil_user == 15) // perfil Apoderado
	               { ?>
                <!------------------------------------------------------------------------procesoapoderado-------------------------------->
                <?	
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$frmModosd		="mostrar";
	
	//----------------------------------------------------------------------------
	// A&Ntilde;O ESCOLAR
	//----------------------------------------------------------------------------	
	
		   
				   
	?>
                <!------------------------------------------------------------------fin proceso apoderado------------------------------->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>&nbsp;</tr>
                  <!-----------------------------------------------------------------------menu antiguo ------------------------------->
                  <?
		$qryM="select * from periodo where id_ano=".$ano." order by id_periodo";
		$resultM=@pg_Exec($conn,$qryM);
		$filaM=@pg_fetch_array($resultM,0);
 
  		if ($filaM['mostrar_notas']==1)
		{
  ?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/fichaAlumno.php3">Ficha Acad&eacute;mica</a> </div></td>
                  </tr>
                  <?
        } //fin if mostrar notas ?>
                  <!--------------------------------------------------------------------fin-------------------------------------------->
                  <? if ($institucion!=24977 and $institucion!=25478){  ?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/fichaMedica.php3">Ficha Medica</a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/fichaDeportiva.php3">Ficha Deportiva </a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/fichaApoderados.php3">Ficha Apoderados </a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/horario/listarHorario.php">Horario Curso </a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/listarAlumnos.php3">Lista Curso </a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/FichaProfesores.php">Profesores</a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/fichaContenidos.php3">Material de Estudio </a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/comunicacion/ListaComunicacion.php">Comunicaciones</a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/diario/ListadoNoticias.php">Diario Mural </a> </div></td>
                  </tr>
				   <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>mensajeria/mira.php">Mensajeria </a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/apoderado/usuario/claveAcceso.php3">Cambio Clave </a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/Colegio_restore/Reportes/Rpt18/rpt18.php?tipo=<? echo trim($tipo)?>&amp;c_curso=<? echo trim($curso)?>&amp;c_alumno=<? echo $alumno?>">Informe Educacional</a> </div></td>
                  </tr>
                  <?  } // fin if institucion ?>
                  
                  
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="http://200.2.201.33/" target="_self">Salir</a> </div></td>
                  </tr>
                </table>
                <? }// fin user 15 ?>
                <!-------------------------------------------------------------------------perfil administrador web --->
                <?
	 if ($perfil_user == 14) 
	 {
	 ?>
                <? //echo $_URLBASE; 
	//session_start();	

	if(!($_CHK_ID==session_id())){//CHEQUEA QUE EL NRO DE LA SESSION ASIGNADO AL LOGONEARSE CORRESPONDE AL ID ACTUAL DE LA SESSION

		echo "ERROR DE ACCESO, SESSION INVALIDA.";

		session_unset();

		session_destroy();

		exit;

	};
?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>&nbsp;</tr>
                  <?php if(($_PERFIL!=3)and ($_PERFIL!=5)){ ?>
                  <tr>
                    <!-- primer boton-->
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?><?php echo trim($_URLBASE)?>" target="_self">Datos Instituci&oacute;n</a></div></td>
                  </tr>
                  <?php }?>
                  <?php if($_PERFIL!=0){ ?>
                  <?php if(($_PERFIL!=3)and ($_PERFIL!=5)){    // define botonera con link o sin link dependiendo si hay institucion

	 // si no existe institucion el boton no aparecera en la botonera
	                          ?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/listarAno.php3" target="_self">A&ntilde;os 
                      Acad&eacute;micos</a></div></td>
                  </tr>
                  <? 	}  ?>
                  <?  if(($_PERFIL!=3)and ($_PERFIL!=5)){ // define botonera con link o sin link dependiendo si hay institucion

	 // si no existe institucion el boton no aparecera en la botonera
	 	       ?>
			   
			      <!-- AQUI BOTONES CON OPCIONES OCULTAS - BOTONES DINAMICOS -->
				  <? 
				  
				  if ($_ANO != 0){
				    
				    ?>
				    <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left">
					<div id="masterdiv">					
					      <div class="Estilo9" onclick="SwitchMenu('sub0')">
                                  <table cellspacing="0" cellpadding="0" 
                     width="100%" border="0">
                                    <tbody>
                                      <tr>
                                        
                                        <td  bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Libro de Clase</a></td>
                                      </tr>
                                    </tbody>
                                  </table>
                      </div>
                              <span class="submenu" id="sub0">  
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>									  
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/periodo/listarPeriodo.php3" >&nbsp;&nbsp;Per&iacute;odo</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/feriado/listaFeriado.php3" >&nbsp;&nbsp;Feriados</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/planEstudio/listarPlanesEstudio.php3" >&nbsp;&nbsp;Planes de estudio</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/listarTiposEnsenanza.php3" >&nbsp;&nbsp;Tipos de ense&ntilde;anza</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    
								<div id="masterdiv3">	
                                    <div class="Estilo9" onclick="SwitchMenu3('subc1')">
									
									  <tr onclick="SwitchMenu3('subc1')">
                                      <td width="90%" class="cajamenu2"><a href="#">&nbsp;&nbsp;Cursos</a>
									  
			<!--  <a href="<? echo $c; ?>admin/institucion/ano/curso/listarCursos.php3" >&nbsp;&nbsp;Cursos</a> -->
									  </td>
                                       </tr>
									   
									</div>
									 <!-- AQUI NUEVO CODIGO DEL SUB-MENU DEL CURSO -->
									   <tr><td>
									      <span class="submenu3" id="subc1"> 
										       <table width="90%" align="right" border="0">
											     <tbody>
											      <tr>
												     <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/listarAlumnos.php3?_url=0">Alumnos</a> </td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>ramo/listarRamos.php3?plan=<?php echo $fila["cod_decreto"] ?>&ext=<?php echo $ext1 ?>">Subsectores </a> </td>
												  </tr>
												  <tr> 	 
													 <td class="cajamenu2"><a href="<? echo $c ?>ramo/listarTalleres.php3">Taller </a> </td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>horario/listarHorario.php">Horario </a></td>
												   </tr>
												   <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>promocion/promocion_pro.php">Promoción </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>asistencia/seteaAsistencia.php3?caso=2">Asistencia </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>inasistencia/inasistencia.php">Inasistencia Asignatura </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>fichas/listarAlumnosMatriculados.php3?tipoFicha=1">Ficha Médica </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>fichas/listarAlumnosMatriculados.php3?tipoFicha=2">Ficha Deportiva </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>frecuencias/main_informe_rendimiento.php?cursos=<?php echo $fila['id_curso']?>">Resultados del Curso </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>Listado_Claves.php?curso=<?php echo $fila['id_curso']?>">Claves </a></td>
												  </tr>
												  
												 </tbody>
											 </table>	 
											   </span>			 
									 </div>
									 </td></td>
									 
									 
									 
									
									<tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/matricula/listarMatricula.php3" >&nbsp;&nbsp;Matricula</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/informe_planillas/plantilla/listaPlantillas.php" >&nbsp;&nbsp;Informe de Personalidad</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>">&nbsp;&nbsp;Reportes</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/ActasMatricula/Menu_Actas.php" >&nbsp;&nbsp;Actas</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    
                                  </tbody>
                              </table>
                        </span>
					
					  </div></td>
                     </tr>
				    </div>
				    <?
			     }
				 ?>		
				
				
				
				
				
				
				
				<div id="masterdiv2">
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left">
					
					
					
					    <div onclick="SwitchMenu('sub1')">
                                  <table  cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Info. Colegio</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
                              <span class="submenu2" id="sub1">
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/nuestraInstitucion.php3" >&nbsp;&nbsp;Nuestra instituci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/reglamentoInterno.php3" >&nbsp;&nbsp;Reglamento interno</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/cartaDireccion.php3" >&nbsp;&nbsp;Carta direcci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/procesoAdmision.php3" >&nbsp;&nbsp;Proceso admisi&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/proyectoEducativo.php3" >&nbsp;&nbsp;Proyecto educativo</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/uniforme.php" >&nbsp;&nbsp;Uniforme</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/sede/listarSede.php" >&nbsp;&nbsp;Sede</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/mapa.php" >&nbsp;&nbsp;Mapa ubicaci&oacute;n </a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/insignia.php" >&nbsp;&nbsp;Insignia</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/biblioteca/listarLibros.php?botonera=1" >&nbsp;&nbsp;Biblioteca</a></td>
                                    </tr>
                                  </tbody>
                              </table>
                        </span>
					             
					
					
					</div>
					</td>
				 </tr>	
					
					

					
					
				 <!-- aqui fin de las nuevas opciones -->
				  
				  
				  
				  
				  
				  
				  
				  <!-- FIN BOTONES DINAMICOS -->	
				  
				  
				  <tr>
                    <!-- primer boton  -->
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>agenda/lista_agenda.php?sw=1" target="_self">Agenda</a></div></td>
                  </tr>		   
			   
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/empleado/listarEmpleado.php3" target="_self">Personal</a></div></td>
                  </tr>
                  <? 	}  ?>
                  <!--  <?php if (($_INSTIT==10237)|| ($_INSTIT==25478)||($_INSTIT==24977)||($_PERFIL==0)){ ?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/Colegio_restore/main.php" target="_self">Colegiatura</a></div></td>
                  </tr>
                  <?php } ?>  -->
                  <?php }?>
                  <? if($_PERFIL==0){?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/soporte/main_soporte.php3" target="_self">soporte</a></div></td>
                  </tr>
                  <? }else{?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/soporte/seteaSoporte.php3?caso=2" target="_self">soporte</a></div></td>
                  </tr>
                  <? } ?>
				  <!--mensajero-->
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>mensajeria/mira.php">Mensajeria</a> </div></td>
                  </tr>
				  <!-- fin mensagero -->
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="http://200.2.201.33/" target="_self">Salir</a></div></td>
                  </tr>
                </table>
                <?  } ?>
                <!-------------------------------------------------------------------perfil docente------------------------------------------------------->  
                <?
	 if ($perfil_user == 17) // docente
	 {
	 
	 $frmModosd		=$_FRMMODO;
	 $ano			=$_ANO;
	 $menudinamico = $_MDINAMICO; //define los valores de la seccion para determinar que tipo de menu tiene que cargar (0 -1 -2)
	 
	 ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <? if ($menudinamico == 0){ //inicio 0?>
                             
                  <tr>
                    <td  align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>/session/perfilDocente.php3" target="_self">Seleccionar Curso</a></div></td>
                  </tr>
				  <tr>
                   <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>mensajeria/mira.php">Mensajeria </a> </div></td>
                  </tr>
				  
				  <tr>
                    <td  align="left" valign="top" class="cajamenu"><div align="left"><a href="http://200.2.201.33/" target="_self">Salir</a></div></td>
                  </tr>
                             
                  <? } //fin 0 ?>
                             
                             
                  <? if ($menudinamico == 1) { //inicio 1 ?>
				  <tr>
                    <!-- primer boton  -->
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>agenda/lista_agenda.php?sw=1" target="_self">Agenda</a></div></td>
                  </tr>
                             
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/listarAlumnos.php3" target="_self">Alumnos</a></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/listarRamos.php3" target="_self">Subsectores</a></div></td>
                  </tr>
				  
				   <!-- informacion del colegio en opciones ocultas -->
				  
				  
				  <div id="masterdiv2">
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left">				
					    <div onclick="SwitchMenu('sub1')">
                                  <table  cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Info. Colegio</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
                              <span class="submenu2" id="sub1">
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/nuestraInstitucion.php3" >&nbsp;&nbsp;Nuestra instituci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/reglamentoInterno.php3" >&nbsp;&nbsp;Reglamento interno</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/cartaDireccion.php3" >&nbsp;&nbsp;Carta direcci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/procesoAdmision.php3" >&nbsp;&nbsp;Proceso admisi&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/proyectoEducativo.php3" >&nbsp;&nbsp;Proyecto educativo</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/uniforme.php" >&nbsp;&nbsp;Uniforme</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    
                                    
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/mapa.php" >&nbsp;&nbsp;Mapa ubicaci&oacute;n </a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    
                                  </tbody>
                              </table>
                        </span>				
					</div>  				  
				  <!-- fin informacion colegio en opciones ocultas -->
				  
				  
				  
				  
				  
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/horario/listarHorario.php" target="_self">Horario</a></div></td>
                  </tr>
                  <?php  $sqlFer="select * from feriado where id_ano=".$ano;
		$resultFer=@pg_Exec($conn,$sqlFer);
		if((@pg_numrows($resultFer)!=0)and ($frmModosd=="mostrar")){	?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/asistencia.php3" target="_self">Asistencia</a></div></td>
                  </tr>
                  <? } ?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/soporte/seteaSoporte.php3?caso=2" target="_self">Soporte</a></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/docente/infoprofe.php?cram=1" target="_self">Informacion</a></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/diario/ListadoNoticias.php" target="_self">Diario Mural</a></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/empleado/usuario/claveAcceso.php3?cram=1">Cambio Clave</a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="http://200.2.201.33/" target="_self">Salir</a></div></td>
                  </tr>
                             
                  <? } //fin 1 ?>
                             
                  <? if($menudinamico == 2) { //inicio 2 ?>
                             
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/contenido/listarContenidos.php3">Material de Estudio</a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/docente/infoprofe.php?cram=2">Informacion</a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/empleado/usuario/claveAcceso.php3?cram=2">Cambio Clave</a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="http://200.2.201.33/" target="_self">Salir</a></div></td>
                  </tr>
                             
                  <? } //fin 2 ?>
				  
				  
                </table>
                <? }?>
				
	<!------------------------------------------------------------------------------perfil director academico	-->		
				
	<?			if (($perfil_user == 2) || ($perfil_user == 23) || ($perfil_user == 24) || ($perfil_user == 25) || ($perfil_user == 26)) 
	 {
	              $menudinamico = $_MDINAMICO;
	 ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>&nbsp;</tr>
				  <? if ($menudinamico == 0){ //inicio 0?>
                             
                  <tr>
                    <td  align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/listarAno.php3" target="_self">Seleccione año escolar</a></div></td>
                  </tr>
				  
				  <tr>
                    <td  align="left" valign="top" class="cajamenu"><div align="left"><a href="http://200.2.201.33/" target="_self">Salir</a></div></td>
                  </tr>
				  
				  
				 
				  
				  
				  
                             
                  <? } //fin 0 ?>
				  <? if ($menudinamico == 1){ //inicio 0?>
                  
				  <tr>
                    <!-- primer boton  -->
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>agenda/lista_agenda.php?sw=1" target="_self">Agenda</a></div></td>
                  </tr>
				  <tr>
                    <!-- primer boton  -->
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/listarCursos.php3" target="_self">Listado cursos</a></div></td>
                  </tr>
                  
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/matricula/listarMatricula.php3" target="_self">Listado Alumnos</a></div></td>
                  </tr>
                 
                  
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/reportes/Menu_Reportes.php" target="_self">Reportes</a></div></td>
                  </tr>
                                   
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="http://200.2.201.33/" target="_self">Salir</a></div></td>
                  </tr>
				  <? } //fin 1 ?>
                </table>
                <?  } ?>
				
				
		<!------------------------------------------------------------------------------perfil inspector	-->			
				<? if ($perfil_user == 19) // inspector
				{
	              $menudinamico = $_MDINAMICO;
	 ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>&nbsp;</tr>
				  <? if ($menudinamico == 0){ //inicio 0?>
                   <tr>
                    <!-- primer boton  -->
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/listarAno.php3" target="_self">A&ntilde;o Academico </a></div></td>
                  </tr>          
                  <tr>
                    <td  align="left" valign="top" class="cajamenu"><div align="left"><a href="http://200.2.201.33/" target="_self">Salir</a></div></td>
                  </tr>
                             
                  <? } //fin 0 ?>
				  <? if ($menudinamico == 1){ //inicio 0?>
                  <tr>
                    <!-- primer boton  -->
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/listarAno.php3" target="_self">A&ntilde;o Academico </a></div></td>
                  </tr>
				  <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>agenda/lista_agenda.php?sw=1" target="_self">Agenda</a></div></td>
                  </tr>
                  
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/listarCursos.php3" target="_self">Listado cursos</a></div></td>
                  </tr>
                 
                  
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/reportes/Menu_Reportes.php" target="_self">Reportes</a></div></td>
                  </tr>
                  
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/matricula/listarMatricula.php3" target="_self">Listado Alumnos</a></div></td>
                  </tr> 
				  
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/empleado/listarEmpleado.php3" target="_self">Personal</a></div></td>
                  </tr>                
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="http://200.2.201.33/" target="_self">Salir</a></div></td>
                  </tr>
				  <? } //fin 1 ?>
                </table>
                <?  } ?>
				
				
                <!-- PERFIL DIRECTOR GENERAL --> 
	          			
				<? if ($perfil_user == 1) // DIRECTOR GENERAL
				{
	             
	            ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
                    <!-- primer boton  -->
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>agenda/lista_agenda.php?sw=1" target="_self">Agenda</a></div></td>
                  </tr>
                  <tr>
                    <!-- primer boton  -->
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/seteaInstitucion.php3?caso=1" target="_self">Datos Institución </a></div></td>
                  </tr>
				  
				  <!-- informacion del colegio en opciones ocultas -->
				  
				  
				  <div id="masterdiv2">
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left">				
					    <div onclick="SwitchMenu('sub1')">
                                  <table  cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Info. Colegio</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
                              <span class="submenu2" id="sub1">
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/nuestraInstitucion.php3" >&nbsp;&nbsp;Nuestra instituci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/reglamentoInterno.php3" >&nbsp;&nbsp;Reglamento interno</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/cartaDireccion.php3" >&nbsp;&nbsp;Carta direcci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/procesoAdmision.php3" >&nbsp;&nbsp;Proceso admisi&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/proyectoEducativo.php3" >&nbsp;&nbsp;Proyecto educativo</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/uniforme.php" >&nbsp;&nbsp;Uniforme</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/sede/listarSede.php" >&nbsp;&nbsp;Sede</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/mapa.php" >&nbsp;&nbsp;Mapa ubicaci&oacute;n </a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/insignia.php" >&nbsp;&nbsp;Insignia</a></td>      </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img 
                        src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/biblioteca/listarLibros.php?botonera=1" >&nbsp;&nbsp;Biblioteca</a></td>
                                    </tr>
                                  </tbody>
                              </table>
                        </span>				
					</div>  				  
				  <!-- fin informacion colegio en opciones ocultas -->
				  
				  	  
                  
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/listarAno.php3" target="_self">Año Académico</a></div></td>
                  </tr>
                 
                  
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/empleado/listarEmpleado.php3" target="_self">Personal</a></div></td>
                  </tr>
                  
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/soporte/seteaSoporte.php3" target="_self">Soporte</a></div></td>
                  </tr> 
				  
				                 
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="http://200.2.201.33/" target="_self">Salir</a></div></td></tr>				  
                </table>
                <?  } ?>				
				
				
				
				
			
            </div></td>
          </tr>
        </table>
    </div></td>
  </tr>
</table>

