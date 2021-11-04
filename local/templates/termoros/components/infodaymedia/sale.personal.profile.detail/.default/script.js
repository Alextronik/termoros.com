$(document).ready(function() {
    $('.profile_radio').on('change', function () {
        $.ajax({
            url: '/include/set_profile.php',
            data: 'profile='+$(this).val(),
            success: function(data) {

            }
        });
    });
    $('.send_edit').on('submit',function()
    {
        var data = $(this).serialize();
        $.ajax({
            url: '/include/edit_profile.php',
            data: data,
            success: function(responce) {
                $.fancybox( '<p class="popup-window-site">Запрос отправлен администратору.</p>',{wrapCSS : 'photo-lightbox-class'});
            }
        });
        return false;
    });
});

