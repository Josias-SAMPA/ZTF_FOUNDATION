document.addEventListener('DOMContentLoaded', function() {
        const welcomeMessage = document.getElementById('welcome-message');
        if (welcomeMessage) {
            setTimeout(() => {
                welcomeMessage.style.display = 'none';
            }, 5000);
        }
    });
