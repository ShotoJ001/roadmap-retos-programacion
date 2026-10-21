<?php include '../conexion.php';
$alumnos = mysqli_query($conexion, "SELECT a.*, g.grupo FROM alumnos a LEFT JOIN grupos g ON a.id_grupo = g.id_grupo ORDER BY apaterno");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Catálogo Alumnos</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}h2{color:#16a085}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#16a085;color:#fff;padding:10px;text-align:left}td{border:1px solid #ddd;padding:10px}tr:nth-child(even){background:#f2f2f2}a{color:#2980b9;text-decoration:none}</style></head>
<body>
<h2>📋 Catálogo de Alumnos</h2>
<table>
<tr><th>ID</th><th>Nombre Completo</th><th>Correo</th><th>Teléfono</th><th>Grupo</th></tr>
<?php while ($a = mysqli_fetch_assoc($alumnos)): ?>
<tr>
<td><?=$a['id']?></td>
<td><?=$a['apaterno']?> <?=$a['amaterno']?>, <?=$a['nombre']?></td>
<td><?=$a['mail']?></td>
<td><?=$a['tel']?></td>
<td><?=$a['grupo']?></td>
</tr>
<?php endwhile; ?>
</table>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>