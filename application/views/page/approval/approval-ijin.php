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

                <div class="nk-block nk-block-lg">
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">
                            <table class="nowrap table" id="__TableIjinKaraywan">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Jenis Ijin</th>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
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

<div class="modal fade" tabindex="-1" id="__ModalApproveIjin">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-light">Approval Ijin</h5>
                <a href="#" class="close text-light" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="row p-2">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label mb-0">Nama</label>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <span>:</span> <span class="text-dark" id="__NamaKaryawan"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label mb-0">Jenis Ijin</label>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <span>:</span> <span class="text-dark" id="__JenisIjin"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label mb-0">Tanggal</label>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <span>:</span> <span class="text-dark" id="__TanggalIjin"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label mb-0">Katerangan</label>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <span>:</span> <span class="text-dark" id="__KeteranganIjin"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <a href="javascript:;" class="btn btn-danger d-md-inline-flex btn-approval-ijin" 
                    onclick="approval_ijin_karyawan(this)" status-approve="2">
                    <em class="icon ni ni-check-circle-cut"></em>
                    <span>Setujui</span>
                </a>
                <a href="javascript:;" class="btn btn-info d-md-inline-flex btn-approval-ijin" 
                    onclick="approval_ijin_karyawan(this)" status-approve="3">
                    <em class="icon ni ni-cross-circle"></em>
                    <span>Tolak</span>
                </a>
                <a href="javascript:;" class="btn btn-light d-md-inline-flex" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-na"></em>
                    <span>Tutup</span>
                </a>
            </div>
        </div>
    </div>
</div>