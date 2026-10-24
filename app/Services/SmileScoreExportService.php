<?php

namespace App\Services;

use App\Models\SmileScoreSubmission;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

class SmileScoreExportService
{
    protected SmileScoreService $questionnaireService;

    public function __construct(SmileScoreService $questionnaireService)
    {
        $this->questionnaireService = $questionnaireService;
    }

    /**
     * Sanitasi teks untuk mencegah Formula Injection (CSV / Excel Injection).
     * Jika string diawali dengan =, +, -, @, \t, atau \r, tambahkan tanda petik tunggal.
     */
    public function sanitizeValue($value): string
    {
        if ($value === null) {
            return '';
        }
        $str = (string) $value;
        if ($str !== '' && in_array($str[0], ['=', '+', '-', '@', "\t", "\r"], true)) {
            return "'" . $str;
        }
        return $str;
    }

    /**
     * Ekspor data responden dan hasil kuesioner ke format CSV (UTF-8 BOM, kompatibel Excel & SPSS).
     */
    public function exportCsv(Collection $submissions, string $filename): StreamedResponse
    {
        $answerKeys = $this->getAnswerKeys();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($submissions, $answerKeys) {
            $output = fopen('php://output', 'w');

            // Tulis UTF-8 BOM agar Microsoft Excel Windows mengenali encoding karakter dengan sempurna
            fwrite($output, "\xEF\xBB\xBF");

            // Susun Header Kolom CSV
            $headerRow = [
                'respondent_id',
                'nama_lengkap',
                'usia',
                'jenis_kelamin',
                'kelas',
                'tanggal_pengerjaan',
                'status_pengerjaan',
                'jumlah_soal_dijawab',
                'jumlah_benar',
                'jumlah_salah',
                'nilai_persentase',
                'kategori_smile_score',
                'kode_kategori_spss', // 1=Baik, 2=Cukup, 3=Kurang baik
            ];

            // Tambahkan kolom jawaban Q01 - Q20
            for ($i = 1; $i <= 20; $i++) {
                $headerRow[] = sprintf('Q%02d', $i);
            }

            // Tambahkan kolom evaluasi Q01_correct - Q20_correct
            for ($i = 1; $i <= 20; $i++) {
                $headerRow[] = sprintf('Q%02d_correct', $i);
            }

            fputcsv($output, $headerRow);

            // Tulis Baris Data
            foreach ($submissions as $sub) {
                $answers = is_array($sub->answers) ? $sub->answers : [];
                $isCompleted = ($sub->status === 'completed');

                // Kode numerik untuk SPSS
                $spssCategoryCode = match ($sub->category) {
                    'Baik' => 1,
                    'Cukup' => 2,
                    'Kurang baik', 'Kurang' => 3,
                    default => '',
                };

                $row = [
                    $this->sanitizeValue($sub->formatted_id),
                    $this->sanitizeValue($sub->name),
                    $sub->age,
                    $this->sanitizeValue($sub->gender),
                    $this->sanitizeValue($sub->class_name),
                    $sub->created_at ? $sub->created_at->format('Y-m-d H:i:s') : '',
                    $sub->status,
                    $sub->answered_count ?? count($answers),
                    $isCompleted ? $sub->correct_count : 0,
                    $isCompleted ? (20 - $sub->correct_count) : 0,
                    $isCompleted ? $sub->percentage : 0,
                    $this->sanitizeValue($sub->category),
                    $spssCategoryCode,
                ];

                // Nilai opsi jawaban Q01 - Q20
                for ($i = 1; $i <= 20; $i++) {
                    $ans = isset($answers[$i]) ? strtolower(trim((string) $answers[$i])) : '';
                    $row[] = $this->sanitizeValue($ans);
                }

                // Nilai kebenaran biner Q01_correct - Q20_correct
                for ($i = 1; $i <= 20; $i++) {
                    if (isset($answers[$i]) && $answers[$i] !== '') {
                        $ans = strtolower(trim((string) $answers[$i]));
                        $key = $answerKeys[$i] ?? '';
                        $row[] = ($ans === $key) ? 1 : 0;
                    } else {
                        // Kosong jika belum dijawab
                        $row[] = '';
                    }
                }

                fputcsv($output, $row);
            }

            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Ekspor data ke file Excel (.xlsx) OpenXML dengan 2 Sheet:
     * Sheet 1: "Data Responden"
     * Sheet 2: "Jawaban Kuesioner"
     */
    public function exportExcel(Collection $submissions, string $filename): StreamedResponse
    {
        $answerKeys = $this->getAnswerKeys();

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($submissions, $answerKeys) {
            $tempFile = tempnam(sys_get_temp_dir(), 'xlsx_');
            $zip = new ZipArchive();
            $zip->open($tempFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

            // 1. [Content_Types].xml
            $zip->addFromString('[Content_Types].xml', $this->getContentTypesXml());

            // 2. _rels/.rels
            $zip->addFromString('_rels/.rels', $this->getRootRelsXml());

            // 3. xl/_rels/workbook.xml.rels
            $zip->addFromString('xl/_rels/workbook.xml.rels', $this->getWorkbookRelsXml());

            // 4. xl/workbook.xml
            $zip->addFromString('xl/workbook.xml', $this->getWorkbookXml());

            // 5. xl/styles.xml
            $zip->addFromString('xl/styles.xml', $this->getStylesXml());

            // 6. xl/worksheets/sheet1.xml (Data Responden)
            $sheet1Xml = $this->buildSheet1Xml($submissions);
            $zip->addFromString('xl/worksheets/sheet1.xml', $sheet1Xml);

            // 7. xl/worksheets/sheet2.xml (Jawaban Kuesioner)
            $sheet2Xml = $this->buildSheet2Xml($submissions, $answerKeys);
            $zip->addFromString('xl/worksheets/sheet2.xml', $sheet2Xml);

            $zip->close();

            readfile($tempFile);
            @unlink($tempFile);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Dapatkan peta kunci jawaban 20 butir soal kuesioner.
     */
    protected function getAnswerKeys(): array
    {
        return [
            1 => 'b', 2 => 'c', 3 => 'c', 4 => 'b', 5 => 'd',
            6 => 'b', 7 => 'd', 8 => 'c', 9 => 'a', 10 => 'd',
            11 => 'c', 12 => 'a', 13 => 'a', 14 => 'a', 15 => 'd',
            16 => 'b', 17 => 'c', 18 => 'a', 19 => 'b', 20 => 'a',
        ];
    }

    protected function getContentTypesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n" .
            '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">' .
            '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>' .
            '<Default Extension="xml" ContentType="application/xml"/>' .
            '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>' .
            '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>' .
            '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>' .
            '<Override PartName="/xl/worksheets/sheet2.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>' .
            '</Types>';
    }

    protected function getRootRelsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n" .
            '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">' .
            '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>' .
            '</Relationships>';
    }

    protected function getWorkbookRelsXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n" .
            '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">' .
            '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>' .
            '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet2.xml"/>' .
            '<Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>' .
            '</Relationships>';
    }

    protected function getWorkbookXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n" .
            '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">' .
            '<sheets>' .
            '<sheet name="Data Responden" sheetId="1" r:id="rId1"/>' .
            '<sheet name="Jawaban Kuesioner" sheetId="2" r:id="rId2"/>' .
            '</sheets>' .
            '</workbook>';
    }

    protected function getStylesXml(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n" .
            '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">' .
            '<fonts count="2">' .
            '<font><sz val="11"/><name val="Calibri"/></font>' .
            '<font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>' .
            '</fonts>' .
            '<fills count="3">' .
            '<fill><patternFill patternType="none"/></fill>' .
            '<fill><patternFill patternType="gray125"/></fill>' .
            '<fill><patternFill patternType="solid"><fgColor rgb="FF168C83"/></patternFill></fill>' . // Brand Teal header fill
            '</fills>' .
            '<borders count="1">' .
            '<border><left/><right/><top/><bottom/></border>' .
            '</borders>' .
            '<cellXfs count="2">' .
            '<xf numFmtId="0" fontId="0" fillId="0" borderId="0"/>' . // Normal
            '<xf numFmtId="0" fontId="1" fillId="2" borderId="0" applyFont="1" applyFill="1"/>' . // Header Bold White on Teal
            '</cellXfs>' .
            '</styleSheet>';
    }

    protected function buildSheet1Xml(Collection $submissions): string
    {
        $headers = [
            'respondent_id',
            'nama_lengkap',
            'usia',
            'jenis_kelamin',
            'kelas',
            'tanggal_pengerjaan',
            'status_pengerjaan',
            'jumlah_soal_dijawab',
            'jumlah_benar',
            'jumlah_salah',
            'nilai_persentase',
            'kategori_smile_score',
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n" .
            '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">' .
            '<sheetData>';

        // Baris Header (Style 1 = Header)
        $rowNum = 1;
        $xml .= '<row r="' . $rowNum . '">';
        foreach ($headers as $colIdx => $h) {
            $colLetter = $this->getColumnLetter($colIdx + 1);
            $xml .= '<c r="' . $colLetter . $rowNum . '" t="inlineStr" s="1"><is><t>' . htmlspecialchars($h, ENT_XML1) . '</t></is></c>';
        }
        $xml .= '</row>';

        // Baris Data
        foreach ($submissions as $sub) {
            $rowNum++;
            $isCompleted = ($sub->status === 'completed');
            $data = [
                $sub->formatted_id,
                $sub->name,
                $sub->age,
                $sub->gender,
                $sub->class_name,
                $sub->created_at ? $sub->created_at->format('Y-m-d H:i:s') : '',
                $sub->status,
                $sub->answered_count ?? (is_array($sub->answers) ? count($sub->answers) : 0),
                $isCompleted ? $sub->correct_count : 0,
                $isCompleted ? (20 - $sub->correct_count) : 0,
                $isCompleted ? $sub->percentage : 0,
                $sub->category,
            ];

            $xml .= '<row r="' . $rowNum . '">';
            foreach ($data as $colIdx => $val) {
                $colLetter = $this->getColumnLetter($colIdx + 1);
                if (is_numeric($val) && !str_starts_with((string)$val, '0')) {
                    $xml .= '<c r="' . $colLetter . $rowNum . '"><v>' . $val . '</v></c>';
                } else {
                    $xml .= '<c r="' . $colLetter . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars((string)$val, ENT_XML1) . '</t></is></c>';
                }
            }
            $xml .= '</row>';
        }

        $xml .= '</sheetData></worksheet>';
        return $xml;
    }

    protected function buildSheet2Xml(Collection $submissions, array $answerKeys): string
    {
        $headers = [
            'respondent_id',
            'nama_lengkap',
            'kelas',
            'tanggal_pengerjaan',
        ];

        for ($i = 1; $i <= 20; $i++) {
            $headers[] = sprintf('Q%02d', $i);
        }

        for ($i = 1; $i <= 20; $i++) {
            $headers[] = sprintf('Q%02d_correct', $i);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n" .
            '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">' .
            '<sheetData>';

        // Baris Header
        $rowNum = 1;
        $xml .= '<row r="' . $rowNum . '">';
        foreach ($headers as $colIdx => $h) {
            $colLetter = $this->getColumnLetter($colIdx + 1);
            $xml .= '<c r="' . $colLetter . $rowNum . '" t="inlineStr" s="1"><is><t>' . htmlspecialchars($h, ENT_XML1) . '</t></is></c>';
        }
        $xml .= '</row>';

        // Baris Data
        foreach ($submissions as $sub) {
            $rowNum++;
            $answers = is_array($sub->answers) ? $sub->answers : [];

            $data = [
                $sub->formatted_id,
                $sub->name,
                $sub->class_name,
                $sub->created_at ? $sub->created_at->format('Y-m-d H:i:s') : '',
            ];

            // Jawaban Q01 - Q20
            for ($i = 1; $i <= 20; $i++) {
                $data[] = isset($answers[$i]) ? strtolower(trim((string)$answers[$i])) : '';
            }

            // Status Benar Q01_correct - Q20_correct
            for ($i = 1; $i <= 20; $i++) {
                if (isset($answers[$i]) && $answers[$i] !== '') {
                    $ans = strtolower(trim((string)$answers[$i]));
                    $key = $answerKeys[$i] ?? '';
                    $data[] = ($ans === $key) ? 1 : 0;
                } else {
                    $data[] = '';
                }
            }

            $xml .= '<row r="' . $rowNum . '">';
            foreach ($data as $colIdx => $val) {
                $colLetter = $this->getColumnLetter($colIdx + 1);
                if (is_numeric($val) && (string)$val !== '') {
                    $xml .= '<c r="' . $colLetter . $rowNum . '"><v>' . $val . '</v></c>';
                } else {
                    $xml .= '<c r="' . $colLetter . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars((string)$val, ENT_XML1) . '</t></is></c>';
                }
            }
            $xml .= '</row>';
        }

        $xml .= '</sheetData></worksheet>';
        return $xml;
    }

    /**
     * Ubah index kolom numerik (1-based) menjadi huruf kolom Excel (e.g., 1=A, 27=AA).
     */
    protected function getColumnLetter(int $colIndex): string
    {
        $letter = '';
        while ($colIndex > 0) {
            $mod = ($colIndex - 1) % 26;
            $letter = chr(65 + $mod) . $letter;
            $colIndex = (int) (($colIndex - $mod) / 26);
        }
        return $letter;
    }
}
