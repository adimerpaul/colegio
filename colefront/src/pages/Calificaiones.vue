<template>
<q-page>
<br>
  <div class="row">
    <div v-for="c in cursos" :key="c.id" class="col-4 col-sm-1 flex flex-center">
      <q-btn :label="c.nombre +' '+ c.paralelo" size="xs" color="primary" @click="listado(c)"/>
    </div>
<br>
    <div class="col-12 flex flex-center">
      <div class="text-h6">Areas</div>
      <q-select outlined dense v-model="trimestre" label="Seleccionar trimestre" :options="['PRIMER TRIMESTRE','SEGUNDO TRIMESTRE','TERCER TRIMESTRE',]" />
    </div>
    <div v-for="g in grupos" :key="g.id" class="col-2 col-sm-3 flex flex-center">
      <q-btn :label="g.nombre"  :color="g.color"/>
    </div>
  </div>
</q-page>
</template>

<script>
export default {
  data(){
    return{
      cursos:[],
      grupos:[],
      trimestre:'PRIMER TRIMESTRE'
    }
  },
  created() {
    this.$q.loading.show()
    this.$api.get('/curso').then(res=>{
      this.cursos=res.data
      this.$q.loading.hide()
    })
    this.$api.get('/grupo').then(res=>{
      this.grupos=res.data
    })
  },
  methods:{
    listado(){

    }
  }
}
</script>

<style scoped>

</style>
