<?php require('../../../../util/header.inc');
?>
                    <td width="163" valign="top"><?
					  /********************************************************CURSOS************************************************/ 
						$qry="SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, cod_tipo FROM tipo_ensenanza INNER JOIN (curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((ano_escolar.id_ano)=".$ano.")) order by curso.grado_curso, curso.letra_curso asc"; 
						echo $qry;
						$result =@pg_Exec($conn,$qry);
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
						
						
						$qry_inasis="select count(id_curso) as alumn_inasis,fecha,id_curso from asistencia where id_curso=".$fila["id_curso"]." group by id_curso,fecha order by id_curso desc";
						$result3 =@pg_Exec($conn,$qry_inasis);
						$fila2 = @pg_result($result3,0);
						$fecha = @pg_result($result3,1);
						$curso = @pg_result($result3,2);	
					/*for($i=0 ; $i < @pg_numrows($result3) ; $i++){
						$fila2 = @pg_fetch_array($result3,$i);
						echo $fila2["alumn_inasis"];
					}*/
						echo "<table border='0' width='280'>";
						echo "<tr><td height='34'><font size='1' face='Arial, Helvetica, sans-serif'>".$fila["grado_curso"]." ".$fila["letra_curso"]." ".$fila["nombre_tipo"]." ".$fila2." ".$fecha." ".$curso."</font></tr></td>";
						echo "</font>";
						echo "</table>";
	 				}
						/**************************************************************FIN CURSOS***********************************/
						?></td>
  
</body>
</html>
