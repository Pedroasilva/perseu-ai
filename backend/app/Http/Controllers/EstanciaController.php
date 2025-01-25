<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstanciaPostRequest;
use App\Models\Estancia;
use App\Services\WhatsappApiService;

class EstanciaController extends Controller
{

    private $whastappApiService;

    public function __construct(WhatsappApiService $whastappApiService)
    {
        $this->whastappApiService = $whastappApiService;
    }

    public function index()
    {

        $ping = $this->whastappApiService->ping();
        dd($ping);

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

    public function editCreate(StoreEstanciaPostRequest $request)
    {
        $id = request()->route('id');

        if ($id) {
            $estancia = Estancia::find($id);
            $estancia->update($request->all());
        } else {
            $estancia = Estancia::onlyTrashed()->where('telefone', $request->telefone)->first();
            if ($estancia) {
                $estancia->restore();
            } else {
                $estancia = Estancia::create($request->all());
            }
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
