<?php

namespace App\Http\Controllers\Usuarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Servicio;
use App\Medico;


class MedicosController extends Controller
{
    public function index()
    {
        $medicos = Medico::paginate(10);
        return view('admin.medicos.index',compact('medicos'));
    }

   
    public function create()
    {
        $usuarios = User::orderBy('name','asc')->pluck('name','id');
        $servicios = Servicio::orderBy('nombre','asc')->pluck('nombre','id');
        return view('admin.medicos.crear',compact('usuarios','servicios'));
    }

   
    public function store(Request $request)
    {
        //Validar los campos
        $request->validate([
            'telefono' => 'required',
            'tarjeta_prof' => 'required',
            'user_id' => 'required',
            'servicio_id' => 'required'
        ]);

        //Insertar los datos
        $medico = Medico::create([
            'telefono'=>$request->telefono,
            'tarjeta_prof'=>$request->tarjeta_prof,
            'user_id'=>$request->user_id,
            'servicio_id'=>$request->servicio_id,
        ]);

        $mensaje = $medico?'Médico creado ok':'No se pudo crear el médico';
        return redirect()->route('medicos.index')->with('mensaje',$mensaje);

    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $medico = Medico::find($id);
        $usuarios = User::orderBy('name','asc')->pluck('name','id');
        $servicios = Servicio::orderBy('nombre','asc')->pluck('nombre','id');
        return view('admin.medicos.editar',compact('medico','usuarios','servicios'));
    }

    
    public function update(Request $request, $id)
    {
        //Validar los campos
        $request->validate([
            'telefono' => 'required',
            'tarjeta_prof' => 'required',
            'user_id' => 'required',
            'servicio_id' => 'required'
        ]);

        //Actualizar el usuario
        $medico = Medico::find($id);
        $medico->telefono = $request->telefono;
        $medico->tarjeta_prof = $request->tarjeta_prof;
        $medico->user_id = $request->user_id;
        $medico->servicio_id = $request->servicio_id;
        $medico->save();

        $mensaje = $medico?'Usuario actualizado ok':'No se pudo actualizar';
        return redirect()->route('medicos.index')->with('mensaje',$mensaje);
    }

    
    public function destroy($id)
    {
        $medico = Medico::find($id);
        $usuario = User::where('id',$medico->user_id)->first();
        $usuario->estado_id = 2;
        $usuario->save();

        $mensaje = $usuario?'Medico inactivado':'No se pudo inactivar';
        return redirect()->route('medicos.index')->with('mensaje',$mensaje);
    }
}
