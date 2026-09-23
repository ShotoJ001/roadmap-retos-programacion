<?php
$servidor = "localhost"; $usuario = "root"; $clave = ""; $base = "Escuela"; $puerto = 3307;
$conexion = mysqli_connect($servidor,$usuario,$clave,$base,$puerto);
if (!$conexion) die("❌ Conexión: ".mysqli_connect_error());

$mensaje = "";
if ($_POST) {
    $nom = $_POST['nom_prof']; $apa = $_POST['apaterno_prof']; $ama = $_POST['amaterno_prof'];
    $dom = $_POST['dom_prof']; $mail = $_POST['mail_prof']; $tel = $_POST['tel_prof']; $est = $_POST['estatus_prof'];
    $sql = "INSERT INTO profesores VALUES(NULL,'$nom','$apa','$ama','$dom','$mail','$tel','$est')";
    $mensaje = mysqli_query($conexion,$sql) ? "✅ Profesor registrado" : "❌ Error: ".mysqli_error($conexion);
}
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Registro Profesores</title>
<style>body{font-family:Arial;margin:30px;background:#f8f9fa}form{max-width:500px;background:#fff;padding:25px;border-radius:8px;box-shadow:0 0 10px #ccc}input,select{width:100%;padding:8px;margin:5px 0 15px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}button{padding:10px 20px;background:#e67e22;color:#fff;border:none;border-radius:5px;cursor:pointer}a{color:#2980b9;text-decoration:none;display:inline-block;margin-top:15px}p{padding:10px;border-radius:4px;font-weight:bold}.ok{background:#d4edda;color:#155724}.err{background:#f8d7da;color:#721c24}</style></head>
<body><h2>👨‍🏫 Registro de Profesores</h2>
<?php if($mensaje){?><p class="<?=strpos($mensaje,'✅')===0?'ok':'err'?>"><?=$mensaje?></p><?php }?>
<form method='post'>
Nombre: <input type='text' name='nom_prof' required>
Apellido Paterno: <input type='text' name='apaterno_prof' required>
Apellido Materno: <input type='text' name='amaterno_prof'>
Domicilio: <input type='text' name='dom_prof'>
Correo: <input type='email' name='mail_prof'>
Teléfono: <input type='text' name='tel_prof'>
Estatus: <select name='estatus_prof'><option>Activo</option><option>Inactivo</option></select>
<button type='submit'>Guardar Profesor</button>
</form>
<a href='../procesos/profesores.php'>📋 Ver Lista</a><br>
<a href='../index.php'>← Volver al Inicio</a></body></html>