<?php $this->load->view('template_landing/header'); ?>

<body class="antialiased selection:bg-teal-400 selection:text-black">

    <?php $this->load->view('template_landing/navbar'); ?>
    <?php $this->load->view($content); ?>
    <?php $this->load->view('template_landing/footer'); ?>
    <?php $this->load->view($script); ?>
    <?php $this->load->view('template_landing/javascript'); ?>

</body>

</html>