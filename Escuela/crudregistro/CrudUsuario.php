<?php
require_once __DIR__ . "/../config/conexion.php";

if (isset($_GET['eliminar'])) {
    $idEliminar = (int)$_GET['eliminar'];
    if ($idEliminar > 0) {
        $stmtDel = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmtDel->bind_param("i", $idEliminar);
        $stmtDel->execute();
    }
    header("Location: CrudUsuario.php");
    exit;
}

$lista = $conexion->query("SELECT u.id, u.nombre_completo, u.usuario, u.password, u.id_puesto, u.estatus, p.nombre_puesto
                           FROM usuarios u
                           INNER JOIN puestos p ON u.id_puesto = p.id
                           ORDER BY u.id ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Gestión de Usuarios (Encriptación)</h5>
            <a href="../formularios/alta.php?tipo=usuario" class="btn btn-success btn-sm">➕ Nuevo Usuario</a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Puesto</th>
                        <th>Contraseña</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $contador = 1; while ($r = $lista->fetch_assoc()): ?>
                    <?php $activo = ($r['estatus'] === 'Activo'); ?>
                    <tr>
                        <td><?= (int)$r['id'] ?></td>
                        <td><?= htmlspecialchars($r['nombre_completo']) ?></td>
                        <td><strong><?= htmlspecialchars($r['usuario']) ?></strong></td>
                        <td><?= htmlspecialchars($r['nombre_puesto']) ?></td>
                        <td>
                            <div class="input-group input-group-sm" style="max-width: 260px;">
                                <input type="password" class="form-control form-control-sm font-monospace bg-white" id="pass_<?= $contador ?>" value="<?= htmlspecialchars($r['password']) ?>" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(<?= $contador ?>)" id="btn_<?= $contador ?>" title="Ver / Ocultar">
                                    <i class="bi bi-eye-slash-fill" id="icon_<?= $contador ?>"></i>
                                </button>
                            </div>
                        </td>
                        <td>
                            <span class="badge <?= $activo ? 'bg-success' : 'bg-secondary' ?>">
                                <?= htmlspecialchars($r['estatus']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="../formularios/modificar.php?tipo=usuario&id=<?= (int)$r['id'] ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-pencil-square me-1"></i>Modificar Usuario
                            </a>
                            <a href="CrudUsuario.php?eliminar=<?= (int)$r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">
                                <i class="bi bi-trash me-1"></i>Eliminar
                            </a>
                        </td>
                    </tr>
                    <?php $contador++; endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword(id) {
    const input = document.getElementById('pass_' + id);
    const icon  = document.getElementById('icon_' + id);

    if (input.type === "password") {
        input.type = "text";
        icon.className = "bi bi-eye-fill";
    } else {
        input.type = "password";
        icon.className = "bi bi-eye-slash-fill";
    }
}
</script>
</body>
</html>