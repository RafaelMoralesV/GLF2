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
  this.tabla = [ ];
  this.reducido=[ ]; //contiene estados de la maquina reducida
  this.eliminados=[];
}
//---revisar si estado inicial es final entonces recibe palabra vacia, designar como no reconocida si sucede lo contrario
//--revisar si al terminar posicion corresponde a est_final, si no designar como desconosido
//--revisar el string para saber si solo tiene los caracteres definidos
//--revisar que cada estado tenga opciones sin  repetir

function setEstados(maquina,caracter){ //crea los estados
  var aux=new estado();
  aux.setCaracter(caracter);
  maquina.estados.push(aux);
  var aux2=[ ];
  maquina.tabla.push(aux2); //crea tabla nxn
}

function inicializarTabla(maquina){
  for(var i=0;i<maquina.estados.length;i++){ //llena de 0 la tabla segun cantidad de estados (nxn)
    for(var j=0;j<maquina.estados.length;j++){
      maquina.tabla[i][j]=0;
      maquina.tabla[i][i]='x'; //ya que la diagonal no se utiliza se rellena de 1
    }
  }
}

function setEstadoInicial(maquina,ini){  //almacena el nombre de estado inicial
  maquina.est_inicial=ini;
  maquina.posicion=ini; //inicia posicion en el inicio
}

function setEstadosFinales(maquina,fin){ //almacena solo los nombres de los estados finales
  maquina.est_final.push(fin);
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

function transicion(maquina,nodo,op){ // nodo -> nombre del estado  /  op -> opcion realizada  // retorna el nombre del nodo al que se dirige
  for(var i=0;i<maquina.estados.length;i++){
    if(maquina.estados[i].caracter==nodo){ //busca el estado entre todos
      for(var j=0;j<maquina.estados[i].opciones.length;j++){ //al encontrarlo busca entre las opciones a op
        if(maquina.estados[i].opciones[j]==op){
          return maquina.estados[i].nomb_estados[j]; //al encontrarlo retorna el nombre del estado al que corresponde
        }
      }
    }
  }
}

function showMaquina(maquina){  //muestra todos los datos de la maquina
    console.log(maquina);
}

function showEstados(maquina){ //muestra los datos de los estados
  console.log(maquina.estados);
}

function recorrer(maquina,string){ //a partir del string llega al estado final
  for(var i=0;i<string.length;i++){
     var a=transicion(maquina,maquina.posicion,string[i]);
     maquina.posicion=a;
     maquina.camino.push(a); //almacena cada estado por el que pasa en el array camino
  }
}

function validarString(maquina,string)
{ //demuestra que es AFD -- retorna 0 si es invalido el string , 1 en el caso contrario
  var aux=0; var aux2=1;
  for(var i=0; i<string.length;i++)
  { //recorre string
    for(var j=0;j<maquina.estados.length;j++)
    { //recorre cada estado
      for(var k=0;k<maquina.estados[j].opciones.length;k++)
      { //para recorrer las opciones de cada estado
        if(string[i]==maquina.estados[j].opciones[k] )
        {
            aux=1; //si alguna de las opciones de cada estado es igual retorna
        }
      }
      if(aux==0)
      { //al terminar de comparar una letra revisa si fue igual a alguna opcion
         aux2=0;  // si compara las opciones de un estado y no es igual a ninguna aux2=0
      }
      aux=0; //reinicia al revisar las opciones
    }
  }
   return aux2;
}

function incompatibles(maquina,nod1,nod2)
{ //retorna true si 2 estados son incompatibles --
   if(nod1.caracter==nod2.caracter)
   {
    return true;
   } // true, estaria comparando un estado con si mismo por lo cual no se pueden trabajar como equivalentes
   for(var i=0; i<maquina.est_final.length;i++)
   { //recorre estados finales
      if(nod1.caracter==maquina.est_final[i])
      {
        return true;
      } //si nod1 es estado final, es incompatible con todos
      if(nod2.caracter==maquina.est_final[i])
      {
        return true;
      }   //si nod2 es estado final, es incompatible con todos
   }
   for(var i=0; i<nod1.nomb_estados.length;i++)
   { //compara opciones
     for(var j=0; j<nod1.nomb_estados.length;j++)
     {
         if(nod1.opciones[i]==nod2.opciones[j])
         {
             if(nod1.nomb_estados[i]!=nod2.nomb_estados[j])
             { //si son iguales, no hay info
                  for(var k=0; k<maquina.est_final.length;k++)
                  {
                      if(nod1.nomb_estados[i]==maquina.est_final[k] || nod2.nomb_estados[j]==maquina.est_final[k])
                        {
                          return true;
                        }
                  }
              }
          }
      }
   }
}

function tablaEstados(maquina){ //simplifica, agrega segun corresponda a el arreglo reducido
  inicializarTabla(maquina);
  for(var i=0; i<maquina.estados.length;i++){
    for(var j=0; j<maquina.estados.length;j++){
      //console.log(maquina.estados[i].caracter,' a',maquina.estados[j].caracter)
      if((incompatibles(maquina,maquina.estados[i],maquina.estados[j]))!=true){ //si son equivalentes
        //console.log(maquina.estados[i].caracter,' ',maquina.estados[j].caracter)
        if(maquina.estados[i].caracter==maquina.est_inicial )
        { // si el nodo1 es estado inicial, se agrega nodo2
               redirigir(maquina,maquina.estados[i],maquina.estados[i]);
               ExisteAgregar(maquina,maquina.estados[j]);
        }
        else{
          for(var q=0;q<maquina.reducido.length;q++){ //equivalentes
            if(maquina.reducido[q].caracter!=maquina.estados[i].caracter){
                 if(existe(maquina.reducido,maquina.estados[j])!=0){
                   redirigir(maquina,maquina.estados[j],maquina.estados[i]); //redurije los que entran a j
                   ExisteAgregar(maquina,maquina.estados[i]);
                 }
            }
          }
        }
      }
      else{
        maquina.tabla[i][j]='x'; //rellena la tabla los estados no equivalentes
        for(var k=0;k<maquina.est_final.length;k++){ //agrega estados finales ya que no son reducibles
        if(maquina.estados[i].caracter==maquina.est_final[k]){
          ExisteAgregar(maquina,maquina.estados[i]);
        }
      }
    }
  }
}
}

function redirigir(maquina,estado1,estado2){
  for(var u=0;u<maquina.estados.length;u++){  //busca en el automata si tienen coneccion con el nodo1, para redirigir
    for(var t=0;t<maquina.estados[u].nomb_estados.length;t++){
     if(maquina.estados[u].nomb_estados[t]==estado1.caracter){
      maquina.estados[u].nomb_estados[t]=estado2.caracter;
     }
   }
  }
}

function ExisteAgregar(maquina,estado){ //revisa si ya fue agregado un estado a reducido, si no lo fue lo agrega
  var aux=0;
  for(var i=0;i<maquina.reducido.length;i++){
    if(estado.caracter==maquina.reducido[i].caracter){
      aux=1;
    }
  }
  if(aux==0){
    maquina.reducido.push(estado);
  }
  else{
    return 1;
  }
}

function existe(lista,estado){
  for(var i=0;i<lista.length;i++){
    if(estado.caracter==lista[i].caracter){
      return 0;
    }
  }
  return;
}

var aux=new maquina();
setEstadoInicial(aux,'5');
setEstadosFinales(aux,'1');
setEstados(aux,'5');
setEstados(aux,'4');
setEstados(aux,'3');
setEstados(aux,'2');
setEstados(aux,'1');
setOpciones(aux,'5','b','3');
setOpciones(aux,'5','a','4');
setOpciones(aux,'4','a','4');
setOpciones(aux,'4','b','2');
setOpciones(aux,'3','b','1');
setOpciones(aux,'3','a','4');
setOpciones(aux,'2','a','4');
setOpciones(aux,'2','b','1');
setOpciones(aux,'1','a','1');
setOpciones(aux,'1','b','1');
showEstados(aux); //muestra automata completo
//recorrer(aux,'abaa');
tablaEstados(aux);
console.log(aux.tabla) //muestra tabla de estados distinguibles
console.log(aux.reducido); //muestra el automata reducido
//crear funcion para asignar posicion a estado segun corresponda (de ser necesario)
