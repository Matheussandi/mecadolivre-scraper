<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-center my-4">
                    <button id="scrape-button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Iniciar Web Scraping
                    </button>
                    <div id="success-message" class="mt-4 text-green-500" style="display: none;">
                        Scraping concluído com sucesso!
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('scrape-button').addEventListener('click', function() {
            const button = document.getElementById('scrape-button');
            button.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-white inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                Carregando...
            `;
            button.disabled = true;
            document.getElementById('success-message').style.display = 'none';

            fetch('/scrape')
                .then(response => response.json())
                .then(data => {
                    button.innerHTML = 'Iniciar Web Scraping';
                    button.disabled = false;
                    document.getElementById('success-message').style.display = 'block';
                })
                .catch(error => {
                    button.innerHTML = 'Iniciar Web Scraping';
                    button.disabled = false;
                    alert('Erro ao realizar o scraping');
                });
        });
    </script>
</x-app-layout>