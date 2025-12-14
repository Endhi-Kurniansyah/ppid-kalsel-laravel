<?php

namespace App\Http\Controllers;

use App\Models\InformationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // <--- INI PERBAIKANNYA (Supaya Str tidak merah)
use Barryvdh\DomPDF\Facade\Pdf; // Pastikan package PDF sudah diinstall

class InformationRequestController extends Controller
{
    // 1. TAMPILKAN DAFTAR REQUEST (ADMIN)
    public function index()
    {
        // PERBAIKAN: Hapus 'with('applicant')' karena tabelnya sudah digabung
        $requests = InformationRequest::latest()->get();

        // Pastikan view ini ada (nanti kita buat)
        return view('admin.requests.index', compact('requests'));
    }

    // 2. FORMULIR PENGAJUAN (FRONTEND)
    public function create()
    {
        return view('frontend.form-permohonan');
    }

    // 3. PROSES SIMPAN DATA (FRONTEND)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name'      => 'required|string|max:255',
            'nik'       => 'required|numeric|digits:16',
            'ktp_file'  => 'required|image|max:2048',
            'email'     => 'required|email',
            'phone'     => 'required|numeric',
            'address'   => 'required',
            'details'   => 'required',
            'purpose'   => 'required',
        ]);

        // Upload Foto KTP
        $ktpPath = $request->file('ktp_file')->store('ktp-uploads', 'public');

        // Generate Nomor Tiket: REQ-2025-XXXXX
        $ticket = 'REQ-' . date('Y') . '-' . strtoupper(Str::random(5));

        // Simpan ke Database
        InformationRequest::create([
            'ticket_number' => $ticket,
            'name'          => $request->name,
            'nik'           => $request->nik,
            'ktp_file'      => $ktpPath,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'job'           => $request->job,
            'details'       => $request->details,
            'purpose'       => $request->purpose,
            'get_method'    => $request->get_method,
            'delivery_method' => $request->delivery_method,
            'status'        => 'pending'
        ]);

        // Arahkan ke halaman Sukses
        return redirect()->route('requests.success', ['ticket' => $ticket]);
    }

    // 4. HALAMAN SUKSES (FRONTEND)
    public function success($ticket)
    {
        return view('frontend.request-success', compact('ticket'));
    }

    // 5. CETAK PDF (ADMIN)
    public function print()
    {
        // PERBAIKAN: Hapus 'with('applicant')'
        $requests = InformationRequest::get();

        // Load view PDF
        $pdf = Pdf::loadView('admin.requests.print', compact('requests'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-permohonan-informasi.pdf');
    }
    public function show($id)
    {
        $req = InformationRequest::findOrFail($id);
        return view('admin.requests.show', compact('req'));
    }

    // 7. UPDATE STATUS & BALAS (ADMIN)
    public function update(Request $request, $id)
    {
        $req = InformationRequest::findOrFail($id);

        $request->validate([
            'status' => 'required',
            // admin_note wajib diisi kalau statusnya ditolak atau selesai
            'admin_note' => 'nullable|string',
        ]);

        $data = [
            'status'     => $request->status,
            'admin_note' => $request->admin_note,
        ];

        // Jika admin melampirkan file balasan (misal SK PDF)
        if ($request->file('reply_file')) {
            $data['reply_file'] = $request->file('reply_file')->store('reply-files', 'public');
        }

        $req->update($data);

        return redirect()->route('admin.requests.index')->with('success', 'Permohonan berhasil diproses!');
    }
    public function track(Request $request)
    {
        // Variabel penampung hasil pencarian (awalnya kosong)
        $result = null;

        // Jika user melakukan pencarian (mengirim input 'ticket')
        if ($request->has('ticket')) {
            $ticket = $request->input('ticket');

            // Cari data berdasarkan nomor tiket dan NIK (biar lebih aman/spesifik)
            // Atau cukup tiket saja juga boleh. Di sini kita pakai tiket saja biar mudah.
            $result = InformationRequest::where('ticket_number', $ticket)->first();

            if (!$result) {
                return back()->with('error', 'Nomor Tiket tidak ditemukan! Mohon periksa kembali.');
            }
        }

        return view('frontend.track', compact('result'));
    }
}
