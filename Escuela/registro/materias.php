<?php include '../conexion.php';

$profesores = mysqli_query($conexion, "SELECT id_prof, nom_prof, apaterno_prof FROM profesores ORDER BY apaterno_prof");
$mensaje = "";

if ($_POST) {
    $descripcion = trim($_POST['descripcion']);
    $clave_mat = trim($_POST['clave_mat']);
    $creditos = (int)$_POST['creditos'];
    $id_prof = (int)$_POST['id_prof'];
    
   $sql = "INSERT INTO materias (id_mat, descripcion, clave_mat, creditos, id_prof, estatus) 
            VALUES (NULL, '$descripcion', '$clave_mat', $creditos, $id_prof, 'Activo')";
    
    if (mysqli_query($conexion, $sql)) {
        $mensaje = "✅ Materia registrada correctamente";
    } else {
        $mensaje = "❌ Error: " . mysqli_error($conexion);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Registro de Materias</title>
<style>
body{font-family:Arial;margin:30px;background:#f8f9fa}
h2{color:#5b21b6}
.caja{max-width:500px;background:#fff;padding:25px;border-radius:8px;box-shadow:0 0 10px #ccc}
.error{background:#fee2e2;color:#b91c1c;padding:10px;border-radius:4px;margin-bottom:15px}
.ok{background:#dcfce7;color:#166534;padding:10px;border-radius:4px;margin-bottom:15px}
label{display:block;margin:15px 0 5px;font-weight:bold}
input,select{width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;box-sizing:border-box}
button{background:#7c3aed;color:#fff;border:none;padding:12px 25px;border-radius:4px;cursor:pointer;font-size:16px;margin-top:15px}
a{color:#5b21b6;text-decoration:none}
</style>
</head>
<body>

<h2>📚 Registro de Materias</h2>

<?php if ($mensaje): ?>
<div class="<?= str_starts_with($mensaje,'✅')?'ok':'error' ?>"><?= $mensaje ?></div>
<?php endif; ?>

<div class="caja">
<form method="post">
<label>Nombre / Descripción de la Materia:</label>
<input type="text" name="descripcion" required>

<label>Clave de la Materia:</label>
<input type="text" name="clave_mat" required placeholder="Ej: MAT-001">

<label>Créditos:</label>
<input type="number" name="creditos" required min="1">

<label>Profesor:</label>
<select name="id_prof" required>
<option value="">-- Selecciona --</option>
<?php while ($p = mysqli_fetch_assoc($profesores)): ?>
<option value="<?= $p['id_prof'] ?>">
    <?= $p['nom_prof'] ?> <?= $p['apaterno_prof'] ?>
</option>
<?php endwhile; ?>
</select>

<button type="submit">Guardar Materia</button>
</form>
</div>

<p><a href="../procesos/materias.php">📋 Ver Lista</a></p>
<p><a href="../index.php">← Volver al Inicio</a></p>

</body>
</html>