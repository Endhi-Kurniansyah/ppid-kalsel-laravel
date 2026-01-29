<?php

namespace App\Http\Controllers;

use App\Models\Objection;
use App\Models\InformationRequest;
use App\Models\User; // <--- TAMBAHKAN INI
use App\Notifications\AdminNotification; // <--- TAMBAHKAN INI
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification; // <--- TAMBAHKAN INI

class ObjectionController extends Controller
{
    // === BAGIAN FRONTEND (WARGA) ===

    public function formSearch()
    {
        return view('frontend.objection-search');
    }

    public function formCreate(Request $request)
    {
        $ticket = $request->input('ticket');
        $infoRequest = InformationRequest::where('ticket_number', $ticket)->first();

        if (!$infoRequest) {
            return back()->with('error', 'Nomor Tiket tidak ditemukan.');
        }

        if ($infoRequest->objection) {
            return back()->with('error', 'Keberatan untuk tiket ini sudah pernah diajukan sebelumnya.');
        }

        return view('frontend.objection-form', compact('infoRequest'));
    }

    // 3. Simpan Keberatan + NOTIFIKASI
    public function store(Request $request)
    {
        $request->validate([
            'information_request_id' => 'required',
            'reason' => 'required',
            'description' => 'required',
        ]);

        $code = 'OBJ-' . date('Y') . '-' . strtoupper(Str::random(5));

        $objection = Objection::create([
            'information_request_id' => $request->information_request_id,
            'objection_code' => $code,
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        // =========================================================
        // LOGIKA NOTIFIKASI UNTUK KEBERATAN
        // =========================================================
        $adminUsers = User::whereIn('role', ['super', 'admin'])->get();

        $details = [
            'title'   => 'Pengajuan Keberatan Baru',
            'message' => 'Ada pengajuan keberatan baru dengan kode: ' . $code,
            'url'     => route('admin.objections.show', $objection->id), // Link ke detail keberatan
            'type'    => 'objection' // Tipe berbeda untuk icon di lonceng
        ];

        Notification::send($adminUsers, new AdminNotification($details));
        // =========================================================

        return redirect()->route('objection.success', $code);
    }

    public function success($code)
    {
        return view('frontend.objection-success', compact('code'));
    }

    // === BAGIAN BACKEND (ADMIN) ===

    public function index(Request $request)
    {
        // 1. Query Dasar (Eager load 'request' untuk ambil data pemohon)
        $query = Objection::with('request')->latest();

        // 2. Filter Bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // 3. Filter Tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // 4. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 5. Search by Objection Code or Applicant Name
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function($q) use ($keyword) {
                $q->where('objection_code', 'LIKE', "%{$keyword}%")
                  ->orWhereHas('request', function($subQ) use ($keyword) {
                      $subQ->where('name', 'LIKE', "%{$keyword}%")
                           ->orWhere('ticket_number', 'LIKE', "%{$keyword}%");
                  });
            });
        }

        // 6. Ambil Data (Pakai Paginate biar halaman tidak berat)
        $objections = $query->paginate(10)->appends($request->all());

        return view('admin.objections.index', compact('objections'));
    }

    public function show($id)
    {
        $objection = Objection::with('request')->findOrFail($id);

         $user = auth()->user();

        /** @var \App\Models\User $user */
        if ($user) {
            $user->unreadNotifications()
                ->where('data->url', route('admin.objections.show', $id))
                ->get()
                ->markAsRead();
        }

        return view('admin.objections.show', compact('objection'));
    }

    public function update(Request $request, $id)
    {
        $objection = Objection::findOrFail($id);

        $request->validate([
            'status' => 'required',
            'admin_note' => 'required',
        ]);

        $objection->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note
        ]);

        return redirect()->route('admin.objections.index')->with('success', 'Tanggapan keberatan berhasil disimpan!');
    }
}
