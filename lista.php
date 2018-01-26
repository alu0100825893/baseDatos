<?php
	include "conexion.php";

	session_start();
	$Conexion = conectar();

	if(!isset($_SESSION["USUARIO_ID"])) {
		header('Location: index.html');
	}


	$id = $_SESSION["USUARIO_ID"];
	$ORDER = "";
	$BUSCAR = "";

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
			elseif ($_REQUEST["Accion"]=="cerrar") {
				session_destroy();
				header('Location: index.html');
			}
			elseif ($_REQUEST["Accion"]=="eliminar") {
   			$titulo = $_REQUEST["titulo"];
   			$fecha = $_REQUEST["fecha"];
   			$director = $_REQUEST["director"];

   			$SQL = "delete from peliculas where titulo='$titulo' and fecha=$fecha and director='$director' and id_usuario=$id";
   			mysqli_query($Conexion, $SQL);
   		}
			elseif ($_REQUEST["Accion"]=="confirm") {
   			$ntitulo = $_REQUEST["ntitulo"];
   			$nfecha = $_REQUEST["nfecha"];
   			$ndirector = $_REQUEST["ndirector"];
				$titulo = $_SESSION["titulo"];
   			$fecha = $_SESSION["fecha"];
   			$director = $_SESSION["director"];

   			$SQL = "update peliculas set titulo='$ntitulo', fecha=$nfecha, director='$ndirector', id_usuario=$id where titulo='$titulo' and fecha=$fecha and director='$director' and id_usuario=$id";
   			mysqli_query($Conexion, $SQL);
   		}
			elseif ($_REQUEST["Accion"]=="orderasct") {
				$ORDER = "ORDER BY titulo ASC ";
			}
			elseif ($_REQUEST["Accion"]=="orderdesct") {
				$ORDER = "ORDER BY titulo DESC ";
			}
			elseif ($_REQUEST["Accion"]=="orderascf") {
				$ORDER = "ORDER BY fecha ASC ";
			}
			elseif ($_REQUEST["Accion"]=="orderdescf") {
				$ORDER = "ORDER BY fecha DESC ";
			}
			elseif ($_REQUEST["Accion"]=="orderascd") {
				$ORDER = "ORDER BY director ASC ";
			}
			elseif ($_REQUEST["Accion"]=="orderdescd") {
				$ORDER = "ORDER BY director DESC ";
			}
			elseif($_REQUEST["Accion"]=="buscar"){
	   			$titulo = $_REQUEST["titulo"];
	   			$fecha = $_REQUEST["fecha"];
	   			$director = $_REQUEST["director"];

					if($titulo != "") {
						$BUSCAR .= " AND titulo = '$titulo' ";
					}

					if($fecha != "") {
						$BUSCAR .= " AND fecha LIKE $fecha ";
					}

					if($director != "") {
						$BUSCAR .= " AND director = '$director' ";
					}
	   		}

	}

	echo "<!DOCTYPE html>
				<html>
				<head>
					<title>Películas pendientes</title>
					<meta charset=\"utf-8\">
					<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
				  <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
				  <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>
				  <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>
					<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\">
				</head>
				<body>";

	echo "<div class=\"container main\">
					<div class=\"row\">
						<div class=\"col-sm-2\"> </div>
						<div class=\"col-sm-8\">";

 	echo "<table class=\"table table-hover table-bordered\">
					<form action=\"lista.php\" method=\"post\">
	 					<thead>
							<tr>
								<th>Título
									<button class=\"btn btn-sm btn-primary\" name=\"Accion\" value=\"orderasct\">^</button>
									<button class=\"btn btn-sm btn-primary\" name=\"Accion\" value=\"orderdesct\">v</button> </a>
								</th>
								<th>Director
									<button class=\"btn btn-sm btn-primary\" name=\"Accion\" value=\"orderascd\">^</button>
									<button class=\"btn btn-sm btn-primary\" name=\"Accion\" value=\"orderdescd\">v</button>
								</th>
								<th>Año
									<button class=\"btn btn-sm btn-primary\" name=\"Accion\" value=\"orderascf\">^</button>
									<button class=\"btn btn-sm btn-primary\" name=\"Accion\" value=\"orderdescf\">v</button>
								</th>
							</tr>
						</thead>
					</form>";

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


   	$consulta = "select * from peliculas where id_usuario=$id ". $BUSCAR ." ". $ORDER . "LIMIT " . $TAMANO_PAGINA . " offset " . $inicio;
	$mostrar = mysqli_query($Conexion, $consulta);

   	while ($Tupla = mysqli_fetch_array($mostrar, MYSQLI_ASSOC)){
			if(isset($_REQUEST["Accion"])){
				if($_REQUEST["Accion"]=="editar"){
					if($Tupla["titulo"] == $_REQUEST["titulo"] && $Tupla["fecha"] == $_REQUEST["fecha"] && $Tupla["director"] == $_REQUEST["director"]){
						$_SESSION["titulo"] = $Tupla["titulo"];
						$_SESSION["fecha"] = $Tupla["fecha"];
						$_SESSION["director"] = $Tupla["director"];
						echo "
									<form action=\"lista.php\" method=\"post\">
										<tr>
											<td><input name='ntitulo' value =" . $Tupla["titulo"] . "></td>
											<td><input name='ndirector' value =" . $Tupla["director"] . "></td>
											<td><input name='nfecha' value =" . $Tupla["fecha"]. "></td>
											<td><button class=\"btn btn-sm btn-primary\" name=\"Accion\" value=\"confirm\">Confirmar</button></td>

										</tr>
									</form>";
					}
					else{
						echo "<tr>
										<td>" . $Tupla["titulo"] . "</td>
										<td>" . $Tupla["director"] . "</td>
										<td>" . $Tupla["fecha"] . "</td>
									</tr>";
					}
				}
				else{
					echo "<tr>
									<td>" . $Tupla["titulo"] . "</td>
									<td>" . $Tupla["director"] . "</td>
									<td>" . $Tupla["fecha"] . "</td>
									<td><a href='lista.php?Accion=eliminar&titulo=" . $Tupla["titulo"] . "&director=" . $Tupla["director"] . "&fecha=" . $Tupla["fecha"] . "'>
										<button class=\"btn btn-sm btn-primary\">X</button>
									</td>
									<td><a href='lista.php?Accion=editar&titulo=" . $Tupla["titulo"] . "&director=" . $Tupla["director"] . "&fecha=" . $Tupla["fecha"] . "'>
										<button class=\"btn btn-sm btn-primary\">Editar</button>
									</td>
								</tr>";
				}
			}
			else{
				echo "<tr>
								<td>" . $Tupla["titulo"] . "</td>
								<td>" . $Tupla["director"] . "</td>
								<td>" . $Tupla["fecha"] . "</td>
								<td>
									<a href='lista.php?Accion=eliminar&titulo=" . $Tupla["titulo"] . "&director=" . $Tupla["director"] . "&fecha=" . $Tupla["fecha"] . "'>
										<button class=\"btn btn-sm btn-primary\">X</button>
									</a>
								</td>
								<td>
									<a href='lista.php?Accion=editar&titulo=" . $Tupla["titulo"] . "&director=" . $Tupla["director"] . "&fecha=" . $Tupla["fecha"] . "'>
										<button class=\"btn btn-sm btn-primary\">Editar</button>
									</a>
								</td>
							</tr>";
			}
   	}

?>

<form action="lista.php" method="post">
	<tr>
		<td><input name='titulo'></td>
		<td><input name='director'></td>
		<td><input name='fecha'></td>
		<td><button class="btn btn-sm btn-primary" type="submit" name="Accion" value="+">+</button> </td>
		<td><button class="btn btn-sm btn-primary" type="submit" name="Accion" value="buscar">Buscar</button> </td>
	</tr>
</form>
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

	echo '<a href=lista.php?Accion=cerrar>
					<button class="btn btn-lg btn-primary">Cerrar sesión</button>
				</a>';

	echo '<a href=editar.php>
					<button class="btn btn-lg btn-primary">Editar usuario</button>
				</a>';

	echo "	     </div>
              <div class=\"col-sm-2\"> </div>
            </div>
          </div	>
        </body>
        </html>";
?>
