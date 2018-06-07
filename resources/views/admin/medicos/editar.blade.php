@extends('admin.template')
@section('titulo','Usuarios')

@section('titulocontenido')
	<h1>Usuarios <small>Editar</small></h1>
@endsection

@section('contenido')
	<div class="container box box-success">
		@include('admin.secciones.errores')
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				{!!Form::model($medico,['route'=>['medicos.update',$medico->id],'method'=>'put'])!!}
					@include('admin.medicos.form')					
				{!! Form::close() !!}
				
			</div>
		</div>		
	</div>
@endsection
