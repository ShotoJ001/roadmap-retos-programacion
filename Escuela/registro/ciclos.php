<?php include '../conexion.php';
$mensaje = "";
if ($_POST) {
    $nom = $_POST['nombre_ciclo']; $ini = $_POST['fecha_inicio']; $fin = $_POST['fecha_fin']; $est = $_POST['estatus_ciclo'];
    $sql = "INSERT INTO ciclos VALUES(NULL,'$nom','$ini','$fin','$est')";
    $mensaje = mysqli_query($conexion,$sql) ? "✅ Ciclo registrado" : "❌ Error: ".mysqli_error($conexion);
}
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Registro Ciclos</title>
<style>body{font-family:Arial;margin:30px;background:#f8f9fa}form{max-width:500px;background:#fff;padding:25px;border-radius:8px;box-shadow:0 0 10px #ccc}input,select{width:100%;padding:8px;margin:5px 0 15px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}button{padding:10px 20px;background:#16a085;color:#fff;border:none;border-radius:5px;cursor:pointer}a{color:#2980b9;text-decoration:none;display:inline-block;margin-top:15px}p{padding:10px;border-radius:4px;font-weight:bold}.ok{background:#d4edda;color:#155724}.err{background:#f8d7da;color:#721c24}</style></head>
<body><h2>📅 Registro de Ciclos Escolares</h2>
<?php if($mensaje){?><p class="<?=strpos($mensaje,'✅')===0?'ok':'err'?>"><?=$mensaje?></p><?php }?>
<form method='post'>
Nombre del Ciclo: <input type='text' name='nombre_ciclo' placeholder='Ej: 2026-2027' required>
Fecha de Inicio: <input type='date' name='fecha_inicio' required>
Fecha de Fin: <input type='date' name='fecha_fin' required>
Estatus: <select name='estatus_ciclo'><option>Activo</option><option>Inactivo</option></select>
<button type='submit'>Guardar Ciclo</button>
</form>
<a href='../procesos/ciclos.php'>📋 Ver Lista</a><br>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>