@if (\Illuminate\Support\Facades\Session::has('throw_detail'))
    <div class="alert alert-danger alert-dismissable text-center">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>{{session('throw_detail')}}</strong>
        {{ Session::forget('throw_detail') }}
    </div>
@endif