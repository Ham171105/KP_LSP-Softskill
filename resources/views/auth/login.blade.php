@extends('layouts.app')

@section('content')
<div class="auth-wrapper">
    <div class="glass-panel animate-fade-in" style="width: 100%; max-width: 420px; position: relative; z-index: 10;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem;"><path d="M12 15l8.38-4.19a2 2 0 0 0 1.1-1.61L22 4l-5.19 1.1a2 2 0 0 0-1.61 1.1L11 14.62"/><path d="m14 12-4-4"/><path d="m8 18-5.5 3 2.5-5.5"/></svg>
            <h1 style="font-size: 1.75rem; font-weight: 700; color: var(--text-main);">Admin Login</h1>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 0.5rem;">Sistem Sertifikasi LSP Soft Skill</p>
        </div>

        @if($errors->any())
            <div style="background: #FEE2E2; color: #B91C1C; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.5rem; font-size: 0.9rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="admin@lspsoftskill.com" value="{{ old('email') }}" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem; padding: 0.85rem;">Sign In to Dashboard</button>
        </form>
    </div>
</div>
@endsection
