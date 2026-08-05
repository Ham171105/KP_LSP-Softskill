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
            padding: 40px 0;
            font-family: Tahoma, sans-serif;
            background: #525659;
            color: #000;
            display: flex;
            justify-content: center;
        }
        .page {
            width: 210mm;
            height: 297mm;
            min-height: 297mm;
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
        
        <div id="no_bnsp" data-label="Nomor Sertifikat (BNSP)" class="abs-text editable-element" style="left: {{ $xSettings['no_bnsp'] ?? '105' }}mm; top: {{ $cleanSettings['no_bnsp'] ?? '75' }}mm; font-size: {{ $fontSettings['no_bnsp'] ?? '11' }}pt; {!! isset($fontFamilySettings['no_bnsp']) ? 'font-family: '.$fontFamilySettings['no_bnsp'].'; ' : '' !!}{!! isset($boldSettings['no_bnsp']) ? ($boldSettings['no_bnsp'] ? 'font-weight: bold; ' : 'font-weight: normal; ') : 'font-weight: bold; ' !!}{!! isset($italicSettings['no_bnsp']) ? ($italicSettings['no_bnsp'] ? 'font-style: italic; ' : 'font-style: normal; ') : '' !!}{!! isset($textAlignSettings['no_bnsp']) ? 'text-align: '.$textAlignSettings['no_bnsp'].'; ' : '' !!}{!! isset($colorSettings['no_bnsp']) ? 'color: '.$colorSettings['no_bnsp'].'; ' : '' !!}{!! isset($underlineSettings['no_bnsp']) && $underlineSettings['no_bnsp'] ? 'text-decoration: underline; ' : '' !!}">
            No. {{ $certificate->certificate_number }}
        </div>

        <div id="text_certify" data-label="Teks 'Dengan ini menyatakan bahwa'" class="abs-text editable-element" style="left: {{ $xSettings['text_certify'] ?? '105' }}mm; top: {{ $cleanSettings['text_certify'] ?? '88' }}mm; font-size: {{ $fontSettings['text_certify'] ?? '11' }}pt; {!! isset($fontFamilySettings['text_certify']) ? 'font-family: '.$fontFamilySettings['text_certify'].'; ' : '' !!}{!! isset($boldSettings['text_certify']) ? ($boldSettings['text_certify'] ? 'font-weight: bold; ' : 'font-weight: normal; ') : '' !!}{!! isset($italicSettings['text_certify']) ? ($italicSettings['text_certify'] ? 'font-style: italic; ' : 'font-style: normal; ') : '' !!}{!! isset($textAlignSettings['text_certify']) ? 'text-align: '.$textAlignSettings['text_certify'].'; ' : '' !!}{!! isset($colorSettings['text_certify']) ? 'color: '.$colorSettings['text_certify'].'; ' : '' !!}{!! isset($underlineSettings['text_certify']) && $underlineSettings['text_certify'] ? 'text-decoration: underline; ' : '' !!}">
            Dengan ini menyatakan bahwa,<br>
            <span style="font-style: italic;">This is to certify that,</span>
        </div>

        <div id="participant_name" data-label="Nama Peserta & No. Reg" class="abs-text editable-element" style="left: {{ $xSettings['participant_name'] ?? '105' }}mm; top: {{ $cleanSettings['participant_name'] ?? '105' }}mm; font-size: {{ $fontSettings['participant_name'] ?? '14' }}pt; {!! isset($fontFamilySettings['participant_name']) ? 'font-family: '.$fontFamilySettings['participant_name'].'; ' : '' !!}{!! isset($boldSettings['participant_name']) ? ($boldSettings['participant_name'] ? 'font-weight: bold; ' : 'font-weight: normal; ') : '' !!}{!! isset($italicSettings['participant_name']) ? ($italicSettings['participant_name'] ? 'font-style: italic; ' : 'font-style: normal; ') : '' !!}{!! isset($textAlignSettings['participant_name']) ? 'text-align: '.$textAlignSettings['participant_name'].'; ' : '' !!}{!! isset($colorSettings['participant_name']) ? 'color: '.$colorSettings['participant_name'].'; ' : '' !!}{!! isset($underlineSettings['participant_name']) && $underlineSettings['participant_name'] ? 'text-decoration: underline; ' : '' !!}">
            <div style="font-weight: bold; text-transform: uppercase; font-size: 1em;">
                {{ $certificate->participant_name }}
            </div>
            <div style="font-weight: bold; margin-top: 2mm; font-size: 0.8em;">
                No. Reg. {{ $certificate->registration_number }}
            </div>
        </div>

        <div id="text_competent" data-label="Teks 'Telah kompeten pada bidang'" class="abs-text editable-element" style="left: {{ $xSettings['text_competent'] ?? '105' }}mm; top: {{ $cleanSettings['text_competent'] ?? '125' }}mm; font-size: {{ $fontSettings['text_competent'] ?? '11' }}pt; {!! isset($fontFamilySettings['text_competent']) ? 'font-family: '.$fontFamilySettings['text_competent'].'; ' : '' !!}{!! isset($boldSettings['text_competent']) ? ($boldSettings['text_competent'] ? 'font-weight: bold; ' : 'font-weight: normal; ') : '' !!}{!! isset($italicSettings['text_competent']) ? ($italicSettings['text_competent'] ? 'font-style: italic; ' : 'font-style: normal; ') : '' !!}{!! isset($textAlignSettings['text_competent']) ? 'text-align: '.$textAlignSettings['text_competent'].'; ' : '' !!}{!! isset($colorSettings['text_competent']) ? 'color: '.$colorSettings['text_competent'].'; ' : '' !!}{!! isset($underlineSettings['text_competent']) && $underlineSettings['text_competent'] ? 'text-decoration: underline; ' : '' !!}">
            Telah kompeten pada bidang :<br>
            <span style="font-style: italic;">Is competent in the area of :</span>
        </div>

        <div id="area_title" data-label="Judul Bidang (Soft Skills)" class="abs-text editable-element" style="left: {{ $xSettings['area_title'] ?? '105' }}mm; top: {{ $cleanSettings['area_title'] ?? '140' }}mm; font-size: {{ $fontSettings['area_title'] ?? '12' }}pt; {!! isset($fontFamilySettings['area_title']) ? 'font-family: '.$fontFamilySettings['area_title'].'; ' : '' !!}{!! isset($boldSettings['area_title']) ? ($boldSettings['area_title'] ? 'font-weight: bold; ' : 'font-weight: normal; ') : '' !!}{!! isset($italicSettings['area_title']) ? ($italicSettings['area_title'] ? 'font-style: italic; ' : 'font-style: normal; ') : '' !!}{!! isset($textAlignSettings['area_title']) ? 'text-align: '.$textAlignSettings['area_title'].'; ' : '' !!}{!! isset($colorSettings['area_title']) ? 'color: '.$colorSettings['area_title'].'; ' : '' !!}{!! isset($underlineSettings['area_title']) && $underlineSettings['area_title'] ? 'text-decoration: underline; ' : '' !!}">
            <div style="font-weight: bold;">Keterampilan Non-Teknis</div>
            <div style="font-weight: bold; font-style: italic;">Soft Skills</div>
        </div>

        <div id="text_qualification" data-label="Teks 'Dengan kualifikasi / Kompetensi'" class="abs-text editable-element" style="left: {{ $xSettings['text_qualification'] ?? '105' }}mm; top: {{ $cleanSettings['text_qualification'] ?? '155' }}mm; font-size: {{ $fontSettings['text_qualification'] ?? '11' }}pt; {!! isset($fontFamilySettings['text_qualification']) ? 'font-family: '.$fontFamilySettings['text_qualification'].'; ' : '' !!}{!! isset($boldSettings['text_qualification']) ? ($boldSettings['text_qualification'] ? 'font-weight: bold; ' : 'font-weight: normal; ') : '' !!}{!! isset($italicSettings['text_qualification']) ? ($italicSettings['text_qualification'] ? 'font-style: italic; ' : 'font-style: normal; ') : '' !!}{!! isset($textAlignSettings['text_qualification']) ? 'text-align: '.$textAlignSettings['text_qualification'].'; ' : '' !!}{!! isset($colorSettings['text_qualification']) ? 'color: '.$colorSettings['text_qualification'].'; ' : '' !!}{!! isset($underlineSettings['text_qualification']) && $underlineSettings['text_qualification'] ? 'text-decoration: underline; ' : '' !!}">
            Dengan kualifikasi / Kompetensi :<br>
            <span style="font-style: italic;">With the Qualification / Competency :</span>
        </div>

        <div id="competency_title" data-label="Judul Kompetensi (Pemecahan Masalah)" class="abs-text editable-element" style="left: {{ $xSettings['competency_title'] ?? '105' }}mm; top: {{ $cleanSettings['competency_title'] ?? '170' }}mm; font-size: {{ $fontSettings['competency_title'] ?? '12' }}pt; {!! isset($fontFamilySettings['competency_title']) ? 'font-family: '.$fontFamilySettings['competency_title'].'; ' : '' !!}{!! isset($boldSettings['competency_title']) ? ($boldSettings['competency_title'] ? 'font-weight: bold; ' : 'font-weight: normal; ') : '' !!}{!! isset($italicSettings['competency_title']) ? ($italicSettings['competency_title'] ? 'font-style: italic; ' : 'font-style: normal; ') : '' !!}{!! isset($textAlignSettings['competency_title']) ? 'text-align: '.$textAlignSettings['competency_title'].'; ' : '' !!}{!! isset($colorSettings['competency_title']) ? 'color: '.$colorSettings['competency_title'].'; ' : '' !!}{!! isset($underlineSettings['competency_title']) && $underlineSettings['competency_title'] ? 'text-decoration: underline; ' : '' !!}">
            <div style="font-weight: bold;">Pemecahan Masalah</div>
            <div style="font-weight: bold; font-style: italic;">Problem Solving</div>
        </div>

        <div id="validity" data-label="Masa Berlaku" class="abs-text editable-element" style="left: {{ $xSettings['validity'] ?? '105' }}mm; top: {{ $cleanSettings['validity'] ?? '195' }}mm; font-size: {{ $fontSettings['validity'] ?? '11' }}pt; {!! isset($fontFamilySettings['validity']) ? 'font-family: '.$fontFamilySettings['validity'].'; ' : '' !!}{!! isset($boldSettings['validity']) ? ($boldSettings['validity'] ? 'font-weight: bold; ' : 'font-weight: normal; ') : '' !!}{!! isset($italicSettings['validity']) ? ($italicSettings['validity'] ? 'font-style: italic; ' : 'font-style: normal; ') : '' !!}{!! isset($textAlignSettings['validity']) ? 'text-align: '.$textAlignSettings['validity'].'; ' : '' !!}{!! isset($colorSettings['validity']) ? 'color: '.$colorSettings['validity'].'; ' : '' !!}{!! isset($underlineSettings['validity']) && $underlineSettings['validity'] ? 'text-decoration: underline; ' : '' !!}">
            Sertifikat berlaku untuk : 3 (tiga) tahun<br>
            <span style="font-style: italic;">This certificate is valid for : 3 (three) years</span>
        </div>

        <div id="issue_date" data-label="Tempat, Tanggal Terbit" class="abs-text editable-element" style="left: {{ $xSettings['issue_date'] ?? '105' }}mm; top: {{ $cleanSettings['issue_date'] ?? '220' }}mm; font-size: {{ $fontSettings['issue_date'] ?? '11' }}pt; {!! isset($fontFamilySettings['issue_date']) ? 'font-family: '.$fontFamilySettings['issue_date'].'; ' : '' !!}{!! isset($boldSettings['issue_date']) ? ($boldSettings['issue_date'] ? 'font-weight: bold; ' : 'font-weight: normal; ') : '' !!}{!! isset($italicSettings['issue_date']) ? ($italicSettings['issue_date'] ? 'font-style: italic; ' : 'font-style: normal; ') : '' !!}{!! isset($textAlignSettings['issue_date']) ? 'text-align: '.$textAlignSettings['issue_date'].'; ' : '' !!}{!! isset($colorSettings['issue_date']) ? 'color: '.$colorSettings['issue_date'].'; ' : '' !!}{!! isset($underlineSettings['issue_date']) && $underlineSettings['issue_date'] ? 'text-decoration: underline; ' : '' !!}">
            Jakarta, {{ \Carbon\Carbon::parse($certificate->issue_date)->locale('id')->translatedFormat('d F Y') }}
        </div>

        <div id="signature_text" data-label="Teks Tanda Tangan" class="abs-text editable-element" style="left: {{ $xSettings['signature_text'] ?? '105' }}mm; top: {{ $cleanSettings['signature_text'] ?? '230' }}mm; line-height: 1.3; font-size: {{ $fontSettings['signature_text'] ?? '11' }}pt; {!! isset($fontFamilySettings['signature_text']) ? 'font-family: '.$fontFamilySettings['signature_text'].'; ' : '' !!}{!! isset($boldSettings['signature_text']) ? ($boldSettings['signature_text'] ? 'font-weight: bold; ' : 'font-weight: normal; ') : '' !!}{!! isset($italicSettings['signature_text']) ? ($italicSettings['signature_text'] ? 'font-style: italic; ' : 'font-style: normal; ') : '' !!}{!! isset($textAlignSettings['signature_text']) ? 'text-align: '.$textAlignSettings['signature_text'].'; ' : '' !!}{!! isset($colorSettings['signature_text']) ? 'color: '.$colorSettings['signature_text'].'; ' : '' !!}{!! isset($underlineSettings['signature_text']) && $underlineSettings['signature_text'] ? 'text-decoration: underline; ' : '' !!}">
            Atas Nama Badan Nasional Sertifikasi Profesi<br>
            <span style="font-style: italic;">On Behalf of Indonesia Professional Certification Authority</span><br>
            Lembaga Sertifikasi Profesi Softskill Indonesia Kompeten<br>
            <span style="font-style: italic;">Competent Indonesian Softskill Professional Certification Body</span>
        </div>

        <div id="signature_name" data-label="Nama Penandatangan" class="abs-text editable-element" style="left: {{ $xSettings['signature_name'] ?? '105' }}mm; top: {{ $cleanSettings['signature_name'] ?? '265' }}mm; font-size: {{ $fontSettings['signature_name'] ?? '12' }}pt; {!! isset($fontFamilySettings['signature_name']) ? 'font-family: '.$fontFamilySettings['signature_name'].'; ' : '' !!}{!! isset($boldSettings['signature_name']) ? ($boldSettings['signature_name'] ? 'font-weight: bold; ' : 'font-weight: normal; ') : '' !!}{!! isset($italicSettings['signature_name']) ? ($italicSettings['signature_name'] ? 'font-style: italic; ' : 'font-style: normal; ') : '' !!}{!! isset($textAlignSettings['signature_name']) ? 'text-align: '.$textAlignSettings['signature_name'].'; ' : '' !!}{!! isset($colorSettings['signature_name']) ? 'color: '.$colorSettings['signature_name'].'; ' : '' !!}{!! isset($underlineSettings['signature_name']) && $underlineSettings['signature_name'] ? 'text-decoration: underline; ' : '' !!}">
            <span style="font-weight: bold; text-decoration: underline;">Puji Dwi Antono, S.Pi., M.SE</span><br>
            <span>(Direktur/ Director)</span>
        </div>
        
    </div>

    @include('certificates.templates.editor_panel')
</body>
</html>
