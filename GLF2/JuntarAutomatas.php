
<?php 
  
  include "FPostingreso.php";
      include "ClaseAutomata.php";
console_log("Aqui se pueden observar ambos automatas ingresados por usted");
 $Automata1=unserialize($_POST['Automata1']);
  $Automata2=unserialize($_POST['Automata2']);
echo'<html><center></html>';


  MostrarAutomata($Automata1);
  echo '<br><br>';
  MostrarAutomata($Automata2);
  $AutomataUnido=new Maquina;
  $AutomataUnido=union($Automata1,$Automata2);
  $AutomataUnido->Caracteres=unirABC($Automata1->Caracteres,$Automata2->Caracteres);
  //MostrarAutomata($AutomataUnido);
  if($Automata1->Tipo="AFD")
  	{
  		tablaEstados($Automata1);
  		MostrarAutomataReducido($Automata1);
  	}
  	if($Automata2->Tipo="AFD")
  	{
  		tablaEstados($Automata2);
  		MostrarAutomataReducido($Automata2);
  	}


//AFD->AFD //  AFD->AFND // AFND -> AFND// AFND -> AFD // AFND-> AFD
 //NO DEJAR ENVIAR TRANSICIONES VACIAS EN AFND
?>
