                <!-- footer @s -->
                <div class="nk-footer">
                    <div class="container-fluid">
                        <div class="nk-footer-wrap">
                            <div class="nk-footer-copyright"> 
                                &copy; 2022 PT. Berkah Jaya Lestarindo
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer @e -->
            </div>
        </div>
    </div>
</body>

<script src="<?= site_url('assets/js/bundle.js?ver=3.1.0') ?>"></script>
<script src="<?= site_url('assets/js/scripts.js?ver=3.1.0') ?>"></script>


<script src="<?= site_url('assets/js/blockui/blockui.min.js') ?>"></script>

<script src="<?= site_url('assets/js/apps/main.js?_=') . rand() ?>"></script>

<?php
    if (isset($bottom_js_plugins)) {
        echo $bottom_js_plugins;
    }
?>

<?php
    if (isset($bottom_js_pages)) {
        echo $bottom_js_pages;
    }
?>
</html>