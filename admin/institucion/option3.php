<?
header("Content-type: text/xml");
if ($_POST["scheme"] == "1")
  $options = array('red', 'green', 'blue');
if ($_POST["scheme"] == "2")
  $options = array('black', 'white', 'orange');
echo '<?xml version="1.0"?>';
echo '<options>';
foreach ($options as $value)
{
  echo '<option>';
  echo $value;
  echo '</option>';
}
echo '</options>';
?>