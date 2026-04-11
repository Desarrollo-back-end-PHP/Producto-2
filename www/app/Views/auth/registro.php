<h2>Registro</h2>

<form method="POST" action="index.php?action=registro">
    <input type="text" name="nombre" placeholder="Nombre" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>

    <select name="rol">
        <option value="cliente">Cliente</option>
        <option value="tecnico">Técnico</option>
        <option value="admin">Admin</option>
    </select><br>

    <button type="submit">Registrarse</button>
</form>

<br>
<a href="index.php">
    <button type="button">Volver al menú principal</button>
</a>