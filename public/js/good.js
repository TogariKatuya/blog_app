$(document).ready(function () {
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
                    button.toggleClass('liked'); // 「いいね」状態をトグル

                } else {

                }
            },
            error: function (xhr) {
                alert('エラーが発生しました。もう一度試してください。');
            }
        });
    });
});
