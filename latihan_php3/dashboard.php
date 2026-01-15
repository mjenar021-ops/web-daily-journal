<?php
// Ambil data user yang sedang login
$username = $_SESSION['username'];

// Query untuk mendapatkan data user
$sql_user = "SELECT username, foto FROM user WHERE username = '$username'";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows > 0) {
    $user_data = $result_user->fetch_assoc();
} else {
    $user_data = array('username' => $username, 'foto' => '');
}

// Query untuk mengambil data article
$sql1 = "SELECT * FROM article ORDER BY tanggal DESC";
$hasil1 = $conn->query($sql1);
$jumlah_article = $hasil1->num_rows;

// Query untuk mengambil data gallery
$sql2 = "SELECT * FROM gallery ORDER BY tanggal DESC";
$hasil2 = $conn->query($sql2);
$jumlah_gallery = $hasil2->num_rows;
?>

<!-- Sambutan dengan Foto User -->
<div class="text-center mb-5">
    <h3 class="text-muted">Selamat Datang,</h3>
    <h1 class="fw-bold text-danger"><?= htmlspecialchars($user_data['username']) ?></h1>
    
    <div class="mt-4">
        <?php if (!empty($user_data['foto']) && file_exists('img/' . $user_data['foto'])) { ?>
            <img src="img/<?= htmlspecialchars($user_data['foto']) ?>" 
                 class="rounded-circle border border-danger border-3 shadow-lg" 
                 width="200" 
                 height="200" 
                 style="object-fit: cover;" 
                 alt="Foto Profil">
        <?php } else { ?>
            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center border border-3 border-danger shadow-lg" 
                 style="width: 200px; height: 200px;">
                <i class="bi bi-person-circle text-white" style="font-size: 120px;"></i>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Card Statistics -->
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center pt-4">
    <div class="col">
        <div class="card border border-danger mb-3 shadow h-100" style="max-width: 18rem;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="p-3">
                        <h5 class="card-title"><i class="bi bi-newspaper"></i> Article</h5> 
                    </div>
                    <div class="p-3">
                        <span class="badge rounded-pill text-bg-danger fs-2"><?php echo $jumlah_article; ?></span>
                    </div> 
                </div>
            </div>
        </div>
    </div> 
    
    <div class="col">
        <div class="card border border-danger mb-3 shadow h-100" style="max-width: 18rem;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="p-3">
                        <h5 class="card-title"><i class="bi bi-camera"></i> Gallery</h5> 
                    </div>
                    <div class="p-3">
                        <span class="badge rounded-pill text-bg-danger fs-2"><?php echo $jumlah_gallery; ?></span>
                    </div> 
                </div>
            </div>
        </div>
    </div> 
</div>