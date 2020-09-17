<?
require('../../../../../util/header.inc');

 $rut_apo=$_POST['rut_apo'];
function generaCurso($ano,$conn){
	
	 $sql="select id_curso from curso where id_ano=".$ano;
	$rs_curso = pg_exec($conn,$sql);

    // Voy imprimiendo el primer select compuesto por los cursos
	echo "<select name='cmb_curso' id='cmb_curso' onChange='cargaContenido(this.id)'>";
	echo "<option value='0'>Elige</option>";
	for($i=0;$i<pg_numrows($rs_curso);$i++)
	{
		$fila = @pg_fetch_array($rs_curso,$i);
		$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
			echo "<option value='".$fila['id_curso']."'>".$Curso_pal."</option>";
	}
	
	echo "</select>";
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="selectFichaAlumno.js"></script>




<script>

 function guarda_relacion(){
	 
 var rut_alumno= $('#cmb_alumno').val();	 
 var rut_apo="<?=$rut_apo;?>";
	  
	var responsable=$("#responsable").attr("checked");
	if(responsable) {
	var responsable=1;
	} else {
	var responsable=0;
	}
	var sostenedor=$("#sostenedor").attr("checked");
	if(sostenedor) {
	var sostenedor=1;
	} else {
	var sostenedor=0;
	}
	var guarda_apo=1;
	var parametros = "rut_alumno="+rut_alumno+"&rut_apo="+rut_apo+"&responsable="+responsable+"&sostenedor="+sostenedor+"&guarda_apo="+guarda_apo;
	//alert(parametros);
	
	$.ajax({
		  url:'guardarelacion.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
					if(data==1){
					alert("Datos Guardados");
					}else if(data==2){
					alert("Apoderado y relación al alumno ya existen");
					}
					
					else{
						alert("Error al Guardar");
						}
				     }
		         })
	
	
	
	}
 
 	function descheck(form){
		if(form.responsable.checked==1){
			form.sostenedor.disabled=true;
			}else{
			form.sostenedor.disabled=false;	
			}
			
		if(form.sostenedor.checked==1){
			form.responsable.disabled=true;
			}else{
			form.responsable.disabled=false;	
			}
		
		}
 
 
</script>

<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
</head>




<form id="form" name="form">

<table width="100%" height="43" border="1" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td class="tableindex">Buscador Avanzado </td>
                                          </tr>
                                          <tr>
                                            <td height="27"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
 
       <td width="130" class="cuadro01">Curso <br>
       <br>	   </td> 
       <td width="21" class="cuadro01">:</td>
       <td width="495" class="cuadro01">
		<? generaCurso($ano,$conn); 
		?>		</td>
        </tr>
        <tr>
        <td class="cuadro01">Alumno</td>
        <td width="21" class="cuadro01">:</td>
        <td width="495" class="cuadro01">
		
		<div id="c_alumno" >
		<select disabled="disabled" name="cmb_alumno" id="cmb_alumno">
          <option value="0">Selecciona opci&oacute;n...</option>
        </select>										  
		</div>		</td>
         </tr>
              <tr>
                <td class="cuadro01">Responsable </td>
                  <td width="21" class="cuadro01">:</td>
                    <td width="495" class="cuadro01"><input name="responsable" type="checkbox" id="responsable" value="checkbox" onChange="descheck(this.form)"></td>
                    </tr>
   <tr>
                <td class="cuadro01">Sostenedor </td>
                  <td width="21" class="cuadro01">:</td>
                    <td width="495" class="cuadro01"><input name="sostenedor" type="checkbox" id="sostenedor" value="0" onChange="descheck(this.form)"></td>
                    </tr>                 
                        <tr>
                           <td class="cuadro01">&nbsp;</td>
              <td width="21" class="cuadro01">&nbsp;</td>
              <td width="495" class="cuadro01"><input name="guardar" type="button" class="botonXX"  id="guardar" value="Guardar" onClick="guarda_relacion()"></td>
                        </tr>
                               </table>							   </td>
                                          </tr>
                                      </table>
</form>                                      
</body>
</html>