<?php include '../conexion.php';

// Obtener el ID de la materia
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$dato = null;

if ($id > 0) {
    $dato = mysqli_fetch_assoc(
        mysqli_query($conexion, "SELECT * FROM materias WHERE id_mat = $id")
    );
}

// ✅ ELIMINAR — BAJA
if (isset($_POST['confirmar_baja']) && $id > 0) {
    mysqli_query($conexion, "DELETE FROM materias WHERE id_mat = $id");
    header("Location: ../procesos/materias.php?msg=baja");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Baja de Materia</title>
<style>
body{font-family:Arial;margin:30px;background:#f8f9fa}
h2{color:#dc3545}
.caja{max-width:500px;background:#fff;padding:25px;border-radius:8px;box-shadow:0 0 10px #ccc}
.aviso{background:#fef2f2;color:#b91c1c;padding:15px;border-radius:4px;margin-bottom:20px;border-left:4px solid #dc3545}
.datos{background:#f9fafb;padding:15px;border-radius:4px;margin-bottom:20px}
.btn-baja{background:#dc3545;color:#fff;border:none;padding:12px 25px;border-radius:4px;cursor:pointer;font-size:16px}
.btn-volver{background:#6b7280;color:#fff;text-decoration:none;padding:12px 25px;border-radius:4px;display:inline-block;margin-left:10px}
</style>
</head>
<body>

<h2>🗑️ Baja de Materia</h2>

<?php if ($id > 0 && $dato): ?>

<div class="caja">
    <div class="aviso">
        ⚠️ <strong>¿Seguro que deseas eliminar esta materia?</strong><br>
        Esta acción no se puede deshacer.
    </div>

    <div class="datos">
        <p><strong>Clave:</strong> <?= $dato['clave_mat'] ?></p>
        <p><strong>Descripción / Nombre:</strong> <?= $dato['descripcion'] ?></p>
        <p><strong>Créditos:</strong> <?= $dato['creditos'] ?></p>
        <p><strong>Profesor asignado (ID):</strong> <?= $dato['id_prof'] ?></p>
    </div>

    <form method="post">
        <button type="submit" name="confirmar_baja" class="btn-baja">✅ Confirmar Baja</button>
        <a href="../procesos/materias.php" class="btn-volver">← Cancelar</a>
    </form>
</div>

<?php else: ?>

<div class="caja">
    <p>No se seleccionó ninguna materia.</p>
    <a href="../procesos/materias.php">← Volver a la lista de materias</a>
</div>

<?php endif; ?>

</body>
</html>