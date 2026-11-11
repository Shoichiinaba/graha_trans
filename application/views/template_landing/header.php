<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <?php
        $site_name  = 'Graha Transport';
        $logo       = base_url('assets/img/logo/logo.png'); // Sesuaikan dengan lokasi logo
        $canonical  = isset($canonical_url) ? $canonical_url : current_url();
        $metaImage  = isset($meta_image) ? $meta_image : $logo;
    ?>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-18178321034"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'AW-18178321034');
    </script>

    <meta name="google-site-verification" content="gpI2QUiYDIM2rOnu6QQEINZTcMNSpTjbh-fsFCbincg" />

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta property="og:site_name" content="Graha Transport">
    <meta property="og:locale" content="id_ID">
    <meta name="twitter:url" content="<?= $canonical_url ?>">
    <meta name="color-scheme" content="dark light">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <meta name="application-name" content="Graha Transport">
    <meta name="theme-color" content="#0f172a">

    <!-- PRIMARY SEO DINAMIS -->
    <title><?= isset($title) ? $title . ' | Graha Transport' : 'Rental Mobil Ungaran Semarang | Graha Transport'; ?>
    </title>
    <link rel="alternate" type="application/rss+xml" title="Graha Transport RSS" href="<?= base_url('rss.xml'); ?>">

    <meta name="description"
        content="<?= isset($meta_desc) ? $meta_desc : 'Graha Transport menyediakan layanan rental mobil Ungaran dan Semarang dengan armada modern, driver profesional, harga terjangkau.'; ?>">

    <meta name="keywords"
        content="<?= isset($meta_keywords) ? $meta_keywords : 'rental mobil ungaran, sewa mobil ungaran, rental mobil semarang, sewa mobil semarang murah'; ?>">

    <meta name="author" content="Graha Transport">
    <meta name="robots" content="max-image-preview:large,index,follow">

    <!-- CANONICAL DINAMIS -->
    <link rel="canonical" href="<?= isset($canonical_url) ? $canonical_url : base_url(); ?>">

    <!-- GEO SEO -->
    <meta name="geo.region" content="ID-JT">
    <meta name="geo.placename" content="Ungaran, Semarang, Jawa Tengah">
    <meta name="geo.position" content="-7.1396;110.4050">
    <meta name="ICBM" content="-7.1396, 110.4050">

    <!-- FAVICON -->
    <link rel="shortcut icon" href="<?= base_url('assets'); ?>/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets'); ?>/img/favicon/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets'); ?>/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="48x48" href="<?= base_url('assets'); ?>/img/favicon/favicon-48x48.png">

    <!-- PWA / MANIFEST -->
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#0f172a">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Graha Transport">

    <!-- OPEN GRAPH / FACEBOOK DINAMIS -->

    <meta property="og:type" content="<?= isset($berita) ? 'article' : 'website'; ?>">
    <meta property="og:site_name" content="<?= $site_name; ?>">
    <meta property="og:locale" content="id_ID">
    <meta property="og:title"
        content="<?= isset($title) ? $title.' | '.$site_name : 'Rental Mobil Ungaran Semarang | '.$site_name; ?>">
    <meta property="og:description"
        content="<?= isset($meta_desc) ? $meta_desc : 'Jasa rental mobil terpercaya di Ungaran dan Semarang.'; ?>">
    <meta property="og:url" content="<?= $canonical; ?>">
    <meta property="og:image" content="<?= $metaImage; ?>">
    <meta property="og:image:secure_url" content="<?= $metaImage; ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type"
        content="<?= strtolower(pathinfo($metaImage, PATHINFO_EXTENSION)) == 'webp' ? 'image/webp' : 'image/jpeg'; ?>">
    <meta property="og:image" content="<?= isset($meta_image) ? $meta_image : base_url('logo.png'); ?>">

    <!-- TWITTER DINAMIS -->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@grahatransport">
    <meta name="twitter:title"
        content="<?= isset($title) ? $title.' | '.$site_name : 'Rental Mobil Ungaran Semarang | '.$site_name; ?>">
    <meta name="twitter:description"
        content="<?= isset($meta_desc) ? $meta_desc : 'Rental mobil profesional area Ungaran dan Semarang dengan armada terbaik dan harga terjangkau.'; ?>">
    <meta name="twitter:image" content="<?= $metaImage; ?>">
    <meta name="twitter:url" content="<?= $canonical; ?>">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/style.css" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- LOCAL BUSINESS SCHEMA -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "Graha Transport",
        "image": "<?= isset($meta_image) ? $meta_image : base_url('logo.png'); ?>",
        "url": "<?= base_url(); ?>",
        "telephone": "+6281327160516",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Ungaran",
            "addressRegion": "Jawa Tengah",
            "addressCountry": "ID"
        },
        "areaServed": [
            "Ungaran",
            "Semarang",
            "Ambarawa",
            "Bandungan",
            "Salatiga"
        ],
        "priceRange": "250000",
        "description": "<?= isset($meta_desc) ? $meta_desc : 'Jasa rental mobil terpercaya di Ungaran dan Semarang dengan armada lengkap dan pelayanan profesional.'; ?>"
    }
    </script>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Graha Transport",
        "url": "<?= base_url(); ?>",
        "logo": "<?= $logo; ?>",
        "image": "<?= $logo; ?>",
        "sameAs": [
            "https://www.instagram.com/USERNAME_INSTAGRAM",
            "https://www.facebook.com/USERNAME_FACEBOOK"
        ]
    }
    </script>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "url": "<?= base_url(); ?>",
        "name": "Graha Transport",
        "alternateName": "Graha Transport Rental Mobil Ungaran",
        "publisher": {
            "@type": "Organization",
            "name": "Graha Transport",
            "logo": {
                "@type": "ImageObject",
                "url": "<?= $logo; ?>"
            }
        }
    }
    </script>

    <?php if(isset($berita)): ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "NewsArticle",
        "headline": "<?= htmlspecialchars($title, ENT_QUOTES); ?>",
        "image": [
            "<?= $metaImage; ?>"
        ],
        "datePublished": "<?= date('c', strtotime($berita->tgl_berita)); ?>",
        "dateModified": "<?= date('c', strtotime($berita->tgl_berita)); ?>",
        "author": {
            "@type": "Organization",
            "name": "Graha Transport"
        },
        "publisher": {
            "@type": "Organization",
            "name": "Graha Transport",
            "logo": {
                "@type": "ImageObject",
                "url": "<?= $logo; ?>"
            }
        },
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "<?= $canonical; ?>"
        },
        "description": "<?= htmlspecialchars($meta_desc, ENT_QUOTES); ?>"
    }
    </script>
    <?php endif; ?>
</head>