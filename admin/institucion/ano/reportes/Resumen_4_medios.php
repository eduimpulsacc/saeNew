<?php require('../../../../util/header.inc');
//setlocale(LC_ALL,"es_ES");
$whe_conceptos=	"and promedio not in ('I','S','B','MB')";

function imprime_arreglo($arreglo){
echo "<pre>";
print_r($arreglo);
echo "</pre>";

}
$query_ins_ano="select rdb,dig_rdb, nombre_instit from institucion as ins, ano_escolar as ano where ins.rdb='$_INSTIT' and  ano.id_ano='$_ANO'"; //revisar
$row_ano=pg_fetch_array(pg_exec($conn,$query_ins_ano));

//$nro_ano = $row_ano['nro_ano'];
///////////////////
$institucion = $_INSTIT;
$ano		 = $_ANO;
$curso       = $cmb_curso;


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
table{font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:9px;
}
td{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:10px;
	font-style: normal;
	font-weight: normal;
}
.conscroll {
overflow: auto;
width: 500px;
height: 400px;
clear:both;
} 
.salto{
page-break-after:always;
}
.Estilo1 {font-size: 10px}
-->
    </style>
	
<SCRIPT language="JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function window_open(url,ancho,alto){
var opciones="left=100,top=100,width="+ancho+",height="+alto+",scrollbars=yes,resizable=yes,status=yes", i= 0;
 window.open(url,"aa",opciones); 
 }

//-->
</script>

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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
       function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../seteaAno.php3?caso=10&pa=14&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }


</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')"  >

 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3; 
						include("../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  <?
								  if (isset($cb_ok)){  ?>
								  
                                   <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                      <tr>
                                        <td colspan="4"><div align="right">
                                          <label></label>
                                          <label>
                                          <input name="Submit" type="button" onClick="MM_openBrWindow('printResumen_4_medios.php?curso=<?=$curso ?>','','resizable=yes,width=600,height=500')" value="Imprimir" class="botonXX">
                                          </label>
                                        </div></td>
                                      </tr>
									  <?
										$Curso_pal = CursoPalabra($curso, 1, $conn);
									  ?>
                                      <tr>
                                        <td colspan="4"><div align="center">Curso: <?=$Curso_pal ?></div></td>
                                      </tr>
                                      <tr>
                                        <td width="20%"><div align="left">Rut</div></td>
                                        <td width="60%"><div align="left">Nombre</div></td>
                                        <td width="10%"><div align="center">Suma</div></td>
                                        <td width="10%"><div align="center">Cantidad</div></td>
                                      </tr>
									  <?
									  $qry="SELECT matricula.bool_ar, alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$_ANO.")) and bool_ar='0'  order by nro_lista asc, ape_pat, ape_mat, nombre_alu asc ";
				                      $result =@pg_Exec($conn,$qry);
									  $num_res = @pg_numrows($result);
									  for ($j = 0; $j < $num_res; $j++){								  
											$fil_res = pg_fetch_array($result,$j);
											$nombre_alu = $fil_res['nombre_alu'];
											$ape_pat    = $fil_res['ape_pat'];
											$ape_mat    = $fil_res['ape_mat'];
											$rut_alumno = $fil_res['rut_alumno'];
											$dig_rut    = $fil_res['dig_rut'];
											  
											///// AQUI DEJAR EN UN ARREGLO TODOS LOS SUBSECTORES DEL ALUMNO EN LA ENSEÑANZA MEDIA ////
										  
											$query_matricula="select * from matricula as mat, ano_escolar as ano, curso as curso  where mat.rut_alumno='$rut_alumno' and mat.id_ano=ano.id_ano and curso.id_curso=mat.id_curso and mat.bool_ar = '0' and mat.id_ano in (select id_ano from promocion where rut_alumno = '$rut_alumno' and situacion_final <> '2') order by ano.nro_ano Desc";
														
											$result_matricula=pg_exec($conn,$query_matricula);
											$num_matricula=pg_numrows($result_matricula);
											for ($i=0;$i<$num_matricula;$i++){
												$row_matricula=pg_fetch_array($result_matricula);
												$curso_grado=$row_matricula[grado_curso];
												//imprime_arreglo($row_matricula);
												$anos_id[$curso_grado]=$row_matricula[id_ano];
												$grado_curso[$curso_grado]=$row_matricula[grado_curso];
												$nro_ano[$curso_grado]=$row_matricula[nro_ano];
												$aproxima[$curso_grado]=$row_matricula[truncado_per];
												$curso_id[$curso_grado]=$row_matricula[id_curso];
												$origen[$curso_grado]=1;
												
												$query_tiene="select * from ramo r inner join tiene".$row_matricula[nro_ano]." t on t.id_ramo=r.id_ramo inner join subsector s on s.cod_subsector=r.cod_subsector inner join curso c on c.id_curso=r.id_curso where r.bool_ip = '1' and t.rut_alumno=".$rut_alumno." and (c.ensenanza>300 ) order by r.id_orden";
															
												$result_tiene=@pg_exec($conn,$query_tiene);
												$num_tiene=@pg_numrows($result_tiene);
												for ($s=0;$s<$num_tiene;$s++){
													$row_tiene=@pg_fetch_array($result_tiene);
													if (@!in_array($row_tiene[cod_subsector],$cod_subsector)){
														$ramo_id[]=$row_tiene[id_ramo];
														$ramo_nombre[]=$row_tiene[nombre];
														$ramo_modo_eval[]=$row_tiene[modo_eval];
														$cod_subsector[]=$row_tiene[cod_subsector];
														$cod_subsector_new[]=$row_tiene[id_orden];
														$ramo_subobli[]=$row_tiene[sub_obli];
													}
												}						
												
											}
										
											///consulta_por datos ingresados en la tabla_concentracion_notas
											$query_mat2="select * from concentracion_notas where rut_alumno='$rut_alumno'";
											$result_mat2=pg_exec($conn,$query_mat2);
											$num_mat2=pg_numrows($result_mat2);
											for ($i=0;$i<$num_mat2;$i++){
												$row_mat2=pg_fetch_array($result_mat2);
												$curso_grado=$row_mat2[curso];
												$anos_id[$curso_grado]=$row_mat2[id_ano];
												$grado_curso[$curso_grado]=$row_mat2[curso];
												$origen[$curso_grado]=2;
										
												////////////////////////////////
												$contador_acumulado = 0;
												$contador_religion = 0;
												$acumulo_promedio = 0;		
												////////////////////////////////
												$query_detalle="select * from concentracion_detalle where rut_alumno='$rut_alumno' and  curso=$row_mat2[curso]";
												$result_detalle=pg_exec($conn,$query_detalle);
												$num_detalle=pg_numrows($result_detalle);
												for ($ff=0;$ff<$num_detalle;$ff++){
												   $row_detalle=pg_fetch_array($result_detalle);
												   if (!in_array($row_detalle[subsector],$cod_subsector)){
													  $cod_subsector[]=$row_detalle[subsector];
													  $query_ram="select * from subsector where cod_subsector='$row_detalle[subsector]'";
													  $result_ram=pg_exec($conn,$query_ram);
													  $num_ram=pg_numrows($result_ram);
													  if ($num_ram>0){			
														  $row_ram=pg_fetch_array($result_ram);
														  $ramo_nombre[]=$row_ram[nombre];
													  }			
												   }
												}
										   }
										  /// aqui recorro los subsectores por año
										  for ($i=0;$i<count($cod_subsector);$i++){		 
										      if ($curso_id[1]){
							                      if ($origen[1]==1){
				                                      $query_saca_ramo="select * from curso,ramo where ramo.cod_subsector='$cod_subsector[$i]' and ramo.id_curso=curso.id_curso  and curso.ensenanza > 300 and $curso_id[1]=curso.id_curso" ;
											          $result_saca_ramo=pg_exec($conn,$query_saca_ramo);
				                                      $num_saca_num=pg_numrows($result_saca_ramo);
				                                      if ($num_saca_num>0){
					                                      $row_saca_ramo=pg_fetch_array($result_saca_ramo);
								                          if ($row_saca_ramo[conex]==2){
						                                      $query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
											                  from notas$nro_ano[1] as notas 
											                  where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
												              $whe_conceptos
											                  group by rut_alumno";
								                              $result_prom=@pg_exec($conn,$query_prom);
								                              $num_prom=@pg_numrows($result_prom);
								                              if ($num_prom>0){
									                              $row_prom=pg_fetch_array($result_prom);
									                              $promedio=$row_prom[suma]/$row_prom[cantidad];
									                              $promedio=intval(aproximar_promedio($promedio,$aproxima[1]));
								                              }
					                                      }else{
						                                      $query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
											                  from notas$nro_ano[3] as notas 
											                  where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
												              $whe_conceptos
											                  group by rut_alumno";
						                                      $query_situacion="select * from situacion_final where  rut_alumno='$rut_alumno' and id_ramo='$row_saca_ramo[id_ramo]'";
						                                      $result_situacion=pg_exec($conn,$query_situacion);
						                                      $num_situacion=pg_numrows($result_situacion);
						                                      if ($num_situacion>0){
							                                     $row_situacion=pg_fetch_array($result_situacion);
							                                     $promedio=$row_situacion[nota_final];
						                                      }
					                                      }
				                                      }
												  }	  
			                                  }		
		
			                                  if (($row_saca_ramo[modo_eval]==2 || $row_saca_ramo[modo_eval]==3)&&($origen[1]==1)){
			     				                  if ($row_saca_ramo[modo_eval]==3){			
						                              ///////// nuevo código sacado del acta para calcular el promedio de RELIGION cuando modo de evaluacion es 3 //////////////
				 				                      $sql_notas_3 = "select nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14,nota15,nota16,nota17,nota18,nota19,nota20 from notas$nro_ano[1] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
					                                  $rsNotas_3=@pg_Exec($conn,$sql_notas_3);				
					                                  $con_notas = 0;
					                                  $prom=0;
					                                  $promedio_nota=0;
					                                  for($g=0 ; $g < @pg_numrows($rsNotas_3) ; $g++){
						                                $fNotas_3 = @pg_fetch_array($rsNotas_3,$g);
														if($fNotas_3['nota1']>0){
															$notas_1 = $fNotas_3['nota1'];	
															$con_notas=$con_notas+1;	
															$prom = $prom + $notas_1;
														}
														if($fNotas_3['nota2']>0){
															$notas_2 = $fNotas_3['nota2'];	
															$con_notas=$con_notas+1;	
															$prom = $prom + $notas_2;
														}
														if($fNotas_3['nota3']>0){
															$notas_3 = $fNotas_3['nota3'];	
															$con_notas=$con_notas+1;	
															$prom = $prom + $notas_3;
														}
														if($fNotas_3['nota4']>0){
															$notas_4 = $fNotas_3['nota4'];
																$con_notas=$con_notas+1;
															$prom = $prom + $notas_4;
														}
														if($fNotas_3['nota5']>0){
															$notas_5 = $fNotas_3['nota5'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_5;
														}
														if($fNotas_3['nota6']>0){
															$notas_6 = $fNotas_3['nota6'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_6;
														}
														if($fNotas_3['nota7']>0){
															$notas_7 = $fNotas_3['nota7'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_7;
														}
														if($fNotas_3['nota8']>0){
															$notas_8 = $fNotas_3['nota8'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_8;
								
														}
														if($fNotas_3['nota9']>0){
															$notas_9 = $fNotas_3['nota9'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_9;
														}
														if($fNotas_3['nota10']>0){
															$notas_10 = $fNotas_3['nota10'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_10;
														}
														if($fNotas_3['nota11']>0){
															$notas_11 = $fNotas_3['nota11'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_11;
														}
														if($fNotas_3['nota12']>0){
															$notas_12 = $fNotas_3['nota12'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_12;
														}
														if($fNotas_3['nota13']>0){
															$notas_13 = $fNotas_3['nota13'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_13;
														}
														if($fNotas_3['nota14']>0){
															$notas_14 = $fNotas_3['nota14'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_14;
														}
														if($fNotas_3['nota15']>0){
															$notas_15 = $fNotas_3['nota15'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_15;
														}
														if($fNotas_3['nota16']>0){
															$notas_16 = $fNotas_3['nota16'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_16;
														}
														if($fNotas_3['nota17']>0){
															$notas_17 = $fNotas_3['nota17'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_17;
														}
														if($fNotas_3['nota18']>0){
															$notas_18 = $fNotas_3['nota18'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_18;
														}
														if($fNotas_3['nota19']>0){
															$notas_19 = $fNotas_3['nota19'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_19;
														}
														if($fNotas_3['nota20']>0){
															$notas_20 = $fNotas_3['nota20'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_20;
														}						
													 }		
							
					                                 /// nuevo código para sacar el promedio correcto de religion 
						                             $sql_1 = "select promedio from notas$nro_ano[1] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
						                             $res_1 = @pg_Exec($conn,$sql_1);
						                             $num_1 = @pg_numrows($res_1);
						                             $contador_promedios = 0;
						                             $promedio_num=0;
											
						                             for ($ii=0; $ii < $num_1; $ii++){
						                                $fil_1 = @pg_fetch_array($res_1,$ii);
							                            $prom_per = $fil_1['promedio'];
														if (trim($prom_per)=="0"){
							                                 /// nada								 
							                            }else{
							                                 // aumento contador
								                             $contador_promedios++;
							                            }										
							                            $prom_per = Conceptual($prom_per,2);							
							                            $promedio_num = $promedio_num + $prom_per;									
						                             }										
												
						                              $promedio_ramo = Promediar($promedio_num,$contador_promedios,0);							    
													  /// como es modo de evaluacion 3 debo convertir el promedio a conceptual
						                              if ($promedio_ramo > 0 and $promedio_ramo < 40){
														 $promedio = "I";
													  }
													  if ($promedio_ramo > 39 and $promedio_ramo < 50){
														 $promedio = "S";
													  }
												      if ($promedio_ramo > 49 and $promedio_ramo < 60){
														 $promedio = "B";
													  }
													  if ($promedio_ramo > 59 ){
														 $promedio = "MB";
													  }
													  $promedio_ramo = NULL;
													 ////////////  fin nuevo código ///////////////////	 
											     }else{	
										
													 $arreglo_concep=NULL;
													 $query_concep="select * from notas$nro_ano[1] where id_ramo=$row_saca_ramo[id_ramo] and rut_alumno='$rut_alumno'";
													 $result_concep=pg_exec($conn,$query_concep);
													 $num_concep=pg_numrows($result_concep);
													 for ($c=0;$c<$num_concep;$c++){
														$row_concep=pg_fetch_array($result_concep);
														$arreglo_concep[]=$row_concep[promedio]	;
													 }
													 $promedio=promediar_conceptos($arreglo_concep);
												 }		
										     }																			 
		
											 if ($origen[1]==2){
											     $query_detalle="select * from concentracion_detalle where rut_alumno='$rut_alumno' and  curso=1 and subsector=$cod_subsector[$i]";
												 $result_detalle=pg_exec($conn,$query_detalle);
												 $num_detalle=pg_numrows($result_detalle);
												 if ($num_detalle){
													  $row_detalle=pg_fetch_array($result_detalle);
													  $promedio=$row_detalle[promedio];
													  $religion=$row_detalle[religion];
												 }
										   	 }											 
											
											
						
											 if ($promedio!=NULL and $religion==NULL){
												  $acumulo_promedio = $acumulo_promedio + $promedio;
												  if ($promedio!=NULL and $promedio!=0){
													  $contador_acumulado++;
												  }	
											 }	
											 
											 
											 $promedio=NULL;
											 $row_saca_ramo[modo_eval]=NULL;
											 
											 if ($curso_id[2]){												 
											     if ($origen[2]==1){
												     $query_saca_ramo="select * from curso,ramo where ramo.cod_subsector='$cod_subsector[$i]' and ramo.id_curso=curso.id_curso  and curso.ensenanza>300 and $curso_id[2]=curso.id_curso" ;
												     $result_saca_ramo=pg_exec($conn,$query_saca_ramo);
												     $num_saca_num=pg_numrows($result_saca_ramo);
													 if ($num_saca_num>0){
														$row_saca_ramo=pg_fetch_array($result_saca_ramo);
														if ($row_saca_ramo[conex]==2){
															$query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
																				from notas$nro_ano[2] as notas 
																				where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
																					$whe_conceptos
																				group by rut_alumno";
															$result_prom=@pg_exec($conn,$query_prom);
															$num_prom=@pg_numrows($result_prom);
															if ($num_prom>0){
																$row_prom=pg_fetch_array($result_prom);
																$promedio=$row_prom[suma]/$row_prom[cantidad];
																$promedio=intval(aproximar_promedio($promedio,$aproxima[2]));
															}
														}else{
															$query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
																				from notas$nro_ano[2] as notas 
																				where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
																					$whe_conceptos
																				group by rut_alumno";
															 $query_situacion="select * from situacion_final where  rut_alumno='$rut_alumno' and id_ramo='$row_saca_ramo[id_ramo]'";
															// echo "<br>$query_situacion<br>";
															$result_situacion=pg_exec($conn,$query_situacion);
															$num_situacion=pg_numrows($result_situacion);
															if ($num_situacion>0){
																$row_situacion=pg_fetch_array($result_situacion);
																$promedio=$row_situacion[nota_final];
															}
														}
													}
												}
											}
		
		
											if (($row_saca_ramo[modo_eval]==2 || $row_saca_ramo[modo_eval]==3)&&($origen[2]==1)){
												 if ($row_saca_ramo[modo_eval]==3){		       
						    				        $sql_notas_3 = "select nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14,nota15,nota16,nota17,nota18,nota19,nota20 from notas$nro_ano[2] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
													$rsNotas_3=@pg_Exec($conn,$sql_notas_3);				
													$con_notas = 0;
													$prom=0;
													$promedio_nota=0;
													for($g=0 ; $g < @pg_numrows($rsNotas_3) ; $g++){
														$fNotas_3 = @pg_fetch_array($rsNotas_3,$g);
														if($fNotas_3['nota1']>0){
															$notas_1 = $fNotas_3['nota1'];	
															$con_notas=$con_notas+1;	
															$prom = $prom + $notas_1;
														}
														if($fNotas_3['nota2']>0){
															$notas_2 = $fNotas_3['nota2'];	
															$con_notas=$con_notas+1;	
															$prom = $prom + $notas_2;
														}
														if($fNotas_3['nota3']>0){
															$notas_3 = $fNotas_3['nota3'];	
															$con_notas=$con_notas+1;	
															$prom = $prom + $notas_3;
														}
														if($fNotas_3['nota4']>0){
															$notas_4 = $fNotas_3['nota4'];
																$con_notas=$con_notas+1;
															$prom = $prom + $notas_4;
														}
														if($fNotas_3['nota5']>0){
															$notas_5 = $fNotas_3['nota5'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_5;
														}
														if($fNotas_3['nota6']>0){
															$notas_6 = $fNotas_3['nota6'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_6;
														}
														if($fNotas_3['nota7']>0){
															$notas_7 = $fNotas_3['nota7'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_7;
														}
														if($fNotas_3['nota8']>0){
															$notas_8 = $fNotas_3['nota8'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_8;
														}
														if($fNotas_3['nota9']>0){
															$notas_9 = $fNotas_3['nota9'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_9;
														}
														if($fNotas_3['nota10']>0){
															$notas_10 = $fNotas_3['nota10'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_10;
														}
														if($fNotas_3['nota11']>0){
															$notas_11 = $fNotas_3['nota11'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_11;
														}
														if($fNotas_3['nota12']>0){
															$notas_12 = $fNotas_3['nota12'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_12;
														}
														if($fNotas_3['nota13']>0){
															$notas_13 = $fNotas_3['nota13'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_13;
														}
														if($fNotas_3['nota14']>0){
															$notas_14 = $fNotas_3['nota14'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_14;
														}
														if($fNotas_3['nota15']>0){
															$notas_15 = $fNotas_3['nota15'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_15;
														}
														if($fNotas_3['nota16']>0){
															$notas_16 = $fNotas_3['nota16'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_16;
														}
														if($fNotas_3['nota17']>0){
															$notas_17 = $fNotas_3['nota17'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_17;
														}
														if($fNotas_3['nota18']>0){
															$notas_18 = $fNotas_3['nota18'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_18;
														}
														if($fNotas_3['nota19']>0){
															$notas_19 = $fNotas_3['nota19'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_19;
														}
														if($fNotas_3['nota20']>0){
															$notas_20 = $fNotas_3['nota20'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_20;
														}														
													}		
							
													/// nuevo código para sacar el promedio correcto de religion 
													$sql_1 = "select promedio, nota1 from notas$nro_ano[2] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
													$res_1 = @pg_Exec($conn,$sql_1);
													$num_1 = @pg_numrows($res_1);
													$contador_promedios = 0;
													$promedio_num=0;
											
													for ($ii=0; $ii < $num_1; $ii++){
														$fil_1 = @pg_fetch_array($res_1,$ii);
														$prom_per = $fil_1['promedio'];
														
														if (trim($prom_per)=="0"){
															/// nada	
																						 
														}else{
															 // aumento contador
															 
															 $contador_promedios++;
														}										
														$prom_per = Conceptual($prom_per,2);							
														$promedio_num = $promedio_num + $prom_per;									
													}										
												
													$promedio_ramo = Promediar($promedio_num,$contador_promedios,0);							    
												
				  
													/// como es modo de evaluacion 3 debo convertir el promedio a conceptual
													if ($promedio_ramo > 0 and $promedio_ramo < 40){
														$promedio = "I";
													}
													if ($promedio_ramo > 39 and $promedio_ramo < 50){
														$promedio = "S";
													}
													if ($promedio_ramo > 49 and $promedio_ramo < 60){
														$promedio = "B";
													}
													if ($promedio_ramo > 59 ){
														$promedio = "MB";
													}
																			
													$promedio_ramo = NULL;
												    ////////////  fin nuevo código ///////////////////	
					 					 
												}else{		   		
							
													$arreglo_concep=NULL;
													$query_concep="select * from notas$nro_ano[2] where id_ramo=$row_saca_ramo[id_ramo] and rut_alumno='$rut_alumno'";
													$result_concep=pg_exec($conn,$query_concep);
													$num_concep=pg_numrows($result_concep);
													for ($c=0;$c<$num_concep;$c++){
														$row_concep=pg_fetch_array($result_concep);
														$arreglo_concep[]=$row_concep[promedio]	;
													}
													$promedio=promediar_conceptos($arreglo_concep);
			  									}		
											}
		
											if ($origen[2]==2){
												$query_detalle="select * from concentracion_detalle where rut_alumno='$rut_alumno' and  curso=2 and subsector=$cod_subsector[$i]";
												$result_detalle=pg_exec($conn,$query_detalle);
												$num_detalle=pg_numrows($result_detalle);
												if ($num_detalle){
													$row_detalle=pg_fetch_array($result_detalle);
													$promedio=$row_detalle[promedio];
													$religion=$row_detalle[religion];
												}
											}
		
													
			
											if ($promedio!=NULL and $religion==NULL){
												$acumulo_promedio = $acumulo_promedio + $promedio;
												if ($promedio!=NULL and $promedio!=0){
													$contador_acumulado++;
												}
											}
											
											$promedio=NULL;
											$row_saca_ramo[modo_eval]=NULL;
			
											if ($curso_id[3]){
		    	
												if ($origen[3]==1){
													$query_saca_ramo="select * from curso,ramo where ramo.cod_subsector='$cod_subsector[$i]' and ramo.id_curso=curso.id_curso  and curso.ensenanza>300 and $curso_id[3]=curso.id_curso" ;
													$result_saca_ramo=pg_exec($conn,$query_saca_ramo);
													$num_saca_num=pg_numrows($result_saca_ramo);
													if ($num_saca_num>0){
														$row_saca_ramo=pg_fetch_array($result_saca_ramo);
														if ($row_saca_ramo[conex]==2){
															 $query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
															 from notas$nro_ano[3] as notas 
															 where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
																$whe_conceptos
															 group by rut_alumno";									
										
															$result_prom=@pg_exec($conn,$query_prom);
															$num_prom=@pg_numrows($result_prom);
															if ($num_prom>0){
																$row_prom=pg_fetch_array($result_prom);
																$promedio=$row_prom[suma]/$row_prom[cantidad];
																$promedio=intval(aproximar_promedio($promedio,$aproxima[3]));
															}
														}else{
						
															  $query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
																				from notas$nro_ano[3] as notas 
																				where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
																					$whe_conceptos
																				group by rut_alumno";
															  $query_situacion="select * from situacion_final where  rut_alumno='$rut_alumno' and id_ramo='$row_saca_ramo[id_ramo]'";
															  $result_situacion=pg_exec($conn,$query_situacion);
															  $num_situacion=pg_numrows($result_situacion);
															  if ($num_situacion>0){
																  $row_situacion=pg_fetch_array($result_situacion);
																  $promedio=$row_situacion[nota_final];
															  }
														}
													}
												}
										    }
		
											if (($row_saca_ramo[modo_eval]==2 || $row_saca_ramo[modo_eval]==3)&&($origen[3]==1)){
												if ($row_saca_ramo[modo_eval]==3){			
												    ///////// nuevo código sacado del acta para calcular el promedio de RELIGION cuando modo de evaluacion es 3 //////////////
													$sql_notas_3 = "select nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14,nota15,nota16,nota17,nota18,nota19,nota20 from notas$nro_ano[3] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
													$rsNotas_3=@pg_Exec($conn,$sql_notas_3);				
													$con_notas = 0;
													$prom=0;
													$promedio_nota=0;
													for($g=0 ; $g < @pg_numrows($rsNotas_3) ; $g++){
														$fNotas_3 = @pg_fetch_array($rsNotas_3,$g);
														if($fNotas_3['nota1']>0){
															$notas_1 = $fNotas_3['nota1'];	
															$con_notas=$con_notas+1;	
															$prom = $prom + $notas_1;
														}
														if($fNotas_3['nota2']>0){
															$notas_2 = $fNotas_3['nota2'];	
															$con_notas=$con_notas+1;	
															$prom = $prom + $notas_2;
														}
														if($fNotas_3['nota3']>0){
															$notas_3 = $fNotas_3['nota3'];	
															$con_notas=$con_notas+1;	
															$prom = $prom + $notas_3;
														}
														if($fNotas_3['nota4']>0){
															$notas_4 = $fNotas_3['nota4'];
																$con_notas=$con_notas+1;
															$prom = $prom + $notas_4;
														}
														if($fNotas_3['nota5']>0){
															$notas_5 = $fNotas_3['nota5'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_5;
														}
														if($fNotas_3['nota6']>0){
															$notas_6 = $fNotas_3['nota6'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_6;
														}
														if($fNotas_3['nota7']>0){
															$notas_7 = $fNotas_3['nota7'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_7;
														}
														if($fNotas_3['nota8']>0){
															$notas_8 = $fNotas_3['nota8'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_8;
														}
														if($fNotas_3['nota9']>0){
															$notas_9 = $fNotas_3['nota9'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_9;
														}
														if($fNotas_3['nota10']>0){
															$notas_10 = $fNotas_3['nota10'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_10;
														}
														if($fNotas_3['nota11']>0){
															$notas_11 = $fNotas_3['nota11'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_11;
														}
														if($fNotas_3['nota12']>0){
															$notas_12 = $fNotas_3['nota12'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_12;
														}
														if($fNotas_3['nota13']>0){
															$notas_13 = $fNotas_3['nota13'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_13;
														}
														if($fNotas_3['nota14']>0){
															$notas_14 = $fNotas_3['nota14'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_14;
														}
														if($fNotas_3['nota15']>0){
															$notas_15 = $fNotas_3['nota15'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_15;
														}
														if($fNotas_3['nota16']>0){
															$notas_16 = $fNotas_3['nota16'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_16;
														}
														if($fNotas_3['nota17']>0){
															$notas_17 = $fNotas_3['nota17'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_17;
														}
														if($fNotas_3['nota18']>0){
															$notas_18 = $fNotas_3['nota18'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_18;
														}
														if($fNotas_3['nota19']>0){
															$notas_19 = $fNotas_3['nota19'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_19;
														}
														if($fNotas_3['nota20']>0){
															$notas_20 = $fNotas_3['nota20'];
																$con_notas=$con_notas+1;	
															$prom = $prom + $notas_20;
														}						
													}		
							
													/// nuevo código para sacar el promedio correcto de religion 
													$sql_1 = "select promedio from notas$nro_ano[3] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
													$res_1 = @pg_Exec($conn,$sql_1);
													$num_1 = @pg_numrows($res_1);
													$contador_promedios = 0;
											
													for ($ii=0; $ii < $num_1; $ii++){
														$fil_1 = @pg_fetch_array($res_1,$ii);
														$prom_per = $fil_1['promedio'];														
														if (trim($prom_per)=="0"){
															/// nada								 
														}else{
															 // aumento contador
															 $contador_promedios++;
														}										
														$prom_per = Conceptual($prom_per,2);							
														$promedio_num = $promedio_num + $prom_per;									
													}										
												
													$promedio_ramo = Promediar($promedio_num,$contador_promedios,0);							    
												
				  
													/// como es modo de evaluacion 3 debo convertir el promedio a conceptual
													if ($promedio_ramo > 0 and $promedio_ramo < 40){
														$promedio = "I";
													}
													if ($promedio_ramo > 39 and $promedio_ramo < 50){
														$promedio = "S";
													}
													if ($promedio_ramo > 49 and $promedio_ramo < 60){
														$promedio = "B";
													}
													if ($promedio_ramo > 59 ){
														$promedio = "MB";
													}
												    ////////////  fin nuevo código ///////////////////			 
					 
												}else{			    
													$arreglo_concep=NULL;
													$query_concep="select * from notas$nro_ano[3] where id_ramo=$row_saca_ramo[id_ramo] and rut_alumno='$rut_alumno'";
													$result_concep=pg_exec($conn,$query_concep);
													$num_concep=pg_numrows($result_concep);
													for ($c=0;$c<$num_concep;$c++){
														$row_concep=pg_fetch_array($result_concep);
														$arreglo_concep[]=$row_concep[promedio]	;
													}
													$promedio=promediar_conceptos($arreglo_concep);
												}	
										   }
			
										   if ($origen[3]==2){
												$query_detalle="select * from concentracion_detalle where rut_alumno='".trim($rut_alumno)."' and  curso=3 and subsector='".trim($cod_subsector[$i])."'";
												$result_detalle=pg_exec($conn,$query_detalle);
												$num_detalle=pg_numrows($result_detalle);
												if ($num_detalle){
													$row_detalle=pg_fetch_array($result_detalle);
													$promedio=$row_detalle[promedio];
													$religion=$row_detalle[religion];
												}
										   }
		
										  		
			
										   if ($promedio!=NULL and $religion==NULL){
												$acumulo_promedio = $acumulo_promedio + $promedio;
												if ($promedio!=NULL and $promedio!=0){
													$contador_acumulado++;
												}
										   }
										   
														
										   $promedio=NULL;
										   $row_saca_ramo[modo_eval]=NULL;
			
										   if ($curso_id[4]){ 
			    	  
											  if ($origen[4]==1){
												  $query_saca_ramo="select * from curso,ramo where ramo.cod_subsector='$cod_subsector[$i]' and ramo.id_curso=curso.id_curso  and curso.ensenanza>300 and $curso_id[4]=curso.id_curso" ;
												  $result_saca_ramo=pg_exec($conn,$query_saca_ramo);
												  $num_saca_num=pg_numrows($result_saca_ramo);
												  if ($num_saca_num>0){
				                                      $row_saca_ramo=pg_fetch_array($result_saca_ramo);
				                                      if ($row_saca_ramo[conex]==2){
														  $query_prom="select rut_alumno,sum(to_number(promedio,'000000000000000')) as suma,count(rut_alumno) as cantidad 
														  from notas$nro_ano[4] as notas 
														  where id_ramo='$row_saca_ramo[id_ramo]' and promedio<>'0' and rut_alumno='$rut_alumno'
															$whe_conceptos
														  group by rut_alumno";										
							
														  $result_prom=@pg_exec($conn,$query_prom);
														  $num_prom=@pg_numrows($result_prom);
														  if ($num_prom>0){
															  $row_prom=pg_fetch_array($result_prom);
															  $promedio=$row_prom[suma]/$row_prom[cantidad];
															  $promedio=intval(aproximar_promedio($promedio,$aproxima[4]));
														  }
														 
				                                      }else{
													      $query_situacion="select * from situacion_final where  rut_alumno='$rut_alumno' and id_ramo='$row_saca_ramo[id_ramo]'";
													      $result_situacion=pg_exec($conn,$query_situacion);
													      $num_situacion=pg_numrows($result_situacion);
													      if ($num_situacion>0){
														      $row_situacion=pg_fetch_array($result_situacion);
														      $promedio=$row_situacion[nota_final];
														      if ($_INSTIT==9566){
															      if ($cod_subsector[$i]==13){
																     $promedio = Conceptual($promedio , 1);					 
															      }	  
														      }
													      }
				                                      }
												  }	  
											  }
										   }
		
	
										   if($num_saca_num!=""){
											   if (($row_saca_ramo[modo_eval]==2 || $row_saca_ramo[modo_eval]==3)&&($origen[4]==1)){
												   if ($row_saca_ramo[modo_eval]==3){			
													   ///////// nuevo código sacado del acta para calcular el promedio de RELIGION cuando modo de evaluacion es 3 //////////////				 
													   $sql_notas_3 = "select nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14,nota15,nota16,nota17,nota18,nota19,nota20 from notas$nro_ano[4] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
													   $rsNotas_3=@pg_Exec($conn,$sql_notas_3);				
													   $con_notas = 0;
													   $prom=0;
													   $promedio_nota=0;
													   for($g=0 ; $g < @pg_numrows($rsNotas_3) ; $g++){
															$fNotas_3 = @pg_fetch_array($rsNotas_3,$g);
															if($fNotas_3['nota1']>0){
																$notas_1 = $fNotas_3['nota1'];	
																$con_notas=$con_notas+1;	
																$prom = $prom + $notas_1;
															}
															if($fNotas_3['nota2']>0){
																$notas_2 = $fNotas_3['nota2'];	
																$con_notas=$con_notas+1;	
																$prom = $prom + $notas_2;
															}
															if($fNotas_3['nota3']>0){
																$notas_3 = $fNotas_3['nota3'];	
																$con_notas=$con_notas+1;	
																$prom = $prom + $notas_3;
															}
															if($fNotas_3['nota4']>0){
																$notas_4 = $fNotas_3['nota4'];
																	$con_notas=$con_notas+1;
																$prom = $prom + $notas_4;
															}
															if($fNotas_3['nota5']>0){
																$notas_5 = $fNotas_3['nota5'];
																	$con_notas=$con_notas+1;	
																$prom = $prom + $notas_5;
															}
															if($fNotas_3['nota6']>0){
																$notas_6 = $fNotas_3['nota6'];
																	$con_notas=$con_notas+1;	
																$prom = $prom + $notas_6;
															}
															if($fNotas_3['nota7']>0){
																$notas_7 = $fNotas_3['nota7'];
																	$con_notas=$con_notas+1;	
																$prom = $prom + $notas_7;
															}
															if($fNotas_3['nota8']>0){
																$notas_8 = $fNotas_3['nota8'];
																	$con_notas=$con_notas+1;	
																$prom = $prom + $notas_8;
															}
															if($fNotas_3['nota9']>0){
																$notas_9 = $fNotas_3['nota9'];
																	$con_notas=$con_notas+1;	
																$prom = $prom + $notas_9;
															}
															if($fNotas_3['nota10']>0){
																$notas_10 = $fNotas_3['nota10'];
																	$con_notas=$con_notas+1;	
																$prom = $prom + $notas_10;
															}
															if($fNotas_3['nota11']>0){
																$notas_11 = $fNotas_3['nota11'];
																	$con_notas=$con_notas+1;	
																$prom = $prom + $notas_11;
															}
															if($fNotas_3['nota12']>0){
																$notas_12 = $fNotas_3['nota12'];
																	$con_notas=$con_notas+1;	
																$prom = $prom + $notas_12;
															}
															if($fNotas_3['nota13']>0){
																$notas_13 = $fNotas_3['nota13'];
																	$con_notas=$con_notas+1;	
																$prom = $prom + $notas_13;
															}
															if($fNotas_3['nota14']>0){
																$notas_14 = $fNotas_3['nota14'];
																	$con_notas=$con_notas+1;	
																$prom = $prom + $notas_14;
															}
															if($fNotas_3['nota15']>0){
																$notas_15 = $fNotas_3['nota15'];
																	$con_notas=$con_notas+1;	
																$prom = $prom + $notas_15;
															}
															if($fNotas_3['nota16']>0){
																$notas_16 = $fNotas_3['nota16'];
																	$con_notas=$con_notas+1;	
																$prom = $prom + $notas_16;
															}
															if($fNotas_3['nota17']>0){
																$notas_17 = $fNotas_3['nota17'];
																	$con_notas=$con_notas+1;	
																$prom = $prom + $notas_17;
															}
															if($fNotas_3['nota18']>0){
																$notas_18 = $fNotas_3['nota18'];
																	$con_notas=$con_notas+1;	
																$prom = $prom + $notas_18;
															}
															if($fNotas_3['nota19']>0){
																$notas_19 = $fNotas_3['nota19'];
																	$con_notas=$con_notas+1;	
																$prom = $prom + $notas_19;
															}
															if($fNotas_3['nota20']>0){
																$notas_20 = $fNotas_3['nota20'];
																	$con_notas=$con_notas+1;	
																$prom = $prom + $notas_20;
															}						
													    }		
							
														/// nuevo código para sacar el promedio correcto de religion 
														$sql_1 = "select promedio from notas$nro_ano[4] where rut_alumno = ".$rut_alumno." and id_ramo = '$row_saca_ramo[id_ramo]'";
														$res_1 = @pg_Exec($conn,$sql_1);
														$num_1 = @pg_numrows($res_1);
														$contador_promedios = 0;
														$promedio_num=0;
																			
														for ($ii=0; $ii < $num_1; $ii++){
															$fil_1 = @pg_fetch_array($res_1,$ii);
															$prom_per = $fil_1['promedio'];
															
															if (trim($prom_per)=="0"){
																/// nada								 
															}else{
																 // aumento contador
																 $contador_promedios++;
															}										
															$prom_per = Conceptual($prom_per,2);							
															$promedio_num = $promedio_num + $prom_per;									
														}										
												
														$promedio_ramo = Promediar($promedio_num,$contador_promedios,0);							    
												
														if ($promedio_ramo > 0 and $promedio_ramo < 40){
																$promedio = "I";
														}
														if ($promedio_ramo > 39 and $promedio_ramo < 50){
															$promedio = "S";
														}
														if ($promedio_ramo > 49 and $promedio_ramo < 60){
															$promedio = "B";
														}
														if ($promedio_ramo > 59 ){
															$promedio = "MB";
														}
																					
														$promedio_ramo = NULL;
														////////////  fin nuevo código ///////////////////					 
					 
													}else{	
														$arreglo_concep=NULL;
														$query_concep="select * from notas$nro_ano[4] where id_ramo=$row_saca_ramo[id_ramo] and rut_alumno='$rut_alumno'";
														$result_concep=pg_exec($conn,$query_concep);
															
														$num_concep=pg_numrows($result_concep);
														for ($c=0;$c<$num_concep;$c++){
															$row_concep=pg_fetch_array($result_concep);
															$arreglo_concep[]=$row_concep[promedio]	;
														}
														$promedio=promediar_conceptos($arreglo_concep);
												    }		
												}
											}		
											if ($origen[4]==2){
												$query_detalle="select * from concentracion_detalle where rut_alumno='$rut_alumno' and  curso=4 and subsector=$cod_subsector[$i]";
												$result_detalle=pg_exec($conn,$query_detalle);
												$num_detalle=pg_numrows($result_detalle);
												if ($num_detalle){
													$row_detalle=pg_fetch_array($result_detalle);
													$promedio=$row_detalle[promedio];
													$religion=$row_detalle[religion];
												}
											}
																					
											if ($promedio!=NULL and $religion==NULL){
												$acumulo_promedio = $acumulo_promedio + $promedio;
												if ($promedio!=NULL and $promedio!=0){
													$contador_acumulado++;
												}
											}			
						
											$promedio=NULL;
											$row_saca_ramo[modo_eval]=NULL;
									   
									   } //// fin for contador de subsectores	
									   
									   $contador_acumulado = ($contador_acumulado - $contador_religion);	
									  
									   ?>											  
									   <tr>
										<td><span class="Estilo1"><? echo "$rut_alumno-$dig_rut"; ?></span></td>
										<td><span class="Estilo1"><? echo "$ape_pat $ape_mat $nombre_alu"; ?></span></td>
										<td><div align="right" class="Estilo1"><? echo "$acumulo_promedio"; ?></div></td>
										<td><div align="right" class="Estilo1"><? echo "$contador_acumulado"; ?></div></td>
									   </tr>
									   <?
									   $acumulo_promedio = 0;
									   $contador_acumulado = 0;
									   $contador_religion = 0;
									   
									}  /// fin for contador de alumnos
									?>								  
                                   </table>
      							<? } 
								
								
								
								?>

<br>
<form method "post" action="Resumen_4_medios.php">
<? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) and curso.ensenanza > 300 and curso.grado_curso='4' ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = @pg_exec($conn,$sql_curso);

?>
<center>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" valign="top">
	  <table width="100%" height="43" border="0" cellpadding="0" cellspacing="0" class="textosimple">
  <tr>
    <td width=""  class="fondo">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
 	<tr class="textosimple">
	<td colspan="2" class="cuadro01"><br>
	  Curso<br>
	  <font size="1" face="arial, geneva, helvetica">
      <select name="cmb_curso"  class="ddlb_9_x" >
        <option value=0 selected>(Seleccione Curso)</option>
        <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){
			  $fila = @pg_fetch_array($resultado_query_cue,$i); 
			  $ensenanza = $fila['ensenanza'];
			  if ($fila["id_curso"]==$cmb_curso){
					$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
					echo "<option selected value=".$fila['id_curso'].">".$Curso_pal.$fila['id_curso']."</option>";
			  }else{
					$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
					echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
			  }
          } ?>
      </select>
      <br>
	  </font></td>
    </tr>
	
	<tr>
	  <td width="107" class="cuadro01">&nbsp;</td>
	  <td width="592"><input name="cb_ok" type="submit" class="botonXX"  id="cb_ok"  value="Buscar"></td>
	  </tr>
</table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form>

 								  								  
								  </td></tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2007</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>