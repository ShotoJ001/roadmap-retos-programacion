<?php include '../conexion.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $dato = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM alumnos WHERE id=$id"));
}

if (isset($_POST['baja']) && $id > 0) {
    mysqli_query($conexion, "DELETE FROM alumnos WHERE id=$id");
    header("Location: ../procesos/alumnos.php?msg=baja");
    exit;
}

if (isset($_POST['editar']) && $id > 0) {
    $nombre = $_POST['nombre'];
    $apaterno = $_POST['apaterno'];
    $amaterno = $_POST['amaterno'];
    $dom = $_POST['dom'];
    $mail = $_POST['mail'];
    $tel = $_POST['tel'];
    $id_grupo = $_POST['id_grupo'];

    mysqli_query($conexion, "UPDATE alumnos SET 
        nombre='$nombre', apaterno='$apaterno', amaterno='$amaterno',
        dom='$dom', mail='$mail', tel='$tel', id_grupo='$id_grupo'
        WHERE id=$id");
    
    header("Location: ../procesos/alumnos.php?msg=editado");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Editar y Baja — Alumno</title>
<style>
body{font-family:Arial;margin:30px;background:#f8f9fa}
h2{color:#dc3545}
.caja{max-width:500px;background:#fff;padding:25px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px}
.aviso{background:#f8d7da;color:#721c24;padding:15px;border-radius:4px;margin-bottom:20px}
.form-editar{background:#e3f2fd;padding:20px;border-radius:6px;margin-bottom:20px}
input,select{width:100%;padding:8px;margin:5px 0 15px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}
.btn-baja{padding:10px 20px;background:#dc3545;color:#fff;border:none;border-radius:4px;cursor:pointer}
.btn-guardar{padding:10px 20px;background:#007bff;color:#fff;border:none;border-radius:4px;cursor:pointer}
.btn-volver{padding:10px 20px;background:#6c757d;color:#fff;border:none;border-radius:4px;cursor:pointer;text-decoration:none;display:inline-block;margin-left:10px}
</style>
</head>
<body>

<?php if ($id > 0 && $dato): ?>

<h2>Editar y Dar de Baja — Alumno</h2>

<div class="form-editar">
<h3>✏️ Editar Datos</h3>
<form method="post">
Nombre:
<input type="text" name="nombre" value="<?= $dato['nombre'] ?>" required>
Apellido Paterno:
<input type="text" name="apaterno" value="<?= $dato['apaterno'] ?>" required>
Apellido Materno:
<input type="text" name="amaterno" value="<?= $dato['amaterno'] ?? '' ?>">
Domicilio:
<input type="text" name="dom" value="<?= $dato['dom'] ?? '' ?>">
Correo:
<input type="email" name="mail" value="<?= $dato['mail'] ?? '' ?>">
Teléfono:
<input type="text" name="tel" value="<?= $dato['tel'] ?? '' ?>">
ID Grupo:
<input type="number" name="id_grupo" value="<?= $dato['id_grupo'] ?? '' ?>">
<button type="submit" name="editar" class="btn-guardar">💾 Guardar Cambios</button>
</form>
</div>

<div class="caja">
<h3>🗑️ Dar de Baja</h3>
<div class="aviso">⚠️ Al dar de baja se eliminará permanentemente.</div>
<p><strong>Nombre:</strong> <?= $dato['nombre'] ?> <?= $dato['apaterno'] ?><br>
<strong>ID:</strong> <?= $dato['id'] ?></p>
<form method="post">
<button type="submit" name="baja" class="btn-baja">✅ Confirmar Baja</button>
<a href="../procesos/alumnos.php" class="btn-volver">← Cancelar</a>
</form>
</div>

<?php else: ?>
<h2>Baja de Alumnos</h2>
<p>No se seleccionó ningún alumno.</p>
<a href="../procesos/alumnos.php">← Volver</a>
<?php endif; ?>

</body>
</html>