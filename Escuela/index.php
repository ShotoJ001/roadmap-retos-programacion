<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title>Sistema de Control Escolar</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:Arial, sans-serif; }
body { background:#f8f9fa; line-height:1.6; }

/* Barra de Navegación */
.barra { background:#2c3e50; color:#fff; padding:0; position:sticky; top:0; z-index:100; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
.logo { display:inline-block; padding:15px 25px; font-size:18px; font-weight:bold; color:#fff; text-decoration:none; }
.menu { display:inline-block; }
.menu > ul { list-style:none; display:flex; }
.menu > ul > li { position:relative; }
.menu > ul > li > a { display:block; padding:15px 20px; color:#fff; text-decoration:none; transition:background 0.2s; }
.menu > ul > li > a:hover { background:#34495e; }

/* Submenús desplegables */
.submenu { position:absolute; left:0; top:100%; background:#fff; min-width:200px; display:none; box-shadow:0 4px 8px rgba(0,0,0,0.15); border-radius:0 0 4px 4px; }
.submenu a { display:block; padding:10px 20px; color:#2c3e50; text-decoration:none; border-bottom:1px solid #eee; transition:background 0.2s; }
.submenu a:last-child { border-bottom:none; }
.submenu a:hover { background:#ecf0f1; color:#2980b9; }
.menu > ul > li:hover .submenu { display:block; }

/* Contenido */
.contenido { padding:40px 30px; max-width:1200px; margin:0 auto; }
.contenido h1 { color:#2c3e50; margin-bottom:10px; font-size:26px; }
.contenido p { color:#7f8c8d; font-size:16px; }
</style>
</head>
<body>

<!-- 🔹 Barra de Navegación Superior -->
<nav class="barra">
    <a href="index.php" class="logo">🏫 SISTEMA ESCOLAR</a>
    
    <div class="menu">
        <ul>
            <!-- CATÁLOGOS -->
            <li>
                <a href="#">Catálogos ▾</a>
                <div class="submenu">
                    <a href="catalogos/alumnos.php">👤 Alumnos</a>
                    <a href="catalogos/grupos.php">👥 Grupos</a>
                    <a href="catalogos/materias.php">📚 Materias</a>
                    <a href="catalogos/profesores.php">👨‍🏫 Profesores</a>
                </div>
            </li>
            
            <!-- REGISTRAR -->
            <li>
                <a href="#">Registrar ▾</a>
                <div class="submenu">
                    <a href="registro/alumnos.php">👤 Alumnos</a>
                    <a href="registro/grupos.php">👥 Grupos</a>
                    <a href="registro/materias.php">📚 Materias</a>
                    <a href="registro/profesores.php">👨‍🏫 Profesores</a>
                </div>
            </li>
            
            <!-- MODIFICAR -->
            <li>
                <a href="#">Modificar ▾</a>
                <div class="submenu">
                    <a href="modificacion/alumnos.php">👤 Alumnos</a>
                    <a href="modificacion/grupos.php">👥 Grupos</a>
                    <a href="modificacion/materias.php">📚 Materias</a>
                    <a href="modificacion/profesores.php">👨‍🏫 Profesores</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<!-- 🔹 Contenido Principal -->
<div class="contenido">
    <h1>Bienvenido al Sistema de Control Escolar</h1>
    <p>Selecciona una opción desde la barra de menú de arriba.</p>
</div>

</body>
</html>