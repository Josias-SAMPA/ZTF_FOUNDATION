<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le dÃ©partement - {{ $department->name }}</title>
    
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
</head>
<body>
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Modifier le dÃ©partement : {{ $department->name }}</h1>
                <p class="text-secondary">Modifiez les informations du dÃ©partement et ses services associÃ©s</p>
            </div>

            <form action="{{ route('departments.update', $department) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="name">Nom du dÃ©partement</label>
                    <input type="text" id="name" name="name" class="form-input" 
                           value="{{ old('name', $department->name) }}" required>
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea id="description" name="description" class="form-input form-textarea" 
                              required>{{ old('description', $department->description) }}</textarea>
                    @error('description')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="head_id">Chef de dÃ©partement</label>
                    <select id="head_id" name="head_id" class="form-input" required>
                        <option value="">SÃ©lectionner un chef de dÃ©partement</option>
                        @foreach($users ?? [] as $user)
                            <option value="{{ $user->id }}" 
                                {{ old('head_id', $department->head_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name ?? $user->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('head_id')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="skills-section">
                    <h3>CompÃ©tences requises</h3>
                    <div class="skills-list">
                        @foreach($department->skills as $skill)
                            <div class="skill-item">
                                <span class="skill-name">{{ $skill->name }}</span>
                                <button type="button" class="remove-skill" 
                                        onclick="removeSkill(this)" data-skill-id="{{ $skill->id }}">&times;</button>
                            </div>
                        @endforeach
                    </div>

                    <div class="add-skill">
                        <h4>Ajouter une compÃ©tence</h4>
                        <div class="input-group">
                            <input type="text" class="form-input" id="newSkillName" 
                                   placeholder="Nom de la compÃ©tence">
                            <button type="button" class="btn btn-primary" onclick="addSkill()">Ajouter</button>
                        </div>
                    </div>
                </div>

                <div class="actions">
                    <div>
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                        <a href="{{ route('departments.show', $department) }}" class="btn btn-secondary">Annuler</a>
                    </div>
                    
                    <form action="{{ route('departments.destroy', $department) }}" 
                          method="POST" 
                          onsubmit="return confirm('ÃŠtes-vous sÃ»r de vouloir supprimer ce dÃ©partement ?');"
                          style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer le dÃ©partement</button>
                    </form>
                </div>
            </form>
        </div>

        <div class="card">
            <h2>Services associÃ©s</h2>
            <div class="services-list">
                @forelse($department->services as $service)
                    <div class="service-item">
                        <div class="service-info">
                            <h4>{{ $service->name }}</h4>
                            <p>{{ $service->users->count() }} employÃ©(s)</p>
                        </div>
                        <div class="service-actions">
                            <a href="{{ route('services.edit', $service) }}" class="btn btn-secondary">Modifier</a>
                        </div>
                    </div>
                @empty
                    <p>Aucun service associÃ© Ã  ce dÃ©partement</p>
                @endforelse
            </div>
            <div class="actions" style="margin-top: 1rem;">
                <a href="{{ route('services.create', ['department_id' => $department->id]) }}" 
                   class="btn btn-primary">Ajouter un service</a>
            </div>
        </div>
    </div>

    
    <script src="{{ asset('js/edit.js') }}"></script>
</body>
</html>

