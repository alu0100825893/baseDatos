<meta charset="UTF8">
<?php
	function conectar(){
		$Servidor = "localhost";
   		$Usuario = "insertar";
   		$Clave = "contraseña";
   		$BaseDatos = "Usuarios";

   		$conn = new mysqli($Servidor, $Usuario, $Clave, $BaseDatos);

   		return $conn;
	}
?>