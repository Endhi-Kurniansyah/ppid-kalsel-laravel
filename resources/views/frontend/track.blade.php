@extends('layouts.frontend')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">Cek Status Permohonan</h2>
                <p class="text-muted">Masukkan Nomor Tiket Anda untuk melihat progress permohonan & keberatan.</p>
            </div>

            <div class="card shadow-sm border-0 mb-5">
                <div class="card-body p-4">
                    <form action="{{ route('requests.track') }}" method="GET">
                        <div class="input-group input-group-lg">
                            <input type="text" name="ticket" class="form-control" placeholder="Masukkan Nomor Tiket (Cth: REQ-2025-XXXX)" required value="{{ request('ticket') }}">
                            <button class="btn btn-primary px-4" type="submit">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                    </form>
                    @if(session('error'))
                        <div class="alert alert-danger mt-3 mb-0">
                            <i class="bi bi-exclamation-circle me-1"></i> {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>

            @if(isset($result))

                <div class="card border-0 shadow-lg mb-4 border-top border-5 {{ $result->status == 'finished' ? 'border-success' : ($result->status == 'rejected' ? 'border-danger' : 'border-warning') }}">
                    <div class="card-body p-5">

                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold text-primary">Permohonan Informasi</h5>
                                <small class="text-muted">Tiket: {{ $result->ticket_number }}</small>
                            </div>
                            @if($result->status == 'pending')
                                <span class="badge bg-warning text-dark">MENUNGGU</span>
                            @elseif($result->status == 'processed')
                                <span class="badge bg-info text-dark">DIPROSES</span>
                            @elseif($result->status == 'finished')
                                <span class="badge bg-success">SELESAI</span>
                            @elseif($result->status == 'rejected')
                                <span class="badge bg-danger">DITOLAK</span>
                            @endif
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <small class="fw-bold text-muted">Nama Pemohon</small>
                                <div class="fs-6">{{ $result->name }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="fw-bold text-muted">Tanggal Masuk</small>
                                <div class="fs-6">{{ $result->created_at->format('d M Y') }}</div>
                            </div>
                            <div class="col-12">
                                <small class="fw-bold text-muted">Informasi yang Diminta</small>
                                <div class="fs-6">{{ $result->details }}</div>
                            </div>
                        </div>

                        @if($result->admin_note)
                            <div class="alert alert-secondary mt-3">
                                <h6 class="fw-bold"><i class="bi bi-chat-left-text-fill me-2"></i> Jawaban Admin:</h6>
                                <p class="mb-0">{{ $result->admin_note }}</p>

                                @if($result->reply_file)
                                    <div class="mt-2 pt-2 border-top border-secondary">
                                        <a href="{{ asset('storage/' . $result->reply_file) }}" class="btn btn-sm btn-dark" target="_blank">
                                            <i class="bi bi-download me-1"></i> Download Lampiran
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif

                    </div>
                </div>

                @if($result->objection)
                    <div class="card border-0 shadow-lg mt-4 border-start border-5 border-danger">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Status Pengajuan Keberatan</h5>
                        </div>
                        <div class="card-body p-5">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <small class="text-muted d-block">Kode Keberatan:</small>
                                    <span class="fw-bold fs-5">{{ $result->objection->objection_code }}</span>
                                </div>

                                @if($result->objection->status == 'pending')
                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">MENUNGGU ATASAN PPID</span>
                                @elseif($result->objection->status == 'processed')
                                    <span class="badge bg-info text-dark fs-6 px-3 py-2">SEDANG DIPROSES</span>
                                @elseif($result->objection->status == 'finished')
                                    <span class="badge bg-success fs-6 px-3 py-2">KEBERATAN DITERIMA</span>
                                @elseif($result->objection->status == 'rejected')
                                    <span class="badge bg-danger fs-6 px-3 py-2">KEBERATAN DITOLAK</span>
                                @endif
                            </div>

                            <hr>

                            <div class="mb-3">
                                <small class="fw-bold text-muted">Alasan Anda:</small>
                                <p>{{ $result->objection->reason }}</p>
                            </div>

                            @if($result->objection->admin_note)
                                <div class="alert alert-light border border-danger">
                                    <h6 class="fw-bold text-danger"><i class="bi bi-gavel me-2"></i> Keputusan Atasan PPID:</h6>
                                    <p class="mb-0 text-dark">{{ $result->objection->admin_note }}</p>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="bi bi-clock-history me-2"></i> Pengajuan keberatan Anda sedang dipelajari oleh tim kami.
                                </div>
                            @endif

                        </div>
                    </div>
                @endif
                @endif

        </div>
    </div>
</div>
@endsection
