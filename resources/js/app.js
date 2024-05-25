import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.pagination a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            fetchPage(this.href);
        });
    });

    function fetchPage(url) {
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.text())
            .then(data => {
                const tableContainer = document.querySelector('.overflow-x-auto');
                tableContainer.innerHTML = data;
                document.querySelectorAll('.pagination a').forEach(function(link) {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        fetchPage(this.href);
                    });
                });
            })
            .catch(error => console.error('Error:', error));
    }
});
