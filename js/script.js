jQuery(document).ready(function ($) {
    // MENU BURGER 
   $('.btn-menu-burger').on('click', function() {
     if ($('.main-menu').hasClass('reveal-menu-mobile')) {
        $('.main-menu').removeClass('reveal-menu-mobile');
    } else {
         $('.main-menu').addClass('reveal-menu-mobile')
    }
   });

    let page = 1;
    let maxPages = 1;

    // LIGHTBOX 
   /* let photosData = [];
    let currentIndex = 0;*/
    window.photosData = [];
    window.currentIndex = 0;


    // AJAX
    function loadPhotos(reset = false) {
        let categorie = $('#categorie').val();
        let format = $('#format').val();

        if (reset) {
            page = 1;
            photosData = [];
            $('.photo-grid').empty();
            $('#load-more').show();
        }
        $.ajax({
            url: mota_js.ajax_url,
            type: 'POST',
            data: {
                action: 'request_photos',
                categorie: categorie,
                format: format,
                paged: page
            },
            success: function (response) {
                maxPages = response.max;

                if (response.photos.length > 0) {
                    response.photos.forEach(function (photo) {

                        const index = photosData.length;
                        photosData.push(photo);

                        $('.photo-grid').append(`
                            <div class="photo-item" data-index="${index}" data-link="${photo.link}">
                                <img src="${photo.thumbnail}" alt="${photo.title}">
                                <div class="content-eye"> 
                                    <button class="btnEye" aria-label="Aperçu details">
                                    <svg width="46" height="32" viewBox="0 0 46 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M45.9081 15.1504C41.9937 5.94703 33.0015 0 23 0C12.9985 0 4.00649 5.94685 0.0919102 15.1504C-0.0306367 15.4385 -0.0306367 15.7638 0.0919102 16.0518C4.00622 25.2563 12.9983 31.2038 23 31.2038C33.0019 31.2038 41.994 25.2563 45.9081 16.0518C46.0306 15.7638 46.0306 15.4385 45.9081 15.1504ZM23 28.9008C14.088 28.9008 6.05933 23.6968 2.40862 15.6013C6.05942 7.50654 14.0883 2.30314 23 2.30314C31.9119 2.30314 39.9407 7.50654 43.5914 15.6011C39.9407 23.6967 31.912 28.9008 23 28.9008Z" fill="white"/>
                                    <path d="M23 6.78149C18.1364 6.78149 14.1797 10.7383 14.1797 15.6018C14.1797 20.4653 18.1365 24.4221 23 24.4221C27.8635 24.4221 31.8203 20.4654 31.8203 15.6018C31.8203 10.7382 27.8635 6.78149 23 6.78149ZM23 22.1193C19.4064 22.1193 16.4827 19.1956 16.4827 15.602C16.4827 12.0084 19.4064 9.08473 23 9.08473C26.5936 9.08473 29.5173 12.0084 29.5173 15.602C29.5173 19.1956 26.5936 22.1193 23 22.1193Z" fill="white"/>
                                    <path d="M22.9999 10.9192C20.4179 10.9192 18.317 13.0199 18.317 15.6021C18.317 16.238 18.8325 16.7536 19.4685 16.7536C20.1046 16.7536 20.6201 16.238 20.6201 15.6021C20.6201 14.2899 21.6876 13.2222 22.9999 13.2222C23.636 13.2222 24.1515 12.7066 24.1515 12.0707C24.1515 11.4346 23.6359 10.9192 22.9999 10.9192Z" fill="white"/>
                                    </svg>
                                    </button>
                                    <div class="photo-details">
                                        <span class="photo-title">${photo.title}</span>
                                        <span class="photo-cat">${photo.category}</span>
                                    </div>
                                </div> 
                                <div class="content-btn-lightbox">
                                <button class="photo-lightbox" aria-label="Voir lightbox">
                                     <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="17" cy="17" r="17" fill="black"/>
                                        <line x1="15" y1="10.5" x2="10" y2="10.5" stroke="white"/>
                                        <line y1="-0.5" x2="5" y2="-0.5" transform="matrix(-1 8.74227e-08 8.74227e-08 1 15 24)" stroke="white"/>
                                        <line x1="9.5" y1="16" x2="9.5" y2="10" stroke="white"/>
                                        <line y1="-0.5" x2="6" y2="-0.5" transform="matrix(4.37114e-08 1 1 -4.37114e-08 10 18)" stroke="white"/>
                                        <line y1="-0.5" x2="5" y2="-0.5" transform="matrix(1 -8.74227e-08 -8.74227e-08 -1 19 10)" stroke="white"/>
                                        <line y1="-0.5" x2="6" y2="-0.5" transform="matrix(-4.37114e-08 -1 -1 4.37114e-08 24 16)" stroke="white"/>
                                        <line x1="19" y1="23.5" x2="24" y2="23.5" stroke="white"/>
                                        <line x1="24.5" y1="18" x2="24.5" y2="24" stroke="white"/>
                                        </svg>
                                 </button>
                                </div>              
                            </div>
                        `);
                    });
                }

                if (page >= maxPages) {
                    $('#load-more').hide();
                }
            }
        });
    }

    // INITIAL LOAD
    loadPhotos(true);


    // FILTERS
    $('#categorie, #format').on('change', function () {
        loadPhotos(true);
    });

    // LOAD MORE
    $('#load-more').on('click', function () {
        page++;
        loadPhotos();
    });

    // SINGLE PAGE OPEN
    $(document).on('click', '.photo-item', function (e) {
    // Si on clique sur une icône, on ne redirige pas
    if ($(e.target).closest('.btnEye, .photo-lightbox').length) {
        return; // ignore
    }

    const link = $(this).data('link');
    if (link) {
        window.location.href = link; // redirection
    }
    });

    // LIGHTBOX OPEN & CLOSE
    $(document).on('click', '.photo-lightbox', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const index = $(this).closest('.photo-item').data('index');
        currentIndex = index;
        openLightbox(currentIndex);
    });

    function openLightbox(index) {
        const photo = photosData[index];

        $('#lightbox-img').attr('src', photo.thumbnail);
        $('#lightbox-ref').text(photo.reference);
        $('#lightbox-cat').text(photo.category);
        $('#lightbox-single').attr('href', photo.link);

        $('#lightbox').addClass('active');
    }

    function closeLightbox() {
        $('#lightbox').removeClass('active');
    }
    // LIGHTBOX NAVIGATION
    $('.lightbox-next').on('click', function () {
        currentIndex = (currentIndex + 1) % photosData.length;
        openLightbox(currentIndex);
    });

    $('.lightbox-prev').on('click', function () {
        currentIndex = (currentIndex - 1 + photosData.length) % photosData.length;
        openLightbox(currentIndex);
    });

    $('.lightbox-close').on('click', closeLightbox);

    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });

    // MODAL CONTACT 
    const modal = $('#myModal');

    // On cible tous les boutons avec la classe open-modal
    $('.open-modal').on('click', function () {
        modal.css('display', 'flex');
        $(this).css('font-weight', '700');
    });

    // Fermeture du modal
    modal.on('click', function (e) {
        if (e.target === this) {
            modal.css('display', 'none');
        }
    });

});