<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="producto-categoria">Categoría</label>
        <select class="form-select" id="producto-categoria" name="id_categoria" required>
            <option value="">Selecciona una categoría</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id_categoria }}" @selected((string) old('id_categoria', $product?->id_categoria) === (string) $categoria->id_categoria)>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="producto-nombre">Nombre</label>
        <input class="form-control" id="producto-nombre" name="nombre" value="{{ old('nombre', $product?->nombre) }}" maxlength="150" required>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="producto-sku">Código SKU</label>
        <input class="form-control" id="producto-sku" name="codigo_sku" value="{{ old('codigo_sku', $product?->codigo_sku) }}" maxlength="80" required>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="producto-precio">Precio</label>
        <input class="form-control" id="producto-precio" type="number" name="precio" min="0" step="0.01" value="{{ old('precio', $product?->precio) }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="producto-oferta">Precio de oferta (opcional)</label>
        <input class="form-control" id="producto-oferta" type="number" name="precio_oferta" min="0" step="0.01" value="{{ old('precio_oferta', $product?->precio_oferta) }}">
    </div>
    <div class="col-md-6">
        <label class="form-label" for="producto-color">Color</label>
        <input class="form-control" id="producto-color" name="color" value="{{ old('color', $product?->color) }}" maxlength="50">
    </div>
    <div class="col-md-6">
        <label class="form-label" for="producto-publico">Público</label>
        <select class="form-select" id="producto-publico" name="publico" required>
            @foreach (['dama' => 'Dama', 'caballero' => 'Caballero', 'ninos' => 'Niños', 'unisex' => 'Unisex'] as $valor => $etiqueta)
                <option value="{{ $valor }}" @selected(old('publico', $product?->publico ?? 'unisex') === $valor)>{{ $etiqueta }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="producto-tamano">Tamaño de esfera</label>
        <select class="form-select" id="producto-tamano" name="tamano_esfera">
            <option value="">Sin especificar</option>
            @foreach (['pequeno' => 'Pequeño', 'mediano' => 'Mediano', 'grande' => 'Grande'] as $valor => $etiqueta)
                <option value="{{ $valor }}" @selected(old('tamano_esfera', $product?->tamano_esfera) === $valor)>{{ $etiqueta }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label" for="producto-imagen">Subir imagen del producto (JPG, PNG o WebP; máximo 5 MB)</label>
        <input class="form-control" id="producto-imagen" type="file" name="imagen" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
        @if ($product?->url_imagen)
            <div class="mt-2">
                <img src="{{ $product->image_url }}" alt="Imagen actual de {{ $product->nombre }}" style="max-width: 160px; max-height: 120px; object-fit: contain">
            </div>
        @endif
        <label class="form-label mt-3" for="producto-ruta-imagen">Ruta existente (opcional)</label>
        <input class="form-control" id="producto-ruta-imagen" name="url_imagen" value="{{ old('url_imagen', $product?->url_imagen) }}" maxlength="500" placeholder="assets/images/store/nombre-imagen.jpeg">
        <div class="form-text">Si subes un archivo, este reemplazará la ruta indicada.</div>
    </div>
    @if (!$product)
        <div class="col-md-6">
            <label class="form-label" for="producto-stock-inicial">Existencias iniciales</label>
            <input class="form-control" id="producto-stock-inicial" type="number" name="cantidad_inicial" min="0" max="4294967295" step="1" value="{{ old('cantidad_inicial', 0) }}" required>
        </div>
    @endif
    <div class="col-12">
        <label class="form-label" for="producto-descripcion">Descripción</label>
        <textarea class="form-control" id="producto-descripcion" name="descripcion" rows="4">{{ old('descripcion', $product?->descripcion) }}</textarea>
    </div>
    <div class="col-12 form-check ms-2">
        <input class="form-check-input" id="producto-activo" type="checkbox" name="esta_activo" value="1" @checked(old('esta_activo', $product?->esta_activo ?? true))>
        <label class="form-check-label" for="producto-activo">Publicado en la tienda (desmarcar para dejar en borrador o desactivar)</label>
    </div>
</div>

<div class="d-flex flex-wrap gap-2 mt-4">
    <button class="btn btn-success" type="submit">{{ $submitLabel }}</button>
    <a class="btn btn-outline-secondary" href="{{ route('admin.productos.index') }}">Cancelar</a>
</div>
