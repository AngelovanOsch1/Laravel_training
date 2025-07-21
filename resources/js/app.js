import './bootstrap';
import './audio-player';
import './modal';

window.Echo.private('chat.3')
    .listen('.message.created', (e) => {
    console.log('Received message.created event:', e);
    Livewire.emit('incomingMessage', e.message);
    });

    window.Echo.channel('test')
.listen('.lol', (e) => {
    alert(e);
});
