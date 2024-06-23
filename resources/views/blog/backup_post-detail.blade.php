@extends('layouts.blog')

@section('title')
    {{ $post->title }}
@endsection

@section('description')
    {{ $post->description }}
@endsection

@section('content')
    <!-- Post Title -->
    <h2 class="mt-4 mb-3">
        {{ $post->title }}
    </h2>

    <!-- Breadcrumb Navigation -->
    {{ Breadcrumbs::render('blog_post', $post->title) }}

    <div class="row">
        <!-- Main Post Content -->
        <div class="col-lg-8">
            <!-- Post Thumbnail -->
            @if (file_exists(public_path($post->thumbnail)))
                <img class="card-img-top mx-auto d-block" src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}"
                    style="width: 400px; height: 350px; object-fit: contain;">
            @else
                <img class="img-fluid rounded mx-auto d-block" src="http://placehold.it/750x300" alt="{{ $post->title }}"
                    style="width: 400px; height: 350px; object-fit: contain;">
            @endif

            <hr>

            <!-- Post Content -->
            <div>
                {!! $post->content !!}
            </div>

            <hr>

            <!-- Comment Form -->
            @if (Auth::check())
                <div class="card my-4">
                    <p style="font-weight: bold; font-size: 24px" class="card-header">Tinggalkan komentar dibawah:</p>
                    <div class="card-body">
                        <form method="post" action="{{ route('comment.store') }}">
                            @csrf
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                    value="{{ Auth::user()->email }}" readonly>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="comment" rows="3" placeholder="Komentar disini..." required></textarea>
                            </div>
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            @else
                <p>Silahkan <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">Register</a>
                    untuk berkomentar disini.</p>
            @endif

            <!-- Comment Section -->
            @foreach ($post->comments as $comment)
                <div class="card mb-4">
                    <div class="card-body">
                        <p>{{ $comment->comment }}</p>
                        <!-- Edit Comment Form -->
                        <form id="edit-comment-form-{{ $comment->id }}" method="post"
                            action="{{ route('comment.update', $comment->id) }}" style="display: none;">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <textarea class="form-control" name="comment" rows="3" required>{{ $comment->comment }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                            <button type="button" class="btn btn-secondary"
                                onclick="toggleEditForm('comment', {{ $comment->id }})">Batal</button>
                        </form>
                        <!-- Meta Information -->
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-row align-items-center">
                                <i class="far fa-user mx-2" style="margin-top: -0.16rem;"></i>
                                <strong>{{ $comment->email }}</strong>
                            </div>
                            <div class="d-flex flex-row align-items-center">
                                <p class="small text-muted mb-0">{{ $comment->created_at }}</p>
                                <i class="far fa-calendar mx-2 fa-xs text-body" style="margin-top: -0.16rem;"></i>
                            </div>
                        </div>
                        <!-- Delete and Edit Comment Buttons -->
                        <div class="text-right">
                            @if (Auth::check() &&
                                    (Auth::user()->email == $comment->email ||
                                        Auth::user()->hasRole('Admin') ||
                                        Auth::user()->hasRole('Manajer Konten')))
                                <form id="delete-comment-{{ $comment->id }}" method="post"
                                    action="{{ route('comment.destroy', $comment->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="confirmDeleteComment('{{ $comment->id }}')"><i
                                            class="fas fa-trash"></i></button>
                                    <!-- Tampilkan tombol edit untuk Admin, Manajer Konten, dan pemilik komentar -->
                                    <button type="button" class="btn btn-sm btn-info"
                                        onclick="toggleEditForm('comment', {{ $comment->id }})"><i
                                            class="fas fa-edit"></i></button>
                                </form>
                            @endif
                        </div>

                        <!-- Separator for Replies -->
                        <hr>
                        <p style="font-weight: bold; font-size: 24px">Balasan Komentar</p>

                        <!-- Display Replies -->
                        @foreach ($comment->replies as $reply)
                            <div class="card mb-2">
                                <div class="card-body">
                                    <p>{{ $reply->reply }}</p>
                                    <!-- Edit Reply Form -->
                                    <form id="edit-reply-form-{{ $reply->id }}" method="post"
                                        action="{{ route('comment.reply.update', $reply->id) }}" style="display: none;">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <textarea class="form-control" name="reply" rows="3" required>{{ $reply->reply }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Perbarui</button>
                                        <button type="button" class="btn btn-secondary"
                                            onclick="toggleEditForm('reply', {{ $reply->id }})">Batal</button>
                                    </form>
                                    <!-- Meta Information -->
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row align-items-center">
                                            <i class="far fa-user mx-2" style="margin-top: -0.16rem;"></i>
                                            <strong>{{ $reply->email }}</strong>
                                        </div>
                                        <div class="d-flex flex-row align-items-center">
                                            <p class="small text-muted mb-0">{{ $reply->created_at }}</p>
                                            <i class="far fa-calendar mx-2 fa-xs text-body"
                                                style="margin-top: -0.16rem;"></i>
                                        </div>
                                    </div>

                                    <!-- Delete and Edit Reply Buttons -->
                                    <div class="text-right">
                                        @if (Auth::check() &&
                                                (Auth::user()->email == $reply->email ||
                                                    Auth::user()->hasRole('Admin') ||
                                                    Auth::user()->hasRole('Manajer Konten')))
                                            <form id="delete-reply-{{ $reply->id }}" method="post"
                                                action="{{ route('comment.reply.destroy', ['reply_id' => $reply->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete('{{ $reply->id }}')"><i
                                                        class="fas fa-trash"></i></button>
                                                <!-- Tampilkan tombol edit untuk Admin, Manajer Konten, dan pemilik balasan -->
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="toggleEditForm('reply', {{ $reply->id }})"><i
                                                        class="fas fa-edit"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Separator for Reply Form -->
                        <hr>

                        <!-- Reply Form -->
                        @if (Auth::check())
                            <p style="font-weight: bold; font-size: 20px">Kolom Balasan</p>

                            <div class="mt-3">
                                <form method="post"
                                    action="{{ route('comment.reply', ['comment_id' => $comment->id]) }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="Email"
                                            value="{{ Auth::user()->email }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" name="reply" rows="1" placeholder="Balas disini..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary">Balas</button>
                                </form>
                            </div>
                        @else
                            <p>Silahkan <a href="{{ route('login') }}">Login</a> atau <a
                                    href="{{ route('register') }}">Register</a>
                                untuk membalas komentar.</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Sidebar Widgets -->
        <div class="col-md-4">
            <!-- Categories Widget -->
            <div class="card mb-3">
                <h5 class="card-header">
                    {{ trans('blog.widget.categories') }}
                </h5>
                <div class="card-body">
                    <!-- Category List -->
                    @foreach ($post->categories as $category)
                        <a href="{{ route('blog.posts.category', ['slug' => $category->slug]) }}"
                            class="badge badge-primary py-2 px-4 my-1">
                            {{ $category->title }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Tags Widget -->
            <div class="card mb-3">
                <h5 class="card-header">
                    {{ trans('blog.widget.tags') }}
                </h5>
                <div class="card-body">
                    <!-- Tag List -->
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('blog.posts.tags', ['slug' => $tag->slug]) }}"
                            class="badge badge-info py-2 px-4 my-1">
                            #{{ $tag->title }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Author Widget -->
            <div class="card mb-3">
                <h5 class="card-header">
                    {{ trans('blog.widget.author') }}
                </h5>
                <div class="card-body">
                    <p class="badge badge-success py-2 px-4 my-1" style="font-weight: bold">
                        {{ $post->author }}
                    </p>
                </div>
            </div>

            <!-- Created At Widget -->
            <div class="card mb-3">
                <h5 class="card-header">
                    {{ trans('blog.widget.create_at') }}
                </h5>
                <div class="card-body">
                    <p class="badge badge-secondary py-2 px-4 my-1" style="font-weight: bold">
                        {{ $post->created_at }}
                    </p>
                </div>
            </div>

            {{-- <!-- Views Widget (Uncomment if needed) -->
            <div class="card mb-3">
                <h5 class="card-header">
                    {{ trans('blog.widget.views') }}
                </h5>
                <div class="card-body">
                    <p class="badge badge-secondary py-2 px-4 my-1" style="font-weight: bold">
                        {{ $post->views }}
                    </p>
                </div>
            </div> --}}
        </div>
    </div>
@endsection

<script>
    function confirmDelete(replyId) {
        if (confirm('Apakah anda akan menghapus balasan ini?')) {
            document.getElementById('delete-reply-' + replyId).submit();
        }
    }

    function confirmDeleteComment(commentId) {
        if (confirm('Apakah anda akan menghapus komentar?')) {
            document.getElementById('delete-comment-' + commentId).submit();
        }
    }

    function toggleEditForm(type, id) {
        const editForm = document.getElementById(`edit-${type}-form-${id}`);
        if (editForm.style.display === 'none') {
            editForm.style.display = 'block';
        } else {
            editForm.style.display = 'none';
        }
    }
</script>
