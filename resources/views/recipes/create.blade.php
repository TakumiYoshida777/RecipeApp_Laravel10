<x-app-layout>
    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js" defer></script>
        <script src="{{ asset('/js/recipe/create.js') }}" defer></script>
    </x-slot>
    <form action="{{ route('recipe.store') }}" method="POST" class="w-10/12 p-4 mx-auto bg-white rounded"
        enctype="multipart/form-data">
        @csrf
        {{ Breadcrumbs::render('create') }}
        <div class="grid grid-cols-2 rounded border border-gray-500 mt-4">
            <div class="col-span-1">
                <img id="preview" class="object-cover w-full aspect-video" src={{ asset('images/recipe-dummy.png') }}
                    alt="recipe-image">
                <input type="file" id="image-data" name="image"
                    class="border border-gray-300 p-2 mb-4 w-full rounded">
            </div>

            <div class="col-span-1 p-4">
                <input type="text" name="title" value="{{ old('title') }}" placeholder="レシピ名"
                    class="border border-gray-300 p-2 mb-4 w-full rounded">
                <textarea name="description" placeholder="レシピの説明" class="border border-gray-300 p-2 mb-4 w-full roundedl">{{ old('description') }}</textarea>
                <select name="category" class="border border-gray-300 p-2 mb-4 w-full rounded">
                    @foreach ($categories as $c)
                        <option
                            value="{{ $c['id'] }}"{{ (old('category') ?? null) == $c['id'] ? 'selected' : '' }}>
                            {{ $c['name'] }}</option>
                    @endforeach
                </select>

                {{-- 材料 --}}
                <h4 class="text-bold text-xl mb-4">材料を入力</h4>
                <div id="ingredients">
                    @php
                        $old_ingredients = old('ingredients') ?? null;
                    @endphp
                    @if (is_null($old_ingredients))
                        @for ($i = 0; $i < 3; $i++)
                            <div class="flex justify-between items-center ingredient-item">
                                @include('components.bars-3')
                                <input type="text" name="ingredients[{{ $i }}][name]" placeholder="材料名"
                                    class="ingredient-name border border-gray-300 p-2 ml-4 w-full rounded">
                                <p class="mx-2">:</p>
                                <input type="text" name="ingredients[{{ $i }}][quantity]"
                                    placeholder="数量"
                                    class="ingredient-quantity border border-gray-300 p-2 w-full rounded">
                                <div class="step-delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-4 h-4 ml-4 ingredient-delete text-gray-600">
                                        <path fill-rule="evenodd"
                                            d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        @endfor
                    @else
                        @foreach ($old_ingredients as $i => $oi)
                            <div class="flex justify-between items-center ingredient-item">
                                @include('components.bars-3')
                                <input type="text" value="{{ $oi['name'] }}"
                                    name="ingredients[{{ $i }}][name]" placeholder="材料名"
                                    class="ingredient-name border border-gray-300 p-2 ml-4 w-full rounded">
                                <p class="mx-2">:</p>
                                <input type="text" value="{{ $oi['quantity'] }}"
                                    name="ingredients[{{ $i }}][quantity]" placeholder="数量"
                                    class="ingredient-quantity border border-gray-300 p-2 w-full rounded">
                                <div class="step-delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-4 h-4 ml-4 ingredient-delete text-gray-600">
                                        <path fill-rule="evenodd"
                                            d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
                <div class="ingredient-add">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-6 h-6 text-gray-600">
                        <path fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <h4 class="text-center">手順を入力</h4>
        <div id="steps">
            @php
                $old_steps = old('steps') ?? null;
            @endphp
            @if (is_null($old_steps))
                @for ($i = 1; $i < 4; $i++)
                    <div class="ingredient flex items-center justify-between mb-4 step">
                        @include('components.bars-3')
                        <p class="step-number w-16">手順{{ $i }}</p>
                        <input type="text" value="" name="steps[]" placeholder="手順を入力"
                            class="ingredient-name border border-gray-300 p-2 ml-4 w-full rounded">
                        <div class="step-delete">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-10 h-10 ml-4 ingredient-delete text-gray-600">
                                <path fill-rule="evenodd"
                                    d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                @endfor
            @else
                @foreach ($old_steps as $i => $os)
                <div class="ingredient flex items-center justify-between mb-4 step">
                    @include('components.bars-3')
                    <p class="step-number w-16">手順{{ $i + 1 }}</p>
                    <input type="text" value="{{ $os }}" name="steps[]" placeholder="手順を入力"
                        class="ingredient-name border border-gray-300 p-2 ml-4 w-full rounded">
                    <div class="step-delete">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-10 h-10 ml-4 ingredient-delete text-gray-600">
                            <path fill-rule="evenodd"
                                d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                @endforeach
            @endif

        </div>
        <div class="step-add">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="w-6 h-6 text-gray-600">
                <path fill-rule="evenodd"
                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z"
                    clip-rule="evenodd" />
            </svg>
        </div>
        <div class="flex justify-center">
            <button type="submit"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">レシピを投稿する</button>
        </div>
    </form>
</x-app-layout>
