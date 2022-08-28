<template>
  <q-page class="q-pa-md">
    <div class="row">
      <div class="col-12 col-md-3"></div>
      <div class="col-12 col-md-6">
        <q-card>
          <q-tabs
            v-model="tab"
            dense
            class="text-grey"
            active-color="primary"
            indicator-color="primary"
            align="justify"
            narrow-indicator
          >
            <q-tab name="login" label="Ingresar" />
<!--            <q-tab name="registro" label="Registrarse" />-->
          </q-tabs>
          <q-separator />
          <q-tab-panels v-model="tab" animated>
            <q-tab-panel name="login">
              <div class="text-h6">Ingresar al sistemas</div>
              Por favor colocar email y contraseña
              <q-form @submit.prevent="login">
                <div class="row">
                  <div class="col-12 ">
                    <q-input type="email" outlined v-model="email" label="Email*" hint="Porfavor ingresar email" :rules="rule">
                      <template v-slot:prepend>
                        <q-icon name="email" />
                      </template>
                    </q-input>
                  </div>
                  <div class="col-12 q-pt-md">
                    <q-input outlined v-model="password" label="password*" :type="isPwd ? 'password' : 'text'" hint="Porfavor ingresar password" :rules="rule">
                      <template v-slot:prepend>
                        <q-icon name="lock" />
                      </template>
                      <template v-slot:append>
                        <q-icon
                          :name="isPwd ? 'visibility_off' : 'visibility'"
                          class="cursor-pointer"
                          @click="isPwd = !isPwd"
                        />
                      </template>
                    </q-input>
                  </div>
                  <div class="col-12 q-py-md">
                    <q-btn label="INGRESAR" color="primary" icon="login" class="full-width" type="submit"/>
<!--                    <q-btn label="Registrate" color="secondary" icon="how_to_reg" @click="tab='registro'" class="full-width q-mt-xs" />-->
                    <div class="text-caption q-py-xs">
                      <!--<a target="_blank" href="https://api.whatsapp.com/send?phone=59169603027&text=olvide mi contraseña santa rosa">Olvidate tu contraseña?</a>-->
                    </div>

                  </div>
                </div>
              </q-form>
            </q-tab-panel>
          </q-tab-panels>
        </q-card>
      </div>
      <hr><br>
      <div>
      <div class="col-6">
          <q-card class="my-card">
      <q-card-section  class="bg-green-6 text-white">
        <div class="text-h5">MISION</div>
      </q-card-section>

      <q-card-actions vertical>
        <div class="">
        La Unidad Educativa “Santa Rosa 2”es un Colegio Técnico-Humanístico, con un selecto plantel docente y administrativo, líder, comprometido con la transformación Social que vive el Estado Plurinacional de Bolivia.
        </div>
      </q-card-actions>
    </q-card>
    </div>
      <div class="col-6">

        <q-card class="my-card">
      <q-card-section class="bg-green-6 text-white">
        <div class="text-h5">VISION</div>
      </q-card-section>

      <q-card-actions vertical>
        <div class="">
        “Formar estudiantes con diversas capacidades, técnicas y humanísticas, jóvenes y señoritas líderes, con análisis crítico y reflexivo, comunicativos con su entorno y consigo mismo, enmarcados en la práctica de valores Socio Comunitarios Productivos, con conocimientos suficientes sobre las nuevas tecnologías de información, aplicando el nuevo modelo Educativo Socio Comunitario Productivo, para vivir bien en armonía con la madre tierra”.
        </div>
      </q-card-actions>
    </q-card>
      </div>
      </div>
    </div>
  </q-page>
</template>

<script>

export default {
  data(){
    return{
      rule:[
        val => (val && val.length > 0) || 'Porfavor ingresar dato'
      ],
      email:'',
      password:'',
      tab:'login',
      user:{},
      isPwd:true,
    }
  },
  created() {
    if (this.$store.getters["login/isLoggedIn"]){
      this.$router.push('/biblioteca')
    }

  },
  methods: {

    registrar(){

      this.$q.loading.show()
      this.$store.dispatch('login/register', this.user).then(() =>{
        this.$q.loading.hide()
        this.$router.push('/biblioteca')
      })
        .catch(err => {
          this.$q.loading.hide();
          // console.log(err.response.data.errors)
          let text=''
          Object.entries(err.response.data.errors).forEach(([key, value]) => {
            // console.log(`${key} ${value}`);
            text+=' '+`${key}: ${value},`
          });
          this.$q.notify({
            message:text,
            color:'red',
            icon:'error'
          })
        })
    },
    login () {
      this.$q.loading.show()
      this.$store.dispatch('login/login', { email:this.email, password:this.password }).then(() =>{
        this.$q.loading.hide()
        this.$router.push('/biblioteca')
      })
        .catch(err => {
          this.$q.loading.hide();
          console.log(err.response.data.res)
          this.$q.notify({
            message:err.response.data.res,
            color:'red',
            icon:'error'
          })
        })
    },
  },
}

</script>

<style scoped>
</style>
