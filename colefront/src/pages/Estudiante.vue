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
            <q-input dense outlined label="Paterno" v-model="dato.paterno" />
          </div>
          <div class="col-12 col-sm-2 q-pa-xs ">
            <q-input dense outlined label="Materno" v-model="dato.materno" />
          </div>
          <div class="col-12 col-sm-2 q-pa-xs ">
            <q-input dense outlined label="Nombres" v-model="dato.nombres" />
          </div>
          <div class="col-12 col-sm-2 q-pa-xs ">
            <q-input dense outlined label="Celular" v-model="dato.celular" />
          </div>
          <div class="col-12 col-sm-2 q-pa-xs ">
            <q-input dense outlined label="Fecha nacimiento" type="date" v-model="dato.fechanac" />
          </div>
          <div class="col-12 col-sm-2 q-pa-xs ">
            <q-select dense outlined label="Tipo" v-model="dato.tipo" :options="['NUEVO','OTROS']" />
          </div>
          <div class="col-12 col-sm-3 q-pa-xs ">
            <q-select outlined dense label="Curso" v-model="curso" :options="cursos"  />
          </div>
          <div class="col-12 col-sm-3 q-pa-xs flex flex-center">
            <q-btn dense color="primary"  class="full-width full-height" icon="add_circle" label="Crear" type="submit"/>
          </div>
        </div>
      </q-form>
    </div>
  </div>
</q-page>
</template>

<script>
import {date} from 'quasar'
export default {
  data(){
    return{
      dato:{ fechanac: date.formatDate(Date.now(),'YYYY-MM-DD')},
      padres:[],
      padre:{},
      newpadre:{ expedido:'OR',fechanac: date.formatDate(Date.now(),'YYYY-MM-DD'),tipo:'PADRE'},
      dialogpadre:false,
      cursos:[],
      curso:{}
    }
  },
  created() {
    this.mispadres()
    this.$q.loading.show()
    this.$axios.get(process.env.API+'/curso').then(res=>{
      this.cursos=[]
      res.data.forEach(r=>{
        let d= r
        d.label=r.nombre
        this.cursos.push(d)
      })
      this.curso=this.cursos[0]
      this.$q.loading.hide()
    })
  },
  methods:{
    buscarestudiante(){

      this.$axios.get(process.env.API+'/estudiante/'+this.dato.carnet).then(res=>{
        if (res.data!=''){
          this.dato.domicilio=res.data.domicilio
          this.dato.paterno=res.data.paterno
          this.dato.materno=res.data.materno
          this.dato.nombres=res.data.nombres
          this.dato.celular=res.data.celular
          this.dato.fechanac=res.data.fechanac
          this.dato.domicilio=res.data.domicilio
          this.dato.domicilio=res.data.domicilio
        }
        // console.log(res.data)
      })
    },
    guardar(){
      this.$q.loading.show()
      this.dato.curso_id=this.curso.id;
      this.dato.padre_id=this.padre.id;
      this.$axios.post(process.env.API+'/estudiante',this.dato).then(res=>{
        this.dato={ fechanac: date.formatDate(Date.now(),'YYYY-MM-DD'),tipo:'PADRE'}
        // this.mispadres()
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
      })
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
