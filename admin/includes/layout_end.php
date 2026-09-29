  </main>
</div>
<script>
  // Dosya seçme alanları: seçilen dosyanın adını butonun yanında Türkçe göster.
  // (Bkz. helpers.php → file_field(); CSS layout_start.php içinde.)
  document.addEventListener('change', function (e) {
    var input = e.target;
    if (!input.classList || !input.classList.contains('ttpa-file-input')) return;
    var wrap = input.closest('.ttpa-file');
    var label = wrap ? wrap.querySelector('.ttpa-file-name') : null;
    if (!label) return;
    if (input.files && input.files.length) {
      label.textContent = input.files.length > 1
        ? input.files.length + ' dosya seçildi'
        : input.files[0].name;
      label.classList.add('has-file');
    } else {
      label.textContent = 'Dosya seçilmedi';
      label.classList.remove('has-file');
    }
  });
</script>
</body>
</html>
