# Vue 3 + TypeScript + Vite

This template should help get you started developing with Vue 3 and TypeScript in Vite. The template uses Vue 3 `<script setup>` SFCs, check out the [script setup docs](https://v3.vuejs.org/api/sfc-script-setup.html#sfc-script-setup) to learn more.

Learn more about the recommended Project Setup and IDE Support in the [Vue Docs TypeScript Guide](https://vuejs.org/guide/typescript/overview.html#project-setup).

# 🎨 Design System - FutureSocial

## 📋 Vue d'ensemble

Ce document décrit le système de design futuriste pour FutureSocial, basé sur une esthétique cyberpunk avec des effets néon, glassmorphism et animations fluides.

## 🎨 Palette de couleurs

### Couleurs principales

- **Primary (Rose/Magenta)** : `primary-500` (#d946ef)
  - Utilisé pour : CTA, liens importants, accents, glow effects
  
- **Secondary (Bleu)** : `secondary-500` (#3b82f6)
  - Utilisé pour : Éléments secondaires, badges, accents alternatifs

- **Dark (Backgrounds)** : `dark-500` (#1e1b4b)
  - Utilisé pour : Backgrounds principaux, overlays

### Couleurs d'accent

- **Cyan** : `accent-cyan` (#06b6d4) - Tags, highlights
- **Purple** : `accent-purple` (#8b5cf6) - Gradients, badges
- **Pink** : `accent-pink` (#ec4899) - Alertes, notifications
- **Orange** : `accent-orange` (#f97316) - Warnings

## 🧩 Composants de base

### Boutons

```vue
<!-- Bouton principal avec effet glow -->
<button class="btn-primary">
  Action principale
</button>

<!-- Bouton secondaire glassmorphism -->
<button class="btn-secondary">
  Action secondaire
</button>

<!-- Bouton fantôme -->
<button class="btn-ghost">
  Annuler
</button>
```

### Inputs

```vue
<!-- Input avec effet glassmorphism -->
<input 
  type="text" 
  class="input" 
  placeholder="Entrez votre texte..."
/>
```

### Cards

```vue
<!-- Card avec glassmorphism et hover effect -->
<div class="card">
  <!-- Contenu -->
</div>

<!-- Card compacte -->
<div class="card-compact">
  <!-- Contenu -->
</div>
```

### Tags

```vue
<!-- Tag principal -->
<span class="tag-primary">
  🍳 Cuisine
</span>

<!-- Tag bleu -->
<span class="tag-secondary">
  🎮 Gaming
</span>

<!-- Tag cyan -->
<span class="tag-cyan">
  💬 Social
</span>
```

## ✨ Effets spéciaux

### Glassmorphism

```vue
<!-- Background transparent avec blur -->
<div class="glass">
  <!-- Contenu -->
</div>

<!-- Version plus opaque -->
<div class="glass-strong">
  <!-- Contenu -->
</div>
```

### Glow Effects

```vue
<!-- Text avec effet glow -->
<h1 class="text-glow">Titre néon</h1>

<!-- Border avec glow -->
<div class="border-glow border rounded-lg p-4">
  Contenu
</div>

<!-- Shadow glow (box-shadow) -->
<div class="shadow-glow">
  Carte brillante
</div>
```

### Gradients

```vue
<!-- Gradient text -->
<h2 class="gradient-text">
  Texte avec gradient
</h2>

<!-- Background gradient -->
<div class="bg-gradient-cyberpunk">
  <!-- Contenu -->
</div>
```

## 🎬 Animations

### Animations intégrées

```vue
<!-- Pulse lent -->
<div class="animate-pulse-slow">
  Pulsation douce
</div>

<!-- Glow animé -->
<div class="animate-glow">
  Effet néon pulsant
</div>

<!-- Float (lévitation) -->
<div class="animate-float">
  Flotte doucement
</div>

<!-- Fade in -->
<div class="animate-fade-in">
  Apparition en fondu
</div>

<!-- Scale in -->
<div class="animate-scale-in">
  Apparition avec zoom
</div>
```

### Transitions Vue

```vue
<!-- Fade transition -->
<Transition name="fade">
  <div v-if="show">Contenu</div>
</Transition>

<!-- Slide transition -->
<Transition name="slide">
  <div v-if="show">Contenu</div>
</Transition>
```

## 📐 Layout & Spacing

### Container

```vue
<div class="container-custom">
  <!-- Contenu centré avec padding responsive -->
</div>
```

### Divider

```vue
<div class="divider"></div>
```

## 🖼️ Composants spécifiques

### Avatar

```vue
<img 
  src="avatar.jpg" 
  alt="User" 
  class="avatar w-12 h-12"
/>
```

### Badge

```vue
<span class="badge">
  4.8 ⭐
</span>
```

### Navigation Link

```vue
<!-- Link normal -->
<a href="#" class="nav-link">
  <Icon name="home" />
  Accueil
</a>

<!-- Link actif -->
<a href="#" class="nav-link active">
  <Icon name="feed" />
  Fil d'actualité
</a>
```

## 💡 Bonnes pratiques

### 1. Hiérarchie visuelle
- Utilisez `text-glow` pour les titres importants
- `shadow-glow` pour mettre en valeur les cards principales
- Les gradients pour les CTA principaux

### 2. Cohérence des effets
- Tous les éléments interactifs ont une transition
- Hover states avec changement d'opacité ou glow
- Focus states pour l'accessibilité

### 3. Performance
- Les animations utilisent `transform` et `opacity` (GPU-accelerated)
- `backdrop-filter` utilisé avec parcimonie
- Transitions de 200-300ms pour une sensation fluide

### 4. Responsive
- Mobile-first approach
- Breakpoints Tailwind standards (sm, md, lg, xl, 2xl)
- Touch-friendly sur mobile (min 44px de zone tactile)

## 🎯 Exemples d'utilisation

### Post Card complète

```vue
<div class="card hover:shadow-glow-lg transition-all duration-300">
  <!-- Header -->
  <div class="flex items-center gap-3 mb-4">
    <img src="avatar.jpg" class="avatar w-12 h-12" />
    <div>
      <div class="flex items-center gap-2">
        <h3 class="font-semibold">Sophie Martin</h3>
        <span class="badge">4.8 ⭐</span>
      </div>
      <p class="text-sm text-gray-400">Il y a 1 heure</p>
    </div>
  </div>

  <!-- Content -->
  <p class="mb-4">
    Je lance une session de cuisine fusion ce soir ! 🍳
  </p>

  <!-- Tags -->
  <div class="flex flex-wrap gap-2 mb-4">
    <span class="tag-primary">🍳 Cuisine</span>
    <span class="tag-secondary">💬 Partage</span>
  </div>

  <!-- Actions -->
  <div class="flex items-center gap-6 text-gray-400">
    <button class="hover:text-primary-400 transition-colors">
      ❤️ 34
    </button>
    <button class="hover:text-primary-400 transition-colors">
      💬 12
    </button>
    <button class="hover:text-primary-400 transition-colors">
      🔗 5
    </button>
  </div>
</div>
```

### Header avec glassmorphism

```vue
<header class="glass-strong border-b border-primary-500/20 sticky top-0 z-50">
  <div class="container-custom py-4">
    <nav class="flex items-center justify-between">
      <h1 class="text-2xl font-bold gradient-text">
        FutureSocial
      </h1>
      
      <div class="flex items-center gap-4">
        <a href="#" class="nav-link active">Fil d'actualité</a>
        <a href="#" class="nav-link">Sessions</a>
        <a href="#" class="nav-link">Messages</a>
      </div>
    </nav>
  </div>
</header>
```

## 🔧 Configuration

Assurez-vous que votre `main.ts` importe le CSS :

```typescript
import './assets/styles/main.css'
```

Et que Tailwind est bien configuré dans `tailwind.config.js` avec toutes les extensions custom.