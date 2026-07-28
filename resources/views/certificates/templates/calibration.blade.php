<div class="calibration-ui" id="calibrationUI">
    <div style="margin-bottom: 5px; font-size: 12px; color: #555;">Editor Tata Letak (Hanya tampil di layar)</div>
    <div style="display: flex; gap: 8px;">
        <button type="button" onclick="toggleCalibration()" id="calib-btn" class="c-btn c-btn-primary">Edit Bebas</button>
        <button type="button" onclick="saveCalibration()" id="save-btn" class="c-btn c-btn-success" style="display:none">Simpan Permanen</button>
        <button type="button" onclick="resetCalibration()" id="reset-btn" class="c-btn c-btn-danger" style="display:none">Reset</button>
        <button type="button" onclick="exportCalibration()" id="export-btn" class="c-btn c-btn-warning" style="display:none; background: #D97706;">Ambil Kode Tata Letak</button>
    </div>
    <div id="calib-hint" style="display:none; margin-top: 8px; font-size: 11px; color: #d97706; max-width: 250px;">
        Geser kotak biru untuk pindah posisi. <b>Klik teksnya</b> untuk mengatur ukuran, lebar, dan perataan layaknya Word.
    </div>
</div>

<div id="float-toolbar" class="floating-toolbar" style="display:none;">
    <div class="tb-group">
        <span class="tb-label">Teks:</span>
        <button type="button" onclick="changeStyle('fontSize', -1)" title="Perkecil Text">A-</button>
        <button type="button" onclick="changeStyle('fontSize', 1)" title="Perbesar Text">A+</button>
    </div>
    <div class="tb-group">
        <span class="tb-label">Lebar Kotak:</span>
        <button type="button" onclick="changeStyle('width', -10)" title="Persempit">-</button>
        <button type="button" onclick="changeStyle('width', 10)" title="Perlebar">+</button>
    </div>
    <div class="tb-group">
        <span class="tb-label">Rata:</span>
        <button type="button" onclick="changeAlign('left')">Kiri</button>
        <button type="button" onclick="changeAlign('center')">Tengah</button>
        <button type="button" onclick="changeAlign('right')">Kanan</button>
    </div>
    <div class="tb-group">
        <span class="tb-label">Geser:</span>
        <button type="button" onclick="nudge('top', -1)" title="Ke Atas">↑</button>
        <button type="button" onclick="nudge('top', 1)" title="Ke Bawah">↓</button>
        <button type="button" onclick="nudge('left', -1)" title="Ke Kiri">←</button>
        <button type="button" onclick="nudge('left', 1)" title="Ke Kanan">→</button>
    </div>
</div>

<style>
    .calibration-ui {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 10000;
        background: #fff;
        padding: 12px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        font-family: sans-serif;
        border: 1px solid #e5e7eb;
    }
    .c-btn {
        padding: 6px 12px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
        color: white;
    }
    .c-btn-primary { background: #4F46E5; }
    .c-btn-success { background: #10B981; }
    .c-btn-danger { background: #EF4444; }
    
    .draggable.edit-mode {
        border: 1px dashed #4F46E5 !important;
        background: rgba(79, 70, 229, 0.05) !important;
        cursor: move !important;
        user-select: none;
        z-index: 50;
    }
    
    .draggable.active-edit {
        border: 2px solid #10B981 !important;
        background: rgba(16, 185, 129, 0.1) !important;
        z-index: 55;
    }

    .floating-toolbar {
        position: fixed;
        background: #1F2937;
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        z-index: 10001;
        display: flex;
        gap: 12px;
        font-family: sans-serif;
        font-size: 12px;
        align-items: center;
    }
    .tb-group {
        display: flex;
        align-items: center;
        gap: 4px;
        border-right: 1px solid #374151;
        padding-right: 12px;
    }
    .tb-group:last-child { border-right: none; padding-right: 0; }
    .tb-label { color: #9CA3AF; margin-right: 2px; }
    .floating-toolbar button {
        background: #374151;
        color: white;
        border: none;
        border-radius: 3px;
        padding: 4px 8px;
        cursor: pointer;
        font-size: 12px;
    }
    .floating-toolbar button:hover { background: #4B5563; }
    
    @media print {
        .calibration-ui, .floating-toolbar { display: none !important; }
        .page { background-image: none !important; }
        .draggable { border: none !important; background: transparent !important; }
    }
</style>

<script>
    let isEditMode = false;
    let draggedElement = null;
    let activeElement = null;
    let startX, startY, initialTop, initialLeft;
    let isDraggingAction = false;

    // Use URL path to generate a unique prefix for this template
    const templateId = window.location.pathname.split('/').pop();
    
    function loadCalibration() {
        document.querySelectorAll('.draggable').forEach(el => {
            if (!el.id) return;
            const saved = localStorage.getItem('calib_' + templateId + '_' + el.id);
            if (saved) {
                const pos = JSON.parse(saved);
                if(pos.top) el.style.top = pos.top;
                if(pos.left) el.style.left = pos.left;
                if(pos.fontSize) el.style.fontSize = pos.fontSize;
                if(pos.width) el.style.width = pos.width;
                if(pos.textAlign) el.style.textAlign = pos.textAlign;
                
                if (window.getComputedStyle(el).position === 'static') {
                    el.style.position = 'relative';
                }
            }
        });
    }

    function toggleCalibration() {
        isEditMode = !isEditMode;
        document.getElementById('calib-btn').innerText = isEditMode ? 'Batal' : 'Edit Bebas';
        document.getElementById('calib-btn').style.background = isEditMode ? '#6B7280' : '#4F46E5';
        document.getElementById('save-btn').style.display = isEditMode ? 'block' : 'none';
        document.getElementById('reset-btn').style.display = isEditMode ? 'block' : 'none';
        document.getElementById('export-btn').style.display = isEditMode ? 'block' : 'none';
        document.getElementById('calib-hint').style.display = isEditMode ? 'block' : 'none';
        
        if (!isEditMode) hideToolbar();
        
        document.querySelectorAll('.draggable').forEach(el => {
            if (isEditMode) {
                el.classList.add('edit-mode');
            } else {
                el.classList.remove('edit-mode');
                el.classList.remove('active-edit');
                loadCalibration(); // Restore if cancelled
            }
        });
    }

    function saveCalibration() {
        document.querySelectorAll('.draggable').forEach(el => {
            if (!el.id) return;
            localStorage.setItem('calib_' + templateId + '_' + el.id, JSON.stringify({
                top: el.style.top,
                left: el.style.left,
                fontSize: el.style.fontSize,
                width: el.style.width,
                textAlign: el.style.textAlign
            }));
        });
        alert('Desain dan Tata Letak berhasil disimpan secara permanen di komputer ini!');
        toggleCalibration();
    }

    function resetCalibration() {
        if(confirm('Hapus semua editan dan kembalikan posisi ke setelan pabrik?')) {
            document.querySelectorAll('.draggable').forEach(el => {
                if (!el.id) return;
                localStorage.removeItem('calib_' + templateId + '_' + el.id);
                el.style.top = '';
                el.style.left = '';
                el.style.fontSize = '';
                el.style.width = '';
                el.style.textAlign = '';
            });
            window.location.reload();
        }
    }

    function exportCalibration() {
        let exportData = {};
        document.querySelectorAll('.draggable').forEach(el => {
            if (!el.id) return;
            let data = localStorage.getItem('calib_' + templateId + '_' + el.id);
            if (data) {
                exportData[el.id] = JSON.parse(data);
            }
        });
        
        let jsonStr = JSON.stringify(exportData, null, 2);
        
        // Copy to clipboard
        navigator.clipboard.writeText(jsonStr).then(() => {
            alert('Berhasil disalin! Silakan Paste (Ctrl+V) kode ini di obrolan dengan AI.');
        }).catch(err => {
            alert('Gagal menyalin otomatis. Silakan copy teks berikut ini:\n\n' + jsonStr);
        });
    }

    // Advanced Toolbar Functions
    function showToolbar(el) {
        if(activeElement) activeElement.classList.remove('active-edit');
        activeElement = el;
        activeElement.classList.add('active-edit');
        
        const tb = document.getElementById('float-toolbar');
        tb.style.display = 'flex';
        
        const rect = el.getBoundingClientRect();
        let topPos = rect.top - 50;
        if(topPos < 10) topPos = rect.bottom + 10;
        
        tb.style.top = topPos + 'px';
        tb.style.left = Math.max(10, rect.left) + 'px';
    }

    function hideToolbar() {
        if(activeElement) activeElement.classList.remove('active-edit');
        activeElement = null;
        document.getElementById('float-toolbar').style.display = 'none';
    }

    function changeStyle(property, amount) {
        if (!activeElement) return;
        const style = window.getComputedStyle(activeElement);
        let currentVal = parseFloat(style[property]);
        
        if (isNaN(currentVal)) {
            if(property === 'fontSize') currentVal = 16; 
            if(property === 'width') currentVal = activeElement.offsetWidth;
        }
        
        activeElement.style[property] = (currentVal + amount) + 'px';
        showToolbar(activeElement); // Re-position toolbar if size changed
    }

    function changeAlign(alignment) {
        if (!activeElement) return;
        activeElement.style.textAlign = alignment;
    }

    function nudge(property, amount) {
        if (!activeElement) return;
        const style = window.getComputedStyle(activeElement);
        let currentVal = parseFloat(style[property]);
        if (isNaN(currentVal)) {
            currentVal = property === 'top' || property === 'left' ? 0 : 0;
        }
        activeElement.style[property] = (currentVal + amount) + 'px';
        showToolbar(activeElement);
    }

    // Drag Logic
    document.addEventListener('mousedown', function(e) {
        if (!isEditMode) return;
        
        if (e.target.closest('#float-toolbar') || e.target.closest('#calibrationUI')) return;

        const target = e.target.closest('.draggable');
        if (!target) {
            hideToolbar();
            return;
        }
        
        isDraggingAction = false;
        draggedElement = target;
        
        startX = e.clientX;
        startY = e.clientY;
        
        const style = window.getComputedStyle(target);
        initialLeft = style.left === 'auto' ? 0 : parseFloat(style.left);
        initialTop = style.top === 'auto' ? 0 : parseFloat(style.top);
        
        e.preventDefault(); 
    });

    document.addEventListener('mousemove', function(e) {
        if (!draggedElement) return;
        
        const dx = e.clientX - startX;
        const dy = e.clientY - startY;
        
        if (Math.abs(dx) > 3 || Math.abs(dy) > 3) {
            isDraggingAction = true;
            draggedElement.style.left = (initialLeft + dx) + 'px';
            draggedElement.style.top = (initialTop + dy) + 'px';
            if (activeElement === draggedElement) {
                hideToolbar(); // Hide toolbar while dragging to prevent stutter
            }
        }
    });

    document.addEventListener('mouseup', function(e) {
        if (draggedElement) {
            if (!isDraggingAction) {
                // Was just a click, show toolbar
                showToolbar(draggedElement);
            } else {
                // Finished dragging, show toolbar at new position
                showToolbar(draggedElement);
            }
        }
        draggedElement = null;
        isDraggingAction = false;
    });

    // Run on load
    document.addEventListener('DOMContentLoaded', loadCalibration);
</script>
