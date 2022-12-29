@props(['route' => 'home'])
<a {{ $attributes }} href="{{route($route)}}" class=" px-2 pb-1 rounded-md capitalize
{{Route::is($route.'*')?'bg-purple-600 text-white':'text-gray-700 dark:text-gray-200'}}">
    {{ @$icon }}<span class="">{{ $slot }}</span>
</a>
