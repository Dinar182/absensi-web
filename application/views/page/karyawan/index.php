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

                        <a href="<?= site_url('karyawan/form_karyawan') ?>" class="btn btn-primary d-md-inline-flex">
                            <em class="icon ni ni-plus"></em>
                            <span>Tambah Karyawan</span>
                        </a>
                    </div>
                </div>

                <div class="nk-block nk-block-lg">
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">
                            <table class="nowrap table" id="__TableKaraywan">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Kode Pegawai</th>
                                        <th>Pas Foto</th>
                                        <th>Username</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Jabatan</th>
                                        <th>Divisi</th>
                                        <th>##</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div><!-- .card-preview -->
                </div>

            </div>
        </div>
    </div>
</div>
<!-- content @e -->