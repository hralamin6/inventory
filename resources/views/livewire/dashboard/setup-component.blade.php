<dev class="border dark:border-gray-600 row-span-4 bg-white dark:bg-darkSidebar">
    <section class="p-4 mx-auto bg-white rounded-md shadow-md dark:bg-darkSidebar">
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">@lang('general information')</h2>
        <form>
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2 capitalize">
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="name">@lang('name')</label>
                    <input id="name" wire:model.lazy="name" type="text" class="input">
                    @error('name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="designation">@lang('designation')</label>
                    <input id="designation" wire:model.lazy="designation" type="text" class="input">
                    @error('designation')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="about">@lang('about')</label>
                    <input id="about" wire:model.lazy="about" type="text" class="input">
                    @error('about')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="location">@lang('location')</label>
                    <input id="location" wire:model.lazy="location" type="text" class="input">
                    @error('location')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="site_name">@lang('site name')</label>
                    <input id="site_name" wire:model.lazy="site_name" type="text" class="input">
                    @error('site_name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="site_url">@lang('site url')</label>
                    <input id="site_url" wire:model.lazy="site_url" type="text" class="input">
                    @error('site_url')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="phone">@lang('phone')</label>
                    <input id="phone" wire:model.lazy="phone" type="text" class="input">
                    @error('phone')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="phone_two">@lang('phone two')</label>
                    <input id="phone_two" wire:model.lazy="phone_two" type="text" class="input">
                    @error('phone_two')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="email">@lang('email')</label>
                    <input id="email" wire:model.lazy="email" type="email" class="input">
                    @error('email')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="email_two">@lang('email two')</label>
                    <input id="email_two" wire:model.lazy="email_two" type="email" class="input">
                    @error('email_two')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="date_of_birth">@lang('date of birth')</label>
                    <input id="date_of_birth" wire:model.lazy="date_of_birth" type="text" class="input">
                    @error('date_of_birth')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="facebook">@lang('facebook')</label>
                    <input id="facebook" wire:model.lazy="facebook" type="text" class="input">
                    @error('facebook')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="twitter">@lang('twitter')</label>
                    <input id="twitter" wire:model.lazy="twitter" type="text" class="input">
                    @error('twitter')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="youtube">@lang('youtube')</label>
                    <input id="youtube" wire:model.lazy="youtube" type="text" class="input">
                    @error('youtube')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="github">@lang('github')</label>
                    <input id="github" wire:model.lazy="github" type="text" class="input">
                    @error('github')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

            </div>
            <div class="flex justify-end mt-6">
                <button wire:click.prevent="updateSetup" class="btn">Save</button>
            </div>
        </form>
    </section>
    <section class="p-4 mx-auto bg-white rounded-md shadow-md dark:bg-darkSidebar">
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">@lang('general information')</h2>
        <form>
            <div class="grid grid-cols-3 gap-6 mt-4 sm:grid-cols-3 capitalize">
                <div class=""  x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <label class="text-gray-700 dark:text-gray-200" for="logo">@lang('choose logo')</label>
                    <input id="logo" type="file" class="input" wire:model.lazy="logo">
                    <div x-cloak x-show="isUploading"><progress max="100" x-bind:value="progress"></progress></div>
                    @error('logo')<span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>@enderror
                </div>
                <div class="mt-4">
                @if ($logo)<img class="w-16 h-16" src="{{ $logo->temporaryUrl() }}">
                    @else<img class="w-16 h-16" src="{{$setup->getFirstMediaUrl('default')}}" alt="logo">@endif
                </div>
                <div class="mt-8">
                <button wire:click.prevent="logoUpdate" type="button" class="btn">@lang('update')</button>
                </div>
            </div>

        </form>
    </section>
</dev>

