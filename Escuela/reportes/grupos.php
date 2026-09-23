<?php
$servidor = "localhost"; $usuario = "root"; $clave = ""; $base = "Escuela"; $puerto = 3307;
$conexion = mysqli_connect($servidor,$usuario,$clave,$base,$puerto);
if (!$conexion) die("❌ Conexión: ".mysqli_connect_error());
$grupos = mysqli_query($conexion,"SELECT * FROM grupos ORDER BY grupo");
$total = mysqli_num_rows($grupos);
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Reporte Grupos</title>
<style>body{font-family:Arial;margin:30px;background:#fff}h1{text-align:center;color:#27ae60;border-bottom:2px solid #27ae60;padding-bottom:10px}table{border-collapse:collapse;width:100%;margin-top:20px}th{background:#27ae60;color:#fff;padding:12px;text-align:left;border:1px solid #ccc}td{border:1px solid #ccc;padding:10px}tr:nth-child(even){background:#f9f9f9}.total{margin-top:15px;font-weight:bold}@media print{button,a{display:none}}</style></head>
<body>
<h1>📄 REPORTE DE GRUPOS</h1>
<table>
<tr><th>ID</th><th>Alumno</th><th>Grupo</th><th>Matrícula</th><th>Carrera</th><th>Semestre</th><th>Estatus</th></tr>
<?php while($g=mysqli_fetch_assoc($grupos)): ?>
<tr>
<td><?=$g['id_grupo']?></td><td><?=$g['nombre_alumno']?></td><td><?=$g['grupo']?></td><td><?=$g['matricula']?></td><td><?=$g['carrera']?></td><td><?=$g['semestre']?></td><td><?=$g['estatus_grupo']?></td>
</tr>
<?php endwhile; ?>
</table>
<p class='total'>Total de registros: <?=$total?></p>
<button onclick='window.print()'>🖨️ Imprimir</button>
<a href='../procesos/grupos.php'>← Volver</a>
</body></html>