<?php 
  include "Funciones.php";
      include "ClaseAutomata.php";

 $Automata1=unserialize($_POST['Automata1']);
  $Automata2=unserialize($_POST['Automata2']);
  $Tipo1=$_POST['Tipo1'];
  $Tipo2=$_POST['Tipo'];
  echo'<center>Automata de tipo : '.$Tipo1.'<br>';
  MostrarAutomata($Automata1);
  echo '<br><br>';
  echo'Automata de tipo : '.$Tipo2.'<br>';
  MostrarAutomata($Automata2);

//AFD->AFD //  AFD->AFND // AFND -> AFND// AFND -> AFD // AFND-> AFD
 //NO DEJAR ENVIAR TRANSICIONES VACIAS EN AFND
?>
