@extends('admin.template')
@section('titulo','Inicio del Admin')

@section('titulocontenido')
	<h1>Inicio <small>Bienvenid@</small></h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Agenda</li>
      </ol>
@endsection

@section('contenido')
	<p>Este es el contenido</p>
@endsection