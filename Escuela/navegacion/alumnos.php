<?php include '../conexion.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$actual = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT a.*, g.grupo FROM alumnos a LEFT JOIN grupos g ON a.id_grupo = g.id_grupo WHERE a.id = $id"));
$anterior = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT MAX(id) as id FROM alumnos WHERE id < $id"))['id'];
$siguiente = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT MIN(id) as id FROM alumnos WHERE id > $id"))['id'];
$primero = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT MIN(id) as id FROM alumnos"))['id'];
$ultimo = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT MAX(id) as id FROM alumnos"))['id'];
?>
<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Navegación Alumnos</title>
<style>body{font-family:Arial;margin:30px;background:#f8f9fa}.ficha{background:#fff;padding:25px;border-radius:10px;box-shadow:0 0 15px #ccc;max-width:500px;margin:0 auto}.campo{margin:10px 0;padding:8px;border-bottom:1px solid #ddd}.etiqueta{font-weight:bold;color:#00bcd4}h2{text-align:center;color:#00bcd4}.navegacion{text-align:center;margin-top:20px}.btn{display:inline-block;padding:10px 15px;margin:5px;background:#00bcd4;color:#fff;text-decoration:none;border-radius:5px}.btn:disabled{background:#ccc;cursor:not-allowed}</style></head>
<body>
<h2>🧭 Navegación — Alumnos</h2>
<div class="ficha">
<?php if ($actual): ?>
<div class="campo"><span class="etiqueta">ID:</span> <?=$actual['id']?></div>
<div class="campo"><span class="etiqueta">Nombre:</span> <?=$actual['nombre']?></div>
<div class="campo"><span class="etiqueta">Apellido Paterno:</span> <?=$actual['apaterno']?></div>
<div class="campo"><span class="etiqueta">Apellido Materno:</span> <?=$actual['amaterno']?></div>
<div class="campo"><span class="etiqueta">Domicilio:</span> <?=$actual['dom']?></div>
<div class="campo"><span class="etiqueta">Correo:</span> <?=$actual['mail']?></div>
<div class="campo"><span class="etiqueta">Teléfono:</span> <?=$actual['tel']?></div>
<div class="campo"><span class="etiqueta">Grupo:</span> <?=$actual['grupo']?></div>
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