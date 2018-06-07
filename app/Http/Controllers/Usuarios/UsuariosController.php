<?php

namespace App\Http\Controllers\Usuarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\UsuarioCreado;
use App\User;
use App\Perfil;
use App\Estado;
use PDF;

class UsuariosController extends Controller
{
    //Función Constructor para validar usuarios
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin',['except'=>'index']);
    }


    public function index(Request $request)
    {
        $usuarios = User::nombres($request->name)
        ->email($request->email)->perfil($request->perfil_id)->paginate(10);
        $perfiles = Perfil::orderBy('nombre','asc')->pluck('nombre','id');
        return view('admin.usuarios.index',compact('usuarios','perfiles'));
    }

   
    public function create()
    {
        $perfiles = Perfil::orderBy('nombre','asc')->pluck('nombre','id');
        $estados = Estado::orderBy('nombre','asc')->pluck('nombre','id');
        return view('admin.usuarios.crear',compact('perfiles','estados'));
    }

   
    public function store(Request $request)
    {
        //Validar los campos
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users|email',
            'password' => 'required',
            'perfil_id' => 'required',
            'estado_id' => 'required'
        ]);

        //Insertar los datos
        $usuario = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'perfil_id'=>$request->perfil_id,
            'estado_id'=>$request->estado_id,
        ]);

        //Enviar mail
        $email = $request->email;
        $nombre = $request->name;
        $pass = $request->password;
        Mail::to($email)->send(new UsuarioCreado($nombre,$email,$pass));

        $mensaje = $usuario?'Usuario creado ok':'No se pudo crear el usuario';
        return redirect()->route('usuarios.index')->with('mensaje',$mensaje);

    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $usuario = User::find($id);
        $perfiles = Perfil::orderBy('nombre','asc')->pluck('nombre','id');
        $estados = Estado::orderBy('nombre','asc')->pluck('nombre','id');
        return view('admin.usuarios.editar',compact('usuario','perfiles','estados'));
    }

    
    public function update(Request $request, $id)
    {
        //Validar los campos
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'perfil_id' => 'required',
            'estado_id' => 'required'
        ]);

        //Actualizar el usuario
        $usuario = User::find($id);
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        if($request->password)
            $usuario->password = Hash::make($request->password);
        $usuario->perfil_id = $request->perfil_id;
        $usuario->estado_id = $request->estado_id;
        $usuario->save();

        $mensaje = $usuario?'Usuario actualizado ok':'No se pudo actualizar';
        return redirect()->route('usuarios.index')->with('mensaje',$mensaje);
    }

    
    public function destroy($id)
    {
        $usuario = User::find($id);
        $usuario->estado_id = 2;
        $usuario->save();

        $mensaje = $usuario?'Usuario inactivado':'No se pudo inactivar';
        return redirect()->route('usuarios.index')->with('mensaje',$mensaje);
    }

    //Funcion para exportar en PDF los usuarios
    public function exportarPDF(){
        $usuarios = User::all();
        $pdf = \App::make('dompdf.wrapper');
        $vista = \view('admin.usuarios.pdf', compact('usuarios'))->render();
        $pdf->loadHTML($vista);
        return $pdf->download('usuarios.pdf');
    }

    //Funcion para exportar en PDF los usuarios
    public function exportarExcel(){
        Excel::create('Usuarios', function($excel) {
            $excel->sheet('Usuarios', function($sheet){
                $usuarios = User::all();
                $sheet->fromArray($usuarios);
            });
        })->export('xlsx');
    }

    //Funcion para importar  usuarios desde excel
    public function importarExcel(){
        Excel::load('usuarios.xlsx', function($reader){
            foreach($reader->get()as $user){
                User::create([
                    'name' =>$user->name,
                    'email' => $user->email,
                    'password' => Hash::make($user->password),
                    'perfil_id' => $user->perfil,
                    'estado_id' => $user->estado
                ]);
            }
        });
        return redirect()->route('usuarios.index');
    }
}
