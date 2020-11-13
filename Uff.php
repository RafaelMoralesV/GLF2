<?php 
      include "Funciones.php";
      include "ClaseAutomata.php";

      
if(isset($_POST['Submit6']))
  {
    $Automata1=$_POST['Automata1'];
    $Tipo1=$_POST['Tipo1'];
    $ABC=$_POST['Aux'];//LLEGA ABCD
    $Estados=unserialize($_POST['Estados']);//LLEGA Q0 NO Q1 SI Q2 SI Q3 NO
    $Transa=ArrayarTrans($ABC,$Estados,$_POST);//RETORNA destinos q0 q1 q0 q0 q1 q2 q0 q3
    $Tipo=$_POST['Tipo'];
    $Key="AFD";

  }

if(isset($_POST['Submit7']))
  {

    $Automata1=$_POST['Automata1'];
    $Tipo1=$_POST['Tipo1'];
    $ABC=$_POST['Aux'];//LLEGA ABCD
    $Estados=unserialize($_POST['Estados']);//LLEGA Q0 NO Q1 SI Q2 SI Q3 NO
    $Transa=unserialize($_POST['Transiciones']);//RETORNA destinos q0 q1 q0 q0 q1 q2 q0 q3
    $Tipo=$_POST['Tipo'];
    $Key="AFND";
  }

  $Automata=new Maquina;
  if($Key=="AFD")
  {
    $Automata=LlenarAutomata($Automata,$Estados,$Transa,$ABC);
    echo ' <center><br><br><br>';
    MostrarAutomata($Automata);
    echo '<br><br><br>';
  }
  if($Key=="AFND")
  {
    //$Automata=LlenarAutomata($Automata,$Estados,$Transa,$ABC);
    $Automata=LlenarAutomata2($Automata,$Estados,$Transa,$ABC);
    echo ' <center><br><br><br>';
    MostrarAutomata($Automata);
    echo '<br><br><br>';
  }
  

  
  echo '<br><br><br>';
  if(unserialize($Automata1)=="")
  {
    print_r($Automata1);
    echo'<html><form method="post" action="index.php">
        <input type="hidden" name="Automata" value='.serialize($Automata).'>
        <input type="hidden" name="Tipo" value= '.$Tipo.' >

        <input type="submit" name="Submit7" value="Continuar..." ></form>';
  }
  else
  {
    echo'<html><form method="post" action="JuntarAutomatas.php">
        <input type="hidden" name="Automata2" value='.serialize($Automata).'>
        <input type="hidden" name="Automata1" value='.$Automata1.'>
        <input type="hidden" name="Tipo1" value="'.$Tipo1.'">
        <input type="hidden" name="Tipo" value="'.$Tipo.'">
        <input type="submit" name="Submit8" value="Continuarsh..." ></form>';
  }
  


#Mostrar2($Automata);





 /*
 setEstadosFinales($Automata,$Estados);
 $Automata->Caracteres=$ABC;
 $Automata->EstadoInicial=$EstadosL[0];
 llenarEstados($Automata,$EstadosL);
 LlenarOpciones($Automata,$Esta2,$Abcedario,$Transa);
 InicializarTabla($Automata);
*/

 //Mostrar($Automata);
 //tablaEstados($Automata);
 //print_r($Automata->Reducido);
 //echo 'OWO';
 






 /*$Automata->setMatriz();


 
 
 //$Automata->MostrarAutomata();
 //$Automata->tablaEstados();
 echo '<html><br><br></html>';
  $Automata->Mostrar();
  tablaEstados($Automata);
  echo '<html><br><br></html>';
 $Automata->MostrarRe();*/

 





?>
