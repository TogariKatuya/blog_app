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

// 既存の内容でプレビューを初期化
window.onload = function () {
    updatePreview();
};
