document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.play-btn').forEach(button => {
        button.addEventListener('click', () => {
            const audioId = button.getAttribute('data-audio-id');
            const audio = document.getElementById(audioId);
            const allAudios = document.querySelectorAll('audio');
            const allPlayIcons = document.querySelectorAll('.play-icon i');

            // Pause all other audios and reset icons
            allAudios.forEach(a => {
                if (a !== audio) {
                    a.pause();
                    a.currentTime = 0;
                }
            });

            allPlayIcons.forEach(icon => {
                icon.classList.remove('fa-pause');
                icon.classList.add('fa-play');
            });

            // Toggle play/pause for clicked audio
            if (audio.paused) {
                audio.play();
                button.querySelector('.play-icon i').classList.remove('fa-play');
                button.querySelector('.play-icon i').classList.add('fa-pause');
            } else {
                audio.pause();
                button.querySelector('.play-icon i').classList.remove('fa-pause');
                button.querySelector('.play-icon i').classList.add('fa-play');
            }

            // Reset icon when audio ends
            audio.onended = () => {
                button.querySelector('.play-icon i').classList.remove('fa-pause');
                button.querySelector('.play-icon i').classList.add('fa-play');
            };
        });
    });
});
