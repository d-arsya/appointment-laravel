<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Buat Janji Temu') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Buat jadwal janji temu anda') }}
        </p>
    </header>

    <form method="post" action="{{ route('appointment.store') }}" class="mt-6 space-y-6">
        @csrf
        <div>
            <x-input-label for="doctor_id" :value="__('Dokter')" />
            <x-dropdown-input id="doctor_id" name="doctor_id" type="text" class="mt-1 block w-full" required autofocus
                autocomplete="doctor_id">
                @foreach ($doctors as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->name }}</option>
                @endforeach
            </x-dropdown-input>
            <x-input-error class="mt-2" :messages="$errors->get('doctor_id')" />
        </div>
        <input type="hidden" name="patient_id" value="{{ auth()->user()->id }}">
        <div>
            <x-input-label for="time" :value="__('Jam')" />
            <x-text-input id="time" name="time" :value="old('time')" type="number" class="mt-1 block w-full"
                required autofocus autocomplete="time" />
            <x-input-error class="mt-2" :messages="$errors->get('time')" />
        </div>
        <div>
            <x-input-label for="date" :value="__('Tangal')" />
            <x-text-input id="date" name="date" type="date" :value="old('date')" class="mt-1 block w-full"
                required autofocus autocomplete="date" />
            <x-input-error class="mt-2" :messages="$errors->get('date')" />
        </div>

        <div class="flex items-center gap-4">
            <a class='inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'
                href="{{ route('appointment.index') }}">Batal</a>
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
