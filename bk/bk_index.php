<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gym App</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                    <label for="userType" class="form-label">Usuario:</label>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Seleccionar Usuario
                        </button>
                        <ul class="dropdown-menu w-100" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#" onclick="selectUser('Admin GYM')">Admin GYM</a></li>
                            <li><a class="dropdown-item" href="#" onclick="selectUser('Manager GYM')">Manager GYM</a></li>
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
            
            <!-- Botón para abrir el modal (opcional) -->
            <button type="button" class="btn btn-link w-100 mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                ¿Olvidaste tu contraseña?
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Recuperar Contraseña</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Ingrese su dirección de correo para recibir instrucciones de recuperación.
            <input type="email" class="form-control mt-2" placeholder="Correo electrónico">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary">Enviar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <!-- Script para manejar el Dropdown -->
    <script>
        function selectUser(userType) {
            document.getElementById('userDropdown').innerText = userType;  // Cambia el texto del botón
            document.getElementById('username').value = userType;         // Asigna el valor seleccionado al campo oculto
        }
    </script>

</body>
</html>
