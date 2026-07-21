import zipfile, re
z = zipfile.ZipFile(r'd:\KERJA PRAKTEK\System Sertifikasi\templates\Pemecahan Masalah - Depan.docx')
xml = z.read('word/document.xml').decode('utf-8')
paras = re.findall(r'<w:p[ >].*?</w:p>', xml)
print('Paragraph Spacings:')
for i, p in enumerate(paras):
    text = re.sub(r'<[^>]+>', '', p).strip()
    if not text: text = '[BLANK]'
    spacing_match = re.search(r'<w:spacing([^>]+)/>', p)
    spacing = spacing_match.group(1) if spacing_match else 'DEFAULT'
    sz_match = re.search(r'<w:sz w:val="(\d+)"', p)
    size = int(sz_match.group(1))/2 if sz_match else 'DEFAULT'
    print(f'{i+1:02d}: {spacing:30s} | Size: {str(size):4s} | {text[:50]}')
