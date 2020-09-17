 <?   

 
 session_start();

require('util/header.inc');
//require('util/pid.php');


$institucion	=$_INSTIT;
 $ano			=$_ANO;
$curso			=$_CURSO;

$empleado=$_EMPLEADO;
$_POSP = 0;
$_bot = 0;
$_MDINAMICO = 1;

$perfil = $_PERFIL; 
 
$usuarioensesion = $_USUARIOENSESION;

$_USUARIOENSESION;

$_USUARIO;


##Selecciono los datos para mostrar en el Diario Mural.

		if (($_PERFIL == 19 or $_PERFIL==16 ) AND $ano == NULL){
		    $qry="SELECT * FROM ano_escolar WHERE id_institucion = '$institucion' AND situacion = 1";
		   //$qry="SELECT * FROM ano_escolar WHERE RDB=".$_INSTIT." AND SITUACION = 1";
		   $result = @pg_Exec($conn,$qry);
		   $fila = @pg_fetch_array($result,0);	
		   $_ANO=$fila["id_ano"];
		   $ano = $_ANO;
		} 

		if ($_PERFIL == 2 AND $ano == NULL){
		   $qry="SELECT * FROM ano_escolar WHERE id_institucion = '$institucion' AND situacion = 1";
		   //$qry="SELECT * FROM ano_escolar WHERE RDB=".$_INSTIT." AND SITUACION = 1";
		   $result = @pg_Exec($conn,$qry);
		   $fila = @pg_fetch_array($result,0);	
		   $_ANO=$fila["id_ano"];
		   $ano = $_ANO;
		} 

			if ($_PERFIL == 25 AND $ano == NULL){
			   $qry="SELECT * FROM ano_escolar WHERE id_institucion = '$institucion' AND situacion = 1";
			   //$qry="SELECT * FROM ano_escolar WHERE RDB=".$_INSTIT." AND SITUACION = 1";
			   $result = @pg_Exec($conn,$qry);
			   $fila = @pg_fetch_array($result,0);	
			   $_ANO=$fila["id_ano"];
			   $ano = $_ANO;
			} 

				if ($_PERFIL == 1 AND  $ano == NULL){
				   $qry="SELECT * FROM ano_escolar WHERE id_institucion = '$institucion' AND situacion = 1";
				   //$qry="SELECT * FROM ano_escolar WHERE RDB=".$_INSTIT." AND SITUACION = 1";
				   $result = @pg_Exec($conn,$qry);
				   $fila = @pg_fetch_array($result,0);	
				   $_ANO=$fila["id_ano"];
				   $ano = $_ANO;
				} 




if ( (($_PERFIL == 17) or ($_PERFIL == 14)) && ($ano == NULL)){
 
  $qry="SELECT * FROM ano_escolar WHERE id_institucion = '$institucion' AND situacion = 1";
   //$qry="SELECT * FROM ano_escolar WHERE RDB=".$_INSTIT." AND SITUACION = 1";
   $result = @pg_Exec($conn,$qry);
   $fila = @pg_fetch_array($result,0);	
   $_ANO=$fila["id_ano"];
   $ano = $_ANO;

// ver la cantidad de errores que tiene.
// cursos
$sql_err_curso = "SELECT curso.id_curso, curso.cod_decreto, curso.grado_curso, curso.letra_curso, curso.acta, curso.bool_jor,   tipo_ensenanza.nombre_tipo, cod_tipo FROM tipo_ensenanza INNER JOIN (curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((ano_escolar.id_ano)=".$ano.")) order by tipo_ensenanza.nombre_tipo,curso.grado_curso, curso.letra_curso asc"; 
$res_err_curso = pg_Exec($conn, $sql_err_curso);
$num_err_curso = pg_numrows($res_err_curso);
      
   for ($i=0; $i < $num_err_curso; $i++){
        $fil_err_curso = @pg_fetch_array($res_err_curso,$i);
				
		$bool_jor = $fil_err_curso['bool_jor'];
		$acta     = $fil_err_curso['acta'];
		$cod_tipo = $fil_err_curso['cod_tipo'];
		
		if (($acta==NULL or $acta==0)   and $cod_tipo > 10){
			$curso_fal = 1;
		}	
		
		$qry55="select * from supervisa where id_curso=".$fil_err_curso['id_curso'];
		$result55 =@pg_Exec($conn,$qry55);
		$num55    =@pg_numrows($result55);
			
		if ($num55==0){
		    $curso_fal = 1;
		}	
		
		/// validaciones en los subsectores
		$qry="SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector, ramo.eee,  ramo.modo_eval, ramo.id_orden,ramo.conex,ramo.prueba_nivel, ramo.porc_examen FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE (((ramo.id_curso)=".$fil_err_curso['id_curso']."))  order by ramo.id_orden";
			   
        $result_qry =@pg_Exec($conn,$qry);
		$num_ramo = @pg_numrows($result_qry);
		
		for ($j=0; $j < $num_ramo; $j++){
		
		    $fila_modo = @pg_fetch_array($result_qry,$j);	
		    $modismo = $fila_modo['modo_eval'];
		    $id_ramo = $fila_modo['id_ramo'];
		
		    $qry_ram="select * from dicta where id_ramo=".$fila['id_ramo'];
		    $result_ram = @pg_Exec($conn,$qry_ram);
		    $num_ram    = @pg_numrows($result_ram);
		
		    if ($num_ram==0){
		       $rf = 1;
		    }
		}	
		/// fin ramo
		
		// validando períodos
		$qry_p="SELECT periodo.id_periodo, periodo.cerrado, periodo.dias_habiles, periodo.nombre_periodo, periodo.fecha_inicio, periodo.fecha_termino, periodo.mostrar_notas, ano_escolar.nro_ano FROM ano_escolar INNER JOIN periodo ON ano_escolar.id_ano = periodo.id_ano WHERE (((ano_escolar.id_ano)=".$ano.")) ORDER BY periodo.fecha_inicio";
		$result_p =@pg_Exec($conn,$qry_p);
		
		for($j=0;$j<@pg_numrows($result_p);$j++){
			$fila = @pg_fetch_array($result_p,$j);
			$fecha_inicio  = $fila['fecha_inicio'];
			$fecha_termino = $fila['fecha_termino'];
			$dias_habiles  = $fila['dias_habiles'];
		
		    if ($fecha_inicio==NULL){
			   $pf = 1;
			}
			if ($fecha_termino==NULL){
			   $pf = 1;
			}
			if ($dias_habiles==NULL or $dias_habiles==0){
			   $pf = 1;
			} 
		}
		//// fin periodo	  
		  
   }  
      
  
}else{
    // ver la cantidad de errores que tiene.
   // cursos
   $sql_err_curso = "SELECT curso.id_curso, curso.cod_decreto, curso.grado_curso, curso.letra_curso, curso.acta, curso.bool_jor,   tipo_ensenanza.nombre_tipo, cod_tipo FROM tipo_ensenanza INNER JOIN (curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((ano_escolar.id_ano)=".$ano.")) order by tipo_ensenanza.nombre_tipo,curso.grado_curso, curso.letra_curso asc"; 
   $res_err_curso = @pg_Exec($conn, $sql_err_curso);
   $num_err_curso = @pg_numrows($res_err_curso);
   
      
   for ($i=0; $i < $num_err_curso; $i++){
        $fil_err_curso = @pg_fetch_array($res_err_curso,$i);
				
		$bool_jor = $fil_err_curso['bool_jor'];
		$acta     = $fil_err_curso['acta'];
		$cod_tipo = $fil_err_curso['cod_tipo'];
		
		if (($acta==NULL or $acta==0)   and $cod_tipo > 10){
			$curso_fal = 1;
		}	
		
		$qry55="select * from supervisa where id_curso=".$fil_err_curso['id_curso'];
		$result55 =@pg_Exec($conn,$qry55);
		$num55    =@pg_numrows($result55);
			
		if ($num55==0){
		    $curso_fal = 1;
		}
		
		
		
		/// validaciones en los subsectores
		$qry="SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector, ramo.eee,  ramo.modo_eval, ramo.id_orden,ramo.conex,ramo.prueba_nivel, ramo.porc_examen FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE (((ramo.id_curso)=".$fil_err_curso['id_curso']."))  order by ramo.id_orden";
			   
        $result_qry =@pg_Exec($conn,$qry);
		$num_ramo = @pg_numrows($result_qry);
		
		for ($j=0; $j < $num_ramo; $j++){
		
		    $fila_modo = @pg_fetch_array($result_qry,$j);	
		    $modismo = $fila_modo['modo_eval'];
		    $id_ramo = $fila_modo['id_ramo'];
		
		    $qry_ram="select * from dicta where id_ramo=".$fila['id_ramo'];
		    $result_ram = @pg_Exec($conn,$qry_ram);
		    $num_ram    = @pg_numrows($result_ram);
		
		    if ($num_ram==0){
		       $rf = 1;
		    }
		}	
		/// fin ramo	
		
		// validando períodos
		$qry_p="SELECT periodo.id_periodo, periodo.cerrado, periodo.dias_habiles, periodo.nombre_periodo, periodo.fecha_inicio, periodo.fecha_termino, periodo.mostrar_notas, ano_escolar.nro_ano FROM ano_escolar INNER JOIN periodo ON ano_escolar.id_ano = periodo.id_ano WHERE (((ano_escolar.id_ano)=".$ano.")) ORDER BY periodo.fecha_inicio";
		$result_p =@pg_Exec($conn,$qry_p);
		
		for($j=0;$j<@pg_numrows($result_p);$j++){
			$fila = @pg_fetch_array($result_p,$j);
			$fecha_inicio  = $fila['fecha_inicio'];
			$fecha_termino = $fila['fecha_termino'];
			$dias_habiles  = $fila['dias_habiles'];
		
		    if ($fecha_inicio==NULL){
			   $pf = 1;
			}
			if ($fecha_termino==NULL){
			   $pf = 1;
			}
			if ($dias_habiles==NULL or $dias_habiles==0){
			   $pf = 1;
			} 
		}
		//// fin periodo	  
   
   }

} 



if ($ano == ""){
    if ($_PERFIL == 0){
       $sqlDiario = "select * from diario_mural order by fecha_publi DESC";
       $rsDiario  = @pg_Exec($conn,$sqlDiario);
	}    
}else{
    
    $sqlDiario = "select * from diario_mural where id_ano = $ano order by fecha_publi DESC";
    $rsDiario  = @pg_Exec($conn,$sqlDiario);
}	

if ($_PERFIL == 19)
	{
	
	$_MDINAMICO = $menu;
	
	}else{
	 
	$_MDINAMICO = 0;
	
}
$cantidad = 4;
	if($pag_actual == "")
{
$pag_actual = 0;
$desde = 0;
	}else{
$desde = ($pag_actual-1) * $cantidad;
}


$sql="SELECT * FROM encuesta.encuestas WHERE estado=true and id_perfil=14";
$rs_encuesta = pg_exec($connection,$sql);
?>
	<script language="javascript">
		//window.open('aviso.php','colegio','','');
	</script>
<? 


?>
<?php //ver si colegio tiene planificacin
 $sqlpla = "select planificacion,codbarra,comunicapp,sms from institucion where rdb= $institucion";
 $rspla  = @pg_Exec($connection,$sqlpla);
 $plani = pg_result($rspla,0);
 $comunicapp = pg_result($rspla,2);
 $codbarra = pg_result($rspla,1);
 $sms = pg_result($rspla,3);
 
 $_CODBARRA = $codbarra;
 session_register('_CODBARRA');
 //$institucion==10774 &&
 $_COMUNICAPP = $comunicapp;
 session_register('_COMUNICAPP');
  $_SMS = $sms;
 session_register('_SMS');
 
 if($_PERFIL==0){
 //show($_SESSION);
 }
 
?>
<?php if( $plani==12 && $perfil==17 && ($_INSTIT==10774 || $_INSTIT==25114)){
	

	
function InicialesSubsector($Subsector)
{
	$largo = strlen($Subsector);
	for($cont_letras=0 ; $cont_letras < $largo  ; $cont_letras++)
	{
		if ($cont_letras == 0)
		{
			$cadena = strtoupper(substr($Subsector,0,1));
			$cont_letras = 1;
		}
		$letra_query = substr($Subsector,$cont_letras,1);
		if (strlen(trim($letra_query)) == 0)
			if (substr($Subsector,$cont_letras+1,1) == "(")
				$cont_letras = $largo;
			else
				$cadena = $cadena . strtoupper(substr($Subsector,$cont_letras+1,1));
		if (strlen($cadena)==6 )
			$cont_letras = $largo;
	}	
	if (strlen(trim($cadena))==1)
		return trim(strtoupper(substr($Subsector,0,3)));
	else
		return trim($cadena);
}	
	
//veo si tengo planificaciones rechazadas	
//anuales
$sql_ruano = "select pa.*,s.cod_subsector,s.nombre as subsector from planificacion.unidad_anio pa
inner join ramo r on pa.id_ramo = r.id_ramo
inner join subsector s on s.cod_subsector = r.cod_subsector where estado=4 and rut_emp=$empleado and id_ano=$ano";
$rs_ruano  = @pg_Exec($conn,$sql_ruano);

$fila_rech="";

if(pg_numrows($rs_ruano)>0){
	for($fua=0;$fua<pg_numrows($rs_ruano);$fua++){
	$fila_fua=pg_fetch_array($rs_ruano,$fua);
	
	
	$s_mota = "select * from planificacion.unidad_anio_observacion where id_unidad = ".$fila_fua['id_unidad']." order by id_observacion desc limit 1"; 
	$r_mota = @pg_Exec($conn,$s_mota);
	
	$mota = CambioFD(pg_result($r_mota,2))." - ".pg_result($r_mota,3);
	
	//grado y curso
	$s_cura = "select grado_curso,ensenanza from curso where id_curso = ".$fila_fua['id_curso'];
	$r_cura = @pg_Exec($conn,$s_cura);
	$gra = pg_result($r_cura,0);
	$ena = pg_result($r_cura,1);
	
	//cod_subsector
	$s_sub ="select cod_subsector from ramo where id_ramo =".$fila_fua['id_ramo'];
	$r_sub = @pg_Exec($conn,$s_sub);
	$sub = pg_result($r_sub,0);
	
	
	$fila_rech.='<tr class="textosimple" style="height:30px"><td>'.CursoPalabra($fila_fua['id_curso'],6, $conn).'</td><td>'.InicialesSubsector($fila_fua['subsector']).'</td><td>'.$fila_fua['nombre'].'</td><td>PA</td><td>'.$mota.'</td><td align="center" ><input name="" type="button" value="IR" class="botonXX" onclick="edita(1,'.$fila_fua['id_unidad'].','.$fila_fua['id_ramo'].','.$fila_fua['id_curso'].','.$fila_fua['id_ano'].','.$gra.','.$ena.','.$sub.')"></td></tr>';
	
	}
}

////////////////////////////////unidad
 $sql_ruuni = "select pu.*,s.cod_subsector,s.nombre as subsector from planificacion.unidad pu
inner join ramo r on pu.id_ramo = r.id_ramo
inner join subsector s on s.cod_subsector = r.cod_subsector where estado=4 and rut_emp=$empleado and id_ano=$ano";
$rs_ruuni  = @pg_Exec($conn,$sql_ruuni);

if(pg_numrows($rs_ruuni)>0){
	for($fui=0;$fui<pg_numrows($rs_ruuni);$fui++){
	$fila_fui=pg_fetch_array($rs_ruuni,$fui);
	
	
	
	  $s_motu = "select * from planificacion.unidad_observacion where id_unidad = ".$fila_fui['id_unidad']." order by id_observacion desc limit 1"; 
	$r_motu = @pg_Exec($conn,$s_motu);
	
	$motu = CambioFD(pg_result($r_motu,2))." - ".pg_result($r_motu,3);
	
	//grado y curso
	$s_curi = "select grado_curso,ensenanza from curso where id_curso = ".$fila_fui['id_curso'];
	$r_curi = @pg_Exec($conn,$s_curi);
	$gri = pg_result($r_curi,0);
	$eni = pg_result($r_curi,1);
	
	//cod_subsector
	$s_subi ="select cod_subsector from ramo where id_ramo =".$fila_fui['id_ramo'];
	$r_subi = @pg_Exec($conn,$s_subi);
	$subi = pg_result($r_subi,0);
	
	
	$fila_rech.='<tr class="textosimple" style="height:30px"><td>'.CursoPalabra($fila_fui['id_curso'],6, $conn).'</td><td>'.InicialesSubsector($fila_fui['subsector']).'</td><td>'.$fila_fui['nombre'].'</td><td>PU</td><td>'.$motu.'</td><td align="center"><input name="" type="button" value="IR" class="botonXX" onclick="edita(2,'.$fila_fui['id_unidad'].','.$fila_fui['id_curso'].','.$fila_fui['id_ramo'].','.$fila_fui['id_ano'].','.$gri.','.$eni.','.$subi.','.$fila_fui['unidad_anual'].')"></td></tr>';
	
	}
}

/////////////////////////////clase
$sql_rucla = "select planificacion.clase.*,s.cod_subsector,s.nombre as subsector,planificacion.unidad.id_ano
from planificacion.clase
inner join planificacion.unidad on planificacion.unidad.id_unidad = planificacion.clase.id_unidad
inner join ramo r on planificacion.clase.id_ramo = r.id_ramo
inner join subsector s on s.cod_subsector = r.cod_subsector where planificacion.clase.estado=4 and planificacion.clase.rut_emp=$empleado and planificacion.unidad.id_ano=$ano";
$rs_rucla  = @pg_Exec($conn,$sql_rucla);

if(pg_numrows($rs_rucla)>0){
	for($fuc=0;$fuc<pg_numrows($rs_rucla);$fuc++){
	$fila_fuc=pg_fetch_array($rs_rucla,$fuc);
	
	 $s_motc = "select * from planificacion.clase_observacion where id_clase = ".$fila_fuc['id_clase']." order by id_observacion desc limit 1"; 
	$r_motc = @pg_Exec($conn,$s_motc);
	
	$motc = CambioFD(pg_result($r_motc,2))." - ".pg_result($r_motc,3);
	
	//grado y curso
	$s_curc = "select grado_curso,ensenanza from curso where id_curso = ".$fila_fuc['id_curso'];
	$r_curc = @pg_Exec($conn,$s_curc);
	$grc = pg_result($r_curc,0);
	$enc = pg_result($r_curc,1);
	
	//cod_subsector
	$s_subc ="select cod_subsector from ramo where id_ramo =".$fila_fuc['id_ramo'];
	$r_subc = @pg_Exec($conn,$s_subc);
	$subc = pg_result($r_subc,0);
	
	
	$fila_rech.='<tr class="textosimple" style="height:30px"><td>'.CursoPalabra($fila_fuc['id_curso'],6, $conn).'</td><td>'.InicialesSubsector($fila_fuc['subsector']).'</td><td>'.$fila_fuc['nombre'].'</td><td>PC</td><td>'.$motc.'</td><td align="center"><input name="" type="button" value="IR" class="botonXX" onclick="edita(3,'.$fila_fuc['id_clase'].','.$fila_fuc['id_ramo'].','.$fila_fuc['id_curso'].','.$ano.','.$grc.','.$enc.','.$subc.','.$fila_fuc['id_unidad'].')"></td></tr>';
	
	}
}
 
 
 $sum_err = pg_numrows($rs_ruano)+pg_numrows($rs_ruuni)+pg_numrows($rs_rucla); 
if($sum_err>0){
?>
 <script type="text/javascript" src="admin/clases/jquery/jquery.js"></script>
        <script type="text/javascript" src="admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
       	<script type="text/javascript" src="admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.theme.css">
<script type="text/javascript">

$( document ).ready(function() {
	
   ventanaR();
	
});

function edita(tipo,id,curso,ramo,anio,grado,ense,subs,uanual){

var ruta = "";


switch(tipo){
case 1:
ruta = "planificacion/anualUnidad/unidad.php?orr=1&uu="+id+"&aa="+anio+"&cc="+curso+"&rr="+ramo+"&viene_de=../listarRamos.php3&gg="+grado+"&ee="+ense+"&ss="+subs; 
break;	

/*case 2:
ruta = "planificacion/unidad/unidad.php?orr=1&uu="+id+"&aa="+anio+"&cc="+curso+"&rr="+ramo+"&viene_de=../listarRamos.php3&gg="+grado+"&ee="+ense+"&ss="+subs+"&iun="+uanual; 
break;	*/
case 2:
ruta = "planificacion/unidad/unidad.php?orr=1&uu="+id+"&aa="+anio+"&cc="+curso+"&rr="+ramo+"&viene_de=../listarRamos.php3&gg="+grado+"&ee="+ense+"&ss="+subs+"&iun="+uanual; 
break;	


case 3:
ruta = "planificacion/clase/clase.php?orr=1&uu="+id+"&aa="+anio+"&rr="+ramo+"&viene_de=../listarRamos.php3&gg="+grado+"&ee="+ense+"&ss="+subs+"&cls="+uanual+"&cc="+curso; 
break;	
}

location.href=ruta;
}


function ventanaR(){
	    $( "#recha" ).append('<div class="textonegrita"> Usted tiene '+<?php echo $sum_err ?>+' planificacione(s) rechazada(s)</div><br>');
		
		$( "#recha" ).append('<div class="textosimple">(*)Tipos de planificaci&oacute;n<br><ul><li>PU: Planificaci&oacute;n de Unidad</li><li>PC: Planificaci&oacute;n de Clase</li></ul><br></div>');
		
		 $( "#recha" ).append('<table id="ret" width="100%" border="1" style="border-collapse:collapse; border:1px black solid">');
		  $( "#ret").append('<tr class="ccctableindex" style="text-align:center;" ><td>Curso</td><td>Asig.</td><td>Nombre</td><td>Tipo*</td><td width="60%">Motivo rechazo</td><td>Acciones</td><tr>');
		  $( "#ret tr:last").after('<?php echo $fila_rech ?>');
		  
		 
		  $( "#recha" ).append('</table>');
     	 $("#recha").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
   Width: 700,
   Height: 500,
   minWidth: 700,
   minHeight: 500,
   maxWidth: 700,
   maxHeight: 500,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
		 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}    
  })

}
</script>

<?php
}

 }?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link  rel="shortcut icon" href="images/icono_sae_33.png">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<?=$_ESTILO?>" rel="stylesheet" type="text/css">


<?

if ($_PERFIL==15 or $_PERFIL==16) { 
	$sql ="SELECT bloqueo FROM alumno WHERE rut_alumno=".$_ALUMNO;
	$rs_bloqueo =pg_exec($conn,$sql);
	$bloqueo =pg_result($rs_bloqueo,0);
	if($bloqueo==1){
		if($institucion==1604){
		echo "<script>alert('ALUMNO SE ENCUENTRA MOROSOS EN MENSUALIDAD, FAVOR ACERCARSE A ADMINISTRACION.')</script>";	
		}else{
			echo "<script>alert('ACCESO A LA PLATAFORMA SE ENCUENTRA BLOQUEADO. FAVOR COMUNICARSE CON EL COLEGIO.')</script>";
		}
		echo "<script>window.location='http://www.colegiointeractivo.com'</script>";
	}
 if (!isset($_ALUMNO)){
?>
	<SCRIPT>
		alert('Error: NO SELECCIONO ALUMNO');
		window.location='logout.php'
	</script>
	

<? }
 }
 
  if($_PERFIL==15){
		  $sql_enf="select * from enfermeria where id_ano = ".$_ANO." and visto =0 and rut_alumno in(select rut_alumno from tiene2 where rut_apo =".$_NOMBREUSUARIO.") ";
		 $rs_conenfe =pg_exec($conn,$sql_enf);
		//echo pg_numrows($rs_conenfe);
		 if(pg_numrows($rs_conenfe)>0){
		?>
        <script type="text/javascript" src="admin/clases/jquery/jquery.js"></script>
        <script type="text/javascript" src="admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
       	<script type="text/javascript" src="admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.theme.css">
     <!--   <script>
		
		//alert("Usted tiene "+<?php echo pg_numrows($rs_conenfe) ?>+" atencion(es) sin ver en el módulo de enfermería");
		</script>-->
        <script>
  $(function() {
	  $( "#avisoenfe" ).html("Usted tiene "+<?php echo pg_numrows($rs_conenfe) ?>+" notificación(es) sin ver en el módulo de enfermería");
     	 $("#avisoenfe").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
   Width: 400,
   Height: 300,
   minWidth: 400,
   minHeight: 300,
   maxWidth: 400,
   maxHeight: 300,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
		 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}    
  })

  });
  </script>
        
        <div id="avisoenfe" title="Aviso módulo enfermería"></div>
        <?
		}else{
			?>
             <script type="text/javascript" src="admin/clases/jquery/jquery.js"></script>
             <script>
            $("#avisoenfe").html("");
			</script>
            <?
			}
    }   
 

 ?>			


<script language="JavaScript" type="text/JavaScript">

<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
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
<?php if( $perfil !=0   ) { ?>
function mostrarVentana()
{
    var ventana = document.getElementById('miVentana');
    ventana.style.marginTop = "100px";
    //ventana.style.left = ((document.body.clientWidth-350) / 2) +  "px";
	 ventana.style.left = "450px";
    ventana.style.display = 'block';
}

<?php  }?>
function ocultarVentana()
{
    var ventana = document.getElementById('miVentana');
    ventana.style.display = 'none';
}

-->
function Abrir_ventana(pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";
window.open(pagina,"",opciones);
}
	
</script>


<SCRIPT language="JavaScript" src="util/chkform.js"></SCRIPT>
<style type="text/css">
<!--
.Estilo8 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo9 {color: #FF0000}
.Estilo10 {font-size: 12px}
.Estilo11 {font-size: 12}
-->
</style>


<link rel="stylesheet" type="text/css" href="admin/clases/jqueryui/themes/smoothness/jquery-ui-1.8.6.custom.css">
<script type="text/javascript" src="admin/clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="admin/clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>


<script>
$(window).load(function() {

        $('#slider').nivoSlider();
    });

$(document).ready(function() {
	mostrarVentana();
	   //alert(parametros);
   /* $.ajax({
			
	  url:'aviso.htm',
	  data:1,
	  type:'POST',
	 
	  success:function(data){
	    // alert(data);
		$("#mensaje").html(data);
		
			   $("#mensaje").dialog({
				  modal: true,
				  title: "",
				  width: 750,
				  minWidth: 400,
				  maxWidth: 700,
				  show: "fold",
				  hide: "scale",
				  	  buttons: {
            "Cerrar": function(){
              $(this).dialog("close");
            }
          },
			   });
		  }
	  });*/	
	
    });
	
</script>

<!-- carga el slider al cargar el navegador -->
</head>


<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"  >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7">
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
			   <tr align="left" valign="top"> 
                <td valign="top">
				    <?
			        include("cabecera/menu_superior.php");
					 
			        ?>
				</td>
              </tr>
		  </table>
            <tr align="left" valign="top"> 
                <td >
<table width="100%" height="207" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="left" valign="bottom" background="cortes/<?=$institucion?>/foto_top.jpg">
					  <font color="#FFFFFF" size="4" face="Arial, Helvetica, sans-serif">SAE &reg;  Sistema de Administraci&oacute;n Escolar</font>
                    </tr>
                  </table></td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="362" align="left" valign="top">
					  
					   <!-- AQUI INSERTO EL MENÚ DINÁMICO -->
					   <?
							include("menus/menu_lateral.php");
						?> 
					  
					  
                    </td>
					
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="borde_grande">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top">
							<table cellSpacing=0 cellPadding=5 width="100%" border=0 >
                                <tr align="left" valign="top"> 
                                  <td width="37%" height="162" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr> 
                                        <td height="195" align="center" valign="top"> 
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr> 
                                              <td height="36" class="tableindex">AGENDA MES <img src="images/ICONO_AGENDA2222.png" width="36" height="47"></td>
                                            </tr>
                                            <tr> 
                                              <td height="149" align="left" valign="top" class="borde">
											  	<? include("calendario.php");?>
											  </td>
                                            </tr>
                                          </table></td>
                                      </tr>
                                      <tr> 
                                        <td align="center" valign="top"> 
									 <?
									 // AQUI MUESTRO LOS MENSAJES RECIBIDOS  //
									 $perfil_user = $_PERFIL;
                                     $idusuario = $_USUARIO;
		                             $idele = $_GET['idel'];	
									
									
									  $qry="SELECT * FROM mensajero WHERE user2men='$_NOMBREUSUARIO' ORDER BY id_mensaje DESC";
	                                  $result = @pg_Exec($conn,$qry);
                                      $num= @pg_numrows($result);
	                                   	 
									   ?>	
										
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr align="center"> 
                                              <td width="100%" height="36" class="tableindex">MENSAJES RECIBIDOS <img src="images/icono_mail_222.png" width="41" height="39"></td>
                                            </tr>
                                            <tr> 
                                              <td height="130" valign="top" class="borde2">
											  
											  
											     
										        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                  <tr>
                                                    <td bgcolor="#CCCCCC"><span class="Estilo8">De</span></td>
                                                     <td bgcolor="#CCCCCC"><span class="Estilo8">Asunto</span></td>
                                                  </tr>
                                                   <?
												   $contadormensaje = 0;
												   if (!$result) {
									                    //error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	                                               }else{
												       $i = 0; 
													   while ($i < $num){
	                                                      $row = pg_fetch_array($result,$i);
										                  $id = $row["id_mensaje"];												
                                                          $de = $row["user1men"];
                                                          $para = $row["user2men"];
                                                          $mensaje = $row["mensaje"];
                                                          $asunto = $row["asunto"];
                                                          $fecha = $row["fecha"];
                                                          $archi = $row["archivos"];
                                                          $cram = $row["lee"];
														  if ($contadormensaje < 7){
													         ?>
												             <tr>
                                                               <td><span class="textosesion"><?=$de ?></span></td>
<td><span class="textosesion"><a href="mensajeria/enviorespu.php?id=<? echo $id ?>" class="Estilo8"><?=$asunto ?></a></span></td>
                                                             </tr>															 
													          <?
														  }	  
													      $i++;
														  $contadormensaje++;
													   }
												   }   
												   ?>  
                                                </table>
											
											
											
											</td>
                                            </tr>
                                            <tr>
                                              <td  class="borde2"><div align="center"><a href="mensajeria/mira.php?menu=9&categoria=48&nw=1" class="Estilo11">Bandeja de entrada</a><a></div></td>
                                            </tr>
                                        </table></td>
                                      </tr>
                                    </table>
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td colspan="4"></td>
                                      </tr>
                                  </table></td>
                             <td width="63%" align="center"><br>
								 <table width="97%" cellspacing="0" cellpadding="0" border=0 class="borde_grande">
								 <tr>
								   <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
								     <td width="314" height="36" align="right" class="tableindex">DIARIO MURAL </td>
										</tr>
										<tr>
<td height="23" align="center" valign="top" class="borde"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th colspan="3" scope="col"><!--<img src="images/PROFESOR_SAE.jpg" width="472" height="375">--></th>
  </tr> 
</table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <!-- AQUI LA INFORMACION DEL DIARIO MURAL -->
  <?
												  $num = @pg_numrows($rsDiario);
												  
												     if(@pg_numrows($rsDiario)!=0){
	                                                    for($i=0 ; $i < 4 ; $i++)
	                                                       {
		                                                   $fDiario = @pg_fetch_array($rsDiario,$i);
														   $detalle = substr($fDiario['detalle'],0,80);	
														   $id_diario = $fDiario['id_diario'];										   						   
		  												
														 if ($detalle != NULL){
                                                             ?>
  <tr>
                <td width="21%" height="54" align="center" valign="top"><? if($fDiario['nom_foto']!=""){?>
                    <img src="fichas/diario/images/<?php echo $fDiario['nom_foto']; ?>" alt="Ampliar Imágen"  width=53 height="50" border="1" onClick="MM_openBrWindow('foto_diarioMural.php?dmural=<?php echo $fDiario['nom_foto']; ?>','','scrollbars=yes,resizable=yes,width=800,height=600')" onMouseOver=this.style.cursor='hand'>
                    <? } ?>
                </td>
                <td width="79%" height="60" align="left" valign="bottom"><a href="detalle_diariomural.php?id_diario=<?=$id_diario ?>" class="textolink"><strong><img src="images/icono_diario_mural.png" width="35" height="30" border="0"><? echo $fDiario['titulo']?></strong><br>
                      <? echo "$detalle..." ?> <img src="cortes/i_flechita.jpg" border="0"></a><br>
                      <br></td>
              </tr>
              <?
													     }		
														}
														 if ($num > 4){ 
														    ?>
              <tr>
                <td colspan="2" align="center" valign="middle"><font face="arial, geneva, helvetica" size="1"><a href="all_diariomural.php" class="textolink">Ver diario mural completo.</a></font></td>
              </tr>
              <?
													     }		 
												    }else{
													     ?>
              <tr>
                <td height="12" colspan="2" align="center"><font face="arial, geneva, helvetica" size="1">NO EXISTEN INFORMACIÓN DISPONIBLE</font></td>
              </tr>
              <?
														
													}	
													?>
        </table></td>
        </tr>
                                    </table>
                                    <br>
                                    <? if ($_PERFIL==14 OR $_PERFIL==0 OR $_PERFIL==17) {?>
			<!-- empieza tabla noticia-->
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borde">
				<?
				
				?>					  
					 <tr>
						<td width="100%" height="36" class="tableindex" colspan="2"><marquee>
COLEGIO INTERACTIVO INFORMA
						</marquee></td>
					  </tr>
                      <tr>
						<td width="100%" height="36"  colspan="2" align="center" class="textonegrita">INFORMACION <img src="images/icono_info.png" width="20" height="23"></td>
					  </tr>
                      <?
					   	$sql1="SELECT * FROM din_noticias  WHERE tipo='1' and estado='1' order by fecha desc";
						$result1 = @pg_Exec($connection,$sql1) or die(pg_last_error($conn));
						$fila1= pg_fetch_array($result1,0);
						$detalle = substr($fila1['tx_titulo'],0,100); 
					?>
                      <tr height="30">
<td valign="bottom" bgcolor="#FFFFFF" class="content"><a href="detalle_noticia.php?id=<?=$fila1['id_noticia']?>"><? echo $fila1['fecha']?></a> <? if ($i==0){ ?><img src="nuevo_animado.gif"> <? } ?></td>
<td bgcolor="#FFFFFF" class="content"><a href="detalle_noticia.php?id=<?=$fila1['id_noticia']?>"><? echo "$detalle ..."?></a></td>
						</tr>
                        <tr>
						<td width="100%" height="36"  colspan="2" align="center" class="textonegrita">NOTIFICACIONES <img src="images/icono_notificacion.png" width="22" height="23"></td>
					  </tr>
					  <? 
						$sql2="SELECT * FROM din_noticias  WHERE tipo='2' and estado='1' order by fecha desc";
						$result2 = @pg_Exec($connection,$sql2) or die(pg_last_error($conn));
						$tot_reg = pg_numrows($result2);
						$num_tot_pag = ceil($tot_reg/$cantidad);
						$qry="SELECT * FROM DIN_NOTICIAS WHERE tipo='2' order by fecha desc limit $cantidad offset $desde";
						$resultq = @pg_Exec($connection,$qry);
						$num = pg_numrows($resultq);
						$num;
						$fila2 = @pg_fetch_array($resultq,0);
					    for($i=0;$i < @pg_numrows($resultq);$i++){
						   $fila2 = @pg_fetch_array($resultq,$i);
						   $n = $i+1;
						   $detalle2 = substr($fila2['tx_titulo'],0,100); 
								if ($fila2['estado']==1){?>
									<tr height="30">
<td valign="bottom" bgcolor="#FFFFFF" class="content"><a href="detalle_noticia.php?id=<?=$fila2['id_noticia']?>"><? echo $fila2['fecha']?></a> <? if ($i==0){ ?><img src="nuevo_animado.gif"> <? } ?></td>
<td bgcolor="#FFFFFF" class="content"><a href="detalle_noticia.php?id=<?=$fila2['id_noticia']?>"><? echo "$detalle2 ..."?></a></td>
									</tr>
							<? }
					  } ?>
                      
                      
        <tr>
						<td width="100%" height="36"  colspan="2" align="center" class="textonegrita">BOLETINES <img src="images/icono_boletin2.png" width="24" height="26"></td>
					  </tr>
                      <?
					   	$sql3="SELECT * FROM din_noticias  WHERE tipo='3' and estado='1' order by id_noticia desc";
						$result3 = @pg_Exec($connection,$sql3) or die(pg_last_error($conn));
						
						for($x=0;$x<pg_num_rows($result3);$x++){
						$fila3= pg_fetch_array($result3,$x);
						$detalle3 = substr($fila3['tx_titulo'],0,100); 
						
					?>
                      <tr height="30">
  <td valign="bottom" bgcolor="#FFFFFF" class="content"><a href="detalle_noticia.php?id=<?=$fila3['id_noticia']?>"><? echo $fila3['fecha']?></a> <? if ($x==0){ ?><img src="nuevo_animado.gif"> <? } ?></td>
  <td align="left" bgcolor="#FFFFFF" class="content"><a href="detalle_noticia.php?id=<?=$fila3['id_noticia']?>"><? echo "$detalle3 ..."?></a></td>
                        
  <?php
						}
?>
</tr>
                      <tr height="30">
                      <td  colspan="2" bgcolor="#FFFFFF" class="content"><MARQUEE TITLE="Para interrumpir el desplazamiento, pulsa el botón del ratón" ONMOUSEDOWN="this.stop();" ONMOUSEUP="this.start();">

 <p>&nbsp;&nbsp;&nbsp;<img  align="top"src="images/logo_adv.png" alt="" />&nbsp;&nbsp;&nbsp;<img  src="images/logo_penalolen.jpg" alt=""/>&nbsp;&nbsp;&nbsp;<img  src="images/logo_vina.png" alt=""/>&nbsp;&nbsp;&nbsp;<!--<img  src="images/logo_huara.png" alt=""/>-->&nbsp;&nbsp;&nbsp;<img  src="images/logo_fodec.png" alt=""/>

</MARQUEE>

<hr></td>
                      
                      </tr>
                      </table>
			<!-- termina tabla noticia-->
									 </td>
									 </tr>

								  <? 
								   }?>
                                    <tr>
                                      <td align="center" valign="top">&nbsp; </td>
                                    </tr>
                                  </table>
								 
								  
								  
								  
								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">
                  <br></td>
                    </tr>
                  </table></td>
              </tr> 
            </table></td>
          <td width="53" align="left" valign="top" background="<?=$_IMAGEN_DERECHA?>" >&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
<? include("cabecera/menu_inferior.php");?>
<div id="recha" title="Planificaciones rechazadas"></div>
<!--<div id="miVentana" style="position: fixed; width: 580px; height: 490px; top: 0; left: 500px; font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif  Tahoma, Geneva, sans-serifVerdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: normal; border: #079 4px solid; background-color: #F9F9F9; color:  #09F; display:block;" >

<table align="center"width="550px" height="450px" border="0" > 

<tr> 
<td>&nbsp;</td>
<td><p>Estimado usuario:</p>
  <p>El Martes 31 de Diciembre el servicio de soporte estar&aacute; suspendido, quedando habilitado para responder sus dudas nuestro mail soporte@eduimpulsa.com</p>
  <p><br>
  
  <p>Atentamente<br>
    
    Colegio Interactivo.<br><br>
  </p>
 </p></td>

</tr>
<tr>
<td  align="right" colspan="2"> <input type="button" class="botonXX" value= "CERRAR" onClick="ocultarVentana()"> 
</tr>
</tr>
</table>

</div>-->

<map name="Map"><area shape="rect" coords="5,5,112,145" href="download/OTROS SERVICIOS Y PRODUCTOS.pdf">
</map></body>
<?php if($institucion==10774 &&( $_PERFIL==15 || $_PERFIL==16)){
	
	
	
	if($_PERFIL==15){$prf="apoderado";}
	if($_PERFIL==16){$prf="alumno";}
	  
$sql_veoarchivo = "select * from archivo 
inner join adjunta on adjunta.id_archivo = archivo.id_archivo
where $prf not like '%$_NOMBREUSUARIO%' and $prf !='1' and adjunta.id_ramo IN
(select id_ramo from ramo where id_curso= $curso)";
$rs_veoarchivo = pg_exec($conn,$sql_veoarchivo);


//mensajeria
if($_PERFIL==15){$cadq="or user2men ='$_ALUMNO' ";}

$sql_me="SELECT * FROM mensajero WHERE lee=0 and (user2men='$_NOMBREUSUARIO' $cadq) Order by fecha";
$rs_me = pg_exec($conn,$sql_me);

if($_PERFIL==15){
//citaciones
  $sql_asis = "select * from citacion_asistencia inner join citacion on
citacion_asistencia.id_citacion = citacion.id_citacion where rut_apo= $_NOMBREUSUARIO  and id_ano=$_ANO and estado=0;";
$rs_ci = pg_exec($conn,$sql_asis);
}


?><?php  if(pg_numrows($rs_veoarchivo)>0 || pg_numrows($rs_me)>0 || pg_numrows($rs_ci)>0){?>
<link rel="stylesheet" href="../admin/clases/jquery-ui-1.8.14.custom/development-bundle/themes/base/jquery.ui.all.css">
	<script src="admin/clases/jquery-ui-1.8.14.custom/development-bundle/jquery-1.5.1.js"></script>
	<script src="admin/clases/jquery-ui-1.8.14.custom/development-bundle/external/jquery.bgiframe-2.1.2.js"></script>
	<script src="admin/clases/jquery-ui-1.8.14.custom/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="admin/clases/jquery-ui-1.8.14.custom/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="admin/clases/jquery-ui-1.8.14.custom/development-bundle/ui/jquery.ui.mouse.js"></script>
	<script src="admin/clases/jquery-ui-1.8.14.custom/development-bundle/ui/jquery.ui.draggable.js"></script>
	<script src="admin/clases/jquery-ui-1.8.14.custom/development-bundle/ui/jquery.ui.position.js"></script>
	<script src="admin/clases/jquery-ui-1.8.14.custom/development-bundle/ui/jquery.ui.resizable.js"></script>
	<script src="admin/clases/jquery-ui-1.8.14.custom/development-bundle/ui/jquery.ui.dialog.js"></script>
	<link rel="stylesheet" href="admin/clases/jquery-ui-1.8.14.custom/development-bundle/demos/demos.css">
	<script>
	$(function() {
		$( "#notimens" ).dialog(
		{
			height:150,
			width:400
			}
		);
	});
	</script>
    <div id="notimens" title="Notificaciones">
   
  <?php  if(pg_numrows($rs_veoarchivo)>0){?> 
  
   <p style="color:#F00; font-weight:bold">Existe nuevo material de estudio disponible</p>
   <?php }?>
   <?php  if(pg_numrows($rs_me)>0){?> 
     <p style="color:#F00; font-weight:bold">Tiene <?php echo pg_numrows($rs_me);?> nuevos(s) mensaje(s) sin leer en mensajer&iacute;a</p>
   <?php }?>
   <?php  if(pg_numrows($rs_ci)>0 && $_PERFIL==15){?> 
     <p style="color:#F00; font-weight:bold">Tiene citaciones pendientes</p>
   <?php }?>
   

</div>
<?php }?>
<?php }?>
<?php  if($_PERFIL == 17){
	$sql_chkRA= "select r.id_curso, r.id_ramo,s.nombre,count(*) as cuenta from archivo_alumno aa
inner join adjunta ad on ad.id_archivo = aa.id_archivo
inner join ramo r on r.id_ramo = ad.id_ramo
inner join dicta d on d.id_ramo = r.id_ramo
inner join subsector s on s.cod_subsector = r.cod_subsector
where d.rut_emp = ".$_NOMBREUSUARIO." and visto=0 group by 1,2,3;";

$rs_chkRA= pg_exec($conn,$sql_chkRA);
if(pg_numrows($rs_chkRA)>0){
	$cadNOT = "";
	for($ra=0;$ra<pg_numrows($rs_chkRA);$ra++){
	$fila_ra = pg_fetch_array($rs_chkRA,$ra);
	$cadNOT.=CursoPalabra($fila_ra['id_curso'],1,$conn)." - ".$fila_ra['nombre']."(".$fila_ra['cuenta'].")<br>";
	}
	
	?>
 <script>
  $(function() {
	  $( "#avisora" ).html("<b>Usted tiene arhivo(s) sin ver en el módulo de archivos de las siguientes asignaturas:</b><br><br><?php echo $cadNOT ?>");
     	 $("#avisora").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
   Width: 400,
   Height: 300,
   minWidth: 400,
   minHeight: 300,
   maxWidth: 400,
   maxHeight: 300,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
		 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}    
  })

  });
  </script>
<?php 
}
}?>
<style>
.ui-dialog .ui-dialog-content {
    background: none repeat scroll 0 0 transparent;
    border: 0 none;
    overflow: auto;
    padding: 0.5em 1em;
    position: relative;
    font-size: 12px;
}
</style>
  <div id="avisora" title="Aviso mensajer&iacute;a Archivos"></div>
</html>
<? pg_close($conn);
pg_close($connection);?>