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

    // Obtener todos los clientes
    $stmt = $pdo->query("SELECT * FROM clients");
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard - Gym App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">Panel de Gestión - <?php echo htmlspecialchars($_SESSION['username']); ?></h1>

        <!-- Sección de Clientes -->
        <div class="card mb-4">
            <div class="card-header">Clientes</div>
            <div class="card-body">
                <!-- Tabla de Clientes -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Estatus de Membresía</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $client): ?>
                            <tr>
                                <td><?php echo $client['client_id']; ?></td>
                                <td><?php echo htmlspecialchars($client['name']); ?></td>
                                <td><?php echo htmlspecialchars($client['email']); ?></td>
                                <td><?php echo htmlspecialchars($client['phone']); ?></td>
                                <td><?php echo htmlspecialchars($client['membership_status']); ?></td>
                                <td>
                                    <a href="edit_client.php?id=<?php echo $client['client_id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <a href="delete_client.php?id=<?php echo $client['client_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este cliente?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="add_client.php" class="btn btn-primary">Agregar Cliente</a>
            </div>
        </div>

        <!-- Sección de Membresías -->
        <div class="card">
            <div class="card-header">Membresías</div>
            <div class="card-body">
                <p>Gestión de membresías próximamente...</p>
            </div>
        </div>
    </div>
</body>
</html>
