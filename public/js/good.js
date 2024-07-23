$(document).ready(function () {
    $('.like-button').on('click', function () {
        var button = $(this);
        var articleId = button.data('article-id');

        $.ajax({
            url: '/blog/' + articleId + '/like',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content') // CSRFトークンを含める
            },
            success: function (response) {
                if (response.status === 'success') {
                    // 「いいね」数を更新
                    $('#like-count').text(response.likeCount);
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr) {
                alert('エラーが発生しました。もう一度試してください。');
            }
        });
    });
});
