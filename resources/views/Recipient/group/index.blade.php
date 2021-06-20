@extends('argon_layouts.app', ['title' => __('Recipient Group')])

@section('style')
<link href="{{ URL::asset('assets/css/frameworks/datatables.min.css') }}" rel="stylesheet" media="all">
<style type="text/css">
	.item--group{
		width: 10rem;
		border-radius: 10px;
		-webkit-box-shadow: 2px 2px 16px -2px rgba(133,131,133,1);
		-moz-box-shadow: 2px 2px 16px -2px rgba(133,131,133,1);
		box-shadow: 2px 2px 16px -2px rgba(133,131,133,1);
	}
	.item--group .item--inner{
		min-height:8rem;
	}

	.item--group{
		cursor: pointer;
	}
</style> 
@endsection

@section('content')
<input type="hidden" name="breadcrumb-title" value="{{ (__('recipient.group.title')) }}">

<div class="col-12">
    <div class="d-flex flex-wrap mb-3">
		<div class="ml-auto p-2">
			<button type="button" class="btn btn-print" onclick="window.location.href='{{ url('Recipient/Group/Create')}}'">
                + {{ (__('recipient.group.create')) }}
            </button>
		</div>
    </div>
</div>

<div class="col-12">
    <div class="d-flex flex-wrap">
	<!-- {{print_r($group)}} -->

	@if(isset($group) && $group!='')
		@php
			$block = 1;
		@endphp
		@for($i=0;$i<$count;$i++)
			@php
				$id	= $group[$i]->id;
				if($block == 1)
				{
					$color = 'bg-primary';
					$block = 2;
				}
				elseif($block == 2)
				{
					$color = 'bg-success';
					$block = 3;
				}
				elseif($block == 3)
				{
					$color = 'bg-info';
					$block = 4;
				}
				else
				{
					$color = 'bg-secondary';
					$block = 1;
				}
			@endphp	
			
			<div class="card text-white mb-3 mx-2 item--group {{$color}}"  onclick="edit({{$id}})">
				<div class="card-body">
					<div class="card-title">{{ $group[$i]->group_name }}</div>
				</div>
				<div class="card-body">
					<h6 class="card-title text-left mb-0">Total&nbsp; {{$total[$i]}}</h6>
					<p class="card-text text-white-50">{{ $group[$i]->description }}</p>
				</div>
			</div>
			
		@endfor

	@endif
	</div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script type="text/javascript">
	function edit(id)
	{
		var group_id = id;
		// alert(group_id);
		window.location.href = '{{ url("Recipient/Group/Edit")}}/'+group_id;
	}
</script>
@endsection
