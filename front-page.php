<?php get_header(); ?>
<main id="main" class="main">
    <section class="hero">
        <div class="banner">
            <div class="banner-content">
                <div class="banner-img">
                    <h1 class="hero-title">
                        PHOTOGRAPHE EVENT
                    </h1>
                </div>
            </div>
        </div>
    </section>
    <div class="grid">

        <!-- Récupérer les filtres dynamiquement (plugins)-->
        <section class="filters">

            <form id="categories" method="POST">
                <select id="categorie" name="categorie">
                    <option value="" disabled selected>Catégories</option>
                    <option value="all">Toutes</option>
                    <?php
                    if (
                        $terms = get_terms(array(
                            'taxonomy' => 'category',
                        ))
                    ) {
                        foreach ($terms as $term) {
                            echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
                        }
                    }
                    ?>
                </select>
            </form>

            <form id="formats" method="POST">
                <select id="format" name="format">
                    <option value="" disabled selected>Formats</option>
                    <option value="all">Tous</option>
                    <?php
                    if (
                        $terms = get_terms(array(
                            'taxonomy' => 'format',
                        ))
                    ) {
                        foreach ($terms as $term) {
                            echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
                        }
                    }
                    ?>
                </select>
            </form>

        </section>
        <section class="photo-grid">

        </section>
       
        <div class="container-load-more">
            <button id="load-more"> Charger plus</button>
        </div>
        
    </div>
</main>
 
<?php get_footer();?>
 <?php get_template_part('lightbox'); ?>
