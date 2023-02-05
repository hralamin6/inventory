<div>
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="max-w-6xl w-full mx-auto sm:px-6 lg:px-8 space-y-4 py-4">
            @if(!$isLoaded)
            <div class="w-full rounded-md bg-white border-2 border-gray-600 p-4 min-h-[60px] text-gray-600">
                <form wire:submit.prevent="generate" class="inline-flex gap-2 w-full">
                    @csrf
                    <input required wire:model.lazy="title" class="w-full outline-none font-bold" placeholder="make 3 multiple choice questions about Dhaka including options with answer" />
                    <button wire:target="generate" wire:loading.class="hidden" class="rounded-md bg-emerald-500 p-2 text-white font-semibold">Send</button>
                </form>
            </div>
            <div class="w-full rounded-md bg-white border-2 border-gray-600 p-4 min-h-[720px] h-full text-gray-600">
                <textarea wire:target="generate" wire:loading.class="bg-green-300 animate-pulse" class="min-h-[720px] h-full w-full outline-none" spellcheck="false">{{ $content }}</textarea>
            </div>
                <button wire:click.prevent="quizMake" class="rounded-md bg-emerald-500 px-4 py-2 text-white font-semibold">Quiz</button>
            @else
            <div class="flex flex-col items-center py-8" x-data="{ans:false, answer : @entangle('answer').defer}">
                <h1 class="text-4xl font-bold mb-4">Quiz</h1>
                <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-lg">
                    @if($isSubmitted)
                    <p class="text-lg mb-5">You scored: {{ $result }} / {{ count($parts) }}</p>
                    @endif
                    @foreach($parts as $i=>$part)
                        <div class="mb-4 p-2 border border-gray-300 @if($isSubmitted) {{trim(@$answer[$i])===preg_replace( "/\r\n|\r|\n/", "", trim($part['ans'] ))? 'bg-green-100':'bg-red-100'}} @endif">
                            <p class="text-lg font-bold">Question 1: {{$part['title']}}?</p>
                            <div class="flex flex-col mt-2">
                                <label class="block"><input x-model="answer[{{$i}}]" value="{{$part['a']}}" type="radio" class="mr-2 leading-tight">{{$part['a']}}</label>
                                <label class="block"><input x-model="answer[{{$i}}]" value="{{$part['b']}}" type="radio" class="mr-2 leading-tight">{{$part['b']}}</label>
                                <label class="block"><input x-model="answer[{{$i}}]" value="{{$part['c']}}" type="radio" class="mr-2 leading-tight">{{$part['c']}}</label>
                                <label class="block"><input x-model="answer[{{$i}}]" value="{{$part['d']}}" type="radio" class="mr-2 leading-tight">{{$part['d']}}</label>
                                <label x-cloak x-show='ans' class="block">Answer: <span class="font-extrabold text-green-700">{{$part['ans']}}</span></label>
                            </div>
                        </div>
                    @endforeach
                    <div class="text-center flex gap-3 justify-between">
                        <button @click="ans=true" wire:click.prevent="submit" class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600">Submit</button>
                        <button @click="ans=false" wire:click.prevent="tryAgain" class="bg-pink-500 text-white px-4 py-2 rounded-full hover:bg-blue-600">Try Again</button>
                    </div>
                </div>
            </div>
            @endif
        </div>


    </div>

</div>
