<?php
require_once("../../../../dompdf/dompdf_config.inc.php");
$texto="mi texto";
$html=
"<html>
<body> 
Hola mundo
<br />
Visiten <strong>www.funcina la ea ctm.com</strong>
<hr />
$texto
</body>
</html>
";
//echo $html;
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("prueba.pdf");
?>