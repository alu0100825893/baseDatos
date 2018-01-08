<meta charset="UTF8">
<?php
   	
   	include "conexion.php";

   	$tabla = "personas";

   	$conexion = conectar();

   	if ($conexion){

   		//Insertar datos dados
   		$nombre = $_REQUEST["usuario"];
	   	$claveusuario = $_REQUEST["clave"];

	   	$Accion = $_REQUEST["Accion"];

	   	if($Accion == "eliminar" && $nombre != ""){
	   		echo "$nombre";
	   		$SQL = "delete from $tabla where usuario = '$nombre'";
	   	}
	   	else{
	   		$SQL = "insert into " . $tabla;
		   	$SQL .= " (usuario, clave) values ";
		   	$SQL .= " ('$nombre', '$claveusuario')";
	   	}

	   	if (!mysqli_query($conexion, $SQL))
	   		echo "Error: " . mysqli_error($conexion);
	   	else
	   		echo "Valores insertados";

   	}
   	else {
   		die("Error al conectar con la base de datos");
   	}
   	//Mostrar tabla
   	echo "<table border='1'>";
   	$SQL = "select * from $tabla";
   	$Resultado = mysqli_query($conexion, $SQL);

   	while ($Tupla = mysqli_fetch_array($Resultado, MYSQLI_ASSOC)){
   		echo "<tr><td>" . $Tupla["usuario"] . "</td><td>" . $Tupla["clave"] . "</td><td><a href='formulario.php?Accion=editar&usuario=".$Tupla["usuario"]."'>Editar</a></td><td><a href='procesar.php?Accion=eliminar&usuario=".$Tupla["usuario"]."'>Eliminar</a></td></tr>";
   	}

   	echo "</table>";

	//cerrar conexión
   	mysqli_close($conexion);
?>