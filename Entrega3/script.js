document.addEventListener('DOMContentLoaded', () => {
    const submitRunForm = document.getElementById('submit-run-form');
    const loadRunsBtn = document.getElementById('load-runs-btn');
    const leaderboardBody = document.getElementById('leaderboard-body');

    // Variable para controlar el Modal de Bootstrap
    let editModalInstance;
    const editModalElement = document.getElementById('editModal');
    if (editModalElement) {
        editModalInstance = new bootstrap.Modal(editModalElement);
    }

    // --- LEER (READ) ---
    const fetchAndDisplayRuns = async () => {
        try {
            const response = await fetch('listar_runs.php');
            const runs = await response.json();
            
            leaderboardBody.innerHTML = '';
            
            if (runs.length === 0) {
                leaderboardBody.innerHTML = '<tr><td colspan="4" class="text-center">No hay records aún.</td></tr>';
                return;
            }

            runs.forEach(run => {
                const row = document.createElement('tr');
                
                // Botón Ver
                let buttonsHtml = `<a href="${run.video_link}" target="_blank" class="btn btn-sm btn-outline-info me-1">Ver</a>`;
                
                // Botones Editar y Eliminar (SOLO Dueño)
                if (typeof currentUserId !== 'undefined' && currentUserId !== null && parseInt(run.user_id) === currentUserId) {
                    // Pasamos los datos "escapados" para evitar errores de comillas
                    const runData = JSON.stringify(run).replace(/"/g, '&quot;');
                    buttonsHtml += `
                        <button class="btn btn-sm btn-warning me-1" onclick="openEditModal(${runData})">✏️</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteRun(${run.id})">🗑️</button>
                    `;
                }

                row.innerHTML = `
                    <td>${run.game}<br><small class="text-muted">${run.category}</small></td>
                    <td>${run.nickname}</td>
                    <td class="fw-bold">${run.time_record}</td>
                    <td>${buttonsHtml}</td>
                `;
                leaderboardBody.appendChild(row);
            });

        } catch (error) {
            console.error('Error:', error);
        }
    };

    // --- ELIMINAR (DELETE) ---
    window.deleteRun = async (id) => {
        const confirm = await Swal.fire({
            title: '¿Borrar Run?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí, borrar'
        });

        if (confirm.isConfirmed) {
            try {
                const res = await fetch('eliminar_run.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ id: id })
                });
                const data = await res.json();
                
                if (data.status === 'success') {
                    Swal.fire('¡Eliminado!', data.message, 'success');
                    fetchAndDisplayRuns();
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            } catch (e) {
                Swal.fire('Error', 'Fallo de conexión', 'error');
            }
        }
    };

    // --- PREPARAR EDITAR (Abrir Modal) ---
    window.openEditModal = (run) => {
        // Llenamos el formulario del modal con los datos actuales
        document.getElementById('edit_id').value = run.id;
        document.getElementById('edit_game').value = run.game;
        document.getElementById('edit_category').value = run.category;
        document.getElementById('edit_time').value = run.time_record;
        document.getElementById('edit_video').value = run.video_link;
        
        // Mostramos el modal
        editModalInstance.show();
    };

    // --- GUARDAR EDICIÓN (UPDATE) ---
    window.saveEdit = async () => {
        const id = document.getElementById('edit_id').value;
        const game = document.getElementById('edit_game').value;
        const category = document.getElementById('edit_category').value;
        const time = document.getElementById('edit_time').value;
        const video = document.getElementById('edit_video').value;

        try {
            const response = await fetch('actualizar_run.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    id: id,
                    game: game,
                    category: category,
                    time_record: time,
                    video_link: video
                })
            });
            const result = await response.json();

            if (result.status === 'success') {
                Swal.fire('Actualizado', 'Los datos se guardaron correctamente.', 'success');
                editModalInstance.hide(); // Cerrar modal
                fetchAndDisplayRuns();    // Refrescar tabla
            } else {
                Swal.fire('Error', result.message, 'error');
            }
        } catch (error) {
            console.error(error);
            Swal.fire('Error', 'No se pudo conectar con el servidor.', 'error');
        }
    };

    // --- CREAR (CREATE) ---
    if (submitRunForm) {
        submitRunForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(submitRunForm);

            try {
                const response = await fetch('registrar_run.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.status === 'success') {
                    Swal.fire('¡Éxito!', result.message, 'success');
                    submitRunForm.reset();
                    fetchAndDisplayRuns();
                } else {
                    Swal.fire('Error', result.message, 'error');
                }
            } catch (error) {
                console.error(error);
            }
        });
    }

    if (loadRunsBtn) loadRunsBtn.addEventListener('click', fetchAndDisplayRuns);
    
    // Carga inicial
    fetchAndDisplayRuns();
});