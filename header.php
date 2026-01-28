<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header id="header" class="header">
        <div class="container-header">
            <!-- Logo du site avec un lien vers la page d'accueil -->
            <a id="logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Page d'accueil de Nathalie Mota">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/logo.png" alt="Logo <?php echo esc_attr(get_bloginfo('name')); ?>">
            </a>

            <!-- Bouton du menu burger -->
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" title="Menu">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </button>

            <!-- Navigation principale -->
            <nav id="navigation" class="main-menu">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary', // Localisation du menu
                        'menu_class'     => 'menu-principal', // Classe CSS pour le menu
                    )
                );
                ?>
                <button class="open-modal">CONTACT</button>
                <?php include get_template_directory() . '/template-parts/contact-modal.php'; //Inclure le fichier externe de modal de contact ?>
            </nav>
        </div>
    </header>
     
    </body>
    </html>
