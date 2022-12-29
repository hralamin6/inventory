@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-2 py-2  dark:bg-darkSidebar dark:text-white">
        <div class="text-lg">
            {{ @$title }}
        </div>

        <div class="mt-4">
            {{ @$content }}
        </div>
    </div>

    <div class="px-2 py-2  dark:bg-darkSidebar dark:text-white">
        {{ @$footer }}
    </div>
</x-modal>
