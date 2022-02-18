<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img width="250" src="{{ url('img/logoRed.png') }}" />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Zaboravili ste lozinku? Nema problema! Ukucajte svoju email adresu i poslati ćemo vam link pomoću kojeg možete promjeniti lozinku.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Pošalji mi link za promjenu lozinke') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
