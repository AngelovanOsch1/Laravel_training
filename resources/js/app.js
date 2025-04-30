import './bootstrap';
import { initFlowbite } from 'flowbite';

// Ensure Livewire is available
document.addEventListener('DOMContentLoaded', () => {
    if (window.Livewire) {
        Livewire.hook('message.processed', () => {
            initFlowbite();
        });

        document.addEventListener('livewire:navigated', () => {
            initFlowbite();
        });
    }
});
