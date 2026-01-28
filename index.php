<?php get_header(); ?>

<main>
    <!--<section class="hero">
        <div class="hero-content">
            <h1>Photographe event</h1>
        </div>
    </section>

    <div class="photo-grid"></div>-->

    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            the_title('<h3>', '</h3>');
            the_content();
        endwhile;
    else :
        echo '<p>Aucun contenu</p>';
    endif;
    ?>

</main>

<?php get_footer(); ?>
