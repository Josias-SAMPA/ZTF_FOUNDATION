<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZTF Foundation - Authentification 2FA</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/2fa.css') }}">
</head>
<body>
    <div class="container">
        <h1 class="auth-title">
            Authentification Ã  Deux Facteurs
            <span>SÃ©curisez votre connexion</span>
        </h1>
        <div class="steps">
            <div class="step active" data-step="1">1</div>
            <div class="step" data-step="2">2</div>
            <div class="step" data-step="3">3</div>
        </div>

        <!-- Ã‰tape 1: Email Form -->
        <div class="form-stage active" id="stage1">
            <form id="emailForm" action="{{ route('sendCode') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Adresse Email</label>
                    <input type="email" id="email" name="email" class="form-input" 
                           value="{{old('email')}}" required 
                           placeholder="exemple@ztffoundation.com">
                    @error('email')
                        <div class="error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn">
                    <i class="fas fa-paper-plane"></i>
                    Envoyer le code
                </button>
            </form>
        </div>

        <!-- Ã‰tape 2: Code Verification -->
        <div class="form-stage" id="stage2">
            <div class="timer">
                <i class="fas fa-clock"></i>
                Code expire dans : <span id="countdown">30</span>s
            </div>
            <form id="verificationForm" action="{{ route('verifyCode') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="code">Code de vÃ©rification</label>
                    <input type="text" id="code" name="code" class="form-input" 
                           required pattern="\d{12}" maxlength="12"
                           placeholder="000000000000">
                    @error('code')
                        <div class="error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn">
                    <i class="fas fa-shield-alt"></i>
                    VÃ©rifier
                </button>
            </form>
        </div>

        <!-- Ã‰tape 3: Success Message -->
        <div class="form-stage" id="stage3">
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <p>Authentification rÃ©ussie!</p>
                <p>Redirection en cours...</p>
            </div>
        </div>
    </div>

    
    <script src="{{ asset('js/2fa.js') }}"></script>
</body>
</html>

