<?php

namespace App\Http\Controllers;

use App\Models\Estancia;
use Illuminate\Http\Request;

class EstanciaController extends Controller
{
    public function index()
    {
        $estancias = Estancia::all();
        return view('estancias.index', compact('estancias'));
    }

    public function show()
    {
        $id = request()->route('id');

        if (!$id) {
            return view('estancias.item');
        }

        $estancia = Estancia::find($id);
        return view('estancias.item', compact('estancia'));
    }

    public function editCreate(Request $request)
    {
        $id = request()->route('id');

        if ($id) {
            $estancia = Estancia::find($id);
            $estancia->update($request->all());
        } else {
            $estancia = Estancia::create($request->all());
        }

        return redirect()->route('estancias.index');
    }

    public function delete()
    {
        $id = request()->route('id');
        $estancia = Estancia::find($id);
        $estancia->delete();

        return redirect()->route('estancias.index');
    }

}
