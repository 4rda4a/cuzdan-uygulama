<?php
if (isset($kadi)) { ?>
    <div class="mt-3">
        <h3>Günlük Gider
            <a href="exit" class="ms-3 text-danger text-decoration-none float-end">
                <i class="fi fi-rr-exit fs-3"></i>
            </a>
        </h3>
        <div class="row">
            <div class="col-6">
                <a href="months" class="btn btn-secondary col-sm-4 col-12">
                    Aylar <i class="fi fi-rr-calendar-days ps-2 pe-0"></i>
                </a>
            </div>
            <div class="col-6 text-end">
                <button type="button" class="btn btn-success col-sm-4 col-12" data-bs-toggle="modal"
                    data-bs-target="#genel_gider_ekle">
                    Tarih Ekle <i class="fi fi-rr-add ps-2 pe-0"></i>
                </button>
            </div>
        </div>
        <div class="modal fade" id="genel_gider_ekle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tarih Ekle</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="input-group mb-3">
                                <?php
                                $bugun_e = str_replace(".", "-", $bugun);
                                $ay = substr($bugun, -7, -5);
                                $yil = substr($bugun, -4);
                                ?>
                                <input type="date" class="form-control" id="tarih_input"
                                    value="<?php echo $yil . "-" . $ay; ?>-01">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                            onclick="fun(5)">Kaydet</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="genel_gider_ekle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tarih Ekle</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="input-group mb-3">
                                <input type="date" class="form-control" id="tarih_input" min="2023-01-01" max="2024-01-01">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                            onclick="fun(5)">Kaydet</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion mt-4" id="accordion-genel">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button bg-white border-1 border-bottom" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-controls="collapseOne">
                        <b>
                            <?php echo $bugun; ?>
                        </b>
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show">
                    <div class="accordion-body" id="#accordion-genel">
                        <div class="col-12 col-sm-8 m-auto">
                            <div class="input-group mb-3">
                                <input type="number" inputmode="tel" class="form-control" id="gider_b" autofocus>
                                <span class="input-group-text">₺</span>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text">Açıklama</span>
                                <textarea class="form-control text-uppercase" id="aciklama_b"></textarea>
                            </div>
                            <label id="err_gelir_b" class="text-danger fw-bold"></label>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" onclick="fun(6)">Kaydet</button>
                            </div>
                            <ul id="ul_b">
                                <?php
                                $top_gider = 0;
                                $veri_sql = $conn->prepare("SELECT * FROM tarihler WHERE tarih ='$bugun' ORDER BY id DESC");
                                $veri_sql->execute();
                                if ($veri_sql->rowCount() == 0) { ?>
                                    <script>
                                        documen.getElementById("top_p").innerHTML = 'TOPLAM = <span class="text-danger fw-bold" id="top_b"> 0 </span> <span class="text-danger fw-bold"> ₺</span>';
                                    </script>
                                <?php } else {
                                    $veri_b = $veri_sql->fetch();
                                    $icerik = $conn->prepare("SELECT * FROM giderler WHERE tarih ='$veri_b[id]'");
                                    $icerik->execute();
                                    $icerikgetir = $icerik->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($icerikgetir as $key => $veri3) { ?>
                                        <li id="gider_id_<?php echo $veri3["id"]; ?>">
                                            <?php echo $veri3["aciklama"] . " = <span class='fw-bold text-primary'>" . $veri3["gider"] . " ₺ </span>"; ?>
                                            <i class="btn fi fi-rr-trash btn-danger p-1 rounded-circle"
                                                onclick="fun(7, <?php echo $veri3['id']; ?>)"></i>
                                        </li>
                                        <?php
                                        $top_gider = $top_gider + $veri3["gider"];
                                    } ?>
                                <?php }
                                ?>
                            </ul>
                            <?php
                            echo '
                            <p class="m-0 fw-bold" id="top_p">
                                TOPLAM = <span class="text-danger fw-bold" id="top_b">' . $top_gider . '</span> <span class="text-danger fw-bold"> ₺</span>  
                            </p>
                            ';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $m = substr($bugun, -7);
            $veri_say = $conn->prepare("SELECT * FROM tarihler WHERE tarih LIKE '%$m%'");
            $veri_say->execute();
            $veri_say2 = $conn->prepare("SELECT * FROM tarihler WHERE tarih = '$bugun'");
            $veri_say2->execute();
            $dur = $veri_say->rowCount() - $veri_say2->rowCount();
            $icerik = $conn->prepare("SELECT * FROM tarihler WHERE tarih !='$bugun' ORDER BY date DESC LIMIT $dur");
            $icerik->execute();
            $icerikgetir = $icerik->fetchAll(PDO::FETCH_ASSOC);
            foreach ($icerikgetir as $key => $veri) { ?>
                <div class="accordion-item" id="accordion-item-<?php echo $veri['id']; ?>">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse<?php echo $veri["id"]; ?>"
                            aria-controls="collapse<?php echo $veri["id"]; ?>" id="accordion-header-<?php echo $veri['id']; ?>">
                            <?php echo $veri["tarih"] ?>
                            <a type="button" class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                onclick="fun(0, <?php echo $veri['id']; ?>)">
                                <i class="fi fi-rr-add m-0"></i>
                            </a>
                            <a type="button" class="btn btn-danger ms-3 float-end rounded-circle border-2 border-white"
                                data-bs-toggle="modal" data-bs-target="#exampleModal_2"
                                onclick="fun(3, <?php echo $veri['id']; ?>)">
                                <i class="fi fi-rr-trash m-0"></i>
                            </a>
                            <span id="toplam_button_err_<?php echo $veri['id']; ?>" class='ps-3 fw-bold'>

                            </span>
                        </button>
                    </h2>
                    <div id="collapse<?php echo $veri["id"]; ?>" class="accordion-collapse collapse"
                        data-bs-parent="#accordion-genel">
                        <div class="accordion-body">
                            <ul class="m-0" id="gelir_ul_<?php echo $veri["id"]; ?>">
                                <?php
                                $top_gider = 0;
                                $icerik = $conn->prepare("SELECT * FROM giderler WHERE tarih='$veri[id]' ORDER BY id ASC");
                                $icerik->execute();
                                $icerikgetir = $icerik->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($icerikgetir as $key => $veri_2) { ?>
                                    <li id="gider_id_<?php echo $veri_2['id']; ?>">
                                        <span>
                                            <?php echo $veri_2["aciklama"]; ?> =
                                        </span>
                                        <span class="text-end fw-bold text-primary">
                                            <?php echo $veri_2["gider"]; ?> ₺
                                        </span>
                                        <i class="btn fi fi-rr-trash btn-danger p-1 rounded-circle"
                                            onclick="fun(2, <?php echo $veri_2['id']; ?>)"></i>
                                    </li>
                                    <?php
                                    $top_gider = $top_gider + $veri_2["gider"];
                                } ?>
                            </ul>
                            <?php
                            echo '
                                <p class="m-0 fw-bold">
                                    TOPLAM = <span class="text-danger fw-bold" id="toplam_id_' . $veri["id"] . '">' . $top_gider . '</span> <span class="text-danger fw-bold"> ₺</span>  
                                </p>
                            ';
                            if ($top_gider == 0) { ?>
                                <script>
                                    document.getElementById("accordion-header-" + <?php echo $veri["id"]; ?>).classList.add("bg-danger");
                                    document.getElementById("accordion-header-" + <?php echo $veri["id"]; ?>).classList.add("text-white");
                                    document.getElementById("toplam_button_err_" + <?php echo $veri["id"]; ?>).innerHTML = "TOPLAM = 0";
                                </script>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Gider Ekle <span id="modal-tittle"></span></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <input type="hidden" id="gider_modal_input" value="">
                                <div class="input-group mb-3">
                                    <input type="number" inputmode="tel" class="form-control" id="gider">
                                    <span class="input-group-text">₺</span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">Açıklama</span>
                                    <textarea class="form-control text-uppercase" id="aciklama"></textarea>
                                </div>
                                <label id="err_gelir"></label>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="fun(1)">Kaydet</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal_2" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Silmek istediğinize emin misiniz?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" value="" id="del-accordion-id">
                            Tarih : <span id="del-date" class="fw-bold"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                onclick="fun(4)">Sil</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    $err = "";
    if (isset($_POST["giris"])) {
        $sifre = $_POST["password"];
        if ($sifre == "") {
            $err = "Lütfen şifre giriniz!";
        } else {
            $sifre = md5($sifre);
            if ($sifre == $site["pass"]) {
                $cookie_time = time() + 60 * 60 * 24 * 7; # 1 hafta
                $cookie = setcookie("a", $sifre, $cookie_time, "/");
                header("refresh: 0");
            }else{
                $err = "Yanlış şifre!";
            }
        }
    } ?>
    <style>
        #blok {
            position: absolute;
            height: 100%;
            bottom: 0px;
            top: 0px;
            left: 0;
            right: 0;
        }
    </style>
    <div class="card col-sm-8 m-auto col-11 position-absolute start-0 end-0 top-0 bottom-0 m-auto" style="height: 220px;">
        <form class="card-body" method="post">
            <h2>Cüzdanım TR - Giriş</h2>
            <div class="form-floating">
                <input name="password" type="password" class="form-control" placeholder="Şifre" autofocus>
                <label for="Şifre">Şifre</label>
            </div>
            <label class="text-danger">
                <?php echo $err; ?>
            </label>
            <div class="text-center mt-3">
                <button name="giris" class="btn btn-primary col-6 col-sm-4">Giriş</button>
            </div>
        </form>
    </div>
<?php } ?>