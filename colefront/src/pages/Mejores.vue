<template>
    <div class="q-pa-md">
        <div class="row">
            <div class="col-4"><q-select square outlined v-model="curso" :options="data" label="CURSO" /></div>
            <div class="col-4"><q-select square outlined v-model="trimestre" :options="periodo" label="TRIMESTRE" /></div>
            <div class="col-4"><q-btn  label="GENERAR" color="positive"  @click="generar"  icon="add_circle" class="q-mb-xs"/></div>
            
        </div>
  
  
      <q-table dense :filter="filter" title="ESTUDIANTES" :rows="calificacion"  row-key="name" :rows-per-page-options="[50,100]">
        <template v-slot:top-right>
          <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>
        </template>

      </q-table>
      <div id="impnota">
      <table>
        <thead>
          <tr id="htmlencabezado">
            
          </tr>
        </thead>
        <tbody id="cuerpo">

        </tbody>
      </table>
    </div>
    </div>
  </template>
  
  <script>
  import { date } from 'quasar'
import {Printd} from "printd";

  const { addToDate } = date

  export default {
    data() {
      return {
        filter:'',
        lmaterias:[],
        dato: { },
        trimestre:'PRIMER TRIMESTRE',
        model:'',
        dato2: {},
        options: [],
        props: [],
        unidades:[],
        permisos:[],
        permisos2:[],
        materias:[],
        calificacion:[],
        encabezado:'',
        cuerponota:'',
        numero:0,
        periodo:['PRIMER TRIMESTRE','SEGUNDO TRIMESTRE','TERCER TRIMESTRE','ANUAL'],
        curso:{},
        modelpermiso:false,
        uni:{},
        columns: [
          {name: "nombre", align: "left", label: "MATERIA ", field: "nombre", sortable: true,},
          {name: "paralelo", align: "left", label: "paralelo", field: "paralelo", sortable: true,},
          { name: "opcion", align:"center",label: "OPCIÓN", field: "action", sortable: false },
        ],
        data: [],
      };
    },
    created() {
      // if (!this.$store.state.boolusuario){
      //   // this.router.push('/')
      // }
      
      this.misdatos();
    },
    methods: {
        generar(){
            this.materias=[]
            this.cadena='<style>\
              table {\
                font-size: 10 px;\
                width: 100%;\
                border-collapse: collapse;\
              }\
              table, th, td {\
                border: 1px solid;\
              }\
              thead{\
                background-color: #12EA00;\
              }\
              .titulo{fontsize:14px;\
                text-align: center;\
                font-weight: bold;}\
              </style>\
              <div class="titulo">CENTRALIZADOR DE NOTAS'+this.trimestre+' CURSO: '+this.curso.label+'</div>\
            <table><thead>\
            <tr ><th>No</th><th>ESTUDIANTE</th>'
            this.cuerponota=''
            let campo=''
            let color=''
            this.curso.materias.forEach(r=>{
                this.materias.push({id:r.id,nombre:r.nombre})
            })
            this.numero=this.materias.length
            console.log(this.materias)
          this.$axios.post(process.env.API + "/notaMejor",{curso:this.curso.id,materias:this.materias,trim:this.trimestre}).then((res) => {
            console.log(res.data)
            this.calificacion=res.data
            for(let i=0;i<this.numero;i++){
              this.cadena+="<th>"+this.materias[i].nombre+"</th>"
            }
              this.cadena+="<th>PROMEDIO</th> </tr></thead><tbody >"
            let i=1
            this.calificacion.forEach(r=>{
              this.cadena+="<tr><td>"+i+"</td><td>"+r.paterno+' '+r.materno+' '+r.nombres+"</td>"
                this.materias.forEach(m=>{
                  campo=m.nombre
                  console.log(r[campo])
                  if(r[campo]==null) r[campo]=0
                  if(r[campo]<51) color='red' 
                  else color='black'
                  this.cadena+="<td style='color:"+color+"'>"+r[campo]+"</td>"
                })
                if(r.promedio==null) r.promedio=0
                if(r.promedio<51) color='red' 
                  else color='black'
                this.cadena+="<td style='color:"+color+"'>"+r.promedio+"</td></tr>"
              console.log(r)
              i++
            })
            this.cadena+="</tbody></table>"
            document.getElementById('impnota').innerHTML = this.cadena
            console.log(this.cuerponota)
            const d = new Printd()
            d.print( document.getElementById('impnota') )

          })  
        },
      misdatos() {
        this.data=[]
        this.$q.loading.show();
        this.$axios.get(process.env.API + "/curso").then((res) => {
           console.log(res.data)
           res.data.forEach(r=>{
                r.label=r.nombre+' '+r.paralelo
            this.data.push(r)

           })
           this.curso=this.data[0]
          this.$q.loading.hide();
        });
      },

    },
  };
  </script>

  