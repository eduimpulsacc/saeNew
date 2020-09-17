<?php 
	$li_month = $_GET["ai_mes"];
	$li_agno = $_GET["ai_ano"];

function UltimoDia($anho,$mes){ 

   if (((fmod($anho,4)==0) and (fmod($anho,100)!=0)) or (fmod($anho,400)==0)) { 
       $dias_febrero = 29; 
   } else { 
	    $dias_febrero = 28; 
   } 
      
   switch($mes) { 
       case 01: return 31; break; 
       case 02: return $dias_febrero; break; 
       case 03: return 31; break; 
       case 04: return 30; break; 
       case 05: return 31; break; 
       case 06: return 30; break; 
       case 07: return 31; break; 
       case 08: return 31; break; 
       case 09: return 30; break; 
       case 10: return 31; break; 
       case 11: return 30; break; 
       case 12: return 31; break; 
  } 
}

//echo "--> $mes";

$fecha_day = array('Domingo','Lunes','Martes','Miercoles','Jueves', 'Viernes', 'Sabado');
$fecha_month = array('--','Enero','Febrero','Marzo','Abril','Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

print_r($fecha_day[date(w)]);
echo "<br>";
print_r($fecha_month[date(n)]);


?> 
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?$li_cantidad_dias = UltimoDia($li_agno, $li_month);?> 
<select name="mes" onChange="parent.location.href='none.php?ai_mes='+mes.options[mes.selectedIndex].value+'&ai_ano='+ano.options[ano.selectedIndex].value">
  <option value="1">e</option>
  <option value="2">f</option>
  <option value="3">m</option>
  <option value="4">a</option>  
</select>
<select name="select2">
<?
for ($j=1;$j<=$li_cantidad_dias;$j++)
	{
		echo " <option value='$j'>$j</option>";
	}
?>
</select>
<select name="ano">
 <option value="2001">2001</option>
  <option value="2002">2002</option>
   <option value="2003">2003</option>
   <option value="2004">2004</option>
</select>

<?=(date(l))?>
</body>
</html>
