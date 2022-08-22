<!-- Nav -->
<nav class="navbar navbar-expand-lg" id="navbar-custom"> 
  <div class="container">
    <a class="navbar-brand" id="text-heading-nav" href="index.php">  
      <img src="img/fav.ico" alt="" width="25" height="25"> ระบบพิมพ์เกียรติบัตรออนไลน์</a>

    <!--Nav Toggle-->
    <button class ="nav-toggle-responsive" type="button" data-bs-toggle="collapse" data-bs-target="#nav-main-link" aria-controls="nav-main-link" 
    aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>

    <!--Nav Menu-->
        <div class="collapse navbar-collapse" id="nav-main-link">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 sub-menu">
              <li class="nav-item">
              <a class="d-block" id="text-sub-menu" aria-current="page" href="index.php"> <i class="fas fa-home icon-main"></i> หน้าแรก</a> 
              </li>

              <li class="nav-item">
                <?=(isset($_SESSION['username'])) ? '<a class="d-block" id="text-sub-menu" href="admin.php"> 
                <i class="fas fa-cog icon-main"></i> บริหารจัดการระบบ</a>
                
                <li class="nav-item"> <a class="d-block" id="text-sub-menu" href="logout.php">
                <i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a> </li>'

                  : '<button class="d-block" id="button-login" class="text-sub-menu" herf="#" data-bs-toggle="modal" 
                  data-bs-target="#exampleModal"> <i class="fas fa-lock icon-main"></i> ล็อกอิน </button>
                  ' ;?>
              </li>
            </ul>
        </div>
  </div>
</nav>