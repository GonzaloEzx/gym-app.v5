<?php
session_start();

// Verificar si el usuario tiene acceso
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirigir si no es admin
    exit();
}

// Configuración de la base de datos
$host = 'localhost';
$db = 'u347774250_gym';
$user = 'root';
$password = '';

try {
    // Conectar a la base de datos
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si se envió el formulario para crear un manager
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $role = 'manager'; // Siempre será manager

        if (!empty($username) && !empty($password)) {
            // Encriptar la contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insertar el nuevo manager
            $stmt = $pdo->prepare('INSERT INTO users (username, password, role, created_at) VALUES (:username, :password, :role, NOW())');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $role);
            $stmt->execute();

            $success = 'Manager creado exitosamente.';
        } else {
            $error = 'Por favor, complete todos los campos.';
        }
    }

    // Obtener todos los managers
    $stmt = $pdo->query('SELECT user_id, username, created_at FROM users WHERE role = "manager"');
    $managers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Gym App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">Panel de Administración</h1>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Formulario para crear managers -->
        <div class="card mb-4">
            <div class="card-header">Crear Nuevo Manager</div>
            <div class="card-body">
                <form action="admin_dashboard.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear Manager</button>
                </form>
            </div>
        </div>

        <!-- Lista de managers -->
        <div class="card">
            <div class="card-header">Managers Existentes</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre de Usuario</th>
                            <th>Fecha de Creación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($managers as $manager): ?>
                            <tr>
                                <td><?php echo $manager['user_id']; ?></td>
                                <td><?php echo $manager['username']; ?></td>
                                <td><?php echo $manager['created_at']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
