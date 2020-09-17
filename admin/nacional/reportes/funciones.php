<?
function envia_mes($mes)
	{
		if($mes=="01"){$t_mes=Enero;}
		if($mes=="02"){$t_mes=Febrero;}
		if($mes=="03"){$t_mes=Marzo;}
		if($mes=="04"){$t_mes=Abril;}
		if($mes=="05"){$t_mes=Mayo;}
		if($mes=="06"){$t_mes=Junio;}
		if($mes=="07"){$t_mes=Julio;}
		if($mes=="08"){$t_mes=Agosto;}
		if($mes=="09"){$t_mes=Septiembre;}
		if($mes=="10"){$t_mes=Octubre;}
		if($mes=="11"){$t_mes=Noviembre;}
		if($mes=="12"){$t_mes=Diciembre;}	
		return ($t_mes);			
	}

?>
