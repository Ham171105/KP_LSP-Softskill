@extends('layouts.app')

@section('content')
<div class="container animate-fade-in">
    {{-- Toast Notifications --}}
    @if(session('success'))
        <div class="toast toast-success">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="toast toast-error">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="dashboard-header">
        <a href="{{ route('dashboard') }}" class="back-link">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali ke Dashboard
        </a>
        <h1 class="dashboard-title">Sertifikasi {{ $category->name }}</h1>
        <p class="dashboard-subtitle">Kelola dan cetak sertifikat untuk skema ini.</p>
    </div>

    {{-- Top Grid: Form + Info --}}
    <div class="grid" style="grid-template-columns: 380px 1fr; align-items: start; margin-bottom: 2rem;">
        
        {{-- Form Buat Sertifikat --}}
        <div class="glass-panel">
            <div class="section-label">Buat Baru</div>
            <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 1.25rem;">Tambah Sertifikat</h3>
            
            @if($errors->any())
                <div style="background: #FEF2F2; color: #991B1B; padding: 0.75rem 1rem; border-radius: var(--radius-lg); margin-bottom: 1rem; font-size: 0.8125rem; border: 1px solid #FECACA;">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('certificates.store', $category) }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Peserta</label>
                    <input type="text" name="participant_name" class="form-control" required placeholder="Cth: Ilham huda" value="{{ old('participant_name') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Terbit</label>
                    <input type="date" name="issue_date" class="form-control" value="{{ old('issue_date', date('Y-m-d')) }}" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                    Generate & Simpan
                </button>
            </form>
        </div>

        {{-- Info Panel --}}
        <div class="glass-panel" style="display: flex; flex-direction: column; gap: 1.25rem;">
            <div>
                <div class="section-label">Panduan</div>
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 0.75rem;">Informasi Cetak Sertifikat</h3>
                <p style="font-size: 0.8125rem; color: var(--text-muted); line-height: 1.7; margin-bottom: 0.75rem;">
                    Sistem ini dikonfigurasi untuk mencetak sertifikat langsung di atas <strong style="color: var(--text-secondary);">Kertas Blangko BNSP</strong>.
                </p>
            </div>
            <ul style="font-size: 0.8125rem; color: var(--text-muted); padding-left: 0; line-height: 1.8; list-style: none;">
                <li style="display: flex; align-items: flex-start; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <span style="color: var(--primary); font-weight: 700;">①</span>
                    Penomoran BNSP & No. Registrasi <strong style="color: var(--text-secondary);">otomatis berurutan</strong> sesuai skema {{ $category->name }}.
                </li>
                <li style="display: flex; align-items: flex-start; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <span style="color: var(--primary); font-weight: 700;">②</span>
                    Klik <strong style="color: var(--text-secondary);">Cetak Depan</strong> untuk sisi identitas peserta.
                </li>
                <li style="display: flex; align-items: flex-start; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <span style="color: var(--primary); font-weight: 700;">③</span>
                    Klik <strong style="color: var(--text-secondary);">Cetak Belakang</strong> untuk sisi tabel unit kompetensi.
                </li>
            </ul>
            <div class="info-box info">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="info-icon"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                <span>Saat jendela Print muncul, pastikan <strong>Scale = 100%</strong> dan matikan <strong>Headers & Footers</strong> agar presisi dengan kertas fisik.</span>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-wrapper" style="margin-bottom: 3rem;">
        <div class="table-header">
            <div class="table-title">
                Daftar Sertifikat
                <span class="badge badge-success">{{ $certificates->total() }} Total</span>
            </div>
            
            <form method="GET" action="{{ route('dashboard.category', $category) }}" class="search-bar" style="display: flex; gap: 0.5rem; align-items: center;">
                @if(isset($years) && count($years) > 0)
                <select name="year" class="form-control" style="width: auto; min-width: 130px; padding: 0.375rem 0.75rem; border-radius: var(--radius-md);" onchange="this.form.submit()">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                    @endforeach
                </select>
                @endif
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau nomor..." class="form-control">
                <button type="submit" class="btn btn-primary btn-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Cari
                </button>
                @if(request('search') || request('year'))
                    <a href="{{ route('dashboard.category', $category) }}" class="btn btn-outline btn-sm">Reset</a>
                @endif
            </form>
        </div>

        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>No. Sertifikat BNSP</th>
                        <th>Nama Peserta</th>
                        <th>Tgl Terbit</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($certificates as $certificate)
                    <tr>
                        <td>
                            <span style="font-weight: 600; color: var(--primary); font-family: monospace; font-size: 0.8125rem; letter-spacing: 0.02em;">
                                {{ $certificate->certificate_number }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: 500;">{{ $certificate->participant_name }}</div>
                            @if($certificate->registration_number)
                                <div style="font-size: 0.6875rem; color: var(--text-muted); margin-top: 0.125rem; font-family: monospace;">Reg: {{ $certificate->registration_number }}</div>
                            @endif
                        </td>
                        <td>
                            <span style="font-size: 0.8125rem;">{{ \Carbon\Carbon::parse($certificate->issue_date)->format('d M Y') }}</span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('certificates.print.front', $certificate) }}" target="_blank" class="action-btn print">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 14h12v8H6z"/></svg>
                                    Depan
                                </a>
                                <a href="{{ route('certificates.print.back', $certificate) }}" target="_blank" class="action-btn print">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 14h12v8H6z"/></svg>
                                    Belakang
                                </a>
                                <button type="button" onclick="openEditModal('{{ $certificate->id }}', '{{ addslashes($certificate->participant_name) }}', '{{ $certificate->certificate_number }}', '{{ \Carbon\Carbon::parse($certificate->issue_date)->format('Y-m-d') }}')" class="action-btn edit" title="Edit">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                </button>
                                <form method="POST" action="{{ route('certificates.destroy', $certificate) }}" onsubmit="return confirm('Yakin ingin menghapus sertifikat ini?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" title="Hapus">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                                <p>Belum ada sertifikat diterbitkan untuk kategori ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($certificates->hasPages())
        <div style="padding: 1rem 1.5rem; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 0.8125rem; color: var(--text-muted);">
                Menampilkan {{ $certificates->firstItem() }}–{{ $certificates->lastItem() }} dari {{ $certificates->total() }} sertifikat
            </span>
            <div style="display: flex; gap: 0.375rem;">
                @if($certificates->onFirstPage())
                    <span class="btn btn-outline btn-sm" style="opacity: 0.4; pointer-events: none;">← Sebelumnya</span>
                @else
                    <a href="{{ $certificates->previousPageUrl() }}" class="btn btn-outline btn-sm">← Sebelumnya</a>
                @endif
                
                @foreach($certificates->getUrlRange(max(1, $certificates->currentPage()-2), min($certificates->lastPage(), $certificates->currentPage()+2)) as $page => $url)
                    @if($page == $certificates->currentPage())
                        <span class="btn btn-primary btn-sm">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="btn btn-outline btn-sm">{{ $page }}</a>
                    @endif
                @endforeach

                @if($certificates->hasMorePages())
                    <a href="{{ $certificates->nextPageUrl() }}" class="btn btn-outline btn-sm">Selanjutnya →</a>
                @else
                    <span class="btn btn-outline btn-sm" style="opacity: 0.4; pointer-events: none;">Selanjutnya →</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- SINGLE SHARED EDIT MODAL (outside table, always at viewport center) --}}
<div id="editModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Edit Sertifikat</h3>
            <button type="button" onclick="closeModal('editModal')" class="btn-ghost btn-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="edit-form" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Nama Peserta</label>
                <input type="text" id="edit-participant-name" name="participant_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">No. Sertifikat BNSP</label>
                <input type="text" id="edit-certificate-number" name="certificate_number" class="form-control" required style="font-family: monospace;">
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Terbit</label>
                <input type="date" id="edit-issue-date" name="issue_date" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('editModal')" class="btn btn-outline">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
