<template>
    <div class="q-pa-md">
    <div class="text-h4" align="center">BIBLIOTECA</div >

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
      dato:{fondo:'APMT',gestion:date.formatDate(Date.now(),'YYYY'),tomo:'1',numtotal:'1'},
      dato2:{},
      subc:{},
      modprod:{},
      cat:[],
      subcat:[],
      materias:[],
      materia:{},
      libro:{},
      data: [
      ],
      prod2: [
      ]
    }
  },
  created() {
      this.mismaterias();
        this.misdatos();

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
                this.materias.push({label:r.nombre,r});
            });
            this.materia=this.materias[0]
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


  },

}
</script>
