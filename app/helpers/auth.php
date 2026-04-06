<?php
function isLoggedIn(): bool { return isset($_SESSION['user_id']); }
function isAdmin(): bool { return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'; }
function isTecnico(): bool { return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'tecnico'; }
function isCliente(): bool { return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'cliente'; }
function requireLogin(): void { if (!isLoggedIn()) { header('Location: /index.php?url=auth/login'); exit; } }
function requireAdmin(): void { requireLogin(); if (!isAdmin()) { header('Location: /index.php?url=home'); exit; } }
