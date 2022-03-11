<template>
<q-page>
<br>
  <div class="row">
    <div v-for="c in cursos" :key="c.id" class="col-4 col-sm-1 flex flex-center">
      <q-btn :label="c.nombre +' '+ c.paralelo" size="xs" color="primary" @click="listado(c)"/>
    </div>
<br>
<template v-if="alumnos.length>0">
    
    <div class="col-12 flex flex-center" >
      <div class="text-h6">Areas</div>
      <q-select outlined dense v-model="trimestre" label="Seleccionar trimestre" :options="['PRIMER TRIMESTRE','SEGUNDO TRIMESTRE','TERCER TRIMESTRE',]" />
    </div>
    <div v-for="g in grupos" :key="g.id" class="col-3 col-sm-3 flex flex-center">
      <div style="width:100%"><q-btn :label="g.nombre"  :color="g.color"/></div>
      <div v-for="m in g.materias" :key="m.id" class="col-3 col-sm-3 flex flex-center">
        <div style="width:100%">
        <q-btn :label="m.nombre"  @click="notas(m.id)" :color="g.color"/>
        </div>
      </div>
    </div>
</template>
    <q-dialog v-model="dialog_nota" >
      <q-card style="min-width: 350px">
        <q-card-section>
          <div class="text-h6">Listado de Alumnos</div>
        </q-card-section>

        <q-card-section class="q-pt-none">
          <q-table title="Estudiantes" :rows="materia" :columns="columns" row-key="name" />
          
        </q-card-section>

        <q-card-actions align="right" class="text-primary">
          <q-btn flat label="Cancel" v-close-popup />
          <q-btn flat label="Add address" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>
</q-page>
</template>

<script>
export default {
  data(){
    return{
      cursos:[],
      grupos:[],
      alumnos:[],
      materia:[],
      dialog_nota:false,
      trimestre:'PRIMER TRIMESTRE',
      columns:[
 {   name: 'paterno',label: 'PATERNO',align: 'left',field: 'paterno',sortable: true  },
 {   name: 'materno',label: 'MATERNO',align: 'left',field: 'materno',sortable: true  },
 {   name: 'nombres',label: 'NOMBRES',align: 'left',field: 'nombres',sortable: true  },
 {   name: 'promedio',label: 'Promedio',align: 'left',field: 'promedio',sortable: true  },
      ]
    }
  },
  created() {
    this.$q.loading.show()
    this.$api.get('/curso').then(res=>{
      this.cursos=res.data
      this.$q.loading.hide()
    })
    this.$api.get('/grupo').then(res=>{
      console.log(res.data)
      this.grupos=res.data
    })
  },
  methods:{
    listado(c){
      this.$api.post('/listestudiante',{'curso_id':c.id}).then(res=>{
        this.alumnos=res.data
        console.log(res.data)
      })


    },
    notas(mat){
      this.materia=[]
      this.alumnos.forEach(r => {
        r.promedio=0;r.materia_id=mat;r.trimestre=this.trimestre;
        this.materia.push(r)
        
      });
      this.dialog_nota=true;
      console.log(this.materia)
    }
  }
}
</script>

<style scoped>

</style>

