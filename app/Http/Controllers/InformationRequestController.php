<?php

namespace App\Http\Controllers;

use App\Models\InformationRequest;
use App\Models\User;
use App\Notifications\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class InformationRequestController extends Controller
{

    public function index(Request $request)
    {
        // 1. Query Dasar
        $query = InformationRequest::latest();

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

        // 5. Search by NIK, Name, or Ticket Number
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function($q) use ($keyword) {
                $q->where('nik', 'LIKE', "%{$keyword}%")
                  ->orWhere('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('ticket_number', 'LIKE', "%{$keyword}%");
            });
        }

        // 6. Ambil Data (Pakai Paginate)
        $requests = $query->paginate(10)->appends($request->all());

        return view('admin.requests.index', compact('requests'));
    }
    public function create()
    {
        return view('frontend.form-permohonan');
    }

    public function store(Request $request)
    {
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

        $ktpPath = $request->file('ktp_file')->store('ktp-uploads', 'public');

        $ticket = 'REQ-' . date('Y') . '-' . strtoupper(Str::random(5));

        $infoRequest = InformationRequest::create([
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
            'status'        => 'pending'
        ]);

        $adminUsers = User::whereIn('role', ['super', 'admin'])->get();

        $details = [
            'title'   => 'Permohonan Informasi Baru',
            'message' => 'Permohonan baru masuk dari ' . $request->name . ' (Tiket: ' . $ticket . ')',
            'url'     => route('admin.requests.show', $infoRequest->id),
            'type'    => 'request'
        ];

        Notification::send($adminUsers, new AdminNotification($details));

        return redirect()->route('requests.success', ['ticket' => $ticket]);
    }
    public function success($ticket)
    {
        return view('frontend.request-success', compact('ticket'));
    }
    public function print()
    {
        $requests = InformationRequest::get();
        $pdf = Pdf::loadView('admin.reports.requests_pdf', compact('requests'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-permohonan-informasi.pdf');
    }

    public function show($id)
    {
        $req = InformationRequest::findOrFail($id);


        $user = auth()->user();

        /** @var \App\Models\User $user */
        if ($user) {
            $user->unreadNotifications()
                ->where('data->url', route('admin.requests.show', $id))
                ->get()
                ->markAsRead();
        }

        return view('admin.requests.show', compact('req'));
    }

    public function update(Request $request, $id)
    {
        $req = InformationRequest::findOrFail($id);

        $request->validate([
            'status' => 'required',
            'admin_note' => 'nullable|string',
        ]);

        $data = [
            'status'     => $request->status,
            'admin_note' => $request->admin_note,
        ];

        if ($request->file('reply_file')) {
            $data['reply_file'] = $request->file('reply_file')->store('reply-files', 'public');
        }

        $req->update($data);

        return redirect()->route('admin.requests.index')->with('success', 'Permohonan berhasil diproses!');
    }

    public function track(Request $request)
    {
        $result = null;
        if ($request->has('ticket')) {
            $ticket = $request->input('ticket');

            // 1. Cek Tiket Permohonan (REQ-...)
            $result = InformationRequest::where('ticket_number', $ticket)->first();

            // 2. Jika tidak ketemu, Cek Tiket Keberatan (OBJ-...)
            if (!$result) {
                $objection = \App\Models\Objection::where('objection_code', $ticket)->first();
                if ($objection) {
                    $result = $objection->request; // Ambil Data Permohonan Induknya
                }
            }

            if (!$result) {
                return back()->with('error', 'Nomor Tiket (Permohonan/Keberatan) tidak ditemukan! Mohon periksa kembali.');
            }
        }
        return view('frontend.track', compact('result'));
    }
}
