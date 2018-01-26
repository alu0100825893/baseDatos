<?php
  session_start();

  $nombre = $_SESSION["USUARIO"];
  $clave = $_SESSION["CLAVE"];


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

  echo "  <div class=\"container main\">
            <div class=\"row\">
              <div class=\"col-sm-2\"> </div>
              <div class=\"col-sm-8\">";


  echo'
        				<form class="form-horizontal" action="autentifica.php" method="post">
        					<div class="form-group">
        						<label class="control-label col-sm-3" for="user">Cambiar usuario:</label>
        						<div class="col-sm-9 input-group">
        							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>';
  echo " 							<input class=\"form-control\" id=\"user\" placeholder=\"Introduzca un nuevo usuario\" name=\"Usuario\" value=$nombre>
        						</div>
        					</div>";

  echo ' 					<div class="form-group">
        						<label class="control-label col-sm-3" for="pw">Cambiar clave:</label>
        						<div class="col-sm-9 input-group">
        							<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>';
echo "  							<input type=\"password\" class=\"form-control\" id=\"pw\" placeholder=\"Introduzca una nueva contraseña\" name=\"Clave\" value=$clave>
        						</div>
        					</div>";

echo '        	<div class="row">
        						<div class="col-sm-5"></div>
        						<div class="col-sm-2">
        							<div class="btn-group-vertical form-group">
        						    <button type="submit" class="btn btn-lg btn-primary" name="Accion" value="EDITAR">Editar</button>
        							</div>
        						</div>
        					 <div class="col-sm-5"></div>
        				</div>
        				</form>';

  echo '	     </div>
              <div class="col-sm-2"> </div>
            </div>
          </div	>
        </body>
        </html>';
?>
