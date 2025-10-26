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
            <h2>VÃ©rification d'identitÃ©</h2>
            <p>Veuillez entrer le code d'identification reÃ§u par email</p>
        </div>

        <form action="{{ route('verify.identification') }}" method="POST">
            @csrf
            <div class="code-input-container">
                <input type="text" class="code-digit" maxlength="1" pattern="[0-9]" required autofocus>
                <input type="text" class="code-digit" maxlength="1" pattern="[0-9]" required>
                <input type="text" class="code-digit" maxlength="1" pattern="[0-9]" required>
                <input type="text" class="code-digit" maxlength="1" pattern="[0-9]" required>
                <input type="text" class="code-digit" maxlength="1" pattern="[0-9]" required>
                <input type="text" class="code-digit" maxlength="1" pattern="[0-9]" required>
                <input type="text" class="code-digit" maxlength="1" pattern="[0-9]" required>
                <input type="text" class="code-digit" maxlength="1" pattern="[0-9]" required>
                <input type="hidden" name="verification_code" id="verification_code">
            </div>

            <div class="timer">
                Expire dans : <span id="timer">02:00</span>
            </div>

            @if ($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" class="submit-button">VÃ©rifier</button>
        </form>

        <div class="form-footer">
            <p>Vous n'avez pas reÃ§u de code ?</p>
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

