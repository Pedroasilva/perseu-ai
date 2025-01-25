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

@if(isset($qrCode))
    <div class="text-center mt-4">
        <h3>QR Code</h3>
        <p>Escaneie o QR Code abaixo para vincular a estância</p>
        <img src="{{ $qrCode }}" alt="QR Code">
    </div>
@endif

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#telefone').mask('(00) 00000-0000');
        });

        document.addEventListener('DOMContentLoaded', function() {
            var qrCodeElement = document.querySelector('img[alt="QR Code"]');
            if (qrCodeElement) {
                QRCode.toDataURL('{{$qrCode}}', function (err, url) {
                    if (!err) {
                        qrCodeElement.src = url;
                    }
                });
            }
        });
    </script>
@endsection
