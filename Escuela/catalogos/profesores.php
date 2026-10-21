<?php include '../conexion.php';
$profesores = mysqli_query($conexion, "SELECT * FROM profesores ORDER BY apaterno_prof");
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Catálogo Profesores</title>
<style>body{font-family:Arial;margin:20px;background:#f8f9fa}h2{color:#16a085}table{border-collapse:collapse;width:100%;background:#fff;box-shadow:0 0 10px #ccc}th{background:#16a085;color:#fff;padding:10px;text-align:left}td{border:1px solid #ddd;padding:10px}tr:nth-child(even){background:#f2f2f2}a{color:#2980b9;text-decoration:none}</style></head>
<body>
<h2>📋 Catálogo de Profesores</h2>
<table>
<tr><th>ID</th><th>Nombre Completo</th><th>Domicilio</th><th>Correo</th><th>Teléfono</th><th>Estatus</th></tr>
<?php while ($p = mysqli_fetch_assoc($profesores)): ?>
<tr>
<td><?=$p['id_prof']?></td>
<td><?=$p['apaterno_prof']?> <?=$p['amaterno_prof']?>, <?=$p['nom_prof']?></td>
<td><?=$p['dom_prof'] ?: 'No especificado'?></td>
<td><?=$p['mail_prof']?></td>
<td><?=$p['tel_prof'] ?: 'No especificado'?></td>
<td><?=$p['estatus_prof']?></td>
</tr>
<?php endwhile; ?>
</table>
<a href='../index.php'>← Volver al Inicio</a>
</body></html>