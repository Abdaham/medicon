<!DOCTYPE html>
<html>
<head>
	<title> Listado de Usuarios</title>
</head>
<body>
	<img src="http://osmaro.com/medicon/logo-doctores.png">
	<h1>Listado de Usuarios</h1>
	<table width="100%" border="2">
		<tr>
			<th> Nombre </th>
			<th> Email </th>
			<th> Perfil </th>
			<th> Estado </th>
		</tr>
		@foreach($usuarios as $usuario)
			<tr>
				<td>{{$usuario->name}}</td>
				<td>{{$usuario->email}}</td>
				<td>{{$usuario->perfil->nombre}}</td>
				<td>{{$usuario->estado->nombre}}</td>
			</tr>
		@endforeach
	</table>
</body>
</html>