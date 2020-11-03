class Persona {
    constructor(nombre, edad){
        this._nombre = nombre;
        this._edad = edad;
    }

    get nombre(){
        return this._nombre;
    }

    get edad(){
        return this._edad;
    }

    toString(){
        console.log(this.nombre);
        console.log(this.edad);
        return "Hola! mi nombre es " + this._nombre + " y tengo " + this._edad + " anos";
    }
}

module.exports = Persona;
