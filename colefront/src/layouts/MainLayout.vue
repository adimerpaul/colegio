<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />
        <q-toolbar-title>
          {{$store.state.login.user.name}}
        </q-toolbar-title>

        <div>
          <q-btn v-if="$store.getters['login/isLoggedIn']" label="Salir" @click="logout"  color="negative" icon="logout" size="xs" />
        </div>
      </q-toolbar>
      <div class="q-px-lg q-pt-xs q-mb-md" >
        <div class="text-h5 text-bold">
          <!--          <template v-if="!$store.getters['login/isLoggedIn']">-->
          UE Santa Rosa 2
          <!--          </template>-->
          <!--          <template v-else>-->
          <!--            Unidad: {{$store.state.login.user.unit.nombre}}-->
          <!--          </template>-->
        </div>
        <div class="text-subtitle1">{{ now }}</div>
      </div>
      <q-img src="img/fondo.jpg" class="header-image absolute-top" />
    </q-header>
    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      :width="250"
      :breakpoint="600"
    >
      <q-scroll-area style="height: calc(100% - 130px); margin-top: 130px; border-right: 1px solid #ddd">
        <q-list padding>
          <q-item
            clickable
            exact
            to="/"
            v-if="!$store.getters['login/isLoggedIn']"
          >
            <q-item-section
              avatar
            >
              <q-icon name="login" />
            </q-item-section>

            <q-item-section>
              <q-item-label>Ingresar</q-item-label>
              <q-item-label caption>
                Ingreso al sistema
              </q-item-label>
            </q-item-section>
          </q-item>

          <q-item
            v-if="$store.state.login.boolgestionarusuarios"
            clickable
            to="/user"
          >
            <q-item-section
              avatar
            >
              <q-icon name="people" />
            </q-item-section>

            <q-item-section>
              <q-item-label>usuarios</q-item-label>
              <q-item-label caption>
                Users/Adm/Prof/Sria
              </q-item-label>
            </q-item-section>
          </q-item>

          <q-item
            v-if="$store.state.login.boolgestionarprofesores"
            clickable
            to="/profesor"
          >
            <q-item-section
              avatar
            >
              <q-icon name="article" />
            </q-item-section>

            <q-item-section>
              <q-item-label>Profesores</q-item-label>
              <q-item-label caption>
                Profesores
              </q-item-label>
            </q-item-section>
          </q-item>

          <q-item
            v-if="$store.state.login.boolgestionarcursos"
            clickable
            to="/curso"
          >
            <q-item-section
              avatar
            >
              <q-icon name="code" />
            </q-item-section>

            <q-item-section>
              <q-item-label>Cursos</q-item-label>
              <q-item-label caption>
                Cursos
              </q-item-label>
            </q-item-section>
          </q-item>

          <q-item
            v-if="$store.state.login.boolgestionarmaterias"
            clickable
            to="/materia"
          >
            <q-item-section
              avatar
            >
              <q-icon name="list" />
            </q-item-section>

            <q-item-section>
              <q-item-label>Materias</q-item-label>
              <q-item-label caption>
                Materias
              </q-item-label>
            </q-item-section>
          </q-item>

          <q-item
            v-if="$store.state.login.boolgestionarbiblioteca"
            clickable
            to="/biblioteca"
          >
            <q-item-section
              avatar
            >
              <q-icon name="picture_as_pdf" />
            </q-item-section>

            <q-item-section>
              <q-item-label>Biblioteca</q-item-label>
              <q-item-label caption>
                Biblioteca
              </q-item-label>
            </q-item-section>
          </q-item>
          <q-item
            v-if="$store.state.login.boolregistrocalificaciones"
            clickable
            to="/calificacion"
          >
            <q-item-section
              avatar
            >
              <q-icon name="receipt_long" />
            </q-item-section>

            <q-item-section>
              <q-item-label>Calificacion</q-item-label>
              <q-item-label caption>
                Calificacion
              </q-item-label>
            </q-item-section>
          </q-item>

          <q-item
            v-if="$store.state.login.boolgestionargestion"
            clickable
            to="/gestion"
          >
            <q-item-section
              avatar
            >
              <q-icon name="touch_app" />
            </q-item-section>

            <q-item-section>
              <q-item-label>Gestion</q-item-label>
              <q-item-label caption>
                Gestion
              </q-item-label>
            </q-item-section>
          </q-item>

          <q-item
            v-if="$store.state.login.boolinscripbirestudiante"
            clickable
            to="/estudiante"
          >
            <q-item-section
              avatar
            >
              <q-icon name="assignment_ind" />
            </q-item-section>

            <q-item-section>
              <q-item-label>Inscribir estudiante</q-item-label>
              <q-item-label caption>
                Inscribir estudiante
              </q-item-label>
            </q-item-section>
          </q-item>

          <q-item
            v-if="$store.state.login.boolinformeinscritos"
            clickable
            to="/inscritos"
          >
            <q-item-section
              avatar
            >
              <q-icon name="supervisor_account" />
            </q-item-section>

            <q-item-section>
              <q-item-label>Inscritos</q-item-label>
              <q-item-label caption>
                Inscritos
              </q-item-label>
            </q-item-section>
          </q-item>

          <q-item
            v-if="$store.state.login.boolgestionarcalificaciones"
            clickable
            to="/calificaciones"
          >
            <q-item-section
              avatar
            >
              <q-icon name="note_add" />
            </q-item-section>

            <q-item-section>
              <q-item-label>Calificaciones</q-item-label>
              <q-item-label caption>
                Calificaciones
              </q-item-label>
            </q-item-section>
          </q-item>


          <q-item
            v-if="$store.getters['login/isLoggedIn']"
            clickable
            @click="logout"
          >
            <q-item-section
              avatar
            >
              <q-icon name="logout" />
            </q-item-section>

            <q-item-section>
              <q-item-label>Salir</q-item-label>
              <q-item-label caption>
                Salir del sistema
              </q-item-label>
            </q-item-section>
          </q-item>

        </q-list>
      </q-scroll-area>

      <q-img class="absolute-top" src="img/fondo.jpg" style="height: 130px">
        <div class="absolute-bottom bg-transparent ">
          <q-avatar size="56px" class="q-mb-sm">
            <img src="https://cdn.quasar.dev/img/boy-avatar.png">
          </q-avatar>
          <div class="text-weight-bold">UE Santa Rosa 2 </div>
          <div>Menu</div>
        </div>
      </q-img>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import {date} from 'quasar'
// import e from 'c'
export default {

  data(){
    return{
      leftDrawerOpen : false,
      now :date.formatDate(Date.now(), 'dddd D  MMMM', {
        days: ['Domingo', 'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado' /* and all the rest of days - remember starting with Sunday */],
        daysShort: ['Dum', 'Lun', /* and all the rest of days - remember starting with Sunday */],
        months: ['Enero', 'Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre' /* and all the rest of months */],
        monthsShort: ['Ian', 'Feb', /* and all the rest of months */]
      }),
      unidad:'aa'
    }
  },
  created() {
    // console.log(this.$store.getters['login/user'])
    // this.unidad=this.$store.getters['login/user'];
  },
  methods:{
    toggleLeftDrawer () {
      this.leftDrawerOpen = !this.leftDrawerOpen
    },
    logout () {
      this.$q.loading.show()
      this.$store.dispatch('login/logout')
        .then(() => {
          this.$q.loading.hide()
          this.$router.push('/')
        })
    },
  }
}
</script>
<style lang="scss">
.header-image{
  height: 100%;
  z-index: -1;
  opacity: 0.2;
  filter: grayscale(100%);
}
</style>
