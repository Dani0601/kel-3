<?php
function tambah_notifikasi($conn, $judul, $pesan, $target_role = null){

    // 1. simpan ke tabel notifikasi
    $stmt = $conn->prepare("
        INSERT INTO notifikasi (judul, pesan, created_at, status) 
        VALUES (?, ?, NOW(), 'aktif')
    ");
    $stmt->bind_param("ss", $judul, $pesan);
    $stmt->execute();

    $id_notif = $stmt->insert_id;

    // 2. ambil user sesuai target
    if($target_role){
        $users = $conn->query("
            SELECT id_user 
            FROM users 
            WHERE role = '$target_role'
        ");
    } else {
        $users = $conn->query("
            SELECT id_user 
            FROM users 
            WHERE role IN ('dosen','mahasiswa')
        ");
    }

    // 3. masukkan ke tabel notifikasi_user
    while($u = $users->fetch_assoc()){
        $id_user = $u['id_user'];

        $conn->query("
            INSERT INTO notifikasi_user (id_notifikasi, id_user, status_dibaca)
            VALUES ('$id_notif', '$id_user', 0)
        ");
    }
}
?>