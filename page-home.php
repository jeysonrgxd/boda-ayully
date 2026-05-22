<?php

$URL_MEDIA = wp_upload_dir()['baseurl'];

get_header(); ?>


<link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/home.css">


<section class="ayllu__portada">
   <!-- <div class="ayllu__portada-contenedor contenedor">

   </div> -->
<?php echo do_shortcode('[metaslider id="10"]'); ?>


</section>

<?php get_footer(); ?>