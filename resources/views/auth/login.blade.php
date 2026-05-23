@extends('layouts.guest')

@section('title', 'Iniciar Sesión')

@section('content')
<h5 class="text-center mb-4 text-secondary fw-semibold">Iniciar Sesión</h5>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
        <i class="fas fa-circle-exclamation me-1"></i>
        {{ $errors->first('usuario') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form method="POST" action="{{ route('login.post') }}">
    @csrf

    <div class="mb-3">
        <label for="usuario" class="form-label fw-semibold">
            <i class="fas fa-user me-1 text-primary"></i> Usuario
        </label>
        <input
            type="text"
            class="form-control @error('usuario') is-invalid @enderror"
            id="usuario"
            name="usuario"
            value="{{ old('usuario') }}"
            placeholder="usuario.sistema"
            autofocus
            autocomplete="username"
        >
    </div>

    <div class="mb-3">
        <label for="password" class="form-label fw-semibold">
            <i class="fas fa-lock me-1 text-primary"></i> Contraseña
        </label>
        <div class="input-group">
            <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                placeholder="••••••••"
                autocomplete="current-password"
            >
            <button type="button" class="btn btn-outline-secondary" id="togglePwd" tabindex="-1">
                <i class="fas fa-eye" id="eyeIcon"></i>
            </button>
        </div>
    </div>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label small" for="remember">Recordarme</label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 fw-semibold">
        <i class="fas fa-right-to-bracket me-1"></i> Ingresar
    </button>
</form>

<p class="text-center text-muted small mt-3 mb-0">
    Usuarios de prueba: <code>admin.municipal</code> / <code>operador.central</code>
</p>

<script>
document.getElementById('togglePwd').addEventListener('click', function () {
    const pwd  = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        pwd.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});
</script>
@endsection
