@extends('layouts.app')

@section('content')
<div class="container animate-fade-in">
    <div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <a href="{{ route('dashboard') }}" style="color: var(--primary); font-size: 0.9rem; margin-bottom: 1rem; display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 500;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Kembali ke Dashboard
            </a>
            <h1 class="dashboard-title" style="margin-top: 0.5rem;">Sertifikasi {{ $category->name }}</h1>
            <p class="dashboard-subtitle">Kelola dan cetak sertifikat untuk bidang ini.</p>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #D1FAE5; color: #065F46; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 2rem;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #FEE2E2; color: #991B1B; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 2rem;">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background: #FEE2E2; color: #991B1B; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 2rem;">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid" style="grid-template-columns: 1fr 2fr; align-items: start; margin-bottom: 2rem;">
        <!-- Form Tambah Sertifikat -->
        <div class="glass-panel" style="padding: 2rem;">
            <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem;">Buat Sertifikat Baru</h3>
            <form method="POST" action="{{ route('certificates.store', $category) }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Peserta</label>
                    <input type="text" name="participant_name" class="form-control" required placeholder="Cth: Budi Santoso">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email (Opsional)</label>
                    <input type="email" name="participant_email" class="form-control" placeholder="budi@email.com">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Tanggal Terbit</label>
                    <input type="date" name="issue_date" class="form-control" required value="{{ date('Y-m-d') }}">
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 0.5rem;"><path d="M12 5v14M5 12h14"/></svg>
                    Generate & Simpan
                </button>
            </form>
        </div>

        <!-- Informasi Cetak -->
        <div class="glass-panel" style="padding: 1.5rem; display: flex; flex-direction: column;">
            <h3 style="font-size: 1.15rem; font-weight: 600; margin-bottom: 1rem;">Informasi Cetak Sertifikat</h3>
            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem; line-height: 1.6;">
                Sistem ini telah dikonfigurasi untuk mencetak sertifikat langsung di atas <strong>Kertas Blangko BNSP</strong>.
            </p>
            <ul style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.5rem; padding-left: 1.5rem; line-height: 1.6;">
                <li>Sistem penomoran BNSP dan No Registrasi akan <strong>di-generate otomatis</strong> (urut) sesuai dengan standar SKEMA {{ $category->name }}.</li>
                <li>Klik tombol <strong>Cetak Depan</strong> untuk mencetak sisi identitas peserta.</li>
                <li>Klik tombol <strong>Cetak Belakang</strong> untuk mencetak sisi tabel unit kompetensi.</li>
            </ul>
            <div style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); padding: 1rem; border-radius: var(--radius-md);">
                <p style="font-size: 0.8rem; color: #1d4ed8; margin: 0; font-weight: 500;">
                    💡 Tips: Saat jendela *Print* muncul, pastikan pengaturan <strong>Scale</strong> berada pada <strong>Default (100%)</strong> dan matikan opsi <strong>Headers and footers</strong> agar presisi dengan kertas fisik Anda.
                </p>
            </div>
        </div>
    </div>

    <!-- Tabel Data Sertifikat -->
    <div class="table-container" style="margin-bottom: 4rem;">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 1.15rem; font-weight: 600;">Daftar Sertifikat Diterbitkan</h3>
            <span class="badge badge-active">{{ $certificates->count() }} Total</span>
        </div>
        
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>No. Sertifikat</th>
                        <th>Nama Peserta</th>
                        <th>Tgl Terbit</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($certificates as $cert)
                    <tr>
                        <td style="font-weight: 500; color: var(--primary);">{{ $cert->certificate_number }}</td>
                        <td>
                            <div>{{ $cert->participant_name }}</div>
                            @if($cert->participant_email)
                                <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $cert->participant_email }}</div>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($cert->issue_date)->format('d M Y') }}</td>
                        <td style="text-align: right;">
                            <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                        <a href="{{ route('certificates.print.front', $cert) }}" target="_blank" class="btn btn-outline" style="padding: 0.25rem 0.5rem; font-size: 0.75rem; display: inline-flex; gap: 0.25rem;">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 14h12v8H6z"/></svg>
                                            Cetak Depan
                                        </a>
                                        <a href="{{ route('certificates.print.back', $cert) }}" target="_blank" class="btn btn-outline" style="padding: 0.25rem 0.5rem; font-size: 0.75rem; display: inline-flex; gap: 0.25rem;">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 14h12v8H6z"/></svg>
                                            Cetak Belakang
                                        </a>
                                    </div>
                                <form method="POST" action="{{ route('certificates.destroy', $cert) }}" onsubmit="return confirm('Yakin ingin menghapus sertifikat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.75rem; font-size: 0.8rem;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 3rem 1rem; color: var(--text-muted);">
                            Belum ada sertifikat diterbitkan untuk kategori ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
