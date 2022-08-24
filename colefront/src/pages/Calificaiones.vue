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

              <input type="file" @change="getArch" >

        </q-card-section>

        <q-card-section class="q-pt-none">
          <q-table title="Estudiantes" :rows="materia" :columns="columns" row-key="name" >
      <template v-slot:body-cell-promedio="props">
<!--        <q-tr :props="props">-->
          <q-td key="promedio" :props="props">
            <q-input v-model="props.row.promedio" type="number" step="0.01" dense/>
          </q-td>

<!--        </q-tr>-->
      </template>
          </q-table>
          
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
      calificacion:[],
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
    getArch(evt){
      //this.archivo = event.target.files[0];

        var files = evt.target.files[0]; // FileList object
        var reader = new FileReader();
        reader.readAsBinaryString(files)
        reader.onload = function (e) {
          try {
            var data = e.target.result
            var workbook = XLSX.read(data, { type: 'binary' })
                         var wsname = workbook.SheetNames [0] // Tome la primera hoja
                         var ws = XLSX.utils.sheet_to_json (workbook.Sheets[wsname]) // Generar contenido de tabla json
                         this.calificacion=ws
        console.log(ws)
                         } 
          catch (e) {
            return false
          }
        }

      // Read in the image file as a data URL.
      //reader.readAsDataURL(files);
    
        console.log(reader.ws)
        
        //var xl2json = XLSX.utils.sheet_to_json(files.Sheets[0])
        //xl2json.parseExcel(files[0]);
        //console.log(XLSX.utils.sheet_to_json(reader.Sheets[reader.SheetNames[0]]))
    },
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

