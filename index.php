<?php
// Configuración de conexión a la base de datos
$host = 'localhost';
$db = 'u347774250_gym';
$user = 'root';
$password = '';

try {
    // Conectar a la base de datos usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consultar todos los managers
    $stmt = $pdo->query("SELECT username FROM users WHERE role = 'manager'");
    $managers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gym App</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Container Principal -->
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
            <h2 class="text-center mb-4">Iniciar Sesión</h2>
            
            <!-- Formulario de Login -->
            <form action="login.php" method="POST">
                <!-- Dropdown de Usuario -->
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario:</label>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Seleccionar Usuario
                        </button>
                        <ul class="dropdown-menu w-100" aria-labelledby="userDropdown">
                            <!-- Opción para Admin -->
                            <li><a class="dropdown-item" href="#" onclick="selectUser('AdminGYM')">Admin GYM</a></li>
                            <!-- Opciones dinámicas para Managers -->
                            <?php foreach ($managers as $manager): ?>
                                <li><a class="dropdown-item" href="#" onclick="selectUser('<?php echo $manager['username']; ?>')">
                                    <?php echo $manager['username']; ?>
                                </a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <input type="hidden" id="username" name="username" required>
                </div>

                <!-- Campo de Contraseña -->
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script para manejar el Dropdown -->
    <script>
        function selectUser(userType) {
            document.getElementById('userDropdown').innerText = userType;  // Cambia el texto del botón
            document.getElementById('username').value = userType;         // Asigna el valor seleccionado al campo oculto
        }
    </script>

</body>
</html>
