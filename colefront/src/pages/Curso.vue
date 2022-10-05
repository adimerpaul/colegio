<template>
  <div class="q-pa-md">
    <q-btn
      label="Nuevo Curso"
      color="positive"
      @click="alert = true"
      icon="add_circle"
      class="q-mb-xs"
    />

    <q-dialog v-model="alert">
      <q-card style="max-width: 80%; width: 50%">
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h7"><q-icon name="add_circle" /> REGISTRO DE CURSO</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-input
                  filled
                  v-model="dato.nombre"
                  type="text"
                  label=" Curso/ Grado"
                  hint="Ingresar Curso"
                  lazy-rules
                  :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
                />

                <q-input
                  filled
                  v-model="dato.paralelo"
                  type="text"
                  label="Paralelo"
                  hint="Ingresar paralelo"
                  lazy-rules
                  :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
                />
            <div>
              <q-btn label="Agregar" type="submit" color="positive" icon="add_circle" />
              <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

    <q-table dense :filter="filter" title="LISTA DE CURSOS Y PARALELOS" :rows="data" :columns="columns" row-key="name" :rows-per-page-options="[50,100]">
      <template v-slot:top-right>
        <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>
      <template v-slot:body-cell-opcion="props">
<!--        <q-tr :props="props">-->
          <q-td key="opcion" :props="props">
            <q-btn
            dense
            round
            flat
            color="accent"
            @click="matRow(props)"
            icon="class"
          />
            <q-btn
              dense
              round
              flat
              color="yellow"
              @click="editRow(props)"
              icon="edit"
            />
            <q-btn
              dense
              round
              flat
              color="red"
              @click="deleteRow(props)"
              icon="delete"
            ></q-btn>
          </q-td>

<!--        </q-tr>-->
      </template>
    </q-table>

    <q-dialog v-model="dialog_mod">
      <q-card style="max-width: 80%; width: 50%">
        <q-card-section class="bg-warning text-white">
          <div class="text-h7"> <q-icon name="edit"/> MODIFICAR DATOS DE CURSO</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form @submit="onMod" class="q-gutter-md">
            <q-input
              filled
              v-model="dato2.nombre"
              type="text"
              label="CURSO/GRADO "
              hint="Ingresar Nombre"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />
            <q-input
              filled
              v-model="dato2.paralelo"
              type="text"
              label="paralelo"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />
            <div>
              <q-btn label="Modificar" type="submit" color="positive" icon="add_circle" />
              <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>


    <q-dialog v-model="dialog_del">
      <q-card>
        <q-card-section class="row items-center">
          <q-avatar icon="clear" color="red" text-color="white" />
          <span class="q-ml-sm">Seguro de eliminar Registro.</span>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="Eliminar" color="deep-orange" @click="onDel" />
          <q-btn flat label="Cancelar" color="primary" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>

    <q-dialog v-model="dialog_mat">
      <q-card>
        <q-card-section class="row items-center">
          <q-avatar icon="class" color="green" text-color="white" />
          <span class="q-ml-sm">LISTA DE MATERIAS.</span>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <div class="row">
            <div class="col-6" v-for=" m in materias " :key="m" ><q-checkbox v-model="lmaterias" :val="m.id" :label="m.nombre" color="teal" /></div>
          </div>
        </q-card-section>
        <q-card-actions align="right">
          <q-btn flat label="Modificar" color="yellow" @click="updateMat" />
          <q-btn flat label="Cancelar" color="primary" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>

  </div>
</template>

<script>
import { date } from 'quasar'
const { addToDate } = date
export default {
  data() {
    return {
      alert: false,
      dialog_mod: false,
      dialog_del: false,
      dialog_mat: false,
      filter:'',
      lmaterias:[],
      dato: {
      },
      model:'',
      dato2: {},
      options: [],
      props: [],
      unidades:[],
      permisos:[],
      permisos2:[],
      materias:[],
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
    this.listMateria();
  },
  methods: {
    updateMat(){
      this.$axios.post(process.env.API + "/upMateriaCurso",{curso:this.curso.id,materias:this.lmaterias}).then((res) => {
        this.dialog_mat=false
      })

    },
    matRow(c){
      this.curso=c.row
      this.lmaterias=[]
      this.$axios.post(process.env.API + "/recperaMat",{curso:this.curso.id}).then((res) => {
        console.log(res.data)
        res.data.forEach(e => {
          this.lmaterias.push(e.materia_id)
          
        });
      this.dialog_mat=true})
    },
    listMateria(){
      this.$axios.get(process.env.API + "/materia").then((res) => {
        // console.log(res.data)
        this.materias = res.data;
      });
    },
    misdatos() {
      this.$q.loading.show();
      this.$axios.get(process.env.API + "/curso").then((res) => {
        // console.log(res.data)
        this.data = res.data;
        this.$q.loading.hide();
      });
    },
    editRow(item) {
      this.dato2 = item.row
      this.dialog_mod = true;
    },
    deleteRow(item) {
      this.dato2 = item.row;
      this.dialog_del = true;
    },
    onSubmit() {
      this.$q.loading.show();
      this.$axios.post(process.env.API + "/curso", this.dato).then((res) => {
        // console.log(res.data)
        this.alert=false;
        this.misdatos();
        this.$q.notify({
          color: "green-4",
          textColor: "white",
          icon: "cloud_done",
          message: "Creado correctamente",
        });
        this.misdatos();
      }).catch(err=>{
        console.log(err.response.data);
        this.$q.notify({
          message:err.response.data.message,
          icon:'close',
          color:'red'
        })
        this.$q.loading.hide()
      })
    },
    onMod() {


      this.$q.loading.show();
      this.$axios.put(process.env.API + "/curso/" + this.dato2.id, this.dato2).then((res) => {
        // console.log(res.daa)
        this.$q.notify({
          color: "green-4",
          textColor: "white",
          icon: "cloud_done",
          message: "Modificado correctamente",
        });
        this.dialog_mod = false;
        this.misdatos();
      });
    },
    onDel() {
      this.$q.loading.show();
      this.$axios.delete(process.env.API + "/curso/" + this.dato2.id)
        .then((res) => {
          this.$q.notify({
            color: "green-4",
            textColor: "white",
            icon: "cloud_done",
            message: "Eliminado correctamente",
          });
          this.dialog_del = false;
          this.misdatos();
        }).catch(err=>{
        this.$q.loading.hide()
        this.$q.notify({
          message:err.response.data.message,
          icon:'error',
          color:'red'
        })
      })
    },
    onReset() {
      this.dato.nombre = '';
      this.dato.codigo = '';
    },
  },
};
</script>
