<?php
	include "conexion.php";
	$conexion = conectar();

	$nombre = $clave = "";
	$Boton = "insertar";

	if ($conexion){
		$Accion = $_REQUEST["Accion"];
		$nombre = $_REQUEST["usuario"];
		if ($Accion == "editar" && $nombre != ""){
			$SQL = "select * from personas where usuario = '$nombre'";
			$Resultado = mysqli_query($conexion, $SQL);

			$Tupla = mysqli_fetch_array($Resultado, MYSQLI_ASSOC);
			$nombre = $Tupla["usuario"];
			$clave = $Tupla["clave"];

			$Boton = "Modificar";
		}
	}
?>
<html>
<head>
	<title>Formulario de registro</title>
	<meta charset="UTF-8">
	<script>
		function Verifica() {
			if (document.getElementById("usuario").value == "") { alert("Especifica un usuario."); return false; }
			if (document.getElementById("clave").value == "") { alert("Se necesita una contraseña."); return false; }
		}
	</script>
</head>
<body>
	<form action="procesar.php" method="post" onsubmit="return Verifica();">
		<div>Usuario: <input name="usuario" id="usuario" value="<?php echo $nombre;?>"></div>
		<div>Contraseña: <input name="clave" id="clave" value="<?php echo $clave;?>"></div>
		<div><input type="submit" name="Accion" value="<?php echo $Boton;?>"></div>
	</form>
</body>
</html>