
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración | Deluxe Store</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3eef9;
            margin: 0;
            padding: 30px;
        }

        .contenedor {
            max-width: 1000px;
            margin: auto;
        }

        header {
            background: #7041a6;
            color: white;
            padding: 25px;
            border-radius: 15px;
        }

        .panel {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 25px;
        }

        .tarjeta {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .tarjeta h2 {
            color: #7041a6;
        }

        button {
            background: #7041a6;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 7px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <header>
        <h1>Panel de administración</h1>
        <p>Bienvenido a Deluxe Store</p>
    </header>

    <div class="panel">

        <div class="tarjeta">
            <h2>Productos</h2>
            <p>Gestiona el catálogo de productos.</p>
        </div>

        <div class="tarjeta">
            <h2>Inventario</h2>
            <p>Consulta y administra las existencias.</p>
        </div>

        <div class="tarjeta">
            <h2>Pedidos</h2>
            <p>Consulta y gestiona los pedidos.</p>
        </div>

        <div class="tarjeta">
            <h2>Reportes</h2>
            <p>Consulta información de las ventas.</p>
        </div>

    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>

</div>

</body>
</html>
