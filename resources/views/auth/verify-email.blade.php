<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <img width="250" src="{{ url('img/logoRed.png') }}" />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Čestitamo, uspješno ste kreirali račun! Prije nego što nastavimo, molimo vas da kliknete na link koji smo vam poslali putem emaila. Ukoliko niste dobili email, rado ćemo vam poslati novi.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Novi link za potvrdu kreiranja računa poslali smo na vašu email adresu.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-jet-button type="submit">
                        {{ __('Ponovo pošalji email') }}
                    </x-jet-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
