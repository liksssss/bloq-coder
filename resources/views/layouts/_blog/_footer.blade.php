<footer class="py-5 mt-auto" style="background: #7EA1FF; position: relative;">
   <div class="container">
       <p class="m-0 text-center text-dark">Copyright &copy;2024 bloqcoder</p>
   </div>
   <!-- Tombol kembali ke atas -->
   <div style="position: absolute; bottom: 20px; right: 20px;">
      <button onclick="scrollToTop()" class="btn btn-primary rounded-circle" style="width: 40px; height: 40px;">
         <i class="fas fa-arrow-up"></i>
     </button>
   </div>
</footer>

<style>
/* CSS untuk responsif tombol */
@media only screen and (max-width: 768px) {
    .btn-primary.rounded-circle {
        width: 30px;
        height: 30px;
        font-size: 12px;
    }
}
</style>

<script>
   // Fungsi untuk animasi scroll ke atas
   function scrollToTop() {
       // Jarak maksimum untuk animasi scroll
       const scrollStep = -window.scrollY / (500 / 15);

       // Animasi scroll ke atas
       const scrollInterval = setInterval(function(){
           if (window.scrollY !== 0) {
               window.scrollBy(0, scrollStep);
           } else {
               clearInterval(scrollInterval);
           }
       }, 15);
   }
</script>
