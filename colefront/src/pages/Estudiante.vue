<template>
<q-page>
  <q-dialog full-width v-model="dialogpadre">
    <q-card>
      <q-card-section><div class="text-h6">Nuevo padre de familia</div></q-card-section>
      <q-card-section class="q-pt-none">
        <q-form @submit.prevent="guardarpadre">
          <div class="row">
<!--            <div class="col-12 col-sm-2 q-pa-xs ">-->
<!--              <q-select dense outlined label="Tipo" v-model="newpadre.tipo" :options="['PADRE','TUTOR']" />-->
<!--            </div>-->
            <div class="col-12 col-sm-2 q-pa-xs ">
              <q-input dense outlined label="nombres" v-model="newpadre.nombres" />
            </div>
            <div class="col-12 col-sm-2 q-pa-xs ">
              <q-input dense outlined label="apellidos" v-model="newpadre.apellidos" />
            </div>
            <div class="col-12 col-sm-2 q-pa-xs ">
              <q-input dense outlined label="carnet" v-model="newpadre.carnet" />
            </div>
            <div class="col-12 col-sm-2 q-pa-xs ">
              <q-select dense outlined label="expedido" v-model="newpadre.expedido" :options="['OR','LP','CB','PT','BE','CH','PA','SC','TA']" />
            </div>
            <div class="col-12 col-sm-2 q-pa-xs ">
              <q-input dense outlined label="Fecha nacimiento" type="date" v-model="newpadre.fechanac" />
            </div>
            <div class="col-12 col-sm-2 q-pa-xs ">
              <q-input dense outlined label="email" v-model="newpadre.email" />
            </div>
            <div class="col-12 col-sm-12 q-pa-xs ">
              <q-card-actions align="right" class="bg-white text-teal">
                <q-btn type="submit" dense icon="send" label="Crear" color="positive"/>
                <q-btn color="negative" dense icon="delete"  label="Cerrar" v-close-popup />
              </q-card-actions>
            </div>

          </div>
        </q-form>
      </q-card-section>

    </q-card>
  </q-dialog>
  <div class="row">
    <div class="col-12">
      <q-form @submit.prevent="guardar">
        <div class="row">
          <div class="col-12 col-sm-8 q-pa-xs ">
            <q-select outlined dense label="Padre de familia" v-model="padre" :options="padres"  />
          </div>
          <div class="col-12 col-sm-4 q-pa-xs flex flex-center">
            <q-btn dense color="primary" icon="add_circle" label="DATOS PADRE/MADRE/TUTOR" @click="dialogpadre=true"/>
          </div>
          <div class="col-12 col-sm-2 q-pa-xs ">
            <q-input dense outlined label="Carnet" v-model="dato.carnet" @keyup="buscarestudiante" />
          </div>
          <div class="col-12 col-sm-2 q-pa-xs ">
            <q-input dense outlined label="Domicilio" v-model="dato.domicilio" />
          </div>
          <div class="col-12 col-sm-2 q-pa-xs ">
            <q-input dense outlined label="Paterno" v-model="dato.paterno" style="text-transform: uppercase" />
          </div>
          <div class="col-12 col-sm-2 q-pa-xs ">
            <q-input dense outlined label="Materno" v-model="dato.materno" style="text-transform: uppercase" />
          </div>
          <div class="col-12 col-sm-2 q-pa-xs ">
            <q-input dense outlined label="Nombres" v-model="dato.nombres" style="text-transform: uppercase" />
          </div>
          <div class="col-12 col-sm-2 q-pa-xs ">
            <q-input dense outlined label="Celular" v-model="dato.celular" />
          </div>
          <div class="col-12 col-sm-2 q-pa-xs ">
            <q-input dense outlined label="Fecha nacimiento" type="date" v-model="dato.fechanac" />
          </div>

          <div class="col-12 col-sm-3 q-pa-xs ">
            <q-select outlined dense label="Curso" v-model="curso" :options="cursos"  @update:model-value="listado"/>
          </div>
          <div class="col-12 col-sm-3 q-pa-xs flex flex-center">
            <q-btn dense color="warning" v-if="dato.id>0" class="full-width full-height" icon="edit" label="Editar" type="submit"/>
            <q-btn dense color="primary"  v-else class="full-width full-height" icon="add_circle" label="Crear" type="submit"/>
          </div>
        </div>
      </q-form>
      <q-table  title="Estudiantes" :rows="estudiantes" :columns="columns"       :filter="filter" :rows-per-page-options="[50,100,200,0]">
        <template v-slot:body-cell-curso="props">
          <q-td :props="props">
            {{props.row.curso.nombre}}
          </q-td>
        </template>
        <template v-slot:body-cell-paralelo="props">
          <q-td :props="props">
            {{props.row.curso.paralelo}}
          </q-td>
        </template>
        <template v-slot:body-cell-opcion="props">
          <q-td :props="props">
<!--            {{props.row}}-->
            <q-btn label="Boleta" size="xs" icon="print" @click="imprimir(props.row)" color="primary"/>
          </q-td>
        </template>
        <template v-slot:top-right>
          <q-input outlined dense debounce="300" v-model="filter" placeholder="Buscar..">
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>
        </template>
      </q-table>
    </div>
  </div>
</q-page>
</template>

<script>
import {date} from 'quasar'
export default {
  data(){
    return{
      filter:'',
      dato:{ fechanac: date.formatDate(Date.now(),'YYYY-MM-DD')},
      padres:[],
      padre:{},
      newpadre:{ expedido:'OR',fechanac: date.formatDate(Date.now(),'YYYY-MM-DD'),tipo:'PADRE'},
      dialogpadre:false,
      cursos:[],
      curso:{},
      estudiantes:[],
      columns: [
        {
          name: 'carnet',
          required: true,
          label: 'Carnet',
          align: 'left',
          field: 'carnet',
          sortable: true
        },
        { name: 'nombres', align: 'center', label: 'nombres', field: 'nombres', sortable: true },
        { name: 'paterno', align: 'center', label: 'paterno', field: 'paterno', sortable: true },
        { name: 'materno', align: 'center', label: 'materno', field: 'materno', sortable: true },
        { name: 'curso', align: 'center', label: 'curso', field: row=>row.nombre, sortable: true },
        { name: 'paralelo', align: 'center', label: 'paralelo', field: row=>row.paralelo, sortable: true },
        { name: 'opcion', align: 'center', label: 'opcion', field: 'opcion', sortable: true },
]
    }
  },
  created() {
    this.mispadres()
    this.$q.loading.show()
    this.$axios.get(process.env.API+'/curso').then(res=>{
      this.cursos=[]
      res.data.forEach(r=>{
        let d= r
        d.label=r.nombre +' ' + r.paralelo
        this.cursos.push(d)
      })
      // console.log(this.cursos)
      this.curso=this.cursos[0]
      this.$q.loading.hide()
    }),
    this.listado()
  },
  methods:{
    imprimir(estudiante){
      console.log(estudiante)
      var myWindow = window.open("", "myWindow", "width=1200,height=500");
      myWindow.document.write("<style>" +
        "*{" +
        "padding: 0px," +
        "margin: 0px," +
        "border: 0px," +
        "}" +
        "</style>" +
        "<div style='font-weight: bold;font-size: 12px;text-align: center'>BOLETA DE INSCRIPCION</div><hr>" +
        "<table style='border-collapse: collapse;border: 1px solid black'>" +
        "<tr></tr>" +
        "</table>");
      myWindow.document.close();
      myWindow.focus();
      myWindow.print();
      myWindow.close();
    },
    listado(){
      this.$axios.post(process.env.API+'/listado').then(res=>{
        this.estudiantes=res.data;
        console.log(this.estudiantes)
      })
    },
    buscarestudiante(){

      this.$axios.get(process.env.API+'/estudiante/'+this.dato.carnet).then(res=>{
        if (res.data!=''){
          this.dato.id=res.data.id
          this.dato.paterno=res.data.paterno
          this.dato.materno=res.data.materno
          this.dato.nombres=res.data.nombres
          this.dato.celular=res.data.celular
          this.dato.fechanac=res.data.fechanac
          this.dato.domicilio=res.data.domicilio
        }
        else {this.dato={carnet:this.dato.carnet, fechanac: date.formatDate(Date.now(),'YYYY-MM-DD')}}
        // console.log(res.data)
      })
    },
    guardar(){
      this.$q.loading.show()
      this.dato.curso_id=this.curso.id;
      this.dato.padre_id=this.padre.id;
      if(this.dato.id>0)
      {
      this.$axios.put(process.env.API+'/estudiante/'+this.dato.id,this.dato).then(res=>{
        this.dato={ fechanac: date.formatDate(Date.now(),'YYYY-MM-DD'),tipo:'PADRE'}
        // this.mispadres()
        this.listado()
        this.$q.loading.hide()
        // this.dialogpadre=false
        this.$q.notify({
          message:"Estudiante modificado!!!",
          color:'green',
          icon:'done'
        })
      }).catch(err=>{
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          icon:'red'
        })
        this.$q.loading.hide()
      })}
      else {
      this.$axios.post(process.env.API+'/estudiante',this.dato).then(res=>{
        // console.log(res.data)
        // return false
        this.dato={ fechanac: date.formatDate(Date.now(),'YYYY-MM-DD'),tipo:'PADRE'}
        // this.mispadres()
        this.listado()
        this.$q.loading.hide()
        // this.dialogpadre=false
        this.$q.notify({
          message:"Estudiante inscrito!!!",
          color:'green',
          icon:'done'
        })
      }).catch(err=>{
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          icon:'red'
        })
        this.$q.loading.hide()
      })}
    },
    guardarpadre(){
      this.$q.loading.show()
      this.newpadre.tipo='PADRE'
      this.$axios.post(process.env.API+'/padre',this.newpadre).then(res=>{
        this.newpadre={ expedido:'OR',fechanac: date.formatDate(Date.now(),'YYYY-MM-DD'),tipo:'PADRE'}
        this.mispadres()
        this.$q.loading.hide()
        this.dialogpadre=false
        this.$q.notify({
          message:"Padre tutor inscrito!!!",
          color:'green',
          icon:'done'
        })
      }).catch(err=>{
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          icon:'red'
        })
        this.$q.loading.hide()
      })
    },
    mispadres(){
      this.$axios.get(process.env.API+'/padre').then(res=>{
        this.padres=[]
        res.data.forEach(r=>{
          let d= r
          d.label=r.nombres+' '+r.apellidos
          this.padres.push(d)
        })
        this.padre=this.padres[0]
      })
    }
  }
}
</script>

<style scoped>

</style>
