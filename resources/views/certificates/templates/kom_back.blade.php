<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Belakang - Komunikasi</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #fff;
        }
        .page {
            width: 210mm;
            height: 297mm;
            position: relative;
            box-sizing: border-box;
            page-break-after: always;
            padding-top: 40mm; /* Adjust to match the pre-printed layout */
            padding-left: 20mm;
            padding-right: 20mm;
        }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .text-lg { font-size: 14pt; }
        .mt-8 { margin-top: 2rem; }
        .mt-12 { margin-top: 3rem; }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
            font-size: 11pt;
            border: 1px solid #000;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
        }
        th {
            background-color: transparent;
            text-align: center;
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
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            table { border: 1px solid #000 !important; }
            th, td { border: 1px solid #000 !important; }
        }
    </style>
</head>
<body>
    <button class="btn-print" onclick="window.print()">Cetak Halaman Belakang</button>

    <div class="page">
        <div class="text-center font-bold text-lg">Daftar Unit Kompetensi</div>
        <div class="text-center font-bold text-lg font-italic">List of Unit Competencies</div>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">No.</th>
                    <th style="width: 25%">Kode Unit<br><span style="font-style: italic; font-weight: normal;">Unit Code</span></th>
                    <th style="width: 70%">Judul Unit<br><span style="font-style: italic; font-weight: normal;">Unit Title</span></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1.</td>
                    <td>P.85SOF00.001.1</td>
                    <td>
                        Membangun Konsep Diri yang Positif dalam Bekerja<br>
                        <span style="font-style: italic;">Building a Positive Self-Concept at Work</span>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">2.</td>
                    <td>P.85SOF00.010.1</td>
                    <td>
                        Membangun Kemampuan dalam Pengelolaan Emosi<br>
                        <span style="font-style: italic;">Developing Emotional Management Skills</span>
                    </td>
                </tr>
                <!-- Anda bisa mengganti baris kompetensi di sini -->
            </tbody>
        </table>

        <div class="mt-8" style="text-align: right; padding-right: 10mm; font-size: 12pt;">
            Jakarta, {{ \Carbon\Carbon::parse($certificate->issue_date)->translatedFormat('d F Y') }}
        </div>
        
        <div class="mt-12" style="text-align: right; padding-right: 10mm;">
            <span class="font-bold" style="text-decoration: underline; font-size: 12pt;">Leli N. Winarini, M.Pd</span><br>
            <span style="font-size: 12pt;">(Manajer Sertifikasi / Certification Manager)</span>
        </div>
    </div>
</body>
</html>
