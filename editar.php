<?php
  session_start();

  $nombre = $_SESSION["USUARIO"];
  $clave = $_SESSION["CLAVE"];

  echo "<form action='autentifica.php' method='post'>
    <p>Cambiar usuario <input name='Usuario' value=$nombre></p>
    <p>Cambiar clave <input type='password' name='Clave' value=$clave></p>
    <p><input type='submit' name='Accion' value='EDITAR'></p>
  </form>";

?>
