<?php

use App\Livewire\Actions\Logout;

$logout = function (Logout $logout) {
    $logout();

    $this->redirect('/login', navigate: true);
};

?>

<nav x-data="{ open: false }" class="bg-brand-500 border-b border-brand-600 relative z-50 shadow-lg shadow-brand-900/20">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center space-x-3">
                        <img src="{{ asset('assets/media/logos/cbd-logo.jpeg') }}" alt="Logo" class="h-9 w-9 rounded-lg shadow-md object-contain bg-white/90 p-0.5">
                        <span class="text-white font-bold text-lg tracking-tight hidden sm:inline-block">NVR Monitoring</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-8 sm:flex">
                    <a href="{{ route('dashboard') }}" wire:navigate
                       class="inline-flex items-center px-4 pt-1 text-sm font-semibold leading-5 transition duration-200 ease-in-out border-b-2
                              {{ request()->routeIs('dashboard') 
                                 ? 'border-white text-white' 
                                 : 'border-transparent text-blue-100/70 hover:text-white hover:border-blue-200/50' }}">
                        <svg class="w-4 h-4 mr-1.5 -ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                        {{ __('Dashboard') }}
                    </a>

                    @if(auth()->user() && auth()->user()->role === 'admin')
                        <a href="{{ route('cms.users.index') }}" wire:navigate
                           class="inline-flex items-center px-4 pt-1 text-sm font-semibold leading-5 transition duration-200 ease-in-out border-b-2
                                  {{ request()->routeIs('cms.users.*') 
                                     ? 'border-white text-white' 
                                     : 'border-transparent text-blue-100/70 hover:text-white hover:border-blue-200/50' }}">
                            <svg class="w-4 h-4 mr-1.5 -ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            {{ __('CMS Pengguna') }}
                        </a>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-white/20 text-sm leading-4 font-semibold rounded-lg text-white bg-white/10 hover:bg-white/20 focus:outline-none transition ease-in-out duration-200 backdrop-blur-sm">
                            <div class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center mr-2 text-xs font-black text-white">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-white/70" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white/80 hover:text-white hover:bg-white/10 focus:outline-none focus:bg-white/10 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-brand-600/95 backdrop-blur-sm border-t border-brand-400/30">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" wire:navigate
               class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out
                      {{ request()->routeIs('dashboard') 
                         ? 'border-white text-white bg-white/10' 
                         : 'border-transparent text-blue-100/70 hover:text-white hover:bg-white/5 hover:border-white/40' }}">
                {{ __('Dashboard') }}
            </a>

            @if(auth()->user() && auth()->user()->role === 'admin')
                <a href="{{ route('cms.users.index') }}" wire:navigate
                   class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out
                          {{ request()->routeIs('cms.users.*') 
                             ? 'border-white text-white bg-white/10' 
                             : 'border-transparent text-blue-100/70 hover:text-white hover:bg-white/5 hover:border-white/40' }}">
                    {{ __('CMS Pengguna') }}
                </a>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-brand-400/30">
            <div class="px-4">
                <div class="font-semibold text-base text-white" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-blue-200/60">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile') }}" wire:navigate class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-blue-100/70 hover:text-white hover:bg-white/5 hover:border-white/40 transition duration-150 ease-in-out">
                    {{ __('Profile') }}
                </a>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <span class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-blue-100/70 hover:text-white hover:bg-white/5 hover:border-white/40 transition duration-150 ease-in-out">
                        {{ __('Log Out') }}
                    </span>
                </button>
            </div>
        </div>
    </div>
</nav>
