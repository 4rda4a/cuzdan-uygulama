<?php
include_once "../baglan.php";
$kod = clean($_POST["kod"]);
if (isset($_POST["id"])) {
    $id = clean($_POST["id"]);
}
$date_time = time();
$bugun = date("d.m.Y");
if ($kod == 0) {
    $veri_sql = $conn->prepare("SELECT * FROM tarihler WHERE id='$id'");
    $veri_sql->execute();
    $veri = $veri_sql->fetch();
    echo $veri["tarih"];
}
if ($kod == 3) {
    $veri_sql = $conn->prepare("SELECT * FROM tarihler WHERE id='$id'");
    $veri_sql->execute();
    $veri = $veri_sql->fetch();
    echo $veri["tarih"];
}
if ($kod == 1) {
    $gider = clean($_POST["gider"]);
    $tarih_id = clean($_POST["tarih_id"]);
    $aciklama = clean($_POST["aciklama"]);
    $sql = "INSERT INTO `giderler` 
    (`gider`, `aciklama`, `tarih`) VALUES 
    ('$gider','$aciklama', '$tarih_id');";
    $conn->exec($sql);
    $veri_sql = $conn->prepare("SELECT * FROM giderler ORDER BY id DESC");
    $veri_sql->execute();
    $veri = $veri_sql->fetch();
    echo $veri["id"];
}
if ($kod == 2) {
    $veri_sql = $conn->prepare("SELECT * FROM giderler WHERE id='$id'");
    $veri_sql->execute();
    $veri = $veri_sql->fetch();
    echo $veri["gider"] . ",";
    echo $veri["tarih"];
    $sql = "DELETE FROM `giderler` WHERE `giderler`.`id` = $id";
    $conn->exec($sql);
}
if ($kod == 4) {
    $sql = "DELETE FROM `giderler` WHERE `giderler`.`tarih` = $id";
    $conn->exec($sql);
    $sql = "DELETE FROM `tarihler` WHERE `tarihler`.`id` = $id";
    $conn->exec($sql);
}
if ($kod == 5) {
    $tarih = clean($_POST["tarih"]);
    $tarih_t = clean($_POST["tarih"]);
    $tarih = str_replace("-", ".", $tarih);
    $gun = substr($tarih, 8);
    $ay = substr($tarih, -5, -3);
    $yil = substr($tarih, 0, 4);
    $tarih_y = $gun . "." . $ay . "." . $yil;
    $veri_sql = $conn->prepare("SELECT * FROM tarihler WHERE tarih='$tarih_y'");
    $veri_sql->execute();
    if ($veri_sql->rowCount() > 0) {
        echo "Tarih daha önce kullanılmıştır!";
    } else {
        $date_time = strtotime("$tarih_t");
        $sql = "INSERT INTO `tarihler` 
                (`tarih`, `date`) VALUES 
                ('$tarih_y', '$date_time');";
        $conn->exec($sql);
    }
}
if ($kod == 6) {
    $gider = clean($_POST["gider"]);
    $aciklama = clean($_POST["aciklama"]);

    $veri_sql = $conn->prepare("SELECT * FROM tarihler WHERE tarih='$bugun' ORDER BY id DESC");
    $veri_sql->execute();
    if ($veri_sql->rowCount() > 0) {
        $veri = $veri_sql->fetch();

        $veri_sql = $conn->prepare("SELECT * FROM tarihler ORDER BY id DESC");
        $veri_sql->execute();
        $veri = $veri_sql->fetch();

        echo $veri["id"] . ","; //tarihin id'si
        $sql = "INSERT INTO `giderler` 
        (`gider`, `aciklama`, `tarih`) VALUES 
        ('$gider','$aciklama', '$veri[id]');";
        $conn->exec($sql);

        $veri_sql = $conn->prepare("SELECT * FROM giderler ORDER BY id DESC");
        $veri_sql->execute();
        $veri = $veri_sql->fetch();
        echo $veri["id"];
    } else {
        $sql = "INSERT INTO `tarihler` 
        (`tarih`, `date`) VALUES 
        ('$bugun', '$date_time');";
        $conn->exec($sql);

        $veri_sql = $conn->prepare("SELECT * FROM tarihler ORDER BY id DESC");
        $veri_sql->execute();
        $veri = $veri_sql->fetch();

        echo $veri["id"] . ","; //tarihin id'si
        $sql = "INSERT INTO `giderler` 
        (`gider`, `aciklama`, `tarih`) VALUES 
        ('$gider','$aciklama', '$veri[id]');";
        $conn->exec($sql);

        $veri_sql = $conn->prepare("SELECT * FROM giderler ORDER BY id DESC");
        $veri_sql->execute();
        $veri = $veri_sql->fetch();
        echo $veri["id"];
    }
}
if ($kod == 7) {
    $veri_sql = $conn->prepare("SELECT * FROM giderler WHERE id='$id'");
    $veri_sql->execute();
    $veri = $veri_sql->fetch();
    echo $veri["gider"] . ",";
    echo $veri["tarih"];
    $sql = "DELETE FROM `giderler` WHERE `giderler`.`id` = $id";
    $conn->exec($sql);
}
if ($kod == 8) {
    $sql = "DELETE FROM `tarihler` WHERE `tarihler`.`tarih` = '$bugun'";
    $conn->exec($sql);
}
?>