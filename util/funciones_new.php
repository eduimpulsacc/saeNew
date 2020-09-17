<?

function registrarnavegacion($id_usuario,$pagina_tabla,$evento,$parametros,$ip,$bd,$navegador,$rbd,$rut_usuario,$id_curso,$conectar){

 $sql_insert = "INSERT INTO public.navegacion(id_usuario,fecha,pagina_tabla,evento,parametros,ip,bd,navegador,rbd,rut_usuario,id_curso) 
	VALUES ($id_usuario,CURRENT_DATE,'$pagina_tabla',$evento,'$parametros','$ip','$bd','$navegador',$rbd,
	$rut_usuario,$id_curso);";
	$rs = @pg_Exec($conectar,$sql_insert);

   }


function ObtenerNavegador($user_agent) {  
     	 
	 $navegadores = array(  
	      'Opera' => 'Opera', 
		  'Chrome'=> 'Chrome', 
          'Mozilla Firefox'=> '(Firebird)|(Firefox)',  
          'Galeon' => 'Galeon',  
          'Mozilla'=>'Gecko',  
          'MyIE'=>'MyIE',  
          'Lynx' => 'Lynx',  
          'Netscape' => '(Mozilla/4\.75)|(Netscape6)|(Mozilla/4\.08)|(Mozilla/4\.5)|(Mozilla/4\.6)|(Mozilla/4\.79)',  
          'Konqueror'=>'Konqueror',  
		  'Internet Explorer 8' => '(MSIE 8\.[0-9]+)',  
          'Internet Explorer 7' => '(MSIE 7\.[0-9]+)',  
          'Internet Explorer 6' => '(MSIE 6\.[0-9]+)',  
          'Internet Explorer 5' => '(MSIE 5\.[0-9]+)',  
          'Internet Explorer 4' => '(MSIE 4\.[0-9]+)',  
		  );  

foreach($navegadores as $navegador=>$pattern){  
       if (eregi($pattern, $user_agent))  
       return $navegador;  
    }  
  return 'Desconocido';  
}  



?>