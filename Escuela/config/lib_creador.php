<?php
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
require_once __DIR__ . "/conexion.php";

/**
- Lista todos los usuarios registrados junto con su puesto.
*/
function listarUsuariosCreador(mysqli $conexion): array
{
$sql = "
SELECT u.id AS id_usuario,
u.nombre_completo,
u.usuario,
u.password,
u.id_puesto,
p.nombre_puesto,
u.estatus
FROM usuarios u
INNER JOIN puestos p ON u.id_puesto = p.id
ORDER BY u.id ASC
";
$res = $conexion->query($sql);
$datos = [];
if ($res) {
while ($row = $res->fetch_assoc()) {
$datos[] = $row;
}
}
return $datos;
}

/**
- Actualiza puesto y estatus (permiso) de un usuario en MySQL.
*/
function actualizarUsuarioCreador(mysqli $conexion, int $idUsuario, int $idPuesto, string $estatus): bool
{
$estatusValido = ($estatus === 'Inactivo') ? 'Inactivo' : 'Activo';

$stmt = $conexion->prepare("
UPDATE usuarios
SET id_puesto = ?, estatus = ?
WHERE id = ?
");
if (!$stmt) {
return false;
}
$stmt->bind_param("isi", $idPuesto, $estatusValido, $idUsuario);
$ok = $stmt->execute();
$stmt->close();

// Si el usuario tiene matrícula en alumnos, sincroniza también su estatus para que todo coincida
if ($ok) {
$stmtUsr = $conexion->prepare("SELECT usuario FROM usuarios WHERE id = ? LIMIT 1");
if ($stmtUsr) {
$stmtUsr->bind_param("i", $idUsuario);
$stmtUsr->execute();
$resUsr = $stmtUsr->get_result();
if ($resUsr && $rowUsr = $resUsr->fetch_assoc()) {
$loginUsr = $rowUsr['usuario'];
$stmtAl = $conexion->prepare("UPDATE alumnos SET estatus = ? WHERE LOWER(matricula) = LOWER(?)");
if ($stmtAl) {
$stmtAl->bind_param("ss", $estatusValido, $loginUsr);
$stmtAl->execute();
$stmtAl->close();
}
}
$stmtUsr->close();
}

// Si el usuario editado quedó Inactivo, revoca su sesión al instante
if ($estatusValido === 'Inactivo' && isset($_SESSION['auth_usuario']['id_usuario']) && (int)$_SESSION['auth_usuario']['id_usuario'] === $idUsuario) {
unset($_SESSION['auth_usuario']);
}
}

return $ok;
}

/**
- Elimina un usuario registrado por su ID.
*/
function eliminarUsuarioCreador(mysqli $conexion, int $idUsuario): bool
{
if ($idUsuario <= 0) {
return false;
}
$stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
if (!$stmt) {
return false;
}
$stmt->bind_param("i", $idUsuario);
$ok = $stmt->execute();
$stmt->close();

if ($ok && isset($_SESSION['auth_usuario']['id_usuario']) && (int)$_SESSION['auth_usuario']['id_usuario'] === $idUsuario) {
unset($_SESSION['auth_usuario']);
}

return $ok;
}

/**
- Actualiza una calificación desde el módulo del creador.
*/
function actualizarCalificacionCreador(mysqli $conexion, int $idCalificacion, float $calificacion): bool
{
$stmt = $conexion->prepare("
UPDATE calificaciones
SET calificacion = ?
WHERE id = ?
");
if (!$stmt) {
return false;
}
$stmt->bind_param("di", $calificacion, $idCalificacion);
$ok = $stmt->execute();
$stmt->close();
return $ok;
}

if (basename($_SERVER['SCRIPT_FILENAME'] ?? '') === basename(__FILE__)) {
$mensajeCreador = "";
$tipoAlertaCreador = "success";

if (isset($_GET['eliminar'])) {
$idDel = (int)$_GET['eliminar'];
if (eliminarUsuarioCreador($conexion, $idDel)) {
header("Location: " . basename(__FILE__) . "?msg=eliminado");
exit;
}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_usuario'])) {
$idUsr = (int)$_POST['id_usuario'];
$idPuesto = (int)($_POST['id_puesto'] ?? 0);

// Prioriza permiso_valor enviado por JS/hidden, luego estatus, luego permiso_switch
if (isset($_POST['permiso_valor']) && ($_POST['permiso_valor'] === '0' || $_POST['permiso_valor'] === '1')) {
$estatusFinal = ($_POST['permiso_valor'] === '1') ? 'Activo' : 'Inactivo';
} elseif (isset($_POST['estatus']) && in_array($_POST['estatus'], ['Activo', 'Inactivo'], true)) {
$estatusFinal = $_POST['estatus'];
} else {
$estatusFinal = isset($_POST['permiso_switch']) ? 'Activo' : 'Inactivo';
}

if ($idUsr > 0 && $idPuesto > 0) {
if (actualizarUsuarioCreador($conexion, $idUsr, $idPuesto, $estatusFinal)) {
header("Location: " . basename(__FILE__) . "?msg=guardado");
exit;
} else {
$mensajeCreador = "ERROR EN LA AUTENTIFICACIÓN / ACTUALIZACIÓN: No se pudo guardar en la base de datos.";
$tipoAlertaCreador = "danger";
}
}
}

if (isset($_GET['msg'])) {
if ($_GET['msg'] === 'guardado') {
$mensajeCreador = "Cambios guardados correctamente en la base de datos.";
$tipoAlertaCreador = "success";
} elseif ($_GET['msg'] === 'eliminado') {
$mensajeCreador = "Usuario eliminado correctamente.";
$tipoAlertaCreador = "warning";
}
}

$usuariosList = listarUsuariosCreador($conexion);
$puestosRes = $conexion->query("SELECT id, nombre_puesto FROM puestos ORDER BY id ASC");
$puestosArr = [];
if ($puestosRes) {
while ($p = $puestosRes->fetch_assoc()) {
$puestosArr[] = $p;
}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lista de Usuarios - Creador</title>
<!-- Documentación Bootstrap: https://getbootstrap.com/docs/6.0/getting-started/install/ -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
<div class="d-flex justify-content-between align-items-center mb-4">
<h3 class="mb-0 fw-bold">Lista de Usuarios</h3>
<a href="../formularios/alta.php?tipo=usuario" class="btn btn-success btn-sm">Nuevo Usuario</a>
</div>

<?php if ($mensajeCreador !== ""): ?>
<div class="alert alert-<?= htmlspecialchars($tipoAlertaCreador) ?> alert-dismissible fade show" role="alert">
<?= htmlspecialchars($mensajeCreador) ?>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="table-responsive">
<table class="table table-bordered table-hover align-middle bg-white">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Nombre Completo</th>
<th>Usuario</th>
<th>Puesto</th>
<th>Contraseña</th>
<th>Estado</th>
<th>Estatus</th>
<th>Acción</th>
</tr>
</thead>
<tbody>
<?php if (count($usuariosList) > 0): ?>
<?php foreach ($usuariosList as $idx => $u): ?>
<?php
$idFila = $idx + 1;
$activo = (trim((string)$u['estatus']) === 'Activo');
$formId = 'form_usr_' . $idFila;
?>
<tr>
<td>
<?= (int)$u['id_usuario'] ?>
<input type="hidden" name="id_usuario" value="<?= (int)$u['id_usuario'] ?>" form="<?= $formId ?>">
<input type="hidden" name="permiso_valor" id="permiso_valor_<?= $idFila ?>" value="<?= $activo ? '1' : '0' ?>" form="<?= $formId ?>">
</td>
<td><?= htmlspecialchars($u['nombre_completo']) ?></td>
<td><strong><?= htmlspecialchars($u['usuario']) ?></strong></td>
<td>
<select name="id_puesto" class="form-select form-select-sm" form="<?= $formId ?>">
<?php foreach ($puestosArr as $p): ?>
<option value="<?= (int)$p['id'] ?>" <?= (int)$u['id_puesto'] === (int)$p['id'] ? 'selected' : '' ?>>
<?= htmlspecialchars($p['nombre_puesto']) ?>
</option>
<?php endforeach; ?>
</select>
</td>
<td>
<div class="input-group input-group-sm" style="min-width: 190px;">
<input type="password" class="form-control form-control-sm font-monospace bg-white" id="creador_pass_<?= $idFila ?>" value="<?= htmlspecialchars($u['password']) ?>" readonly>
<button class="btn btn-outline-secondary" type="button" onclick="togglePassCreador(<?= $idFila ?>)" title="Ver / Ocultar">
<i class="bi bi-eye-slash-fill" id="creador_icon_<?= $idFila ?>"></i>
</button>
</div>
</td>
<td>
<div class="form-check form-switch">
<input class="form-check-input" type="checkbox" role="switch" id="permiso_<?= $idFila ?>" name="permiso_switch" <?= $activo ? 'checked' : '' ?> onchange="sincronizarSwitchConEstatus(<?= $idFila ?>)" form="<?= $formId ?>">
<label class="form-check-label" for="permiso_<?= $idFila ?>" id="lbl_permiso_<?= $idFila ?>">
<?= $activo ? 'puede ingresar' : 'no ingresa' ?>
</label>
</div>
</td>
<td>
<select name="estatus" id="estatus_<?= $idFila ?>" class="form-select form-select-sm" onchange="sincronizarEstatusConSwitch(<?= $idFila ?>)" form="<?= $formId ?>">
<option value="Activo" <?= $activo ? 'selected' : '' ?>>Activo</option>
<option value="Inactivo" <?= !$activo ? 'selected' : '' ?>>Inactivo</option>
</select>
</td>
<td class="text-nowrap">
<form method="POST" id="<?= $formId ?>" class="d-inline">
<button type="submit" class="btn btn-primary btn-sm">Guardar</button>
</form>
<a href="../formularios/modificar.php?tipo=usuario&id=<?= (int)$u['id_usuario'] ?>" class="btn btn-success btn-sm">Editar</a>
<a href="?eliminar=<?= (int)$u['id_usuario'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">Eliminar</a>
</td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
<td colspan="8" class="text-center text-muted py-3">No hay usuarios registrados.</td>
</tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassCreador(id) {
const input = document.getElementById('creador_pass_' + id);
const icon = document.getElementById('creador_icon_' + id);
if (input.type === 'password') {
input.type = 'text';
icon.className = 'bi bi-eye-fill';
} else {
input.type = 'password';
icon.className = 'bi bi-eye-slash-fill';
}
}

function sincronizarSwitchConEstatus(id) {
const sw = document.getElementById('permiso_' + id);
const sel = document.getElementById('estatus_' + id);
const lbl = document.getElementById('lbl_permiso_' + id);
const val = document.getElementById('permiso_valor_' + id);
if (sw.checked) {
sel.value = 'Activo';
lbl.textContent = 'puede ingresar';
val.value = '1';
} else {
sel.value = 'Inactivo';
lbl.textContent = 'no ingresa';
val.value = '0';
}
}

function sincronizarEstatusConSwitch(id) {
const sw = document.getElementById('permiso_' + id);
const sel = document.getElementById('estatus_' + id);
const lbl = document.getElementById('lbl_permiso_' + id);
const val = document.getElementById('permiso_valor_' + id);
const esActivo = (sel.value === 'Activo');
sw.checked = esActivo;
lbl.textContent = esActivo ? 'puede ingresar' : 'no ingresa';
val.value = esActivo ? '1' : '0';
}
</script>
</body>
</html>
<?php
}