@extends('components.layout')

@section('content')
    <h2>
        Contatos
    </h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Instância</th>
                <th>Número</th>
                <th>Nome</th>
                <!-- <th>Opções</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($contatos as $contato)
                <tr>
                    <td>{{ $contato->instancia->nome }}</td>
                    <td>{{ preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $contato->numero) }}</td>
                    <td>{{ $contato->nome }}</td>
                    <!-- <td>
                        <a href="{{ route('contatos.edit', $contato->id) }}" class="btn btn-primary">Editar</a>
                        <form action="{{ route('contatos.destroy', $contato->id) }}" method="post" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </td> -->
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
