<?php include '../conexion.php';
$mensaje = "";
if ($_POST) {
    $id_prof = (int)$_POST['id_prof'];
    $id_ciclo = (int)$_POST['id_ciclo'];
    
    $sql = "SELECT p.*, COUNT(DISTINCT m.id_mat) AS total_materias, 
                   COUNT(DISTINCT c.id_alumno) AS total_alumnos,
                   AVG(c.calificacion) AS promedio_general
            FROM profesores p
            LEFT JOIN materias m ON p.id_prof = m.id_prof
            LEFT JOIN calificaciones c ON m.id_mat = c.id_mat AND c.id_ciclo = $id_ciclo
            WHERE p.id_prof = $id_prof
            GROUP BY p.id_prof";
    
    $lista_prof = mysqli_query($conexion, $sql);
    $mensaje = "✅ Consulta realizada correctamente";
}

$consulta = "SELECT p.id_prof, CONCAT(p.apaterno_prof, ' ', p.amaterno_prof, ', ', p.nom_prof) AS profesor,
                    cic.nombre_ciclo,
                    COUNT(DISTINCT m.id_mat) AS total_materias,
                    COUNT(DISTINCT c.id_alumno) AS total_alumnos,
                    AVG(c.calificacion) AS promedio_asignado
             FROM profesores p
             LEFT JOIN materias m ON p.id_prof = m.id_prof
             LEFT JOIN calificaciones c ON m.id_mat = c.id_mat
             LEFT JOIN ciclos cic ON c.id_ciclo = cic.id_ciclo
             GROUP BY p.id_prof, cic.id_ciclo
             ORDER BY p.apaterno_prof";
$lista = mysqli_query($conexion, $consulta);
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Calificaciones por Profesor</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}h2{color:#f39c12}form{background:#fff;padding:20px;border-radius:8px;box-shadow:0 0 10px #ccc;margin-bottom:20px}select,input{width:100%;padding:8px;margin:5px 0 15px;box-sizing:border-box;border:1px solid #ddd;border-radius:4px}button{background:#f39c12;color:#fff;border:none;padding:10px 20px;border-radius:4px;cursor:pointer}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#f39c12;color:#fff;padding:10px;text-align:left}td{border:1px solid #ddd;padding:10px}tr:nth-child(even){background:#f2f2f2}.msg{padding:10px;border-radius:4px;margin:10px 0;font-weight:bold}.ok{background:#d4edda;color:#155724}.err{background:#f8d7da;color:#721c24}a{color:#2980b9;text-decoration:none}</style></head>
<body>
<h2>📝 Calificaciones por Profesor</h2>
<?php if ($mensaje): ?><div class="msg ok"><?=$mensaje?></div><?php endif; ?>
<form method='post'>
Profesor: <select name='id_prof' required>
<option value=''>-- Selecciona --</option>
<?php $res = mysqli_query($conexion, "SELECT * FROM profesores ORDER BY apaterno_prof");
while ($p = mysqli_fetch_assoc($res)) echo "<option value='{$p['id_prof']}'>{$p['apaterno_prof']} {$p['amaterno_prof']}, {$p['nom_prof']}</option>"; ?>
</select>
Ciclo Escolar: <select name='id_ciclo' required>
<option value=''>-- Selecciona --</option>
<?php $res = mysqli_query($conexion, "SELECT * FROM ciclos ORDER BY nombre_ciclo");
while ($c = mysqli_fetch_assoc($res)) echo "<option value='{$c['id_ciclo']}'>{$c['nombre_ciclo']}</option>"; ?>
</select>
<button type='submit'>📊 Ver Desempeño</button>
</form>
<h3>Resumen General</h3>
<table>
<tr><th>Profesor</th><th>Ciclo</th><th>Materias Impartidas</th><th>Alumnos Evaluados</th><th>Promedio General</th></tr>
<?php while ($r = mysqli_fetch_assoc($lista)): ?>
<tr>
<td><?=$r['profesor']?></td>
<td><?=$r['nombre_ciclo'] ?? 'Sin ciclo'?></td>
<td><?=$r['total_materias']?></td>
<td><?=$r['total_alumnos']?></td>
<td><strong><?=$r['promedio_asignado'] ? number_format($r['promedio_asignado'], 2) : 'Sin calificaciones'?></strong></td>
</tr>
<?php endwhile; ?>
</table>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>