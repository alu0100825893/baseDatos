<?php
	include "conexion.php";

	$Conexion = conectar();

	$Usuario = $_REQUEST["Usuario"];
	$Clave = $_REQUEST["Clave"];

	if( ctype_space($Usuario) || ctype_space($Clave) || ($Usuario == '') || ($Clave == '')) {
		header('Location: index.html');
	}
	else {

		$Clave = md5($Clave);
		$Accion = $_REQUEST["Accion"];



		if($Accion == "ENTRAR"){

			// Comprobación inyección de SQL
			$stmt = $Conexion->prepare("select ID, usuario, clave from usuarios where usuario = ? and clave = ?");
			$stmt->bind_param("ss", $Usuario, $Clave);
			$stmt->execute();
			$stmt->bind_result($Tupla["ID"], $Tupla["usuario"], $Tupla["clave"]);
			$stmt->fetch();

			#$SQL = "select ID from usuarios where usuario = '$Usuario' and clave = '$Clave'";
			#$Resultado = mysqli_query($Conexion, $SQL);
			#$Tupla = mysqli_fetch_array($Resultado, MYSQLI_ASSOC);
			# ' or '1'='1

			if ($Tupla["ID"] != ""){
				session_start();
				$_SESSION["USUARIO_ID"] = $Tupla["ID"];
				$_SESSION["USUARIO"] = $Tupla["usuario"];
				$_SESSION["CLAVE"] = $Tupla["clave"];

				#$_SESSION["USUARIO"] = $Tupla["Usuario"];
				header('Location: lista.php');
			}
			else {
				# Si no se encuentra el usuario o la contraseña no coincide.
				header('Location: index.html');
			}
		}
		elseif ($Accion == "REGISTRARSE") {
			$stmt = $Conexion->prepare("insert into usuarios(ID, usuario, clave) values(DEFAULT, ?, ?)");


			$stmt->bind_param("ss", $Usuario, $Clave);


			# $SQL = "insert into usuarios(ID, usuario, clave) values(DEFAULT, '$Usuario', '$Clave')";

			if(!$stmt->execute()){
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
				$_SESSION["USUARIO"] = $Usuario;
				$_SESSION["CLAVE"] = $Clave;

				header('Location: lista.php');
			}
		}
		elseif ($Accion == "EDITAR") {
			session_start();
			$id = $_SESSION["USUARIO_ID"];

			$stmt = $Conexion->prepare("update usuarios set usuario = ?, clave = ?
																	where ID = $id");
			$stmt->bind_param("ss", $Usuario, $Clave);
			if(!$stmt->execute()) {
				header('Location: editar.php');
			}
			else {
				$_SESSION["USUARIO"] = $Usuario;
				$_SESSION["CLAVE"] = $Clave;
				header('Location: lista.php');
			}

		}
	}

?>
