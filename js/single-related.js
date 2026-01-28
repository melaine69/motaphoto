jQuery(document).ready(function($){
    const singleContainer = $('#single-photo');
    if (singleContainer.length) {
        const category = singleContainer.data('category');
        const current_id = singleContainer.data('current-id') || $('#post-id').val();

        $.ajax({
            url: mota_js.ajax_url,
            type: 'POST',
            data: {
                action: 'get_related_photos',
                category: category,
                current_id: current_id
            },
            success: function(response) {
                if (response.photos.length) {
                    response.photos.forEach(function(photo, index){
                        // Ajouter à photosData pour la lightbox
                        const dataIndex = photosData.length;
                        photosData.push(photo);

                        $('.photo-grid-single').append(`
                            <div class="photo-item single" data-index="${dataIndex}" data-link="${photo.link}">
                                <img src="${photo.thumbnail}" alt="${photo.title}">
                                <div class="content-eye"> 
                                    <button class="btnEye" aria-label="Aperçu details">👁️</button>
                                </div> 
                                <div class="content-btn-lightbox">
                                    <button class="photo-lightbox" aria-label="Voir lightbox">🔍</button>
                                </div>              
                                <div class="photo-details">
                                    <span class="photo-title">${photo.title}</span>
                                    <span class="photo-cat">${photo.category}</span>
                                </div>
                            </div>
                        `);
                    });
                }
            }
        });
    }

    // Lightbox et œil pour la mini-galerie
    $(document).on('click', '.photo-grid-single .photo-lightbox', function(e){
        e.preventDefault();
        e.stopPropagation();
        const index = $(this).closest('.photo-item').data('index');
        currentIndex = index;
        openLightbox(currentIndex);
    });

    $(document).on('click', '.photo-grid-single .btnEye', function(e){
        e.preventDefault();
        e.stopPropagation();
        $(this).closest('.photo-item').toggleClass('show-details');
    });

    $(document).on('click', '.photo-grid-single .photo-item', function(e){
        if ($(e.target).closest('.btnEye, .photo-lightbox').length) return;
        const link = $(this).data('link');
        if (link) window.location.href = link;
    });
});
