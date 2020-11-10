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
function boxtobool($e)
{
  if($e=="on")
    return true;
  else
    return false;
}
?>