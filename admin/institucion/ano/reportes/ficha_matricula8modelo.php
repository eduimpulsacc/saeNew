<?php require('../../../../util/header.inc');
 
$institucion= $_INSTIT;?>
<html xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<style>
table{font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:11px;
}
</style>
</head>

<body lang=ES>
<div class=textosimple>
  <table border=1 cellspacing=0 cellpadding=0 width=755>
    <tr>
      <td width=335 colspan=7 class="textonegrita"><p><?
						if($institucion!=""){
							echo "<img src='../../../../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?></p>
        <p>&nbsp;<? $sql="SELECT nombre_instit,rdb,dig_rdb FROM institucion WHERE rdb=".$institucion;
		$rs_instit = pg_exec($conn,$sql);
		echo pg_result($rs_instit,0);
	?></p>
        <p><b>  &nbsp; RBD <?php  echo pg_result($rs_instit,1); ?>-<?php echo pg_result($rs_instit,2);?></b></p></td>
      <td width=169 colspan=5 valign=top><p><b>Año </b></p>
        <p>Nº
          Matrícula</p>
        <p>Fecha
          Ingreso</p>
        <p>Jornada</p>
        <p>Curso</p></td>
      <td width=146 colspan=4 valign=top><p align=center style='
  text-align:center'><b></b></p>
        <p align=center style='
  text-align:center'>&nbsp;</p>
        <p align=center style='
  text-align:center'>&nbsp;</p>
        <p align=center style='
  text-align:center'>&nbsp;</p></td>
      <td width=106 colspan=2 valign=top><p align=center style='
  text-align:center'>FOTO</p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=754 colspan=17 valign=top>&nbsp;</td>
    </tr>
    <tr>
      <td width=0>&nbsp;</td>
      <td width=754 colspan=17 valign=top><p align=center style='
  text-align:center'><b>FICHA
          DE MATRICULA</b></p></td>
    </tr>
    <tr>
      <td  width=0>&nbsp;</td>
      <td width=503 colspan=11 valign=top><p><b>IDENTIFICACIÓN
          DEL ALUMNO</b></p></td>
      <td width=252 colspan=6 valign=top><p>RUT:   </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=754 colspan=17 valign=top><p>NOMBRE:
      </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=452 colspan=9 valign=top><p>FECHA
      DE NACIMIENTO: </p></td>
      <td width=302 colspan=8 valign=top><p>EDAD
      AL 31 DE MARZO: </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=613 colspan=14 valign=top><p>DIRECCIÓN:
      </p></td>
      <td width=141 colspan=3 valign=top><p>COMUNA:
      </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=158 valign=top><p>ENFERMEDADES
          CRÓNICAS:</p></td>
      <td width=228 colspan=6><p align=center style='
  text-align:center'>&nbsp;</p></td>
      <td width=117 colspan=4 valign=top><p>ALERGIAS
          ALIMENTOS:</p></td>
      <td width=252 colspan=6><p align=center style='
  text-align:center'>&nbsp;</p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=319 colspan=5 valign=top><p><b>ANTECEDENTES
          FAMILIARES:</b></p></td>
      <td width=436 colspan=12 valign=top><p>ESTADO
      CIVIL DE LOS PADRES: </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=545 colspan=13 valign=top><p>NOMBRE
       PADRE: </p></td>
      <td width=209 colspan=4 valign=top><p>EDAD:
      </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=545 colspan=13 valign=top><p>OCUPACIÓN: </p></td>
      <td width=209 colspan=4 valign=top><p>ESCOLARIDAD:</p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=545 colspan=13 valign=top><p>DIRECCIÓN:
      </p></td>
      <td width=209 colspan=4 valign=top><p>TELÉFONO:
      </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=545 colspan=13 valign=top><p>NOMBRE
       MADRE: </p></td>
      <td width=209 colspan=4 valign=top><p>EDAD: </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=545 colspan=13 valign=top><p>OCUPACIÓN: </p></td>
      <td width=209 colspan=4 valign=top><p>ESCOLARIDAD:
      </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=545 colspan=13 valign=top><p>DIRECCIÓN:
      </p></td>
      <td width=209 colspan=4 valign=top><p>TELÉFONO:
      </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=432 colspan=8 valign=top><p>Nº
      DE HERMANOS: </p></td>
      <td width=322 colspan=9 valign=top><p>LUGAR
          QUE OCUPA:  </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=754 colspan=17 valign=top><p>PERSONAS
      CON QUIEN VIVE: </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=545 colspan=13 valign=top><p>NOMBRE
      DEL APODERADO: </p></td>
      <td width=209 colspan=4 valign=top><p>EDAD:
      </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=545 colspan=13 valign=top><p>PARENTESCO: </p></td>
      <td width=209 colspan=4 valign=top><p>RUT: </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=545 colspan=13 valign=top><p>OCUPACIÓN:  </p></td>
      <td width=209 colspan=4 valign=top><p>ESCOLARIDAD:  </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=545 colspan=13 valign=top><p>DIRECCIÓN: </p></td>
      <td width=209 colspan=4 valign=top><p>TELÉFONO:  </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=754 colspan=17 valign=top><p>CORREO
          ELECTRÓNICO:  </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=754 colspan=17 valign=top><p align=center style='
  text-align:center'><b>AUTORIZACIONES</b></p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=203 colspan=2><p align=center style='
  text-align:center'>Cambiar de
          ropa en caso de ser necesario</p></td>
      <td width=36><p align=center style='
  text-align:center'>&nbsp;</p></td>
      <td width=257 colspan=7><p align=center style='
  text-align:center'>Tomar fotografías/videos
          en actividades escolares</p></td>
      <td width=36 colspan=2><p align=center style='
  text-align:center'>&nbsp;</p></td>
      <td width=183 colspan=4><p align=center style='
  text-align:center'>Compartir
          fotografías en facebook Escuela</p></td>
      <td width=39><p align=center style='
  text-align:center'>&nbsp;</p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=203 colspan=2 valign=top><p>RETIRAR
          AL ALUMNO:</p></td>
      <td width=551 colspan=15 valign=top><p>&nbsp;</p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=300 colspan=4 valign=top><p>PROCEDENCIA: </p></td>
      <td width=455 colspan=13 valign=top><p>ELECCIÓN:
      </p></td>
    </tr>
    <tr>
      <td
  width=0>&nbsp;</td>
      <td width=754 colspan=17 valign=top><p style='text-align:justify'>OBSERVACIONES: Al momento de
          matricular a mi pupilo/a en este establecimiento declaro haber sido
          informado, tomar conocimiento y aceptar el <b>Proyecto Educativo Institucional</b>, el <b>Reglamento de Convivencia Escolar</b> y <b>Procedimiento de acción ante Emergencia</b>.</p>
        <p style='text-align:justify'>Me comprometo a apoyar el proceso
          educativo de mi pupilo/a, velando por el cumplimiento de la <b>asistencia a clases</b>, <b>tareas escolares</b> que le sean
          asignadas. Asistir a reuniones, entrevistas y cuando sean citado. Apoyar y
          participar de las actividades extraescolares.</p></td>
    </tr>
    <tr height=0>
      <td width=1></td>
      <td width=158></td>
      <td width=44></td>
      <td width=36></td>
      <td width=59></td>
      <td width=19></td>
      <td width=15></td>
      <td width=52></td>
      <td width=47></td>
      <td width=21></td>
      <td width=44></td>
      <td width=9></td>
      <td width=29></td>
      <td width=13></td>
      <td width=67></td>
      <td width=35></td>
      <td width=66></td>
      <td width=39></td>
    </tr>
  </table>
  <table border=1 cellspacing=0 cellpadding=0 width=756>
    <tr>
      <td width=471 height="150" valign=top>&nbsp;</td>
      <td width=284 valign=baseline><p align=center style='
  text-align:center;'>FIRMA APODERADO</p>
     </td>
    </tr>
  </table>
</div>
</body>
</html>
