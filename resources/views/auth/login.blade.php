<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="bg-white shadow-2xl rounded-2xl p-8 border border-orange-200">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-orange-600 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-orange-300 focus:border-orange-500 focus:ring-orange-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-orange-600 font-semibold" />
            <x-text-input id="password" class="block mt-1 w-full border-orange-300 focus:border-orange-500 focus:ring-orange-500"
                          type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-orange-300 text-orange-600 shadow-sm focus:ring-orange-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-orange-500 hover:text-orange-700 transition duration-150 ease-in-out" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif

            <x-primary-button class="bg-orange-600 hover:bg-orange-700 focus:ring-orange-500">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-6">
            <span class="text-sm text-gray-500">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="text-orange-600 hover:underline font-semibold">Daftar Sekarang</a>
        </div>
    </form>
</x-guest-layout>
