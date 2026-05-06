/**
 * Static Timeline Widget – Admin JS
 * Handles WordPress Media Library upload for image and icon fields
 */
(function ($) {
    'use strict';

    // ── Upload button ──
    $(document).on('click', '.stw-upload-btn', function (e) {
        e.preventDefault();

        var btn       = $(this);
        var targetId  = btn.data('target');
        var previewId = btn.data('preview');

        var mediaFrame = wp.media({
            title:    'Select or Upload Media',
            button:   { text: 'Use this media' },
            multiple: false,
            library:  { type: ['image'] }
        });

        mediaFrame.on('select', function () {
            var attachment = mediaFrame.state().get('selection').first().toJSON();
            var url        = attachment.url;

            $('#' + targetId).val(url);

            var $preview = $('#' + previewId);
            $preview.attr('src', url).show();

            // Show remove button
            btn.siblings('.stw-remove-btn').show();
        });

        mediaFrame.open();
    });

    // ── Remove button ──
    $(document).on('click', '.stw-remove-btn', function (e) {
        e.preventDefault();

        var btn       = $(this);
        var targetId  = btn.data('target');
        var previewId = btn.data('preview');

        $('#' + targetId).val('');
        $('#' + previewId).attr('src', '').hide();
        btn.hide();
    });

})(jQuery);
