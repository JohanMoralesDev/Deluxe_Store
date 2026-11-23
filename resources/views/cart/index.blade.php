@extends('layouts.app')

@section('title', 'Deluxe Store')

@push('head')
    @vite(['assets/css/Carrito.css', 'assets/js/script.js'])
@endpush

@section('content')
<button type="button" class="boton-chatbot" aria-label="Abrir chatbot">
        <i class="bi bi-chat-dots"></i>
        <span>Chatbot</span>
    </button>


    <main class="contenido-carrito">

        <h1 class="titulo-carrito">TU CARRITO</h1>

        <div class="carrito-layout">


            <section class="carrito-lista" aria-label="Productos en el carrito">

                <article class="carrito-item" data-id="1">
                    <div class="carrito-item-imagen">
                        <img src="{{ asset('assets/images/store/Curren-Hombre.jpeg') }}" alt="Nombre del producto">
                    </div>

                    <div class="carrito-item-info">
                        <h2 class="carrito-item-nombre">Reloj para caballero marca Curren</h2>
                        <p class="carrito-item-descripcion">Descripción corta del producto</p>

                        <div class="carrito-item-acciones">
                            <div class="selector-cantidad" role="group" aria-label="Cantidad">
                                <button type="button" class="cantidad-menos" aria-label="Disminuir cantidad">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <span class="cantidad-valor" aria-live="polite">1</span>
                                <button type="button" class="cantidad-mas" aria-label="Aumentar cantidad">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>

                            <button type="button" class="boton-eliminar">
                                <i class="bi bi-trash3"></i>
                                <span>Eliminar</span>
                            </button>
                        </div>
                    </div>

                    <p class="carrito-item-precios">
                        <span class="precio-antes">Precio antes</span>
                        <span class="precio-actual">Precio</span>
                    </p>
                </article>

                <article class="carrito-item" data-id="2">
                    <div class="carrito-item-imagen">
                        <img src="{{ asset('assets/images/store/Rolex.jpeg') }}" alt="Nombre del producto">
                    </div>

                    <div class="carrito-item-info">
                        <h2 class="carrito-item-nombre">Reloj marca Rolex</h2>
                        <p class="carrito-item-descripcion">Descripción corta del producto</p>

                        <div class="carrito-item-acciones">
                            <div class="selector-cantidad" role="group" aria-label="Cantidad">
                                <button type="button" class="cantidad-menos" aria-label="Disminuir cantidad">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <span class="cantidad-valor" aria-live="polite">1</span>
                                <button type="button" class="cantidad-mas" aria-label="Aumentar cantidad">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>

                            <button type="button" class="boton-eliminar">
                                <i class="bi bi-trash3"></i>
                                <span>Eliminar</span>
                            </button>
                        </div>
                    </div>

                    <p class="carrito-item-precios">
                        <span class="precio-antes">Precio antes</span>
                        <span class="precio-actual">Precio</span>
                    </p>
                </article>

                <article class="carrito-item" data-id="3">
                    <div class="carrito-item-imagen">
                        <img src="{{ asset('assets/images/store/Naviforce.jpeg') }}" alt="Nombre del producto">
                    </div>

                    <div class="carrito-item-info">
                        <h2 class="carrito-item-nombre">Reloj Naviforce</h2>
                        <p class="carrito-item-descripcion">Descripción corta del producto</p>

                        <div class="carrito-item-acciones">
                            <div class="selector-cantidad" role="group" aria-label="Cantidad">
                                <button type="button" class="cantidad-menos" aria-label="Disminuir cantidad">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <span class="cantidad-valor" aria-live="polite">1</span>
                                <button type="button" class="cantidad-mas" aria-label="Aumentar cantidad">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>

                            <button type="button" class="boton-eliminar">
                                <i class="bi bi-trash3"></i>
                                <span>Eliminar</span>
                            </button>
                        </div>
                    </div>

                    <p class="carrito-item-precios">
                        <span class="precio-antes">Precio antes</span>
                        <span class="precio-actual">Precio</span>
                    </p>
                </article>

            </section>

            <aside class="resumen-pedido" aria-labelledby="titulo-resumen">

                <h2 id="titulo-resumen" class="resumen-titulo">Resumen del pedido</h2>

                <dl class="resumen-detalle">
                    <div class="resumen-fila">
                        <dt>Subtotal</dt>
                        <dd id="resumen-subtotal">$----</dd>
                    </div>

                    <div class="resumen-fila resumen-descuento">
                        <dt>Descuento aplicado</dt>
                        <dd id="resumen-descuento">-$----</dd>
                    </div>

                    <div class="resumen-fila">
                        <dt>Envío estimado</dt>
                        <dd id="resumen-envio">Gratis</dd>
                    </div>
                </dl>

                <div class="resumen-fila resumen-total">
                    <span>Total</span>
                    <span id="resumen-total">$---</span>
                </div>

                <a href="pago.html" class="boton-pagar">Proceder al pago</a>
                <a href="{{ route('store.catalogo') }}" class="boton-continuar">Continuar comprando</a>

                <p class="resumen-seguro">
                    <i class="bi bi-lock"></i>
                    <span>Pago seguro SSL encriptado</span>
                </p>

            </aside>

        </div>

    </main>

    <!-- Pie de página -->
@endsection
