<template>
  <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
    <h2 class="text-xl font-semibold text-slate-900">Gestión de Estudiantes</h2>

    <div class="mt-4 flex flex-col gap-3 md:flex-row md:items-center">
      <input
        v-model="filtro"
        placeholder="Buscar estudiante..."
        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm"
      />
      <button
        class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white"
        @click="cargarEstudiantes"
      >
        Recargar
      </button>
    </div>

    <ul class="mt-6 space-y-3">
      <li
        v-for="p in estudiantesFiltrados"
        :key="p.id"
        class="flex flex-col justify-between gap-3 rounded-xl border border-slate-100 bg-slate-50 p-4 md:flex-row md:items-center"
      >
        <div>
          <p class="font-medium text-slate-900">{{ p.name }}</p>
          <p class="text-sm text-slate-500">{{ p.email }}</p>
          <p class="text-xs text-slate-400">
            {{ p.course ? p.course.name : 'Sin curso' }}
          </p>
        </div>
        <div class="flex gap-2">
          <button class="rounded-lg border border-slate-200 px-3 py-1 text-sm" @click="editar(p)">
            Editar
          </button>
          <button class="rounded-lg border border-rose-200 px-3 py-1 text-sm text-rose-600" @click="borrar(p.id)">
            Eliminar
          </button>
        </div>
      </li>
    </ul>

    <div class="mt-8 border-t border-slate-200 pt-6">
      <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">
        {{ editando ? 'Editar estudiante' : 'Nuevo estudiante' }}
      </h3>
      <div class="mt-4 grid gap-3 md:grid-cols-2">
        <input
          v-model="form.name"
          placeholder="Nombre"
          class="rounded-lg border border-slate-200 px-3 py-2 text-sm"
        />
        <input
          v-model="form.email"
          placeholder="Email"
          class="rounded-lg border border-slate-200 px-3 py-2 text-sm"
        />
        <select
          v-model="form.course_id"
          class="rounded-lg border border-slate-200 px-3 py-2 text-sm"
        >
          <option :value="null">-- ninguno --</option>
          <option v-for="c in courses" :key="c.id" :value="c.id">
            {{ c.name }}
          </option>
        </select>
      </div>
      <button
        class="mt-4 rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white"
        @click="guardar"
      >
        Guardar
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Students',
  data() {
    return {
      estudiantes: [],
      courses: [],
      form: { id: null, name: '', email: '', course_id: null },
      filtro: '',
      editando: false,
      apiBase: import.meta.env.VITE_API_URL || 'http://localhost:8000',
    };
  },
  computed: {
    estudiantesFiltrados() {
      return this.estudiantes.filter((p) =>
        p.name.toLowerCase().includes(this.filtro.toLowerCase())
      );
    },
  },
  methods: {
    buildUrl(path) {
      const base = (this.apiBase || '').replace(/\/$/, '');
      return `${base}${path}`;
    },
    async cargarEstudiantes() {
      const res = await fetch(this.buildUrl('/api/students'));
      this.estudiantes = await res.json();
    },
    async cargarCursos() {
      const res = await fetch(this.buildUrl('/api/courses'));
      this.courses = await res.json();
    },
    async guardar() {
      const url = this.editando
        ? this.buildUrl(`/api/students/${this.form.id}`)
        : this.buildUrl('/api/students');

      const res = await fetch(url, {
        method: this.editando ? 'PUT' : 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          ...this.form,
          course_id: this.form.course_id || null,
        }),
      });

      if (!res.ok) {
        const error = await res.json();
        console.log(error);
        return;
      }

      this.resetForm();
      this.cargarEstudiantes();
    },
    editar(p) {
      this.form = {
        id: p.id,
        name: p.name,
        email: p.email,
        course_id: p.course_id,
      };
      this.editando = true;
    },
    async borrar(id) {
      await fetch(this.buildUrl(`/api/students/${id}`), { method: 'DELETE' });
      this.cargarEstudiantes();
    },
    resetForm() {
      this.form = { id: null, name: '', email: '', course_id: null };
      this.editando = false;
    },
  },
  mounted() {
    this.cargarEstudiantes();
    this.cargarCursos();
  },
};
</script>
