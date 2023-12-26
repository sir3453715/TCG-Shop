import './admin/libs';
import slick from 'slick-carousel';

import 'select2/dist/js/i18n/zh-TW.js';


$(() => {
    $( document ).ready(function() {

        $('.select2').select2({
            placeholder:"enter keyword",
            allowClear: true,
            language:'zh-TW',
        });

        $('.slider').slick({
            prevArrow:'<button type="button" class="slick-prev"></button>',
            nextArrow:'<button type="button" class="slick-next"></button>',
            dots: true,
        });

        $('.slider-syncing').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            asNavFor: '.slider-center'
        });
        $('.slider-nav').slick({
            prevArrow:'<button type="button" class="slick-prev"></button>',
            nextArrow:'<button type="button" class="slick-next"></button>',
            slidesToShow: 3,
            slidesToScroll: 1,
            dots: true,
            centerMode: true,
            focusOnSelect: true
        });

        $('.slider-center').slick({
            centerMode: true,
            centerPadding: '0px',
            slidesToShow: 3,
            adaptiveHeight: true,
            asNavFor: '.slider-syncing',
        });


        $('.table-cart').DataTable({
            responsive: false,
            autoWidth: false,
            paging: false,
            searching: false,
            info: false,
            ordering : false,
        });

        $('body').on('click','.add-to-cart',function (e){
            let id = $(this).data('id');
            $.ajax({
                type: "POST",
                url:"/AddToCart",
                dataType:"json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id': id,
                    'type': $(this).data('type'),
                },
                success:function(object){
                    $('#mini-cart-list').html(object.html);
                    $('#count').html(object.cart.count);
                    $('#total').html(object.cart.total);
                }
            });
        });


        $('body').on('click','#cleanCart',function (e){
            $.ajax({
                type: "POST",
                url:"/CleanCart",
                dataType:"json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
                success:function(object){
                    $('#mini-cart-list').html('<div class="col-12 align-self-center text-center">購物車內目前沒有商品</div>');
                    $('#count').html(0);
                    $('#total').html(0);
                }
            });
        });









        // mini-cart
    (function(){
 
         $("#mini-cart, #mini-cart-close").on("click", function() {
             $(".mini-cart").fadeToggle( "fast");
         });
    
        })();


    });



    //驗證資料是否有必填
    let $form = $('.validation-form');
    function focusField(element) {//鎖定未填欄位
        let tabId = $(element).closest('.tab-pane').attr('aria-labelledby')
        $('#' + tabId).tab('show');
        $(window).scrollTop($(element).offset().top - $(window).height() / 2);
        $(element).focus();
    }
    function showValidationMessage(element, message) {//顯示必填通知
        removeValidationMessage();
        $(element).addClass('required-error');
        $('<div>').addClass('required-error-message text-danger').html(message).insertAfter(element)
    }
    function removeValidationMessage() {//移除必填通知
        $('.required-error-message').remove();
        $('.required-error').removeClass('required-error');
    }
    $(document.body).on('change','.required-error',function (){//必填未填項目修改後移除通知
        removeValidationMessage();
    });

    $form.on('submit', e => {//表單送出後進行驗證
        // 檢查所有的必填欄位
        let invalid = false;
        $('.form-required').each((index, ele) => {
            if(!$(ele).val()) {
                invalid = true;
                focusField(ele);
                showValidationMessage(ele, '此欄位必填');
                return false;
            }
        });
        if(invalid) {
            return false;
        }
        $('#notification-message').show();
        return false;
    });
})
