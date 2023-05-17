<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Category;

class TodosController extends Controller
{
    /**
     * Index para mostrar todos los todos
     * store para guardar un todo
     * update para actualizar un todo
     * destroy para eliminar un todo
     * edir para mostrar el formulario de edicion
     */

     public function store(Request $request){
        
        //validamos
        $request -> validate([
            'title' => 'required|min:3'
        ]);
        

        //creamos objetos y asignamos valores
        $todo = new Todo;
        $todo -> title = $request -> title;
        $todo -> category_id = $request -> category_id;
        $todo -> save();

        //mostramos mensaje
        return redirect() -> route ('todos') -> with('success','Tarea Creada Correctamente');
     }

     public function index(){
        $todos = Todo::all();
        $categories = Category::all();
        return view('todos.index', ['todos' => $todos, 'categories' => $categories]);
     }

     public function show($id){
        $todo = Todo::find($id);
        return view('todos.show', ['todo' => $todo]);
     }

     public function update(Request $request, $id){
        $todo = Todo::find($id);
        $todo->title = $request->title;
        $todo->save();

        //return view('todos.index', ['success' => 'Tarea Actualizada']);
        return redirect()->route('todos')->with('success', 'Tarea Actualizada!');
     }

     public function destroy($id){
        $todo = Todo::find($id);
        $todo->delete();

        return redirect()->route('todos')->with('success', 'Tarea ha sido Eliminada!');
     }
}



//la solucion   es Route::post('/todos', TodosController::class . '@store');   quitale el name y le puse tambien todos en vez de tarea

//<form action="{{ route('todos-update', ['id' => $todo->id]) }}" method="POST">