<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>

<?
echo "encuesta tiene: $id_encuesta<br>";


if ($modo == 4){
   ?>
   <table width="700" border="0" align="center" cellpadding="5" cellspacing="0">
     <tr>
       <td colspan="3">Pregunta: <?=$p ?></td>
     </tr>
      <?
     $i = 0;
     while ($i < $contopt){
        ?>
        <tr>
          <td width="30%">&gt; <?=$opcion[$i]; ?> </td>
	      <td width="10%"><?=$porcentaje[$i]; ?> </td>
          <td width="60%">Grfico</td>
        </tr>
	    <?
	    $i++;
     }  ?>
  
     <tr>
      <td colspan="3"><hr size="1" /></td>
     </tr>
     <tr>
       <td colspan="3"><div align="center">Votantes (<?=$votantes ?>) </div></td>
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
        <td><?=$pregunta ?></td>
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
          </div></td>
        </tr>
    </table>
   </form>
   <?
} ?>   
</body>
</html>
