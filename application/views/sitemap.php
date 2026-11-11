<?php
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <!-- Homepage -->
    <url>

        <loc><?= base_url(); ?></loc>

        <lastmod><?= date('Y-m-d'); ?></lastmod>

        <changefreq>daily</changefreq>

        <priority>1.0</priority>

    </url>

    <?php foreach($berita as $row){ ?>

    <url>

        <loc><?= base_url('Artikel/'.url_title($row->judul_berita,'-',TRUE)); ?></loc>

        <lastmod><?= date('Y-m-d',strtotime($row->tgl_berita)); ?></lastmod>

        <changefreq>weekly</changefreq>

        <priority>0.9</priority>

    </url>

    <?php } ?>

</urlset>