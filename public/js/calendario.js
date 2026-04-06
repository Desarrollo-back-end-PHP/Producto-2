document.addEventListener('DOMContentLoaded', () => {
    let vista = 'mensual';
    let fecha = new Date();

    const container = document.getElementById('calendario');

    function render() {
        container.innerHTML = '';
        const tabs = document.createElement('div');
        tabs.className = 'cal-tabs';
        ['mensual','semanal','diaria'].forEach(v => {
            const btn = document.createElement('button');
            btn.textContent = v.charAt(0).toUpperCase() + v.slice(1);
            if (v === vista) btn.classList.add('active');
            btn.onclick = () => { vista = v; render(); };
            tabs.appendChild(btn);
        });
        container.appendChild(tabs);

        if (vista === 'mensual') renderMensual();
        else if (vista === 'semanal') renderSemanal();
        else renderDiaria();
    }

    function renderMensual() {
        const year = fecha.getFullYear();
        const month = fecha.getMonth();
        const header = document.createElement('div');
        header.className = 'cal-header';
        header.innerHTML = `
            <button onclick="cambiarMes(-1)">&#8592;</button>
            <strong>${fecha.toLocaleString('es', {month:'long', year:'numeric'})}</strong>
            <button onclick="cambiarMes(1)">&#8594;</button>`;
        container.appendChild(header);

        window.cambiarMes = (dir) => { fecha.setMonth(fecha.getMonth() + dir); render(); };

        const grid = document.createElement('div');
        grid.className = 'cal-grid';
        ['Lun','Mar','Mie','Jue','Vie','Sab','Dom'].forEach(d => {
            const dn = document.createElement('div');
            dn.className = 'cal-day-name';
            dn.textContent = d;
            grid.appendChild(dn);
        });

        const firstDay = new Date(year, month, 1);
        const lastDay  = new Date(year, month + 1, 0);
        let startDow = firstDay.getDay(); // 0=Dom
        startDow = startDow === 0 ? 6 : startDow - 1;

        for (let i = 0; i < startDow; i++) {
            const empty = document.createElement('div');
            empty.className = 'cal-day other-month';
            grid.appendChild(empty);
        }

        for (let d = 1; d <= lastDay.getDate(); d++) {
            const dayEl = document.createElement('div');
            dayEl.className = 'cal-day';
            const hoy = new Date();
            if (d === hoy.getDate() && month === hoy.getMonth() && year === hoy.getFullYear())
                dayEl.classList.add('today');

            const num = document.createElement('small');
            num.textContent = d;
            dayEl.appendChild(num);

            const dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
            avisos.filter(a => a.fecha && a.fecha.startsWith(dateStr)).forEach(a => {
                dayEl.appendChild(crearEvento(a));
            });
            grid.appendChild(dayEl);
        }
        container.appendChild(grid);
    }

    function renderSemanal() {
        const lunes = new Date(fecha);
        const dow = lunes.getDay() === 0 ? 6 : lunes.getDay() - 1;
        lunes.setDate(lunes.getDate() - dow);

        const header = document.createElement('div');
        header.className = 'cal-header';
        header.innerHTML = `
            <button onclick="cambiarSemana(-1)">&#8592;</button>
            <strong>Semana del ${lunes.toLocaleDateString('es')}</strong>
            <button onclick="cambiarSemana(1)">&#8594;</button>`;
        container.appendChild(header);

        window.cambiarSemana = (dir) => { fecha.setDate(fecha.getDate() + dir * 7); render(); };

        const grid = document.createElement('div');
        grid.className = 'cal-grid';
        for (let i = 0; i < 7; i++) {
            const day = new Date(lunes);
            day.setDate(lunes.getDate() + i);
            const dayEl = document.createElement('div');
            dayEl.className = 'cal-day';
            dayEl.style.minHeight = '120px';
            const dateStr = day.toISOString().split('T')[0];
            dayEl.innerHTML = `<small>${day.toLocaleDateString('es',{weekday:'short',day:'numeric'})}</small>`;
            avisos.filter(a => a.fecha && a.fecha.startsWith(dateStr)).forEach(a => dayEl.appendChild(crearEvento(a)));
            grid.appendChild(dayEl);
        }
        container.appendChild(grid);
    }

    function renderDiaria() {
        const header = document.createElement('div');
        header.className = 'cal-header';
        header.innerHTML = `
            <button onclick="cambiarDia(-1)">&#8592;</button>
            <strong>${fecha.toLocaleDateString('es',{weekday:'long',day:'numeric',month:'long',year:'numeric'})}</strong>
            <button onclick="cambiarDia(1)">&#8594;</button>`;
        container.appendChild(header);

        window.cambiarDia = (dir) => { fecha.setDate(fecha.getDate() + dir); render(); };

        const dateStr = fecha.toISOString().split('T')[0];
        const dayAvisos = avisos.filter(a => a.fecha && a.fecha.startsWith(dateStr));
        const card = document.createElement('div');
        card.className = 'card';
        if (dayAvisos.length === 0) {
            card.innerHTML = '<p>No hay avisos para este dia.</p>';
        } else {
            dayAvisos.forEach(a => card.appendChild(crearEvento(a)));
        }
        container.appendChild(card);
    }

    function crearEvento(a) {
        const ev = document.createElement('div');
        ev.className = `cal-event ${a.urgencia}`;
        ev.textContent = `${a.codigo} - ${a.tipo_servicio}`;
        ev.onclick = () => mostrarDetalle(a);
        return ev;
    }

    function mostrarDetalle(a) {
        document.getElementById('cal-overlay').classList.add('visible');
        const det = document.getElementById('cal-detail');
        det.classList.add('visible');
        det.innerHTML = `
            <h3>${a.codigo}</h3>
            <p><strong>Tipo:</strong> ${a.tipo_servicio}</p>
            <p><strong>Urgencia:</strong> ${a.urgencia}</p>
            <p><strong>Fecha:</strong> ${a.fecha}</p>
            <p><strong>Franja:</strong> ${a.franja || '-'}</p>
            <p><strong>Descripcion:</strong> ${a.descripcion}</p>
            <p><strong>Direccion:</strong> ${a.direccion}</p>
            <p><strong>Telefono:</strong> ${a.telefono}</p>
            <p><strong>Estado:</strong> ${a.estado}</p>
            <br>
            <a href="/index.php?url=admin/detalle/${a.id}">Ver detalle completo</a>
            <button onclick="cerrarDetalle()" style="margin-left:1rem">Cerrar</button>`;
    }

    window.cerrarDetalle = () => {
        document.getElementById('cal-overlay').classList.remove('visible');
        document.getElementById('cal-detail').classList.remove('visible');
    };

    // Overlay y modal
    const overlay = document.createElement('div');
    overlay.id = 'cal-overlay';
    overlay.className = 'cal-overlay';
    overlay.onclick = cerrarDetalle;
    document.body.appendChild(overlay);

    const detail = document.createElement('div');
    detail.id = 'cal-detail';
    detail.className = 'cal-detail';
    document.body.appendChild(detail);

    render();
});
