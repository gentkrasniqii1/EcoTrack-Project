<template>
    <section class="py-5" id="contact">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6 mb-4">
            <h3 class="text-success fw-bold mb-4">Na Kontakto</h3>
            <p class="mb-4">Keni pyetje, sugjerime apo dëshironi të bashkëpunoni me ne? Na shkruani dhe do t'ju përgjigjemi sa më shpejt.</p>
            <ul class="list-unstyled">
              <li class="mb-3"><i class="fas fa-phone text-success me-2"></i> +355 69 000 0000</li>
              <li class="mb-3"><i class="fas fa-envelope text-success me-2"></i> info@ecotrack.com</li>
              <li><i class="fas fa-map-marker-alt text-success me-2"></i> Tirana, Albania</li>
            </ul>
          </div>
  
          <div class="col-md-6">
            <form @submit.prevent="submitForm">
              <div class="mb-3">
                <input v-model="form.name" type="text" class="form-control shadow-sm" placeholder="Emri juaj" required>
              </div>
              <div class="mb-3">
                <input v-model="form.email" type="email" class="form-control shadow-sm" placeholder="Email adresa" required>
              </div>
              <div class="mb-3">
                <textarea v-model="form.message" class="form-control shadow-sm" rows="5" placeholder="Mesazhi juaj..." required></textarea>
              </div>
              <button type="submit" class="btn btn-success w-100">Dërgo Mesazh</button>
              <div class="alert alert-success mt-3" v-if="confirmationMessage">
                {{ confirmationMessage }}
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </template>
  
  <script>
  export default {
    name: 'ContactView',
    data() {
      return {
        form: {
          name: '',
          email: '',
          message: ''
        },
        confirmationMessage: ''
      };
    },
    methods: {
      submitForm() {
        // Këtu mund të shtosh thirrje API ose integrim backend
        this.confirmationMessage = `Faleminderit ${this.form.name}, mesazhi juaj u dërgua me sukses!`;
        this.form = { name: '', email: '', message: '' };
      }
    }
  };
  </script>
  
  <style scoped>
  /* Stilet e formës mund të sillen nga style.css ose të përfshihen këtu */
  </style>
  