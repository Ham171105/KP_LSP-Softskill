<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Depan - Komunikasi</title>
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
            padding-top: 50mm; /* Adjust to match the pre-printed layout */
            padding-left: 20mm;
            padding-right: 20mm;
            text-align: center;
        }
        .text-md { font-size: 14pt; line-height: 1.4; }
        .text-lg { font-size: 16pt; line-height: 1.4; }
        .text-xl { font-size: 22pt; line-height: 1.4; }
        .font-bold { font-weight: bold; }
        .font-italic { font-style: italic; }
        .mt-4 { margin-top: 1rem; }
        .mt-8 { margin-top: 2rem; }
        .mt-12 { margin-top: 3rem; }
        
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

    <div class="page">
        <div class="font-bold text-md mt-12">No. {{ $certificate->certificate_number }}</div>

        <div class="mt-8 text-md">
            Dengan ini menyatakan bahwa,<br>
            <span class="font-italic">This is to certify that,</span>
        </div>

        <div class="font-bold text-xl mt-8" style="text-transform: uppercase;">
            {{ $certificate->participant_name }}
        </div>
        <div class="font-bold text-md">
            No. Reg. {{ $certificate->registration_number }}
        </div>

        <div class="mt-8 text-md">
            Telah kompeten pada bidang :<br>
            <span class="font-italic">Is competent in the area of :</span>
        </div>

        <div class="font-bold text-lg mt-4">Keterampilan Non-Teknis</div>
        <div class="font-bold font-italic text-lg">Soft Skills</div>

        <div class="mt-8 text-md">
            Dengan kualifikasi / Kompetensi :<br>
            <span class="font-italic">With the Qualification / Competency :</span>
        </div>

        <div class="font-bold text-lg mt-4">Pengembangan Komunikasi Yang Efektif</div>
        <div class="font-bold font-italic text-lg">Effective Communication Development</div>

        <div class="mt-8 text-md">
            Sertifikat berlaku untuk : 3 (tiga) tahun<br>
            <span class="font-italic">This certificate is valid for : 3 (three) years</span>
        </div>

        <div class="mt-8 text-md">
            Jakarta, {{ \Carbon\Carbon::parse($certificate->issue_date)->translatedFormat('d F Y') }}
        </div>

        <div class="mt-4 text-md">
            Atas Nama Badan Nasional Sertifikasi Profesi<br>
            <span class="font-italic">On Behalf of Indonesia Professional Certification Authority</span><br>
            Lembaga Sertifikasi Profesi Softskill Indonesia Kompeten<br>
            <span class="font-italic">Competent Indonesian Softskill Professional Certification Body</span>
        </div>

        <div class="mt-12 text-md">
            <span class="font-bold" style="text-decoration: underline;">Puji Dwi Antono, S.Pi., M.SE</span><br>
            (Direktur/ Director)
        </div>
    </div>
</body>
</html>
