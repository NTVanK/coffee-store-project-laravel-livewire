<div class="col position-relative">
    <input type="text" wire:model.live.debounce:200ms ='search' id="search"
        class="form-control border border-dark" placeholder="Tìm kiếm...">

    @if ($searchResults)
        <ul class="list-group position-absolute shadow w-100 mt-1 z-3" wire:transition.scale.origin.top>
            @forelse ($searchResults as $product)
                <li class="list-group-item p-1">
                    <a href="{{ route('detail', ['id' => $product->id]) }}" wire:navigate
                        class="d-flex text-decoration-none">
                        <img src="{{ asset($product->image[0]) }}" width='48' height="48"
                            class="rounded border border-dark">
                        <span class="fw-bold ms-2">
                            {{ $product->name }}
                            <br>
                            <small class="text-danger">
                                {{ $product->price }} (VND)
                            </small>
                        </span>
                    </a>
                </li>
            @empty
                <li class="list-group-item text-danger fw-bold">Không tìm thấy sản phẩm nào!</li>
            @endforelse
        </ul>
    @endif
</div>