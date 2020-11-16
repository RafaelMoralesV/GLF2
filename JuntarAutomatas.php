
<?php 
  
  include "FPostingreso.php";
      include "ClaseAutomata.php";
console_log("Aqui se pueden observar ambos automatas ingresados por usted, sus eventuales equivalencias en AFD de ser AFND");
console_log("a demás de sus simplificicaciones");
//console_log("Así tambien el automata a partir del Complemento,Unión, Concatenación e Intersección entre ambos automatas");
//console_log("como también su equivalencia AFD y su simplificación");
 $Automata1=unserialize($_POST['Automata1']);
  $Automata2=unserialize($_POST['Automata2']);
echo'<html><center></html>';

echo '<table border = 1><tr><h3>AUTOMATAS INGRESADOS </H3></tr><th>';
  MostrarAutomata($Automata1);
  echo '</th><th>';

  MostrarAutomata($Automata2);
  echo '</th></table>';
  $AutomataUnido=new Maquina;
  $AutomataUnido=union($Automata1,$Automata2);
  $AutomataUnido->Caracteres=unirABC($Automata1->Caracteres,$Automata2->Caracteres);
  //MostrarAutomata($AutomataUnido);
  
  if($Automata1->Tipo=="AFND")
  	{
      echo '<h3>Dado que el Automata 1 es AFND, será transformado a su AFD equivalente</h3>';

      //transformar($Automata1);
      //MostrarAutomata($Automata1);
  		
  	}

  	if($Automata2->Tipo=="AFND")
  	{
      echo '<h3>Dado que el Automata 2 es AFND, será transformado a su AFD equivalente</h3>';

      //transformacion($Automata2);
      //MostrarAutomata($Automata2);
  		
  	}
    echo '<h2><table border = 1><tr>Los Automatas 1 y 2 simplificados</tr><tr><td>';
    if($Automata1->Tipo=="AFD")
    {
      tablaEstados($Automata1);
    MostrarAutomataReducido($Automata1);
    }
    
    
    echo'</td><td>';
    if($Automata2->Tipo=="AFD")
    {
      tablaEstados($Automata2);
      MostrarAutomataReducido($Automata2);
    }
    else
      echo'No pudimos transformar de AFD a AFND';
    
      echo'</tr></table>';
   echo '<H2>A continuación se desplegarán los automatas a partir del Complemento,Unión,Concatenación e Intersección de ambos Automatas ingresados</h2>';
   echo'<h2><table border = 1><tr><th>Complemento </th><th> Unión </th><th> Concatenación </th><th> Interseccion </th> </tr><tr><td>';
    echo'<table><td>';
    $Comp1=complemento($Automata1);
    $Comp1->Tipo='AFND';
    MostrarAutomata($Comp1);
    echo'</td><td>';
    $Comp2=complemento($Automata2);
     $Comp2->Tipo='AFND';
    MostrarAutomata($Comp2);
    echo'</td></table></td><td>';
     $Uni=union($Automata1,$Automata2);
    $Uni->Tipo="AFND";
    $Uni->Caracteres=unirABC($Automata1->Caracteres,$Automata2->Caracteres);
    MostrarAutomata($Uni);
    echo'</td><td>';
    $Conca=concatenacion($Automata1,$Automata2);
    $Conca->Tipo="AFND";
    MostrarAutomata($Conca);
    echo'</td><td>';
    $Inter=interseccion($Automata1,$Automata2);
    $Inter->Tipo="AFND";
    MostrarAutomata($Inter);
    echo '</td></table>';



//AFD->AFD //  AFD->AFND // AFND -> AFND// AFND -> AFD // AFND-> AFD
 //NO DEJAR ENVIAR TRANSICIONES VACIAS EN AFND
?>
