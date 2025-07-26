<x-container>
		<section {{ $attributes->merge(['class' => 'rounded-md border border-solid border-gray-200 p-4 mb-8']) }}
				aria-labelledby="skills-heading">
				<h2 id="skills-heading">{{ $title }}</h2>
				@if ($skills)
						<ul class="skills-list mt-4 space-y-4" role="list" aria-label="Technical skills and expertise">
								@foreach ($skills as $index => $skill)
										<li class="skill-item" itemscope itemtype="https://schema.org/Skill">
												<div class="flex items-center gap-2">
														@if ($skill['icon'])
																{!! wp_get_attachment_image($skill['icon'], 'medium', false, [
																    'class' => 'w-10 h-10 object-cover',
																    'alt' => $skill['name'] . ' technology icon',
																    'role' => 'img',
																    'aria-describedby' => 'skill-' . $index,
																]) !!}
														@else
																<div class="flex h-10 w-10 items-center justify-center rounded bg-gray-200" role="img"
																		aria-label="{{ $skill['name'] }} placeholder icon">
																		<span class="text-xs font-bold text-gray-500">{{ strtoupper(substr($skill['name'], 0, 2)) }}</span>
																</div>
														@endif
														<strong class="skill-name text-lg font-semibold" id="skill-{{ $index }}"
																itemprop="name">{{ $skill['name'] }}</strong>
												</div>

												@if (!empty($skill['badges']))
														<div class="mt-3 flex flex-wrap gap-2" role="group" aria-labelledby="skill-{{ $index }}"
																aria-label="Related technologies and frameworks">
																@foreach ($skill['badges'] as $badgeIndex => $badge)
																		<span class="badge rounded bg-blue-100 px-2.5 py-0.5 font-medium text-blue-800" role="note"
																				aria-label="Technology: {{ $badge['name'] }}" itemscope itemtype="https://schema.org/Thing"
																				itemprop="relatedTechnology">
																				<span itemprop="name">{{ $badge['name'] }}</span>
																		</span>
																@endforeach
														</div>
												@endif
										</li>
								@endforeach
						</ul>
				@else
						<p class="mt-4 text-gray-600" role="status" aria-live="polite">No skills information available at this time.</p>
				@endif
		</section>
</x-container>
