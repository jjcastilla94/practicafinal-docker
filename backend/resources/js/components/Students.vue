<template>
  <div>
    <h2 class="titulo">Gestión de Estudiantes</h2>

    <input v-model="filtro" placeholder="Buscar estudiante..." class="border p-2 mb-3">

    <ul>
      <li v-for="p in estudiantesFiltrados" :key="p.id">
        <div>
          {{ p.name }} - {{ p.email }} -
          {{ p.course ? p.course.name : 'Sin curso' }}
        </div>
        <div>
          <button @click="editar(p)">Editar</button>
          <button @click="borrar(p.id)">Eliminar</button>
        </div>
      </li>
    </ul>

    <h3 class="subtitulo">{{ editando ? 'Editar estudiante' : 'Nuevo estudiante' }}</h3>

    <input v-model="form.name" placeholder="Nombre">
    <input v-model="form.email" placeholder="Email">

    <select v-model="form.course_id">
      <option :value="null">-- ninguno --</option>
      <option v-for="c in courses" :key="c.id" :value="c.id">
        {{ c.name }}
      </option>
    </select>

    <button @click="guardar">Guardar</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      estudiantes: [],
      courses: [],
      form: { id: null, name: '', email: '', course_id: null },
      filtro: '',
      editando: false,
      apiBase: '/api/students'
    };
  },

  computed: {
    estudiantesFiltrados() {
      return this.estudiantes.filter(p =>
        p.name.toLowerCase().includes(this.filtro.toLowerCase())
      );
    },
  },

  methods: {
    async cargarEstudiantes() {
      const res = await fetch(this.apiBase);
      this.estudiantes = await res.json();
    },

    async cargarCursos() {
      const res = await fetch('/api/courses');
      this.courses = await res.json();
    },

    async guardar() {
      const url = this.editando
        ? `${this.apiBase}/${this.form.id}`
        : this.apiBase;

      const res = await fetch(url, {
        method: this.editando ? 'PUT' : 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          ...this.form,
          course_id: this.form.course_id || null
        })
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
        course_id: p.course_id
      };
      this.editando = true;
    },

    async borrar(id) {
      await fetch(`${this.apiBase}/${id}`, { method: 'DELETE' });
      this.cargarEstudiantes();
    },

    resetForm() {
      this.form = { id: null, name: '', email: '', course_id: null };
      this.editando = false;
    }
  },

  mounted() {
    this.cargarEstudiantes();
    this.cargarCursos();
  }
};
</script>
