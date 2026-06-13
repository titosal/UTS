<?php
session_start();
require 'koneksi.php';

// cek user login apa belum
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// ambil parameter menu
$menu = isset($_GET['menu']) ? $_GET['menu'] : 'dashboard';

// fitur logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

//insert data drone
if(isset($_POST['simpan_drone'])) {
    $kode_drone =$_POST['kode_drone'];
    $merk_model =$_POST['merk_model'];
    $kondisi =$_POST['kondisi'];

    $insert_drone = mysqli_query($conn, "INSERT INTO drones (kode_drone, merk_model, kondisi) VALUES ('$kode_drone', '$merk_model', '$kondisi')");
    if($insert_drone) {
        echo "Data Drone berhasil ditambahkan!'); window.location='dashboard.php?menu=drone';</script>";
    }
    else {
        echo "<script>alert('Gagal menambahkan data drone!');</script>";
    }
}

//update data drone
if(isset($_POST['update_drone'])) {
    $id         = $_POST['id'];
    $kode_drone = $_POST['kode_drone'];
    $merk_model = $_POST['merk_model'];
    $kondisi    = $_POST['kondisi'];

    $update_drone = mysqli_query($conn, "UPDATE drones SET kode_drone='$kode_drone', merk_model='$merk_model', kondisi='$kondisi' WHERE id='$id'");
    if($update_drone) {
        echo "<script>alert('Data Drone berhasil diperbarui!'); window.location='dashboard.php?menu=drone';</script>";
    }
}
//delete data
if($menu == 'drone' && isset($_GET['delete_id'])) {
    $id_hapus = $_GET['delete_id'];
    $hapus_drone = mysqli_query($conn, "DELETE FROM drones WHERE id='$id_hapus'");
    if($hapus_drone) echo "<script>alert('Data Drone berhasil dihapus!'); window.location='dashboard.php?menu=drone';</script>";
}


// insert Lokasi Operasional
if(isset($_POST['simpan_lokasi'])) {
    $distrik = $_POST['distrik'];
    $no_spk = $_POST['no_spk'];
    $no_petak = $_POST['no_petak'];
    $tanggal_ops = $_POST['tanggal_ops'];

    $insert_lokasi = mysqli_query($conn, "INSERT INTO lokasi_kerja (distrik, no_spk, no_petak, tanggal_ops) VALUES ('$distrik', '$no_spk', '$no_petak', '$tanggal_ops')");
    if($insert_lokasi) {
        echo "<script>alert('Data Lokasi Kerja berhasil ditambahkan!'); window.location='dashboard.php?menu=lokasi';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data lokasi!');</script>";
    }
}
//update lokasi ops
if(isset($_POST['update_lokasi'])) {
    $id          = $_POST['id'];
    $distrik     = $_POST['distrik'];
    $no_spk      = $_POST['no_spk'];
    $no_petak    = $_POST['no_petak'];
    $tanggal_ops = $_POST['tanggal_ops'];

    $update_lokasi = mysqli_query($conn, "UPDATE lokasi_kerja SET distrik='$distrik', no_spk='$no_spk', no_petak='$no_petak', tanggal_ops='$tanggal_ops' WHERE id='$id'");
    if($update_lokasi) {
        echo "<script>alert('Data Lokasi Kerja berhasil diperbarui!'); window.location='dashboard.php?menu=lokasi';</script>";
    }
}
//delete data
if($menu == 'lokasi' && isset($_GET['delete_id'])) {
    $id_hapus = $_GET['delete_id'];
    $hapus_lokasi = mysqli_query($conn, "DELETE FROM lokasi_kerja WHERE id='$id_hapus'");
    if($hapus_lokasi) echo "<script>alert('Lokasi Kerja berhasil dihapus!'); window.location='dashboard.php?menu=lokasi';</script>";
}

//mengambil data statistik drone
$query_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM drones");
$data_total = mysqli_fetch_assoc($query_total);

$query_terbang = mysqli_query($conn, "SELECT COUNT(*) as total FROM drones WHERE kondisi='Siap Terbang'");
$data_terbang = mysqli_fetch_assoc($query_terbang);

$query_perbaikan = mysqli_query($conn, "SELECT COUNT(*) as total FROM drones WHERE kondisi='Dalam Perbaikan'");
$data_perbaikan = mysqli_fetch_assoc($query_perbaikan);

$query_rusak = mysqli_query($conn, "SELECT COUNT(*) as total FROM drones WHERE kondisi='Rusak'");
$data_rusak = mysqli_fetch_assoc($query_rusak);

//mengambil data statistik operasioal
$query_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM lokasi_kerja");
$data_distrik = mysqli_fetch_assoc($query_total);

$query_terbang = mysqli_query($conn, "SELECT COUNT(*) as total FROM lokasi_kerja WHERE distrik='Distrik Bengkal'");
$data_bengkal = mysqli_fetch_assoc($query_terbang);

$query_perbaikan = mysqli_query($conn, "SELECT COUNT(*) as total FROM lokasi_kerja WHERE distrik='Distrik Santan'");
$data_santan = mysqli_fetch_assoc($query_perbaikan);

$query_rusak = mysqli_query($conn, "SELECT COUNT(*) as total FROM lokasi_kerja WHERE distrik='Distrik Sebulu'");
$data_sebulu = mysqli_fetch_assoc($query_rusak);

$query_rusak = mysqli_query($conn, "SELECT COUNT(*) as total FROM lokasi_kerja WHERE distrik='Distrik Sei Mao'");
$data_sei = mysqli_fetch_assoc($query_rusak);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sistem Manajemen Drone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .sidebar { width: 260px; min-height: 100vh; background-color: #ffffff; border-right: 1px solid #e2e8f0; position: fixed; }
        .main-wrapper { margin-left: 260px; }
        .card-custom { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
        .sidebar-link { color: #64748b; text-decoration: none; padding: 12px 16px; display: block; border-radius: 8px; font-weight: 500; margin-bottom: 4px; }
        .sidebar-link:hover, .sidebar-link.active { background-color: #e0f2fe; color: #0369a1; }
        .table th { background-color: #f8fafc !important; font-weight: 600; color: #0f172a; }
        
        /* Badges */
        .badge-siap { background-color: #dcfce7; color: #15803d; }
        .badge-perbaikan { background-color: #fef3c7; color: #d97706; }
        .badge-admin { background-color: #e0f2fe; color: #0369a1; }
        .badge-user { background-color: #f1f5f9; color: #475569; }
        
        /* Action buttons */
        .btn-action { padding: 4px 10px; border-radius: 6px; border: 1px solid #e2e8f0; background: #fff; transition: 0.2s;}
        .btn-action:hover { background: #f8fafc; }
    </style>
</head>
<body>

    <div class="sidebar p-3 d-flex flex-column">
        <div class="d-flex align-items-center gap-2 mb-4 px-2">
            <i class="bi bi-airplane-engines-fill text-primary fs-3"></i>
            <span class="fw-bold fs-5">Drone Tani Indonesia</span>
        </div>
        
        <div class="flex-grow-1">
            <a href="?menu=dashboard" class="sidebar-link <?= $menu=='dashboard'?'active':'' ?>"><i class="bi bi-house-door me-2"></i> Dashboard</a>
            <a href="?menu=drone" class="sidebar-link <?= $menu=='drone'?'active':'' ?>"><i class="bi bi-camera-video me-2"></i> Data Drone</a>
            <a href="?menu=lokasi" class="sidebar-link <?= $menu=='lokasi'?'active':'' ?>"><i class="bi bi-geo-alt me-2"></i> Lokasi Kerja</a>
            <a href="?menu=users" class="sidebar-link <?= $menu=='users'?'active':'' ?>"><i class="bi bi-people me-2"></i> Data Users</a>
        </div>
        
        <div class="mt-auto">
            <a href="?logout=true" class="sidebar-link text-danger border border-danger bg-light text-center">
                <i class="bi bi-box-arrow-left me-2"></i> Logout
            </a>
        </div>
    </div>

    <div class="main-wrapper">
        <nav class="bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Sistem Manajemen Drone</h5>
            <div class="d-flex align-items-center gap-2">
                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px;">
                    <i class="bi bi-person"></i>
                </div>
                <span class="fw-semibold"><?= $_SESSION['username']; ?> (<?= $_SESSION['status']; ?>)</span>
            </div>
        </nav>

        <div class="p-4">
            
            <?php if($menu == 'dashboard'): ?>
            <div class="card-custom p-4 mb-4 border-primary border-top border-4">
                <h5 class="fw-bold">Selamat datang, <?= $_SESSION['username']; ?>!</h5>
                <p class="text-muted mb-0">Sistem Informasi Manajemen Aset dan Operasional Drone.</p>
            </div>
            <div class="row g-4">

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm bg-white p-3 mb-3">
                        <h2 class="mb-0">Data Drone</h2>
                    </div>
                    
                    <div class="d-flex flex-column gap-3">
                        <div class="card border-0 shadow-sm bg-white p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted small fw-bold">Total Fleet</h6>
                                    <h3 class="fw-bold mb-0"><?php echo $data_total['total']; ?></h3>
                                </div>
                                <div class="bg-dark text-white rounded p-3">
                                    <i class="bi bi-cpu fs-4"></i>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm bg-white p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted small fw-bold">Siap Terbang</h6>
                                    <h3 class="text-primary fw-bold mb-0"><?php echo $data_terbang['total']; ?></h3>
                                </div>
                                <div class="bg-primary text-white rounded p-3">
                                    <i class="bi bi-cloud-arrow-up fs-4"></i>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm bg-white p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted small fw-bold">Selesai Perbaikan</h6>
                                    <h3 class="text-success fw-bold mb-0"><?php echo $data_perbaikan['total']; ?></h3>
                                </div>
                                <div class="bg-success text-white rounded p-3">
                                    <i class="bi bi-check-circle fs-4"></i>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm bg-white p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted small fw-bold">Sedang Perbaikan</h6>
                                    <h3 class="text-warning fw-bold mb-0"><?php echo $data_rusak['total']; ?></h3>
                                </div>
                                <div class="bg-warning text-dark rounded p-3">
                                    <i class="bi bi-tools fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm bg-white p-3 mb-3">
                        <h2 class="mb-0">Data Operasional </h2>
                    </div>
                    
                    <div class="d-flex flex-column gap-3">
                        <div class="card border-0 shadow-sm bg-white p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted small fw-bold">Bengkal</h6>
                                    <h3 class="fw-bold mb-0"><?php echo $data_bengkal['total']; ?></h3>
                                </div>
                                <div class="bg-dark text-white rounded p-3">
                                    <i class="bi bi-airplane-engines-fill  fs-4"></i>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm bg-white p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted small fw-bold">Santan</h6>
                                    <h3 class="text-primary fw-bold mb-0"><?php echo $data_santan['total']; ?></h3>
                                </div>
                                <div class="bg-primary text-white rounded p-3">
                                    <i class="bi bi-airplane-engines-fill  fs-4"></i>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm bg-white p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted small fw-bold">Sebulu</h6>
                                    <h3 class="text-success fw-bold mb-0"><?php echo $data_sebulu['total']; ?></h3>
                                </div>
                                <div class="bg-success text-white rounded p-3">
                                    <i class="bi bi-airplane-engines-fill "></i>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm bg-white p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted small fw-bold">Sei Mao</h6>
                                    <h3 class="text-warning fw-bold mb-0"><?php echo $data_sei['total']; ?></h3>
                                </div>
                                <div class="bg-warning text-dark rounded p-3">
                                    <i class="bi bi-airplane-engines-fill "></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
                        <?php elseif($menu == 'drone'): 
                            $is_edit_drone = false;
                            if(isset($_GET['edit_id'])) {
                                $edit_id = $_GET['edit_id'];
                                $q_edit = mysqli_query($conn, "SELECT * FROM drones WHERE id='$edit_id'");
                                $data_edit = mysqli_fetch_array($q_edit);
                                $is_edit_drone = true;
                            }
                        ?>
                        <div class="card-custom p-4 mb-4 <?= $is_edit_drone ? 'border-warning border-top border-4 bg-light' : '' ?>">
                            <h6 class="fw-bold mb-3 <?= $is_edit_drone ? 'text-warning' : 'text-primary' ?>">
                                <i class="bi <?= $is_edit_drone ? 'bi-pencil-square' : 'bi-plus-circle' ?> me-2"></i>
                                <?= $is_edit_drone ? 'Edit Data Drone' : 'Tambah Data Drone Baru' ?>
                            </h6>
                            <form method="POST" class="row g-3">
                                <?php if($is_edit_drone): ?>
                                    <input type="hidden" name="id" value="<?= $data_edit['id']; ?>">
                                <?php endif; ?>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small">Kode Drone</label>
                                    <input type="text" name="kode_drone" class="form-control" placeholder="Contoh: DRN-003" value="<?= $is_edit_drone ? $data_edit['kode_drone'] : '' ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small">Merk & Model</label>
                                    <input type="text" name="merk_model" class="form-control" placeholder="Contoh: DJI Mavic 3" value="<?= $is_edit_drone ? $data_edit['merk_model'] : '' ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small">Kondisi</label>
                                    <select name="kondisi" class="form-select" required>
                                        <option value="Siap Terbang" <?= ($is_edit_drone && $data_edit['kondisi'] == 'Siap Terbang') ? 'selected' : '' ?>>Siap Terbang</option>
                                        <option value="Dalam Perbaikan" <?= ($is_edit_drone && $data_edit['kondisi'] == 'Dalam Perbaikan') ? 'selected' : '' ?>>Dalam Perbaikan</option>
                                        <option value="Rusak" <?= ($is_edit_drone && $data_edit['kondisi'] == 'Rusak') ? 'selected' : '' ?>>Rusak</option>
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end gap-2">
                                    <?php if($is_edit_drone): ?>
                                        <button type="submit" name="update_drone" class="btn btn-warning w-100 fw-bold text-white"><i class="bi bi-save me-1"></i> Update</button>
                                        <a href="?menu=drone" class="btn btn-outline-secondary">Batal</a>
                                    <?php else: ?>
                                        <button type="submit" name="simpan_drone" class="btn btn-primary w-100"><i class="bi bi-save me-1"></i> Simpan</button>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>

            <div class="card-custom overflow-hidden">
                <div class="p-4 border-bottom">
                    <h6 class="fw-bold mb-0"><i class="bi bi-list-ul me-2"></i>Daftar Aset Drone</h6>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0 text-center align-middle">
                        <thead>
                            <tr><th>No</th><th>Kode Drone</th><th>Merk & Model</th><th>Kondisi</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            $drones = mysqli_query($conn, "SELECT * FROM drones ORDER BY id DESC");
                            while($d = mysqli_fetch_array($drones)): 
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="fw-semibold"><code class="text-dark"><?= $d['kode_drone']; ?></code></td>
                                <td><?= $d['merk_model']; ?></td>
                                <td>
                                    <span class="badge <?= $d['kondisi']=='Siap Terbang' ? 'badge-siap' : 'badge-perbaikan' ?> px-3 py-2 rounded-pill"><?= $d['kondisi']; ?></span>
                                </td>
                                <td>
                                    <a href="?menu=drone&edit_id=<?= $d['id']; ?>" class="btn-action text-warning"><i class="bi bi-pencil-square"></i></a>
                                    <a href="?menu=drone&delete_id=<?= $d['id']; ?>" class="btn-action text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data drone ini?');"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php elseif($menu == 'lokasi'): 
                $is_edit_lok = false;
                if(isset($_GET['edit_id'])) {
                    $edit_id = $_GET['edit_id'];
                    $q_edit_lok = mysqli_query($conn, "SELECT * FROM lokasi_kerja WHERE id='$edit_id'");
                    $data_lok = mysqli_fetch_array($q_edit_lok);
                    $is_edit_lok = true;
                }
            ?>
            <div class="card-custom p-4 mb-4 <?= $is_edit_lok ? 'border-warning border-top border-4 bg-light' : '' ?>">
                <h6 class="fw-bold mb-3 <?= $is_edit_lok ? 'text-warning' : 'text-primary' ?>">
                    <i class="bi <?= $is_edit_lok ? 'bi-pencil-square' : 'bi-plus-circle' ?> me-2"></i>
                    <?= $is_edit_lok ? 'Edit Operasional Lokasi' : 'Tambah Operasional Lokasi' ?>
                </h6>
                <form method="POST" class="row g-3">
                    <?php if($is_edit_lok): ?><input type="hidden" name="id" value="<?= $data_lok['id']; ?>"><?php endif; ?>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">Lokasi (Distrik)</label>
                        <select name="distrik" class="form-select" required>
                            <option value="Distrik Bengkal" <?= ($is_edit_lok && $data_lok['distrik'] == 'Distrik Bengkal') ? 'selected' : '' ?>>Distrik Bengkal</option>
                            <option value="Distrik Santan" <?= ($is_edit_lok && $data_lok['distrik'] == 'Distrik Santan') ? 'selected' : '' ?>>Distrik Santan</option>
                            <option value="Distrik Sebulu" <?= ($is_edit_lok && $data_lok['distrik'] == 'Distrik Sebulu') ? 'selected' : '' ?>>Distrik Sebulu</option>
                            <option value="Distrik Sei mao" <?= ($is_edit_lok && $data_lok['distrik'] == 'Distrik Sei mao') ? 'selected' : '' ?>>Distrik Sei mao</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">No SPK</label>
                        <input type="text" name="no_spk" class="form-control" value="<?= $is_edit_lok ? $data_lok['no_spk'] : '' ?>" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small">No Petak</label>
                        <input type="text" name="no_petak" class="form-control" value="<?= $is_edit_lok ? $data_lok['no_petak'] : '' ?>" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small">Tanggal Ops</label>
                        <input type="date" name="tanggal_ops" class="form-control" value="<?= $is_edit_lok ? $data_lok['tanggal_ops'] : '' ?>" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <?php if($is_edit_lok): ?>
                            <button type="submit" name="update_lokasi" class="btn btn-warning w-100 fw-bold text-white"><i class="bi bi-save me-1"></i> Update</button>
                            <a href="?menu=lokasi" class="btn btn-outline-secondary">Batal</a>
                        <?php else: ?>
                            <button type="submit" name="simpan_lokasi" class="btn btn-primary w-100"><i class="bi bi-save me-1"></i> Simpan</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="card-custom overflow-hidden">
                <div class="p-4 border-bottom">
                    <h6 class="fw-bold mb-0"><i class="bi bi-list-ul me-2"></i>Daftar Lokasi Operasional</h6>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0 text-center align-middle">
                        <thead>
                            <tr><th>No</th><th>Distrik</th><th>No SPK</th><th>No Petak</th><th>Tanggal Ops</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            $query_lokasi = mysqli_query($conn, "SELECT * FROM lokasi_kerja ORDER BY id DESC");
                            while($row = mysqli_fetch_array($query_lokasi)): 
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="fw-semibold text-start px-4"><?= $row['distrik']; ?></td>
                                <td><code class="text-dark"><?= $row['no_spk']; ?></code></td>
                                <td><span class="badge bg-light text-dark border px-3 py-2"><?= $row['no_petak']; ?></span></td>
                                <td><i class="bi bi-calendar3 me-1 text-muted"></i> <?= date('d M Y', strtotime($row['tanggal_ops'])); ?></td>
                                <td>
                                    <a href="?menu=lokasi&edit_id=<?= $row['id']; ?>" class="btn-action text-warning"><i class="bi bi-pencil-square"></i></a>
                                    <a href="?menu=lokasi&delete_id=<?= $row['id']; ?>" class="btn-action text-danger" onclick="return confirm('Yakin ingin menghapus data lokasi ini?');"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php elseif($menu == 'users'): ?>
            <div class="card-custom overflow-hidden">
                <div class="p-4 border-bottom">
                    <h6 class="fw-bold mb-0"><i class="bi bi-people text-primary me-2"></i> Manajemen Users</h6>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0 text-center align-middle">
                        <thead>
                            <tr><th>No</th><th>Username</th><th>Status</th><th>Terdaftar Pada</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            $users = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
                            while($u = mysqli_fetch_array($users)): 
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="fw-semibold"><?= $u['username']; ?></td>
                                <td><span class="badge <?= $u['status']=='Admin'?'badge-admin':'badge-user' ?> px-3 py-2 rounded-pill"><?= $u['status']; ?></span></td>
                                <td><i class="bi bi-clock me-1 text-muted"></i> <?= date('d M Y', strtotime($u['created_at'])); ?></td>
                                <td>
                                    <a href="?menu=users&delete_id=<?= $u['id']; ?>" class="btn-action text-danger" onclick="return confirm('Hapus user ini?');"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php else: ?>
                <div class="alert alert-danger">Halaman tidak ditemukan.</div>
            <?php endif; ?>
            
        </div>
    </div>
</body>
</html>