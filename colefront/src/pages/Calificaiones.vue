<template>
<q-page>

  <div class="row">
    <div v-for="c in cursos" :key="c.id" class="col-4 col-sm-1 flex flex-center">
      <q-btn :label="c.nombre +' '+ c.paralelo" size="xs" color="primary" @click="listado(c)"/>
    </div>
  </div>

    <template v-if="alumnos.length>0">
      <div class="row">
      <div class="col-12 flex flex-center" >
        <div class="text-h6">Areas</div>
        <q-select outlined dense v-model="trimestre" label="Seleccionar trimestre" :options="['PRIMER TRIMESTRE','SEGUNDO TRIMESTRE','TERCER TRIMESTRE',]" />
      </div>
      <div v-for="g in grupos" :key="g.id" class="col-3">
          <q-btn :label="g.nombre"  :color="g.color" class="full-width"/>
        <div class="row">
          <div v-for="m in g.materias" :key="m.id" class="col-12 text-center">
              <q-btn :label="m.nombre" class="full-width"  @click="notas(m.id)" :color="g.color" outline/>
          </div>
        </div>
      </div>
      </div>
    </template>
  <q-dialog v-model="dialog_nota" >
    <q-card style="min-width: 350px">
      <q-card-section>
        <div class="text-h6">Listado de Alumnos</div>

        <input type="file" @change="getArch" >

      </q-card-section>

      <q-card-section class="q-pt-none">
        <q-table title="Estudiantes" :rows="materia" :columns="columns" row-key="name" >
          <template v-slot:body-cell-promedio="props">
            <q-td key="promedio" :props="props">
              <q-input outlined v-model="props.row.promedio" type="number" step="0.01" dense/>
            </q-td>
          </template>
        </q-table>
      </q-card-section>

      <q-card-actions align="right" class="text-primary">
        <q-btn flat label="Cancel" v-close-popup />
        <q-btn flat label="Registrar" @click="registrarNota" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</q-page>
</template>

<script>
import * as XLSX from 'xlsx/xlsx.mjs';

/* load 'fs' for readFile and writeFile support */
export default {
  data(){
    return{
      cursos:[],
      XLSX : require("xlsx"),
      grupos:[],
      alumnos:[],
      materia:[],
      materias:[],
      cursomat:[],
      calificacion:[],
      dialog_nota:false,
      mat:{},
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
    this.$axios.get('/curso').then(res=>{
      this.cursos=res.data
      this.$q.loading.hide()
    })
    this.$axios.get('/grupo').then(res=>{
       console.log(res.data)
      this.grupos=res.data
    })
  },
  methods:{
    getArch(evt){
      let index=0
      if (this.trimestre=='PRIMER TRIMESTRE'){
        index=4
      }
      if (this.trimestre=='SEGUNDO TRIMESTRE'){
        index=5
      }
      if (this.trimestre=='TERCER TRIMESTRE'){
        index=6
      }

        var files = evt.target.files[0]; // FileList object
        var reader = new FileReader();
        reader.readAsBinaryString(files)
        let cm= this
        reader.onload = function (e) {
          try {
            var data = e.target.result
            var workbook = XLSX.read(data, { type: 'binary' })
            var wsname = workbook.SheetNames [index] // Tome la primera hoja
            var ws = XLSX.utils.sheet_to_json (workbook.Sheets[wsname]) // Generar contenido de tabla json
            cm.calificacion=[]
            ws.forEach((e,i) => {

              if (i>=10 && e.__EMPTY!=undefined && e.__EMPTY.trim()!='' && e.__EMPTY.trim()!=' ' && e.__EMPTY!=null){
                let nombre=e.__EMPTY.replace('  ',' ')
                let nota=e.__EMPTY_25
                cm.calificacion.push(e)
                let indexFind= (cm.materia.findIndex(e=>e.nombreCompleto==nombre))
                if (indexFind>=0){
                  cm.materia[indexFind].promedio=nota
                }
              }
            })

        //      this.calificacion=ws
        // console.log(ws)
          }
          catch (e) {
            return false
          }
        }

      // Read in the image file as a data URL.
      //reader.readAsDataURL(files);

        // console.log(reader.ws)

        //var xl2json = XLSX.utils.sheet_to_json(files.Sheets[0])
        //xl2json.parseExcel(files[0]);
        //console.log(XLSX.utils.sheet_to_json(reader.Sheets[reader.SheetNames[0]]))
    },
    listado(c){
      this.materias=[]
      this.curso=c
      this.$axios.post('/listestudiante',{'curso_id':c.id}).then(res=>{
        this.alumnos=res.data
        // console.log(res.data)
        this.$axios.post('/listmaterias/'+c.id).then(res=>{
            //console.log(res.data[0])
            this.cursomat=res.data[0].materias
            this.grupos.forEach(r=>{
                this.cursomat.forEach(d=>{
                  if(r.id==d.grupo_id){
                    this.materias.push(d)
                  }
                })
            //console.log(this.materias)
                r.materias=this.materias
                this.materias=[]
            })
           // console.log(this.grupos)
        })
        
      })


    },
    notas(mat){
      this.materia=[]
      this.mat=mat
      this.alumnos.forEach(r => {
        r.promedio=0;
        r.materia_id=mat;
        r.trimestre=this.trimestre;
        r.nombreCompleto= r.paterno+' ' +r.materno+' ' +r.nombres
        this.materia.push(r)
      });
      this.dialog_nota=true;
      this.$axios.post('/listnota',{curso:this.curso,trimestre:this.trimestre,materia:mat}).then(res=>{
        console.log(res.data)
       // return false
        res.data.forEach(r=>{
            this.materia.forEach(l=>{
              if(r.estudiante_id==l.id){
                l.promedio=r.promedio;
              }
            })
        })
      })

    },

    registrarNota(){
      this.$axios.post('/nota',{curso:this.curso,trimestre:this.trimestre,materia:this.mat,notas:this.materia}).then(res=>{
          console.log(res.data)
      })

    }
  }
}
</script>

<style scoped>

</style>

