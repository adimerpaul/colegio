export default function () {
  return {
    status: '',
    token: localStorage.getItem('tokencole') || '',
    user : {unit:{}},
    pedido:[],
    boolusuarios:false,
    boolrecepcion:false,
    boolseguimiento:false,
    booldesignacion:false,
    boolmisrecepciones:false,
    // inventario:false,
    // ventadetalle:false,
    // historialventadetalle:false,
    // ventalocal:false,
    // historialventalocal:false,
    // empleados:false,
    // reportes:false,
    // gastos:false,
    // historialprestamo:false,
  }
}
