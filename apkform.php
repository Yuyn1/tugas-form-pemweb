<!DOCTYPE html>
<html>
<head>
    <title>Biodata & Pencarian</title>
    <link rel="stylesheet" href="styleapkform.css">
</head>
<body class="minecraft-stone">
<div class="container">

    <!-- Form Biodata -->
    <h2>Form Biodata</h2>
    <form method="post" action="">
        <label>Nama Lengkap:</label><br>
        <input type="text" name="nama"><br><br>

        <label>NIM:</label><br>
        <input type="text" name="nim"><br><br>

        <label>Program Studi:</label><br>
        <select name="prodi">
            <option value="Informatika">Informatika</option>
            <option value="Sistem Informasi">Sistem Informasi</option>
            <option value="Teknik Elektro">Teknik Elektro</option>
        </select><br><br>

        <label>Jenis Kelamin:</label><br>
        <input type="radio" name="jk" value="Laki-laki"> Laki-laki
        <input type="radio" name="jk" value="Perempuan"> Perempuan<br><br>
        <input type="radio" name="jk" value="wallmart bag"> Wallmart Bag<br><br>

        <label>Hobi:</label><br>
        <input type="checkbox" name="hobi[]" value="Gk tau Hobi"> Gk tau Hobi
        <input type="checkbox" name="hobi[]" value="Sedang Mencari hobi"> Sedang Mencari hobi
        <input type="checkbox" name="hobi[]" value="Gk punya Hobi"> Gk punya Hobi<br><br>

        <label>Alamat:</label><br>
        <textarea name="alamat" rows="4" cols="30"></textarea><br><br>

        <button type="submit" name="submit_biodata" class="pay-btn">
        <span class="btn-text">Kirim</span>
        </button>
    </form>

    <?php
    if(isset($_POST['submit_biodata'])){
        $nama   = $_POST['nama'];
        $nim    = $_POST['nim'];
        $prodi  = $_POST['prodi'];
        $jk     = $_POST['jk'] ?? "-";
        $hobi   = !empty($_POST['hobi']) ? implode(", ", $_POST['hobi']) : "Tidak ada";
        $alamat = $_POST['alamat'];

        $data = "$nama|$nim|$prodi|$jk|$hobi|$alamat\n";

    file_put_contents("apkform.txt", $data, FILE_APPEND);

    echo "Data berhasil disimpan";
    }
    ?>

    <h2>Form Pencarian</h2>
<form method="get" action="">
    <label>Kata Kunci Pencarian:</label><br>
    <input type="text" name="keyword" value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
    <button type="submit" class="pay-btn">
        <span class="btn-text">Cari</span>
    </button>
</form>

<?php
$file = "apkform.txt";

if(file_exists($file) && filesize($file) > 0){
    $lines = file($file, FILE_IGNORE_NEW_LINES);

    // cek apakah ada keyword
    $keyword = isset($_GET['keyword']) ? strtolower(trim($_GET['keyword'])) : "";

    // filter hasil berdasarkan nama
    $filtered = [];
    foreach($lines as $line){
        $parts = explode("|", $line);
        if($keyword === "" || strpos(strtolower($parts[0]), $keyword) !== false){
            $filtered[] = $parts;
        }
    }

    if(count($filtered) > 0){
        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Prodi</th>
                <th>Jenis Kelamin</th>
                <th>Hobi</th>
                <th>Alamat</th>
              </tr>";

        $no = 1;
        foreach($filtered as $parts){
            echo "<tr>";
            echo "<td>".$no++."</td>";
            echo "<td>".$parts[0]."</td>";
            echo "<td>".$parts[1]."</td>";
            echo "<td>".$parts[2]."</td>";
            echo "<td>".$parts[3]."</td>";
            echo "<td>".$parts[4]."</td>";
            echo "<td>".$parts[5]."</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='result'>Data dengan kata kunci '<b>".htmlspecialchars($keyword)."</b>' tidak ditemukan.</div>";
    }

} else {
    echo "Belum ada data yang tersimpan.";
}
?>


</div>
</body>
</html>
