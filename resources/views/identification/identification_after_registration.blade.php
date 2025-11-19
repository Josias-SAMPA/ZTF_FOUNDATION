<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZTF Foundation Identification</title>
    <link rel="stylesheet" href="{{ asset('first_registration.css') }}">
    <link rel="stylesheet" href="{{asset('identification_after_registration.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h2>Vérification d'identité</h2>
            <p>Veuillez entrer le code d'identification reçu par email</p>
        </div>

        <form action="{{ route('verify.identification') }}" method="POST">
            @csrf
            <div class="code-input-container">
                <input type="text" class="code-digit" maxlength="1" required autofocus inputmode="numeric">
                <input type="text" class="code-digit" maxlength="1" required inputmode="numeric">
                <input type="text" class="code-digit" maxlength="1" required inputmode="numeric">
                <input type="text" class="code-digit" maxlength="1" required inputmode="numeric">
                <input type="text" class="code-digit" maxlength="1" required inputmode="numeric">
                <input type="text" class="code-digit" maxlength="1" required inputmode="numeric">
                <input type="text" class="code-digit" maxlength="1" required inputmode="numeric">
                <input type="text" class="code-digit" maxlength="1" required inputmode="numeric">
                <input type="hidden" name="verification_code" id="verification_code">
            </div>

            <div class="timer">
                Expire dans : <span id="timer">02:00</span>
            </div>

            @if(session('success'))
                <div class="success-message" style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 15px;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-message" style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 15px;">
                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" class="submit-button">Vérifier</button>
        </form>

        <div class="form-footer">
            <p>Vous n'avez pas reçu de code ?</p>
            <form action="{{route('resend.code')}}" method="POST">
                @csrf
                <button type="submit" class="resend-button">
                    <i class="fas fa-sync-alt"></i> Renvoyer le code
                </button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/identification_after_registration.js') }}"></script>
</body>
</html>

