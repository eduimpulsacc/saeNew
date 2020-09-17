<?php
echo "base ". $celu ="973331374";
	
function sanear_string($string)
{

    $string = trim($string);
	
	$string=strtolower($string);

    $string = str_replace(
        array("á", "à", "ä", "â", "ª", "Á", "À", "Â", "Ä"),
        "",
        $string
    );

    $string = str_replace(
        array("é", "è", "ë", "ê", "É", "È", "Ê", "Ë"),
        "",
        $string
    );

    $string = str_replace(
        array("í", "ì", "ï", "î", "Í", "Ì", "Ï", "Î"),
        "",
        $string
    );

    $string = str_replace(
        array("ó", "ò", "ö", "ô", "Ó", "Ò", "Ö", "Ô"),
        "",
        $string
    );

    $string = str_replace(
        array("ú", "ù", "ü", "û", "Ú", "Ù", "Û", "Ü"),
        "",
        $string
    );

    $string = str_replace(
        array("ñ", "Ñ", "ç", "Ç"),
       "",
        $string
    );
	
	

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~","#", "@", "|", "!", "\"","·", "$", "%", "&", "/","(", ")", "?", "'", "¡","¿", "[", "^", "`", "]","+", "}", "{", "¨", "´",">", "< ", ";", ",", ":",'',' '," ",".",),"",$string);

	
	$string = str_replace(
        array("a","b", "c", "d", "e","f", "g", "h", "i","j", "k", "l", "m", "n","o", "p", "r", "s", "t","u", "v", "w", "x", "y", "z"),
        "",
        $string
    );
	
	$quito=substr($string,0,1);
	$string=($quito==0)?substr($string, 1):$string;

    return $string;
}	
	
function formatoNumero($cadena){
	$cel="";
	if(strlen($cadena)<8 ||  strlen($cadena)>11  ){
		$cel= "numero inválido";
	}
	else{
				
		if(strlen($cadena)==8 ){
			 $cel="569".$cadena;
			}
		if(strlen($cadena)==9 || strlen($cadena)==10){
			 $cel="56".$cadena;
		}
		
				
		
	}
	
	return $cel;
} 

function convierteNumero($celu){
$clim="";	
$clim = sanear_string($celu);
formatoNumero($clim);
}
?>