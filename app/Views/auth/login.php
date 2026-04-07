<h2>Login</h2>

<?php if(isset($error) && $error): ?>
    <p style="color: red; font-weight: bold; background-color: #ffe6e6; padding: 10px; border-radius: 5px;">
        <?php echo $error; ?>
    </p>
<?php endif; ?>
<form method="POST" action="index.php?action=login">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Contraseña" required><br><br>

    <button type="submit">Entrar</button>
</form>