<?php

namespace App\Http\Controllers\Agenda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Agenda;
use App\User;
use App\Servicio;
use App\Paciente;
use App\Medico;

class AgendasController extends Controller
{

    //Función Constructor para validar usuarios
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin',['except'=>'index']);
    }

    public function index()
    {
       $agendas = Agenda::select('id','fecha_ini as start','fecha_fin as end','paciente_id as title')->get();
       $pacientes = User::where('perfil_id',3)->orderBy('name','asc')->pluck('name','id');
       $medicos = User::where('perfil_id',2)->orderBy('name','asc')->pluck('name','id');
       $servicios = Servicio::orderBy('nombre','asc')->pluck('nombre','id');
       return view('admin.agenda.index',compact('agendas','pacientes','medicos','servicios'));
    }

    
    public function create()
    {
        
    }


    public function store(Request $request)
    {
        //Validar los campos
        $request->validate([
            'fecha_ini' => 'required',
            'fecha_fin' => 'required',
            'paciente_id' => 'required',
            'medico_id' => 'required',
            'servicio_id' => 'required'
        ]);

        $paciente = Paciente::where('user_id',$request->paciente_id)->first();
        $medico = Medico::where('user_id',$request->medico_id)->first();

        //Insertar en la tabla Agendas
        $agenda = Agenda::create([
            'fecha_ini'=>$request->fecha_ini." ".$request->hora_ini,
            'fecha_fin'=>$request->fecha_fin." ".$request->hora_fin,
            'user_id'=>Auth::user()->id,
            'paciente_id'=>$paciente->id,
            'medico_id'=>$medico->id,
            'servicio_id'=>$request->servicio_id,
            'estado_id'=>1
        ]);

        $mensaje = $agenda?'Cita creada ok':'No se pudo crear la cita';
        return redirect()->route('calendario.index')->with('mensaje',$mensaje);
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $agenda = Agenda::find($id);
        $pacientes = User::where('perfil_id',3)->orderBy('name', 'asc')->pluck('name', 'id');
        $medicos = User::where('perfil_id',2)->orderBy('name', 'asc')->pluck('name', 'id');
        $servicios = servicio::orderBy('name', 'asc')->pluck('name', 'id');
        $estados = Estadoagenda::orderBy('name', 'asc')->pluck('name', 'id');
               

    }

    public function update(Request $request, $id)
    {
        //
    }
    
    public function destroy($id)
    {
        //
    }
}