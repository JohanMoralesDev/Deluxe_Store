@if (session('success') || session('error') || $errors->any())
    <div class="mensajes-globales" aria-live="polite" aria-atomic="true">
        @if (session('success'))
            <p class="alert alert-success mb-3" role="status">{{ session('success') }}</p>
        @endif

        @if (session('error'))
            <p class="alert alert-danger mb-3" role="alert">{{ session('error') }}</p>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mb-3" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endif
