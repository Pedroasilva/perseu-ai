@extends('components.layout')

@section('content')

<form action="{{ route('mensagem.enviar') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="estancia">Estância:</label>
        <select name="estancia" id="estancia" class="form-control">
            <option value="" selected disabled>Selecione uma estância</option>
            @foreach($estancias as $estancia)
            <option value="{{ $estancia->id }}">{{ preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $estancia->telefone) }} - {{ $estancia->descricao }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" id="telefone" class="form-control">
    </div>
    <div class="form-group">
        <label for="mensagem">Mensagem:</label>
        <textarea name="mensagem" id="mensagem" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Enviar</button>
</form>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#telefone').mask('(00) 00000-0000');
        });
    </script>
@endsection
