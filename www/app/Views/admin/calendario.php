<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<div class="container">
    <h1>Calendario de Avisos</h1>
    <div id="calendario" style="margin-top:20px;"></div>
</div>

<script>
const avisos = <?= json_encode($avisos) ?>;

document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendario');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: avisos.map(function(aviso) {
            return {
                title: aviso.tipo_servicio + ' - ' + aviso.codigo,
                start: aviso.fecha,
                color: aviso.urgencia === 'urgente' ? '#e74c3c' : '#27ae60',
                extendedProps: {
                    descripcion: aviso.descripcion,
                    direccion: aviso.direccion,
                    telefono: aviso.telefono,
                    estado: aviso.estado,
                    urgencia: aviso.urgencia
                }
            };
        }),
        eventClick: function(info) {
            const p = info.event.extendedProps;
            alert(
                'Código: ' + info.event.title +
                '\nDescripción: ' + p.descripcion +
                '\nDirección: ' + p.direccion +
                '\nTeléfono: ' + p.telefono +
                '\nEstado: ' + p.estado +
                '\nUrgencia: ' + p.urgencia
            );
        }
    });
    calendar.render();
});
</script>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>