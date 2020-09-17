<?include"../Coneccion/conexion.php"?>
<?
	$ls_institucion = $_GET["as_institucion"];
	$ls_alumno = $_GET["as_alumno"];
	$li_ano = $_GET["ai_ano"];
	//$tipo_ense = $_GET["ai_tipo_ense"];
	
	if ($ls_institucion=='')
		{
		$ls_institucion = 0;
		$ls_alumno = 0;
		$li_ano = 0;
		$tipo_ense = 0;
		}
	
	$ls_sql = "select distinct(alumno.rut_alumno), alumno.dig_rut, alumno.nombre_alu, ";
	$ls_sql = $ls_sql . " alumno.ape_pat,alumno.ape_mat, alumno.fecha_nac, alumno.email, alumno.sexo,  ";
	$ls_sql = $ls_sql . " curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, alumno.nacionalidad,  ";
	$ls_sql = $ls_sql . " matricula.fecha, alumno.telefono, matricula.num_mat, matricula.bool_baj as junaeb, ";
	$ls_sql = $ls_sql . " matricula.bool_bchs as chile_sol, matricula.bool_aoi as orig_indig,  ";
	$ls_sql = $ls_sql . " matricula.bool_rg as repi_grado, matricula.bool_ae as alumn_emb,  ";
	$ls_sql = $ls_sql . " matricula.bool_gd as grupo_dif, matricula.bool_i as integrado,matricula.bool_ar as alu_ret, ";
	$ls_sql = $ls_sql . " alumno.calle, alumno.nro, alumno.depto, alumno.block, alumno.villa, alumno.region,  ";
	$ls_sql = $ls_sql . " alumno.ciudad, alumno.comuna, region.nom_reg, provincia.nom_pro, comuna.nom_com, ";
	$ls_sql = $ls_sql . " institucion.nombre_instit from institucion, alumno, matricula,curso, tipo_ensenanza,   ";
	$ls_sql = $ls_sql . " ano_escolar, comuna, provincia, region ";
	$ls_sql = $ls_sql . " where institucion.rdb = matricula.rdb  ";
	$ls_sql = $ls_sql . " and alumno.rut_alumno = matricula.rut_alumno ";
	$ls_sql = $ls_sql . " and matricula.id_curso = curso.id_curso ";
	$ls_sql = $ls_sql . " and matricula.rdb = tipo_ense_inst.rdb ";
	$ls_sql = $ls_sql . " and curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$ls_sql = $ls_sql . " and matricula.id_ano = ano_escolar.id_ano ";
	$ls_sql = $ls_sql . " and comuna.cor_pro = provincia.cor_pro ";
	$ls_sql = $ls_sql . " and comuna.cod_reg = region.cod_reg ";
	$ls_sql = $ls_sql . " and provincia.cod_reg = region.cod_reg ";
	$ls_sql = $ls_sql . " and alumno.region = region.cod_reg ";
	$ls_sql = $ls_sql . " and alumno.ciudad = provincia.cor_pro ";
	$ls_sql = $ls_sql . " and alumno.comuna = comuna.cor_com ";
	$ls_sql = $ls_sql . " and institucion.rdb = $ls_institucion ";
	$ls_sql = $ls_sql . " and alumno.rut_alumno = $ls_alumno  ";
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano ;";
	//echo "$ls_sql";
	$resultado_query= pg_exec($conexion,$ls_sql);
	$total_filas= pg_numrows($resultado_query);
	

	$ls_sql = "select apoderado.rut_apo, apoderado.dig_rut, apoderado.nombre_apo, apoderado.ape_pat, ";
	$ls_sql = $ls_sql . " apoderado.ape_mat, apoderado.telefono, apoderado.email,  ";
	$ls_sql = $ls_sql . " apoderado.calle, apoderado.nro,  ";
	$ls_sql = $ls_sql . " apoderado.depto, apoderado.block, apoderado.villa,  ";
	$ls_sql = $ls_sql . " region.nom_reg, provincia.nom_pro, comuna.nom_com ";
	$ls_sql = $ls_sql . " from apoderado, tiene2, comuna, provincia, region  ";
	$ls_sql = $ls_sql . " where apoderado.rut_apo = tiene2.rut_apo ";
	$ls_sql = $ls_sql . " and tiene2.rut_alumno =  $ls_alumno ";
	$ls_sql = $ls_sql . " and tiene2.responsable = 1 ";
	$ls_sql = $ls_sql . " and comuna.cor_pro = provincia.cor_pro  ";
	$ls_sql = $ls_sql . " and comuna.cod_reg = region.cod_reg  ";
	$ls_sql = $ls_sql . " and provincia.cod_reg = region.cod_reg  ";
	$ls_sql = $ls_sql . " and apoderado.region = region.cod_reg  ";
	$ls_sql = $ls_sql . " and apoderado.ciudad = provincia.cor_pro  ";
	$ls_sql = $ls_sql . " and apoderado.comuna = comuna.cor_com ; ";

	$resultado_query_apo = pg_exec($conexion,$ls_sql);
	$total_filas_apo = pg_numrows($resultado_query_apo);


	pg_close($conexion);

?>
<html>
<head>
<title>Rpt09</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../css/objeto.css" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF">
<?
if ($total_filas>0){
?>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<table width="650" border="0" cellspacing="1" cellpadding="1" align="center">
  <tr>
    <td><div id="capa0"> 
        <input 
		name="cmdimprimiroriginal" 
		type="button" 
		class="cb_submit_9_x_75" 
		id="cmdimprimiroriginal" 
		onclick="imprimir();" 
		value="Imprimir">
      </div></td>
  </tr>
</table>
<table width="650" border="1" cellspacing="1" cellpadding="0" align="center">
  <tr> 
    <td> <table width="95%" border="0" cellspacing="1" cellpadding="1" align="center">
        <tr> 
          <td><b><font size="6" face="Verdana, Arial, Helvetica, sans-serif"><br>
            <?print Trim(pg_result($resultado_query, 0, 34));?> <br>
            <br>
            </font></b></td>
        </tr>
        <tr> 
          <td> <div align="center"><font size="4" face="Verdana, Arial, Helvetica, sans-serif">Ficha 
              del Alumno</font></div></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td> <br> <table width="95%" border="0" cellspacing="1" cellpadding="1" align="center">
        <tr> 
          <td class="textos" width="21%"><b>Rut Alumno</b></td>
          <td width="25%" class="textos"> <?print Trim(pg_result($resultado_query, 0, 0));?> 
            <?print Trim(pg_result($resultado_query, 0, 1));?> </td>
          <td class="textos" width="21%"><b>Nombre Alumno</b></td>
          <td width="33%" class="textos"> <?print Trim(pg_result($resultado_query, 0, 2));?> 
            <?print Trim(pg_result($resultado_query, 0, 3));?> <?print Trim(pg_result($resultado_query, 0, 4));?> 
          </td>
        </tr>
        <tr> 
          <td class="textos" width="21%"><b>Fecha de Nacimiento</b></td>
          <td width="25%" class="textos"> <?print Trim(pg_result($resultado_query, 0, 5));?> 
          </td>
          <td class="textos" width="21%"><b>E-mail</b></td>
          <td width="33%" class="textos"> <?print Trim(pg_result($resultado_query, 0, 6));?> 
          </td>
        </tr>
        <tr> 
          <td class="textos" width="21%"><b>Sexo</b></td>
          <td width="25%" class="textos"> 
            <?if(Trim(pg_result($resultado_query, 0, 7))== 1){
				echo "Femenino";
			}else{
				echo "Masculino";
				}
			
			;?>
          </td>
          <td class="textos" width="21%"><b>Curso</b></td>
          <td width="33%" class="textos"> <?print Trim(pg_result($resultado_query, 0, 8));?> 
            - <?print Trim(pg_result($resultado_query, 0, 9));?> <?print Trim(pg_result($resultado_query, 0, 10));?> 
          </td>
        </tr>
        <tr> 
          <td class="textos" width="21%"><b>Nacionalidad</b></td>
          <td width="25%" class="textos"> 
            <?
			if(Trim(pg_result($resultado_query, 0, 11))==2){
				echo "Chilena";
			}else{
				echo "Otra";
			}
			
			;?>
          </td>
          <td class="textos" width="21%"><b>Fecha Matricula</b></td>
          <td width="33%" class="textos"> <?print Trim(pg_result($resultado_query, 0, 12));?> 
          </td>
        </tr>
        <tr> 
          <td class="textos" width="21%"><b>Telefono</b></td>
          <td width="25%" class="textos"> <?print Trim(pg_result($resultado_query, 0, 13));?> 
          </td>
          <td class="textos" width="21%"><b>N&deg; Matricula</b></td>
          <td width="33%" class="textos"> <?print Trim(pg_result($resultado_query, 0, 14));?> 
          </td>
        </tr>
      </table>
      <br> </td>
 
  </tr>

  <tr> 
    <td> 
	
	<br> <table width="95%" border="0" cellspacing="1" cellpadding="1" align="center">
        <tr> 
          <td width="29%" class="textos"><b>Beca Alimentaci&Oacute;n JUNAEB</b></td>
          <td width="17%" class="textos"> 
            <?if ((Trim(pg_result($resultado_query, 0, 15))=='0') or (Trim(pg_result($resultado_query, 0, 15))== '')){
				echo "NO";
			}else{
				echo "SI";
			}
			;?>
          </td>
          <td width="21%" class="textos"><b>Alumna Embarazada</b></td>
          <td width="33%" class="textos"> 
            <?if ((Trim(pg_result($resultado_query, 0, 19))=='0') or (Trim(pg_result($resultado_query, 0, 19))== '')){
				echo "NO";
			}else{
				echo "SI";
			}
			;?>
          </td>
        </tr>
        <tr> 
          <td width="29%" class="textos"><b>Beneficio Chile Solidario</b></td>
          <td width="17%" class="textos"> 
            <?if ((Trim(pg_result($resultado_query, 0, 16))=='0') or (Trim(pg_result($resultado_query, 0, 16))== '')){
				echo "NO";
			}else{
				echo "SI";
			}
			;?>
          </td>
          <td width="21%" class="textos"><b>Grupo Diferencial</b></td>
          <td width="33%" class="textos"> 
            <?if ((Trim(pg_result($resultado_query, 0, 20))=='0') or (Trim(pg_result($resultado_query, 0, 20))== '')){
				echo "NO";
			}else{
				echo "SI";
			}
			;?>
          </td>
        </tr>
        <tr> 
          <td width="29%" class="textos"><b>Alumno Origen Indigena</b></td>
          <td width="17%" class="textos"> 
            <?if ((Trim(pg_result($resultado_query, 0, 17))=='0') or (Trim(pg_result($resultado_query, 0, 17))== '')){
				echo "NO";
			}else{
				echo "SI";
			}
			;?>
          </td>
          <td width="21%" class="textos"><b>Integrado</b></td>
          <td width="33%" class="textos"> 
            <?if ((Trim(pg_result($resultado_query, 0, 21))=='0') or (Trim(pg_result($resultado_query, 0, 21))== '')){
				echo "NO";
			}else{
				echo "SI";
			}
			;?>
          </td>
        </tr>
        <tr> 
          <td width="29%" class="textos"><b>Repitente Grado</b></td>
          <td width="17%" class="textos"> 
            <?if ((Trim(pg_result($resultado_query, 0, 18))=='0') or (Trim(pg_result($resultado_query, 0, 18))== '')){
				echo "NO";
			}else{
				echo "SI";
			}
			;?>
          </td>
          <td width="21%" class="textos"><b>Alumno Retirado</b></td>
          <td width="33%" class="textos"> 
            <?if ((Trim(pg_result($resultado_query, 0, 22))=='0') or (Trim(pg_result($resultado_query, 0, 22))== '')){
				echo "NO";
			}else{
				echo "SI";
			}
			;?>
          </td>
        </tr>
      </table>
      <br> </td>
  </tr>
  <tr> 
    <td> <br> <table width="95%" border="0" cellspacing="1" cellpadding="1" align="center">
        <tr> 
          <td colspan="2" class="textos"><b>Calle:</b> <?print Trim(pg_result($resultado_query, 0, 23));?> 
            # <?print Trim(pg_result($resultado_query, 0, 24));?> </td>
        </tr>
        <tr> 
          <td width="49%" class="textos"><b>Depto:</b> <?print Trim(pg_result($resultado_query, 0, 25));?> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Block: </b><?print Trim(pg_result($resultado_query, 0, 26));?></td>
          <td width="51%" class="textos"><b>Villa/Problaci&Oacute;n:</b> <?print Trim(pg_result($resultado_query, 0, 27));?> 
            </td>
        </tr>
        <tr> 
          <td colspan="2" class="textos"><b>Regi&Oacute;n:</b> <?print Trim(pg_result($resultado_query, 0, 31));?> 
            </td>
        </tr>
        <tr> 
          <td width="49%" class="textos"><b>Provincia:</b> <?print Trim(pg_result($resultado_query, 0, 32));?> 
            </td>
          <td width="51%" class="textos"><b>Comuna:</b> <?print Trim(pg_result($resultado_query, 0, 33));?> 
            </td>
        </tr>
      </table>
     <br> </td>
  </tr>
  <? if ($total_filas_APO>0){ ?>
  <tr>
    <td class="titulos"><br>
      <div align="center">Apoderado</div>
      <br>
      <table width="95%" border="0" cellspacing="1" cellpadding="1" align="center">
        <tr> 
          <td class="textos" width="21%"><b>Rut Apoderado</b></td>
          <td width="25%" class="textos"> <?print Trim(pg_result($resultado_query_apo, 0, 0));?> 
            <?print Trim(pg_result($resultado_query_apo, 0, 1));?> </td>
          <td class="textos" width="21%"><b>Nombre apoderado</b></td>
          <td width="33%" class="textos"> <?print Trim(pg_result($resultado_query_apo, 0, 2));?> 
            <?print Trim(pg_result($resultado_query_apo, 0, 3));?> <?print Trim(pg_result($resultado_query_apo, 0, 4));?> 
          </td>
        </tr>
        <tr> 
          <td class="textos"><b>Telefono</b></td>
          <td class="textos"> <?print Trim(pg_result($resultado_query_apo, 0, 5));?> 
          </td>
          <td class="textos" width="21%"><b>E-mail</b></td>
          <td width="33%" class="textos"> <?print Trim(pg_result($resultado_query_apo, 0, 6));?> 
          </td>
        </tr>
        <tr> 
          <td colspan="4" class="textos"><b>Calle: <?print Trim(pg_result($resultado_query_apo, 0, 7));?> 
            # <?print Trim(pg_result($resultado_query, 0, 8));?> </b></td>
        </tr>
        <tr> 
          <td colspan="2" class="textos"><b>Depto:</b> <?print Trim(pg_result($resultado_query_apo, 0, 9));?> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Block: <?print Trim(pg_result($resultado_query_apo, 0, 10));?> 
            </b></td>
          <td colspan="2" class="textos"><b>Villa/Problaci&Oacute;n: <?print Trim(pg_result($resultado_query_apo, 0, 11));?> 
            </b></td>
        </tr>
        <tr> 
          <td colspan="4" class="textos"><b>Regi&Oacute;n: <?print Trim(pg_result($resultado_query_apo, 0, 12));?> 
            </b></td>
        </tr>
        <tr> 
          <td colspan="2" class="textos"><b>Provincia: <?print Trim(pg_result($resultado_query_apo, 0, 13));?> 
            </b></td>
          <td colspan="2" class="textos"><b>Comuna: <?print Trim(pg_result($resultado_query_apo, 0, 14));?> 
            </b></td>
        </tr>
      </table>
      <br>
    </td>
  </tr>
  <?
  }
  ?>
</table>
<?
}
?>
</body>
</html>