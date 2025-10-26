<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des rÃ´les</title>
  
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
  <div class="container">
    <h1>Liste des rÃ´les</h1>

    <a href="{{ route('roles.create') }}" class="btn btn-primary">+ Nouveau rÃ´le</a>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">Retour au dashboard</a>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Nom</th>
            <th>Display Name</th>
            <th>Grade</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($roles as $role)
          <tr>
            <td>{{ $role->name }}</td>
            <td>{{ $role->display_name }}</td>
            <td>{{ $role->grade }}</td>
            <td>{{ $role->description }}</td>
            <td class="actions">
              <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-secondary">Modifier</a>
              <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Supprimer ce rÃ´le ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Supprimer</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5">Aucun rÃ´le trouvÃ©.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>

