<template>
    <section class="py-5" id="tips">
      <div class="container">
        <h2 class="text-center section-title mb-4">
          <i class="fas fa-lightbulb text-warning me-2"></i>Këshilla Eco-Friendly
        </h2>
  
        <div class="text-center mb-4">
          <button class="btn btn-outline-success m-1" @click="filterCategory('all')">Të gjitha</button>
          <button class="btn btn-outline-primary m-1" @click="filterCategory('daily')">Të përditshme</button>
          <button class="btn btn-outline-warning m-1" @click="filterCategory('home')">Në shtëpi</button>
          <button class="btn btn-outline-info m-1" @click="filterCategory('energy')">Energji</button>
          <button class="btn btn-outline-success m-1" @click="filterCategory('recycle')">Riciklim</button>
        </div>
  
        <div class="row">
          <div v-for="(tip, index) in filteredTips" :key="index" class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 text-center">
              <div class="card-body">
                <i :class="tip.icon + ' mb-3'" :style="{ color: tip.color }"></i>
                <h5 class="card-title">{{ tip.title }}</h5>
                <p class="card-text">{{ tip.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </template>
  
  <script>
  export default {
    name: 'TipsView',
    data() {
      return {
        currentCategory: 'all',
        tips: [
          { category: 'recycle', icon: 'fas fa-recycle', color: '#28a745', title: 'Përdor sende të ripërdorshme', description: 'Zëvendëso shishet plastike me ato metalike ose qelqi.' },
          { category: 'daily', icon: 'fas fa-shopping-bag', color: '#ffc107', title: 'Mbaj çantë prej cope', description: 'Shmang qeset plastike duke marrë gjithmonë një çantë tekstili.' },
          { category: 'home', icon: 'fas fa-compost', color: '#795548', title: 'Komposto mbetjet ushqimore', description: 'Krijo kompost nga mbetjet e frutave dhe perimeve.' },
          { category: 'energy', icon: 'fas fa-bolt', color: '#17a2b8', title: 'Kurse energjinë', description: 'Fike dritat dhe pajisjet që nuk i përdor.' },
          { category: 'home', icon: 'fas fa-water', color: '#007bff', title: 'Ruaj ujin', description: 'Mos lër çezmën hapur kur lan dhëmbët dhe përdor ujë me kursim.' },
          { category: 'daily', icon: 'fas fa-tree', color: '#28a745', title: 'Mbjell një pemë', description: 'Një pemë absorbon deri në 22 kg CO₂ në vit.' }
        ]
      };
    },
    computed: {
      filteredTips() {
        if (this.currentCategory === 'all') return this.tips;
        return this.tips.filter(tip => tip.category === this.currentCategory);
      }
    },
    methods: {
      filterCategory(category) {
        this.currentCategory = category;
      }
    }
  };
  </script>
  
  <style scoped>
  /* Përfshi stilizimet nga style.css për kartat dhe filtrat */
  </style>
  