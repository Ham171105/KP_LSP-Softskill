<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Depan - Komunikasi</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}">
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 40px 0;
            font-family: Arial, sans-serif;
            background: #525659;
            color: #000;
            display: flex;
            justify-content: center;
        }
        .page {
            width: 210mm;
            height: 297mm;
            box-sizing: border-box;
            position: relative;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
            margin: 0 auto;
            overflow: hidden;
            background-image: url('{{ asset('images/bg_depan.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .abs-text {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: max-content;
            text-align: center;
            padding: 5px 10px;
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
        }
    </style>
</head>
<body>
    <button class="btn-print" onclick="printCertificate()">Cetak Halaman Depan</button>

    <div class="page text-11">
        
        <div id="no_bnsp" data-label="Nomor Sertifikat (BNSP)" class="abs-text font-bold editable-element" style="left: {{ $xSettings['no_bnsp'] ?? '105' }}mm; top: {{ $cleanSettings['no_bnsp'] ?? '75' }}mm; font-size: {{ $fontSettings['no_bnsp'] ?? '11' }}pt;">
            No. {{ $certificate->certificate_number }}
        </div>

        <div id="text_certify" data-label="Teks 'Dengan ini menyatakan bahwa'" class="abs-text editable-element" style="left: {{ $xSettings['text_certify'] ?? '105' }}mm; top: {{ $cleanSettings['text_certify'] ?? '88' }}mm; font-size: {{ $fontSettings['text_certify'] ?? '11' }}pt;">
            Dengan ini menyatakan bahwa,<br>
            <span class="font-italic">This is to certify that,</span>
        </div>

        <div id="participant_name" data-label="Nama Peserta & No. Reg" class="abs-text editable-element" style="left: {{ $xSettings['participant_name'] ?? '105' }}mm; top: {{ $cleanSettings['participant_name'] ?? '105' }}mm; font-size: {{ $fontSettings['participant_name'] ?? '14' }}pt;">
            <div class="font-bold" style="text-transform: uppercase; font-size: 1em;">
                {{ $certificate->participant_name }}
            </div>
            <div class="font-bold" style="margin-top: 2mm; font-size: 0.8em;">
                No. Reg. {{ $certificate->registration_number }}
            </div>
        </div>

        <div id="text_competent" data-label="Teks 'Telah kompeten pada bidang'" class="abs-text editable-element" style="left: {{ $xSettings['text_competent'] ?? '105' }}mm; top: {{ $cleanSettings['text_competent'] ?? '125' }}mm; font-size: {{ $fontSettings['text_competent'] ?? '11' }}pt;">
            Telah kompeten pada bidang :<br>
            <span class="font-italic">Is competent in the area of :</span>
        </div>

        <div id="area_title" data-label="Judul Bidang (Soft Skills)" class="abs-text editable-element" style="left: {{ $xSettings['area_title'] ?? '105' }}mm; top: {{ $cleanSettings['area_title'] ?? '140' }}mm; font-size: {{ $fontSettings['area_title'] ?? '12' }}pt;">
            <div class="font-bold">Keterampilan Non-Teknis</div>
            <div class="font-bold font-italic">Soft Skills</div>
        </div>

        <div id="text_qualification" data-label="Teks 'Dengan kualifikasi / Kompetensi'" class="abs-text editable-element" style="left: {{ $xSettings['text_qualification'] ?? '105' }}mm; top: {{ $cleanSettings['text_qualification'] ?? '155' }}mm; font-size: {{ $fontSettings['text_qualification'] ?? '11' }}pt;">
            Dengan kualifikasi / Kompetensi :<br>
            <span class="font-italic">With the Qualification / Competency :</span>
        </div>

        <div id="competency_title" data-label="Judul Kompetensi (Komunikasi)" class="abs-text editable-element" style="left: {{ $xSettings['competency_title'] ?? '105' }}mm; top: {{ $cleanSettings['competency_title'] ?? '170' }}mm; font-size: {{ $fontSettings['competency_title'] ?? '12' }}pt;">
            <div class="font-bold">Pengembangan Komunikasi Yang Efektif</div>
            <div class="font-bold font-italic">Effective Communication Development</div>
        </div>

        <div id="validity" data-label="Masa Berlaku" class="abs-text editable-element" style="left: {{ $xSettings['validity'] ?? '105' }}mm; top: {{ $cleanSettings['validity'] ?? '195' }}mm; font-size: {{ $fontSettings['validity'] ?? '11' }}pt;">
            Sertifikat berlaku untuk : 3 (tiga) tahun<br>
            <span class="font-italic">This certificate is valid for : 3 (three) years</span>
        </div>

        <div id="issue_date" data-label="Tempat, Tanggal Terbit" class="abs-text editable-element" style="left: {{ $xSettings['issue_date'] ?? '105' }}mm; top: {{ $cleanSettings['issue_date'] ?? '220' }}mm; font-size: {{ $fontSettings['issue_date'] ?? '11' }}pt;">
            Jakarta, {{ \Carbon\Carbon::parse($certificate->issue_date)->locale('id')->translatedFormat('d F Y') }}
        </div>

        <div id="signature_text" data-label="Teks Tanda Tangan" class="abs-text editable-element" style="left: {{ $xSettings['signature_text'] ?? '105' }}mm; top: {{ $cleanSettings['signature_text'] ?? '230' }}mm; line-height: 1.3; font-size: {{ $fontSettings['signature_text'] ?? '11' }}pt;">
            Atas Nama Badan Nasional Sertifikasi Profesi<br>
            <span class="font-italic">On Behalf of Indonesia Professional Certification Authority</span><br>
            Lembaga Sertifikasi Profesi Softskill Indonesia Kompeten<br>
            <span class="font-italic">Competent Indonesian Softskill Professional Certification Body</span>
        </div>

        <div id="signature_name" data-label="Nama Penandatangan" class="abs-text editable-element" style="left: {{ $xSettings['signature_name'] ?? '105' }}mm; top: {{ $cleanSettings['signature_name'] ?? '265' }}mm; font-size: {{ $fontSettings['signature_name'] ?? '12' }}pt;">
            <span class="font-bold" style="text-decoration: underline;">Puji Dwi Antono, S.Pi., M.SE</span><br>
            <span>(Direktur/ Director)</span>
        </div>
        
    </div>

    @include('certificates.templates.editor_panel')
</body>
</html>
