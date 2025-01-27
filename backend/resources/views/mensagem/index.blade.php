@extends('components.layout')

@section('content')
<h1 class="text-center my-4">Enviar Mensagem</h1>

<form action="{{ route('mensagem.enviar') }}" method="POST" class="w-50 mx-auto">
    @if ($errors->any())
        <div class="alert alert-danger mt-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success mt-4">
            {{ session('success') }}
        </div>
    @endif

    @csrf
    @method('POST')
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="estancia_id">Estância:</label>
                <select name="estancia_id" id="estancia_id" class="form-control">
                    <option value="" selected disabled>Selecione uma estância</option>
                    @foreach($estancias as $estancia)
                    <option value="{{ $estancia->id }}" {{ old('estancia_id') == $estancia->id ? 'selected' : '' }}>
                        {{ preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $estancia->telefone) }} - {{ $estancia->descricao }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="destinatario">Destinatário:</label>
                <input type="text" name="destinatario" id="destinatario" class="form-control" value="{{ old('destinatario') }}">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="mensagem">Mensagem:</label>
        <textarea name="mensagem" id="mensagem" class="form-control" rows="5">{{ old('mensagem') }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Enviar</button>
</form>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#destinatario').mask('(00) 00000-0000');
        });
    </script>
@endsection
