@extends('layouts.app')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card animate-fade-in" style="padding: 3rem 2.5rem;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <img src="{{ asset('images/logo-lsp.png') }}" alt="LSP Softskill Indonesia Kompeten" style="height: 60px; transform: scale(3.5); object-fit: contain; margin-bottom: 2.5rem;">
            <h1 style="font-size: 1.75rem; font-weight: 800; color: var(--text-main); letter-spacing: -0.03em; margin: 0;">Selamat Datang</h1>
        </div>

        @if($errors->any())
            <div style="background: var(--danger-light); color: var(--danger); padding: 0.875rem 1rem; border-radius: var(--radius-lg); margin-bottom: 1.5rem; font-size: 0.8125rem; border: 1px solid rgba(239, 68, 68, 0.2); display: flex; align-items: center; gap: 0.75rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink: 0;"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                <span style="font-weight: 500;">{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 1.25rem;">
            @csrf
            <div>
                <label for="email" class="form-label">Alamat Email</label>
                <div style="position: relative;">
                    <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    </div>
                    <input type="email" id="email" name="email" class="form-control" placeholder="admin@lspsoftskill.com" value="{{ old('email') }}" required autofocus style="padding-left: 3rem; background: rgba(255, 255, 255, 0.7); border-color: rgba(0,0,0,0.1);">
                </div>
            </div>
            
            <div>
                <label for="password" class="form-label" style="display: flex; justify-content: space-between; align-items: center;">
                    Kata Sandi
                </label>
                <div style="position: relative;">
                    <div style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    </div>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required style="padding-left: 3rem; background: rgba(255, 255, 255, 0.7); border-color: rgba(0,0,0,0.1);">
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem; padding: 0.875rem; font-size: 0.9375rem; font-weight: 600; box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);">
                Masuk ke Dashboard
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 0.25rem;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </button>
        </form>
        
        <div style="text-align: center; margin-top: 2rem;">
            <p style="font-size: 0.75rem; color: var(--text-muted);">
                &copy; {{ date('Y') }} LSP Softskill Indonesia Kompeten.<br>All rights reserved.
            </p>
        </div>
    </div>
</div>
@endsection
