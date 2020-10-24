<template>
    <main class="main">
        <div class="container-fluid mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Gestión de Laboratorios</h4>
                            <button class="btn btn-success" data-toggle="modal" data-target="#modalLaboratorio" @click="initial()">
                                Nuevo Laboratorio
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="laboratorio in arrayLaboratorio" :key="laboratorio.idLaboratorio">
                                        <td>
                                            <button type="button" @click="llenarDatos(laboratorio)" class="btn btns btn-warning btn-sm" data-toggle="modal" data-target="#modalLaboratorio">
                                                <i style="font-size: 15px;" class="feather  icon-edit"></i>
                                            </button>
                                        </td>
                                        <td v-text="laboratorio.codigo"></td>
                                        <td v-text="laboratorio.nombre"></td>                                        
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
            <div class="modal fade" tabindex="-1" id="modalLaboratorio" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                            </div>                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" v-if="tipoAccion == 1"  class="btn btn-success" @click="registrarLaboratorio()">Registrar</button>
                            <button type="submit" v-if="tipoAccion == 2" class="btn btn-success"  @click="actualizarLaboratorio()">Actualizar</button>
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
            tituloModal : 'Registro de Laboratorio',            
            codigo : '',
            nombre: '',
            arrayLaboratorio: [],        
            errors : [],            
            idLaboratorio : '',
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
            me.obtenerLaboratorios(page);
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
        llenarDatos(laboratorio){
            this.tituloModal = 'Actualizar Laboratorio';
            this.idLaboratorio = laboratorio['id'];
            this.tipoAccion = 2;
            this.codigo = laboratorio['codigo'];            
            this.nombre = laboratorio['nombre'];
        },
        actualizarLaboratorio() {            
            let me = this;
            axios
                .put("/Laboratorio/update", {
                    id: this.idLaboratorio,
                    codigo: this.codigo,                                        
                    nombre: this.nombre,                    
                })
                .then(function(response) {
                    console.log(response);
                    toastr.success("Laboratorio Actualizada");
                    me.cerrarModal();
                    me.obtenerLaboratorios(1);
                })
                .catch(error => (this.errors = error.response.data.errors));
        },
        obtenerLaboratorios(page){
            let me = this;
            var url = '/Laboratorio?page=' + page;
            axios.get(url).then(function(response){
                var respuesta = response.data;
                me.arrayLaboratorio = respuesta.laboratorios.data;                
                me.pagination = respuesta.pagination;
            })
            .catch(function(error){
            });
        },
        limpiar(){
            this.codigo = '';            
            this.nombre = '';            
            this.errors = [];
        },
        registrarLaboratorio(){
            var aux = '';
            var cod = '';
            let me = this;
            axios.post('/Laboratorio/store',{                
                'codigo' : this.codigo,                                
                'nombre' : this.nombre
            }).then((response)=>{
                me.initial();
                toastr.success('Laboratorio registrado.');
                me.obtenerLaboratorios(1);
                me.cerrarModal();
                me.limpiar();
            }).catch((error)=>{
                this.errors = error.response.data.errors;
            })
        },
        cerrarModal(){
            $('#modalLaboratorio').modal('hide');
        },
        initial(){
            this.errors = [];
            this.tipoAccion = 1;
            this.tituloModal = 'Registrar Laboratorio';
        },
    },
    mounted() {        
        this.obtenerLaboratorios(1);
    },
}
</script>
<style >
    .p-text{
        margin-bottom: 0px !important;
    }
</style>