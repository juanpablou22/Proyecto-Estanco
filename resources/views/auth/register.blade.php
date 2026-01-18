@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-dark text-white text-center fw-bold">
                    Registro de usuario
                </div>

                <div class="card-body bg-white">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Nombre -->
                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nombre</label>
                            <div class="col-md-6">
                                <input id="name" type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Usuario -->
                        <div class="mb-3 row">
                            <label for="username" class="col-md-4 col-form-label text-md-end">Usuario</label>
                            <div class="col-md-6">
                                <input id="username" type="text"
                                       class="form-control @error('username') is-invalid @enderror"
                                       name="username" value="{{ old('username') }}" required>
                                @error('username')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Contraseña</label>
                            <div class="col-md-6">
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password" required>
                                @error('password')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirmar contraseña -->
                        <div class="mb-3 row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmar Contraseña</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password"
                                       class="form-control"
                                       name="password_confirmation" required>
                            </div>
                        </div>

                        <!-- Rol -->
                        <div class="mb-3 row">
                            <label for="role" class="col-md-4 col-form-label text-md-end">Rol</label>
                            <div class="col-md-6">
                                <select name="role" id="role"
                                        class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="">-- Selecciona un rol --</option>
                                    <option value="empleado" {{ old('role') == 'empleado' ? 'selected' : '' }}>Empleado</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                </select>
                                @error('role')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Botón de registro -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    Registrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection