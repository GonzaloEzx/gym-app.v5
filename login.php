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

    // Verificar si los datos fueron enviados por POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Validar que los campos no estén vacíos
        if (!empty($username) && !empty($password)) {
            // Buscar el usuario en la base de datos
            $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            // Obtener el resultado
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Iniciar sesión y redirigir según el rol
                session_start();
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header('Location: admin_dashboard.php');
                } elseif ($user['role'] === 'manager') {
                    header('Location: manager_dashboard.php');
                }
                exit();
            } else {
                $error = 'Usuario o contraseña incorrectos.';
            }
        } else {
            $error = 'Por favor, complete todos los campos.';
        }
    }
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gym App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h2 class="text-center mb-4">Iniciar Sesión</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>
    </div>
</body>
</html>
