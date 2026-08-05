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
        user-select: none;
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

    /* Text Editing Mode */
    body.editor-active .editable-element.text-editing {
        cursor: text;
        user-select: text;
        border-color: #4f46e5;
        background: rgba(79, 70, 229, 0.04);
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.25);
        outline: none;
        min-width: 40px;
        min-height: 18px;
    }
    body.editor-active .editable-element.text-editing::selection,
    body.editor-active .editable-element.text-editing *::selection {
        background: rgba(79, 70, 229, 0.25);
    }

    /* Drag Handle */
    .drag-handle {
        display: none;
        position: absolute;
        top: -10px;
        left: -10px;
        width: 22px;
        height: 22px;
        background: #4f46e5;
        border-radius: 5px;
        cursor: grab;
        align-items: center;
        justify-content: center;
        z-index: 10;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        transition: transform 0.15s ease, background 0.15s ease;
    }
    .drag-handle:hover { background: #4338ca; transform: scale(1.1); }
    .drag-handle:active { cursor: grabbing; background: #3730a3; }
    .drag-handle svg { width: 12px; height: 12px; stroke: white; fill: none; }
    body.editor-active .editable-element:hover .drag-handle,
    body.editor-active .editable-element.active .drag-handle,
    body.editor-active .editable-element.text-editing .drag-handle {
        display: flex;
    }

    /* Edit hint badge */
    .edit-hint {
        display: none;
        position: absolute;
        top: -10px;
        right: -6px;
        background: #0ea5e9;
        color: white;
        font-size: 8px;
        padding: 1px 5px;
        border-radius: 4px;
        font-family: sans-serif;
        white-space: nowrap;
        letter-spacing: 0.3px;
        pointer-events: none;
        font-weight: 600;
    }
    body.editor-active .editable-element:hover .edit-hint { display: block; }
    body.editor-active .editable-element.text-editing .edit-hint { display: none; }

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
    
    /* ===== Floating Toolbar (Word-style) ===== */
    .floating-toolbar {
        position: fixed;
        display: none;
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border-radius: 12px;
        padding: 5px 8px;
        box-shadow: 0 12px 40px rgba(0,0,0,0.35), 0 4px 12px rgba(0,0,0,0.15);
        z-index: 2000;
        gap: 2px;
        align-items: center;
        flex-wrap: wrap;
        font-family: 'Inter', 'Segoe UI', sans-serif;
        transform: translateX(-50%);
        animation: floatToolbarIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid rgba(255,255,255,0.1);
        max-width: 520px;
    }
    .floating-toolbar.visible { display: flex; }
    @keyframes floatToolbarIn {
        from { opacity: 0; transform: translateX(-50%) translateY(6px) scale(0.96); }
        to { opacity: 1; transform: translateX(-50%) translateY(0) scale(1); }
    }
    .floating-toolbar .ft-divider {
        width: 1px; height: 24px;
        background: rgba(255,255,255,0.1);
        margin: 0 3px;
    }
    .floating-toolbar .ft-btn {
        background: transparent; border: none; color: #94a3b8;
        width: 30px; height: 30px; border-radius: 6px;
        cursor: pointer; font-size: 13px; font-weight: 600;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.12s ease; position: relative;
        padding: 0;
    }
    .floating-toolbar .ft-btn:hover { background: rgba(255,255,255,0.1); color: #e2e8f0; }
    .floating-toolbar .ft-btn.active { background: #4f46e5; color: #fff; box-shadow: inset 0 1px 0 rgba(255,255,255,0.15); }
    .floating-toolbar .ft-btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; }
    .floating-toolbar select {
        background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
        color: #e2e8f0; padding: 4px 20px 4px 8px; border-radius: 6px;
        font-size: 11px; cursor: pointer; outline: none; font-family: inherit;
        -webkit-appearance: none; appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 5px center;
        transition: all 0.12s;
    }
    .floating-toolbar select:hover { border-color: rgba(255,255,255,0.2); background-color: rgba(255,255,255,0.1); }
    .floating-toolbar select:focus { border-color: #4f46e5; box-shadow: 0 0 0 2px rgba(79,70,229,0.3); }
    .floating-toolbar select option { background: #1e293b; color: #e2e8f0; }
    .floating-toolbar .ft-size-input {
        width: 38px; background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;
        text-align: center; padding: 4px 2px; border-radius: 6px;
        font-size: 11px; outline: none; font-family: inherit; transition: all 0.12s;
    }
    .floating-toolbar .ft-size-input:focus { border-color: #4f46e5; box-shadow: 0 0 0 2px rgba(79,70,229,0.3); }
    .floating-toolbar .ft-color-btn {
        position: relative; width: 30px; height: 30px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; border-radius: 6px; border: none;
        background: transparent; transition: all 0.12s;
    }
    .floating-toolbar .ft-color-btn:hover { background: rgba(255,255,255,0.1); }
    .floating-toolbar .ft-color-btn input[type='color'] {
        position: absolute; opacity: 0; width: 100%; height: 100%;
        cursor: pointer; top: 0; left: 0;
    }
    .floating-toolbar .ft-color-btn .color-preview {
        width: 16px; height: 3px; border-radius: 1px;
        position: absolute; bottom: 4px; left: 50%; transform: translateX(-50%);
    }
    .floating-toolbar::after {
        content: ''; position: absolute; bottom: -6px; left: 50%;
        width: 12px; height: 12px; background: #0f172a;
        border-right: 1px solid rgba(255,255,255,0.1);
        border-bottom: 1px solid rgba(255,255,255,0.1);
        transform: translateX(-50%) rotate(45deg);
    }
    .floating-toolbar.arrow-top::after {
        bottom: auto; top: -6px; border: none;
        border-left: 1px solid rgba(255,255,255,0.1);
        border-top: 1px solid rgba(255,255,255,0.1);
        transform: translateX(-50%) rotate(45deg);
    }

    @media print {
        .editor-panel, .editor-toggle, .floating-toolbar { display: none !important; }
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

<!-- Floating Toolbar (Word-style popup) -->
<div class="floating-toolbar no-print" id="floating-toolbar">
    <!-- Font Family -->
    <select id="ft-font-family" onchange="ftUpdateFont(this.value)" title="Jenis Font">
        <option value="Arial">Arial</option>
        <option value="Tahoma" selected>Tahoma</option>
        <option value="Times New Roman">Times NR</option>
        <option value="Calibri">Calibri</option>
        <option value="Verdana">Verdana</option>
        <option value="Cambria">Cambria</option>
        <option value="Courier New">Courier</option>
        <option value="Georgia">Georgia</option>
    </select>
    <div class="ft-divider"></div>
    <!-- Font Size -->
    <button class="ft-btn" onclick="ftChangeSize(-0.5)" title="Perkecil Font">
        <svg viewBox="0 0 24 24"><path d="M5 12h14"/></svg>
    </button>
    <input type="number" class="ft-size-input" id="ft-font-size" min="6" max="72" step="0.5" value="11" onchange="ftUpdateSize(this.value)" title="Ukuran Font (pt)">
    <button class="ft-btn" onclick="ftChangeSize(0.5)" title="Perbesar Font">
        <svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
    </button>
    <div class="ft-divider"></div>
    <!-- Text Formatting -->
    <button class="ft-btn" id="ft-bold" onclick="ftToggleBold()" title="Bold (Ctrl+B)"><b>B</b></button>
    <button class="ft-btn" id="ft-italic" onclick="ftToggleItalic()" title="Italic (Ctrl+I)"><i style="font-family:Georgia,serif">I</i></button>
    <button class="ft-btn" id="ft-underline" onclick="ftToggleUnderline()" title="Underline (Ctrl+U)"><u>U</u></button>
    <button class="ft-btn" id="ft-strike" onclick="ftToggleStrike()" title="Strikethrough"><s>S</s></button>
    <div class="ft-divider"></div>
    <!-- Text Color -->
    <div class="ft-color-btn" title="Warna Teks">
        <span style="color:#94a3b8;font-size:14px;font-weight:700;">A</span>
        <div class="color-preview" id="ft-color-preview" style="background:#ef4444;"></div>
        <input type="color" id="ft-text-color" value="#000000" onchange="ftSetColor(this.value)">
    </div>
    <!-- Highlight -->
    <div class="ft-color-btn" title="Warna Sorotan (Highlight)">
        <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:#94a3b8;fill:none;stroke-width:2;"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
        <div class="color-preview" id="ft-highlight-preview" style="background:#facc15;"></div>
        <input type="color" id="ft-highlight-color" value="#facc15" onchange="ftSetHighlight(this.value)">
    </div>
    <div class="ft-divider"></div>
    <!-- Alignment -->
    <button class="ft-btn" id="ft-align-left" onclick="ftSetAlign('left')" title="Rata Kiri">
        <svg viewBox="0 0 24 24"><path d="M17 10H3M21 6H3M21 14H3M17 18H3"/></svg>
    </button>
    <button class="ft-btn" id="ft-align-center" onclick="ftSetAlign('center')" title="Rata Tengah">
        <svg viewBox="0 0 24 24"><path d="M18 10H6M21 6H3M21 14H3M18 18H6"/></svg>
    </button>
    <button class="ft-btn" id="ft-align-right" onclick="ftSetAlign('right')" title="Rata Kanan">
        <svg viewBox="0 0 24 24"><path d="M21 10H7M21 6H3M21 14H3M21 18H7"/></svg>
    </button>
    <div class="ft-divider"></div>
    <!-- Line Height -->
    <select id="ft-line-height" onchange="ftSetLineHeight(this.value)" title="Spasi Baris" style="width:50px;">
        <option value="1">1.0</option>
        <option value="1.15">1.15</option>
        <option value="1.3" selected>1.3</option>
        <option value="1.5">1.5</option>
        <option value="2">2.0</option>
        <option value="2.5">2.5</option>
    </select>
    <!-- Clear Format -->
    <button class="ft-btn" onclick="ftClearFormat()" title="Hapus Semua Format">
        <svg viewBox="0 0 24 24"><path d="M4 7h16M10 11l-6 6M12.5 7l-2.5 4M15 7l-5 9M6 21h12"/></svg>
    </button>
</div>

<script>
    // Backend variables
    const serverCustomTexts = {{ \Illuminate\Support\Js::from($customTextSettings ?? []) }};
    const serverSettings = {{ \Illuminate\Support\Js::from($settings ?? []) }};

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
                fontFamily: el.style.fontFamily || window.getComputedStyle(el).fontFamily || 'Arial',
                isBold: el.style.fontWeight === 'bold' || el.style.fontWeight >= 700 || el.classList.contains('font-bold'),
                isItalic: el.style.fontStyle === 'italic' || el.classList.contains('font-italic'),
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
                el.style.fontFamily = data.fontFamily;
                
                if (data.isBold) el.style.fontWeight = 'bold'; else el.style.fontWeight = 'normal';
                if (data.isItalic) el.style.fontStyle = 'italic'; else el.style.fontStyle = 'normal';
                
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
                const fontSelect = document.getElementById(`font_${id}`);
                const boldCheck = document.getElementById(`bold_${id}`);
                const italicCheck = document.getElementById(`italic_${id}`);
                const textInput = document.getElementById(`text_${id}`);
                
                if (yInput) { yInput.value = data.y; yRange.value = data.y; }
                if (xInput) { xInput.value = data.x; xRange.value = data.x; }
                if (sizeInput) { sizeInput.value = data.fontSize; sizeRange.value = data.fontSize; }
                if (fontSelect) { fontSelect.value = data.fontFamily.replace(/['"]/g, ''); }
                if (boldCheck) { boldCheck.checked = data.isBold; }
                if (italicCheck) { italicCheck.checked = data.isItalic; }
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
        let currentFont = (el.style.fontFamily || window.getComputedStyle(el).fontFamily || 'Tahoma').split(',')[0].replace(/['"]|/g, '').trim() || 'Tahoma';
        let currentBold = el.style.fontWeight === 'bold' || el.style.fontWeight >= 700 || el.classList.contains('font-bold');
        let currentItalic = el.style.fontStyle === 'italic' || el.classList.contains('font-italic');
        let currentText = el.getAttribute('data-custom-text') || '';
        let placeholderText = el.innerText.trim().replace(/"/g, '&quot;');
        
        serverSavedState[id] = {
            y: currentY,
            x: currentX,
            fontSize: currentSize,
            fontFamily: currentFont,
            isBold: currentBold,
            isItalic: currentItalic,
            customText: currentText
        };

        const controlHTML = `
            <div class="control-group" id="group_${id}">
                <label>${label}</label>
                
                <div style="font-size: 11px; margin-bottom: 4px; color: #64748b; margin-top: 5px;">Teks (Opsional, timpa teks asli)</div>
                <textarea id="text_${id}" rows="2" placeholder="${placeholderText}" style="width: 100%; border: 1px solid #cbd5e1; border-radius: 4px; padding: 4px; font-size: 12px; margin-bottom: 10px;"
                          onchange="updateValue('${id}', 'text', this.value)">${currentText}</textarea>

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

                <div style="font-size: 11px; margin-bottom: 4px; color: #64748b; margin-top: 10px;">Jenis Font</div>
                <select id="font_${id}" onchange="updateValue('${id}', 'font', this.value)" style="width: 100%; padding: 4px 8px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 13px; margin-bottom: 10px;">
                    <option value="Arial" ${currentFont === 'Arial' ? 'selected' : ''}>Arial</option>
                    <option value="Tahoma" ${currentFont === 'Tahoma' ? 'selected' : ''}>Tahoma</option>
                    <option value="Times New Roman" ${currentFont === 'Times New Roman' ? 'selected' : ''}>Times New Roman</option>
                    <option value="Calibri" ${currentFont === 'Calibri' ? 'selected' : ''}>Calibri</option>
                    <option value="Verdana" ${currentFont === 'Verdana' ? 'selected' : ''}>Verdana</option>
                    <option value="Cambria" ${currentFont === 'Cambria' ? 'selected' : ''}>Cambria</option>
                    <option value="Courier New" ${currentFont === 'Courier New' ? 'selected' : ''}>Courier New</option>
                </select>
                
                <div style="display: flex; gap: 15px; margin-top: 10px;">
                    <label style="display:flex; align-items:center; gap:5px; font-weight:normal; cursor:pointer;">
                        <input type="checkbox" id="bold_${id}" ${currentBold ? 'checked' : ''} onchange="updateValue('${id}', 'bold', this.checked)">
                        <b>B</b> Bold
                    </label>
                    <label style="display:flex; align-items:center; gap:5px; font-weight:normal; cursor:pointer;">
                        <input type="checkbox" id="italic_${id}" ${currentItalic ? 'checked' : ''} onchange="updateValue('${id}', 'italic', this.checked)">
                        <i>I</i> Italic
                    </label>
                </div>
                
                ${isNew ? `<button onclick="deleteCustomElement('${id}')" style="margin-top: 10px; width: 100%; padding: 5px; background: #ef4444; color: white; border: none; border-radius: 4px; cursor: pointer;">🗑️ Hapus Elemen</button>` : ''}
            </div>
        `;
        
        controlsContainer.innerHTML += controlHTML;
        // Drag is now handled by the drag handle only (injected in injectDragHandles)
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

        // 3. Store default HTML for fallback, apply styles and custom texts
        elements.forEach(el => {
            if (!el.hasAttribute('data-default-html')) {
                el.setAttribute('data-default-html', el.innerHTML);
            }
            
            // Apply server settings for bold/italic if they exist
            const setting = serverSettings.find(s => s.element === el.id);
            if (setting) {
                if (setting.is_bold) el.style.fontWeight = 'bold'; else el.style.fontWeight = 'normal';
                if (setting.is_italic) el.style.fontStyle = 'italic'; else el.style.fontStyle = 'normal';
                if (setting.font_family) el.style.fontFamily = setting.font_family;
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
        } else if (type === 'font') {
            document.getElementById(`font_${id}`).value = value;
            el.style.fontFamily = value;
        } else if (type === 'bold') {
            document.getElementById(`bold_${id}`).checked = value;
            el.style.fontWeight = value ? 'bold' : 'normal';
        } else if (type === 'italic') {
            document.getElementById(`italic_${id}`).checked = value;
            el.style.fontStyle = value ? 'italic' : 'normal';
        }
    }

    controlsContainer.addEventListener('change', (e) => {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.tagName === 'SELECT') {
            captureState();
        }
    });

    function startDrag(e, el) {
        if (e.button !== 0) return;
        
        // ONLY allow dragging from the drag-handle to allow text selection
        if (!e.target.closest('.drag-handle')) return;
        
        // Exit text editing mode if dragging
        exitTextEditing();
        hideFloatingToolbar();
        
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
            const fontVal = document.getElementById(`font_${id}`) ? document.getElementById(`font_${id}`).value : 'Arial';
            const boldVal = document.getElementById(`bold_${id}`) ? document.getElementById(`bold_${id}`).checked : false;
            const italicVal = document.getElementById(`italic_${id}`) ? document.getElementById(`italic_${id}`).checked : false;
            let yVal = document.getElementById(`y_${id}`)?.value;
            let xVal = document.getElementById(`x_${id}`)?.value;
            settings[id] = {
                y: yVal && !isNaN(yVal) ? yVal + 'mm' : null,
                x: xVal && !isNaN(xVal) ? xVal + 'mm' : null,
                fontSize: (document.getElementById(`size_${id}`)?.value || '12') + 'pt',
                fontFamily: fontVal,
                isBold: boldVal,
                isItalic: italicVal,
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
                    let syVal = document.getElementById(`y_${id}`)?.value;
                    let sxVal = document.getElementById(`x_${id}`)?.value;
                    serverSavedState[id] = {
                        y: syVal && !isNaN(syVal) ? parseMM(syVal) : null,
                        x: sxVal && !isNaN(sxVal) ? parseMM(sxVal) : null,
                        fontSize: parsePT(document.getElementById(`size_${id}`)?.value || '12'),
                        fontFamily: document.getElementById(`font_${id}`) ? document.getElementById(`font_${id}`).value : 'Arial',
                        isBold: document.getElementById(`bold_${id}`) ? document.getElementById(`bold_${id}`).checked : false,
                        isItalic: document.getElementById(`italic_${id}`) ? document.getElementById(`italic_${id}`).checked : false,
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

    // ===== FLOATING TOOLBAR + CONTENTEDITABLE LOGIC =====
    const floatingToolbar = document.getElementById('floating-toolbar');
    let ftActiveElement = null;
    let textEditingElement = null;

    // --- Inject drag handles and edit hints into elements ---
    function injectDragHandles() {
        elements.forEach(el => {
            if (el.querySelector('.drag-handle')) return;
            const handle = document.createElement('div');
            handle.className = 'drag-handle';
            handle.innerHTML = '<svg viewBox="0 0 24 24" stroke-width="2.5"><path d="M8 6h.01M8 12h.01M8 18h.01M14 6h.01M14 12h.01M14 18h.01"/></svg>';
            handle.addEventListener('mousedown', (e) => { e.stopPropagation(); startDrag(e, el); });
            el.appendChild(handle);

            const hint = document.createElement('div');
            hint.className = 'edit-hint';
            hint.textContent = 'double-click edit';
            el.appendChild(hint);
        });
    }

    // --- Enter text editing mode (contenteditable) ---
    function enterTextEditing(el) {
        if (textEditingElement === el) return;
        exitTextEditing();

        textEditingElement = el;
        el.setAttribute('contenteditable', 'true');
        el.classList.add('text-editing');
        el.classList.remove('active');
        el.focus();

        // Show toolbar for this element
        showFloatingToolbar(el);
    }

    function exitTextEditing() {
        if (!textEditingElement) return;
        textEditingElement.removeAttribute('contenteditable');
        textEditingElement.classList.remove('text-editing');
        
        // Sync back the innerHTML as custom_text to sidebar textarea
        const id = textEditingElement.id;
        const textarea = document.getElementById(`text_${id}`);
        if (textarea) {
            textarea.value = textEditingElement.innerHTML.replace(/<br\s*\/?>/gi, '\n');
        }
        textEditingElement.setAttribute('data-custom-text', textEditingElement.innerHTML);
        
        textEditingElement = null;
        captureState();
    }

    // --- Double-click to enter text editing + show toolbar ---
    document.addEventListener('dblclick', function(e) {
        if (!document.body.classList.contains('editor-active')) return;
        const clickedEl = e.target.closest('.editable-element');
        if (clickedEl) {
            e.preventDefault();
            enterTextEditing(clickedEl);
            showFloatingToolbar(clickedEl);
        }
    });

    // --- Show floating toolbar ---
    function showFloatingToolbar(el) {
        ftActiveElement = el;
        syncToolbarState(el);
        positionToolbar(el);
        floatingToolbar.classList.add('visible');
    }

    function syncToolbarState(el) {
        const cs = window.getComputedStyle(el);
        // Extract primary font name from computed style (e.g. "Tahoma, sans-serif" → "Tahoma")
        let rawFont = el.style.fontFamily || cs.fontFamily || 'Tahoma';
        let font = rawFont.split(',')[0].replace(/['"]/g, '').trim();
        // Match against dropdown options
        const fontSelect = document.getElementById('ft-font-family');
        const matchedOption = Array.from(fontSelect.options).find(opt => opt.value.toLowerCase() === font.toLowerCase());
        fontSelect.value = matchedOption ? matchedOption.value : 'Tahoma';

        let size = el.style.fontSize ? parsePT(el.style.fontSize) : parsePT(cs.fontSize);
        document.getElementById('ft-font-size').value = size;

        const isBold = el.style.fontWeight === 'bold' || parseInt(cs.fontWeight) >= 700;
        document.getElementById('ft-bold').classList.toggle('active', isBold);

        const isItalic = el.style.fontStyle === 'italic' || cs.fontStyle === 'italic';
        document.getElementById('ft-italic').classList.toggle('active', isItalic);

        const isUnderline = el.style.textDecoration?.includes('underline') || cs.textDecorationLine?.includes('underline');
        document.getElementById('ft-underline').classList.toggle('active', isUnderline);

        const isStrike = el.style.textDecoration?.includes('line-through') || cs.textDecorationLine?.includes('line-through');
        document.getElementById('ft-strike').classList.toggle('active', isStrike);

        // Alignment
        const align = el.style.textAlign || cs.textAlign || 'center';
        document.getElementById('ft-align-left').classList.toggle('active', align === 'left' || align === 'start');
        document.getElementById('ft-align-center').classList.toggle('active', align === 'center');
        document.getElementById('ft-align-right').classList.toggle('active', align === 'right' || align === 'end');

        // Line height
        const lh = el.style.lineHeight || cs.lineHeight;
        const lhSelect = document.getElementById('ft-line-height');
        if (lh && lh !== 'normal') {
            const lhVal = parseFloat(lh);
            lhSelect.value = lhVal || '1.3';
        }

        // Color
        document.getElementById('ft-color-preview').style.background = el.style.color || cs.color || '#000';
    }

    function positionToolbar(el) {
        const rect = el.getBoundingClientRect();
        const toolbarHeight = 48;
        const margin = 14;
        let topPos = rect.top - toolbarHeight - margin;
        floatingToolbar.classList.remove('arrow-top');
        if (topPos < 10) {
            topPos = rect.bottom + margin;
            floatingToolbar.classList.add('arrow-top');
        }
        floatingToolbar.style.left = (rect.left + rect.width / 2) + 'px';
        floatingToolbar.style.top = topPos + 'px';
    }

    function hideFloatingToolbar() {
        floatingToolbar.classList.remove('visible');
        ftActiveElement = null;
    }

    // --- Toolbar actions ---
    function ftUpdateFont(value) {
        if (!ftActiveElement) return;
        ftActiveElement.style.fontFamily = value;
        const sb = document.getElementById(`font_${ftActiveElement.id}`);
        if (sb) sb.value = value;
        captureState();
    }

    function ftUpdateSize(value) {
        if (!ftActiveElement) return;
        const id = ftActiveElement.id;
        ftActiveElement.style.fontSize = value + 'pt';
        const s = document.getElementById(`size_${id}`);
        const r = document.getElementById(`range_size_${id}`);
        if (s) s.value = value;
        if (r) r.value = value;
        captureState();
    }

    function ftChangeSize(delta) {
        if (!ftActiveElement) return;
        const input = document.getElementById('ft-font-size');
        let current = parseFloat(input.value) || 11;
        current = Math.max(6, Math.min(72, current + delta));
        input.value = current;
        ftUpdateSize(current);
    }

    function ftToggleBold() {
        if (window.getSelection().toString().length > 0 && document.activeElement && document.activeElement.isContentEditable) {
            document.execCommand('bold');
            captureState();
            return;
        }
        if (!ftActiveElement) return;
        const isBold = ftActiveElement.style.fontWeight === 'bold' || parseInt(ftActiveElement.style.fontWeight) >= 700;
        const newVal = !isBold;
        ftActiveElement.style.fontWeight = newVal ? 'bold' : 'normal';
        document.getElementById('ft-bold').classList.toggle('active', newVal);
        const sb = document.getElementById(`bold_${ftActiveElement.id}`);
        if (sb) sb.checked = newVal;
        captureState();
    }

    function ftToggleItalic() {
        if (window.getSelection().toString().length > 0 && document.activeElement && document.activeElement.isContentEditable) {
            document.execCommand('italic');
            captureState();
            return;
        }
        if (!ftActiveElement) return;
        const isItalic = ftActiveElement.style.fontStyle === 'italic';
        const newVal = !isItalic;
        ftActiveElement.style.fontStyle = newVal ? 'italic' : 'normal';
        document.getElementById('ft-italic').classList.toggle('active', newVal);
        const sb = document.getElementById(`italic_${ftActiveElement.id}`);
        if (sb) sb.checked = newVal;
        captureState();
    }

    function ftToggleUnderline() {
        if (window.getSelection().toString().length > 0 && document.activeElement && document.activeElement.isContentEditable) {
            document.execCommand('underline');
            captureState();
            return;
        }
        if (!ftActiveElement) return;
        const current = ftActiveElement.style.textDecoration || '';
        const hasUL = current.includes('underline');
        if (hasUL) {
            ftActiveElement.style.textDecoration = current.replace('underline', '').trim() || 'none';
        } else {
            ftActiveElement.style.textDecoration = (current === 'none' ? '' : current + ' ') + 'underline';
        }
        document.getElementById('ft-underline').classList.toggle('active', !hasUL);
        captureState();
    }

    function ftToggleStrike() {
        if (window.getSelection().toString().length > 0 && document.activeElement && document.activeElement.isContentEditable) {
            document.execCommand('strikeThrough');
            captureState();
            return;
        }
        if (!ftActiveElement) return;
        const current = ftActiveElement.style.textDecoration || '';
        const hasLT = current.includes('line-through');
        if (hasLT) {
            ftActiveElement.style.textDecoration = current.replace('line-through', '').trim() || 'none';
        } else {
            ftActiveElement.style.textDecoration = (current === 'none' ? '' : current + ' ') + 'line-through';
        }
        document.getElementById('ft-strike').classList.toggle('active', !hasLT);
        captureState();
    }

    function ftSetColor(value) {
        if (!ftActiveElement) return;
        ftActiveElement.style.color = value;
        document.getElementById('ft-color-preview').style.background = value;
        captureState();
    }

    function ftSetHighlight(value) {
        if (!ftActiveElement) return;
        ftActiveElement.style.backgroundColor = value;
        document.getElementById('ft-highlight-preview').style.background = value;
        captureState();
    }

    function ftSetAlign(align) {
        if (!ftActiveElement) return;
        ftActiveElement.style.textAlign = align;
        document.getElementById('ft-align-left').classList.toggle('active', align === 'left');
        document.getElementById('ft-align-center').classList.toggle('active', align === 'center');
        document.getElementById('ft-align-right').classList.toggle('active', align === 'right');
        captureState();
    }

    function ftSetLineHeight(value) {
        if (!ftActiveElement) return;
        ftActiveElement.style.lineHeight = value;
        captureState();
    }

    function ftClearFormat() {
        if (!ftActiveElement) return;
        ftActiveElement.style.fontWeight = '';
        ftActiveElement.style.fontStyle = '';
        ftActiveElement.style.textDecoration = '';
        ftActiveElement.style.color = '';
        ftActiveElement.style.backgroundColor = '';
        ftActiveElement.style.textAlign = '';
        ftActiveElement.style.lineHeight = '';
        syncToolbarState(ftActiveElement);
        captureState();
    }

    // --- Click & interaction handling ---
    document.addEventListener('mousedown', function(e) {
        if (floatingToolbar.contains(e.target)) return;
        if (e.target.closest('.drag-handle')) return;
        
        const clickedEl = e.target.closest('.editable-element');
        if (clickedEl && document.body.classList.contains('editor-active')) {
            // If already in text editing mode for this element, let native cursor work
            if (textEditingElement === clickedEl) return;
            
            // Single click: only select element for dragging (no toolbar popup)
            elements.forEach(el => el.classList.remove('active'));
            clickedEl.classList.add('active');
            
            // Highlight corresponding control in sidebar
            document.querySelectorAll('.control-group').forEach(c => c.style.borderColor = '#e2e8f0');
            const group = document.getElementById(`group_${clickedEl.id}`);
            if (group) {
                group.style.borderColor = '#ef4444';
                group.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        } else {
            // Clicked outside
            exitTextEditing();
            hideFloatingToolbar();
            elements.forEach(el => el.classList.remove('active'));
        }
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (ftActiveElement && e.ctrlKey) {
            if (e.key === 'b') { e.preventDefault(); ftToggleBold(); }
            if (e.key === 'i') { e.preventDefault(); ftToggleItalic(); }
            if (e.key === 'u') { e.preventDefault(); ftToggleUnderline(); }
        }
        // Escape to exit text editing
        if (e.key === 'Escape') {
            exitTextEditing();
            hideFloatingToolbar();
            elements.forEach(el => el.classList.remove('active'));
        }
    });

    // Reposition toolbar on scroll
    document.addEventListener('scroll', function() {
        if (ftActiveElement && floatingToolbar.classList.contains('visible')) {
            positionToolbar(ftActiveElement);
        }
    }, true);

    // After initControls, inject drag handles
    const _origInit = initControls;
    initControls = function() {
        _origInit();
        injectDragHandles();
    };

    window.onload = initControls;
</script>
