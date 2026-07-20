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
            box-sizing: border-box;
            padding: 25mm 20mm 15mm 20mm;
            overflow: hidden;
        }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .font-italic { font-style: italic; }
        .text-lg { font-size: 14pt; }
        .mt-4 { margin-top: 1rem; }
        .mt-6 { margin-top: 1.5rem; }
        .mt-8 { margin-top: 2rem; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            font-size: 10pt;
            border: 1px solid #000;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: top;
        }
        th {
            background-color: transparent;
            text-align: center;
        }

        .atas-nama {
            text-align: center;
            font-size: 11pt;
            margin-top: 1.5rem;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
            font-size: 11pt;
        }
        .signature-left {
            text-align: center;
            width: 45%;
        }
        .signature-right {
            text-align: center;
            width: 45%;
        }
        .photo-placeholder {
            width: 30mm;
            height: 40mm;
            border: 1px dashed #999;
            margin: 0 auto 8px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8pt;
            color: #999;
        }
        .signature-space {
            height: 40mm;
            margin-bottom: 8px;
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
            .photo-placeholder { border: 1px dashed #ccc !important; }
        }
    </style>
</head>
<body>
    <button class="btn-print" onclick="window.print()">Cetak Halaman Belakang</button>

    <div class="page">
        <!-- Title -->
        <div class="text-center font-bold text-lg">Daftar Unit Kompetensi</div>
        <div class="text-center font-bold font-italic text-lg">List of Unit Competencies</div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 22%">Kode Unit<br><span style="font-style: italic; font-weight: normal;">Unit Code</span></th>
                    <th style="width: 73%">Judul Unit<br><span style="font-style: italic; font-weight: normal;">Unit Title</span></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>P.85SOF00.001.1</td>
                    <td>
                        Membangun Konsep Diri yang Positif dalam Bekerja<br>
                        <span style="font-style: italic;">Building a Positive Self-Concept at Work</span>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td>P.85SOF00.010.1</td>
                    <td>
                        Membangun Kemampuan dalam Pengelolaan Emosi<br>
                        <span style="font-style: italic;">Developing Emotional Management Skills</span>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td>P.85SOF00.014.1</td>
                    <td>
                        Meningkatkan Kualitas Penampilan Prima<br>
                        <span style="font-style: italic;">Enhancing Professional Presence and Presentation</span>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">4</td>
                    <td>P.85SOF00.017.1</td>
                    <td>
                        Membangun Kemampuan Komunikasi yang Efektif<br>
                        <span style="font-style: italic;">Building Effective Communication Skills</span>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">5</td>
                    <td>P.85SOF00.019.1</td>
                    <td>
                        Mengembangkan Kemampuan Bekerja Sama dalam Tim<br>
                        <span style="font-style: italic;">Developing Team Collaboration Skills</span>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Date -->
        <div class="mt-8" style="text-align: center; font-size: 11pt;">
            Jakarta, {{ \Carbon\Carbon::parse($certificate->issue_date)->translatedFormat('d F Y') }}
        </div>

        <!-- Atas Nama Section -->
        <div class="atas-nama">
            Atas Nama Badan Nasional Sertifikasi Profesi<br>
            <span class="font-italic">On Behalf of Indonesia Professional Certification Authority</span>
        </div>

        <div class="atas-nama" style="margin-top: 0.5rem;">
            <span class="font-bold">Lembaga Sertifikasi Profesi Softskill Indonesia Kompeten</span><br>
            <span class="font-italic">Competent Indonesian Softskill Professional Certification Body</span>
        </div>

        <!-- Dual Signature Section -->
        <div class="signature-section">
            <div class="signature-left">
                <div class="photo-placeholder">Foto 3x4</div>
                <span class="font-bold" style="text-decoration: underline; text-transform: uppercase;">{{ $certificate->participant_name }}</span><br>
                Tanda tangan pemilik<br>
                <span class="font-italic">(Signature of holder)</span>
            </div>
            <div class="signature-right">
                <div class="signature-space"></div>
                <span class="font-bold" style="text-decoration: underline;">Leli N. Winarini, M.Pd</span><br>
                Manajer Sertifikasi<br>
                <span class="font-italic">(Certification Manager)</span>
            </div>
        </div>
    </div>
</body>
</html>
