<?php
$servidor = "localhost"; $usuario = "root"; $clave = ""; $base = "Escuela"; $puerto = 3307;
$conexion = mysqli_connect($servidor,$usuario,$clave,$base,$puerto);
if (!$conexion) die("❌ Conexión: ".mysqli_connect_error());
$materias = mysqli_query($conexion,"SELECT m.*,CONCAT(p.apaterno_prof,' ',p.amaterno_prof,', ',p.nom_prof) AS profesor FROM materias m JOIN profesores p ON m.id_prof=p.id_prof ORDER BY descripcion");
$total = mysqli_num_rows($materias);
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Reporte Materias</title>
<style>body{font-family:Arial;margin:30px;background:#fff}h1{text-align:center;color:#8e44ad;border-bottom:2px solid #8e44ad;padding-bottom:10px}table{border-collapse:collapse;width:100%;margin-top:20px}th{background:#8e44ad;color:#fff;padding:12px;text-align:left;border:1px solid #ccc}td{border:1px solid #ccc;padding:10px}tr:nth-child(even){background:#f9f9f9}.total{margin-top:15px;font-weight:bold}@media print{button,a{display:none}}</style></head>
<body>
<h1>📄 REPORTE DE MATERIAS</h1>
<table>
<tr><th>ID</th><th>Materia</th><th>Profesor Responsable</th></tr>
<?php while($m=mysqli_fetch_assoc($materias)): ?>
<tr><td><?=$m['id_mat']?></td><td><?=$m['descripcion']?></td><td><?=$m['profesor']?></td></tr>
<?php endwhile; ?>
</table>
<p class='total'>Total de materias: <?=$total?></p>
<button onclick='window.print()'>🖨️ Imprimir</button>
<a href='../procesos/materias.php'>← Volver</a>
</body></html>