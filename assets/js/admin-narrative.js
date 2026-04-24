/* global wp, jQuery */
( function ( $ ) {
    'use strict';

    var $rows       = $( '#cs-narrative-rows' );
    var sectionTpl  = tpl( 'cs-narrative-tpl' );
    var singleTpl   = tpl( 'cs-gallery-row-single-tpl' );
    var pairTpl     = tpl( 'cs-gallery-row-pair-tpl' );
    var nextSection = $rows.find( '.cs-row' ).length + 100;
    var nextGallery = 1000; // global counter for gallery row indices

    function tpl( id ) {
        var el = document.getElementById( id );
        return el ? el.innerHTML : '';
    }

    // ── Add narrative section ─────────────────────────────────────────────────

    $( '#cs-narrative-add' ).on( 'click', function () {
        var html = sectionTpl.replace( /__IDX__/g, nextSection );
        $rows.append( html );
        nextSection++;
    } );

    // ── Remove narrative section ──────────────────────────────────────────────

    $rows.on( 'click', '.cs-row__remove', function () {
        if ( ! window.confirm( 'Remove this section?' ) ) return;
        $( this ).closest( '.cs-row' ).remove();
    } );

    // ── Add gallery row (single or pair) ─────────────────────────────────────

    $rows.on( 'click', '.cs-add-gallery-single, .cs-add-gallery-pair', function () {
        var $btn        = $( this );
        var sectionIdx  = $btn.closest( '.cs-row' ).data( 'index' );
        var isPair      = $btn.hasClass( 'cs-add-gallery-pair' );
        var galleryIdx  = nextGallery++;
        var source      = isPair ? pairTpl : singleTpl;

        var html = source
            .replace( /__IDX__/g, sectionIdx )
            .replace( /__GDX__/g, galleryIdx );

        $btn.closest( '.cs-gallery-wrap' ).find( '.cs-gallery-rows' ).append( html );
    } );

    // ── Remove gallery row ────────────────────────────────────────────────────

    $rows.on( 'click', '.cs-gallery-row__remove', function () {
        $( this ).closest( '.cs-gallery-row' ).remove();
    } );

    // ── Add image to slot (single pick per slot) ──────────────────────────────

    $rows.on( 'click', '.cs-slot__add', function () {
        var $btn  = $( this );
        var $slot = $btn.closest( '.cs-gallery-slot' );
        var sectionIdx = $slot.data( 'section' );
        var galleryIdx = $slot.data( 'grow' );

        var frame = wp.media( {
            title   : 'Select Image',
            button  : { text: 'Use this image' },
            multiple: false,
            library : { type: 'image' },
        } );

        frame.on( 'select', function () {
            var att   = frame.state().get( 'selection' ).first().toJSON();
            var thumb = att.sizes && att.sizes.thumbnail
                ? att.sizes.thumbnail.url
                : att.url;

            var $preview = $(
                '<span class="cs-slot-img">' +
                    '<img src="' + thumb + '" width="80" height="80">' +
                    '<input type="hidden"' +
                        ' name="cs_narrative[' + sectionIdx + '][gallery][' + galleryIdx + '][ids][]"' +
                        ' value="' + att.id + '">' +
                    '<button type="button" class="cs-slot-img__remove" aria-label="Remove">&times;</button>' +
                '</span>'
            );

            $btn.replaceWith( $preview );
        } );

        frame.open();
    } );

    // ── Remove image from slot ────────────────────────────────────────────────

    $rows.on( 'click', '.cs-slot-img__remove', function () {
        var $slot = $( this ).closest( '.cs-gallery-slot' );
        var sectionIdx = $slot.data( 'section' );
        var galleryIdx = $slot.data( 'grow' );

        $( this ).closest( '.cs-slot-img' ).replaceWith(
            '<button type="button" class="button cs-slot__add"' +
                ' data-section="' + sectionIdx + '" data-grow="' + galleryIdx + '">' +
                'Add Image' +
            '</button>'
        );
    } );

}( jQuery ) );
