<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<div class="container">
    <div class="card" style="text-align:center; padding: 3rem;">
        <h1>Bienvenido a ReparaYa</h1>
        <p style="margin: 1rem 0; color: #666;">Gestion de averias domesticas — fontaneria, electricidad y mas.</p>
        <div style="display:flex; gap:1rem; justify-content:center; margin-top:2rem;">
            <a href="/index.php?url=auth/login">
                <button>Iniciar sesion</button>
            </a>
            <a href="/index.php?url=auth/registro">
                <button style="background:#27AE60">Registrarse</button>
            </a>
        </div>
    </div>
</div>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
