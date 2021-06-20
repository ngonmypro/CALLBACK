<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<style> 

th{
	background-color: #B2D2DC;
}
</style>
<body>

	<table>
		<thead>
			<tr>
				@foreach($headers as $item)
					<td>{{ $item }}</td>
				@endforeach
			</tr>
		</thead>
		<tbody>
			@foreach($csv as $row)
				<tr>
					@foreach ($row as $item)
						<td>{{ $item }}</td>
					@endforeach
				</tr>
			@endforeach
		</tbody>
	</table>
</body>