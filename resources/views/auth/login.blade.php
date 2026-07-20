@extends('layouts.app')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card animate-fade-in">
        <div style="text-align: center; margin-bottom: 2rem;">
            <img src="{{ asset('images/logo-lsp.png') }}" alt="LSP Softskill Indonesia Kompeten" style="height: 90px; object-fit: contain; margin-bottom: 1.25rem;">
            <h1 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); letter-spacing: -0.02em;">Selamat Datang</h1>
            <p style="color: var(--text-muted); font-size: 0.875rem; margin-top: 0.375rem;">Masuk ke Sistem Sertifikasi</p>
        </div>

        @if($errors->any())
            <div style="background: #FEF2F2; color: #991B1B; padding: 0.75rem 1rem; border-radius: var(--radius-lg); margin-bottom: 1.25rem; font-size: 0.8125rem; border: 1px solid #FECACA; display: flex; align-items: center; gap: 0.5rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="admin@lspsoftskill.com" value="{{ old('email') }}" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem; padding: 0.75rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Masuk ke Dashboard
            </button>
        </form>
    </div>
</div>
@endsection
