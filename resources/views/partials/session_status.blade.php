@if (session('status'))
    <div class="alert alert-{{session('status_color') ?? 'secondary'}} alert-dismissible text-center">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong> {{ session('status')}} </strong>
    </div>
@endif
