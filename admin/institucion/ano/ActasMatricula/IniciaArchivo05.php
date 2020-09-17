<? require('../../../../util/header.inc');

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 9;
	$ano_ac=date("Y");
		
/*	$sql="delete from archivo04 where rdb = $institucion";
	$rsBorra = pg_exec($conn,$sql);*/
	

if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
alert ("No Autorizado");
window.location="../../../../index.php";
</script>
         
<? } ?>

<script language="JavaScript" type="text/JavaScript">

function creararchivo_por_curso(a){
	  if(a!=01){
	    window.location='Archivo05.php?grado_filtro='+a;  
	  }else if(a==01){
		window.location='Archivo05.php'  
	  }else if(a==0){
	    alert("Debe Seleccionar Un Grado");
	  }
   }

</script>
<HTML>
<HEAD>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 12px;
}
.Estilo2 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif;}
.Estilo3 {font-size: 10px}
-->
    </style>
	</HEAD>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
	  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
<td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
<? include("../../../../cabecera/menu_superior.php"); ?>
</td>
</tr>
<tr align="left" valign="top"> 
<td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr> 
<td width="27%" height="363" align="left" valign="top"> 
<? $menu_lateral=3; include ("../../../../menus/menu_lateral.php"); ?></td>
<td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr> 
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr> 
<td height="395" align="left" valign="top"> 
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
<tr> 
<td height="390" valign="top">
<!-- inicio codigo nuevo -->
<div style=" border:1px solid #ccc;padding-top:30px; margin-top:30px; padding-bottom:30px;" align="center"><p>Puede Obtener el Archivo para todos los cursos o Seleccionar un Curso en Particular</p>
<p>
<br/>
<?
$sql_curso=  "SELECT DISTINCT curso.grado_curso,curso.ensenanza,
						CASE 
						WHEN curso.ensenanza = 110 THEN 'Basicos' 
						WHEN curso.ensenanza = 310 THEN 'Media Humanista - Científica'
						 WHEN curso.ensenanza = 363 THEN 'Adulto'
						 WHEN curso.ensenanza = 610 THEN 'Profesional Tecnica'
						 WHEN curso.ensenanza = 510 THEN 'Profesional Industrial '
						 WHEN curso.ensenanza = 410 THEN 'Profesional Comercial '
						END as ensenanzaletra 
						FROM curso WHERE curso.id_ano = ".$ano."
						and ensenanza > 109 order by 2";
$resultado_query_cue = pg_exec($conn,$sql_curso);
        ?>
<select name="select_Curso" id="select_Curso" class="ddlb_x" onChange="creararchivo_por_curso(this.value);">
<option value="0">(Seleccione un Grado)</option>
<option value="01">Todos los Grados</option>
<?
 for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){
 $fila = @pg_fetch_array($resultado_query_cue,$i); 
 echo "<option value=".$fila['grado_curso']."_".$fila['ensenanza']." >".$fila['grado_curso'] ." => ".$fila['ensenanzaletra'] ."</option>";
	 } ?>
  </select> 
</div>
								  
								  <!-- fin codigo nuevo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
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
<? pg_close($conn); ?>
</body>
</html>

