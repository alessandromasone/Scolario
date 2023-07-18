// Seleziona tutti gli elementi con la classe "to-debug"
var elements = document.querySelectorAll('.on-listen');
const form = document.querySelector('#to-replace');

// Aggiungi un listener di tipo "input" per ogni elemento
elements.forEach(function(element) {
    element.addEventListener('input', function() {
        const button = document.createElement('button');
        button.classList.add('w-100', 'btn', 'btn-lg', 'blue-fb', 'mb-2', 'apply-button');
        button.type = 'submit';
        button.textContent = 'Applica modifiche';
        button.id = 'hide-on-click'; // Aggiungi l'ID all'elemento
        if (!form.querySelector('.apply-button')) {
            form.appendChild(button);
        }
        button.onclick = function() {
            setTimeout(function() {
                const element = document.querySelector('.apply-button');
                element.parentNode.removeChild(element); // Rimuovi l'elemento dal DOM
            }, 1);
        };

    });
});