@extends('layouts.master')

@section('content')

<section id="about-klinik" class="about-klinik mb-5">
    <div class="container about-container pad-50">
        <div class="row justify-content-center">
            <div class="col-6 col-lg-6">
                <img src="{{ asset('gambar/Pet Clin.jpg') }}" alt="About Us Image" class="img-fluid heart float-lg-end">
            </div>
            <div class="col-12 col-lg-6 mt-lg-3">
                <h6 class="ms-4">CERITA KAMI</h6>
                <h2 class="text-danger ms-4 mb-3">Tentang Klinik Sahabat Hewan</h2>
                <div class="container justify">
                    <p class="my-4">
                        Klinik Sahabat Hewan, tempat di mana cinta, kepedulian, dan keahlian bertemu untuk menciptakan pengalaman perawatan 
                        hewan yang luar biasa. Cerita kami dimulai dengan visi sederhana yaitu memberikan layanan kesehatan hewan terbaik yang menggabungkan keahlian 
                        medis dengan sentuhan hangat dan perhatian penuh kasih.
                    </p>
                    <p class="my-4">
                        Didirikan oleh drh. Muammar Khadafi pada tahun 2015, Klinik Sahabat Hewan terus bertumbuh menjadi tempat yang tidak hanya
                        menyediakan layanan kesehatan untuk hewan peliharaan, tetapi juga menciptakan ikatan emosional dengan setiap hewan yang dilayani.
                        Setiap anggota tim kami tidak hanya ahli dalam bidangnya masing-masing, tetapi juga memiliki dedikasi tinggi terhadap hewan-hewan yang menjadi bagian dari keluarga Anda.
                    </p>
                    <p class="my-4">
                        Kami akan terus memperbaiki dan meningkatkan pemberian layanan kesehatan untuk hewan peliharaan Anda. Karena kami sadar bahwa pelanggan
                        kami yang merupakan pemilik, pecinta, serta partner hewan berhak untuk mendapatkan pelayanan terbaik bagi hewan peliharaan tersayang yang
                        mereka miliki. 
                    </p>
                    <p class="my-4">
                        Selalu ingat bahwa Klinik Sahabat Hewan merawat hewanmu seperti hewan kami sendiri.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section><!-- End About-klinik Section -->

<section id="achieve" class="achieve mb-5">
    <div class="container achieve-content">
        <div class="row justify-content-center bg-op py-5">
            <h5>Terima Kasih</h5>
            <h2>Atas Kepercayaan yang Anda berikan kepada Kami</h2>
            <div class="col-lg-8 d-flex align-items-stretch">
                <div class="icon-boxes d-flex flex-column justify-content-center">
                    <div class="row justify-content-center">
                        <div class="col-8 col-sm-8 col-md-4 col-lg-4 col-xl-4 d-flex align-items-stretch">
                            <div class="icon-box mt-4 mt-xl-0">
                                <div class="square-shape mx-auto">
                                    <i class="fa fa-birthday-cake"></i>
                                </div>
                                <h1 id="count1" class="hidden">0</h1>
                                <h5>Tahun Bersama Untuk Hewan Peliharaan</h5>
                            </div>
                        </div>
                        <div class="col-8 col-sm-8 col-md-4 col-lg-4 col-xl-4 d-flex align-items-stretch">
                            <div class="icon-box mt-4 mt-xl-0">
                                <div class="square-shape mx-auto">
                                    <i class="fa-solid fa-dog"></i>
                                </div>
                                <h1 id="count2"  class="hidden">0+</h1>
                                <h5>Pasien Telah Mendapatkan Layanan Terbaik</h5>
                            </div>
                        </div>
                        <div class="col-8 col-sm-8 col-md-4 col-lg-4 col-xl-4 d-flex align-items-stretch">
                            <div class="icon-box mt-4 mt-xl-0">
                                <div class="square-shape mx-auto">
                                    <i class="fa fa-star"></i>
                                </div>
                                <h1 id="count3" class="hidden">0+</h1>
                                <h5>Testimoni Dari Pemilik Hewan di Google Review</h5>
                            </div>
                        </div>
                    </div>
                </div><!-- End .content-->
            </div>
        </div>
    </div>
</section><!-- End achieve Section -->

<!-- ======= Services Section ======= -->
<section id="gallery" class="gallery">
    <div class="container">
        <div class="section-title">
            <h2>Galeri</h2>
            <p>
                Di sini, kami membagikan momen-momen istimewa dan pengalaman luar biasa yang telah terjadi di klinik kami.
            </p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="icon-box">
                    <img src="{{ asset('gambar/shiba.jpg') }}" alt="Card Image" class="icon-box-img" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="updateModalImage('{{ asset('gambar/shiba.jpg') }}')">
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mt-4 mt-md-0">
                <div class="icon-box">
                    <img src="{{ asset('gambar/Corgi.jpg') }}" alt="Card Image" class="icon-box-img" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="updateModalImage('{{ asset('gambar/Corgi.jpg') }}')">
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">
                <div class="icon-box">
                    <img src="{{ asset('gambar/Richie.jpg') }}" alt="Card Image" class="icon-box-img" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="updateModalImage('{{ asset('gambar/Richie.jpg') }}')">
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mt-4 video-container">
                <div class="icon-box">
                    <video width="100%" height="100%" controls>
                        <source src="/video/Pet Clinic.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mt-4 video-container">
                <div class="icon-box">
                    <video width="100%" height="100%" controls>
                        <source src="/video/Pet Grooming.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mt-4 video-container">
                <div class="icon-box">
                    <video width="100%" height="100%" controls>
                        <source src="/video/Pet Hotel.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Gambar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="" id="zoomedImg" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- End Services Section -->


<script src="https://cdn.jsdelivr.net/npm/countup.js@2.0.7/dist/countUp.min.js"></script>

<script>
    function updateModalImage(imgSrc) {
        document.getElementById('zoomedImg').src = imgSrc;
    }
</script>

<script>
    var videos = document.querySelectorAll('.video-container video');

    function handleFullscreenChange(video) {
        return function () {
            var isFullscreen =
                document.fullscreenElement ||
                document.mozFullScreenElement ||
                document.webkitFullscreenElement;

            if (isFullscreen) {
                video.closest('.icon-box').style.overflow = 'hidden';
                video.style.objectFit = 'contain';
            } else {
                video.closest('.icon-box').style.overflow = 'visible';
                video.style.objectFit = 'cover';
            }
        };
    }

    videos.forEach(function (video) {
        video.addEventListener('fullscreenchange', handleFullscreenChange(video));
    });
</script>

<script>
    // Function to perform counting up animation
    function countUpAnimation(elementId, startValue, endValue, duration, addPlus) {
      let currentCount = startValue;
      const element = document.getElementById(elementId);

      // Calculate the increment value based on duration
      const increment = (endValue - startValue) / (duration / 100);

      // Use setInterval to update the count
      const intervalId = setInterval(function () {
        currentCount += increment;

        // Update the element text content with formatted number
        element.textContent = Math.round(currentCount).toLocaleString();

        // Check if we've reached or exceeded the end value
        if (currentCount >= endValue) {
          // Set the final value and clear the interval
          element.textContent = addPlus ? endValue.toLocaleString() + '+' : endValue.toLocaleString();
          clearInterval(intervalId);
        }
      }, 100);
    }


    // Function to check if an element is in the viewport
    function isElementInViewport(el) {
      const rect = el.getBoundingClientRect();
      return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
      );
    }

    // Function to handle scroll events
    function handleScroll() {
      const count1 = document.getElementById('count1');
      const count2 = document.getElementById('count2');
      const count3 = document.getElementById('count3');

      // Check if the elements are in the viewport and animation hasn't been triggered
      if (isElementInViewport(count1) && !count1.classList.contains('visible')) {
        count1.classList.add('visible');
        countUpAnimation('count1', 1, 9, 2500, false);
      }

      if (isElementInViewport(count2) && !count2.classList.contains('visible')) {
        count2.classList.add('visible');
        countUpAnimation('count2', 1, 25000, 2500, true);
      }

      if (isElementInViewport(count3) && !count3.classList.contains('visible')) {
        count3.classList.add('visible');
        countUpAnimation('count3', 1, 1400, 2500, true);
      }
    }

    // Attach scroll event listener
    window.addEventListener('scroll', handleScroll);

    // Initial check on page load
    handleScroll();
  </script>

@endsection