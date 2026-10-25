<?php 
include '../conexion.php';

// Consulta para obtener el catálogo completo de unidades
$unidades = mysqli_query($conexion, "SELECT * FROM unidades ORDER BY id_unidad");
if (!$unidades) { 
    die("❌ Error al consultar las unidades: " . mysqli_error($conexion)); 
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo — Unidades</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f8f9fa; }
        .contenedor { max-width: 800px; margin: 0 auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #3498db; color: #fff; padding: 12px; text-align: left; }
        td { border: 1px solid #ddd; padding: 10px; }
        tr:nth-child(even) { background: #f2f2f2; }
        .btn-inicio { display: inline-block; margin-top: 20px; color: #2980b9; text-decoration: none; font-weight: bold; }
        .btn-inicio:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>📖 Catálogo de Unidades</h2>

    <table>
        <thead>
            <tr>
                <th style="width: 80px;">ID</th>
                <th>Descripción de la Unidad</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($unidades) > 0): ?>
                <?php while ($u = mysqli_fetch_assoc($unidades)): ?>
                <tr>
                    <td><?= $u['id_unidad'] ?></td>
                    <td><?= htmlspecialchars($u['descripcion']) ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" style="text-align: center; color: #7f8c8d;">No hay unidades registradas en el catálogo.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="../index.php" class="btn-inicio">← Volver al Inicio</a>
</div>

</body>
</html>