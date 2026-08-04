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
            box-sizing: border-box;
            padding: 35mm 20mm 25mm 20mm;
            display: flex;
            flex-direction: column;
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
            th, td { border: 1px solid #000 !important; }
            .photo-box { border: 1px solid #000 !important; }
        }
    
        .abs-text {
            position: absolute;
            transform: translateX(-50%);
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <button class="btn-print" onclick="printCertificate()">Cetak Halaman Belakang</button>

    <div class="page">
        <!-- Title -->
        <div id="back_header" data-label="Judul Daftar Unit" class="editable-element" style="left: {{ $xSettings['back_header'] ?? '0' }}mm; position: relative; top: {{ $cleanSettings['back_header'] ?? '0' }}mm; font-size: {{ $fontSettings['back_header'] ?? '14' }}pt;">
            <div class="header-title" style="font-size: inherit;">Daftar Unit Kompetensi</div>
            <div class="header-subtitle" style="font-size: inherit;">List of Unit (s) of competency</div>
        </div>

        <!-- Table -->
        <div id="back_table" data-label="Tabel Kompetensi" class="editable-element" style="left: {{ $xSettings['back_table'] ?? '0' }}mm; position: relative; top: {{ $cleanSettings['back_table'] ?? '0' }}mm; font-size: {{ $fontSettings['back_table'] ?? '11' }}pt;">
            <table style="font-size: inherit;">
                <thead>
                    <tr>
                        <th style="width: 5%"><span class="font-bold">No</span></th>
                        <th style="width: 20%"><span class="font-bold">Kode Unit</span><br><span style="font-style: italic; font-weight: normal;">Unit Code</span></th>
                        <th style="width: 75%"><span class="font-bold">Judul Unit</span><br><span style="font-style: italic; font-weight: normal;">Unit Title</span></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td class="text-center">P.85SOF00.001.1</td>
                        <td>
                            Membangun Konsep Diri yang Positif dalam Bekerja<br>
                            <span style="font-style: italic;">Building a Positive Self-Concept at Work</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td class="text-center">P.85SOF00.004.1</td>
                        <td>
                            Mengembangkan Kemampuan Berpikir Kritis dalam Memecahkan Masalah dan Mencari Solusi<br>
                            <span style="font-style: italic;">Developing Critical Thinking Skills for Problem Solving and Solution Finding</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td class="text-center">P.85SOF00.009.1</td>
                        <td>
                            Mengembangkan Kemampuan Menghadapi Tantangan di Tempat Kerja<br>
                            <span style="font-style: italic;">Developing Skills to Overcome Challenges in the Workplace</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

                                <!-- Footer Section Elements (Separated) -->
        <div id="back_date_text" data-label="Teks Tgl & Instansi" class="abs-text editable-element" style="left: {{ $xSettings['back_date_text'] ?? '110' }}mm; top: {{ $cleanSettings['back_date_text'] ?? '175' }}mm; font-size: {{ $fontSettings['back_date_text'] ?? '11' }}pt; text-align: right; width: 120mm;">
            <div style="margin-bottom: 0.5rem;">Jakarta, {{ \Carbon\Carbon::parse($certificate->issue_date)->locale('id')->translatedFormat('d F Y') }}</div>
            <div>Atas Nama Badan Nasional Sertifikasi Profesi</div>
            <div class="font-italic">On Behalf of Indonesia Professional Certification Authority</div>
            <div class="font-bold">Lembaga Sertifikasi Profesi Softskill Indonesia Kompeten</div>
            <div class="font-italic">Competent Indonesian Softskill Professional Certification Body</div>
        </div>

        <div id="back_photo" data-label="Kotak Foto 3x4" class="abs-text editable-element" style="left: {{ $xSettings['back_photo'] ?? '35' }}mm; top: {{ $cleanSettings['back_photo'] ?? '205' }}mm; font-size: {{ $fontSettings['back_photo'] ?? '11' }}pt;">
            <div class="photo-box">
                <span>FOTO</span>
                <span style="margin-top: 0.5rem;">3X4</span>
            </div>
        </div>

        <div id="back_holder_signature" data-label="Tanda Tangan Pemilik" class="abs-text editable-element" style="left: {{ $xSettings['back_holder_signature'] ?? '35' }}mm; top: {{ $cleanSettings['back_holder_signature'] ?? '250' }}mm; font-size: {{ $fontSettings['back_holder_signature'] ?? '11' }}pt; text-align: left;">
            <div class="font-bold" style="text-decoration: underline; text-transform: uppercase; font-size: inherit;">{{ $certificate->participant_name }}</div>
            <div style="color: #000; font-size: inherit;">Tanda tangan pemilik</div>
            <div class="font-italic" style="color: #000; font-size: inherit;">(Signature of holder)</div>
        </div>

        <div id="back_manager_signature" data-label="Tanda Tangan Manajer" class="abs-text editable-element" style="left: {{ $xSettings['back_manager_signature'] ?? '135' }}mm; top: {{ $cleanSettings['back_manager_signature'] ?? '250' }}mm; font-size: {{ $fontSettings['back_manager_signature'] ?? '11' }}pt; text-align: center;">
            <div class="font-bold" style="color: #000; font-size: inherit;">DRA. CRIANA MARDEWI, M.M.</div>
            <div style="color: #000; font-size: inherit;">Manajer Sertifikasi</div>
            <div class="font-italic" style="color: #000; font-size: inherit;">(Certification Manager)</div>
        </div>
    </div>
    
    @include('certificates.templates.editor_panel')
</body>
</html>
