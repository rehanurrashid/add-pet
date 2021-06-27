/**
 * Media upload logic
 * @author  Technology Architects
 */
// manage so
(function (so, $) {
    'use strict';

    var p = so.ap = {};
    p.image_frame = null;

    p.init = function () {

        var $body = $('body');

        $body.on('click', '.upload_image', function (e) {
            var $this = $(e.currentTarget);
            p.$parent = $this.parent();

            if (p.image_frame) {
                p.image_frame.open();
                return false;
            }

            if (!p.image_frame) {
                p.image_frame = wp.media({
                    title: 'Select an Image',
                    multiple: false,
                    library: {
                        type: 'image',
                    }
                });

                p.image_frame.on('close', function () {
                    var selection = p.image_frame.state().get('selection').first();
                    if (selection) {
                        var json = selection.toJSON();
                        p.$parent.find('img').attr('src', json.url);

                        p.$parent.find('.loader').show();
                        console.log('loading...');
                        p.$parent.find('img').one('load', function(){
                            p.$parent.find('.loader').hide();
                            console.log('loaded');
                        });
                        p.$parent.find('input[type=hidden]').val(json.id);
                        // console.log(p.$parent.find('input[type=hidden]').attr('name'));
                    }
                    // p.image_frame.detach();
                    // p.image_frame = null;

                });

                p.image_frame.open();
            }

            // p.image_frame.on('open', function () {
            //     // var selection = p.image_frame.state().get('selection');
            // });

            return false;
        });

        $body.on('click', '.upload_svg', function (e) {
            var $this = $(e.currentTarget);
            p.$parent = $this.parent();

            if (p.svg_frame) {
                p.svg_frame.open();
                return false;
            }

            if (!p.svg_frame) {
                p.svg_frame = wp.media({
                    title: 'Select a SVG image',
                    multiple: false,
                    library: {
                        type: [
                            'image/svg+xml',
                        ]
                    }
                });

                p.svg_frame.on('close', function () {
                    var selection = p.svg_frame.state().get('selection').first();
                    if (selection) {
                        var json = selection.toJSON();
                        p.$parent.find('img').attr('src', json.url);

                        p.$parent.find('.loader').show();
                        console.log('loading...');
                        p.$parent.find('img').one('load', function(){
                            p.$parent.find('.loader').hide();
                            console.log('loaded');
                        });
                        p.$parent.find('input[type=hidden]').val(json.url);
                    }

                });

                p.svg_frame.open();
            }

            return false;
        });

        $body.on('click', '.upload_font', function(e){
            var $this = $(e.currentTarget);
            p.$parent = $this.parent().parent();

            if (p.font_frame) {
                p.font_frame.open();
                return false;
            }

            if (!p.font_frame) {
                p.font_frame = wp.media({
                    title: 'Select a TTF File',
                    multiple: false,
                    library: {
                        type: [
                            'application/x-font-ttf',
                        ]
                    }
                });

                p.font_frame.on('close', function () {
                    var selection = p.font_frame.state().get('selection').first();
                    if (selection) {
                        var json = selection.toJSON();
                        p.$parent.find('.name').html('File : <strong>'+json.filename+'</strong>');

                        p.$parent.find('input[type=hidden]').val(json.url);
                    }

                });

                p.font_frame.open();
            }
            return false;
        });

        $body.on('click', '.add-btn', function(){
            var $parent = $(this).parent().parent(),
                $jlist = $parent.find('.jlist'),
                i = ($jlist.children().length>0)?parseInt($jlist.find('> :last-child').data('index'))+1:0,
                html = '';

            if($parent.hasClass('pet-images'))
                html = so.ap.getPetImagesHTML(i);

            $jlist.append(html);
            console.log('hello .add-btn', $jlist.children().length);
            return false;
        });
        $body.on('click', '.btn-delete', function(){
            var c = confirm('Are you sure? Item will be deleted'),
                isOutputPage =  $body.find('.jdt-output').length !== 0;

            if(c && !isOutputPage) {
               $(this).parent().remove();
            } else if( c  && isOutputPage ) {
                return true;
            }

            return false;
        });

       // .current class custom category pet
    if(window.location.href.includes("taxonomy=ap_cat&post_type=ap-pet")){
        let pet_sub_menu = $("#toplevel_page_edit-post_type-ap-pet ul.wp-submenu a");
        $.each(pet_sub_menu, function(k, v){
            if($(v).attr('href').includes("taxonomy=ap_cat&post_type=ap-pet")){
                $(v).parent().addClass('current');
            }
            else{
                $(v).parent().removeClass('current');
            }
        })
    }
    
    //  when radio button option selected 

        $("input[name='_sell_adopt']").on('change', function(e) {
            var sell_adopt_input = $(this);
            var sell_adopt=sell_adopt_input.val();

            if(sell_adopt == 'sell'){ 

                $('.price-div').slideDown("fast");
                $('.pet-sitting-div').slideUp("fast");

            }
            else if(sell_adopt == 'adopt'){ 

                $('.price-div').slideUp("fast");
                $('.pet-sitting-div').slideUp("fast");

            }
            else if(sell_adopt == 'pet-sitting'){ 

                $('.price-div').slideUp("fast");
                $('.pet-sitting-div').slideDown("fast");

            }
         });

    }

     p.getPetImagesHTML = function(i) {
        return '<div class="jitem p10" data-index="'+i+'">\
                <button class="button vm upload_image">Add Image</button>\
                <img class="vm" width="150px" height="150px" src="'+so.ap_url+'/admin/images/placeholder.png" alt="">\
                <input name="image_gallary[]" type="hidden" >\
            <button class="button fr btn-delete">x</button>\
        </div>';
    }


})(window.so = window.so || {}, jQuery);

jQuery(document).ready(so.ap.init);
