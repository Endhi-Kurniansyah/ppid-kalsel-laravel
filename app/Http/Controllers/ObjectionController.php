<?php

namespace App\Http\Controllers;

use App\Models\Objection;
use App\Models\InformationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ObjectionController extends Controller
{
    // === BAGIAN FRONTEND (WARGA) ===

    // 1. Tampilkan Halaman Cek Tiket Dulu
    // (Warga harus masukkan nomor tiket lama untuk mengajukan keberatan)
    public function formSearch()
    {
        return view('frontend.objection-search');
    }

    // 2. Tampilkan Form Pengajuan (Setelah tiket ditemukan)
    public function formCreate(Request $request)
    {
        $ticket = $request->input('ticket');

        // Cari tiketnya
        $infoRequest = InformationRequest::where('ticket_number', $ticket)->first();

        // Validasi:
        // 1. Tiket harus ada
        if (!$infoRequest) {
            return back()->with('error', 'Nomor Tiket tidak ditemukan.');
        }

        // 2. Tiket belum pernah diajukan keberatan sebelumnya
        if ($infoRequest->objection) {
            return back()->with('error', 'Keberatan untuk tiket ini sudah pernah diajukan sebelumnya.');
        }

        // Jika lolos, tampilkan form
        return view('frontend.objection-form', compact('infoRequest'));
    }

    // 3. Simpan Keberatan
    public function store(Request $request)
    {
        $request->validate([
            'information_request_id' => 'required',
            'reason' => 'required',
            'description' => 'required',
        ]);

        // Buat Kode Unik OBJ-XXXX
        $code = 'OBJ-' . date('Y') . '-' . strtoupper(Str::random(5));

        Objection::create([
            'information_request_id' => $request->information_request_id,
            'objection_code' => $code,
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        return redirect()->route('objection.success', $code);
    }

    // 4. Halaman Sukses
    public function success($code)
    {
        return view('frontend.objection-success', compact('code'));
    }

    // === BAGIAN BACKEND (ADMIN) ===
    // Nanti kita tambahkan di langkah selanjutnya
    // === BAGIAN BACKEND (ADMIN) ===

    // 5. DAFTAR KEBERATAN MASUK (ADMIN)
    public function index()
    {
        // Ambil data keberatan beserta data permohonan aslinya
        $objections = Objection::with('request')->latest()->get();
        return view('admin.objections.index', compact('objections'));
    }

    // 6. DETAIL & PROSES (ADMIN)
    public function show($id)
    {
        $objection = Objection::with('request')->findOrFail($id);
        return view('admin.objections.show', compact('objection'));
    }

    // 7. UPDATE STATUS (ADMIN)
    public function update(Request $request, $id)
    {
        $objection = Objection::findOrFail($id);

        $request->validate([
            'status' => 'required',
            'admin_note' => 'required', // Tanggapan wajib diisi untuk keberatan
        ]);

        $objection->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note
        ]);

        return redirect()->route('admin.objections.index')->with('success', 'Tanggapan keberatan berhasil disimpan!');
    }
}
