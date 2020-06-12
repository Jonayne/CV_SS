<div class="container py-1">
    @if (($curriculum->status) == 'en_proceso')
        <div class="alert alert-info text-center">
            <h5><strong> Curriculum aún no completo </strong></h5>
            <div class="progress" style="height: 40px">
                <div class="progress-bar bg-secondary progress-bar-striped progress-bar-animated" style="width:{{ session()->get('completedList')['percentage']}}%;height:40px">
                    {{ number_format(session()->get('completedList')['percentage']) }} %
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center">
            <h5><strong> Curriculum completo </strong></h5>
            <div class="progress" style="height: 20px">
                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width:{{ session()->get('completedList')['percentage']}}%;height:20px">
                    {{ number_format(session()->get('completedList')['percentage']) }} %
                </div>
            </div>
            <a href="{{route('home')}}" class="btn btn-outline-secondary btn mt-2"> Ir al inicio </a>
        </div>
    @endif
</div>
