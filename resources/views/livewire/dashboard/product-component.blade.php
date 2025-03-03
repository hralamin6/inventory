<div class=" rounded-xl mt-4" x-data="{openTable: $persist(true), modal: false, editMode: false, selectedField: $persist(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']),
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
            <x-input wire:model.debounce.1000ms="itemPerPage" type="number"/>
        </div>
        <div class="w-96">
            <x-input placeholder="search" wire:model.debounce="search" type="search"/>
        </div>
        <div class="w-96">
            <x-input x-model="selectedField" />
        </div>
        <div class="w-36">
            <x-select wire:model="searchBy" >
                @foreach(\Illuminate\Support\Facades\Schema::getColumnListing('products') as $i=> $col)
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
            <center><a href="javascript:void(0);" onclick="printPageArea('printableArea')">print</a></center>

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
                <div  x-cloak x-show="rows.length > 0 " class="flex items-center justify-center" x-data="{bulk: false}">
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
                    <table class="w-full font-myfont whitespace-no-wrap">
                        <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-300 dark:bg-darkSidebar"
                        >
                            <th class="px-4 py-3">
                                <input class="ring-0 dark:bg-gray-400" x-model="selectPage" type="checkbox" value="" name="todo2" id="todoCheck2">
                            </th>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'id'">@lang('sl')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'name'">@lang('name')</x-field>
                            <x-field>@lang('image')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'category_id'">@lang('category')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'brand_id'">@lang('brand')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'quantity'">@lang('quantity')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'buying_unit_id'">@lang('buying')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'selling_unit_id'">@lang('selling')</x-field>
                            <x-field :OB="$orderBy" :OD="$orderDirection" :field="'unit_relation'">@lang('relation')</x-field>
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
                                <td class="px-4 py-3 text-sm flex gap-1 overflow-x-scroll">
                                            @foreach($item->getMedia() as $k => $media)
                                                <div class="border dark:border-gray-600 text-center">
                                                    <img style="height: 44px; width: 55px;" src="{{$media->getAvailableUrl(['thumb'])}}" onerror="this.onerror=null;this.src='https://picsum.photos/id/10/600/300';">
                                                    <button class="text-pink-500" wire:click.prevent="deleteMedia({{$item}}, {{$k}})"><x-h-o-x-mark class="w-5"/></button>
                                                </div>
                                            @endforeach
                                </td>
                                <td class="px-4 py-3 text-sm">{{ $item->category->name }} </td>
                                <td class="px-4 py-3 text-sm">{{ $item->brand->name }} </td>
                                <td class="px-4 py-3 text-sm">{{ $item->quantity }} </td>
                                <td class="px-4 py-3 text-sm">{{ $item->buyingUnit->name }} </td>
                                <td class="px-4 py-3 text-sm">{{ $item->sellingUnit->name }} </td>
                                <td class="px-4 py-3 text-sm">{{ $item->unit_relation }} </td>
                                <td class="px-4 py-3 text-xs">
                                    <button class="uppercase px-2 py-1 font-semibold leading-tight {{$item->status==='active'?'text-green-700 bg-green-100':'text-red-700 bg-red-100'}}  rounded-full " wire:click.prevent="changeStatus({{ $item->id }})">{{ $item->status }}
                                        <span wire:loading wire:target="changeStatus({{ $item->id }})" class="animate-spin rounded-full h-4 w-4 border-2 border-black"></span></button>
                                </td>

                                <td class="px-4 py-3 text-sm">{{ $item->created_at }} </td>
                                <td class="px-4 py-3 text-sm flex space-x-4">
                                    <x-h-o-pencil-square wire:target="loadData({{$item->id}})" wire:loading.class="animate-spin" @click.prevent="editModal({{$item->id}})" class="w-5 text-purple-600 cursor-pointer"/>
                                    @if($item->invoiceDetails->has(0) || $item->purchaseDetails->has(0))
                                    @else
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
                    {{ $items->links() }}
                </div>
            </div>
        </div>

    </aside>

    <div x-cloak x-show="modal">
        <div class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
        <div  class="inset-0 py-4 rounded-2xl transition duration-150 ease-in-out z-50 absolute" id="modal">
            <div @click.outside="" class="container mx-auto w-11/12 md:w-2/3 max-w-lg ">
                <form @submit.prevent="editMode? $wire.editData(): $wire.saveData()" class="relative py-3 px-5 md:px-10 bg-white dark:bg-darkSidebar shadow-md rounded border border-gray-400 dark:border-gray-600 capitalize">
                    <h1 x-cloak x-show="!editMode" class="text-gray-800 dark:text-gray-200 font-lg font-semibold text-center mb-4">@lang('add new data')</h1>
                    <h1 x-cloak x-show="editMode" class="text-gray-800 dark:text-gray-200 font-lg font-semibold text-center mb-4">@lang('edit this data')</h1>

                    <div class="grid grid-cols-2 gap-2 mt-4">
                        <div>
                            <label class="text-gray-700 dark:text-gray-200" for="input">@lang('name')</label>
                            <input x-ref="input" id="input" wire:model.lazy="name" type="text" class="input">
                            @error('name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-gray-700 dark:text-gray-200" for="input">@lang('overview')</label>
                            <input wire:model.lazy="overview" type="text" class="input">
                            @error('overview')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="col-span-2 overflow-scroll">
                            <label class="text-gray-700 dark:text-gray-200" for="input">@lang('description')</label>
                            <span wire:ignore>
                                <trix-editor class="formatted-content" x-data x-on:trix-change="$dispatch('input', event.target.value)" wire:model.debounce.1000ms="description" wire:key="description"></trix-editor>
                            </span>
                            @error('description')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-gray-700 dark:text-gray-200" for="input">@lang('quantity')</label>
                            <input wire:model.lazy="quantity" type="number" class="input">
                            @error('quantity')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-gray-700 dark:text-gray-200" for="input">@lang('regular price')</label>
                            <input wire:model.lazy="regular_price" type="number" class="input">
                            @error('regular_price')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-gray-700 dark:text-gray-200" for="input">@lang('actual price')</label>
                            <input wire:model.lazy="actual_price" type="number" class="input">
                            @error('actual_price')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-gray-700 dark:text-gray-200" for="input">@lang('unit relation')</label>
                            <input wire:model.lazy="unit_relation" type="number" class="input">
                            @error('unit_relation')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-gray-700 dark:text-gray-200" for="category_id">@lang('category')</label>
                            <select id="category_id" class="input" wire:model.lazy="category_id" >
                                <option value="">@lang('select cagtegory')</option>
                            @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-gray-700 dark:text-gray-200" for="brand_id">@lang('brand')</label>
                            <select class="input" id="brand_id" wire:model.lazy="brand_id" >
                                <option value="">@lang('select brand')</option>
                            @foreach($brands as $brand)
                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                            @error('brand_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-gray-700 dark:text-gray-200" for="buying_unit_id">@lang('buying unit')</label>
                            <select class="input" id="buying_unit_id" wire:model.lazy="buying_unit_id" >
                                <option value="">@lang('select buying unit')</option>
                            @foreach($units as $unit)
                                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                                @endforeach
                            </select>
                            @error('buying_unit_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-gray-700 dark:text-gray-200" for="selling_unit_id">@lang('selling unit')</label>
                            <select class="input" id="selling_unit_id" wire:model.lazy="selling_unit_id" >
                                <option value="">@lang('select selling unit')</option>
                            @foreach($units as $unit)
                                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                                @endforeach
                            </select>
                            @error('selling_unit_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-gray-700 dark:text-gray-200" for="type">@lang('status')</label>
                            <select class="input" id="status" wire:model.lazy="status" >
                                <option value="">@lang('select status')</option>
                                <option value="active">@lang('active')</option>
                                <option value="inactive">@lang('inactive')</option>
                            </select>
                            @error('status')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                            <div>
                                <label class="text-gray-700 dark:text-gray-200" for="attribute_id">@lang('attribute')</label>
                                <select class="input" id="attribute_id" wire:model.lazy="attribute_id" >
                                    <option value="">@lang('select attribute')</option>
                                    @foreach($attributes as $attribute)
                                        <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                                    @endforeach
                                </select>
                                @error('attribute_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        @foreach($inputs as $key=> $input)

                                    <div id="{{$key}}">
                                        <label class="text-gray-700 dark:text-gray-200" for="input">{{\App\Models\Attribute::find($inputs[$key]['attribute_id'])->name}}</label>
                                        <div class="flex gap-2">
                                            <input wire:model.lazy="inputs.{{ $key }}.value" type="text" class="input">
                                            <button wire:click="remove({{$key}})" class="p-2 bg-red-600 h-8 mt-3 rounded text-white"><x-h-o-x-mark class="w-5"/></button>
                                        </div>
                                        @error('inputs.'.$key.'.value')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>
                        @endforeach
                            <div class=""  x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <label class="text-gray-700 dark:text-gray-200">@lang('choose image')</label>
                                <input type="file" class="input" wire:model.lazy="image">
                                <div class="col-md-4 list-inline-item" x-show="isUploading"><progress max="100" x-bind:value="progress"></progress></div>
                                @error('image')<span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>@enderror
                            </div>
                        <div>
                            <label class="text-gray-700 dark:text-gray-200" for="input">@lang('image link')</label>
                            <input wire:model.lazy="image_link" type="url" class="input">
                            @error('image_link')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                    </div>
                    <div class="flex gap-4">
                        @if($product!=null)
                            @foreach($product->getMedia() as $k => $media)
                                <div><img style="height: 55px; width: 66px;" src="{{$media->getAvailableUrl(['thumb'])}}" onerror="this.onerror=null;this.src='https://picsum.photos/id/10/600/300';"></div>
                            @endforeach
                        @endif
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
@push('js')
    <script>
        function printPageArea(areaID){
            var printContent = document.getElementById(areaID);
            var WinPrint = window.open('', '', 'scrollbars=yes, width=900,height=650');
            WinPrint.document.write(printContent.innerHTML);
            WinPrint.document.close();
            WinPrint.focus();
            WinPrint.onload = WinPrint.print;
        }
    </script>
@endpush
