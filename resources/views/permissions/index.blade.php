<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des permissions</title>
  
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
  <div class="container">
    <h1>Liste des permissions</h1>

    <a href="{{ route('permissions.create') }}" class="btn btn-primary">+ Nouvelle permission</a>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">Retour au dashboard</a>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>RÃ´les associÃ©s</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($permissions as $permission)
          <tr>
            <td>{{ $permission->name }}</td>
            <td>{{ $permission->description }}</td>
            <td>
              @forelse($permission->roles as $role)
                <span class="role-badge">{{ $role->display_name ?? $role->nom }}</span>
              @empty
                <em>Aucun rÃ´le associÃ©</em>
              @endforelse
            </td>
            <td class="actions">
              <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-secondary">Modifier</a>
              <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('Supprimer cette permission ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Supprimer</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4">Aucune permission trouvÃ©e.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>

