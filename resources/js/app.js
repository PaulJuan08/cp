import './bootstrap';
import 'preline';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

function showTopic(title, desc, content) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDescription').textContent = desc;
    document.getElementById('modalContent').textContent = content;
}

window.showTopic = showTopic;


document.addEventListener('DOMContentLoaded', function () {
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error('Error initializing CKEditor:', error);
        });
});
<<<<<<< Updated upstream

=======
<<<<<<< HEAD
<<<<<<< Updated upstream
=======


<<<<<<< Updated upstream
>>>>>>> Stashed changes
=======
>>>>>>> Stashed changes
=======
>>>>>>> parent of c90dbe7 (done major functionalities)
>>>>>>> Stashed changes
