<?php
include '../../config/db.php';
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
$query_total = "SELECT COUNT(*) AS total FROM kunjungan";
$result_total = mysqli_query($conn, $query_total);
$total_kunjungan = ($result_total) ? mysqli_fetch_assoc($result_total)['total'] : 0;
$query_kunjungan = "SELECT * FROM kunjungan ORDER BY Tanggal DESC";
$result_kunjungan = mysqli_query($conn, $query_kunjungan);

if (!$result_kunjungan) {
    die("Query Error: " . mysqli_error($conn));
}
$query_chart = "SELECT MONTH(Tanggal) AS bulan, COUNT(*) AS jumlah FROM kunjungan GROUP BY MONTH(Tanggal) ORDER BY MONTH(Tanggal)";
$result_chart = mysqli_query($conn, $query_chart);

$labels = [];
$data = [];
while ($row = mysqli_fetch_assoc($result_chart)) {
    $bulan = date("F", mktime(0, 0, 0, $row['bulan'], 1)); 
    $labels[] = $bulan;
    $data[] = $row['jumlah'];
}
$labels_json = json_encode($labels);
$data_json = json_encode($data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../../assets/admin-style.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin.php">🏠 Dashboard</a>
        <a href="manage-users.php">👤 Kelola Pengguna</a>
        <a href="reports.php">📊 Laporan</a>
        <a href="../../routes/logout.php">🚪 Logout</a>
    </div>
    <div class="content">
        <h1>Selamat Datang, Admin!</h1>        
        <div class="card-container">
            <div class="card">
                <h3>Total Kunjungan</h3>
                <p><b><?php echo $total_kunjungan; ?> Kali</b></p>
            </div>
        </div>       
        <h2>Data Kunjungan</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Organisasi</th>
                        <th>Tujuan</th>
                        <th>Durasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($result_kunjungan)) { ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['Tanggal']; ?></td>
                        <td><?php echo $row['Nama']; ?></td>
                        <td><?php echo $row['Organisasi']; ?></td>
                        <td><?php echo $row['Tujuan']; ?></td>
                        <td><?php echo $row['Durasi']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <h2>Statistik Kunjungan</h2>
        <div class="chart-container">
            <canvas id="visitChart"></canvas>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('visitChart').getContext('2d');
        var labels = <?php echo $labels_json; ?>;
        var data = <?php echo $data_json; ?>;
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Kunjungan',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                },
                scales: {
                    y: { beginAtZero: true },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</body>
</html>
                                                                                                                                                                                  