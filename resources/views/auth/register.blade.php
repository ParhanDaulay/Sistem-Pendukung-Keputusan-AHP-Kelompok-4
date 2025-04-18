<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="bg-white shadow-2xl rounded-2xl p-8 border border-orange-200">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama')" class="text-orange-600 font-semibold" />
            <x-text-input id="name" class="block mt-1 w-full border-orange-300 focus:border-orange-500 focus:ring-orange-500"
                          type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-orange-600 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-orange-300 focus:border-orange-500 focus:ring-orange-500"
                          type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-orange-600 font-semibold" />
            <x-text-input id="password" class="block mt-1 w-full border-orange-300 focus:border-orange-500 focus:ring-orange-500"
                          type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-orange-600 font-semibold" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full border-orange-300 focus:border-orange-500 focus:ring-orange-500"
                          type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-orange-500 hover:text-orange-700 transition duration-150 ease-in-out" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <x-primary-button class="bg-orange-600 hover:bg-orange-700 focus:ring-orange-500">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
