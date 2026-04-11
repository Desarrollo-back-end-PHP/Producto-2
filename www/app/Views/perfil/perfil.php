<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<div class="container">
    <h1>Editar Perfil</h1>
    <form method="POST" action="index.php?action=perfil">
        <input type="text" name="nombre" 
        value="<?php echo $_SESSION['usuario']['nombre']; ?>" required>
        <input type="email" name="email" 
        value="<?php echo $_SESSION['usuario']['email']; ?>" required>
        <input type="password" name="password" 
        placeholder="Nueva contraseña (opcional)">
        <button type="submit">Actualizar</button>
    </form>
    <br>
    <a href="index.php?action=dashboard" class="btn">Volver</a>
</div>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>