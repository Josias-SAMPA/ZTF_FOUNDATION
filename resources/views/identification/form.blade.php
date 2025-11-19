<!DOCTYPE html>
<html>
    <head>
        <title>ZTF Foundation First Register</title>
        <link rel="stylesheet" href="{{ asset('identification-form.css') }}">
    </head>
    <body>
        <h1>Welcome to the ZTF Foundation</h1>

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('identification.register') }}" method="POST" target="_blank" id="registrationForm">
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <label for="name">First Name:</label>
            <input type="text" id="name" name="first_name" value="{{old('name')}}" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="first_email" value="{{old('email')}}" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="first_password" required>

            <button type="submit" id="registerBtn">Register</button>
        </form>

        <script src="{{ asset('js/form.js') }}"></script>
    </body>
</html>