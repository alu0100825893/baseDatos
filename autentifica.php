<?php
	include "conexion.php";

	$Conexion = conectar();

	$Usuario = $_REQUEST["Usuario"];
	$Clave = $_REQUEST["Clave"];

	$Accion = $_REQUEST["Accion"];

	if($Accion == "ENTRAR"){
		$SQL = "select ID from usuarios where usuario = '$Usuario' and clave = '$Clave'";

		$Resultado = mysqli_query($Conexion, $SQL);
		$Tupla = mysqli_fetch_array($Resultado, MYSQLI_ASSOC);

		if ($Tupla["ID"] != ""){
			session_start();
			$_SESSION["USUARIO_ID"] = $Tupla["ID"];
			echo $_SESSION["USUARIO_ID"];
			#$_SESSION["USUARIO"] = $Tupla["Usuario"];
			header('Location: lista.php');
		}
		else {
			# Si no se encuentra el usuario o la contraseña no coincide.
			header('Location: index.html');
		}
	}
	elseif ($Accion == "REGISTRARSE") {
		$SQL = "insert into usuarios(ID, usuario, clave) values(DEFAULT, '$Usuario', '$Clave')";

		if(!mysqli_query($Conexion, $SQL)){
			# Error al registrarse
			header('Location: index.html');
		}
		else{
			session_start();
			#$_SESSION["USUARIO_ID"] = $Usuario;

			$SQL = "select ID from usuarios where usuario = '$Usuario' and clave = '$Clave'";

			$Resultado = mysqli_query($Conexion, $SQL);
			$Tupla = mysqli_fetch_array($Resultado, MYSQLI_ASSOC);

			$_SESSION["USUARIO_ID"] = $Tupla["ID"];
			echo $_SESSION["USUARIO_ID"];
			header('Location: lista.php');
		}
	}
	
?>