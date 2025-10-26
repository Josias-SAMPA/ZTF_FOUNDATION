<!DOCTYPE html>
@php
    // DÃ©bogage des variables
    if (isset($activeUsers)) {
        dd($activeUsers);
    } else {
        dd('$activeUsers n\'est pas dÃ©fini');
    }
@endphp
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - ZTF Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    
    
    <link rel="stylesheet" href="{{ asset('css/statistique.css') }}">
</head>
<body>
    
    <div class="dashboard-container">
        <main class="main-content" style="margin-left: 0;">
            <div class="page-header">
                <h1 class="page-title">Statistiques d'Utilisation</h1>
                <div class="breadcrumb">Tableau de bord / Statistiques</div>
            </div>

            <div class="header-actions">
                <div class="date-filter">
                    <a href="{{ route('dashboard') }}" class="refresh-button">
                        <i class="fas fa-arrow-left"></i>
                        Retour au Dashboard
                    </a>
                    <input type="date" id="startDate" onchange="updateStats()">
                    <input type="date" id="endDate" onchange="updateStats()">
                    <select id="timeRange" onchange="updateDateRange()">
                        <option value="week">7 derniers jours</option>
                        <option value="month">30 derniers jours</option>
                        <option value="year">12 derniers mois</option>
                    </select>
                </div>
                <button class="refresh-button" onclick="refreshStats()">
                    <i class="fas fa-sync-alt"></i>
                    Actualiser
                </button>
            </div>

            <!-- Statistiques des utilisateurs actifs -->
            <div class="stats-section">
                <h2 class="section-title">Utilisateurs Actuellement Actifs</h2>
                <div class="active-users-grid">
                    @forelse($activeUsers as $user)
                        <div class="user-card {{ $user['is_online'] ? 'online' : '' }}">
                            <div class="user-info">
                                <div class="user-name">{{ $user['name'] }}</div>
                                <div class="user-meta">
                                    <span class="department">{{ $user['department'] }}</span>
                                    <span class="status-dot"></span>
                                    <span class="session-time">Session: {{ $user['session_duration'] }}</span>
                                </div>
                            </div>
                            <div class="connection-time">
                                ConnectÃ© depuis {{ $user['last_login'] }}
                            </div>
                        </div>
                    @empty
                        <div class="no-data">Aucun utilisateur actif actuellement</div>
                    @endforelse
                </div>
            </div>

            <!-- Connexions d'aujourd'hui -->
            <div class="stats-section">
                <h2 class="section-title">Connexions Aujourd'hui</h2>
                <div class="connections-grid">
                    @forelse($todayLogins as $login)
                        <div class="connection-card {{ $login['is_still_active'] ? 'still-active' : '' }}">
                            <div class="user-info">
                                <div class="user-name">{{ $login['name'] }}</div>
                                <div class="user-meta">
                                    <span class="department">{{ $login['department'] }}</span>
                                </div>
                            </div>
                            <div class="login-time">
                                Connexion Ã  {{ $login['login_time'] }}
                            </div>
                        </div>
                    @empty
                        <div class="no-data">Aucune connexion aujourd'hui</div>
                    @endforelse
                </div>
            </div>

            <!-- Temps moyen de session -->
            <div class="stats-section">
                <h2 class="section-title">Temps Moyen de Session par Utilisateur</h2>
                <div class="global-average">
                    Moyenne globale : <span class="highlight">{{ $avgSessionTime['global_average'] }}</span>
                </div>
                <div class="sessions-grid">
                    @forelse($avgSessionTime['sessions'] as $session)
                        <div class="session-card">
                            <div class="user-info">
                                <div class="user-name">{{ $session['name'] }}</div>
                                <div class="user-meta">
                                    <span class="department">{{ $session['department'] }}</span>
                                </div>
                            </div>
                            <div class="average-time">
                                {{ $session['average_time'] }}
                            </div>
                        </div>
                    @empty
                        <div class="no-data">Aucune donnÃ©e de session disponible</div>
                    @endforelse
                </div>
            </div>

            <!-- Statistiques globales -->
            <div class="stats-container">
                <div class="stat-card">
                    <h3>Total Utilisateurs</h3>
                    <div class="value">{{ $totalRegistrations ?? 0 }}</div>
                    @if(isset($departmentName))
                        <div class="subtitle">Dans {{ $departmentName }}</div>
                    @endif
                </div>
            </div>

            <div class="chart-grid">
                <div class="chart-container">
                    <h3>Connexions par Jour</h3>
                    <canvas id="loginChart"></canvas>
                </div>
                <div class="chart-container">
                    <h3>Utilisateurs par DÃ©partement</h3>
                    <canvas id="departmentChart"></canvas>
                </div>
                <div class="chart-container">
                    <h3>ActivitÃ© par Heure</h3>
                    <canvas id="hourlyActivityChart"></canvas>
                </div>
                <div class="chart-container">
                    <h3>Distribution des RÃ´les</h3>
                    <canvas id="roleDistributionChart"></canvas>
                </div>
            </div>
        </main>
    </div>

    
    <script src="{{ asset('js/statistique.js') }}"></script>
</body>
</html>

