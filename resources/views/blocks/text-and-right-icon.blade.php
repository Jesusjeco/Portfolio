<x-container>
		<div class="grid lg:grid-cols-4 gap-4 items-center">
				<div class="lg:col-span-3">
						@if ($title)
								<h2>{{ $title }}</h2>
						@endif
						@if ($description)
								{!! $description !!}
						@endif
				</div>

				<div class="lg:col-span-1">
						@if ($icon)
								{!! wp_get_attachment_image($icon, 'medium', false, ['class' => 'mx-auto']) !!}
						@endif
				</div>
		</div>
</x-container>
