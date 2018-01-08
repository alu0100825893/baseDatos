<?php
	include "conexion.php";

	session_start();
	$Conexion = conectar();
	
	$id = $_SESSION["USUARIO_ID"];

	if(isset($_REQUEST["Accion"])){
		if($_REQUEST["Accion"]=="+"){
   			$titulo = $_REQUEST["titulo"];
   			$fecha = $_REQUEST["fecha"];
   			$director = $_REQUEST["director"];

   			$SQL = "insert into peliculas(id_usuario, titulo, fecha, director) values($id, '$titulo', $fecha, '$director')";

			mysqli_query($Conexion, $SQL);
			#manejar errores
   		}
   		elseif ($_REQUEST["Accion"]=="eliminar") {
   			$titulo = $_REQUEST["titulo"];
   			$fecha = $_REQUEST["fecha"];
   			$director = $_REQUEST["director"];

   			$SQL = "delete from peliculas where titulo='$titulo' and fecha=$fecha and director='$director' and id_usuario=$id";
   			mysqli_query($Conexion, $SQL);
   		}
	}

   	echo "<table border='1'>";
   	echo "<tr><td>Título</td><td>Director</td><td>Año</td></tr>";

   	$SQL = "select * from peliculas where id_usuario = $id";
   	$Resultado = mysqli_query($Conexion, $SQL);
   	$num_registros = mysqli_num_rows($Resultado);
   	$TAMANO_PAGINA = 10;
   	$total_paginas = ceil($num_registros / $TAMANO_PAGINA);

   	if(isset($_REQUEST["pagina"])){
   		$pagina = $_REQUEST["pagina"];
   	}
   	else{
   		$pagina = 1;
   	}
   
   	$inicio = ($pagina - 1) * $TAMANO_PAGINA;

   	$consulta = "select * from peliculas LIMIT " . $TAMANO_PAGINA . " offset " . $inicio;
	$mostrar = mysqli_query($Conexion, $consulta);
   
   	while ($Tupla = mysqli_fetch_array($mostrar, MYSQLI_ASSOC)){
   		echo "<tr><td>" . $Tupla["titulo"] . "</td><td>" . $Tupla["director"] . "</td><td>" . $Tupla["fecha"] . "</td><td><a href='lista.php?Accion=eliminar&titulo=" . $Tupla["titulo"] . "&director=" . $Tupla["director"] . "&fecha=" . $Tupla["fecha"] . "'><button>V</button></a></td></tr>";
   	}
   	 
?>

<form action="lista.php" method="post"><tr><td><input name='titulo'></td><td><input name='director'></td><td><input name='fecha'></td><td><input type="submit" name="Accion" value="+"></td></tr></form>

</table>

<?php
	$paginasiguiente = $pagina + 1;
	$paginaanterior = $pagina - 1;

	if ($pagina > 1) {
		echo "Página $pagina  <a href='lista.php?pagina=$paginaanterior'><<</a>";
	}
	if ($pagina < $total_paginas) {
		echo "<a href='lista.php?pagina=$paginasiguiente'>>></a>";
	}
	
?>
