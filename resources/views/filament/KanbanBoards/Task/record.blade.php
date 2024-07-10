<div
	class="px-4 py-2 font-medium text-gray-600 bg-white rounded-lg record cursor-grab dark:bg-gray-700 dark:text-gray-200"
	id="{{ $record->getKey() }}" wire:click="recordClicked('{{ $record->getKey() }}', {{ @json_encode($record) }})"
	@if ($record->timestamps && now()->diffInSeconds($record->{$record::UPDATED_AT}) < 3) x-data
        x-init="
            $el.classList.add('animate-pulse-twice', 'bg-primary-100', 'dark:bg-primary-800')
            $el.classList.remove('bg-white', 'dark:bg-gray-700')
            setTimeout(() => {
                $el.classList.remove('bg-primary-100', 'dark:bg-primary-800')
                $el.classList.add('bg-white', 'dark:bg-gray-700')
            }, 3000)
        " @endif>

	<div class="text-lg">
		{{ $record->{static::$recordTitleAttribute} }}
	</div>
	<div class="mb-2 overflow-hidden text-sm truncate text-ellipsis whitespace-nowrap text-white/50">
		{!! $record->description !!}
	</div>

	<div class="flex flex-wrap items-center justify-start gap-2">
		@foreach ($record->assignees as $assign)
			<div class="w-8 h-8 overflow-hidden rounded-full">
				<img src="{{ $assign->worker->profile_picture }}" alt="" loading="lazy">
			</div>
		@endforeach
	</div>

	{{-- {{ $record->{static::$recordTitleAttribute} }} --}}
</div>
