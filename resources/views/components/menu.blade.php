@props(['route' => 'home'])
<a {{ $attributes }} href="{{route($route)}}" class="m-2 px-3 py-2 flex justify-start rounded-md gap-2 hover:bg-purple-600 hover:text-white
{{Route::is($route.'*')?'bg-purple-600 text-white':'text-gray-700 dark:text-gray-200'}}">
    {{ @$icon }}<span class="">{{ $slot }}</span>
</a>
