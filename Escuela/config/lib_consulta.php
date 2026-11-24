<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/conexion.php";

function iniciarSesionSistema(mysqli $conexion, string $usuario, string $password): array
{
    $usuarioLimpio = trim($usuario);
    $hashSha1      = sha1(trim($password));

    $stmt = $conexion->prepare("
        SELECT u.id AS id_usuario,
               u.nombre_completo,
               u.usuario,
               u.id_puesto,
               u.estatus,
               p.nombre_puesto
        FROM usuarios u
        INNER JOIN puestos p ON u.id_puesto = p.id
        WHERE u.usuario = ?
          AND u.password = ?
        LIMIT 1
    ");
    if (!$stmt) {
        return ['ok' => false, 'error' => 'ERROR EN LA AUTENTIFICACIÓN'];
    }
    $stmt->bind_param("ss", $usuarioLimpio, $hashSha1);
    $stmt->execute();
    $res = $stmt->get_result();

    if (!$res || $res->num_rows === 0) {
        unset($_SESSION['auth_usuario']);
        return ['ok' => false, 'error' => 'ERROR EN LA AUTENTIFICACIÓN: Usuario o contraseña incorrectos.'];
    }

    $usr = $res->fetch_assoc();
    $stmt->close();

    // Bloqueo estricto si el usuario está Inactivo (sin permiso en lib_creador)
    if (trim((string)($usr['estatus'] ?? '')) !== 'Activo') {
        unset($_SESSION['auth_usuario']);
        return ['ok' => false, 'error' => 'ERROR EN LA AUTENTIFICACIÓN: El usuario está Inactivo y no tiene permiso para ingresar.'];
    }

    $puestoNorm = mb_strtolower(trim($usr['nombre_puesto']), 'UTF-8');
    $esPuestoAlumno = in_array($puestoNorm, ['alumnos', 'alumno'], true);

    $idAlumnoVinculado = null;
    $estatusAlumnoVinculado = null;
    $stmtAl = $conexion->prepare("
        SELECT id, estatus
        FROM alumnos
        WHERE LOWER(matricula) = LOWER(?)
        LIMIT 1
    ");
    if ($stmtAl) {
        $stmtAl->bind_param("s", $usr['usuario']);
        $stmtAl->execute();
        $resAl = $stmtAl->get_result();
        if ($resAl && $rowAl = $resAl->fetch_assoc()) {
            $idAlumnoVinculado = (int)$rowAl['id'];
            $estatusAlumnoVinculado = trim((string)($rowAl['estatus'] ?? 'Activo'));
        }
        $stmtAl->close();
    }

    if ($idAlumnoVinculado !== null && $estatusAlumnoVinculado !== 'Activo') {
        unset($_SESSION['auth_usuario']);
        return ['ok' => false, 'error' => 'ERROR EN LA AUTENTIFICACIÓN: El alumno está Inactivo y no tiene permiso para ingresar.'];
    }

    $esAlumno = $esPuestoAlumno || ($idAlumnoVinculado !== null);

    $_SESSION['auth_usuario'] = [
        'id_usuario'      => (int)$usr['id_usuario'],
        'nombre_completo' => $usr['nombre_completo'],
        'usuario'         => $usr['usuario'],
        'id_puesto'       => (int)$usr['id_puesto'],
        'nombre_puesto'   => trim($usr['nombre_puesto']),
        'estatus'         => trim((string)$usr['estatus']),
        'es_alumno'       => $esAlumno,
        'id_alumno'       => $idAlumnoVinculado
    ];

    return ['ok' => true, 'data' => $_SESSION['auth_usuario']];
}

function cerrarSesionSistema(): void
{
    $_SESSION = [];
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
}

function obtenerSesionActual(?mysqli $conexion = null): ?array
{
    if (!isset($_SESSION['auth_usuario'])) {
        return null;
    }

    if ($conexion instanceof mysqli) {
        $idUsr = (int)($_SESSION['auth_usuario']['id_usuario'] ?? 0);
        if ($idUsr > 0) {
            $stmt = $conexion->prepare("SELECT estatus, usuario FROM usuarios WHERE id = ? LIMIT 1");
            if ($stmt) {
                $stmt->bind_param("i", $idUsr);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = ($res && $res->num_rows > 0) ? $res->fetch_assoc() : null;
                $stmt->close();

                if (!$row || trim((string)($row['estatus'] ?? '')) !== 'Activo') {
                    unset($_SESSION['auth_usuario']);
                    $_SESSION['login_error_inactivo'] = 'ERROR EN LA AUTENTIFICACIÓN: El usuario está Inactivo y no tiene permiso para ingresar.';
                    return null;
                }
            }
        }
    }

    return $_SESSION['auth_usuario'];
}

function obtenerReporteUsuario(mysqli $conexion, int $idUsuario): ?array
{
    $stmt = $conexion->prepare("
        SELECT u.id AS id_usuario,
               u.nombre_completo,
               u.usuario,
               u.estatus AS estatus_usuario,
               p.id AS id_puesto,
               p.nombre_puesto,
               p.estatus AS estatus_puesto
        FROM usuarios u
        INNER JOIN puestos p ON u.id_puesto = p.id
        WHERE u.id = ?
        LIMIT 1
    ");
    if (!$stmt) {
        return null;
    }
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $res = $stmt->get_result();
    $data = ($res && $res->num_rows > 0) ? $res->fetch_assoc() : null;
    $stmt->close();
    return $data;
}

function obtenerResumenAlumno(mysqli $conexion, int $idAlumno): ?array
{
    $stmt = $conexion->prepare("
        SELECT a.id AS id_alumno,
               a.matricula,
               CONCAT_WS(' ', a.nombre, a.apaterno, a.amaterno) AS alumno,
               a.mail,
               a.tel,
               COALESCE(u.estatus, a.estatus) AS estatus,
               ROUND(AVG(c.calificacion), 2) AS promedio_general,
               COUNT(c.id) AS total_calificaciones
        FROM alumnos a
        LEFT JOIN usuarios u ON LOWER(u.usuario) = LOWER(a.matricula)
        LEFT JOIN calificaciones c ON c.id_alumno = a.id
        WHERE a.id = ?
        GROUP BY a.id, a.matricula, alumno, a.mail, a.tel, estatus
        LIMIT 1
    ");
    if (!$stmt) {
        return null;
    }
    $stmt->bind_param("i", $idAlumno);
    $stmt->execute();
    $res = $stmt->get_result();
    $data = ($res && $res->num_rows > 0) ? $res->fetch_assoc() : null;
    $stmt->close();
    return $data;
}

function obtenerCalificacionesAlumno(mysqli $conexion, int $idAlumno): array
{
    $stmt = $conexion->prepare("
        SELECT c.id AS id_calificacion,
               a.id AS id_alumno,
               a.matricula,
               CONCAT_WS(' ', a.nombre, a.apaterno, a.amaterno) AS alumno,
               m.id AS id_materia,
               m.clave_mat,
               m.nombre_mat AS materia,
               m.creditos,
               u.id AS id_unidad,
               u.nombre_unidad AS unidad,
               c.calificacion,
               COALESCE(p.id, 0) AS id_profesor,
               COALESCE(CONCAT_WS(' ', p.nombre, p.apaterno, p.amaterno), 'Sin asignar') AS profesor,
               a.estatus,
               ROUND(AVG(c.calificacion) OVER (PARTITION BY a.id), 2) AS promedio_alumno
        FROM calificaciones c
        INNER JOIN alumnos a ON c.id_alumno = a.id
        INNER JOIN materias m ON c.id_materia = m.id
        INNER JOIN unidades u ON c.id_unidad = u.id
        LEFT JOIN asignaciones asig
               ON asig.id_alumno = c.id_alumno
              AND asig.id_materia = c.id_materia
        LEFT JOIN profesores p ON asig.id_profesor = p.id
        WHERE c.id_alumno = ?
        ORDER BY c.id ASC
    ");
    if (!$stmt) {
        return [];
    }
    $stmt->bind_param("i", $idAlumno);
    $stmt->execute();
    $res = $stmt->get_result();

    $filas = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $filas[] = $row;
        }
    }
    $stmt->close();
    return $filas;
}

if (basename($_SERVER['SCRIPT_FILENAME'] ?? '') === basename(__FILE__)) {
    if (isset($_GET['logout'])) {
        cerrarSesionSistema();
        header("Location: " . basename(__FILE__));
        exit;
    }

    $errorLogin = "";
    if (!empty($_SESSION['login_error_inactivo'])) {
        $errorLogin = $_SESSION['login_error_inactivo'];
        unset($_SESSION['login_error_inactivo']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuario'], $_POST['password'])) {
        $intento = iniciarSesionSistema($conexion, $_POST['usuario'], $_POST['password']);
        if ($intento['ok']) {
            header("Location: " . basename(__FILE__));
            exit;
        }
        $errorLogin = $intento['error'];
    }

    $sesion = obtenerSesionActual($conexion);
    if (!$sesion && !empty($_SESSION['login_error_inactivo'])) {
        $errorLogin = $_SESSION['login_error_inactivo'];
        unset($_SESSION['login_error_inactivo']);
    }
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistema de Consulta - Usuario y Alumno</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <style>
            @media print {
                .d-print-none { display: none !important; }
            }
        </style>
    </head>
    <body class="bg-light">
    <?php if (!$sesion): ?>
        <div class="container d-flex align-items-center justify-content-center min-vh-100 py-4">
            <div class="col-md-5 col-lg-4">
                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0">Sistema de Login</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($errorLogin !== ""): ?>
                            <div class="alert alert-danger py-2 fw-bold" role="alert"><?= htmlspecialchars($errorLogin) ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Ingrese su usuario" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Ingrese su contraseña" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif ($sesion['es_alumno']): ?>
        <?php
        $idAl = (int)($sesion['id_alumno'] ?? 0);
        $resumen = $idAl > 0 ? obtenerResumenAlumno($conexion, $idAl) : null;
        $califs  = $idAl > 0 ? obtenerCalificacionesAlumno($conexion, $idAl) : [];
        ?>
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Portal del Alumno</h4>
                <a href="?logout=1" class="btn btn-outline-secondary btn-sm d-print-none">Cerrar sesión</a>
            </div>

            <?php if ($resumen): ?>
                <?php $activo = ($resumen['estatus'] === 'Activo'); ?>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted d-block">ID Alumno: <strong><?= (int)$resumen['id_alumno'] ?></strong></small>
                            <strong><?= htmlspecialchars($resumen['matricula'] . ' - ' . $resumen['alumno']) ?></strong>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted d-block">Estatus</small>
                            <span class="badge <?= $activo ? 'text-bg-success' : 'text-bg-secondary' ?>">
                                <?= htmlspecialchars($resumen['estatus']) ?>
                            </span>
                        </div>
                        <div>
                            <small class="text-muted d-block">Promedio General</small>
                            <strong class="fs-5 text-dark"><?= htmlspecialchars((string)($resumen['promedio_general'] ?? '—')) ?></strong>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle bg-white">
                    <thead class="table-dark">
                        <tr>
                            <th>ID Calificación</th>
                            <th>ID Alumno</th>
                            <th>ID Materia</th>
                            <th>Materia</th>
                            <th>Unidad</th>
                            <th>Profesor</th>
                            <th>Calificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($califs) > 0): ?>
                            <?php foreach ($califs as $c): ?>
                                <tr>
                                    <td><?= (int)$c['id_calificacion'] ?></td>
                                    <td><?= (int)$c['id_alumno'] ?></td>
                                    <td><?= (int)$c['id_materia'] ?></td>
                                    <td><?= htmlspecialchars($c['clave_mat'] . ' - ' . $c['materia']) ?></td>
                                    <td><?= htmlspecialchars($c['unidad']) ?></td>
                                    <td><?= htmlspecialchars($c['profesor']) ?></td>
                                    <td><strong><?= htmlspecialchars($c['calificacion']) ?></strong></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">No tienes calificaciones registradas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-print-none">
                <button type="button" class="btn btn-primary" onclick="window.print();">
                    <i class="bi bi-printer-fill me-1"></i> Imprimir
                </button>
            </div>
        </div>
    <?php else: ?>
        <?php $repUsr = obtenerReporteUsuario($conexion, (int)$sesion['id_usuario']); ?>
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Mi Reporte de Usuario</h4>
                <a href="?logout=1" class="btn btn-outline-secondary btn-sm d-print-none">Cerrar sesión</a>
            </div>

            <?php if ($repUsr): ?>
                <?php $activo = ($repUsr['estatus_usuario'] === 'Activo'); ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <strong>Reporte Personal</strong>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>ID Usuario:</strong> <?= (int)$repUsr['id_usuario'] ?></p>
                        <p class="mb-2"><strong>Nombre Completo:</strong> <?= htmlspecialchars($repUsr['nombre_completo']) ?></p>
                        <p class="mb-2"><strong>Usuario:</strong> <?= htmlspecialchars($repUsr['usuario']) ?></p>
                        <p class="mb-2">
                            <strong>Puesto que le tocó:</strong>
                            <span class="badge text-bg-primary"><?= htmlspecialchars($repUsr['nombre_puesto']) ?></span>
                        </p>
                        <p class="mb-0">
                            <strong>Estatus:</strong>
                            <span class="badge <?= $activo ? 'text-bg-success' : 'text-bg-secondary' ?>">
                                <?= htmlspecialchars($repUsr['estatus_usuario']) ?>
                            </span>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
}