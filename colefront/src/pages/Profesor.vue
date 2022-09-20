<template>
  <div class="q-pa-md">

    <q-table dense :filter="filter" title="LISTA DE PROFESORES" :rows="data" :columns="columns" row-key="name" :rows-per-page-options="[50,100]">
      <template v-slot:top-right>
         <q-btn color="info"  icon="print" @click="printpdf"/>
        
        <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>

      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td key="nombres" :props="props">
            {{props.row.nombres}}
          </q-td>
         <q-td key="apellidos" :props="props">
            {{props.row.apellidos}}
          </q-td>
         <q-td key="carnet" :props="props">
                     {{props.row.carnet}}
          </q-td>
          <q-td key="materias" :props="props">
            <ul v-for=" m in props.row.materias" :key="m">
            <li> {{m.nombre}}</li>
            </ul>
          </q-td>
          <q-td key="cursos" :props="props">
            <ul v-for=" c in props.row.cursos" :key="c">
            <li> {{c.nombre}} {{c.paralelo}}</li>
            </ul>
          </q-td>
          <q-td key="email" :props="props">
            {{props.row.email}}
          </q-td>
                             <q-td key="fechalimite" :props="props">
                     {{props.row.fechalimite}}
          </q-td>
          <q-td key="opcion" :props="props">
            <q-btn dense round flat color="accent" @click="vermaterias(props.row)"  icon="menu_book"/>
            <q-btn dense round flat color="cyan" @click="vercursos(props.row)"  icon="history_edu"/>
            <q-btn dense round flat color="yellow" @click="editRow(props)"  icon="edit"/>

            <q-btn dense round flat color="red" @click="deleteRow(props)" icon="delete"/>
          </q-td>
        </q-tr>

      </template>
    </q-table>

    <q-dialog v-model="dialog_mod">
      <q-card style="max-width: 80%; width: 50%">
        <q-card-section class="bg-warning text-white">
          <div class="text-h7"> <q-icon name="edit"/> MODIFICAR DATOS DE USUARIO</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form @submit="onMod" class="q-gutter-md">
            <q-input
              filled
              v-model="dato2.nombres"
              type="text"
              label="Nombres "
              hint="Ingresar Nombre"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />
            <q-input
              filled
              v-model="dato2.apellidos"
              type="text"
              label="Apellidos "
              hint="Ingresar apellido"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />
            <q-input
              filled
              v-model="dato2.carnet"
              type="text"
              label="Carnet"
              hint="Carnet de identidad"
              lazy-rules
              :rules="[(val) => (val && val.length > 0) || 'Por favor ingresa datos']"
            />

            <q-input
              filled
              label="Fecha limite"
              type="date"
              v-model="dato2.fechalimite"
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

    <q-dialog v-model="modelpermiso">
      <q-card style="width: 700px;max-width: 80vw">
        <q-card-section class="bg-info">
          <div class="text-h7 text-white"><q-icon name="folder"/> PERMISOS DE ACCESO</div>
        </q-card-section>
        <q-card-section>
          <q-form @submit.prevent="updatepermisos">
            <!--          v-on:click.native="updatepermiso(permiso)"-->
            <q-checkbox style="width: 100%"  v-for="(permiso,index) in permisos2" :key="index" :label="permiso.nombre" v-model="permiso.estado" />
            <!--          <q-form>-->
            <!--&lt;!&ndash;            <q-checkbox v-model="permisos" />&ndash;&gt;-->
            <!--          </q-form>-->
            <q-btn  type="submit" color="info" icon="send" label="Actualizar"></q-btn>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

    <q-dialog v-model="dialogMateria" >
      <q-card style="min-width: 350px">
        <q-card-section>
          <div class="text-h6">MATERIAS</div>
        </q-card-section>

        <q-card-section class="q-pt-none">
         <div class="row" >
            <div class="col-4" v-for=" m in materias " :key="m" ><q-checkbox v-model="lmaterias" :val="m.id" :label="m.nombre" color="teal" /></div>
         </div>
        </q-card-section>

        <q-card-actions align="right" class="text-primary">
          <q-btn flat label="CANCELAR" v-close-popup />
          <q-btn flat label="MODIFICAR" @click="modmateria" />
        </q-card-actions>
      </q-card>
    </q-dialog>

    <q-dialog v-model="dialogCurso" >
      <q-card style="min-width: 350px">
        <q-card-section>
          <div class="text-h6">CURSOS</div>
        </q-card-section>

        <q-card-section class="q-pt-none">
         <div class="row" >
            <div class="col-4" v-for=" c in cursos " :key="c" ><q-checkbox v-model="lcursos" :val="c.id" :label="c.nombre+' ' +c.paralelo" color="teal" /></div>
         </div>
        </q-card-section>

        <q-card-actions align="right" class="text-primary">
          <q-btn flat label="CANCELAR" v-close-popup />
          <q-btn flat label="MODIFICAR" @click="modcurso" />
        </q-card-actions>
      </q-card>
    </q-dialog>

  </div>
</template>

<script>
import { date } from 'quasar'
import jsPDF from "jspdf";

const { addToDate } = date
export default {
  data() {
    return {
      alert: false,
      dialogMateria:false,
      dialogCurso:false,
      dialog_mod: false,
      dialog_del: false,
      filter:'',
      lmaterias:[],
      lcursos:[],
      dato: {
        fechalimite:date.formatDate( addToDate(new Date(),{days:7}) , 'YYYY-MM-DD')
      },
      model:'',
      dato2: {},
      options: [],
      props: [],
      unidades:[],
      permisos:[],
      permisos2:[],
      materias:[],
      cursos:[],
      usuario:{},
      modelpermiso:false,
      uni:{},
      columns: [
        {name: "nombres", align: "left", label: "NOMBRE", field: "nombres", sortable: true,},
        {name: "apellidos", align: "left", label: "APELLIDOS ", field: "apellidos", sortable: true,},
         {name: "carnet", align: "left", label: "CARNET ", field: "carnet", sortable: true,},
         {name: "materias", align: "left", label: "MATERIAS ", field: row=>row.materias},
         {name: "cursos", align: "left", label: "CURSOS ", field: row=>row.cursos},
        {name: "email", align: "left", label: "E-MAIL", field: "email", sortable: true,},
        {name: "fechalimite", align: "left", label: "FECHA LÍMITE", field: "fechalimite", sortable: true,},
        { name: "opcion", label: "OPCIÓN", field: "action", sortable: false },
      ],
      data: [],
    };
  },
  created() {
    // if (!this.$store.state.boolusuario){
    //   // this.router.push('/')
    // }
    this.misdatos();

    this.$axios.get(process.env.API+'/permiso').then(res=>{
      res.data.forEach(r=>{
        this.permisos.push({id:r.id,nombre:r.nombre,estado:false})
        this.permisos2.push({id:r.id,nombre:r.nombre,estado:false})
      })
    })
    this.listmaterias();
    this.listcursos();
  },
  methods: {
    printpdf(){
      let cm=this;
      function header(){
        var img = new Image()
        img.src = 'img/escudo.jpeg'
        doc.addImage(img, 'jpg', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(5, 1, 'LISTA DE PROFESORES')
        doc.text(1, 3, 'ID')
        doc.text(3, 3, 'NOMBRES')
        doc.text(6, 3, 'APELLIDOS')
        doc.text(9, 3, 'CI')
        doc.text(14, 3, 'MATERIAS')
        doc.setFont(undefined,'normal')
      }
      var doc = new jsPDF('p','cm','letter')
      doc.setFontSize(10);
      header()
      doc.setFontSize(8);
      let y=0 
      this.data.forEach(r=>{
        console.log(r)
        y+=0.5
        doc.text(1, y+3, r.id+'')
        doc.text(3, y+3, r.nombres+'')
        doc.text(6, y+3, r.apellidos+'')
        doc.text(9, y+3, r.carnet+'')
        r.materias.forEach(m=>{
          doc.text(14, y+3, m.nombre+'')
          y+=0.5
          if(y+0.5>=27){
            doc.addPage()
            header()
            y=0
          }
        })
        if(y+0.5>=27){
            doc.addPage()
            header()
            y=0
          }
      })
      window.open(doc.output('bloburl'), '_blank');
    },
    modmateria(){
      this.$axios.post(process.env.API+'/asignarMateria',{user:this.usuario,materias:this.lmaterias}).then(res=>{
        console.log(res.data)
        this.$q.notify({
          color: "green-4",
          textColor: "white",
          icon: "cloud_done",
          message: "Modificado correctamente",
        });
        this.dialogMateria=false
        this.misdatos();
      })

    },
    modcurso(){
      this.$axios.post(process.env.API+'/asignarCurso',{user:this.usuario,cursos:this.lcursos}).then(res=>{
        this.$q.notify({
          color: "green-4",
          textColor: "white",
          icon: "cloud_done",
          message: "Modificado correctamente",
        });
        this.dialogCurso=false
        this.misdatos()
      }) 
    },
    vermaterias(user){
      this.usuario=user
      this.lmaterias=[]
      this.usuario.materias.forEach(r=>{
        this.lmaterias.push(r.id)
      })
      console.log(this.lmaterias)
      this.dialogMateria=true
    },
    vercursos(user){
      this.usuario=user
      this.lcursos=[]
      console.log(this.usuario)
      this.usuario.cursos.forEach(r=>{
        this.lcursos.push(r.id)
      })
      console.log(this.lcursos)
      this.dialogCurso=true
    },
    listmaterias(){
      this.$axios.get(process.env.API+'/materia').then(res=>{
        
        this.materias=res.data
      })
    },
    listcursos(){
      this.$axios.get(process.env.API+'/curso').then(res=>{
        this.cursos=res.data
      })
    },
    updatepermisos(){
      this.$axios.put(process.env.API+'/updatepermisos/'+this.dato2.id,{permisos:this.permisos2}).then(res=>{
        // console.log(res.data)
        this.modelpermiso=false
        this.misdatos()
      }).catch(err=>{
        this.$q.notify({
          message:err.response.data.message,
          icon:'close',
          color:'red'
        })
      })
    },
    mispermisos(i){
      // console.log(i.row)
      this.modelpermiso=true
      this.dato2=i.row
      // console.log(this.dato2.permisos)
      // return false
      let p;
      // this.permisos2.forEach(r=>{
      //
      // })
      this.permisos2.forEach(pe=>{
        // console.log(pe);
        p=this.dato2.permisos.find(r=>r.pivot.permiso_id==pe.id)
        // console.log(p)
        if (p!=undefined)
          pe.estado=true
        else
          pe.estado=false
        // console.log(p)
      })
    },
    misdatos() {
      this.$q.loading.show();
      this.$axios.post(process.env.API + "/listprofesor").then((res) => {
        console.log(res.data)
        this.data = res.data;
        this.$q.loading.hide();
      });
    },
    editRow(item) {
      this.dato2 = item.row
      this.dato2.unid_id = item.row.unid
      // console.log(this.dato2)
      this.dialog_mod = true;
    },
    deleteRow(item) {
      this.dato2 = item.row;
      this.dialog_del = true;
    },

    onMod() {


      this.$q.loading.show();
      this.$axios.put(process.env.API + "/user/" + this.dato2.id, {
        name:this.dato2.name,
        // password:this.dato2.password,
        // name:this.dato2.name,
        email:this.dato2.email,
        carnet:this.dato2.carnet,
        celular:this.dato2.celular,
        tipo:this.dato2.tipo,
        fechalimite:this.dato2.fechalimite,
        // codigo:this.dato2.codigo,
      }).then((res) => {
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
      this.$axios.delete(process.env.API + "/user/" + this.dato2.id)
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
      this.dato.nombre = null;
      this.dato.inicio = 0;
      this.dato.fin = 0;
    },
    cambiopass (i) {
      // console.log(i.row);
      this.$q.dialog({
        title: 'CAMBIAR PASSWORD',
        message: 'Ingresar nueva contraseña',
        prompt: {
          model: '',
          type: 'password' // optional
        },
        cancel: true,
        persistent: true
      }).onOk(data => {
        // console.log('>>>> OK, received', data)
        this.$q.loading.show()
        this.$axios.put(process.env.API+'/pass/'+i.row.id,{password:data}).then(res=>{
          // console.log(res.data)
          this.$q.loading.hide()
        })
      }).onCancel(() => {
        // console.log('>>>> Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
    }
  },
};
</script>
