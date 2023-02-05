<div class="dark:bg-darkBg bg-white lg:mx-36" x-data="{ activeSlide: 1, slides: 1 }" x-init="window.setInterval(function(){
                 if(slides=={{$products->count()}}){
                 slides=1
                 }else{slides+=1}
                }, 5000)">
    <section class="bg-white dark:bg-darkSidebar my-2 border border-gray-300 dark:border-gray-600">
        <div class="container px-6 py-10 mx-auto">
            @foreach($products as $key=> $product)
            <div x-cloak x-show="slides=={{$key+1}}"  class="lg:-mx-6 lg:flex lg:items-center">
                <img class="object-cover object-center lg:w-1/2 lg:mx-6 w-full h-96 rounded-lg lg:h-[36rem]" src="{{$product->getFirstMediaURl('default', 'thumb')}}" onerror="this.onerror=null;this.src='https://picsum.photos/id/10/600/300';" alt="">

                <div class="mt-8 lg:w-1/2 lg:px-6 lg:mt-0">
                    <h1 class="text-3xl font-semibold text-gray-800 dark:text-white lg:text-4xl lg:w-96">{{$product->name}}</h1>

                    <p class="max-w-lg mt-6 text-gray-500 dark:text-gray-400 ">{{$product->overview}}</p>

                    <h3 class="mt-6 text-lg font-medium text-blue-500">Mia Brown</h3>
                    <p class="text-gray-600 dark:text-gray-300">Marketing Manager at Stech</p>

                    <div class="flex items-center justify-between mt-12 lg:justify-start">
                        <button  x-on:click="if(slides<{{$products->count()}})slides-=1" title="left arrow" class="p-2 text-gray-800 transition-colors duration-300 border rounded-full rtl:-scale-x-100 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <button  x-on:click="if(slides<{{$products->count()}})slides+=1" title="right arrow" class="p-2 text-gray-800 transition-colors duration-300 border rounded-full rtl:-scale-x-100 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800 lg:mx-6 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
                <div class="w-full flex items-center justify-center px-4">
                    @foreach($products as $key=> $product)
                        <button class="flex-1 w-4 h-2 mt-4 mx-2 mb-0 rounded-full overflow-hidden transition-colors duration-200 ease-out hover:bg-teal-600 hover:shadow-lg"
                                :class="{ 'bg-orange-600': slides == {{$key+1}},  'bg-teal-300': slides !== {{$key+1}}}" x-on:click="slides = {{$key+1}}">
                        </button>
                    @endforeach
                </div>
        </div>
    </section>
    <section class="bg-white dark:bg-darkSidebar border border-gray-300 dark:border-gray-600 my-2">
        <div class="container px-6 py-10 mx-auto">
            <h1 class="text-3xl font-semibold text-center text-gray-800 capitalize lg:text-4xl dark:text-white">Our Executive Team</h1>
            <div class="grid grid-cols-2 gap-2 lg:gap-8 mt-8 xl:mt-16 md:grid-cols-2 xl:grid-cols-4">
                @foreach($categories as $key=> $category)
                <div class="flex flex-col items-center p-8 transition-colors duration-300 transform border cursor-pointer rounded-xl hover:border-transparent group hover:bg-blue-600 dark:border-gray-700 dark:hover:border-transparent">
                    <img class="object-cover w-32 h-32 rounded-full ring-4 ring-gray-300" src="{{$category->getFirstMediaURl('default', 'thumb')}}" onerror="this.onerror=null;this.src='https://picsum.photos/id/10/600/300';" alt="">
                    <h1 class="mt-4 lg:text-xl  font-semibold text-gray-700 capitalize dark:text-white group-hover:text-white">
                        {{$category->name}}</h1>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <div class="container pb-16">
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">recomended for you</h2>
        <div class="grid grid-cols-4 gap-6">
            @foreach($items as $item)
                <div class="bg-white shadow rounded overflow-hidden group p-3 border dark:border-gray-500 rounded-2xl">
                    <div class="relative rounded-2xl bg-gray-200 overflow-hidden p-2">
                        <img class="h-48 w-48 mx-auto" src="{{$item->getFirstMediaURl('default', 'thumb')}}" onerror="this.onerror=null;this.src='https://picsum.photos/id/10/600/300';" alt="product 1" class="w-full">
                    </div>
                    <div class="pt-4 pb-3 px-4">
                        <a href="#">
                            <h4 class="uppercase font-medium text-xl mb-2 text-gray-800 hover:text-primary transition">{{$item->name}}</h4>
                        </a>
                        <div class="flex items-baseline mb-1 space-x-2">
                            <p class="text-xl text-primary font-semibold">$45.00</p>
                            <p class="text-sm text-gray-400 line-through">$55.90</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2  justify-between gap-2">
                        <div>
                            <a class="text-white w-9 h-8 rounded-full bg-primary  flex items-center justify-center hover:bg-gray-800 transition">
                                <i class="fa-solid fa-heart"></i>
                            </a>
                        </div>
                        <div>
                            <a class="text-white w-9 h-8 rounded-full bg-primary  flex items-center justify-center hover:bg-gray-800 transition">
                                <i class="fa-solid fa-heart"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

</div>
