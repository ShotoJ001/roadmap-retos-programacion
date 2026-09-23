<?php
$servidor = "localhost"; $usuario = "root"; $clave = ""; $base = "Escuela"; $puerto = 3307;
$conexion = mysqli_connect($servidor,$usuario,$clave,$base,$puerto);
if (!$conexion) die("❌ Conexión: ".mysqli_connect_error());

$mensaje = "";
if ($_POST) {
    $nom = $_POST['nombre_alumno']; $grp = $_POST['grupo']; $mat = $_POST['matricula'];
    $car = $_POST['carrera']; $sem = $_POST['semestre']; $est = $_POST['estatus_grupo'];
    $sql = "INSERT INTO grupos VALUES(NULL,'$nom','$grp','$mat','$car','$sem','$est')";
    $mensaje = mysqli_query($conexion,$sql) ? "✅ Grupo registrado" : "❌ Error: ".mysqli_error($conexion);
}
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Registro Grupos</title>
<style>body{font-family:Arial;margin:30px;background:#f8f9fa}form{max-width:500px;background:#fff;padding:25px;border-radius:8px;box-shadow:0 0 10px #ccc}input,select{width:100%;padding:8px;margin:5px 0 15px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}button{padding:10px 20px;background:#27ae60;color:#fff;border:none;border-radius:5px;cursor:pointer}a{color:#2980b9;text-decoration:none;display:inline-block;margin-top:15px}p{padding:10px;border-radius:4px;font-weight:bold}.ok{background:#d4edda;color:#155724}.err{background:#f8d7da;color:#721c24}</style></head>
<body><h2>📚 Registro de Grupos</h2>
<?php if($mensaje){?><p class="<?=strpos($mensaje,'✅')===0?'ok':'err'?>"><?=$mensaje?></p><?php }?>
<form method='post'>
Nombre del Alumno: <input type='text' name='nombre_alumno' required>
Grupo: <input type='text' name='grupo' placeholder='Ej: A1' required>
Matrícula: <input type='text' name='matricula' required>
Carrera: <input type='text' name='carrera' required>
Semestre: <input type='text' name='semestre' required>
Estatus: <select name='estatus_grupo'><option>Activo</option><option>Inactivo</option></select>
<button type='submit'>Guardar Grupo</button>
</form>
<a href='../procesos/grupos.php'>📋 Ver Lista</a><br>
<a href='../index.php'>← Volver al Inicio</a></body></html>