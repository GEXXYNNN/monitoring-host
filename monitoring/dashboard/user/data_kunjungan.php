<?php
session_start();
include '../../config/db.php';

// Ambil data kunjungan dari database
$query = "SELECT * FROM kunjungan WHERE id = {$_SESSION['id']}";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kunjungan</title>
    <link rel="stylesheet" href="../../assets/data_kunjungan.css">
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <li><a href="user.php">🏠 Beranda</a></li>
                <li><a href="data_kunjungan.php" class="active">📊 Data Kunjungan</a></li>
                <li><a href="profile.php">👤 Profil</a></li>
                <li><a href="../../routes/logout.php">🚪 Logout</a></li>
            </ul>
        </div>

        <!-- Konten Utama -->
        <div class="main-content">
            <header>
                <h1>Data Kunjungan</h1>
            </header>

            <!-- Statistik -->
            <div class="stats">
                <div class="card">
                    <h3>Total Kunjungan</h3>
                    <p>💡 <?= mysqli_num_rows($result) ?> kali</p>
                </div>
                <div class="card">
                    <h3>Kunjungan Terakhir</h3>
                    <p>📅 <?= date('d M Y') ?></p>
                </div>
            </div>

            <!-- Data Tabel -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>tanggal</th>
                            <th>nama</th>
                            <th>organisasi</th>
                            <th>tujuan</th>
                            <th>durasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$row['tanggal']}</td>
                                    <td>{$row['nama']}</td>
                                      <td>{$row['organisasi']}</td>
                                    <td>{$row['tujuan']}</td>
                                    <td>{$row['durasi']}</td>
                                  </tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
