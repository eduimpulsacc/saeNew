<? 
$posp           =$_POSP;
$perfil_user    =$_PERFIL;
$ano            =$_ANO;

if ($ano == NULL){
 $qry="SELECT id_institucion, id_ano, situacion from ano_escolar WHERE id_institucion = '$institucion' AND situacion = 1";
 $result = @pg_Exec($conn,$qry);
 $filaaux = @pg_fetch_array($result,0);	
 $_ANO=$filaaux["id_ano"];
 $ano = $_ANO;
}  

  $qry_info = "select info_colegio from institucion where rdb = '$institucion'";
  $res_info = @pg_Exec($conn,$qry_info);
  $fila_info = @pg_fetch_array($res_info,0);
  $_INFO = $fila_info['info_colegio']; 

$location = dirname($_SERVER['PHP_SELF']); 
$arr = split('/', $location); 
$num = count($arr); 


$num = $num - 0; ?>


<? /////////////////////////////////////////////////////////////////////////////
		// Este codigo permite al menu de la cabecera poder encontrar las imagenes en forma automatica
		
		$w = 0;
		$posp = $posp -2;
		$c = "sae3.0/";
		$e = "";
		$d = "";
		$ca = "";
		
		while ($w < $num){ // while de imagenes
		$e = $d;
		$d = $c;
		$c = "../".$c;
		$ca = $c."../";
		$w++; 
		}




////////////////////////////////////////////////////////////////////////////////////////////////

?>


<style type="text/css">
<!--
.Estilo99 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
<? if ($menu_lateral=="1"){?>.submenu1{display:block;} <? }else{?>.submenu1{display:none;}<? } ?>
<? if ($menu_lateral=="2"){?>.submenu2{display:block;} <? }else{?>.submenu2{display:none;}<? } ?>
<? if (substr($menu_lateral, 0, 1)=="3"){?>.submenu3{display:block;} <? }else{?>.submenu3{display:none;}<? } ?>
<? if (substr($menu_lateral, 0, 3)=="3_1"){?>.submenu3_1{display:block;} <? }else{?>.submenu3_1{display:none;}<? } ?>
<? if ($menu_lateral=="4"){?>.submenu4{display:block;} <? }else{?>.submenu4{display:none;}<? } ?>
<? if ($menu_lateral=="5"){?>.submenu5{display:block;} <? }else{?>.submenu5{display:none;}<? } ?>
<? if ($menu_lateral=="6"){?>.submenu6{display:block;} <? }else{?>.submenu6{display:none;}<? } ?>
-->
</style>
<SCRIPT type=text/javascript>

/***********************************************
* Switch Menu script- by Martial B of http://getElementById.com/
* Modified by Dynamic Drive for format & NS4/IE4 compatibility
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/


function SwitchMenu(obj){
    if(document.getElementById){
	var el = document.getElementById(obj);
	var ar = document.getElementById("masterADMIN").getElementsByTagName("span"); //DynamicDrive.com change
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

</SCRIPT>
<?  if (($perfil_user != 20)&&($perfil_user != 21)&&($perfil_user != 25)){?>
 <table width="190" border="0" align="left">
  <tr>
    <td width="100%">
	  
 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="top">
			
			<?
			if ($perfil_user==6){ ?>
			      <table width="100%" border="0" cellspacing="0" cellpadding="0">
			        <tr>	 
					 <td class="cajamenu"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=1">Ficha M�dica </a></td>
				    </tr>
				     <tr>
				       <td valign="top" class="cajamenu"><a href="<? echo $c ?>menu/salida.php">Salir</a></td>
				     </tr>
  		      </table>
		   <? } ?>	
			
			
			
			

<!--////////////////////////// ADMINISTRADOR SAE //////////////////////////-->
	
	<? if (($perfil_user == 0)or($perfil_user == 14))
	 {?>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<?php if(($_PERFIL==0) and ($perfil_user!="99999")) {?>
				  <tr>
						<td valign="top" class="cajamenu"><a href="<? echo $c ?>admin/institucion/listarInstituciones.php3?modo=ini&pag=1" target="_self">Seleccione Instituci�n</a></td>
				  </tr>
				   <tr>
						<td valign="top" class="cajamenu"><a href="<? echo $c ?>estadisticas/estadisticas_new.php" target="_self">Estad�sticas de Conecci�n</a></td>
				  </tr>
					<tr>
                    	<td valign="top" class="cajamenu"><a href="<? echo $c ?>estadisticas/estadisticas.php" target="_self">Reportes Estad�sticos</a></td>
                    </tr>
		  		<? }?>
				  
				  
				  
				  
				  
                  <? if ($institucion != ""){ ?>


<!-- ******************** Men� Administraci�n ***************-->

				<div id="masterADMIN">
				  <tr>
                    <td align="left" valign="top" class="cajamenu">
					
					
					
					    <div onclick="SwitchMenu('sub_admin')">
                                  <table  cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Administraci�n</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
						  <span class="submenu1" id="sub_admin">
							<table cellspacing="0" cellpadding="0" width="100%" border="0">
							  <tbody>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c ?>admin/institucion/institucion.php3" target="_self">&nbsp;&nbsp;&nbsp;&nbsp;Datos Instituci&oacute;n</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/listarAno.php3">&nbsp;&nbsp;&nbsp;&nbsp;A&ntilde;os Acad&eacute;micos</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/Menu_Respaldo.php" target="_self">&nbsp;&nbsp;&nbsp;&nbsp;Respaldos</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
					<?	if($_PERFIL==0){	?>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/ArchivosRech/ArchRech2.php" >&nbsp;&nbsp;&nbsp;&nbsp;Subir Archivos RECH</a></td>
								</tr>
                                <tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/registro.php" >&nbsp;&nbsp;&nbsp;&nbsp;Log de Acceso</a></td>
								</tr>
                                
					<? } ?>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/Claves.php" >&nbsp;&nbsp;&nbsp;&nbsp;Claves del Sistema</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
							  </tbody>
						  </table>
                        </span>
					</td>
				 </tr>	
				<!--/div-->
					
<!-- ******************** Men� Configuraci�n ***************-->

				<!--div id="masterCONF"-->
				  <tr>
                    <td align="left" valign="top" class="cajamenu">

					    <div onclick="SwitchMenu('sub_conf')">
                                  <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Configuraci�n</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
						  <span class="submenu2" id="sub_conf">
							<table cellspacing="0" cellpadding="0" width="100%" border="0">
							  <tbody>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/periodo/listarPeriodo.php3" >&nbsp;&nbsp;&nbsp;&nbsp;Per&iacute;odo</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<?
								if ($_INSTIT==8933 AND $_PERFIL==0){ ?>
									<tr>
									  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/periodo/config_ing_notas.php" >&nbsp;&nbsp;&nbsp;&nbsp;Per&iacute;odo de notas</a></td>
									</tr>
									<tr>
									  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
									</tr>
							  <? } ?>		
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/feriado/listaFeriado.php3" >&nbsp;&nbsp;&nbsp;&nbsp;Feriados</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/planEstudio/listarPlanesEstudio.php3" >&nbsp;&nbsp;&nbsp;&nbsp;Planes de estudio</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/listarTiposEnsenanza.php3" >&nbsp;&nbsp;&nbsp;&nbsp;Tipos de ense&ntilde;anza</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
                                <tr>
                                   <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/curso/listarCursos.php3" >&nbsp;&nbsp;&nbsp;&nbsp;Cursos </a></td>
                                </tr>					
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/informe_planillas/plantilla/listaPlantillas.php" >&nbsp;&nbsp;&nbsp;&nbsp;Informe Personalidad</a></td>
								</tr>
								<tr>
								<td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>mensajeria/configuracion.php" >&nbsp;&nbsp;&nbsp;&nbsp;Mapa Mensajer�a</a></td>
								</tr>
								<tr>
								   <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>grupos/adm_grupos.php" >&nbsp;&nbsp;&nbsp;&nbsp;Grupos</a></td>
								</tr>
								<tr>
								   <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>																
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/curso/alumno/anotacion/configurar.php" >&nbsp;&nbsp;&nbsp;&nbsp;Anotaciones</a></td>
								</tr>
								<tr>
								   <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
							<? if($_PERFIL==0){?>								
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/corporacion/admin_corporaciones.php" >&nbsp;&nbsp;&nbsp;&nbsp;Corporaciones</a></td>
								</tr>
								<tr>
								   <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
							<?	}	?>				  
							  </tbody>
						  </table>
                        </span>
					</td>
				 </tr>	
				<!--/div-->


                  <? 	}  
				  
				  if ($institucion == ""){ 
				  	// define botonera con link o sin link dependiendo si hay institucion
					// si no existe institucion el boton no aparecera en la botonera
			      }else{ 
                 
					if ($_ANO != 0){?>
				    <tr>
                    <td align="left" valign="top" class="cajamenu">
					      <div class="Estilo99" onclick="SwitchMenu('sub0')">
                                  <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tbody>
                                      <tr>
                                        <td  bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Libro de Clase</a></td>
                                      </tr>
                                    </tbody>
                                  </table>
	                      </div>
                              <span class="submenu3" id="sub0">  
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									
									
									
									
									<!--div id="masterdiv3"-->
                                  <div class="Estilo99" onclick="SwitchMenu('sub2')">
									
									  <tr onclick="SwitchMenu('sub2')">
                                      <td width="90%" class="cajamenu2"><a href="#">&nbsp;&nbsp;&nbsp;Cursos</a></td>
                                      </tr>
									   
								  </div>
									 <!-- AQUI NUEVO CODIGO DEL SUB-MENU DEL CURSO -->
									
									   <tr><td>
									      <span class="submenu3_1" id="sub2"> 
										      
										       <table width="90%" align="right" border="0">
											     <tbody>
											      <tr>
												     <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/buscaralumno.php"><li>B�squeda Alumno</li></a> </td>
												  </tr>
											      <tr>
												     <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/listarAlumnos.php3?_url=0"><li>Alumnos</li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/listarRamos.php3?plan=<?php echo $fila["cod_decreto"] ?>&ext=<?php echo $ext1 ?>"><li>Subsectores</li> </a> </td>
												  </tr>
												  <tr> 	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/listarTalleres.php3"><li>Talleres </a> </td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/horario/listarHorario.php"><li>Horario</li> </a></td>
												   </tr>
												   <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/promocion/promocion_pro.php"><li>Promoci�n</li> </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/seteaAsistencia.php3?caso=2"><li>Asistencia Mensual</li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/inasistencia/inasistencia.php"><li>Asistencia Horaria</li> </a></td>
												  </tr>	
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/inasistencia/inasistencia_docente.php"><li>Asist. H. Docente</li> </a></td>
												  </tr>	
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/seteaAsistencia.php3?caso=13"><li>Asist. Apoderado</li></a></td>
												  </tr>												  
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/justifica_inasistencia.php"><li>Justifica Inasist.</li></a></td>
												  </tr>													  											 
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/atrasos/atrasos.php"><li>Atrasos</li> </a></td>
												  </tr>																							  
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=1"><li>Ficha M�dica </li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=2"><li>Ficha Deportiva </li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/informe_educacional/listarAlumnos.php"><li>Inf. Personalidad</li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/frecuencias/main_informe_rendimiento.php?cursos=<?php echo $fila['id_curso']?>"><li>Resultados Curso</li> </a></td>
												  </tr>
												 
												  
												 </tbody>
											 </table>	 
											   
									     </span>			 
									 <!--/div-->
									
							
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/matricula/listarMatricula.php3" >&nbsp;&nbsp;&nbsp;Matr�cula</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>">&nbsp;&nbsp;&nbsp;Reportes</a></td>
                                    </tr>
									<? if($_INSTIT==2999 OR $_INSTIT==2995){?>
									 <tr>
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/reportes/MenuRECH.php?ai_institucion=<?php echo $_INSTIT ;?>">&nbsp;&nbsp;&nbsp;Reportes Estadisticos </a></td>
                                    </tr>
									<? } ?>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/ActasMatricula/Menu_Actas.php" >&nbsp;&nbsp;&nbsp;Actas</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    
                                  </tbody>
                              </table>
                        </span>
					</td></tr>
			  </div>
				    <!--/div-->
				    <?
			     }
				 ?>		
				
				
			    </div>

				
				
				
				
				<!--div id="masterdiv2"-->
				  <tr>
                    <td align="left" valign="top" class="cajamenu">
					
					<? 	if($_INFO==1){ 	?>
					
					    <div onclick="SwitchMenu('sub1')">
                                  <table  cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Info. Colegio</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
					<? } ?>
                              <span class="submenu4" id="sub1">
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/nuestraInstitucion.php3" >&nbsp;&nbsp;Nuestra instituci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/reglamentoInterno.php3" >&nbsp;&nbsp;Reglamento interno</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/cartaDireccion.php3" >&nbsp;&nbsp;Carta direcci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/procesoAdmision.php3" >&nbsp;&nbsp;Proceso admisi&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/proyectoEducativo.php3" >&nbsp;&nbsp;Proyecto educativo</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/uniforme.php" >&nbsp;&nbsp;Uniforme</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/sede/listarSede.php" >&nbsp;&nbsp;Sede</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/mapa.php" >&nbsp;&nbsp;Mapa ubicaci&oacute;n </a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/insignia.php" >&nbsp;&nbsp;Insignia</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <!--tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/biblioteca/listarLibros.php?botonera=1" >&nbsp;&nbsp;Biblioteca</a></td>
                                    </tr-->
                                  </tbody>
                              </table>
                        </span>
					             
					
					
					</td>
				 </tr>	


<!-- ******************** Men� Comunicaciones ***************-->

				<!--div id="masterCONF"-->
				  <tr>
                    <td align="left" valign="top" class="cajamenu">

					    <div onclick="SwitchMenu('sub_comunica')">
                                  <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Comunicaciones</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
						  <span class="submenu5" id="sub_comunica">
							<table cellspacing="0" cellpadding="0" width="100%" border="0">
							  <tbody>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>mensajeria/mira.php" >&nbsp;&nbsp;Mensajer�a</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>agenda/lista_agenda.php?sw=1" >&nbsp;&nbsp;Agenda</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>fichas/diario/ListadoNoticias.php" >&nbsp;&nbsp;Diario Mural</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<? if($perfil==0){ ?>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>fichas/sugerencias/sugrec.php" >&nbsp;&nbsp;Sugerencias o Reclamos</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<? } ?>								
							  </tbody>
						  </table>
                        </span>
					</td>
				 </tr>	
				<!--/div-->

					

					
					
				 <!-- aqui fin de las nuevas opciones -->
				  
				  
				  <!-- MENU PARA LA INFORMACI�N DE LA INSTITUCION -->
				
				  
				  
				  <!-- FIN MENU DE LA INSTITUCION -->			  
				  <!--tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>agenda/lista_agenda.php?sw=1" target="_self">Agenda</a></div></td>
                  </tr-->
				  
<!-- vel ****--><tr>
                    <td align="left" valign="top" class="cajamenu">

					    <div onclick="SwitchMenu('sub_personal')">
							  <table cellspacing="0" cellpadding="0" width="100%" border="0">
								<tr>
									<td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Personal</a></td>
								</tr>                                    
							  </table>
                        </div>
						<span class="submenu6" id="sub_personal">
							<table cellspacing="0" cellpadding="0" width="100%" border="0">
							 	<tbody>										  
							  		<tr>
										<td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/empleado/listarEmpleado.php3" target="_self">&nbsp;&nbsp;&nbsp;Listar Personal</a></div></td>
									</tr>
									<tr>
                                      	<td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
							  		<tr>
										<td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/anotacion_empleado/asistencia.php" target="_self">&nbsp;&nbsp;&nbsp;Asistencia del Personal</a></div></td>
									</tr>
									<tr>
                                      	<td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
							  		<tr>
										<td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/anotacion_empleado/atrasos.php" target="_self">&nbsp;&nbsp;&nbsp;Atrasos del Personal</a></div></td>
									</tr>
									<tr>
                                      	<td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>																		
								</tbody>
							</table>
						</span>
					</td>
				</tr>
                  <? 	}  ?>
                  <tr>
                    <!--td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/soporte/main_soporte.php3" target="_self">Soporte</a></div></td-->
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>solicitud2/index.php" target="_self">Soporte</a></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>menu/salida.php" target="_self">Salir</a></div></td>
                  </tr>
				  <? if($perfil==0 or $perfil==14 or $perfil==17){?>
				    <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="http://www.colegiointeractivo.com/encuesta/" target="_blank"><img src="http://intranet.colegiointeractivo.cl/sae3.0/menus/gift.gif" border="0"></img></a></div></td>
                  </tr>
				   <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="http://www.colegiointeractivo.cl/Archivos/manual_administrador.pdf" target="_blank"><img src="http://intranet.colegiointeractivo.cl/sae3.0/menus/manual.gif" border="0"></img></a></div></td>
                  </tr>
				  <? } ?>
              </table>
                <?  } ?>
				
	<!-- //////// FIN MENU ADMINISTRADOR WEB ////////////////// -->			
				
				
				
				
	<!--////////////////////////// INICIO MEN� ADMINISTRATIVO SAE //////////////////////////-->
	
	<? if ($perfil_user == 27)
	 {?>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
			    <div id="masterADMIN">
				 <?              
				  
				  if ($institucion == ""){ 
				  	// define botonera con link o sin link dependiendo si hay institucion
					// si no existe institucion el boton no aparecera en la botonera
			      }else{ 
                 
					if ($_ANO != 0){?>
				    <tr>
                    <td align="left" valign="top" class="cajamenu">
					      <div class="Estilo99" onclick="SwitchMenu('sub0')">
                                  <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tbody>
                                      <tr>
                                        <td  bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Libro de Clase</a></td>
                                      </tr>
                                    </tbody>
                                  </table>
	                      </div>
                              <span class="submenu3" id="sub0">  
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									
									
									
									
									<!--div id="masterdiv3"-->
                                  <div class="Estilo99" onclick="SwitchMenu('sub2')">
									
									  <tr onclick="SwitchMenu('sub2')">
                                      <td width="90%" class="cajamenu2"><a href="#">&nbsp;&nbsp;&nbsp;Cursos</a></td>
                                      </tr>
									   
								  </div>
									 <!-- AQUI NUEVO CODIGO DEL SUB-MENU DEL CURSO -->
									
									   <tr><td>
									      <span class="submenu3_1" id="sub2"> 
										      
										       <table width="90%" align="right" border="0">
											     <tbody>
											      <tr>
												     <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/buscaralumno.php"><li>B�squeda Alumno</li></a> </td>
												  </tr>
												   <? if ($_INSTIT!=9074){ ?>
											      <tr>
												     <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/listarAlumnos.php3?_url=0"><li>Alumnos</li></a></td>
												  </tr>
												  <? if ($institucion != 1685){ ?>
												
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/listarRamos.php3?plan=<?php echo $fila["cod_decreto"] ?>&ext=<?php echo $ext1 ?>"><li>Subsectores</li> </a> </td>
												  </tr>
												  <? } ?>
												
												  <? } ?>
												   <? if ($_INSTIT!=12086){?>
												   <!--
												  <tr> 	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/listarTalleres.php3"><li>Talleres </a> </td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/horario/listarHorario.php"><li>Horario</li> </a></td>
												   </tr>
												   <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/promocion/promocion_pro.php"><li>Promoci�n</li> </a></td>
												  </tr>
												  
												  -->
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/seteaAsistencia.php3?caso=2"><li>Asistencia Mensual</li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/inasistencia/inasistencia.php"><li>Asistencia Horaria</li> </a></td>
												  </tr>	
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/inasistencia/inasistencia_docente.php"><li>Asist. H. Docente</li> </a></td>
												  </tr>													  
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/justifica_inasistencia.php"><li>Justifica Inasist.</li></a></td>
												  </tr>	
												  
												   <? if ($_INSTIT!=9074){ ?>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/seteaAsistencia.php3?caso=13"><li>Asist. Apoderado</li></a></td>
												  </tr>		
												  <? } ?>										  											 
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/atrasos/atrasos.php"><li>Atrasos</li> </a></td>
												  </tr>		
												   <? if ($_INSTIT!=9074){ ?>																					  
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=1"><li>Ficha M�dica </li></a></td>
												  </tr>
												  <? } ?>
												  <!--												  
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=2"><li>Ficha Deportiva </li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/informe_educacional/listarAlumnos.php"><li>Inf. Personalidad</li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/frecuencias/main_informe_rendimiento.php?cursos=<?php echo $fila['id_curso']?>"><li>Resultados Curso</li> </a></td>
												  </tr>
												 -->
												   <? } ?>
												 </tbody>
											 </table>	 
											   
									     </span>			 
									 <!--/div-->
									
							
									<?
									if ($_INSTIT==1598){ ?>
									
								  <tr>
										  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								  </tr>
										<tr>
										  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/matricula/listarMatricula.php3" >&nbsp;&nbsp;&nbsp;Matr�cula</a></td>
										</tr>
										<tr>
										  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
										</tr>
									<? } ?>
									
									<? if ($_INSTIT!=12086){?>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/reportes/Menu_Reportes_Administrativo.php?ai_institucion=<?php echo $_INSTIT ;?>">&nbsp;&nbsp;&nbsp;Reportes</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									<? } ?>
									<!--									
                                    <tr>
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/ActasMatricula/Menu_Actas.php" >&nbsp;&nbsp;&nbsp;Actas</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    -->
                                  </tbody>
                              </table>
                        </span>
					</td></tr>
			  </div>
			 
				    <!--/div-->
				    <?
			     }
				 ?>		
				
				
			    </div>

				
				
				
				
				<!--div id="masterdiv2"-->
				 <? if ($_INSTIT!=9074){ ?>
				  <tr>
                    <td align="left" valign="top" class="cajamenu">
					
					<? 	if($_INFO==1){ 	?>
					
					    <div onclick="SwitchMenu('sub1')">
                                  <table  cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Info. Colegio</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
					<? } ?>
                              <span class="submenu4" id="sub1">
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/nuestraInstitucion.php3" >&nbsp;&nbsp;Nuestra instituci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/reglamentoInterno.php3" >&nbsp;&nbsp;Reglamento interno</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/cartaDireccion.php3" >&nbsp;&nbsp;Carta direcci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/procesoAdmision.php3" >&nbsp;&nbsp;Proceso admisi&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/proyectoEducativo.php3" >&nbsp;&nbsp;Proyecto educativo</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/uniforme.php" >&nbsp;&nbsp;Uniforme</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/sede/listarSede.php" >&nbsp;&nbsp;Sede</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/mapa.php" >&nbsp;&nbsp;Mapa ubicaci&oacute;n </a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/insignia.php" >&nbsp;&nbsp;Insignia</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <!--tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/biblioteca/listarLibros.php?botonera=1" >&nbsp;&nbsp;Biblioteca</a></td>
                                    </tr-->
                                  </tbody>
                              </table>
                        </span>
					             
					
					
					</td>
				 </tr>	


<!-- ******************** Men� Comunicaciones ***************-->

				<!--div id="masterCONF"-->
				  <tr>
                    <td align="left" valign="top" class="cajamenu">

					    <div onclick="SwitchMenu('sub_comunica')">
                                  <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Comunicaciones</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
						  <span class="submenu5" id="sub_comunica">
							<table cellspacing="0" cellpadding="0" width="100%" border="0">
							  <tbody>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>mensajeria/mira.php" >&nbsp;&nbsp;Mensajer�a</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>agenda/lista_agenda.php?sw=1" >&nbsp;&nbsp;Agenda</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>fichas/diario/ListadoNoticias.php" >&nbsp;&nbsp;Diario Mural</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
							  </tbody>
						  </table>
                        </span>
					</td>
				 </tr>	
				<!--/div-->				
					
				 <!-- aqui fin de las nuevas opciones -->
				  
				  
				  <!-- MENU PARA LA INFORMACI�N DE LA INSTITUCION -->			  
				  
				  <!-- FIN MENU DE LA INSTITUCION -->			  
				  <!--tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>agenda/lista_agenda.php?sw=1" target="_self">Agenda</a></div></td>
                  </tr-->
				  
<!-- vel ****--><tr>
                    <td align="left" valign="top" class="cajamenu">

					    <div onclick="SwitchMenu('sub_personal')">
							  <table cellspacing="0" cellpadding="0" width="100%" border="0">
								<tr>
									<td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Personal</a></td>
								</tr>                                    
							  </table>
                        </div>
						<span class="submenu6" id="sub_personal">
							<table cellspacing="0" cellpadding="0" width="100%" border="0">
							 	<tbody>										  
							  		<tr>
										<td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/empleado/listarEmpleado.php3" target="_self">&nbsp;&nbsp;&nbsp;Listar Personal</a></div></td>
									</tr>
									<tr>
                                      	<td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									<!--
									
							  		<tr>
										<td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/anotacion_empleado/asistencia.php" target="_self">&nbsp;&nbsp;&nbsp;Asistencia del Personal</a></div></td>
									</tr>
									<tr>
                                      	<td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
							  		<tr>
										<td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/anotacion_empleado/atrasos.php" target="_self">&nbsp;&nbsp;&nbsp;Atrasos del Personal</a></div></td>
									</tr>
									<tr>
                                      	<td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									
									-->																		
								</tbody>
							</table>
						</span>
					</td>
				</tr>
                  <? 	}  ?>
				  
				 <? } //TERMINA LA CONDICION PARA LA 9074?>
				 <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>solicitud2/index.php" target="_self">Soporte</a></div></td>
                 </tr>
				 
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>menu/salida.php" target="_self">Salir</a></div></td>
                  </tr>
              </table>
                <?  } ?>
				
		<!-- /////////// fin men� ADMINISTRATIVO WEB //////////////-->
				
				
				
				
				



<!--////////////////////////// ALUMNO //////////////////////////-->
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
			
/*			if($institucion==11106){
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
			}*/
				   
						   
		?>
                <!------------------------------------------------------------------fin proceso alumno------------------------------->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>&nbsp;</tr>
                  <!-----------------------------------------------------------------------menu antiguo ------------------------------->
         <?
		 // Aqui rescato nuevamente el a�o en que esta abierto
		$qry2_ano     = "select * from ano_escolar where id_ano = '".trim($ano)."'";
		$r2_ano       = @pg_Exec($conn,$qry2_ano);
		$f2_ano       = @pg_fetch_array($r2_ano,0);
		$ano_avierto  = $f2_ano['nro_ano'];			 
		 
		 
		$hoy_date=date("Y-m-d");		
		$partedefecha = substr($hoy_date,4,6);
		$hoy_date = "$ano_avierto"."$partedefecha";
		
		$qryM="select * from periodo where id_ano=".$ano." and fecha_inicio<='".$hoy_date."' order by id_periodo Desc "; 
		$resultM=pg_Exec($conn,$qryM);
		$filaM=@pg_fetch_array($resultM,0);		
		
 
  		if (($filaM['mostrar_notas']==1) OR ($filaM['mostrar_notas']=="")){ ?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/fichaAlumno.php3">Ficha Acad&eacute;mica</a> </div></td>
                  </tr>
        <?  }  ?>
                  <!--------------------------------------------------------------------fin-------------------------------------------->
		<? if($institucion!=24988){ //Temporalmente : omitir estos menu para el colegio Almenar del Maipo?>			  
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/fichas/medicas/listarFichasAlumno.php3">Ficha M&eacute;dica</a> </div></td>
                  </tr>		
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/fichas/deportivas/lista_fichadeportiva.php">Ficha Deportiva </a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/fichaApoderados.php3">Ficha Apoderado </a> </div></td>
                  </tr>
		<?  } ?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/horario/listarHorario.php">Horario </a> </div></td>
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
               
			    <div id="masterADMIN">
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left">				
					
					<? 	if($_INFO==1){ 	?>	
					   <div onclick="SwitchMenu('sub1')">
                                  <table  cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Info. Colegio</a></td>
                                    </tr>                                    
                                  </table>
                      </div>
					  <? }	?>
                              <span class="submenu4" id="sub1">
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/nuestraInstitucion.php3" >&nbsp;&nbsp;Nuestra instituci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/reglamentoInterno.php3" >&nbsp;&nbsp;Reglamento interno</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/cartaDireccion.php3" >&nbsp;&nbsp;Carta direcci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/procesoAdmision.php3" >&nbsp;&nbsp;Proceso admisi&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/proyectoEducativo.php3" >&nbsp;&nbsp;Proyecto educativo</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/uniforme.php" >&nbsp;&nbsp;Uniforme</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <? //if($_PERFIL == 0){?>
									<tr>                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/sede/listarSede.php" >&nbsp;&nbsp;Sede</a></td>
                                    </tr>
									<? //}?>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/mapa.php" >&nbsp;&nbsp;Mapa ubicaci&oacute;n </a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/insignia.php" >&nbsp;&nbsp;Insignia</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <!--tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/biblioteca/listarLibros.php?botonera=1" >&nbsp;&nbsp;Biblioteca</a></td>
                                    </tr-->
                                  </tbody>
                              </table>
                        </span>
					</div>  				  
				  <!-- fin informacion colegio en opciones ocultas -->
				   
			  <div id="masterADMIN">
				  <!-- ******************** Men� Comunicaciones ***************-->

				<!--div id="masterCONF"-->
				  <tr>
                    <td align="left" valign="top" class="cajamenu">

					    <div onclick="SwitchMenu('sub_comunica')">
                                  <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Comunicaciones</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
						  <span class="submenu5" id="sub_comunica">
							<table cellspacing="0" cellpadding="0" width="100%" border="0">
							  <tbody>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>mensajeria/mira.php" >&nbsp;&nbsp;Mensajer�a</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>agenda/lista_agenda.php?sw=1" >&nbsp;&nbsp;Agenda</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>fichas/diario/ListadoNoticias.php" >&nbsp;&nbsp;Diario Mural</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
							  </tbody>
						  </table>
                        </span>
					</td>
				 </tr>	
				<!--/div-->
				  
				  </div>
				  
		
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/usuario/claveAcceso.php3">Cambio Clave </a> </div></td>
                  </tr>
				  
				 <? if ($_INSTIT!=8905 AND $_INSTIT!=9035){?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/Colegio_restore/Reportes/Rpt18/rpt18.php?tipo=<? echo trim($tipo)?>&amp;c_curso=<? echo trim($curso)?>&amp;c_alumno=<? echo $alumno?>">Informe Educacional</a> </div></td>
                  </tr>
				  <? } ?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>menu/salida.php" target="_self">Salir</a> </div></td>
                  </tr>
                </table>
                <?  // fin if institucion
				
	          }
			  
  // fin ALUMNO ?>

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
	
		   
				   
	?><br />


                <!------------------------------------------------------------------fin proceso apoderado------------------------------->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>&nbsp;</tr>
                  <!-----------------------------------------------------------------------menu antiguo ------------------------------->
        <?
		// Aqui rescato nuevamente el a�o en que esta abierto
		$qry2_ano     = "select * from ano_escolar where id_ano = '".trim($ano)."'";
		$r2_ano       = @pg_Exec($conn,$qry2_ano);
		$f2_ano       = @pg_fetch_array($r2_ano,0);
		$ano_avierto  = $f2_ano['nro_ano'];		  
				  
				  
				  
	    $qry2_curso     = "select * from curso where id_ano = '".trim($ano)."' and id_curso='$curso'";
		$r2_curso       = @pg_Exec($conn,$qry2_curso);
		$f2_curso       = @pg_fetch_array($r2_curso,0);
		$curso_ficha  = $f2_curso['ensenanza'];		  		  
				  
		$hoy_date=date("Y-m-d");		
		$partedefecha = substr($hoy_date,4,6);
		$hoy_date = "$ano_avierto"."$partedefecha";
		
	$qryM="select * from periodo where id_ano=".$ano." and fecha_inicio<='".$hoy_date."' order by id_periodo Desc "; 
		$resultM=pg_Exec($conn,$qryM);
		$filaM=@pg_fetch_array($resultM,0);		
		
 
  		if (($filaM['mostrar_notas']==1) OR ($filaM['mostrar_notas']=="")){ ?>
                  <tr><br />
<?php 
session_start(mostrar_notas);
?> 
<? if ($curso_ficha!=10){ ?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c; ?>fichas/fichaAlumno.php3">Ficha Acad&eacute;mica</a> </div></td>
                  </tr>
				  <? } ?>
				  
				  <? if ($curso_ficha=10){ ?>
				      
					  <? if ($_INSTIT==8905 or $_INSTIT==9035){ 
					  
					          /// nada
					     }else{  ?>
					          <tr>
                                <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/Colegio_restore/Reportes/Rpt18/rpt18.php?tipo=<? echo trim($tipo)?>&amp;c_curso=<? echo trim($curso)?>&amp;c_alumno=<? echo $alumno?>">Informe Hogar</a> </div></td>
                              </tr>
					  <? } ?>		  
				  <? } ?>
                  <?
        } //fin if mostrar notas ?>
                  <!--------------------------------------------------------------------fin-------------------------------------------->
                  <? if ($institucion!=24977 and $institucion!=25478){  ?>
			  <? if($institucion!=24988){ ?>
                  
				  
				  
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/fichas/medicas/listarFichasAlumno.php3">Ficha M�dica</a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/fichas/deportivas/lista_fichadeportiva.php">Ficha Deportiva </a> </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>fichas/fichaApoderados.php3">Ficha Apoderado</a></div></td>
                  </tr>
			  <? } ?>				  
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/horario/listarHorario.php">Horario  </a> </div></td>
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
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>session/listarPupilos.php">Seleccionar Alumno </a> </div></td>
                  </tr>
				  
				  <div id="masterADMIN">
				  <!-- ******************** Men� Comunicaciones ***************-->

				<!--div id="masterCONF"-->
				  <tr>
                    <td align="left" valign="top" class="cajamenu">

					    <div onclick="SwitchMenu('sub_comunica')">
                                  <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Comunicaciones</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
						  <span class="submenu5" id="sub_comunica">
							<table cellspacing="0" cellpadding="0" width="100%" border="0">
							  <tbody>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>mensajeria/mira.php" >&nbsp;&nbsp;Mensajer�a</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>agenda/lista_agenda.php?sw=1" >&nbsp;&nbsp;Agenda</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>fichas/diario/ListadoNoticias.php" >&nbsp;&nbsp;Diario Mural</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
							  </tbody>
						  </table>
                        </span>
					</td>
				 </tr>	
				<!--/div-->
				  
				  </div>
				  <td align="left" valign="top" class="cajamenu">
					
					<? 	if($_INFO==1){ 	?>
					
					    <div onclick="SwitchMenu('sub1')">
                                  <table  cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Info. Colegio</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
					<? } ?>
                              <span class="submenu4" id="sub1">
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/nuestraInstitucion.php3" >&nbsp;&nbsp;Nuestra instituci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/reglamentoInterno.php3" >&nbsp;&nbsp;Reglamento interno</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/cartaDireccion.php3" >&nbsp;&nbsp;Carta direcci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/procesoAdmision.php3" >&nbsp;&nbsp;Proceso admisi&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/proyectoEducativo.php3" >&nbsp;&nbsp;Proyecto educativo</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/uniforme.php" >&nbsp;&nbsp;Uniforme</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/sede/listarSede.php" >&nbsp;&nbsp;Sede</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/mapa.php" >&nbsp;&nbsp;Mapa ubicaci&oacute;n </a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/insignia.php" >&nbsp;&nbsp;Insignia</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <!--tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/biblioteca/listarLibros.php?botonera=1" >&nbsp;&nbsp;Biblioteca</a></td>
                                    </tr-->
                                  </tbody>
                              </table>
				  
		
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/apoderado/usuario/claveAcceso.php3">Cambio Clave </a> </div></td>
                  </tr>
				  <? if ($curso_ficha!=10){ ?> 
				   <? if ($_INSTIT!=8905 OR $_INSTIT!=9035){?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/Colegio_restore/Reportes/Rpt18/rpt18.php?tipo=<? echo trim($tipo)?>&amp;c_curso=<? echo trim($curso)?>&amp;c_alumno=<? echo $alumno?>">Informe Educacional</a> </div></td>
                  </tr>
				  <? } }?>
                  <?  } // fin if institucion ?>
                  
                  
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>menu/salida.php" target="_self">Salir</a> </div></td>
                  </tr>
                </table>
                <? }// fin user 15 ?>



<!--////////////////////////// ADMINISTRADOR WEB COLEGIO //////////////////////////-->


        <?
	 if ($perfil_user == 99) 
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
                    <td align="left" valign="top" class="cajamenu">
					<div id="masterdiv">					
					      <div class="Estilo99" onclick="SwitchMenu('sub0')">
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
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/feriado/listaFeriado.php3" >&nbsp;&nbsp;Feriados</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/planEstudio/listarPlanesEstudio.php3" >&nbsp;&nbsp;Planes de estudio</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/listarTiposEnsenanza.php3" >&nbsp;&nbsp;Tipos de ense&ntilde;anza</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    jnjnsasad
								<div id="masterdiv3">	
                                    <div class="Estilo99" onclick="SwitchMenu('subc1')">
										<tr onclick="SwitchMenu('subc1')">
	                                      <td width="90%" class="cajamenu2"><a href="#">&nbsp;&nbsp;Cursos</a></td>
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
													 <td class="cajamenu2"><a href="<? echo $c ?>promocion/promocion_pro.php">Promoci�n </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>asistencia/seteaAsistencia.php3?caso=2">Asistencia </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>inasistencia/inasistencia.php">Inasistencia Asignatura </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>fichas/listarAlumnosMatriculados.php3?tipoFicha=1">Ficha M�dica </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>fichas/listarAlumnosMatriculados.php3?tipoFicha=2">Ficha Deportiva </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>frecuencias/main_informe_rendimiento.php?cursos=<?php echo $fila['id_curso']?>">Resultados del Curso </a></td>
												  </tr>
												 
												  
												 </tbody>
											 </table>	 
									     </span>		
									 
									 </td></tr></div>
									 
									 
									 
									
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/matricula/listarMatricula.php3" >&nbsp;&nbsp;Matricula</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/informe_planillas/plantilla/listaPlantillas.php" >&nbsp;&nbsp;Informe de Personalidad</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>">&nbsp;&nbsp;Reportes</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/ActasMatricula/Menu_Actas.php" >&nbsp;&nbsp;Actas</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    
                                  </tbody>
                              </table>
                        </span>
					
					  </div></td>
                  </tr>
				    <?
			     }
				 ?>		
				
				
				
				
				
				
				
				<div id="masterdiv2">
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left">
					
					<? 	if($_INFO==1){ 	?>
					
					    <div onclick="SwitchMenu('sub1')">
                                  <table  cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Info. Colegio</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
					<? } ?>						
                              <span class="submenu2" id="sub1">
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/nuestraInstitucion.php3" >&nbsp;&nbsp;Nuestra instituci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/reglamentoInterno.php3" >&nbsp;&nbsp;Reglamento interno</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/cartaDireccion.php3" >&nbsp;&nbsp;Carta direcci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/procesoAdmision.php3" >&nbsp;&nbsp;Proceso admisi&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/proyectoEducativo.php3" >&nbsp;&nbsp;Proyecto educativo</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/uniforme.php" >&nbsp;&nbsp;Uniforme</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/sede/listarSede.php" >&nbsp;&nbsp;Sede</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/mapa.php" >&nbsp;&nbsp;Mapa ubicaci&oacute;n </a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/insignia.php" >&nbsp;&nbsp;Insignia</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <!--
									
									<tr>
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/biblioteca/listarLibros.php?botonera=1" >&nbsp;&nbsp;Biblioteca</a></td>
                                    </tr>
									
									-->
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
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>solicitud2/index.php" target="_self">soporte</a></div></td>
                  </tr>
                  <? }else{?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>solicitud2/index.php" target="_self">soporte</a></div></td>
                  </tr>
                  <? } ?>
				  <!--mensajero-->
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>mensajeria/mira.php">Mensajeria</a> </div></td>
                  </tr>
				  <!-- fin mensagero -->
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>menu/salida.php" target="_self">Salir</a></div></td>
                  </tr>
                </table>
                <?  } ?>
                <!-------------------------------------------------------------------perfil docente------------------------------------------------------->            <?
	 if ($perfil_user == 17) // docente
	 {
	 
	 $frmModosd		=$_FRMMODO;
	 $ano			=$_ANO;
	 $menudinamico = $_MDINAMICO; //define los valores de la seccion para determinar que tipo de menu tiene que cargar (0 -1 -2)
		
		$sql_profjefe = "select rut_emp from supervisa where rut_emp = '$_NOMBREUSUARIO'"; // Profesor Jefe
		$res_profjefe = @pg_Exec($conn,$sql_profjefe);
		$num_profjefe = @pg_numrows($res_profjefe);


	              ?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <? if ($menudinamico == 0){ //inicio 0?>
                             
                  <tr>
                    <td  align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>session/perfilDocente.php3" target="_self">Seleccionar Curso</a></div></td>
                  </tr>
				 
				  <tr>
                    <td  align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>menu/salida.php" target="_self">Salir</a></div></td>
                  </tr>
                             
                  <? } //fin 0 ?>
                             
                             
                  <? if ($menudinamico == 1) { //inicio 1 ?>			    
                
				    <tr>
                    <td align="left" valign="top" class="cajamenu">
					      <div class="Estilo99" onclick="SwitchMenu('sub0')">
                                  <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tbody>
                                      <tr>
                                        <td  bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Libro de Clase</a></td>
                                      </tr>
                                    </tbody>
                                  </table>
	                      </div>
                              <span class="submenu3" id="sub0">  
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>

									
									<!--div id="masterdiv3"-->
                                  <div class="Estilo99">
									
										     <tbody>
											      <tr>
												     <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/listarAlumnos.php3?_url=0">&nbsp;&nbsp;&nbsp;&nbsp;Alumnos</a> </td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/listarRamos.php3?plan=<?php echo $fila["cod_decreto"] ?>&ext=<?php echo $ext1 ?>">&nbsp;&nbsp;&nbsp;&nbsp;Subsectores </a> </td>
												  </tr>
												  <tr> 	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/listarTalleres.php3">&nbsp;&nbsp;&nbsp;&nbsp;Taller </a> </td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/horario/listarHorario.php">&nbsp;&nbsp;&nbsp;&nbsp;Horario </a></td>
											   </tr>
												   <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/promocion/promocion_pro.php">&nbsp;&nbsp;&nbsp;&nbsp;Promoci�n </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/seteaAsistencia.php3?caso=2">&nbsp;&nbsp;&nbsp;&nbsp;Asistencia </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/inasistencia/inasistencia.php">&nbsp;&nbsp;&nbsp;&nbsp;Inasistencia Asignatura </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/seteaAsistencia.php3?caso=13">&nbsp;&nbsp;&nbsp;&nbsp;Asist. Apoderado</a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=1">&nbsp;&nbsp;&nbsp;&nbsp;Ficha M�dica </a></td>
												  </tr>
												<!-- Solo para Profesor Jefe y Profesor de educacion Fisica (todos los codigos de subsector relacionado con educacion fisica van aca)-->
												<? if(($_CODSUBECTOR == 11)OR($_CODSUBECTOR == 237)OR($_CODSUBECTOR == 158)OR($_CODSUBECTOR == 160)OR($_CODSUBECTOR == 773)OR($_CODSUBECTOR == 3176)OR($_CODSUBECTOR == 4359)OR($_CODSUBECTOR == 1184)OR($_CODSUBECTOR == 2967)OR($_CODSUBECTOR == 4360)OR($_CODSUBECTOR == 186)OR($_CODSUBECTOR == 426)OR($_CODSUBECTOR == 187)OR($_CODSUBECTOR == 3177)OR($_CODSUBECTOR == 700)OR($_CODSUBECTOR == 737)OR($_CODSUBECTOR == 4888)OR($_CODSUBECTOR == 4879)OR(@pg_numrows($res_profjefe)==1) AND $_TIPODOCENTE==1){ ?>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=2">&nbsp;&nbsp;&nbsp;&nbsp;Ficha Deportiva </a></td>
												  </tr>
												 <? 	}	?>
												<!-- Fin de condicion Profesor Jefe-->
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/informe_educacional/listarAlumnos.php">&nbsp;&nbsp;&nbsp;&nbsp;Informe Personalidad</a></td>
												  </tr>
												  <? if ($institucion==516 or $institucion==769) {  ?>
									                 <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/reportes/NotasParciales_Taller.php?flag=0">&nbsp;&nbsp;&nbsp;&nbsp;Informe de Notas</a></td>
												  </tr>
												  <? } ?>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/frecuencias/main_informe_rendimiento.php?cursos=<?php echo $fila['id_curso']?>">&nbsp;&nbsp;&nbsp;&nbsp;Resultados del Curso </a></td>
												  </tr>

												 <?
												 if ($num_profjefe==0){ ?>
												 
												      <tr>	 
													    <td class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/reportes/Menu_Reportes_Docente.php?ai_institucion=<?php echo $_INSTIT ;?>">&nbsp;&nbsp;&nbsp;&nbsp;Reportes </a></td>
												      </tr>
                                               <? }else{ ?> 
                                                     
													  <tr>
                                                        <td class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>">&nbsp;&nbsp;&nbsp;Reportes</a></td>
                                                      </tr>
											    <? } ?>		  
											  
								    </tbody>								   
								  </div>
								  
								  
								  
									 <!-- AQUI NUEVO CODIGO DEL SUB-MENU DEL CURSO -->
									
									   <tr><td>
									      <span > 
										      
										       <table width="90%" align="right" border="0">
											 </table>	 
											   
									     </span>			 
									 <!--/div-->
							
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    
									<!--<tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/informe_planillas2/listar_informe.php" >&nbsp;&nbsp;Info.de Personalidad 2</a></td>
                                    </tr>-->
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    
                                  </tbody>
                              </table>
                            </span>
							  <!-- codigo vhs-->			
					  </td></tr>								
				   <!-- informacion del colegio en opciones ocultas -->
				  
				  
				  <div id="masterADMIN">
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left">
					<? 	if($_INFO==1){ 	?>			
					   <div onclick="SwitchMenu('sub1')">
                                  <table  cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Info. Colegio</a></td>
                                    </tr>                                    
                                  </table>
                      </div>
					 <? } ?>
                              <span class="submenu4" id="sub1">
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/nuestraInstitucion.php3" >&nbsp;&nbsp;Nuestra instituci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/reglamentoInterno.php3" >&nbsp;&nbsp;Reglamento interno</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/cartaDireccion.php3" >&nbsp;&nbsp;Carta direcci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/procesoAdmision.php3" >&nbsp;&nbsp;Proceso admisi&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/proyectoEducativo.php3" >&nbsp;&nbsp;Proyecto educativo</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/uniforme.php" >&nbsp;&nbsp;Uniforme</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/sede/listarSede.php" >&nbsp;&nbsp;Sede</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/mapa.php" >&nbsp;&nbsp;Mapa ubicaci&oacute;n </a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/insignia.php" >&nbsp;&nbsp;Insignia</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <!--tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/biblioteca/listarLibros.php?botonera=1" >&nbsp;&nbsp;Biblioteca</a></td>
                                    </tr-->
                                  </tbody>
                              </table>
                        </span>
					</div>  				  
				  <!-- fin informacion colegio en opciones ocultas -->
				  
				  
				   <div id="masterADMIN">
				  <!-- ******************** Men� Comunicaciones ***************-->


				<!--div id="masterCONF"-->
				  <tr>
                    <td align="left" valign="top" class="cajamenu">

					    <div onclick="SwitchMenu('sub_comunica')">
                                  <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Comunicaciones</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
						  <span class="submenu5" id="sub_comunica">
							<table cellspacing="0" cellpadding="0" width="100%" border="0">
							  <tbody>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>mensajeria/mira.php" >&nbsp;&nbsp;Mensajer�a</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>agenda/lista_agenda.php?sw=1" >&nbsp;&nbsp;Agenda</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>fichas/diario/ListadoNoticias.php" >&nbsp;&nbsp;Diario Mural</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
							  </tbody>
						  </table>
                        </span>
					</td>
				 </tr>	
				<!--/div-->
				  
				  </div>
				  
				  
				  
				  
				  
				  
				  
				  
				  
             <!--     <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/horario/listarHorario.php" target="_self">Horario</a></div></td>
                  </tr>
                  <?php  $sqlFer="select * from feriado where id_ano=".$ano;
		$resultFer=@pg_Exec($conn,$sqlFer);
		if((@pg_numrows($resultFer)!=0)and ($frmModosd=="mostrar")){	?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/asistencia.php3" target="_self">Asistencia</a></div></td>
                  </tr>
                  <? } ?>-->
				  </td>
                  <tr>
				  </div>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>solicitud2/index.php" target="_self">Soporte</a></div></td>
                  </tr>

                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>menu/salida.php" target="_self">Salir</a></div></td>
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
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>menu/salida.php" target="_self">Salir</a></div></td>
                  </tr>
                             
                  <? } //fin 2 ?>
				  
				  
                </table>
                <? }?>
				
	<!------------------------------------------------------------------------------perfil director academico	-->		
				
	<?			if (($perfil_user == 2) || ($perfil_user == 23) || ($perfil_user == 24) || ($perfil_user == 25)) 
	 {
	              $menudinamico = $_MDINAMICO;				  
	 ?>
	          
			   <div id="masterADMIN">	 
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>&nbsp;</tr>
				  <? if ($menudinamico == 0){ //inicio 0?>
                             
                 
				 
				  <tr>
                    <td  align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/listarAno.php3" target="_self">Seleccione a�o escolar</a></div></td>
                  </tr>
				  
				  <tr>
                    <td  align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>menu/salida.php" target="_self">Salir</a></div></td>
                  </tr>
				  
				  
				 
				  
				  
				  
                             
                  <? } //fin 0 ?>
				  <? if ($menudinamico == 1){ //inicio 0?>
				  
				  
		          <tr>
                    <!-- primer boton  -->
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>agenda/lista_agenda.php?sw=1" target="_self">Agenda</a></div></td>
                  </tr>
		   
		    <!--   MENU INFO COLEGIO   -->
		
		   <!--div id="masterdiv2"-->
				  <tr>
                    <td align="left" valign="top" class="cajamenu">
					
					<? 	if($_INFO==1){ 	?>
					
					    <div onclick="SwitchMenu('sub1')">
                                  <table  cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Info. Colegio</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
					<? } ?>
                              <span class="submenu4" id="sub1">
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/nuestraInstitucion.php3" >&nbsp;&nbsp;Nuestra instituci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/reglamentoInterno.php3" >&nbsp;&nbsp;Reglamento interno</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/cartaDireccion.php3" >&nbsp;&nbsp;Carta direcci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/procesoAdmision.php3" >&nbsp;&nbsp;Proceso admisi&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/proyectoEducativo.php3" >&nbsp;&nbsp;Proyecto educativo</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/uniforme.php" >&nbsp;&nbsp;Uniforme</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/sede/listarSede.php" >&nbsp;&nbsp;Sede</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/mapa.php" >&nbsp;&nbsp;Mapa ubicaci&oacute;n </a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/insignia.php" >&nbsp;&nbsp;Insignia</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <!--tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/biblioteca/listarLibros.php?botonera=1" >&nbsp;&nbsp;Biblioteca</a></td>
                                    </tr-->
                                  </tbody>
                              </table>
                        </span>
					             
					
					
					</td>
				 </tr>
				 
	  <!-- FIN MENU INFO COLEGIO  --> 
	  
	             <!-- AQUI SE INCLUYE MEN� LIBRO CLASE PARA DIECTOR ACADEMICO INSTITUCION 516 -->
				 <?
				 if (($_ANO != 0) AND ($_INSTIT==516)){?>
				    <tr>
                    <td align="left" valign="top" class="cajamenu">
					      <div class="Estilo99" onclick="SwitchMenu('sub0')">
                                  <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tbody>
                                      <tr>
                                        <td  bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Libro de Clase</a></td>
                                      </tr>
                                    </tbody>
                                  </table>
	                      </div>
                              <span class="submenu3" id="sub0">  
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									
									
									
									
									<!--div id="masterdiv3"-->
                                  <div class="Estilo99" onclick="SwitchMenu('sub2')">
									
									  <tr onclick="SwitchMenu('sub2')">
                                      <td width="90%" class="cajamenu2"><a href="#">&nbsp;&nbsp;&nbsp;Cursos</a></td>
                                      </tr>
									   
								  </div>
									 <!-- AQUI NUEVO CODIGO DEL SUB-MENU DEL CURSO -->
									
									   <tr><td>
									      <span class="submenu3_1" id="sub2"> 
										      
										       <table width="90%" align="right" border="0">
											     <tbody>
											      <tr>
												     <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/buscaralumno.php"><li>B�squeda Alumno</li></a> </td>
												  </tr>
											      <tr>
												     <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/listarAlumnos.php3?_url=0"><li>Alumnos</li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/listarRamos.php3?plan=<?php echo $fila["cod_decreto"] ?>&ext=<?php echo $ext1 ?>"><li>Subsectores</li> </a> </td>
												  </tr>
												  <tr> 	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/listarTalleres.php3"><li>Talleres </a> </td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/horario/listarHorario.php"><li>Horario</li> </a></td>
												   </tr>
												   <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/promocion/promocion_pro.php"><li>Promoci�n</li> </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/seteaAsistencia.php3?caso=2"><li>Asistencia Mensual</li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/inasistencia/inasistencia.php"><li>Asistencia Horaria</li> </a></td>
												  </tr>	
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/justifica_inasistencia.php"><li>Justifica Inasist.</li></a></td>
												  </tr>	
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/seteaAsistencia.php3?caso=13"><li>Asist. Apoderado</li></a></td>
												  </tr>												  											 
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/atrasos/atrasos.php"><li>Atrasos</li> </a></td>
												  </tr>																							  
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=1"><li>Ficha M�dica </li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=2"><li>Ficha Deportiva </li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/informe_educacional/listarAlumnos.php"><li>Inf. Personalidad</li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/frecuencias/main_informe_rendimiento.php?cursos=<?php echo $fila['id_curso']?>"><li>Resultados Curso</li> </a></td>
												  </tr>
												 
												  
												 </tbody>
											 </table>	 
											   
									     </span>			 
									 <!--/div-->
									
							
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/matricula/listarMatricula.php3" >&nbsp;&nbsp;&nbsp;Matr�cula</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>">&nbsp;&nbsp;&nbsp;Reportes</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/ActasMatricula/Menu_Actas.php" >&nbsp;&nbsp;&nbsp;Actas</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    
                                  </tbody>
                              </table>
                        </span>
					</td></tr>
			        </div>
				    <!--/div-->
				    <?
			     }
				 ?>	
				 
				 
				 <!-- FIN MENU LIBRO DE CLASE -->
	                  
				  
				  <tr>
                    <!-- primer boton  -->
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/listarCursos.php3" target="_self">Listado cursos</a></div></td>
                  </tr>                  
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/matricula/listarMatricula.php3" target="_self">Listado Alumnos</a></div></td>
                  </tr>                 
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/empleado/listarEmpleado.php3" target="_self">Personal</a></div></td>
                  </tr>                 
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>solicitud2/index.php" target="_self">Soporte</a></div></td>
                  </tr>                  
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/reportes/Menu_Reportes.php" target="_self">Reportes</a></div></td>
                  </tr>                                   
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>menu/salida.php" target="_self">Salir</a></div></td>
                  </tr>
				  <? } //fin 1 ?>
                </table>
			  </div>		
                <?  } ?>

		<!----------------------------------------------------------------------- Sostenedor Corporativo --------------------------->
			
				<? if($perfil_user == 26)
				{
					$menudinamico = $_MDINAMICO;
					$ano			=$_ANO;
				?>
				
				 <table cellspacing="0" cellpadding="0" width="100%" border="0">
					<tbody>
					  <tr>
						<td  align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/corporacion/listaCorporacion.php" target="_self">Seleccione Instituci�n</a></div></td>
					  </tr>
					  <tr>
						<td  bgcolor="#f5f5f5" class="cajamenu"><a href="<? echo $c ?>admin/corporacion/establecimientos.php">Establecimientos</a></td>
					  </tr>
					  <tr>
						<td  bgcolor="#f5f5f5" class="cajamenu"><a href="<? echo $c ?>admin/corporacion/reportesCorporativos.php">Reportes</a></td>
					  </tr>
					  <? if ($menudinamico == 0)
					  	{	?>
						   <tr>
							<td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/listarAno.php3" target="_self">A&ntilde;o Academico </a></div></td>
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
						  	<td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>solicitud2/index.php" target="_self">Soporte</a></div></td>
                          </tr>						  						  						  						   							
					  <?	}  ?>				  
					  <tr>
						<td  align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>menu/salida.php" target="_self">Salir</a></div></td>
					  </tr>					  
					  
					</tbody>
			  </table>				
		
				
			<?	}?>

		<!---------------------------------------------------------------------- Fin Corporativo ----------------------------------->		
				
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
                    <td  align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>menu/salida.php" target="_self">Salir</a></div></td>
                  </tr>
                             
                  <? } //fin 0 ?>
				  <? if ($menudinamico == 1){ //inicio 0?>
                  <tr>
                    <!-- primer boton  -->
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/listarAno.php3" target="_self">A&ntilde;o Academico </a></div></td>
					
                  </tr>
				  
				  <? if ($_INSTIT!=14912){?>
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/matricula/listarMatricula.php3" target="_self">Listado Alumnos</a></div></td>
                  </tr>
                  <? } ?>
				 <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/atrasos/atrasos.php" target="_self">Atrasos</a></div></td>
                  </tr>
				  
				  <tr>	 
					 <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/seteaAsistencia.php3?caso=13" target="_self">Asist. Apoderado</a></div></td>
				  </tr>	
				  	  
				  
				  
				  <tr>
		                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/listarCursos.php3" target="_self">Listado cursos</a></div></td>
                  </tr>
						   <tr>
		                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/listarAlumnos.php3?_url=0" target="_self">Alumnos</a></div></td>
		                  </tr>
						  <tr>
		                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/justifica_inasistencia.php" target="_self">Justifica Inas.</a></div></td>
		                  </tr>
						  <tr>
		                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=1" target="_self">Ficha Medica</a></div></td>
		                  </tr>
						  <tr>
		                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/seteaAsistencia.php3?caso=2" target="_self">Asistencia Mensual</a></div></td>
		                  </tr>
						  <tr>
		                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/inasistencia/inasistencia.php" target="_self">Asistencia Asignaturas</a></div></td>
		                  </tr>
						  						  
						 
                 <!-- aQUI AGREGO LA OPCI�N DEL LIBRO DE CLASE CON TODO SU CONTENIDO
				 PARA EL PERFIL 19, PARA LA INSTITUCION
				 gABRIELA MISTRAL 516  -->
				 <? if ($_INSTIT==516 or $_INSTIT==1756 or $_INSTIT==770){ ?>
				 
				         <tr>
                    <td align="left" valign="top" class="cajamenu">
					      <div class="Estilo99" onclick="SwitchMenu('sub0')">
                                  <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tbody>
                                      <tr>
                                        <td  bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Libro de Clase</a></td>
                                      </tr>
                                    </tbody>
                                  </table>
	                      </div>
                              <span class="submenu3" id="sub0">  
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>

									
									<!--div id="masterdiv3"-->
                                  <div class="Estilo99">
									
										     <tbody>
											      <tr>
												     <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/listarAlumnos.php3?_url=0">&nbsp;&nbsp;&nbsp;&nbsp;Alumnos</a> </td>
												  </tr>
												 <? if ($_INSTIT!=770) {?> <tr>	 
												  
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/listarRamos.php3?plan=<?php echo $fila["cod_decreto"] ?>&ext=<?php echo $ext1 ?>">&nbsp;&nbsp;&nbsp;&nbsp;Subsectores</a></td>
												  </tr>
												 <? } ?>
												 <!--											 
												 
												  <tr> 	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/listarTalleres.php3">&nbsp;&nbsp;&nbsp;&nbsp;Taller </a> </td>
												  </tr>
												  
												  -->
												  
												  <?
												  if ($_INSTIT==770){ /// MUESTRO SUBMENU HORARIO PARA INSPECTOR ?>												  
												     <tr>	 
													    <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/horario/listarHorario.php">&nbsp;&nbsp;&nbsp;&nbsp;Horario </a></td>
											         </tr>
											   <? } ?>
											   
											     <!--		 
													 
													 
												   <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/promocion/promocion_pro.php">&nbsp;&nbsp;&nbsp;&nbsp;Promoci�n </a></td>
												  </tr>
												  -->
												  
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/seteaAsistencia.php3?caso=2">&nbsp;&nbsp;&nbsp;&nbsp;Asistencia </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/inasistencia/inasistencia.php">&nbsp;&nbsp;&nbsp;&nbsp;Inasistencia Asignatura </a></td>
												  </tr>
												  
												 
												  <!--
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=1">&nbsp;&nbsp;&nbsp;&nbsp;Ficha M�dica </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=2">&nbsp;&nbsp;&nbsp;&nbsp;Ficha Deportiva </a></td>
												  </tr>
												  -->
												  
												  <?
												  if ($_INSTIT==770){  // MUESTRO PARA QUE INGRESE INFORME A LOS ALUMNOS   ?>												  
												  
														  <tr>	 
															 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/informe_educacional/listarAlumnos.php">&nbsp;&nbsp;&nbsp;&nbsp;Informe Personalidad</a></td>
														  </tr>
												<? } ?>		  
												  
												  <!--
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/frecuencias/main_informe_rendimiento.php?cursos=<?php echo $fila['id_curso']?>">&nbsp;&nbsp;&nbsp;&nbsp;Resultados del Curso </a></td>
												  </tr>
												  -->
												 
												  
								    </tbody>								   
								  </div>
								  
								  
								  
									 <!-- AQUI NUEVO CODIGO DEL SUB-MENU DEL CURSO -->
									
									   <tr><td>
									      <span > 
										      
										       <table width="90%" align="right" border="0">
											 </table>	 
											   
									     </span>			 
									 <!--/div-->
							
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    
									<!--<tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/informe_planillas2/listar_informe.php" >&nbsp;&nbsp;Info.de Personalidad 2</a></td>
                                    </tr>-->
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    
                                  </tbody>
                              </table>
                            </span>
							  <!-- codigo vhs-->			
					  </td></tr>		
				 
				    		 
						
					<!-- FIN MENU LIBRO DE CLASE PARA PERFIL 19 CUANDO INSTITUCION
					ES 516, GABRIELA MISTRAL -->
					
				<? } ?>			 
				
				<? if ($_INSTIT==770) { ?> 
				<tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=1" target="_self">Ficha M�dica</a></div></td>
                  </tr>   
                  <? } ?>
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/reportes/Menu_Reportes.php" target="_self">Reportes</a></div></td>
                  </tr>                 
				  
				 <? if($institucion==14629 or $institucion==12829 or $institucion==516 or $institucion==1756 or $institucion==769 or $institucion==770){ ?>
				  <tr>	 
					 <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/justifica_inasistencia.php" target="_self">Justifica Inasist.</a></div></td>
				  </tr>					  				  
				  <? }
				  
		 if ($_INSTIT==516){  ?>
				  
				  <!-- Aqui inserto menu de info colegio para el perfil Inspector
				  pero solo para la institucion 516 GABRIELA MISTRAL -->				  
				  <!-- informacion del colegio en opciones ocultas -->				  
				  <div id="masterdiv2">
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left">
					<? 	if($_INFO==1){ 	?>				
					    <div onclick="SwitchMenu('sub1')">
                                  <table  cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Info. Colegio</a></td>
                                    </tr>                                    
                                  </table>
                        </div>				
					<? } ?>		
                              <span class="submenu4" id="sub1">
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/nuestraInstitucion.php3" >&nbsp;&nbsp;Nuestra instituci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/reglamentoInterno.php3" >&nbsp;&nbsp;Reglamento interno</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/cartaDireccion.php3" >&nbsp;&nbsp;Carta direcci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/procesoAdmision.php3" >&nbsp;&nbsp;Proceso admisi&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/proyectoEducativo.php3" >&nbsp;&nbsp;Proyecto educativo</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/uniforme.php" >&nbsp;&nbsp;Uniforme</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/sede/listarSede.php" >&nbsp;&nbsp;Sede</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/mapa.php" >&nbsp;&nbsp;Mapa ubicaci&oacute;n </a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/insignia.php" >&nbsp;&nbsp;Insignia</a></td>      </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									
									<!--
                                    <tr>                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/biblioteca/listarLibros.php?botonera=1" >&nbsp;&nbsp;Biblioteca</a></td>
                                    </tr>  -->
                                  </tbody>
                              </table>
                        </span>				
					</div>  				  
				  <!-- fin informacion colegio en opciones ocultas PARA PERFIL 19 INSTITUCION 516 -->			  
				 <? } ?>  
				  
				  
				  
				  
				  
				  <div id="masterADMIN">			  
				  <!-- ******************** Men� Comunicaciones ***************-->
				<!--div id="masterCONF"-->
				  <tr>
                    <td align="left" valign="top" class="cajamenu">
					    <div onclick="SwitchMenu('sub_comunica')">
                                  <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Comunicaciones</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
						  <span class="submenu5" id="sub_comunica">
							<table cellspacing="0" cellpadding="0" width="100%" border="0">
							  <tbody>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>mensajeria/mira.php" >&nbsp;&nbsp;Mensajer�a</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>agenda/lista_agenda.php?sw=1" >&nbsp;&nbsp;Agenda</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>fichas/diario/ListadoNoticias.php" >&nbsp;&nbsp;Diario Mural</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>								
								<td width="90%" class="cajamenu2"><a href="<? echo $c; ?>fichas/sugerencias/sugrec.php" >&nbsp;&nbsp;Sugerencias o Reclamos</a></td>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
							  </tbody>
						  </table>
                        </span>
					</td>
				 </tr>	
				<!--/div-->
				  
				  </div>
				  
			
				  
				  
				  
				  
				  
				  
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/empleado/listarEmpleado.php3" target="_self">Personal</a></div></td>
                  </tr>
				  
				   <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/anotacion_empleado/atrasos.php" target="_self">Atrasos Personal</a></div></td>
                  </tr>
				   <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/anotacion_empleado/asistencia.php" target="_self">Asistencia Personal</a></div></td>
                  </tr>
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/curso/inasistencia/inasistencia_docente.php" target="_self">Asistencia Horaria Docente</a></div></td>
                  </tr>
				 
				  
				
			<!-- Para la institucion Gabriela Mistral (516)
			Soporte debe estar disponible para perfil 19 -->
			<? if ($_INSTIT==516){ ?>				  
				    <tr>
                      <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>solicitud2/index.php" target="_self">Soporte</a></div></td>
                    </tr>
		    <? } ?>			
				  
				                  
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>menu/salida.php" target="_self">Salir</a></div></td>
                  </tr>
				  <? } //fin 1 ?>
                </table>
                <?  } ?>
				
				
                <!-- PERFIL DIRECTOR GENERAL --> 
	          			
				<? if ($perfil_user == 1) // DIRECTOR GENERAL
				{
	             
	            ?>
				
				
				<div id="masterADMIN">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
                    <!-- primer boton  -->
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>agenda/lista_agenda.php?sw=1" target="_self">Agenda</a></div></td>
                  </tr>
                  <tr>
                    <!-- primer boton  -->
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/institucion.php3?caso=1" target="_self">Datos Instituci�n </a></div></td>
                  </tr>
				  
				  <!-- informacion del colegio en opciones ocultas -->
				  
				  
				  <div id="masterdiv2">
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left">
					<? 	if($_INFO==1){ 	?>				
					    <div onclick="SwitchMenu('sub1')">
                                  <table  cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Info. Colegio</a></td>
                                    </tr>                                    
                                  </table>
                        </div>				
					<? } ?>		
                              <span class="submenu4" id="sub1">
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/nuestraInstitucion.php3" >&nbsp;&nbsp;Nuestra instituci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/reglamentoInterno.php3" >&nbsp;&nbsp;Reglamento interno</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/cartaDireccion.php3" >&nbsp;&nbsp;Carta direcci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/procesoAdmision.php3" >&nbsp;&nbsp;Proceso admisi&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/proyectoEducativo.php3" >&nbsp;&nbsp;Proyecto educativo</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/uniforme.php" >&nbsp;&nbsp;Uniforme</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/sede/listarSede.php" >&nbsp;&nbsp;Sede</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/mapa.php" >&nbsp;&nbsp;Mapa ubicaci&oacute;n </a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/insignia.php" >&nbsp;&nbsp;Insignia</a></td>      </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									<!--
                                    <tr>                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/biblioteca/listarLibros.php?botonera=1" >&nbsp;&nbsp;Biblioteca</a></td>
                                    </tr>  -->
                                  </tbody>
                              </table>
                        </span>				
					</div>  				  
				  <!-- fin informacion colegio en opciones ocultas -->			  
                  
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/ano/listarAno.php3" target="_self">A�o Acad�mico</a></div></td>
                  </tr>                 
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>admin/institucion/empleado/listarEmpleado.php3" target="_self">Personal</a></div></td>
                  </tr>                 
				  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>solicitud2/index.php" target="_self">Soporte</a></div></td>
                  </tr>			                 
                  <tr>
                    <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>menu/salida.php" target="_self">Salir</a></div></td></tr>				  
                </table>
				</div>
                <?  } ?>				
				
				
				
				
			
            </div></td>
          </tr>
        </table>
    </div></td>
  </tr>
</table>
<? }?>
 <? 
 // ORIENTADOR 20 - PSICOLOGO 21
 if (($perfil_user == 20)||($perfil_user == 21)){?>
 <table width="190" border="0" align="left">
   <tr>
     <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td align="left" valign="top" class="cajamenu">		     <a href="<? echo $c ?>admin/institucion/ano/listarAno.php3">A&ntilde;os Acad&eacute;micos</a></td>
         </tr>
		 
		       <!-- AQUI SE INCLUYE MEN� LIBRO CLASE PARA DIECTOR ACADEMICO INSTITUCION 516 -->
				 <?
				 if (($_ANO != 0) AND ($_INSTIT==516 or $_INSTIT==8933) ){?>
				    <tr>
                    <td align="left" valign="top" class="cajamenu">
					      <div class="Estilo99" onclick="SwitchMenu('sub0')">
                                  <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tbody>
                                      <tr>
                                        <td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Libro de Clase</a></td>
                                      </tr>
                                    </tbody>
                                  </table>
	                      </div>
                              <span class="submenu3" id="sub0">  
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									
									
									
									
									<!--div id="masterdiv3"-->
                                  <div class="Estilo99" onclick="SwitchMenu('sub2')">
									
									  <tr onclick="SwitchMenu('sub2')">
                                      <td width="90%" class="cajamenu2"><a href="#">&nbsp;&nbsp;&nbsp;Cursos</a></td>
                                      </tr>
									   
								  </div>
									 <!-- AQUI NUEVO CODIGO DEL SUB-MENU DEL CURSO -->
									
									   <tr><td>
									      <span class="submenu3_1" id="sub2"> 
										      
										       <table width="90%" align="right" border="0">
											     <tbody>
											      <tr>
												     <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/buscaralumno.php"><li>B�squeda Alumno</li></a> </td>
												  </tr>
											      <tr>
												     <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/listarAlumnos.php3?_url=0"><li>Alumnos</li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/listarRamos.php3?plan=<?php echo $fila["cod_decreto"] ?>&ext=<?php echo $ext1 ?>"><li>Subsectores</li> </a> </td>
												  </tr>
												  <tr> 	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/listarTalleres.php3"><li>Talleres </a> </td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/horario/listarHorario.php"><li>Horario</li> </a></td>
												   </tr>
												   <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/promocion/promocion_pro.php"><li>Promoci�n</li> </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/seteaAsistencia.php3?caso=2"><li>Asistencia Mensual</li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/inasistencia/inasistencia.php"><li>Asistencia Horaria</li> </a></td>
												  </tr>	
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/justifica_inasistencia.php"><li>Justifica Inasist.</li></a></td>
												  </tr>													  											 
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/atrasos/atrasos.php"><li>Atrasos</li> </a></td>
												  </tr>																							  
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=1"><li>Ficha M�dica </li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=2"><li>Ficha Deportiva </li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/informe_educacional/listarAlumnos.php"><li>Inf. Personalidad</li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/frecuencias/main_informe_rendimiento.php?cursos=<?php echo $fila['id_curso']?>"><li>Resultados Curso</li> </a></td>
												  </tr>
												 
												  
												 </tbody>
											 </table>	 
											   
									     </span>			 
									 <!--/div-->
									
							
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/matricula/listarMatricula.php3" >&nbsp;&nbsp;&nbsp;Matr�cula</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>">&nbsp;&nbsp;&nbsp;Reportes</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/ActasMatricula/Menu_Actas.php" >&nbsp;&nbsp;&nbsp;Actas</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    
                                  </tbody>
                              </table>
                        </span>
					</td></tr>
			        </div>
				    <!--/div-->
				    <?
			     }
				 ?>	
				 
				 
				 <!-- FIN MENU LIBRO DE CLASE -->
		 
		  <tr>
           <td align="left" valign="top" class="cajamenu">		     <a href="<? echo $c ?>admin/institucion/ano/curso/listarCursos.php3">Cursos</a></td>
         </tr>
		    <tr>
           <td align="left" valign="top" class="cajamenu">		     <a href="<? echo $c ?>admin/institucion/ano/matricula/listarMatricula.php3">Alumnos</a></td>
         </tr>
		    <tr>
           <td align="left" valign="top" class="cajamenu">		     <a href="<? echo $c ?>admin/institucion/ano/reportes/Menu_Reportes.php">Reportes</a></td>
         </tr>
		     <tr>
           <td align="left" valign="top" class="cajamenu"><a href="<? echo $c ?>admin/institucion/empleado/listarEmpleado.php3">Personal</a></td>
         </tr>
		<?  if ($perfil_user == 20){?>
		    <tr>
           <td align="left" valign="top" class="cajamenu">		     <a href="<? echo $c ?>fichas/orientador/ficha_orientador.php">Ingreso Ficha</a></td>
         </tr>
		<? }elseif ($perfil_user == 21){?>
		    <tr>
           <td align="left" valign="top" class="cajamenu">		     <a href="<? echo $c ?>fichas/psicologo/ficha_psicologo.php">Ingreso Ficha</a></td>
         </tr>
		<? }?>
		  <!-- ******************** Men� Comunicaciones ***************-->

				<!--div id="masterCONF"-->
				<div id="masterADMIN">
				  <tr>
                    <td align="left" valign="top" class="cajamenu">

					    <div onclick="SwitchMenu('sub_comunica')">
                                  <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Comunicaciones</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
						  <span class="submenu5" id="sub_comunica">
							<table cellspacing="0" cellpadding="0" width="100%" border="0">
							  <tbody>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>mensajeria/mira.php" >&nbsp;&nbsp;Mensajer�a</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>agenda/lista_agenda.php?sw=1" >&nbsp;&nbsp;Agenda</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>fichas/diario/ListadoNoticias.php" >&nbsp;&nbsp;Diario Mural</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
							  </tbody>
						  </table>
                        </span>
					</td>
				 </tr>	
	    </div>
				<!--/div-->		
		    <tr>
           <td align="left" valign="top" class="cajamenu">		     <a href="<? echo $c ?>menu/salida.php">Salir</a></td>
         </tr>
     </table></td>
   </tr>
 </table>
 <? }?>
 
 <? 
 // PERFIL JEFE DE UTP
  if ($perfil_user == 25){?>
 <table width="190" border="0" align="left">
   <tr>
     <td width="100%">
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td align="left" valign="top" class="cajamenu"><a href="<? echo $c ?>admin/institucion/ano/listarAno.php3">A&ntilde;os Acad&eacute;micos</a></td>
         </tr>
         <tr>
           <td align="left" valign="top" class="cajamenu"><a href="<? echo $c ?>admin/institucion/ano/curso/listarCursos.php3">Cursos</a></td>
         </tr>
		       
		 <tr>
		   <td align="left" valign="top" class="cajamenu"><a href="<? echo $c; ?>admin/institucion/planEstudio/listarPlanesEstudio.php3" >Planes de estudio</a></td>
		 </tr>
		
		<!--   MENU INFO COLEGIO   -->
		
		   <!--div id="masterdiv2"-->
				  <tr>
                    <td align="left" valign="top" class="cajamenu">
					
					<? 	if($_INFO==1){ 	?>
					
					    <div onclick="SwitchMenu('sub1')">
                                  <table  cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Info. Colegio</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
					<? } ?>
                              <span class="submenu4" id="sub1">
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/nuestraInstitucion.php3" >&nbsp;&nbsp;Nuestra instituci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/reglamentoInterno.php3" >&nbsp;&nbsp;Reglamento interno</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/cartaDireccion.php3" >&nbsp;&nbsp;Carta direcci&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/procesoAdmision.php3" >&nbsp;&nbsp;Proceso admisi&oacute;n</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/atributos/proyectoEducativo.php3" >&nbsp;&nbsp;Proyecto educativo</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/uniforme.php" >&nbsp;&nbsp;Uniforme</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/sede/listarSede.php" >&nbsp;&nbsp;Sede</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/mapa.php" >&nbsp;&nbsp;Mapa ubicaci&oacute;n </a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/insignia.php" >&nbsp;&nbsp;Insignia</a></td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <!--tr>
                                      
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/biblioteca/listarLibros.php?botonera=1" >&nbsp;&nbsp;Biblioteca</a></td>
                                    </tr-->
                                  </tbody>
                              </table>
                        </span>
					             
					
					
					</td>
				 </tr>
				 
	  <!-- FIN MENU INFO COLEGIO  -->	
	  
	  
	  
	  <!-- MENU LIBRO DE CLASE -->
	  		
	<?	if ($_ANO != 0){?>
				    <tr>
                    <td align="left" valign="top" class="cajamenu">
					      <div class="Estilo99" onclick="SwitchMenu('sub0')">
                                  <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tbody>
                                      <tr>
                                        <td  bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Libro de Clase</a></td>
                                      </tr>
                                    </tbody>
                                  </table>
	                      </div>
                              <span class="submenu3" id="sub0">  
                                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                  <tbody>
                                    <tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									
									
									
									
									
                                  <div class="Estilo99" onclick="SwitchMenu('sub2')">
									
									  <tr onclick="SwitchMenu('sub2')">
                                      <td width="90%" class="cajamenu2"><a href="#">&nbsp;&nbsp;&nbsp;Cursos</a></td>
                                      </tr>
									   
								  </div>
									 <!-- AQUI NUEVO CODIGO DEL SUB-MENU DEL CURSO -->
									
									   <tr><td>
									      <span class="submenu3_1" id="sub2"> 
										      
										       <table width="90%" align="right" border="0">
											     <tbody>
											      <tr>
												     <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/buscaralumno.php"><li>B�squeda Alumno</li></a> </td>
												  </tr>
											      <tr>
												     <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/alumno/listarAlumnos.php3?_url=0"><li>Alumnos</li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/listarRamos.php3?plan=<?php echo $fila["cod_decreto"] ?>&ext=<?php echo $ext1 ?>"><li>Subsectores</li> </a> </td>
												  </tr>
												  <tr> 	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/ramo/listarTalleres.php3"><li>Talleres </a> </td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/horario/listarHorario.php"><li>Horario</li> </a></td>
												   </tr>
												   <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/promocion/promocion_pro.php"><li>Promoci�n</li> </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/asistencia/seteaAsistencia.php3?caso=2"><li>Asistencia Mensual</li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/inasistencia/inasistencia.php"><li>Asistencia Horaria</li> </a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=1"><li>Ficha M�dica </li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/fichas/listarAlumnosMatriculados.php3?tipoFicha=2"><li>Ficha Deportiva </li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/informe_educacional/listarAlumnos.php"><li>Inf. Personalidad</li></a></td>
												  </tr>
												  <tr>	 
													 <td class="cajamenu2"><a href="<? echo $c ?>admin/institucion/ano/curso/frecuencias/main_informe_rendimiento.php?cursos=<?php echo $fila['id_curso']?>"><li>Resultados Curso</li> </a></td>
												  </tr>
												 
												  
												 </tbody>
											 </table>	 
											   
									     </span>			 
								
									
							
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/matricula/listarMatricula.php3" >&nbsp;&nbsp;&nbsp;Matr�cula</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>">&nbsp;&nbsp;&nbsp;Reportes</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    <tr>
                                      <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>admin/institucion/ano/ActasMatricula/Menu_Actas.php" >&nbsp;&nbsp;&nbsp;Actas</a></td>
                                    </tr>
									<tr>
                                      <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
                                    </tr>
                                    
                                  </tbody>
                              </table>
                        </span>
					</td></tr>
			  </div>
			
				    <?
			     }
				 ?>	
		
		<tr>
           <td align="left" valign="top" class="cajamenu"><a href="<? echo $c ?>admin/institucion/empleado/listarEmpleado.php3">Personal</a></td>
        </tr>	
				  <!-- ******************** Men� Comunicaciones ***************-->

				<!--div id="masterCONF"-->
				<div id="masterADMIN">
				  <tr>
                    <td align="left" valign="top" class="cajamenu">

					    <div onclick="SwitchMenu('sub_comunica')">
                                  <table cellspacing="0" cellpadding="0" width="100%" border="0">
                                    <tr><td bgcolor="#f5f5f5" class="cajamenu2"><a href="#">Comunicaciones</a></td>
                                    </tr>                                    
                                  </table>
                        </div>
						  <span class="submenu5" id="sub_comunica">
							<table cellspacing="0" cellpadding="0" width="100%" border="0">
							  <tbody>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>mensajeria/mira.php" >&nbsp;&nbsp;Mensajer�a</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>agenda/lista_agenda.php?sw=1" >&nbsp;&nbsp;Agenda</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
								<tr>
								  <td width="90%" class="cajamenu2"><a href="<? echo $c; ?>fichas/diario/ListadoNoticias.php" >&nbsp;&nbsp;Diario Mural</a></td>
								</tr>
								<tr>
								  <td colspan="2" height="1"><img  src="" width="100" height="1" /></td>
								</tr>
							  </tbody>
						  </table>
                        </span>
					</td>
				 </tr>	
	    </div>
				<!--/div-->	
				
				
			
		
		<tr>
           <td align="left" valign="top" class="cajamenu"><div align="left"><a href="<? echo $c ?>solicitud2/index.php" target="_self">Soporte</a></div></td>
        </tr>			
					
		    <tr>
           <td align="left" valign="top" class="cajamenu">		     <a href="<? echo $c ?>menu/salida.php">Salir</a></td>
         </tr>
     </table></td>
   </tr>
 </table>
 <? }?>
 
 
 
