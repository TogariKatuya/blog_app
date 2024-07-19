document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('myModal');
    var openModalBtn = document.getElementById('openModalBtn');
    var closeModalBtn = document.getElementById('closeModalBtn');

    openModalBtn.onclick = function () {
        modal.classList.add('show'); // ポップアップを表示する
    }

    closeModalBtn.onclick = function () {
        modal.classList.remove('show'); // ポップアップを非表示にする
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.classList.remove('show'); // 背景クリックでポップアップを非表示にする
        }
    }

    document.getElementById('popupForm').onsubmit = function (event) {
        event.preventDefault();

        var formData = new FormData(this);
        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        axios.post('/registration', formData, {
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'multipart/form-data' // フォームデータを送信するためのヘッダー
            }
        })
            .then(response => {
                console.log('Response:', response.data); // デバッグ用ログ
                alert(response.data.message);
                modal.classList.remove('show'); // フォーム送信後にポップアップを非表示にする
            })
            .catch(error => {
                console.error('Error:', error); // デバッグ用ログ
                alert('ユーザーの作成に失敗しました');
            });
    }
});
