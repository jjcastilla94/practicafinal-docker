<template>
  <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
    <h2 class="text-xl font-semibold text-slate-900">Gestión de Cursos</h2>

    <div class="mt-4 flex flex-col gap-3 md:flex-row md:items-center">
      <input
        v-model="filtro"
        placeholder="Buscar curso..."
        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm"
      />
      <button
        class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white"
        @click="cargarCursos"
      >
        Recargar
      </button>
    </div>

    <ul class="mt-6 space-y-3">
      <li
        v-for="p in cursosFiltrados"
        :key="p.id"
        class="flex flex-col justify-between gap-3 rounded-xl border border-slate-100 bg-slate-50 p-4 md:flex-row md:items-center"
      >
        <div>
          <p class="font-medium text-slate-900">{{ p.name }}</p>
          <p class="text-sm text-slate-500">{{ p.description }}</p>
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
        {{ editando ? 'Editar curso' : 'Nuevo curso' }}
      </h3>
      <div class="mt-4 grid gap-3 md:grid-cols-2">
        <input
          v-model="form.name"
          placeholder="Nombre"
          class="rounded-lg border border-slate-200 px-3 py-2 text-sm"
        />
        <input
          v-model="form.description"
          placeholder="Descripción"
          class="rounded-lg border border-slate-200 px-3 py-2 text-sm"
        />
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
  name: 'Courses',
  data() {
    return {
      cursos: [],
      form: { id: null, name: '', description: '' },
      filtro: '',
      editando: false,
      apiBase: import.meta.env.VITE_API_URL || 'http://localhost:8000',
    };
  },
  computed: {
    cursosFiltrados() {
      return this.cursos.filter((p) =>
        p.name.toLowerCase().includes(this.filtro.toLowerCase())
      );
    },
  },
  methods: {
    buildUrl(path) {
      const base = (this.apiBase || '').replace(/\/$/, '');
      return `${base}${path}`;
    },
    async cargarCursos() {
      try {
        const res = await fetch(this.buildUrl('/api/courses'), {
          headers: { Accept: 'application/json' },
        });
        if (!res.ok) throw new Error('Error al cargar cursos');
        this.cursos = await res.json();
      } catch (error) {
        console.error(error);
      }
    },
    async guardar() {
      try {
        const options = {
          method: this.editando ? 'PUT' : 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
          },
          body: JSON.stringify(this.form),
        };

        const url = this.editando
          ? this.buildUrl(`/api/courses/${this.form.id}`)
          : this.buildUrl('/api/courses');

        const res = await fetch(url, options);
        if (!res.ok) throw new Error('Error al guardar el curso');

        this.resetForm();
        this.cargarCursos();
      } catch (error) {
        console.error(error);
      }
    },
    editar(prod) {
      this.form = { ...prod };
      this.editando = true;
    },
    async borrar(id) {
      try {
        const res = await fetch(this.buildUrl(`/api/courses/${id}`), {
          method: 'DELETE',
        });
        if (!res.ok) throw new Error('Error al borrar el curso');
        this.cargarCursos();
      } catch (error) {
        console.error(error);
      }
    },
    resetForm() {
      this.form = { id: null, name: '', description: '' };
      this.editando = false;
    },
  },
  mounted() {
    this.cargarCursos();
  },
};
</script>
