<template>
  <div>
    <h2 class="titulo">Gestión de Cursos</h2>

    <input v-model="filtro" placeholder="Buscar curso..." class="border p-2 mb-3">

    <ul>
      <li v-for="p in cursosFiltrados" :key="p.id">
        <div>
          {{ p.name }} - {{ p.description }}
        </div>
        <div>
          <button @click="editar(p)">Editar</button>
          <button @click="borrar(p.id)">Eliminar</button>
        </div>
      </li>
    </ul>

    <h3 class="subtitulo">{{ editando ? 'Editar curso' : 'Nuevo curso' }}</h3>
    <input v-model="form.name" placeholder="Nombre">
    <input v-model="form.description" placeholder="Descripción">
    <button @click="guardar">Guardar</button>
  </div>
</template>

<script>
export default {
  name: 'Cursos',
  data() {
    return {
      cursos: [],
      form: { id: null, name: '', description: '' },
      filtro: '',
      editando: false,
      apiBase: '/api/courses'
    };
  },
  computed: {
    cursosFiltrados() {
      return this.cursos.filter(p =>
        p.name.toLowerCase().includes(this.filtro.toLowerCase())
      );
    },
  },
  methods: {
    async cargarCursos() {
      try {
        const res = await fetch(this.apiBase,{
          headers: { 'Accept': 'application/json' }
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
            'Accept': 'application/json'
          },
          body: JSON.stringify(this.form)
        };

        const url = this.editando ? `${this.apiBase}/${this.form.id}` : this.apiBase;

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
        const res = await fetch(`${this.apiBase}/${id}`, { method: 'DELETE' });
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