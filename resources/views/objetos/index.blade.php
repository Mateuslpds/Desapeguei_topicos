<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus objetos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div id="objects-container" class="px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 w-full">
            <!-- Conteúdo será inserido via JavaScript -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/graphql', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    query: `
                    query {
                        objetos {
                            id
                            nome
                            descricao
                            cep
                            imagem
                        }
                    }
                    `
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                const objectsContainer = document.getElementById('objects-container');
                const objetos = data.data.objetos;

                if (objetos.length > 0) {
                    objetos.forEach(objeto => {
                        const card = `
                            <div class="relative max-w-sm bg-white border border-gray-200 rounded-lg shadow">
                                <img class="w-full h-64 object-cover" src="/img/objetos/${objeto.imagem}" alt="Imagem do objeto" />
                                <div class="p-5">
                                    <h5 class="mb-2 text-2xl font-bold">${objeto.nome}</h5>
                                    <p class="font-normal text-gray-700">
                                        <b>Descrição:</b> ${objeto.descricao}<br>
                                        <b>CEP:</b> ${objeto.cep}<br>
                                    </p>
                                    <div class="flex justify-between mt-4">
                                        <a href="/objetos/${objeto.id}/edit"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                            <span class="px-1">Editar</span>
                                        </a>
                                        <form action="/objetos/${objeto.id}" method="POST" class="inline-flex">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-red-500 rounded-lg hover:bg-red-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                                <span class="px-1">Excluir</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        `;
                        objectsContainer.innerHTML += card;
                    });
                } else {
                    objectsContainer.innerHTML = '<p class="text-gray-500 text-lg">Você não possui objetos.</p>';
                }
            })
            .catch(error => console.error('Error fetching objects:', error));
        });
    </script>
</x-app-layout>
