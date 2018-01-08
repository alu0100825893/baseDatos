<?php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_DATABASE', 'inventario');

   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

   if($_SERVER["REQUEST_METHOD"] == "POST") {
     $myusername = mysqli_real_escape_string($db,$_POST['usuario']);
     $mypassword = mysqli_real_escape_string($db,$_POST['password']);

     //echo "INICIANNNNNNNNNNNNNNNNNNnnDO---------------------------------";
     $sql = "SELECT * FROM usuario WHERE dni = '$myusername' and password = '$mypassword'";
     $result = mysqli_query($db,$sql);
     $count = mysqli_num_rows($result);

     if($count == 1) {
      echo "Usuario ENCONTRADO---------------------------------";
      while($row = $result->fetch_assoc()) {
        echo "id: " . $row["dni"]. " - Name: " . $row["nombre"]. " " . $row["password"]. "<br>";
      }
     }
     else {
       echo "Usuario NO encontrado-----------------------------";
     }

   }
?>

<html>
  <head>
    <title>
      Inicio de sesion
    </title>
  </head>
  <body>
    <form action = "" method = "post">
       <label>Nombre de usuario  :</label><input type = "text" name = "usuario"/><br /><br />
       <label>Contrasña  :</label><input type = "password" name = "password"/><br/><br />
       <input type = "submit" value = "Iniciar"/><br />
    </form>

  </body>
</html>
