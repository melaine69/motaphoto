<?php
// Activer le menu pour pouvoir le modifier sur l'interface wordpress
function mota_register_menus()
{
    register_nav_menus(array(
        'primary' => __('Menu principal', 'motaphoto'),
    ));
}

function mota_enqueue_scripts()
{
    wp_enqueue_style('mota_style', get_template_directory_uri() . '/style.css');

    // Script de la page d'accueil / archives
    wp_enqueue_script(
        'mota_script',
        get_template_directory_uri() . '/js/script.js',
        array('jquery'),
        '1.0.0',
        true
    );
    wp_localize_script('mota_script', 'mota_js', array('ajax_url' => admin_url('admin-ajax.php')));

    // Script de la page single (related)
    if (is_singular('photo')) { // charge uniquement sur single photo
        wp_enqueue_script(
            'mota_related',
            get_template_directory_uri() . '/js/single-related.js',
            array('jquery'),
            '1.0.0',
            true
        );
        wp_localize_script('mota_related', 'mota_js', array('ajax_url' => admin_url('admin-ajax.php')));
    }
}

function mota_request_photos()
{
    $tax_query = [];
    // Filtre catégorie
    if (!empty($_POST['categorie']) && $_POST['categorie'] !== 'all') {
        $tax_query[] = array(
            'taxonomy' => 'category', // la taxonomy Wordpress par défaut
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['categorie']),
        );
    }

    // Filtre format
    if (!empty($_POST['format']) && $_POST['format'] !== 'all') {
        $tax_query[] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => sanitize_text_field($_POST['format']),
        );
    }

    $paged = !empty($_POST['paged']) ? intval($_POST['paged']) : 1; //sert à savoir quelle page charger
    // Grp de photos 1 : Photos de 0 à 7, Grp de photos 2 : 8 à 15 et Grp de photos 3 : 16 à 22.
// Gestion du tri
    $orderby = 'date';
    $order = 'DESC';

    if (!empty($_POST['sort']) && $_POST['sort'] !== 'all') {
        switch ($_POST['sort']) {
            case 'date_asc':
                $orderby = 'date';
                $order = 'ASC';
                break;
            case 'date_desc':
                $orderby = 'date';
                $order = 'DESC';
                break;
            case 'year_asc':
                $orderby = 'meta_value_num';
                $order = 'ASC';
                break;
            case 'year_desc':
                $orderby = 'meta_value_num';
                $order = 'DESC';
                break;
        }
    } else {
        $orderby = 'date';
        $order = 'DESC';
    }


    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
        'orderby' => $orderby,
        'order' => $order,
    );


    if (!empty($tax_query)) {
        if (count($tax_query) > 1)
            $tax_query['relation'] = 'AND';
        $args['tax_query'] = $tax_query;
    }
    $query = new WP_Query($args); // requête personnalisée
    $response = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $response[] = array(
                'link' => get_permalink(),
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'gallery'),// sans 'gallery' = images floues
                'title' => get_the_title(),
                'reference' => get_field('reference', get_the_ID()), //comme ref vient du plugin ACF
                'category' => wp_get_post_terms(get_the_ID(), 'category')[0]->name ?? '',
                'year' => get_field('annee', get_the_ID()),
            );
        }
        wp_reset_postdata();
    } else {
        $response = [];
    }

    wp_send_json(array(
        'photos' => $response,
        'max' => $query->max_num_pages // 22 photos total et seulement 8 de visibles en premier lieu
    ));//encode les données en json, arrête le script puis envoie la rép à JS
}

function get_related_photos()
{
    $category_slug = sanitize_text_field($_POST['category'] ?? '');
    $current_id = intval($_POST['current_id'] ?? 0);

    if (!$category_slug)
        wp_send_json(['photos' => []]);

    $args = [
        'post_type' => 'photo',
        'posts_per_page' => 2,
        'post__not_in' => [$current_id],
        'tax_query' => [
            [
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $category_slug,
            ]
        ]
    ];

    $photos = get_posts($args);
    $response = [];

    foreach ($photos as $photo) {
        $response[] = [
            'id' => $photo->ID,
            'title' => get_the_title($photo->ID),
            'thumbnail' => get_the_post_thumbnail_url($photo->ID, 'gallery'),
            'category' => wp_get_post_terms($photo->ID, 'category')[0]->name ?? '',
            'link' => get_permalink($photo->ID),
            'reference' => get_field('reference', $photo->ID) ?? ''
        ];
    }

    wp_send_json([
        'photos' => $response
    ]);
}


add_action('after_setup_theme', 'mota_register_menus');
add_action('wp_enqueue_scripts', 'mota_enqueue_scripts');
add_action('wp_ajax_request_photos', 'mota_request_photos');
add_action('wp_ajax_nopriv_request_photos', 'mota_request_photos');
add_action('wp_ajax_get_related_photos', 'get_related_photos');
add_action('wp_ajax_nopriv_get_related_photos', 'get_related_photos');


