<div class="category-component form-control shadow">
    <h5 class="title">Danh mục</h5>
    <div class="content mt-3">
        @forelse ($categories as $category)
            <a href="#" class="form-control">
                <img class="rounded"
                    src="{{ $category->image ?? 'https://i.pinimg.com/564x/60/16/26/601626fbf785535009359a1b480268c0.jpg' }}"
                    width="28" height="28" />
                <span>{{ $category->name }}</span>
            </a>
        @empty
            <p class="text-danger">Không có danh mục nào!</p>
        @endforelse
    </div>
    <style>
        .category-component {
            width: 235px;
            height: 365px;
            background: var(--milk);
            border-radius: 1rem;
            overflow: hidden;

            .title {
                font-weight: 600;
                color: var(--coffee-black);
            }

            .content {
                display: flex;
                flex-direction: column;
                gap: 5px;

                &::-webkit-scrollbar{
                    display: none;
                }
                
                a {
                    display: flex;
                    gap: 5px;
                    align-items: center;
                    border: none;
                    background: none;
                    text-decoration: none;
                    width: 100%;
                    font-weight: bold;
                    white-space:nowrap;
                    max-width: 100%;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    transition: 0.25s;

                    &:hover{
                        background: var(--coffee-milk);
                        box-shadow: 0 3px 5px var(--coffee-black);
                        transform: 0.25s;
                    }
                }
            }
        }
    </style>
</div>
