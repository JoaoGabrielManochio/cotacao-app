<table class="table table-striped">
    <thead>
        <tr>
            <th class="text-center" scope="col">Nome</th>
            <th class="text-center" scope="col">Email</th>
            <th class="text-center" scope="col">Criado em</th>
            <th class="text-center" scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td class="text-center">{{ $user->name }}</td>
                <td class="text-center">{{ $user->email }}</td>
                <td class="text-center">{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                <td class="text-center">
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Editar</a>
                    <button type="button" onclick="return (confirm('Tem certeza que deseja excluir?') ? document.getElementById('form-{{ $user->id }}').submit() : false);" class="btn btn-sm btn-danger">Excluir</button>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" id="form-{{ $user->id }}">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
