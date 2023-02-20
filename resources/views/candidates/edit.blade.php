<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Candidate in ').$position->name.' position' }}
        </h2>
    </x-slot>

    <section class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Edit Candidate') }}
                    </h2>
            
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Edit candidate that can be elected in UM ISA.') }}
                    </p>
                </header>
            
                <form method="post" action="{{ route('positions.candidates.update', [$position, $candidate]) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
            
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" autocomplete="name" :value="old('name', $candidate->name)" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div x-data="{photoName: null, deletion: false, cropping: null}">
                        <!-- Profile Photo File Input -->
                        <input type="file"
                            class="hidden"
                            x-ref="crops"
                            name="photo"
                            x-on:change="
                                photoName = $refs.crops.files[0].name;
                                done = url => {
                                    document.getElementById('cropper').src = url
                                    cropping = url;
                                }
                                if (URL) done(URL.createObjectURL($refs.crops.files[0]));
                                else if (FileReader) {
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        done(reader.result);
                                    };
                                    reader.readAsDataURL($refs.crops.files[0]);
                                }
                            " />
        
                        <x-input-label for="crops" :value="__('Candidate Photo')" />
        
                        <!-- Current Profile Photo & Cropper -->
                        <div class="mt-2" x-show="! cropping && ! deletion">
                            <img src="{{ $candidate->photo }}" alt="{{ $candidate->name }}"  class="block object-cover object-center w-full h-32 rounded-xl">
                        </div>
                        <div class="mt-2" x-show="cropping">
                            <img id="cropper" src="" alt="" style="display: block; max-width: 100%;">
                        </div>
        
                        <x-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.crops.click()">
                            {{ __('Select New Photo') }}
                        </x-secondary-button>
        
                        @if ($candidate->candidate_photo_path)
                            <x-text-input id="deletion" name="deletion" type="hidden" x-model="deletion" />

                            <x-secondary-button type="button" class="mt-2" @click="deletion = !deletion" x-show="! cropping">
                                <span x-text="deletion ? 'Undo Deletion' : 'Delete Photo'"></span>
                            </x-secondary-button>
                            <x-input-error :messages="$errors->get('deletion')" class="mt-2" />
                        @endif
        
                        <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                    </div>
            
                    <div class="flex items-center justify-end gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
            
                        @if (session('status') === 'position-stored')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400"
                            >{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>

            </div>
        </div>
    </section>
</x-app-layout>

