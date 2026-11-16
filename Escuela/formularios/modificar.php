<?php
require_once __DIR__ . "/../config/conexion.php";
$tipo = $_GET['tipo'] ?? 'alumno';
$id   = (int)($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($tipo === 'alumno') {
        $stmt = $conexion->prepare("UPDATE alumnos SET matricula=?, nombre=?, apaterno=?, amaterno=?, dom=?, mail=?, tel=?, tutor=? WHERE id=?");
        $stmt->bind_param("ssssssssi", $_POST['matricula'], $_POST['nombre'], $_POST['apaterno'], $_POST['amaterno'], $_POST['dom'], $_POST['mail'], $_POST['tel'], $_POST['tutor'], $id);
        $stmt->execute();
        header("Location: ../crudregistro/CrudAlumno.php"); exit;
    } elseif ($tipo === 'profesor') {
        $stmt = $conexion->prepare("UPDATE profesores SET clave=?, nombre=?, apaterno=?, amaterno=?, mail=?, tel=? WHERE id=?");
        $stmt->bind_param("ssssssi", $_POST['clave'], $_POST['nombre'], $_POST['apaterno'], $_POST['amaterno'], $_POST['mail'], $_POST['tel'], $id);
        $stmt->execute();
        header("Location: ../crudregistro/CrudProfesor.php"); exit;
    } elseif ($tipo === 'grupo') {
        $stmt = $conexion->prepare("UPDATE grupos SET clave_grupo=?, nombre_grupo=?, turno=? WHERE id=?");
        $stmt->bind_param("sssi", $_POST['clave_grupo'], $_POST['nombre_grupo'], $_POST['turno'], $id);
        $stmt->execute();
        header("Location: ../crudregistro/CrudGrupo.php"); exit;
    } elseif ($tipo === 'materia') {
        $cred = (int)$_POST['creditos'];
        $stmt = $conexion->prepare("UPDATE materias SET clave_mat=?, nombre_mat=?, creditos=? WHERE id=?");
        $stmt->bind_param("ssii", $_POST['clave_mat'], $_POST['nombre_mat'], $cred, $id);
        $stmt->execute();
        header("Location: ../crudregistro/CrudMateria.php"); exit;
    }
}

$tablas = ['alumno' => 'alumnos', 'profesor' => 'profesores', 'grupo' => 'grupos', 'materia' => 'materias'];
$tabla = $tablas[$tipo] ?? 'alumnos';
$resultado = $conexion->query("SELECT * FROM $tabla WHERE id = $id");
// Evita los warnings inicializando como arreglo vacío si no hay datos
$dato = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Registro</title>
    <!-- Estándar oficial de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>

<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">✏️ Modificar <?= ucfirst(htmlspecialchars($tipo)) ?> #<?= $id ?></h5>
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

                <?php elseif ($tipo === 'profesor'): ?>
                    <div class="col-md-3"><label class="form-label">Clave</label><input type="text" name="clave" value="<?= htmlspecialchars($dato['clave'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Nombre</label><input type="text" name="nombre" value="<?= htmlspecialchars($dato['nombre'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Apellido Paterno</label><input type="text" name="apaterno" value="<?= htmlspecialchars($dato['apaterno'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Apellido Materno</label><input type="text" name="amaterno" value="<?= htmlspecialchars($dato['amaterno'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">Correo</label><input type="email" name="mail" value="<?= htmlspecialchars($dato['mail'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">Teléfono</label><input type="text" name="tel" value="<?= htmlspecialchars($dato['tel'] ?? '') ?>" class="form-control" required></div>

                <?php elseif ($tipo === 'grupo'): ?>
                    <div class="col-md-4"><label class="form-label">Clave</label><input type="text" name="clave_grupo" value="<?= htmlspecialchars($dato['clave_grupo'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-5"><label class="form-label">Nombre</label><input type="text" name="nombre_grupo" value="<?= htmlspecialchars($dato['nombre_grupo'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Turno</label><input type="text" name="turno" value="<?= htmlspecialchars($dato['turno'] ?? '') ?>" class="form-control" required></div>

                <?php elseif ($tipo === 'materia'): ?>
                    <div class="col-md-3"><label class="form-label">Clave</label><input type="text" name="clave_mat" value="<?= htmlspecialchars($dato['clave_mat'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">Materia</label><input type="text" name="nombre_mat" value="<?= htmlspecialchars($dato['nombre_mat'] ?? '') ?>" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Créditos</label><input type="number" name="creditos" value="<?= htmlspecialchars($dato['creditos'] ?? '') ?>" class="form-control" required></div>
                <?php endif; ?>

                <div class="col-12">
                    <button type="submit" class="btn btn-success btn-sm">💾 Actualizar</button>
                    <a href="javascript:history.back()" class="btn btn-secondary btn-sm">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- JS de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>