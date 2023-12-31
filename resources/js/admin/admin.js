import './libs';
import slick from 'slick-carousel';

require('./template/adminlte');

$(() => {
    /**
     * 全後台基礎JS 宣告
     */
    $( document ).ready(function() {
        if($('.custom-editor').length){
            $('.custom-editor').summernote({
                placeholder: 'Please Edit Here.',
                tabsize: 2,
                height: $('.custom-editor').data('height'),
            });
        }
        $('.select2').select2({
            allowClear: true
        });
        $('.table-default').DataTable({
            responsive: true,
            paging: false,
            searching: false,
            info: false,
            ordering : false,
        });

        $(document).on("keypress", "form", function (e) {
            var code = e.keyCode || e.which;
            if (code == 13) {
                e.preventDefault();
                return false;
            }
        });


        $('.search-user').select2({
            language: 'zh-TW',
            allowClear: true,
            ajax: {
                type: 'POST',
                url:window.location.origin+"/searchUser",
                dataType: 'json',
                delay:300,
                data: function (params) {
                    let roles = $(this).data('roles');
                    return {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        keyword: params.term,
                        roles : roles,
                    };
                },
                processResults: function (users) {
                    let usersOption = []
                    $.each(users.users, (index, user) => {
                        usersOption.push({
                            id: user.id,
                            text: user.name + ' - ' + user.email
                        })
                    });

                    return {
                        results: usersOption
                    }
                },
            }
        });

    });

    //驗證資料是否有必填
    let $form = $('#admin-form');
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
    });
    $(document.body).on('click','.delete-confirm',e => {
       e.preventDefault();
        let code = '';
        var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        for (var x = 0; x < 10; x++) {
            var i = Math.floor(Math.random() * chars.length);
            code += chars.charAt(i);
        }
        if(prompt('注意！目前將刪除所選擇項目，此操作無法回覆。 如果仍要繼續動作，請輸入以下代碼： ' + code ) === code) {
            $(e.currentTarget).closest('form').submit();
        }
    });

})
