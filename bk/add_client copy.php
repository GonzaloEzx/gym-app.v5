<?php
session_start();

// Verificar si el usuario tiene acceso
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
    header('Location: login.php'); // Redirigir si no es manager
    exit();
}

// Configuración de conexión a la base de datos
$host = 'localhost';
$db = 'u347774250_gym';
$user = 'root';
$password = '';

try {
    // Conectar a la base de datos
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Procesar el formulario cuando se envía
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $membership_status = trim($_POST['membership_status']);

        // Validar que los campos no estén vacíos
        if (!empty($name) && !empty($email) && !empty($membership_status)) {
            // Insertar el cliente en la base de datos
            $stmt = $pdo->prepare("INSERT INTO clients (name, email, phone, membership_status, registered_at) VALUES (:name, :email, :phone, :membership_status, NOW())");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':membership_status', $membership_status);
            $stmt->execute();

            $success = "Cliente agregado exitosamente.";
        } else {
            $error = "Por favor, complete todos los campos obligatorios.";
        }
    }
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente - Gym App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">Agregar Cliente</h1>

        <!-- Mensajes de éxito o error -->
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Formulario para agregar un cliente -->
        <div class="card">
            <div class="card-header">Formulario de Cliente</div>
            <div class="card-body">
                <form action="add_client.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="membership_status" class="form-label">Estatus de Membresía</label>
                        <select class="form-select" id="membership_status" name="membership_status" required>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Agregar Cliente</button>
                </form>
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="manager_dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </div>
    </div>
</body>
</html>
