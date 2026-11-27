<div class="mb-3">
    <label class="form-label" for="categoria-nombre">Nombre</label>
    <input class="form-control" id="categoria-nombre" name="nombre" value="{{ old('nombre', $category?->nombre) }}" maxlength="100" required>
</div>
<div class="mb-3">
    <label class="form-label" for="categoria-descripcion">Descripción</label>
    <textarea class="form-control" id="categoria-descripcion" name="descripcion" rows="4" maxlength="500">{{ old('descripcion', $category?->descripcion) }}</textarea>
</div>
<div class="form-check mb-3">
    <input class="form-check-input" id="categoria-activa" type="checkbox" name="esta_activa" value="1" @checked(old('esta_activa', $category?->esta_activa ?? true))>
    <label class="form-check-label" for="categoria-activa">Categoría activa</label>
</div>
<div class="d-flex gap-2">
    <button class="btn btn-success" type="submit">{{ $submitLabel }}</button>
    <a class="btn btn-outline-secondary" href="{{ route('admin.categories.index') }}">Cancelar</a>
</div>
