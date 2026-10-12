<?php include '../conexion.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Datos del grupo
if ($id > 0) {
    $dato = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM grupos WHERE id_grupo=$id"));
}

// Dar de Baja
if (isset($_POST['baja']) && $id > 0) {
    mysqli_query($conexion, "DELETE FROM grupos WHERE id_grupo=$id");
    header("Location: ../procesos/grupos.php?msg=baja");
    exit;
}

// Editar / Guardar cambios
if (isset($_POST['editar']) && $id > 0) {
    $Nombre = $_POST['Nombre'];
    $grupo = $_POST['grupo'];
    $matricula = $_POST['matricula'];
    $carrera = $_POST['carrera'];
    $semestre = $_POST['semestre'];
    $estatus_grupo = $_POST['estatus_grupo'];

    mysqli_query($conexion, "UPDATE grupos SET 
        Nombre='$Nombre',
        grupo='$grupo',
        matricula='$matricula',
        carrera='$carrera',
        semestre='$semestre',
        estatus_grupo='$estatus_grupo'
        WHERE id_grupo=$id");
    
    header("Location: ../procesos/grupos.php?msg=editado");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Baja y Editar — Grupo</title>
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
a{text-decoration:none}
</style>
</head>
<body>

<?php if ($id > 0 && $dato): ?>

<h2>Editar y Dar de Baja — Grupo</h2>

<!-- FORMULARIO DE EDICIÓN -->
<div class="form-editar">
<h3>✏️ Editar Datos</h3>
<form method="post">
Nombre:
<input type="text" name="Nombre" value="<?= $dato['Nombre'] ?>" required>
Grupo:
<input type="text" name="grupo" value="<?= $dato['grupo'] ?>" required>
Matrícula:
<input type="text" name="matricula" value="<?= $dato['matricula'] ?>" required>
Carrera:
<input type="text" name="carrera" value="<?= $dato['carrera'] ?>" required>
Semestre:
<input type="text" name="semestre" value="<?= $dato['semestre'] ?>" required>
Estatus:
<select name="estatus_grupo">
    <option <?= $dato['estatus_grupo']=='Activo'?'selected':'' ?>>Activo</option>
    <option <?= $dato['estatus_grupo']=='Inactivo'?'selected':'' ?>>Inactivo</option>
</select>
<button type="submit" name="editar" class="btn-guardar">💾 Guardar Cambios</button>
</form>
</div>

<!-- DAR DE BAJA -->
<div class="caja">
<h3>🗑️ Dar de Baja</h3>
<div class="aviso">⚠️ Al dar de baja se eliminará este registro permanentemente.</div>
<p><strong>Nombre:</strong> <?= $dato['Nombre'] ?><br>
<strong>Grupo:</strong> <?= $dato['grupo'] ?><br>
<strong>Matrícula:</strong> <?= $dato['matricula'] ?><br>
<strong>Carrera:</strong> <?= $dato['carrera'] ?></p>

<form method="post">
<button type="submit" name="baja" class="btn-baja">✅ Confirmar Baja</button>
<a href="../procesos/grupos.php" class="btn-volver">← Cancelar</a>
</form>
</div>

<?php else: ?>

<h2>Baja de Grupos</h2>
<p>No se seleccionó ningún grupo.</p>
<a href="../procesos/grupos.php">← Volver a Procesos</a>

<?php endif; ?>

</body>
</html>