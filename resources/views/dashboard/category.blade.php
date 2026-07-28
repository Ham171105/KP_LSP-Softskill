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
    <div class="dashboard-header" style="display: flex; align-items: flex-start; gap: 1.25rem; margin-bottom: 2rem;">
        <a href="{{ route('dashboard') }}" class="btn btn-ghost" style="background: var(--surface); border: 1px solid var(--border); border-radius: 50%; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-sm); color: var(--text-main); flex-shrink: 0; padding: 0; transition: all var(--transition);" onmouseover="this.style.transform='translateX(-3px)'; this.style.borderColor='var(--primary)'; this.style.color='var(--primary)';" onmouseout="this.style.transform='none'; this.style.borderColor='var(--border)'; this.style.color='var(--text-main)';">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        </a>
        <div>
            <h1 class="dashboard-title" style="margin-bottom: 0.375rem; line-height: 1.2;">Sertifikasi {{ $category->name }}</h1>
            <p class="dashboard-subtitle" style="margin-top: 0;">Kelola dan cetak sertifikat untuk skema ini.</p>
        </div>
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
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="gender" class="form-control">
                        <option value="">Pilih (Opsional)</option>
                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>L (Laki-laki)</option>
                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>P (Perempuan)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">No. Sertifikat BNSP</label>
                    <input type="text" name="certificate_number" class="form-control" value="{{ old('certificate_number', $nextIds['certificate_number'] ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">No. Reg. SOF</label>
                    <input type="text" name="registration_number" class="form-control" value="{{ old('registration_number', $nextIds['registration_number'] ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Blanko</label>
                    <input type="text" name="blanko_number" class="form-control" placeholder="Opsional (Otomatis: {{ $nextBlankoNumber ?? '' }})" value="{{ old('blanko_number', $nextBlankoNumber ?? '') }}">
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
        <div class="glass-panel" style="display: flex; flex-direction: column; position: relative; overflow: hidden; padding: 1.75rem;">
            <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: linear-gradient(to bottom, var(--primary), #818CF8);"></div>
            
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                <div style="width: 36px; height: 36px; border-radius: var(--radius-md); background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                </div>
                <div>
                    <div class="section-label" style="margin-bottom: 0.125rem;">Panduan Singkat</div>
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin: 0;">Informasi Cetak Sertifikat</h3>
                </div>
            </div>

            <div style="background: var(--surface-hover); border-radius: var(--radius-lg); padding: 1rem; border: 1px solid var(--border); margin-bottom: 1.25rem;">
                <p style="font-size: 0.8125rem; color: var(--text-secondary); line-height: 1.6; margin: 0;">
                    Panduan ringkas fitur-fitur yang tersedia di halaman ini.
                </p>
            </div>

            <ul style="font-size: 0.8125rem; color: var(--text-secondary); padding-left: 0; line-height: 1.6; list-style: none; display: flex; flex-direction: column; gap: 0.875rem; margin-bottom: 1.5rem; max-height: 250px; overflow-y: auto; padding-right: 0.5rem;">
                <li style="display: flex; align-items: flex-start; gap: 0.75rem;">
                    <div style="background: var(--primary-light); color: var(--primary); width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; flex-shrink: 0;">1</div>
                    <span><strong>Input Data:</strong> Bisa manual via form di kiri, atau massal klik tombol <strong>Import</strong> Excel (sistem anti-duplikat aktif).</span>
                </li>
                <li style="display: flex; align-items: flex-start; gap: 0.75rem;">
                    <div style="background: var(--primary-light); color: var(--primary); width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; flex-shrink: 0;">2</div>
                    <span><strong>Penomoran Otomatis:</strong> No. BNSP & Registrasi selalu berurutan sesuai skema saat di-<em>generate</em>.</span>
                </li>
                <li style="display: flex; align-items: flex-start; gap: 0.75rem;">
                    <div style="background: var(--primary-light); color: var(--primary); width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; flex-shrink: 0;">3</div>
                    <span><strong>Cetak:</strong> Klik <span class="badge badge-primary" style="padding: 0.15rem 0.4rem;">Cetak Depan</span> atau <span class="badge badge-primary" style="padding: 0.15rem 0.4rem;">Belakang</span> di tabel untuk pratinjau.</span>
                </li>
                <li style="display: flex; align-items: flex-start; gap: 0.75rem;">
                    <div style="background: var(--primary-light); color: var(--primary); width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; flex-shrink: 0;">4</div>
                    <span><strong>Atur Tata Letak:</strong> Di halaman Cetak, terdapat <strong>Panel Editor</strong> untuk menggeser teks & mengatur ukuran font. Perubahan tersimpan permanen!</span>
                </li>
                <li style="display: flex; align-items: flex-start; gap: 0.75rem;">
                    <div style="background: var(--primary-light); color: var(--primary); width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; flex-shrink: 0;">5</div>
                    <span><strong>Kelola:</strong> Gunakan ikon pensil (Edit) atau tempat sampah (Hapus) pada tabel untuk merevisi data.</span>
                </li>
            </ul>

            <div class="info-box info" style="margin-top: auto; align-items: center;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="info-icon" style="margin-top: 0;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                <span style="font-size: 0.75rem;">Saat jendela Print (Ctrl+P) muncul, pastikan <strong>Scale = 100%</strong> dan matikan <strong>Headers & Footers</strong>.</span>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-wrapper" style="margin-bottom: 3rem;">
        <div class="table-header" style="flex-wrap: wrap; gap: 1rem;">
            <div class="table-title">
                Daftar Sertifikat
                <span class="badge badge-success">{{ $certificates->total() }} Total</span>
            </div>
            
            <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center; justify-content: flex-end; flex: 1;">
                <form method="GET" action="{{ route('dashboard.category', $category) }}" style="display: flex; gap: 0.5rem; align-items: center; background: var(--surface); padding: 0.375rem 0.5rem; border-radius: var(--radius-md); border: 1px solid var(--border); max-width: 400px; flex: 1;">
                    @if(isset($years) && count($years) > 0)
                    <div style="position: relative;">
                        <select name="year" class="form-control" style="appearance: none; padding-right: 1.5rem; border: none; background: var(--background); font-size: 0.8125rem; font-weight: 500; cursor: pointer; color: var(--text); padding-top: 0.25rem; padding-bottom: 0.25rem; min-height: unset; height: auto;" onchange="this.form.submit()">
                            <option value="">Semua Tahun</option>
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                        <svg style="position: absolute; right: 0.25rem; top: 50%; transform: translateY(-50%); pointer-events: none; color: var(--text-muted);" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </div>
                    <div style="width: 1px; height: 1.25rem; background: var(--border);"></div>
                    @endif
                    <div style="flex: 1; position: relative;">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data..." class="form-control" style="width: 100%; border: none; background: transparent; padding: 0.25rem 0.5rem; font-size: 0.8125rem; box-shadow: none; min-height: unset; height: auto;">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </button>
                    @if(request('search') || request('year'))
                        <a href="{{ route('dashboard.category', $category) }}" class="btn btn-outline btn-sm" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">Reset</a>
                    @endif
                </form>

                <div style="display: flex; gap: 0.5rem;">
                    <button type="button" onclick="document.getElementById('importModal').style.display='flex'" class="btn btn-outline btn-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                        Import
                    </button>
                    <a href="{{ route('certificates.export', array_merge(['category' => $category->id], request()->query())) }}" class="btn btn-outline btn-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5-5 5 5M12 15V3"/></svg>
                        Export
                    </a>
                </div>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>No. Sertifikat BNSP</th>
                        <th>No. Blanko</th>
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
                            @if($certificate->blanko_number)
                                <span class="badge badge-success" style="font-family: monospace; font-size: 0.75rem;">{{ $certificate->blanko_number }}</span>
                            @else
                                <span style="font-size: 0.75rem; color: var(--text-muted);">-</span>
                            @endif
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
                                <button type="button" onclick="openEditModal('{{ $certificate->id }}', '{{ addslashes($certificate->participant_name) }}', '{{ $certificate->certificate_number }}', '{{ $certificate->registration_number }}', '{{ \Carbon\Carbon::parse($certificate->issue_date)->format('Y-m-d') }}', '{{ $certificate->gender }}', '{{ $certificate->blanko_number }}')" class="action-btn edit" title="Edit">
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
                <label class="form-label">No. Reg. SOF</label>
                <input type="text" id="edit-registration-number" name="registration_number" class="form-control" required style="font-family: monospace;">
            </div>
            <div class="form-group">
                <label class="form-label">Jenis Kelamin</label>
                <select id="edit-gender" name="gender" class="form-control">
                    <option value="">Pilih (Opsional)</option>
                    <option value="L">L (Laki-laki)</option>
                    <option value="P">P (Perempuan)</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Nomor Blanko</label>
                <input type="text" id="edit-blanko-number" name="blanko_number" class="form-control" placeholder="Opsional" style="font-family: monospace;">
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

{{-- IMPORT MODAL --}}
<div id="importModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Import Excel</h3>
            <button type="button" onclick="document.getElementById('importModal').style.display='none'" class="btn-ghost btn-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('certificates.import', $category) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Pilih File Excel (.xlsx)</label>
                <input type="file" name="excel_file" class="form-control" accept=".xlsx, .xls" required style="padding: 10px;">
                <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.5rem;">
                    Format kolom harus sesuai: No, NAMA ASESI, JENIS KELAMIN (L/P), NOMOR BLANKO, NO. REG. SOF, SKEMA, TANGGAL ASESMEN
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="document.getElementById('importModal').style.display='none'" class="btn btn-outline">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                    Import Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
