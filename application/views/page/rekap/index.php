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
                            <div class="row pb-3">
                                <div class="col-md-5 offset-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Dari - Sampai</label>
                                        <div class="form-control-wrap">
                                            <!-- <select class="form-select js-select2" id="__Bulan">
                                                <option value="0" disabled>- Pilih Bulan -</option>
                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <option value="<?php # date('m', strtotime('2019-' . $i . '-01')) ?>" <?php # (date('n') == $i) ? 'selected' : '' ?>>
                                                    <?php # strftime('%B', strtotime('2019-' . $i . '-01')) ?>
                                                </option>
                                                <?php endfor ?>
                                            </select> -->
                                            <div class="input-daterange date-picker-range input-group">
                                                <input type="text" class="form-control" id="__tanggalStart"  value="<?php echo date('Y-m-01'); ?>" />
                                                <div class="input-group-addon">TO</div>
                                                <input type="text" class="form-control" id="__tanggalEnd" value="<?php echo date('Y-m-d'); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label class="form-label">&nbsp;</label>
                                        <div class="form-control-wrap">
                                            <a href="javascript:;" class="btn btn-primary btn-block" id="__btnFilter">
                                                <em class="icon ni ni-filter"></em>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="nowrap table" id="__TableRekapAbsensi">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Masuk</th>
                                        <th>Terlambat</th>
                                        <th>Hari Kerja</th>
                                        <th>Ijin</th>
                                        <th>Cuti</th>
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