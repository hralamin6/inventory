@props(['route' => 'admin.home'])
<a {{ $attributes }} href="{{route($route)}}" class="m-2 px-3 py-2 flex justify-start rounded-md gap-2 hover:bg-gray-200 hover:text-gray-700 dark:hover:bg-gray-600 dark:hover:text-gray-100 {{Route::is($route)?'bg-purple-500 text-white':'text-gray-700 dark:text-gray-200'}}">
    {{ @$icon }}<span class="">{{ $slot }}</span>
</a>
