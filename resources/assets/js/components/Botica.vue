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
                                            <button type="button" @click="llamarDatos(botica)" class="btn btns btn-success btn-sm" data-toggle="modal" data-target="#modalDetalleMedicamento">
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
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row"> 
                                <div class="col-md-12"> 
                                    <p>Por Favor no hay validaciones !!!</p>
                                </div>
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
            <div class="modal fade" tabindex="-1" id="modalDetalleMedicamento" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Registro de Medicamentos</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 d-flex">
                                    <input type="text" class="form-control" @keyup.enter="obtenerDetalleMedicamento(1, idBotica, textoBuscar)" v-model="textoBuscar">
                                    <button class="btn btn-success" @click.prevent="obtenerDetalleMedicamento(1, idBotica, textoBuscar)">Buscar</button>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalRegistro" @click="inicializarMedicamento()">
                                        Agregar
                                    </button>
                                </div>
                            </div>
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
                                                <th class="text-center">Precio</th>
                                                <th class="text-center">Registro Sanitario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="detalle in arrayDetalleMedicamento" :key="detalle.id">
                                                <td>
                                                    <button type="button" @click="llenarDatosMedicamentos(detalle)" class="btn btns btn-warning btn-sm" data-toggle="modal" data-target="#modalRegistro">
                                                        <i style="font-size: 15px;" class="feather  icon-edit"></i>
                                                    </button>
                                                </td>
                                                <td v-text="detalle.codigo"></td>
                                                <td v-text="detalle.nombre_medicamento"></td>                                       
                                                <td v-text="detalle.nombre_tipo"></td>
                                                <td v-text="detalle.nombre_presentacion"></td>
                                                <td v-text="detalle.nombre_laboratorio"></td>
                                                <td v-text="detalle.precio"></td>
                                                <td v-text="detalle.registoSanitario"></td>
                                            </tr>                                
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <nav class="mt-2">
                                <ul class="pagination mb-0">
                                    <li class="page-item" v-if="pagination_2.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina2(pagination_2.current_page - 1)">Ant</a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumber2" :key="page" :class="[page == isActived2 ? 'active' : '']" >
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina2(page)" v-text="page"></a>
                                    </li>
                                    <li class="page-item" v-if="pagination_2.current_page < pagination_2.last_page">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina2(pagination_2.current_page + 1)">Sig</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" id="modalRegistro" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Detalle de Medicamentos</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p style="color: red;">Por favor no hay validaciones, si hay campos nulos los rellenan con: 'sin información', y si es un campo que se debe de seleccionar registrar uno que diga no se encuentra.</p>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Codigo</p>
                                    <input type="text" class="form-control" v-model="codigo">
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Medicamento</p>
                                    <v-select label="nombre" :options="arrayMedicamento" :clearable="false" v-model="idMedicamento" style="width:100% !important;" >
                                        <span  slot = "no-options" >No se encontró el Medicamento.</span>
                                    </v-select>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Tipo</p>
                                    <v-select label="nombre" :options="arrayTipo" :clearable="false" v-model="idTipo" style="width:100% !important;" >
                                        <span  slot = "no-options" >No se encontró el Medicamento.</span>
                                    </v-select>
                                </div> 
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Presentacion</p>
                                    <v-select label="nombre" :options="arrayPresentacion" :clearable="false" v-model="idPresentacion" style="width:100% !important;" >
                                        <span  slot = "no-options" >No se encontró el Medicamento.</span>
                                    </v-select>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Laboratorio</p>
                                    <v-select label="nombre" :options="arrayLaboratorio" :clearable="false" v-model="idLaboratorio" style="width:100% !important;" >
                                        <span  slot = "no-options" >No se encontró el Medicamento.</span>
                                    </v-select>
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
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
export default {
    components : {
        VueNumeric,
        vSelect,
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
            textoBuscar : '',
            arrayBoticas: [],        
            errors : [],            
            idBotica2 : '',
            tituloModal2 : 'Registro de Detalle Presentacion',            
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
            pagination_2 : {
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
        isActived2: function(){
            return this.pagination_2.current_page;
        },
        pagesNumber2: function(){
            if(!this.pagination_2.to){
                return [];
            }
            var from = this.pagination_2.current_page - this.offset;
            if(from < 1){
                from = 1;
            }
            var to = from + (this.offset * 2);
            if(to >= this.pagination_2.last_page){
                to= this.pagination_2.last_page;
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
        cambiarPagina2(page){
            let me = this;
            me.pagination_2.current_page = page;
            me.obtenerDetalleMedicamento(page, this.idBotica, this.textoBuscar);
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
        llamarDatos (data){
            this.idBotica = data['id'];
            this.obtenerDetalleMedicamento(1, this.idBotica, this.textoBuscar);
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
            $('#modalBoticas').modal('hide');
        },
        initial(){
            this.errors = [];
            this.tipoAccion = 1;
            this.tituloModal = 'Registrar Boticas';
        },
        llenarDatosMedicamentos(data){
            this.tituloModal2 = 'Actualizar  Medicamento';
            this.idDetalleMedicamento = data['id'];
            this.idMedicamento = {'nombre' : data['nombre_medicamento'], 'id': data['id_medicamento']};
            this.idPresentacion = {'nombre' : data['nombre_presentacion'], 'id': data['id_presentacion']};
            this.idTipo = {'nombre' : data['nombre_tipo'], 'id': data['id_tipo']};
            this.idLaboratorio = {'nombre' : data['nombre_laboratorio'], 'id': data['id_laboratorio']};
            this.tipoAccion = 2;
            this.codigo = data['codigo'];
            this.precio = data['precio'];
            this.registroSanitario = data['registoSanitario'];  
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
            if(this.idMedicamento == '' | this.idPresentacion == '' |  this.idLaboratorio == '' | this.idTipo){
                toastr.error('Revise sus datos');
            }else{
                axios
                .put("/DetalleMedicamento/update", {
                    'codigo' : this.codigo,                                
                    'nombre' : this.nombre,
                    'precio' : this.precio,
                    'registroSanitario' : this.registroSanitario,
                    'idMedicamento' : this.idMedicamento.id,
                    'idPresentacion' : this.idPresentacion.id,
                    'idLaboratorio' : this.idLaboratorio.id,
                    'idBotica' : this.idBotica,
                    'idTipo' : this.idTipo.id,
                    'id': this.idDetalleMedicamento
                })
                .then(function(response) {
                    console.log(response);
                    toastr.success('Detalle Actualizado.');
                    $('#modalRegistro').modal('hide');
                    me.obtenerDetalleMedicamento(1, me.idBotica, me.textoBuscar);
                    me.limpiarMedicamento();
                })
                .catch(error => (this.errors = error.response.data.errors));
            }

        },
        obtenerDetalleMedicamento(page, idBotica, texto){
            let me = this;
            var url = '/DetalleMedicamento?page=' + page + '&idBotica=' + idBotica + '&texto=' + texto;
            axios.get(url).then(function(response){
                var respuesta = response.data;
                me.arrayDetalleMedicamento = respuesta.detalle_medicamentos.data;                
                me.pagination_2 = respuesta.pagination;
            })
            .catch(function(error){
            });
        },
        limpiarMedicamento(){
            this.codigo = ''
            this.nombre = ''
            this.precio = ''
            this.registroSanitario = ''
        },
        registrarDetalleMedicamentos(){
            var aux = '';
            var cod = '';
            let me = this;
            if(this.idMedicamento == '' | this.idPresentacion == '' |  this.idLaboratorio == '' | this.idTipo){
                toastr.error('Revise sus datos');
            }else{
                axios.post('/DetalleMedicamento/store',{                
                    'codigo' : this.codigo,                                
                    'nombre' : this.nombre,
                    'precio' : this.precio,
                    'registroSanitario' : this.registroSanitario,
                    'idMedicamento' : this.idMedicamento.id,
                    'idPresentacion' : this.idPresentacion.id,
                    'idLaboratorio' : this.idLaboratorio.id,
                    'idBotica' : this.idBotica,
                    'idTipo' : this.idTipo.id,
                }).then((response)=>{
                    me.initial();
                    toastr.success('Detalle registrado.');
                    $('#modalRegistro').modal('hide');
                    me.obtenerDetalleMedicamento(1, me.idBotica, me.textoBuscar);
                    me.limpiarMedicamento();
                }).catch((error)=>{
                    this.errors = error.response.data.errors;
                })
            }
        },
        cerrarModalMedicamento(){
            $('#modalDetalleMedicamento').modal('hide');
        },
        initialMedicamento(){
            this.errors = [];
            this.tipoAccion = 1;
            this.tituloModal = 'Registrar Detalle Medicamento';
        },
        inicializarMedicamento(){
            this.limpiarMedicamento();
        }
    },
    mounted() {        
        this.obtenerBoticas(1);
        this.selectMedicamento();
        this.selectPresentacion();
        this.selectTipo();
        this.selectLaboratorio();
    },
    created() {
        $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });
        $(document).on('hidden.bs.modal', '.modal', function () {
            $('.modal:visible').length && $(document.body).addClass('modal-open');
        });
    },
}
</script>
<style >
    .p-text{
        margin-bottom: 0px !important;
    }
    ul#vs3__listbox{
        max-height: 200px;
    }
    ul#vs1__listbox{
        max-height: 200px;
    }
    ul#vs2__listbox{
        max-height: 200px;
    }
    ul#vs4__listbox{
        max-height: 200px;
    }
</style>