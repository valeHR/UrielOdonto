<?php
include 'conexion.php';

// Obtener todos los pacientes para seleccionar uno
$sql = "SELECT * FROM pacientes";
$result = mysqli_query($conn, $sql);

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paciente_id = (int)$_POST['paciente_id'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $descripcion = $_POST['descripcion'];

    if (empty($paciente_id) || empty($fecha) || empty($hora)) {
        echo "<script>alert('Todos los campos son obligatorios');</script>";
    } else {
        // Insertar cita
        $sql_insert = "INSERT INTO citas (paciente_id, fecha, hora, descripcion) 
                        VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_insert);
        mysqli_stmt_bind_param($stmt, "isss", $paciente_id, $fecha, $hora, $descripcion);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Cita agendada correctamente'); window.location.href='listar_citas.php';</script>";
        } else {
            echo "Error al agendar cita: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Agendar Cita</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Paciente</label>
            <select name="paciente_id" class="form-control" required>
                <option value="">Seleccione un paciente</option>
                <?php while ($paciente = mysqli_fetch_assoc($result)): ?>
                    <option value="<?= $paciente['id'] ?>"><?= htmlspecialchars($paciente['nombre']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" class="form-control" name="fecha" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Hora</label>
            <input type="time" class="form-control" name="hora" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion"></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Agendar Cita</button>
        <a href="listar_citas.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
