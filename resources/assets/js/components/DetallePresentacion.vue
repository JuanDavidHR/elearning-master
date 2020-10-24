<template>
    <main class="main">
        <div class="container-fluid mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Gestión de  Detalle</h4>
                            <button class="btn btn-success" data-toggle="modal" data-target="#modalDetallePresentacion" @click="initial()">
                                Nuevo Detalle Presentacion
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
                                        <th class="text-center">Medicamento</th>
                                        <th class="text-center">Presentacion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="detalle_presentacion in arrayDetallePresentacion" :key="detalle_presentacion.idDetallePresentacion">
                                        <td>
                                            <button type="button" @click="llenarDatos(detalle_presentacion)" class="btn btns btn-warning btn-sm" data-toggle="modal" data-target="#modalDetallePresentacion">
                                                <i style="font-size: 15px;" class="feather  icon-edit"></i>
                                            </button>
                                        </td>
                                        <td v-text="detalle_presentacion.codigo"></td>
                                        <td v-text="detalle_presentacion.nombre_medicamento"></td>
                                        <td v-text="detalle_presentacion.nombre_presentacion"></td>                                       
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
            <div class="modal fade" tabindex="-1" id="modalDetallePresentacion" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                    <p class="p-text">Medicamento</p>
                                    <select class="form-control" v-model="idMedicamento">
                                        <option value="0" disabled>Seleccionar</option>
                                        <option v-for="medicamento in arrayMedicamento" :key="medicamento.id" :value="medicamento.id" v-text="medicamento.nombre"></option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Presentacion</p>
                                    <select class="form-control" v-model="idPresentacion">
                                        <option value="0" disabled>Seleccionar</option>
                                        <option v-for="presentacion in arrayPresentacion" :key="presentacion.id" :value="presentacion.id" v-text="presentacion.nombre"></option>
                                    </select>
                                </div>                                                                                       
                            </div>                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" v-if="tipoAccion == 1"  class="btn btn-success" @click="registrarDetallePresentacion()">Registrar</button>
                            <button type="submit" v-if="tipoAccion == 2" class="btn btn-success"  @click="actualizarDetallePresentacion()">Actualizar</button>
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
            tituloModal : 'Registro de Detalle Presentacion',            
            codigo : '',
            arrayDetallePresentacion: [],
            arrayPresentacion: [],
            arrayMedicamento: [],        
            errors : [],            
            idDetallePresentacion : '',
            idPresentacion : '',
            nombre_presentacion: '',
            nombre_medicamento: '',
            idMedicamento : '',
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
            me.obtenerDetalleMedicamento(page);
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
        llenarDatos(detalle_presentacion){
            this.tituloModal = 'Actualizar  Medicamento';
            this.idDetallePresentacion = detalle_presentacion['id'];
            this.idMedicamento = detalle_presentacion['idMedicamento'];  
            this.idPresentacion = detalle_presentacion['idPresentacion'];             
            this.tipoAccion = 2;
            this.codigo = detalle_presentacion['codigo']; 
        },
        selectPresentacion(){
            let me=this;
            var url= '/Presentacion/selectPresentacion' ;
            axios.get(url).then(function (response) {
                //console.log(response);
                var respuesta= response.data;
                me.arrayPresentacion = respuesta.presentacion;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        selectMedicamento(){
            let me=this;
            var url= '/Medicamento/selectMedicamento' ;
            axios.get(url).then(function (response) {
                //console.log(response);
                var respuesta= response.data;
                me.arrayMedicamento = respuesta.medicamento;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        actualizarDetallePresentacion() {            
            let me = this;
            axios
                .put("/DetallePresentacion/update", {
                    idMedicamento: this.idMedicamento,
                    idPresentacion: this.idPresentacion,
                    codigo: this.codigo,
                    id: this.idDetallePresentacion,                   
                })
                .then(function(response) {
                    console.log(response);
                    toastr.success("Detalle Actualizado");
                    me.cerrarModal();                    
                    me.obtenerDetallePresentacion(1);
                })
                .catch(error => (this.errors = error.response.data.errors));
        },
        obtenerDetallePresentacion(page){
            let me = this;
            var url = '/DetallePresentacion?page=' + page;
            axios.get(url).then(function(response){
                var respuesta = response.data;
                me.arrayDetallePresentacion = respuesta.detalle_presentaciones.data;                
                me.pagination = respuesta.pagination;
            })
            .catch(function(error){
            });
        },
        limpiar(){
            this.codigo = '';
            this.idPresentacion = '';
            this.idMedicamento = '';                      
            this.errors = [];
        },
        registrarDetallePresentacion(){
            var aux = '';
            var cod = '';
            let me = this;
            axios.post('/DetallePresentacion/store',{                
                'codigo' : this.codigo,                                
                'nombre' : this.nombre,
                'idMedicamento' : this.idMedicamento,
                'idPresentacion' : this.idPresentacion
            }).then((response)=>{
                me.initial();
                toastr.success('Detalle registrado.');
                me.obtenerDetallePresentacion(1);
                me.cerrarModal();
                me.limpiar();
            }).catch((error)=>{
                this.errors = error.response.data.errors;
            })
        },
        cerrarModal(){
            $('#modalDetalleMedicamento').modal('hide');
        },
        initial(){
            this.errors = [];
            this.tipoAccion = 1;
            this.tituloModal = 'Registrar Medicamento';
        },
    },
    mounted() {        
        this.obtenerDetallePresentacion(1);
        this.selectMedicamento();
        this.selectPresentacion();
    },
}
</script>
<style >
    .p-text{
        margin-bottom: 0px !important;
    }
</style>