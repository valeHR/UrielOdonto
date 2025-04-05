<?php
// Conectar con la base de datos
$conexion = new mysqli("localhost", "root", "", "clinica_dental");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$fecha = $_POST['fecha'];
$horario = $_POST['horario'];
$mensaje = $_POST['mensaje'];

// Preparar la consulta SQL para insertar la cita
$sql = "INSERT INTO citas (nombre, correo, telefono, fecha, horario, mensaje) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssssss", $nombre, $correo, $telefono, $fecha, $horario, $mensaje);

// Ejecutar la consulta y verificar si fue exitosa
if ($stmt->execute()) {
    echo "<script>alert('Cita agendada correctamente'); window.location.href='listar_citas.php';</script>";
} else {
    echo "<script>alert('Error al agendar la cita'); window.history.back();</script>";
}

// Cerrar la conexión
$stmt->close();
$conexion->close();
?>
