import './admin/libs';
import slick from 'slick-carousel';

import 'select2/dist/js/i18n/zh-TW.js';


$(() => {
    $( document ).ready(function() {
        /** select2 宣告與中文*/
        $('.select2').select2({
            placeholder:"enter keyword",
            allowClear: true,
            language:'zh-TW',
        });
        /** 一般Slider*/
        $('.slider').slick({
            prevArrow:'<button type="button" class="slick-prev"></button>',
            nextArrow:'<button type="button" class="slick-next"></button>',
            dots: true,
        });
        /** 雙層slider&Slider 置中 */
        $('.slider-syncing').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            asNavFor: '.slider-center'
        });
        $('.slider-center').slick({
            centerMode: true,
            centerPadding: '0px',
            slidesToShow: 3,
            adaptiveHeight: true,
            asNavFor: '.slider-syncing',
        });

        /** 訂單資料DataTable宣告 */
        $('.table-cart').DataTable({
            responsive: false,
            autoWidth: false,
            paging: false,
            searching: false,
            info: false,
            ordering : false,
        });

        /** 購物車動作 */
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
                    $('.cart-count').html(object.cart.count);
                    $('#total').html(object.cart.total);
                    // swal({
                    //     title: '已成功加入購物車!',
                    //     icon: "success",
                    // });
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
                    $('.cart-count').html(0);
                    $('#total').html(0);
                }
            });
        });
        $('body').on('click','.modal-add',function (e){
            let $type = $(this).data('type'),$number = $('.modal-number').val(), $newNumber = 0;
            if($type === 'plus'){
                $newNumber = (parseInt($number) + 1);
                $('.modal-number').val($newNumber);
            }else if($type === 'minus'){
                if($number > 1){
                    $newNumber = (parseInt($number) - 1);
                    $('.modal-number').val($newNumber);
                }else{
                    $('.modal-number').val(1);
                }
            }
        });


        $('body').on('click','#modal-add-to-cart',function (e){
            let $id = $(this).data('id');
            $.ajax({
                type: "POST",
                url:"/AddToCart",
                dataType:"json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id': $id,
                    'type': 'modal',
                    'num': $('.modal-number').val(),
                },
                success:function(object){
                    console.log(object)
                    let changeItem = object.cart.items[$id];
                    $('#mini-cart-list').html(object.html);
                    $('#count').html(object.cart.count);
                    $('.cart-count').html(object.cart.count);
                    $('#total').html(object.cart.total);
                    $('#item-subtotal').html(object.cart.total);
                    $('#number-'+$id).val(changeItem['number']);
                    $('#price-'+$id).html(parseInt(changeItem['price'])/parseInt(changeItem['number']));
                    $('#total-'+$id).html(changeItem['price']);
                    // swal({
                    //     title: '已成功加入購物車!',
                    //     icon: "success",
                    //     buttons: false,
                    //     timer: 2000,
                    // });
                }
            });
        });


        /** sweet Alert 刪除資料提示*/
        $('body').on('click','.sweet-delete-confirm',function (event){
            var form =  $(this).closest("form");
            event.preventDefault();
            swal({
                title: `您確定要刪除此牌組嗎?`,
                text: "此操作將無法復原!",
                icon: "warning",
                buttons: {
                    Btn: false,
                    cancel: {
                        text: "取消",
                        visible: true
                    },
                    confirm: {
                        text: "確認刪除",
                        visible: true
                    },
                },
                dangerMode: true,

            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });


        /** mini cart */
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
