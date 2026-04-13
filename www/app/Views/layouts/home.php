<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<style>
.hero {
    background: linear-gradient(135deg, #2c3e50, #3498db);
    color: white;
    padding: 60px 30px;
    text-align: center;
    border-radius: 8px;
    margin-bottom: 40px;
}
.hero h1 { font-size: 2.4em; margin-bottom: 15px; color: white; }
.hero p  { font-size: 1.1em; margin-bottom: 30px; opacity: 0.9; }
.hero-btns { display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; }
.hero-btns a { padding: 12px 28px; border-radius: 5px; text-decoration: none; font-size: 15px; font-weight: bold; }
.btn-white { background: white; color: #2c3e50; }
.btn-outline { border: 2px solid white; color: white; }
.btn-outline:hover { background: rgba(255,255,255,0.15); }

.features { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 25px; margin-bottom: 40px; }
.card {
    background: white;
    border-radius: 8px;
    padding: 25px 20px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border-top: 4px solid #3498db;
}
.card .icon { font-size: 2.2em; margin-bottom: 12px; }
.card h3 { color: #2c3e50; margin-bottom: 10px; font-size: 1.05em; }
.card p  { color: #666; font-size: 0.9em; line-height: 1.5; }

.roles-section { margin-bottom: 40px; }
.roles { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
.role-card { background: #f8f9fa; border-radius: 8px; padding: 20px; border-left: 5px solid #3498db; }
.role-card h3 { color: #2c3e50; margin-bottom: 10px; }
.role-card ul { list-style: none; padding: 0; }
.role-card ul li { color: #555; font-size: 0.9em; padding: 4px 0; }
.role-card ul li::before { content: "✓ "; color: #27ae60; font-weight: bold; }

.cta-section { background: #2c3e50; color: white; border-radius: 8px; padding: 40px; text-align: center; margin-bottom: 20px; }
.cta-section h2 { color: white; margin-bottom: 10px; }
.cta-section p { opacity: 0.85; margin-bottom: 20px; }

.section-title { color: #2c3e50; font-size: 1.4em; margin-bottom: 20px; text-align: center; }
</style>

<div style="max-width:1100px; margin:30px auto; padding:0 20px;">

    <!-- Hero -->
    <div class="hero">
        <h1>ReparaYa</h1>
        <p>Gestión de averías domésticas de forma rápida y eficiente.<br>Fontanería, electricidad, carpintería y más.</p>
        <div class="hero-btns">
            <a href="/index.php?action=login" class="btn-white">Iniciar Sesión</a>
            <a href="/index.php?action=registro" class="btn-outline">Crear Cuenta</a>
        </div>
    </div>

    <!-- Características -->
    <h2 class="section-title">¿Qué ofrece ReparaYa?</h2>
    <div class="features">
        <div class="card">
            <div class="icon">🔧</div>
            <h3>Solicitud de servicios</h3>
            <p>Los clientes pueden solicitar asistencia técnica en cualquier momento, con hasta 48h de antelación para servicios estándar.</p>
        </div>
        <div class="card">
            <div class="icon">📅</div>
            <h3>Calendario visual</h3>
            <p>Vista mensual, semanal y diaria de todos los avisos. Los servicios urgentes y estándar se muestran con colores diferenciados.</p>
        </div>
        <div class="card">
            <div class="icon">👷</div>
            <h3>Asignación de técnicos</h3>
            <p>El administrador asigna técnicos especializados a cada aviso de forma sencilla desde el panel de control.</p>
        </div>
        <div class="card">
            <div class="icon">📋</div>
            <h3>Historial de avisos</h3>
            <p>Consulta todas tus solicitudes pasadas y futuras. Cancela citas con antelación suficiente cuando lo necesites.</p>
        </div>
        <div class="card">
            <div class="icon">⚡</div>
            <h3>Servicio urgente 24h</h3>
            <p>Para emergencias, el servicio urgente garantiza atención en menos de 24 horas con técnicos disponibles.</p>
        </div>
        <div class="card">
            <div class="icon">🔒</div>
            <h3>Acceso seguro</h3>
            <p>Sistema de registro y login con contraseñas cifradas. Cada usuario accede solo a su información.</p>
        </div>
    </div>

    <!-- Roles -->
    <div class="roles-section">
        <h2 class="section-title">Perfiles de usuario</h2>
        <div class="roles">
            <div class="role-card">
                <h3>👤 Cliente</h3>
                <ul>
                    <li>Solicitar nuevos avisos</li>
                    <li>Ver historial de solicitudes</li>
                    <li>Cancelar citas con antelación</li>
                    <li>Editar perfil y contraseña</li>
                </ul>
            </div>
            <div class="role-card" style="border-left-color:#e74c3c;">
                <h3>🛠️ Técnico</h3>
                <ul>
                    <li>Consultar su agenda de trabajo</li>
                    <li>Ver detalle de cada aviso asignado</li>
                    <li>Conocer dirección y franja horaria</li>
                    <li>Editar su perfil</li>
                </ul>
            </div>
            <div class="role-card" style="border-left-color:#27ae60;">
                <h3>⚙️ Administrador</h3>
                <ul>
                    <li>Crear y gestionar todos los avisos</li>
                    <li>Asignar técnicos a servicios</li>
                    <li>Ver calendario completo</li>
                    <li>Gestionar técnicos y servicios</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="cta-section">
        <h2>¿Tienes una avería en casa?</h2>
        <p>Regístrate gratis y solicita asistencia técnica en minutos.</p>
        <a href="/index.php?action=registro" class="btn btn-success">Crear cuenta gratuita</a>
    </div>

</div>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
