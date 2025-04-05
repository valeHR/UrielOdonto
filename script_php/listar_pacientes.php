<?php
include 'conexion.php'; // Conexión a la base de datos

// Paginación
$registros_por_pagina = 5; 
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina > 1) ? ($pagina * $registros_por_pagina) - $registros_por_pagina : 0;

// Búsqueda
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : "";
$condicion = "";
if (!empty($busqueda)) {
    $condicion = "WHERE nombre LIKE '%$busqueda%' OR telefono LIKE '%$busqueda%' OR correo LIKE '%$busqueda%'";
}

// Obtener el total de registros
$sql_total = "SELECT COUNT(*) AS total FROM pacientes $condicion";
$result_total = mysqli_query($conn, $sql_total);
$total_pacientes = mysqli_fetch_assoc($result_total)['total'];
$total_paginas = ceil($total_pacientes / $registros_por_pagina);

// Obtener pacientes con paginación
$sql = "SELECT * FROM pacientes $condicion LIMIT $inicio, $registros_por_pagina";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Pacientes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Listado de Pacientes</h2>

    <!-- Barra de búsqueda -->
    <form method="GET" class="mb-3">
        <input type="text" name="busqueda" class="form-control" placeholder="Buscar por nombre, teléfono o correo" value="<?= htmlspecialchars($busqueda) ?>">
    </form>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($paciente = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $paciente['id'] ?></td>
                    <td><?= htmlspecialchars($paciente['nombre']) ?></td>
                    <td><?= $paciente['edad'] ?></td>
                    <td><?= htmlspecialchars($paciente['telefono']) ?></td>
                    <td><?= htmlspecialchars($paciente['correo']) ?></td>
                    <td>
                        <a href="editar_paciente.php?id=<?= $paciente['id'] ?>" class="btn btn-info btn-sm">Editar</a>
                        <a href="eliminar_paciente.php?id=<?= $paciente['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <li class="page-item <?= ($pagina == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="listar_pacientes.php?pagina=<?= $i ?>&busqueda=<?= htmlspecialchars($busqueda) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>
