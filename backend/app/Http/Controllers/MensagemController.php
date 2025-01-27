<?php

namespace App\Http\Controllers;

use App\Http\Requests\MensagemPostRequest;
use App\Models\Instancia;
use App\Models\Mensagem;
use App\Models\Contatos;
use App\Services\WhatsappApiService;
use Illuminate\Http\RedirectResponse;

class MensagemController extends Controller
{
    private WhatsappApiService $whatsAppApiService;

    public function __construct(WhatsappApiService $whatsAppApiService)
    {
        $this->whatsAppApiService = $whatsAppApiService;
    }

    public function index()
    {
        $instancias = Instancia::all();
        return view('mensagem.index', compact('instancias'));
    }

    public function enviarMensagem(MensagemPostRequest $request): RedirectResponse
    {
        $instancia = Instancia::findOrFail($request->instancia_id);
        $destinatario = $request->destinatario;
        $corpo = $request->mensagem;

        $message = $this->whatsAppApiService->sendMessage($instancia->telefone, $destinatario, $corpo);

        if (!$message['success']) {
            return redirect()->route('mensagem.index')->with('error', 'Erro ao enviar mensagem');
        }

        $this->saveMensagem($instancia, $destinatario, $corpo);
        $this->saveContato($instancia, $destinatario);

        return redirect()->route('mensagem.index')->with('success', 'Mensagem enviada com sucesso');
    }

    private function saveMensagem(Instancia $instancia, string $destinatario, string $corpo): void
    {
        $mensagem = new Mensagem();
        $mensagem->instancia_id = $instancia->id;
        $mensagem->numero_envio = $instancia->telefone;
        $mensagem->numero_recebimento = $destinatario;
        $mensagem->corpo_mensagem = $corpo;
        $mensagem->enviado = true;
        $mensagem->save();
    }

    private function saveContato(Instancia $instancia, string $destinatario): void
    {
        $contato = new Contatos();
        $contato->instancia_id = $instancia->id;
        $contato->numero = $destinatario;
        $contato->nome = $this->whatsAppApiService->getContactInfo($instancia->telefone, $destinatario)['result']['pushname'];
        $contato->save();
    }
}
