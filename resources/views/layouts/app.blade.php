@extends('layouts.base')

@section('body')
    <div class="dark:bg-darkBg flex h-screen"
         :class="{ 'overflow-hidden': nav }"
    >
        <div x-cloak
             x-show="nav"
             x-transition:enter="transition ease-in-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in-out duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
        ></div>
        @include('layouts.sidebar')
        {{--        <livewire:sidebar-component />--}}
        <div class="flex flex-col flex-1 w-full">
            <livewire:header-component />
{{--            @include('layouts.header')--}}
            <main class="h-full overflow-y-auto dark:bg-darkBg">
                <div class="m-2">

                    @yield('content')

                    @isset($slot)
                        {{ $slot }}
                    @endisset
                </div>
            </main>
        </div>
    </div>


@endsection
