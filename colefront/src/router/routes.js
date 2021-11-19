import Login from "pages/Login";
// import Recepcion from "pages/Recepcion";
import Profesor from "pages/Profesor";
import User from "pages/User";
import Materia from "pages/Materia";
import Curso from "pages/Curso";
// import Asignacion from "pages/Asignacion";
// import Misrecepciones from "pages/Misrecepciones";
import Biblioteca from "pages/Biblioteca";
import Estudiante from "pages/Estudiante";
import Inscritos from "pages/Inscritos";
import Calificaiones from "pages/Calificaiones";

const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: Login },

      { path: '/user', component: User,meta: {requiresAuth: true,} },
      { path: '/biblioteca', component: Biblioteca,meta: {requiresAuth: true,} },
      { path: '/estudiante', component: Estudiante,meta: {requiresAuth: true,} },
      { path: '/profesor', component: Profesor,meta: {requiresAuth: true,} },
      { path: '/materia', component: Materia,meta: {requiresAuth: true,} },
      { path: '/curso', component: Curso,meta: {requiresAuth: true,} },
      { path: '/inscritos', component: Inscritos,meta: {requiresAuth: true,} },
      { path: '/calificaciones', component: Calificaiones,meta: {requiresAuth: true,} },
      // { path: '/asiganacion', component: Asignacion,meta: {requiresAuth: true,} },
      // { path: '/misrecepciones', component: Misrecepciones,meta: {requiresAuth: true,} },
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
