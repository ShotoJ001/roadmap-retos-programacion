<?php
require_once __DIR__ . "/../config/conexion.php";
$lista = $conexion->query("SELECT u.*, p.nombre_puesto FROM usuarios u INNER JOIN puestos p ON u.id_puesto=p.id ORDER BY u.id ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"> Gestión de Usuarios (Encriptación )</h5>
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
                    </tr>
                </thead>
                <tbody>
                    <?php $contador = 1; while ($r = $lista->fetch_assoc()): ?>
                    <tr>
                        <td><?= $r['id'] ?></td>
                        <td><?= htmlspecialchars($r['nombre_completo']) ?></td>
                        <td><strong><?= htmlspecialchars($r['usuario']) ?></strong></td>
                        <td><?= htmlspecialchars($r['nombre_puesto']) ?></td>
                        <td>
                            
                            <div class="input-group input-group-sm" style="max-width: 260px;">
                                <input type="password" class="form-control form-control-sm font-monospace bg-white" id="pass_<?= $contador ?>" value="<?= htmlspecialchars($r['password']) ?>" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword(<?= $contador ?>)" id="btn_<?= $contador ?>" title="Ver / Ocultar">
                                  
                                    <svg id="icon_<?= $contador ?>" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                                        <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                                        <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.83zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td><span class="badge bg-success"><?= $r['estatus'] ?></span></td>
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
    const icon = document.getElementById('icon_' + id);
    
    if (input.type === "password") {
        input.type = "text";
        
        icon.innerHTML = `<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>`;
    } else {
        input.type = "password";
       
        icon.innerHTML = `<path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.83zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829j3.171 6-12-12 .708-.708 12 12-.708.708z"/>`;
    }
}
</script>
</body>
</html>