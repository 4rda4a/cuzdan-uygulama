function fun(kod, id) {
    if (kod === 0) {
        $.ajax({
            url: "assets/ajax.php",
            type: "POST",
            data: "kod=" + kod + "&id=" + id,
            success: function (data) {
                document.getElementById("modal-tittle").innerHTML = " - " + data;
                document.getElementById("gider_modal_input").value = id;
            }
        });
    }
    if (kod === 1) {
        gider = document.getElementById("gider").value;
        tarih_id = document.getElementById("gider_modal_input").value;
        aciklama = document.getElementById("aciklama").value;
        document.getElementById("aciklama").value = "";
        document.getElementById("gider").value = "";
        document.getElementById("err_gelir").innerHTML = "";
        if (gider != "" && tarih_id != "" && aciklama != "") {
            $.ajax({
                url: "assets/ajax.php",
                type: "POST",
                data: "kod=" + kod + "&gider=" + gider + "&tarih_id=" + tarih_id + "&aciklama=" + aciklama,
                success: function (data) {
                    toplam = Number(document.getElementById("toplam_id_" + tarih_id).innerText);
                    gider = Number(gider);
                    toplam = toplam + gider;
                    document.getElementById("err_gelir").innerHTML = "<span class='text-success'>Gelir kayıt edildi.<span>";
                    var x = document.createElement("LI");
                    x.setAttribute("id", "gider_id_" + data);
                    document.getElementById("gelir_ul_" + tarih_id).appendChild(x);
                    document.getElementById("gider_id_" + data).innerHTML = aciklama + " = ";
                    var x = document.createElement("SPAN");
                    x.setAttribute("id", "gider_span_" + data);
                    x.classList.add("fw-bold", "text-primary");
                    document.getElementById("gider_id_" + data).appendChild(x);
                    document.getElementById("gider_span_" + data).innerHTML = gider + " ₺ ";
                    var x = document.createElement("I");
                    x.addEventListener('click', function del_gider() {
                        kod = 2;
                        id = data;
                        $.ajax({
                            url: "assets/ajax.php",
                            type: "POST",
                            data: "kod=" + kod + "&id=" + id,
                            success: function (data) {
                                document.getElementById("gider_id_" + id).remove();
                                array_data = data.split(",");
                                cikar = Number(array_data[0]);
                                toplam = Number(document.getElementById("toplam_id_" + array_data[1]).innerText);
                                snc = toplam - cikar;
                                if (snc == 0) {
                                    document.getElementById("accordion-header-" + tarih_id).classList.add("bg-danger");
                                    document.getElementById("accordion-header-" + tarih_id).classList.add("text-white");
                                    document.getElementById("toplam_button_err_" + tarih_id).innerHTML = "TOPLAM = 0";
                                }
                                document.getElementById("toplam_id_" + tarih_id).innerHTML = snc;
                            }
                        });
                    });
                    x.classList.add("btn", "fi", "fi-rr-trash", "btn-danger", "p-1", "rounded-circle");
                    document.getElementById("gider_span_" + data).appendChild(x);
                    document.getElementById("toplam_id_" + tarih_id).innerHTML = toplam;
                    if (toplam > 0) {
                        document.getElementById("accordion-header-" + tarih_id).classList.remove("bg-danger");
                        document.getElementById("accordion-header-" + tarih_id).classList.remove("text-white");
                        document.getElementById("toplam_button_err_" + tarih_id).innerHTML = "";
                    }
                }
            });
        } else {
            document.getElementById("err_gelir").innerHTML = "<span class='text-danger'>Bütün alanları doldurunuz.<span>";
        }
    }
    if (kod === 2) {
        $.ajax({
            url: "assets/ajax.php",
            type: "POST",
            data: "kod=" + kod + "&id=" + id,
            success: function (data) {
                document.getElementById("gider_id_" + id).remove();
                array_data = data.split(",");
                cikar = Number(array_data[0]);
                toplam = Number(document.getElementById("toplam_id_" + array_data[1]).innerText);
                snc = toplam - cikar;
                if (snc == 0) {
                    document.getElementById("accordion-header-" + array_data[1]).classList.add("bg-danger");
                    document.getElementById("accordion-header-" + array_data[1]).classList.add("text-white");
                    document.getElementById("toplam_button_err_" + array_data[1]).innerHTML = "TOPLAM = 0";
                }
                document.getElementById("toplam_id_" + array_data[1]).innerHTML = snc;
            }
        });
    }
    if (kod === 3) {
        $.ajax({
            url: "assets/ajax.php",
            type: "POST",
            data: "kod=" + kod + "&id=" + id,
            success: function (data) {
                document.getElementById("del-date").innerHTML = data;
                document.getElementById("del-accordion-id").value = id;
            }
        });
    }
    if (kod === 4) {
        id = document.getElementById("del-accordion-id").value;
        $.ajax({
            url: "assets/ajax.php",
            type: "POST",
            data: "kod=" + kod + "&id=" + id,
            success: function (data) {
                document.getElementById("accordion-item-" + id).remove();
            }
        });
    }
    if (kod === 5) {
        tarih = document.getElementById("tarih_input").value;
        $.ajax({
            url: "assets/ajax.php",
            type: "POST",
            data: "kod=" + kod + "&tarih=" + tarih,
            success: function (data) {
                if (data == "") {
                    location.reload();
                } else {
                    alert(data);
                }
            }
        });
    }
    if (kod === 6) {
        gider = document.getElementById("gider_b").value;
        aciklama = document.getElementById("aciklama_b").value;
        if (gider != "" && aciklama != "") {
            document.getElementById("aciklama_b").classList.remove("is-invalid");
            document.getElementById("gider_b").classList.remove("is-invalid");
            document.getElementById("err_gelir_b").innerHTML = "";
            $.ajax({
                url: "assets/ajax.php",
                type: "POST",
                data: "kod=" + kod + "&gider=" + gider + "&aciklama=" + aciklama,
                success: function (data) {
                    array_veri = data.split(",");
                    data = array_veri[1]; //gider id'si
                    var x = document.createElement("LI");
                    x.setAttribute("id", "gider_id_" + data);
                    document.getElementById("ul_b").appendChild(x);
                    document.getElementById("gider_id_" + data).innerHTML = aciklama + " = ";
                    var x = document.createElement("SPAN");
                    x.setAttribute("id", "gider_span_" + data);
                    x.classList.add("fw-bold", "text-primary");
                    document.getElementById("gider_id_" + data).appendChild(x);
                    document.getElementById("gider_span_" + data).innerHTML = gider + " ₺ ";
                    var x = document.createElement("I");
                    x.addEventListener('click', function del_gider() {
                        kod = 2;
                        id = data;
                        $.ajax({
                            url: "assets/ajax.php",
                            type: "POST",
                            data: "kod=" + kod + "&id=" + id,
                            success: function (data) {
                                document.getElementById("gider_id_" + id).remove();
                                array_data = data.split(",");
                                cikar = Number(array_data[0]);
                                toplam = Number(document.getElementById("top_b").innerText);
                                snc = toplam - cikar;
                                if (snc == 0) {
                                    kod = 8;
                                    $.ajax({
                                        url: "assets/ajax.php",
                                        type: "POST",
                                        data: "kod=" + kod,
                                        success: function (data) {
                                        }
                                    });
                                }
                                document.getElementById("top_b").innerHTML = snc;
                            }
                        });
                    });
                    x.classList.add("btn", "fi", "fi-rr-trash", "btn-danger", "p-1", "rounded-circle");
                    document.getElementById("gider_span_" + data).appendChild(x);

                    toplam = Number(document.getElementById("top_b").innerText);
                    gider = Number(gider);
                    toplam = toplam + gider;
                    document.getElementById("top_b").innerHTML = toplam;
                    document.getElementById("gider_b").value = "";
                    document.getElementById("aciklama_b").value = "";
                    document.getElementById("gider_b").focus();
                }
            });
        } else {
            if (gider == "") {
                document.getElementById("gider_b").classList.add("is-invalid");
                document.getElementById("aciklama_b").classList.remove("is-invalid");
            } else if (aciklama == "") {
                document.getElementById("gider_b").classList.remove("is-invalid");
                document.getElementById("aciklama_b").classList.add("is-invalid");
            }
            document.getElementById("err_gelir_b").innerHTML = "Lütfen boş yer bırakmayınız!";
        }
    }
    if (kod === 7) {
        $.ajax({
            url: "assets/ajax.php",
            type: "POST",
            data: "kod=" + kod + "&id=" + id,
            success: function (data) {
                document.getElementById("gider_id_" + id).remove();
                array_data = data.split(",");
                cikar = Number(array_data[0]);
                toplam = Number(document.getElementById("top_b").innerText);
                snc = toplam - cikar;
                if (snc == 0) {
                    kod = 8;
                    $.ajax({
                        url: "assets/ajax.php",
                        type: "POST",
                        data: "kod=" + kod,
                        success: function (data) {
                        }
                    });
                }
                document.getElementById("top_b").innerHTML = snc;
            }
        });
    }
}