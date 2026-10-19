<?php include '../conexion.php';
$materias = mysqli_query($conexion, "SELECT m.*, CONCAT(p.apaterno_prof, ' ', p.amaterno_prof, ', ', p.nom_prof) AS profesor 
                                     FROM materias m 
                                     LEFT JOIN profesores p ON m.id_prof = p.id_prof 
                                     ORDER BY descripcion");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Catálogo Materias</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}h2{color:#16a085}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#16a085;color:#fff;padding:10px;text-align:left}td{border:1px solid #ddd;padding:10px}tr:nth-child(even){background:#f2f2f2}a{color:#2980b9;text-decoration:none}</style></head>
<body>
<h2>📋 Catálogo de Materias</h2>
<table>
<tr><th>ID</th><th>Materia</th><th>Profesor Asignado</th></tr>
<?php while ($m = mysqli_fetch_assoc($materias)): ?>
<tr>
<td><?=$m['id_mat']?></td>
<td><?=$m['descripcion']?></td>
<td><?=$m['profesor'] ?: 'Sin asignar'?></td>
</tr>
<?php endwhile; ?>
</table>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>