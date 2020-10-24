<template>
    <main class="main">
        <div class="container-fluid mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Gestión de  Detalle Medicamento</h4>
                            <button class="btn btn-success" data-toggle="modal" data-target="#modalDetalleMedicamento" @click="initial()">
                                Nuevo Detalle Medicamento
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
                                        <th class="text-center">Tipo</th>
                                        <th class="text-center">Presentacion</th>
                                        <th class="text-center">Laboratorio</th>
                                        <th class="text-center">Botica</th>
                                        <th class="text-center">Precio</th>
                                        <th class="text-center">Registro Sanitario</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="detalle_medicamento in arrayDetalleMedicamento" :key="detalle_medicamento.idDetalleMedicamento">
                                        <td>
                                            <button type="button" @click="llenarDatos(detalla_medicamento)" class="btn btns btn-warning btn-sm" data-toggle="modal" data-target="#modalDetalleMedicamento">
                                                <i style="font-size: 15px;" class="feather  icon-edit"></i>
                                            </button>
                                        </td>
                                        <td v-text="detalle_medicamento.codigo"></td>
                                        <td v-text="detalle_medicamento.nombre_medicamento"></td>
                                        <td v-text="detalle_medicamento.nombre_tipo"></td>
                                        <td v-text="detalle_medicamento.nombre_presentacion"></td>
                                        <td v-text="detalle_medicamento.nombre_botica"></td>
                                        <td v-text="detalle_medicamento.nombre_laboratorio"></td>
                                        <td v-text="detalle_medicamento.precio"></td>
                                        <td v-text="detalle_medicamento.registroSanitario"></td>                                       
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
            <div class="modal fade" tabindex="-1" id="modalDetalleMedicamento" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                        <option v-for="medicamentos in arrayMedicamento" :key="medicamentos.id" :value="medicamentos.id" v-text="medicamentos.nombre"></option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Tipo</p>
                                    <select class="form-control" v-model="idTipo">
                                        <option value="0" disabled>Seleccionar</option>
                                        <option v-for="tipo_medicamentos in arrayTipo" :key="tipo_medicamentos.id" :value="tipo_medicamentos.id" v-text="tipo_medicamentos.nombre"></option>
                                    </select>
                                </div> 
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Presentacion</p>
                                    <select class="form-control" v-model="idPresentacion">
                                        <option value="0" disabled>Seleccionar</option>
                                        <option v-for="presentacion in arrayPresentacion" :key="presentacion.id" :value="presentacion.id" v-text="presentacion.nombre"></option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Botica</p>
                                    <select class="form-control" v-model="idBotica">
                                        <option value="0" disabled>Seleccionar</option>
                                        <option v-for="botica in arrayBotica" :key="botica.id" :value="botica.id" v-text="botica.nombre"></option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Laboratorio</p>
                                    <select class="form-control" v-model="idLaboratorio">
                                        <option value="0" disabled>Seleccionar</option>
                                        <option v-for="laboratorio in arrayLaboratorio" :key="laboratorio.id" :value="laboratorio.id" v-text="laboratorio.nombre"></option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Precio</p>
                                    <input type="text" class="form-control" v-model="precio">
                                </div> 
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Registro Sanitario</p>
                                    <input type="text" class="form-control" v-model="registroSanitario">
                                </div>                                                                                   
                            </div>                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" v-if="tipoAccion == 1"  class="btn btn-success" @click="registrarDetalleMedicamentos()">Registrar</button>
                            <button type="submit" v-if="tipoAccion == 2" class="btn btn-success"  @click="actualizarDetalleMedicamento()">Actualizar</button>
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
            arrayDetalleMedicamento: [],
            arrayPresentacion: [],
            arrayMedicamento: [],
            arrayTipo: [],
            arrayBotica: [],
            arrayLaboratorio: [],           
            errors : [],            
            idDetalleMedicamento : '',
            idPresentacion : '',
            idBotica : '',
            idLaboratorio : '',
            idTipo : '',
            precio : '',
            registroSanitario : '',
            nombre_presentacion: '',
            nombre_medicamento: '',
            nombre_tipo: '',
            nombre_laboratorio: '',
            nombre_botica: '',
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
        llenarDatos(detalla_medicamento){
            this.tituloModal = 'Actualizar  Medicamento';
            this.idDetalleMedicamento = detalla_medicamento['id'];
            this.idMedicamento = detalla_medicamento['idMedicamento'];  
            this.idPresentacion = detalla_medicamento['idPresentacion']; 
            this.idTipo = detalla_medicamento['idTipo']; 
            this.idBotica = detalla_medicamento['idBotica'];
            this.idLaboratorio = detalla_medicamento['idLaboratorio'];            
            this.tipoAccion = 2;
            this.codigo = detalla_medicamento['codigo'];
            this.precio = detalla_medicamento['precio'];
            this.registroSanitario = detalla_medicamento['registroSanitario'];  
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
        selectBotica(){
            let me=this;
            var url= '/Botica/selectBotica' ;
            axios.get(url).then(function (response) {
                //console.log(response);
                var respuesta= response.data;
                me.arrayBotica = respuesta.botica;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        selectLaboratorio(){
            let me=this;
            var url= '/Laboratorio/selectLaboratorio' ;
            axios.get(url).then(function (response) {
                //console.log(response);
                var respuesta= response.data;
                me.arrayLaboratorio = respuesta.laboratorio;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        selectTipo(){
            let me=this;
            var url= '/TipoMedicamento/selectTipo' ;
            axios.get(url).then(function (response) {
                //console.log(response);
                var respuesta= response.data;
                me.arrayTipo = respuesta.tipo_medicamentos;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        actualizarDetalleMedicamento() {            
            let me = this;
            axios
                .put("/DetalleMedicamento/update", {
                    idMedicamento: this.idMedicamento,
                    idPresentacion: this.idPresentacion,
                    idBotica: this.idBotica,
                    idTipo: this.idTipo,
                    idLaboratorio: this.idLaboratorio,
                    codigo: this.codigo,
                    precio: this.precio,
                    registroSanitario: this.registroSanitario,
                    id: this.idDetalleMedicamento,                   
                })
                .then(function(response) {
                    console.log(response);
                    toastr.success("Detalle Medicamento Actualizado");
                    me.cerrarModal();                    
                    me.obtenerDetalleMedicamento(1);
                })
                .catch(error => (this.errors = error.response.data.errors));
        },
        obtenerDetalleMedicamento(page){
            let me = this;
            var url = '/DetalleMedicamento?page=' + page;
            axios.get(url).then(function(response){
                var respuesta = response.data;
                me.arrayDetalleMedicamento = respuesta.detalle_medicamentos.data;                
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
        registrarDetalleMedicamentos(){
            var aux = '';
            var cod = '';
            let me = this;
            axios.post('/DetalleMedicamento/store',{                
                'codigo' : this.codigo,                                
                'nombre' : this.nombre,
                'precio' : this.precio,
                'registroSanitario' : this.registroSanitario,
                'idMedicamento' : this.idMedicamento,
                'idPresentacion' : this.idPresentacion,
                'idLaboratorio' : this.idLaboratorio,
                'idBotica' : this.idBotica,
                'idTipo' : this.idTipo,
            }).then((response)=>{
                me.initial();
                toastr.success('Detalle registrado.');
                me.obtenerDetalleMedicamento(1);
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
            this.tituloModal = 'Registrar Detalle Medicamento';
        },
    },
    mounted() {        
        this.obtenerDetalleMedicamento(1);
        this.selectMedicamento();
        this.selectPresentacion();
        this.selectLaboratorio();
        this.selectBotica();
        this.selectTipo();
    },
}
</script>
<style >
    .p-text{
        margin-bottom: 0px !important;
    }
</style>