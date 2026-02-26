<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">

@auth
    <flux:sidebar sticky collapsible="mobile"
        class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">

        <flux:sidebar.header>
            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.group :heading="__('Platform')" class="grid">
                <flux:sidebar.item icon="home"
                    :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')"
                    wire:navigate>
                    {{ __('Dashboard') }}
                </flux:sidebar.item>
            </flux:sidebar.group>
        </flux:sidebar.nav>

        <flux:spacer />

        <flux:sidebar.nav>
            <flux:sidebar.item icon="folder-git-2"
                href="https://github.com/laravel/livewire-starter-kit"
                target="_blank">
                Repository
            </flux:sidebar.item>

            <flux:sidebar.item icon="book-open-text"
                href="https://laravel.com/docs/starter-kits#livewire"
                target="_blank">
                Documentation
            </flux:sidebar.item>
        </flux:sidebar.nav>

        {{-- Desktop user menu --}}
        <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />

    </flux:sidebar>

    {{-- Mobile Header --}}
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle icon="bars-2" inset="left" />
        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile
                :initials="auth()->user()->initials()"
                icon-trailing="chevron-down"
            />

            <flux:menu>
                <div class="flex items-center gap-2 px-2 py-2">
                    <flux:avatar
                        :name="auth()->user()->name"
                        :initials="auth()->user()->initials()"
                    />
                    <div>
                        <flux:heading>{{ auth()->user()->name }}</flux:heading>
                        <flux:text>{{ auth()->user()->email }}</flux:text>
                    </div>
                </div>

                <flux:menu.separator />

                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                    Settings
                </flux:menu.item>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle">
                        Log Out
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>
@endauth

{{-- PUBLIC CONTENT --}}
{{ $slot }}

@fluxScripts
</body>
</html>