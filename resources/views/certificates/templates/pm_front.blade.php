<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Depan - Pemecahan Masalah</title>
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
            /* padding removed because we are using absolute positioning */
            position: relative;
        }
        .abs-text {
            position: absolute;
            left: 0;
            width: 100%;
            text-align: center;
        }
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
        
        <div class="abs-text font-bold" style="top: 75mm;">
            No. {{ $certificate->certificate_number }}
        </div>

        <div class="abs-text" style="top: 88mm;">
            Dengan ini menyatakan bahwa,<br>
            <span class="font-italic">This is to certify that,</span>
        </div>

        <div class="abs-text" style="top: 105mm;">
            <div class="font-bold text-14" style="text-transform: uppercase;">
                {{ $certificate->participant_name }}
            </div>
            <div class="font-bold" style="margin-top: 2mm;">
                No. Reg. {{ $certificate->registration_number }}
            </div>
        </div>

        <div class="abs-text" style="top: 125mm;">
            Telah kompeten pada bidang :<br>
            <span class="font-italic">Is competent in the area of :</span>
        </div>

        <div class="abs-text" style="top: 140mm;">
            <div class="font-bold text-12">Keterampilan Non-Teknis</div>
            <div class="font-bold font-italic text-12">Soft Skills</div>
        </div>

        <div class="abs-text" style="top: 155mm;">
            Dengan kualifikasi / Kompetensi :<br>
            <span class="font-italic">With the Qualification / Competency :</span>
        </div>

        <div class="abs-text" style="top: 170mm;">
            <div class="font-bold text-12">Pemecahan Masalah</div>
            <div class="font-bold font-italic text-12">Problem Solving</div>
        </div>

        <div class="abs-text" style="top: 195mm;">
            Sertifikat berlaku untuk : 3 (tiga) tahun<br>
            <span class="font-italic">This certificate is valid for : 3 (three) years</span>
        </div>

        <div class="abs-text" style="top: 220mm;">
            Jakarta, {{ \Carbon\Carbon::parse($certificate->issue_date)->translatedFormat('d F Y') }}
        </div>

        <div class="abs-text" style="top: 230mm; line-height: 1.3;">
            Atas Nama Badan Nasional Sertifikasi Profesi<br>
            <span class="font-italic">On Behalf of Indonesia Professional Certification Authority</span><br>
            Lembaga Sertifikasi Profesi Softskill Indonesia Kompeten<br>
            <span class="font-italic">Competent Indonesian Softskill Professional Certification Body</span>
        </div>

        <div class="abs-text" style="top: 265mm;">
            <span class="font-bold text-12" style="text-decoration: underline;">Puji Dwi Antono, S.Pi., M.SE</span><br>
            <span class="text-12">(Direktur/ Director)</span>
        </div>
        
    </div>
</body>
</html>
