<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<div class="container" style="max-width:400px;">
    <h1>Crear Cuenta</h1>
    <?php if(isset($error) && $error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="index.php?action=registro">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <select name="rol">
            <option value="cliente">Cliente</option>
        </select>
        <button type="submit">Registrarse</button>
    </form>
    <br>
    <p>¿Ya tienes cuenta? <a href="index.php?action=login">Iniciar sesión</a></p>
</div>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>