
function parseMarkdown(text) {
    let html = text
        .replace(/^### (.*$)/gim, '<h3>$1</h3>')
        .replace(/^## (.*$)/gim, '<h2>$1</h2>')
        .replace(/^# (.*$)/gim, '<h1>$1</h1>')
        .replace(/\*\*(.*)\*\*/gim, '<b>$1</b>')
        .replace(/\*(.*)\*/gim, '<i>$1</i>')
        .replace(/\[([^\[]+)\]\(([^\)]+)\)/gim, '<a href="$2">$1</a>')
        .replace(/\n$/gim, '<br>');
    return html.trim();
}

// プレビューを更新
function updatePreview() {
    const contents = document.getElementById('contents').value;
    const preview = document.getElementById('preview');
    preview.innerHTML = parseMarkdown(contents);
}

// イベントリスナーを追加
document.getElementById('contents').addEventListener('input', updatePreview);

// ローカルストレージに入力内容を保存
function saveDraft() {
    localStorage.setItem('blogTitle', document.getElementById('title').value);
    localStorage.setItem('blogContents', document.getElementById('contents').value);
}

// ページロード時にローカルストレージから入力内容を復元
window.onload = function () {
    document.getElementById('title').value = localStorage.getItem('blogTitle') || '';
    document.getElementById('contents').value = localStorage.getItem('blogContents') || '';
    updatePreview();
}

// 定期的に入力内容を保存
setInterval(saveDraft, 5000);

function clearDraft() {
    localStorage.removeItem('blogTitle');
    localStorage.removeItem('blogContents');
    document.getElementById('title').value = '';
    document.getElementById('contents').value = '';
    updatePreview();
}

// 下書き削除ボタンのクリック処理
document.querySelector('button[onclick="clearDraft()"]').addEventListener('click', function () {
    // 下書きをクリア
    clearDraft();
});