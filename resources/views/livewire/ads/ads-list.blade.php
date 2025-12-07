<div class="table-responsive">
	<table class="table table-hover align-middle">
		<thead>
			<tr>
				<th scope="col">
					<button class="btn btn-link p-0" wire:click="setSort('ad_name')">
						{{ __('Title') }}
						@if($sortBy === 'ad_name')
							<i class="bi bi-caret-{{ $sortDir === 'asc' ? 'up' : 'down' }}-fill"></i>
						@endif
					</button>
				</th>
				<th scope="col" class="text-nowrap">
					<button class="btn btn-link p-0" wire:click="setSort('price')">
						{{ __('Price') }}
						@if($sortBy === 'price')
							<i class="bi bi-caret-{{ $sortDir === 'asc' ? 'up' : 'down' }}-fill"></i>
						@endif
					</button>
				</th>
				<th scope="col" class="text-nowrap">
					<button class="btn btn-link p-0" wire:click="setSort('price_period')">
						{{ __('Period') }}
						@if($sortBy === 'price_period')
							<i class="bi bi-caret-{{ $sortDir === 'asc' ? 'up' : 'down' }}-fill"></i>
						@endif
					</button>
				</th>
				<th scope="col" class="text-end">{{ __('Actions') }}</th>
			</tr>
		</thead>
		<tbody>
			@forelse($ads as $ad)
				<tr>
					<td>
						<a href="{{ route('ads.show', $ad->id) }}" class="text-decoration-none">
							{{ $ad->ad_name }}
						</a>
					</td>
					<td>
						{{ number_format($ad->price, 0, ',', ' ') }}
					</td>
					<td>
						{{ __($ad->price_period) }}
					</td>
					<td class="text-end">
						<button class="btn btn-outline-secondary btn-sm" wire:click="$dispatch('edit-ad', { id: {{ $ad->id }} })">
							<i class="bi bi-pencil-square me-1"></i>{{ __('Edit') }}
						</button>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="5" class="text-center text-muted py-4">
						{{ __('No ads yet') }}
					</td>
				</tr>
			@endforelse
		</tbody>
	</table>
</div>
