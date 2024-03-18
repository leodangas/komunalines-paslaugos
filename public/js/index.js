const $ = jQuery;

$(document).ready(function() {
    function openPopup(popup, eventListenerTag){
        popup.fadeIn(500).css('display', 'flex');

        $(document).on(`click.${eventListenerTag}`, function(e) {
            let target = $(e.target);
            if (target.hasClass('default-popup')) {
                popup.fadeOut(500, function() {
                    $(document).off(`click.${eventListenerTag}`);
                });
            }
        })
    }

    $(document).on('click', '.default-actions-button', function(e) {
        e.stopPropagation();
        $(document).off('click.closeactions');
        let $this = $(this),
            actions = $this.siblings('.default-actions'),
            otherActions = $('.default-actions');

        if (actions.length === 0) {
            actions = $this.find('.default-actions');
        }

        if (actions.css('display') !== 'none') {
            actions.hide();
            return;
        }

        otherActions.hide();
        otherActions.closest('.last').removeClass('active');

        $this.closest('.last').addClass('active');
        actions.show();


        $(document).on('click.closeactions', function(e) {
            e.stopPropagation();
            let target = $(e.target);
            if (target.hasClass('default-actions') || target.hasClass('action')) {

            }
            else {
                actions.hide();
                $(document).off('click.closeactions');
            }
        })
    })

    $('.delete-user-button-form-link').on('click', function(e) {
        e.preventDefault();
        $(this).siblings('.delete-user-form').submit();
    })

    $('select').each(function() {
        let $this = $(this);
        $this.select2({
            minimumResultsForSearch: -1,
            placeholder: $this.hasClass('add-select2--placeholder') ? '' : null
        })
    })

    $('.load-new-creation-form').on('click', function() {
        openPopup($('.new-creation-popup'), 'new-popup');
    })

    $('.show-edit-popup').on('click', function(e) {
        e.preventDefault();
        openPopup($(this).closest('.last').find('.edit-popup'), 'edit-popup');
    })

    $('.default-popup').each(function() {
        if ($(this).hasClass('active')) {
            openPopup($(this), 'popupActive');
        }
    })

    $('.default-popup__close').on('click', function() {
        $('.default-popup').fadeOut();
    })

    $('.container-log-out').on('click', function() {
        $('#logout-form').submit();
    })
})
