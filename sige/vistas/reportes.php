<?     header( 'Content-type: text/html; charset=iso-8859-1' );

require_once('../../util/header.inc');
require_once('../Controlador_Masivo.php');

$Obj = new Controlador_Masivo($connection,"reportes.php","ReportesModelo");

	switch ($_GET['var'])
	{

	  case 1:

		echo "<form name='form_patoc' id='form_patoc' >";  
		
		echo "<h1>Motor de Busqueda</h1>";
		
		echo "<div>";
		
		echo "<p><label>Nacional : </label>".$Obj->carga_select($r=$_GET['cmb_nacional'],"cmb_nacional",
		$Obj->Retorno_Array_Select("SELECT * FROM nacional"),'var=1','Todos')."</p>";
		
		if(!empty($_GET['cmb_nacional']))
		echo "<p><label>".$Obj->formato_utf8('Corporación')." : </label>".$Obj->carga_select($r=$_GET['cmb_corp'],"cmb_corp",$Obj->Retorno_Array_Select("SELECT co.num_corp,co.nombre_corp FROM corporacion co 
		inner join nacional_corp na on na.num_corp = co.num_corp WHERE na.id_nacional = ".$_GET['cmb_nacional']." "),'var=1','Todos')."</p>";
		
																					
	if(!empty($_GET['cmb_corp'])) echo "<p><label>".$Obj->formato_utf8('Institución')." : </label>".$Obj->carga_select($r=$_GET['cmb_institucion'],"cmb_institucion",$Obj->Retorno_Array_Select("SELECT a.rdb,a.nombre_instit FROM institucion as a 
	INNER JOIN corp_instit c ON c.rdb = a.rdb WHERE c.num_corp = ".$_GET['cmb_corp']." "),NULL,'Todos')."</p>";	
		
		echo "</div>";
		
		echo "<br/><br/>";
		
		echo "<div>";
		
		echo "<p><label>Encuestas : </label>".$Obj->carga_select($r=$_GET['cmb_encuesta'],"cmb_encuesta",
		$Obj->Retorno_Array_Select("SELECT en.id_enc,en.nombre_encuesta FROM encuesta.encuestas en WHERE en.estado = 't' "),'var=1','Todos')."</p>";
		
		if(!empty($_GET['cmb_encuesta']))
		echo "<p><label>Preguntas : </label>".$Obj->carga_select($r=$_GET['cmb_preg'],"cmb_preg",
		$Obj->Retorno_Array_Select("SELECT preg.id_preg,substr(preg.pregunta,0,40) FROM encuesta.preguntas_encuesta preg 
		WHERE preg.id_enc = ".$_GET['cmb_encuesta']." "),NULL,'Todos');
		
		echo "</div>";
																			 
		echo "<br/><br/><input name='buscar' type='button'  id='buscar' value='Buscar' class='botonXX' onclick=enviapag('reportes.php?var=2') />";
																			 
        echo "<form>";
	  	
		break;	
	  
	 case 2:

		//print_r($_GET);
		$filtros = "";
		
		if(!empty($_GET['cmb_nacional']))
		$filtros .= ' AND f.id_nacional = '.$_GET['cmb_nacional'];
			
		if(!empty($_GET['cmb_corp']))
		$filtros .= ' AND d.num_corp = '.$_GET['cmb_corp'];

		if(!empty($_GET['cmb_institucion']))
		$filtros .= ' AND b.rdb = '.$_GET['cmb_institucion'];

		if(!empty($_GET['cmb_preg']))
		$filtros .= ' AND preg.id_preg = '.$_GET['cmb_preg'];
		 
		 $sql = "SELECT 
				  en.nombre_encuesta,
				  substr(preg.pregunta,0,60) as preguntas ,
				  count(a.for_id_preg) as cant_respuestas,
				  SUM(CAST(a.respuestas as integer)) as suma_respuestas,
				  (SUM(CAST(a.respuestas as integer)) / count(a.for_id_preg)) as promedio_respuestas, 
				  b.nombre_instit as institucion,
				  d.nombre_corp as corporacion,
				  f.nombre as nacional
				  FROM 
				  encuesta.respuestas_encuestas a 
				  INNER JOIN public.institucion as b on b.rdb = a.rdb
				  INNER JOIN public.corp_instit as c on c.rdb = b.rdb
				  INNER JOIN public.corporacion as d on d.num_corp = c.num_corp
				  INNER JOIN public.nacional_corp as e on e.num_corp = d.num_corp
				  INNER JOIN public.nacional as f on f.id_nacional = e.id_nacional
				  INNER JOIN encuesta.preguntas_encuesta as preg on preg.id_preg = a.for_id_preg
				  INNER JOIN encuesta.encuestas as en on en.id_enc = preg.id_enc
				  WHERE 
				  respuestas in (10,20,30,40,50,60,70)
				  AND en.estado = 't'
				  $filtros
				  GROUP BY 1,2,6,7,8";

         	//Nombre a los campos y nombre a las acciones sino se toman los por defecto
			echo "<h1>Listado Resultados Encuesta</h1>";
			$result =  $Obj->Listado_Resultados($sql);
			
	    
		break;
	  
	 case 3:
	    
	    header('Content-Type: application/vnd.ms-excel');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('content-disposition: attachment;filename=resultado_encuesta.xls');

		break;	
	
	}

?>