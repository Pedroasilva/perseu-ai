@extends('components.layout')

@section('content')

<h2>
    Estâncias (editar ou criar)
</h2>
<p>
    <a href="{{ route('estancias.index') }}" class="btn btn-primary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</p>
<form action="{{ route('estancias.editCreate', ['id' => $estancia->id ?? '']) }}" method="post">
    @csrf
    @method('POST')
    <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control" value="{{ $estancia->nome ?? ''}}">
    </div>
    <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea name="descricao" id="descricao" class="form-control">{{ $estancia->descricao ?? '' }}</textarea>
    </div>
    <div class="form-group">
        <label for="telefone">Telefone</label>
        <input type="text" name="telefone" id="telefone" class="form-control" value="{{ $estancia->telefone ?? '' }}">
    </div>
    <button type="submit" class="btn btn-success mt-4">
        <i class="fas fa-save"></i> Salvar
    </button>
</form>

@endsection
