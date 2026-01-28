<?php get_header(); ?>

<main class="single-content">
	<section class="photo-post">
		<div class="photo-descp">
			<h1>
				<?php
				$title = get_the_title();
				$title = str_replace(' ', '<br/>', $title); // comme titre sur deux lignes
				echo $title;
				?>
			</h1>

			<p>Référence: <span id="photo-reference"><?php echo get_field('reference'); ?></span></p>
			<p>Catégorie : <span
					id="photo-categorie"><?php echo wp_get_post_terms(get_the_ID(), 'category')[0]->name ?? ''; ?></span>
			</p>
			<p>Format : <span id="photo-format"><?php echo strip_tags(get_the_term_list($post->ID, 'format')); ?></span>
			</p>
			<p>Année : <span id="photo-year"><?php echo get_field('annee') ?></span></p>
		</div>
		<div class="photo-container">
			<img src="<?php the_post_thumbnail_url() ?>" alt="photo du post" />
		</div>
	</section>

	<section class="second-block">
		<div class="block-contact">
			<p>Cette photo vous intéresse ?</p>
			<button id="contact-single" class="open-modal">Contact</button>
			<?php include get_template_directory() . '/template-parts/contact-modal.php'; //Inclure le fichier externe de modal de contact ?>
		</div>

<div class="block-nav-photo">
    <?php
    $current_id = get_the_ID();
    $category_slug = wp_get_post_terms($current_id, 'category')[0]->slug ?? '';

    // Récupérer toutes les photos de la même catégorie triées par année
    $categoryPosts = get_posts([
        'post_type' => 'photo',
        'posts_per_page' => -1,
        'tax_query' => [ //filtre la même cat que la photo actuelle
            [
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $category_slug
            ]
        ],
        'meta_key' => 'annee',
        'orderby' => [
            'meta_value_num' => 'ASC', // par année croissante
            'ID' => 'ASC'
        ]
    ]);

    // Trouver l'index de la photo actuelle
    $current_index = null;
    foreach ($categoryPosts as $i => $post) {
        if ($post->ID == $current_id) {
            $current_index = $i;
            break;
        }
    }

    // Photo précédente = index -1, photo suivante = index +1
    $prev_index = ($current_index - 1 + count($categoryPosts)) % count($categoryPosts);
    $next_index = ($current_index + 1) % count($categoryPosts);

    $prev = $categoryPosts[$prev_index];
    $next = $categoryPosts[$next_index];

    $prevThumb = get_the_post_thumbnail_url($prev->ID, 'medium');
    $nextThumb = get_the_post_thumbnail_url($next->ID, 'medium');
    ?>

  <div class="photos-nav">
        <!-- Bouton précédent -->
        <a class="nav-photo nav-prev" href="<?php echo get_permalink($prev); ?>">
        <?php if ($prevThumb): ?>
                <img src="<?php echo $prevThumb; ?>" alt="photo précédente" class="current-photo">
            <?php endif; ?>
            <span class="arrow">&#8592;</span>
        </a>

        <!-- Bouton suivant -->
        <a class="nav-photo nav-next" href="<?php echo get_permalink($next); ?>">
        <?php if ($nextThumb): ?>
                <img src="<?php echo $nextThumb; ?>" alt="photo suivante" class="current-photo">
            <?php endif; ?>
            <span class="arrow">&#8594;</span>
        </a>
    </div>
</div>
	</section>
	<!-- div pr stocker la catégorie pour l'AJAX -->
<div class="block-reco">
			<p>VOUS AIMEREZ AUSSI</p>
<div id="single-photo" 
     data-category="<?php echo esc_attr(wp_get_post_terms(get_the_ID(), 'category')[0]->slug ?? ''); ?>"
     data-current-id="<?php echo get_the_ID(); ?>">
    <div class="photo-grid-single"></div>
</div>

</div>
</main>

<?php get_footer(); ?>