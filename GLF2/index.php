<?php include "ClaseAutomata.php";
include "Funciones.php";
$cont=0;
if(isset($_POST['Submit7']))
 {
  $Automata1=($_POST['Automata']);
  $cont=1;
 }
if(isset($_POST['Submit8']))
{
  $Automata1=($_POST['Automata1']);
  $Automata2=($_POST['Automata2']);
  $cont=2;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Index Trabajo 2 Grafos</title>
</head>
<body>

  <center>
  <?php 
  if($cont==0)
  {
    echo"<html>
  <center>  <h1>TRABAJO GRAFOS 2</h1>

    <h2>¿Que tipo de automata desea ingresar? </h2>
    <form method='post' action='IngresoAFD.php'>
      <input type='submit' name='SubmitIndex' value=AFD>
    </form>
    <form method='post' action='IngresoAFND.php'>
      <input type='submit' value=AFND>
    </form></html>";
    console_log("Seleccione tipo de automata, luego de eso podrá ingresar el alfabeto de entrada del automata");
  }
 if($cont==1)
 {
  echo"<html>
  <center>  <h1>TRABAJO GRAFOS 2</h1>

    <h2>¿Que tipo de automata desea ingresar ahora ? </h2>
    <form method='post' action='IngresoAFD.php'>
      <input type='submit' name='A1' value=AFD>
      <input type='hidden' name='Automata1' value=".$Automata1.">
      <input type='hidden' name='Tipo1' value=".$Tipo1.">
    </form>

    <form method='post' action='IngresoAFND.php'>
      <input type='submit' name='A1' value=AFND>
      <input type='hidden' name='Automata1' value=".$Automata1.">
      <input type='hidden' name='Tipo1' value=".$Tipo1.">
    </form></html>";
    console_log("Puede volver a seleccionar el tipo de automata a ingresar");
    console_log("Bajo los botones de AFD y AFND se encuentra el automata anteriormente ingresado");
    console_log("Seleccione tipo de automata, luego de eso podrá ingresar el alfabeto de entrada del automata");
  echo'<h3> <br>Automata 1 Ingresado <br> ';
  MostrarAutomata(unserialize($Automata1));
  echo'<br></h3>';
 }
?>
</body>
</html>