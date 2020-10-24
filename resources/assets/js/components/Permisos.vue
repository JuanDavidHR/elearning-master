<template>
    <main class="main">
      Los Permisos que Habrán, por ejemplo.
      Registro de Artículos.
      Registro de Categorias.
      Registro de Kardex.{Mermas}
      Registro de Usuarios.
      Registro de Roles.
      Registro de Compras.
      Registro de Ventas.
      Acceso a los Reportes.
      Registro de Ticket.
      Serialización.
      Impresoras.
      {Esto Va Registrado en el Instalador.}
      <div class="container-fluid">
          <div class="form-group">
              <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Si desea Registrar Más, por favor pague más xd.
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-success" role="alert">
                                        <h6>Listado de Permisos Habílitados para la nueva Creación de Roles.</h6>
                                    </div>
                                </div>
                                <div class="col-md-4" v-for="grado in arreglo" :key="grado.dGrado">     
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center"  >
                                            <label class ="jeje son" for="" v-text="grado"></label>
                                            <label class="switch">
                                                <input type="checkbox">
                                                <!--<input type="checkbox" v-model="usaSerie" :checked ="usaSerie" @click="Notificacion(usaSerie);">-->
                                                <span class="slider round"></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            Guardat Cambios
                        </div>
                    </div>
                </div>
            </div>
          </div>
      </div>
    </main>
</template>

<script>
    export default {
        data(){
            return{
                arreglo : ['Registro de Artículos.','Registro de Categorias.',3,4,5,6,7,8,9,0,2,1,2,]

            }
        },computed:{// se almacenan en el cache los métodos no :3

        },methods:{
            cambiarArreglo(arreglo){

            },
            cambiarArreglo2(arreglo){

            }
        },mounted(){
            //los métodos que se utilizan al iniciar el Template
        }
    }
</script>

<style>

</style>