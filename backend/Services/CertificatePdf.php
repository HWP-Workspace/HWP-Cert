<?php

/**
 * สร้างไฟล์ PDF เกียรติบัตรด้วย mPDF (HTML อยู่ที่ frontend/pages/certificate.php)
 */
final class CertificatePdf
{
    const FONT_DIRECTORY = BACKEND_PATH . '/resources/fonts';
    const FONT_FILES = [
        'thniramitas'  => ['R' => 'THNiramit-AS.ttf', 'B' => 'THNiramit-AS-Bold.ttf'],
        'thsarabunnew' => ['R' => 'THSarabunNew.ttf', 'B' => 'THSarabunNew-Bold.ttf'],
    ];

    /** ส่ง PDF ไปแสดงในเบราว์เซอร์ */
    public static function output(array $project, array $participant, $qrCodeUrl)
    {
        $font = array_key_exists($project['font'], Project::FONTS) ? $project['font'] : Project::DEFAULT_FONT;

        $mpdf = new \Mpdf\Mpdf([
            'format'       => 'A4',
            'mode'         => 'UTF-8',
            'fontDir'      => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], [self::FONT_DIRECTORY]),
            'fontdata'     => (new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'] + self::FONT_FILES,
            'default_font' => $font,
        ]);
        $mpdf->AddPage('L');
        $mpdf->adjustFontDescLineheight = 1;
        $mpdf->SetDefaultBodyCSS('background', "url('" . TemplateStorage::templatePath($project['tempate']) . "')");
        $mpdf->SetDefaultBodyCSS('background-image-resize', 6);

        ob_start();
        View::page('certificate', [
            'project'     => $project,
            'participant' => $participant,
            'lines'       => self::lines($project, $participant),
            'qrCodeUrl'   => $qrCodeUrl,
        ]);
        $mpdf->WriteHTML(ob_get_clean());

        $mpdf->Output('เกียรติบัตร ' . $participant['name'] . ' (' . $participant['idcer'] . ').pdf', 'I');
    }

    /** ข้อความแต่ละบรรทัดบนเกียรติบัตรตามรูปแบบโครงการ */
    private static function lines(array $project, array $participant)
    {
        $extraLines = Project::extraLines($project);

        $lines = [['text' => $participant['name'], 'size' => $project['size_name'], 'tag' => 'h1']];
        if ($extraLines >= 1 && ($participant['line2'] !== '' || $extraLines >= 2)) {
            $lines[] = ['text' => $participant['line2'], 'size' => $project['size_line2'], 'tag' => 'h2'];
        }
        if ($extraLines >= 2) {
            $lines[] = ['text' => $participant['line3'], 'size' => $project['size_line3'], 'tag' => 'h2'];
        }
        return $lines;
    }
}
