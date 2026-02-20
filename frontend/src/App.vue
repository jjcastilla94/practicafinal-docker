<template>
  <div class="min-h-screen bg-slate-50 text-slate-900">
    <header class="mx-auto max-w-5xl px-4 py-10">
      <p class="text-sm uppercase tracking-[0.2em] text-slate-500">
        Vue 3 + Laravel API
      </p>
      <h1 class="mt-3 text-3xl font-semibold text-slate-900 md:text-4xl">
        Panel de Cursos y Estudiantes
      </h1>
      <p class="mt-2 max-w-2xl text-base text-slate-600">
        Frontend en Vercel consumiendo el backend en Render. Usa los botones para
        alternar las vistas.
      </p>

      <div class="mt-6 inline-flex overflow-hidden rounded-full border border-slate-200 bg-white">
        <button
          class="px-6 py-2 text-sm font-medium transition"
          :class="view === 'courses' ? 'bg-slate-900 text-white' : 'text-slate-600'"
          @click="view = 'courses'"
        >
          Cursos
        </button>
        <button
          class="px-6 py-2 text-sm font-medium transition"
          :class="view === 'students' ? 'bg-slate-900 text-white' : 'text-slate-600'"
          @click="view = 'students'"
        >
          Estudiantes
        </button>
      </div>

      <p class="mt-4 text-xs text-slate-400">
        API: {{ apiBase }}
      </p>
    </header>

    <main class="mx-auto max-w-5xl px-4 pb-16">
      <Courses v-if="view === 'courses'" />
      <Students v-else />
    </main>
  </div>
</template>

<script>
import Courses from './components/Courses.vue';
import Students from './components/Students.vue';

export default {
  components: {
    Courses,
    Students,
  },
  data() {
    return {
      view: 'courses',
      apiBase: import.meta.env.VITE_API_URL || 'http://localhost:8000',
    };
  },
};
</script>
