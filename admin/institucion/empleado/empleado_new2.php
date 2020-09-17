<?
	require('../../../util/header.inc');
	require('../../clases/Class_empleado.php');
	require('../../clases/OpenConnect.php');
?>
<script language="JavaScript" type="text/javascript">
	var ArrayProvincia = new Array();
	var contador_provincia;
	<?
		$sql="SELECT * FROM provincia";
		$resp = pg_exec($conn,$sql);
		$i=0;
		
		if (@pg_numrows($resp)!=0)
			{ 
				$filsprov = @pg_fetch_array($resp,0);
				for ($i=0;$i<@pg_numrows($resp);$i++)
				{
					$filsprov = @pg_fetch_array($resp,$i); ?>
					var ArrayFilProv = new Array(3);
					ArrayFilProv[0] = '<?php echo Trim($filsprov["cor_pro"])?>';
					ArrayFilProv[1] = '<?php echo Trim($filsprov["cod_reg"])?>';
					ArrayFilProv[2] = '<?php echo Trim($filsprov["nom_pro"])?>';
					ArrayProvincia[<?php echo $i?>] = ArrayFilProv;
		<? }
		}?>
			contador_provincia = <?php echo $i?>;
//---------------------- FIN PROVINCIA ---------------------------------//
	//-------------------------- COMUNA ------------------------------------//
	var ArrayComuna = new Array();
	var contador_comuna;
	<?php	$SQL = "SELECT * FROM comuna ORDER BY nom_com";
			$res = @pg_exec($conn,$SQL);
			$i=0;
			
			if (@pg_numrows($res)!=0){
				$filscom = @pg_fetch_array($res,0);
				for ($i=0;$i<@pg_numrows($res);$i++){
					$filscom = @pg_fetch_array($res,$i); ?>
					var ArrayFilCom = new Array(4);
					ArrayFilCom[0] = '<?php echo Trim($filscom["cor_com"])?>';
					ArrayFilCom[1] = '<?php echo Trim($filscom["cor_pro"])?>';
					ArrayFilCom[2] = '<?php echo Trim($filscom["cod_reg"])?>';
					ArrayFilCom[3] = '<?php echo Trim($filscom["nom_com"])?>';
					ArrayComuna[<?php echo $i?>] = ArrayFilCom;
	<?php		};
			};?>
			contador_comuna = <?php echo $i; ?>;
//----------------------- FIN COMUNA -----------------------------------//
//**********************************************************************************************************//
//-------------------------------------------- FIN ARREGLOS ------------------------------------------------//
//**********************************************************************************************************//

//**********************************************************************************************************//
//-------------------------------------------- LLENA COMBO -------------------------------------------------//
//**********************************************************************************************************//

//----------------------- PROVINCIA-----------------------------------//
function LlenaProvincia(){
	var id_search;
	if (document.form1.region.options.selectedIndex!=-1 || document.form1.region.options[document.form1.region.options.selectedIndex].value!="null"){
		id_search = document.form1.region.options[document.form1.region.options.selectedIndex].value;
		if (id_search!=""){
			document.form1.ciudad.length = 0;
			document.form1.ciudad.options[document.form1.ciudad.options.length++] = new Option("Seleccione ciudad");
			document.form1.ciudad.options[document.form1.ciudad.options.length - 1].value = "null";
			document.form1.comuna.length = 0;
			document.form1.comuna.options[document.form1.comuna.options.length++] = new Option("Seleccione Comuna");
			document.form1.comuna.options[document.form1.comuna.options.length - 1].value = "null";
			for(i=0;i<=contador_provincia-1;i++){
				if (id_search==ArrayProvincia[i][1]){
					document.form1.ciudad.options[document.form1.ciudad.options.length++] = new Option(ArrayProvincia[i][2]);
					document.form1.ciudad.options[document.form1.ciudad.options.length - 1].value = ArrayProvincia[i][0];
				};
			};
		};
	};
};
//--------------------- FIN ciudad---------------------------------//

//------------------------- COMUNA ------------------------------------//
function LlenaComuna(){
	var id_search,id_search_aux;
	if (document.form1.ciudad.options.selectedIndex!=-1 || document.form1.ciudad.options[document.form1.ciudad.options.selectedIndex].value!="null"){
		id_search = document.form1.region.options[document.form1.region.options.selectedIndex].value; 
		id_search_aux = document.form1.ciudad.options[document.form1.ciudad.options.selectedIndex].value;
		if (id_search!=""){
			document.form1.comuna.length = 0;
			document.form1.comuna.options[document.form1.comuna.options.length++] = new Option("Seleccione Comuna");
			document.form1.comuna.options[document.form1.comuna.options.length - 1].value = "null";
			for(i=0;i<=contador_comuna-1;i++){
				if (id_search==ArrayComuna[i][2] && id_search_aux==ArrayComuna[i][1]){
					document.form1.comuna.options[document.form1.comuna.options.length++] = new Option(ArrayComuna[i][3]);
					document.form1.comuna.options[document.form1.comuna.options.length - 1].value = ArrayComuna[i][0];
				};
			};
		};
	};
};
function muestra_texto(span){
	var nac = document.form1.nacionalidad.value;
	//alert("nacionalidad02= "+nac);
	document.getElementById('nac1').style.display='block';
	document.getElementById('nac2').style.display='none';
}
function hide_cod(span){
	document.getElementById('cod_reg').style.display='none';
	document.getElementById('cod_pro').style.display='none';
	document.getElementById('cod_com').style.display='none';
}
function muestra_cmb(span){
	document.getElementById('nac2').style.display='block';
	document.getElementById('nac1').style.display='none';
}
function muestra_cmb_R(span){
	document.getElementById('div_region').style.display='block';
	document.getElementById('nom_reg').style.display='none';
}
function muestra_cmb_P(span){
	document.getElementById('div_provincia').style.display='block';
	document.getElementById('nom_pro').style.display='none';

}
function muestra_cmb_C(span){
	document.getElementById('div_comuna').style.display='block';
	document.getElementById('nom_com').style.display='none';
}
function muestra_text_R(span){
	document.getElementById('div_region').style.display='none';
	document.getElementById('nom_reg').style.display='block';
}
function muestra_text_P(span){
	document.getElementById('div_provincia').style.display='none';
	document.getElementById('nom_pro').style.display='block';
}
function muestra_text_C(span){
	document.getElementById('div_comuna').style.display='none';
	document.getElementById('nom_com').style.display='block';
}
function muestra_cargo(span,i){
	document.getElementById('div_cargo'+i+'').style.display='none';
	document.getElementById('cargos'+i+'').style.display='block';
}
function muestra_cmb_cargo(span,i){
	document.getElementById('div_cargo'+i+'').style.display='block';
	document.getElementById('cargos'+i+'').style.display='none';
}
function muestra_estado(span){
	document.getElementById('est_civil').style.display='block';
	document.getElementById('est_c').style.display='none';
}
function muestra_cmb_estado(span){
	document.getElementById('est_c').style.display='block';
	document.getElementById('est_civil').style.display='none';
}
function muestra_sex(span){
	var nac = document.form1.sexo.value;
	document.getElementById('sexo2').style.display='block';
	document.getElementById('sexo1').style.display='none';
}
function muestra_sexo(span){
	var nac = document.form1.sexo.value;
	document.getElementById('sexo2').style.display='none';
	document.getElementById('sexo1').style.display='block';
}
function muestra_txtsub(span){
	//var coun= document.form2.count.value;
	//alert("count="+coun);
	for(i=1;i<3;i++){
	document.getElementById('subsector2'+i+'').style.display='block';
	document.getElementById('div_subsector2'+i+'').style.display='none';
	}
}
function muestra_sub(span,i){
	//var i = document.form2.contador.value;
	//for(i=1;i<3;i++){
	//alert("div="+i);
	document.getElementById('div_subsector2'+i+'').style.display='block';
	document.getElementById('subsector2'+i+'').style.display='none';
	//}
}
function muestra_txttipo_aut(span){
	for(i=1;i<3;i++){
	document.getElementById('tipo_autorizacion'+i+'').style.display='block';
	document.getElementById('div_tipo_autorizacion'+i+'').style.display='none';
	}
}
function muestra_cmb_aut(span,i){
	document.getElementById('div_tipo_autorizacion'+i+'').style.display='block';
	document.getElementById('tipo_autorizacion'+i+'').style.display='none';
	
}
</script>


<?    
	if ($_FRMMODO == NULL){
	   $_FRMMODO = "mostrar";
	}   
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	if ($md==1){
	   $empleado = $_NOMBREUSUARIO;
	   $_EMPLEADO = $_NOMBREUSUARIO;
	}else{	
	   $empleado		=$_EMPLEADO;
	   $_POSP          =3;
	}   
	//$empleado="88888888";
	//$empleado="13658172";
	//$empleado="16908489";
	//$empleado="12419805";
	$ob_inst=new Empleado();
	$ob_inst->institucion=$_INSTIT;
	$rs=$ob_inst->institucion($conn);
	$fila = pg_fetch_array($rs,0);
		$regINS = $fila['region'];
		$proINS = $fila['ciudad'];
		$comINS = $fila['comuna'];
	
	if ($usr==1){
	    $empleado  = $_NOMBREUSUARIO2;
		$_EMPLEADO = $_NOMBREUSUARIO2;
	}

function chekear($num){
   global $fila;
   //echo "entro";
   //echo $num;
	if (($num==1)&&($fila[habilitado]==1)){echo " checked";}
	if (($num==2)&&($fila[titulado]==1)){echo " checked";}
	if (($num==3)&&($fila[tit_otras]==1)){echo " checked";}

}

		$ob_trabaja=new Empleado();
		$ob_trabaja->institucion=trim($_INSTIT);
		$ob_trabaja->empleado=trim($empleado);
		$resV=$ob_trabaja->trabaja($conn);
		$filaV = pg_fetch_array($resV,0);
		if (@pg_numrows($resV)>0){
			$ob_subtr=new Empleado();
			$ob_subtr->institucion=trim($_INSTIT);
			$ob_subtr->id_curso=$filaV['id_curso'];
			$resultVV=$ob_subtr->sub_trabaja($conn);
			if (pg_numrows($resultVV)>0){?>
				<SCRIPT language="JavaScript">///$resV=1;
				  if (document.frm.m1!=0 and document.frm.m2!=0 and document.frm.m3!=0){
				          window.alert("ESTE EMPLEADO ES PROFESOR JEFE. SI DESEA ELIMINARLO PRIMERO DEBE ASIGNAR UN NUEVO PROFESOR JEFE AL CURSO")
				  } 	</SCRIPT>
			<!--?php }else{ ?>
					<SCRIPT language="JavaScript">///$resV=1;
						document.location="seteaEmpleado.php3?caso=9";
					</SCRIPT-->
				
		<? }}?>
	
	<?
	if($frmModo!="ingresar"){
	
		$ob_trabaja1=new Empleado();
		$ob_trabaja1->institucion=trim($_INSTIT);
		$ob_trabaja1->empleado=trim($empleado);
		$result=$ob_trabaja1->trabaja1($conn);
		
		if (!$result) {
		    echo $qry;
			exit();
			 //error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
			}
		}
}

function generar_sexo($conn,$sexo,$empleado)
{
	$sql="SELECT * FROM sexo";
	$resp = pg_exec($conn,$sql);
	$num_sexo = pg_numrows($resp);
	$rg = "'javascript:muestra_sexo(sexo2)'";
									
	echo "<select name='sexo' id='sexo' onblur=".$rg." onchange='cargaContenido(this.id,".$empleado.",1,0,0,0)'>";
	echo "<option value='0'>Elige</option>";
			for($sex=0;$sex<$num_sexo;$sex++){
				$fila_sexo= pg_fetch_array($resp,$sex);
			if($sexo==$fila_sexo['cod_sexo']){
				echo "<option value='".$fila_sexo['cod_sexo']."' selected='selected'>".$fila_sexo['sexo']."</option>";
			}else{
				echo "<option value='".$fila_sexo['cod_sexo']."'>".$fila_sexo['sexo']."</option>";
			}

	}
				echo "</select>";
	
}
function generar_est_civil($conn,$est_civil,$empleado)
{
	$sql="SELECT * FROM estado_civil";
	$resp = pg_exec($conn,$sql);
	$num_est_civil = pg_numrows($resp);
	$rg = "'javascript:muestra_estado(est_civil)'";
									
	echo "<select name='estado_civil' id='estado_civil' onblur=".$rg." onchange='cargaContenido(this.id,".$empleado.",1,0,0,0)'>";
	echo "<option value='0'>Elige</option>";
			for($est=0;$est<$num_est_civil;$est++){
				$fila_est_civil= pg_fetch_array($resp,$est);
			if($est_civil==$fila_est_civil['cod_estado']){
				echo "<option value='".$fila_est_civil['cod_estado']."' selected='selected'>".$fila_est_civil['estado']."</option>";
			}else{
				echo "<option value='".$fila_est_civil['cod_estado']."'>".$fila_est_civil['estado']."</option>";
			}

	}
				echo "</select>";
	
}


function generar_comuna($conn,$region,$provincia,$comuna,$empleado)
{
	echo $sql="SELECT * FROM comuna WHERE cod_reg=".$region." AND cor_pro=".$provincia."";
	$resp = pg_exec($conn,$sql);
	$num_com = pg_numrows($resp);
										
	echo "<select name='m3' id='comuna' onchange='cargaContenido(this.id,".$empleado.",1,0,0,0)'>";
			for($com=0;$com<$num_com;$com++){
				$fila_com= pg_fetch_array($resp,$com);
			if($comuna==$fila_com['cor_com']){
				echo "<option value='".$fila_com['cor_com']."' selected='selected'>".$fila_com['nom_com']."</option>";
			}else{
				echo "<option value='".$fila_com['cor_com']."'>".$fila_com['nom_com']."</option>";
			}

	}
				echo "</select>";
	
}
function generar_provincia($conn,$region,$provincia,$empleado)
{		
	echo $sql	="SELECT * FROM PROVINCIA WHERE COD_REG=".$region." ORDER BY NOM_PRO ASC";
		$resp	=@pg_exec($conn,$sql);
		$num_pro=pg_numrows($resp);
	echo "<SELECT id='ciudad' name=m2 onChange='relate2(this.form,0,this.selectedIndex,0);'>"; 
		for($i=0;$i<$num_pro;$i++){
			$filaPRO = @pg_fetch_array($resp,$i);
			if($filaPRO['cor_pro']==$provincia){
				echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\" selected>".trim($filaPRO['nom_pro'])." </OPTION>\n";
			}else{
				echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\">".trim($filaPRO['nom_pro'])." </OPTION>\n";
			}
		}
	echo "</SELECT>";
}
function generar_region($conn,$region,$empleado)
{

	echo $sql	="SELECT * FROM REGION ORDER BY COD_REG ASC";
	$resp	=pg_Exec($conn,$sql);
	$num_reg=pg_numrows($resp);
	echo "<SELECT id='region' name=m1 onChange='relate(this.form,0,this.selectedIndex);'>";
		for($i=0;$i<$num_reg;$i++){
			$filaREG = @pg_fetch_array($resp,$i);
				if($filaREG['cod_reg']==$region){
					echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\" selected>".trim($filaREG['nom_reg'])." </OPTION>\n";
				}else{
					echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\">".trim($filaREG['nom_reg'])." </OPTION>\n";
				}
		}
		echo "</SELECT>";
}
function generar_cargo($conn,$cargo,$empleado,$i,$institucion)
{
	$sql="SELECT * FROM cargos";
	$resp = pg_exec($conn,$sql);
	$num_cargo = pg_numrows($resp);
	if($cargo=="" or $cargo==NULL){
		$cargo=0;
	}else{
		$cargo=$cargo;
	}
	
	$rg = "'javascript:muestra_cargo(cargos".$i.",".$i.")'";										
	echo "<select name='cargo".$i."' id='cargo".$i."' onblur=".$rg." onchange='cargaContenido(this.id,".$empleado.",5,".$cargo.",".$institucion.",".$i.")'>";
	echo "<option value='0'>Elige</option>";
			for($co=0;$co<$num_cargo;$co++){
				$fila_cargo= pg_fetch_array($resp,$co);
			if($cargo==$fila_cargo['id_cargo']){
				echo "<option value='".$fila_cargo['id_cargo']."' selected='selected'>".$fila_cargo['nombre_cargo']."</option>";
			}else{
				echo "<option value='".$fila_cargo['id_cargo']."'>".$fila_cargo['nombre_cargo']."</option>";
			}

	}
				echo "</select>";
	
}
function generar_subsector($conn,$institucion,$ano,$cmb_subsector,$i,$id_aux,$empleado)
{
	
	$sq1= "select * from subsector where cod_subsector in (select cod_subsector from ramo where id_ramo in (select id_ramo from curso where id_curso in (select id_curso from matricula where rdb = '".trim($institucion)."' and id_ano = '".trim($ano)."'))) order by nombre"; 
	$resp = @pg_Exec($conn,$sq1);
	$num_sub = @pg_numrows($resp);
	$rg = "'javascript:muestra_txtsub(subsector2".$i.")'";
	if(!$i==0){									
	echo "<select name='cmb_subsector".$i."' id='cmb_subsector".$i."' onblur=".$rg." onChange='cargaContenido(this.id,".$empleado.",3,".$id_aux.",25,".$i.")'>";
	}else{
	echo "<select name='cmb_subsector".$i."' id='cmb_subsector".$i."'>";
	}
	echo "<option value='0'>Seleccione Subsector</option>";
			for($sub=0;$sub<$num_sub;$sub++){
			$fila_subsector= pg_fetch_array($resp,$sub);
			$nombre = substr($fila_subsector['nombre'],0,65);
			if($cmb_subsector==$fila_subsector['cod_subsector']){
				echo "<option value='".trim($fila_subsector['cod_subsector'])."' selected='selected'>".$nombre."</option>";
			}else{
				echo "<option value='".trim($fila_subsector['cod_subsector'])."'>".$nombre."</option>";
			}

			}
	echo "</select>";
	
}
function generar_tipo_en($conn,$institucion,$cmb_tipoensenanza)
{
	$sql = "select * from tipo_ensenanza where cod_tipo in (select cod_tipo from plan_tipo where cod_decreto in (select cod_decreto from plan_estudio where cod_decreto in (select cod_decreto from plan_inst where rdb = '".trim($institucion)."')))";        
	$resp = @pg_Exec($conn,$sql);
	$num_tipo = @pg_numrows($resp);
	
	echo "<select name='cmb_tipoensenanza' id='cmb_tipoensenanza' onChange='enviapag(this.form)'>";
	echo "<option value='0'>Seleccione Tipo de Enseñanza</option>";
			for($tipo=0;$tipo<$num_tipo;$tipo++){
			$fila_tipoensenanza= pg_fetch_array($resp,$sub);
			if($cmb_tipoensenanza==$fila_tipoensenanza['cod_tipo']){
				echo "<option value='".trim($fila_tipoensenanza['cod_tipo'])."' selected='selected'>".trim($fila_tipoensenanza['nombre_tipo'])."</option>";
			}else{
				echo "<option value='".trim($fila_tipoensenanza['cod_tipo'])."'>".trim($fila_tipoensenanza['nombre_tipo'])."</option>";
			}

			}
	echo "</select>";
}
function generar_tipo_autorizacion($tipo_aut,$empleado,$id_aux,$i)
{	
	//$cont = $i+1;
	//$campo = "tipo_aut";
	/*$sql= "SELECT * FROM tipo_autorizacion";
	$resp = pg_exec($conn,$sql);
	$num_tipo_aut = pg_numrows($resp);
	*/
	$i = $i+1;
	$rg = "'javascript:muestra_txttipo_aut(cmb_tipo_aut".$i.")'";

	echo "<select name='cmb_tipo_aut".$i."' id='cmb_tipo_aut".$i."' onblur=".$rg." onChange='cargaContenido(this.id,".$empleado.",3,".$id_aux.",24,".$i.")'>";
	echo "<option value='0'>Elige</option>";
	//	for($tipo_aut=0;$tipo_aut<$num_tipo_aut;$tipo_aut++)
	if($tipo_aut == "INDEFINIDA" or $tipo_aut == "Indefinida"){
		echo "<option value='1' selected='selected'>INDEFINIDA</option>";
		echo "<option value='2'>TEMPORAL</option>";
	}
	if($tipo_aut == "TEMPORAL" or $tipo_aut == "Temporal"){
		echo "<option value='1'>INDEFINIDA</option>";
		echo "<option value='2' selected='selected'>TEMPORAL</option>";
	};
	echo "</select>";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script language="JavaScript" type="text/JavaScript">
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

<? if ($frmModo!="ingresar"){ ?>

<!--
function muestra_tabla(tabla,span){
	t=document.getElementById(tabla);
	span2=document.getElementById(span);
	temp=document.getElementById(tabla);
	document.getElementById('personal').style.display='none';
	document.getElementById('docente').style.display='none';
	document.getElementById('curriculum').style.display='none';
	document.getElementById('acceso_web').style.display='none';
	document.getElementById('grupos').style.display='none';
	/*document.getElementById('habilitado').style.display='none';
	document.getElementById('autorizacion').style.display='block';
*/	document.getElementById('pesta1').className='span_normal';
	document.getElementById('pesta2').className='span_normal';
	document.getElementById('pesta3').className='span_normal';
	document.getElementById('pesta4').className='span_normal';
	document.getElementById('pesta5').className='span_normal';
	t.style.display="";
	span2.className='span_seleccionado';
	

}

<? } ?>


function uno(span){
	
	document.getElementById('habilitado').style.display='block';
	document.getElementById('autorizacion').style.display='none';	

}

function dos(span){
	
	document.getElementById('habilitado').style.display='none';
	document.getElementById('autorizacion').style.display='block';	

}





function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
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
function SwitchMenuAnotacion(obj){  
   
	var el = document.getElementById(obj);
	var ar = document.getElementById("masterdiv3").getElementsByTagName("span"); //DynamicDrive.com change
		
	   
	    if (el.className=="habilitado"){
	       el.style.display = "block";		   
		   for (var i=0; i<ar.length; i++){
				if (ar[i].className=="autorizacion") //DynamicDrive.com change
				ar[i].style.display = "none";			
				
			}
		   
		   
	    }
	
	    if (el.className=="autorizacion"){
	       el.style.display = "block";		   
		   for (var i=0; i<ar.length; i++){
				if (ar[i].className=="habilitado") //DynamicDrive.com change
				ar[i].style.display = "none";			   
				   
			}
	    }	
}
//-->
</script>
<?
include('../../../util/rpc.php3');
?>


<? if($frmModo!="mostrar"){?>

   <SCRIPT language="JavaScript">
         function valida3(form){
		 	  if(!chkVacio(form.h_fecha,'Ingresar Fecha.')){
					return false;
			  };

			  if(!chkFecha(form.h_fecha,'Fecha invalida.')){
					return false;
			  };
	           
			  if(!chkVacio(form.h_resolucion,'Ingresar número de resolucón.')){
					return false;
			  };
			
			  if(!chkVacio(form.h_inscripcion,'Ingresar número de inscripción.')){
					return false;
			  };	 
			 
			  if(form.cmb_subsector.value=='0'){
				alert ('Seleccionar Subsector.')
				form.cmb_subsector.focus();
				return false;
			  };
			  
			  if(form.cmb_tipoensenanza.value=='0'){
				 alert ('Seleccionar tipo de enseñanza.')
				 form.cmb_tipoensenanza.focus();
				 return false;
			  };			   
			   
			 document.form.Accion.value = "3";
			 document.form.submit();
		
		  }
	</script>
		  


		
	<? if($frmModo=="modificar"){ ?>
		<SCRIPT language="JavaScript">
	
		function valida(form){
		
			if(form.cmbCARGO0.value=='0'){
				alert ('Seleccionar CARGO.')
				form.cmbCARGO0.focus();
				return false;
			};
			
				if(form.cmbCARGO0.value==form.cmbCARGO1.value){
					alert('Cargo 2 no puede ser igual a Cargo 1')
					form.cmbCARGO1.focus();
					return false;
				};

             if(!nroOnly(form.txtEXPERIENCIA,'Se permiten sólo números en el campo Años de Experiencia.')){
				  return false;
			  }; 

             if(!nroOnly(form.horasxclase,'Se permiten sólo números en el campo Nro. Horas por Contrato.')){
				  return false;
			  }; 
  
             if(!nroOnly(form.horasxcontrato,'Se permiten sólo números en el campo Nro. Horas por Clase.')){
				  return false;
			  };
			  			  
             if(!nroOnly(form.txtNROres,'Se permiten sólo números en el campo Nº RESOLUCION.')){
				  return false;
			  };
			  
                if(!chkVacio(form.txtFECHA,'Ingresar FECHA.')){
					return false;
				};
							  
				if(!chkFecha(form.txtFECHA,'Fecha invalida.')){
					return false;
				};			  

	   		  if(!chkVacio(form.txtRUT,'Ingresar RUT.')){
					return false;
			  };

			  if(!nroOnly(form.txtRUT,'Se permiten sólo números en el RUT.')){
					return false;
			  };
				
			  if(!chkVacio(form.txtDIGRUT,'Ingresar dígito verificador del RUT.')){
					return false;
			  };
				
			  if(!chkCod(form.txtRUT,form.txtDIGRUT,'RUT inválido.')){
					return false;
			  };
				
			  if (form.cmb.value==0){
					alert ('Ingrese por lo menos el primer cargo')	;
					return false;
			   } 
				
 				if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE.')){
					return false;
				};
				
				if(form.horasxclase.value!=''){
					if(!phoneOnly(form.horasxclase,'Se permiten sólo números en el campo Horas por Clase.')){
						return false;
					};
				};
				
				
				if(form.horasxcontrato.value!=''){
					if(!phoneOnly(form.horasxcontrato,'Se permiten sólo números en el campo Horas por Contrato.')){
						return false;
					};
				};
				
				
				if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
					return false;
				};
				if(!chkVacio(form.txtAPEPAT,'Ingresar APELLIDO PATERNO.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEPAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO PATERNO.')){
					return false;
				};

				if(!chkVacio(form.txtAPEMAT,'Ingresar APELLIDO MATERNO.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEMAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO MATERNO.')){
					return false;
				};

				if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
					return false;
				};

				if(form.txtTELEF.value!=''){
					if(!phoneOnly(form.txtTELEF,'Se permiten sólo números telefónicos en el campo TELEFONO.')){
						return false;
					};
				};

				if(form.txtEMAIL.value!=''){
					if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
						return false;
					};
				};
						/*
						if(!chkSelect2(f1.m1,'Seleccionar REGION.')){
							return false;
						};
						*/
						if(!chkSelect2(f2.m2,'Seleccionar PROVINCIA.')){
							return false;
						};

						if(!chkSelect2(f3.m3,'Seleccionar COMUNA.')){
							return false;
						};
			//alert ('hola');
				/*if(!alfaOnly(form.txtTITULO,'Se permiten sólo caracteres alfanuméricos en el campo TITULO.')){
					return false;
				};*/

				if(!chkSelect2(form.cmbSEXO,'Seleccionar SEXO.')){
					return false;
				};

				if(!chkSelect2(form.cmbCIVIL,'Seleccionar ESTADO CIVIL.')){
					return false;
				};

					
		   /*		if(!chkSelect2(form.cmb,'Seleccionar CARGO.')){
					return false;
				};  */

			
                if(!chkVacio(form.txtFECHA,'Ingresar FECHA.')){
					return false;
				};

				if(!chkFecha(form.txtFECHA,'Fecha invalida.')){
					return false;
				};



				if(!nroOnly(form.txtEXPERIENCIA,'Se permiten sólo números en el campo AÑOS DE EXPERIENCIA.')){
					return false;
				};				
				return true;
			}
		   function valida2(form){
		      if(!nroOnly(form.horasxclase,'Se permiten sólo números en el campo Horas x clase.')){
					return false;
			   };
			   
			   
			   if(!nroOnly(form.horasxcontrato,'Se permiten sólo números en el campo Horas x contrato.')){
					return false;
			   };
	   
			   
			   document.form.Accion.value = "3";
			   document.form.submit();
		
		
		   }		 
		  
		</SCRIPT>	
	<? }?>
	
<? }?>




<script language="javascript">
function valida3(form){
		      
	  if(!chkVacio(form.h_fecha,'Ingresar Fecha.')){
			return false;
	  };

	  if(!chkFecha(form.h_fecha,'Fecha invalida.')){
			return false;
	  };
	   
	  if(!chkVacio(form.h_resolucion,'Ingresar número de resolucón.')){
			return false;
	  };
	  
	  if(!nroOnly(form.h_resolucion,'Se permiten sólo numeros en el numero de resolucion.')){
		    return false;
	  };
	
	  if(!chkVacio(form.h_inscripcion,'Ingresar número de inscripción.')){
			return false;
	  };	 
	 
	  if(!nroOnly(form.h_inscripcion,'Se permiten sólo numeros en el numero de inscripción.')){
		    return false;
	  };
	  
	  if(!checkRadios(form.h_tipo_aut,'Debe elegir tipo de autorización.')){
		    return false;
	  };
	 
	  if(form.cmb_subsector.value=='0'){
		alert ('Seleccionar Subsector.')
		form.cmb_subsector.focus();
		return false;
	  };
	  
	  if(form.cmb_tipoensenanza.value=='0'){
		 alert ('Seleccionar tipo de enseñanza.')
		 form.cmb_tipoensenanza.focus();
		 return false;
	  }; 
	   
	   
	 document.form.Accion.value = "3";
	 document.form.submit();

}
</script>



<?
if ($frmModo!="ingresar"){ ?>

    <script language="javascript" type="text/javascript">
       function getElementObject(elementID) {
         var elemObj = null;
         if (document.getElementById) {
            elemObj = document.getElementById(elementID);
         }
         return elemObj;
       } 

       function mostrar_ocultar(obj){
          a=getElementObject(obj);
	      if (a.style.display==""){
		     a.style.display="none";
	      }else{
		     a.style.display="";
	      }
	   }

       function chekear(obj){
	     //a=getElementObject(obj);
	     a=window.document.frm.cod_subsector;
	     largo=	window.document.frm.cod_subsector.length;
		for (i=0;i<largo;i++)	{
	       if (a[i].checked==true){
		      a[i].checked=false;
	       }else{
		      a[i].checked=true;
		   }
        }
       }	

     function posicion(valor,nombre)
       {
        form=window.document.frm;
        largo=form.elements.length;	
	    for (i=0;i<largo;i++)	{
		   if ((form.elements[i].type=="checkbox")&&(form.elements[i].value==valor)&&(form.elements[i].name==nombre)){
		   return i;
		   }
	    }
     }

     function  titulado(obj,valor,nombre){
	    pos=posicion(valor,nombre);
	    pos++;
	    form=window.document.frm;
	    if (obj.checked==true){
		   form.elements[pos].checked=false;
	   }
	 }
    function tit_otras(obj,valor,nombre){
	    pos=posicion(valor,nombre);
    	pos--;
	    form=window.document.frm;
	    if (obj.checked==true){
		   form.elements[pos].checked=false;
	   }
    }
</script>
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>


<? } ?>

	
<script language="javascript">
function enviapag(form){
    form.action = 'empleado_new2.php?pesta=2&m1=1&cmb_tipoensenanza='+document.form2.cmb_tipoensenanza.value+'&cmb_subsector='+document.form2.cmb_subsector.value;
	form.submit(true);
}


function SwitchMenuAnotacion(obj){  
   
	var el = document.getElementById(obj);
	var ar = document.getElementById("masterdiv3").getElementsByTagName("span"); //DynamicDrive.com change
		
	   
	    if (el.className=="habilitado"){
	       el.style.display = "block";		   
		   for (var i=0; i<ar.length; i++){
				if (ar[i].className=="autorizacion") //DynamicDrive.com change
				ar[i].style.display = "none";			
				
			}
		   
		   
	    }
	
	    if (el.className=="autorizacion"){
	       el.style.display = "block";		   
		   for (var i=0; i<ar.length; i++){
				if (ar[i].className=="habilitado") //DynamicDrive.com change
				ar[i].style.display = "none";			   
				   
			}
	    }	
}
</script>
<script type="text/javascript" src="prueba/js/mootools.js"></script>
<script type="text/javascript" src="prueba/js/imageMenu.js"></script>
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link href="prueba/css/imageMenu.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="ajax/ingreso_sin_recargar.css">
<link rel="stylesheet" type="text/css" href="ajax/select/select_dependientes.css" />
<script type="text/javascript" src="ajax/ingreso_sin_recargar.js"></script>
</head>
<SCRIPT LANGUAGE="JavaScript">


function ChequearTodos(chkbox)
{
	for (var i=0;i < document.forms[1].elements.length;i++)
	{
		var elemento = document.forms[1].elements[i];		
		if (elemento.type == "checkbox")
		{
			elemento.checked = chkbox.checked
		}
	}
}
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="
SwitchMenuAnotacion('autorizacion');
muestra_estado();
muestra_sexo();
muestra_texto();
muestra_text_R();
muestra_text_P();
muestra_text_C();

muestra_cargo(cargo1,1);
muestra_cargo(cargo2,2);

hide_cod();

<?
if ($frmModo!="ingresar"){ 
   if (($pesta == "") or ($pesta == NULL) or ($pesta == " ") or ($pesta == 1) or (!isset($pesta))){ ?>
      muestra_tabla('personal','pesta1');
	   <?
   } 
   if ($pesta == 2){ ?>
      muestra_tabla('docente','pesta2');
	<? if ($m1==1){ ?>
	       uno();
	<? }else{?>
	       dos();
	<? }
		  
   }
   if ($pesta == 3){ ?>
      muestra_tabla('curriculum','pesta3'); <?
	  
   }	   
   
   
   if ($pesta == 4){ ?>
      muestra_tabla('accesoweb','pesta4'); <?
   }
   if ($pesta == 5){ ?>
      muestra_tabla('grupos','pesta5'); <?
   }   
}
?>
muestra_txttipo_aut();
muestra_txtsub();
MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table height="924" width="1259" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="54" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
			<td colspan="2" valign="top">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
				<td height="116" colspan="2"><? include("../../../cabecera/menu_superior.php"); ?>
				</td>
				</tr>
				</table>
			</td>
		  </tr>
		  <tr>
			<td width="16%" valign="top"><? include("../../../menus/menu_lateral.php"); ?></td>
			<td width="100%" valign="top" align="center">
			<div id="kwick" align="center">
				<ul class="kwicks">
					<li><a class="kwick opt1" href="javascript:;" onClick="muestra_tabla('personal','pesta1');"><span id="pesta1" class="span_normal"></span></a></li>
					<li><a class="kwick opt2" href="javascript:;" onClick="muestra_tabla('docente','pesta2');"><span id="pesta2" class="span_normal"></span></a></li>
					<li><a class="kwick opt3" href="javascript:;" onClick="muestra_tabla('curriculum','pesta3');"><span id="pesta3" class="span_normal"></span></a></li>
					<li><a class="kwick opt4" href="javascript:;" onClick="muestra_tabla('acceso_web','pesta4');"><span id="pesta4" class="span_normal"></span></a></li>
					<li><a class="kwick opt5" href="javascript:;" onClick="muestra_tabla('grupos','pesta5');"><span id="pesta5" class="span_normal"></span></a></li>
				</ul>
			</div>
			<script type="text/javascript">
				var myMenu = new ImageMenu($$('#kwick .kwick'),{openWidth:250});
			</script>
			<!--campos de datos-->
			<!--nueva tabla ingresar-->
			<? if($frmModo=="ingresar"){?>
			<table width="60%" align="center" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="left">
					<!--ingresar empleado-->
					
					<table width="618" border="0" cellpadding="1" cellspacing="0">
					  <tr align="left">
						<td width="41" height="26">&nbsp;</td>
						<td width="65" class="textosesion"><strong>Rut</strong></td>
						<td width="4" class="textosesion"><strong>:</strong></td>
						<td class="textosesion">
						   <div id="div_rut_empleado" style="width:150px;">
							  <div id="div_rut_emp" onClick="creaInput(this.id, 'rut_emp',0,1,0,<?=$_INSTIT?>)">Ingrese rut aqui</div>
							  <div class="mensaje" id="error"></div>
						   </div>                    
						</td>
						<td width="15" class="textosesion">&nbsp;</td>
					  </tr>
					  <tr align="left">
						<td>&nbsp;</td>
						<td class="textosesion">&nbsp;</td>
						<td class="textosesion">&nbsp;</td>
						<td class="textosesion">&nbsp;</td>
					  </tr>
					  
					  
					  <tr>
						<td>&nbsp;</td>
						<td colspan="3">&nbsp;</td>
					  </tr>
					</table>
					
					<!--fin ingresar empleado-->
					</td>
				</tr>
			</table>
			<? }?>
			<!--fin nueva tabala ingresar-->
			<? if($frmModo !="ingresar"){?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="left">
					<table width="100%" border="0" cellpadding="1" cellspacing="0">
					  <tr align="left">
						<td width="42" height="26">&nbsp;</td>
						<td width="66" class="textosesion"><strong>Rut</strong></td>
						<td width="4" class="textosesion"><strong>:</strong></td>
						<td colspan="3" class="textosesion">
						<span>
						  <?=$fila['rut_emp']."-".$fila['dig_rut']?>
						</span>
						</td>
						<td width="9" rowspan="7">&nbsp;</td>
						<td width="117" rowspan="7"><?
								if ($frmModo != "ingresar"){ 
								   // codigo para insertar la foto
								   $remple = pg_Exec($conn,"select * from empleado where rut_emp=".trim($_EMPLEADO));
								   $arr=pg_fetch_array($remple,0);
								   $nombrefoto = $arr['nom_foto2'];
								   ?>
						  <img src="../../../tmp/<?=$nombrefoto ?>" alt= "NO INGRESADA"  width="90" height="100" border="1" />
						  <?
						} ?></td>
					  </tr>
					  <tr align="left">
						<td>&nbsp;</td>
						<td class="textosesion"><strong>Nombre</strong></td>
						<td class="textosesion"><strong>:</strong></td>
						<td colspan="3" class="textosesion">
						<div id="nombres" style="width:150px;">
									<div id="nombre1" onClick="creaInput(this.id, 'nombre_emp',<?=$empleado?>,1,0,0)"><?=$fila['nombre_emp']?></div>
									<div class="mensaje" id="error"></div>
						</div>					</td>
					  </tr>
					  <tr align="left">
						<td>&nbsp;</td>
						<td class="textosesion"><strong>Apellidos</strong></td>
						<td class="textosesion"><strong>:</strong></td>
						<td width="36" class="textosesion"><div id="apellido_paterno" style="width:5px;">
						  <div id="apellido_pat" onClick="creaInput(this.id, 'ape_pat',<?=$empleado?>,1,0,0)">
							<?=$fila['ape_pat']?>
						  </div>
						  <div class="mensaje" id="div3"></div>
						</div></td>
						<td width="3" class="textosesion">,</td>
						<td width="325" class="textosesion"><div id="apellido_materno" style="width:80px;">
						  <div id="apellido_mat" onClick="creaInput(this.id, 'ape_mat',<?=$empleado?>,1,0,0)">
							<?=$fila['ape_mat']?>
						  </div>
						  <div class="mensaje" id="div2"></div>
						</div></td>
						</tr>
					  
					  <tr align="left">
						<td>&nbsp;</td>
						<td class="textosesion"><strong>Fono</strong></td>
						<td class="textosesion"><strong>:</strong></td>
						<td colspan="3" class="textosesion"><div id="telefonos" style="width:30px;">
						  <div id="fono" onClick="creaInput(this.id, 'telefono',<?=$empleado?>,1,0,0)">
							<?	if(strlen(trim($fila['telefono'])) > 1){
										echo $fila['telefono'];
									}else{
										echo "-";
									}?>
						  </div>
						  <div class="mensaje" id="div"></div>
						</div></td>
						</tr>
					  <tr align="left">
						<td>&nbsp;</td>
						<td class="textosesion"><strong>Email</strong></td>
						<td class="textosesion"><strong>:</strong></td>
						<td colspan="3" class="textosesion">
						<div id="e-mail" style="width:100px;">
							<div id="mail" onClick="creaInput(this.id, 'email',<?=$empleado?>,1,0,0)">
							  <? 								
								if(strlen(trim($fila['email'])) > 1){
									echo $fila['email'];
								}else{
									echo "-";
								}?>
							</div>
							<div class="mensaje" id="error"></div>
						</div>					</td>
						</tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan="5">&nbsp;</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
			<table width="80%" align="center" border="0" cellpadding="10" cellspacing="0">
			  <tr>
				<td valign="top" align="center">
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr id="personal"><!--datos personales-->
							<td valign="top" align="center">
							<form name="form1" action="">
							<table width="100%" border="0" cellpadding="0" cellspacing="2">
							  <tr>
								<td colspan="4">							</td>
							  </tr>
							  <tr>
								<td colspan="4" align="right">
								<?		$ob_usuario=new Empleado();
										$ob_usuario->empleado=$empleado;
										$res=$ob_usuario->usuario($conn);
										$usuario=pg_fetch_array($res,0);
											$ob_perfil=new Empleado();
											$ob_perfil->id_usuario=$usuario['id_usuario'];
											$res2=$ob_perfil->perfil($conn);
											for($i=0 ; $i < @pg_numrows($res2) ; $i++){
												$perfil=pg_fetch_array($res2,$i);
													if($perfil["id_perfil"]==26){
														$mostrar=$perfil["id_perfil"];
													}
											}
								if($mostrar==26){?>
										<? if ($_PERFIL==0 || $_PERFIL==14){?>
											<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick="confirmDelete();">&nbsp;
										<? } ?>
										<? }else{?>
											<? if ($_PERFIL==0 || $_PERFIL==14){?>
												<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaEmpleado.php3?caso=9">&nbsp;
											<? } ?>
										<? }
										?>
										<? //ACADEMICO Y LEGAL?>
										
								<? if($frmModo=="mostrar"){?>
										<?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=25)&&($_PERFIL!=26)){ //ACADEMICO Y LEGAL?>
										<!--	<INPUT class="botonXX"  TYPE="button" value="ACCESO WEB" onClick=document.location="usuario/usuario.php3">  -->
										<!--	<INPUT class="botonXX"  TYPE="button" value="ANOTACIONES" onClick=document.location="anotacion/listarAnotacion.php3"> -->
										<input name="Submit" class="botonXX" type="button" onClick="MM_openBrWindow('frmFoto.php3?rut=<?=$empleado ?>','','width=380,height=200')" value="FOTO" />
										
										<!--	<INPUT class="botonXX"  TYPE="button" value="FOTO" onClick="MM_openBrWindow('frmFoto.php3?rut=<?=$empleado ?>','CodigoProducto','height=200,width=380,scrollbar='no',location='no',resizable='no')"> -->
											
										<? }?>
									<? } ?>							</td>
							  </tr>
							  <tr>
								<td colspan="4" class="tableindex"><strong>Personal</strong></td>
							  </tr>
							  <tr>
								<td class="cuadro02"><strong>nacionalidad</strong></td>
								<td class="cuadro01">
								<div id="nac1" onClick="javascript:muestra_cmb(nac1)">
								<?  $sql  = "SELECT nacionalidad FROM nacionalidad WHERE cod_nac =".$fila['nacionalidad'];
									$resp = pg_exec($conn,$sql);
									$nac1 = pg_result($resp,0); 
									if(strlen($nac1)<0){
									echo "Presione Aquí";
									}else{
									echo $nac1;
									}
								?>
								</div>
								<div id="nac2">
								<? 	$sql="SELECT * FROM nacionalidad";
									$resp = pg_exec($conn,$sql);
									$num_nac = pg_numrows($resp);
								?>
								<select name="nacionalidad" id="nacionalidad" onchange='cargaContenido(this.id,<?=$empleado?>,1,0,0,0)' onBlur="javascript:muestra_texto(nac2)">
									<option value="0">Elige</option>
								<?	for($nac=0;$nac<$num_nac;$nac++){
									$fila_nac= pg_fetch_array($resp,$nac);
									if($fila['nacionalidad']==$fila_nac['cod_nac']){?>
									<option value="<?=$fila_nac['cod_nac']?>" selected="selected"><?=$fila_nac['nacionalidad']?></option>
								<? }else{?>
									<option value="<?=$fila_nac['cod_nac']?>"><?=$fila_nac['nacionalidad']?></option>
								<? }
	
								}?>
									</select>
								</div>							</td>
								<td class="cuadro02"><strong>Sexo</strong></td>
								<td class="cuadro01">
								<div id="sexo1" onClick="javascript:muestra_sex(sexo1)">
								<?  $sql 	= "SELECT sexo FROM sexo WHERE cod_sexo =".$fila['sexo'];
									$resp 	= pg_exec($conn,$sql);
									$sexo	= pg_result($resp,0); 
									if(strlen($sexo)<0){
									echo "Presione Aqui";
									}else{
									echo $sexo;
									}
								?>
								</div>
								<div id="sexo2"><?
									$sql="SELECT * FROM sexo";
									$resp = pg_exec($conn,$sql);
									$num_sexo = pg_numrows($resp);
									$rg = "'javascript:muestra_sexo(sexo2)'";
									?>								
									<select name="sexo" id="sexo" onBlur="javascript:muestra_sexo(sexo2)" onChange="cargaContenido(this.id,<?=$empleado?>,1,0,0,0)">
									<option value="0">Elige</option>
										<?	for($sex=0;$sex<$num_sexo;$sex++){
												$fila_sexo= pg_fetch_array($resp,$sex);
											if($fila['sexo']==$fila_sexo['cod_sexo']){?>
												<option value="<?=$fila_sexo['cod_sexo']?>" selected="selected"><?=$fila_sexo['sexo']?></option>
											<? }else{?>
												<option value="<?=$fila_sexo['cod_sexo']?>"><?=$fila_sexo['sexo']?></option>
											<? }
								
									}?>
											</select>
								</div>
															</td>
							  </tr>
							  <tr>
								<td width="23%" class="cuadro02"><strong>Telefono 2 </strong></td>
								<td width="25%" class="cuadro01">
								<div id="telefonos2" style="width:80px;">
									<div id="fono2" onClick="creaInput(this.id, 'telefono2',<?=$empleado?>,1,0,0)">
									 <?	if(strlen(trim($fila['telefono2'])) > 1){
											echo $fila['telefono2'];
										}else{
											echo "-";
									}?>
									</div>
									<div class="mensaje" id="error"></div>
								</div>							</td>
								<td width="24%" class="cuadro02"><strong>Telefono 3 </strong></td>
								<td width="28%" class="cuadro01">
								<div id="telefonos3" style="width:80px;">
									<div id="fono3" onClick="creaInput(this.id, 'telefono3',<?=$empleado?>,1,0,0)">
									<?	if(strlen(trim($fila['telefono3'])) > 1){
											echo $fila['telefono3'];
										}else{
											echo "-";
									}?>
									</div>
									<div class="mensaje" id="error"></div>
								</div>							</td>
							  </tr>
							  <tr>
							  <!--DAR VUELTA FECHA-->
							  <?
									
									$dd = substr($fila['fecha_nacimiento'],8,2);
									$mm = substr($fila['fecha_nacimiento'],5,2);
									$aa = substr($fila['fecha_nacimiento'],0,4);
									$fecha_nacimiento = "$dd-$mm-$aa";
							  
							  ?>
								<td class="cuadro02"><strong>Fecha de nac </strong></td>
								<td class="cuadro01">
								<div id="fecha_nac" style="width:80px;">
									<div id="f_nac" onClick="creaInput(this.id, 'fecha_nacimiento',<?=$empleado?>,1,0,0)">
									  <? 								
										if(strlen(trim($fecha_nacimiento)) > 1){
											echo $fecha_nacimiento;
										}else{
											echo "-";
										}					
									  ?>
									</div>
									<div class="mensaje" id="error"></div>
								</div>							</td>
								<!--DAR VUELTA FECHA INGRESO-->
								<?
									$dd = substr($fila['fecha_ingreso'],8,2);
									$mm = substr($fila['fecha_ingreso'],5,2);
									$aa = substr($fila['fecha_ingreso'],0,4);
									$fecha_ingreso = "$dd-$mm-$aa";
								?>
								<td class="cuadro02"><strong>Fecha de ingreso </strong></td>
								<td class="cuadro01">
								<div id="f_ingreso" style="width:80px;">
									<div id="fecha_ing" onClick="creaInput(this.id, 'fecha_ingreso',<?=$empleado?>,1,0,0)">
									<? 								
										if(strlen(trim($fecha_ingreso)) > 1){
											echo $fecha_ingreso;
										}else{
											echo "-";
										}					
									  ?>
									</div>
									<div class="mensaje" id="error"></div>
								</div>							</td>
							  </tr>
							  <tr>
								<td class="cuadro02"><strong>Prevision (AFP) </strong></td>
								<td class="cuadro01">
								<div id="sist_prevision" style="width:80px;">
									<div id="sist_prev" onClick="creaInput(this.id, 'prevision',<?=$empleado?>,1,0,0)">
									<? 								
										if(strlen(trim($fila['prevision'])) > 0){
											echo $fila['prevision'];
										}else{
											echo "-";
										}					
									  ?>
									</div>
									<div class="mensaje" id="error">								</div>
								</div></td>
								<td class="cuadro02"><strong>Sist. de salud </strong></td>
								<td class="cuadro01">
								<div id="salud" style="width:80px;">
									<div id="sist_salud" onClick="creaInput(this.id, 'sistema_salud',<?=$empleado?>,1,0,0)"><?=$fila['sistema_salud']?></div>
									<div class="mensaje" id="error"></div>
								</div>							</td>
							  </tr>
							  <tr>
								<td class="cuadro02"><strong>Horas presente a&ntilde;o </strong></td>
								<td class="cuadro01">
								<div id="hrs_ano" style="width:80px;">
									<div id="horas_ano" onClick="creaInput(this.id, 'horas_presente_ano',<?=$empleado?>,1,0,0)">
									<? 								
										if(strlen(trim($fila['horas_presente_ano'])) > 1){
											echo $fila['horas_presente_ano']."hrs";
										}else{
											echo "0 hrs";
										}					
									  ?>
									</div>
									<div class="mensaje" id="error"></div>
								</div>							</td>
								<td class="cuadro02"><strong>Estado civil</strong> </td>
								<td class="cuadro01">
								<div id="est_civil" onClick="javascript:muestra_cmb_estado(est_c)">
								<?  $sql 	= "SELECT estado FROM estado_civil WHERE cod_estado =".$fila['estado_civil'];
									$resp 	= pg_exec($conn,$sql);
									$civil	= pg_result($resp,0); 
									if(strlen($civil)<0){
									echo "Presione Aquí";
									}else{
									echo $civil;
									}
									
								?>
								</div>
								<div id="est_c"><? generar_est_civil($conn,$fila['estado_civil'],$empleado);?></div>							</td>
							  </tr>
							  <tr>
								<td class="cuadro02"><strong>Dia y horario de atencion </strong></td>
								<td class="cuadro01" colspan="3">
								<div id="dia_hora" style="width:80px;">
									<div id="dia_y_hora" onClick="creaInput(this.id, 'atencion',<?=$empleado?>,1,0,0)">
									<? 								
										if(strlen(trim($fila['atencion'])) > 1){
											echo $fila['atencion'];
										}else{
											echo "--:--";
										}					
									  ?>
									</div>
									<div class="mensaje" id="error"></div>
								</div>							</td>
							  </tr>
							  <tr>
								<td colspan="4" class="tableindex"><strong>Direccion</strong></td>
							  </tr>
							  <tr>
								<td class="cuadro02"><strong>Calle</strong></td>
								<td class="cuadro01">
								<div id="calles" style="width:80px;">
									<div id="div_calle" onClick="creaInput(this.id, 'calle',<?=$empleado?>,1,0,0)">
									<? 								
										if(strlen(trim($fila['calle'])) > 0){
											echo $fila['calle'];
										}else{
											echo "-";
										}					
									  ?>
									</div>
									<div class="mensaje" id="error"></div>
								</div>							</td>
								<td class="cuadro02"><strong>NRO</strong></td>
								<td class="cuadro01">
								<div id="numero" style="width:80px;">
									<div id="div_nro" onClick="creaInput(this.id, 'nro',<?=$empleado?>,1,0,0)">
									<? 								
										if(strlen(trim($fila['nro'])) > 1){
											echo $fila['nro'];
										}else{
											echo "-";
										}					
									  ?>
									</div>
									<div class="mensaje" id="error"></div>
								</div>							</td>
							  </tr>
							  <tr>
								<td class="cuadro02"><strong>Depto (Opcional) </strong></td>
								<td class="cuadro01">
								<div id="departamento" style="width:80px;">
									<div id="div_depto" onClick="creaInput(this.id, 'depto',<?=$empleado?>,1,0,0)">
									<? 								
										if(strlen(trim($fila['depto'])) > 1){
											echo $fila['depto'];
										}else{
											echo "-";
										}					
									  ?>
									</div>
									<div class="mensaje" id="error"></div>
								</div>							</td>
								<td class="cuadro02"><strong>Villa/Pobl (Opcional) </strong></td>
								<td class="cuadro01">
								<div id="villa_poblacion" style="width:80px;">
									<div id="div_villa" onClick="creaInput(this.id, 'villa',<?=$empleado?>,1,0,0)">
									<? 								
										if(strlen(trim($fila['villa'])) > 1){
											echo $fila['villa'];
										}else{
											echo "-";
										}					
									  ?>
									</div>
									<div class="mensaje" id="error"></div>
								</div>							</td>
							  </tr>
							  <tr>
								<td height="137" class="cuadro02"><strong>Block (Opcional) </strong></td>
								<td class="cuadro01">
								<div id="div_block2" style="width:80px;">
									<div id="div_block" onClick="creaInput(this.id, 'block',<?=$empleado?>,1,0,0)">
									<? 								
										if(strlen(trim($fila['block'])) > 1){
											echo $fila['block'];
										}else{
											echo "-";
										}					
									  ?>
									</div>
									<div class="mensaje" id="error"></div>
								</div>							</td>
								<td class="cuadro02"><strong>Regi&oacute;n</strong></td>
								<td class="cuadro01">
								<div id="cod_reg">
								</div>
								<div id="nom_reg" onClick="javascript:muestra_cmb_R(div_region);muestra_cmb_P(div_provincia);muestra_cmb_C(div_comuna)">
									<?  $sql = "SELECT nom_reg FROM region WHERE cod_reg=".$fila['region'];
										$resp = pg_exec($conn,$sql);
										$reg =pg_result($resp,0);
										if(strlen($reg)<1){
										echo "Presione Aquí"; 
										}else{
										echo $reg;
										}
									?>
								</div>
								<div id="div_region">
								<select name="region" size="1" id="region" onChange="javascript:LlenaProvincia();cargaContenido(this.id,<?=$empleado?>,1,0,0,0);hide_cod(cod_reg)" onFocus="siguientecampo ='ciudad'" onBlur="javascript:muestra_text_R(nom_reg)">
								<option value="0" selected="selected">Seleccione Region</option>
								<? 	$sql = "SELECT * FROM region ORDER BY cod_reg";
									$res = pg_exec($conn,$sql);
									for($i=0;$i<pg_numrows($res);$i++){ 
									$fila_reg = pg_fetch_array($res,$i);
										if($fila['region']==$fila_reg['cod_reg']){	?>
												<option value="<? echo $fila_reg['cod_reg'];?>" selected="selected"><? echo $fila_reg['nom_reg'];?></option>
										<? }else{ ?>
												<option value="<? echo $fila_reg['cod_reg'];?>"><? echo $fila_reg['nom_reg'];?></option>
										<? 	}
									} ?>
								</select>
								</div>
								 </td>
							  </tr>
							  <tr>
								<td height="137" class="cuadro02"><strong>Provincia</strong></td>
								<td class="cuadro01">
								<div id="cod_pro">
								</div>
								<div id="nom_pro" onClick="javascript:muestra_cmb_P(div_provincia)">
									<?  $sql = "SELECT nom_pro FROM provincia WHERE cor_pro=".$fila['ciudad']."AND cod_reg=".$fila['region'];
										$resp = pg_exec($conn,$sql);
										$pro =pg_result($resp,0); 
										if(strlen($pro)<1){
										echo "Presione Aquí"; 
										}else{
										echo $pro;
										}
									?>
								</div>
								<div id="div_provincia">
									<select name="ciudad" id="ciudad" onChange="javascript:LlenaComuna();cargaContenido(this.id,<?=$empleado?>,1,0,0,0);muestra_txt_R(nom_reg);hide_cod(cod_pro)" onFocus="siguientecampo = 'comuna'" onBlur="javascript:muestra_text_P(nom_pro)">
									<option value="" selected="selected">Seleccione Provincia</option>
									<? 	$sql = "SELECT * FROM provincia WHERE cod_reg =".$fila['region']."";
											$res = pg_exec($conn,$sql);
											for($i=0;$i<pg_numrows($res);$i++){ 
													$fila_pro = pg_fetch_array($res,$i);
													if($fila['ciudad']==$fila_pro['cor_pro']){	?>
														<option value="<? echo $fila_pro['cod_pro'];?>" selected="selected"><? echo $fila_pro['nom_pro'];?></option>
												<? }else{ ?>
														<option value="<? echo $fila_pro['cor_pro'];?>"><? echo $fila_pro['nom_pro'];?></option>
												<? 	}
												} ?>
									</select>
									</div>
								</td>
								<td class="cuadro02"><strong>Comuna</strong></td>
								<td class="cuadro01">
								<div id="cod_com">
								</div>
								<div id="nom_com" onClick="javascript:muestra_cmb_C(div_comuna)">
									<?  $sql 	= "SELECT nom_com FROM comuna WHERE cor_com=".$fila['comuna']." AND cor_pro=".$fila['ciudad']." AND cod_reg=".$fila['region'];
										$resp 	= pg_exec($conn,$sql);
										$com	= pg_result($resp,0); 
										if(strlen($com)<1){
										echo "Presione Aquí"; 
										}else{
										echo $com;
										}
									?>
								</div>
								<div id="div_comuna">
									<select name="comuna" id="comuna" onchange='cargaContenido(this.id,<?=$empleado?>,1,0,0,0);hide_cod(cod_com)' onBlur="javascript:muestra_text_C(nom_com)">
									<option value="" selected="selected">Seleccione Comuna</option>
									<? 	$sql = "SELECT * FROM comuna WHERE cor_pro =".$fila['ciudad']. "AND cod_reg =".$fila['region']."";
									$res = pg_exec($conn,$sql);
									for($i=0;$i<pg_numrows($res);$i++){ 
									$fila_com = pg_fetch_array($res,$i);
										if($fila['comuna']==$fila_com['cor_com']){	?>
											<option value="<? echo $fila_com['cor_com'];?>" selected="selected"><? echo $fila_com['nom_com'];?></option>
									<? }else{ ?>
											<option value="<? echo $fila_com['cor_com'];?>"><? echo $fila_com['nom_com'];?></option>
									<? 	}
									} ?>
									</select>
									</div>
								</td>
							  </tr>
							</table>
							</form>
							</td>
						</tr>
						<tr id="docente"><!--autrorizacion docente-->
						 <td>
						  <div id="masterdiv3">
							  <form name="form2" action="procesaEmpleado_new2.php?pesta=2&h=1&caso_an=1" method="post">
							 <table width="100%" border="0" cellpadding="0" cellspacing="2">
							   <? if($_PERFIL!=26){?>
							   <tr>
								 <td height="21" colspan="2" valign="top">
								 <div onClick="SwitchMenuAnotacion('habilitado')">
											<center><a href="#"><input type="button" value="HABILITACIONES" class="botonXX"></a></center>
								 </div>						 
								 </td>
								 <td width="74%" colspan="4" valign="top" align="left">
								 <div onClick="SwitchMenuAnotacion('autorizacion')">
												<div align="left"><a href="#">
												<input type="button" value="AUTORIZACION EJERCICIO DOCENTE" class="botonXX">
												  </a></div>
								 </div>
								 </td>
								 </tr>
								 <? }?>
								  <tr>
									<td colspan="4">
									<span class="autorizacion" id="autorizacion">
											<table width="100%" border="0" cellpadding="0" cellspacing="2">
								   <tr>
								  <td colspan="4" class="tableindex">Autorizacion ejercicio docente </td>
								  </tr>
								  <tr>
								   <td width="13%" class="cuadro02"><strong>N&deg; Resolucion </strong></td>
								  <td width="44%" class="cuadro01">
								  <div id="n_resolucion" style="width:80px;">
										<div id="div_resolu" onClick="creaInput(this.id, 'nu_resol',<?=$empleado?>,1,0,0)"><?=$fila['nu_resol']?></div>
										<div class="mensaje" id="error"></div>
									</div>						  </td>
								  <td width="13%" class="cuadro02"><strong>Fecha</strong></td>
								  <td width="27%" colspan="3" class="cuadro01">
								  <?
								  
										$dd = substr($fila['fecha_resol'],8,2);
										$mm = substr($fila['fecha_resol'],5,2);
										$aa = substr($fila['fecha_resol'],0,4);
										$fecha_resol = "$dd-$mm-$aa";
								  ?>
								  <div id="fecha_resolucion" style="width:80px;">
										<div id="div_fecha_resolu" onClick="creaInput(this.id, 'fecha_resol',<?=$empleado?>,1,0,0)"><?=$fecha_resol?></div>
										<div class="mensaje" id="error"></div>
									</div>						  </td>
								  </tr>
								<tr>
								  <td class="cuadro02"><strong>Nivel</strong></td>
								  <td colspan="5" class="cuadro01">
								   <? 
										$ob_titulo=new Empleado();
										$result_tipo_titulo=$ob_titulo->titulo($conn);
										$num_tipo_titulo=pg_numrows($result_tipo_titulo);
						?>
						<table width="119" >
						 <tr>
						   <td>		   
							 <table width="111">
								 <tr>
								 <? for ($iii=0;$iii<$num_tipo_titulo;$iii++){
										$row_tipo_tit=pg_fetch_array($result_tipo_titulo)?>
									   <td width="41">
										<?  if ($row_tipo_tit[codigo]=='1'){$var_click="mostrar_ocultar('tabla_sub_sector');";}
										   if ($row_tipo_tit[codigo]=='2'){$var_click="titulado(this,this.value,this.name);";}
										   if ($row_tipo_tit[codigo]=='3'){$var_click="tit_otras(this,this.value,this.name);";}
										?>
										<input name="tipo_titulo[]" value="<? echo $row_tipo_tit[codigo];?>" type="checkbox" onClick="<? echo $var_click;?>" <? if ($frmModo=="mostrar"){echo "disabled";}?> <? chekear($row_tipo_tit[codigo]);?> /></td>
										<td width="81" nowrap="nowrap"><font face="arial, geneva, helvetica" size=1 color=#000000><strong> <? echo $row_tipo_tit['nombre'];?> </strong></font> </td>
								 <? } ?>
								 </tr>
							 </table>					</td>
						 </tr>
						</table>							</td>
								  </tr>
								   <tr>
									 <?	$ob_plan=new Empleado();
										$ob_plan->institucion=$_INSTIT;
										$result_plan=$ob_plan->plan($conn);		
										$num_plan=pg_numrows($result_plan);
											
											$ob_titulo=new Empleado();
											$ob_titulo->empleado=$empleado;
											$ob_titulo->tipo=1;
											$res_titulo=$ob_titulo->postitulo($conn);
											$cant_titulo = @pg_numrows($res_titulo);
											
										//$row_tit_0 = @pg_fetch_array($res_postit,0); 
									?>   
									<? for($i=0;$i<3;$i++){
										$row_tit_x = @pg_fetch_array($res_titulo,$i);
										$id_estudio = $row_tit_x['id_estudio'];
										if(trim($id_estudio)==NULL){
											$id_estudio=0;
										}else{
											$id_estudio=$id_estudio;
										}
									?>
								  <td class="cuadro02"><strong>Titulo <?=$i+1?> </strong></td>
								  <td class="cuadro01">
								  <div id="nombre_titulos<?=$i+1?>" style="width:200px;">
										<div id="nomb_titulo<?=$i+1?>" onClick="creaInput(this.id, 'nombre', <?=$empleado?>, 2, <?=$id_estudio?>,1)">
										<?
											if(!$row_tit_x['nombre'] == NULL){
												echo $row_tit_x['nombre'];
											}else{
												echo "-";
											}
										?>
										</div>
										<div class="mensaje" id="error"></div>
									</div>						  </td>
								  <td class="cuadro02"><strong>Institucion</strong></td>
								  <td colspan="3" class="cuadro01">
								  <div id="nombre_institucion<?=$i?>" style="width:100px;">
										<div id="nomb_institucion<?=$i?>" onClick="creaInput(this.id, 'institucion',<?=$empleado?>,2,<?=$id_estudio?>,1)">
										<?
											if(!$row_tit_x['institucion'] == NULL){
												echo $row_tit_x['institucion'];
											}else{
												echo "-";
											}
										?>
										</div>
										<div class="mensaje" id="error"></div>
									</div>						  </td>
								  </tr>
								<tr>
								  <td class="cuadro02"><strong>A&ntilde;o</strong></td>
								  <td colspan="5" class="cuadro01">
								  <div id="año_1<?=$i?>" style="width:100px;">
										<div id="ano<?=$i?>1" onClick="creaInput(this.id, 'ano',<?=$empleado?>,2,<?=$id_estudio?>,1)">
										<?
											if(!$row_tit_x['ano'] == NULL){
												echo $row_tit_x['ano'];
											}else{
												echo "-";
											}
										?>
										</div>
										<div class="mensaje" id="error"></div>
									</div>						  </td>
								</tr>
								<? }?>
								<tr>
								  <?
									$ob_postit=new Empleado();
									$ob_postit->empleado=$empleado;
									$ob_postit->tipo=2;
									$res_postit=$ob_postit->postitulo($conn);
									$cant_postit = @pg_numrows($res_postit);
										for($ii=0;$ii<2;$ii++){
											$row_postit = @pg_fetch_array($res_postit,$ii);
											$id_estudio2 = $row_postit['id_estudio'];
											if(trim($id_estudio2)==NULL){
												$id_estudio2 = 0;
											}else{
												$id_estudio2 = $id_estudio2;
											}
								?>
								  <td class="cuadro02"><strong>Postitulo <?=$ii+1?> </strong></td>
								  <td class="cuadro01">
								  <div id="postitutlo<?=$ii?>" style="width:100px;">
										<div id="post<?=$ii?>1" onClick="creaInput(this.id, 'nombre',<?=$empleado?>,2,<?=$id_estudio2?>,2)">
										<?
											if(strlen(trim($row_postit['nombre'])) > 1){
												echo $row_postit['nombre'];
											}else{
												echo "-";
											}
										?>
										</div>
										<div class="mensaje" id="error"></div>
									</div>						  </td>
								<? }?>
								</tr>
								<tr>
								  <?
									$ob_posgra=new Empleado();
									$ob_posgra->empleado=$empleado;
									$ob_posgra->tipo=3;
									$res_posgra=$ob_posgra->postitulo($conn);
									$cant_posgra = @pg_numrows($res_posgra);
										for($e=0;$e<2;$e++){
											 $row_posgra = @pg_fetch_array($res_posgra,$e);
											 $id_estudio3 = $row_posgra['id_estudio'];
											 if(trim($id_estudio3)==NULL){
												$id_estudio3 = 0;
											}else{
												$id_estudio3 = $id_estudio3;
											}
								?>
								  <td class="cuadro02"><strong>Postgrado<?=$e+1?> </strong></td>
								  <td class="cuadro01">
								  <div id="posgrado<?=$e?>" style="width:100px;">
										<div id="pos<?=$e?>1" onClick="creaInput(this.id, 'nombre',<?=$empleado?>,2,<?=$id_estudio3?>,3)">
										<?
											if(strlen(trim($row_posgra['nombre'])) > 1){
												echo $row_posgra['nombre'];
											}else{
												echo "-";
											}
										?>
										</div>
										<div class="mensaje" id="error"></div>
									</div>						   </td>
								 <? }?>
								</tr>
								<?
									$ob_cu=new Empleado();
									$ob_cu->empleado=$empleado;
									$ob_cu->tipo=4;
									$res_cu=$ob_cu->postitulo($conn);
									$cant_cu = @pg_numrows($res_cu);
									
									for($ee=0;$ee<4;$ee++){
										$row_curso = @pg_fetch_array($res_cu,$ee);
										$id_estudio4 = $row_curso['id_estudio'];
											 if(trim($id_estudio4)==NULL){
												$id_estudio4 = 0;
											}else{
												$id_estudio4 = $id_estudio4;
											}
								
								?>
								<tr>
								  <td class="cuadro02"><strong>Curso <?=$ee+1?> </strong></td>
								  <td class="cuadro01">
								  <div id="nombre_curso<?=$ee?>" style="width:100px;">
										<div id="nomb_curso<?=$ee?>1" onClick="creaInput(this.id, 'nombre',<?=$empleado?>,2,<?=$id_estudio4?>,4)">
										<?
											if(strlen(trim($row_curso['nombre'])) > 0){
												echo $row_curso['nombre'];
											}else{
												echo "-";
											}
										?>
										</div>
										<div class="mensaje" id="error"></div>
									</div>						  </td>
								  <td class="cuadro02"><strong>A&ntilde;o</strong></td>
								  <td colspan="3" class="cuadro01">
								  <div id="ano_curso<?=$ee?>" style="width:100px;">
										<div id="anos_curso<?=$ee?>1" onClick="creaInput(this.id, 'ano',<?=$empleado?>,2,<?=$id_estudio4?>,4)">
										<?
											if(strlen(trim($row_curso['ano'])) > 0){
												echo $row_curso['ano'];
											}else{
												echo "-";
											}
										?>
										</div>
										<div class="mensaje" id="error"></div>
								  </div></td>
								  </tr>
								<tr>
								  <td class="cuadro02"><strong>Horas</strong></td>
								  <td colspan="5" class="cuadro01">
								  <div id="hora_curso<?=$ee?>" style="width:100px;">
										<div id="horas_curso<?=$ee?>1" onClick="creaInput(this.id, 'horas',<?=$empleado?>,2,<?=$id_estudio4?>,4)">
										<?
											if(strlen(trim($row_curso['horas'])) > 0){
												echo $row_curso['horas'];
											}else{
												echo "-";
											}
										?>
										</div>
										<div class="mensaje" id="error"></div>
									</div>						</td>
								</tr>
								<? }?>
								<tr>
								  <td class="cuadro02"><strong>Resumen de estudios </strong></td>
								  <td colspan="5" class="cuadro01">
								  <div id="resumen_estudios" style="width:100px;">
										<div id="res_estudio" onClick="creaInput(this.id, 'estudios',<?=$empleado?>,1,0,0)">
										<?
											if(strlen(trim($fila['estudios'])) > 1){
												echo $fila['estudios'];
											}else{
												echo "-";
											}
										?>
										</div>
										<div class="mensaje" id="error"></div>
									</div>							 </td>
								   </tr>
								 </table>
									</span>
									<span class="habilitado" id="habilitado">
										<?
											$q1 = "select * from habilitaciones where id_ano = '".trim($_ANO)."' and rut_emp = '".trim($_EMPLEADO)."' ORDER BY id_aux"; 
											$r1 = pg_Exec($conn,$q1);
											$n1 = pg_numrows($r1);
											
											if ($n1>0){  
										?>
										<!--habilitaciones ingresadas-->
										<input name="count" id="count" type="hidden" value="<?=$n1?>"/>
											<table width="103%" border="0" cellspacing="1" cellpadding="3">
											 <tr>
											   <td colspan="14" class="tableindex">HABILITACIONES INGRESADAS </td>
											  </tr>
											 <tr>
											   <td width="12%" rowspan="2" class="cuadro02"><div align="center">Fecha</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
											   <td width="10%" rowspan="2" class="cuadro02"><div align="center">Nro. Resol. </div></td>
											   <td width="7%" rowspan="2" class="cuadro02"><div align="center">Nro. Insc. </div></td>
											   <td width="13%" rowspan="2" class="cuadro02"><div align="center">Tipo Autriz. </div></td>
											   <td width="9%" rowspan="2" class="cuadro02"><div align="center">Subsector</div></td>
											   <td colspan="8" class="cuadro02"><div align="center">Cursos</div></td>
											   <td width="10%" rowspan="2" class="cuadro02"><div align="center">Eliminar</div></td>
											 </tr>
											 <tr>
											   <td width="4%" class="cuadro02">1&deg;</td>
											   <td width="5%" class="cuadro02">2&deg;</td>
											   <td width="5%" class="cuadro02">3&deg;</td>
											   <td width="5%" class="cuadro02">4&deg;</td>
											   <td width="5%" class="cuadro02">5&deg;</td>
											   <td width="5%" class="cuadro02">6&deg;</td>
											   <td width="5%" class="cuadro02">7&deg;</td>
											   <td width="5%" class="cuadro02">8&deg;</td>
											 </tr>
											 <?
											$arreglo_temp=array();					 
											 
											 $i = 0;
											 while ($i < $n1){ 
												 $f1 = pg_fetch_array($r1,$i);
												 $id_aux        =  $f1['id_aux'];
												 $fecha2        =  $f1['fecha'];
												 $resolucion    =  $f1['resolucion'];
												 $inscripcion   =  $f1['inscripcion'];
												 $tipo_aut      =  $f1['tipo_aut'];
												 $cod_subsector =  $f1['cod_subsector'];
												 $tipo_ense     =  $f1['tipo_ense'];
												 $c1            =  $f1['c1'];
												 $c2            =  $f1['c2'];
												 $c3            =  $f1['c3'];
												 $c4            =  $f1['c4'];
												 $c5            =  $f1['c5'];
												 $c6            =  $f1['c6'];
												 $c7            =  $f1['c7'];
												 $c8            =  $f1['c8'];
												 $EP            =  $f1['EP'];
												 $EDA           =  $f1['EDA'];
												 $EDM           =  $f1['EDM'];
												 $EDV           =  $f1['EDV'];
												 $EAL           =  $f1['EAL'];
												 $ETM           =  $f1['ETM'];
												 $EA            =  $f1['EA'];
												 
												 
												 $dd = substr($fecha2,8,2);
												 $mm = substr($fecha2,5,2);
												 $aa = substr($fecha2,0,4);
												 
												 $fecha2 = "$dd-$mm-$aa";
												 
												 
												 if ($tipo_aut==1){
													 $tipo_aut="Indefinida";
												 }else{
													 $tipo_aut="Temporal";
												 } 
																					
												
												 ?>
												 <tr class="cuadro01">
												   <td height="138">
													<div id="fecha_hab<?=$i+1?>" style="width:auto;">
														<div id="fecha_habilitacion<?=$i+1?>" onClick="creaInput(this.id, 'fecha', <?=$empleado?>,3,<?=$id_aux?>,0)">
															<?=$fecha2?>
														</div>
													<div class="mensaje" id="error"></div>
													</div>
												   </td>
												   <td>
												   <div id="resolucion<?=$i+1?>" style="width:50px;">
														<div id="div_resolucion<?=$i+1?>" onClick="creaInput(this.id, 'resolucion', <?=$empleado?>,3,<?=$id_aux?>,0)">
														  <?=$resolucion ?>
														</div>
													<div class="mensaje" id="error"></div>
													</div>
												   </td>
													<td>
														<div id="inscripcion<?=$i+1?>" style="width:50px;">
															<div id="div_inscripcion<?=$i+1?>" onClick="creaInput(this.id, 'inscripcion', <?=$empleado?>,3,<?=$id_aux?>)">
															  <?=$inscripcion ?>
															</div>
														<div class="mensaje" id="error"></div>
														</div>
												   </td>
												   <td>
												   <div id="tipo_autorizacion<?=$i+1?>" style="width:100" onClick="javascript:muestra_cmb_aut(div_tipo_autorizacion<?=$i+1?>,<?=$i+1?>)">
														<?=$tipo_aut;?>
													</div>
													<div id="div_tipo_autorizacion<?=$i+1?>"><? generar_tipo_autorizacion($tipo_aut,$empleado,$id_aux,$i);?></div>
													</td>
														 
														 
														<?
														// aqui agrego los subsectores asociados para esta institucion, para este año.
														$b2 = "select * from subsector where cod_subsector = '$cod_subsector'"; 
														$r2 = @pg_Exec($conn,$b2);
														$f2 = @pg_fetch_array($r2);
														$nombre_subsector = $f2['nombre'];
														$e=$i+1;
														?>											 
														 
												   <td>
												   <input type="hidden" name="contador" value="<?=$i?>" />
												   <div id="subsector2<?=$i+1?>" style="width:100" onClick="javascript:muestra_sub(div_subsector2<?=$i+1?>,<?=$i+1?>)">
														<?=$nombre_subsector?> 
												   </div>
													<div id="div_subsector2<?=$i+1?>"><? generar_subsector($conn,$institucion,$ano,$cod_subsector,$e,$id_aux,$empleado);?></div>
												   
												   </td>
												   <td colspan="8">
												   <div align="center">&nbsp;
												   
													  <table width="100%" border="0" cellspacing="1" cellpadding="0">
													   <tr>
														
														 <td width="15%" align="center">
														 <? if ($c1==1){ ?>
															<input type="checkbox" name="checkbox" value="checkbox" checked="checked" disabled="disabled" />
														 <? }else{ ?>
															<input type="checkbox" name="checkbox" value="checkbox" disabled="disabled" />
														 <? }?>
														 </td>											 
														 <td width="12%" align="center">
														 <? if ($c2==1){ ?> 
															<input type="checkbox" name="checkbox" value="checkbox" checked="checked" disabled="disabled" />
														 <? }else{?>
															<input type="checkbox" name="checkbox" value="checkbox" disabled="disabled" />
														 <? }?>
														 </td>											
														 <td width="12%" align="center">
														 <? if ($c3==1){ ?>
															<input type="checkbox" name="checkbox" value="checkbox" checked="checked" disabled="disabled" />
														 <? }else{?>
															<input type="checkbox" name="checkbox" value="checkbox" disabled="disabled" />
														 <? }?>
														 </td>											 
														<td width="12%">
														<? if ($c4==1){ ?> 
															<input type="checkbox" name="checkbox" value="checkbox" checked="checked" disabled="disabled" />										
														<? }else{ ?>
															<input type="checkbox" name="checkbox" value="checkbox" disabled="disabled" />
														<? }?>
														</td>
														<td width="9%">
														<? if ($c5==1){ ?>
															<input type="checkbox" name="checkbox" value="checkbox" checked="checked" disabled="disabled" />												
														<? }else{ ?>
															<input type="checkbox" name="checkbox" value="checkbox" disabled="disabled" />
														<? }?>
														</td>
														<td width="15%">
														<? if ($c6==1){ ?>
															<input type="checkbox" name="checkbox" value="checkbox" checked="checked" disabled="disabled" />		
														<? }else{ ?>
															<input type="checkbox" name="checkbox" value="checkbox" disabled="disabled" />		
														<? }?>
														</td>
														<td width="12%">
														<? if ($c7==1){ ?>
															<input type="checkbox" name="checkbox" value="checkbox" checked="checked" disabled="disabled" />		 
														<? }else{ ?>
															<input type="checkbox" name="checkbox" value="checkbox" disabled="disabled" />		
														<? }?>
														</td>
														<td width="13%">
														<? if ($c8==1){ ?>
															<input type="checkbox" name="checkbox" value="checkbox" checked="checked" disabled="disabled" />
														<? }else{ ?>
															<input type="checkbox" name="checkbox" value="checkbox" disabled="disabled" />		
														<? }?>
														</td>
																										
														<? if ($EP==1){ ?>
															 <? } ?>
														<? if ($EDA==1){ ?>
															 <? } ?>
														<? if ($EDM==1){ ?>
															 <? } ?>
														<? if ($EDV==1){ ?>
															 <? } ?>
														<? if ($EAL==1){ ?>
															 <? } ?>
														<? if ($ETM==1){ ?>
															 <? } ?>
														<? if ($EA==1){ ?>
															 <? } ?>
													   </tr>
													 </table>
												   </div></td>
												   <td><div align="center">
													 <label>
													 <input name="Submit3" type="submit" onClick="MM_goToURL('parent','procesaEmpleado_new2.php?id_aux=<?=$id_aux ?>&eli=1&pesta=2&caso_an=1');return document.MM_returnValue" value="E">
													 </label>
												   </div></td>
											  </tr>
												 <?
												 //// codigo nuevo para llenar el arreglo cod_subsecto[]
												 $arreglo_temp[]=$cod_subsector;									 
												 
												 $i++;
											 } 
											 ?>									  		 
									  </table>
										<!--fin habilitaciones ingresadas-->
										<? }?>
										<!--habilitaciones-->
											<table width="100%" border="0" cellpadding="0" cellspacing="0">
												  <tr>
													<td class="tableindex" colspan="4">Habilitaciones</td>
											  </tr>
												  <tr>
													<td colspan="3">&nbsp;</td>
													<td width="17%"><input type="submit" name="Submit322" value="GUARDAR" class="botonXX" onClick="return valida3(this.form);"/></td>
											  </tr>
												  <tr>
													<td width="14%" class="cuadro02"><strong>Fecha</strong></td>
													<td colspan="3" class="cuadro01"><input name="h_fecha" type="text" id="h_fecha" value="<?=$h_fecha ?>" size="10" maxlength="10"> 
														<span class="Estilo1">(dd-mm-aaaa)</span> <span class="Estilo2">(*)</span> <input name="rut_emp" type="hidden" id="rut_emp" value="<?=$_EMPLEADO ?>">								 		</td>
												  </tr>
												  <tr>
													<td class="cuadro02"><strong>Resolucion</strong></td>
													 <td colspan="3" class="cuadro01"><input name="h_resolucion" type="text" id="h_resolucion" value="<?=$h_resolucion ?>"> <span class="Estilo2">(*)</span>							   			 </td>
												  </tr>
												  <tr>
													<td class="cuadro02"><strong>Nro. Inscripcion</strong></td>
													<td colspan="3" class="cuadro01"><input name="h_inscripcion" type="text" id="h_inscripcion" value="<?=$h_inscripcion ?>"> <span class="Estilo2">(*)</span>							   			</td>
												  </tr>
												  <tr>
													<td class="cuadro02"><strong>Subsector</strong></td>
													<td colspan="3" class="cuadro01"> <? generar_subsector($conn,$_INSTIT,$_ANO,$cmb_subsector)?>
														<span class="Estilo2">(*)</span>										</td>
												  </tr>
												  <tr>
													<td class="cuadro02"><strong>Tipo de enseñanza</strong></td>
													<td colspan="3" class="cuadro01"><? generar_tipo_en($conn,$_INSTIT,$cmb_tipoensenanza)?>
														<span class="Estilo2">(*)</span>
													</td>
												  </tr>
												  
									  </table>
										<!--fin habilitaciones-->
										
										<? if ($cmb_tipoensenanza!=0){ ?>
										 <table width="100%" border="1" cellpadding="0" cellspacing="0" height="30">
										  <tr>
												<td colspan="4" class="tableindex">CURSOS</td>
										   </tr>
										  <tr>
											<td align="right" ><input type="checkbox" name="checkbox11" value="checkbox" onClick="ChequearTodos(this);"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Todos</font></td>
										  </tr>
										</table> 
									 <? /// muestro la tabla para básica de 1º a 8º								
										if (($cmb_tipoensenanza=="110") OR ($cmb_tipoensenanza=="160") OR ($cmb_tipoensenanza=="163")){ ?>	
										<table width="100%" border="1" cellspacing="0" cellpadding="0">
											   <tr>
												 <td class="cuadro02"><div align="center">1&ordm; </div></td>
												 <td class="cuadro01"><label>
													 <div align="center">
													   <input name="c1" type="checkbox" id="c1" value="1">
													 </div>
													 </label>                                     </td>
												 <td class="cuadro02"><div align="center">2&ordm;</div></td>
												 <td class="cuadro01">
													 <div align="center">
													   <input name="c2" type="checkbox" id="c2" value="1">
												   </div></td>
												 <td class="cuadro02"><div align="center">3&ordm;</div></td>
												 <td class="cuadro01">
													 <div align="center">
													   <input name="c3" type="checkbox" id="c3" value="1">
												   </div></td>
												 <td class="cuadro02"><div align="center">4&ordm;</div></td>
												 <td class="cuadro01">
													 <div align="center">
													   <input name="c4" type="checkbox" id="c4" value="1">
												   </div></td>											 
												<td class="cuadro02"><div align="center">5&ordm;</div></td>
												 <td class="cuadro01">
													 <div align="center">
													   <input name="c5" type="checkbox" id="c5" value="1">
												   </div></td>
												<td class="cuadro02"><div align="center">6&ordm;</div></td>
												 <td class="cuadro01">
													 <div align="center">
													   <input name="c6" type="checkbox" id="c6" value="1">
												   </div></td>
												<td class="cuadro02"><div align="center">7&ordm;</div></td>
												 <td class="cuadro01">
													 <div align="center">
													   <input name="c7" type="checkbox" id="c7" value="1">
												   </div></td>
												  <td class="cuadro02"><div align="center">8&ordm;</div></td>
												 <td class="cuadro01">
													 <div align="center">
													   <input name="c8" type="checkbox" id="c8" value="1">
												   </div></td>																		 
											   </tr>
									  </table>
									<? } 								
									 /// muestro la tabla para Media de 1º a 4º								
										if  (($cmb_tipoensenanza=="761") OR ($cmb_tipoensenanza=="410") OR ($cmb_tipoensenanza=="510") OR
											 ($cmb_tipoensenanza=="610") OR ($cmb_tipoensenanza=="710") OR ($cmb_tipoensenanza=="360") OR 
											 ($cmb_tipoensenanza=="362") OR ($cmb_tipoensenanza=="361") OR ($cmb_tipoensenanza=="460") OR 
											 ($cmb_tipoensenanza=="461") OR ($cmb_tipoensenanza=="560") OR ($cmb_tipoensenanza=="561") OR 
											 ($cmb_tipoensenanza=="660") OR ($cmb_tipoensenanza=="661") OR ($cmb_tipoensenanza=="760") OR 
											 ($cmb_tipoensenanza=="860") OR ($cmb_tipoensenanza=="861") OR ($cmb_tipoensenanza=="810") OR 
											 ($cmb_tipoensenanza=="310") ){ ?>	
											 <table width="100%" border="1" cellspacing="0" cellpadding="0">
											   <tr>
												 <td class="cuadro02"><div align="center">1&ordm; </div></td>
												 <td class="cuadro01"><label>
													 <div align="center">
													   <input name="c1" type="checkbox" id="c1" value="1">
													 </div>
													 </label>                                     </td>
												 <td class="cuadro02"><div align="center">2&ordm;</div></td>
												 <td class="cuadro01">
													 <div align="center">
													   <input name="c2" type="checkbox" id="c2" value="1">
												   </div></td>
												 <td class="cuadro02"><div align="center">3&ordm;</div></td>
												 <td class="cuadro01">
													 <div align="center">
													   <input name="c3" type="checkbox" id="c3" value="1">
												   </div></td>
												 <td class="cuadro02"><div align="center">4&ordm;</div></td>
												 <td class="cuadro01">
													 <div align="center">
													   <input name="c4" type="checkbox" id="c4" value="1">
												   </div></td>																										 
											   </tr>
											 </table>
									 <? }
									 }?>
									 <br/>
									 <table width="100%" border="0" cellpadding="0" cellspacing="0">
										  <tr>
											<td width="14%" class="cuadro02"><strong>Tipo de<br />
											Autorizacion</strong></td>
											<td width="86%" align="left">
											<table width="51%" border="0" cellpadding="0" cellspacing="0">
												 <tr>
												   <td width="47%" class="cuadro01">Indefinido</td>
												   <td width="53%" class="cuadro01">Temporal</td>
												 </tr>
												 <tr align="center">
												   <td><input name="h_tipo_aut" type="radio" value="1" checked="checked"></td>
												   <td><input name="h_tipo_aut" type="radio" value="2" checked="checked"></td>
												 </tr>
											  </table></td>
										  </tr>
									</table>	
									</span>
									</td>
								  </tr>
								</table>
							  </form>
						  </div>
							 
						  </td>
							 
						</tr>
						   <tr>
						   </tr>
					  </table>
					</td>
						</tr>
							<tr id="curriculum"><!--CV-->
							  <td>
							  <table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
								  <td>
								  <table width="90%" border="0" cellpadding="0" cellspacing="2">
									<tr>
									  <!--CURRICULUM!-->
									  <?		
											$ob_trabaja_cv=new Empleado();
											$ob_trabaja_cv->empleado=$empleado;
											$ob_trabaja_cv->institucion=$_INSTIT;
											$result_trabaja=$ob_trabaja_cv->trabaja_cv($conn);
											$num_trabaja = @pg_numrows($res_trabaja);
											
									?>
									  <td colspan="4" class="tableindex"><strong>Curriculum</strong></td>
									</tr>
									<tr>
									  <?
										for($cargo=0;$cargo<2;$cargo++){
										 $row_trabaja=@pg_fetch_array($result_trabaja,$cargo);
									?>
									  <td width="18%" class="cuadro02"><strong>Cargo
										<?=$cargo+1?>
									  </strong></td>
									  <td width="24%" class="cuadro01">
									  <div id="cargos<?=$cargo+1?>" style="width:100" onClick="javascript:muestra_cmb_cargo(div_cargo<?=$cargo+1?>,<?=$cargo+1?>)">
										<? 	$sql= "SELECT nombre_cargo FROM cargos WHERE id_cargo=".$row_trabaja['cargo'];
											$resp=pg_exec($conn,$sql);
											$nombre = pg_result($resp,0);
											$null = "Presione Aquí";
											if(strlen($nombre)>1){
												echo $nombre;
											}else{
												echo $null;
											}
										?> 
									  </div><? $e=$cargo+1;?>
									  <div id="div_cargo<?=$cargo+1?>"><? generar_cargo($conn,$row_trabaja['cargo'],$empleado,$e,$_INSTIT);?></div>
									  </td>
									  <? }?>
									</tr>
									<tr>
									  <td class="cuadro02"><strong>Idiomas</strong></td>
									  <td class="cuadro01"><div id="div_idioma" style="width:100px;">
										  <div id="div_idiomas" onClick="creaInput(this.id,'idiomas',<?=$empleado?>,1,0,0)">
											<?
											if(strlen(trim($fila['idiomas'])) > 0){
												echo $fila['idiomas'];
											}else{
												echo "-";
											}
										?>
										  </div>
										<div class="mensaje" id="div6"></div>
									  </div></td>
									  <td width="22%" class="cuadro02"><strong>A&ntilde;os de experiencia </strong></td>
									  <td width="36%" class="cuadro01">
									  <div id="anos_experiencia" style="width:auto;">
										  <div id="div_anos_exp" onClick="creaInput(this.id, 'anos_exp',<?=$empleado?>,1,0,0)">
											<?
											if(strlen(trim($fila['anos_exp'])) > 0){
												echo $fila['anos_exp'];
											}else{
												echo "-";
											}
										?></div>
										 <div class="mensaje" id="div6"></div>
									  </div></td>
									</tr>
									<tr>
									  <td class="cuadro02"><strong>N&deg; horas por<br />
										contrato </strong></td>
									  <td class="cuadro01"><div id="horas_por_contrato" style="width:100px;">
										  <div id="div_hxcontrato" onClick="creaInput(this.id, 'hxcontrato',<?=$empleado?>,1,0,0)">
											<?
											if(strlen(trim($fila['hxcontrato'])) > 0){
												echo $fila['hxcontrato'];
											}else{
												echo "- hrs";
											}
										?>
										  </div>
										<div class="mensaje" id="div6"></div>
									  </div></td>
									  <td class="cuadro02"><strong>N&deg; horas por clase </strong></td>
									  <td class="cuadro01"><div id="horas_por_clase" style="width:20px;">
										  <div id="div_hxclase" onClick="creaInput(this.id, 'hxclase',<?=$empleado?>),1,0,0">
											<?
											if(strlen(trim($fila['hxclase'])) > 0){
												echo $fila['hxclase'];
											}else{
												echo "- hrs";
											}
										?>
										  </div>
										<div class="mensaje" id="div6"></div>
									  </div></td>
									</tr>
									<tr>
									  <td class="cuadro02"><strong>Responsable de<br />
										anotaciones </strong></td>
									  <td colspan="3" class="cuadro01"><div id="responsable_anotaciones" style="width:100px;">
										  <div id="resp_anotaciones" onClick="creaInput(this.id, 'campo2')">
											<?
											/*if(strlen(trim($fila['hxclase'])) > 0){
												echo $fila['hxclase']."&nbsp;hrs";
											}else{
												echo "- hrs";
											}*/
											echo "SI";
										?>
										  </div>
										<div class="mensaje" id="div6"></div>
									  </div></td>
									</tr>
								  </table>
								  </td>
								</tr>
								<tr>
								  <td>&nbsp;</td>
								</tr>
								<tr>
								  <td>
								  <table width="90%" border="0" cellpadding="0" cellspacing="1">
									<tr>
									  <td colspan="4" class="tableindex"><strong>Trabaja en otra institucion </strong></td>
									</tr>
									 <? for($oi=0;$oi<3;$oi++){?>
									<tr>
									  <td width="17%" class="cuadro02"><strong>Institucion&nbsp;<?=$oi+1?></strong></td>
									  <td width="26%" class="cuadro01">
									  <div id="div_t_institucion1<?=$oi?>" style="width:100px;">
										<div id="div_tipoinst<?=$oi?>" onClick="creaInput(this.id, 't_institucion<?=$oi+1?>',<?=$empleado?>,1,0,0)">
										<?	$tt=$oi+1;
											$nombre = "t_institucion".$tt;
											if(strlen(trim($fila[$nombre])) > 0){
												echo $fila[$nombre];
											}else{
												echo "-";
											}
										?>
										</div>
										<div class="mensaje" id="error"></div>
									</div>							  </td>
									  <td width="22%" class="cuadro02"><strong>Horas</strong></td>
									  <td width="35%" class="cuadro01">
									  <div id="t_horas<?=$oi?>" style="width:60px;">
										<div id="t_hora1<?=$oi?>" onClick="creaInput(this.id, 't_hora<?=$oi+1?>',<?=$empleado?>,1,0,0)">
										<?	
											$th=$oi+1;
											$hora= "t_hora".$th;
											if(strlen(trim($fila[$hora])) > 0){
												echo $fila[$hora];
											}else{
												echo "-";
											}
										?>
										</div>
										<div class="mensaje" id="error"></div>
									</div>							  </td>
									</tr>
									<? }?>
								</table>
								</td>
								</tr>
							  </table>
							  </td>
							</tr>
							<tr id="acceso_web"><!--Acceso WEB-->
							  <td>
							  <table width="90%" border="0" cellpadding="0" cellspacing="2">
								<tr>
								  <td colspan="2" class="tableindex"><strong>Acceso Web </strong></td>
								</tr>
								<?
										if (($_PERFIL == 0) || ($_PERFIL == 14) || ($_PERFIL == 1)){
								?>
								<tr>
								  <td colspan="2" class="tabla02">
								  <? if($_PERFIL == 0){?> 
									 <INPUT class="BotonXX"  TYPE="button" value="AGREGAR EXPIRACION" onClick=document.location="usuario/expiracion.php">
									 <? } ?>
									 <INPUT class="BotonXX"  TYPE="button" value="CAMBIAR CLAVE" onClick=document.location="usuario/claveAcceso.php3">
									 <INPUT class="BotonXX"  TYPE="button" value="AGREGAR PERFIL" onClick=document.location="usuario/addPerfil.php3">						 
							
								  </td>
								</tr>
								<? }
										$qry="select * from usuario where nombre_usuario='".trim($empleado)."'";
										$result =@pg_Exec($conn,$qry);
										if (!$result) {
											error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
										}else{
											if (pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}else{
														$idUsuario=trim($fila1['id_usuario']);
													};
											};
										};
		
								$_ID_USER	=	$idUsuario;
								if(!session_is_registered('_ID_USER')){
								   session_register('_ID_USER');
								};
								if($idUsuario!="") {//SI EL NOMBRE DE USUARIO YA ESTA REGISTRADO COMO USUARIO DE COE
								?> 
								<tr>
								  <td width="28%" class="cuadro02"><strong>Nombre de usuario </strong></td>
								  <td width="72%" class="cuadro01"><?=trim($empleado)?></td>
								</tr>
								<tr>
								  <td class="cuadro02"><strong>Perfiles de acceso </strong></td>
								  <td class="cuadro01">
								  <?
										$ob_usuariocv = new Empleado();
										$ob_usuariocv->id_usuario=$idUsuario;
										$ob_usuariocv->institucion=$_INSTIT;
										$result=$ob_usuariocv->usuario_cv($conn);
											if (!$result){ 
												error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
															error('<B> ERROR :</b>Error al acceder a la BD. (10)</B>');
															exit();
														};
														for($i=0 ; $i < @pg_numrows($result) ; $i++){
															$fila1 = @pg_fetch_array($result,$i);
															echo "- ".$fila1["nombre_perfil"];
															 if(($_PERFIL=="0")||($_PERFIL=="14")){
																	if($fila1["estado"]==1){?>
																&nbsp;&nbsp;&nbsp;&nbsp;
																<input name="button"  type=button class='BotonXX' onclick=document.location='usuario/onoffPerfil.php3?estado=1&perfil=<? echo $fila1["id_perfil"]; ?>&usuario=<? echo $fila1["id_usuario"]; ?>' value=DESACTIVAR />
																<input name="button2"  type=button class='BotonXX' onclick=document.location='usuario/onoffPerfil.php3?accion=3&perfil=<? echo $fila1["id_perfil"]; ?>&usuario=<? echo $fila1["id_usuario"]; ?>' value=ELIMINAR />
																<br />
																<? }else{?>
																&nbsp;&nbsp;&nbsp;&nbsp;
																<input name="button2"  type=button class='BotonXX' onclick=document.location='usuario/onoffPerfil.php3?estado=0&perfil=<? echo $fila1["id_perfil"]; ?>&usuario=<? echo $fila1["id_usuario"]; ?>' value=ACTIVAR />
																<input name="button2"  type=button class='BotonXX' onclick=document.location='usuario/onoffPerfil.php3?accion=3&perfil=<? echo $fila1["id_perfil"]; ?>&usuario=<? echo $fila1["id_usuario"]; ?>' value=ELIMINAR />
																<br />
																<? }
														 }
													}
											  }
										};?>						 
								 </td>
								</tr>
								<? }else{ //el usuario no tiene acceso web?>
								<tr>
								  <td colspan="2" class="cuadro02">
								  <center><BR><BR><BR><BR>
											<b>USUARIO SIN ACCESO WEB</b> <BR>
											
											<INPUT class="BotonXX"  TYPE="button" value="CREAR CUENTA" onClick=document.location="usuario/creaAcceso.php3"                                     <?php if(($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL==1)){echo " disabled ";}?>>&nbsp;
									</center>						  
									</td>
								</tr>
								<tr>
								  <td colspan="2" class="cuadro02">
											<input type="button" class="BotonXX" value="VOLVER" onclick=document.location="empleado_new2.php" />
								  </td>
								</tr>
								 <? }?>
								
							  </table>
							  </td>
							</tr>
							<tr id="grupos"><!--grupos-->
							  <td height="24">
							  <form mane="frm" action="procesaEmpleado_new2.php?pesta=5&graba=1&caso_an=1&rdb=<?=$institucion?>&_EMPLEADO=<?=$_EMPLEADO?>" method=post>
							  <table width="90%" border="0" cellpadding="0" cellspacing="0">
								<tr>
								  <td colspan="3" class="tableindex"><strong>Grupos</strong></td>
								</tr>
								<? if($agregarg==1){
									   
								?>
								<tr>
									<td colspan="3">
									<div align="right">
									  <label>
										  <input name="GRABAR" class="BotonXX" type="submit" id="GRABAR" value="GRABAR">
										  <input name="Submit" class="BotonXX" type="button" onClick="MM_goToURL('parent','empleado_new2.php?pesta=5');return document.MM_returnValue" value="VOLVER">
									  </label>
									</div>
									</td>
								</tr>
								<tr class="cuadro02">
									<td width="38%"><strong>Nombre</strong></td>
									<td width="48%"><strong>Descripcion</strong></td>
									<td><strong>&nbsp;</strong></td>
								</tr>
								<?		$ob_grupo= new Empleado();
										$ob_grupo->institucion=trim($_INSTIT);
										$resp=$ob_grupo->grupos($conn);
										$nun = pg_numrows($resp);
								 for($lt=0;$lt<$nun;$lt++){
										$fl = @pg_fetch_array($resp,$lt);
										$nombre      = $fl['nombre'];
										$descripcion = $fl['descripcion'];
										$id_grupo    = $fl['id_grupo'];
										
										// busco este grupo en la relacion_grupo
											$ob_grupo2= new Empleado();
											$ob_grupo2->empleado=$_EMPLEADO;
											$ob_grupo2->id_grupo=$id_grupo;
											$r2=$ob_grupo2->grupos_2($conn);
											$n2 = pg_numrows($r2);
											 
									if ($n2==0){ 
								?>
								<tr class="cuadro01">
									<td><?=$nombre?></td>
									<td><?=$descripcion?></td>
									<td>
									<div align="center">
									   <label>
										<input type="checkbox" name="chg<?=$lt_grupo?>" value="<?=$id_grupo?>">
									   </label>
									</div>
									</td>
								</tr>
								<? };	
								}?>
								
								<? }else{ 
									$ob_grupo3= new Empleado();
									$ob_grupo3->institucion=$institucion;
									$ob_grupo3->empleado=$_EMPLEADO;
									$rl=$ob_grupo3->grupos_3($conn);
									$n1 = pg_numrows($rl);
									
											
								?>
								<? if (($_PERFIL == 14) OR ($_PERFIL == 0)){  ?>	
									<tr class="cuadro01">
									  <td>&nbsp;</td>
									  <td>&nbsp;</td>
									  <td align="right"><input class="BotonXX" name="AGREGARGRUPO" type="submit" id="AGREGARGRUPO" onClick="MM_goToURL('parent','empleado_new2.php?pesta=5&agregarg=1');return document.MM_returnValue" value="AGREGAR"></td>
									</tr>
								<? }?>
								<tr class="cuadro02">
								  <td><strong>Nombre</strong></td>
								  <td><strong>Descripcion</strong></td>
								  <?
										if (($_PERFIL==14) OR ($_PERFIL==0)){ ?>								
											<td width="14%" class="cuadro02"><strong>Borrar</strong></td>
									 <? } ?>
								</tr>
								<?
									for($grupos=0;$grupos<$n1;$grupos++){
											$row_grupos = @pg_fetch_array($rl,$grupos);
											 $nombre      = $row_grupos['nombre'];
											 $descripcion = $row_grupos['descripcion'];
											 $id_aux      = $row_grupos['id_aux'];
											 $id_grupo    = $row_grupos['id_grupo'];
								?>
								<tr class="cuadro01">
								  <td><?=$nombre?></td>
								  <td><?=$descripcion?></td>
								<? if (($_PERFIL==14) OR ($_PERFIL==0)){ ?>									 
								   <td class="cuadro01">
									<div align="center">
										   <input name="Submit2" type="button" onClick="MM_goToURL('parent','procesaEmpleado_new2.php?pesta=5&borrar=1&id_grupo=<?=$id_grupo ?>&caso_an=1');return document.MM_returnValue" value="B">
									</div>
								   </td>
								 <? }?>
								</tr>
								<? }
								}?>
							  </table>
							  </form>
							  </td>
							</tr>
					</table>
			<? }?>  
			<!--</table>-->
			<!--fin campos de datos-->
			</td>
		  </tr>
    </table>
	</td>
		<td width="65" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
</table>
</body>
</html>
