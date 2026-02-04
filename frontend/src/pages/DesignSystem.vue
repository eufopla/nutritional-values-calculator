<template>
  <div class="min-h-screen p-8">
    <div class="container-custom">
      <h1 class="text-4xl font-bold gradient-text mb-8 animate-fade-in">
        🎨 Design System - FutureSocial
      </h1>

      <!-- Colors Section -->
      <section class="mb-12 animate-slide-up">
        <h2 class="text-2xl font-semibold mb-6 text-glow">Palette de couleurs</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <!-- Primary -->
          <div class="card-compact">
            <div class="h-20 bg-primary-500 rounded-lg mb-2 shadow-glow"></div>
            <p class="text-sm font-medium">Primary</p>
            <p class="text-xs text-gray-400">#d946ef</p>
          </div>

          <!-- Secondary -->
          <div class="card-compact">
            <div class="h-20 bg-secondary-500 rounded-lg mb-2 shadow-glow-blue"></div>
            <p class="text-sm font-medium">Secondary</p>
            <p class="text-xs text-gray-400">#3b82f6</p>
          </div>

          <!-- Accent Cyan -->
          <div class="card-compact">
            <div class="h-20 bg-accent-cyan rounded-lg mb-2 shadow-glow-cyan"></div>
            <p class="text-sm font-medium">Cyan</p>
            <p class="text-xs text-gray-400">#06b6d4</p>
          </div>

          <!-- Purple -->
          <div class="card-compact">
            <div class="h-20 bg-accent-purple rounded-lg mb-2"></div>
            <p class="text-sm font-medium">Purple</p>
            <p class="text-xs text-gray-400">#8b5cf6</p>
          </div>
        </div>
      </section>

      <!-- Buttons Section -->
      <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-6 text-glow">Boutons</h2>
        
        <div class="flex flex-wrap gap-4">
          <button class="btn-primary">
            Bouton Principal
          </button>
          
          <button class="btn-secondary">
            Bouton Secondaire
          </button>
          
          <button class="btn-ghost">
            Bouton Ghost
          </button>
        </div>
      </section>

      <!-- Cards Section -->
      <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-6 text-glow">Cards</h2>
        
        <div class="grid md:grid-cols-2 gap-6">
          <!-- Card normale -->
          <div class="card">
            <h3 class="text-xl font-semibold mb-2">Card Standard</h3>
            <p class="text-gray-300 mb-4">
              Card avec effet glassmorphism et border glow au hover.
            </p>
            <button class="btn-primary">Action</button>
          </div>

          <!-- Card avec avatar -->
          <div class="card">
            <div class="flex items-center gap-3 mb-4">
              <div class="avatar w-12 h-12 bg-gradient-to-br from-primary-500 to-purple-600">
                <div class="w-full h-full flex items-center justify-center text-xl">
                  👤
                </div>
              </div>
              <div>
                <h3 class="font-semibold">Utilisateur</h3>
                <span class="badge">4.8 ⭐</span>
              </div>
            </div>
            <p class="text-gray-300">
              Card avec avatar et badge de notation.
            </p>
          </div>
        </div>
      </section>

      <!-- Tags Section -->
      <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-6 text-glow">Tags</h2>
        
        <div class="flex flex-wrap gap-2">
          <span class="tag-primary">🍳 Cuisine</span>
          <span class="tag-secondary">💬 Partage</span>
          <span class="tag-cyan">🎮 Gaming</span>
          <span class="tag tag border-orange-500/30 text-orange-300">
            🔥 Trending
          </span>
          <span class="tag tag border-green-500/30 text-green-300">
            ✅ Vérifié
          </span>
        </div>
      </section>

      <!-- Inputs Section -->
      <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-6 text-glow">Inputs</h2>
        
        <div class="max-w-md space-y-4">
          <input 
            type="text" 
            class="input" 
            placeholder="Email ou nom d'utilisateur"
          />
          
          <input 
            type="password" 
            class="input" 
            placeholder="Mot de passe"
          />
          
          <textarea 
            class="input min-h-[120px]" 
            placeholder="Écrivez votre message..."
          ></textarea>
        </div>
      </section>

      <!-- Effects Section -->
      <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-6 text-glow">Effets spéciaux</h2>
        
        <div class="grid md:grid-cols-3 gap-6">
          <!-- Glassmorphism -->
          <div class="glass p-6 rounded-xl">
            <h3 class="font-semibold mb-2">Glassmorphism</h3>
            <p class="text-sm text-gray-300">
              Effet de verre avec blur et transparence.
            </p>
          </div>

          <!-- Glow effect -->
          <div class="p-6 rounded-xl shadow-glow border border-primary-500/30">
            <h3 class="font-semibold mb-2">Glow Effect</h3>
            <p class="text-sm text-gray-300">
              Ombre lumineuse néon autour de l'élément.
            </p>
          </div>

          <!-- Gradient -->
          <div class="p-6 rounded-xl bg-gradient-cyberpunk">
            <h3 class="font-semibold mb-2">Gradient</h3>
            <p class="text-sm text-gray-300">
              Dégradé personnalisé cyberpunk.
            </p>
          </div>
        </div>
      </section>

      <!-- Animations Section -->
      <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-6 text-glow">Animations</h2>
        
        <div class="grid md:grid-cols-4 gap-4">
          <div class="card-compact text-center">
            <div class="w-16 h-16 mx-auto mb-3 bg-primary-500 rounded-full animate-pulse-slow"></div>
            <p class="text-sm">Pulse</p>
          </div>

          <div class="card-compact text-center">
            <div class="w-16 h-16 mx-auto mb-3 bg-secondary-500 rounded-full animate-glow"></div>
            <p class="text-sm">Glow</p>
          </div>

          <div class="card-compact text-center">
            <div class="w-16 h-16 mx-auto mb-3 bg-accent-purple rounded-full animate-float"></div>
            <p class="text-sm">Float</p>
          </div>

          <div class="card-compact text-center">
            <div class="w-16 h-16 mx-auto mb-3 bg-accent-cyan rounded-full animate-spin-slow"></div>
            <p class="text-sm">Spin</p>
          </div>
        </div>
      </section>

      <!-- Example Post Card -->
      <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-6 text-glow">Exemple : Post Card</h2>
        
        <div class="max-w-2xl mx-auto">
          <div class="card hover:shadow-glow-lg transition-all duration-300">
            <!-- Header -->
            <div class="flex items-center gap-3 mb-4">
              <div class="avatar w-12 h-12 bg-gradient-to-br from-primary-500 to-purple-600">
                <div class="w-full h-full flex items-center justify-center text-xl">
                  👩
                </div>
              </div>
              <div class="flex-1">
                <div class="flex items-center gap-2">
                  <h3 class="font-semibold">Sophie Martin</h3>
                  <span class="badge">4.8 ⭐</span>
                  <span class="px-2 py-0.5 rounded-full text-xs bg-orange-500/20 text-orange-300">
                    Annonce
                  </span>
                </div>
                <p class="text-sm text-gray-400">Il y a 1 heure</p>
              </div>
            </div>

            <!-- Meta -->
            <div class="flex items-center gap-4 mb-4 text-sm text-gray-400">
              <span>📅 2026-01-27</span>
              <span>🕐 19h - 21h</span>
              <span>🎥 Vidéo</span>
            </div>

            <!-- Content -->
            <p class="mb-4">
              Je lance une session de cuisine fusion ce soir ! Venez partager vos recettes favorites 🍳
            </p>

            <!-- Tags -->
            <div class="flex flex-wrap gap-2 mb-4">
              <span class="tag-primary">🍳 Cuisine</span>
              <span class="tag-secondary">💬 Partage</span>
              <span class="tag-cyan">🌟 Social</span>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-4 border-t border-primary-500/20">
              <div class="flex items-center gap-6 text-gray-400">
                <button class="flex items-center gap-2 hover:text-primary-400 transition-colors">
                  <span>❤️</span>
                  <span>34</span>
                </button>
                <button class="flex items-center gap-2 hover:text-primary-400 transition-colors">
                  <span>💬</span>
                  <span>12</span>
                </button>
                <button class="flex items-center gap-2 hover:text-primary-400 transition-colors">
                  <span>🔗</span>
                  <span>5</span>
                </button>
              </div>
              
              <button class="btn-secondary">
                ⭐ Noter
              </button>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup lang="ts">
// Ce composant sert de showcase pour le design system
</script>

<style scoped>
@keyframes spin-slow {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

.animate-spin-slow {
  animation: spin-slow 3s linear infinite;
}
</style>