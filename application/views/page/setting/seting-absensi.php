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
                            <form action="#" class="ajax-form" method="post" id="__formSimpanSettingAbsensi" enctype="multipart/form-data">
                                <span class="preview-title-lg overline-title">Data Umum</span>
                                <div class="row gy-4">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Jam Masuk <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-control-wrap">
                                                <input type="time" class="form-control" name="jam_masuk" value="<?= $data['jam_masuk'] ?>" placeholder="Jam Masuk ...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Jam Pulang <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-control-wrap">
                                                <input type="time" class="form-control" name="jam_pulang" value="<?= $data['jam_pulang'] ?>" placeholder="Jam Pulang ...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Radius <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <em class="icon ni ni-rss"></em>
                                                </div>
                                                <input type="number" class="form-control" name="radius" value="<?= $data['radius'] ?>" placeholder="Radius Absensi (Meter)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Koordinat <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <em class="icon ni ni-map-pin"></em>
                                                </div>
                                                <input type="text" class="form-control" name="koordinat" value="<?= $data['latitude'].', '.$data['longtitude'] ?>" placeholder="Koordinat Absensi ...">
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
                        <button id="__SubmitSimpanSetting" class="btn btn-primary">
                            <span>Simpan Setting</span>
                            <em class="icon ni ni-save"></em>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- content @e -->