<?php include '../conexion.php';
if(isset($_GET['del'])){
    mysqli_query($conexion,"DELETE FROM calificaciones WHERE id_calif=".(int)$_GET['del']);
    header("Location: calificaciones.php"); exit;
}
if($_POST && isset($_POST['editar'])){
    $id=(int)$_POST['id'];
    $sql="UPDATE calificaciones SET calificacion='{$_POST['calificacion']}' WHERE id_calif=$id";
    mysqli_query($conexion,$sql);
    header("Location: calificaciones.php"); exit;
}
if($_POST && !isset($_POST['editar'])){
    $ida=$_POST['id_alumno']; $idm=$_POST['id_mat']; $idc=$_POST['id_ciclo']; $cal=$_POST['calificacion'];
    $sql="INSERT INTO calificaciones VALUES(NULL,'$ida','$idm','$idc','$cal')";
    mysqli_query($conexion,$sql);
    header("Location: calificaciones.php"); exit;
}
$editar=isset($_GET['edit'])?mysqli_fetch_assoc(mysqli_query($conexion,"SELECT * FROM calificaciones WHERE id_calif=".(int)$_GET['edit'])):null;
$calif=mysqli_query($conexion,"SELECT c.*, CONCAT(a.apaterno,' ',a.amaterno,', ',a.nombre) AS alumno, m.descripcion AS materia, ci.nombre_ciclo AS ciclo FROM calificaciones c JOIN alumnos a ON c.id_alumno=a.id JOIN materias m ON c.id_mat=m.id_mat JOIN ciclos ci ON c.id_ciclo=ci.id_ciclo ORDER BY alumno, materia");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Calificaciones</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}h2{color:#16a085}table{border-collapse:collapse;width:100%;background:#fff;margin:15px 0;box-shadow:0 0 10px #ccc}th{background:#16a085;color:#fff;padding:10px;text-align:left}td{border:1px solid #ddd;padding:10px}tr:nth-child(even){background:#f2f2f2}a{text-decoration:none}.edit{color:#e67e22}.del{color:#e74c3c}form{max-width:500px;background:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px}input,select{width:100%;padding:8px;margin:5px 0 12px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}button{padding:10px 20px;background:#16a085;color:#fff;border:none;border-radius:5px}</style></head>
<body>
<h2>📝 Control de Calificaciones</h2>
<?php if($editar): ?>
<h3>✏️ Editar Calificación</h3>
<form method='post'>
<input type='hidden' name='editar'><input type='hidden' name='id' value='<?=$editar['id_calif']?>'>
Calificación (0-10): <input type='number' step='0.01' min='0' max='10' name='calificacion' value='<?=$editar['calificacion']?>' required>
<button type='submit'>💾 Guardar</button>
</form>
<?php else: ?>
<h3>➕ Nueva Calificación</h3>
<form method='post'>
Alumno: <select name='id_alumno' required>
<option value=''>-- Selecciona --</option>
<?php $a=mysqli_query($conexion,"SELECT * FROM alumnos ORDER BY apaterno");
while($opt=mysqli_fetch_assoc($a)) echo "<option value='{$opt['id']}'>{$opt['apaterno']} {$opt['amaterno']}, {$opt['nombre']}</option>"; ?>
</select>
Materia: <select name='id_mat' required>
<option value=''>-- Selecciona --</option>
<?php $m=mysqli_query($conexion,"SELECT * FROM materias ORDER BY descripcion");
while($opt=mysqli_fetch_assoc($m)) echo "<option value='{$opt['id_mat']}'>{$opt['descripcion']}</option>"; ?>
</select>
Ciclo: <select name='id_ciclo' required>
<option value=''>-- Selecciona --</option>
<?php $c=mysqli_query($conexion,"SELECT * FROM ciclos ORDER BY nombre_ciclo");
while($opt=mysqli_fetch_assoc($c)) echo "<option value='{$opt['id_ciclo']}'>{$opt['nombre_ciclo']}</option>"; ?>
</select>
Calificación: <input type='number' step='0.01' min='0' max='10' name='calificacion' required>
<button type='submit'>💾 Registrar</button>
</form>
<?php endif; ?>

<table>
<tr><th>Alumno</th><th>Materia</th><th>Ciclo</th><th>Calificación</th><th>Acciones</th></tr>
<?php while($r=mysqli_fetch_assoc($calif)): ?>
<tr>
<td><?=$r