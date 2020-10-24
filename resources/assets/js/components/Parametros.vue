<template>
    <main class="main">
        <div class="container-fluid mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between">
                            <h4>Gestión de Parámetros</h4>
                            <!-- <button class="btn btn-success nuevo" data-toggle="modal" data-target="#modalParametro" @click="initial()">
                                Nuevo Parámetro
                            </button> -->
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-striped table-responsive-sm table-sm text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">Opciones</th>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Inicial</th>
                                        <th class="text-center">Valor Mínimo</th>
                                        <th class="text-center">Valor Máximo</th>
                                        <th class="text-center">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="parametro in arrayParametros" :key="parametro.idParametro">
                                        <td>
                                            <button type="button" @click="setData(parametro)" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalParametro">
                                                <i  style="font-size: 15px;" class="feather  icon-edit"></i>
                                            </button>
                                        </td>
                                        <td v-text="parametro.nombreParametro"></td>
                                        <td v-text="parametro.inicialParametro"></td>
                                        <td v-text="parametro.minParametro"></td>
                                        <td v-text="parametro.maxParametro"></td>
                                        <td>
                                            <div v-if="parametro.vigenciaParametro">
                                                <span class="badge badge-success" style="font-size: 12px; font-weight: 900;">Activo</span>
                                            </div>    
                                            <div v-else>
                                                <span class="badge badge-danger" style="font-size: 12px;  font-weight: 900;">Desactivado</span>
                                            </div>  
                                        </td>
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" id="modalParametro" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-8 mb-1">
                                    <p class="p-text">Nombre</p>
                                    <input type="text" class="form-control" v-model="nombreParametro">
                                    <small v-if="errors.nombreParametro" class="text-danger" v-text="errors.nombreParametro[0]"></small>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Siglas</p>
                                    <input type="text" class="form-control" v-model="inicialParametro">
                                    <small v-if="errors.inicialParametro" class="text-danger" v-text="errors.inicialParametro[0]"></small>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <p class="p-text">Número Mínimo</p>
                                    <vue-numeric v-bind:minus ="false" v-bind:precision="0" v-bind:min = "0" v-bind:max="maxParametro" class="form-control"  currency="" separator="," v-model="minParametro"></vue-numeric>
                                    <small v-if="errors.monto_encargo" class="text-danger" v-text="errors.maxParametro[0]"></small>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <p class="p-text" >Número Máximo</p>
                                    <vue-numeric v-bind:minus ="false" v-bind:precision="0" v-bind:min="minParametro" v-bind:max = "100" class="form-control"  currency="" separator="," v-model="maxParametro"></vue-numeric>
                                    <small v-if="errors.monto_encargo" class="text-danger" v-text="errors.minParametro[0]"></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal" value="Cerrar">Cerrar</button>
                            <button v-if="tipoAccion == 1"  class="btn btn-success" @click="registrarParametro()">Registrar</button>
                            <button v-if="tipoAccion == 2" class="btn btn-success"  @click="actualizarParametro()">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
import VueNumeric from 'vue-numeric'
export default {
    components : {
        VueNumeric
    },
    data(){
        return {
            arrayParametros : [],
            tituloModal : 'Registro de Parámetro',
            nombreParametro : '',
            inicialParametro : '',
            tipoAccion : 1,
            arregloxd : [],
            errors : [],
            idParametro : '',
            minParametro : 0,
            maxParametro : 100,            
        }
    },
    computed:{

    },
    methods: {
        cerrarModal(){
            $('#modalParametro').modal('hide');
        },
        actualizarParametro(){
            let me = this;
            axios.put('/parametro/update',{
                'idParametro' : this.idParametro,
                'nombreParametro' : this.nombreParametro,
                'inicialParametro' : this.inicialParametro,
                'minParametro' : this.minParametro,
                'maxParametro' : this.maxParametro
            }).then((response)=>{
                toastr.success('Parametro Actualizado.');
                me.obtenerParametro();
                me.cerrarModal();
            }).catch((error)=>{
                this.errors = error.response.data.errors;
            })
        },
        registrarParametro(){
            this.errors = [];
            let me = this;
            axios.post('/parametro/store', {
                'nombreParametro' : this.nombreParametro,
                'inicialParametro' : this.inicialParametro,
                'minParametro' : this.minParametro,
                'maxParametro' : this.maxParametro
            }).then((response)=>{
                me.initial();
                alert('No olvidar que al registrar un parámetro concatenar todos los códigos con el máximo xd xd o sea con 000');
                toastr.success('Parametro registrado.');
                me.obtenerParametro();
                me.cerrarModal();
            }).catch((error)=>{
                this.errors = error.response.data.errors;
            })
        },
        setData(data){
            this.errors = [];
            this.tipoAccion = 2;
            this.idParametro = data['idParametro'];
            this.nombreParametro = data['nombreParametro'];
            this.inicialParametro = data['inicialParametro'];
            this.minParametro = data['minParametro'];
            this.maxParametro = data['maxParametro'];
            this.tituloModal = 'Actualización de Parámetros';
        },
        initial(){
            this.tituloModal = 'Registro de Parámetro';
            this.nombreParametro = '';
            this.inicialParametro = '';
            this.tipoAccion = 1;
            this.minParametro = 0;
            this.maxParametro = 100;
            this.errors = [];
        },
        obtenerParametro(){
            let me = this;
            var url;
            url = "/parametro";
            axios.get(url).then((response)=>{
                var respuesta = response.data;
                me.arrayParametros = respuesta.parametros;

            }).catch((error)=>{
                console.log(error);
            })
        }
    },
    mounted() {
        this.obtenerParametro();
    }
}
</script>