  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 bg-black">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Okan Aras</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">E-Commerce</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <?php $sideUri = explode('.', explode('/', $_SERVER['REQUEST_URI'])[3])[0]; ?>

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="index" class="nav-link <?= $sideUri === 'index' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Anasayfa
                <span class="right badge badge-danger">Yeni</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="kategori" class="nav-link <?= $sideUri === 'kategori' || $sideUri === 'kategori-ekle' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-bars"></i>
              <p>
                Kategoriler
                <span class="right badge badge-danger">Yeni</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="hakkimizda" class="nav-link <?= $sideUri === 'hakkimizda' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-address-card"></i>
              <p>
                Hakkımızda
                <span class="right badge badge-danger">Yeni</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="siparisler" class="nav-link <?= $sideUri === 'siparisler' ? 'active' : '' ?>">
              <i class="nav-icon fa fa-shopping-cart"></i>
              <p>
                Siparişler
                <span class="right badge badge-danger">Yeni</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="slider" class="nav-link <?= $sideUri === 'slider' || $sideUri === 'slider-ekle' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-image"></i>
              <p>
                Slider
                <span class="right badge badge-danger">Yeni</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="uyeler" class="nav-link <?= $sideUri === 'uyeler' || $sideUri === 'uyeler-ekle'  ? 'active' : '' ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Üyeler
                <span class="right badge badge-danger">Yeni</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="yorumlar" class="nav-link <?= $sideUri === 'yorumlar' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-comments"></i>
              <p>
                Yorumlar
                <span class="right badge badge-danger">Yeni</span>
              </p>
            </a>
          </li>
          <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview 
                    <?= $sideUri === 'ayarlar' ||
                      $sideUri === 'iletisim' ||
                      $sideUri === 'sosyalmedya' ||
                      $sideUri === 'kullanicilar' ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= $sideUri === 'ayarlar' || $sideUri === 'iletisim' || $sideUri === 'sosyalmedya' || $sideUri === 'kullanicilar' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Ayarlar
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="ayarlar" class="nav-link <?= $sideUri === 'ayarlar' ? 'active' : '' ?>">
                  <i class="fab fa-chrome nav-icon"></i>
                  <p>Site Ayarları</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="iletisim" class="nav-link <?= $sideUri === 'iletisim' ? 'active' : '' ?>">
                  <i class="fa fa-address-book nav-icon"></i>
                  <p>İletişim Ayarları</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="sosyalmedya" class="nav-link <?= $sideUri === 'sosyalmedya' ? 'active' : '' ?>">
                  <i class="fa fa-hashtag nav-icon"></i>
                  <p>Sosyal Medya Ayarları</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="kullanicilar" class="nav-link <?= $sideUri === 'kullanicilar' ? 'active' : '' ?>">
                  <i class="far fa-user nav-icon"></i>
                  <p>Kullanıcı Bilgileri</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="./index3.html" class="nav-link">
              <i class="fa fa-bookmark nav-icon"></i>
              <p>Tema Bilgileri</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="cikis" class="nav-link">
              <i class="fas fa-sign-out-alt nav-icon"></i>
              <p>Çıkış</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->







































      </di v>
      <!-- /.sidebar -->
  </aside>
