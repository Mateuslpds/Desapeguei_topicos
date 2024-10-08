<x-app-layout>

    <div class="h bg-gradient-to-r from-blue-300 to-blue-400">
        <h1 class="flex flex-col text-center mb-2 pt-5 text-5xl font-extrabold dark:text-blue-900 drop-shadow-lg shadow-black">Bem-vindo ao Desapeguei!</h1>
        <div class="flex flex-col text-center pb-4 text-2xl font-semibold text-white drop-shadow-lg shadow-black">
            <h1>
                Desapegue do que não precisa e abrace um futuro sustentável.
                <br>
            </h1>
        </div>
        
        <div class="flex flex-col items-center justify-center p-5"> <!--- Botão de doar -->
            <a href="/objetos/create" class="h-12 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 25 25" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="px-2 text-lg">Doar um objeto</div>
            </a>
        </div>
    </div>

    <div class="py-8" x-data="{ typeFilter: '' }">

        <div class="flex mb-5">
            <h1 class="pl-10 pb-2 text-4xl font-semibold text-gray-600">Doações</h1>
            <div class="px-8">
                <select class="py-3 px-4 pr-9 block w-100 border-blue-500 rounded-full text-sm focus:border-blue-500 focus:ring-blue-500" x-model="typeFilter" name="typeFilter" id="typeFilter">
                    <option value="">Clique aqui para filtrar os objetos por tipo</option>
                    @foreach (\App\Models\Tipo::all() as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->descricao }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="py-2 px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 w-full">
            @foreach (\App\Models\Objeto::all() as $objeto)
            @if ($objeto->agendamentos->where('status', 'entregue')->count() == 0)
            <span x-show="typeFilter == '' || typeFilter == '{{ $objeto->tipo_id }}'">
                <div class="max-w-sm py-2 bg-white border border-gray-200 rounded-lg shadow hover:-translate-y-1 hover:scale-105 duration-300">
                    <a href="" class="px-2 ml-2 font-regular text-gray-900">
                        <span class="font-bold">
                            {{ $objeto->usuarioDoador->name }}
                        </span>
                        publicou:
                    </a>
                    <img style="height: 400px; width:400px" class="md:w-full pt-2" src="{{ $objeto->imagem }}" alt="Imagem do objeto" />
                    </a>
                    <div class="p-5">
                        <h5 class="flex flex-col mb-2 text-2xl tracking-tight text-gray-900">
                            <div class="text-center"> {{ $objeto->nome }} </div>
                            <hr>
                        </h5>

                        <p class="mb-3 font-normal text-gray-700">
                            <b>Descrição:</b> {{ $objeto->descricao }}
                            <br>
                            <b>CEP do doador:</b> {{ $objeto->cep }}
                            <br>
                            <b>Tipo do objeto:</b> {{ $objeto->tipos->descricao }}
                            <br>
                        </p>
                        <div>
                            <a href="/objetos/{{ $objeto->id }}" class="inline-flex px-3 py-2 text-sm font-medium text-center text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Realizar agendamento
                                <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </span>
            @endif
            @endforeach
        </div>
    </div>
</x-app-layout>