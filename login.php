</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();
    require('core/components/head.php'); ?>
    <link rel="stylesheet" type="text/css" href="assets/css/login.css">
</head>

<body class="text-center">
    <form class="form-signin">
        <img class="mb-3" src="fav.ico" alt="" width="100" height="100">
        <h2 class="h2 mb-1">ล็อกอินเข้าสู่ระบบ</h2>
        <h3 class="h4 mb-3  op-7">ระบบพิมพ์เกียรติบัตรออนไลน์</h3>

        <label for="username" class="sr-only">ชื่อผู้ใช้งาน</label>
        <input type="text" id="username" name="username" class="form-control" placeholder="ชื่อผู้ใช้งาน">

        <label for="password" class="sr-only">รหัสผ่าน</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="รหัสผ่าน">

        <div id="div-msg" name="div-msg" style="display:none;" class="alert alert-warning alert-custom m-1" role="alert">
            <div id="text-msg" class="alert-text"></div>
        </div>

        <button class="btn btn-primary btn-block mt-2" name="submit" id="submit" type="button" onclick="cklogin();">เข้าสู่ระบบ</button>

        <h5 class="mt-4 text-primary"><a href="index"><i class="fas fa-home"></i> กลับสู่หน้าหลัก</a></h5>
        <h5 class="mt-1">สงวนลิขสิทธิ์ &copy; <?= date('Y') + 543 ?> <?= $nameschool_data ?></h5>
    </form>

    <!-- Script-->
    <?php require('core/components/script.php'); ?>
    <script type="text/javascript">
        function cklogin() {
            const username = $("#username").val().trim();
            const password = $("#password").val().trim();
            
            if (username != "" && password != "") {
                $.ajax({
                    url: 'core/sql/auth/ck-login.php',
                    method: 'POST',
                    data: {
                        username: username,
                        password: password
                    },
                    success: function(response) {
                        if (response == "S") {
                            location.replace("index");
                        } else {
                            $("#div-msg").show();
                            $("#text-msg").html(response);
                        }

                    }
                });
            } else {
                $("#div-msg").show();
                $("#text-msg").html("กรุณากรอกชื่อ และ รหัสผ่านให้ถูกต้อง");
            }
        }
    </script>

</body>

</html>