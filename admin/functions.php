<?php
require '../koneksi.php';

// tambah Kamar
function tambahKamar($data) {
    global $koneksi;
    
    //ambil semua data dari form
    $nama_kamar = $data['nama_kamar'];
    $gambar = upload();
    if( !$gambar ){
        return false;
    }

    $insert = "INSERT INTO kamar 
                VALUES
                ('', '$nama_kamar','$gambar')";

    mysqli_query($koneksi, $insert);

    return mysqli_affected_rows($koneksi);
}

// edit kamar
function editKamar($data) {
    global $koneksi;
    
    // ambi semua data dari form
    $id_kamar = $data['id_kamar'];
    $nama_kamar = $data['nama_kamar'];
    $gambarLama = $data['gambarLama'];

    if( $_FILES['gambar']['error'] === 4 ){
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
        if ( !$gambar ) {
            return false;
        }
    }

    //query edit
    $edit = "UPDATE kamar 
            SET
            nama_kamar = '$nama_kamar',
            gambar = '$gambar'
            WHERE id_kamar = '$id_kamar'";

    mysqli_query($koneksi, $edit);

    return mysqli_affected_rows($koneksi);
}

// hapus kamar
function hapusKamar($id) {
    global $koneksi;

    mysqli_query($koneksi, "DELETE FROM kamar WHERE id_kamar = '$id'");

    return mysqli_affected_rows($koneksi);
}

// tambah fasilitas
function tambahFasilitas($data) {
    global $koneksi;

    //ambil semua data dari form
    $id_kamar = $data['id_kamar'];
    $fasilitas = $data['fasilitas'];

    $query = "INSERT INTO fasilitas
                VALUES
                ('','$id_kamar','$fasilitas')";
    mysqli_query($koneksi, $query);

    return(mysqli_affected_rows($koneksi));
}

// hapus fasilitas
function hapusFasilitas($id) {
    global $koneksi;

    // ambil data
    mysqli_query($koneksi, "DELETE FROM fasilitas WHERE id_fasilitas = '$id'");

    return mysqli_affected_rows($koneksi);
}

// edit fasilitas
function editFasilitas($data) {
    global $koneksi;

    //ambil data
    $id_fasilitas = $data['id_fasilitas'];
    $id_kamar = $data['id_kamar'];
    $nama_fasilitas = $data['fasilitas'];

    $edit = "UPDATE fasilitas SET
            id_kamar = '$id_kamar',
            nama_fasilitas = '$nama_fasilitas'
            WHERE id_fasilitas = '$id_fasilitas'";

    mysqli_query($koneksi, $edit);

    return mysqli_affected_rows($koneksi);
}


function upload() {
    
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpname = $_FILES['gambar']['tmp_name'];

    //cek apakah gambar diupload atau tidak
    if ( $error === 4 ) {
        echo "<script>
        alert('Anda belum memasukkan gambar, silahkan masukkan gambar');
        </script>";
        return false;
    }

    // cek apakah tipe gambar sesuai
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode(".",$namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if( !in_array($ekstensiGambar, $ekstensiGambarValid) ){
        echo "<script>
        alert('Tipe gambar tidak sesuai');
        </script>";
        return false;
    }

    // cek apakah ukuran gambar tidak terlalu besar
    if( $ukuranFile > 10000000 ){
        echo "<script>
        alert('Ukuran gambar terlalu besar');
        </script>";
        return false;
    }

    // memberi nama baru pada gambar
    $namaGambarBaru = uniqid();
    $namaGambarBaru .= ".";
    $namaGambarBaru .= $ekstensiGambar;

    // lolos pengecekan gambar siap diupload
    move_uploaded_file($tmpname, 'gambar/'.$namaGambarBaru);

    return $namaGambarBaru;
}

// function kurangJumlahKamar($data) {
//     $jumlahKamar = mysqli_query($koneksi, "SELECT jumlah_kamar FROM kamar WHERE id_kamar = '$id_kamar'");


//     $query = "UPDATE kamar
//                 SET jumlah_kamar = '$jumlahKamar'
//                 WHERE id_kamar = '$id_kamar'";

//     mysqli_query($koneksi, $query);

//     return
// }
?>