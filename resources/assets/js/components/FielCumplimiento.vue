<template>
    <main class="main">
        &nbsp;
        <div class="container-fluid">
            <div class="card mb-4">
                <template v-if="se_muestra">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3 btn1">
                                <h6 class="mt-1">Garantías de fiel cumplimiento.</h6>
                            </div>
                            <div class="col-md-4 btn1">
                                <div class="input-group">
                                    <input type="text" @keyup.enter="listarEgreso(1, buscar, mes, anho)" v-model="buscar" class="form-control document-nice " placeholder="Documento a buscar">
                                    <button type="submit" @click.prevent="listarEgreso(1, buscar, mes, anho)" class="btn btn-primary btn-border"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>    
                            <div class="col-md-3 btn1">
                                <date-picker v-model="mesBuscar" type="month" value-type="date" format="MM-Y" @change="validateMes()" placeholder="Seleccionar mes"></date-picker>
                            </div>    
                            <div class="col-md-2 d-flex btn1">
                                <button class="btn ml-auto nuevo btn-success" @click="nuevoEncargo();">Nuevo Contrato</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <template v-if="arrayViatico.length">
                                <div class="col-md-6 mb-2" v-for="fiel in arrayViatico" :key="fiel.idFiel">
                                    <div class="card" v-bind:class="{'subrayado' : calcul(fiel.fecha_termino_garantia) >= 0,'help': calcul(fiel.fecha_termino_garantia) < 0}">
                                        <div class="card-header"  v-bind:class="{'vigente' : calcul(fiel.fecha_termino_garantia) >= 0, 'pasado': calcul(fiel.fecha_termino_garantia) < 0}">
                                            <div class="row">
                                                <div class="col-md-12 d-flex">
                                                    <template v-if="calcul(fiel.fecha_termino_garantia) >= 0">
                                                        <div class="noneBottom">
                                                            Días faltantes: <span>{{calcul(fiel.fecha_termino_garantia)}}</span>
                                                        </div>
                                                    </template>
                                                    <template v-else>
                                                        <div class="noneBottom">
                                                            Días excedentes: <span>{{calcul(fiel.fecha_termino_garantia)}}</span>
                                                        </div>
                                                    </template>
                                                    <div class="btn-group ml-auto " role="group">
                                                        <button type="button" class="btn btns mr-2 btn-success btn-sm" @click="cambiarFormulario(fiel)">
                                                            <i class="icon-book-open"></i>
                                                        </button>
                                                        <button type="button" class="btn btns mr-2 btn-warning btn-sm" @click="llenarFormulario(fiel)">
                                                            <i class="icon-pencil"></i>
                                                        </button>
                                                        <button type="button" class="btn btns btn-info btn-sm" @click="imprimir(fiel)">
                                                            <i class="fa fa-print"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <span class="estilo">Documento de remisión:</span> {{fiel.documento_remision}}<br>
                                                <!-- <span class="estilo">Fecha de Remisión:</span> {{usemoment(fiel.fecha_remision)}}<br> -->
                                                <span class="estilo">Fecha de recepción por tesorería:</span> {{usemoment(fiel.fecha_recepcion)}}<br>
                                                <span class="estilo">Contrato:</span> {{fiel.contrato}}<br>
                                                <!-- <span class="estilo">Monto del Contrato:</span> {{convert(fiel.monto_contrato)}}<br> -->
                                                <span class="estilo">Monto de garantía:</span> {{convert(total(fiel))}}<br>
                                                <span class="estilo">Fecha de inicio de garantía:</span> {{usemoment(fiel.fecha_inicio_garantia)}}<br>
                                                <span class="estilo">Fecha de término de garantía:</span> {{usemoment(fiel.fecha_termino_garantia)}}
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
                            <h4 v-if="!garantia" style="font-weight: bold; text-transform: uppercase;">Control de las Garantías de Fiel Cumplimiento</h4>
                            <h4 v-if="garantia" style="font-weight: bold;">Modificaciones a las garantías por modificaciones del contrato</h4>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3 mt-1 ml-auto">
                                <h5>Fecha: {{obtenerHora}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <template v-if="!garantia">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="" class="col-form-label">Documento de remisión de la garantía al área de tesorería: </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" v-model="documento_remision" class="form-control">
                                        <small v-if="errors.documento_remision" class="text-danger" v-text="errors.documento_remision[0]"></small>
                                    </div>
                                    <div class="col-md-1">
                                        <label for="" class="col-form-label">Fecha: </label>
                                    </div>
                                    <div class="col-md-3">
                                        <date-picker v-model="fecha_remision" :disabled-date="disableWeekends" value-type="format" :clearable = "false" format="DD-MM-YYYY"></date-picker>
                                        <small v-if="errors.fecha_remision" class="text-danger" v-text="errors.fecha_remision[0]"></small>
                                    </div>
                                </div>
                            </div>    
                            <div class="form-group">
                                <div class="row d-flex form-inline">
                                    <div class="ml-auto col-md-3">
                                        <label for="" class="col-form-label">Fecha de la recepción de la garantía dal área de tesorería: </label>
                                    </div>
                                    <div class="col-md-3">
                                        <date-picker v-model="fecha_recepcion" :disabled-date="disableWeekends" value-type="format" :clearable = "false" format="DD-MM-YYYY"></date-picker>
                                        <small v-if="errors.fecha_recepcion" class="text-danger" v-text="errors.fecha_recepcion[0]"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="" class="col-form-label">Contrato Nº: </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" v-model="contrato">
                                        <small v-if="errors.contrato" class="text-danger" v-text="errors.contrato[0]"></small>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="" class="col-form-label">Monto del contrato:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <vue-numeric v-bind:minus ="false" v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999999.99" class="form-control"  currency="" separator="," v-model="monto_contrato"></vue-numeric>
                                        <small v-if="errors.monto_contrato" class="text-danger" v-text="errors.monto_contrato[0]"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row d-flex">
                                    <div class="ml-auto col-md-3">
                                        <label for="" class="col-form-label">Monto de la garantría:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <vue-numeric v-bind:minus ="false" v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999999.99" class="form-control"  currency="" separator="," v-model="monto_garantia"></vue-numeric>
                                        <small v-if="errors.monto_garantia" class="text-danger" v-text="errors.monto_garantia[0]"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row justify-content-center">
                                            <h5>Plazo de cobertura de garantía</h5>
                                        </div>
                                        <div class="form-inline">
                                            <div class="col-md-6 mt-2 mb-2">
                                                <div class="card">
                                                    <div class="card-header">
                                                        Fecha de inicio
                                                    </div>
                                                    <div class="card-body">
                                                        <date-picker v-model="fecha_inicio_garantia" :disabled-date="disableYear" :clearable = "false" value-type="format" format="DD-MM-YYYY"></date-picker>
                                                        <small v-if="errors.fecha_inicio_garantia" class="text-danger" v-text="errors.fecha_inicio_garantia[0]"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-2 mb-2">
                                                <div class="card">
                                                    <div class="card-header">
                                                        Fecha de término
                                                    </div>
                                                    <div class="card-body">
                                                        <date-picker v-model="fecha_termino_garantia" :disabled-date="disableYear" readonly :clearable = "false" value-type="format" format="DD-MM-YYYY"></date-picker>
                                                        <small v-if="errors.fecha_termino_garantia" class="text-danger" v-text="errors.fecha_termino_garantia[0]"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row justify-content-center">
                                            <h5>Plazo de ejecución del contrato</h5>
                                        </div>
                                        <div class="form-inline">
                                            <div class="col-md-6 mt-2 mb-2">
                                                <div class="card">
                                                    <div class="card-header">
                                                        Fecha de inicio
                                                    </div>
                                                    <div class="card-body">
                                                        <date-picker v-model="fecha_inicio_contrato" :disabled-date="disableWeekends"  :clearable = "false" value-type="format" format="DD-MM-YYYY"></date-picker>
                                                        <small v-if="errors.fecha_inicio_contrato" class="text-danger" v-text="errors.fecha_inicio_contrato[0]"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-2 mb-2">
                                                <div class="card">
                                                    <div class="card-header">
                                                        Fecha de término
                                                    </div>
                                                    <div class="card-body">
                                                        <date-picker v-model="fecha_termino_contrato" :disabled-date="disableWeekends" :clearable = "false" value-type="format" format="DD-MM-YYYY"></date-picker>
                                                        <small v-if="errors.fecha_termino_contrato" class="text-danger" v-text="errors.fecha_termino_contrato[0]"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Un v-show, si es registro normal, si es edición del documento lo de arriba y si es modificación de garantía lo de abajo, mosca que los mensajes sí van -->
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row justify-content-center mb-3">
                                                        <h5>Garantías adicionales</h5>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="" class="col-form-label">Monto adicional 1:</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" step="0.01" min="0" :disabled="!permite_1" value="0" max="99999999.99" pattern="^\d*(\.\d{0,2})?$" v-model="monto_adicional_1" class="form-control">
                                                                <small v-if="errors.monto_adicional_1" class="text-danger" v-text="errors.monto_adicional_1[0]"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="" class="col-form-label">Monto adicional 2:</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" step="0.01" min="0" :disabled="!permite_2" value="0"  max="99999999.99" pattern="^\d*(\.\d{0,2})?$" v-model="monto_adicional_2" class="form-control">
                                                                <small v-if="errors.monto_adicional_2" class="text-danger" v-text="errors.monto_adicional_2[0]"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="" class="col-form-label">Monto adicional 3:</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" step="0.01" min="0" value="0" :disabled="!permite_3" max="99999999.99" pattern="^\d*(\.\d{0,2})?$" v-model="monto_adicional_3" class="form-control">
                                                                <small v-if="errors.monto_adicional_3" class="text-danger" v-text="errors.monto_adicional_3[0]"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row justify-content-center mb-3">
                                                        <h5>Reducciones</h5>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="" class="col-form-label">Monto de reducción:</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" step="0.01" min="0" value="0" :disabled="!permite_reduccion" max="99999999.99" pattern="^\d*(\.\d{0,2})?$" v-model="monto_reduccion" class="form-control">
                                                                <small v-if="errors.monto_reduccion" class="text-danger" v-text="errors.monto_reduccion[0]"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mt-4">
                                                    <div class="row justify-content-center">
                                                        <h4 style="font-wight: bold;">Ampliación de plazo de la garantía por ampliacion en el plazo contractual</h4>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <div class="row justify-content-center">
                                                            <div class="col-md-3 mt-2 mb-2">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        Término de la garantía (*)
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <date-picker v-model="fecha_termino_ampliacion"  @pick="propp" :disabled-date="disableYear" :clearable = "false" value-type="format" format="DD-MM-YYYY"></date-picker>
                                                                        <small v-if="errors.fecha_termino_ampliacion" class="text-danger" v-text="errors.fecha_termino_ampliacion[0]"></small>
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
                                                                <span>(*) Incluye ampliación.</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-body border" style="background:#b2ebf2;">
                                        <p class="mb-0">Para perfeccionar el contrato, el contratista deberá entregar a la Entidad una garantía de fiel cumplimiento del 10% del monto del contrato original. Esta deberá estar vigente hasta la conformidad de la recepción del bien, servicio y/o consultoría.  Y trantándose de la ejecución y consultoría de obras, hasta el consentimiento de la liquidación final.</p>
                                        <p><span style="font-weight:bold !important;font-style:italic !important;">(Art. 149° del Reglamento de la Ley N° 30225, Ley de Contrataciones del Estado aprobada mediante D.S. N° 344-2018-EF vigente desde el 30 de enero de 2019 y modificada mediante Decreto Supremo N° 377-2019-EF de 14 de diciembre de 2019.)</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="card-body border" style="background:#ffecb8;">
                                        <p class="mb-0">Se considera un tiempo de alerta de 10 días hábiles antes del vencimiento de la garantía debido a que es un  periodo prudencial en el cual el tesorero puede revisar el avance de obra, determinar si esta garantía requiere ser renovada o no, informar sobre tal situación a la administración, que esta advierta al contratista y que finalmente este renueve la citada garantía.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer mb-0">
                            <button type="button" class="btn regresar btns text-white btn-secondary ml-auto" @click="se_muestra = true,scrollBehavior">Regresar</button>
                            <template v-if="!garantia">
                                <button v-if="tipoAccion == 1" class="btn nuevo btn-success" @click="registrarEncargo();">Registrar garantía</button>
                                <button v-if="tipoAccion == 2" class="btn nuevo btn-success" @click="actualizarEncargo();">Actualizar garantía</button>    
                            </template>
                            <template v-else>
                                <button class="btn nuevo btn-success" @click="modificarGarantia();">Modificar garantía</button>
                            </template>
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
    import moment from 'moment';
    import VueNumeric from 'vue-numeric';
    export default {
        components:{
            DatePicker,
            vSelect,
            VueNumeric
        },
        data() {
            return {
                //Nuevas
                documento_remision :'',
                fecha_remision : '', 
                fecha_recepcion : '', 
                contrato : '',
                monto_contrato : '0', 
                monto_garantia : '0', 
                fecha_inicio_garantia : '',
                fecha_termino_garantia : '', 
                fecha_inicio_contrato : '', 
                fecha_termino_contrato : '',
                monto_adicional_1 : '0',
                monto_adicional_2 : '0',
                monto_adicional_3 : '0',
                monto_reduccion : '0',
                fecha_termino_ampliacion : '0',
                disconect_1 : false,
                disconect_2 : false,
                disconect_3 : false,
                //No Nuevas
                mes : '',
                anho : '',
                idViatico : 0,
                cargando : true,
                buscar : '',
                mesBuscar : '',
                arrayViatico : [],
                documento_autorizacion : '',
                documento_solicitud : '',
                nombre_responsable : '',
                monto_viatico : 0,
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
                garantia:false,
                idFiel : '',
                ok : true,
                //Validation
                permite_1 : false,
                permite_2 : false,
                permite_3 : false,
                permite_reduccion : false,
                //Sumasxd
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
                if(this.fechaMaximo != ''){
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
            convert(number){
                let val = (number/1).toFixed(2).replace(',', '.');
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            total(data){
                var garantia = data['monto_garantia'];
                var adicional1 = data['monto_adicional_1'];
                var adicional2 = data['monto_adicional_2'];
                var adicional3 = data['monto_adicional_3'];
                var reduccion = data['monto_reduccion'];
                
                var totalSuma = parseFloat(garantia) + parseFloat(adicional1) + parseFloat(adicional2) + parseFloat(adicional3) + parseFloat(adicional3) - parseFloat(reduccion);
             
                return parseFloat(totalSuma).toFixed(2);
            },
            cambiarFormulario(data){
                this.garantia = true;
                this.se_muestra = false;
                this.idFiel = data['idFiel'];
                this.monto_adicional_1 = data['monto_adicional_1'];
                this.monto_adicional_2 = data['monto_adicional_2'];
                this.monto_adicional_3 = data['monto_adicional_3'];
                this.monto_reduccion = data['monto_reduccion'];
                this.fecha_termino_ampliacion = data['fecha_termino_ampliacion'];
                
                console.log(this.fecha_termino_ampliacion);
                if(this.fecha_termino_ampliacion == null){
                    this.fecha_termino_ampliacion = this.usemoment(data['fecha_termino_garantia']);;
                    this.fechaMaximo = this.fecha_termino_ampliacion;
                }else{
                    this.fecha_termino_ampliacion = this.usemoment(data['fecha_termino_ampliacion']);
                    this.fechaMaximo = this.fecha_termino_ampliacion;
                }
                if(this.monto_adicional_1 == 0){
                    this.permite_1 = true;
                    this.permite_2 = false;
                    this.permite_3 = false;
                }
                if(this.monto_adicional_1 != 0){
                    this.permite_1 = true;
                    this.permite_2 = true;
                    this.permite_3 = false;
                }
                if(this.monto_adicional_2 != 0){
                    this.permite_1 = true;
                    this.permite_2 = true;
                    this.permite_3 = true;
                }
                if(this.monto_adicional_3 == 0 && this.monto_adicional_2 == 0 && this.monto_adicional_1 == 0  ){
                    this.permite_reduccion = true;
                }else{
                    this.permite_reduccion = false;
                }
                if(this.monto_reduccion != 0){
                    this.permite_1 = false;
                    this.permite_2 = false;
                    this.permite_3 = false;
                }
            },
            llenarFormulario(data){
                this.garantia = false;
                this.tipoAccion = 2;
                this.idFiel = data['idFiel'];
                this.documento_remision = data['documento_remision'];
                this.fecha_remision = this.usemoment(data['fecha_remision']);
                this.fecha_recepcion = this.usemoment(data['fecha_recepcion']);
                this.contrato = data['contrato'];
                this.monto_contrato = data['monto_contrato'];
                this.monto_garantia = data['monto_garantia'];
                this.fecha_inicio_garantia = this.usemoment(data['fecha_inicio_garantia']);
                this.fecha_termino_garantia = this.usemoment(data['fecha_termino_garantia']);
                this.fecha_inicio_contrato = this.usemoment(data['fecha_inicio_contrato']);
                this.fecha_termino_contrato = this.usemoment(data['fecha_termino_contrato']);
                this.se_muestra = false;
            },
            modificarGarantia(){
                this.ok = true;
                if(this.monto_adicional_1 != 0 && this.monto_reduccion != 0){
                    this.ok = false;
                    toastr.error('Sólo se puede uno a la vez.');
                }else{
                    this.ok = true;
                }
                if(this.permite_3 == false && this.permite_2 == true && this.monto_adicional_1 == 0 && this.monto_adicional_2 != 0){
                    this.ok = false;
                    toastr.error('Monto Adicional 1 no puede ser 0.');  
                }
                if(this.permite_3 == true && this.monto_adicional_2 == 0 && this.monto_adicional_3 != 0){
                    this.ok = false;
                    toastr.error('Monto Adicional 2 no puede ser 0.');  
                }
                if(this.permite_3 == true && this.monto_adicional_1 == 0 && this.monto_adicional_3 != 0){
                    this.ok = false;
                    toastr.error('Monto Adicional 1 no puede ser 0.');  
                }
                this.errors = [];
                let me = this;
                if(me.ok){
                    axios.post("/Fiel/actualizarGarantia", {
                    'idFiel' : this.idFiel,
                        'fecha_termino_ampliacion' : me.savemoment(this.fecha_termino_ampliacion),
                        'monto_adicional_1' : this.monto_adicional_1,
                        'monto_adicional_2' : this.monto_adicional_2,
                        'monto_adicional_3' : this.monto_adicional_3,
                        'monto_reduccion' : this.monto_reduccion
                    }).then(function(response){
                        me.limpiar();
                        me.buscar = '';
                        me.mesBuscar = '';
                        me.mes = '';
                        me.anho = '';
                        me.listarEgreso(1, me.buscar, me.mes, me.anho);
                        toastr.success('Garantía actualizada.');
                        me.se_muestra = true;
                    })
                    .catch((error)=> this.errors = error.response.data.errors)
                }
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
                this.listarEgreso(1, this.buscar, this.mes, this.anho)
            },
            imprimir(data){
                var arreglo = new Array();  
                var compara = 0;
                var titulo = '';
                var monto_sum = this.convert(data['monto_garantia']);
                compara = this.calcul(data['fecha_termino_garantia']);
                if(compara >=0){
                    titulo = 'Días faltantes: ' + compara;
                }else{
                    titulo = 'Días excedentes: ' + compara;
                }
                window.open('http://muni.pibea.org/Fiel/printf/'+'RGDUQc7pPdWVPKGekpIHMOKG7fwFcO8H+JMs92yylpAypUPtIOznlxtfIayb9811D5EQ43fCvInBjV5yPU9g=='+'/'+data['idFiel']+'/'+monto_sum+'/RGDUQc7pPdWVPKGekpIHMOKG7fwFcO8H+JMs92yylpAypUPtIOznlxtfIayb9811D5EQ43fCvInBjV5yPU9g=='+ '/' + titulo);
                //window.open('http://127.0.0.1:8000/Fiel/printf/'+'RGDUQc7pPdWVPKGekpIHMOKG7fwFcO8H+JMs92yylpAypUPtIOznlxtfIayb9811D5EQ43fCvInBjV5yPU9g=='+'/'+data['idFiel']+'/'+monto_sum+'/RGDUQc7pPdWVPKGekpIHMOKG7fwFcO8H+JMs92yylpAypUPtIOznlxtfIayb9811D5EQ43fCvInBjV5yPU9g=='+ '/' + titulo);
            },
            nuevoEncargo(){
                this.garantia = false;
                this.tipoAccion = 1;
                this.se_muestra = false;
                this.interior();
                this.limpiar();
            },
            cambiarPagina(page){
                let me = this;
                me.pagination.current_page = page;
                me.listarEgreso(page, me.buscar, me.mes, me.anho)
            },
            propp(date){
                if(this.fecha_termino_ampliacion){
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
                            this.fechaMaximo = this.fecha_termino_ampliacion;
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
                    contador = 1;
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
                this.tipo_actividad = 'COMISIÓN DE SERVICIOS AL INTERIOR DEL PAÍS';
                this.texto1 ='Para la comisión de servicios desarrollada al interior del país, la rendición de cuentas no debe exceder los 8 días hábiles después de concluida. Ante el incumplimiento de la rendición o devolución de viáticos no utilizados en el referido plazo, el perceptor de los mismos debe autorizar a la Municipalidad efectúe la retención correspondiente en la Planilla Única de Pagos.';
                this.texto2 = '(Art. 68° de la Directiva n.° 001-2007-EF/77.15 Directiva de Tesorería, aprobada el 24 de enero de 2007 vigente desde el 25 de enero de 2007 a la actualidad)';
                this.maximo = 8;
                this.fechaFinal = '';
                this.fechaMaximo = '';
                this.contador = 0;
            },
            exterior(){
                this.tipo_actividad ='COMISIÓN DE SERVICIOS AL EXTERIOR DEL PAÍS';
                this.texto1 = 'Para la comisión de servicios desarrollada al exterior del país, la rendición de cuentas no debe exceder los 15 días hábiles después de concluida. Ante el incumplimiento de la rendición o devolución de viáticos no utilizados en el referido plazo, el perceptor de los mismos debe autorizar a la Municipalidad efectúe la retención correspondiente en la Planilla Única de Pagos.'
                this.texto2 = '(Art. 68° de la Directiva n.° 001-2007-EF/77.15 Directiva de Tesorería, aprobada el 24 de enero de 2007 vigente desde el 25 de enero de 2007 a la actualidad)';
                this.maximo = 15;
                this.fechaFinal = '';
                this.fechaMaximo = '';
                this.contador = 0;
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
                axios.post("/Fiel/actualizar", {
                    'idFiel' : this.idFiel,
                    'fecha_remision' : me.savemoment(this.fecha_remision),
                    'fecha_recepcion' : me.savemoment(this.fecha_recepcion),
                    'documento_remision' : this.documento_remision,
                    'contrato' : this.contrato,
                    'monto_contrato' : this.monto_contrato,
                    'monto_garantia' : this.monto_garantia,
                    'fecha_inicio_garantia' : me.savemoment(this.fecha_inicio_garantia),
                    'fecha_termino_garantia' : me.savemoment(this.fecha_termino_garantia),
                    'fecha_inicio_contrato' : me.savemoment(this.fecha_inicio_contrato),
                    'fecha_termino_contrato' : me.savemoment(this.fecha_termino_contrato)
                }).then(function(response){
                    me.limpiar();
                    me.buscar = '';
                    me.mesBuscar = '';
                    me.mes = '';
                    me.anho = '';
                    me.listarEgreso(1, me.buscar, me.mes, me.anho);
                    toastr.success('Contrato actualizado.');
                    me.se_muestra = true
                })
                .catch((error)=> this.errors = error.response.data.errors)
            },
            registrarEncargo(){
                this.errors = [];
                let me = this;
                axios.post("/Fiel/registrar", {
                    'fecha_remision' : me.savemoment(this.fecha_remision),
                    'fecha_recepcion' : me.savemoment(this.fecha_recepcion),
                    'documento_remision' : this.documento_remision,
                    'contrato' : this.contrato,
                    'monto_contrato' : this.monto_contrato,
                    'monto_garantia' : this.monto_garantia,
                    'fecha_inicio_garantia' : me.savemoment(this.fecha_inicio_garantia),
                    'fecha_termino_garantia' : me.savemoment(this.fecha_termino_garantia),
                    'fecha_inicio_contrato' : me.savemoment(this.fecha_inicio_contrato),
                    'fecha_termino_contrato' : me.savemoment(this.fecha_termino_contrato),
                    'monto_adicional_1' : '0.0',
                    'monto_adicional_2' : '0.0',
                    'monto_adicional_3' : '0.0',
                    'monto_reduccion' : '0.0',
                    'fecha_termino_ampliacion' : '',
                }).then(function(response){
                    me.limpiar();
                    me.buscar = '';
                    me.mesBuscar = '';
                    me.listarEgreso(1, me.buscar, me.mes, me.anho);
                    toastr.success('Viatico registrado.');
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
                this.documento_remision = '';
                this.fecha_remision = '';
                this.fecha_recepcion = '';
                this.monto_contrato = 0;
                this.contrato = '';
                this.monto_garantia = 0;
                this.fecha_inicio_garantia = '';
                this.fecha_termino_garantia = '';
                this.fecha_inicio_contrato = '';
                this.fecha_termino_contrato = '';
                this.cambia = true;
                this.errors = [];
            },
            listarEgreso(page, buscar, mes, anho){
                let me = this;
                var url = '/Fiel?page=' + page + '&buscar=' + buscar + '&mes=' + mes + '&anho=' + anho ;
                axios.get(url).then(function(response){//obteniendo todo lo que envia el url, todo los registros 
                    var respuesta = response.data;
                    me.arrayViatico = respuesta.fiel.data;
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
    border-radius: 10px;
}
.btn-border{
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
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