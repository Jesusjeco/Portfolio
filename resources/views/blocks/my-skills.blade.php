<x-container>
		<div {{ $attributes->merge(['class' => 'rounded-md border border-solid border-gray-200 p-4']) }}>
				<h2>{{ $title }}</h2>
				@if ($skills)
						@foreach ($skills as $skill)
								<div class="mt-4 flex items-center gap-2">
										{!! wp_get_attachment_image($skill['icon'], 'medium', false, ['class' => 'w-10 h-10 object-cover']) !!}
										<span class="skill-name text-lg font-semibold">{{ $skill['name'] }}</span>
								</div>

								@if (!empty($skill['badges']))
										<div class="mt-3 flex flex-wrap gap-2">
												@foreach ($skill['badges'] as $badge)
														<span class="badge rounded bg-blue-100 px-2.5 py-0.5 font-medium text-blue-800">
																{{ $badge['name'] }}
														</span>
												@endforeach
										</div>
								@endif
						@endforeach
				@endif
		</div>
</x-container>
