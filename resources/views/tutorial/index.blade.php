@extends('layouts.app')

@section('content')
<div class="container animate-fade-in" style="max-width: 1000px; padding-bottom: 4rem;">
    <div class="dashboard-header" style="position: relative; text-align: center; margin-bottom: 3rem; margin-top: 1rem;">
        <a href="{{ route('dashboard') }}" class="btn btn-ghost" style="position: absolute; left: 0; top: 0; background: var(--surface); border: 1px solid var(--border); border-radius: 50%; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-sm); color: var(--text-main); padding: 0; transition: all var(--transition);" onmouseover="this.style.transform='translateX(-3px)'; this.style.borderColor='var(--primary)'; this.style.color='var(--primary)';" onmouseout="this.style.transform='none'; this.style.borderColor='var(--border)'; this.style.color='var(--text-main)';">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        </a>
        <div style="display: inline-flex; justify-content: center; align-items: center; width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-light), var(--primary-glow)); color: var(--primary); margin-bottom: 1.5rem;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
        </div>
        <h1 class="dashboard-title" style="font-size: 2.5rem;">Panduan Penggunaan Sistem</h1>
        <p class="dashboard-subtitle" style="font-size: 1.1rem; max-width: 600px; margin: 0.5rem auto 0;">Pelajari cara mengelola dan mencetak sertifikat dengan mudah menggunakan sistem ini.</p>
    </div>

    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Section 1 -->
        <div class="glass-panel" style="position: relative; overflow: hidden; padding: 2.5rem;">
            <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: linear-gradient(to bottom, var(--primary), #818CF8);"></div>
            <div style="display: flex; gap: 2rem; align-items: flex-start;">
                <div style="width: 48px; height: 48px; border-radius: var(--radius-lg); background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: 700; font-size: 1.25rem;">1</div>
                <div>
                    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: var(--text-main);">Memilih Bidang Sertifikasi</h2>
                    <p style="color: var(--text-secondary); margin-bottom: 1.5rem; line-height: 1.7;">
                        Langkah pertama adalah memilih kategori atau bidang sertifikasi dari <strong>Dashboard</strong>. 
                        Terdapat tiga bidang utama yang dapat Anda pilih:
                    </p>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                        <li style="display: flex; align-items: center; gap: 0.75rem;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            <span><strong>KPM</strong> - Kompetensi Penyuluh Pertanian</span>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.75rem;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            <span><strong>KOM</strong> - Bidang Komunikasi</span>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.75rem;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--warning)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            <span><strong>MET</strong> - Bidang Metodologi</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Section 2 -->
        <div class="glass-panel" style="position: relative; overflow: hidden; padding: 2.5rem;">
            <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: linear-gradient(to bottom, var(--success), #34D399);"></div>
            <div style="display: flex; gap: 2rem; align-items: flex-start;">
                <div style="width: 48px; height: 48px; border-radius: var(--radius-lg); background: var(--success-light); color: var(--success); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: 700; font-size: 1.25rem;">2</div>
                <div>
                    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: var(--text-main);">Mengelola Data Sertifikat</h2>
                    <p style="color: var(--text-secondary); margin-bottom: 1.5rem; line-height: 1.7;">
                        Setelah memilih bidang, Anda akan masuk ke halaman pengelolaan. Di sini Anda dapat melakukan berbagai operasi data:
                    </p>
                    <div class="grid grid-cols-2" style="gap: 1.5rem;">
                        <div style="background: var(--surface-hover); padding: 1.5rem; border-radius: var(--radius-xl); border: 1px solid var(--border);">
                            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                                <div style="background: white; padding: 0.5rem; border-radius: var(--radius-md); box-shadow: var(--shadow-sm);"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></div>
                                <h3 style="font-weight: 600; font-size: 1.05rem;">Tambah Data</h3>
                            </div>
                            <p style="font-size: 0.85rem; color: var(--text-muted);">Gunakan form di bagian atas tabel untuk menambahkan sertifikat baru satu per satu.</p>
                        </div>
                        <div style="background: var(--surface-hover); padding: 1.5rem; border-radius: var(--radius-xl); border: 1px solid var(--border);">
                            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                                <div style="background: white; padding: 0.5rem; border-radius: var(--radius-md); box-shadow: var(--shadow-sm);"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg></div>
                                <h3 style="font-weight: 600; font-size: 1.05rem;">Import Excel</h3>
                            </div>
                            <p style="font-size: 0.85rem; color: var(--text-muted);">Klik tombol <strong>"Import"</strong> untuk memasukkan banyak data sekaligus menggunakan template Excel (.xlsx).</p>
                        </div>
                        <div style="background: var(--surface-hover); padding: 1.5rem; border-radius: var(--radius-xl); border: 1px solid var(--border);">
                            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                                <div style="background: white; padding: 0.5rem; border-radius: var(--radius-md); box-shadow: var(--shadow-sm);"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-warning"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></div>
                                <h3 style="font-weight: 600; font-size: 1.05rem;">Ubah & Hapus</h3>
                            </div>
                            <p style="font-size: 0.85rem; color: var(--text-muted);">Gunakan tombol <strong>Ubah</strong> (kuning) atau <strong>Hapus</strong> (merah) di baris tabel setiap peserta.</p>
                        </div>
                        <div style="background: var(--surface-hover); padding: 1.5rem; border-radius: var(--radius-xl); border: 1px solid var(--border);">
                            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                                <div style="background: white; padding: 0.5rem; border-radius: var(--radius-md); box-shadow: var(--shadow-sm);"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-success"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></div>
                                <h3 style="font-weight: 600; font-size: 1.05rem;">Export Data</h3>
                            </div>
                            <p style="font-size: 0.85rem; color: var(--text-muted);">Klik <strong>"Export Excel"</strong> untuk mengunduh seluruh data sertifikat pada bidang tersebut.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3 -->
        <div class="glass-panel" style="position: relative; overflow: hidden; padding: 2.5rem;">
            <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: linear-gradient(to bottom, var(--accent), #FBBF24);"></div>
            <div style="display: flex; gap: 2rem; align-items: flex-start;">
                <div style="width: 48px; height: 48px; border-radius: var(--radius-lg); background: var(--warning-light); color: var(--warning); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: 700; font-size: 1.25rem;">3</div>
                <div>
                    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: var(--text-main);">Mencetak Sertifikat</h2>
                    <p style="color: var(--text-secondary); margin-bottom: 1.5rem; line-height: 1.7;">
                        Sistem mendukung pencetakan sertifikat bagian depan (berisi nama dan nomor sertifikat) dan bagian belakang (berisi daftar unit kompetensi).
                    </p>
                    
                    <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem;">
                        <span class="action-btn print" style="pointer-events: none;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                            Depan
                        </span>
                        <p style="margin: 0; font-size: 0.9rem; color: var(--text-secondary);">Mencetak halaman depan sertifikat (Template Khusus KPM, KOM, atau MET).</p>
                    </div>
                    
                    <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1.5rem;">
                        <span class="action-btn print" style="pointer-events: none;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                            Belakang
                        </span>
                        <p style="margin: 0; font-size: 0.9rem; color: var(--text-secondary);">Mencetak halaman belakang berisi tabel unit kompetensi dari masing-masing bidang.</p>
                    </div>

                    <div class="info-box info">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="info-icon"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        <div>
                            <strong>Tips Mencetak:</strong><br>
                            Saat kotak dialog print (Ctrl+P) terbuka, pastikan <strong>"Background graphics"</strong> (grafis latar belakang) dicentang dan margin diatur ke <strong>"None"</strong> (tidak ada) agar desain sertifikat tercetak penuh tanpa terpotong.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Info -->
        <div style="text-align: center; margin-top: 1rem; padding-top: 2rem; border-top: 1px solid var(--border);">
            <p style="color: var(--text-muted); font-size: 0.9rem;">
                Mengalami kendala teknis? Silakan hubungi Administrator Sistem (LSP Softskill Indonesia Kompeten).
            </p>
        </div>
    </div>
</div>
@endsection
