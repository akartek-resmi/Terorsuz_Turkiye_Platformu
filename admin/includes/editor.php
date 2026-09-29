<?php

function rich_editor(string $name, string $value, array $opts = []): string {
    $preview = $opts['preview'] ?? 'page';
    $minH    = (int)($opts['min_height'] ?? 240);
    $id      = 'ttpaed_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $name);

    $buttons = [
        ['cmd' => 'formatBlock', 'val' => 'p',  'label' => 'Paragraf', 'title' => 'Normal paragraf'],
        ['cmd' => 'formatBlock', 'val' => 'h3', 'label' => 'Başlık',   'title' => 'Ara başlık'],
        ['sep' => true],
        ['cmd' => 'bold',      'label' => '<b>K</b>', 'title' => 'Kalın (Ctrl+B)'],
        ['cmd' => 'italic',    'label' => '<i>İ</i>', 'title' => 'İtalik (Ctrl+I)'],
        ['cmd' => 'underline', 'label' => '<u>A</u>', 'title' => 'Altı çizili (Ctrl+U)'],
        ['sep' => true],
        ['cmd' => 'insertUnorderedList', 'label' => 'Madde listesi',  'title' => 'Madde işaretli liste'],
        ['cmd' => 'insertOrderedList',   'label' => 'Numaralı liste', 'title' => 'Numaralı liste'],
        ['sep' => true],
        ['cmd' => 'ttpLink', 'label' => 'Bağlantı ekle',     'title' => 'Seçili metne bağlantı ver'],
        ['cmd' => 'unlink',  'label' => 'Bağlantıyı kaldır', 'title' => 'Bağlantıyı kaldır'],
        ['sep' => true],
        ['cmd' => 'removeFormat', 'label' => 'Biçimi temizle', 'title' => 'Kalın/italik gibi biçimleri kaldır'],
        ['cmd' => 'undo', 'label' => 'Geri al',  'title' => 'Geri al (Ctrl+Z)'],
        ['cmd' => 'redo', 'label' => 'İleri al', 'title' => 'İleri al (Ctrl+Y)'],
    ];

    $html  = '<div class="ttpa-editor">';
    $html .= '<div class="ttpa-ed-toolbar">';
    foreach ($buttons as $b) {
        if (!empty($b['sep'])) { $html .= '<span class="ttpa-ed-sep"></span>'; continue; }
        $html .= '<button type="button" class="ttpa-ed-btn"'
               . ' data-cmd="' . htmlspecialchars($b['cmd']) . '"'
               . (isset($b['val']) ? ' data-val="' . htmlspecialchars($b['val']) . '"' : '')
               . ' title="' . htmlspecialchars($b['title']) . '">' . $b['label'] . '</button>';
    }
    $html .= '<span class="ttpa-ed-spacer"></span>';
    $html .= '<button type="button" class="ttpa-ed-btn ttpa-ed-source" title="HTML kaynağını göster/gizle">HTML</button>';
    $html .= '</div>';

    $html .= '<div class="ttpa-ed-surface" contenteditable="true" data-preview="'
           . htmlspecialchars($preview) . '" style="min-height:' . $minH . 'px;">'
           . $value . '</div>';

    $html .= '<textarea class="ttpa-ed-input" id="' . htmlspecialchars($id) . '" name="'
           . htmlspecialchars($name) . '" hidden>' . htmlspecialchars($value) . '</textarea>';

    $html .= '<p class="ttpa-ed-note">Enter yeni paragraf, Shift+Enter alt satır açar.</p>';
    $html .= '</div>';

    return $html;
}

function rich_editor_assets(): void {
    static $done = false;
    if ($done) return;
    $done = true;
?>
<style>
  .ttpa-editor { border:1px solid var(--border); border-radius:4px; background:#fff; margin-bottom:6px; }
  .ttpa-ed-toolbar { display:flex; flex-wrap:wrap; align-items:center; gap:4px; padding:7px 8px;
    border-bottom:1px solid var(--border); background:#F8FAFC; border-radius:4px 4px 0 0; }
  .ttpa-ed-btn { font:inherit; font-size:12.5px; line-height:1; padding:7px 10px; min-height:30px;
    background:#fff; border:1px solid var(--border); border-radius:3px; color:#334155; cursor:pointer;
    transition:background .15s ease, border-color .15s ease; }
  .ttpa-ed-btn:hover { background:#EEF2F7; border-color:#CBD5E1; }
  .ttpa-ed-btn.is-active { background:#0F172A; border-color:#0F172A; color:#fff; }
  .ttpa-ed-btn b, .ttpa-ed-btn i, .ttpa-ed-btn u { font-size:13px; }
  .ttpa-ed-sep { width:1px; height:18px; background:var(--border); margin:0 3px; }
  .ttpa-ed-spacer { flex:1 1 auto; }

  .ttpa-ed-surface { padding:22px 24px; outline:none; overflow-wrap:break-word;
    font-family:-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
  .ttpa-ed-surface:focus { box-shadow:inset 0 0 0 2px rgba(168,28,28,.12); }
  .ttpa-ed-surface a { color:#A81C1C; }
  .ttpa-ed-surface img { max-width:100%; height:auto; }
  .ttpa-ed-surface ul, .ttpa-ed-surface ol { padding-left:22px; }

  .ttpa-ed-surface[data-preview="page"] { font-size:16px; color:#334155; line-height:1.85; max-width:840px; }
  .ttpa-ed-surface[data-preview="page"] p { margin:0 0 20px 0; }
  .ttpa-ed-surface[data-preview="founder"] { font-size:15px; color:#4A5568; line-height:1.8; max-width:580px; }
  .ttpa-ed-surface[data-preview="founder"] p { margin:0 0 16px 0; }
  .ttpa-ed-surface[data-preview="mv"] { font-size:13.5px; color:#475569; line-height:1.65; max-width:430px; }
  .ttpa-ed-surface[data-preview="mv"] p { margin:0 0 10px 0; }

  .ttpa-ed-source-view { display:none; width:100%; box-sizing:border-box; border:none;
    border-top:1px solid var(--border); padding:16px 18px;
    font-family:ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
    font-size:12.5px; line-height:1.6; color:#0F172A; resize:vertical; min-height:200px; outline:none; }
  .ttpa-editor.is-source .ttpa-ed-surface { display:none; }
  .ttpa-editor.is-source .ttpa-ed-source-view { display:block; }
  .ttpa-ed-note { margin:0; padding:8px 12px; border-top:1px solid var(--border);
    background:#FBFCFD; color:#94A3B8; font-size:11.5px; border-radius:0 0 4px 4px; }
</style>
<script>
(function () {
  'use strict';

  document.querySelectorAll('.ttpa-editor').forEach(function (wrap) {
    var surface = wrap.querySelector('.ttpa-ed-surface');
    var input   = wrap.querySelector('.ttpa-ed-input');
    var toolbar = wrap.querySelector('.ttpa-ed-toolbar');
    if (!surface || !input || !toolbar) return;

    if (surface.innerHTML.trim() === '') surface.innerHTML = '<p><br></p>';

    var source = document.createElement('textarea');
    source.className = 'ttpa-ed-source-view';
    source.setAttribute('spellcheck', 'false');
    surface.parentNode.insertBefore(source, surface.nextSibling);

    try { document.execCommand('defaultParagraphSeparator', false, 'p'); } catch (e) {}
    try { document.execCommand('styleWithCSS', false, false); } catch (e) {}

    function sync() {
      if (wrap.classList.contains('is-source')) surface.innerHTML = source.value;
      input.value = surface.innerHTML;
    }

    function refreshState() {
      toolbar.querySelectorAll('.ttpa-ed-btn[data-cmd]').forEach(function (b) {
        var c = b.getAttribute('data-cmd');
        if (c === 'ttpLink' || c === 'unlink' || c === 'undo' || c === 'redo' ||
            c === 'removeFormat' || c === 'formatBlock') return;
        var on = false;
        try { on = document.queryCommandState(c); } catch (e) {}
        b.classList.toggle('is-active', on);
      });
    }

    toolbar.addEventListener('click', function (e) {
      var btn = e.target.closest('.ttpa-ed-btn');
      if (!btn) return;
      e.preventDefault();

      if (btn.classList.contains('ttpa-ed-source')) {
        if (wrap.classList.contains('is-source')) {
          surface.innerHTML = source.value;
          wrap.classList.remove('is-source');
          surface.focus();
        } else {
          source.value = surface.innerHTML;
          wrap.classList.add('is-source');
          source.focus();
        }
        btn.classList.toggle('is-active');
        sync();
        return;
      }

      if (wrap.classList.contains('is-source')) return;
      surface.focus();

      var cmd = btn.getAttribute('data-cmd');
      if (cmd === 'ttpLink') {
        var url = window.prompt('Bağlantı adresi (https://... veya /sayfa.php):', 'https://');
        if (url) document.execCommand('createLink', false, url.trim());
      } else if (cmd === 'formatBlock') {
        document.execCommand('formatBlock', false, btn.getAttribute('data-val'));
      } else {
        document.execCommand(cmd, false, null);
      }
      sync();
      refreshState();
    });

    surface.addEventListener('keyup', refreshState);
    surface.addEventListener('mouseup', refreshState);
    surface.addEventListener('input', sync);
    source.addEventListener('input', sync);

    surface.addEventListener('paste', function (e) {
      e.preventDefault();
      var data = e.clipboardData || window.clipboardData;
      var text = data ? data.getData('text/plain') : '';
      var html = (text || '').split(/\n{2,}/).map(function (block) {
        var esc = block.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        return '<p>' + esc.replace(/\n/g, '<br>') + '</p>';
      }).join('');
      document.execCommand('insertHTML', false, html);
      sync();
    });

    var form = wrap.closest('form');
    if (form) form.addEventListener('submit', sync);

    sync();
  });
})();
</script>
<?php
}

