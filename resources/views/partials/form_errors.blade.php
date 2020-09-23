@if ($errors->any())
    <hr>
    <div class="container text-center alert-info">
        <ul>
            <h2 class="text-danger"> Se encontraron los siguientes detalles: </h2>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <hr>
@endif