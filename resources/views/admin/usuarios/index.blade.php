@extends('admin.template')
@section('titulo','Usuarios')

@section('titulocontenido')
	<h1>Usuarios <small>Listado</small></h1>
@endsection

@section('contenido')
	<div class="container box box-success">
		<br>
		<div class="text-center">
			<a class="btn btn-primary" href="{{ route('usuarios.create') }}">Crear Nuevo</a>
			<a class="btn btn-warning" href="{{ route('pdfusuarios') }}">Exportar PDF</a>
			<a class="btn btn-success" href="{{ route('excelusuarios') }}">Exportar Excel</a>
			<hr>	
		</div>
		@if(\Session::has('mensaje'))
			<div class="alert alert-success alert-dismissible">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			   {{\Session::get('mensaje')}}
			</div>
		@endif
		<!-- FORMULARIO DE FILTROS -->
		{!!Form::open(['route'=>'usuarios.index','method'=>'get','class'=>'form-inline text-center'])!!}
			{!! Form::text('name',null, ['placeholder'=>'Nombre...','class'=>'form-control']) !!}
			{!! Form::text('email',null, ['placeholder'=>'Email...','class'=>'form-control']) !!}
			{!! Form::select('perfil_id',$perfiles,null,
			['placeholder'=>'Perfil...','class'=>'form-control'	])!!}
			<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
		{!! Form::close() !!}
		<!-- FIN FORMULARIO -->
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Nombres</th>
					<th>Email</th>
					<th>Perfil</th>
					<th>Estado</th>
					<th>Editar</th>
					<th>Borrar</th>
				</tr>
			</thead>
			<tbody>
				@foreach($usuarios as $usuario)
					<tr @if($usuario->estado_id==2) class="danger" @endif>
						<td>{{$usuario->name}}</td>
						<td>{{$usuario->email}}</td>
						<td>{{$usuario->perfil->nombre}}</td>
						<td>{{$usuario->estado->nombre}}</td>
						<td><a class="btn btn-warning" href="{{ route('usuarios.edit',$usuario->id) }}">Editar</a></td>
						<td>
							<form method="post" action="{{ route('usuarios.destroy',$usuario->id) }}">
								@csrf
								<input type="hidden" name="_method" value="DELETE">
								<button class="btn btn-danger" type="submit" onClick="return confirm('Eliminar usuario?')">Borrar</button>
							</form>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<hr>
		<div class="text-center">
			{{$usuarios->links()}}
		</div>	
		
	</div>
@endsection
