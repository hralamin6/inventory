<nav x-cloak @click.outside="nav = false" class="md:block shadow-2xl bg-white overflow-y-hidden overflow-x-hidden inset-y-0 z-10 fixed md:relative flex-shrink-0 w-64 overflow-y-auto bg-white dark:bg-darkSidebar"
     :class="{'hidden': nav == false}">
    <div class="h-14 border-b dark:border-gray-600 flex px-4 py-2 gap-3">
        <span class="w-10 h-10 rounded-full bg-purple-600 border dark:border-gray-600 shadow-xl"></span>
        <span class="my-auto text-xl text-gray-500 font-mono dark:text-gray-300">Adminlte</span>
    </div>
    <div class="h-screen  overflow-y-auto scrollbar-none">
        <div class="h-16 border-b dark:border-gray-600 flex px-4 py-2 gap-3">
            <span class="w-10 h-10 rounded-full bg-indigo-600 border dark:border-gray-600 shadow-xl"></span>
            <span class="my-auto text-sm text-gray-600 font-medium dark:text-gray-300">Alexander Pairace</span>
        </div>
        <div class="m-2 mt-4 flex">
            <input type="search"  class="border dark:border-gray-500 dark:bg-gray-600 dark:placeholder-gray-300 text-gray-200 text-sm border-gray-300 bg-gray-100 px-2 w-48 h-9 rounded-md rounded-r-none" placeholder="Search">
            <a href="" class="border  dark:bg-gray-600 border-gray-300 dark:border-gray-500 bg-gray-100 rounded-l-none p-2 h-9 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 text-gray-600 dark:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </a>
        </div>
            <div class="capitalize">

                <a href="{{route('dashboard')}}" class="navMenuLink {{Route::is('dashboard')?'navActive':'navInactive'}}">
                    <x-h-o-home class="w-6"/><span class="">dashboard</span>
                </a>
                <a href="{{route('users')}}" class="navMenuLink {{Route::is('users')?'navActive':'navInactive'}}">
                    <x-h-o-users class="w-6"/><span class="">users</span>
                </a>
                <a href="{{route('categories')}}" class="navMenuLink {{Route::is('categories')?'navActive':'navInactive'}}">
                    <x-h-o-banknotes class="w-6"/><span class="">categories</span>
                </a>
                <a href="{{route('brands')}}" class="navMenuLink {{Route::is('brands')?'navActive':'navInactive'}}">
                    <x-h-o-speaker-wave class="w-6"/><span class="">brands</span>
                </a>
                @can('isAdmin')
                    <a href="{{route('units')}}" class="navMenuLink {{Route::is('units')?'navActive':'navInactive'}}">
                        <x-h-o-funnel class="w-6"/><span class="">units</span>
                    </a>
                    <a href="{{route('products')}}" class="navMenuLink {{Route::is('products')?'navActive':'navInactive'}}">
                        <x-h-o-printer class="w-6"/><span class="">products</span>
                    </a>
                    <a href="{{route('purchases')}}" class="navMenuLink {{Route::is('purchases')?'navActive':'navInactive'}}">
                        <x-h-o-shopping-cart class="w-6"/><span class="">purchases</span>
                    </a>
                @endcan
{{--                <a href="{{route('units')}}" class="navMenuLink {{Route::is('units')?'navActive':'navInactive'}}">--}}
{{--                    <x-h-o-funnel class="w-6"/><span class="">units</span>--}}
{{--                </a>--}}

                <div  x-data="{setup: false}">
                    <div @click="setup= !setup"  class="navMenuLink dark:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="">setup</span>
                        <svg x-show="!setup" class="w-4 ml-auto" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <svg x-show="setup" class="w-4 ml-auto" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    {{--                <div x-show="setup" class="text-sm" x-collapse>--}}
                    {{--                    <a href="{{route('admin.setup.label')}}" class="subNavMenuLink {{Route::is('admin.setup.label')?'subNavActive':'subNavInactive'}}">--}}
                    {{--                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
                    {{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />--}}
                    {{--                        </svg>--}}
                    {{--                        <span class="">class</span>--}}
                    {{--                    </a>--}}
                    {{--                    <a href="{{route('admin.setup.group')}}" class="subNavMenuLink {{Route::is('admin.setup.group')?'subNavActive':'subNavInactive'}}">--}}
                    {{--                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
                    {{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />--}}
                    {{--                        </svg>--}}
                    {{--                        <span class="">group</span>--}}
                    {{--                    </a>--}}
                    {{--                </div>--}}
                </div>

            </div>
    </div>

</nav>
