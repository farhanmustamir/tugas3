<?php
// index.php

include 'konek.php';

// Formulir input data mahasiswa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tambah data mahasiswa
    if (isset($_POST["tambah"])) {
        $nama = $_POST["nama"];
        $nim = $_POST["nim"];
        $alamat = $_POST["alamat"];

        // Menyimpan data ke dalam tabel
        $sql = "INSERT INTO mahasiswa (nama, nim, alamat) VALUES ('$nama', '$nim', '$alamat')";

        if ($conn->query($sql) === TRUE) {
            echo "Data mahasiswa berhasil ditambahkan.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } 
    // Ubah data mahasiswa
    elseif (isset($_POST["update"])) {
        $id = $_POST["id"];
        $nama = $_POST["nama"];
        $nim = $_POST["nim"];
        $alamat = $_POST["alamat"];

        // Mengubah data dalam tabel
        $sql = "UPDATE mahasiswa SET nama='$nama', nim='$nim', alamat='$alamat' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Data mahasiswa berhasil diubah.";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } 
    // Hapus data mahasiswa
    elseif (isset($_POST["hapus"])) {
        $id = $_POST["id"];

        // Menghapus data dari tabel
        $sql = "DELETE FROM mahasiswa WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Data mahasiswa berhasil dihapus.";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

// Pencarian data mahasiswa
if (isset($_GET["cari"])) {
    $kata_kunci = $_GET["kata_kunci"];
    $sql = "SELECT * FROM mahasiswa WHERE nama LIKE '%$kata_kunci%' OR nim LIKE '%$kata_kunci%' OR alamat LIKE '%$kata_kunci%'";
} else {
    // Menampilkan semua data mahasiswa
    $sql = "SELECT * FROM mahasiswa";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Form Input Mahasiswa</h2>
        <!-- Formulir input data mahasiswa -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            Nama: <input type="text" name="nama" required><br>
            NIM: <input type="text" name="nim" required><br>
            Alamat: <input type="text" name="alamat" required><br>
            <input type="submit" name="tambah" value="Tambah">
        </form>

        <h2>Data Mahasiswa</h2>

        <!-- Formulir pencarian -->
        <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="text" name="kata_kunci" placeholder="Cari Mahasiswa">
            <input type="submit" name="cari" value="Cari">
        </form>

        <table>
            <tr>
                <th>Nama</th>
                <th>NIM</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['nama']}</td>
                            <td>{$row['nim']}</td>
                            <td>{$row['alamat']}</td>
                            <td>
                                <form method='post' action='{$_SERVER["PHP_SELF"]}'>
                                    <input type='hidden' name='id' value='{$row["id"]}'>
                                    <input type='text' name='nama' value='{$row["nama"]}'>
                                    <input type='text' name='nim' value='{$row["nim"]}'>
                                    <input type='text' name='alamat' value='{$row["alamat"]}'>
                                    <input type='submit' name='update' value='Update'>
                                    <input type='submit' name='hapus' value='Hapus'>
                                </form>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada data mahasiswa.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
// Menutup koneksi database
$conn->close();
?>