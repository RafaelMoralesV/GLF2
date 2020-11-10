<?php 
class Estado 
{

	public $Nombre;//Nombre de estado/Etiqueta
	public $TransEt=array();//Arreglo que contiene los estados que se une
	public $TransEs=array();//Arreglo que contiene la transicion de los estados de arriba
	public $EsFinal;//Probando si unserializando se mantiene el bool
	public $Inicial;//Same
	
	public function setNombre($e)
	{
		$this->Nombre=$e;
	}
	public function addEt($e)
	{
		$this->TransEt[sizeof($this->TransEt)]=$e;
	}
	public function addEs($e)
	{
		$this->TransEs[sizeof($this->TransEs)]=$e;
	}
	public function setInicial()
	{
		$this->Inicial=true;
	}
	public function setFinal($e)
	{
		$this->EsFinal=$e;
	}
	public function getFinal()
	{
		return $this->EsFinal;
	}
	public function getNombre()
	{
		return $this->Nombre;
	}
	
} 
class Automata
{
	public $CantStates;//Cantidad de estados que posee el automata
	public $States=array(); //Arreglo de clase estados
	public $Alfabeto; //Alfabeto :v
	public $EFinales=array();//Array con las etiquetas finales (Desconozco si será worth tenerla, pero por siacaso)
	public $Begin;//Conocer cual es el estado default.
	public function setFinales() //Funcion para guardar los finales en $EFinales
	{
		for($i=0;$i<$this->CantStates;$i++)
		{
			if($States[$i].getFinal()==true)
			{
				$this->EFinales[sizeof($this->Efinales)]=$States[$i].getNombre();
			}
		}
	}
	public function setCant($e) 
	{
		$this->CantStates=$e;
	}
	public function setBegin($e) //Guardar en el automata el nombre del estado defualt y llenar el primer slot del array d States
	{
		$aux=unserialize($e);
		$this->Begin=$aux[0];
		$this->States[0].setNombre($aux[0]);
		$this->States[0].setInicial();
		$this->States[0].setFinal($aux[1]);
	}
	public function setAlfabeto($e)//Copypastear el alfabeto
	{
		$aux = unserialize($e);
		for($i=0;$i<sizeof($aux);$i++)
		{
			$this->Alfabeto[$i]=$aux[$i];
		}
	}
	public function setStates($e) //Añadir todos los estados/etiquetade stados ingresados por el usuario
	{
		$aux = unserialize($e);
		for ($i=0;$i<sizeof($aux);i+2)
		{
			$this->States[$i+1].setNombre($aux[$i]);
			$this->States[$i+2].setFinal($aux[$i+1]);
		}
	}
	///q1-a-q2-q2-a-q1-q1-b-q2-q2-b-q1
	public function setTransiciones($e)//Seteando las transiciones y estados a los que se transicionan
	{
		$aux=unserialize($e);
		for($i=0;$i<sizeof($e);$i+3)
		{
			for($j=0;$j<sizeof($this->States);$j++)
			{
				if($aux[$i]==$this->States[$j])
				{
					$this->States[$j].addEt($aux[$i+1]);
					$this->States[$j].addEs($aux[$i+2]);
				}
			}
		}
	}
}
?>