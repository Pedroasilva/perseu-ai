@extends('components.layout')

@section('content')
    <h2>
        Instâncias
    </h2>
    <p>
        <a href="{{ route('instancias.create') }}" class="btn btn-success text-white">
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
                <th>Status</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($instancias as $instancia)
                <tr>
                    <td>{{ str_pad($instancia->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $instancia->telefone) }}</td>
                    <td>{{ $instancia->nome }}</td>
                    <td>{{ $instancia->descricao }}</td>
                    <td>
                        @if (!$instancia->vinculado)
                            <a href="{{ route('instancias.vincular', ['id' => $instancia->id]) }}" title="Whatsapp não vinculado, clique para vincular">
                                <span class="badge text-bg-danger">WHATSAPP NÃO VINCULADO</span>
                            </a>
                        @else
                            <a href="{{ route('instancias.desvincular', ['id' => $instancia->id]) }}" title="Whatsapp vinculado, clique para desvincular">
                                <span class="badge text-bg-success">WHATSAPP VINCULADO</span>
                            </a>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('instancias.edit', ['id' => $instancia->id]) }}" class="btn btn-primary" title="Ver">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="{{ route('instancias.delete', ['id' => $instancia->id]) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" title="Deletar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
