<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline">
            {{ __('Janji Temu') }}
        </h2>
        @if (auth()->user()->role == 'patient')
            <a class='inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'
                href="{{ route('appointment.create') }}">Buat Janji Temu</a>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-gray-900 dark:text-gray-100 relative overflow-x-auto">
                    @if ($appointments->count())
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    @if (auth()->user()->role == 'doctor')
                                        <th scope="col" class="px-6 py-3">
                                            Pasien
                                        </th>
                                    @else
                                        <th scope="col" class="px-6 py-3">
                                            Dokter
                                        </th>
                                    @endif
                                    <th scope="col" class="px-6 py-3">
                                        Jadwal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $item)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        @if (auth()->user()->role == 'doctor')
                                            <td class="px-6 py-4">
                                                {{ $item->patient->name }}
                                            </td>
                                        @else
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $item->doctor->name }}
                                            </th>
                                        @endif
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($item->book)->isoFormat('DD MMMM Y hh:mm') }}
                                        </td>
                                        <td class="px-6 py-4 flex gap-2">
                                            @if (auth()->user()->role == 'patient')
                                                <a class='inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'
                                                    href="{{ route('appointment.edit', $item->id) }}">Edit</a>
                                            @endif
                                            <form action="{{ route('appointment.destroy', $item->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button
                                                    class='px-4 py-2 bg-{{ auth()->user()->role == 'doctor' ? 'blue' : 'red' }}-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-{{ auth()->user()->role == 'doctor' ? 'blue' : 'red' }}-500 active:bg-{{ auth()->user()->role == 'doctor' ? 'blue' : 'red' }}-700 focus:outline-none focus:ring-2 focus:ring-{{ auth()->user()->role == 'doctor' ? 'blue' : 'red' }}-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'>
                                                    {{ auth()->user()->role == 'doctor' ? 'Selesai' : 'Batalkan' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        belum ada janji temu
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
