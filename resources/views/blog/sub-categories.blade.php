<ul>
    @foreach ($categoryRoot as $item)
    <li>
        @if ($category->slug == $item->slug)
        {{ $item->title }}
    @else
    <a href="{{ route('blog.posts.category', ['slug' => $item->slug]) }}">
        {{ $item->title }}
    </a>
    @endif
    @if ($item->descendants)
            @include('blog.sub-categories', [
            'categoryRoot' => $item->descendants,
            'category' => $category
            ])           
    @endif
    </li>
    @endforeach
</ul>