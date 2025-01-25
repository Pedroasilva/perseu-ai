@extends('components.layout')

@section('content')
    <h2>
        Estâncias
    </h2>
    <p>
        <a href="{{ route('estancias.create') }}" class="btn btn-success text-white">
            <i class="fas fa-plus"></i> Nova
        </a>
    </p>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Instância</th>
                <th>Telefone</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estancias as $estancia)
                <tr>
                    <td>{{ str_pad($estancia->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $estancia->telefone) }}</td>
                    <td>{{ $estancia->nome }}</td>
                    <td>{{ $estancia->descricao }}</td>
                    <td>
                        <a href="{{ route('estancias.edit', ['id' => $estancia->id]) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('estancias.delete', ['id' => $estancia->id]) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
