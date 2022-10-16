<template>
    <q-page>
      <div class="row">

        <div class="col-12">
    
          <q-table dense title="" :rows="estudiantes" :columns="columns" :filter="filter">
            <template v-slot:top-right>
              <q-input outlined dense debounce="300" v-model="filter" placeholder="Buscar estudiante">
                <template v-slot:append>
                  <q-icon name="search" />
                </template>
              </q-input>
            </template>
            <template v-slot:body-cell-opcion="props">

                <q-td key="opcion" :props="props">
                     <q-btn color="green" label="libreta" @click="libreta(props.row)" v-if="props.row.vernota=='SI'"/>
                    
                </q-td>
            </template>
          </q-table>
          <!--<pre>{{estudiantes}}</pre>-->
        </div>
      </div>
    </q-page>
    </template>
    
    <script>
    import { exportFile } from 'quasar'
    import jsPDF from "jspdf";
    import conversor from "conversor-numero-a-letras-es-ar";
    
    
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
            { name: 'nombre', label: 'NOMBRES', field: 'nombre', sortable: true },
            { name: 'apellidos', label: 'APELLIDO', field: 'apellidos', sortable: true },
            { name: 'opcion', label: 'OPCION', field: 'opciones', aling:'center' },
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

        libreta(estud){
          this.$axios.post('/libreta',{estudiante:estud,curso:this.curso}).then(res=>{
    
          var doc = new jsPDF('L','cm','legal')
          let cm=this;
            var img = new Image()
            var img2 = new Image()
            var img3 = new Image()
            img.src = 'img/escudo.jpeg'
            img2.src = 'img/EscudoBolivia.png'
            img3.src = 'img/EscudoBolivia2.png'
            doc.addImage(img2, 'png', 1, 0.5, 2.5, 2.5)
            doc.addImage(img, 'jpg', 32, 0.5, 2.5, 2.5)
            doc.addImage(img3, 'png', 6, 6, 22, 12)
            doc.setFont(undefined,'bold')
            doc.setFontSize(12);
            doc.text(15, 1, 'LIBRETA ESCOLAR')
            doc.text(14, 1.5, 'Educacion Secundaria')
            doc.text(5, 2, 'Unidad Educativa:')
            doc.text(5, 2.5, 'Distrito Escolar:')
            doc.text(5, 3, 'Turno:')
            doc.text(20, 2, 'Departamento:')
            doc.text(20, 2.5, 'Dependencia:')
            doc.text(20, 3, 'Gestion:')
            doc.setFont(undefined,'normal')
            doc.text(10, 2, '81230294 -SANTA ROSA2')
            doc.text(10, 2.5, 'ORURO')
            doc.text(10, 3, 'TARDE')
            doc.text(25, 2, 'ORURO')
            doc.text(25, 2.5, 'FISCAL')
            doc.text(25, 3, '2021')
            doc.setLineWidth(0.01)
            doc.line(1,3.1,33,3.1)
            doc.setFont(undefined,'bold')
            doc.text(1, 3.5, 'Codigo rude')
            doc.text(9, 3.5, 'Apellidos Nombres')
            doc.setFont(undefined,'normal')
            doc.text(3, 3.5, estud.rude)
            doc.text(15, 3.5, estud.paterno+' '+estud.materno+' '+estud.nombres)
            doc.line(1,3.6,33,3.6)
            doc.setFont(undefined,'bold')
            doc.text(4, 4,   ' AREAS CURRICULARES ')
            doc.text(15, 4,   '1er ')
            doc.text(18, 4,   '2do ')
            doc.text(21, 4,   '3er ')
            doc.text(25, 4,   'Promedio Anual')
            doc.text(14.5, 4.5, 'Trimestre')
            doc.text(17.5, 4.5, 'Trimestre')
            doc.text(20.5, 4.5, 'Trimestre')
            doc.text(24.5, 4.5, '  Numeral    ')
            doc.text(27, 4.5, '  Literal')
            doc.setFont(undefined,'normal')
    
    
          // doc.setFont("courier");
          //doc.setFontSize(8);
          let y=5
          let promedio
          let ClaseConversor = conversor.conversorNumerosALetras;
          let miConversor = new ClaseConversor();
          let a = ''
          res.data.forEach(r=>{
            y+=0.7
            r.primero=r.primero==null?0:r.primero
            r.segundo=r.segundo==null?0:r.segundo
            r.tercero=r.tercero==null?0:r.tercero
            promedio=Math.round((parseFloat(r.primero)+parseFloat(r.segundo)+parseFloat(r.tercero))/3)
            a=miConversor.convertToText( parseInt(promedio));
            doc.text(2.5, y, r.nombre)
            doc.text(15, y, r.primero+'')
            doc.text(18, y, r.segundo+'')
            doc.text(21, y, r.tercero+'')
            doc.text(25, y, promedio+'')
            doc.text(27, y, a+'')
    
          })
    
          // let sumtotal=0
    
          // doc.text(12, y+4, 'TOTAL RECAUDADCION: ')
          // doc.text(18, y+4, sumtotal+'Bs')
          window.open(doc.output('bloburl'), '_blank');})
        },

        misalumnos(){
          this.$axios.post('/hijos').then(res=>{
            console.log(res.data)
            this.$q.loading.hide()
            this.estudiantes=[]
            res.data[0].estudiantes.forEach(r=>{
              let d=r
              d.nombre=r.nombres
              d.apellidos=r.paterno+' '+r.materno
              this.estudiantes.push(d)
            })
          })
        }
      }
    }
    </script>
    
    <style scoped>
    
    </style>
    