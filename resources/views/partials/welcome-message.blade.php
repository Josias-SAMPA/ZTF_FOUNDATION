    <link rel="stylesheet" href="{{ asset('css/welcome-message.css') }}">
@if(session('success') || session('message'))
    <div id="welcome-message" class="welcome-alert">
        {{ session('success') ?? session('message') }}
    </div>

    

    
@endif
</script>
    <script src="{{ asset('js/welcome-message.js') }}"></script>
