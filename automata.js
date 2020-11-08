function estado(){
  this.caracter = null; //nombre del estado
  this.opciones = [ ]; //conecciones a los estados
  this.nomb_estados = [ ]; //noombres de los estados segun opciones
}

estado.prototype.setCaracter = function(value){
  this.caracter= value;
}

function maquina(){
  this.estados = [ ]; //  (K)  conjunto de estados existentes -- tipo estado
  this.caracteres = [ ]; //  (Σ) alfabeto de entrada para funcionamiento
  this.est_inicial = null; // (s) estado inicial - inicio por defecto al inciar la maquina
  this.est_final = [ ]; // (F) estados finales a los que se pueden llegar

  this.camino = [ ]; //camino recorrido por los carateres  -- puede ser variable global
  this.posicion = null; //posicion actual o final al recorrer el string -- puede ser variable global


}
//---revisar si estado inicial es final entonces recibe palabra vacia, designar como no reconocida si sucede lo contrario
//--revisar si al terminar posicion corresponde a est_final, si no designar como desconosido
//--revisar el string para saber si solo tiene los caracteres definidos

function setEstados(maquina,caracter){ //crea los estados
  var aux=new estado();
  aux.setCaracter(caracter);
  maquina.estados.push(aux);
}

function setOpciones(maquina,c,op,est){ //agrega a maquina la opcion 'op' de 'c' hacia 'est'
  for(var i=0; i<maquina.estados.length;i++){
    if(maquina.estados[i].caracter==c){
      maquina.estados[i].opciones.push(op);
      maquina.estados[i].nomb_estados.push(est);
      break;
    }
  }
}

function showMaquina(maquina){  //muestra todos los datos de la maquina
    console.log(maquina);
}

function showEstados(maquina){ //muestra los datos de los estados
  console.log(maquina.estados);
}

var aux=new maquina();
setEstados(aux,'q0');
setEstados(aux,'q1');
setEstados(aux,'q2');
setOpciones(aux,'q0','b','q1');
setOpciones(aux,'q0','a','q2');
setOpciones(aux,'q1','a','q1');
setOpciones(aux,'q1','b','q1');
setOpciones(aux,'q2','b','q1');
setOpciones(aux,'q2','a','q0');

showEstados(aux);
//crear funcion para asignar valores al estado est_inicial
//crear funcion para rellenar los estados existentes
//crear funcion para asignar los estados finales
//crear funcion para asingar posicion a posicion inicial
//crear funcion para asignar posicion a estado segun corresponda (de ser necesario)
//funcion transicion (a partir de un estado moverse a un caracter utilizando posicion)
