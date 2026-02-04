<template>
  <div>
    <h2 class="text-3xl font-bold">
      Profil de {{ username }}
    </h2>
  </div>
</template>

<script setup lang="ts">
import { useRoute } from 'vue-router'

const route = useRoute()
const username = route.params.username as string
</script>
