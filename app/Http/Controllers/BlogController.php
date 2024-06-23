<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    private $perpage = 10;

    public function home()
    {
        // Mengambil postingan dengan views terbanyak, maksimal 5 post
        $popular_posts = Post::where('status', 'publish')
            ->orWhere(function ($query) {
                if (Auth::check()) {
                    $query->where('status', 'private');
                }
            })
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        // Mengambil postingan terbaru untuk ditampilkan di halaman utama
        $latest_posts = Post::where(function ($query) {
                $query->where('status', 'publish');
                if (Auth::check()) {
                    $query->orWhere('status', 'private');
                }
            })
            ->latest()
            ->paginate($this->perpage);

        return view('blog.home', [
            'popular_posts' => $popular_posts,
            'latest_posts' => $latest_posts
        ]);
    }

    public function showCategories()
    {
        $categories = Category::whereNull('parent_id')->paginate($this->perpage);
        return view('blog.categories', compact('categories'));
    }

    public function showTags()
    {
        $tags = Tag::paginate($this->perpage);
        return view('blog.tags', compact('tags'));
    }

    public function searchPosts(Request $request)
    {
        if (!$request->get('keyword')) {
            return redirect()->route('blog.home');
        }

        $postsQuery = Post::where('status', 'publish'); // Mengambil hanya post dengan status "publish"
        
        // Jika pengguna sudah login, tambahkan kondisi untuk menampilkan post dengan status "private"
        if (Auth::check()) {
            $postsQuery->orWhere('status', 'private');
        }

        // Ambil data post sesuai query yang telah dibuat
        $posts = $postsQuery->search($request->keyword)
            ->paginate($this->perpage)
            ->appends(['keyword' => $request->keyword]);

        return view('blog.search-post', [
            'posts' => $posts
        ]);
    }

    public function showPostsByCategory($slug)
    {
        $postsQuery = Post::where('status', 'publish') // Mengambil hanya post dengan status "publish"
                            ->whereHas('categories', function ($query) use ($slug) {
                                // Memastikan hanya mengambil posting dengan kategori yang sesuai
                                $query->where('slug', $slug);
                            });

        // Jika pengguna sudah login, tambahkan kondisi untuk menampilkan post dengan status "private"
        if (Auth::check()) {
            $postsQuery->orWhere(function ($query) use ($slug) {
                $query->where('status', 'private')
                    ->whereHas('categories', function ($query) use ($slug) {
                        $query->where('slug', $slug);
                    });
            });
        }

        $posts = $postsQuery->paginate($this->perpage);

        $category = Category::where('slug', $slug)->first();
        $categoryRoot = $category->root();

        return view('blog.post-category', [
            'posts' => $posts,
            'category' => $category,
            'categoryRoot' => $categoryRoot
        ]);
    }

    public function showPostsByTag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $posts = $tag->posts()->where(function ($query) {
            $query->where('status', 'publish');
            if (Auth::check()) {
                $query->orWhere('status', 'private');
            }
        })->paginate($this->perpage);

        return view('blog.post-tag', [
            'posts' => $posts,
            'tag' => $tag,
            'tags' => Tag::paginate($this->perpage)
        ]);
    }

    public function showPostsByDetail($slug)
    {
        $postsQuery = Post::where('slug', $slug); // Ambil post dengan slug yang sesuai

        // Jika pengguna sudah login, tambahkan kondisi untuk menampilkan post dengan status "private"
        if (Auth::check()) {
            $postsQuery->whereIn('status', ['publish', 'private']);
        } else {
            $postsQuery->where('status', 'publish');
        }

        $post = $postsQuery->with(['categories', 'tags'])->first();
        
        if (!$post) {
            return redirect()->route('blog.home');
        }

        // Tambahkan jumlah tampilan setiap kali postingan dibuka
        $post->increment('views');

        return view('blog.post-detail', [
            'post' => $post
        ]);
    }



}