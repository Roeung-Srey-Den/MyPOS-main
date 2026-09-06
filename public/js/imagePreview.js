// ---------------------------Image preview
document.addEventListener('DOMContentLoaded', () => {
  const imageInput = document.getElementById('imageInput');
  const previewImage = document.getElementById('previewImage');
  
  imageInput.onchange = e => {
    previewImage.src = URL.createObjectURL(e.target.files[0]);
    previewImage.classList.remove('d-none');
  };
});
// function addToCart(){
// var cart = document.getElementById("cart");
// cart.innerHTML += '<div class="cart">1 Nom Banh Juk 0.75c <i class="fa-solid fa-xmark px-5" ></i></div>';
// }

$(document).ready(function() {
  $('#menu-toggle').on('click', function(e) {
    e.stopPropagation();
    $('#sidebar-nav').toggleClass('active');
  });

  // Clicking anywhere else closes sidebar
  $(document).on('click touchstart', function(e) {
    const sidebar = $('#sidebar-nav');
    const toggleBtn = $('#menu-toggle');
    

    if (sidebar.hasClass('active') && 
        !sidebar.is(e.target) && 
        sidebar.has(e.target).length === 0 &&
        !toggleBtn.is(e.target) &&
        toggleBtn.has(e.target).length === 0) {
      sidebar.removeClass('active');
    }
  });
});