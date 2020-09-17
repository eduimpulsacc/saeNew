<HTML>
<HEAD>
<TITLE>TABLA CON SCROLL</TITLE>
<STYLE>
#encabezado2{border:0}
#encabezado2 td{border-width:1px} /* columna fija de numeros*/
#datos2{border:0}
#datos2 td{border-width:1px; vertical-align:top; white-space:nowrap}
</STYLE>
</HEAD>
<BODY>

<h2>Tabla con desplazamiento y encabezado fijo.</h2>
Para <b>IE</b> ?.
<p>

<table border=1 bgcolor=scrollbar align=center>

<td style="vertical-align:top">

<table border=1 bgcolor="#cccccc" cellspacing=0 id="encabezado2">
<tr><td>&nbsp;</td></tr>
<tr><td>1</td></tr>
<tr><td>2</td></tr>
<tr><td>3</td></tr>
<tr><td>4</td></tr>
<tr><td>5</td></tr>
<tr><td>6</td></tr>
</table>

</td>

<td style="vertical-align:top">

<div style="overflow:auto; overflow-y:hidden; width:100px; padding:0">

<table border=1 cellspacing=0 id="datos2" bgcolor=white>

	<tr>
		<th width="100">Q</th>
		<th width="100">Q</th>
		<th width="100">Q</th>
		<th width="100">Q</th>
		<th width="100">Q</th>
		<th width="100">Q</th>
		<th width="100">Q</th>
		<th width="100">Q</th>
		<th width="100">Q</th>
		<th width="100">Q</th>
	</tr>
<?	for($i=1;$i<=6;$i++){	?>
		<tr>
	<?	for($j=1;$j<=10;$j++){	
			if($j<10){	?>
				<td width="100">&nbsp;<? echo $j;?></td>
	<?		}else{	?>
				<td width="100"><? echo $j;?></td>
<?			}	?>
<?		}	?>
		</tr>
<?	}	?>

<!--	<tr>
		<td width="50">&nbsp;</td><td width="50">qwertyuiop</td><td width="50">qwertyuiop</td><td width="50">qwertyuiop</td><td width="50">qwertyuiop</td><td width="50">qwerty</td><td width="50">qwerty</td>
		<td width="50">qwertyuiop</td><td width="50">qwerty</td><td width="50">qwerty</td>
	</tr>
	<tr>
		<td width="50">&nbsp;</td><td width="50">qwertyuiop</td><td width="50">qwertyuiop</td><td width="50">qwertyuiop</td><td width="50">qwertyuiop</td><td width="50">qwerty</td><td width="50">qwerty</td>
		<td width="50">qwertyuiop</td><td width="50">qwerty</td><td width="50">qwerty</td>
	</tr>
	<tr>
		<td width="50">&nbsp;</td><td width="50">qwertyuiop</td><td width="50">qwertyuiop</td><td width="50">qwertyuiop</td><td width="50"><nobr>qwert yuiop</nobr></td><td width="50">qwerty <br>qwerty</td>
		<td width="50">qwerty</td><td width="50">qwertyuiop</td><td width="50">qwerty</td><td width="50">qwerty</td>
	</tr>
	<tr>
		<td width="50">&nbsp;</td><td width="50">qwertyuiop</td><td width="50">qwertyuiop</td><td width="50">qwertyuiop</td><td width="50">qwertyuiop</td><td width="50">qwerty</td><td width="50">qwerty</td>
		<td width="50">qwertyuiop</td><td width="50">qwerty</td><td width="50">qwerty</td>
	</tr>
	<tr>
		<td width="50">&nbsp;</td><td width="50">qwertyuiop</td><td width="50">qwertyuiop</td><td width="50">qwertyuiop</td><td width="50">qwertyuiop</td><td width="50">qwerty</td><td width="50">qwerty</td>
		<td width="50">qwertyuiop</td><td width="50">qwerty</td><td width="50">qwerty</td>
	</tr>
	<tr>
		<td width="50">&nbsp;</td><td width="50">qwertyuiop</td><td width="50">qwertyuiop</td><td width="50">qwertyuiop</td><td width="50">qwertyuiop</td><td width="50">qwerty</td><td width="50">qwerty</td>
		<td width="50">qwertyuiop</td><td width="50">qwerty</td><td width="50">qwerty</td>
	</tr>
-->
	<tr>


	<!-- //CANTIDAD DE COLUMNAS ¡SIN ENCABEZADO!//    -->
		<td colspan=10>&nbsp;</td>
	</tr>	

</table>
</div>
</td>
</table>
</BODY>
</HTML>