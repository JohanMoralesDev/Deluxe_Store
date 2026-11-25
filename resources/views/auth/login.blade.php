
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | Deluxe Store</title>

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
            width: 400px;
            max-width: 92%;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.10);
        }

        h1 {
            text-align: center;
            color: #7041a6;
        }

        label {
            display: block;
            margin-top: 18px;
            font-weight: bold;
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
        }

        .errores {
            color: #a00000;
        }

        .enlace {
            text-align: center;
            margin-top: 20px;
        }

        a {
            color: #8052b5;
        }
    </style>
</head>

<body>

    <div class="contenedor">

        <h1>Deluxe Store</h1>
        <p>Inicia sesión en tu cuenta</p>

        @if ($errors->any())
            <div class="errores">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.store') }}" method="POST">
            @csrf

            <label>Correo electrónico</label>
            <input
                type="email"
                name="correo"
                value="{{ old('correo') }}"
                required
            >

            <label>Contraseña</label>
            <input
                type="password"
                name="contrasena"
                required
            >

            <label>
                <input type="checkbox" name="recordar" value="1">
                Recordarme
            </label>

            <button type="submit">Iniciar sesión</button>
        </form>

        <div class="enlace">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}">Regístrate</a>
        </div>

    </div>

</body>
</html>
