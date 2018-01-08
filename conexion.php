<meta charset="UTF8">
<?php
	function conectar(){
		$Servidor = "localhost";
   		$Usuario = "root";
   		$Clave = "";
   		$BaseDatos = "peliculaspendientes";

   		$conn = new mysqli($Servidor, $Usuario, $Clave, $BaseDatos);

   		return $conn;
	}
?>