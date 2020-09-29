<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class EmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['empleados']=Empleados::paginate(10);
        return view('empleados.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     //Agregar usuario
    public function store(Request $request)
    {

        //crear una variable 
        $campos=[
            //validacion laravel
            'Nombre'=> 'required|string|max:100',
            'ApellidoPaterno'=> 'required|string|max:100',
            'ApellidoMaterno'=> 'required|string|max:100',
            'Correo'=> 'required|email',
            'Foto'=> 'required|max:10000|mimes:jpeg,png,jpg'   
        ];
        //crear mensaje
        $Mensaje=["required"=>'El :attribute es requerido'];
        //se pueda ejecutar entre parentesis va el metodo a validar, la variable
        //creada y el mensaje.
        $this->validate($request,$campos,$Mensaje);


        //Se almacene todo lo que se envia al metodo store almacenando en datosEmpleado
       // $datosEmpleado=request()->all();
        //No recibir el campo token y recolectar toda la info para que concida con la tabla
        $datosEmpleado=request()->except('_token');

        if($request->hasFile('Foto')){

            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');

        }
        
        Empleados::insert($datosEmpleado);

        //ver dato que llegan 
       // return response()->json($datosEmpleado); 
       return redirect('empleados')->with('Mensaje','Empleado agregado con exíto');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function show(Empleados $empleados)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */

     //recepcionar la informacion enviada atraves de la URL-> edit($id)
    public function edit($id)
    {
        //Buscando todos los empleados que tengan ese id
        //el metodo findOrFail devuelve todos los resultados(nombre,apellido,ect) que corresponden a ese id
        $empleado=Empleados::findOrFail($id);
        //retornamos una vista
        return view('empleados.edit',compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    //recepcionar el id
    public function update(Request $request, $id)
    {
        $campos=[
            //validacion laravel
            'Nombre'=> 'required|string|max:100',
            'ApellidoPaterno'=> 'required|string|max:100',
            'ApellidoMaterno'=> 'required|string|max:100',
            'Correo'=> 'required|email', 
        ];
        
        if($request->hasFile('Foto')){
            $campos+=['Foto'=> 'required|max:10000|mimes:jpeg,png,jpg'];

        }
        //crear mensaje
        $Mensaje=["required"=>'El :attribute es requerido'];
        //se pueda ejecutar entre parentesis va el metodo a validar, la variable
        //creada y el mensaje.
        $this->validate($request,$campos,$Mensaje);

        //exceptuando el token y creamos un arreglo de informacion todo esto colocandolo en un variable
        $datosEmpleado = request()->except(['_token', '_method']);
        //valida la fotografia
        if ($request->hasFile('Foto')) {
            $empleado = Empleados::findOrFail($id);

            //Borra la fotografia vieja
            Storage::delete('public/' . $empleado->Foto);

            $datosEmpleado['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }

        //Busca el id y hace un update
        Empleados::where('id', '=', $id)->update($datosEmpleado);
        //metodo que busca todos los elementos
        //$empleado = Empleados::findOrFail($id);
        //retornamos una vista
       // return view('empleados.edit', compact('empleado'));
       return redirect('empleados')->with('Mensaje','Empleado modificado con exíto');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //busca el id referente a la foto
        $empleado = Empleados::findOrFail($id);

        //Se intenta borrar la fotografia vieja si la encuentra la borra de la BD
 
        if (Storage::delete('public/' . $empleado->Foto)) {
            //eliminar registro de la BD
            Empleados::destroy($id);
        }
      
        
        return redirect('empleados')->with('Mensaje','Empleado eliminado con exíto');
        
    }
}
