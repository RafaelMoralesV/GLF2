<!DOCTYPE html>
<html>
<head>
  <title>Trabajo Grafos 2</title>

</head>
<body>
<body><center>

<?php include "ClaseAutomata.php"; 
      include "Funciones.php";

  $Paso1=false;
  $Paso2=false;
  $Paso3=false;
  $Paso4=false;
  $Envio="";
  $ABC="";
  $EI;
  $EIFBool;
  $Estados=array();
  $Automata1;
  

  if(isset($_POST['A1']))
  {

    $Automata1=$_POST['Automata1'];
    $Tipo1=$_POST['Tipo1'];

  }
  if(isset($_POST['Submit1']))
  {

    $Letra=$_POST['Letra'];
    $Automata1=$_POST['Automata1'];
    $Tipo1=$_POST['Tipo1'];
    $aux=$_POST['Aux'];
    if(strlen($Letra)==1)
    {
      if(validarExistente($aux,$Letra)==0)
      {
        $ABC=$aux.$Letra;
      }
      else
      {
        $ABC=$_POST['Aux'];
        echo "<html><H3>Letra $Letra ya ingresada.</h3></html>";
      }       
    }
    else
    {
      $ABC=$_POST['Aux'];
       echo'<html>Ingrese una letra</html>';
    }
  }
  if(isset($_POST['Submit2']))
  {
    $ABC=$_POST['Aux'];
    $Automata1=$_POST['Automata1'];
    $Tipo1=$_POST['Tipo1'];
    if(Largoaceptado($ABC))
    {
      $Paso1=true;
    }
    else
     echo'<html>Alfabeto Vacio </html>';
  }
  if(isset($_POST['Submit3']))
  {
    $ABC=$_POST['Aux'];
    $Automata1=$_POST['Automata1'];
    $Tipo1=$_POST['Tipo1'];
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
    }
    else
      echo'<html><H3>Ingrese estado valido</H3></html>';    
    $Paso1=true;
    $Envio=serialize($Estados);
  }
  if(isset($_POST['Submit4']))
  {
    
    $ABC=$_POST['Aux'];
    $Automata1=$_POST['Automata1'];
    $Tipo1=$_POST['Tipo1'];
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
    }
    else
    {
      if(validarExistente2($Estados,$E)!=0)
      {
        echo '<html><H3>Estado ya ingresado</H3><html>';
      }
      else
      {
        if(!Invalidarspaces($E))
        {
          echo '<html><H3>Favor no ingresar estados en blanco</H3><html>';
        }
      }
      
    }
    $Envio=serialize($Estados);
    $Paso1=true;
    $Paso2=true;
  }
  if(isset($_POST['Submit5']))
  {
    
    $ABC=$_POST['Aux'];
    $Automata1=$_POST['Automata1'];

    $Tipo1=$_POST['Tipo1'];
    $Estados=unserialize($_POST['Estados']);
    $Envio=serialize($Estados);
    $Paso1=true;
    $Paso2=true;
    $Paso3=true;
  }
?>


<?php 
if($Paso1==false )
    {
    echo "<html>
    <form method='post' action=''>
    <p>Añada letras al alfabeto:</p>
    <input type='text' name='Letra' placeholder='Letra'>
    <input type='hidden' name='Aux' value=$ABC>
    <input type='submit' name='Submit1' value='Añadir'>
    <input type='hidden' name='Automata1' value=$Automata1>
    <input type='hidden' name='Tipo1' value=$Tipo1>
    <input type='submit' name='Submit2' value='Finalizar'>
    </form></html>";
    echo "<html><br><h3>Alfabeto de entrada : ( $ABC )</h3></html>";
    }
else if($Paso2==false)
    {
    echo "<html>
    <form method='post' action=''>
    <p>Ingrese el estado inicial del automata: </p>
    <input type='text' name='EInicial' placeholder='Etiqueta de estado' required>
    <input type='hidden' name='Aux' value=$ABC>
    <input type='hidden' name='Estado' value=$Envio>
    <input type='hidden' name='Automata1' value=$Automata1>
    <input type='hidden' name='Tipo1' value=$Tipo1>
    ¿Estado Finalizado?<input type='checkbox' name='Finado'>
    <input type='submit' name='Submit3' value='Siguiente'>
    </form></html>";
    echo "<html><h3>Alfabeto de entrada : ( $ABC )</h3></html>";
    }
else if($Paso3==false)
    {
      echo "<html>
      <form method='post' action=''>
      <br><p>Añada etiqueta de estado: </p>
      <input type='text' name='NEstado' placeholder='Estado' >
      <input type='hidden' name='Aux' value=$ABC>
      <input type='hidden' name='Estados' value=$Envio>
      <input type='hidden' name='Automata1' value=$Automata1>
      <input type='hidden' name='Tipo1' value=$Tipo1>
    ¿Estado Finalizado?<input type='checkbox' name='Finado'>
      <input type='submit' name='Submit4' value='Agregar'>
      <input type='submit' name='Submit5' value='Siguiente'>
      <H3>Alfabeto de entrada : ( $ABC )</H3></form>
      </html>";
      MostrarEstados(unserialize($Envio));
    }
else if($Paso4==false)
{
  echo "<html><form method='post' action='Uff.php'>
   
   <input type='hidden' name='Aux' value='$ABC'>";
   TablaTrans($ABC,$Estados);
   echo"<input type='hidden' name='Estados' value='$Envio'>
   <input type='hidden' name='Tipo1' value=$Tipo1>
   <input type='hidden' name='Tipo' value='AFD'>
   <input type='hidden' name='Automata1' value=$Automata1>
   <input type='submit' name='Submit6' value='Enviar'>
   </form></html>";
   
}
?>
</center>
</body>
</html>