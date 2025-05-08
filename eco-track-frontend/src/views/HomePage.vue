<template>
  <div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white sticky-top">
      <div class="container">
        <a class="navbar-brand" href="#">EcoTrack</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#ecoNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="ecoNavbar">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="fas fa-home"></i> Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="fas fa-leaf"></i> Track Waste</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="fas fa-chart-line"></i> Statistics</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="fas fa-lightbulb"></i> Tips</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="fas fa-envelope"></i> Contact</a>
            </li>

            <!-- Profile dropdown -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-user-circle"></i> Profile
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">My Account</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
              </ul>
            </li>

          </ul>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-end">
      <div class="hero-overlay"></div>
      <div class="container position-relative">
        <div class="row justify-content-end">
          <div class="col-lg-6 text-white text-end mb-5" data-aos="fade-left">
            <h1 class="display-4 fw-bold mb-3">
              Mirësevjen në <span class="text-success">Eco Track 🌿</span>
            </h1>
            <p class="lead mb-4">
              Monitoro, menaxho dhe zvogëlo ndikimin tënd në mjedis.
            </p>
            <a href="#track" class="btn btn-success btn-lg" data-aos="zoom-in" data-aos-delay="200">
              Track Waste Now
            </a>
          </div>
        </div>
      </div>
    </section>

   <!-- Carousel Section -->
<section class="container my-5" data-aos="fade-up" data-aos-delay="100">
  <div id="ecoCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner rounded-4 shadow-sm">
      <div class="carousel-item active">
        <img src="@/assets/carousel_ready_1.png" class="d-block w-100" alt="Eco Image 1">
      </div>
      <div class="carousel-item">
        <img src="@/assets/carousel_ready_2.png" class="d-block w-100" alt="Eco Image 2">
      </div>
      <div class="carousel-item">
        <img src="@/assets/carousel_ready_3.png" class="d-block w-100" alt="Eco Image 3">
      </div>
      <div class="carousel-item">
        <img src="@/assets/carousel_ready_4.png" class="d-block w-100" alt="Eco Image 4">
      </div>
      <div class="carousel-item">
        <img src="@/assets/carousel_ready_5.png" class="d-block w-100" alt="Eco Image 5">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#ecoCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#ecoCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</section>

    <!-- Postcards Section -->
    <section class="container my-5">
      <div class="row text-center">
        <!-- Card 1 -->
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <i class="fas fa-leaf fa-2x text-success mb-3"></i>
              <h5 class="card-title">Track Waste</h5>
              <p class="card-text">Regjistro mbeturinat ditore dhe gjurmo impaktin tënd në kohë reale.</p>
              <a href="#" class="btn btn-outline-success">Shiko më shumë</a>
            </div>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <i class="fas fa-lightbulb fa-2x text-warning mb-3"></i>
              <h5 class="card-title">Eco Tips</h5>
              <p class="card-text">Këshilla praktike për të jetuar në mënyrë më të qëndrueshme çdo ditë.</p>
              <a href="#" class="btn btn-outline-success">Mëso më shumë</a>
            </div>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <i class="fas fa-chart-line fa-2x text-primary mb-3"></i>
              <h5 class="card-title">Statistics</h5>
              <p class="card-text">Analizo të dhënat e tua dhe përmirëso performancën mjedisore.</p>
              <a href="#" class="btn btn-outline-success">Shiko statistikat</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section class="bg-light py-5" id="contact">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6 mb-4" data-aos="fade-right">
            <h3 class="text-success fw-bold mb-4">Na Kontakto</h3>
            <p class="mb-4">Keni pyetje, sugjerime apo dëshironi të bashkëpunoni me ne? Na shkruani dhe do t'ju përgjigjemi sa më shpejt.</p>
            <ul class="list-unstyled">
              <li class="mb-3"><i class="fas fa-phone text-success me-2"></i> +355 69 000 0000</li>
              <li class="mb-3"><i class="fas fa-envelope text-success me-2"></i> info@ecotrack.com</li>
              <li><i class="fas fa-map-marker-alt text-success me-2"></i> Tirana, Albania</li>
            </ul>
          </div>

          <div class="col-md-6" data-aos="fade-left">
            <form>
              <div class="mb-3">
                <input type="text" class="form-control shadow-sm" placeholder="Emri juaj" required>
              </div>
              <div class="mb-3">
                <input type="email" class="form-control shadow-sm" placeholder="Email adresa" required>
              </div>
              <div class="mb-3">
                <textarea class="form-control shadow-sm" rows="5" placeholder="Mesazhi juaj..." required></textarea>
              </div>
              <button type="submit" class="btn btn-success w-100">Dërgo Mesazh</button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4" data-aos="fade-up">
      <div class="container text-md-start text-center">
        <div class="row">
          <div class="col-md-4 mb-4">
            <h5 class="text-success fw-bold">EcoTrack 🌿</h5>
            <p>Ne ndihmojmë komunitetet të monitorojnë ndikimin e tyre në mjedis dhe të marrin hapa të qëndrueshëm.</p>
          </div>

          <div class="col-md-4 mb-4">
            <h6 class="text-uppercase fw-bold">Linke të shpejtë</h6>
            <ul class="list-unstyled">
              <li><a href="#" class="text-white text-decoration-none d-block py-1">Home</a></li>
              <li><a href="#" class="text-white text-decoration-none d-block py-1">Track Waste</a></li>
              <li><a href="#" class="text-white text-decoration-none d-block py-1">Statistics</a></li>
              <li><a href="#" class="text-white text-decoration-none d-block py-1">Contact</a></li>
            </ul>
          </div>

          <div class="col-md-4 mb-4">
            <h6 class="text-uppercase fw-bold">Na ndiqni</h6>
            <div class="d-flex justify-content-md-start justify-content-center">
              <a href="#" class="me-3 text-white fs-5 social-icon"><i class="fab fa-facebook-f"></i></a>
              <a href="#" class="me-3 text-white fs-5 social-icon"><i class="fab fa-twitter"></i></a>
              <a href="#" class="me-3 text-white fs-5 social-icon"><i class="fab fa-instagram"></i></a>
              <a href="#" class="text-white fs-5 social-icon"><i class="fab fa-linkedin-in"></i></a>
            </div>
          </div>
        </div>

        <hr class="border-light">
        <div class="text-center">
          <small>&copy; 2025 EcoTrack. Të gjitha të drejtat e rezervuara.</small>
        </div>
      </div>
    </footer>

  </div>
</template>

<script>
import AOS from 'aos';
import 'aos/dist/aos.css';

export default {
  name: 'EcoTrackHome',
  mounted() {
    AOS.init({
      once: true,
      duration: 800,
    });
  }
};
</script>

<style scoped>
/* Your same style from the <style> tag in HTML file */
</style>
