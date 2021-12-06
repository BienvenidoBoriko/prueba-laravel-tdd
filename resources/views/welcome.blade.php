<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Repositorios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                @forelse ($repositories as $item)
                    <h1>{{ $item->url }}</h1>
                    <div>{{ $item->description }}</div>
                @empty
                    <p>No hay repositorios creados</p>
                @endforelse
                </tbody>
                </table>
            </div>
        </div>
    </div>
</x-guest-layout>
