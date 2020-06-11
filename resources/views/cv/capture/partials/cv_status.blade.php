<div class="container py-1">
    @if (($curriculum->status) == 'completado')
        <div class="alert alert-info text-center">
            <h5><strong> Curriculum completo </strong></h5>
            <a href="{{route('home')}}" class="btn btn-outline-secondary btn"> Ir al inicio </a>
        </div>
    @else
        <div class="alert alert-info text-center">
            <h5><strong> Curriculum aún no completo </strong></h5>
            {{-- Agregar barra de progreso cuando siga en progreso la captura de CV --}}
        </div>
    @endif
</div>