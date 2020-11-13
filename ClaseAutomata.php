<?php 
class Estado 
{
  public $Caracter=null;//Nombre de estado/Etiqueta
  public $Opciones=array();//Arreglo que contiene los estados que se une
  public $Nomb_estados=array();//Arreglo que contiene la transicion de los estados de arriba
 
} 
class Maquina
{
  public $Estados=array();
  public $Caracteres; 
  public $Est_Inicial; 
  public $Est_Final=array();

  public $Camino=array();
  public $Posicion;
  public $Tabla=array();
  public $Reducido=array();
  public $Eliminados=array();
}
function llenarEstados($auto,$e)
 {
  for($i=0;$i<count($e);$i++)
  {
    $Aux=new Estado;
    $Aux->Caracter=$e[$i];
    $auto->Estados[$i]=$Aux;
  }
 }
function setOpciones($auto,$c,$op,$est)
  {
    for($i=0;$i<count($auto->Estados);$i++)
    {
      if($auto->Estados[$i]->Caracter==$c)
      {
        $auto->Estados[$i]->Opciones[count($auto->Estados[$i]->Opciones)]=$op;
        $auto->Estados[$i]->Nomb_estados[count($auto->Estados[$i]->Nomb_estados)]=$est;
                break;
      }
    }
  }
 function LlenarOpciones($auto,$Estados1,$Trans,$Estados2)
  {
    for($i=0;$i<count($Trans);$i++)
    {
      setOpciones($auto,$Estados1[$i],$Trans[$i],$Estados2[$i]);
    }
  }

function Mostrar($auto)
 {
  for($i=0;$i<count($auto->Estados);$i++)
  {
    echo 'estado {<br>';
    echo '  &nbsp;&nbsp;  caracter'.$auto->Estados[$i]->Caracter;
    echo '  <br> &nbsp;&nbsp; opciones : [';
    for($j=0;$j<count($auto->Estados[$i]->Opciones);$j++)
    {
      echo $auto->Estados[$i]->Opciones[$j];
    }
    echo ']<br>';
    echo ' &nbsp;&nbsp;   nomb_estados : [';
    for($k=0;$k<count($auto->Estados[$i]->Nomb_estados);$k++)
    {
      echo $auto->Estados[$i]->Nomb_estados[$k];
    }
    echo ']<br> &nbsp }<br>';

  }
 }
function Mostrar2($auto)
 {
  for($i=0;$i<count($auto->Reducido);$i++)
  {

    echo 'estado {<br>';
    echo '  &nbsp;&nbsp;  caracter '.$auto->Reducido[$i]->Caracter;
    echo '  <br>  opciones : [';
    for($j=0;$j<count($auto->Reducido[$i]->Opciones);$j++)
    {
      echo $auto->Reducido[$i]->Opciones[$j];
    }
    echo ']<br>';
    echo ' &nbsp;&nbsp;   nomb_estados : [';
    for($k=0;$k<count($auto->Reducido[$i]->Nomb_estados);$k++)
    {
      echo $auto->Reducido[$i]->Nomb_estados[$k];
    }
    echo ']<br> &nbsp }<br>';

  }
 }

 function inicializarTabla($maquina)
 {
  for($i=0;$i<count($maquina->Estados);$i++)
  {
    for($j=0;$j<count($maquina->Estados);$j++)
    {
      $maquina->Tabla[$i][$j]=0;
      $maquina->Tabla[$i][$i]='x';
    }
  }
 }

 function transicion($maquina,$nodo,$op)
 {
  for($i=0;$i<count($maquina->Estados);$i++)
  {
    if($maquina->Estados[$i]->Caracter==$nodo)
    {
      for($j=0;$j<count($maquina->Estados[$i]->Opciones);$j++)
      {
        if($maquina->Estados[$i]->Opciones[$j]==$op)
        {
          return $maquina->Estados[$i]->Nomb_estados[$j];
        }
      }
    }
  }
 }
 /*function recorrer ($maquina,$string)
 {
  for($i=0;$i<strlen($string);$i++)
  {
    $a=transicion($maquina,$maquina->Posicion,$string[$i]);
    $maquina->Posicion=$a;
    array_push($maquina->Camino,$a);
  }
 }*/
 function incompatibles($maquina,$nod1,$nod2)
 {
  if($nod1->Caracter==$nod2->Caracter)
  {
    return true;
  }
  for($i=0;$i<count($maquina->Est_Final);$i++)
  {
    if($nod1->Caracter==$maquina->Est_Final[$i])
    {
      return true;
    }
    if($nod2->Caracter==$maquina->Est_Final[$i])
    {
      return true;
    }
  }
 
  for($i=0;$i<count($nod1->Nomb_estados);$i++)
  {
    for($j=0;$j<count($nod1->Nomb_estados);$j++)
    {
      if($nod1->Opciones[$i]==$nod2->Opciones[$j])
      {
        if($nod1->Nomb_estados[$i]!=$nod2->Nomb_estados[$j])
        {
          for($k=0;$k<count($maquina->Est_Final);$k++)
          {
            if($nod1->Nomb_estados[$i]==$maquina->Est_Final[$k] || $nod2->Nomb_estados[$j]==$maquina->Est_Final[$k])
            {

              return true;

            }
          }
        }
      }
    }
  }
 }
 function tablaEstados($maquina)
 {
  $maquina->Reducido=$maquina->Estados;
  inicializarTabla($maquina);

  for($i=0;$i<count($maquina->Reducido);$i++)
  {
    
    for($j=0;$j<count($maquina->Reducido);$j++)
    {

      if(existe($maquina->Reducido,$maquina->Reducido[$j])!=true)
      {
        if((incompatibles($maquina,$maquina->Reducido[$i],$maquina->Reducido[$j]))!=true)
        {
          if($maquina->Reducido[$i]==$maquina->Est_Inicial)
           {
            $maquina->Est_Inicial=$maquina->Reducido[$j]->Caracter;
           }
           redirigir($maquina,$maquina->Reducido[$i]);

           array_splice($maquina->Reducido,$i,1);
          

        }
      }
    }
 }
}
 function redirigir($maquina,$estado1)
 {

  for($u=0;$u<count($maquina->Estados);$u++)
  {
    for($t=0;$t<count($maquina->Estados[$u]->Nomb_estados);$t++)
    {
      if($maquina->Estados[$u]->Nomb_estados[$t]==$estado1->Caracter)
      {
        $maquina->Estados[$u]->Nomb_estados[$t]=$maquina->Estados[$u]->Caracter;
      }
    }
  }
  
 }
 function ExisteAgregar($maquina,$estado)
 {
  
  $aux=0;
  
  for($i=0;$i<count($maquina->Reducido);$i++)
  {
    #echo'<br> '.$estado->Caracter.' vs '.$maquina->Reducido[$i]->Caracter;
    if($estado->Caracter==$maquina->Reducido[$i]->Caracter)
    {

      $aux=1;
    }

  }
  if($aux==0)
  {

    array_push($maquina->Reducido,$estado);
  }
  else
    return 1;
 }
 function rellenaTabla($maquina)
 {
  for($i=0;$i<count($maquina->Estados);$i++)
  {
    for($j=0;$j<count($maquina->Estados);$j++)
    {
      if((incompatibles($maquina,$maquina->Estados[$i],$maquina->Estados[$j]))==true)
        {
          $maquina->Tabla[$i][$j]='x';
        }
        else{
          $maquina->Tabla[$i][$j]=0;
        }
    }
  }
 }
 function existe($lista,$estado)
 {
  $cont=1;
  for($i=0;count($lista);$i++)
  {
    
    if($estado->Caracter==$lista[$i]->Caracter)
    {

      return 0;
    }
    $cont=$cont+1;
    if($cont-3>count($lista))
      {
        return 1;
      }
      
  }
  

 }
 function SetEFinales($automata,$e)
  {
    for($i=1;$i<count($e);$i=$i+2)
    {
      if($e[$i]=="si")
      {
        array_push($automata->Est_Final,$e[$i-1]);
      }
    }
  }
?>