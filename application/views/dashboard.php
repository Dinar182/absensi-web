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

                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-xxl-6">
                            <div class="row g-gs">
                                <div class="col-lg-3 col-xxl-12">
                                    <div class="card card-bordered bg-info text-light">
                                        <div class="card-inner">
                                            <div class="card-title-group align-start mb-0">
                                                <div class="card-title">
                                                    <h6 class="fs-22px text-light">
                                                        <em class="icon ni ni-users-fill"></em>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="card-amount">
                                                <span class="amount text-light">
                                                    Jumlah <br> Karyawan
                                                </span>
                                            </div>
                                            <div class="invest-data">
                                                <div class="invest-data-amount g-2">
                                                    <div class="invest-data-history">
                                                        <div class="amount text-light fw-bold"><?= $total_karyawan ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-xxl-12">
                                    <div class="card card-bordered bg-danger text-light">
                                        <div class="card-inner">
                                            <div class="card-title-group align-start mb-0">
                                                <div class="card-title">
                                                    <h6 class="fs-22px text-light">
                                                        <em class="icon ni ni-calendar-alt-fill"></em>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="card-amount">
                                                <span class="amount text-light">
                                                    Karyawan <br> Izin
                                                </span>
                                            </div>
                                            <div class="invest-data">
                                                <div class="invest-data-amount g-2">
                                                    <div class="invest-data-history">
                                                        <div class="amount text-light fw-bold"><?= $total_karyawan_ijin ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-xxl-12">
                                    <div class="card card-bordered bg-warning text-light">
                                        <div class="card-inner">
                                            <div class="card-title-group align-start mb-0">
                                                <div class="card-title">
                                                    <h6 class="fs-22px text-light">
                                                        <em class="icon ni ni-clock-fill"></em>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="card-amount">
                                                <span class="amount text-light">
                                                    Karyawan <br> Terlambat
                                                </span>
                                            </div>
                                            <div class="invest-data">
                                                <div class="invest-data-amount g-2">
                                                    <div class="invest-data-history"> 
                                                        <div class="amount text-light fw-bold"><?= $total_karyawan_terlambat ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-xxl-12">
                                    <div class="card card-bordered bg-success text-light">
                                        <div class="card-inner">
                                            <div class="card-title-group align-start mb-0">
                                                <div class="card-title">
                                                    <h6 class="fs-22px text-light">
                                                        <em class="icon ni ni-calendar-check-fill"></em>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="card-amount">
                                                <span class="amount text-light">
                                                    Karyawan <br> Hadir
                                                </span>
                                            </div>
                                            <div class="invest-data">
                                                <div class="invest-data-amount g-2">
                                                    <div class="invest-data-history">
                                                        <div class="amount text-light fw-bold"><?= $total_karyawan_hadir ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .row -->
                        </div><!-- .col -->
                    </div><!-- .row -->
                </div>

                <div class="nk-block nk-block-lg">
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">
                            <div class="nk-block-head-content py-2">
                                <h5 class="modal-title">Baru Saja Absen</h5>
                            </div>
                            <table class="nowrap table" id="__TableLastScanLog">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Nip</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
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