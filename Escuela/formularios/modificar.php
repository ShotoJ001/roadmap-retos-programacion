<?php
require_once __DIR__ . "/../config/conexion.php";
$tipo = $_GET['tipo'] ?? 'alumno';
$id   = (int)($_GET['id'] ?? 0);

$esCalif = in_array($tipo, ['calificacion', 'boleta'], true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estatus = $_POST['estatus'] ?? 'Activo';

    if ($tipo === 'alumno') {
        $stmt = $conexion->prepare("UPDATE alumnos SET matricula=?, nombre=?, apaterno=?, amaterno=?, dom=?, mail=?, tel=?, tutor=?, estatus=? WHERE id=?");
        $stmt->bind_param("sssssssssi", $_POST['matricula'], $_POST['nombre'], $_POST['apaterno'], $_POST['amaterno'], $_POST['dom'], $_POST['mail'], $_POST['tel'], $_POST['tutor'], $estatus, $id);
        $stmt->execute();
        header("Location: ../crudregistro/CrudAlumno.php"); exit;
    } elseif ($tipo === 'profesor') {
        $stmt = $conexion->prepare("UPDATE profesores SET clave=?, nombre=?, apaterno=?, amaterno=?, mail=?, tel=?, estatus=? WHERE id=?");
        $stmt->bind_param("sssssssi", $_POST['clave'], $_POST['nombre'], $_POST['apaterno'], $_POST['amaterno'], $_POST['mail'], $_POST['tel'], $estatus, $id);
        $stmt->execute();
        header("Location: ../crudregistro/CrudProfesor.php"); exit;
    } elseif ($tipo === 'grupo') {
        $stmt = $conexion->prepare("UPDATE grupos SET clave_grupo=?, nombre_grupo=?, turno=?, estatus=? WHERE id=?");
        $stmt->bind_param("ssssi", $_POST['clave_grupo'], $_POST['nombre_grupo'], $_POST['turno'], $estatus, $id);
        $stmt->execute();
        header("Location: ../crudregistro/CrudGrupo.php"); exit;
    } elseif ($tipo === 'materia') {
        $cred = (int)$_POST['creditos'];
        $stmt = $conexion->prepare("UPDATE materias SET clave_mat=?, nombre_mat=?, creditos=?, estatus=? WHERE id=?");
        $stmt->bind_param("ssisi", $_POST['clave_mat'], $_POST['nombre_mat'], $cred, $estatus, $id);
        $stmt->execute();
        header("Location: ../crudregistro/CrudMateria.php"); exit;
    } elseif ($tipo === 'unidad') {
        $stmt = $conexion->prepare("UPDATE unidades SET nombre_unidad=?, estatus=? WHERE id=?");
        $stmt->bind_param("ssi", $_POST['nombre_unidad'], $estatus, $id);
        $stmt->execute();
        header("Location: ../crudregistro/CrudUnidad.php"); exit;
    } elseif ($tipo === 'usuario') {
        $nombre_completo = trim($_POST['nombre_completo'] ?? '');
        $usuario_limpio  = trim($_POST['usuario'] ?? '');
        $id_puesto       = (int)($_POST['id_puesto'] ?? 0);
        $pass_nueva      = trim($_POST['password'] ?? '');

        if ($pass_nueva !== '') {
            $pass_sha1 = sha1($pass_nueva);
            $stmt = $conexion->prepare("UPDATE usuarios SET nombre_completo=?, usuario=?, password=?, id_puesto=?, estatus=? WHERE id=?");
            $stmt->bind_param("sssisi", $nombre_completo, $usuario_limpio, $pass_sha1, $id_puesto, $estatus, $id);
        } else {
            $stmt = $conexion->prepare("UPDATE usuarios SET nombre_completo=?, usuario=?, id_puesto=?, estatus=? WHERE id=?");
            $stmt->bind_param("ssisi", $nombre_completo, $usuario_limpio, $id_puesto, $estatus, $id);
        }
        $stmt->execute();
        header("Location: ../crudregistro/CrudUsuario.php"); exit;
    } elseif ($esCalif) {
        $calif = (float)$_POST['calificacion'];
        $stmt = $conexion->prepare("UPDATE calificaciones SET calificacion=? WHERE id=?");
        $stmt->bind_param("di", $calif, $id);
        $stmt->execute();

        if (!empty($_POST['id_alumno']) && isset($_POST['estatus'])) {
            $idAl = (int)$_POST['id_alumno'];
            $stmtEst = $conexion->prepare("UPDATE alumnos SET estatus=? WHERE id=?");
            $stmtEst->bind_param("si", $estatus, $idAl);
            $stmtEst->execute();
        }

        $destino = ($tipo === 'boleta') ? "../reportes/rep_boleta.php" : "../reportes/rep_calificaciones.php";
        header("Location: " . $destino); exit;
    }
}

$dato = [];
$estatusActual = 'Activo';

if ($esCalif) {
    $resultado = $conexion->query("SELECT c.id,
                                          c.id_alumno,
                                          c.calificacion,
                                          a.matricula,
                                          CONCAT_WS(' ', a.nombre, a.apaterno, a.amaterno) AS alumno,
                                          a.estatus,
                                          m.clave_mat,
                                          m.nombre_mat,
                                          u.nombre_unidad
                                   FROM calificaciones c
                                   INNER JOIN alumnos a ON c.id_alumno = a.id
                                   INNER JOIN materias m ON c.id_materia = m.id
                                   INNER JOIN unidades u ON c.id_unidad = u.id
                                   WHERE c.id = $id");
    $dato = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : [];
    $estatusActual = $dato['estatus'] ?? 'Activo';
} else {
    $tablas = [
        'alumno'   => 'alumnos',
        'profesor' => 'profesores',
        'grupo'    => 'grupos',
        'materia'  => 'materias',
        'unidad'   => 'unidades',
        'usuario'  => 'usuarios'
    ];
    $tabla = $tablas[$tipo] ?? 'alumnos';
    $resultado = $conexion->query("SELECT * FROM $tabla WHERE id = $id");
    $dato = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : [];
    $estatusActual = $dato['estatus'] ?? 'Activo';
}

$puestosMod = ($tipo === 'usuario') ? $conexion->query("SELECT id, nombre_puesto FROM puestos ORDER BY id ASC") : null;

$tituloTipo = ($tipo === 'boleta')
    ? 'Boleta / Calificación'
    : (($tipo === 'calificacion') ? 'Calificación' : ucfirst(htmlspecialchars($tipo)));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>

<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">✏️ Modificar <?= $tituloTipo ?> #<?= $id ?></h5>
        </div>
        <div class="card-body">
            <form method="POST" class="row g-3">
                <?php if ($tipo === 'alumno'): ?>
                    <div class="col-md-3"><label class="form-label">Matrícula</label><input type="text" name="matricula" value="<?= htmlspecialchars($dato['matricula'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Nombre</label><input type="text" name="nombre" value="<?= htmlspecialchars($dato['nombre'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Apellido Paterno</label><input type="text" name="apaterno" value="<?= htmlspecialchars($dato['apaterno'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Apellido Materno</label><input type="text" name="amaterno" value="<?= htmlspecialchars($dato['amaterno'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-5"><label class="form-label">Domicilio</label><input type="text" name="dom" value="<?= htmlspecialchars($dato['dom'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-4"><label class="form-label">Correo</label><input type="email" name="mail" value="<?= htmlspecialchars($dato['mail'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Teléfono</label><input type="text" name="tel" value="<?= htmlspecialchars($dato['tel'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-4"><label class="form-label">Tutor</label><input type="text" name="tutor" value="<?= htmlspecialchars($dato['tutor'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-4">
                        <label class="form-label">Estatus</label>
                        <select name="estatus" class="form-select" required>
                            <option value="Activo" <?= $estatusActual === 'Activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="Inactivo" <?= $estatusActual === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>

                <?php elseif ($tipo === 'profesor'): ?>
                    <div class="col-md-3"><label class="form-label">Clave</label><input type="text" name="clave" value="<?= htmlspecialchars($dato['clave'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Nombre</label><input type="text" name="nombre" value="<?= htmlspecialchars($dato['nombre'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Apellido Paterno</label><input type="text" name="apaterno" value="<?= htmlspecialchars($dato['apaterno'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Apellido Materno</label><input type="text" name="amaterno" value="<?= htmlspecialchars($dato['amaterno'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-4"><label class="form-label">Correo</label><input type="email" name="mail" value="<?= htmlspecialchars($dato['mail'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-4"><label class="form-label">Teléfono</label><input type="text" name="tel" value="<?= htmlspecialchars($dato['tel'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-4">
                        <label class="form-label">Estatus</label>
                        <select name="estatus" class="form-select" required>
                            <option value="Activo" <?= $estatusActual === 'Activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="Inactivo" <?= $estatusActual === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>

                <?php elseif ($tipo === 'grupo'): ?>
                    <div class="col-md-3"><label class="form-label">Clave</label><input type="text" name="clave_grupo" value="<?= htmlspecialchars($dato['clave_grupo'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-4"><label class="form-label">Nombre</label><input type="text" name="nombre_grupo" value="<?= htmlspecialchars($dato['nombre_grupo'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Turno</label><input type="text" name="turno" value="<?= htmlspecialchars($dato['turno'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-2">
                        <label class="form-label">Estatus</label>
                        <select name="estatus" class="form-select" required>
                            <option value="Activo" <?= $estatusActual === 'Activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="Inactivo" <?= $estatusActual === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>

                <?php elseif ($tipo === 'materia'): ?>
                    <div class="col-md-3"><label class="form-label">Clave</label><input type="text" name="clave_mat" value="<?= htmlspecialchars($dato['clave_mat'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-4"><label class="form-label">Materia</label><input type="text" name="nombre_mat" value="<?= htmlspecialchars($dato['nombre_mat'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-2"><label class="form-label">Créditos</label><input type="number" name="creditos" value="<?= htmlspecialchars($dato['creditos'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-3">
                        <label class="form-label">Estatus</label>
                        <select name="estatus" class="form-select" required>
                            <option value="Activo" <?= $estatusActual === 'Activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="Inactivo" <?= $estatusActual === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>

                <?php elseif ($tipo === 'unidad'): ?>
                    <div class="col-md-8"><label class="form-label">Nombre de Unidad</label><input type="text" name="nombre_unidad" value="<?= htmlspecialchars($dato['nombre_unidad'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-4">
                        <label class="form-label">Estatus</label>
                        <select name="estatus" class="form-select" required>
                            <option value="Activo" <?= $estatusActual === 'Activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="Inactivo" <?= $estatusActual === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>

                <?php elseif ($tipo === 'usuario'): ?>
                    <div class="col-md-4">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre_completo" value="<?= htmlspecialchars($dato['nombre_completo'] ?? '') ?>" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Usuario</label>
                        <input type="text" name="usuario" value="<?= htmlspecialchars($dato['usuario'] ?? '') ?>" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Puesto</label>
                        <select name="id_puesto" class="form-select" required>
                            <?php if ($puestosMod): ?>
                                <?php while ($p = $puestosMod->fetch_assoc()): ?>
                                    <option value="<?= (int)$p['id'] ?>" <?= (int)($dato['id_puesto'] ?? 0) === (int)$p['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($p['nombre_puesto']) ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Estatus</label>
                        <select name="estatus" class="form-select" required>
                            <option value="Activo" <?= $estatusActual === 'Activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="Inactivo" <?= $estatusActual === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nueva Contraseña (opcional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Déjalo vacío para conservar la contraseña actual">
                    </div>

                <?php elseif ($esCalif): ?>
                    <input type="hidden" name="id_alumno" value="<?= (int)($dato['id_alumno'] ?? 0) ?>">
                    <div class="col-md-4">
                        <label class="form-label">Alumno</label>
                        <input type="text" value="<?= htmlspecialchars(($dato['matricula'] ?? '') . ' - ' . ($dato['alumno'] ?? '')) ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Materia</label>
                        <input type="text" value="<?= htmlspecialchars(($dato['clave_mat'] ?? '') . ' - ' . ($dato['nombre_mat'] ?? '')) ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Unidad</label>
                        <input type="text" value="<?= htmlspecialchars($dato['nombre_unidad'] ?? '') ?>" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Calificación</label>
                        <input type="number" step="0.1" min="0" max="10" name="calificacion" value="<?= htmlspecialchars($dato['calificacion'] ?? '') ?>" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Estatus</label>
                        <select name="estatus" class="form-select" required>
                            <option value="Activo" <?= $estatusActual === 'Activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="Inactivo" <?= $estatusActual === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="col-12">
                    <button type="submit" class="btn btn-success btn-sm">💾 Actualizar</button>
                    <a href="javascript:history.back()" class="btn btn-secondary btn-sm">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>