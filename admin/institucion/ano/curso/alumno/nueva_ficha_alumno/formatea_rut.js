function formato_rut(rut)
{
   var sRut1 = rut;
   //contador de para saber cuando insertar el . o la -
   var nPos = 0;
 
   //Guarda el rut invertido con los puntos y el guión agregado
   var sInvertido = "";
 
   //Guarda el resultado final del rut como debe ser
   var sRut = "";
 
   for(var i = sRut1.length - 1; i >= 0; i-- )
   {
        
           sInvertido += sRut1.charAt(i);
           if (i == sRut1.length - 1 )
               sInvertido += "-";
           else if (nPos == 3)
           {
               sInvertido += ".";
               nPos = 0;
           }
           nPos++;       
   }
 
   for(var j = sInvertido.length - 1; j >= 0; j-- )
   {
           if (sInvertido.charAt(sInvertido.length - 1) != ".")
                sRut += sInvertido.charAt(j);
           else if (j != sInvertido.length - 1 )
               sRut += sInvertido.charAt(j);
        
   }
   //Pasamos al campo el valor formateado
   //return sRut;
   rut_retira.value = sRut.toUpperCase();
}



