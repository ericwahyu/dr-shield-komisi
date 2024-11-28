document.addEventListener("DOMContentLoaded", function() {
    getDateTime();
    getSelamat();
});

$(document).ready(function() {

    $('#preloader').delay(100).slideUp();
    $('.layout-wrapper.layout-content-navbar.d-none').removeClass('d-none');

    $(document).on("keydown keyup", function(e) {
        if (e.keyCode == 27) {
            e.stopImmediatePropagation();
            e.preventDefault();
            return;
        }
    });
});

function onlyNumberKey(evt) {
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}

function numberWithPeriodKey(evt) {
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        if (ASCIICode != 46) return false;
    return true;
}

function numberWithCommaKey(evt) {
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
    if (ASCIICode != 44) return false;
    return true;
}

function convertToRupiah(objek) {
    separator = ".";
    a = objek.value;
    b = a.replace(/[^\d]/g, "");
    c = "";
    panjang = b.length;
    j = 0;
    for (i = panjang; i > 0; i--) {
        j = j + 1;
        if (((j % 3) == 1) && (j != 1)) {
            c = b.substr(i - 1, 1) + separator + c;
        } else {
            c = b.substr(i - 1, 1) + c;
        }
    }
    objek.value = c;
}

function getDateTime() {
    const hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
    const bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    const today = new Date();
    let D = today.getDay();
    let M = today.getMonth();
    let Y = today.getFullYear();
    let d = today.getDate();
    let h = ('0' + today.getHours()).substr(-2);
    let m = today.getMinutes();
    let s = today.getSeconds();
    m = m < 10 ? m = "0" + m : m;
    s = s < 10 ? s = "0" + s : s;
    document.getElementById('dateTime').innerHTML = hari[D] + ", " + d + " " + bulan[M] + " " + Y + " • " + h +
        ":" + m + ":" + s + " WIB";
    setTimeout(getDateTime, 1000);
}

function getSelamat() {

    var selamat = document.getElementById("selamat");

    if (selamat) {
        
        var dt = new Date().getHours();
        if (dt >= 5 && dt <= 9) {
            document.getElementById("selamat").innerHTML =
                "Pagi";
        } else if (dt >= 10 && dt <= 14) {
            document.getElementById("selamat").innerHTML =
                "Siang";
        } else if (dt >= 15 && dt <= 17) {
            document.getElementById("selamat").innerHTML =
                "Sore";
        } else {
            document.getElementById("selamat").innerHTML =
                "Malam";
        }
        setTimeout(getSelamat, 1000);

    }
    
}