<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus agendamentos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <!--<x-welcome />-->
            <h1>Seus agendamentos solicitados</h1>
            <div class="flex flex-col gap-2">
                @foreach (\App\Models\Agenda::all() as $agenda)
                @if ($agenda->usuarioDest_id == auth()->id())
                <div class="bg-gray-300 grid grid-cols-8 text-center p-2 relative" x-data="{ editMode: false }">
                    <div class="col-span-6 text-left">
                        <template x-if="!editMode">
                            <span>
                                {{ $agenda->objetos->nome }}
                                -
                                {{ $agenda->data }}
                                -
                                {{ $agenda->status }}
                            </span>
                        </template>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        <br>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <!--<x-welcome />-->
            <h1>Agendamentos solicitados para seus objetos</h1>
            <div class="flex flex-col gap-2">
                @foreach (\App\Models\Agenda::all() as $agenda)
                @if ($agenda->usuarioDoar_id == auth()->id())
                <div class="bg-gray-300 grid grid-cols-8 text-center p-2 relative" x-data="{ editMode: false }">
                    <div class="col-span-6 text-left">
                        <template x-if="!editMode">
                            <span>
                                {{ $agenda->objetos->nome }}
                                -
                                {{ $agenda->data }}
                                -
                                {{ $agenda->status }}
                            </span>
                        </template>
                        <template x-if="editMode">
                            <form action="{{ route('agenda.update', $agenda) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="text" name="data" value="{{ $agenda->data }}" />
                                <button>Salvar</button>
                            </form>
                        </template>
                    </div>
                    

                    
                    <template x-if="!editMode">
                        <div class="cursor-pointer hover:bg-gray-700 hover:text-white" @click="editMode = true">
                            Editar
                        </div>
                    </template>
                    <template x-if="editMode">
                        <div class="cursor-pointer hover:bg-gray-700 hover:text-white" @click="editMode = false">
                            Cancelar
                        </div>
                    </template>
                    <div class="cursor-pointer hover:bg-red-700 hover:text-white">
                        <form action="{{ route('agenda.destroy', $agenda) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button>Excluir</button>
                        </form>
                    </div>
                </div>
                <form action="{{ route('agenda.updateStatus', $agenda) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <button type="submit">confirmar envio</button>
                </form>
                @endif
                @endforeach
            </div>
        </div>
    </div>
    </div>
    </div>
</x-app-layout>