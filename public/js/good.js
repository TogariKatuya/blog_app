$(document).ready(function () {
    var articleId = $('.like-button').data('article-id');

    $.ajax({
        url: '/blog/' + articleId + '/like-status',
        method: 'GET',
        success: function (response) {
            if (response.liked) {
                $('.like-button').addClass('liked');
            }
        },
        error: function (xhr) {
            alert('エラーが発生しました。もう一度試してください。');
        }
    });

    $('.like-button').on('click', function () {
        var button = $(this);
        var articleId = button.data('article-id');

        $.ajax({
            url: '/blog/' + articleId + '/like',
            method: 'POST',
            data: {},
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            },
            success: function (response) {
                if (response.status === 'success') {
                    $('#like-count').text(response.likeCount);
                    button.toggleClass('liked');
                }
            },
            error: function (xhr) {
                alert('エラーが発生しました。もう一度試してください。');
            }
        });
    });
});
