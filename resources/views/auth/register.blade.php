<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario - Estanco POS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-white">

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="#">Esquina Del Movimiento</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav" aria-controls="navbarNav" 
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/login">Inicio de sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="/register">Registro</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Formulario de registro -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header text-center fw-bold bg-light">Registro de usuario</div>
                    <div class="card-body bg-white">
                        <form method="POST" action="/register">
                            <!-- Token CSRF simulado -->
                            <input type="hidden" name="_token" value="TOKEN_AQUI">

                            <!-- Nombre -->
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Nombre</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" required autofocus>
                                </div>
                            </div>

                            <!-- Usuario -->
                            <div class="mb-3 row">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Usuario</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" required>
                                </div>
                            </div>

                            <!-- Contraseña -->
                            <div class="mb-3 row">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Contraseña</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                            </div>

                            <!-- Confirmar contraseña -->
                            <div class="mb-3 row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmar Contraseña</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <!-- Acordeón de rol -->
                            <div class="accordion mb-3" id="roleAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingRole">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                                                data-bs-target="#collapseRole" aria-expanded="true" aria-controls="collapseRole">
                                            Seleccionar Rol
                                        </button>
                                    </h2>
                                    <div id="collapseRole" class="accordion-collapse collapse show" aria-labelledby="headingRole" data-bs-parent="#roleAccordion">
                                        <div class="accordion-body">
                                            <select name="role" class="form-select" required>
                                                <option value="">-- Selecciona un rol --</option>
                                                <option value="empleado">Empleado</option>
                                                <option value="admin">Administrador</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón de registro -->
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Registrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>