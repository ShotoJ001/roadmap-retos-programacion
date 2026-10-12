<?php include '../conexion.php';
$grupos = mysqli_query($conexion, "SELECT * FROM grupos ORDER BY grupo");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Catálogo Grupos</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}h2{color:#16a085}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#16a085;color:#fff;padding:10px;text-align:left}td{border:1px solid #ddd;padding:10px}tr:nth-child(even){background:#f2f2f2}a{color:#2980b9;text-decoration:none}</style></head>
<body>
<h2>📋 Catálogo de Grupos</h2>
<table>
<tr><th>ID</th><th>Grupo</th><th>Matrícula</th><th>Carrera</th><th>Semestre</th><th>Estatus</th></tr>
<?php while ($g = mysqli_fetch_assoc($grupos)): ?>
<tr>
<td><?=$g['id_grupo']?></td>
<td><?=$g['grupo']?></td>
<td><?=$g['matricula']?></td>
<td><?=$g['carrera']?></td>
<td><?=$g['semestre']?></td>
<td><?=$g['estatus_grupo']?></td>
</tr>
<?php endwhile; ?>
</table>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>