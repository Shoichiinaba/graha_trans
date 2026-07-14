<?php $this->load->view('template/header'); ?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php $this->load->view('template/sidebar'); ?>
            <div class="layout-page">
                <?php $this->load->view('template/navbar'); ?>
                <div class="content-wrapper">
                    <?php $this->load->view($content); ?>
                    <?php $this->load->view('template/footer'); ?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('template/javascript'); ?>
    <?php $this->load->view($script); ?>
</body>

</html>