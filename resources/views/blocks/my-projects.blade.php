<div {{ $attributes->merge(['class' => 'pt-8 pb-15']) }}>
		<x-container>
				@if ($title)
						<h2 class="text-2xl font-bold">{{ $title }}</h2>
				@endif
				@if ($description)
						<p>{{ $description }}</p>
				@endif
				@if ($projects)
						<div class="grid grid-cols-2 gap-4 pt-4 md:grid-cols-3 lg:grid-cols-4">
								@foreach ($projects as $project)
										<a href="{{ $project['link']['url'] }}" target="{{ $project['link']['target'] }}"
												class="rounded bg-white shadow">
												<img src="{{ $project['logo']['url'] }}" alt="{{ $project['link']['title'] }}"
														class="block h-[60px] w-[175px] object-contain p-2">
										</a>
								@endforeach
						</div>
				@endif
		</x-container>
</div>
