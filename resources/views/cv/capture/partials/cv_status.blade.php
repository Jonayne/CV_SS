<div class="container py-1">
    @can('editar-cualquier-usuario')
        @if (($curriculum->status) == 'en_proceso')
        <div class="alert alert-info text-center">
            <h5><strong>(Se encuentra en modo de edición de administrador)<br>
                            Este currículum está incompleto </strong></h5>
        </div>
        @else
            <div class="alert alert-success text-center">
                <h5><strong>(Se encuentra en modo de edición de administrador)</strong><br>Este currículum está completo. </strong><br><br>Puede agregar/editar información.</h5>
                <a href="{{route('curricula.show', array('id'=>$curriculum->id, 'formNum'=>1))}}" class="btn btn-secondary btn mt-2"> Salir de modo de edición </a>
            </div>
        @endif

    @elsecan('capturar-cv')
        @if (($curriculum->status) == 'en_proceso')
        <div class="alert alert-info text-center">
            <h5><strong> Currículum incompleto </strong></h5>
        </div>
        @else
            <div class="alert alert-success text-center">
                <h5><strong> Currículum completo. </strong><br><br>Su currículum cumple con las especificaciones básicas.<br>Puede seguir agregando/editando información.</h5>
                <a href="{{route('home')}}" class="btn btn-secondary btn mt-2"> Ir al inicio </a>
            </div>
        @endif
    @endcan
    
</div>
