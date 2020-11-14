<?php 

function validarExistente($e,$y)
{
  $cont=0;
  for($i=0;$i<strlen($e);$i++)
  {
    if($e[$i]==$y)
      $cont++;
  }
  return $cont;
}
function boxtosi($e)
{
  if($e=="on")
    return "si";
  else
    return "no";
}
function LargoAceptado($e)
{
  if($e!="")
    return true;
  else
    return false;
}
function validarExistente2($e,$y)
{
  $cont=0;
  if($y=="")
  {
    $cont+1;
  }
  else
  {
    for($i=0;$i<count($e);$i++)
    {
      if($e[$i]==$y)
        $cont++;
    }
    return $cont;
  }
  
}
function MostrarEstados($e)
{

  $count=0;
  for($i=0;$i<count($e);$i++)
  {
    if($i%2==0)
    {
      $e[$i]=str_replace("/"," ",$e[$i]);
      echo"<html><H3>Estado : $e[$i] </html>";
      $e[$i]=str_replace(" ","/",$e[$i]);
    }
    else
    {
      if($e[$i]=="no")
      {
        echo'<html> no final</H3></html>';
      }
      else
        echo'<html> final</H3></html>';

      $count=0;
    }
  }

}
  function Invalidarspaces($e)
  { $cont=0;
    for($i=0;$i<strlen($e);$i++)
    {
      if($e[$i]!=" ")
      {
        $cont++;
      }
    }
    if($cont==0)
    {
      return false;
    }
    else
      return true;
  }
function RemoverEspacios($f)
{
  $e=$f;
  $e=str_replace(" ","/",$e);
  return $e;
}


function TablaTrans($ABC,$Estados)
{
  $cont=0;
  echo '<table border="1">
    <tr>
      <th>ESTADO</th><th>Transición</th><th>Destino</th>';
  for($i=0;$i<count($Estados);$i++)
  {
    if($i%2==0)
    {
      for($j=0;$j<strlen($ABC);$j++)
      {
        echo'
              <tr>
                <th>'.$Estados[$i].' </th>
                <th> '.$ABC[$j].'</th>
                <th><select name='.$cont.'>';
                for($k=0;$k<count($Estados);$k++)
                {
                  
                  if($k%2==0)
                  {
                    echo'<option value='.$Estados[$k].'>'.$Estados[$k].'</option>';
                    
                  }
                  
                }
                $cont++;
                
             echo'</select> </th></tr>';
      }
    }
  }echo'</table>';
  
}
function TablaTransAFND($ABC,$Estados,$conta)
{
  $cont=$conta;
  echo '<table border="1">
    <tr>
      <th>ESTADO</th><th>Transición</th><th>Destino</th>
      <tr>
            <th><select name='.$cont.'>';
    for($i=0;$i<count($Estados);$i++)
    {
      if($i%2==0)
      {
        echo'<option value='.$Estados[$i].'>'.$Estados[$i].'</option>';
      }
      
    }
    $cont++;
    echo'<th><input type="text" name='.$cont.' placeholder="Transicion..." value="Ɛ" required>';
    $cont++;
    echo'</th><th><select name='.$cont.'>';
    
    for($j=0;$j<count($Estados);$j++)
    {
      if($j%2==0)
      {
        echo'<option value='.$Estados[$j].'>'.$Estados[$j].'</option>';
      }
    }
    $cont++;
    echo'</select> </th></tr>';
  
    
  echo'</table>';
}

function ArrayarTrans($ABC,$Estados,$Posht) //RETORNA destinos q0 q1 q0 q0 q1 q2 q0 q3
{
  $Array=array();
  $Cant=strlen($ABC)*(count($Estados)/2);
  for($i=0;$i<$Cant;$i++)
  {
    $Array[$i]=$Posht[$i];
  }
  return $Array;
  
}
//_------------------------------------------
function ArrayP1($ABC,$Estados) //RETORNA q0 q0 q0 q0 q1 q1 q1 q1 q2 q2 q2 q2 q3 q3 q3 q3 
{
  $Cont=0;
  $Array=array();
  for($i=0;$i<count($Estados);$i++)
  {
    for($j=0;$j<strlen($ABC);$j++)
    {
        array_push($Array,$Estados[$i]);
        
    }
    
  }
  return $Array;
}
function GetEstados($Estados)
{
  $Arr=array();
  for($i=0;$i<count($Estados);$i++)
  {
    if($i%2==0)
      array_push($Arr,$Estados[$i]);
  }
  return $Arr;
  
}
function ArrayP2($ABC,$Estados)//RETORNA A B C D A B C D A B C D A B C D 
{
  
  $Cont=0;
  $Array=array();
  
  for($i=0;$i<count($Estados);$i++)
  {
    for($j=0;$j<strlen($ABC);$j++)
    {
      $Array[$Cont]=$ABC[$j];
      $Cont++;
    }
  }
  return $Array;
} 





function GetFinales($Estados)
{
  $Arr=array();
  for($i=1;$i<count($Estados);$i++)
  {
    if($i%2==1)
      array_push($Arr,$Estados[$i]);
  }
  return $Arr;
}
function ValidarTransicion($ABC,$e)
{
  $cont=0;
  for($i=0;$i<strlen($e);$i++)
  {
    for($j=0;$j<strlen($ABC);$j++)
    {
      if($e[$i]==$ABC[$j])
      {
        $cont++;
      }
    }
  }
  if($cont==strlen($e))
  {
    return true;
  }
  else
  {
    return false;
  }
}
function MostrarTransiciones($e)
{
  for($i=0;$i<count($e);$i=$i+3)
  {
    echo'<h3>Transicion ( '.$e[$i].'-'.$e[$i+1].'->'.$e[$i+2].')</h3>';
     
  }

}
function validarExistente3($Arreglo,$Entrada1,$Entrada2,$Entrada3)
{
  $contad=0;
  for($i=0;$i<count($Arreglo);$i=$i+3)
  {
   
    if($Arreglo[$i]==$Entrada1 && $Arreglo[$i+1]==$Entrada2 && $Arreglo[$i+2]==$Entrada3)
    {
      $contad=$contad+1;
      
    }
  }
  
  if($contad==0)
    return true;
  else
    return false;
}
function LlenarAutomata($Automata,$Estados,$Transa,$ABC)
{
  $EstadosL=GetEstados($Estados);//CONTIENE TODOS LOS ESTADOS 1 SOLA VEZ
//  $EFinales=GetFinales($Estados);//CONTIENE SI O NO SEGUN $EstadosL
  $Esta2=ArrayP1($ABC,$EstadosL);//REPITE LOS ESTADOS AAAA BBBB CCCC DDDD
  $Abcedario=ArrayP2($ABC,$EstadosL);//REPITE EL ABC ABCDABCDABCD
  $Automata->Est_Inicial=$EstadosL[0];
  $Automata->Posicion=$EstadosL[0];
  llenarEstados($Automata,$EstadosL);
  InicializarTabla($Automata);
  SetEFinales($Automata,$Estados);
  LlenarOpciones($Automata,$Esta2,$Abcedario,$Transa);
  return $Automata;
}
function llenarTransiciones($Automata,$Transa)
{
  for($i=0;$i<count($Automata->Estados);$i++)
  {
    for($j=0;$j<count($Transa);$j=$j+3)
    {
      if($Transa[$j]==$Automata->Estados[$i]->Caracter)
      {
        array_push($Automata->Estados[$i]->Opciones,$Transa[$j+1]);
        array_push($Automata->Estados[$i]->Nomb_estados,$Transa[$j+2]);
      }
    }
  }
}
function LlenarAutomata2($Automata,$Estados,$Transa)
{
  //GuardarTransiciones/Opciones

  $EstadosL=GetEstados($Estados);
  $Automata->Est_Inicial=$EstadosL[0];
  $Automata->Posicion=$EstadosL[0];
  llenarEstados($Automata,$EstadosL);
  SetEFinales($Automata,$Estados);
  llenarTransiciones($Automata,$Transa);
  return $Automata;

}
function MostrarAutomata($Automata)
{
  echo '<html><br>

    <table border 1>
    <tr><th>Estado Inicial  </th><th>'.$Automata->Est_Inicial.'</th></tr>
    <tr><th>Estados finales  <th>';
       foreach($Automata->Est_Final as $x)
        {
         echo ' '.$x.' ';
        }
      echo'</th></th></tr>
      <tr>
        <th>Estados</th><th>Transiciones</th>
      </tr>
      <tr>';
      for($i=0;$i<count($Automata->Estados);$i++)
      {
        echo'<th>'.$Automata->Estados[$i]->Caracter.'</th>';
        {
          echo'<th><table border 1>';
          for($j=0;$j<count($Automata->Estados[$i]->Opciones);$j++)
          {
            echo'<th>&nbsp;&nbsp;&nbsp;&nbsp;'.$Automata->Estados[$i]->Opciones[$j].'&nbsp;&nbsp;&nbsp;&nbsp;</th><th>→</th><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$Automata->Estados[$i]->Nomb_estados[$j].'&nbsp;&nbsp;&nbsp;&nbsp;</th><tr>';
          }
          echo'</tr></table></tr>';
        }
      }
      echo '</table></br>';
}
?>