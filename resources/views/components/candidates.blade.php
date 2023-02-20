<div class="rounded-xl shadow-lg">
    <img src="{{ $candidate->photo }}" alt="{{ $candidate->name }}" class="block object-cover object-top w-full h-32 rounded-t-xl">

    <div class="p-6 rounded-b-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
        <h2 class="text-lg font-semibold">{{ $candidate->name }}</h2>

        {{ $actions }}
    </div>
</div>