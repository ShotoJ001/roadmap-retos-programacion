<?php
$servidor = "localhost"; $usuario = "root"; $clave = ""; $base = "Escuela"; $puerto = 3307;
$conexion = mysqli_connect($servidor,$usuario,$clave,$base,$puerto);
if (!$conexion) die("❌ Conexión: ".mysqli_connect_error());
$profes = mysqli_query($conexion,"SELECT * FROM profesores ORDER BY apaterno_prof");
$total = mysqli_num_rows($profes);
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Reporte Profesores</title>
<style>body{font-family:Arial;margin:30px;background:#fff}h1{text-align:center;color:#e67e22;border-bottom:2px solid #e67e22;padding-bottom:10px}table{border-collapse:collapse;width:100%;margin-top:20px}th{background:#e67e22;color:#fff;padding:12px;text-align:left;border:1px solid #ccc}td{border:1px solid #ccc;padding:10px}tr:nth-child(even){background:#f9f9f9}.total{margin-top:15px;font-weight:bold}@media print{button,a{display:none}}</style></head>
<body>
<h1>📄 REPORTE DE PROFESORES</h1>
<table>
<tr><th>ID</th><th>Nombre Completo</th><th>Domicilio</th><th>Correo</th><th>Teléfono</th><th>Estatus</th></tr>
<?php while($p=mysqli_fetch_assoc($profes)): ?>
<tr>
<td><?=$p['id_prof']?></td>
<td><?=$p['apaterno_prof']?> <?=$p['amaterno_prof']?>, <?=$p['nom_prof']?></td>
<td><?=$p['dom_prof']?></td>
<td><?=$p['mail_prof']?></td>
<td><?=$p['tel_prof']?></td>
<td><?=$p['estatus_prof']?></td>
</tr>
<?php endwhile; ?>
</table>
<p class='total'>Total de profesores: <?=$total?></p>
<button onclick='window.print()'>🖨️ Imprimir</button>
<a href='../procesos/profesores.php'>← Volver</a>
</body></html>