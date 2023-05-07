<!-- content @s -->
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title"><?= $page_title ?></h3>
                        </div>
                    </div>
                </div>

                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <div class="preview-block">
                            <form action="#" class="ajax-form" method="post" id="__formSubmitKaryawan" enctype="multipart/form-data">
                                <input type="hidden" name="nip_karyawan" value="<?= isset($karyawan['nip']) ? $karyawan['nip'] : '' ?>">
                                <span class="preview-title-lg overline-title">Data Umum</span>
                                <div class="row gy-4">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Nama <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <em class="icon ni ni-user-alt-fill"></em>
                                                </div>
                                                <input type="text" class="form-control" name="nama_lengkap" value="<?= isset($karyawan['nama']) ? $karyawan['nama'] : '' ?>" placeholder="Nama Lengkap ...">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                Tanggal Lahir <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <em class="icon ni ni-calender-date-fill"></em>
                                                </div>
                                                <input type="text" class="form-control date-picker" name="tanggal_lahir" value="<?= isset($karyawan['tgl_lahir']) ? $karyawan['tgl_lahir'] : '' ?>" placeholder="Tanggal Lahir ...">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                No Telp <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <em class="icon ni ni-mobile"></em>
                                                </div>
                                                <input type="text" class="form-control" name="phone" value="<?= isset($karyawan['no_telp']) ? $karyawan['no_telp'] : '' ?>" placeholder="Nomor Telpon ...">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                Agama <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-wrap">
                                                    <select class="form-select" data-search="on" id="__Agamakaryawan" name="agama">
                                                        <?php if (!empty($karyawan['id_agama'])): ?>
                                                            <option value="<?= $karyawan['id_agama'] ?>">
                                                                <?= $karyawan['agama'] ?>
                                                            </option>
                                                        <?php endif ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                NIK <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <em class="icon ni ni-hash"></em>
                                                </div>
                                                <input type="text" class="form-control" name="nik" value="<?= isset($karyawan['nik']) ? $karyawan['nik'] : '' ?>" placeholder="Nomor Induk Kependudukan ...">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                Jenis Kelamin <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-control-wrap">
                                                <div class="row p-1">
                                                    <div class="col-md-3">
                                                        <div class="g">
                                                            <div class="custom-control custom-control-sm custom-radio checked">
                                                                <input type="radio" class="custom-control-input" name="jenis_kelamin" id="__JkPerempuan" <?= isset($karyawan['jenis_kelamin']) ? (($karyawan['jenis_kelamin'] == 'Perempuan') ? 'checked' : '') : '' ?> value="Perempuan">
                                                                <label class="custom-control-label" for="__JkPerempuan">Perempuan</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="custom-control custom-control-sm custom-radio checked">
                                                            <input type="radio" class="custom-control-input" name="jenis_kelamin" id="__JkLakilaki" <?= isset($karyawan['jenis_kelamin']) ? (($karyawan['jenis_kelamin'] == 'Laki - Laki') ? 'checked' : '') : '' ?> value="Laki - Laki">
                                                            <label class="custom-control-label" for="__JkLakilaki">Laki - Laki</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                Status Kawin <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-control-wrap">
                                                <div class="row p-1">
                                                    <div class="col-md-3">
                                                        <div class="custom-control custom-control-sm custom-radio checked">
                                                            <input type="radio" class="custom-control-input" name="status_kawin" <?= isset($karyawan['status_kawin']) ? (($karyawan['status_kawin'] == 'Kawin') ? 'checked' : '') : '' ?> id="__SkKawin" value="Kawin">
                                                            <label class="custom-control-label" for="__SkKawin">Kawin</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="custom-control custom-control-sm custom-radio checked">
                                                            <input type="radio" class="custom-control-input" name="status_kawin" <?= isset($karyawan['status_kawin']) ? (($karyawan['status_kawin'] == 'Belum Kawin') ? 'checked' : '') : '' ?> id="__SkBelumKawin" value="Belum Kawin">
                                                            <label class="custom-control-label" for="__SkBelumKawin">Belum Kawin</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                Alamat <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control no-resize" name="alamat_lengkap" placeholder="Alamat Lengkap ..."><?= isset($karyawan['alamat']) ? $karyawan['alamat'] : '' ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="preview-hr">

                                <span class="preview-title-lg overline-title">Data Karyawan</span>
                                <div class="row gy-4">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Email <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <em class="icon ni ni-mail-fill"></em>
                                                </div>
                                                <input type="text" class="form-control" name="email" value="<?= isset($karyawan['email']) ? $karyawan['email'] : '' ?>" placeholder="Email Karyawan ...">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                Username <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <em class="icon ni ni-user-circle-fill"></em>
                                                </div>
                                                <input type="text" class="form-control" name="username" value="<?= isset($karyawan['username']) ? $karyawan['username'] : '' ?>" placeholder="Username Karyawan ...">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Lokasi Kerja</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-wrap">
                                                    <select class="form-select" data-search="on" id="__LokasiKerja" name="lokasi_kerja">
                                                        <?php if (!empty($karyawan['id_lokasi_kerja'])): ?>
                                                            <option value="<?= $karyawan['id_lokasi_kerja'] ?>">
                                                                <?= $karyawan['lokasi_kerja'] ?>
                                                            </option>
                                                        <?php endif ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                Pass Foto
                                            </label>
                                            <div class="form-control-wrap">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Upload</span>
                                                    </div>
                                                    <div class="form-file">
                                                        <input type="file" class="form-file-input" name="pass_foto" id="__PassFotoKaryawan">
                                                        <label class="form-file-label" for="__PassFotoKaryawan"><?= isset($karyawan['profile']) ? $karyawan['profile'] : 'Browes File' ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Divisi</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-wrap">
                                                    <select class="form-select" data-search="on" id="__Divisikaryawan" name="divisi">
                                                        <?php if (!empty($karyawan['id_divisi'])): ?>
                                                            <option value="<?= $karyawan['id_divisi'] ?>">
                                                                <?= $karyawan['divisi'] ?>
                                                            </option>
                                                        <?php endif ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Jabatan</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-wrap">
                                                    <select class="form-select" data-search="on" id="__Jabatankaryawan" name="jabatan">
                                                        <?php if (!empty($karyawan['id_jabatan'])): ?>
                                                            <option value="<?= $karyawan['id_jabatan'] ?>">
                                                                <?= $karyawan['jabatan'] ?>
                                                            </option>
                                                        <?php endif ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                Posisi Karyawan <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-control-wrap">
                                                <div class="row p-1">
                                                    <div class="col-md-3">
                                                        <div class="g">
                                                            <div class="custom-control custom-control-sm custom-radio checked">
                                                                <input type="radio" class="custom-control-input" name="is_admin" id="__PosisiKaryawan" <?= isset($karyawan['is_admin']) ? (($karyawan['is_admin'] == '0') ? 'checked' : '') : 'checked' ?> value="0">
                                                                <label class="custom-control-label" for="__PosisiKaryawan">Karyawan</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="custom-control custom-control-sm custom-radio checked">
                                                            <input type="radio" class="custom-control-input" name="is_admin" id="__PosisiAdmin" <?= isset($karyawan['is_admin']) ? (($karyawan['is_admin'] == '1') ? 'checked' : '') : '' ?> value="1">
                                                            <label class="custom-control-label" for="__PosisiAdmin">Admin</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row py-3">
                    <div class="col-md-6 offset-md-6 text-end">
                        <a href="<?= site_url('karayawan') ?>" class="btn btn-light">
                            <span>Kembali</span>
                            <em class="icon ni ni-back-alt"></em>
                        </a>
                        <button id="__SubmitKaryawan" class="btn btn-primary">
                            <span>Simpan Karyawan</span>
                            <em class="icon ni ni-save"></em>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- content @e -->