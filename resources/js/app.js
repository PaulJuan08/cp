import './bootstrap';
import 'preline';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

function showTopic(title, desc, content) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDescription').textContent = desc;
    document.getElementById('modalContent').textContent = content;
}

window.showTopic = showTopic;