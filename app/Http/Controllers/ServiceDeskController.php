<?php

namespace App\Http\Controllers;

use App\Models\ServiceDesk;
use App\Models\ServiceDeskReply;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;


class ServiceDeskController extends Controller
{
    public function index()
    {
        $questions = ServiceDesk::orderBy('created_at', 'desc')->paginate(2); // Ambil data pertanyaan dengan sistem paginasi
        $popularQuestions = ServiceDesk::orderBy('helpful', 'desc')->take(3)->get();
            return view('blog.service-desk', compact('questions', 'popularQuestions')); // Kirim data pertanyaan ke tampilan
    }

    public function giveHelpful(Request $request)
    {
        $question = ServiceDesk::findOrFail($request->question_id);

        if (Auth::check() && !$question->helpfulGivenByUser(Auth::id())) {
            $question->increment('helpful');
            $question->helpfulUsers()->attach(Auth::id());
        }

        return redirect()->back();
    }

    public function removeHelpful(Request $request)
    {
        $question = ServiceDesk::findOrFail($request->question_id);

        if (Auth::check() && $question->helpfulGivenByUser(Auth::id())) {
            $question->decrement('helpful');
            $question->helpfulUsers()->detach(Auth::id());
        }

        return redirect()->back();
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:13',
            'question' => 'required|string|max:2000',
        ], [
            'name.max' => 'Nama maksimal berisi 100 karakter.',
            'phone.max' => 'Nomor Telepon maksimal berisi 13 karakter.',
        ]);

        // Create a new ServiceDesk entry
        ServiceDesk::create([
            'email' => $request->email,
            'name' => $request->name,
            'phone' => $request->phone,
            'question' => $request->question,
        ]);

        // Set success message
        $successMessage = 'Your question has been submitted successfully.';

        // Redirect back with a success message
        return redirect()->back()->with('success', $successMessage);
    }

    public function destroy(Request $request, $id)
    {
        $serviceDesk = ServiceDesk::findOrFail($id);

        // Periksa apakah pengguna memiliki peran Admin atau Manajer Konten
        if ($request->user()->hasRole('Admin') || $request->user()->hasRole('Manajer Konten')) {
            // Jika iya, hapus entri ServiceDesk tanpa memeriksa email
            $serviceDesk->delete();
            return redirect()->back()->with('success', 'Pertanyaan berhasil dihapus.');
        }

        // Jika tidak, periksa apakah pengguna adalah penulis pertanyaan
        if ($serviceDesk->email === $request->user()->email) {
            // Jika iya, izinkan penghapusan
            $serviceDesk->delete();
            return redirect()->back()->with('success', 'Pertanyaan berhasil dihapus.');
        }

        // Jika tidak memiliki izin, kembalikan error atau alihkan ke halaman lain
        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus pertanyaan ini.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|max:2000',
        ]);

        $serviceDesk = ServiceDesk::findOrFail($id);

        // Periksa apakah pengguna adalah pemilik pertanyaan, admin, atau manajer konten yang memiliki pertanyaan tersebut
        if ($serviceDesk->email === Auth::user()->email ||
            ($request->user()->hasRole('Admin') && $serviceDesk->email === Auth::user()->email) ||
            ($request->user()->hasRole('Manajer Konten') && $serviceDesk->email === Auth::user()->email)) {
            
            $serviceDesk->update([
                'question' => $request->question,
            ]);
            return redirect()->back()->with('success', 'Pertanyaan berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk memperbarui pertanyaan ini.');
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string|max:255',
        ]);

        $serviceDesk = ServiceDesk::findOrFail($id);

        $serviceDesk->replies()->create([
            'email' => Auth::user()->email,
            'reply' => $request->reply,
        ]);

        return redirect()->back()->with('success', 'Reply added successfully.');
    }

    public function updateReply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string|max:255', // Sesuaikan aturan validasi sesuai kebutuhan Anda
        ]);

        $reply = ServiceDeskReply::findOrFail($id);

        // Pastikan pengguna adalah pemilik reply atau memiliki izin admin untuk melakukan update
        if ($reply->email === Auth::user()->email || 
            ($request->user()->hasRole('Admin') && $reply->email === Auth::user()->email) ||
            ($request->user()->hasRole('Manajer Konten') && $reply->email === Auth::user()->email)) {
            
            $reply->update([
                'reply' => $request->reply,
            ]);
            return redirect()->back()->with('success', 'Reply updated successfully.');
        }

        return redirect()->back()->with('error', 'You are not authorized to update this reply.');
    }

    public function destroyReply(Request $request, $id)
    {
        $reply = ServiceDeskReply::findOrFail($id);

        // Periksa apakah pengguna memiliki peran Admin atau Manajer Konten atau pemilik balasan
        if ($request->user()->hasRole('Admin') || $request->user()->hasRole('Manajer Konten') || $reply->email === $request->user()->email) {
            // Hapus balasan komentar
            $reply->delete();
            return redirect()->back()->with('success', 'Balasan pertanyaan berhasil dihapus.');
        }

        // Jika tidak memiliki izin, kembalikan error atau alihkan ke halaman lain
        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus balasan pertanyaan ini.');
    }

    public function getPopularQuestions()
    {
        $popularQuestions = ServiceDesk::orderBy('helpful', 'desc')->take(3)->get();
        return view('blog.popular-questions', compact('popularQuestions'));
    }
}
