<?php
/**
 * ส่วนล่างของหน้าเว็บ
 *
 * @var array $page [
 *     'modals'  => ชื่อไฟล์ใน frontend/components/modals ที่ต้องการแสดง,
 *     'scripts' => ไฟล์ JS ในโฟลเดอร์ js/ ของหน้านั้น,
 *     'data'    => ข้อมูลที่ส่งให้ JavaScript ผ่าน window.APP.page,
 * ]
 */
?>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    ระบบพิมพ์เกียรติบัตรออนไลน์ เวอร์ชัน <span class="badge badge-primary"><?= e(Config::get('app.version')) ?></span>
                </nav>
                <div class="copyright ml-auto text-center">
                    สงวนลิขสิทธิ์ &copy; <?= thai_year() ?> <?= e(School::name()) ?>, <a href="https://www.themekita.com">ThemeKita</a>
                </div>
            </div>
        </footer>
    </div>
</div>

<?php foreach (isset($page['modals']) ? $page['modals'] : [] as $modal): ?>
    <?php require FRONTEND_PATH . '/components/modals/' . $modal . '.php'; ?>
<?php endforeach; ?>

<?php require __DIR__ . '/scripts.php'; ?>
</body>
</html>
