<template>
<q-page>
  <div class="row">
    <div class="col-3 q-pa-xs">
      <q-select outlined dense label="Seleccionar Curso" :options="cursos" v-model="curso" @update:model-value="actualizar"></q-select>
<!--      <pre>{{cursos}}</pre>-->
    </div>
    <div class="col-12">

      <q-table dense :title="curso.nombre" :rows="estudiantes" :columns="columns" :filter="filter">
        <template v-slot:top-right>
          <q-btn
            color="red-9"
            icon-right="picture_as_pdf"
            label="Expotar a PDF"
            no-caps
            @click="exportarPDF"
          />
          <q-btn
            color="primary"
            icon-right="archive"
            label="Expotar a Excel"
            no-caps
            @click="exportTable"
          />
          <q-input outlined dense debounce="300" v-model="filter" placeholder="Buscar estudiante">
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>
        </template>
        <template v-slot:body="props">
          <q-tr :props="props">
            <q-td key="id" :props="props">
              {{ props.row.id }}
            </q-td>
            <q-td key="nombre" :props="props">
              {{ props.row.nombre }}
            </q-td>
            <q-td key="apellidos" :props="props">
              {{ props.row.apellidos}}
            </q-td>
            <q-td key="ci" :props="props">
              {{ props.row.ci}}
            </q-td>
            <q-td key="celular" :props="props">
              {{ props.row.celular}}
            </q-td>
            <q-td key="direccion" :props="props">
              {{ props.row.direccion}}
            </q-td>
            <q-td key="foto" :props="props">
<!--              {{ props.row.imagen}}-->
              <q-img :src="url+'../../imagenes/'+props.row.imagen" width="30px"/>
            </q-td>
          </q-tr>
        </template>
      </q-table>
      <pre>{{estudiantes}}</pre>
    </div>
  </div>
</q-page>
</template>

<script>
import { exportFile } from 'quasar'
import jsPDF from "jspdf";

function wrapCsvValue (val, formatFn) {
  let formatted = formatFn !== void 0
    ? formatFn(val)
    : val

  formatted = formatted === void 0 || formatted === null
    ? ''
    : String(formatted)

  formatted = formatted.split('"').join('""')
  /**
   * Excel accepts \n and \r in strings, but some other CSV parsers do not
   * Uncomment the next two lines to escape new lines
   */
  // .split('\n').join('\\n')
  // .split('\r').join('\\r')

  return `"${formatted}"`
}
export default {
  data(){
    return{
      filter:'',
      estudiantes:[],
      url:process.env.API,
      cursos:[],
      curso:{},
      columns:[
        { name: 'id', label: 'id', field: 'id', sortable: true },
        { name: 'nombre', label: 'nombre', field: 'nombre', sortable: true },
        { name: 'apellidos', label: 'apellidos', field: 'apellidos', sortable: true },
        { name: 'ci', label: 'ci', field: 'ci', sortable: true },
        { name: 'celular', label: 'celular', field: 'celular', sortable: true },
        { name: 'direccion', label: 'direccion', field: 'direccion', sortable: true },
        { name: 'foto', label: 'foto', field: 'foto', sortable: true },
        { name: 'opciones', label: 'opciones', field: 'opciones', sortable: true },
      ]
    }
  },
  created() {
    this.$q.loading.show()
    this.$axios.get('/curso').then(res=>{

      this.cursos=[]
      res.data.forEach(r=>{
        let d={}
        d=r
        d.label=r.nombre+' '+r.paralelo
        this.cursos.push(d)
      })
      // this.cursos=res.data
      this.curso=this.cursos[0]
      this.misalumnos(this.curso.id)
    })
  },
  methods:{
    exportarPDF(){
      let cm=this;
      function header(){
        var img = new Image()
        img.src = 'img/escudo.jpeg'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(5, 1, 'LISTA DE ESTUDIANTES')
        doc.text(5, 1.5, cm.curso.label)
        doc.text(1, 3, 'ID')
        doc.text(3, 3, 'NOMBRES')
        doc.text(6, 3, 'PATERNO')
        doc.text(9, 3, 'MATERNO')
        doc.text(13.5, 3, 'CI/RUN/RUC')
        doc.text(16, 3, 'CELULAR')
        doc.setFont(undefined,'normal')
      }
      var doc = new jsPDF('p','cm','letter')
      // doc.setFont("courier");
      doc.setFontSize(8);
      header()
      let y=0
      // let sumtotal=0
      this.estudiantes.forEach(r=>{
        console.log(r)
        y+=0.5
        doc.text(1, y+3, r.id+'')
        doc.text(3, y+3, r.nombres+'')
        doc.text(6, y+3, r.paterno+'')
        doc.text(9, y+3, r.materno+'')
        doc.text(13.5, y+3, r.ci+'')
        doc.text(16, y+3, r.celular+'')
        // sumtotal+=parseInt(r.total)
        // doc.text(18, y+3, r.user.codigo )
      })
      // doc.text(12, y+4, 'TOTAL RECAUDADCION: ')
      // doc.text(18, y+4, sumtotal+'Bs')
      window.open(doc.output('bloburl'), '_blank');
    },
    exportTable () {
      const content = [this.columns.map(col => wrapCsvValue(col.label))].concat(
        this.estudiantes.map(row => this.columns.map(col => wrapCsvValue(
          typeof col.field === 'function'
            ? col.field(row)
            : row[ col.field === void 0 ? col.name : col.field ],
          col.format
        )).join(','))
      ).join('\r\n')

      const status = exportFile(
        'table-export.csv',
        content,
        'text/csv'
      )

      if (status !== true) {
        $q.notify({
          message: 'Browser denied file download...',
          color: 'negative',
          icon: 'warning'
        })
      }
    },
    actualizar(val){
      // console.log(val)
      this.$q.loading.show()
      this.misalumnos(val.id)
    },
    misalumnos(id){
      this.$axios.get('/curso/'+id).then(res=>{
        this.$q.loading.hide()
        this.estudiantes=[]
        res.data.forEach(r=>{
          let d=r
          d.nombre=r.nombres
          d.apellidos=r.paterno+' '+r.materno
          d.ci=r.carnet
          d.direccion=r.domicilio
          this.estudiantes.push(d)
        })
      })
    }
  }
}
</script>

<style scoped>

</style>
