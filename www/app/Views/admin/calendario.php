<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<div class="container">
    <h1>Calendario de Avisos</h1>
    <div id="calendario"></div>
</div>
<script>
const avisos = <?= json_encode($avisos) ?>;
</script>
<script src="/js/calendario.js"></script>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
