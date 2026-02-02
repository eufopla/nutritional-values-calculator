<template>
  <div class="min-h-screen bg-gray-900 text-white">
    <header class="p-4 border-b border-gray-800">
      <h1 class="text-xl font-bold">Social Network</h1>
    </header>

    <main class="p-6">
      <slot /> <!-- Ici passent les pages via router-view -->
    </main>
  </div>
</template>

<script setup lang="ts">
// rien de spécial pour l'instant
</script>

<style scoped>
/* optionnel : styles spécifiques du layout */
</style>
