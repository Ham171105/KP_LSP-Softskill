<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Depan - Kepemimpinan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}">
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Tahoma', sans-serif;
            background: #fff;
            color: #000;
            line-height: 1.15;
        }
        .page {
            width: 210mm;
            height: 297mm;
            box-sizing: border-box;
            padding: 80mm 20mm 15mm 20mm; /* Adjust top padding to bring text higher */
            text-align: center;
            overflow: hidden;
            background-image: url('{{ asset('images/bg_depan.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .text-11 { font-size: 11pt; }
        .text-12 { font-size: 12pt; }
        .text-14 { font-size: 14pt; }
        .font-bold { font-weight: bold; }
        .font-italic { font-style: italic; }
        
        .mb-8pt { margin-bottom: 10pt; } /* Word default spacing after (was 8pt, corrected to 10pt) */
        .mb-13pt { margin-bottom: 13pt; } /* 1 blank line of 11pt */
        .mb-25pt { margin-bottom: 25pt; } /* Exact w:after="500" from Word */
        .mb-71pt { margin-bottom: 71pt; } /* 6 blank lines + 11pt after */

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
        }
    </style>
</head>
<body>
    <button class="btn-print" onclick="window.print()">Cetak Halaman Depan</button>

    <div class="page text-11">
        <div class="font-bold" style="margin-bottom: 3mm;">No. {{ $certificate->certificate_number }}</div>

        <div style="margin-bottom: 8mm;">
            Dengan ini menyatakan bahwa,<br>
            <span class="font-italic">This is to certify that,</span>
        </div>

        <div style="margin-bottom: 8mm;">
            <div class="font-bold text-14" style="text-transform: uppercase;">
                {{ $certificate->participant_name }}
            </div>
            <div class="font-bold" style="margin-top: 1mm;">
                No. Reg. {{ $certificate->registration_number }}
            </div>
        </div>

        <div style="margin-bottom: 4mm;">
            Telah kompeten pada bidang :<br>
            <span class="font-italic">Is competent in the area of :</span>
        </div>

        <div style="margin-bottom: 4mm;">
            <div class="font-bold text-12">Keterampilan Non-Teknis</div>
            <div class="font-bold font-italic text-12">Soft Skills</div>
        </div>

        <div style="margin-bottom: 4mm;">
            Dengan kualifikasi / Kompetensi :<br>
            <span class="font-italic">With the Qualification / Competency :</span>
        </div>

        <div style="margin-bottom: 8mm;">
            <div class="font-bold text-12">Pengembangan Kepemimpinan</div>
            <div class="font-bold font-italic text-12">Leadership Development</div>
        </div>

        <div style="margin-bottom: 15mm;">
            Sertifikat berlaku untuk : 3 (tiga) tahun<br>
            <span class="font-italic">This certificate is valid for : 3 (three) years</span>
        </div>

        <div style="margin-bottom: 3mm;">
            Jakarta, {{ \Carbon\Carbon::parse($certificate->issue_date)->translatedFormat('d F Y') }}
        </div>

        <div style="margin-bottom: 18mm; line-height: 1.3;">
            Atas Nama Badan Nasional Sertifikasi Profesi<br>
            <span class="font-italic">On Behalf of Indonesia Professional Certification Authority</span><br>
            Lembaga Sertifikasi Profesi Softskill Indonesia Kompeten<br>
            <span class="font-italic">Competent Indonesian Softskill Professional Certification Body</span>
        </div>

        <div>
            <span class="font-bold text-12" style="text-decoration: underline;">Puji Dwi Antono, S.Pi., M.SE</span><br>
            <span class="text-12">(Direktur/ Director)</span>
        </div>
    </div>
</body>
</html>
