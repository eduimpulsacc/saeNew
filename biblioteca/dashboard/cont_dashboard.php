<?
 require("../../util/header.php");
 require("mod_dashboard.php");
 
 $funcion=$_POST['funcion'];
 
 $ob_dashboard = new Dashhoard();
 
 
 if($funcion==1){
	$rstop10LP = $ob_dashboard->top10LibrosPrestados($conn,$_ANO);
	?>
    <script type="text/javascript" src="../../admin/clases/highcharts/js/highcharts2.js"></script>
   
    <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" bordercolor="#FFFFFF">
  <tr class="titulos-respaldo">
    <td colspan="2" align="center">CUADRO ESTAD&Iacute;STICO<br /></td>
    </tr>
  <tr>
    <td width="50%" valign="top" nowrap="nowrap"><table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
      <tr class="cuadro02 header">
        <td colspan="2" align="center">Libros m&aacute;s solicitados (Top 10)</td>
        </tr>
      <tr class="cuadro02 header">
        <td width="80%">T&iacute;tulo</td>
        <td width="20%" align="center">Solicitudes</td>
      </tr>
       <?php  for($lp=0;$lp<pg_numrows($rstop10LP);$lp++){
		   $fila_lp = pg_fetch_array($rstop10LP,$lp);
		   
		   if(($lp % 2)==0){
				$clase="detalleoff";
			}else{
				$clase="detalleon";
			}
		   ?>
      <tr class="<?php echo $clase ?>">
        <td><?php echo $fila_lp['titulo'] ?></td>
        <td align="center"><?php echo $fila_lp['cuenta'] ?></td>
        </tr>
        <?php }?>
    </table></td>
    <td valign="top">
    
   
    
    <table width="100%" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse">
      <tr class="cuadro02 header">
        <td width="100%" align="center">Estad&iacute;stica mensual</td>
      </tr>
      <tr >
        <td align="center"><?php 
	//prestamos por mes
	//primero necesito las fechas del año
	$rs_fecha = $ob_dashboard->dataAno($conn,$_ANO);
	$fila_ano = pg_fetch_array($rs_fecha,0);
	$parte = explode("-",$fila_ano['fecha_inicio']);
	$termina = explode("-",$fila_ano['fecha_termino']);
	
	if($fila_ano['situacion']==1){
		if(date("m")){
			$termina = explode("-",date("Y-m-d"));
		}
		else{
		 $termina = explode("-",$fila_ano['fecha_termino']);
		}
	}
	else{
		$termina = explode("-",$fila_ano['fecha_termino']);
	}
	
	for($f=$parte[1];$f<=$termina[1];$f++){
		
  $mes=($parte[1]!= $f && $f<10)?"0$f":$f;
	 
	 $rs_pmes = $ob_dashboard->cuentaPrestamosTodo($conn,$_ANO,$mes);
	 
	 $cuenta = pg_result($rs_pmes,0);
	 
	 $gr['mes'][]="$mes";
	 $gr['cuenta'][]=$cuenta;
	 
	}
	
	?>
    <script>
	Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
         text: ''
    },
    
    xAxis: {
        categories: [
			<?php for($m=0;$m<=count($gr['mes']);$m++){
			echo "'".envia_mesCorto($gr['mes'][$m])."',";			
			 }?>
			
		]
    },
    yAxis: {
        title: {
            text: ''
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Cantidad de Pr\xe9stamos',
        data: [<?php for($m=0;$m<=count($gr['cuenta']);$m++){
			echo $gr['cuenta'][$m].",";			
			 }?>]
    },]
});
	</script>
    <div id="container" style="width:350px;">
    
    </td>
      </tr>
      <?php  for($lp=0;$lp<pg_numrows($rstop10LP);$lp++){
		   $fila_lp = pg_fetch_array($rstop10LP,$lp);
		   
		   if(($lp % 2)==0){
				$clase="detalleoff";
			}else{
				$clase="detalleon";
			}
		   ?>
      <?php }?>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
      <tr class="titulos-respaldo">
        <td colspan="3" align="center">TOP 10 Usuarios</td>
        </tr>
      <tr class="cuadro02 header">
        <td width="33%" align="center">Alumnos</td>
        <td width="33%" align="center">Apoderados</td>
        <td width="33%" align="center">Empleados</td>
      </tr>
      <tr>
        <td valign="top">
        <?php 
		$rs_topalu = $ob_dashboard->top10Usuarios($conn,$_ANO,3);?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <?php if(pg_numrows($rs_topalu)==0){?>
        <tr class="detalleoff">
            <td align="center">Sin informaci&oacute;n</td>
          </tr>
        <?php }else{?>
       <?php  for($ta=0;$ta<pg_numrows($rs_topalu);$ta++){
		   $fila_ta=pg_fetch_array($rs_topalu,$ta);
		   if(($ta % 2)==0){
				$clase="detalleoff";
			}else{
				$clase="detalleon";
			}
		   ?>
          <tr class="<?php echo $clase ?>">
            <td><?php echo $fila_ta['nombre'] ?></td>
          </tr>
         <?php  }?>
         <?php }?>
        </table></td>
        <td valign="top"> <?php 
		$rs_topalu = $ob_dashboard->top10Usuarios($conn,$_ANO,2);?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <?php if(pg_numrows($rs_topalu)==0){?>
        <tr class="detalleoff">
            <td align="center">Sin informaci&oacute;n</td>
          </tr>
        <?php }else{?>
       <?php  for($ta=0;$ta<pg_numrows($rs_topalu);$ta++){
		   $fila_ta=pg_fetch_array($rs_topalu,$ta);
		   if(($ta % 2)==0){
				$clase="detalleoff";
			}else{
				$clase="detalleon";
			}
		   ?>
          <tr class="<?php echo $clase ?>">
            <td><?php echo $fila_ta['nombre'] ?></td>
          </tr>
         <?php  }?>
         <?php }?>
        </table></td>
        <td valign="top"> <?php 
		$rs_topalu = $ob_dashboard->top10Usuarios($conn,$_ANO,1);?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <?php if(pg_numrows($rs_topalu)==0){?>
        <tr class="detalleoff">
            <td align="center">Sin informaci&oacute;n</td>
          </tr>
        <?php }else{?>
       <?php  for($ta=0;$ta<pg_numrows($rs_topalu);$ta++){
		   $fila_ta=pg_fetch_array($rs_topalu,$ta);
		   if(($ta % 2)==0){
				$clase="detalleoff";
			}else{
				$clase="detalleon";
			}
		   ?>
          <tr class="<?php echo $clase ?>">
            <td><?php echo $fila_ta['nombre'] ?></td>
          </tr>
         <?php  }?>
         <?php }?>
        </table></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse">
      <tr class="titulos-respaldo">
        <td align="center">Pr&eacute;stamos por Curso</td>
      </tr>
      <tr>
        <td>
       <?php  
	   $rs_liscurso = $ob_dashboard->cuentaPrestamosGroupCurso($conn,$_ANO);
	   
	   for($pc=0;$pc<pg_numrows($rs_liscurso);$pc++){
		 $fila_pc = pg_fetch_array($rs_liscurso,$pc);
		 
		 $gc['curso'][]=$fila_pc['id_curso'];
	 	 $gc['cuenta'][]=$fila_pc['cuenta'];
		 
		 }
	   
	   
	   ?>
        <script>
	Highcharts.chart('cont2', {
    chart: {
        type: 'line'
    },
    title: {
         text: ''
    },
    
    xAxis: {
        categories: [
			<?php for($m=0;$m<=count($gc['curso']);$m++){
			echo "'".CursoPalabra($gc['curso'][$m],6,$conn)."',";			
			 }?>
			
		]
    },
    yAxis: {
        title: {
            text: ''
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Cantidad de Pr\xe9stamos',
        data: [<?php for($m=0;$m<=count($gc['cuenta']);$m++){
			echo $gc['cuenta'][$m].",";			
			 }?>]
    },]
});
	</script>
        <div id="cont2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </td>
      </tr>
    </table></td>
  </tr>
    </table>

    <?
	 
 }
 if($funcion==2){
	 //tengo que revisar si tengo bloqueos vencidos
	 $lisbloqueos = $ob_dashboard->bloqueosVencidos($conn,$rdb,$ano,$fecha);
	 if(pg_numrows($lisbloqueos)>0){
			for($r=0;$r<pg_numrows($lisbloqueos);$r++){
				$freg = pg_fetch_array($lisbloqueos,$r);
				$pres = $freg['id_prestamo'];
				$ob_dashboard->desbloquearPrestamos($conn,$pres);
			
			}
		}
	}
?>