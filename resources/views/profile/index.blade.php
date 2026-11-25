
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil | Deluxe Store</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3eef9;
            margin: 0;
            padding: 30px;
        }

        .contenedor {
            background: white;
            max-width: 550px;
            margin: auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.10);
        }

        h1 {
            color: #7041a6;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 11px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 7px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 13px;
            margin-top: 25px;
            background: #8052b5;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
        }

        .mensaje {
            color: green;
            text-align: center;
        }

        .errores {
            color: red;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h1>Mi perfil</h1>

    @if (session('success'))
        <p class="mensaje">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div class="errores">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">

        @csrf
        @method('PUT')

        <label>Nombre completo</label>
        <input type="text" name="nombre"
            value="{{ old('nombre', $usuario->nombre) }}" required>

        <label>Correo electrónico</label>
        <input type="email"
            value="{{ $usuario->correo }}" disabled>

        <label>Teléfono</label>
        <input type="text" name="telefono"
            value="{{ old('telefono', $usuario->telefono) }}">

        <label>Dirección</label>
        <input type="text" name="direccion"
            value="{{ old('direccion', $usuario->direccion) }}">

        <label>Ciudad</label>
        <input type="text" name="ciudad"
            value="{{ old('ciudad', $usuario->ciudad) }}">

        <label>Departamento</label>
        <input type="text" name="departamento"
            value="{{ old('departamento', $usuario->departamento) }}">

        <button type="submit">Guardar cambios</button>

    </form>

</div>

</body>
</html>
