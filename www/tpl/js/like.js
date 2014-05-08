/**
 * Like
 * @author Vladimir Shestakov
 */
(function ($) {
    $(document).ready(function () {
        $(this).on('click', '.photo__like-link', function (e) {
            var like_value = $(this).parent().find('.photo__like-value');
            e.preventDefault();
            $.ajax({
                type: "POST",
                data: {
                    call: 'like',
                    photo_id: $(this).attr('data-id')
                },
                success: function (result) {
                    like_value.text((result > 0 ? '+' : '') + result);
                }
            });
        });
    })
})(jQuery);