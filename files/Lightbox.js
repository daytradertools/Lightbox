(function ($) {
  $(document).ready(function () {

    // Standardwerte, falls du (vorerst) keine Plugin-Konfiguration nutzt
    var lightbox_display_on_img_preview = true;
    var lightbox_display_on_img_link    = true;

    function applyLightbox() {
        // 1. Vorschaubilder in der Hauptansicht (Anhänge mit Bild)
        if (lightbox_display_on_img_preview) {
            $('a[href*="file_download.php"]').filter(function() {
                return $(this).find('img').length > 0;
            }).attr('data-lightbox', 'bug-attachments');
        }

        // 2. Links in Bugnotes/Kommentaren
        if (lightbox_display_on_img_link) {
            $('a[href*="file_download.php"]').each(function() {
                var href = $(this).attr('href') || '';
                if (href.match(/\.(jpeg|jpg|gif|png|webp)$/i)) {
                    $(this).attr('data-lightbox', 'bug-attachments');
                }
            });
        }
    }

    applyLightbox();

    // Falls Inhalte per AJAX nachgeladen werden
    $(document).ajaxComplete(function() {
        applyLightbox();
    });

  });
})(jQuery);
