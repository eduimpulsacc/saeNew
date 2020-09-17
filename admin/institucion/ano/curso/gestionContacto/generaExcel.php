<?php
session_start();

$id_base=$_SESSION['_ID_BASE'];
$ano=$_SESSION['_ANO'];
$institucion =$_SESSION['_INSTIT'];
$id_periodo = $_GET['ipe'];

//var_dump($_SESSION);


//convertir posiciones de letras y numeros
function letraNum($letra){
$letras = array('A'=>1,'B'=>2,'C'=>3,'D'=>4,'E'=>5,'F'=>6,'G'=>7,'H'=>8,'I'=>9,'J'=>10,'K'=>11,'L'=>12,'M'=>13,'N'=>14,'O'=>15,'P'=>16,'Q'=>17,'R'=>18,'S'=>19,'T'=>20,'U'=>21,'V'=>22,'W'=>23,'X'=>24,'Y'=>25,'Z'=>26);
   return $letras[$letra];
}


function numLetra($num){
$nums= array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E',6=>'F',7=>'G',8=>'H',9=>'I',10=>'J',11=>'K',12=>'L',13=>'M',14=>'N',15=>'O',16=>'P',17=>'Q',18=>'R',19=>'S',20=>'T',21=>'U',22=>'V',23=>'W',24=>'X',25=>'Y',26=>'Z');
   return $nums[$num];
}

//eliminar caracteres especiales
function sanear_string($string)
{

    $string = trim($string);

    $string = str_replace(
        array("á", "à", "ä", "â", "ª", "Á", "À", "Â", "Ä"),
        array("a", "a", "a", "a", "a", "A", "A", "A", "A"),
        $string
    );

    $string = str_replace(
        array("é", "è", "ë", "ê", "É", "È", "Ê", "Ë"),
        array("e", "e", "e", "e", "E", "E", "E", "E"),
        $string
    );

    $string = str_replace(
        array("í", "ì", "ï", "î", "Í", "Ì", "Ï", "Î"),
        array("i", "i", "i", "i", "I", "I", "I", "I"),
        $string
    );

    $string = str_replace(
        array("ó", "ò", "ö", "ô", "Ó", "Ò", "Ö", "Ô"),
        array("o", "o", "o", "o", "O", "O", "O", "O"),
        $string
    );

    $string = str_replace(
        array("ú", "ù", "ü", "û", "Ú", "Ù", "Û", "Ü"),
        array("u", "u", "u", "u", "U", "U", "U", "U"),
        $string
    );

    $string = str_replace(
        array("ñ", "Ñ", "ç", "Ç"),
        array("n", "N", "c", "C"),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~","#", "@", "|", "!", "\"","·", "$", "%", "&", "/", "?", "'", "¡","¿", "[", "^", "`", "]","+", "}", "{", "¨", "´",">", "< "),
        ' ',
        $string
    );


    return $string;
}


if($id_base ==1){
	$b= "coi_final";
  $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
  $b= "coi_final_vina";
	$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vina");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi?a");	
	}

  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	 $b= "coi_corporaciones";
$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");
	 }



/** Incluir la libreria PHPExcel */
require_once '../../../../clases/PHPExcel/Classes/PHPExcel.php';
//require_once('../../../../../util/header.php');

// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

// Establecer propiedades
$objPHPExcel->getProperties()
->setCreator("COI")
->setLastModifiedBy("COI")
->setTitle("Planilla SIGE")
->setSubject("Planilla SIGE")
->setDescription("Planilla SIGE")
->setKeywords("Planilla SIGE")
->setCategory("Planilla SIGE");







//armar los cursos
$sql_cur ="select c.grado_curso,c.ensenanza,te.nombre_tipo,c.id_curso from curso c
 inner join matricula m on m.id_curso = c.id_curso
 inner join tipo_ensenanza2 te on te.cod_tipo = c.ensenanza
 where m.id_ano=$ano
 group by grado_curso,ensenanza,te.nombre_tipo,c.id_curso
 order by ensenanza,grado_curso";
$rs_cur = pg_exec($conn,$sql_cur);


 $sql_preg="select * from gestion_periodo_pregunta order by nro_pregunta";
$rs_preg = pg_exec($conn,$sql_preg);





$objPHPExcel->setActiveSheetIndex(0)->getRowDimension('1')->setRowHeight(105);

//Montaje Preguntas
for($p=0;$p<pg_numrows($rs_preg);$p++){
	
	$fila_preg = pg_fetch_array($rs_preg,$p);
	
	$txtp =$fila_preg['texto_pregunta'];
	$txtp = str_replace("<br>","\r",$txtp);
	$txtp = str_replace("<b>","",$txtp);
	$txtp = str_replace("</b>","",$txtp);
	$txtp=utf8_encode($txtp);
	$pos1 = 1+$paso;
	$pos2 = 2+$paso;
	$pos3 = 3+$paso;
	
	$letraPos1=numLetra($pos1)."1";
	$letraPos2=numLetra($pos2)."1";
	$letraPos3=numLetra($pos3)."1";
	
	
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension(numLetra($pos1))->setWidth(2);
	
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension(numLetra($pos2))->setWidth(3);
	
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension(numLetra($pos3))->setWidth(44);
	
	
	$objPHPExcel->setActiveSheetIndex(0)->getStyle(numLetra($pos3))->getFont()->setBold(true);
	
	$objPHPExcel->setActiveSheetIndex(0)->getStyle(numLetra($pos3))->getAlignment()->setWrapText(true);
	
	$objPHPExcel->setActiveSheetIndex(0)->getStyle(numLetra($pos3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	
	$objPHPExcel->setActiveSheetIndex(0)->getStyle(numLetra($pos3))->getAlignment()->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	
	$objPHPExcel->setActiveSheetIndex(0)->getStyle(numLetra($pos3))->getAlignment()->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	
	
	
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letraPos1, '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letraPos2, '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letraPos3, $txtp);
	$paso = (3*$p)+3;
	
	$objPHPExcel->setActiveSheetIndex(0)->getStyle($letraPos3)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,				
                )
            )
        ));	
	
}  


//montaje_alternativas
$sql_max = "select max(nro_alternativa) from gestion_periodo_alterantiva_pregunta";
$rs_max=pg_exec($conn,$sql_max);
$max = pg_result($rs_max,0);


for($ma=1;$ma<=$max;$ma++){
$paso=0;	
	$rowA = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow()+1;
	
	for($p=0;$p<pg_numrows($rs_preg);$p++){
	 $fila_preg = pg_fetch_array($rs_preg,$p);
	
	 $cp =$fila_preg['id_pregunta'];
	 
	 $sq_alt="select * from gestion_periodo_alterantiva_pregunta where nro_pregunta=$cp and nro_alternativa=$ma";
	 
	 
	 $rs_alt = pg_exec($conn,$sq_alt);
	 
	 $fila_alt = pg_fetch_array($rs_alt,0);
	 $nro_alt = $fila_alt['nro_alternativa'];
	 $texto_alt = utf8_encode($fila_alt['texto_alternativa']);
	 
	 $largo_alt = strlen($fila_alt['texto_alternativa']);
	
		$pos1 = 1+$paso;
		$pos2 = 2+$paso;
		$pos3 = 3+$paso;
		
		
		$letraPos1=numLetra($pos1).$rowA;
		$letraPos2=numLetra($pos2).$rowA;
		$letraPos3=numLetra($pos3).$rowA;
		
		
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letraPos1, '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letraPos2, $nro_alt);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letraPos3, $texto_alt);
	
	
	
	 $paso = (3*$p)+3;
	
	if( $largo_alt>0){
	$objPHPExcel->setActiveSheetIndex(0)->getStyle($letraPos2.":".$letraPos3)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,				
                )
            )
        ));	
	}
	
	
	
	}
	
	
}	


// exit;		

 	
			

// Renombrar Hoja
$nho = utf8_encode("Indicación");
$objPHPExcel->getActiveSheet()->setTitle($nho);


for($c=0;$c<pg_numrows($rs_cur);$c++){
	$hoja=$c+1;
	$fila_c = pg_fetch_array($rs_cur,$c);
	$ensenanza = $fila_c['ensenanza'];
	$grado = $fila_c['grado_curso'];
	$id_curso = $fila_c['id_curso'];
	
	if($ensenanza==10 && $grado==1){
		$nivel ="Sala cuna";	
	}
	elseif($ensenanza==10 && $grado==2){
		$nivel ="Medio Menor";	
	}
	elseif($ensenanza==10 && $grado==3){
		$nivel ="Medio Mayor";	
	}
	elseif($ensenanza==10 && $grado==4){
		$nivel ="1° nivel Transición (Prekinder)";	
	}
	elseif($ensenanza==10 && $grado==5){
		$nivel ="2° nivel Transición (Kinder)";
	}
	elseif($ensenanza==110){
		$nivel =$grado."° básico";
	}
	elseif($ensenanza>=210 && $ensenanza<=300){
		$nivel =$grado."° especial";
	}
	elseif($ensenanza>=300){
		$nivel =$grado."° medio";
	}
	
	$nivel = utf8_encode($nivel);
// Add new sheet
         $objWorkSheet = $objPHPExcel->createSheet($hoja); //Setting index when creating
		$objWorkSheet->getColumnDimension('A')->setWidth(8,57);
		$objWorkSheet->getColumnDimension('B')->setWidth(3);
		$objWorkSheet->getColumnDimension('C')->setWidth(25);
		$objWorkSheet->getColumnDimension('D')->setWidth(15);
		$objWorkSheet->getColumnDimension('E')->setWidth(15);
		$objWorkSheet->getColumnDimension('F')->setWidth(9);
		$objWorkSheet->getColumnDimension('G')->setWidth(6);
		$objWorkSheet->getColumnDimension('H')->setWidth(44);
		$objWorkSheet->getColumnDimension('I')->setWidth(44);
		$objWorkSheet->getColumnDimension('J')->setWidth(44);
		$objWorkSheet->getColumnDimension('K')->setWidth(44);
		
		$objWorkSheet->getRowDimension('1')->setRowHeight(105); 
		
		
         //Write cells
         $objWorkSheet->setCellValue('A1', 'RUT')
                      ->setCellValue('B1', 'Dv')
                      ->setCellValue('C1', 'Nombre')
                      ->setCellValue('D1', 'Apellido paterno')
					  ->setCellValue('E1', 'Apellido paterno')
					  ->setCellValue('F1', 'Nivel')
					  ->setCellValue('G1', 'Curso')
		;
		
		$objWorkSheet->getStyle('D1:E1')->getAlignment()->setWrapText(true);
		
				   
						for($p=0;$p<pg_numrows($rs_preg);$p++){
							$fila_preg = pg_fetch_array($rs_preg,$p);
							$txtp =$fila_preg['texto_pregunta'];
							$txtp = str_replace("<br>","\r",$txtp);
							$txtp = str_replace("<b>","",$txtp);
							$txtp = str_replace("</b>","",$txtp);
							$txtp=utf8_encode($txtp);
							$pos = 8+$p;
							$letraPos=numLetra($pos)."1";
							$objWorkSheet->setCellValue($letraPos, $txtp);
							$objWorkSheet->getStyle($letraPos)->getAlignment()->setWrapText(true);
							
						}  
						
						
						
						
			$objWorkSheet->getStyle('A1:'.$letraPos)->getFont()->setBold(true);
			$objWorkSheet->getStyle('A1:'.$letraPos)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objWorkSheet->getStyle('A1:'.$letraPos)->getAlignment()->setVERTICAL(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					 
			
		//alimentar las filas con los alumnos
		$sql_alu  = "select al.rut_alumno,al.dig_rut,al.ape_pat,al.ape_mat,al.nombre_alu,c.letra_curso
		 from alumno al
		inner join matricula m on m.rut_alumno = al.rut_alumno
		inner join curso c on c.id_curso = m.id_curso
		where m.id_ano=$ano and c.ensenanza = $ensenanza and c.grado_curso=$grado and m.bool_ar=0
		order by c.letra_curso,m.nro_lista";
		$rs_alu = pg_exec($conn,$sql_alu);
		
		if(pg_numrows($rs_alu)>0){
			for($al=0;$al<pg_numrows($rs_alu);$al++){
				$fila_alu = pg_fetch_array($rs_alu,$al);
				$rut = $fila_alu['rut_alumno'];
				$ape_pat = utf8_encode($fila_alu['ape_pat']);
				$ape_mat = utf8_encode($fila_alu['ape_mat']);
				$nombre_alu = utf8_encode($fila_alu['nombre_alu']);
				$letra_curso = utf8_encode($fila_alu['letra_curso']);
				$row = $objWorkSheet->getHighestRow()+1;
				$objWorkSheet->SetCellValue('A'.$row, $rut)
                   ->setCellValue('B'.$row, strtoupper($fila_alu['dig_rut']))
                   ->setCellValue('C'.$row, strtoupper($nombre_alu))  
                   ->setCellValue('D'.$row, strtoupper($ape_pat))
				   ->setCellValue('E'.$row, strtoupper($ape_mat))
				   ->setCellValue('F'.$row, $nivel)
				   ->setCellValue('G'.$row, $letra_curso)			
		;
		
		
		
		for($p=0;$p<pg_numrows($rs_preg);$p++){
							$fila_preg = pg_fetch_array($rs_preg,$p);
							$cod_pregunta =$fila_preg['id_pregunta'];
							
					//echo "<br>".
						$sqlR="select re.cod_respuesta,al.texto_alternativa from gestion_periodo_respuesta re
inner join gestion_periodo_alterantiva_pregunta al on al.id_alternativa = re.cod_respuesta
where re.cod_pregunta=$cod_pregunta and id_periodo=$id_periodo and id_curso=$id_curso and rut_alumno=$rut";
//exit;
	$rsR = pg_exec($conn,$sqlR);
	
	$respuesta = (pg_numrows($rsR)>0)?utf8_encode(pg_result($rsR,1)):"";
							
							
							$pos = 8+$p;
							$letraPos=numLetra($pos).$row;
							$objWorkSheet->setCellValue($letraPos, $respuesta);
							$objWorkSheet->getStyle($letraPos)->getAlignment()->setWrapText(true);
				
				
				 $objWorkSheet->getStyle('A'.$row.":".$letraPos)->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,				
                )
            )
        ));		
		
		
			
			}  
				
			}
		}	 

         // Rename sheet
         $objWorkSheet->setTitle("$nivel");
		 
		 $objWorkSheet->getStyle("A1:K1")->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
					
                )
            )
        ));
		
	
	
	
}

// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);


// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Planilla SIGE.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

?>