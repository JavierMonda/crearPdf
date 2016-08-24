<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- BOOTSTRAP -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
	integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" 
	crossorigin="anonymous">

    <title>Título página</title>

</head>

<body>

<?php

	require_once "mpdf/mpdf.php";
	require_once "php/conectari.php";
		
	$mysqli = conectar();

	// SI PULSAMOS GENERAR PDF
	if (isset($_POST["generar"])) {
        $cabecera = "<span><img src='ruta_imagen' width='100px' height='50px'/><b>Informe PDF</b></span>";
        $pie = "<span>Descripción pie</span>";
        $mpdf=new mPDF();
        //$style=file_get_contents('../css/tabla.css');
        //$mpdf->WriteHTML($style, 1);
        $mpdf->SetHTMLHeader($cabecera);
        $mpdf->SetHTMLFooter($pie);

        $sql = "SELECT * FROM  nombreTabla";                       
        $resultado = $mysqli -> query($sql);

        $mpdf->WriteHTML('<table class="table-hover table-responsive table-striped">
            <tr>
                <th>CABECERA 1</th>
                <th>CABECERA 2</th>
                <th>CABECERA 3</th>
                <th>CABECERA 4</th>
            </tr>',2);
        while ($fila = $resultado -> fetch_assoc()){

            $mpdf->WriteHTML('
            	<tr>
                    <td>' .$fila['campoDb1'] .'</td>
                    <td>' .$fila['campoDb2'] .'</td>
                    <td>' .$fila['campoDb3'] .'</td>
                    <td>' .$fila['campoDb4'] .'</td>
                </tr>
                ', 2);
        }
        $mpdf->WriteHTML('</table>',2);             
        $mpdf->Output('archivo.pdf','I');
        exit;
    } // CIERRE DE IF GENERAR
?>


<!-- FORMULARIO -->

<div class="form-group">
	<fieldset>

	<?php 
		// LANZAMOS LA CONSULTA DE TODOS LOS DATOS DE LA TABLA MANUALES
		// PARA MOSTRARLOS EN EL FORMULARIO
		
		$sql = "SELECT * FROM  nombreTabla";						
		$resultado = $mysqli -> query($sql);						
	?>
		<legend><span>Alta, baja y modificación de Clientes</span></legend> 

		<form class="form" method="POST" enctype="multipart/form-data" 
            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

			<table class="table-hover table-responsive table-striped">
				<tr><td colspan="6">Dar de alta un nuevo Cliente: </td></tr>
				<tr><td colspan="6"><button type="submit" name="alta" class="btn btn-default" />Alta</button></td></tr>
				<tr>
					<th>CABECERA 1</th>
					<th>CABECERA 2</th>
					<th>CABECERA 3</th>
					<th>CABECERA 4</th>
				</tr>
		<?php
			while ($fila = $resultado -> fetch_assoc()){
				echo '
				<tr>
					<td><input type="text" name="campoDb1" class="form-control" value="' .$fila['campoDb1'] .'" readonly></td>
					<td><input type="text" name="campoDb2" class="form-control" value="' .$fila['campoDb2'] .'"></td>
					<td><input type="text" name="campoDb3" class="form-control" value="' .$fila['campoDb3'] .'"></td>
					<td><input type="text" name="campoDb4" class="form-control" value="' .$fila['campoDb4'] .'"></td>
				</tr>';
				
			}
			echo '<tr><td colspan="2"><button type="submit" class="btn btn-default" name="generar"/>Generar PDF</button></td>';
			echo '</tr>';

			
			echo "</table>";
			echo "</form>"
		?> 
	
	</fieldset>
	<div id="error" class="" role="alert">
		<!-- AQUI SE MOSTRARÁ EL MENSAJE DE CONEXIÓN EXITOSA CON LA BD O ERROR -->
	</div>

</div>

<?php
	$mysqli -> close();
?>

</body>

</html>