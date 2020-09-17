$(document).ready(function(){
 
    //$(".messages").hide();
    //queremos que esta variable sea global
    var fileExtension = "";
    //función que observa los cambios del campo file y obtiene información
    $(':file').change(function()
    {
        //obtenemos un array con los datos del archivo
        var file = $("#imagen")[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la información del archivo
		var eleman = document.getElementById("car");
		
		if(isValid(fileExtension)){
			if(isValidSize(fileSize)){
		//showMessage("<span class='info'>Archivo para subir: "+fileName+"</span><br><span class='info'> peso total: "+fileSize+" bytes.</span>");	
		 //eleman.removeAttribute("disabled");   
			}else{
				showMessage("<span class='error'>Error: Archivo tiene un tama&ntilde;o superior a 4MB</span>");	eleman.setAttribute("disabled", true);
			}
		}
		else{
		showMessage("<span class='error'>Error: Archivo tiene una extesi&oacute;n inv&aacute;lida</span>");	
		// eleman.setAttribute("disabled", true);
		}
		//message = $("<span class='error'>Error: Archivo tiene una extesi&oacute;n inv&aacute;lida</span>");
        
    });
 
    //al enviar el formulario
    $(':button').click(function(){
        //información del formulario
        var formData = new FormData($(".formulario")[0]);
        var message = ""; 
		var err=0;
		var msg="";
		
		if($("#select_CursoN").val()==0){
		 msg+="Debe Seleccionar curso\n";
		 err=err+1;
		}
		if($("#select_RamosN").val()==0){
		 msg+="Debe Seleccionar asignatura\n";
		 err=err+1;
		}
		if($("#txt_fecha").val()==""){
		 msg+="Debe Seleccionar fecha\n";
		 err=err+1;
		}
		if($("#txt_hora").val()==""){
		 msg+="Debe Seleccionar hora\n";
		 err=err+1;
		}
		if($("#txt_contenido").val()==""){
		 msg+="Debe ingresar contenido evaluaci\xf3n\n";
		 err=err+1;
		}
		
		if(err!=0){
		alert("Se encontraron campos incompletos:\n"+msg);
		
		}
		else{
		
        //hacemos la petición ajax  
        $.ajax({
            url: 'upload.php',  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){
                message = $("<span class='before'>Subiendo Archivo, por favor espere...</span>");
                //showMessage(message);        
            },
            //una vez finalizado correctamente
            success: function(data){
                message = $("<span class='success'>Archivo ha subido correctamente.</span><br><span class='success'> Esta ventana se cerrar&aacute; autom&aacute;ticamente.</span>");
				$("#ruta").val(data);
               // showMessage(message);
			 // ;
			  
				
				  //top.location='../CalPruebasNew.php?menu=6&categoria=3&item=67&nw=1+cu='+$("#select_CursoN").val()+'&ra='+$("#select_CursoN").val()+'';           
				//console.log(data); 
				
				
				
				//setTimeout(function(){window.close(); }, 2000);
				window.opener.location.reload('');self.close();
				
            },
            //si ha ocurrido un error
            error: function(){
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                showMessage(message);
            }
        });
		}//fin 
		
    });
})

//como la utilizamos demasiadas veces, creamos una función para 
//evitar repetición de código
function showMessage(message){
    $(".messages").html("").show();
    $(".messages").html(message);
}
 
//comprobamos si el archivo a subir es una imagen
//para visualizarla una vez haya subido
function isImage(extension)
{
    switch(extension.toLowerCase()) 
    {
        case 'doc': case 'docx': case 'xls': case 'xlsx': case 'ppt': case 'pptx': case 'pdf':
            return true;
        break;
        default:
            return false;
        break;
    }
}

//para extension
function isValid(extension)
{
    switch(extension.toLowerCase()) 
    {
        case 'xls': case 'xlsx': case 'doc': case 'docx': case 'ppt': case 'pptx': case 'pdf':
            return true;
        break;
        default:
            return false;
        break;
    }
}

function isValidSize(size)
{
   
       if(size<=4194304)
            return true;
       else
            return false;
       
    
}