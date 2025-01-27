<?php

namespace App\Http\Controllers;

use App\Enums\WhatsappApiEnum;
use App\Http\Requests\StoreInstanciaPostRequest;
use App\Models\Instancia;
use App\Services\WhatsappApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InstanciaController extends Controller
{
    private WhatsappApiService $whatsAppApiService;

    public function __construct(WhatsappApiService $whatsAppApiService)
    {
        $this->whatsAppApiService = $whatsAppApiService;
    }

    /**
     * Display a listing of the Instancias.
     *
     * @return View
     */
    public function index(): View
    {
        $instancias = Instancia::all();
        return view('instancias.index', compact('instancias'));
    }

    /**
     * Display a single Instancia or initiate a session if necessary.
     *
     * @return View
     */
    public function show(): View
    {
        $id = request()->route('id');
        $instancia = Instancia::find($id);

        if (!$instancia) {
            return view('instancias.item', compact('instancia'));
        }

        $status = $this->whatsAppApiService->checkSession($instancia->telefone);

        if ($status['success']) {
            $instancia->vinculado = true;
            $instancia->save();
        }

        $this->handleSession($status, $instancia->telefone);

        return view('instancias.item', compact('instancia'));
    }

    /**
     * Handle Session code generation based on session status.
     *
     * @param array $status
     * @param string $telefone
     * @return string|null
     */
    private function handleSession(array $status, string $telefone): ?string
    {
        if ($status['message'] == WhatsappApiEnum::SESSAO_NAO_ENCONTRADA->value) {
            $this->whatsAppApiService->startSession($telefone);
        }

        return null;
    }

    public function showQrCode(): ?array
    {
        $id = request()->route('id');
        $instancia = Instancia::findOrFail($id);

        $status = $this->whatsAppApiService->checkSession($instancia->telefone);

        if ($status['message'] == WhatsappApiEnum::SESSAO_CONECTADA->value) {
            $response = [
                'connected' => true,
            ];
            return $response;
        }

        return $this->whatsAppApiService->getQrCode($instancia->telefone);
    }

    /**
     * Create or update an Instancia.
     *
     * @param StoreInstanciaPostRequest $request
     * @return RedirectResponse
     */
    public function editCreate(StoreInstanciaPostRequest $request): RedirectResponse
    {
        $id = request()->route('id');
        $data = $request->validated();

        if ($id) {
            $instancia = Instancia::findOrFail($id);
            $instancia->update($data);
        } else {
            $this->createOrUpdateInstancia($data);
        }

        return redirect()->route('instancias.index');
    }

    /**
     * Create or update an Instancia showQrCodebased on the provided data.
     *
     * @param array $data
     * @return void
     */
    private function createOrUpdateInstancia(array $data): void
    {
        $instancia = Instancia::onlyTrashed()->where('telefone', $data['telefone'])->first();

        if ($instancia) {
            $instancia->restore();
        } else {
            Instancia::create($data);
        }
    }

    /**
     * Delete an Instancia.
     *
     * @return RedirectResponse
     */
    public function delete(): RedirectResponse
    {
        $id = request()->route('id');
        $instancia = Instancia::findOrFail($id);
        $instancia->delete();

        return redirect()->route('instancias.index');
    }
}
