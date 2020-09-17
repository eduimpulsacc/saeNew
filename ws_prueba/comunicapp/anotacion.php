<script type="text/javascript" src="../../admin/clases/jquery/jquery.js"></script>
<?
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

/* function pruebaEdugestorAtraso() {
	 
 $data = array(
 'token' => "RWR1SW1wdWxzYQ==",
 'rbd' => 555,
 'curso' =>  array(280,290),
 'alumnos' => array("24764512_10:00:34", "23811987_x","24291446_10:30:50"),
 'user' => 13907900,
 'fecha' => "2019-06-03",
 'hora' => "10:00:00",
 'modo' => "Alumno Especifico",
 'user_name' => "Rodrigo Monte",
 'user_type' => "Admin",
 'texto' => "Prueba Mensaje Atraso",
 );
 $curl = curl_init();
 $arreglo = json_encode($data);
 curl_setopt_array($curl, array(
 CURLOPT_URL =>
"https://www.comunicapp.cl/api_partners/reporteAtraso",
 CURLOPT_RETURNTRANSFER => true,
 CURLOPT_ENCODING => "",
 CURLOPT_MAXREDIRS => 10,
 CURLOPT_TIMEOUT => 30,
 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
 CURLOPT_CUSTOMREQUEST => "POST",
 CURLOPT_POSTFIELDS => $arreglo,
 CURLOPT_HTTPHEADER => array(
 "Accept: application/json",
 "Cache-Control: no-cache",
 "Connection: keep-alive",
 "Content-Type: application/json",
 "Host: www.comunicapp.cl",
 "accept-encoding: gzip, deflate",
 "cache-control: no-cache",
 "content-length: ". strlen($arreglo),
 ),
 )
 );
 $response = curl_exec($curl);
 $err = curl_error($curl);
 curl_close($curl);
 $respuesta = array(
 "response" => $response,
 "err"=> $err,
 );
 print_r($respuesta);
 }*/
 ?>
 <script>
 function pruebaEdugestorInasistencia() {
 var url2 = "https://www.comunicapp.cl/api_partners/reporteInasistencia";
        $.ajax({
            data: {'token': "RWR1SW1wdWxzYQ==", 'rbd':555, 'curso':[280], 'alumnos' : ["24764512", "23811987","24291446"],
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
 
/* echo "->pruebaEdugestorAtraso()".pruebaEdugestorAtraso();
 echo "<br>";*/
pruebaEdugestorInasistencia();
</script>