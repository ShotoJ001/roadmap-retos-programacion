<?php include '../conexion.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$actual = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM grupos WHERE id_grupo = $id"));
$anterior = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT MAX(id_grupo) as id FROM grupos WHERE id_grupo < $id"))['id'];
$siguiente = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT MIN(id_grupo) as id FROM grupos WHERE id_grupo > $id"))['id'];
$primero = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT MIN(id_grupo) as id FROM grupos"))['id'];
$ultimo = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT MAX(id_grupo) as id FROM grupos"))['id'];
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Navegación Grupos</title>
<style>body{font-family:Arial;margin:30px;background:#f8f9fa}.ficha{background:#fff;padding:25px;border-radius:10px;box-shadow:0 0 15px #ccc;max-width:500px;margin:0 auto}.campo{margin:10px 0;padding:8px;border-bottom:1px solid #ddd}.etiqueta{font-weight:bold;color:#00bcd4}h2{text-align:center;color:#00bcd4}.navegacion{text-align:center;margin-top:20px}.btn{display:inline-block;padding:10px 15px;margin:5px;background:#00bcd4;color:#fff;text-decoration:none;border-radius:5px}.btn:disabled{background:#ccc;cursor:not-allowed}</style></head>
<body>
<h2>🧭 Navegación — Grupos</h2>
<div class="ficha">
<?php if ($actual): ?>
<div class="campo"><span class="etiqueta">ID:</span> <?=$actual['id_grupo']?></div>
<div class="campo"><span class="etiqueta">Grupo:</span> <?=$actual['grupo']?></div>
<div class="campo"><span class="etiqueta">Matrícula:</span> <?=$actual['matricula']?></div>
<div class="campo"><span class="etiqueta">Carrera:</span> <?=$actual['carrera']?></div>
<div class="campo"><span class="etiqueta">Semestre:</span> <?=$actual['semestre']?></div>
<div class="campo"><span class="etiqueta">Estatus:</span> <?=$actual['estatus_grupo']?></div>
<?php else: ?>
<p style="text-align:center;color:red">No existe el registro</p>
<?php endif; ?>
</div>
<div class="navegacion">
<a href="?id=<?=$primero?>" class="btn">⏮️ Primero</a>
<a href="?id=<?=$anterior?:$id?>" class="btn" style="background:<?=$anterior?'#00bcd4':'#ccc'?>">◀️ Anterior</a>
<a href="?id=<?=$siguiente?:$id?>" class="btn" style="background:<?=$siguiente?'#00bcd4':'#ccc'?>">Siguiente ▶️</a>
<a href="?id=<?=$ultimo?>" class="btn">Último ⏭️</a>
</div>
<p style="text-align:center;margin-top:20px"><a href='../index.php' style="color:#00bcd4">← Volver al Inicio</a></p>
</body></html>