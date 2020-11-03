const aux = require("./aux.js");
let persona = new aux("Rafael", 21);

var http = require('http');

const server = http.createServer((req, res) => {
    res.statusCode = 200;
    res.setHeader('Content-Type', 'text/plain');
    res.end(persona.toString());
});

server.listen(3000, () => {
    console.log("Server inicializado en localhost:3000");
});
