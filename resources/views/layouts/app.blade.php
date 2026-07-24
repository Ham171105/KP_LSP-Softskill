<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Sertifikasi - LSP Softskill Indonesia Kompeten</title>
    <meta name="description" content="Sistem Pengelolaan dan Pencetakan Sertifikat BNSP - LSP Softskill Indonesia Kompeten">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}">
</head>
<body>
    @auth
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                <img src="{{ asset('images/logo-lsp.png') }}" alt="LSP Softskill Indonesia Kompeten" style="height: 52px; object-fit: contain;">
            </a>
            <div class="navbar-end">
                <a href="{{ route('tutorial') }}" class="btn btn-outline btn-sm" style="margin-right: 1rem; display: flex; align-items: center; gap: 0.35rem; color: var(--primary); border-color: rgba(99, 102, 241, 0.3); background: var(--primary-light);">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    Panduan Sistem
                </a>
                <div class="navbar-user">
                    <div class="navbar-user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <span>{{ Auth::user()->name }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline btn-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
    @endauth

    <main>
        @yield('content')
    </main>

    <script>
        // Auto-dismiss toast after 4s
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(t => {
                setTimeout(() => t.remove(), 4000);
            });
        });

        // Single shared modal logic
        function openEditModal(id, name, certNumber, issueDate, gender, blanko) {
            document.getElementById('edit-participant-name').value = name;
            document.getElementById('edit-certificate-number').value = certNumber;
            document.getElementById('edit-blanko-number').value = blanko;
            document.getElementById('edit-issue-date').value = issueDate;
            
            let genderInput = document.getElementById('edit-gender');
            if (genderInput) genderInput.value = gender || '';
            
            let blankoInput = document.getElementById('edit-blanko-number');
            if (blankoInput) blankoInput.value = blanko || '';

            document.getElementById('edit-form').action = '/certificates/' + id;
            document.getElementById('editModal').classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        // Close modal on overlay click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                e.target.classList.remove('active');
            }
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay.active').forEach(m => m.classList.remove('active'));
            }
        });
    </script>
</body>
</html>
