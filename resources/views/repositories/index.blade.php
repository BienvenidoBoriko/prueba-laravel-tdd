<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Repositorios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Enlace</th>
                            <th>ver</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($repositories as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->url}}</td>
                                <td><a href="{{route('repositories.show', $item->id)}}">ver</a> {{$item->url}}</td>
                                <td><a href="{{route('repositories.edit', $item->id)}}">Editar</a></td>
                            </tr>
                        @empty
                            <tr aria-colspan="3" colspan="3">
                                <td>No hay repositorios creados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
