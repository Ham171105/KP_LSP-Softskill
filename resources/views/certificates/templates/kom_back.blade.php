<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Belakang - Pemecahan Masalah</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}">
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 40px 0;
            font-family: Tahoma, sans-serif;
            background: #525659;
            color: #000;
            display: flex;
            justify-content: center;
        }
        .page {
            position: relative;
            width: 210mm;
            height: 297mm;
            min-height: 297mm;
            box-sizing: border-box;
            padding: 35mm 20mm 25mm 20mm;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
            margin: 0 auto;
            overflow: hidden;
            background-image: url('{{ asset('images/bg_belakang.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .font-italic { font-style: italic; }
        
        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            color: #777; /* Exact gray match */
        }
        .header-subtitle {
            text-align: center;
            font-style: italic;
            font-size: 14pt;
            color: #777;
            margin-bottom: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt; /* Match target size */
            border: 1px solid #000;
            color: #000;
        }
        th, td {
            vertical-align: middle;
            border: 1px solid #000;
            padding: 8px 5px; /* Reduced horizontal padding to allow text to fit */
            vertical-align: top;
        }
        th {
            background-color: transparent;
            text-align: center;
        }

        /* 
           FOOTER LAYOUT
           Uses absolute positioning for the right text block so it doesn't wrap
           and allows perfect vertical overlap with the FOTO box.
        */
        .footer-section {
            margin-top: auto;
            color: #777; /* Match gray color */
            font-size: 11pt;
            position: relative;
            margin-bottom: 20mm;
        }

        .footer-text-right {
            position: absolute;
            top: 0;
            right: 0;
            width: 75%; /* Plenty of space to prevent wrapping */
            text-align: right;
            line-height: 1.3;
        }

        .signature-container {
            display: flex;
            justify-content: space-between;
            margin-top: 80px; /* Pushes container down relative to top, effectively moving text block UP */
        }

        .signature-left {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .photo-box {
            width: 30mm;
            height: 40mm;
            border: 1px solid #000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 10pt;
            color: #000;
        }

        .holder-signature {
            text-align: center;
            line-height: 1.2;
            width: 50mm; /* Restrict width to allow wrapping */
        }

        .manager-signature {
            text-align: center;
            line-height: 1.2;
            display: flex;
            flex-direction: column;
            justify-content: flex-end; /* Aligns this block to bottom */
            white-space: nowrap;
        }

        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #4F46E5;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-family: sans-serif;
            border: none;
            cursor: pointer;
            z-index: 1000;
        }
        @media print {
            .btn-print { display: none; }
            body { 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact; 
                background: #fff !important; 
                padding: 0 !important; 
                display: block !important; 
            }
            .page { 
                box-shadow: none !important; 
                margin: 0 !important; 
            }
            table { border: 1px solid #000 !important; }
            th, td {
            vertical-align: middle; border: 1px solid #000 !important; }
            .photo-box { border: 1px solid #000 !important; }
        }
    
        .abs-text {
            position: absolute;
            transform: translateX(-50%);
            white-space: nowrap;
        }
        @media print {
            .btn-print { display: none; }
            .page { box-shadow: none; }
        }
        td { vertical-align: middle; }
    </style>
</head>
<body>
    <button class="btn-print" onclick="printCertificate()">Cetak Halaman Belakang</button>

    <div class="page">
        <!-- Title -->
        <div id="back_header" data-label="Judul Daftar Unit" class="editable-element" style="left: {{ $xSettings['back_header'] ?? '0' }}mm; position: relative; top: {{ $cleanSettings['back_header'] ?? '0' }}mm; font-size: {{ $fontSettings['back_header'] ?? '14' }}pt; {!! isset($fontFamilySettings['back_header']) ? 'font-family: '.$fontFamilySettings['back_header'].'; ' : '' !!}{!! isset($boldSettings['back_header']) ? ($boldSettings['back_header'] ? 'font-weight: bold; ' : 'font-weight: normal; ') : '' !!}{!! isset($italicSettings['back_header']) ? ($italicSettings['back_header'] ? 'font-style: italic; ' : 'font-style: normal; ') : '' !!}{!! isset($textAlignSettings['back_header']) ? 'text-align: '.$textAlignSettings['back_header'].'; ' : '' !!}{!! isset($colorSettings['back_header']) ? 'color: '.$colorSettings['back_header'].'; ' : '' !!}{!! isset($underlineSettings['back_header']) && $underlineSettings['back_header'] ? 'text-decoration: underline; ' : '' !!}">
            <div class="header-title" style="font-size: inherit;">Daftar Unit Kompetensi</div>
            <div class="header-subtitle" style="font-size: inherit;">List of Unit (s) of competency</div>
        </div>

        <!-- Table -->
        <div id="back_table" data-label="Tabel Kompetensi" class="editable-element" style="left: {{ $xSettings['back_table'] ?? '0' }}mm; position: relative; top: {{ $cleanSettings['back_table'] ?? '0' }}mm; font-size: {{ $fontSettings['back_table'] ?? '11' }}pt; {!! isset($fontFamilySettings['back_table']) ? 'font-family: '.$fontFamilySettings['back_table'].'; ' : '' !!}{!! isset($boldSettings['back_table']) ? ($boldSettings['back_table'] ? 'font-weight: bold; ' : 'font-weight: normal; ') : '' !!}{!! isset($italicSettings['back_table']) ? ($italicSettings['back_table'] ? 'font-style: italic; ' : 'font-style: normal; ') : '' !!}{!! isset($textAlignSettings['back_table']) ? 'text-align: '.$textAlignSettings['back_table'].'; ' : '' !!}{!! isset($colorSettings['back_table']) ? 'color: '.$colorSettings['back_table'].'; ' : '' !!}{!! isset($underlineSettings['back_table']) && $underlineSettings['back_table'] ? 'text-decoration: underline; ' : '' !!}">
            <table style="font-size: inherit;">
            <thead>
                <tr>
                    <th style="width: 5%"><span style="font-weight: bold;">No</span></th>
                    <th style="width: 20%"><span style="font-weight: bold;">Kode Unit</span><br><span style="font-style: italic; font-weight: normal;">Unit Code</span></th>
                    <th style="width: 75%"><span style="font-weight: bold;">Judul Unit</span><br><span style="font-style: italic; font-weight: normal;">Unit Title</span></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">1</td>
                    <td style="text-align: center;">P.85SOF00.001.1</td>
                    <td>
                        Membangun Konsep Diri yang Positif dalam Bekerja<br>
                        <span style="font-style: italic;">Building a Positive Self-Concept at Work</span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">2</td>
                    <td style="text-align: center;">P.85SOF00.010.1</td>
                    <td>
                        Membangun Kemampuan dalam Pengelolaan Emosi<br>
                        <span style="font-style: italic;">Developing Emotional Management Skills</span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">3</td>
                    <td style="text-align: center;">P.85SOF00.014.1</td>
                    <td>
                        Meningkatkan Kualitas Penampilan Prima<br>
                        <span style="font-style: italic;">Enhancing Professional Presence and Presentation</span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">4</td>
                    <td style="text-align: center;">P.85SOF00.017.1</td>
                    <td>
                        Membangun Kemampuan Komunikasi yang Efektif<br>
                        <span style="font-style: italic;">Building Effective Communication Skills</span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">5</td>
                    <td style="text-align: center;">P.85SOF00.019.1</td>
                    <td>
                        Mengembangkan Kemampuan Bekerja Sama dalam Tim<br>
                        <span style="font-style: italic;">Developing Team Collaboration Skills</span>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>

                                <!-- Footer Section Elements (Separated) -->
        <div id="back_date_text" data-label="Teks Tgl & Instansi" class="abs-text editable-element" style="left: {{ $xSettings['back_date_text'] ?? '110' }}mm; top: {{ $cleanSettings['back_date_text'] ?? '168' }}mm; font-size: {{ $fontSettings['back_date_text'] ?? '11' }}pt; text-align: right; width: 120mm; {!! isset($fontFamilySettings['back_date_text']) ? 'font-family: '.$fontFamilySettings['back_date_text'].'; ' : '' !!}{!! isset($boldSettings['back_date_text']) ? ($boldSettings['back_date_text'] ? 'font-weight: bold; ' : 'font-weight: normal; ') : '' !!}{!! isset($italicSettings['back_date_text']) ? ($italicSettings['back_date_text'] ? 'font-style: italic; ' : 'font-style: normal; ') : '' !!}{!! isset($textAlignSettings['back_date_text']) ? 'text-align: '.$textAlignSettings['back_date_text'].'; ' : '' !!}{!! isset($colorSettings['back_date_text']) ? 'color: '.$colorSettings['back_date_text'].'; ' : 'color: #777; ' !!}{!! isset($underlineSettings['back_date_text']) && $underlineSettings['back_date_text'] ? 'text-decoration: underline; ' : '' !!}">
            <div style="margin-bottom: 0.5rem;">Jakarta, {{ \Carbon\Carbon::parse($certificate->issue_date)->locale('id')->translatedFormat('d F Y') }}</div>
            <div>Atas Nama Badan Nasional Sertifikasi Profesi</div>
            <div style="font-style: italic;">On Behalf of Indonesia Professional Certification Authority</div>
            <div style="font-weight: bold;">Lembaga Sertifikasi Profesi Softskill Indonesia Kompeten</div>
            <div style="font-style: italic;">Competent Indonesian Softskill Professional Certification Body</div>
        </div>

        <div id="back_photo" data-label="Kotak Foto 3x4" class="abs-text editable-element" style="left: {{ $xSettings['back_photo'] ?? '35' }}mm; top: {{ $cleanSettings['back_photo'] ?? '200' }}mm; font-size: {{ $fontSettings['back_photo'] ?? '11' }}pt; {!! isset($fontFamilySettings['back_photo']) ? 'font-family: '.$fontFamilySettings['back_photo'].'; ' : '' !!}{!! isset($boldSettings['back_photo']) ? ($boldSettings['back_photo'] ? 'font-weight: bold; ' : 'font-weight: normal; ') : '' !!}{!! isset($italicSettings['back_photo']) ? ($italicSettings['back_photo'] ? 'font-style: italic; ' : 'font-style: normal; ') : '' !!}{!! isset($textAlignSettings['back_photo']) ? 'text-align: '.$textAlignSettings['back_photo'].'; ' : '' !!}{!! isset($colorSettings['back_photo']) ? 'color: '.$colorSettings['back_photo'].'; ' : '' !!}{!! isset($underlineSettings['back_photo']) && $underlineSettings['back_photo'] ? 'text-decoration: underline; ' : '' !!}">
            <div class="photo-box">
                <span>FOTO</span>
                <span style="margin-top: 0.5rem;">3X4</span>
            </div>
        </div>

        <div id="back_holder_signature" data-label="Tanda Tangan Pemilik" class="abs-text editable-element" style="left: {{ $xSettings['back_holder_signature'] ?? '35' }}mm; top: {{ $cleanSettings['back_holder_signature'] ?? '245' }}mm; font-size: {{ $fontSettings['back_holder_signature'] ?? '11' }}pt; text-align: left; {!! isset($fontFamilySettings['back_holder_signature']) ? 'font-family: '.$fontFamilySettings['back_holder_signature'].'; ' : '' !!}{!! isset($boldSettings['back_holder_signature']) ? ($boldSettings['back_holder_signature'] ? 'font-weight: bold; ' : 'font-weight: normal; ') : '' !!}{!! isset($italicSettings['back_holder_signature']) ? ($italicSettings['back_holder_signature'] ? 'font-style: italic; ' : 'font-style: normal; ') : '' !!}{!! isset($textAlignSettings['back_holder_signature']) ? 'text-align: '.$textAlignSettings['back_holder_signature'].'; ' : '' !!}{!! isset($colorSettings['back_holder_signature']) ? 'color: '.$colorSettings['back_holder_signature'].'; ' : 'color: #777; ' !!}{!! isset($underlineSettings['back_holder_signature']) && $underlineSettings['back_holder_signature'] ? 'text-decoration: underline; ' : '' !!}">
            <div style="font-weight: bold; text-decoration: underline; text-transform: uppercase; font-size: inherit;">{{ $certificate->participant_name }}</div>
            <div style="color: inherit; font-size: inherit;">Tanda tangan pemilik</div>
            <div style="font-style: italic; color: inherit; font-size: inherit;">(Signature of holder)</div>
        </div>

        <div id="back_manager_signature" data-label="Tanda Tangan Manajer" class="abs-text editable-element" style="left: {{ $xSettings['back_manager_signature'] ?? '135' }}mm; top: {{ $cleanSettings['back_manager_signature'] ?? '245' }}mm; font-size: {{ $fontSettings['back_manager_signature'] ?? '11' }}pt; text-align: center; {!! isset($fontFamilySettings['back_manager_signature']) ? 'font-family: '.$fontFamilySettings['back_manager_signature'].'; ' : '' !!}{!! isset($boldSettings['back_manager_signature']) ? ($boldSettings['back_manager_signature'] ? 'font-weight: bold; ' : 'font-weight: normal; ') : '' !!}{!! isset($italicSettings['back_manager_signature']) ? ($italicSettings['back_manager_signature'] ? 'font-style: italic; ' : 'font-style: normal; ') : '' !!}{!! isset($textAlignSettings['back_manager_signature']) ? 'text-align: '.$textAlignSettings['back_manager_signature'].'; ' : '' !!}{!! isset($colorSettings['back_manager_signature']) ? 'color: '.$colorSettings['back_manager_signature'].'; ' : 'color: #777; ' !!}{!! isset($underlineSettings['back_manager_signature']) && $underlineSettings['back_manager_signature'] ? 'text-decoration: underline; ' : '' !!}">
            <div style="font-weight: bold; color: inherit; font-size: inherit;">DRA. CRIANA MARDEWI, M.M.</div>
            <div style="color: inherit; font-size: inherit;">Manajer Sertifikasi</div>
            <div style="font-style: italic; color: inherit; font-size: inherit;">(Certification Manager)</div>
        </div>
    </div>
    
    @include('certificates.templates.editor_panel')
</body>
</html>
