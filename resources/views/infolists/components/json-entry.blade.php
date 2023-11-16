<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div>
        <dl class="divide-y divide-gray-100">
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 items-center bg-gray-100 p-2 rounded">
                <div class="text-sm font-medium leading-6 text-gray-900">{{ __('Column') }}</div>
                <div class="text-sm font-medium leading-6 text-gray-900">{{ __('Old value') }}</div>
                <div class="text-sm font-medium leading-6 text-gray-900">{{ __('New value') }}</div>
            </div>
            @if(is_array($getState()) && count($getState()))
                @foreach($getState() as $key => $value)
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 items-center p-2">
                        <div class="text-sm leading-6 text-gray-700 mt-0">{{ $key }}</div>
                        <div class="text-sm leading-6 text-red-500 mt-0">{{ $value['original'] }}</div>
                        <div class="text-sm leading-6 text-green-500 mt-0">{{ $value['modified'] }}</div>
                    </div>
                @endforeach
            @endif
        </dl>
    </div>



</x-dynamic-component>
