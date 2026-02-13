<?php get_header(); ?>
<main>
    <div class="bloc-page page">
        <h1><?= the_title(); ?></h1>
        <div class="page__contenu">
            <?= the_content(); ?>
        </div>
    </div>
</main>


<?php get_footer(); ?>