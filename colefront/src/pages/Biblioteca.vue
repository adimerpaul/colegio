<template>
    <div class="q-pa-md">
    <div class="text-h4" align="center">BIBLIOTECA</div >
    <div class="row">
    <div class="col-3"> <q-select  outlined v-model="curso" :options="cursos" label="Curso" /></div>
    <div class="col-3"> <q-select  outlined v-model="materia" :options="materias" label="Materia" /></div>
    <div class="col-3">  <q-btn color="info" icon="search" label="Buscar" @click="buscar"/>
    </div>
    </div>
    <div class="row"  >
    <q-card  class="my-card" style="width:200px;height:200px;margin:5px"  v-for="r in data" :key="r">
      <q-img :src="url+'/../imagenes/'+r.imagen" style="width:200px;height:200px;" @click="descargar(r)">
        <div class="absolute-bottom text-subtitle2 text-center">
          {{r.titulo}}<br>{{r.autor}}

        </div>
      </q-img>
    </q-card>
    </div>
    </div>
</template>
<script>

import {date} from "quasar";

export default {
  data () {
    return {
      url:process.env.API,
      subc:{},
      modprod:{},
      cat:[],
      subcat:[],
      materias:[],
      materia:{},
      cursos:[],
      curso:{},
      libro:{},
      data: [],
      prod2: []
    }
  },
  created() {
      this.mismaterias();
      this.miscursos();

  },
  methods:{
        descargar(lib){
              console.log(lib) 
              var fileName=this.url+'/../archivos/'+lib.archivo; 
              window.open(fileName, 'Download');
        },
      mismaterias(){
          this.materias=[]
        this.$axios.get(process.env.API+'/materia').then(res=>{
            res.data.forEach(r => {
                r.label=r.nombre;
                this.materias.push(r);
            });
            this.materia=this.materias[0]
        })

      },
      miscursos(){
          this.cursos=[]
        this.$axios.get(process.env.API+'/curso').then(res=>{
            res.data.forEach(r => {
                r.label=r.nombre + ' '+ r.paralelo
                this.cursos.push(r);
            });
            this.curso=this.cursos[0]
        })

      },
    misdatos(){
      this.$q.loading.show();
        this.$axios.get(process.env.API+'/libro').then(res=>{
            console.log(res.data)
           this.data=res.data;
          this.$q.loading.hide();
        })
    },

    buscar(){
      this.$q.loading.show();
        this.$axios.post(process.env.API+'/buscarlibro',{materia_id:this.materia.id,curso_id:this.curso.id}).then(res=>{
            console.log(res.data)
          //this.$q.loading.hide();
           // return false
           this.data=res.data;
          this.$q.loading.hide();
        })

    }


  },

}
</script>
