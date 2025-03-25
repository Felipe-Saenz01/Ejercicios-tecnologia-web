document.getElementById('formulario').addEventListener('submit', function(e){
    e.preventDefault();
    var datos = new FormData(document.getElementById('formulario'));
    fetch('./demo.php', {
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            document.getElementById('respuesta').innerHTML = "Credenciales correctas, Bienvenido";
        }else{
            document.getElementById('respuesta').innerHTML = "Credenciales Incorrectas";
        }
    })
});