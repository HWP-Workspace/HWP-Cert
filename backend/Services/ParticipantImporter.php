<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;

/**
 * นำเข้ารายชื่อผู้เข้าร่วมจากไฟล์ Excel/CSV
 * คอลัมน์ A = ชื่อ-นามสกุล, B = บรรทัด 2, C = บรรทัด 3 (แถวแรกของแต่ละชีตเป็นหัวตาราง)
 */
final class ParticipantImporter
{
    const MAX_BYTES = 5242880; // 5 MB
    const READERS = ['csv' => IOFactory::READER_CSV, 'xlsx' => IOFactory::READER_XLSX, 'xls' => IOFactory::READER_XLS];

    /** @return int จำนวนรายชื่อที่นำเข้า */
    public static function import(array $project, array $file)
    {
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!isset(self::READERS[$extension])) {
            throw HttpException::badRequest('กรุณาอัปโหลดไฟล์ .xlsx หรือ .csv เท่านั้น');
        }

        try {
            $reader = IOFactory::createReader(self::READERS[$extension]);
            $reader->setReadDataOnly(true);
            if ($reader instanceof Csv) {
                $reader->setInputEncoding('UTF-8');
            }
            $spreadsheet = $reader->load($file['tmp_name']);
        } catch (ReaderException $e) {
            throw HttpException::badRequest('ไม่สามารถอ่านไฟล์ได้ กรุณาตรวจสอบรูปแบบไฟล์');
        }

        return Database::transaction(function () use ($spreadsheet, $project) {
            $imported = 0;
            foreach ($spreadsheet->getAllSheets() as $sheet) {
                $rows = $sheet->toArray(null, true, false, false);
                array_shift($rows); // หัวตาราง

                foreach ($rows as $row) {
                    $name = self::cell($row, 0);
                    if ($name === '') {
                        continue;
                    }
                    Participant::create($project, $name, self::cell($row, 1), self::cell($row, 2));
                    $imported++;
                }
            }
            return $imported;
        });
    }

    private static function cell(array $row, $index)
    {
        return isset($row[$index]) ? mb_substr(trim((string) $row[$index]), 0, 255) : '';
    }
}
