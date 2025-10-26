    <link rel="stylesheet" href="{{ asset('css/manage.css') }}">
<div class="departments-management">
    <div class="section-header">
        <h2>Gestion des DÃ©partements</h2>
        <button class="btn btn-primary" onclick="toggleDepartmentForm()">
            <i class="fas fa-plus"></i> Nouveau DÃ©partement
        </button>
    </div>

    @include('committee.departments.create-modal')
    <!-- Modal pour assigner un chef de dÃ©partement -->
    <div id="assignHeadModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Assigner un Chef de DÃ©partement</h3>
                <button type="button" class="close-button" onclick="toggleAssignHeadModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="assignHeadForm" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="user_id">SÃ©lectionner un employÃ©</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">Choisir un employÃ©...</option>
                            @foreach($availableUsers ?? [] as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->matricule }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="toggleAssignHeadModal()">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Liste des dÃ©partements -->
    <div class="departments-grid">
        @foreach($departments ?? [] as $department)
            <div class="department-card">
                <div class="department-header">
                    <h3>{{ $department->name }}</h3>
                    <span class="department-code">{{ $department->code }}</span>
                </div>

                <div class="department-info">
                    <p>{{ $department->description }}</p>
                    
                    <div class="department-stats">
                        <div class="stat">
                            <i class="fas fa-users"></i>
                            <span>{{ $department->users_count ?? 0 }} employÃ©s</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-building"></i>
                            <span>{{ $department->services_count ?? 0 }} services</span>
                        </div>
                    </div>

                    <div class="head-info">
                        <h4>Chef de dÃ©partement</h4>
                        @if($department->head)
                            <div class="current-head">
                                <div class="head-details">
                                    <i class="fas fa-user-tie"></i>
                                    <span>{{ $department->head->name }}</span>
                                </div>
                                <div class="head-since">
                                    Depuis le {{ $department->head_assigned_at->format('d/m/Y') }}
                                </div>
                            </div>
                            <form action="{{ route('departments.head.remove', $department->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('ÃŠtes-vous sÃ»r de vouloir retirer ce chef de dÃ©partement ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-user-minus"></i> Retirer
                                </button>
                            </form>
                        @else
                            <div class="no-head">
                                <p><i class="fas fa-exclamation-triangle"></i> Aucun chef assignÃ©</p>
                                <button onclick="openAssignHeadModal('{{ $department->id }}')" 
                                        class="btn btn-primary btn-sm">
                                    <i class="fas fa-user-plus"></i> Assigner un chef
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="department-actions">
                    <a href="{{ route('departments.show', $department->id) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> DÃ©tails
                    </a>
                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('departments.destroy', $department->id) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('ÃŠtes-vous sÃ»r de vouloir supprimer ce dÃ©partement ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>




    <script src="{{ asset('js/manage.js') }}"></script>
