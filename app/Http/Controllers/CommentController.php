<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|max:2000',
            'post_id' => 'required|exists:posts,id',
        ]);

        Comment::create([
            'email' => Auth::user()->email,
            'comment' => $request->comment,
            'post_id' => $request->post_id,
        ]);

        return back()->with('success', 'Comment added successfully.');
    }

    public function reply(Request $request, $comment_id)
    {
        $request->validate([
            'reply' => 'required',
        ]);

        $comment = Comment::findOrFail($comment_id);

        $comment->replies()->create([
            'email' => Auth::user()->email,
            'reply' => $request->reply,
        ]);

        return back()->with('success', 'Reply added successfully.');
    }

    public function destroy(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        // Periksa apakah pengguna memiliki peran Admin atau Manajer Konten
        if ($request->user()->hasRole('Admin') || $request->user()->hasRole('Manajer Konten')) {
            // Jika iya, hapus komentar tanpa memeriksa email
            $comment->delete();
            return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
        }

        // Jika tidak, periksa apakah pengguna adalah penulis komentar
        if ($comment->email === $request->user()->email) {
            // Jika iya, izinkan penghapusan
            $comment->delete();
            return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
        }

        // Jika tidak memiliki izin, kembalikan error atau alihkan ke halaman lain
        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus komentar ini.');
    }

    public function destroyReply(Request $request, $id)
    {
        $reply = CommentReply::findOrFail($id);

        // Periksa apakah pengguna memiliki peran Admin atau Manajer Konten atau pemilik balasan
        if ($request->user()->hasRole('Admin') || $request->user()->hasRole('Manajer Konten') || $reply->email === $request->user()->email) {
            // Hapus balasan komentar
            $reply->delete();
            return redirect()->back()->with('success', 'Balasan komentar berhasil dihapus.');
        }

        // Jika tidak memiliki izin, kembalikan error atau alihkan ke halaman lain
        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus balasan komentar ini.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $comment = Comment::findOrFail($id);

        // Periksa apakah pengguna adalah pemilik komentar, admin atau manajer konten yang memiliki komentar tersebut
        if ($comment->email === Auth::user()->email ||
            ($request->user()->hasRole('Admin') && $comment->email === Auth::user()->email) ||
            ($request->user()->hasRole('Manajer Konten') && $comment->email === Auth::user()->email)) {
            
            $comment->update([
                'comment' => $request->comment,
            ]);
            return redirect()->back()->with('success', 'Komentar berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk memperbarui komentar ini.');
    }

    public function updateReply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required',
        ]);

        $reply = CommentReply::findOrFail($id);

        // Periksa apakah pengguna adalah pemilik balasan
        if ($reply->email === Auth::user()->email) {
            $reply->update([
                'reply' => $request->reply,
            ]);
            return redirect()->back()->with('success', 'Balasan komentar berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk memperbarui balasan komentar ini.');
    }
}
