 <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
    crossorigin="anonymous"></script>

  <!-- Search Bar Expand Script -->
  <script>
    const searchBox = document.getElementById('searchBox');
    let input = searchBox.querySelector('input');
    let timeout;

    searchBox.addEventListener('mouseenter', () => {
      clearTimeout(timeout);
      searchBox.classList.add('expanded');
      input.focus();
    });

    searchBox.addEventListener('mouseleave', () => {
      timeout = setTimeout(() => {
        searchBox.classList.remove('expanded');
        input.blur();
      }, 1500);
    });
  </script>