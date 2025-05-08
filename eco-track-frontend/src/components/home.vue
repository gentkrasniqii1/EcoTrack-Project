<template>
    <div>
      <!-- NavbarComponent imported from components -->
      <NavbarComponent />
  
      <!-- Hero Section -->
      <section class="hero-section d-flex align-items-end">
        <div class="hero-overlay"></div>
        <div class="container position-relative">
          <div class="row justify-content-end">
            <div class="col-lg-6 text-white text-end mb-5">
              <h1 class="display-4 fw-bold mb-3">
                Mirësevjen në <span class="text-success">Eco Track </span>
              </h1>
              <p class="lead mb-4">
                Monitoro, menaxho dhe zvogëlo ndikimin tënd në mjedis.
              </p>
              <router-link to="/track-waste" class="btn btn-success btn-lg">
                Track Waste Now
              </router-link>
            </div>
          </div>
        </div>
      </section>
  
      <!-- Carousel Section -->
      <section class="carousel-section">
        <div class="carousel-header">
          <h2>♻️ Eco Tips Carousel</h2>
          <p>Zbulo këshilla të thjeshta për një jetë më të qëndrueshme dhe të gjelbër.</p>
        </div>
  
        <div class="carousel-3d-wrapper">
          <div class="carousel-3d" ref="carousel">
            <img v-for="(img, index) in images" :key="index" :src="img" :alt="`Tip ${index + 1}`" />
          </div>
          <div class="carousel-controls">
            <button @click="rotateCarousel(-1)">❮</button>
            <button @click="rotateCarousel(1)">❯</button>
          </div>
        </div>
      </section>
  
      <!-- Postcard Section -->
      <section class="container my-5">
        <div class="row text-center">
          <div v-for="card in cards" :key="card.title" class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
              <div class="card-body">
                <i :class="card.icon + ' fa-2x mb-3'" :style="{ color: card.color }"></i>
                <h5 class="card-title">{{ card.title }}</h5>
                <p class="card-text">{{ card.text }}</p>
                <router-link :to="card.link" class="btn btn-outline-success">{{ card.button }}</router-link>
              </div>
            </div>
          </div>
        </div>
      </section>
  
      <!-- Contact Section -->
      <section class="bg-light py-5" id="contact">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-6 mb-4">
              <h3 class="text-success fw-bold mb-4">Na Kontakto</h3>
              <p class="mb-4">Keni pyetje, sugjerime apo dëshironi të bashkëpunoni me ne?</p>
              <ul class="list-unstyled">
                <li class="mb-3"><i class="fas fa-phone text-success me-2"></i> +355 69 000 0000</li>
                <li class="mb-3"><i class="fas fa-envelope text-success me-2"></i> info@ecotrack.com</li>
                <li><i class="fas fa-map-marker-alt text-success me-2"></i> Tirana, Albania</li>
              </ul>
            </div>
  
            <div class="col-md-6">
              <form @submit.prevent="sendContact">
                <input type="text" v-model="form.name" class="form-control shadow-sm mb-3" placeholder="Emri juaj" required>
                <input type="email" v-model="form.email" class="form-control shadow-sm mb-3" placeholder="Email adresa" required>
                <textarea v-model="form.message" class="form-control shadow-sm mb-3" rows="5" placeholder="Mesazhi juaj..." required></textarea>
                <button type="submit" class="btn btn-success w-100">Dërgo Mesazh</button>
                <div v-if="messageSent" class="alert alert-success mt-3">Faleminderit për kontaktin!</div>
              </form>
            </div>
          </div>
        </div>
      </section>
  
      <!-- Footer -->
      <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container text-md-start text-center">
          <div class="row">
            <div class="col-md-4 mb-4">
              <h5 class="text-success fw-bold">EcoTrack</h5>
              <p>Ne ndihmojmë komunitetet të monitorojnë ndikimin e tyre në mjedis.</p>
            </div>
            <div class="col-md-4 mb-4">
              <h6 class="text-uppercase fw-bold">Linke të shpejtë</h6>
              <ul class="list-unstyled">
                <li><router-link to="/">Home</router-link></li>
                <li><router-link to="/track-waste">Track Waste</router-link></li>
                <li><router-link to="/statistics">Statistics</router-link></li>
                <li><router-link to="/contact">Contact</router-link></li>
              </ul>
            </div>
            <div class="col-md-4 mb-4">
              <h6 class="text-uppercase fw-bold">Na ndiqni</h6>
              <div class="d-flex justify-content-md-start justify-content-center">
                <i class="fab fa-facebook-f me-3"></i>
                <i class="fab fa-twitter me-3"></i>
                <i class="fab fa-instagram me-3"></i>
                <i class="fab fa-linkedin-in"></i>
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
  import NavbarComponent from '@/components/NavbarComponent.vue';
  
  export default {
    name: 'LandingPageView',
    components: {
      NavbarComponent
    },
    data() {
      return {
        images: [
          'carousel_ready_1.png',
          'carousel_ready_2.png',
          'carousel_ready_3.png',
          'carousel_ready_4.png',
          'carousel_ready_5.png'
        ],
        angle: 0,
        form: {
          name: '',
          email: '',
          message: ''
        },
        messageSent: false,
        cards: [
          {
            icon: 'fas fa-leaf',
            color: '#28a745',
            title: 'Track Waste',
            text: 'Regjistro mbeturinat ditore dhe gjurmo impaktin tënd në kohë reale.',
            button: 'Shiko më shumë',
            link: '/track-waste'
          },
          {
            icon: 'fas fa-lightbulb',
            color: '#ffc107',
            title: 'Eco Tips',
            text: 'Këshilla praktike për të jetuar në mënyrë më të qëndrueshme çdo ditë.',
            button: 'Mëso më shumë',
            link: '/tips'
          },
          {
            icon: 'fas fa-chart-line',
            color: '#0d6efd',
            title: 'Statistics',
            text: 'Analizo të dhënat dhe përmirëso performancën mjedisore.',
            button: 'Shiko statistikat',
            link: '/statistics'
          }
        ]
      };
    },
    methods: {
      rotateCarousel(direction) {
        const step = 360 / this.images.length;
        this.angle += direction * step;
        this.$refs.carousel.style.transform = `rotateY(${this.angle}deg)`;
      },
      sendContact() {
        this.messageSent = true;
        this.form = { name: '', email: '', message: '' };
      }
    }
  };
  </script>
  
  <style scoped>
  /* You can paste CSS here or import from a shared file */
  </style>
  