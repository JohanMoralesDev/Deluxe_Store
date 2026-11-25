@extends('layouts.app')

@section('title', isset($checkout) && $checkout ? 'Finalizar compra - Deluxe Store' : 'Compra confirmada - Deluxe Store')

@section('content')
<main class="contenido-carrito">
    @if(isset($checkout) && $checkout)
        <h1 class="titulo-carrito">FINALIZAR COMPRA</h1>

        @if($errors->any())
            <div class="alerta alerta-error">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="carrito-layout">
            <section class="carrito-lista">
                <form method="POST" action="{{ route('checkout.store') }}">
                    @csrf
                    <label>Nombre del destinatario
                        <input type="text" name="nombre_destinatario" value="{{ old('nombre_destinatario', auth()->user()->nombre ?? '') }}" required>
                    </label>
                    <label>Teléfono
                        <input type="text" name="telefono_destinatario" value="{{ old('telefono_destinatario', auth()->user()->telefono ?? '') }}" required>
                    </label>
                    <label>Dirección
                        <input type="text" name="direccion_envio" value="{{ old('direccion_envio', auth()->user()->direccion ?? '') }}" required>
                    </label>
                    <label>Ciudad
                        <input type="text" name="ciudad_envio" value="{{ old('ciudad_envio', auth()->user()->ciudad ?? '') }}" required>
                    </label>
                    <label>Departamento
                        <input type="text" name="departamento_envio" value="{{ old('departamento_envio', auth()->user()->departamento ?? '') }}" required>
                    </label>
                    <label>Método de pago
                        <select name="metodo_pago" required>
                            <option value="CONTRAENTREGA">Contraentrega</option>
                            <option value="TRANSFERENCIA">Transferencia</option>
                        </select>
                    </label>
                    <label>Observaciones
                        <textarea name="observaciones">{{ old('observaciones') }}</textarea>
                    </label>
                    <button type="submit" class="boton-pagar">Confirmar compra</button>
                </form>
            </section>

            <aside class="resumen-pedido">
                <h2 class="resumen-titulo">Resumen</h2>
                @foreach($items as $item)
                    <p>{{ $item['quantity'] }} × {{ $item['product']->name }}</p>
                @endforeach
                <div class="resumen-fila resumen-total">
                    <span>Total</span>
                    <span>${{ number_format($total, 2, ',', '.') }}</span>
                </div>
            </aside>
        </div>
    @else
        <section class="carrito-vacio">
            <h1 class="titulo-carrito">COMPRA CONFIRMADA</h1>
            <p>Pedido <strong>{{ $order->numero_pedido }}</strong></p>
            <p>Estado: {{ $order->estado }}</p>

            <h2>Productos</h2>
            @foreach($order->details as $detail)
                <p>{{ $detail->cantidad }} × {{ $detail->nombre_producto }}
                    — ${{ number_format($detail->subtotal, 2, ',', '.') }}</p>
            @endforeach

            <p><strong>Total: ${{ number_format($order->total, 2, ',', '.') }}</strong></p>
            <a href="{{ route('orders.index') }}" class="boton-continuar">Ver mis pedidos</a>
        </section>
    @endif
</main>
@endsection
