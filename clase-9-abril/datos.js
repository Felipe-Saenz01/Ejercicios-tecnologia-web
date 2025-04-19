document.addEventListener('DOMContentLoaded', function() {
    // Selecciona todos los inputs cuya clase es nota
    const inputsNotas = document.querySelectorAll('.nota');
    
    // Agrega event listener a cada input
    inputsNotas.forEach(input => {
        input.addEventListener('input', calcularNotaFinal);
    });
    
    function calcularNotaFinal() {
        // Obtiene el número de estudiante del atributo data
        const estudianteId = this.getAttribute('estudiante');
        // console.log(estudianteId);
        // console.log(document.querySelector(`.nota[estudiante="${estudianteId}"][num-nota="1"]`));
        // Selecciona los 3 inputs de notas para este estudiante
        const nota1 = parseFloat(document.querySelector(`.nota[estudiante="${estudianteId}"][num-nota="1"]`).value) || 0;
        const nota2 = parseFloat(document.querySelector(`.nota[estudiante="${estudianteId}"][num-nota="2"]`).value) || 0;
        const nota3 = parseFloat(document.querySelector(`.nota[estudiante="${estudianteId}"][num-nota="3"]`).value) || 0;
        
        // Calcula el promedio (puedes modificar la fórmula según tus necesidades)
        const promedio = ((nota1 + nota2 + nota3) / 3).toFixed(1);
        
        // Actualiza el campo Final
        const inputFinal = document.querySelector(`.final[estudiante="${estudianteId}"]`);
        inputFinal.value = promedio;
    }
});