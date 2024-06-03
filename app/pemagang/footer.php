<script src="../../index.js"></script>

<!-- Show All/Less -->
<script>
  const showAllLink = document.querySelector('.show-all-link');
  const showLessLink = document.querySelector('.show-less-link');
  const remainingRows = document.querySelectorAll('.remaining-row');

  showAllLink.addEventListener('click', () => {
    showAllLink.style.display = 'none';
    showLessLink.style.display = 'block';

    document.querySelector('#example1').classList.add('show-all-rows');
  });
  showLessLink.addEventListener('click', () => {
    showAllLink.style.display = 'block';
    showLessLink.style.display = 'none';

    document.querySelector('#example1').classList.remove('show-all-rows');
  });
</script>

<!-- Buttons -->
<script>
  const backBtn = document.querySelector('.back-button');
  backBtn.addEventListener('click', () => {
    window.history.back();
  })
</script>

<!-- Modals -->
<script>
  const plusButton = document.querySelector('.plusButton');
  const modal = document.querySelector('.modal');
  const closeButton = document.querySelector('.close-button');


  plusButton.addEventListener('click', () => {
    modal.style.display = 'flex';
    modal.style.opacity = '1';
    modal.style.visibility = 'visible';
  });

  closeButton.addEventListener('click', () => {
    modal.style.opacity = '0';
    modal.style.visibility = 'hidden';
  });

  window.addEventListener('click', (event) => {
    if (event.target === modal) {
      modal.style.opacity = '0';
      modal.style.visibility = 'hidden';
    }
  });

  window.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      modal.style.opacity = '0';
      modal.style.visibility = 'hidden';
    }
  });
</script>

<!-- Select2 -->
<script>
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
  });
</script>

<!-- Preloader -->
<script>
  const loader = document.getElementById('preloader');
  setTimeout(() => {
    loader.style.display = 'none';
  }, 1250);

  // Hide the page loader when the page is fully loaded
  // window.addEventListener('load', () => {
  //     loader.style.display = 'none';
  // });

  // setTimeout(() => {
  //       const preloader = document.getElementById('preloader');
  //       preloader.classList.add('hide');
  //       preloader.addEventListener('animationend', () => {
  //           preloader.style.display = 'none';
  //       });
  //   }, 1000);
</script>

<!-- Logout -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const logoutLink = document.getElementById('logout-link');

    logoutLink.addEventListener('click', function(event) {
      event.preventDefault();

      Swal.fire({
        title: 'Apakah Anda yakin ingin keluar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, keluar!',
        cancelButtonText: 'Batal',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = '../../conf/logout.php';
        }
      });
    });
  });
</script>