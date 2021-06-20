<div id="" class="row mx-auto mb-4">
    <div class="col-12 p-0">
        <form  action="{{ url('Corporate/Setting/ImgLogo') }}" method="POST" class="form" enctype="multipart/form-data">

                {{ csrf_field() }}

                <input type="hidden" name="corp_code" value="{{ $corp_code }}">

                @if(isset($branch) && !blank($branch))
                    @foreach($branch as $k => $v)
                        <div class="card">
                            <div class="card-header">
                                <h3>
                                    {{ $v->name_th }} {{ $v->name_en }}
                                </h3>
                                <h4>
                                    {{ $v->short_name_en }} : {{ $v->branch_code }}
                                </h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><h4>{{__('corpsetting.logo')}}</h4></td>
                                            <td>
                                                @if($v->img_logo != null)
                                                    <img src="data:image/png;base64, {{ $v->img_logo }}" alt="LOGO" class="img-thumbnail">
                                                @else
                                                    <p>{{__('corpsetting.no_image')}}</p>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="hidden" value="{{ $v->img_logo }}" class="form-control input_logo-{{$k}}" name="corp_info[{{ $v->id }}][logo]">
                                                <input type="file" class="form-control logo-file" data-target="input_logo-{{$k}}" accept="image/gif, image/jpeg, image/png"  onchange="convertB64(this)">
                                                <span>({{__('corpsetting.file_size_limit')}} 800 kb)</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><h4>{{__('corpsetting.signature')}}</h4></td>
                                            <td>
                                                @if($v->signature != null)
                                                    <img src="data:image/png;base64, {{ $v->signature }}" alt="SIGNATURE" class="img-thumbnail">
                                                @else
                                                    <p>{{__('corpsetting.no_image')}}</p>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="hidden" value="{{ $v->signature }}" class="form-control input_signature-{{$k}}" name="corp_info[{{ $v->id }}][signature]">
                                                <input type="file" class="form-control" data-target="input_signature-{{$k}}" accept="image/gif, image/jpeg, image/png"  onchange="convertB64(this)">
                                                <span>({{__('corpsetting.file_size_limit')}} 800 kb)</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @endif



            <div class="row">
                <div class="col-12 text-right">
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-primary"><i class="zmdi zmdi-spinner"></i> {{__('corpsetting.save')}}</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>


@section('script.eipp.corp-setting.img_logo')
<script>
    function convertB64(img) {
        var target = $(img).data('target');
        file = img.files[0];
        if (img.files && img.files[0]) {

            if(file.size < 819200){


                var reader = new FileReader();
                reader.onload = function (e) {
                var base64 = e.target.result;
                $('.'+target).val(base64)
            };
            }else{
                Swal.fire("ผิดพลาด", "ขนาดรูปใหญ่เกินไป", 'error')
                const file = document.querySelector('.logo-file');
                file.value = '';
                return false;
            }
          
            reader.readAsDataURL(img.files[0]);
        }
    }




</script>
@endsection
