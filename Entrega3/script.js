// - Código JS externo: Todo el código está en este archivo, referenciado una vez.
// - Manejador de eventos: Se usa 'DOMContentLoaded' para asegurar que el DOM esté listo.
// - 3 Eventos con addEventListener(): Se manejan 'submit' del formulario y 'click' del botón de carga.
// - 3 Funciones (2 con 2+ params, 2 con 'this'): Se implementan las funciones requeridas.
// - console.log(): Cada función incluye un console.log para depuración.

document.addEventListener('DOMContentLoaded', () => {

    // Selectores de elementos del DOM
    const submitRunForm = document.getElementById('submit-run-form');
    const loadRunsBtn = document.getElementById('load-runs-btn');
    const leaderboardBody = document.getElementById('leaderboard-body');
    const notificationArea = document.getElementById('notification-area');

    /**
     * Muestra una notificación al usuario en el área designada.
     * @param {string} message - El mensaje a mostrar.
     * @param {string} type - El tipo de notificación ('success' o 'error').
     */
    const displayNotification = (message, type) => {
        console.log(`Mostrando notificación: [${type}] ${message}`);
        
        notificationArea.innerHTML = `<div class="notification ${type}">${message}</div>`;
        
        setTimeout(() => {
            notificationArea.innerHTML = '';
        }, 5000);
    };

    /**
     * Se activa al hacer clic en un botón de acción de una fila de la tabla.
     * @param {HTMLElement} buttonElement - El elemento botón que fue clickeado.
     * @param {object} runData - Los datos completos del speedrun asociado a esa fila.
     */
    const showRunDetails = (buttonElement, runData) => {
        console.log("Mostrando detalles para el run ID:", runData.id);
        console.log("Elemento 'this' recibido:", buttonElement);
        
        const details = `
            Juego: ${runData.game}
            Jugador: ${runData.nickname}
            Tiempo: ${runData.time_record}
            Video: ${runData.video_link}
        `;
        alert(details);
    };

    /**
     * FETCH para obtener los speedruns desde el servidor y mostrarlos en la tabla.
     */
    const fetchAndDisplayRuns = async () => {
        console.log('Iniciando fetch para obtener runs...');
        
        try {
            const response = await fetch('listar_runs.php');
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            const runs = await response.json();
            
            leaderboardBody.innerHTML = '';

            if (runs.length === 0) {
                leaderboardBody.innerHTML = '<tr><td colspan="5">Aún no hay speedruns registrados. ¡Sé el primero!</td></tr>';
            } else {
                runs.forEach(run => {
                    const row = document.createElement('tr');
                    
                    row.innerHTML = `
                        <td>${run.game}</td>
                        <td>${run.nickname}</td>
                        <td>${run.category}</td>
                        <td>${run.time_record}</td>
                        <td><button class="btn-small">Ver Video</button></td>
                    `;

                    const detailButton = row.querySelector('.btn-small');
                    detailButton.addEventListener('click', function() {
                        showRunDetails(this, run);
                    });

                    leaderboardBody.appendChild(row);
                });
            }
        } catch (error) {
            console.error('Error al cargar los runs:', error);
            displayNotification('No se pudieron cargar los datos del leaderboard.', 'error');
        }
    };
    
    // Maneja el envío del formulario para registrar un nuevo speedrun.
    submitRunForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        console.log('Formulario de registro enviado.');

        const formData = new FormData(submitRunForm);

        try {
            const response = await fetch('registrar_runs.php', { // ← CORREGIDO AQUÍ
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.status === 'success') {
                displayNotification(result.message, 'success');
                submitRunForm.reset();
                fetchAndDisplayRuns();
            } else {
                displayNotification(result.message, 'error');
            }

        } catch (error) {
            console.error('Error al enviar el formulario:', error);
            displayNotification('Ocurrió un error de red. Inténtalo de nuevo.', 'error');
        }
    });

    loadRunsBtn.addEventListener('click', fetchAndDisplayRuns);

    // Evento extra para cumplir la pauta (mouseover)
    const logo = document.getElementById('logo');
    logo.addEventListener('mouseover', () => {
        console.log("Mouse sobre el logo.");
        logo.style.opacity = '0.8';
    });
    logo.addEventListener('mouseout', () => {
        logo.style.opacity = '1';
    });

    // Carga inicial
    fetchAndDisplayRuns();
});