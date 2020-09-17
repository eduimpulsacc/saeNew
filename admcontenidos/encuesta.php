<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>

<?

if ($modo == 4){
   ?>
   <table width="700" border="0" align="center" cellpadding="3" cellspacing="0">
     <tr>
       <td colspan="3">Pregunta: <?=$p ?></td>
     </tr>
      <?
     $i = 0;
     while ($i < $contopt){
        ?>
        <tr>
          <td width="30%">&gt; <?=$opcion[$i]; ?> </td>
	      <td width="10%" align="center"><? printf("%.2f",$porcentaje[$i]); ?>  %</td>
          <td width="60%"><table width="<?=$porcentaje[$i] ?>%" height="15" border="0" cellpadding="0" cellspacing="0" background="images/barra.jpg">
            <tr>
              <td><img src="images/barrat.gif" width="1" height="15" /></td>
            </tr>
          </table></td>
        </tr>
	    <?
	    $i++;
     }  ?>
  
     <tr>
      <td colspan="3"><hr size="1" /></td>
     </tr>
     <tr>
       <td colspan="3"><div align="center">Votantes (<?=$votantes ?>) <br />
           <?
		   if ($op == "b"){
		      ?>
		   
		      <br />
              <table width="400" border="0" cellpadding="3" cellspacing="1" bgcolor="#FF0000">
               <tr>
                <td bgcolor="#FFFFFF"><div align="center">&iquest;Esta seguro de borrar esta encuesta? <br />
                  <br />
                      <a href="admencuesta.php?op=b&id_encuesta=<?=$id_encuesta ?>">Si, Borrar</a> <br />
                      <br />
                     <a href="admencuesta.php">No, Volver </a><br />
                   <br />
                  </div></td>
                </tr>
               </table><br />
			   <?
			} ?>    
         <br />
         <a href="admencuesta.php">Administrador de encuestas</a> </div></td>
     </tr>
</table>
     <?
}else{ ?>	 
    <form name="form1" method="post" action="proceso_encuesta.php?modo=3"> 
    <table width="300" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
       <td>Encuesta
        <input type="hidden" name="id_encuesta" value="<?=$id_encuesta ?>" />
		<input type="hidden" name="p" value="<?=$p ?>" /></td>
      </tr>
      <tr>
        <td><?=$p ?></td>
      </tr>
  
      <?
      $i = 0;
      while ($i < $contopt){
         ?>
         <tr>
	     <td>
	        <table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
              <td width="10%"><label>
                <input name="id_opt" type="radio" value="<?=$id_opt[$i] ?>" />
               </label></td>
              <td><?=$opcion[$i]; ?></td>
             </tr>
            </table>
	      </td>
        </tr>
        <?
	     $i++;
      }
	  ?> 
       <tr>
         <td><div align="center">
           <label>
           <input name="opinar" type="submit" id="opinar" value="Enviar" />
           </label>
           <br />
           <br />
           <a href="admencuesta.php">Administrador de encuestas</a> </div></td>
      </tr>
    </table>
   </form>
   <?
} ?>   
</body>
</html>
