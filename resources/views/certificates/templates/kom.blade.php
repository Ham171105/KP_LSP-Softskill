<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Komunikasi - {{ $certificate->certificate_number }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', serif;
            background-color: #f0f0f0;
        }
        .page {
            width: 297mm;
            height: 210mm; /* A4 Landscape */
            background: white;
            margin: 10mm auto;
            position: relative;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
            page-break-after: always;
        }
        /* Mode Print */
        @media print {
            body { background: none; }
            .page { margin: 0; box-shadow: none; border: none; }
            @page { size: A4 landscape; margin: 0; }
            .btn-print { display: none; }
        }
        
        /* Desain Depan */
        .front-page {
            padding: 20mm;
            text-align: center;
            border: 15px solid #10B981;
            box-sizing: border-box;
            background: linear-gradient(to bottom right, #ffffff, #ecfdf5);
        }
        .front-page h1 {
            font-size: 48px;
            color: #064e3b;
            margin-top: 30mm;
            text-transform: uppercase;
            letter-spacing: 5px;
        }
        .front-page .subtitle {
            font-size: 24px;
            color: #047857;
            margin-bottom: 20mm;
        }
        .front-page .given-to {
            font-size: 18px;
            color: #4b5563;
        }
        .front-page .name {
            font-size: 42px;
            font-weight: bold;
            color: #111827;
            margin: 10mm 0;
            text-decoration: underline;
        }
        .front-page .desc {
            font-size: 20px;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.5;
        }
        .front-page .id-number {
            position: absolute;
            bottom: 20mm;
            left: 20mm;
            font-size: 16px;
            font-family: monospace;
            color: #6b7280;
        }
        .front-page .date {
            position: absolute;
            bottom: 20mm;
            right: 20mm;
            font-size: 18px;
            font-weight: bold;
        }
        
        /* Desain Belakang */
        .back-page {
            padding: 30mm;
            box-sizing: border-box;
            border: 2px solid #ccc;
        }
        .back-page h2 {
            text-align: center;
            margin-bottom: 20mm;
            font-size: 28px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 18px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f3f4f6;
        }

        .btn-print {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #10B981;
            color: white;
            padding: 15px 25px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
            z-index: 1000;
        }
    </style>
</head>
<body>

    <button class="btn-print" onclick="window.print()">Cetak Sertifikat</button>

    <!-- Halaman Depan -->
    <div class="page front-page">
        <h1>Sertifikat Kompetensi</h1>
        <div class="subtitle">Bidang Komunikasi</div>
        
        <div class="given-to">Diberikan kepada:</div>
        <div class="name">{{ $certificate->participant_name }}</div>
        
        <div class="desc">
            Telah menyelesaikan pelatihan dan asesmen pada bidang <strong>Komunikasi Efektif</strong> dengan predikat <em>Sangat Memuaskan</em>.
        </div>
        
        <div class="id-number">No. Sertifikat: {{ $certificate->certificate_number }}</div>
        <div class="date">Diterbitkan: {{ \Carbon\Carbon::parse($certificate->issue_date)->translatedFormat('d F Y') }}</div>
    </div>

    <!-- Halaman Belakang -->
    <div class="page back-page">
        <h2>Transkrip Kompetensi - Komunikasi</h2>
        <table>
            <thead>
                <tr>
                    <th width="10%">No</th>
                    <th width="70%">Unit Kompetensi</th>
                    <th width="20%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Menerapkan Keterampilan Presentasi</td>
                    <td>Kompeten</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Komunikasi Asertif di Tempat Kerja</td>
                    <td>Kompeten</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Negosiasi dan Persuasi</td>
                    <td>Kompeten</td>
                </tr>
            </tbody>
        </table>
        
        <div style="margin-top: 40mm; text-align: right; padding-right: 20mm;">
            <p>Direktur LSP Soft Skill,</p>
            <br><br><br>
            <p style="font-weight: bold; text-decoration: underline;">Dr. Ahmad Subagyo, M.Si</p>
        </div>
    </div>

</body>
</html>
