<footer class="py-10 mt-8 bg-[#1E1E1E]">
		{{-- @php(dynamic_sidebar('sidebar-footer')) --}}
		<x-container>
				<hr class="mb-5 border-gray-200">
				<div class="flex flex-wrap items-center justify-between">
						<div class="w-full sm:w-1/2">
								<p class="text-sm text-gray-400">
										&copy; {{ date('Y') }} {{ get_bloginfo('name') }}. All rights reserved.
								</p>
						</div>
						<div class="flex items-center justify-end gap-5">
								<a href="https://github.com/jesusjeco" target="_blank" class="text-sm text-gray-400">
										GitHub
								</a>
								<a href="mailto:jesusenrique.carrero@gmail.com" class="text-sm text-gray-400">
										Contact
								</a>
								<a href="https://www.linkedin.com/in/jesus-carrero/" target="_blank" class="text-sm text-gray-400">
										LinkedIn
								</a>
						</div>
				</div>
		</x-container>
</footer>
