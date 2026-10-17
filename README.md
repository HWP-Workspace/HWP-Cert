# HWP-Cert
ระบบพิมพ์เกียรติบัตรออนไลน์ โรงเรียนหอวัง ปทุมธานี พัฒนาขึ้นโดยภาษา PHP ช่วยอำนวยความสะดวกให้แก่ครู นักเรียน ในการสร้างและดาวน์โหลดเกียรติบัตรในรูปแบบออนไลน์

## ความต้องการ
PHP Version : 8.2 ขึ้นไป (ทดสอบแล้วบน PHP 8.2, 8.4 และ 8.5) แบบ 64-bit
PHP Extension : pdo_mysql, gd, mbstring, zip, fileinfo, xml, dom, xmlreader, zlib (ระบบจะแจ้งเตือนหากยังไม่ได้เปิด)
MYSQL : UTF-8 Unicode (รองรับไทย)
Web Server : Apache (เปิด mod_rewrite และ AllowOverride) — หากใช้ Nginx ให้ตั้ง Document Root เป็นโฟลเดอร์ `public/`

## ข้อตกลง
เราอนุญาตให้ท่านสามารถแก้ไข ปรับปรุง เปลี่ยนแปลงซอสโค๊ดภายในได้ทุุกส่วน (MIT License)
หากเกิดความเสียหายต่อคอมพิวเตอร์แม่ค่ายของท่าน ขอปฎิเสธความรับผิดชอบทุกประการ
หากท่านลบลายน้ำธีม โดยไม่ได้มีการจัดซื้อลิขสิทธิ์อย่างถูกต้อง ขอปฎิเสธความรับผิดชอบทุกประการ
การแจกจ่ายนี้ได้ให้ลิขสิทธิ์แก่ธีมอย่างถูกต้อง
กรุณาอัปเดตระบบอย่างสม่ำเสมอเพื่อความปลอดภัยของระบบ
หากท่านนำไปใช้งาน ถือว่าท่านได้ยอมรับข้อตกลงทั้งหมดแล้ว

## การใช้งาน
### การติดตั้ง
ท่านควรติดตั้งใน Sub-Domain ไม่ควรติดตั้งใน Sub-Directory เพื่อความสเถียรของระบบสูงสุด
1. นำเข้าฐานข้อมูลจากไฟล์ `database/cer.sql`
2. คัดลอก `config/config.example.php` เป็น `config/config.php` แล้วแก้ไขข้อมูลการเชื่อมต่อฐานข้อมูล
3. ให้สิทธิ์เขียนไฟล์แก่โฟลเดอร์ `storage/` และไฟล์ `public/assets/img/fav.ico`
4. (แนะนำ) ตั้ง Document Root ของ Sub-Domain ให้ชี้ไปที่โฟลเดอร์ `public/` — หากตั้งไม่ได้ ให้ชี้ที่โฟลเดอร์หลักได้เลย ไฟล์ `.htaccess` จะส่งต่อไปที่ `public/` ให้อัตโนมัติ
5. เข้าสู่ระบบด้วยบัญชีเริ่มต้นด้านล่าง แล้ว **เปลี่ยนรหัสผ่านทันที**

### การอัปเดต
หากเลข Version ด้านหน้าเท่ากัน เช่น V2.0 >> V2.1 : สามารถโยนไฟล์ทับกันได้เลย
หากเลข  Version ด้านหน้าต่างกัน เช่น V1.1 >> V2.0 : ต้องมีการอัปเดต Databate ใหม่, มีการเปลี่ยนแปลงมีที่มีผลกระทบต่อข้อมูลเดิม

**อัปเดตจาก V3.x เป็น V4.0** — ไม่ต้องแก้ไขฐานข้อมูล แต่ต้องใช้ PHP 8.2 ขึ้นไป
1. สำรองไฟล์แม่แบบที่อัปโหลดไว้: `upload/tempate/*` และ `upload/preview/*` รวมถึงตราสัญลักษณ์ `img/fav.ico`
2. ลบไฟล์ทั้งหมดของเวอร์ชันเดิม (โครงสร้างโฟลเดอร์เปลี่ยนทั้งหมด) แล้วอัปโหลดเวอร์ชันใหม่
3. นำไฟล์ที่สำรองไว้กลับ: `upload/tempate/*` → `storage/uploads/templates/`, `upload/preview/*` → `storage/uploads/previews/`, `img/fav.ico` → `public/assets/img/fav.ico`
4. สร้าง `config/config.php` จาก `config/config.example.php` โดยใช้ค่าฐานข้อมูลเดิมจาก `connect.php`
5. รหัสผ่านเดิม (md5) ยังใช้เข้าสู่ระบบได้ และจะถูกแปลงเป็นรูปแบบที่ปลอดภัยให้อัตโนมัติเมื่อผู้ใช้ล็อกอินครั้งแรก
6. ลิงก์และ QR code บนเกียรติบัตรที่ออกไปแล้วยังใช้งานได้ตามเดิม

## โครงสร้างระบบ
```
HWP-Cert/
├── public/                 Web root — โฟลเดอร์เดียวที่เข้าถึงได้จากเว็บ
│   ├── index.php …         จุดเข้าของแต่ละหน้า: ตรวจสิทธิ์ → ดึงข้อมูล → แสดงหน้าจาก frontend/pages
│   │                       (print.php ถูกฝังใน QR code บนเกียรติบัตร ห้ามเปลี่ยนชื่อ)
│   ├── api/                จุดเข้าของ API แบบ JSON (เรียกผ่าน ?action=...) → ส่งต่อให้ Controller
│   ├── assets/             css, js (app.js + pages/), img และ vendor (ธีม Atlantis, DataTables, Colorpicker)
│   └── downloads/          ไฟล์ตัวอย่าง Excel และเทมเพลต .psd
│
├── frontend/               FE — หน้าตาเว็บ (HTML template)
│   ├── layouts/            head, navbar, sidebar, footer, scripts
│   ├── components/modals/  ฟอร์ม popup เพิ่ม/แก้ไขข้อมูล
│   └── pages/              เนื้อหาแต่ละหน้า (pages/admin/ สำหรับผู้ดูแลระบบ) และ certificate.php (HTML ของ PDF)
│
├── backend/                BE — การทำงานทั้งหมด
│   ├── bootstrap.php       จุดเริ่มต้นของทุก request
│   ├── Core/               Database (PDO), Auth, Csrf, Session, Request/Response, Api, DataTable, View
│   ├── Models/             ตารางในฐานข้อมูล: Project, Participant, Admin, Department, School
│   ├── Services/           CertificateNumber, CertificatePdf, TemplateStorage, ParticipantImporter
│   ├── Controllers/        การทำงานของ API แต่ละตัว
│   └── resources/fonts/    ฟอนต์ไทยสำหรับสร้าง PDF
│
├── config/                 ค่าตั้งค่าระบบ
├── database/               ไฟล์ฐานข้อมูลเริ่มต้น (cer.sql)
├── storage/                ไฟล์ที่ระบบเขียน: uploads/ (แม่แบบเกียรติบัตร) และ throttle/
└── vendor/                 ไลบรารีจาก Composer (mPDF, PhpSpreadsheet) — อัปเดตด้วย `composer update`
```

**ลำดับการทำงาน:** เบราว์เซอร์ → `public/*.php` → `backend/` (ตรวจสิทธิ์/ดึงข้อมูล) → `frontend/pages/*` (แสดงผล)
และ JavaScript → `public/api/*.php` → `backend/Controllers/*` → JSON

## ความปลอดภัย
- **Token ในการล็อกอินและการส่งข้อมูล (CSRF Token)** — ทุกหน้ามี token ผูกกับ session ซึ่ง JavaScript แนบไปกับทุก request ผ่าน header `X-CSRF-Token` ระบบจะปฏิเสธคำสั่งที่เปลี่ยนแปลงข้อมูล (รวมถึงการล็อกอิน/ออกจากระบบ) ที่ไม่มี token ที่ถูกต้อง และจะสร้าง token ใหม่ทุกครั้งที่เข้าสู่ระบบ
- **Session** — สร้าง session ID ใหม่เมื่อเข้าสู่ระบบ (ป้องกัน session fixation), cookie แบบ HttpOnly/SameSite, ผูกกับเบราว์เซอร์ และหมดอายุเมื่อไม่ใช้งานตามที่ตั้งไว้ใน config
- **รหัสผ่าน** — เก็บด้วย `password_hash` (bcrypt) แทน md5 และล็อกการเข้าสู่ระบบชั่วคราวเมื่อกรอกรหัสผิดเกินกำหนด
- **สิทธิ์การใช้งาน** — ทุก API ตรวจสอบการล็อกอินและสิทธิ์ (ผู้ดูแลจัดการได้เฉพาะโครงการในกลุ่ม/งานของตน, หน้าตั้งค่าระบบเฉพาะผู้ดูแลระบบสูงสุด)
- **SQL Injection / XSS** — ทุก query ใช้ prepared statement และทุกข้อมูลที่แสดงผลผ่านการ escape
- **การอัปโหลดไฟล์** — ตรวจสอบชนิดไฟล์จากเนื้อหาจริง (ไม่ใช่แค่นามสกุล) และจำกัดขนาดไฟล์

### ลายน้ำธีม
หากต้องการนำออกกรุณาซื้อสิทธิ์การใช้งานได้ที่ https://themekita.com/demo-atlantis-bootstrap ท่านจึงจะสามารถนำลายน้ำ (โดย ThemeKita) ออกได้

### ส่งกำลังใจ
หน่วยงานสถานศึกษา, รัฐบาล หรือเอกชน สามารถส่งหนังสือขอบคุณเข้ามาที่ งานคอมพิวเตอร์โรงเรียนหอวัง ปทุมธานี เพื่อเป็นกำลังใจ และแรงสนับสนุนการพัฒนาระบบต่อไป

### ชื่อผู้ใช้งาน (เริ่มต้น — กรุณาเปลี่ยนรหัสผ่านหลังติดตั้ง)
Username : admin <br>
Password : admin1234
