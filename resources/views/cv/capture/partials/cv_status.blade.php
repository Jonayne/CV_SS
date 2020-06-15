<div class="container py-1">
    @if (($curriculum->status) == 'en_proceso')
        <div class="alert alert-info text-center">
            <h5><strong> Currículum incompleto </strong></h5>
            @if (session()->get('completedList') && session()->get('completedList')['percentage'] > 0)
                <div class="progress" style="height: 40px">
                        <div class="progress-bar bg-secondary progress-bar-striped progress-bar-animated" 
                            style="width:{{ session()->get('completedList')['percentage']}}%;height:40px">
                                {{ number_format(session()->get('completedList')['percentage']) }} %
                        </div>
                </div>
            @endif
        </div>
    @else
        <div class="alert alert-info text-center">
            <h5><strong> Currículum completo </strong></h5>
            @if (session()->get('completedList'))
                <div class="progress" style="height: 40px">
                        <div class="progress-bar bg-secondary progress-bar-striped progress-bar-animated" 
                            style="width:{{ session()->get('completedList')['percentage']}}%;height:40px">
                                {{ number_format(session()->get('completedList')['percentage']) }} %
                        </div>
                </div>
            @endif
            <a href="{{route('home')}}" class="btn btn-outline-secondary btn mt-2"> Ir al inicio </a>
        </div>
    @endif
</div>
