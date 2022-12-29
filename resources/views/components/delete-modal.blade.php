@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="bg-white justify-center rounded shadow-lg border flex flex-col overflow-hidden px-3 py-3">
        <div class="text-center py-3 text-2xl text-gray-700">Are you sure ?</div>
           <p class="text-center pb-3" >
              {{$title}}
           </p>
        <div class="flex justify-center">
           {{$button}}
        </div>
    </div>

</x-modal>
