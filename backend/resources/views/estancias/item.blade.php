@extends('components.layout')

@section('content')

<h2>
    @if(isset($estancia->id))
        Editar
    @else
        Criar
    @endif
    Estância
</h2>
<p>
    <a href="{{ route('estancias.index') }}" class="btn btn-primary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</p>

@if ($errors->any())
    <div class="alert alert-danger mt-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('estancias.editCreate', ['id' => $estancia->id ?? '']) }}" method="post">
    @csrf
    @method('POST')
    <div class="form-group">
        <label for="nome">Nome *</label>
        <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome', $estancia->nome ?? '') }}">
    </div>
    <div class="form-group">
        <label for="descricao">Descrição *</label>
        <textarea name="descricao" id="descricao" class="form-control">{{ old('descricao', $estancia->descricao ?? '') }}</textarea>
    </div>
    <div class="form-group">
        <label for="telefone">Telefone *</label>
        <input type="text" name="telefone" id="telefone" class="form-control" value="{{ old('telefone', $estancia->telefone ?? '') }}" readonly>
    </div>
    <button type="submit" class="btn btn-success mt-4">
        <i class="fas fa-save"></i> Salvar
    </button>
</form>

@if(!$estancia->vinculado)
    <div class="mt-4">
        <button id="verQrCodeBtn" class="btn btn-info" data-toggle="modal" data-target="#qrCodeModal">
            <i class="fas fa-qrcode"></i> Ver QR Code
        </button>

        <div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                    <div id="qrCodeContainer" class="text-center">
                        <h5 class="modal-title" id="qrCodeModalLabel">
                            Escaneie o QR Code para vincular a estância ao whatsapp
                        </h5>
                        <img alt="QR Code" class="img-fluid">
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endif

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#telefone').mask('(00) 00000-0000');
        });

        var qrCodeInterval;

        $('#verQrCodeBtn').on('click', function() {
            loadQrCode();
            qrCodeInterval = setInterval(loadQrCode, 10000);
            $('#qrCodeModal').modal('show');
        });

        $('#qrCodeModal').on('hidden.bs.modal', function () {
            clearInterval(qrCodeInterval);
        });

        function loadQrCode() {
            $.ajax({
            url: '{{ route('estancias.qrcode.ver', ['id' => $estancia->id ?? '']) }}',
            method: 'GET',
            success: function(response) {

                if (response.connected) {
                    window.location.href = '{{ route('estancias.index') }}';
                    return;
                }

                var qrCodeElement = document.querySelector('img[alt="QR Code"]');
                if (qrCodeElement) {
                QRCode.toDataURL(response.qr, function (err, url) {
                    if (!err) {
                    qrCodeElement.src = url;
                    }
                });
                }
                $('#qrCodeContainer').show();
            },
            error: function() {
                alert('Erro ao carregar o QR Code.');
            }
            });
        }

    </script>
@endsection
