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
    
    <button class="save-btn" style="background:#3b82f6; margin-bottom: 10px;" onclick="tambahTeksBaru()">➕ Tambah Teks Baru</button>
    <button class="save-btn" onclick="saveSettings()">💾 Simpan Template</button>
    
    <div class="keyboard-shortcuts">
        <strong>Pintasan Keyboard:</strong><br><br>
        <kbd>Ctrl</kbd> + <kbd>Z</kbd> : Undo (Kembali)<br>
        <kbd>Ctrl</kbd> + <kbd>Y</kbd> : Redo (Maju)<br><br>
        <em>Atau klik, tahan, dan geser teks langsung di halaman.</em>
    </div>
</div>

<script>
    // Backend variables
    const serverCustomTexts = {!! json_encode($customTextSettings ?? []) !!};
    const serverSettings = {!! json_encode($settings ?? []) !!};

    // State management
    let elements = [];
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

    function parseMM(value) {
        if (!value) return 0;
        return parseFloat(value.toString().replace('mm', '')) || 0;
    }
    function parsePT(value) {
        if (!value) return 12;
        let pt = value;
        if (typeof value === 'string' && value.includes('pt')) pt = value.replace('pt', '');
        else if (typeof value === 'string' && value.includes('px')) pt = parseFloat(value) * 0.75;
        return parseFloat(pt) || 12;
    }

    function captureState() {
        const state = {};
        elements.forEach(el => {
            const id = el.id;
            let leftVal = el.style.left ? parseMM(el.style.left) : 105;
            state[id] = {
                y: parseMM(el.style.top || window.getComputedStyle(el).top),
                x: leftVal,
                fontSize: parsePT(el.style.fontSize || window.getComputedStyle(el).fontSize),
                customText: el.getAttribute('data-custom-text') || ''
            };
        });
        
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
                el.setAttribute('data-custom-text', data.customText);
                
                if (data.customText.trim() !== '') {
                    el.innerHTML = data.customText.replace(/\n/g, '<br>');
                } else if (el.hasAttribute('data-default-html')) {
                    el.innerHTML = el.getAttribute('data-default-html');
                }
                
                const yInput = document.getElementById(`y_${id}`);
                const yRange = document.getElementById(`range_y_${id}`);
                const xInput = document.getElementById(`x_${id}`);
                const xRange = document.getElementById(`range_x_${id}`);
                const sizeInput = document.getElementById(`size_${id}`);
                const sizeRange = document.getElementById(`range_size_${id}`);
                const textInput = document.getElementById(`text_${id}`);
                
                if (yInput) { yInput.value = data.y; yRange.value = data.y; }
                if (xInput) { xInput.value = data.x; xRange.value = data.x; }
                if (sizeInput) { sizeInput.value = data.fontSize; sizeRange.value = data.fontSize; }
                if (textInput) { textInput.value = data.customText; }
            }
        }
    }

    function undo() { if (historyIndex > 0) { historyIndex--; applyState(historyStack[historyIndex]); } }
    function redo() { if (historyIndex < historyStack.length - 1) { historyIndex++; applyState(historyStack[historyIndex]); } }
    
    function printCertificate() {
        applyState(serverSavedState);
        setTimeout(() => { window.print(); }, 150);
    }

    function createControlPanel(el, isNew = false) {
        const id = el.id;
        const label = el.getAttribute('data-label') || id;
        
        let currentY = el.style.top ? parseMM(el.style.top) : (parseFloat(window.getComputedStyle(el).top) * 0.264583).toFixed(1);
        let currentX = el.style.left ? parseMM(el.style.left) : 105;
        let currentSize = el.style.fontSize ? parsePT(el.style.fontSize) : parsePT(window.getComputedStyle(el).fontSize);
        let currentText = el.getAttribute('data-custom-text') || '';
        
        serverSavedState[id] = {
            y: currentY,
            x: currentX,
            fontSize: currentSize,
            customText: currentText
        };

        const controlHTML = `
            <div class="control-group" id="group_${id}">
                <label>${label}</label>
                
                ${isNew ? `
                <div style="font-size: 11px; margin-bottom: 4px; color: #64748b; margin-top: 5px;">Teks (Bebas)</div>
                <textarea id="text_${id}" rows="2" style="width: 100%; border: 1px solid #cbd5e1; border-radius: 4px; padding: 4px; font-size: 12px; margin-bottom: 10px;"
                          onchange="updateValue('${id}', 'text', this.value)">${currentText}</textarea>
                ` : ''}

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
                
                ${isNew ? `<button onclick="deleteCustomElement('${id}')" style="margin-top: 10px; width: 100%; padding: 5px; background: #ef4444; color: white; border: none; border-radius: 4px; cursor: pointer;">🗑️ Hapus Elemen</button>` : ''}
            </div>
        `;
        
        controlsContainer.innerHTML += controlHTML;
        el.addEventListener('mousedown', (e) => startDrag(e, el));
    }

    function initControls() {
        // 1. Load server generated custom elements
        serverSettings.forEach(setting => {
            if (setting.element.startsWith('custom_element_')) {
                // Check if it already exists to prevent duplicates
                if (document.getElementById(setting.element)) return;
                
                const newEl = document.createElement('div');
                newEl.id = setting.element;
                newEl.className = 'abs-text editable-element';
                newEl.setAttribute('data-label', 'Teks Tambahan');
                newEl.style.left = setting.x_position || '105mm';
                newEl.style.top = setting.y_position || '100mm';
                newEl.style.fontSize = setting.font_size || '12pt';
                newEl.style.textAlign = 'center';
                document.querySelector('.page').appendChild(newEl);
            }
        });

        // 2. Fetch all elements including newly injected ones
        elements = Array.from(document.querySelectorAll('.editable-element'));

        // 3. Store default HTML for fallback and apply custom texts
        elements.forEach(el => {
            if (!el.hasAttribute('data-default-html')) {
                el.setAttribute('data-default-html', el.innerHTML);
            }
            if (serverCustomTexts[el.id]) {
                el.setAttribute('data-custom-text', serverCustomTexts[el.id]);
                if (serverCustomTexts[el.id].trim() !== '') {
                    el.innerHTML = serverCustomTexts[el.id].replace(/\n/g, '<br>');
                }
            }
        });

        // 4. Create UI
        elements.forEach(el => {
            const isNew = el.id.startsWith('custom_element_');
            createControlPanel(el, isNew);
        });
        
        captureState();
    }

    let customCounter = Date.now();
    function tambahTeksBaru() {
        customCounter++;
        const id = 'custom_element_' + customCounter;
        
        const newEl = document.createElement('div');
        newEl.id = id;
        newEl.className = 'abs-text editable-element';
        newEl.setAttribute('data-label', 'Teks Tambahan');
        newEl.setAttribute('data-custom-text', 'Teks Baru');
        newEl.style.left = '105mm';
        newEl.style.top = '148mm';
        newEl.style.fontSize = '12pt';
        newEl.style.textAlign = 'center';
        newEl.innerHTML = 'Teks Baru';
        
        document.querySelector('.page').appendChild(newEl);
        elements.push(newEl);
        
        createControlPanel(newEl, true);
        captureState();
        
        setTimeout(() => {
            document.getElementById(`group_${id}`).scrollIntoView({ behavior: 'smooth' });
        }, 100);
    }
    
    function deleteCustomElement(id) {
        if(!confirm('Hapus teks ini?')) return;
        const el = document.getElementById(id);
        if(el) el.remove();
        
        const group = document.getElementById(`group_${id}`);
        if(group) group.remove();
        
        elements = elements.filter(e => e.id !== id);
        delete serverSavedState[id];
        
        // Save immediately to remove from DB
        saveSettings();
    }

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
        } else if (type === 'text') {
            document.getElementById(`text_${id}`).value = value;
            el.setAttribute('data-custom-text', value);
            if (value.trim() !== '') {
                el.innerHTML = value.replace(/\n/g, '<br>');
            } else if (el.hasAttribute('data-default-html')) {
                el.innerHTML = el.getAttribute('data-default-html');
            }
        }
    }

    controlsContainer.addEventListener('change', (e) => {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
            captureState();
        }
    });

    function startDrag(e, el) {
        if (e.button !== 0) return;
        isDragging = true;
        activeDragElement = el;
        
        elements.forEach(e => e.classList.remove('active'));
        el.classList.add('active');
        
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
        if (!isDragging) return;
        const deltaY = e.clientY - startY;
        const deltaX = e.clientX - startX;
        
        const deltaYMM = deltaY * 0.264583;
        const deltaXMM = deltaX * 0.264583;
        
        const newTop = (initialTop + deltaYMM).toFixed(1);
        const newLeft = (initialLeft + deltaXMM).toFixed(1);
        
        activeDragElement.style.top = `${newTop}mm`;
        activeDragElement.style.left = `${newLeft}mm`;
        
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
            captureState();
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'z') { e.preventDefault(); undo(); } 
        else if (e.ctrlKey && e.key === 'y') { e.preventDefault(); redo(); }
    });

    function saveSettings() {
        const btn = document.querySelectorAll('.save-btn')[1]; // The second save-btn
        const originalText = btn.innerHTML;
        btn.innerHTML = '⏳ Menyimpan...';
        btn.style.background = '#f59e0b';
        
        const settings = {};
        elements.forEach(el => {
            const id = el.id;
            const customTextVal = document.getElementById(`text_${id}`) ? document.getElementById(`text_${id}`).value : '';
            settings[id] = {
                y: document.getElementById(`y_${id}`).value + 'mm',
                x: document.getElementById(`x_${id}`).value + 'mm',
                fontSize: document.getElementById(`size_${id}`).value + 'pt',
                custom_text: customTextVal
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
                
                elements.forEach(el => {
                    const id = el.id;
                    serverSavedState[id] = {
                        y: parseMM(document.getElementById(`y_${id}`).value),
                        x: parseMM(document.getElementById(`x_${id}`).value),
                        fontSize: parsePT(document.getElementById(`size_${id}`).value),
                        customText: document.getElementById(`text_${id}`) ? document.getElementById(`text_${id}`).value : ''
                    };
                });
                
                setTimeout(() => { btn.innerHTML = originalText; btn.style.background = '#4f46e5'; }, 2000);
            }
        })
        .catch(err => {
            console.error(err);
            btn.innerHTML = '❌ Gagal';
            btn.style.background = '#ef4444';
            setTimeout(() => { btn.innerHTML = originalText; btn.style.background = '#4f46e5'; }, 3000);
        });
    }

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

    window.onload = initControls;
</script>
