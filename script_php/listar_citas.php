<?php
// Conectar con la base de datos
$conexion = new mysqli("localhost", "root", "", "clinica_dental");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consultar todas las citas
$sql = "SELECT * FROM citas ORDER BY fecha, horario";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas Agendadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Citas Agendadas</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Motivo</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $resultado->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $fila['id']; ?></td>
                        <td><?php echo $fila['nombre']; ?></td>
                        <td><?php echo $fila['correo']; ?></td>
                        <td><?php echo $fila['telefono']; ?></td>
                        <td><?php echo $fila['fecha']; ?></td>
                        <td><?php echo $fila['horario']; ?></td>
                        <td><?php echo $fila['mensaje']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="../index.html" class="btn btn-primary">Volver al inicio</a>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conexion->close();
?>
