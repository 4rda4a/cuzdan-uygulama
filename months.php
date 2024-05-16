<div class="pt-3 row">
    <?php if (isset($_GET["t"]) && isset($kadi)) {
        $ay = clean($_GET["t"]);
        $yil = substr($ay, 3);
        $ay_id = substr($ay, 0, 2);
        $ay_id_eksi = substr($ay, 0, 2) - 1;
        $m = $ay_id . "." . $yil;
        ?>
        <h3>
            <a href="./months?year=<?php echo $_SESSION["year"]; ?>" class="text-decoration-none text-primary">
                <i class="fi fi-rr-angle-double-small-left fs-1 m-0"></i>
            </a>
            AYLAR /
            <?php echo $aylar[$ay_id_eksi] . '(' . $yil . ')'; ?>
            <a href="pdf.php?t=<?php echo $ay . '&ay=' . te(strtoupper($aylar[$ay_id_eksi])) . '&yil=' . $_SESSION["year"]; ?>"
                class="float-end nav-link text-primary" target="_blank" download>
                <i class="fi fi-rr-file-download fs-2"></i>
            </a>
            <a href="pdf.php?t=<?php echo $ay . '&ay=' . te(strtoupper($aylar[$ay_id_eksi])) . '&yil=' . $_SESSION["year"]; ?>"
                class="float-end nav-link text-primary me-3" target="_blank">
                <i class="fi fi-rr-share fs-2"></i>
            </a>
        </h3>
        <table class="table table-bordered border-dark">
            <thead>
                <tr class="row">
                    <th scope="col" class="col-6">Gider</th>
                    <th scope="col" class="col-6">Açıklama</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $top = 0;
                $veri_sql = $conn->prepare("SELECT * FROM tarihler WHERE tarih LIKE '%$m%' ORDER BY tarih ASC");
                $veri_sql->execute();
                $veri_b = $veri_sql->fetchAll();
                foreach ($veri_b as $key => $veri_b) { ?>
                    <tr class="row">
                        <th class="col-12 bg-warning">
                            <?php echo $veri_b["tarih"]; ?>
                        </th>
                    </tr>
                    <?php
                    $icerik = $conn->prepare("SELECT * FROM giderler WHERE tarih ='$veri_b[id]'");
                    $icerik->execute();
                    $toplam_icerik = $icerik->rowCount();
                    $icerikgetir = $icerik->fetchAll(PDO::FETCH_ASSOC);
                    $toplam = 0;
                    foreach ($icerikgetir as $key => $veri) {
                        ?>
                        <tr class="row">
                            <td class="col-6">
                                <span class="fw-bold text-danger">
                                    <?php echo $veri["gider"]; ?> ₺
                                </span>
                            </td>
                            <td class="col-6 text-uppercase">
                                <?php echo $veri["aciklama"]; ?>
                            </td>
                        </tr>
                        <?php
                        $toplam = $toplam + $veri["gider"];
                    } ?>
                    <tr class="row">
                        <th class="col-12 bg-danger">
                            Toplam:
                            <?php echo $toplam; ?> ₺
                        </th>
                    </tr>
                    <?php
                    $top = $top + $toplam;
                }
                ?>
                <p class="fw-bold fs-5">
                    Toplam Aylık Gider:
                    <span class="text-danger fs-4">
                        <?php echo $top; ?>
                    </span> ₺
                </p>
            </tbody>
        </table>
        <?php
    } else {
        if (isset($_GET['year'])) {
            $_SESSION["year"] = $_GET['year'];
        } else {
            $_SESSION["year"] = date("Y");
        }
        ?>
        <table class="table table-bordered border-dark text-center">
            <h3>
                <a href="./" id="left" class="text-decoration-none text-primary">
                    <i class="fi fi-rr-angle-double-small-left fs-1 m-0"></i>
                </a>
                Aylar
            </h3>
            <div class="card col-sm-5 m-auto mb-3 px-0">
                <div class="card-header">
                    Yıl Seçiniz
                </div>
                <ul class="list-group list-group-flush">
                    <a href="?year=2024" class="list-group-item fw-bold <?php if (isset($_GET['year'])) {
                        if ($_GET['year'] == 2024) {
                            echo 'text-primary';
                        }
                    } else {
                        if (date('Y') == 2024) {
                            echo 'text-primary';
                        }
                    } ?>">2024</a>
                    <a href="?year=2023" class="list-group-item fw-bold <?php if (isset($_GET['year'])) {
                        if ($_GET['year'] == 2023) {
                            echo 'text-primary';
                        }
                    } else {
                        if (date('Y') == 2023) {
                            echo 'text-primary';
                        }
                    } ?>">2023</a>
                </ul>
            </div>
            <tr class="col-12">
                <th class="col-3" id="t01-<?php if (isset($_GET['year'])) {
                    echo $_GET['year'];
                } else {
                    echo date('Y');
                } ?>">
                    <a href="?t=01-<?php if (isset($_GET['year'])) {
                        echo $_GET['year'];
                    } else {
                        echo date('Y');
                    } ?>">
                        OCAK
                    </a>
                    1
                </th>
                <th class="col-3" id="t02-<?php if (isset($_GET['year'])) {
                    echo $_GET['year'];
                } else {
                    echo date('Y');
                } ?>">
                    <a href="?t=02-<?php if (isset($_GET['year'])) {
                        echo $_GET['year'];
                    } else {
                        echo date('Y');
                    } ?>">
                        ŞUBAT
                    </a>
                </th>
                <th class="col-3" id="t03-<?php if (isset($_GET['year'])) {
                    echo $_GET['year'];
                } else {
                    echo date('Y');
                } ?>">
                    <a href="?t=03-<?php if (isset($_GET['year'])) {
                        echo $_GET['year'];
                    } else {
                        echo date('Y');
                    } ?>">
                        MART
                    </a>
                </th>
                <th class="col-3" id="t04-<?php if (isset($_GET['year'])) {
                    echo $_GET['year'];
                } else {
                    echo date('Y');
                } ?>">
                    <a href="?t=04-<?php if (isset($_GET['year'])) {
                        echo $_GET['year'];
                    } else {
                        echo date('Y');
                    } ?>">
                        NİSAN
                    </a>
                </th>
            </tr>
            <tr class="col-12">
                <th class="col-3" id="t05-<?php if (isset($_GET['year'])) {
                    echo $_GET['year'];
                } else {
                    echo date('Y');
                } ?>">
                    <a href="?t=05-<?php if (isset($_GET['year'])) {
                        echo $_GET['year'];
                    } else {
                        echo date('Y');
                    } ?>">
                        MAYIS
                    </a>
                    1
                </th>
                <th class="col-3" id="t06-<?php if (isset($_GET['year'])) {
                    echo $_GET['year'];
                } else {
                    echo date('Y');
                } ?>">
                    <a href="?t=06-<?php if (isset($_GET['year'])) {
                        echo $_GET['year'];
                    } else {
                        echo date('Y');
                    } ?>">
                        HAZİRAN
                    </a>
                </th>
                <th class="col-3" id="t07-<?php if (isset($_GET['year'])) {
                    echo $_GET['year'];
                } else {
                    echo date('Y');
                } ?>">
                    <a href="?t=07-<?php if (isset($_GET['year'])) {
                        echo $_GET['year'];
                    } else {
                        echo date('Y');
                    } ?>">
                        TEMMUZ
                    </a>
                </th>
                <th class="col-3" id="t08-<?php if (isset($_GET['year'])) {
                    echo $_GET['year'];
                } else {
                    echo date('Y');
                } ?>">
                    <a href="?t=08-<?php if (isset($_GET['year'])) {
                        echo $_GET['year'];
                    } else {
                        echo date('Y');
                    } ?>">
                        AĞUSTOS
                    </a>
                </th>
            </tr>
            <tr class="col-12">
                <th class="col-3" id="t09-<?php if (isset($_GET['year'])) {
                    echo $_GET['year'];
                } else {
                    echo date('Y');
                } ?>">
                    <a href="?t=09-<?php if (isset($_GET['year'])) {
                        echo $_GET['year'];
                    } else {
                        echo date('Y');
                    } ?>">
                        EYLÜL
                    </a>
                    1
                </th>
                <th class="col-3" id="t10-<?php if (isset($_GET['year'])) {
                    echo $_GET['year'];
                } else {
                    echo date('Y');
                } ?>">
                    <a href="?t=10-<?php if (isset($_GET['year'])) {
                        echo $_GET['year'];
                    } else {
                        echo date('Y');
                    } ?>">
                        EKİM
                    </a>
                </th>
                <th class="col-3" id="t11-<?php if (isset($_GET['year'])) {
                    echo $_GET['year'];
                } else {
                    echo date('Y');
                } ?>">
                    <a href="?t=11-<?php if (isset($_GET['year'])) {
                        echo $_GET['year'];
                    } else {
                        echo date('Y');
                    } ?>">
                        KASIM
                    </a>
                </th>
                <th class="col-3" id="t12-<?php if (isset($_GET['year'])) {
                    echo $_GET['year'];
                } else {
                    echo date('Y');
                } ?>">
                    <a href="?t=12-<?php if (isset($_GET['year'])) {
                        echo $_GET['year'];
                    } else {
                        echo date('Y');
                    } ?>">
                        ARALIK
                    </a>
                </th>
            </tr>
        </table>
        <style>
            #left {
                position: static;
            }

            th {
                line-height: 200px;
                transition: 0.5s;
                background-color: #def5ffb0 !important;
                position: relative;
                color: #def5ffb0;
            }

            th:hover a {
                font-size: 1.1em;
                background-color: #b9eaffb0 !important;
            }

            tr a {
                transition: 0.5s;
                text-decoration: none;
                color: #000;
                position: absolute;
                top: 0;
                right: 0;
                left: 0;
                bottom: 0;
                margin: auto;
            }

            <?php
            $bugun = substr($bugun, -7);
            $bugun = str_replace(".", "-", $bugun);
            echo '
        #t' . $bugun . '{
            background-color: #b9eaffb0 !important;
            font-size: 1.3em;
        }
        #t' . $bugun . ' a{
            font-size: 1.3em;
        }
        ';
            ?>
        </style>
    <?php } ?>
</div>