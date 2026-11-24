<?php
require_once __DIR__ . "/../config/conexion.php";
$lista = $conexion->query("SELECT * FROM puestos ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>CRUD Puestos</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"> Gestión de Puestos</h5>
            <a href="../formularios/alta.php?tipo=puesto" class="btn btn-success btn-sm">➕ Nuevo Puesto</a>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light"><tr><th>ID</th><th>Puesto</th><th>Estatus</th></tr></thead>
                <tbody>
                    <?php while ($r = $lista->fetch_assoc()): ?>
                    <tr><td><?= $r['id'] ?></td><td><?= htmlspecialchars($r['nombre_puesto']) ?></td><td><span class="badge bg-success"><?= $r['estatus'] ?></span></td></tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>