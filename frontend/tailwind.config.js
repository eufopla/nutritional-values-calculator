/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        // Palette principale futuriste
        primary: {
          50: '#fdf4ff',
          100: '#fae8ff',
          200: '#f5d0fe',
          300: '#f0abfc',
          400: '#e879f9',
          500: '#d946ef', // Rose néon principal
          600: '#c026d3',
          700: '#a21caf',
          800: '#86198f',
          900: '#701a75',
        },
        secondary: {
          50: '#eff6ff',
          100: '#dbeafe',
          200: '#bfdbfe',
          300: '#93c5fd',
          400: '#60a5fa',
          500: '#3b82f6', // Bleu principal
          600: '#2563eb',
          700: '#1d4ed8',
          800: '#1e40af',
          900: '#1e3a8a',
        },
        accent: {
          cyan: '#06b6d4',
          purple: '#8b5cf6',
          pink: '#ec4899',
          orange: '#f97316',
        },
        // Couleurs sombres pour le background
        dark: {
          50: '#18181b',
          100: '#1a1625',
          200: '#1f1838',
          300: '#241c47',
          400: '#2d2054',
          500: '#1e1b4b', // Background principal
          600: '#1a1740',
          700: '#151334',
          800: '#0f0e27',
          900: '#0a0a1a',
        },
      },
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
        'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
        'gradient-cyberpunk': 'linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #1e1b4b 100%)',
        'gradient-card': 'linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%)',
        'gradient-glow': 'radial-gradient(circle at 50% 0%, rgba(217, 70, 239, 0.15), transparent 50%)',
      },
      boxShadow: {
        'glow-sm': '0 0 10px rgba(217, 70, 239, 0.3)',
        'glow': '0 0 20px rgba(217, 70, 239, 0.4), 0 0 40px rgba(139, 92, 246, 0.2)',
        'glow-lg': '0 0 30px rgba(217, 70, 239, 0.5), 0 0 60px rgba(139, 92, 246, 0.3)',
        'glow-blue': '0 0 20px rgba(59, 130, 246, 0.4), 0 0 40px rgba(96, 165, 250, 0.2)',
        'glow-cyan': '0 0 20px rgba(6, 182, 212, 0.4)',
        'inner-glow': 'inset 0 0 20px rgba(217, 70, 239, 0.1)',
        'card': '0 8px 32px 0 rgba(0, 0, 0, 0.37)',
      },
      animation: {
        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
        'glow': 'glow 2s ease-in-out infinite alternate',
        'float': 'float 3s ease-in-out infinite',
        'slide-up': 'slideUp 0.3s ease-out',
        'slide-down': 'slideDown 0.3s ease-out',
        'fade-in': 'fadeIn 0.3s ease-in',
        'scale-in': 'scaleIn 0.2s ease-out',
        'shimmer': 'shimmer 2s linear infinite',
      },
      keyframes: {
        glow: {
          '0%': { 
            boxShadow: '0 0 20px rgba(217, 70, 239, 0.4), 0 0 40px rgba(139, 92, 246, 0.2)',
          },
          '100%': { 
            boxShadow: '0 0 30px rgba(217, 70, 239, 0.6), 0 0 60px rgba(139, 92, 246, 0.4)',
          },
        },
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-10px)' },
        },
        slideUp: {
          '0%': { 
            opacity: '0',
            transform: 'translateY(10px)',
          },
          '100%': { 
            opacity: '1',
            transform: 'translateY(0)',
          },
        },
        slideDown: {
          '0%': { 
            opacity: '0',
            transform: 'translateY(-10px)',
          },
          '100%': { 
            opacity: '1',
            transform: 'translateY(0)',
          },
        },
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        scaleIn: {
          '0%': { 
            opacity: '0',
            transform: 'scale(0.9)',
          },
          '100%': { 
            opacity: '1',
            transform: 'scale(1)',
          },
        },
        shimmer: {
          '0%': { backgroundPosition: '-1000px 0' },
          '100%': { backgroundPosition: '1000px 0' },
        },
      },
      backdropBlur: {
        xs: '2px',
      },
      borderRadius: {
        'xl': '1rem',
        '2xl': '1.5rem',
      },
      spacing: {
        '18': '4.5rem',
        '88': '22rem',
        '128': '32rem',
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        display: ['Space Grotesk', 'Inter', 'sans-serif'],
      },
      fontSize: {
        'xxs': '0.625rem',
      },
    },
  },
  plugins: [
    // Plugin personnalisé pour les effets de glassmorphism
    function({ addUtilities }) {
      const newUtilities = {
        '.glass': {
          background: 'rgba(30, 27, 75, 0.7)',
          backdropFilter: 'blur(10px)',
          border: '1px solid rgba(139, 92, 246, 0.2)',
        },
        '.glass-strong': {
          background: 'rgba(30, 27, 75, 0.9)',
          backdropFilter: 'blur(20px)',
          border: '1px solid rgba(139, 92, 246, 0.3)',
        },
        '.text-glow': {
          textShadow: '0 0 10px rgba(217, 70, 239, 0.5)',
        },
        '.text-glow-blue': {
          textShadow: '0 0 10px rgba(59, 130, 246, 0.5)',
        },
        '.border-glow': {
          borderColor: 'rgba(217, 70, 239, 0.5)',
          boxShadow: '0 0 10px rgba(217, 70, 239, 0.3)',
        },
        '.hover-glow': {
          transition: 'all 0.3s ease',
          '&:hover': {
            boxShadow: '0 0 20px rgba(217, 70, 239, 0.5), 0 0 40px rgba(139, 92, 246, 0.3)',
          },
        },
      }
      addUtilities(newUtilities)
    },
  ],
}