  <footer class="d-flex justify-content-between align-items-center py-3">

    <h6 class="text-start ps-5 animate__animated animate__fadeInLeft">&copy;Raven</h6>

    <!-- Switch button toggle -->
      <div class="form-check form-switch pe-5 animate__animated animate__fadeInRight">
        <input class="form-check-input" type="checkbox" id="themeSwitch">
        <label class="form-check-label" for="themeSwitch">Theme Mode</label>
      </div>
    <!-- /Switch button toggle -->
      
  </footer>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous">
    </script>
    <script 
      src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous">
    </script>
    <!-- Toggle theme -->
    <script>
      document.getElementById('themeSwitch').addEventListener('change', function() {
        // Get the current theme from the data attribute
        const currentTheme = document.documentElement.getAttribute('data-bs-theme');
        
        // Toggle between dark and light theme
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        // Set the new theme on the html element
        document.documentElement.setAttribute('data-bs-theme', newTheme);
        
        // Update the navbar theme
        const navbar = document.getElementById('themeNavbar');
        if (newTheme === 'dark') {
          navbar.classList.remove('navbar-light', 'bg-primary');
          navbar.classList.add('navbar-dark', 'bg-secondary');
        } else {
          navbar.classList.remove('navbar-dark', 'bg-secondary');
          navbar.classList.add('navbar-light', 'bg-primary');
        }

        // Mengubah table header style sesuai dengan theme
        const tableHeaders = document.querySelectorAll('table thead th');
        if (newTheme === 'dark') {
          tableHeaders.forEach(th => {
            th.classList.remove('text-dark', 'bg-primary');
            th.classList.add('text-light', 'bg-secondary');
          });
        } else {
          tableHeaders.forEach(th => {
            th.classList.remove('text-light', 'bg-secondary');
            th.classList.add('text-dark', 'bg-primary');
          });
        }

        // Update label text berdasarkan theme
        document.querySelector('.form-check-label').textContent = newTheme === 'dark' ? 'Light Mode' : 'Dark Mode';
      });
    </script>
  </body>
</html>