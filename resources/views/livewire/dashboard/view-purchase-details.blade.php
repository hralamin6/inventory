<div x-cloak x-show="viewProduct">
    <div class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
    <div  class="inset-0 py-4 rounded-xl transition duration-150 ease-in-out z-50 absolute" id="modal">
        <div  @click.outside="closeModal" class="container mx-auto ">
            <form @submit.prevent="editMode? $wire.editData(): $wire.saveData()" class="relative py-3 px-5 md:px-10 bg-white dark:bg-darkSidebar shadow-md rounded border border-gray-400 dark:border-gray-600 capitalize">
                <h1 x-cloak x-show="!editMode" class="text-gray-800 dark:text-gray-200 font-lg font-semibold text-center mb-4">@lang('supplier invoice')</h1>
                <div class="flex flex-2 lg:flex-5 justify-between gap-2 capitalize pb-4 border-b-4 gr">
                    <div>
                        <span class="font-semibold">purchase no:</span>
                        <span class="text-gray-700">#{{@$purchase->purchase_no}}</span>
                    </div>
                    <div>
                        <span class="font-semibold">date:</span>
                        <span class="text-gray-700">#{{@$purchase->date}}</span>
                    </div>
                    <div>
                        <span class="font-semibold">name:</span>
                        <span class="text-gray-700">{{@$purchase->supplier->name}}</span>
                    </div>
                    <div>
                        <span class="font-semibold">phone:</span>
                        <span class="text-gray-700">{{@$purchase->supplier->phone}}</span>
                    </div>
                    <div>
                        <span class="font-semibold">address:</span>
                        <span class="text-gray-700 text-sm">{{@$purchase->supplier->address}}</span>
                    </div>

                </div>


                <div class="w-full overflow-x-auto mt-8">
                    <table  class="w-full text-center border-collapse border border-slate-500 whitespace-no-wrap">
                        <thead>
                        <tr
                            class="text-xs text-center font-semibold dark:border-gray-700 bg-gray-50 dark:text-gray-300 dark:bg-darkSidebar"
                        >
                            <th class="font-semibold p-2 border border-purple-600">@lang('Sl')</th>
                            <th class="font-semibold p-2 border border-purple-600">@lang('product')</th>
                            <th class="font-semibold p-2 border border-purple-600">@lang('category')</th>
                            <th class="font-semibold p-2 border border-purple-600">@lang('quantity')</th>
                            <th class="font-semibold p-2 border border-purple-600">@lang('price')</th>
                            <th class="font-semibold p-2 border border-purple-600">@lang('total')</th>
                        </tr>
                        </thead>
                        <tbody
                            class="bg-white divide-y capitalize dark:divide-gray-700 dark:bg-darkSidebar"
                        >

                        @foreach($purchaseDetails as $key=> $item)

                            <tr id="item-id-{{$key}}" class="text-gray-700 dark:text-gray-300 capitalize">
                                <td class="p-1 border border-purple-600">
                                    {{$key+1}}
                                </td>
                                <td class="p-1 border border-purple-600">
                                    {{ $item->product->name }}
                                </td>
                                <td class="p-1 border border-purple-600">
                                    {{ $item->product->category->name }}
                                </td>
                                <td class="p-1 border border-purple-600">
                                    {{ $item->quantity }}
                                </td>
                                <td class="p-1 border border-purple-600">
                                    {{ $item->unit_price }}
                                </td>
                                <td class="p-1 border border-purple-600">
                                    {{$item->quantity*$item->unit_price}}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" class="p-1 border border-purple-600 text-gray-500 dark:text-gray-300 font-semibold text-sm">total:</td>
                            <td class="p-1 border border-purple-600">{{@$bill->discount_amount+@$bill->total_amount}}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="p-1 border border-purple-600 text-gray-500 dark:text-gray-300 font-semibold text-sm">discount:</td>
                            <td class="p-1 border border-purple-600">{{@$bill->discount_amount}}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="p-1 border border-purple-600 text-gray-500 dark:text-gray-300 font-semibold text-sm">grand total:</td>
                            <td class="p-1 border border-purple-600">{{@$bill->total_amount}}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="p-1 border border-purple-600 text-gray-500 dark:text-gray-300 font-semibold text-sm">paid amount:</td>
                            <td class="p-1 border border-purple-600">{{@$bill->paid_amount}}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="p-1 border border-purple-600 text-gray-500 dark:text-gray-300 font-semibold text-sm">due amount:</td>
                            <td class="p-1 border border-purple-600">{{@$bill->due_amount}}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="p-1 border border-purple-600 text-gray-700 dark:text-gray-100 font-bold">paid summary</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="p-1 border border-purple-600 text-gray-600 dark:text-gray-200 font-bold">date</td>
                            <td colspan="3" class="p-1 border border-purple-600 text-gray-600 dark:text-gray-200 font-bold">amount</td>
                        </tr>
                        @foreach($billDetails as $key=> $item)
                        <tr>
                            <td colspan="3" class="p-1 border border-purple-600 text-gray-500 dark:text-gray-300">
                                {{$item->date}}</td>
                            <td colspan="3" class="p-1 border border-purple-600 text-gray-500 dark:text-gray-300">
                                {{$item->current_paid_amount}}</td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="grid grid-cols-2 capitalize gap-4 mt-4 lg:grid-cols-4">
                        <div>
                            <label class="text-gray-700 dark:text-gray-200" for="paid_amount">@lang('paid amount')</label>
                            <x-input wire:model.debounce="paid_amount" type="number"/>
                            @error('paid_amount')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-gray-700 dark:text-gray-200" for="date">@lang('paid date')</label>
                            <x-input wire:model.debounce="date" type="date"/>
                            @error('date')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
{{--                        <div>--}}
{{--                            <button wire:click.prevent="PaidNew" class="flex gap-1 mt-8 text-white capitalize hover:bg-blue-700 p-2 font-semibold text-sm bg-blue-500 rounded">--}}
{{--                                <x-h-s-rectangle-group class="w-5"/>--}}
{{--                                @lang('submit')</button>--}}
{{--                        </div>--}}
                    </div>
                </div>

                <div class="flex items-center justify-between w-full mt-4">
                    <button type="button" @click="closeModal" class="bg-red-600 focus:ring-gray-400 transition duration-150 text-white ease-in-out hover:bg-red-300 rounded px-8 py-2 text-sm">Cancel</button>
                    <button wire:click.prevent="PaidNew" class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 bg-indigo-700 rounded text-white px-8 py-2 text-sm">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>
