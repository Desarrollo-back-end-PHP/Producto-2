<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<div class="container" style="max-width:400px;">
    <h1>Iniciar Sesión</h1>
    <?php if(isset($error) && $error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="index.php?action=login">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Entrar</button>
    </form>
    <br>
    <p>¿No tienes cuenta? <a href="index.php?action=registro">Crear cuenta</a></p>
</div>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>