<?php

namespace App\Http\Controllers;

use App\Enums\WhatsappApiEnum;
use App\Http\Requests\StoreEstanciaPostRequest;
use App\Models\Estancia;
use App\Services\WhatsappApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EstanciaController extends Controller
{
    private WhatsappApiService $whatsAppApiService;

    public function __construct(WhatsappApiService $whatsAppApiService)
    {
        $this->whatsAppApiService = $whatsAppApiService;
    }

    /**
     * Display a listing of the Estancias.
     *
     * @return View
     */
    public function index(): View
    {
        $estancias = Estancia::all();
        return view('estancias.index', compact('estancias'));
    }

    /**
     * Display a single Estancia or initiate a session if necessary.
     *
     * @return View
     */
    public function show(): View
    {
        $id = request()->route('id');
        $estancia = Estancia::find($id);

        if (!$estancia) {
            return view('estancias.item');
        }

        $status = $this->whatsAppApiService->checkSession($estancia->telefone);

        if ($status['success']) {
            $estancia->update(['vinculado' => true]);
        }

        $qrCode = $this->handleQrCode($status, $estancia->telefone);

        return view('estancias.item', compact('estancia', 'qrCode'));
    }

    /**
     * Handle QR code generation based on session status.
     *
     * @param array $status
     * @param string $telefone
     * @return string|null
     */
    private function handleQrCode(array $status, string $telefone): ?string
    {
        if (in_array($status['message'], [
            WhatsappApiEnum::SESSAO_NAO_ENCONTRADA->value,
            WhatsappApiEnum::SESSAO_NAO_CONECTADA->value
        ])) {
            if ($status['message'] == WhatsappApiEnum::SESSAO_NAO_ENCONTRADA->value) {
                $this->whatsAppApiService->startSession($telefone);
            }

            return $this->whatsAppApiService->getQrCode($telefone)['qr'];
        }

        return null;
    }

    /**
     * Create or update an Estancia.
     *
     * @param StoreEstanciaPostRequest $request
     * @return RedirectResponse
     */
    public function editCreate(StoreEstanciaPostRequest $request): RedirectResponse
    {
        $id = request()->route('id');
        $data = $request->validated();

        if ($id) {
            $estancia = Estancia::findOrFail($id);
            $estancia->update($data);
        } else {
            $this->createOrUpdateEstancia($data);
        }

        return redirect()->route('estancias.index');
    }

    /**
     * Create or update an Estancia based on the provided data.
     *
     * @param array $data
     * @return void
     */
    private function createOrUpdateEstancia(array $data): void
    {
        $estancia = Estancia::onlyTrashed()->where('telefone', $data['telefone'])->first();

        if ($estancia) {
            $estancia->restore();
        } else {
            Estancia::create($data);
        }
    }

    /**
     * Delete an Estancia.
     *
     * @return RedirectResponse
     */
    public function delete(): RedirectResponse
    {
        $id = request()->route('id');
        $estancia = Estancia::findOrFail($id);
        $estancia->delete();

        return redirect()->route('estancias.index');
    }
}
