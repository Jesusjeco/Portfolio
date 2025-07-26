<x-container>
		<section {{ $attributes->merge(['class' => 'grid items-center gap-4 lg:grid-cols-4']) }}
				aria-labelledby="{{ $title ? 'content-heading' : '' }}"{{ $title ? '' : ' aria-label="Content section"' }}>
				<div class="lg:col-span-3" role="main">
						@if ($title)
								<h2 id="content-heading" itemprop="headline">{{ $title }}</h2>
						@endif
						@if ($description)
								<div class="content-description" aria-labelledby="{{ $title ? 'content-heading' : '' }}">
										{!! $description !!}
								</div>
						@endif
				</div>

				<div class="lg:col-span-1" role="complementary" aria-label="Supporting illustration">
						@if ($icon)
								@php
										$icon_alt = $title ? $title . ' illustration' : 'Supporting content illustration';
								@endphp
								{!! wp_get_attachment_image($icon, 'medium', false, [
								    'class' => 'mx-auto',
								    'alt' => $icon_alt,
								    'role' => 'img',
								    'aria-describedby' => $title ? 'content-heading' : '',
								]) !!}
						@else
								<div class="mx-auto flex h-24 w-24 items-center justify-center rounded-lg bg-gray-100" role="img"
										aria-label="Placeholder illustration">
										<svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
												<path fill-rule="evenodd"
														d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
														clip-rule="evenodd" />
										</svg>
								</div>
						@endif
				</div>
		</section>
</x-container>
