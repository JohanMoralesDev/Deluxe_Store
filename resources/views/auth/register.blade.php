
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Deluxe Store</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3eef9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .contenedor {
            background: white;
            width: 420px;
            max-width: 92%;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.10);
        }

        h1 {
            text-align: center;
            color: #7041a6;
        }

        p {
            text-align: center;
            color: #777;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #444;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 7px;
            border: 1px solid #ccc;
            border-radius: 7px;
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
            font-size: 16px;
        }

        button:hover {
            background: #62378f;
        }

        .errores {
            background: #ffe5e5;
            color: #a00000;
            padding: 10px;
            border-radius: 7px;
        }

        .enlace {
            margin-top: 20px;
            text-align: center;
        }

        .enlace a {
            color: #8052b5;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="contenedor">

        <h1>Deluxe Store</h1>
        <p>¡Crea tu cuenta y disfruta de nuestra tienda!</p>

        @if ($errors->any())
            <div class="errores">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST">

            @csrf

            <label>Nombre completo</label>
            <input
                type="text"
                name="nombre"
                value="{{ old('nombre') }}"
                maxlength="150"
                required
            >

            <label>Correo electrónico</label>
            <input
                type="email"
                name="correo"
                value="{{ old('correo') }}"
                maxlength="150"
                required
            >

            <label>Contraseña</label>
            <input
                type="password"
                name="contrasena"
                minlength="8"
                required
            >

            <label>Confirmar contraseña</label>
            <input
                type="password"
                name="contrasena_confirmation"
                required
            >

            <button type="submit">Crear cuenta</button>

        </form>

        <div class="enlace">
            ¿Ya tienes una cuenta?
            <a href="{{ route('login') }}">Iniciar sesión</a>
        </div>

    </div>

</body>
</html>
