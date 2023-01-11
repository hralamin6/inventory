<div class=" rounded-xl mt-4" x-data="{openTable: $persist(true), modal: false, editMode: false,
addModal() { this.modal = true; this.editMode = false; $nextTick(() => $refs.input.focus()); },
editModal(id) { $wire.loadData(id); this.modal = true; this.editMode = true; $nextTick(() => $refs.input.focus()); },
closeModal() { this.modal = false; this.editMode = false; $wire.resetData()},
}"
     x-init="
     $wire.on('dataAdded', (e) => {
            modal = false; editMode = false;
            element = document.getElementById(e.dataId)
            console.log(element)
            element.scrollIntoView({behavior: 'smooth'})
            element.classList.add('bg-green-50')
            element.classList.add('dark:bg-gray-500')
            element.classList.add('animate-pulse')
            setTimeout(() => {
            element.classList.remove('bg-green-50')
            element.classList.remove('dark:bg-gray-500')
            element.classList.remove('animate-pulse')
            }, 5000)
            })
        "
     @open-delete-modal.window="
     model = event.detail.model
     eventName = event.detail.eventName
Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.icon,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',

            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit(eventName, model )
                }
            })
"
>
    <div class="grid grid-cols-3 gap-2 mt-4 justify-center">
        <div class="w-24">
            <input wire:model.debounce.1000ms="itemPerPage" type="number" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
        </div>
        <div class="w-96">
            <x-input placeholder="search" wire:model.debounce="search" type="search"/>
        </div>
        <div class="w-36">
            <x-select wire:model="searchBy" >
                @foreach(\Illuminate\Support\Facades\Schema::getColumnListing('categories') as $i=> $col)
                    @if($col!='created_at' && $col!='updated_at')
                        <option value="{{$col}}">{{$col}}</option>
                    @endif
                @endforeach
            </x-select>
        </div>

    </div>
    <aside class="border dark:border-gray-600 row-span-4 bg-white dark:bg-darkSidebar" x-data="{rows: @entangle('selectedRows').defer, selectPage: @entangle('selectPageRows')}">
        <div class="flex justify-between gap-3 bg-white border dark:border-gray-600 dark:bg-darkSidebar px-4 py-2">
            <p class="text-gray-600 dark:text-gray-200">Products Table</p>
            {{--            <a class="text-blue-500" href="{{route('admin.quiz')}}">all quiz</a>--}}
            <div class="flex justify-center capitalize gap-4 text-gray-500 dark:text-gray-300 capitalize">
                <button @click.prevent="addModal" class="flex gap-1 text-white capitalize hover:bg-blue-700 p-2 font-semibold text-sm bg-blue-500 rounded">
                    <x-h-o-plus-circle class="w-5"/>
                    @lang('add new')</button>
                <button class="" @click="openTable = !openTable">
                    <svg x-show="openTable" xmlns="http://www.w3.org/2000/svg" class="h-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                    <svg x-show="!openTable" xmlns="http://www.w3.org/2000/svg" class="h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
                <div x-cloak x-show="rows.length > 0 " class="flex items-center justify-center" x-data="{bulk: false}">
                    <div class="relative inline-block">
                        <!-- Dropdown toggle button -->
                        <button @click="bulk=!bulk" class="relative z-10 block px-2 text-gray-700 border border-transparent rounded-md dark:text-white focus:border-blue-500 focus:ring-opacity-40 dark:focus:ring-opacity-40 focus:ring-blue-300 dark:focus:ring-blue-400 focus:ring focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800 dark:text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div x-show="bulk" class="absolute right-0 z-20 w-48 py-2 mt-2 bg-white rounded-md shadow-xl dark:bg-gray-800" @click.outside="bulk= false">
                            <a @click="$dispatch('open-delete-modal', { title: 'Hello World!', text: 'you cant revert', icon: 'error', eventName: 'deleteMultiple', model: '' })" class="cursor-pointer block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                Delete </a>
                            <a wire:click.prevent="" class="cursor-pointer block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                                Your projects </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div x-cloak x-show="openTable" x-collapse>
            <div class="mb-1 overflow-y-scroll scrollbar-none">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-300 dark:bg-darkSidebar"
                        >
                            <th class="px-4 py-3">
                                <input class="ring-0 dark:bg-gray-400" x-model="selectPage" type="checkbox" value="" name="todo2" id="todoCheck2">
                            </th>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'id'">@lang('sl')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'name'">@lang('name')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'status'">@lang('status')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'created_at'">@lang('date')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'action'">@lang('action')</x-field>
                        </tr>
                        </thead>
                        <tbody
                            class="bg-white divide-y dark:divide-gray-700 dark:bg-darkSidebar"
                        >
                        @forelse($items as $i => $item)
                            <tr id="item-id-{{$item->id}}" class="text-gray-700 dark:text-gray-300 capitalize" :class="{'bg-gray-200 dark:bg-gray-600': rows.includes('{{$item->id}}') }">
                                <td class="px-4 py-3">
                                    <input x-model="rows" class="ring-none dark:bg-gray-400" type="checkbox" value="{{ $item->id }}" name="todo2" id="{{ $item->id }}">
                                </td>
                                <td class="px-4 py-3">{{$items->firstItem() + $i}}</td>
                                <td class="px-4 py-3 text-sm">{{ $item->name }} </td>
                                <td class="px-4 py-3 text-xs">
                                <span wire:click.prevent="changeStatus({{$item->id}})" class="text-white cursor-pointer px-2 py-1 font-semibold rounded-lg {{ $item->status=='active'? 'bg-green-300 dark:bg-green-700': 'bg-red-300 dark:bg-red-700' }} ">
                                    {{ $item->status }}
                                    <x-loader  wire:target="changeStatus({{$item->id}})"/>
                                </span></td>
                                <td class="px-4 py-3 text-sm">{{ $item->created_at }} </td>
                                <td class="px-4 py-3 text-sm flex space-x-4">
                                    <x-h-o-pencil-square wire:target="loadData({{$item->id}})" wire:loading.class="animate-spin" @click.prevent="editModal({{$item->id}})" class="w-5 text-purple-600 cursor-pointer"/>
                                    @if(!$item->products->has(0))
                                    <x-h-o-trash @click.prevent="$dispatch('open-delete-modal', { title: 'Hello World!', text: 'you cant revert', icon: 'error', eventName: 'deleteSingle', model: {{$item->id}} })" class="w-5 text-pink-500 cursor-pointer"/>
                                    @endif
                                </td>
                            </tr>
                        @empty

                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mx-auto my-4 px-4">
                    {{--                    {{ $items->links('vendor.pagination.default') }}--}}
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </aside>

    <div x-cloak x-show="modal">
        <div class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
        <div  class="inset-0 py-4 rounded-2xl transition duration-150 ease-in-out z-50 absolute" id="modal">
            <div @click.outside="closeModal" class="container mx-auto w-11/12 md:w-2/3 max-w-lg ">
                <form @submit.prevent="editMode? $wire.editData(): $wire.saveData()" class="relative py-3 px-5 md:px-10 bg-white dark:bg-darkSidebar shadow-md rounded border border-gray-400 dark:border-gray-600 capitalize">
                    <h1 x-cloak x-show="!editMode" class="text-gray-800 dark:text-gray-200 font-lg font-semibold text-center mb-4">@lang('add new data')</h1>
                    <h1 x-cloak x-show="editMode" class="text-gray-800 dark:text-gray-200 font-lg font-semibold text-center mb-4">@lang('edit this data')</h1>

                    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                        <div>
                            <label class="text-gray-700 dark:text-gray-200" for="input">@lang('name')</label>
                            <input x-ref="input" id="input" wire:model.lazy="name" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                            @error('name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-gray-700 dark:text-gray-200" for="type">@lang('status')</label>
                            <x-select id="status" wire:model.lazy="status" >
                                <option value="active">@lang('active')</option>
                                <option value="inactive">@lang('inactive')</option>
                            </x-select>
                            @error('status')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="flex items-center justify-between w-full mt-4">
                        <button type="button" @click="closeModal" class="bg-red-600 focus:ring-gray-400 transition duration-150 text-white ease-in-out hover:bg-red-300 rounded px-8 py-2 text-sm">Cancel</button>
                        <button type="submit" class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 bg-indigo-700 rounded text-white px-8 py-2 text-sm">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

