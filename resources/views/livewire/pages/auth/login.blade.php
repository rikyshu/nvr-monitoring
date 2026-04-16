<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');

form(LoginForm::class);

$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();

    $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
};

?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-xl font-bold text-brand-800 mb-1 text-center">Masuk ke Akun Anda</h2>
    <p class="text-sm text-gray-500 mb-6 text-center">Silakan masukkan kredensial Anda</p>

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-brand-700 font-semibold" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full !border-brand-200 !focus:border-brand-500 !focus:ring-brand-500" type="email" name="email" required autofocus autocomplete="username" placeholder="email@contoh.com" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-brand-700 font-semibold" />

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full !border-brand-200 !focus:border-brand-500 !focus:ring-brand-500"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-brand-300 text-brand-600 shadow-sm focus:ring-brand-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-brand-500 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-wider hover:bg-brand-600 focus:bg-brand-700 active:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-200 shadow-lg shadow-brand-500/30">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                {{ __('Masuk') }}
            </button>
        </div>

        @if (Route::has('password.request'))
            <div class="text-center mt-4">
                <a class="text-sm text-brand-500 hover:text-brand-700 font-medium transition-colors" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Lupa Password?') }}
                </a>
            </div>
        @endif
    </form>
</div>
