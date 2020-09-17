<?php  
// Define constants
define('DB_HOST', 'ip-172-31-0-119.ec2.internal');
define('DB_USER', 'postgres');
define('DB_PASS', 'f4g5h6.j');
define('DB_NAME', 'coi_final');
define('DB_PORT', '5432');

// Connection string with SSL certificate files
$conn_str  = 'host=' . DB_HOST . ' ';
$conn_str .= 'port=' . DB_PORT . ' ';
$conn_str .= 'dbname=' . DB_NAME . ' ';
$conn_str .= 'user=' . DB_USER . ' ';
$conn_str .= 'password=' . DB_PASS ;

// Try catch block grabbing stored exception
try {
    echo "Attempting pg_connect: " . $conn_str . "<br>";
    $conn=@pg_connect($conn_str);
} catch (Exception $e) {
    echo $e->getMessage();
}

// Attempt Connection
$conn = pg_connect($conn_str) or die('Cannot connect to database.');

// Set SQL String
$sql = 'SELECT * FROM USUARIO'; 

// Attempt query and iterate results
//if(result = pg_query($conn, $sql)) 
//    while($row=pg_fetch_row($result)) {
//        var_dump($row);
//    } 

// Close it up
pg_close();
?>
