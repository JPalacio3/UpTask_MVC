
(function () {


    // Boton para mostrar el Modal de agregar tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click',function () { mostrarFormulario() });

    function mostrarFormulario() {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
<form class="formulario nueva-tarea">
<legend>Añade una Nueva Tarea</legend>
<div class="campo">
<label>Tarea: </label>
<input
type="text"
name="tarea"
placeholder="Añadir Tarea al Proyecto Actual"
id="tarea"
/>
</div>

<div class="opciones">
<input type="submit" class="submit-nueva-tarea" value="Añadir Tarea" />
<button type="button" class="cerrar-modal">Cancelar</button>
</div>
</form>
`;

        setTimeout(() => {
            const formulario = document.querySelector('.formulario');
            formulario.classList.add('animar');
        },200);

        modal.addEventListener('click',function (e) {
            e.preventDefault();

            if (e.target.classList.contains('cerrar-modal')) {
                const formulario = document.querySelector('.formulario');
                formulario.classList.add('cerrar');
                setTimeout(() => {
                    modal.remove();
                },200);
            }

            if (e.target.classList.contains('submit-nueva-tarea')) {

                submitFormularioNuevaTarea();
            }

        });


        document.querySelector('.dashboard').appendChild(modal);

    }

    function submitFormularioNuevaTarea() {

        const nombreTarea = document.querySelector('#tarea').value.trim();

        if (nombreTarea === '') {
            // Mostrar una alerta de error
            mostrarAlerta('El Nombre de la tarea es Obligatorio','error',document.querySelector('.formulario legend'));
            return;
        } else {
            agregarTarea(nombreTarea);
        }

    }

    // Muestra un mensaje en la interfaz
    function mostrarAlerta(mensaje,tipo,referencia) {

        //Prevenir la creación de múltiples tareas
        const alertaPrevia = document.querySelector('.alerta');

        if (alertaPrevia) { alertaPrevia.remove(); }

        const alerta = document.createElement('DIV');
        alerta.classList.add('alerta',tipo);
        alerta.textContent = mensaje;

        // Inserta la alerta antes del legend
        referencia.parentElement.insertBefore(alerta,referencia.nextElementSibling);

        // Eliminar la alerta después de 2segundos
        setTimeout(() => {
            alerta.remove();
        },2000);

    }

    // Consultar el servidor para añadir una nueva tarea al proyecto actual
    async function agregarTarea(tarea) {
        // Construir la petición
        const datos = new FormData();
        datos.append('nombre',tarea);
        datos.append('proyectoId',obtenerProyecto());

        try {
            const url = 'http://localhost:6969/api/tarea';
            const respuesta = await fetch(url,{
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();

            // Mostrar una alerta de error
            mostrarAlerta(resultado.mensaje,resultado.tipo,document.querySelector('.formulario legend'));
            if (resultado.tipo === 'exito') {
                const modal = document.querySelector('.modal');

                setTimeout(() => {
                    modal.remove();
                },1800);


            }

        } catch (error) {
            console.log(error);
        }
    }



    function obtenerProyecto() {
        const proyectoParams = new URLSearchParams(window.location.search);
        const proyecto = Object.fromEntries(proyectoParams.entries());
        return proyecto.id;

    }
})();
