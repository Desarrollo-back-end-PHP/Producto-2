<h2>Editar Perfil</h2>

<form method="POST" action="index.php?action=perfil">

    <input type="text" name="nombre" 
    value="<?php echo $_SESSION['usuario']['nombre']; ?>" required><br>

    <input type="email" name="email" 
    value="<?php echo $_SESSION['usuario']['email']; ?>" required><br>

    <input type="password" name="password" 
    placeholder="Nueva contraseña (opcional)"><br>

    <button>Actualizar</button>
</form>

<a href="index.php?action=dashboard">Volver</a>