<template>
  <div class="q-pa-md">
    <div class="text-h6">LISTADO DE LIBROS</div >
    <q-btn label="Nuevo Libro" color="positive" @click="alert = true" icon="add_circle" class="q-mb-xs" />

    <q-dialog v-model="alert" >
      <q-card style="width: 700px; max-width: 80vw;">
        <q-card-section class="bg-green-14 text-white">
          <div class="text-h6"> <q-icon name="add_circle"/> Agregar Libro</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form
            @submit="onSubmit"
            @reset="onReset"
            class="q-gutter-md"
          >
        <div class="row">
           <div class="col-6">
            <q-input
              outlined
              dense
              v-model="dato.titulo"
              type="text"
              label="Titulo"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa titulo']"
            />
              </div>
              <div class="col-6">
            <q-input
              outlined
              dense
              v-model="dato.autor"
              type="text"
              label="Autor"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa autor']"
            />
              </div>
              <div class="col-6">
               <q-input
                outlined
                dense
                v-model="dato.editorial"
                type="text"
                label="Editorial"
                lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa editorial']"
              />
              </div>
          <div class="col-3">
            <q-select dense outlined  v-model="materia" :options="materias" label="Materia" required/>
          </div>
          <div class="col-3">
            <q-select dense outlined  v-model="curso" :options="cursos" label="Curso" required/>
          </div>
          <div class="col-6 ">
            <label for="">ARCHIVO</label><br>
            <input type="file" @change="getArch" >
            <div v-if="porcentaje >0" class="red">Subiendo ...{{porcentaje}}%</div>
          </div>
          <div class="col-6">
            <label for="">IMAGEN</label>
            <input type="file" @change="getImage" >
          </div>
          <div>
            <q-btn label="Crear" type="submit" color="positive" icon="add_circle"/>
            <q-btn  label="Cancelar" icon="delete" color="negative" v-close-popup />
          </div>
            </div>
          </q-form>
        </q-card-section>


      </q-card>
    </q-dialog>

    <q-table
      title="Libros"
      :rows="data"
      :columns="columns"
      :filter="filter"
      row-key="name"
      :rows-per-page-options="[50,100,200,0]"
    >
          <template v-slot:top-right>
        <q-input borderless dense debounce="300" v-model="filter" placeholder="Buscar">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>

      <template v-slot:body-cell-archivo="props">
        <q-td key="archivo" :props="props">
          <a :href="url+'/../archivos/'+props.row.archivo" target="_blank">{{props.row.archivo}}</a>
        </q-td>
      </template>
      <template v-slot:body-cell-imagen="props">
        <q-td key="imagen" :props="props" style="  display: flex; height: 80px; justify-content: center;">
          <div style="width:80px;height:80px;display: block;"><q-img :src="url+'/../imagenes/'+props.row.imagen"  /></div>
        </q-td>
      </template>
      <template v-slot:body-cell-opcion="props">
          <q-td key="opcion" :props="props">
            <q-btn-group>
              <q-btn dense round flat color="yellow" @click="editRow(props)" icon="edit"></q-btn>
              <q-btn dense round flat color="accent" @click="archRow(props)" icon="upload_file"></q-btn>
              <q-btn dense round flat color="accent" @click="imgRow(props)" icon="image"></q-btn>
              <q-btn dense round flat color="red" @click="deleteRow(props)" icon="delete"></q-btn>
            </q-btn-group>
          </q-td>
      </template>

    </q-table>

    <q-dialog v-model="dialog_mod">
      <q-card>
        <q-card-section class="bg-amber-14 text-white">
          <div class="text-h6">Modificar</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form
            @submit="onMod"
            class="q-gutter-md"
          >
            <div class="row">
                          <div class="col-6">

            <q-input
              outlined
              dense
              v-model="dato2.titulo"
              type="text"
              label="Titulo"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa titulo']"
            />
              </div>
              <div class="col-6">

            <q-input
              outlined
              dense
              v-model="dato2.autor"
              type="text"
              label="Autor"
              lazy-rules
              :rules="[ val => val && val.length > 0 || 'Por favor ingresa autor']"
            />
              </div>
              <div class="col-6">
               <q-input
                outlined
                dense
                v-model="dato2.editorial"
                type="text"
                label="Editorial"
                lazy-rules
                :rules="[ val => val && val.length> 0 || 'Por favor editorial']"
              />
              </div>
            <q-select outlined  v-model="materia" :options="materias" label="Materia" required/>
            <q-select outlined  v-model="curso" :options="cursos" label="Curso" required/>

            </div>

           <div>
<br>
              <q-btn label="Modificar" type="submit" color="positive" icon="add_circle"/>
                <q-btn  label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

    <q-dialog v-model="dialog_arch">
      <q-card>
        <q-card-section class="bg-amber-14 text-white">
          <div class="text-h6">Archivo Subir</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form
            @submit="onArch"
            class="q-gutter-md"
          >
            <input type="file" @change="getArch" >
            <div><br>
              <q-btn label="Modificar" type="submit" color="positive" icon="add_circle"/>
              <q-btn  label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

        <q-dialog v-model="dialog_img">
      <q-card>
        <q-card-section class="bg-amber-14 text-white">
          <div class="text-h6">Imagen Subir</div>
        </q-card-section>
        <q-card-section class="q-pt-xs">
          <q-form
            @submit="onImg"
            class="q-gutter-md"
          >
            <input type="file" @change="getImage" >

            <div>
<br>
              <q-btn label="Modificar" type="submit" color="positive" icon="add_circle"/>
                <q-btn  label="Cancelar" icon="delete" color="negative" v-close-popup />
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

    <q-dialog v-model="dialog_del" >
      <q-card>
        <q-card-section class="row items-center">
          <q-avatar icon="clear" color="red" text-color="white" />
          <span class="q-ml-sm">Seguro de eliminar Registro.</span>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="Eliminar" color="deep-orange" @click="onDel"/>
          <q-btn flat label="Cancelar" color="primary" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>

  </div>

</template>

<script>
import {date} from "quasar";

export default {
  data () {
    return {
      url:process.env.API,
      imagen : null,
      archivo : null,
      fecha:{
        inicio:date.formatDate(Date.now(),'YYYY-MM-DD'),
        fin:date.formatDate(Date.now(),'YYYY-MM-DD'),
      },
      alert: false,
      dialog_mod:false,
      dialog_del:false,
      dialog_ver:false,
      dialog_arch:false,
      dialog_img:false,
      boolmod:false,
      nameFile:'',
      filter:'',
      filter2:'',
      dato:{fondo:'APMT',gestion:date.formatDate(Date.now(),'YYYY'),tomo:'1',numtotal:'1'},
      dato2:{},
      subc:{},
      modprod:{},
      cat:[],
      subcat:[],
      materias:[],
      materia:{},
            cursos:[],
      curso:{},
      columns: [
        {name: 'titulo', label: 'TITULO', align: 'left', field: 'titulo', sortable: true},
        {name: 'autor', label: 'AUTOR', align: 'left', field: 'autor', sortable: true},
        { name: 'editorial', align: 'center', label: 'EDITORIAL', field: 'editorial', sortable: true },
        { name: 'archivo', align: 'center', label: 'ARCHIVO', field: 'archivo', sortable: true },
        { name: 'imagen', align: 'center', label: 'IMAGEN', field: 'imagen', sortable: true },
        { name: 'materia', align: 'center', label: 'MATERIA', field: row=>row.materia.nombre, sortable: true },
        { name: 'curso', align: 'center', label: 'CURSO', field: row=>row.curso.nombre+' '+row.curso.paralelo, sortable: true },
        { name: 'opcion', label: 'OPCION', field:'opcion'}

      ],
      data: [
      ],
      prod2: [
      ],
      porcentaje:0,
    }
  },
  created() {
      this.mismaterias();
    this.misdatos();
    this.miscursos();

  },
  methods:{

      mismaterias(){
          this.materias=[]
        this.$axios.get(process.env.API+'/materia').then(res=>{
            res.data.forEach(r => {
                this.materias.push({label:r.nombre,r});
            });
            this.materia=this.materias[0]
        })

      },
            miscursos(){
          this.cursos=[]
        this.$axios.get(process.env.API+'/curso').then(res=>{
            res.data.forEach(r => {
                this.cursos.push({label:r.nombre+' '+r.paralelo,r});
            });
            this.curso=this.cursos[0]
        })

      },
    getImage(event){
      //Asignamos la imagen a  nuestra data
      // console.log(event.target)
      this.imagen = event.target.files[0];
    },
    getArch(event){
      //Asignamos la imagen a  nuestra data
      // console.log(event.target)
      this.archivo = event.target.files[0];
      this.porcentaje = 0
      const fd = new FormData()
      fd.append('file', this.archivo)

      this.$axios.post(process.env.API+'/upload', fd, {
          headers: { 'Content-Type': 'multipart/form-data' },
          onUploadProgress: (progressEvent) => {
            this.porcentaje = Math.round((progressEvent.loaded / progressEvent.total) * 100)
          }
        }).then(res => {
          this.nameFile=res.data
          // console.log(res.data)
        })

    },
    misdatos(){
      this.$q.loading.show();
        this.$axios.get(process.env.API+'/libro').then(res=>{
            // console.log(res.data)
           this.data=res.data;
          this.$q.loading.hide();
        })
    },



    editRow(props){
        // console.log(categoria.row);
        this.onReset()
        this.boolmod=false;
        this.dato2= props.row;
        this.materia={label:this.dato2.materia.nombre,r:this.dato2.materia}
        this.curso={label:this.dato2.curso.nombre+' '+this.dato2.curso.paralelo,r:this.dato2.curso}
        this.dialog_mod=true;
    },
        archRow(props){
        // console.log(categoria.row);
        this.onReset()
        this.dato2= props.row;
        this.dialog_arch=true;
    },
            imgRow(props){
        // console.log(categoria.row);
        this.onReset()
        this.dato2= props.row;
        this.dialog_img=true;
    },
    verRow(categoria){
        this.dato2= categoria.row;
        // console.log(categoria.row);
        this.sub= categoria.row.subcategorias;
        this.dialog_ver=true;
    },

    deleteRow(categoria){
        // console.log(categoria.row);
        this.dato2= categoria.row;
        this.dialog_del=true;
    },

    onSubmit () {

      this.$q.loading.show();
      var data = new  FormData();
      data.append('archivo', this.nameFile);
      data.append('imagen', this.imagen);
      data.append('titulo', this.dato.titulo);
      data.append('autor', this.dato.autor);
      data.append('editorial', this.dato.editorial);
      data.append('materia_id', this.materia.r.id);
      data.append('curso_id', this.curso.r.id);

      this.$axios.post(process.env.API+'/libro', data).then(res=>{
        this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Creado correctamente'
        });
        this.alert=false;
        this.misdatos();
      })
    },

    onMod(){
        this.$q.loading.show();
        this.dato2.materia_id=this.materia.r.id;
        this.dato2.curso_id=this.curso.r.id;
        this.$axios.put(process.env.API+'/libro/'+this.dato2.id,this.dato2).then(res=>{
         this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Modificado correctamente'
        });
        this.dialog_mod=false;
        this.misdatos();})
    },

    onArch(){
           var data2 = new  FormData();

          data2.append('id', this.dato2.id);
          data2.append('titulo', this.dato2.titulo);
          data2.append('archivo', this.archivo);
          this.$axios.post(process.env.API+'/uparchivo', data2).then(res=>{
                     this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Modificado correctamente'
        });
        this.misdatos();
        this.dialog_arch=false;
          })
    },
        onImg(){
           var data2 = new  FormData();

          data2.append('id', this.dato2.id);
          data2.append('titulo', this.dato2.titulo);
          data2.append('imagen', this.imagen);
          this.$axios.post(process.env.API+'/upimagen', data2).then(res=>{
                     this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Modificado correctamente'
        });
        this.misdatos();
        this.dialog_arch=false;
          })
    },

    onDel(){
        this.$q.loading.show();
        this.$axios.delete(process.env.API+'/libro/'+this.dato2.id).then(res=>{
         this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'cloud_done',
          message: 'Eliminado correctamente'
        });
        this.dialog_del=false;
        this.misdatos();})
    },

    onReset () {
      this.dato.titulo = null;
      this.dato.autor = null;
      this.dato.editorial = null;
    }
  },

}
</script>
