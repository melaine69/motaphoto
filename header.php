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
           <button class="btn-menu-burger" aria-controls="primary-menu" aria-expanded="false" title="Menu">
                     <svg class="burger-icon" width="28" height="19" viewBox="0 0 28 19">
<path d="M0.856708 1.71342H26.5586C27.0315 1.71342 27.4153 1.32957 27.4153 0.856708C27.4153 0.383774 27.0314 0 26.5586 0H0.856708C0.383845 0 0 0.383774 0 0.856708C0 1.32964 0.383845 1.71342 0.856708 1.71342Z" fill="black"/>
<path d="M26.5586 8.56738H0.856708C0.383774 8.56738 0 8.95123 0 9.42409C0 9.89695 0.383845 10.2808 0.856708 10.2808H26.5586C27.0315 10.2808 27.4153 9.89695 27.4153 9.42409C27.4153 8.95123 27.0315 8.56738 26.5586 8.56738Z" fill="black"/>
<path d="M26.5586 17.1345H0.856708C0.383774 17.1345 0 17.5184 0 17.9912C0 18.4642 0.383845 18.8479 0.856708 18.8479H26.5586C27.0315 18.8479 27.4153 18.4641 27.4153 17.9912C27.4154 17.5183 27.0315 17.1345 26.5586 17.1345Z" fill="black"/>
</svg>

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
