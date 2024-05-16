<!doctype html>
<html lang="en" style="height:100%;">
<?php
include_once "baglan.php";

$urladres = $_SERVER['REQUEST_URI'];
$site_sql = $conn->prepare("SELECT * FROM arda");
$site_sql->execute();
$site = $site_sql->fetch();

if (isset($_COOKIE["a"])) {
    $kadi = $_COOKIE["a"];
}
$bugun = date("d.m.Y");
$aylar = array(
    "OCAK",
    "ŞUBAT",
    "MART",
    "NİSAN",
    "MAYIS",
    "HAZİRAN",
    "TEMMUZ",
    "AĞUSTOS",
    "EYLÜL",
    "EKİM",
    "KASIM",
    "ARALIK"
);
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta property="og:description" content="">
    <title>
        ARDA ANIL - Cüzdanım TR
    </title>
    <!-- FAVICON -->
    <link rel="icon" href="img/a_logo.png">
    <!-- CSS -->
    <link rel="stylesheet" href="assets/style.css">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- ICONS -->
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <div class="d-none">
        <?php echo $site["about_me"]; ?>
    </div>
</head>

<body>
    <div id="blok" class="col-md-8 col-12 m-auto border-secondary container pb-3">
        <div class="container">
            <?php
            $mevcut_ay = substr($bugun, -3, -6);
            echo $mevcut_ay;
            if (isset($_GET["seo"])) {
                $k = explode("/", rtrim($_GET["seo"], "/"));
                $dosya_kategori = $k[0];
                if (file_exists($dosya_kategori . ".php")) {
                    include $dosya_kategori . ".php";
                } else {
                    $icerik = $conn->prepare("SELECT * FROM kategoriler WHERE link='$dosya_kategori'");
                    $icerik->execute();
                    $icerikgetir = $icerik->fetch(PDO::FETCH_ASSOC);
                    if ($icerikgetir) {
                        $baslik_kategori = $icerikgetir['kategori'];
                        if (isset($k[1])) {
                            include "detay.php";
                        } else {
                            include "liste.php";
                        }
                    } else {
                        include "liste.php";
                    }
                }
            } else {
                include "anasayfa.php";
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N"
        crossorigin="anonymous"></script>
    <!--JQUERY -->
    <script src="assets/script.js?2024-01-29"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.js"></script>
</body>

</html>