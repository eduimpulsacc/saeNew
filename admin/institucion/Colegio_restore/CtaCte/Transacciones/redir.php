<?
		$li_id_usuario     = Trim($_GET["ai_usuario"]);
		$li_id_perfil      = Trim($_GET["ai_perfil"]);
		$li_colegio_selec  = Trim($_GET["ai_colegio_selec"]);

if($li_id_perfil ==0 or $li_id_perfil == 14 or $li_id_perfil == 5 or $li_id_perfil == 1 or $li_id_perfil == 3)
{
		?>
		<Script>
		window.location.href="xColegio/main.php?ai_usuario=<?=($li_id_usuario)?>&ai_perfil=<?=($li_id_perfil)?>&ai_colegio_selec=<?=($li_colegio_selec)?>"
		</Script>		
		<?

}Else
{
		?>
		<Script>
		window.location.href="xApoderado/main.php?ai_usuario=<?=($li_id_usuario)?>&ai_perfil=<?=($li_id_perfil)?>&ai_colegio_selec=<?=($li_colegio_selec)?>"
		</Script>		
		<?

}

?>
