<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "laundry_db";
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah'])) {
        $id_pelanggan = $_POST['id_pelanggan'];
        $id_jenis = $_POST['id_jenis'];
        $jumlah = $_POST['jumlah'];
        $harga = $_POST['harga'];
        $total = $_POST['total'];
        $tanggal_terima = date('Y-m-d');
        $tanggal_selesai = date('Y-m-d', strtotime('+3 days'));

        $query = "INSERT INTO transaksi (id_pelanggan, id_jenis, tanggal_terima, tanggal_selesai, harga, jumlah, total) 
                  VALUES ('$id_pelanggan', '$id_jenis', '$tanggal_terima', '$tanggal_selesai', '$harga', '$jumlah', '$total')";
        mysqli_query($conn, $query);
        header("Location: index.php");
    }
    
    if (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $id_pelanggan = $_POST['id_pelanggan'];
        $id_jenis = $_POST['id_jenis'];
        $jumlah = $_POST['jumlah'];
        $harga = $_POST['harga'];
        $total = $_POST['total'];

        $query = "UPDATE transaksi SET 
                  id_pelanggan = '$id_pelanggan', 
                  id_jenis = '$id_jenis', 
                  harga = '$harga',
                  jumlah = '$jumlah', 
                  total = '$total' 
                  WHERE id_transaksi = $id";
        mysqli_query($conn, $query);
        header("Location: index.php");
    }
    
    if (isset($_POST['hapus'])) {
        $id = $_POST['id'];
        $query = "DELETE FROM transaksi WHERE id_transaksi = $id";
        mysqli_query($conn, $query);
        header("Location: index.php");
    }
}

$pelanggan_query = "SELECT * FROM pelanggan";
$pelanggan_result = mysqli_query($conn, $pelanggan_query);

$jenis_query = "SELECT * FROM jenis_laundry";
$jenis_result = mysqli_query($conn, $jenis_query);

$transaksi_query = "SELECT t.id_transaksi, p.nama, j.jenis_laundry AS jenis, j.harga, 
                           t.tanggal_terima, t.tanggal_selesai, t.jumlah, t.total 
                    FROM transaksi t 
                    JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan 
                    JOIN jenis_laundry j ON t.id_jenis = j.id_jenis";
$transaksi_result = mysqli_query($conn, $transaksi_query);

$edit_data = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_query = "SELECT * FROM transaksi WHERE id_transaksi = $id";
    $edit_result = mysqli_query($conn, $edit_query);
    $edit_data = mysqli_fetch_assoc($edit_result);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistem Laundry</title>
    <style>
        .container{display: grid; grid-template-columns: 3fr 1fr; gap: 15px;}
        .form-group{padding: 5px;}
        form{padding: 0; margin: 0;}
        .btn-success{background-color: green; color: #fff; border-style: none; padding: 5px 100px; border-radius: 5px;}
        .delete{background-color: red; color: #fff; padding: 5px 15px; border-style: none; border-radius: 5px;}
        .edit{color: #fff; border-style: none; padding: 5px 15px;}
        .edit{background-color: gray; padding: 5px 15px; border-radius: 5px;}
        a .edit{text-decoration: none;} 
    </style>

</head>
<body>
    <h1 align="center">Sistem Informasi Laundry</h1>
    <div class="container">
        <section>
            <table border="1" cellpadding="5" cellspacing="0" width="80%" align="center">
                <tr>
                    <th>ID</th>
                    <th>Nama Pelanggan</th>
                    <th>Jenis Laundry</th>
                    <th>Harga</th>
                    <th>Tanggal Terima</th>
                    <th>Tanggal Selesai</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
                <?php 
                    mysqli_data_seek($transaksi_result, 0);
                    while($row = mysqli_fetch_assoc($transaksi_result)) { ?>
                    <tr>
                        <td><?php echo $row['id_transaksi']; ?></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['jenis']; ?></td>
                        <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['tanggal_terima']; ?></td>
                        <td><?php echo $row['tanggal_selesai']; ?></td>
                        <td><?php echo $row['jumlah']; ?></td>
                        <td>Rp <?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                        <td align="center" >
                            <a href="index.php?edit=<?php echo $row['id_transaksi']; ?>" style="text-decoration: none; color: #fff;"><button class="edit">Edit</buttonclass=></a>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id_transaksi']; ?>">
                                <button type="submit" name="hapus" class="delete" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </section>
        <form method="post" action="">
            <div class="form-row">
                <div class="form-group">
                    <label>Pelanggan:</label><br><br>
                    <select name="id_pelanggan" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php while($row = mysqli_fetch_assoc($pelanggan_result)) { ?>
                            <option value="<?php echo $row['id_pelanggan']; ?>" 
                                <?php if($edit_data && $edit_data['id_pelanggan'] == $row['id_pelanggan']) echo 'selected'; ?>>
                                <?php echo $row['nama']; ?>
                            </option>
                        <?php } ?>  
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Jenis Laundry:</label><br><br>
                    <select name="id_jenis" id="jenis" onchange="tampilHarga()" required>
                        <option value="">-- Pilih Jenis --</option>
                        <?php 
                            mysqli_data_seek($jenis_result, 0);
                            while($row = mysqli_fetch_assoc($jenis_result)) { 
                                $selected = ($edit_data && $edit_data['id_jenis'] == $row['id_jenis']) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $row['id_jenis']; ?>" 
                                    data-harga="<?php echo $row['harga']; ?>" 
                                    <?php echo $selected; ?>>
                                <?php echo $row['jenis_laundry']?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Jumlah (kg/pcs):</label><br><br>
                    <input type="number" id="jumlah" name="jumlah" min="1" 
                           value="<?php echo $edit_data ? $edit_data['jumlah'] : 1; ?>" 
                           oninput="hitungTotal()" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Harga per Unit:</label><br><br>
                    <input type="text" id="harga" readonly>
                    <input type="hidden" id="harga_numeric" name="harga" 
                           value="<?php echo $edit_data ? $edit_data['harga'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label>Total Bayar:</label><br><br>
                    <input type="text" id="total" readonly>
                    <input type="hidden" id="total_numeric" name="total" 
                           value="<?php echo $edit_data ? $edit_data['total'] : ''; ?>">
                </div>

                <div class="form-group">
                    <label>Tanggal Terima:</label><br><br>
                    <input type="date" name="tanggal_terima" 
                           value="<?php echo $edit_data ? $edit_data['tanggal_terima'] : date('Y-m-d'); ?>" readonly>
                </div>
                
                <div class="form-group">
                    <label>Tanggal Selesai:</label><br><br>
                    <input type="date" name="tanggal_selesai" 
                           value="<?php echo $edit_data ? $edit_data['tanggal_selesai'] : date('Y-m-d', strtotime('+3 days')); ?>" readonly>
                </div>
            </div>
            
            <div class="form-group">
                <?php if($edit_data) { ?>
                    <input type="hidden" name="id" value="<?php echo $edit_data['id_transaksi']; ?>">
                    <button type="submit" name="edit" class="btn-success" style="padding: 5px 15px;">Update</button>
                    <a href="index.php"><button type="button" class="delete">Cancel</button></a>
                <?php } else { ?>
                    <button type="submit" name="tambah" class="btn-success">Save</button>
                <?php } ?>
            </div>
        </form>
        
        
    </div>

<script>
function formatRupiah(number) {
    return parseInt(number).toLocaleString('id-ID');
}

function tampilHarga() {
    let select = document.getElementById("jenis");
    let harga = select.options[select.selectedIndex].getAttribute("data-harga");
    
    document.getElementById("harga").value = harga ? "Rp " + formatRupiah(harga) : "";
    document.getElementById("harga_numeric").value = harga ? harga : "";

    hitungTotal();
}

function hitungTotal() {
    let harga = document.getElementById("harga_numeric").value;
    let jumlah = document.getElementById("jumlah").value;

    if (harga && jumlah) {
        let total = parseInt(harga) * parseInt(jumlah);
        document.getElementById("total").value = "Rp " + formatRupiah(total);
        document.getElementById("total_numeric").value = total;
    } else {
        document.getElementById("total").value = "";
        document.getElementById("total_numeric").value = "";
    }
}

window.onload = function() {
    tampilHarga();
}
</script>
</body>
</html>