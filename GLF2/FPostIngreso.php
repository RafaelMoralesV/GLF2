<?php include 'Funciones.php';

function union($maquina1,$maquina2)
{
	$aux=new Estado;
	$aux2=new Estado;
	$res=new Maquina;
	$e=$maquina1;
	array_push($res->Estados,$aux);
	$aux->Caracter='#u';
	$res->Est_Inicial='#u';
	$res->Posicion='#u';
	setOpciones($res,'#u','Ɛ',$maquina1->Est_Inicial);
	setOpciones($res,'#u','Ɛ',$maquina2->Est_Inicial);
	for($j=0;$j<count($maquina2->Estados);$j++)
	{
		$aux2=$maquina2->Estados[$j];
		array_push($res->Estados,$aux2);
	}
	for($x=0;$x<count($maquina2->Est_Final);$x++)
		{
			array_push($res->Est_Final,$maquina2->Est_Final[$x]);
		}
	for($i=0;$i<count($e->Estados);$i++)
	{
		
		$aux2=$e->Estados[$i];
		if(existe($res->Estados,$aux2)==0)
		{
			
			renombrar($e,$aux2,'✤'.$aux2->Caracter);
		}
		if(existe($e->Est_Final,$aux2->Caracter)==0)
		{
			if(existe($res->Est_Final,$aux2->Caracter)!=0)
			{
				array_push($res->Est_Final,'✤'.$e->Est_Final[$i]);
			}
			else
			{
				array_push($res->Est_Final,$e->Est_Final[$i]);
			}

				
		}
		array_push($res->Estados,$aux2);
	}
		

	return $res;
}
function renombrar($maquina,$aux,$a)
{
	for($i=0;$i<count($maquina->Estados);$i++)
	{
		if($maquina->Estados[$i]->Caracter==$aux->Caracter)
		{
			$maquina->Estados[$i]->Caracter=$a;
		}
		for($j=0;$j<count($maquina->Estados[$i]->Nomb_estados);$j++)
		{
			if($maquina->Estados[$i]->Nomb_estados[$j]==$aux->Caracter)
			{
				$maquina->Estados[$i]->Nomb_estados[$j]=$a;
			}
		}

	}
}
function complemento($maquina)
{
	$a=$maquina;
	$aux=array();
	for($i=0;$i<count($a->Estados);$i++)
	{
		if(existeC($a->Est_Final,$a->Estados[$i]->Caracter)!=0)
		{
			array_push($aux,$a->Estados[$i]->Caracter);
		}
	}$a->Est_Final($aux);
	return $a;
}

function concatenacion($maquina1,$maquina2)
{
	$res=new Maquina;
	$aux = new Estado;
	$aux=$maquina2;
	for($j=0;$j<count($maquina1->Estados);$j++)
	{
		for($i=0;$i<count($maquina1->Est_Final);$i++)
		{
			$aux=$maquina1->Estados[$j];
			if($aux->Caracter==$maquina1->Est_Final[$i])
			{
				array_push($aux->Opciones,'Ɛ');
				array_push($aux->Nomb_estados,$maquina2->Est_Inicial);
			}
		}array_push($res->Estados,$aux);
	}
	for($k=0;$k<count($aux2->Estados);$k++)
	{
		$aux=$aux2->Estados[$k];
		if(existe($res->Estados,$aux)==0)
		{
			renombrar($aux2,$aux,'✦'.$aux->Caracter);
		}
		array_push($res->Estados,$aux2->Estados[$k]);
	}
	return $res;
}
function existeC($lista,$caracter)
  { 
  	$cont=0;
    for($i=0;$i<count($lista);$i++)
    {
   
    	if($caracter==$lista[$i])
   		 {

     		 $cont++;
    	}
 
   
  }
  if($cont==0)
  {
  	return 0;
  }
  else
  {
  	return 1;
  }
  	
}
function incompatibles($maquina,$nod1,$nod2)
{
	if($nod1->Caracter==$nod2->Caracter)
	{

		return true;
	}
	if(existe($maquina->Est_Final,$nod1)==0 && existe($maquina->Est_Final,$nod2)!=0)
	{

		return true;
	}
	if(existe($maquina->Est_Final,$nod1)!=0 && existe($maquina->Est_Final,$nod2)==0)
	{

		return true;
	}
	for($i=0;$i<count($nod1->Nomb_estados);$i++)
	{
		
		for($j=0;$j<count($nod1->Nomb_estados);$j++)
		{
			if($nod1->Opciones[$i]==$nod2->Opciones[$j])
			{
				
				if($nod1->Nomb_estados[$i]!=$nod2->Nomb_estados[$j])
				{


					if(existeC($maquina->Est_Final,$nod1->Nomb_estados[$i])==0 && existeC($maquina->Est_Final,$nod2->Nomb_estados[$j])!=0)
					{


						return true;
					}
	
					if(existeC($maquina->Est_Final,$nod1->Nomb_estados[$i])!=0 && existeC($maquina->Est_Final,$nod2->Nomb_estados[$j])==0)
					{

						return true;
					}
				}
			}
		}
	}


}
function tablaEstados($maquina)
{
	$maquina->Reducido=$maquina->Estados;
	$cont=0;
	
	inicializarTabla($maquina);
	for($i=0;$i<count($maquina->Reducido);$i++)
	{

		
		for($j=0;$j<count($maquina->Reducido);$j++)
		{

			if(existe($maquina->Reducido,$maquina->Reducido[$j])==0)
			{
				//echo incompatibles($maquina,$maquina->Reducido[$i],$maquina->Reducido[$j])? 'true' : 'false';

				if(incompatibles($maquina,$maquina->Reducido[$i],$maquina->Reducido[$j])!=true)
				{
					
					if($maquina->Reducido[$i]->Caracter==$maquina->Est_Inicial)
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






?>