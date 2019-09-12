/**
 * Controls the behaviours of custom metabox fields.
 *
 * @author Opalteam
 */
window.OPAL_USER_RATING = window.OPAL_USER_RATING || {};
( function ( window, document, $, opalUserRating, undefined ) {
    'use strict';

    // localization strings
    var l10n = window.opalUserRating_l10;
    var $document;

    /**
     * Constructor.
     */
    opalUserRating.init = function () {
        $document = $( document );

        var $el_container = opalUserRating.el_container();

        $el_container
            .on( 'click', '.add-new-feature', opalUserRating.addFeature )
            .on( 'click', '.feature-rating-remove', opalUserRating.removeFeature );

        // Make Features List drag/drop sortable:
        opalUserRating.makeListSortable();
    };

    opalUserRating.makeListSortable = function() {
        var $features_list = opalUserRating.el_container().find( '.opaljob-features-rating-list' );
        if ( $features_list.length ) {
            $features_list.sortable({ cursor: 'move' }).disableSelection();
        }
    };

    opalUserRating.addFeature = function( evt ) {
        evt.preventDefault();

        var $el = $( this );

        $.ajax( {
            type: 'post',
            dataType: 'json',
            url: ajaxurl,
            data: {
                action: 'render_new_feature_item'
            },
            success: function ( response ) {
                if ( response.type == 'success' ) {
                    $el.closest( '.features-wrap' ).find( '.opaljob-features-rating-list' ).append( response.html );
                }
            }
        } );
    };

    opalUserRating.removeFeature = function( evt ) {
        evt.preventDefault();

        var $el = $( this );
        $el.closest( '.opaljob-features-rating-item' ).remove();
    };

    /**
     * Gets jQuery object containing all el_containeres. Caches the result.
     *
     * @return {Object} jQuery object containing all el_containeres.
     */
    opalUserRating.el_container = function () {
        if ( opalUserRating.$metabox ) {
            return opalUserRating.$metabox;
        }
        opalUserRating.$metabox = $( 'form.opaljob-user-rating-options' );
        return opalUserRating.$metabox;
    };

    // Kick it off!
    $( opalUserRating.init );

} )( window, document, jQuery, window.OPAL_USER_RATING );
