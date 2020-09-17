<?php require('../../../../../util/header.inc'); ?>
<?php
		$institucion= $_INSTIT;
		$frmModo	= $_FRMMODO;
		$ano		= $_ANO;
		$curso		= $_CURSO;


		$i_retir = 0;
		$i_aprob = 0;

		/*********************************************************************************************/
			/*----------------------------- ALUMNOS RETIRADOS ---------------------------------*/
		/*********************************************************************************************/
			for ($i=0;$i<$cantalumret;$i++){
				echo "<br>".$SQL = "UPDATE promocion SET situacion_final=3, fecha_retiro=to_date('" . $fecha[$i] . "','DD MM YYYY') WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND rut_alumno='".Trim($rutalumret[$i])."'";
				//echo ("Fecha:".$SQL."<BR>");
				$ejecutapromocion = @pg_Exec($conn,$SQL);			
			};
		/*********************************************************************************************/
			/*--------------------------- FIN ALUMNOS RETIRADOS -------------------------------*/
		/*********************************************************************************************/

		/*********************************************************************************************/
			/*------------------- ALUMNOS APROBADOS ESPECIALIZADOS ----------------------------*/
		/*********************************************************************************************/
			for ($x=0;$x<$cantalumaprob;$x++){
				/*--- Recupera codigo de rama,sector economico y especialidad ---*/
					$posicion1 = strpos($especialidad[$x],"-");
					//echo ("posicion:".$posicion1."<br>");
					$cod_rama = substr($especialidad[$x],0,$posicion1);
					//echo ("rama:".$cod_rama."<br>");
					$resto1 = substr($especialidad[$x],$posicion1+1);
					//echo ("resto:".$resto1."<br>");
					$posicion2 = strpos($resto1,"-");
					$cod_sector = substr($resto1,0,$posicion2);
					$cod_esp = substr($resto1,$posicion1+1);
					//echo ("Rama:".$cod_rama." Sector:".$cod_sector." Especialidad:".$cod_esp."<BR>");
				/*------------------------ Fin ----------------------------------*/

				$SQL = "UPDATE promocion SET situacion_final=1, cod_rama=" . $cod_rama . ", cod_sector=" . $cod_sector . ", cod_esp=" . $cod_esp . " WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND rut_alumno='".Trim($rutalumaprob[$x])."'";
				//echo ("Especialidad: ".$SQL."<BR>");
				$ejecutapromocion = @pg_Exec($conn,$SQL);			
			};

		/*********************************************************************************************/
			/*----------------- FIN ALUMNOS APROBADOS ESPECIALIZADOS --------------------------*/
		/*********************************************************************************************/
		if($_PERFIL==0){
			exit;
		}
		echo "<script>window.location = 'seteapromocion.php3?institucion=" . $_INSTIT . "&ano=" . $_ANO . "&curso=" . $_CURSO . "&caso=1'</script>";



?>