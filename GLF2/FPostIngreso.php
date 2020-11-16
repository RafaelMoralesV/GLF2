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
	}$a->Est_Final=$aux;
	return $a;
}

function concatenacion($maquina1,$maquina2)
{
	$res=new Maquina;
	$aux = new Estado;
	$aux2=$maquina2;
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
  if($cont!=0)
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
function interseccion ($maquina1,$maquina2)
{
	$a1=complemento($maquina1);
	$a2=complemento($maquina2);
	$final=union($a1,$a2);
	return $final;
}
function tablatransic($maquina1)
{
	$tabla=array();
	$aux=array();
	array_push($aux,'&');
	for($j=0;$j<strlen($maquina1->Caracteres);$j++)
	{
		array_push($aux,$maquina->Caracteres[$j]);
	}
	array_push($tabla,$aux);
	$aux=array();
	for($k=0;$k<count($maquina1->Estados);$k++)
	{
		$aux=array();
		array_push($aux,$maquina1->Estados[$k]->Caracter);
		for($i=1;$i<count($tabla[0]);$i++)
		{
			$aux2=array();
			$cont=0;
			for($u=0;$u<count($maquina1->Estados[$k]->Opciones);$u++)
			{
				if($maquina1->Estados[$k]->Opciones[$u]==$tabla[0][$i])
					{
						$cont+=1;
						array_push($maquina->Estados[$k]->Nomb_estados[$u]);
					}
			}
			if($cont==0)
			{
				array_push($aux2,'0');
			}
			array_push($aux,$aux2);
		} array_push($tabla,$aux);
	}
	return $tabla;
}
function rellenaTabla($maquina)
{
	for($i=0;$i<count($maquina->Estados);$i++)
	{
		for($j=0;$j<count($maquina->Estados);$j++)
		{
			if(incompatibles($maquina,$maquina->Estados[$i],$maquina->Estados[$j])==true)
			{
				$maquina->Tabla[$i][$j]=0;
			}
			else
			{
				$maquina->Tabla[$i][$j]='x';
			}
		}
	}
}

function setRES($aux,$res,$columna,$tabla)
{
	$s=array();
	for($m=0;$m<count($res[0]);$m++)
	{
		array_push($s,'#');
	}
	if($columa[0]=='#')
	{
		if(count(columna)==1)
		{
			if(existeE($res,$columna)==false)
			{
				array_push($res,$s);
			}
		}
	}
	else
	{
		if(existeE($res,$columna)!=true)
		{
			opE($aux,$columna,$res,$tabla);
			array_push($res,$aux);
		}
	}
}
function inicializacionRes($res,$tabla)
{
	$r=array();
	array_push($r,'&');
	for($t=0;$t<count($tabla[0]);$t++)
	{
		if($tabla[0][$t]!='Ɛ')
		{
			array_push($res,$r);
		}
	}
}
function existeE($res,$estado)
{
	$cont=0;
	for($i=1;$i<count($res);$i++)
	{
		if(count($res[$i][0])==count($estado))
		{
			for($j=0;$j<count($estado);$j++)
			{
				for($c=0;c<count($res[$i][0]);$c++)
				{
					if($res[$i][0][$c]==$estado[$j])
					{
						$cont=$cont+1;
					}
				}
			}
			if($cont==count($estado))
			{
				return true;
			}
		}
	}return false;
}
function opE($aux,$auxe,$res,$tabla)
{
	$ep=0;
	for($y=1;$y<count($tabla[0]);$y++)
	{
		if($tabla[0][$y]=='Ɛ')
		{
			$ep=$y;
		}
	}
	for($j=1;$j<count($tabla[0]);$j++)
	{
		for($i=1;$i<strlen($res[0]);$i++)
		{
			if($tabla[0][$j]==$res[0][$i])
			{
				$auxop=array();
				for($k=1;$k<count($tabla);$k++)
				{
					for($l=0;$l<count($auxe);$l++)
					{
						if($tabla[$k][0]==$auxe[$l])
						{
							for($c=0;$c<count($tabla[$k][$j]);$c++)
							{
								for($g=1;$g<count($tabla);$g++)
								{
									if($tabla[$g][0]==$tabla[$k][$j])
									{
										if($tabla[$g][$ep][0]!='0')
										{
											for($f=0;$f<count($tabla[$g][$ep]);$f++)
											{
												array_push($auxop,$tabla[$g][$ep][$f]);
											}
										}
									}
								}
								if(existeC($auxop,$tabla[$k][$j][$c])!=0)
								{
									if($tabla[$k][$j][$c]!='0')
									{
										array_push($auxop,$tabla[$k][$j][$c]);
									}
									else
									{
										if(count($auxop)==0)
										{
											array_push($auxop,'#');
										}
									}
								}

							}
						}
					}
				}
				array_push($aux,$auxop);
			}
		}
	}
}
function transformacion($maquina1)
{
	$maquinaf=new Maquina;
	$a=null;
	$aux=array();
	$auxe=array();
	$auxop=array();
	$res=array();
	$tabla=tablatransic($maquina1);
	print_r($tabla);
	array_push($auxe,$maquina1->Est_Inicial);
	$a=$auxe;
	for($a=1;$a<strlen($maquina1->Caracteres);$a++)
	{
		if($tabla[0][$a]=='Ɛ')
		{
			for($b=1;$b<count($tabla)-1;$b++)
			{
				for($c=0;$c<count($tabla[$b][$a]);$c++)
				{

					if($tabla[$b][$a]!=['0'])
					{
						array_push($auxe,$tabla[$b][$a][$c]);
						$a=$a+$tabla[$b][$a];
					}
				}
			}
		}
	}array_push($aux,$auxe);
	$maquinaf->Est_Inicial=$a;
	inicializacionRes($res,$tabla);
	opE($aux,$auxe,$res,$tabla);
	array_push($res,$aux);
	$cont=0;



	for($e=1;$e<count($res);$e++)
	{
		for($y=1;$y<count($res[0]);$y++)
		{
			if(existeE($res,$res[$e][$y])==false)
			{
				$aux=array();
				array_push($aux,$res[$e][$y]);
				setRES($aux,$res,$res[$e][$y],$tabla);
			}
		}
	}$fin=array();



	for($i=1;$i<count($res);$i++)
	{
		$cont=0;
		$aux=$res[0];
		$string=$res[$i][0][0];
		for($l=1;$l<count($res[$i][0]);$l++)
		{
			$string=$res[$i][0][$l].$string;
			for($t=0;$t<count($maquina1->Est_Final);$t++)
			{
				if($res[$i][0][$l]==$maquina1->Est_Final[$t] || $res[$i][0][0]==$maquina1->Est_Final[$t])
				{
					$cont=1;
				}
			}
		}
		if($cont==1)
		{
			array_push($fin,$string);
		}
		setEstados($maquinaf,$string);
		for($y=1;$y<count($aux);$y++)
		{
			$op=$aux[$y];
			$tran=$res[$i][$y][0];
			for($h=1;$h<count($res[$i][$y]);$h++)
			{
				$tran=$res[$i][$y][$h]+$tran;
			}
			setOpciones($maquinaf,$string,$op,$tran);
		}

	}$maquinaf->Est_Final=$fin;

	return $maquinaf;

}
?>