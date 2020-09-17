<script type="text/javascript" src="../../admin/clases/jquery/jquery.js"></script>
<script>
function pruebaEdugestorAtraso(){
var url2 = "https://www.comunicapp.cl/api_partners/reporteAtraso";
        $.ajax({
            data: {'token': "RWR1SW1wdWxzYQ==", 'rbd':25269, 'curso':[280], 'alumnos':["24035001_10:00:34"],
                'user': 13907900, 'fecha':"2019-06-03",'hora':"10:00:00",'modo':"Alumno Especifico",
                'user_name':"Rodrigo Monte", 'user_type':"Admin",'texto':"Prueba Mensaje Atraso"},
            url: url2,
            xhrFields: {
                withCredentials: true
            },
            type: 'POST',
            success: function (response) {//resultado de la función
                console.log(response);
            }
        });

}
$( document ).ready(function() {
   pruebaEdugestorAtraso();
});	
</script>