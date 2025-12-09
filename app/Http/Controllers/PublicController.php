<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\InformationRequest;
use App\Models\Document;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    // Menampilkan Halaman Form
    public function showForm()
    {
        return view('frontend.form-permohonan');
    }
    public function showPage($slug)
    {
        // Cari halaman berdasarkan slug, kalau tidak ketemu munculkan 404
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('frontend.page', compact('page'));
    }

    // Memproses Data yang Dikirim
    public function submitRequest(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nik_ktp' => 'required|numeric',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'details' => 'required',
            'purpose' => 'required',
        ]);

        try {
            DB::beginTransaction(); // Mulai Transaksi Database

            // 2. Cek atau Buat Data Pemohon (Applicant)
            // Logic: Cari berdasarkan NIK, kalau gak ada, buat baru.
            $applicant = Applicant::firstOrCreate(
                ['nik_ktp' => $request->nik_ktp],
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'job' => $request->job,
                    'type' => 'perorangan' // Default perorangan dulu
                ]
            );

            // 3. Simpan Permintaan Informasi (InformationRequest)
            // Buat No Tiket Unik, misal: TICK-8291
            $ticket = 'TICK-' . strtoupper(Str::random(6));

            InformationRequest::create([
                'ticket_number' => $ticket,
                'applicant_id' => $applicant->id,
                'details' => $request->details,
                'purpose' => $request->purpose,
                'status' => 'pending'
            ]);

            DB::commit(); // Simpan permanen

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Permohonan berhasil dikirim! Nomor Tiket Anda: ' . $ticket);

        } catch (\Exception $e) {
            DB::rollback(); // Batalkan semua kalau ada error
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
    public function sop()
    {
        // Ambil dokumen yang kategorinya punya slug 'sop'
        $sops = Document::whereHas('category', function($q) {
            $q->where('slug', 'sop');
        })->latest()->get();

        return view('frontend.sop', compact('sops'));
    }
    public function showDocuments($slug)
    {
        // 1. Cari Kategorinya dulu (Misal: 'sop', 'berkala')
        $category = Category::where('slug', $slug)->firstOrFail();

        // 2. Ambil dokumen yang sesuai kategori itu
        $documents = Document::where('category_id', $category->id)
                             ->latest()
                             ->get();

        // 3. Tampilkan ke view yang umum
        return view('frontend.documents', compact('category', 'documents'));
    }
}
