<div class="form-group">
	<label>Usuario</label>
	{!!Form::select('user_id',$usuarios,null,[
		'class'=>'form-control',
		'placeholder'=>'Escoger Usuario...'
	])!!}
</div>
<div class="form-group">
	<label>Servicio</label>
	{!!Form::select('servicio_id',$servicios,null,[
		'class'=>'form-control',
		'placeholder'=>'Escoger Servicio...'
	])!!}
</div>

<div class="form-group">
	<label>Telefono</label>
	{!!Form::text('telefono',null,[
		'class'=>'form-control',
		'placeholder'=>'Teléfono...',
		'required'=>'required'
	])!!}
</div>
<div class="form-group">
	<label>Tarjeta Profesional</label>
	{!!Form::text('tarjeta_prof',null,[
		'class'=>'form-control',
		'placeholder'=>'Tarjeta Profesional...',
		'required'=>'required'
	])!!}
</div>

<div class="form-group">
	<button type="submit" class="btn btn-success">Guardar Médico</button>
	<a class="btn btn-danger" href="{{ route('medicos.index') }}">Cancelar</a>
</div>
					