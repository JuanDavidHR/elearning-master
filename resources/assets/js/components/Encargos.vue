
<template>
    <main class="main">
        <div class="container-fluid mt-4">
            <div class="card mb-4">
                <template v-if="se_muestra">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3 btn1">
                                <h6 class="mt-1">Listado de control de encargos.</h6>
                            </div>
                            <div class="col-md-4 btn1">
                                <div class="input-group">
                                    <input type="text" @keyup.enter="listarEgreso(1, buscar, mes, anho)" v-model="buscar" class="form-control document-nice" placeholder="Documento a buscar">
                                    <button type="submit" @click.prevent="listarEgreso(1, buscar, mes, anho)" class="btn btn-primary btn-border"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>    
                            <div class="col-md-3 btn1">
                                <date-picker v-model="mesBuscar" type="month" value-type="date" format="MM-Y" @change="validateMes()" placeholder="Seleccionar mes"></date-picker>
                            </div>    
                            <div class="col-md-2 d-flex btn1">
                                <button class="btn ml-auto nuevo btn-success" @click="nuevoEncargo();">Nuevo encargo</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <template v-if="arrayEncargo.length">
                                <div class="col-md-6 mb-2" v-for="encargo in arrayEncargo" :key="encargo.idEncargo">
                                    <div class="card">
                                        <div class="card-header" v-bind:class="{'vigente' : calcul(encargo.fecha_maximo) >= 0, 'pasado': calcul(encargo.fecha_maximo) < 0}">
                                            <div class="row">
                                                <div class="col-md-12 d-flex">
                                                    <template v-if="calcul(encargo.fecha_maximo) >= 0">
                                                        <div class="noneBottom">
                                                            Días faltantes: <span>{{calcul(encargo.fecha_maximo)}}</span>
                                                        </div>
                                                    </template>
                                                    <template v-else>
                                                        <div class="noneBottom">
                                                            Días excedentes: <span>{{calcul(encargo.fecha_maximo)}}</span>
                                                        </div>
                                                    </template>
                                                    
                                                    <div class="btn-group ml-auto " role="group">
                                                        <button type="button" class="btn btns mr-2 btn-warning btn-sm" @click="llenarFormulario(encargo)">
                                                            <i class="icon-pencil"></i>
                                                        </button>
                                                        <button type="button" class="btn btns mr-2 btn-info btn-sm" @click="imprimir(encargo)">
                                                            <i class="fa fa-print"></i>
                                                        </button>
                                                        <template v-if="encargo.vigencia">
                                                            <button type="button" class="btn btns btn-success btn-sm" @click="desactivarCategoria(encargo.idEncargo)">
                                                                <i class="icon-check"></i>
                                                            </button>
                                                        </template>
                                                        <template v-else>
                                                            <button type="button" class="btn btns btn-danger btn-sm" @click="activarCategoria(encargo.idEncargo)">
                                                                <i class="icon-trash"></i>
                                                            </button>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <span class="estilo">Tipo de actividad:</span> {{encargo.tipo_actividad}}<br>
                                                <span class="estilo">Documento de solicitud:</span> {{encargo.documento_solicitud}}<br>
                                                <span class="estilo">Fecha de solicitud:</span> {{usemoment(encargo.fecha_solicitud)}}<br>
                                                <span class="estilo">Documento de autorización:</span> {{encargo.documento_autorizacion}}<br>
                                                <span class="estilo">Fecha de autorización:</span> {{usemoment(encargo.fecha_autorizacion)}}<br>
                                                <span class="estilo">Nombre de responsable:</span> {{encargo.nombre_responsable}}<br>
                                                <span class="estilo">Monto:</span> {{convert(encargo.monto_encargo)}}<br>
                                                <span class="estilo">Fecha de inicio:</span> {{usemoment(encargo.fecha_inicio)}}<br>
                                                <span class="estilo">Fecha de fin:</span> {{usemoment(encargo.fecha_final)}}<br>
                                                <span class="estilo">Fecha máxima de rendición:</span> {{usemoment(encargo.fecha_maximo)}}
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template v-else>
                                <div class="col-md-12">
                                    <template v-if="cargando">
                                        <div>
                                            Cargando....
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="alert alert-danger" role="alert">
                                            No hay resultados
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                        <nav>
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
                </template>
                <template v-else>
                    <div class="card-header" style="background-color:#fff!important;">
                        <div class="row justify-content-center mt-1 mb-3">
                            <h4 style="text-decoration:underline; font-weight: bold; text-transform: uppercase;">Control de los Encargos</h4>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3 col-sm-6">
                                <a href="#" class="btn btn-primary btn-xs aux" @click="interior()" style="margin-bottom:4px; word-wrap:break-word;" v-bind:class="{'borde' : bord == true}">ACTIVIDADES DESARROLLADAS AL INTERIOR DEL PAÍS</a>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <a href="#" class="btn btn-primary btn-xs aux" @click="exterior()" style="margin-bottom:4px; word-wrap:break-word;" v-bind:class="{'borde' : !bord == true}">ACTIVIDADES DESARROLLADAS AL EXTERIOR DEL PAÍS</a>
                            </div>
                            <div class="col-md-3 mt-1 ml-auto">
                                <h5>Fecha: {{obtenerHora}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center mt-1 mb-3">
                            <div>
                                <h6 style="font-weight: bold;">{{tipo_actividad}}</h6>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="" class="col-form-label">Documento de solicitud:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" v-model="documento_solicitud" class="form-control">
                                    <small v-if="errors.documento_solicitud" class="text-danger" v-text="errors.documento_solicitud[0]"></small>
                                </div>
                                <div class="col-md-1">
                                    <label for="" class="col-form-label">Fecha:</label>
                                </div>
                                <div class="col-md-3">
                                    <date-picker v-model="fechaSolicitud" :disabled-date="disableWeekends" value-type="format" :clearable = "false" format="DD-MM-YYYY"></date-picker>
                                    <small v-if="errors.fecha_solicitud" class="text-danger" v-text="errors.fecha_solicitud[0]"></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="" class="col-form-label">Documento de autorización:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" v-model="documento_autorizacion">
                                    <small v-if="errors.documento_autorizacion" class="text-danger" v-text="errors.documento_autorizacion[0]"></small>
                                </div>
                                <div class="col-md-1">
                                    <label for="" class="col-form-label">Fecha:</label>
                                </div>
                                <div class="col-md-3">
                                    <date-picker v-model="fechaAutorizacion" :disabled-date="disableWeekends" value-type="format" :clearable = "false" format="DD-MM-YYYY"></date-picker>
                                    <small v-if="errors.fecha_autorizacion" class="text-danger" v-text="errors.fecha_autorizacion[0]"></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="" class="col-form-label">Nombre del responsable del encargo:</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" @change="oportunidad(nombre_responsable)" v-model="nombre_responsable">
                                    <small v-if="errors.nombre_responsable" class="text-danger" v-text="errors.nombre_responsable[0]"></small>
                                </div>
                                <div class="col-md-1">
                                    <label for="" class="col-form-label">Área:</label>
                                </div>
                                <div class="col-md-3">
                                    <v-select label="nombre" @input="cambioEstado" :options="arrayArea" v-model="area" style="width:100% !important;" >
                                        <span  slot = "no-options" >No se encontró el área.</span>
                                    </v-select>   
                                    <small v-if="errors.idArea" class="text-danger" v-text="errors.idArea[0]"></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="" class="col-form-label">Monto:</label>
                                </div>
                                <div class="col-md-4">
                                    <vue-numeric v-bind:minus ="false" v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999999.99" class="form-control"  currency="" separator="," v-model="monto_encargo"></vue-numeric>
                                    <small v-if="errors.monto_encargo" class="text-danger" v-text="errors.monto_encargo[0]"></small>
                                </div>
                                
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <div class="row">
                                <div class="col-md-3 mt-2 mb-2">
                                    <div class="card">
                                        <div class="card-header">
                                            Fecha de inicio de actividades
                                        </div>
                                        <div class="card-body">
                                            <date-picker v-model="fechaInicio" :disabled-date="disableYear" :clearable = "false" value-type="format" format="DD-MM-YYYY"></date-picker>
                                            <small v-if="errors.fecha_inicio" class="text-danger" v-text="errors.fecha_inicio[0]"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-2 mb-2">
                                    <div class="card">
                                        <div class="card-header">
                                            Fecha final de actividades
                                        </div>
                                        <div class="card-body">
                                            <date-picker v-model="fechaFinal" @pick="propp" :disabled-date="disableYear" readonly :clearable = "false" value-type="format" format="DD-MM-YYYY"></date-picker>
                                            <small v-if="errors.fecha_final" class="text-danger" v-text="errors.fecha_final[0]"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-2 mb-2">
                                    <div class="card">
                                        <div class="card-header">
                                            Plazo máximo de rendición*
                                        </div>
                                        <div class="card-body">
                                            <date-picker v-model="fechaMaximo" :disabled-date="disableWeekends" :disabled = "true" :clearable = "false" value-type="format" format="DD-MM-YYYY"></date-picker>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-2 mb-2">
                                    <div class="card">
                                        <div class="card-header">
                                            <template v-if="cambia">
                                                <label for="">Días faltantes</label>
                                            </template>
                                            <template v-else>
                                                <div>
                                                    <label for="">Días excedentes</label>
                                                </div>
                                            </template>
                                            <div style="display:none;">
                                                {{dias}}
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <input type="text" class="form-control" style="background:#FFF8E1;" v-model="resta" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card-body border" style="background:#ffcdd2;">
                                        <p class="mb-0">{{texto1}}
                                        </p>
                                        <p><span style="font-weight:bold !important;font-style:italic !important;">{{texto2}}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer mb-0">
                            <button type="button" class="btn regresar btns text-white btn-secondary ml-auto" @click="se_muestra = true,scrollBehavior">Regresar</button>
                            <button v-if="tipoAccion == 1" class="btn nuevo btn-success" @click="registrarEncargo();">Registrar encargo</button>
                            <button v-if="tipoAccion == 2" class="btn nuevo btn-success" @click="actualizarEncargo();">Actualizar encargo</button>
                        </div>
                    </div>
                </template>
            </div>
        </div>             
    </main>
</template>
<script>
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    import DatePicker from 'vue2-datepicker'
    import 'vue2-datepicker/index.css';
    import 'vue2-datepicker/locale/es';
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import VueNumeric from 'vue-numeric'
    export default {
        components:{
            DatePicker,
            vSelect,
            VueNumeric
        },
        data() {
            return {
                mes : '', 
                anho : '',
                idEncargo : 0,
                cargando : true,
                buscar : '',
                mesBuscar : '',
                arrayEncargo : [],
                documento_autorizacion : '',
                documento_solicitud : '',
                nombre_responsable : '',
                monto_encargo : 0,
                area : '',
                fechaSolicitud : '',
                fechaAutorizacion : '',
                fechaInicio : '',
                fechaFinal : '',
                fechaMaximo : '',
                tipo_actividad : '',
                texto1 : '',
                texto2 : '',
                validar : '',
                arrayArea : [],
                errors:{},
                resta: '', 
                maximo : '', 
                fecha : '',
                contador : 0, 
                idArea : 0,
                cambia : true,
                descontar : 0,
                se_muestra : true,
                tipoAccion : 1,
                bord : true,
                pagination : {
                    'total'          : 0,
                    'current_page'   : 0,
                    'per_page'       : 0,
                    'last_page'      : 0,
                    'from'           : 0, //desde la página
                    'to'             : 0, //hasta la página
                },
                offset : 3
            }
        },
        computed:{
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
            obtenerHora(){
                return  moment().format('DD-MM-YYYY');
            },
            dias(){
                if(this.fechaFinal!= '' && this.fechaMaximo != ''){
                    var aux = moment().format('DD-MM-YYYY');
                    this.resta = moment((this.fechaMaximo.split("-").reverse().join("-"))).diff(moment((aux).split("-").reverse().join("-")), 'days');
                    var mayor, menor, contador = 1, restar = 0;
                        if(this.resta > 0){
                            mayor = this.fechaMaximo;
                            menor = aux;
                            contador = 1;
                        }else{
                            mayor = aux;
                            menor = this.fechaMaximo;
                            contador = 0;
                        }
                        var recorre = moment((mayor.split("-").reverse().join("-"))).diff(moment((menor).split("-").reverse().join("-")), 'days');
                        while(contador<=recorre){
                            var nombre_semana = moment(menor, "DD-MM-YYYY").add(contador, 'days').format("DD-MM-YYYY");
                            var semana = moment(nombre_semana, "DD-MM-YYYY").isoWeekday()
                            var day = moment(nombre_semana, "DD-MM-YYYY").date();
                            var mot = moment(nombre_semana, "DD-MM-YYYY").month();
                            if((day == 1 && mot == 0 || day == 9 && mot == 3 || day == 10 && mot == 3|| day == 1 && mot == 4|| 
                                day == 29 && mot == 5|| day == 27 && mot == 6|| day == 28 && mot == 6|| day == 29 && mot == 6||
                                day == 30 && mot == 7 || day == 8 && mot == 9|| day == 9 && mot == 9 || day == 1 && mot == 10 || 
                                day == 8 && mot == 11 || day == 25 && mot ==11 || day == 31 && mot ==11)||(semana == 6 || semana ==7)){
                                restar ++;
                            }
                            contador ++;
                        }
                    if(this.resta < 0){
                        this.cambia = false;
                        this.resta = this.resta + restar;
                        return this.resta;
                    }else{
                        this.resta = this.resta -restar;
                        this.cambia = true;
                        return this.resta;
                    }
                }else{
                    this.resta = '';
                    this.cambia = true;
                    return this.resta;
                }
            },
        },
        methods: {
            oportunidad(nombre_responsable){
                var number = nombre_responsable.replace(/\s/g, "");
                if(number.length >= 6){
                    axios.post("/Encargo/buscarPersona", {
                        'nombre' : nombre_responsable,
                    }).then(function(response){
                        if(response.data.cantidad != 0){
                            
                            toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": true,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": 0,
                                "extendedTimeOut": 0,
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut",
                                "tapToDismiss": false
                            }
                            toastr["warning"]('La persona posee encargos pendientes por rendir.', "Advertencia")
                            toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": true,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": 0,
                                "extendedTimeOut": 0,
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut",
                                "tapToDismiss": false
                            }
                        }
                    })
                }
            },
            desactivarCategoria(idEncargo){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success mr-2',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                title: '¿Se rindió el Encargo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No',
                reverseButtons: false
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put("/Encargo/desactivar", {
                        'idEncargo' : idEncargo
                    }).then(function(response){ 
                        me.listarEgreso(1, me.buscar, me.mes, me.anho);
                    })
                    .catch(function(error){
                    })
                    swalWithBootstrapButtons.fire(
                    'Éxito',
                    'Encargo Actualizado Correctamente.',
                    'success')
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                }
                })
            },activarCategoria(idEncargo){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success mr-2',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                title: '¿Está seguro de Modificar la Rendición?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No',
                reverseButtons: false
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put("/Encargo/activar", {
                        'idEncargo' : idEncargo
                    }).then(function(response){
                        me.listarEgreso(1, me.buscar, me.mes, me.anho);
                    })
                    .catch(function(error){
                    })
                    swalWithBootstrapButtons.fire(
                    'Éxito',
                    'Encargo Actualizado Correctamente.',
                    'success')
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                }
                })
            },
            convert(number){
                let val = (number/1).toFixed(2).replace(',', '.');
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            llenarFormulario(data){
                this.tipoAccion = 2;
                this.idEncargo = data['idEncargo'];
                this.documento_autorizacion = data['documento_autorizacion'];
                this.documento_solicitud = data['documento_solicitud'];
                this.fechaSolicitud = this.usemoment(data['fecha_solicitud']);
                this.fechaAutorizacion = this.usemoment(data['fecha_autorizacion']);
                this.nombre_responsable = data['nombre_responsable'];
                this.idArea = data['idArea'];
                this.area = data['nombreArea'];
                this.maximo = 3; 
                if('Actividades desarrolladas al interior del país' == data['tipo_actividad']){
                    this.tipo_actividad = 'Actividades desarrolladas al interior del país';
                    this.texto1 ='Para actividades desarrolladas al interior del país, la rendición de cuentas no debe exceder los 3 días hábiles después de concluida la actividad materia del encargo. No procede la entrega de nuevos Encargos a personas que tienen pendientes la rendición de cuentas o devolución de montos no utilizados de Encargos anteriormente otorgados.';
                    this.texto2 = '(Art. 40° de la Directiva n.° 001-2007-EF/77.15 Directiva de Tesorería, aprobada el 24 de enero de 2007 vigente desde el 25 de enero de 2007 y modificada mediante la R.D. 004-2009-EF-77.15 de 8 de abril de 2009 vigente a la actualidad)';
                    this.maximo = 3;
                }else{
                    this.tipo_actividad ='Actividades desarrolladas al exterior del país';
                    this.texto1 = 'Para actividades desarrolladas al exterior del país, la rendición de cuentas no debe exceder los 15 días hábiles después de concluida la actividad materia del encargo. No procede la entrega de nuevos Encargos a personas que tienen pendientes la rendición de cuentas o devolución de montos no utilizados de Encargos anteriormente otorgados.'
                    this.texto2 = '(Art. 40° de la Directiva n.° 001-2007-EF/77.15 Directiva de Tesorería, aprobada el 24 de enero de 2007 vigente desde el 25 de enero de 2007 y modificada mediante la R.D. 004-2009-EF-77.15 de 8 de abril de 2009 vigente a la actualidad)';
                    this.maximo = 15;
                }
                this.fechaInicio = this.usemoment(data['fecha_inicio']);
                this.fechaFinal = this.usemoment(data['fecha_final']);
                this.monto_encargo = data['monto_encargo'];
                this.fechaMaximo = this.usemoment(data['fecha_maximo']);
                this.se_muestra = false;
            },
            validateMes(){
                
                if(!this.mesBuscar){
                    this.mesBuscar = '';
                    this.mes = '';
                    this.anho = '';
                }else{
                    this.mes = new Date(this.mesBuscar).getMonth() + 1;
                    this.anho = new Date(this.mesBuscar).getFullYear();
                }
                this.listarEgreso(1, this.buscar, this.mes, this.anho);
            },
            imprimir(data){
                var arreglo = new Array();  
                var compara = 0;
                var money = '';
                var titulo = '';
                compara = this.calcul(data['fecha_maximo']);
                money = this.convert(data['monto_encargo']);
                if(compara >=0){
                    titulo = 'Días faltantes: ' + compara;
                }else{
                    titulo = 'Días excedentes: ' + compara;
                }
                window.open('http://muni.pibea.org/Encargo/printf/'+'RGDUQc7pPdWVPKGekpIHMOKG7fwFcO8H+JMs92yylpAypUPtIOznlxtfIayb9811D5EQ43fCvInBjV5yPU9g=='+'/'+data['idEncargo']+'/RGDUQc7pPdWVPKGekpIHMOKG7fwFcO8H+JMs92yylpAypUPtIOznlxtfIayb9811D5EQ43fCvInBjV5yPU9g=='+ '/' + titulo+ '/' + money+'/RGDUQc7pPdWVPKGekpIHMOKG7fwFcO8H+JMs92yylpAypUPtIOznlxtfIayb9811D5EQ43fCvInBjV5yPU9g==');
            },
            nuevoEncargo(){
                this.interior();
                this.tipoAccion = 1;
                this.se_muestra = false;
                this.limpiar();
            },
            cambiarPagina(page){
                let me = this;
                me.pagination.current_page = page;
                me.listarEgreso(page, me.buscar, me.mes, me.anho)
            },
            propp(date){
                if(this.fechaFinal){
                    this.contador = 0;
                    var aux = moment(date).format('DD-MM-YYYY');
                    var sum = date;
                    while(this.contador != this.maximo){
                        aux = moment(aux, "DD-MM-YYYY").add(1, 'days').format("DD-MM-YYYY");
                        const dia = new Date(sum).getDay();
                        const day = new Date(sum.setDate(sum.getDate()+1)).getDate();
                        const mot = new Date(sum).getMonth(); 
                        if((day == 1 && mot == 0 || day == 9 && mot == 3 || day == 10 && mot == 3|| day == 1 && mot == 4|| 
                day == 29 && mot == 5|| day == 27 && mot == 6|| day == 28 && mot == 6|| day == 29 && mot == 6||
                 day == 30 && mot == 7 || day == 8 && mot == 9|| day == 9 && mot == 9 || day == 1 && mot == 10 || 
                 day == 8 && mot == 11 || day == 25 && mot ==11 || day == 31 && mot ==11) || (dia==6 || dia==5)){
                        }else{
                            this.contador ++;
                        }
                        if(this.contador == this.maximo){
                            this.fechaMaximo = moment(sum).format('DD-MM-YYYY');
                        }
                    }
                }
            },
            calcul:function (fechaMaximo){
                var aux = moment().format('DD-MM-YYYY');
                fechaMaximo = moment(fechaMaximo).format('DD-MM-YYYY');
                var resta = moment((fechaMaximo.split("-").reverse().join("-"))).diff(moment((aux).split("-").reverse().join("-")), 'days');
                var mayor, menor, contador = 1, restar = 0;
                if(resta > 0){
                    mayor = fechaMaximo;
                    menor = aux;
                    contador = 1;
                }else{
                    mayor = aux;
                    menor = fechaMaximo;
                    contador = 0;
                }
                var recorre = moment((mayor.split("-").reverse().join("-"))).diff(moment((menor).split("-").reverse().join("-")), 'days');
                while(contador<=recorre){
                    var nombre_semana = moment(menor, "DD-MM-YYYY").add(contador, 'days').format("DD-MM-YYYY");
                    var semana = moment(nombre_semana, "DD-MM-YYYY").isoWeekday()
                    var day = moment(nombre_semana, "DD-MM-YYYY").date();
                    var mot = moment(nombre_semana, "DD-MM-YYYY").month();
                    if((day == 1 && mot == 0 || day == 9 && mot == 3 || day == 10 && mot == 3|| day == 1 && mot == 4|| 
                        day == 29 && mot == 5|| day == 27 && mot == 6|| day == 28 && mot == 6|| day == 29 && mot == 6||
                        day == 30 && mot == 7 || day == 8 && mot == 9|| day == 9 && mot == 9 || day == 1 && mot == 10 || 
                        day == 8 && mot == 11 || day == 25 && mot ==11 || day == 31 && mot ==11)||(semana == 6 || semana ==7)){
                        restar ++;
                    }
                    contador ++;
                }
                if(resta < 0){
                    resta = resta + restar;
                    return resta;
                }else{
                    resta = resta -restar;
                    return resta;
                }
            },
            disableYear(date){
                const year = new Date(date).getFullYear(); (year>2040 || year <2020)
                return(year>2040 || year <2020);
            },
            disableWeekends(date) {
                const dia = new Date(date).getDay();
                const day = new Date(date).getDate();
                const mot = new Date(date).getMonth();
                const year = new Date(date).getFullYear(); (year>2040 || year <2020)
                return (day == 1 && mot == 0 || day == 9 && mot == 3 || day == 10 && mot == 3|| day == 1 && mot == 4|| 
                day == 29 && mot == 5|| day == 27 && mot == 6|| day == 28 && mot == 6|| day == 29 && mot == 6||
                 day == 30 && mot == 7 || day == 8 && mot == 9|| day == 9 && mot == 9 || day == 1 && mot == 10 || 
                 day == 8 && mot == 11 || day == 25 && mot ==11 || day == 31 && mot ==11) || (dia==0 || dia==6) || (year>2040 || year <2020) ;
            },
            notBeforeToday(date) {
                return date.noWeekends;
            },
            notAfterToday(date) {
                return date > today;
            },
            interior(){
                this.tipo_actividad = 'Actividades desarrolladas al interior del país';
                this.texto1 ='Para actividades desarrolladas al interior del país, la rendición de cuentas no debe exceder los 3 días hábiles después de concluida la actividad materia del encargo. No procede la entrega de nuevos Encargos a personas que tienen pendientes la rendición de cuentas o devolución de montos no utilizados de Encargos anteriormente otorgados.';
                this.texto2 = '(Art. 40° de la Directiva n.° 001-2007-EF/77.15 Directiva de Tesorería, aprobada el 24 de enero de 2007 vigente desde el 25 de enero de 2007 y modificada mediante la R.D. 004-2009-EF-77.15 de 8 de abril de 2009 vigente a la actualidad)';
                this.maximo = 3;
                this.fechaFinal = '';
                this.fechaMaximo = '';
                this.contador = 0;
                this.bord = true;
            },
            exterior(){
                this.tipo_actividad ='Actividades desarrolladas al exterior del país';
                this.texto1 = 'Para actividades desarrolladas al exterior del país, la rendición de cuentas no debe exceder los 15 días hábiles después de concluida la actividad materia del encargo. No procede la entrega de nuevos Encargos a personas que tienen pendientes la rendición de cuentas o devolución de montos no utilizados de Encargos anteriormente otorgados.'
                this.texto2 = '(Art. 40° de la Directiva n.° 001-2007-EF/77.15 Directiva de Tesorería, aprobada el 24 de enero de 2007 vigente desde el 25 de enero de 2007 y modificada mediante la R.D. 004-2009-EF-77.15 de 8 de abril de 2009 vigente a la actualidad)';
                this.maximo = 15;
                this.fechaFinal = '';
                this.fechaMaximo = '';
                this.contador = 0;
                this.bord = false;
            },
            selectArea(){
                let me = this;
                var url = '/Area/selectArea';
                axios.get(url).then(function(response){//obteniendo todo lo que envia el url, todo los registros 
                    var respuesta = response.data;
                    me.arrayArea = respuesta.areas;
                })
                .catch(function(error){
                    console.log(error);
                });
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
            scrollBehavior: function (to, from, savedPosition) {
                return savedPosition || { x: 0, y: 0 }
            },
            actualizarEncargo(){
                this.errors = [];
                let me = this;
                axios.post("/Encargo/actualizar", {
                    'idEncargo' : this.idEncargo,
                    'idArea' : this.idArea,
                    'fecha_solicitud' : me.savemoment(this.fechaSolicitud),
                    'fecha_autorizacion' : me.savemoment(this.fechaAutorizacion),
                    'fecha_inicio' : me.savemoment(this.fechaInicio),
                    'fecha_final' : me.savemoment(this.fechaFinal),
                    'fecha_maximo' : me.savemoment(this.fechaMaximo),
                    'documento_solicitud' : this.documento_solicitud,
                    'tipo_actividad' : this.tipo_actividad,
                    'documento_autorizacion' : this.documento_autorizacion,
                    'nombre_responsable' : this.nombre_responsable,
                    'monto_encargo' : this.monto_encargo,
                }).then(function(response){
                    me.limpiar();
                    me.buscar = '';
                    me.mesBuscar = '';
                    me.listarEgreso(1, me.buscar, me.mes, me.anho);
                    toastr.success('Registro actualizado.');
                    me.se_muestra = true
                })
                .catch((error)=> this.errors = error.response.data.errors)
            },
            registrarEncargo(){
                this.errors = [];
                let me = this;
                axios.post("/Encargo/registrar", {
                    'idArea' : this.idArea,
                    'fecha_solicitud' : me.savemoment(this.fechaSolicitud),
                    'fecha_autorizacion' : me.savemoment(this.fechaAutorizacion),
                    'fecha_inicio' : me.savemoment(this.fechaInicio),
                    'fecha_final' : me.savemoment(this.fechaFinal),
                    'fecha_maximo' : me.savemoment(this.fechaMaximo),
                    'documento_solicitud' : this.documento_solicitud,
                    'tipo_actividad' : this.tipo_actividad,
                    'documento_autorizacion' : this.documento_autorizacion,
                    'nombre_responsable' : this.nombre_responsable,
                    'monto_encargo' : this.monto_encargo,
                }).then(function(response){
                    me.limpiar();
                    me.buscar = '';
                    me.mesBuscar = '';
                    me.listarEgreso(1, me.buscar, me.mes, me.anho);
                    toastr.success('Encargo registrado.');
                    me.se_muestra = true
                })
                .catch((error)=> this.errors = error.response.data.errors)
            }, 
            cambioEstado(){
                if(!this.area){
                    this.idArea = 0;
                }else{
                    this.idArea = this.area.idArea;
                }
            }, 
            limpiar(){
                this.area = '';
                this.idArea = 0;
                this.documento_solicitud = '';
                this.documento_autorizacion = '';
                this.nombre_responsable = '';
                this.monto_encargo = 0;
                this.fechaSolicitud = '';
                this.fechaAutorizacion = '';
                this.fechaInicio = '';
                this.fechaMaximo = '';
                this.fechaFinal = '';
                this.cambia = true;
                this.errors = [];
            },
            listarEgreso(page, buscar, mes, anho){
                let me = this;
                var url = '/Encargo?page=' + page + '&buscar=' + buscar + '&mes=' + mes + '&anho=' + anho ;
                axios.get(url).then(function(response){//obteniendo todo lo que envia el url, todo los registros 
                    var respuesta = response.data;
                    me.arrayEncargo = respuesta.encargo.data;
                    me.pagination = respuesta.pagination;
                    me.cargando =  false;
                })
                .catch(function(error){
                    console.log(error);
                });
            }
        },
        mounted() {
            this.interior();
            this.selectArea();
            this.listarEgreso(1, this.buscar, this.mes, this.anho);
        }
    }
</script>
<style>
.mx-datepicker{
    width: 100% !important;
}
.card{
    border-radius: 10px;
    margin-bottom: 0px;
}
.card-header{
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    /*background-color: #56E396;*/
}
.fa-align-justify:before {
    color: whitesmoke !important;
}
.mod{
    background-color: #21B2FD;
    border-color: #21B2FD;
    color: black;
    margin-left: 20px;
    border-radius: 20px !important;
}
.mod:hover{
    background-color: #9E80FF;
    border-color:#9E80FF;
    color: white;
    border-radius: 20px;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.05);
}
.mods{
    border-radius : 10px;
}
.modle{
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
    color: #fff;
    background-color: #9E80FF !important;
}
.border{
    border-bottom-left-radius: 10px;
    border-top-left-radius: 10px;
}
.btn-border{
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    margin-top: 0px !important;
}
.btns{
    border-radius: 10px !important;
    
}.aux{
    white-space:normal !important;
    border-radius: 10px !important;
}
.estilo{
    font-weight: bold;
}
.vigente{
    background-color: #4CAF50;
    color: #fff;
}
.nuevo{
    border-radius: 20px !important;
    background-color: #4CAF50 !important;
    color: #fff;
    margin-top: 0px !important;
}
.regresar{
    border-radius: 20px !important;
}
.pasado{
    background-color: #E53935;  
    color: #fff;
}
label{
    margin-bottom: 0!important;
}
.noneBottom{
    margin-top: 5px;
}
.document-nice{
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}
@media (max-width: 500px) {
    .asd{
        display: block;
        width: 100%;
        overflow-x: auto;
    }
    .btn1{
        margin-bottom: 5px;
    }
}
</style>