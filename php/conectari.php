<?php
//MySQLi
//Se incluye el código con los datos de conexión

// Función testeo
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = strip_tags($data);
	$data = htmlspecialchars($data);
	return $data;
}

function conectar()
{
require_once 'mysql-login.php';

//creación de un objeto para la clase mysqli
//realiza la conexión con el servidor MySQL
$mysqli = new mysqli($hostname, $username, $password, $database);

//Se comprueba si da error en la conexión
if ($mysqli -> connect_errno) {
	//Se muestra mensaje del fallo
	//die("Falló la conexión a MySQL: (".$mysqli -> connect_errno .")" .$mysqli -> connect_error);
		die("<script type ='text/javascript'>
window.onload = function alerta() {
	document.getElementById('error').className='alert alert-success';
	document.getElementById('error').innerHTML = 'Conexión exitosa!';};
</script>" .$mysqli -> connect_errno .")" .$mysqli -> connect_error);


} else {
//o bien mensaje de éxito
	//echo "<script type='text/javascript'>document.getElementById('error').innerHTML = 'Conexion exitosa!';</script>";
	echo "<script type ='text/javascript'>
window.onload = function alerta() {
	document.getElementById('error').className='alert alert-success';
	document.getElementById('error').innerHTML = 'Conexión exitosa!';};
</script>";
	//echo "<script>$('#error').html('Conexión exitosa!');</script>";
}

return($mysqli);

}


?>