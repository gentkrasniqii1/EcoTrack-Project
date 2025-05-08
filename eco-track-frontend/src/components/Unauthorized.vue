<template>
  <div class="unauthorized">
    <h2>⛔ Akses i ndaluar</h2>
    <p>Ju nuk keni të drejtë të shikoni këtë faqe.</p>
    <router-link to="/">Kthehu në faqen kryesore</router-link>
  </div>
</template>

<script>
export default {
  name: 'Unauthorized'
};
</script>

<style scoped>
.unauthorized {
  text-align: center;
  padding: 60px 20px;
}
</style>
