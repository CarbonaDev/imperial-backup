/* Mega Menu */
(function($) {
    "use strict";

    $(document).ready(function($) {
        var dependiences = new Array();

        dependiences.push({
            field: 'kft-design',
            values: [
            {
                fieldValue: 'sized',
                showFields: ['kft-width', 'kft-height', 'kft-block', 'wp-editor-wrap', 'kft-columns']
            },
            {
                fieldValue: 'full-width',
                showFields: ['kft-block', 'wp-editor-wrap', 'kft-columns']
            }
            ]
        });

        $('.kft-design').find('select').on('change', function() {

            var field = $(this).data('field'),
            dependency = $.grep(dependiences, function(e) { return e.field == field; }),
            selectValue = $(this).val();

            if (!dependency.length > 0) {
                return;
            }

            dependency = dependency[0];

            // Sort values dependencies. We need to hide unnecessary first and then show required fields
            dependency.values.sort(function(a, b) {
                return b.fieldValue == selectValue;
            });

            for (var k = dependency.values.length - 1; k >= 0; k--) {
                var value = dependency.values[k].fieldValue,
                depended = '';

                for (var l = dependency.values[k].showFields.length - 1; l >= 0; l--) {
                    depended += '.' + dependency.values[k].showFields[l] + ', ';
                };

                depended += '.xyz';

                if (selectValue != value) {
                    $(this).parents('li').find(depended).hide();
                } else {
                    $(this).parents('li').find(depended).show();
                }
            };

        }).trigger('change');
    });

    /* Upload thumbnail */
    $(document).on('click', '.kft_mega_menu_upload_image', function() {
        var upload = $(this);
        var remove = $(this).siblings('a.kft_mega_menu_remove_image');
        var preview = $(this).siblings('span.preview-thumbnail-wrapper');
        var id = $(this).siblings('.thumbnail-id-hidden');
        wp.media.editor.send.attachment = function(props, attachment) {
            var thumb_id = attachment.id;
            var thumb_url = '';
            if (typeof(attachment.sizes.thumbnail) !== 'undefined') {
                thumb_url = attachment.sizes.thumbnail.url;
            } else {
                thumb_url = attachment.sizes[props.size].url;
            }
            var img_html = '<img src="' + thumb_url + '" width="80" height="80" >';
            preview.html(img_html);
            id.val(thumb_id);

            upload.hide();
            remove.show();
        }
        wp.media.editor.open(upload);
    });

    $(document).on('click', '.kft_mega_menu_remove_image', function() {
        var remove = $(this);
        var upload = $(this).siblings('a.kft_mega_menu_upload_image');
        var preview = $(this).siblings('span.preview-thumbnail-wrapper');
        var id = $(this).siblings('.thumbnail-id-hidden');
        preview.html('');
        id.val('');
        upload.show();
        remove.hide();
        return false;
    });

    /* Add Sidebar */
    $(document).ready(function($) {
        var sidebarForm = $('#mipro_add_sidebar_form');
        var sidebarFormNew = sidebarForm.clone();
        sidebarForm.remove();
        $('#widgets-right').append('<div style="clear:both;"></div>');
        $('#widgets-right').append(sidebarFormNew);

        sidebarFormNew.on('submit', function(e) {
            e.preventDefault();
            var data = {
                'action': 'mipro_add_sidebar',
                '_wpnonce_mipro_widgets': $('#_wpnonce_mipro_widgets').val(),
                'mipro_sidebar_name': $('#mipro_sidebar_name').val(),
            };
            $.ajax({
                url: ajaxurl,
                data: data,
                success: function(response) {
                    window.location.reload(true);
                },
                error: function(data) {

                }
            });
        });
    });

    $(document).ready(function($) {

        var deleteSidebar = '<div class="delete-sidebar"></div>';

        $('.sidebar-mipro_custom_sidebar').find('.handlediv').before(deleteSidebar);

        $('.delete-sidebar').on('click', function() {

            var confirmIt = confirm('Are you sure?');

            if (!confirmIt) {
                return;
            }

            var widgetBlock = $(this).closest('.sidebar-mipro_custom_sidebar');

            var data = {
                'action': 'mipro_delete_sidebar',
                'mipro_sidebar_name': $(this).parent().find('h2').text()
            };

            widgetBlock.hide();

            $.ajax({
                url: ajaxurl,
                data: data,
                success: function(response) {
                    widgetBlock.remove();
                },
                error: function(data) {
                    alert('Error while deleting sidebar');
                    widgetBlock.show();
                }
            });
        });
    });

    /* Upload media widget */
    $(document).on('click', '.widgets-holder-wrap .upload_image_button', function() {

        $.data(document.body, 'prevElement', $(this).prev());

        var mediaFrame;

        mediaFrame = wp.media({
            title: 'Add Image',
            multiple: false,
            library: {
                type: 'image'
            },
            button: {
                text: 'Add to Widget'
            }
        });

        var media_set_image = function() {
            var selection = mediaFrame.state().get('selection');
            if ( !selection ) {
                return;
            }
            selection.each(function(attachment) {
                var url = attachment.attributes.url;
                var inputText = $.data(document.body, 'prevElement');

                if(inputText != undefined && inputText != '') {
                    inputText.val(url);
                }
            });
        };

        mediaFrame.on('close', media_set_image);

        mediaFrame.on('select', media_set_image);

        mediaFrame.open();
    });

})(jQuery);