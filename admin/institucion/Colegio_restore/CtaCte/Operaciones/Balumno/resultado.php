<? include"../../../Coneccion/conexion.php"?>

<?

	if($_POST["cb_save"] != '')

	{

		$li_total_registros   = Trim($_POST["hf_total"]);

		

		for($j=0; $j < $li_total_registros; $j++)

		{

		

		$ls_rut_alumno   = Trim($_POST["hf_id_".$j]);

		$li_beca 		 = Trim($_POST["tf_valor_".$j]);

		

		if($li_beca=='')

		{

		$li_beca = 0;

		}



		$sql= "Select * From con_alumno_beca Where Trim(rut_alumno) = Trim('$ls_rut_alumno') ";
		

		$resultado_query= pg_exec($conexion,$sql);

		$total_filas= pg_numrows($resultado_query);

	

		if($total_filas <=0)

		{

		$sql_new = "INSERT INTO con_alumno_beca VALUES ('$ls_rut_alumno', $li_beca);";

		$res_new = pg_exec($conexion,$sql_new);

		}Else

		{

		$sql_update = "UPDATE con_alumno_beca SET beca = $li_beca WHERE Trim(rut_alumno) = Trim('$ls_rut_alumno');";

		$res_update = pg_exec($conexion,$sql_update);

		}





		}

	

	}

?>



<?

	$li_id_usuario = Trim($_GET["ai_usuario"]);

	$li_id_nivel   = Trim($_GET["ai_nivel"]);

	$li_id_perfil  = Trim($_GET["ai_perfil"]);

	$li_mostrar_tabla = Trim($_GET["ai_mostrar"]);

	//Echo("Perfil : ($li_id_perfil) - Usuario : ($li_id_usuario) <BR>");

	

	

	if($li_mostrar_tabla==1)

	{



	$li_id_colegio = Trim($_GET["ai_colegio"]);

	$li_criterio   = Trim($_GET["ai_criterio"]);

	$ls_input      = Trim($_GET["as_input"]);

	$ls_campo      = Trim($_GET["ai_campo"]);

	//Echo("Colegio : ($li_id_colegio) <BR>");

	



if($li_id_perfil == 15)

{

//echo("<b>Perfil Apoderado</b><BR>");



	echo $sql= "Select nombre_usuario From usuario Where id_usuario = $li_id_usuario ;";
exit;
	$resultado_query_user= pg_exec($conexion,$sql);

	$total_filas_user    = pg_numrows($resultado_query_user);



	If($total_filas_user <= 0)

	{

	$ls_rut_usuario = 0;

	}Else

	{

	$ls_rut_usuario = pg_result($resultado_query_user, 0, 0);	

	}

	



	if ($li_criterio  == 1)

	

	{

	$sql= "Select Distinct a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat From alumno a, matricula c, tiene2 d Where Upper($ls_campo) like Upper('$ls_input%') and a.rut_alumno = c.rut_alumno And c.rdb = $li_id_colegio and a.rut_alumno = d.rut_alumno And d.rut_apo = '$ls_rut_usuario' Order by 4,5,3 ;";

	}

	Else //Criterio = 2 CONTENGA

	{

	

		If($ls_campo == "a.rut_alumno")

		{ 

	

		$sql= "Select Distinct a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat From alumno a, matricula c, tiene2 d Where Upper(a.rut_alumno) like Upper('$ls_input%') and a.rut_alumno = c.rut_alumno And a.rut_alumno = d.rut_alumno And d.rut_apo = '$ls_rut_usuario' And c.rdb = $li_id_colegio Order by 4,5,3 ;";

		

		}Else

		{



		$sql= "Select Distinct a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat From alumno a, matricula c, tiene2 d Where Upper(a.nombre_alu || a.ape_pat || a.ape_mat) like Upper('%$ls_input%') And a.rut_alumno = c.rut_alumno And a.rut_alumno = d.rut_alumno And d.rut_apo = '$ls_rut_usuario' And c.rdb = $li_id_colegio Order by 4,5,3 ;";



		}

	

	}



}

Else If($li_id_perfil == 0) // Perfil ADMINISTRADOR

{



	if ($li_criterio  == 1)

	

	{

	$sql= "Select Distinct a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat From alumno a, matricula c Where Upper($ls_campo) like Upper('$ls_input%') and a.rut_alumno = c.rut_alumno And c.rdb = $li_id_colegio Order by 4,5,3 ;";

	}

	Else //Criterio = 2 CONTENGA

	{

	

		If($ls_campo == "a.rut_alumno")

		{ 

	

		$sql= "Select Distinct a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat From alumno a, matricula c Where Upper(a.rut_alumno) like Upper('$ls_input%') and a.rut_alumno = c.rut_alumno And c.rdb = $li_id_colegio Order by 4,5,3 ;";

		

		}Else

		{



		$sql= "Select Distinct a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat From alumno a, matricula c Where Upper(a.nombre_alu || a.ape_pat || a.ape_mat) like Upper('%$ls_input%') and a.rut_alumno = c.rut_alumno And c.rdb = $li_id_colegio Order by 4,5,3 ;";



		}

	

	}





}

Else If($li_id_perfil == 14 or $li_id_perfil == 5 or $li_id_perfil == 1 or $li_id_perfil == 3) // Perfil ADMINISTRADOR WEB X COLEGIO

{



	if ($li_criterio  == 1)

	

	{

	$sql= "Select Distinct a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat From alumno a, matricula c Where Upper($ls_campo) like Upper('$ls_input%') and a.rut_alumno = c.rut_alumno And c.rdb = $li_id_colegio Order by 4,5,3 ;";

	}

	Else //Criterio = 2 CONTENGA

	{

	

		If($ls_campo == "a.rut_alumno")

		{ 

	

		$sql= "Select Distinct a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat From alumno a, matricula c Where Upper(a.rut_alumno) like Upper('$ls_input%') and a.rut_alumno = c.rut_alumno And c.rdb = $li_id_colegio Order by 4,5,3 ;";

		

		}Else

		{



		$sql= "Select Distinct a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat From alumno a, matricula c Where Upper(a.nombre_alu || a.ape_pat || a.ape_mat) like Upper('%$ls_input%') and a.rut_alumno = c.rut_alumno And c.rdb = $li_id_colegio Order by 4,5,3 ;";



		}

	

	}





}

Else If($li_id_perfil == 16) // Perfil ALUMNO

{



	$sql= "SELECT DISTINCT A.ID_USUARIO, B.RUT_APO, B.RUT_ALUMNO FROM USUARIO A, TIENE2 B WHERE A.ID_USUARIO = $li_id_usuario AND A.NOMBRE_USUARIO = B.RUT_ALUMNO ;";

	$resultado_query_user= pg_exec($conexion,$sql);

	$total_filas_user    = pg_numrows($resultado_query_user);



	If($total_filas_user <= 0)

	{

	$ls_rut_usuario = 0;

	}Else

	{

	$ls_rut_alumno  = pg_result($resultado_query_user, 0, 2);	

	$ls_rut_usuario = pg_result($resultado_query_user, 0, 1);	

	}





	if ($li_criterio  == 1)

	

	{

	$sql= "Select Distinct a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat From alumno a, matricula c, tiene2 d Where Upper($ls_campo) like Upper('$ls_input%') and a.rut_alumno = c.rut_alumno And c.rdb = $li_id_colegio and a.rut_alumno = d.rut_alumno And a.rut_alumno = '$ls_rut_alumno' And d.rut_apo = '$ls_rut_usuario' Order by 4,5,3 ;";

	}

	Else //Criterio = 2 CONTENGA

	{

	

		If($ls_campo == "a.rut_alumno")

		{ 

	

		$sql= "Select Distinct a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat From alumno a, matricula c, tiene2 d Where Upper(a.rut_alumno) like Upper('$ls_input%') and a.rut_alumno = c.rut_alumno And a.rut_alumno = d.rut_alumno And a.rut_alumno = '$ls_rut_alumno' And d.rut_apo = '$ls_rut_usuario' And c.rdb = $li_id_colegio Order by 4,5,3 ;";

		

		}Else

		{



		$sql= "Select Distinct a.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat From alumno a, matricula c, tiene2 d Where Upper(a.nombre_alu || a.ape_pat || a.ape_mat) like Upper('%$ls_input%') And a.rut_alumno = c.rut_alumno And a.rut_alumno = d.rut_alumno And a.rut_alumno = '$ls_rut_alumno' And d.rut_apo = '$ls_rut_usuario' And c.rdb = $li_id_colegio Order by 4,5,3 ;";



		}

	

	}



	

}//Cierra IF perfil Linea 53	

	

	//echo("Campo : ($ls_campo) - Criterio : ($li_criterio) <BR> SQL 2 : $sql <br>");

	$resultado_query= pg_exec($conexion,$sql);

	$total_filas    = pg_numrows($resultado_query);

	

	//pg_close($conexion);

	}

?>

<?

	if($li_mostrar_tabla==1)

	{



	$sql= "Select nombre_instit From institucion Where rdb = $li_id_colegio ;";

	$resultado_nombre   = pg_exec($conexion,$sql);

	$total_filas_nombre = pg_numrows($resultado_nombre);

	

	}

?>

<html>

<head>

<title>MODULOS</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link rel="stylesheet" href="../../../css/objeto.css" type="text/css">

</head>



<body bgcolor="#FFFFFF" text="#000000">

<?

	if($li_mostrar_tabla==1)

	{

	

		if($total_filas <= 0)

		{

		echo("<Center><BR><Font size='2'>No se encontraron Alumnos...</Center>");

		}Else

		{

	

?>

<form name="form1" method="post" action="">

  <table width="85%" border="1" align="center" cellspacing="0" cellpadding="0">

    <tr> 

      <td class="linea_datos_02" colspan="3">

	  INSTITUCI&Oacute;N<font size="2"> 

        : 

        <?print Trim(pg_result($resultado_nombre, 0, 0));?>

        </font>

	  </td>

    </tr>

    <tr> 

      <td class="linea_datos_02" colspan="3">RESULTADOS : 

        <?echo $total_filas?>

      </td>

    </tr>

    <tr> 

      <td class="linea_datos_05"> 

        <div align="center">NOMBRE</div>

      </td>

      <td class="linea_datos_05"> 

        <div align="center">RUT</div>

      </td>

      <td class="linea_datos_05" width="12%"> 

        <div align="right"> 

		<?

		If($li_id_perfil == 15 or $li_id_perfil == 16)

		{

		}Else{

		?>

          <input type="submit" name="cb_save" value="Grabar &gt;&gt;" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff'>

		 <?

		 }	 

		 ?>

        </div>

      </td>

    </tr>

    <?

	For ($j=0; $j < $total_filas; $j++)

	{

	?>

    <tr> 

      <td class="membrete_datos"> &nbsp; 
		<!-- CAMBIE EL ORDEN DE PRESENTACION DEL NOMBRE DE NOMBRE, APE_PAT, APE_MAT A APE_PAT,APE_MAT,NOMBRE -->

        <?print Trim(pg_result($resultado_query, $j, 3));?>

        <?print Trim(pg_result($resultado_query, $j, 4));?>

        <?print Trim(pg_result($resultado_query, $j, 2));?>

      </td>

      <td class="membrete_datos"> 

        <?print Trim(pg_result($resultado_query, $j, 0));?>

        - 

        <?print pg_result($resultado_query, $j, 1);?>

      </td>

      <td class="membrete_datos" width="12%"> 

        <div align="center"> 

          <input type="hidden" name="hf_id_<?=($j)?>" value="<?=pg_result($resultado_query, $j, 0)?>">

          <?

	$ls_rut_alumno = Trim(pg_result($resultado_query, $j, 0));

	$sqlbeca= "Select beca From con_alumno_beca Where Trim(rut_alumno) = '$ls_rut_alumno' ;";

	//echo(" SQL Beca : $sqlbeca <br>");

	$resultado_query_beca = pg_exec($conexion,$sqlbeca);

	$total_filas_beca     = pg_numrows($resultado_query_beca);

	

		If($total_filas_beca<=0)

		{

		$li_valor_beca = 0;

		}Else

		{

		$li_valor_beca = pg_result($resultado_query_beca, 0, 0);

		}

		  ?>

          Porcentaje 

          <input type="text" name="tf_valor_<?=($j)?>" class="text_9_x_100" value="<?=($li_valor_beca)?>" onfocus="Limpiar(this)" onkeypress="Numero()" maxlength="3">

        </div>

      </td>

    </tr>

    <?

	}

	pg_freeresult($resultado_query);

	?>

    <tr> 

      <td class="linea_datos_05" colspan="3"> 

        <div align="right">

		<?

		If($li_id_perfil == 15 or $li_id_perfil == 16)

		{

		}Else

		{

		?>

           <input type="submit" name="cb_save" value="Grabar &gt;&gt;" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff'>

		   <?

		   }

		   ?>

        </div>

      </td>

    </tr>

  </table>

  <input type="hidden" name="hf_total" value="<?=($j)?>">

</form>

<?

		}//Cierra el IF de Datos



	}else

	{

	echo("<Center><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><BR>Ingrese Criterios para la Busqueda...</font></Center>");

	}

?>

</body>

</html>

<Script>

function Limpiar(valor)

{

valor.value = ''

}



function Numero()

{

var key = window.event.keyCode;

if (key < 40 || key > 57)

{

window.event.keyCode=0;

}

}

</Script>