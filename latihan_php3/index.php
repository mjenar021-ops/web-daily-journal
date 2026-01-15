<?php
//menyertakan code dari file koneksi
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Daily Journal</title>
    <link rel="icon" href="img/logo.jpg" />
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Bootstrap CSS - Multiple CDN for fallback -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
      /* Fallback styles jika Bootstrap tidak load */
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
      }
      .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
      }
      .navbar {
        background-color: #f8f9fa;
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      }
      .navbar-brand {
        font-weight: bold;
        font-size: 1.25rem;
        text-decoration: none;
        color: #000;
      }
      .nav-link {
        text-decoration: none;
        color: #000;
        padding: 0.5rem 1rem;
      }
      .btn {
        padding: 0.375rem 0.75rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
        cursor: pointer;
      }
      .btn-dark {
        background-color: #212529;
        color: #fff;
      }
      .btn-danger {
        background-color: #dc3545;
        color: #fff;
      }
      .bg-danger-subtle {
        background-color: #f8d7da !important;
      }
      .text-center {
        text-align: center;
      }
      .p-5 {
        padding: 3rem !important;
      }
      .card {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        margin-bottom: 1rem;
      }
      .card-img-top {
        width: 100%;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
      }
      .card-body {
        padding: 1rem;
      }
      img {
        max-width: 100%;
        height: auto;
      }
    </style>
  </head>
  <body>
    <!-- nav begin -->
    <nav class="navbar navbar-expand-sm bg-body-tertiary sticky-top">
      <div class="container">
        <a class="navbar-brand" href="#">My Daily Journal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
            <li class="nav-item">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#article">Article</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#gallery">Gallery</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#schedule">Schedule</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#aboutme">About Me</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php" target="_blank">Login</a>
            </li>
            <li class="nav-item">
              <button type="button" class="btn btn-dark theme me-2" id="dark" title="dark">
                <i class="bi bi-moon-stars-fill"></i>
              </button>
            </li>
            <li class="nav-item">
              <button type="button" class="btn btn-danger theme" id="light" title="light">
                <i class="bi bi-brightness-high"></i>
              </button>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- nav end -->
    
    <!-- hero begin -->
    <section id="hero" class="text-center p-5 bg-danger-subtle text-sm-start">
      <div class="container">
        <div class="d-sm-flex flex-sm-row-reverse align-items-center">
          <img src="img/banner.jpg" class="img-fluid" width="300" alt="Banner" onerror="this.src='https://via.placeholder.com/300x200/f8d7da/dc3545?text=Banner'" />
          <div>
            <h1 class="fw-bold display-4">Create Memories, Save Memories, Everyday</h1>
            <h4 class="lead display-6">Mencatat semua kegiatan sehari-hari yang ada tanpa terkecuali</h4>
            <h6>
              <span id="tanggal"></span>
              <span id="jam"></span>
            </h6>
          </div>
        </div>
      </div>
    </section>
    <!-- hero end -->
    
    <!-- article begin -->
    <section id="article" class="text-center p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">Article</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
        <?php
        $sql = "SELECT * FROM article ORDER BY tanggal DESC";
        $hasil = $conn->query($sql); 

        if($hasil && $hasil->num_rows > 0){
          while($row = $hasil->fetch_assoc()){
        ?>
          <div class="col">
            <div class="card h-100">
              <?php if($row["gambar"] != '' && file_exists('img/'.$row["gambar"])){ ?>
                <img src="img/<?= $row["gambar"]?>" class="card-img-top" alt="<?= $row["judul"]?>" style="height: 200px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/300x200/dee2e6/6c757d?text=No+Image'" />
              <?php } else { ?>
                <img src="https://via.placeholder.com/300x200/dee2e6/6c757d?text=No+Image" class="card-img-top" alt="No Image" />
              <?php } ?>
              <div class="card-body">
                <h5 class="card-title"><?= $row["judul"]?></h5>
                <p class="card-text"><?= strlen($row["isi"]) > 100 ? substr($row["isi"], 0, 100).'...' : $row["isi"]?></p>
              </div>
              <div class="card-footer">
                <small class="text-body-secondary"><?= $row["tanggal"]?></small>
              </div>
            </div>
          </div>
        <?php
          }
        } else {
          echo '<p class="text-muted">Belum ada artikel.</p>';
        }
        ?>
        </div>
      </div>
    </section>
    <!-- article end -->
    
    <!-- gallery begin -->
    <section id="gallery" class="text-center p-5 bg-danger-subtle">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">Gallery</h1>
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <?php
            $sql_gallery = "SELECT * FROM gallery ORDER BY tanggal DESC LIMIT 5";
            $hasil_gallery = $conn->query($sql_gallery);
            $first = true;
            
            if($hasil_gallery && $hasil_gallery->num_rows > 0){
              while($row_gallery = $hasil_gallery->fetch_assoc()){
            ?>
              <div class="carousel-item <?= $first ? 'active' : '' ?>">
                <?php if(file_exists('img/'.$row_gallery["gambar"])){ ?>
                  <img src="img/<?= $row_gallery["gambar"]?>" class="d-block w-100" alt="<?= $row_gallery["judul"]?>" style="max-height: 500px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/1200x500/f8d7da/dc3545?text=Gallery+Image'" />
                <?php } else { ?>
                  <img src="https://via.placeholder.com/1200x500/f8d7da/dc3545?text=<?= urlencode($row_gallery['judul'])?>" class="d-block w-100" alt="<?= $row_gallery["judul"]?>" style="max-height: 500px; object-fit: cover;" />
                <?php } ?>
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                  <h5><?= $row_gallery["judul"]?></h5>
                  <?php if(!empty($row_gallery["deskripsi"])){ ?>
                    <p><?= $row_gallery["deskripsi"]?></p>
                  <?php } ?>
                </div>
              </div>
            <?php
                $first = false;
              }
            } else {
              // Jika tidak ada data gallery, tampilkan gambar default
            ?>
              <div class="carousel-item active">
                <img src="https://via.placeholder.com/1200x500/f8d7da/dc3545?text=No+Gallery+Images+Yet" class="d-block w-100" alt="No Images" style="max-height: 500px; object-fit: cover;" />
              </div>
            <?php
            }
            ?>
          </div>
          <?php if($hasil_gallery && $hasil_gallery->num_rows > 1){ ?>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
          <?php } ?>
        </div>
      </div>
    </section>
    <!-- gallery end -->
    
    <!-- schedule begin -->
    <section id="schedule" class="text-center p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">Schedule</h1>
        <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
          <div class="col">
            <div class="card h-100">
              <div class="card-header bg-danger text-white">SENIN</div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Etika Profesi<br />16.20-18.00 | H.4.4</li>
                <li class="list-group-item">Sistem Operasi<br />18.30-21.00 | H.4.8</li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <div class="card-header bg-danger text-white">SELASA</div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Pendidikan Kewarganegaraan<br />12.30-13.10 | Kulino</li>
                <li class="list-group-item">Probabilitas dan Statistik<br />15.30-18.00 | H.4.9</li>
                <li class="list-group-item">Kecerdasan Buatan<br />18.30-21.00 | H.4.11</li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <div class="card-header bg-danger text-white">RABU</div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Manajemen Proyek Teknologi Informasi<br />15.30-18.00 | H.4.6</li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <div class="card-header bg-danger text-white">KAMIS</div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Bahasa Indonesia<br />12.30-14.10 | Kulino</li>
                <li class="list-group-item">Pendidikan Agama Kristen<br />16.20-18.00 | Kulino</li>
                <li class="list-group-item">Penambangan Data<br />18.30-21.00 | H.4.9</li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <div class="card-header bg-danger text-white">JUMAT</div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Pemrograman Web Lanjut<br />10.20-12.00 | D.2.K</li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <div class="card-header bg-danger text-white">SABTU</div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">FREE</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- schedule end -->
    
    <!-- about me begin -->
    <section id="aboutme" class="text-center p-5 bg-danger-subtle">
      <div class="container">
        <div class="d-sm-flex align-items-center justify-content-center">
          <div class="p-3">
            <img src="img/Udinus.jpg" class="rounded-circle border shadow" width="300" alt="Profile" onerror="this.src='https://via.placeholder.com/300/f8d7da/dc3545?text=Profile'" />
          </div>
          <div class="p-md-5 text-sm-start">
            <h3 class="lead">A11.2024.15854</h3>
            <h1 class="fw-bold">Rizky Cahya Ramadhan</h1>
            Program Studi Teknik Informatika<br />
            <a href="https://dinus.ac.id/" class="fw-bold text-decoration-none text-danger">Universitas Dian Nuswantoro</a>
          </div>
        </div>
      </div>
    </section>
    <!-- about me end -->
    
    <!-- footer begin -->
    <footer id="footer" class="text-center p-5">
      <div>
        <a href="https://www.instagram.com/rzkychyrmdhn__" class="text-dark"><i class="bi bi-instagram h2 p-2"></i></a>
        <a href="https://twitter.com/udinusofficial" class="text-dark"><i class="bi bi-twitter h2 p-2"></i></a>
        <a href="https://wa.me/+6281225664725" class="text-dark"><i class="bi bi-whatsapp h2 p-2"></i></a>
      </div>
      <div>Rizky Cahya Ramadhan &copy; 2025</div>
    </footer>
    <!-- footer end -->

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script type="text/javascript">
      // Fungsi untuk menampilkan waktu
      function tampilWaktu() {
        var waktu = new Date();
        var bulan = waktu.getMonth() + 1;
        var tanggalEl = document.getElementById("tanggal");
        var jamEl = document.getElementById("jam");
        
        if(tanggalEl) {
          tanggalEl.innerHTML = waktu.getDate() + "/" + bulan + "/" + waktu.getFullYear();
        }
        if(jamEl) {
          var jam = waktu.getHours().toString().padStart(2, '0');
          var menit = waktu.getMinutes().toString().padStart(2, '0');
          var detik = waktu.getSeconds().toString().padStart(2, '0');
          jamEl.innerHTML = jam + ":" + menit + ":" + detik;
        }
        
        setTimeout(tampilWaktu, 1000);
      }
      
      // Jalankan fungsi waktu saat halaman load
      window.onload = function() {
        tampilWaktu();
      };

      // Dark Mode
      document.getElementById("dark").onclick = function () {
        document.body.style.backgroundColor = "black";
        document.getElementById("hero").classList.remove("bg-danger-subtle", "text-black");
        document.getElementById("hero").classList.add("bg-secondary", "text-white");
        document.getElementById("gallery").classList.remove("bg-danger-subtle", "text-black");
        document.getElementById("gallery").classList.add("bg-secondary", "text-white");
        document.getElementById("aboutme").classList.remove("bg-danger-subtle", "text-black");
        document.getElementById("aboutme").classList.add("bg-secondary", "text-white");
        document.getElementById("footer").classList.remove("text-black");
        document.getElementById("footer").classList.add("text-white");
        document.getElementById("article").classList.remove("text-black");
        document.getElementById("article").classList.add("text-white");
        document.getElementById("schedule").classList.remove("text-black");
        document.getElementById("schedule").classList.add("text-white");

        const cards = document.getElementsByClassName("card");
        for (let i = 0; i < cards.length; i++) {
          cards[i].classList.add("bg-secondary", "text-white");
        }

        const listItems = document.getElementsByClassName("list-group-item");
        for (let i = 0; i < listItems.length; i++) {
          listItems[i].classList.add("bg-secondary", "text-white");
        }
        
        const links = document.querySelectorAll("#footer a");
        for(let i = 0; i < links.length; i++) {
          links[i].classList.remove("text-dark");
          links[i].classList.add("text-white");
        }
      };

      // Light Mode
      document.getElementById("light").onclick = function () {
        document.body.style.backgroundColor = "white";
        document.getElementById("hero").classList.remove("bg-secondary", "text-white");
        document.getElementById("hero").classList.add("bg-danger-subtle", "text-black");
        document.getElementById("gallery").classList.remove("bg-secondary", "text-white");
        document.getElementById("gallery").classList.add("bg-danger-subtle", "text-black");
        document.getElementById("aboutme").classList.remove("bg-secondary", "text-white");
        document.getElementById("aboutme").classList.add("bg-danger-subtle", "text-black");
        document.getElementById("footer").classList.remove("text-white");
        document.getElementById("footer").classList.add("text-black");
        document.getElementById("article").classList.remove("text-white");
        document.getElementById("article").classList.add("text-black");
        document.getElementById("schedule").classList.remove("text-white");
        document.getElementById("schedule").classList.add("text-black");

        const cards = document.getElementsByClassName("card");
        for (let i = 0; i < cards.length; i++) {
          cards[i].classList.remove("bg-secondary", "text-white");
        }

        const listItems = document.getElementsByClassName("list-group-item");
        for (let i = 0; i < listItems.length; i++) {
          listItems[i].classList.remove("bg-secondary", "text-white");
        }
        
        const links = document.querySelectorAll("#footer a");
        for(let i = 0; i < links.length; i++) {
          links[i].classList.remove("text-white");
          links[i].classList.add("text-dark");
        }
      };
    </script>
  </body>
</html>