<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Belakang - Komunikasi</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}">
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
            color: #000;
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
        
        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            color: #555;
        }
        .header-subtitle {
            text-align: center;
            font-style: italic;
            font-size: 14pt;
            color: #555;
            margin-bottom: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
            border: 1px solid #000;
            color: #000;
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

        .footer-section {
            margin-top: 2rem;
            color: #555;
            font-size: 11pt;
        }

        .footer-text-right {
            text-align: right;
        }

        .signature-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 2rem;
        }

        .signature-left {
            display: flex;
            gap: 1.5rem;
            align-items: flex-end;
        }

        .photo-box {
            width: 30mm;
            height: 40mm;
            border: 1px solid #000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 9pt;
            color: #000;
        }

        .holder-signature {
            text-align: center;
        }

        .manager-signature {
            text-align: center;
            padding-bottom: 2mm;
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
            .photo-box { border: 1px solid #000 !important; }
        }
    </style>
</head>
<body>
    <button class="btn-print" onclick="window.print()">Cetak Halaman Belakang</button>

    <div class="page">
        <!-- Title -->
        <div class="header-title">Daftar Unit Kompetensi</div>
        <div class="header-subtitle">List of Unit (s) of competency</div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th style="width: 5%"><span class="font-bold">No</span></th>
                    <th style="width: 22%"><span class="font-bold">Kode Unit</span><br><span style="font-style: italic; font-weight: normal;">Unit Code</span></th>
                    <th style="width: 73%"><span class="font-bold">Judul Unit</span><br><span style="font-style: italic; font-weight: normal;">Unit Title</span></th>
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
                    <td class="text-center">P.85SOF00.010.1</td>
                    <td>
                        Membangun Kemampuan dalam Pengelolaan Emosi<br>
                        <span style="font-style: italic;">Developing Emotional Management Skills</span>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td class="text-center">P.85SOF00.014.1</td>
                    <td>
                        Meningkatkan Kualitas Penampilan Prima<br>
                        <span style="font-style: italic;">Enhancing Professional Presence and Presentation</span>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">4</td>
                    <td class="text-center">P.85SOF00.017.1</td>
                    <td>
                        Membangun Kemampuan Komunikasi yang Efektif<br>
                        <span style="font-style: italic;">Building Effective Communication Skills</span>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">5</td>
                    <td class="text-center">P.85SOF00.019.1</td>
                    <td>
                        Mengembangkan Kemampuan Bekerja Sama dalam Tim<br>
                        <span style="font-style: italic;">Developing Team Collaboration Skills</span>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Footer Section -->
        <div class="footer-section">
            <div class="footer-text-right">
                <div>Jakarta, {{ \Carbon\Carbon::parse($certificate->issue_date)->translatedFormat('d F Y') }}</div>
                <div style="margin-top: 0.5rem;">Atas Nama Badan Nasional Sertifikasi Profesi</div>
                <div class="font-italic">On Behalf of Indonesia Professional Certification Authority</div>
                <div class="font-bold" style="margin-top: 0.25rem;">Lembaga Sertifikasi Profesi Softskill Indonesia Kompeten</div>
                <div class="font-italic">Competent Indonesian Softskill Professional Certification Body</div>
            </div>

            <!-- Signatures -->
            <div class="signature-container">
                <!-- Left: Foto and Holder Signature -->
                <div class="signature-left">
                    <div class="photo-box">
                        <span>FOTO</span>
                        <span style="margin-top: 0.5rem;">3X4</span>
                    </div>
                    <div class="holder-signature">
                        <div class="font-bold" style="text-decoration: underline; text-transform: uppercase;">{{ $certificate->participant_name }}</div>
                        <div>Tanda tangan pemilik</div>
                        <div class="font-italic">(Signature of holder)</div>
                    </div>
                </div>

                <!-- Right: Manager Signature -->
                <div class="manager-signature">
                    <div class="font-bold">DRA. CRIANA MARDEWI, M.M.</div>
                    <div>Manajer Sertifikasi</div>
                    <div class="font-italic">(Certification Manager)</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
