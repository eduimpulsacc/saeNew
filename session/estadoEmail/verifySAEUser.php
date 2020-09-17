
<?php
if(isset($_GET['t']) && isset($_GET['user'])){
    $token = trim($_GET['t']);
    $userId = trim($_GET['user']);
   $conn=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j");
   
   
    
     $sql = "SELECT * FROM usuario WHERE id_usuario = $userId AND token = '".$token."'";
     $result = pg_exec($conn,$sql);
                      if(pg_numrows($result)>0){
                           $sql2 = "UPDATE usuario set estado_email = 2 WHERE id_usuario = $userId  AND token = '".$token."'";
                           $result2 = pg_exec($conn,$sql2);
                         // echo'<script type="text/javascript">alert("Email confirmado exitosamente se le redirigirá a iniciar sesión");</script>';
                          echo "Email confirmado exitosamente<br />";

                          //echo'<script>windows.location="seteaAsistencia.php3?caso=2"</script>';
                          //header("Location: https://app.colegiointeractivo.cl/sae3.0/index3_new.html");
                          if($result2){
                          echo '<a href="https://app.colegiointeractivo.cl/sae3.0/index3_new.html">Click aqu&iacute; para iniciar sesi&oacute;n</a>';
                          }

                      }
                      else {
                          echo "token inv&aacute;lido";
                      }
//    $stmt = $pdo->prepare($sql);
//    $stmt->bindParam(':user_id', $userId);
//    $stmt->bindParam(':token', $token);
//    $stmt->execute();
    
//    $result = $stmt->fetch(PDO::FETCH_ASSOC);
//    if($result['num'] == 1){
//        //Token is valid. Verify the email address
//    } else{
//        //Token is not valid.
//    }
    
}
?>
