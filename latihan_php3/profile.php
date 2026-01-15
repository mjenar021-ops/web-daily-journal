<?php
// Ambil data user yang sedang login
$username = $_SESSION['username'];

$stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

// Cek apakah data user ditemukan
if (!$user_data) {
    echo "<div class='alert alert-danger'>Error: Data user tidak ditemukan!</div>";
    exit;
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="bi bi-person-circle"></i> Profile Saya</h5>
                </div>
                <div class="card-body">
                    <!-- Tampilkan foto profil besar di bagian atas -->
                    <div class="text-center mb-4">
                        <?php if (!empty($user_data['foto']) && file_exists('img/' . $user_data['foto'])) { ?>
                            <img src="img/<?= htmlspecialchars($user_data['foto']) ?>" 
                                 class="rounded-circle border border-danger shadow" 
                                 width="150" 
                                 height="150" 
                                 style="object-fit: cover;" 
                                 alt="Foto Profil">
                        <?php } else { ?>
                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center border border-3 border-danger" 
                                 style="width: 150px; height: 150px;">
                                <i class="bi bi-person-circle text-white" style="font-size: 100px;"></i>
                            </div>
                        <?php } ?>
                        <h5 class="mt-3 mb-0"><?= htmlspecialchars($user_data['username']) ?></h5>
                        <p class="text-muted">Foto Profil Saat Ini</p>
                    </div>

                    <hr>

                    <form method="post" action="" enctype="multipart/form-data">
                        <!-- Username (Readonly) -->
                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">
                                <i class="bi bi-person-badge"></i> Username
                            </label>
                            <input type="text" 
                                   class="form-control bg-light" 
                                   id="username" 
                                   name="username" 
                                   value="<?= htmlspecialchars($user_data['username']) ?>" 
                                   readonly>
                             <div class="form-text">Username tidak dapat diubah</div>
                        </div>

                        <!-- Ganti Password -->
                        <div class="mb-3">
                            <label for="password_baru" class="form-label fw-bold">
                                <i class="bi bi-key"></i> Ganti Password
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_baru" 
                                   name="password_baru" 
                                   placeholder="Tuliskan Password Baru Jika Ingin Mengganti Password Saja">
                        </div>

                        <!-- Ganti Foto Profil -->
                        <div class="mb-3">
                            <label for="foto" class="form-label fw-bold">
                                <i class="bi bi-camera"></i> Ganti Foto Profil
                            </label>
                            <input type="file" 
                                   class="form-control" 
                                   id="foto" 
                                   name="foto" 
                                   accept="image/*">
                            <div class="form-text">Format: JPG, JPEG, PNG, GIF (Maksimal 5MB)</div>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="mb-3">
                            <button type="submit" name="update_profile" class="btn btn-primary">
                                simpan
                            </button>
                        </div>

                        <!-- Hidden field untuk foto lama -->
                        <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($user_data['foto'] ?? '') ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "upload_foto.php";

// Proses update profile
if (isset($_POST['update_profile'])) {
    $username = $_SESSION['username'];
    $password_baru = trim($_POST['password_baru']);
    $foto_lama = $_POST['foto_lama'];
    
    $update_password = false;
    $update_foto = false;
    $new_password = '';
    $new_foto = $foto_lama;
    
    // ===== PROSES PASSWORD =====
    if (!empty($password_baru)) {
        // Validasi panjang password minimal 4 karakter
        if (strlen($password_baru) < 4) {
            echo "<script>
                alert('Password minimal 4 karakter!');
                window.location='admin.php?page=profile';
            </script>";
            exit;
        }
        
        $new_password = md5($password_baru);
        $update_password = true;
    }
    
    // ===== PROSES FOTO =====
    if (!empty($_FILES['foto']['name'])) {
        // Upload foto baru
        $cek_upload = upload_foto($_FILES["foto"]);
        
        if ($cek_upload['status']) {
            // Hapus foto lama jika ada
            if (!empty($foto_lama) && file_exists('img/' . $foto_lama)) {
                unlink('img/' . $foto_lama);
            }
            $new_foto = $cek_upload['message'];
            $update_foto = true;
        } else {
            echo "<script>
                alert('" . addslashes($cek_upload['message']) . "');
                window.location='admin.php?page=profile';
            </script>";
            exit;
        }
    }
    
    // ===== UPDATE DATABASE =====
    if ($update_password && $update_foto) {
        // Update password dan foto
        $stmt = $conn->prepare("UPDATE user SET password = ?, foto = ? WHERE username = ?");
        $stmt->bind_param("sss", $new_password, $new_foto, $username);
    } elseif ($update_password) {
        // Update password saja
        $stmt = $conn->prepare("UPDATE user SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $new_password, $username);
    } elseif ($update_foto) {
        // Update foto saja
        $stmt = $conn->prepare("UPDATE user SET foto = ? WHERE username = ?");
        $stmt->bind_param("ss", $new_foto, $username);
    } else {
        echo "<script>
            alert('Tidak ada perubahan yang dilakukan!');
            window.location='admin.php?page=profile';
        </script>";
        exit;
    }
    
    $update = $stmt->execute();
    
    if ($update) {
        echo "<script>
            alert('Profile berhasil diupdate!');
            window.location='admin.php?page=profile';
        </script>";
    } else {
        echo "<script>
            alert('Gagal update profile!');
            window.location='admin.php?page=profile';
        </script>";
    }
    
    $stmt->close();
}
?>
