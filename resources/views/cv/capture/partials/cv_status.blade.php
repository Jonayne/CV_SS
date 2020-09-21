<div class="container py-1">
    @if (($curriculum->status) == 'en_proceso')
        <div class="alert alert-danger text-center">
            <h5><strong> Currículum incompleto </strong></h5>
        </div>
    @else
        <div class="alert alert-success text-center">
            <h5><strong> Currículum completo. </strong><br><br>Su currículum cumple con las especificaciones básicas.<br>Puede seguir agregando/editando información.</h5>
            <a href="{{route('home')}}" class="btn btn-secondary btn mt-2"> Ir al inicio </a>
        </div>
    @endif
</div>
