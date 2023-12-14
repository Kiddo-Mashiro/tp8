document.addEventListener('DOMContentLoaded', function () {
    loadCSVContent();
});

function loadCSVContent() {
    const csvFile = 'fichier.csv';

    fetch(csvFile)
        .then(response => response.text())
        .then(csvData => {
            displayCSVContent(csvData);
        })
        .catch(error => console.error('Erreur lors de la récupération du fichier CSV :', error));
}

function displayCSVContent(data) {
    const csvContentDiv = document.getElementById('csv-content');

    const lines = data.split('\n');

    const ul = document.createElement('ul');


    lines.forEach(line => {
        const li = document.createElement('li');
        li.textContent = line;
        ul.appendChild(li);
    });

    csvContentDiv.appendChild(ul);
}