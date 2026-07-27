<!-- CSS for Editor Panel and Visual Enhancements -->
<style>
    /* Editor Panel Styling */
    .editor-panel {
        position: fixed;
        top: 0;
        left: -320px;
        width: 300px;
        height: 100vh;
        background: #f8fafc;
        box-shadow: 4px 0 15px rgba(0,0,0,0.1);
        z-index: 1000;
        transition: left 0.3s ease;
        padding: 20px;
        overflow-y: auto;
        font-family: 'Inter', sans-serif;
    }
    .editor-panel.open {
        left: 0;
    }
    .editor-panel h3 {
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 16px;
        color: #1e293b;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 10px;
    }
    .editor-toggle {
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1001;
        background: #4f46e5;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 8px;
        transition: left 0.3s ease;
    }
    .editor-toggle.panel-open {
        left: 320px;
        background: #ef4444;
    }
    .control-group {
        margin-bottom: 20px;
        background: white;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    .control-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
    }
    .slider-container {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
    }
    .slider-container input[type="range"] {
        flex: 1;
    }
    .slider-container input[type="number"] {
        width: 70px;
        padding: 4px 8px;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        font-size: 13px;
    }
    .save-btn {
        width: 100%;
        padding: 12px;
        background: #10b981;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 20px;
    }
    .save-btn:hover { background: #059669; }

    /* Interactive Elements on Page */
    .editable-element {
        cursor: move;
        transition: border 0.2s, background 0.2s;
        border: 1px dashed transparent;
        user-select: none; /* Prevent text selection while dragging */
        border-radius: 4px;
    }
    
    body.editor-active .editable-element:hover {
        border-color: #3b82f6;
        background: rgba(59, 130, 246, 0.05);
    }
    body.editor-active .editable-element.active {
        border-color: #ef4444;
        background: rgba(239, 68, 68, 0.05);
        box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2);
    }

    /* Undo/Redo info */
    .keyboard-shortcuts {
        margin-top: 20px;
        font-size: 11px;
        color: #64748b;
        background: #f1f5f9;
        padding: 10px;
        border-radius: 6px;
    }
    .keyboard-shortcuts kbd {
        background: white;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        padding: 2px 5px;
        font-family: monospace;
        font-weight: bold;
    }
    
    @media print {
        .editor-panel, .editor-toggle { display: none !important; }
        .editable-element { border: none !important; background: transparent !important; }
    }
</style>

<!-- Toggle Button -->
<button class="editor-toggle no-print" onclick="toggleEditor()">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
    <span id="toggle-text">Mode Edit Visual</span>
</button>

<!-- Editor Panel -->
<div class="editor-panel no-print" id="editor-panel">
    <h3>⚙️ Pengaturan Posisi & Ukuran</h3>
    
    <!-- Dynamic Controls Container -->
    <div id="controls-container"></div>
    
    <button class="save-btn" onclick="saveSettings()">💾 Simpan Template</button>
    
    <div class="keyboard-shortcuts">
        <strong>Pintasan Keyboard:</strong><br><br>
        <kbd>Ctrl</kbd> + <kbd>Z</kbd> : Undo (Kembali)<br>
        <kbd>Ctrl</kbd> + <kbd>Y</kbd> : Redo (Maju)<br><br>
        <em>Atau klik, tahan, dan geser teks langsung di halaman.</em>
    </div>
</div>

<script>
    // State management
    const elements = document.querySelectorAll('.editable-element');
    const controlsContainer = document.getElementById('controls-container');
    const categoryId = "{{ $certificate->category_id }}";
    
    // Undo/Redo State
    let historyStack = [];
    let historyIndex = -1;
    let isDragging = false;
    let activeDragElement = null;
    let startY = 0;
    let startX = 0;
    let initialTop = 0;
    let initialLeft = 0;
    
    // Last saved state to ensure print always uses confirmed settings
    let serverSavedState = {};

    // Default configuration parsing
    function parseMM(value) {
        if (!value) return 0;
        return parseFloat(value.toString().replace('mm', '')) || 0;
    }
    function parsePT(value) {
        if (!value) return 12; // default
        let pt = value;
        if (typeof value === 'string' && value.includes('pt')) pt = value.replace('pt', '');
        else if (typeof value === 'string' && value.includes('px')) pt = parseFloat(value) * 0.75;
        return parseFloat(pt) || 12;
    }

    // Capture state for Undo/Redo
    function captureState() {
        const state = {};
        elements.forEach(el => {
            const id = el.id;
            // If left is not set via style, we assume center (105mm for 210mm width)
            let leftVal = el.style.left ? parseMM(el.style.left) : 105;
            state[id] = {
                y: parseMM(el.style.top || window.getComputedStyle(el).top),
                x: leftVal,
                fontSize: parsePT(el.style.fontSize || window.getComputedStyle(el).fontSize)
            };
        });
        
        // Remove forward history if we're not at the end
        if (historyIndex < historyStack.length - 1) {
            historyStack = historyStack.slice(0, historyIndex + 1);
        }
        
        historyStack.push(state);
        historyIndex++;
    }

    function applyState(state) {
        for (const [id, data] of Object.entries(state)) {
            const el = document.getElementById(id);
            if (el) {
                el.style.top = data.y + 'mm';
                el.style.left = data.x + 'mm';
                el.style.fontSize = data.fontSize + 'pt';
                
                // Update UI controls if panel is open
                const yInput = document.getElementById(`y_${id}`);
                const yRange = document.getElementById(`range_y_${id}`);
                const xInput = document.getElementById(`x_${id}`);
                const xRange = document.getElementById(`range_x_${id}`);
                const sizeInput = document.getElementById(`size_${id}`);
                const sizeRange = document.getElementById(`range_size_${id}`);
                
                if (yInput) {
                    yInput.value = data.y;
                    yRange.value = data.y;
                }
                if (xInput) {
                    xInput.value = data.x;
                    xRange.value = data.x;
                }
                if (sizeInput) {
                    sizeInput.value = data.fontSize;
                    sizeRange.value = data.fontSize;
                }
            }
        }
    }

    function undo() {
        if (historyIndex > 0) {
            historyIndex--;
            applyState(historyStack[historyIndex]);
        }
    }

    function redo() {
        if (historyIndex < historyStack.length - 1) {
            historyIndex++;
            applyState(historyStack[historyIndex]);
        }
    }
    
    function printCertificate() {
        // Kembalikan ke posisi terakhir yang tersimpan sebelum print
        // untuk mencegah print bergeser kalau tidak sengaja tergeser dan belum di-save
        applyState(serverSavedState);
        
        // Kasih waktu sedikit untuk DOM render ulang posisinya sebelum box print keluar
        setTimeout(() => {
            window.print();
        }, 150);
    }

    // Initialize UI Controls
    function initControls() {
        elements.forEach(el => {
            const id = el.id;
            const label = el.getAttribute('data-label') || id;
            
            // Get initial values from inline style or computed style
            // Note: window.getComputedStyle returns pixels, so we do a rough conversion for initialization if no inline style
            let currentY = el.style.top ? parseMM(el.style.top) : (parseFloat(window.getComputedStyle(el).top) * 0.264583).toFixed(1);
            let currentX = el.style.left ? parseMM(el.style.left) : 105; // 105mm is center
            let currentSize = el.style.fontSize ? parsePT(el.style.fontSize) : parsePT(window.getComputedStyle(el).fontSize);
            
            // Simpan status awal sebagai status yang ada di server
            serverSavedState[id] = {
                y: currentY,
                x: currentX,
                fontSize: currentSize
            };

            const controlHTML = `
                <div class="control-group" id="group_${id}">
                    <label>${label}</label>
                    <div style="font-size: 11px; margin-bottom: 4px; color: #64748b;">Posisi Y (Naik/Turun)</div>
                    <div class="slider-container">
                        <input type="range" id="range_y_${id}" min="0" max="297" step="0.5" value="${currentY}" 
                               oninput="updateValue('${id}', 'y', this.value)">
                        <input type="number" id="y_${id}" value="${currentY}" step="0.5" 
                               onchange="updateValue('${id}', 'y', this.value)">
                    </div>
                    
                    <div style="font-size: 11px; margin-bottom: 4px; color: #64748b; margin-top: 10px;">Posisi X (Kiri/Kanan)</div>
                    <div class="slider-container">
                        <input type="range" id="range_x_${id}" min="0" max="210" step="0.5" value="${currentX}" 
                               oninput="updateValue('${id}', 'x', this.value)">
                        <input type="number" id="x_${id}" value="${currentX}" step="0.5" 
                               onchange="updateValue('${id}', 'x', this.value)">
                    </div>
                    
                    <div style="font-size: 11px; margin-bottom: 4px; color: #64748b; margin-top: 10px;">Ukuran Font (pt)</div>
                    <div class="slider-container">
                        <input type="range" id="range_size_${id}" min="8" max="72" step="0.5" value="${currentSize}" 
                               oninput="updateValue('${id}', 'size', this.value)">
                        <input type="number" id="size_${id}" value="${currentSize}" step="0.5" 
                               onchange="updateValue('${id}', 'size', this.value)">
                    </div>
                </div>
            `;
            controlsContainer.innerHTML += controlHTML;

            // Drag and drop setup
            el.addEventListener('mousedown', (e) => startDrag(e, el));
        });
        
        // Initial state capture
        captureState();
    }

    // Update from inputs
    function updateValue(id, type, value) {
        const el = document.getElementById(id);
        if (!el) return;

        if (type === 'y') {
            document.getElementById(`y_${id}`).value = value;
            document.getElementById(`range_y_${id}`).value = value;
            el.style.top = `${value}mm`;
        } else if (type === 'x') {
            document.getElementById(`x_${id}`).value = value;
            document.getElementById(`range_x_${id}`).value = value;
            el.style.left = `${value}mm`;
        } else if (type === 'size') {
            document.getElementById(`size_${id}`).value = value;
            document.getElementById(`range_size_${id}`).value = value;
            el.style.fontSize = `${value}pt`;
        }
    }

    // Record state change when input is done (so we don't capture every single pixel of slider drag)
    controlsContainer.addEventListener('change', (e) => {
        if (e.target.tagName === 'INPUT') {
            captureState();
        }
    });

    // Drag and Drop Logic
    function startDrag(e, el) {
        // Only trigger on left click
        if (e.button !== 0) return;
        
        isDragging = true;
        activeDragElement = el;
        
        // Add active class
        elements.forEach(e => e.classList.remove('active'));
        el.classList.add('active');
        
        // Highlight control group in panel
        document.querySelectorAll('.control-group').forEach(c => c.style.borderColor = '#e2e8f0');
        const group = document.getElementById(`group_${el.id}`);
        if(group) {
            group.style.borderColor = '#ef4444';
            group.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        startY = e.clientY;
        startX = e.clientX;
        initialTop = parseMM(el.style.top || window.getComputedStyle(el).top);
        initialLeft = el.style.left ? parseMM(el.style.left) : 105;
        
        document.addEventListener('mousemove', drag);
        document.addEventListener('mouseup', stopDrag);
    }

    function drag(e) {
        if (!isDragging || !activeDragElement) return;
        
        const deltaY = e.clientY - startY;
        const deltaX = e.clientX - startX;
        // 1 pixel is roughly 0.264583 mm
        const deltaYMM = deltaY * 0.264583;
        const deltaXMM = deltaX * 0.264583;
        
        const newTop = (initialTop + deltaYMM).toFixed(1);
        const newLeft = (initialLeft + deltaXMM).toFixed(1);
        
        // Update DOM
        activeDragElement.style.top = `${newTop}mm`;
        activeDragElement.style.left = `${newLeft}mm`;
        
        // Update UI Controls if panel is open
        const id = activeDragElement.id;
        if(document.getElementById(`y_${id}`)) {
            document.getElementById(`y_${id}`).value = newTop;
            document.getElementById(`range_y_${id}`).value = newTop;
        }
        if(document.getElementById(`x_${id}`)) {
            document.getElementById(`x_${id}`).value = newLeft;
            document.getElementById(`range_x_${id}`).value = newLeft;
        }
    }

    function stopDrag() {
        if (isDragging) {
            isDragging = false;
            document.removeEventListener('mousemove', drag);
            document.removeEventListener('mouseup', stopDrag);
            
            // Capture state after drop
            captureState();
        }
    }

    // Keyboard Shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'z') {
            e.preventDefault();
            undo();
        } else if (e.ctrlKey && e.key === 'y') {
            e.preventDefault();
            redo();
        }
    });

    // Save AJAX
    function saveSettings() {
        const btn = document.querySelector('.save-btn');
        const originalText = btn.innerHTML;
        btn.innerHTML = '⏳ Menyimpan...';
        btn.style.background = '#f59e0b';
        
        const settings = {};
        elements.forEach(el => {
            const id = el.id;
            settings[id] = {
                y: document.getElementById(`y_${id}`).value + 'mm',
                x: document.getElementById(`x_${id}`).value + 'mm',
                fontSize: document.getElementById(`size_${id}`).value + 'pt'
            };
        });

        fetch(`/settings/templates/${categoryId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ settings: settings })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                btn.innerHTML = '✅ Tersimpan!';
                btn.style.background = '#10b981';
                
                // Update serverSavedState dengan setting terbaru yang baru saja disimpan
                elements.forEach(el => {
                    const id = el.id;
                    serverSavedState[id] = {
                        y: parseMM(document.getElementById(`y_${id}`).value),
                        fontSize: parsePT(document.getElementById(`size_${id}`).value)
                    };
                });
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                }, 2000);
            }
        })
        .catch(err => {
            console.error(err);
            btn.innerHTML = '❌ Gagal Menyimpan';
            btn.style.background = '#ef4444';
            setTimeout(() => {
                btn.innerHTML = originalText;
            }, 3000);
        });
    }

    // Toggle Panel
    function toggleEditor() {
        const panel = document.getElementById('editor-panel');
        const btn = document.querySelector('.editor-toggle');
        const text = document.getElementById('toggle-text');
        
        panel.classList.toggle('open');
        btn.classList.toggle('panel-open');
        document.body.classList.toggle('editor-active');
        
        if (panel.classList.contains('open')) {
            text.innerText = 'Tutup Editor';
            btn.style.background = '#ef4444';
        } else {
            text.innerText = 'Mode Edit Visual';
            btn.style.background = '#4f46e5';
        }
    }

    // Initialize on load
    window.onload = initControls;
</script>
