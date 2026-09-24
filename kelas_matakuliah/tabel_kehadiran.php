<?php
require_once '../database/koneksi.php';

?>

                <?php
                  $id_pertemuan = @$_GET['id_pertemuan'];
                  $panggil_data_pertemuan = mysqli_query($con, "SELECT * FROM tbl_pertemuan WHERE id='$id_pertemuan'")or die(mysqli_error($con));
                  $data_pertemuan = mysqli_fetch_array($panggil_data_pertemuan);

                  $kode_kls = $data_pertemuan['kode_kelas'];
                  $tanggal_pertemuan = $data_pertemuan['tanggal'];
                  $judul_pertemuan = $data_pertemuan['judul_pertemuan'];
                  $pertemuan_ke = $data_pertemuan['pertemuan_ke'];
                  $status_pertemuan = $data_pertemuan['status'];

                  $panggil_data_kelas = mysqli_query($con, "SELECT * FROM tbl_kelas_matkul WHERE kode_kelas = '$kode_kls'")or die(mysqli_error($con));
                  $data_kelas = mysqli_fetch_array($panggil_data_kelas);

                  $nik = $data_kelas['nik'];
                  $panggila_data_dosen = mysqli_query($con, "SELECT nama,img,kelamin FROM tbl_dosen WHERE nik='$nik'")or die(mysqli_error($con));
                  $data_dosen = mysqli_fetch_array($panggila_data_dosen);
                  $foto = $data_dosen['img'];
                  $jk = $data_dosen['kelamin'];

                  $kode_matkul = $data_kelas['kode_matkul'];
                  $panggil_data_matkul = mysqli_query($con, "SELECT nama_matkul FROM tbl_matkul WHERE kode_matkul='$kode_matkul'")or die(mysqli_error($con));
                  $data_matkul = mysqli_fetch_array($panggil_data_matkul);

                  $kode_jurusan = $data_kelas['kode_jurusan'];
                  $panggil_data_jurusan = mysqli_query($con, "SELECT nama_jurusan FROM tbl_jurusan WHERE kode_jurusan='$kode_jurusan'")or die(mysqli_error($con));
                  $data_jurusan = mysqli_fetch_array($panggil_data_jurusan);
                ?>

<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>Mahasiswa</th>
            <th>Status</th>
            <th>Aksi</th>
         </tr>
    </thead>
        <tbody>
            <?php

                $panggil_data_presensi = mysqli_query($con, "SELECT * FROM tbl_presensi WHERE id_pertemuan = '$id_pertemuan'") or die(mysqli_error($con));
                $no = 1;
                
                $rv = mysqli_num_rows($panggil_data_presensi); //tampung nilai kembali
                    if ($rv > 0) {
                      while ($data = mysqli_fetch_array($panggil_data_presensi)) {
                        $id_presensi = $data['id'];
                        $nim = $data['nim'];
                        $status_kehadiran = $data['status_kehadiran'];
                        ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td>
                            <?php 
                            $query_mahasiswa = mysqli_query($con, "SELECT * FROM tbl_mahasiswa WHERE nim = '$nim'")or die(mysqli_error($con));
                            $data_mahasiswa = mysqli_fetch_array($query_mahasiswa);
                            
                            if ($data_mahasiswa) {
                                echo $data_mahasiswa['nim'] . '-' . $data_mahasiswa['nama'];
                            } 
                            ?>
                          </td>
                          <td>
                          <?php 
                          $warna = 'danger';
                          if ($status_kehadiran == 'hadir') {
                            $warna = 'success';
                          } elseif ($status_kehadiran == 'izin') {
                            $warna = 'warning';
                          } elseif ($status_kehadiran == 'sakit') {
                            $warna = 'primary';
                          } else{
                            $warna = 'danger';
                          }
                          ?>  
                          <span class="badge badge-<?= $warna ?>"><?= $status_kehadiran; ?></span>
                          </td>

                          <td>
                            <button type="button" class="btn btn-primary btn-xs" 
                            data-toggle="modal" data-target="#modal-edit"
                            data-presensi="<?= $id_presensi; ?>"
                            data-id="<?= $id_pertemuan; ?>"
                            ><i class="fas fa-edit"></i>
                          </button>
                          </td>

                        </tr>
                        <?php  
                      }
                    } 

        ?>
    </tbody>
                  
</table>