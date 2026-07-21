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
            padding: 100mm 20mm 15mm 20mm; /* Match exact 10cm gap from physical paper */
            text-align: center;
            overflow: hidden;
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
        <div class="font-bold mb-8pt">No. {{ $certificate->certificate_number }}</div>

        <div class="mb-8pt">
            Dengan ini menyatakan bahwa,<br>
            <span class="font-italic">This is to certify that,</span>
        </div>

        <div>
            <div class="font-bold text-14" style="text-transform: uppercase;">
                {{ $certificate->participant_name }}
            </div>
            <div class="font-bold mb-8pt">
                No. Reg. {{ $certificate->registration_number }}
            </div>
        </div>

        <div class="mb-8pt">
            Telah kompeten pada bidang :<br>
            <span class="font-italic">Is competent in the area of :</span>
        </div>

        <div class="mb-8pt">
            <div class="font-bold text-12">Keterampilan Non-Teknis</div>
            <div class="font-bold font-italic text-12">Soft Skills</div>
        </div>

        <div class="mb-8pt">
            Dengan kualifikasi / Kompetensi :<br>
            <span class="font-italic">With the Qualification / Competency :</span>
        </div>

        <div class="mb-25pt">
            <div class="font-bold text-12">Pengembangan Kepemimpinan</div>
            <div class="font-bold font-italic text-12">Leadership Development</div>
        </div>

        <div class="mb-13pt">
            Sertifikat berlaku untuk : 3 (tiga) tahun<br>
            <span class="font-italic">This certificate is valid for : 3 (three) years</span>
        </div>

        <div class="mb-13pt">
            Jakarta, {{ \Carbon\Carbon::parse($certificate->issue_date)->translatedFormat('d F Y') }}
        </div>

        <div class="mb-71pt">
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
