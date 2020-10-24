<template>
    <main class="main">
        <div class="container-fluid mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Gestión de Boticas</h4>
                            <button class="btn btn-success" data-toggle="modal" data-target="#modalBoticas" @click="initial()">
                                Nuevo Boticas
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-striped table-sm text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">Opciones</th>
                                        <th class="text-center">Codigo</th>                                        
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Direccion</th>
                                        <th class="text-center">Telefono</th>
                                        <th class="text-center">Longitud</th>
                                        <th class="text-center">Latitud</th>
                                        <th class="text-center">Hora Apertura</th>
                                        <th class="text-center">Hora Cierre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="botica in arrayBoticas" :key="botica.idLaboratorio">
                                        <td>
                                            <button type="button" @click="llenarDatos(botica)" class="btn btns btn-warning btn-sm" data-toggle="modal" data-target="#modalBoticas">
                                                <i style="font-size: 15px;" class="feather  icon-edit"></i>
                                            </button>
                                        </td>
                                        <td v-text="botica.codigo"></td>
                                        <td v-text="botica.nombre"></td>
                                        <td v-text="botica.direccion"></td>
                                        <td v-text="botica.telefono"></td>                                       
                                        <td v-text="botica.longitud"></td>
                                        <td v-text="botica.latitud"></td>
                                        <td v-text="botica.hapertura"></td>
                                        <td v-text="botica.hcierra"></td>
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <nav class="mt-2">
                        <ul class="pagination mb-0">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']" >
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" id="modalBoticas" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row"> 
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Codigo</p>
                                    <input type="text" class="form-control" v-model="codigo">
                                </div>                     
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Nombre</p>
                                    <input type="text" class="form-control" v-model="nombre">
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Direccion</p>
                                    <input type="text" class="form-control" v-model="direccion">
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Teléfono</p>
                                    <input type="text" class="form-control" v-model="telefono">
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Longitud</p>
                                    <input type="text" class="form-control" v-model="longitud">
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Latitud</p>
                                    <input type="text" class="form-control" v-model="latitud">
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Hora Apertura</p>
                                    <input type="text" class="form-control" v-model="hapertura">
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Hora Cierre</p>
                                    <input type="text" class="form-control" v-model="hcierra">
                                </div>                                                                                   
                            </div>                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" v-if="tipoAccion == 1"  class="btn btn-success" @click="registrarBotica()">Registrar</button>
                            <button type="submit" v-if="tipoAccion == 2" class="btn btn-success"  @click="actualizarBotica()">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
import VueNumeric from 'vue-numeric';
import moment from 'moment';
export default {
    components : {
        VueNumeric
    },
    data(){
        return {
            tipoAccion : 1,
            tituloModal : 'Registro de Botica',            
            codigo : '',
            nombre: '',
            direccion: '',
            telefono: '',
            longitud: '',
            latitud: '',
            hapertura: '',
            hcierra: '',
            arrayBoticas: [],        
            errors : [],            
            idBotica : '',
            pagination : {
                'total'          : 0,
                'current_page'   : 0,
                'per_page'       : 0,
                'last_page'      : 0,
                'from'           : 0,
                'to'             : 0,
            },
            offset : 3
        }
    },
    computed: {
        isActived: function(){
            return this.pagination.current_page;
        },
        pagesNumber: function(){
            if(!this.pagination.to){
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if(from < 1){
                from = 1;
            }
            var to = from + (this.offset * 2);
            if(to >= this.pagination.last_page){
                to= this.pagination.last_page;
            }
            var pagesArrays = [];
            while(from <= to){
                pagesArrays.push(from);
                from++;          
            }
            return pagesArrays;
        },
    },
    methods: {
        cambiarPagina(page){
            let me = this;
            me.pagination.current_page = page;
            me.obtenerBoticas(page);
        },
        numCero:function(lengthCaracter, total){
            var resta = total-lengthCaracter;
            var count = 0;
            var copy = '0';
            var result = '';
            if(resta != 0){
                while (count!=resta) {
                    result = result + copy;
                    count ++;
                }
            }
            return result;
        },
        usemoment: function(date){
            return moment(date).format("DD-MM-YYYY");
        },
        savemoment : function(d){
            if(d == null){  
                return '';
            }else{
                return d.split("-").reverse().join("-");
            }
        },
        llenarDatos(botica){
            this.tituloModal = 'Actualizar Boticas';
            this.idBotica = botica['id'];
            this.tipoAccion = 2;
            this.codigo = botica['codigo'];            
            this.nombre = botica['nombre'];
            this.direccion = botica['direccion'];
            this.telefono = botica['telefono'];
            this.longitud = botica['longitud'];
            this.latitud = botica['latitud'];
            this.hapertura = botica['hapertura'];
            this.hcierra = botica['hcierra'];
        },
        actualizarBotica() {            
            let me = this;
            axios
                .put("/Botica/update", {
                    id: this.idBotica,
                    codigo: this.codigo,                                        
                    nombre: this.nombre,
                    direccion: this.direccion,
                    telefono: this.telefono,                   
                    longitud: this.longitud,
                    latitud: this.latitud,
                    hapertura: this.hapertura,
                    hcierra: this.hcierra,
                })
                .then(function(response) {
                    console.log(response);
                    toastr.success("Laboratorio Actualizada");
                    me.cerrarModal();
                    me.obtenerBoticas(1);
                })
                .catch(error => (this.errors = error.response.data.errors));
        },
        obtenerBoticas(page){
            let me = this;
            var url = '/Botica?page=' + page;
            axios.get(url).then(function(response){
                var respuesta = response.data;
                me.arrayBoticas = respuesta.boticas.data;                
                me.pagination = respuesta.pagination;
            })
            .catch(function(error){
            });
        },
        limpiar(){
            this.codigo = '';            
            this.nombre = '';
            this.direccion = '';
            this.telefono = '';            
            this.longitud = '';
            this.latitud = '';
            this.hapertura = '';
            this.hcierra = '';
            this.errors = [];
        },
        registrarBotica(){
            var aux = '';
            var cod = '';
            let me = this;
            axios.post('/Botica/store',{                
                'codigo' : this.codigo,                                
                'nombre' : this.nombre,
                'direccion' : this.direccion,
                'telefono' : this.telefono,
                'longitud' : this.longitud,
                'latitud' : this.latitud,
                'hapertura' : this.hapertura,
                'hcierra' : this.hcierra,
            }).then((response)=>{
                me.initial();
                toastr.success('Botica registrado.');
                me.obtenerBoticas(1);
                me.cerrarModal();
                me.limpiar();
            }).catch((error)=>{
                this.errors = error.response.data.errors;
            })
        },
        cerrarModal(){
            $('#modaBoticas').modal('hide');
        },
        initial(){
            this.errors = [];
            this.tipoAccion = 1;
            this.tituloModal = 'Registrar Boticas';
        },
    },
    mounted() {        
        this.obtenerBoticas(1);
    },
}
</script>
<style >
    .p-text{
        margin-bottom: 0px !important;
    }
</style>