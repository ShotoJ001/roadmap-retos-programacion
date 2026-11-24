<?php
require_once __DIR__ . "/../config/conexion.php";
$tipo = $_GET['tipo'] ?? 'alumno';
$alerta = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($tipo === 'alumno') {
        $tutor = $_POST['tutor'] ?? '';
        $stmt = $conexion->prepare("INSERT INTO alumnos (matricula, nombre, apaterno, amaterno, dom, mail, tel, tutor, estatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Activo')");
        $stmt->bind_param("ssssssss", $_POST['matricula'], $_POST['nombre'], $_POST['apaterno'], $_POST['amaterno'], $_POST['dom'], $_POST['mail'], $_POST['tel'], $tutor);
        if ($stmt->execute()) { header("Location: ../crudregistro/CrudAlumno.php"); exit; }
    } elseif ($tipo === 'profesor') {
        $stmt = $conexion->prepare("INSERT INTO profesores (clave, nombre, apaterno, amaterno, mail, tel, estatus) VALUES (?, ?, ?, ?, ?, ?, 'Activo')");
        $stmt->bind_param("ssssss", $_POST['clave'], $_POST['nombre'], $_POST['apaterno'], $_POST['amaterno'], $_POST['mail'], $_POST['tel']);
        if ($stmt->execute()) { header("Location: ../crudregistro/CrudProfesor.php"); exit; }
    } elseif ($tipo === 'grupo') {
        $stmt = $conexion->prepare("INSERT INTO grupos (clave_grupo, nombre_grupo, turno, estatus) VALUES (?, ?, ?, 'Activo')");
        $stmt->bind_param("sss", $_POST['clave_grupo'], $_POST['nombre_grupo'], $_POST['turno']);
        if ($stmt->execute()) { header("Location: ../crudregistro/CrudGrupo.php"); exit; }
    } elseif ($tipo === 'materia') {
        $cred = (int)$_POST['creditos'];
        $stmt = $conexion->prepare("INSERT INTO materias (clave_mat, nombre_mat, creditos, estatus) VALUES (?, ?, ?, 'Activo')");
        $stmt->bind_param("ssi", $_POST['clave_mat'], $_POST['nombre_mat'], $cred);
        if ($stmt->execute()) { header("Location: ../crudregistro/CrudMateria.php"); exit; }
    } elseif ($tipo === 'unidad') {
        $stmt = $conexion->prepare("INSERT INTO unidades (nombre_unidad, estatus) VALUES (?, 'Activo')");
        $stmt->bind_param("s", $_POST['nombre_unidad']);
        if ($stmt->execute()) { header("Location: ../crudregistro/CrudUnidad.php"); exit; }
    } elseif ($tipo === 'puesto') {
        $stmt = $conexion->prepare("INSERT INTO puestos (nombre_puesto, estatus) VALUES (?, 'Activo')");
        $stmt->bind_param("s", $_POST['nombre_puesto']);
        if ($stmt->execute()) { header("Location: ../crudregistro/CrudPuesto.php"); exit; }
    } elseif ($tipo === 'usuario') {
        $nombre_completo = trim($_POST['nombre_completo'] ?? '');
        $usuario_limpio  = trim($_POST['usuario'] ?? '');
        $pass_plano      = trim($_POST['password'] ?? '');
        $id_puesto       = (int)($_POST['id_puesto'] ?? 0);

        if ($nombre_completo !== '' && $usuario_limpio !== '' && $pass_plano !== '' && $id_puesto > 0) {
            $pass_sha1 = sha1($pass_plano);
            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre_completo, usuario, password, id_puesto, estatus) VALUES (?, ?, ?, ?, 'Activo')");
            $stmt->bind_param("sssi", $nombre_completo, $usuario_limpio, $pass_sha1, $id_puesto);
            if ($stmt->execute()) {
                header("Location: ../crudregistro/CrudUsuario.php");
                exit;
            }
        }
    }
    $alerta = '<div class="alert alert-danger">❌ Error al guardar el registro.</div>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include __DIR__ . "/../navBar/navbar.php"; ?>

<div class="container mt-5">
    <?= $alerta ?>
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">➕ Alta de <?= ucfirst(htmlspecialchars($tipo)) ?></h5>
        </div>
        <div class="card-body">
            <form method="POST" class="row g-3">
                <?php if ($tipo === 'alumno'): ?>
                    <div class="col-md-3"><label class="form-label">Matrícula</label><input type="text" name="matricula" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Nombre</label><input type="text" name="nombre" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Apellido Paterno</label><input type="text" name="apaterno" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Apellido Materno</label><input type="text" name="amaterno" class="form-control" required></div>
                    <div class="col-md-5"><label class="form-label">Domicilio</label><input type="text" name="dom" class="form-control" required></div>
                    <div class="col-md-4"><label class="form-label">Correo</label><input type="email" name="mail" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Teléfono</label><input type="text" name="tel" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Tutor</label><input type="text" name="tutor" class="form-control" required></div>

                <?php elseif ($tipo === 'profesor'): ?>
                    <div class="col-md-3"><label class="form-label">Clave</label><input type="text" name="clave" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Nombre</label><input type="text" name="nombre" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Apellido Paterno</label><input type="text" name="apaterno" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Apellido Materno</label><input type="text" name="amaterno" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">Correo</label><input type="email" name="mail" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">Teléfono</label><input type="text" name="tel" class="form-control" required></div>

                <?php elseif ($tipo === 'grupo'): ?>
                    <div class="col-md-4"><label class="form-label">Clave Grupo</label><input type="text" name="clave_grupo" class="form-control" required></div>
                    <div class="col-md-5"><label class="form-label">Nombre Grupo</label><input type="text" name="nombre_grupo" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Turno</label><select name="turno" class="form-select"><option>Matutino</option><option>Vespertino</option></select></div>

                <?php elseif ($tipo === 'materia'): ?>
                    <div class="col-md-3"><label class="form-label">Clave</label><input type="text" name="clave_mat" class="form-control" required></div>
                    <div class="col-md-6"><label class="form-label">Nombre Materia</label><input type="text" name="nombre_mat" class="form-control" required></div>
                    <div class="col-md-3"><label class="form-label">Créditos</label><input type="number" name="creditos" class="form-control" min="1" max="10" required></div>

                <?php elseif ($tipo === 'unidad'): ?>
                    <div class="col-12"><label class="form-label">Nombre de la Unidad</label><input type="text" name="nombre_unidad" class="form-control" required></div>

                <?php elseif ($tipo === 'puesto'): ?>
                    <div class="col-12"><label class="form-label">Nombre del Puesto</label><input type="text" name="nombre_puesto" class="form-control" required></div>

                <?php elseif ($tipo === 'usuario'):
                    $puestos = $conexion->query("SELECT * FROM puestos WHERE estatus='Activo' ORDER BY id ASC");
                    $alumnosReg = $conexion->query("SELECT id, matricula, CONCAT_WS(' ', nombre, apaterno, amaterno) AS nombre_completo FROM alumnos ORDER BY id ASC");
                ?>
                    <div class="col-md-3">
                        <label class="form-label">Puesto</label>
                        <select id="id_puesto" name="id_puesto" class="form-select" required>
                            <?php while ($p = $puestos->fetch_assoc()): ?>
                                <option value="<?= (int)$p['id'] ?>" data-nombre="<?= htmlspecialchars(mb_strtolower(trim($p['nombre_puesto']), 'UTF-8')) ?>">
                                    <?= htmlspecialchars($p['nombre_puesto']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-3 d-none" id="bloque_matricula_alumno">
                        <label for="select_matricula_alumno" class="form-label">Matrícula Registrada</label>
                        <select id="select_matricula_alumno" class="form-select">
                            <option value="">-- Seleccionar matrícula --</option>
                            <?php if ($alumnosReg): ?>
                                <?php while ($al = $alumnosReg->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($al['matricula']) ?>" data-nombre="<?= htmlspecialchars($al['nombre_completo']) ?>">
                                        <?= htmlspecialchars($al['matricula'] . ' - ' . $al['nombre_completo']) ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="col-md-2" id="col_nombre_completo">
                        <label for="nombre_completo" class="form-label">Nombre Completo</label>
                        <input type="text" id="nombre_completo" name="nombre_completo" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" id="usuario" name="usuario" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <script>
                        (function () {
                            const selectPuesto = document.getElementById('id_puesto');
                            const bloqueMatricula = document.getElementById('bloque_matricula_alumno');
                            const selectMatricula = document.getElementById('select_matricula_alumno');
                            const inputNombre = document.getElementById('nombre_completo');
                            const inputUsuario = document.getElementById('usuario');
                            const colNombre = document.getElementById('col_nombre_completo');

                            function actualizarVistaPuesto() {
                                const opt = selectPuesto.options[selectPuesto.selectedIndex];
                                const nombrePuesto = opt ? (opt.getAttribute('data-nombre') || '') : '';
                                const esAlumno = nombrePuesto.includes('alumno');

                                if (esAlumno) {
                                    bloqueMatricula.classList.remove('d-none');
                                    selectMatricula.setAttribute('required', 'required');
                                    colNombre.className = 'col-md-2';
                                } else {
                                    bloqueMatricula.classList.add('d-none');
                                    selectMatricula.removeAttribute('required');
                                    selectMatricula.value = '';
                                    colNombre.className = 'col-md-3';
                                }
                            }

                            selectPuesto.addEventListener('change', actualizarVistaPuesto);

                            selectMatricula.addEventListener('change', function () {
                                const opt = this.options[this.selectedIndex];
                                const nombreAl = opt ? (opt.getAttribute('data-nombre') || '') : '';
                                const matriculaAl = this.value || '';

                                if (nombreAl) {
                                    inputNombre.value = nombreAl;
                                }
                                if (matriculaAl && !inputUsuario.value.trim()) {
                                    inputUsuario.value = matriculaAl.toLowerCase();
                                }
                            });

                            actualizarVistaPuesto();
                        })();
                    </script>
                <?php endif; ?>

                <div class="col-12">
                    <button type="submit" class="btn btn-success btn-sm">💾 Guardar</button>
                    <a href="javascript:history.back()" class="btn btn-secondary btn-sm">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>