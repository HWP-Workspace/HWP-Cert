<?php
/**
 * HTML ของเกียรติบัตร (แปลงเป็น PDF ด้วย mPDF — รองรับ CSS เพียงบางส่วน)
 *
 * @var array  $project
 * @var array  $participant
 * @var array  $lines       [['text', 'size', 'tag'], ...]
 * @var string $qrCodeUrl
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        h1, h2, h3, h4, h5, h6 { margin: 0 !important; padding: 0 !important; }
    </style>
</head>
<body>
    <table>
        <tr>
            <td><barcode code="<?= e($qrCodeUrl) ?>" type="QR" size="0.5" error="M" disableborder="1"></barcode></td>
            <td style="font-size: 20px"><?= e(thai_digits($participant['idcer'])) ?></td>
        </tr>
    </table>

    <div style="margin-top: <?= (int) $project['margin'] ?>; text-align: center;">
        <?php foreach ($lines as $line): ?>
            <<?= $line['tag'] ?> style="font-size: <?= (int) $line['size'] ?>px; color: <?= e($project['color']) ?>;"><?= e($line['text']) ?></<?= $line['tag'] ?>>
        <?php endforeach; ?>
    </div>
</body>
</html>
