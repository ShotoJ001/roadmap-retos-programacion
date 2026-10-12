<?php include '../conexion.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $dato = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM profesores WHERE id_prof=$id"));
}

if (isset($_POST['baja']) && $id > 0) {
    mysqli_query($conexion, "DELETE FROM profesores WHERE id_prof=$id");
    header("Location: ../procesos/profesores.php?msg=baja");
    exit;
}

if (isset($_POST['editar']) && $id > 0) {
    $nom_prof = $_POST['nom_prof'];
    $apaterno_prof = $_POST['apaterno_prof'];
    $amaterno_prof = $_POST['amaterno_prof'];
    $dom_prof = $_POST['dom_prof'];
    $mail_prof = $_POST['mail_prof'];
    $tel_prof = $_POST['tel_prof'];
    $estatus_prof = $_POST['estatus_prof'];

    mysqli_query($conexion, "UPDATE profesores SET 
        nom_prof='$nom_prof', apaterno_prof='$apaterno_prof', amaterno_prof='$amaterno_prof',
        dom_prof='$dom_prof', mail_prof='$mail_prof', tel_prof='$tel_prof', estatus_prof='$estatus_prof'
        WHERE id_prof=$id");
    
    header("Location: ../procesos/profesores.php?msg=editado");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Editar y Baja — Profesor</title>
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

<h2>Editar y Dar de Baja — Profesor</h2>

<div class="form-editar">
<h3>✏️ Editar Datos</h3>
<form method="post">
Nombre:
<input type="text" name="nom_prof" value="<?= $dato['nom_prof'] ?>" required>
Apellido Paterno:
<input type="text" name="apaterno_prof" value="<?= $dato['apaterno_prof'] ?>" required>
Apellido Materno:
<input type="text" name="amaterno_prof" value="<?= $dato['amaterno_prof'] ?>">
Domicilio:
<input type="text" name="dom_prof" value="<?= $dato['dom_prof'] ?>">
Correo:
<input type="email" name="mail_prof" value="<?= $dato['mail_prof'] ?>">
Teléfono:
<input type="text" name="tel_prof" value="<?= $dato['tel_prof'] ?>">
Estatus:
<select name="estatus_prof">
    <option <?= $dato['estatus_prof']=='Activo'?'selected':'' ?>>Activo</option>
    <option <?= $dato['estatus_prof']=='Inactivo'?'selected':'' ?>>Inactivo</option>
</select>
<button type="submit" name="editar" class="btn-guardar">💾 Guardar Cambios</button>
</form>
</div>

<div class="caja">
<h3>🗑️ Dar de Baja</h3>
<div class="aviso">⚠️ Se eliminará permanentemente.</div>
<p><strong>Nombre:</strong> <?= $dato['nom_prof'] ?> <?= $dato['apaterno_prof'] ?><br>
<strong>Correo:</strong> <?= $dato['mail_prof'] ?></p>
<form method="post">
<button type="submit" name="baja" class="btn-baja">✅ Confirmar Baja</button>
<a href="../procesos/profesores.php" class="btn-volver">← Cancelar</a>
</form>
</div>

<?php else: ?>
<h2>Baja de Profesores</h2>
<p>No se seleccionó ningún profesor.</p>
<a href="../procesos/profesores.php">← Volver</a>
<?php endif; ?>

</body>
</html>