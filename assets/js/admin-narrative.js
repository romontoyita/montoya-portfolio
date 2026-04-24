/* global wp, jQuery */
( function ( $ ) {
    'use strict';

    var $rows    = $( '#cs-narrative-rows' );
    var tplEl    = document.getElementById( 'cs-narrative-tpl' );
    var template = tplEl ? tplEl.innerHTML : '';

    // Start index above existing row count to avoid collisions
    var nextIndex = $rows.find( '.cs-row' ).length + 100;

    // ── Add section ───────────────────────────────────────────────────────────

    $( '#cs-narrative-add' ).on( 'click', function () {
        var html = template.replace( /__INDEX__/g, nextIndex );
        $rows.append( html );
        nextIndex++;
    } );

    // ── Remove section ────────────────────────────────────────────────────────

    $rows.on( 'click', '.cs-row__remove', function () {
        // eslint-disable-next-line no-alert
        if ( ! window.confirm( 'Remove this section?' ) ) return;
        $( this ).closest( '.cs-row' ).remove();
    } );

    // ── Add images via WP media library ──────────────────────────────────────

    $rows.on( 'click', '.cs-images__add', function () {
        var $btn  = $( this );
        var index = $btn.closest( '.cs-images' ).data( 'index' );

        var frame = wp.media( {
            title   : 'Select Images',
            button  : { text: 'Add selected images' },
            multiple: true,
            library : { type: 'image' },
        } );

        frame.on( 'select', function () {
            frame.state().get( 'selection' ).each( function ( attachment ) {
                var att   = attachment.toJSON();
                var thumb = att.sizes && att.sizes.thumbnail
                    ? att.sizes.thumbnail.url
                    : att.url;

                var $item = $(
                    '<span class="cs-img">' +
                        '<img src="' + thumb + '" width="60" height="60">' +
                        '<input type="hidden"' +
                            ' name="cs_narrative[' + index + '][image_ids][]"' +
                            ' value="' + att.id + '">' +
                        '<button type="button" class="cs-img__remove" aria-label="Remove image">&times;</button>' +
                    '</span>'
                );
                $btn.before( $item );
            } );
        } );

        frame.open();
    } );

    // ── Remove image ──────────────────────────────────────────────────────────

    $rows.on( 'click', '.cs-img__remove', function () {
        $( this ).closest( '.cs-img' ).remove();
    } );

} ( jQuery ) );
