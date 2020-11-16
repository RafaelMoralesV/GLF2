<!DOCTYPE html>
<html>
<head>
  <title>Entrada AFND</title>

</head>
<body>
<body>
  <center>

<?php include "ClaseAutomata.php"; 
      include "Funciones.php";
  $contrans=0;
  $Paso1=false;
  $Paso2=false;
  $Paso3=false;
  $Paso4=false;
  $Envio="";
  $Envio2="";
  $Aux=array();
  $Aux2=array();
  $ABC="";
  $EI;
  $EIFBool;
  $Estados=array();
  $Transiciones=array();
  $Automata1;
   console_log("INGRESO DE DATOS AFND");
  if(isset($_POST['A1']))
  {

    $Automata1=$_POST['Automata1'];



  }
  if(isset($_POST['Submit1']))
  {
    $Letra=$_POST['Letra'];
    console_log("ha intentado ingresar : ".$Letra);
    $Automata1=$_POST['Automata1'];

    $aux=$_POST['Aux'];
    if(strlen($Letra)==1)
    {
      if(validarExistente($aux,$Letra)==0)
      {
        console_log($Letra." ha sido agregada exitosamente!");
        $ABC=$aux.$Letra;
        console_log("El alfabeto actualmente es : ".$ABC);
      }
      else
      {
        console_log($Letra." ya existe actualmente, por lo que no será añadido al alfabeto.");
        $ABC=$_POST['Aux'];
        echo "<html><H3>Letra $Letra ya ingresada.</h3></html>";
        console_log("El alfabeto actualmente es : ".$ABC);
      }       
    }
    else
    {console_log($Letra." no corresponde a UN caracter, por lo que no será añadido al alfabeto.");
      $ABC=$_POST['Aux'];
       echo'<html>Ingrese una letra</html>';
    }
  }
  if(isset($_POST['Submit2']))
  {
    $ABC=$_POST['Aux'];
    $Automata1=$_POST['Automata1'];

    if(Largoaceptado($ABC))
    {
      $Paso1=true;
      console_log("Ha finalizado el ingreso del alfabeto de entrada, el cual es : $ABC");
    }
    else
    {
     echo'<html>Alfabeto Vacio </html>';
     console_log("No puede crear un alfabeto vacio, por favor agregue caracter");
    }
  }
  if(isset($_POST['Submit3']))
  {
    $ABC=$_POST['Aux'];
    $Automata1=$_POST['Automata1'];

    $EI=$_POST['EInicial'];
    $EIFBool="no";
    if(isset($_POST['Finado']))
    {
      $EIFBool=boxtosi($_POST['Finado']);
    }
    if(Invalidarspaces($EI))
    {
      $Paso2=true;
      $Estados[0]=RemoverEspacios($EI);
      $Estados[1]=$EIFBool;
      console_log("Ha ingresado el estado $EI , final = $EIFBool");
    }
    else
    {
      echo'<html><H3>Ingrese estado valido</H3></html>';
      console_log("Ha intentado ingresar $EI, pero este solo contiene espacios, por lo que no será agregado, ingrese un estado valido.");    
    }
    $Paso1=true;
    $Envio=serialize($Estados);
  }
  if(isset($_POST['Submit4']))
  {
    
    $ABC=$_POST['Aux'];
    $Automata1=$_POST['Automata1'];

    $Estados=unserialize($_POST['Estados']);
    $E=$_POST['NEstado'];
    $EF="no";
    if(isset($_POST['Finado']))
    {
      $EF=boxtosi($_POST['Finado']);
    }
    $EAux=array();
    if(validarExistente2($Estados,$E)==0 && Invalidarspaces($E))
    {
      $EAux[0]=RemoverEspacios($E);
      $EAux[1]=$EF;
      $Estados=array_merge($Estados,$EAux);
      console_log("Ha ingresado el estado $E , final = $EF");
    }
    else
    {
      if(validarExistente2($Estados,$E)!=0)
      {
        echo '<html><H3>Estado ya ingresado</H3><html>';
        console_log("Ha intentado ingresar el estado $E, pero este ya existe.");
      }
      else
      {
        if(!Invalidarspaces($E))
        {
          echo '<html><H3>Favor no ingresar estados en blanco</H3><html>';
          console_log("Ha intentado ingresar un estado en blanco, no será agregado");
        }
      }
      
    }
    $Envio=serialize($Estados);
    $Paso1=true;
    $Paso2=true;
  }
  if(isset($_POST['Submit5']))
  {
    console_log("Agregue las transiciones utilizando la columna de estado para seleccionar el estado de origen, ingresar por teclado el tipo de transicion y seleccionar el estado de destino; La entrada predeterminada que hemos seleccionado es Ɛ, en caso de querer agregarlo como transicion ");
    $ABC=$_POST['Aux'];
    $Automata1=$_POST['Automata1'];

    $Estados=unserialize($_POST['Estados']);
    $Envio=serialize($Estados);
    $Paso1=true;
    $Paso2=true;
    $Paso3=true;
  }
  if(isset($_POST['Submit6']))
  {
    
    $contrans=$_POST['Contador'];
    $Automata1=$_POST['Automata1'];
    $Tipo1=$_POST['Tipo1'];
    $ABC=$_POST['Aux'];
    $Estados=unserialize($_POST['Estados']);
    console_log("Ha intentado agregar la transicion (".$_POST[$contrans-3]." -- ".$_POST[$contrans-2]." -> ".$_POST[$contrans-1]).")";
    if($_POST['Transiciones']!="")
    {
       $Transiciones=unserialize($_POST['Transiciones']);
    }
    if(ValidarTransicion($ABC,$_POST[$contrans-2]) || $_POST[$contrans-2]=="Ɛ" )
    {
      if(validarExistente3($Transiciones,$_POST[$contrans-3],$_POST[$contrans-2],$_POST[$contrans-1]))
      {
        array_push($Aux,$_POST[$contrans-3]);
        array_push($Aux,$_POST[$contrans-2]);
        array_push($Aux,$_POST[$contrans-1]);
        console_log("La transicion fue agregada exitosamente!");

      }
      else
      {
        echo'<h3>Transiciones ya agregada anteriormente</h3>';
        console_log("La transicion que intenta agregar ya existe, por lo cual no será agregada nuevamente");
      }
     
    }
    else
    {
      echo'<h3> Ingrese una transicion valida, respete el alfabeto de entrada</h3>';
      console_log("La transicion que intentó agregar no pertenece al alfabeto de entrada, por lo cual no será añadida");
    }
    
    $Aux2=array_merge($Transiciones,$Aux);
    $Envio=serialize($Estados);
    $Envio2=serialize($Aux2);
    $Paso1=true;
    $Paso2=true;
    $Paso3=true;
  }
?>


<?php 
if($Paso1==false )
    {
    console_log("Ingrese el caracter a agregar o finalice en caso de estar listo con el actual alfabeto de entrada");
    echo "<html>
    <form method='post' action=''>
    <p>Añada letras al alfabeto:</p>
    <input type='text' name='Letra' placeholder='Letra'>
    <input type='hidden' name='Aux' value=$ABC>
    <input type='submit' name='Submit1' value='Añadir'>
    <input type='hidden' name='Automata1' value=$Automata1>
    <input type='submit' name='Submit2' value='Finalizar'>
    </form></html>";
    echo "<html><br><h3>Alfabeto de entrada : ( $ABC )</h3></html>";
    }
else if($Paso2==false)
    {
      console_log("Ingrese el primer estado del automata y marque la casilla en caso de ser un estado final");
    echo "<html>
    <form method='post' action=''>
    <p>Ingrese el estado inicial del automata: </p>
    <input type='text' name='EInicial' placeholder='Etiqueta de estado' required>
    <input type='hidden' name='Aux' value=$ABC>
    <input type='hidden' name='Estado' value=$Envio>
    ¿Estado Finalizado?<input type='checkbox' name='Finado'>
    <input type='hidden' name='Automata1' value=$Automata1>
    <input type='submit' name='Submit3' value='Siguiente'>
    </form></html>";
    echo "<html><h3>Alfabeto de entrada : ( $ABC )</h3></html>";
    }
else if($Paso3==false)
    {
      console_log("Ingrese los estados que contenga su automata, si ha finalizado su ingreso, haga click en Siguiente");

      echo "<html>
      <form method='post' action=''>
      <br><p>Añada etiqueta de estado: </p>
      <input type='text' name='NEstado' placeholder='Estado' >
      <input type='hidden' name='Aux' value=$ABC>
      <input type='hidden' name='Estados' value=$Envio>
    ¿Estado Finalizado?<input type='checkbox' name='Finado'>
    <input type='hidden' name='Automata1' value=$Automata1>
      <input type='submit' name='Submit4' value='Agregar'>
      <input type='submit' name='Submit5' value='Siguiente'>
      <H3>Alfabeto de entrada : ( $ABC )</H3></form>
      </html>";
      MostrarEstados(unserialize($Envio));
    }
else if($Paso4==false)
{ 
  console_log("Ingrese transicion o en caso de ya haber ingresado todas, haga click en Finalizar Automata");
  echo "<h1>A partir del Alfabeto de entrada, añada transiciones del automata por favor.<h1>
<h3>(Si ya terminó de ingresar, haga click en Finalizar Automata)</h3> ";
  echo "<h2>Alfabeto de entrada ( ".$ABC.' )</h2>';
  echo "<html><form method='post' action=''>
   
   <input type='hidden' name='Aux' value='$ABC'>";
   TablaTransAFND($ABC,$Estados,$contrans);
   $contrans=$contrans+3;
   echo"<input type='hidden' name='Estados' value='$Envio'>
   <input type='hidden' name='Transiciones' value='$Envio2'>
   <input type='hidden' name='Contador' value='$contrans'>
   <input type='hidden' name='Automata1' value=$Automata1>
   <input type='submit' name='Submit6' value='Añadir'>
    </form>";

    if($Envio2!="")
    {
      echo "<form method='post' action='Uff.php'>
   <input type='hidden' name='Aux' value='$ABC'>
   <input type='hidden' name='Estados' value='$Envio'>
   <input type='hidden' name='Automata1' value=$Automata1>
   <input type='hidden' name='Tipo' value='AFND'>
   <input type='hidden' name='Transiciones' value='$Envio2'>
   <input type='submit' name='Submit7' value='Finalizar Automata'>


    </html>";
      MostrarTransiciones(unserialize($Envio2));
    }
   
}
?>
</center>
</body>
</html>