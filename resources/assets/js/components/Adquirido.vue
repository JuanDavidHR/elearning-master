<template>
    <main class="main">
        <div class="mb-4 container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-5 d-flex justify-content-betweend align-items-center">
                        <h5>Materia Prima Adquirida - Sin Distribuir</h5> 
                    </div>
                    <div class="col-md-4 d-flex">
                        <input type="text" class="form-control" @change="verificarVacio()" @keypress.enter="mostrarRecepcion(1, textoBuscar)" v-model="textoBuscar">
                        <button class="btn mt-0 btn-primary" @click="mostrarRecepcion(1, textoBuscar)">Buscar</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4" v-for="recepcion in arrayRecepcion" :key="recepcion.idRecepcion">
                            <div class="card mb-3" style="cursor:pointer;" @click="mostrarData(recepcion)" data-toggle="modal" data-target="#nuevo">
                                <div class="card-header header-modal">
                                    <h5 class="mb-0">{{recepcion.guia}}</h5>
                                </div>
                                <div class="card-body body-modal" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                    <h6>Socio: {{recepcion.nombre}}</h6>
                                    <h6>Zona: {{recepcion.zona}}</h6>
                                    <h6>Total : {{moneyConvert(recepcion.total)}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <nav>   
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="modal fade" tabindex="-1" id="nuevo" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h5 class="mb-0">Detalle de Guía de Acopio</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body body-modal">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-6">
                                            <h6>Socio: {{titleModal}}</h6>    
                                        </div> 
                                        <div class="col-md-6">
                                            <h6>DNI: {{num_documento}}</h6>    
                                        </div> 
                                        <!-- <div class="col-md-4">
                                            <p class="p-text">Cantidad: {{cantModal}}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="p-text">Total: {{totalModal}}</p>
                                        </div> -->
                                    </div>
                                    <div class="table-responsive mt-2">
                                        <table class="table table-bordered table-striped table-sm mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Opciones</th>
                                                    <th>Nombre</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="detalle in arrayDetalle" :key="detalle.idDetalleRecepcion">
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <!-- No olvidar que debe de existir un if  -->
                                                            <button type="button" @click="llenarDatosDetalle(detalle, detalle.nombre)" data-toggle="modal" :data-target="detalle.modal" class="btn btn-info btn-sm" >
                                                                <i style="font-size: 15px;" class="feather icon-eye"></i>
                                                            </button> &nbsp;
                                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" :data-target="getModal(detalle)" @click="setIdDetalle(detalle)">
                                                                <i style="font-size: 15px;" class="feather  icon-chevrons-right"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td v-text="detalle.tipo"></td>
                                                    <td v-text="convert(detalle.total)"></td>
                                                </tr>                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" tabindex="-1" id="guardarCacao" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="mb-0">Cacao</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-12 mb-2">
                                            <p class="p-text">¿Hacia dónde va dirigida la Materia Prima?</p>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="card d-flex justify-content-center align-items-center" style="background: #eee; cursor: pointer;" @click="enviarMateria('Lote Cacao', '#guardarCacao');">
                                                <div class="card-body">
                                                    Ruma
                                                </div>     
                                            </div>  
                                        </div> 
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="guardarComercial" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="mb-0">Café Comercial</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-12 mb-2">
                                            <p class="p-text">¿Hacia dónde va dirigida la Materia Prima?</p>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="card d-flex justify-content-center align-items-center" style="background: #eee; cursor: pointer;" @click="enviarMateria('Ruma Café Comercial', '#guardarComercial');">
                                                <div class="card-body">
                                                    Rumas
                                                </div>     
                                            </div>  
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="card d-flex justify-content-center align-items-center" style="background: #eee; cursor: pointer;" @click="enviarMateria('Lote Café Comercial', '#guardarComercial');">
                                                <div class="card-body">
                                                    Lotes
                                                </div>   
                                            </div>    
                                        </div> 
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="guardarCorriente" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="mb-0">Café Corriente</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-12 mb-2">
                                            <p class="p-text">¿Hacia dónde va dirigida la Materia Prima?</p>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="card d-flex justify-content-center align-items-center" style="background: #eee; cursor: pointer;" @click="enviarMateria('Ruma Café Corriente', '#guardarCorriente');">
                                                <div class="card-body">
                                                    Rumas
                                                </div>     
                                            </div>  
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="card d-flex justify-content-center align-items-center" style="background: #eee; cursor: pointer;" @click="enviarMateria('Lote Café Corriente', '#guardarCorriente');">
                                                <div class="card-body">
                                                    Lotes
                                                </div>   
                                            </div>    
                                        </div> 
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="guardarOrganico" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="mb-0">Café Orgánico</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-12 mb-2">
                                            <p class="p-text">¿Hacia dónde va dirigida la Materia Prima?</p>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="card d-flex justify-content-center align-items-center" style="background: #eee; cursor: pointer;" @click="enviarMateria('Lote Café Orgánico', '#guardarOrganico');">
                                                <div class="card-body">
                                                    Lotes
                                                </div>   
                                            </div>    
                                        </div> 
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="guardarCoco" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="mb-0">Café Coco</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-12 mb-2">
                                            <p class="p-text">¿Hacia dónde va dirigida la Materia Prima?</p>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="card d-flex justify-content-center align-items-center" style="background: #eee; cursor: pointer;" @click="enviarMateria('Lote Café Coco', '#guardarCoco');">
                                                <div class="card-body">
                                                    Lotes
                                                </div>   
                                            </div>    
                                        </div> 
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="guardarCashapa" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="mb-0">Café Coco</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-12 mb-2">
                                            <p class="p-text">¿Hacia dónde va dirigida la Materia Prima?</p>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="card d-flex justify-content-center align-items-center" style="background: #eee; cursor: pointer;" @click="enviarMateria('Lote Café Cashapa', '#guardarCashapa');">
                                                <div class="card-body">
                                                    Lotes
                                                </div>   
                                            </div>    
                                        </div> 
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" tabindex="-1" id="persona" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="modal-title">Pagar</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body body-modal">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="p-text">Socio</p>
                                            <input type="text" class="form-control" disabled="disabled" :value="titleModal">
                                        </div>
                                        <div class="col-md-4">
                                            <p class="p-text">DNI</p>
                                            <input type="text" class="form-control" disabled="disabled" :value="num_documento">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <p class="p-text">Monto Total</p>
                                            <input type="text" class="form-control" disabled="disabled" :value="totalModal">
                                        </div>
                                        <div class="col-md-6">
                                            <p class="p-text">Monto Pagar</p>
                                            <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max="totalPosible" class="form-control"  currency="" separator="," v-model="montoPagado"></vue-numeric>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <p class="p-text">Observación</p>
                                            <textarea class="form-control" cols="30" rows="5" v-model="observacion"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal" >Cerrar</button>
                                    <button class="btn  btn-success" @click="comprarMateria()">Registrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="coco" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="modal-title">Detalle de Coco</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body body-modal">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>Pesaje Coco</h5>
                                        </div>
                                        <div class="col-md-6 form-group ">
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Nº/ Sacos</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:readOnly="true" v-bind:precision="0" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateTaraCoco()" v-model="sacosCoco"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Peso Bruto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetosCoco()" v-model="kilosBrutosCoco"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Tara</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetosCoco()" v-model="taraCoco"></vue-numeric>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Peso Neto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-model="kilosNetosCoco"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Precio x Kg/L</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="precioCoco"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Kilos / Libras</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="librasCoco"></vue-numeric>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="text-danger">
                                                Total : {{precioCoco}} X {{librasCoco}} = {{convert(Math.round((precioCoco * librasCoco) * 100) / 100 )}}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="cacao" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="modal-title" >Detalle de Cacao</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body body-modal">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>Pesaje Cacao</h5>
                                        </div>
                                        <div class="col-md-6 form-group ">
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Nº/ Sacos</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateTaraCacao()" v-model="sacosCacao"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Peso Bruto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetosCacao()" v-model="kilosBrutosCacao"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Tara</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetosCacao()" v-model="taraCacao"></vue-numeric>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Peso Neto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-model="kilosNetosCacao"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Precio x Kg/L</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:readOnly="true"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="precioCacao"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Kilos / Libras</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="librasCacao"></vue-numeric>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="text-danger">
                                                Total : {{precioCacao}} X {{librasCacao}} = {{convert(Math.round((precioCacao * librasCacao) * 100) / 100 )}}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="cashapa" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="modal-title">Detalle de Cashapa</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body body-modal">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>Pesaje Cashapa</h5>
                                        </div>
                                        <div class="col-md-6 form-group ">
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Nº/ Sacos</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateTaraCashapa()" v-model="sacosCashapa"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Peso Bruto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetosCashapa()" v-model="kilosBrutosCashapa"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Tara</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetosCashapa()" v-model="taraCashapa"></vue-numeric>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Peso Neto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-model="kilosNetosCashapa"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Precio x Kg/L</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:readOnly="true"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="precioCashapa"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Kilos / Libras</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="librasCashapa"></vue-numeric>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="text-danger">
                                                Total : {{precioCashapa}} X {{librasCashapa}} = {{convert(Math.round((precioCashapa * librasCashapa) * 100) / 100 )}}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="corriente" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="modal-title">Detalle Café</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body body-modal">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>Pesaje Café</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group ">
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Nº/Sacos</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateTaraCorriente()" v-model="sacosCorriente"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Peso Bruto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetosCorriente()" v-model="kilosBrutosCorriente"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Tara</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetosCorriente()" v-model="taraCorriente"></vue-numeric>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Peso Neto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-model="kilosNetosCorriente"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Quintales</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="quintalesCorriente"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Precio</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetos()" v-model="precioCorriente"></vue-numeric>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="text-danger">
                                                Total : {{quintalesCorriente}} X {{convert(precioCorriente)}} = {{convert(Math.round((obtenerDato(precioCorriente) * obtenerDato(quintalesCorriente)) * 100) / 100 )}}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="cantidad" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="modal-title">Detalle de Café</h4>
                                    <button type="button" class="close" @click="cerrarCantidad()" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body body-modal">
                                    <div class="row">
                                        <div class="col-md-6 form-group ">
                                            <h5>Pesaje Café</h5>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Nº/Sacos</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateTara()" v-model="sacosCafe"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Peso Bruto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetos()" v-model="kilosBrutosCafe"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Tara</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetos()" v-model="taraCafe"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Peso Neto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-model="kilosNetosCafe"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Quintales</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="quintalesCafe"></vue-numeric>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group ">
                                            <h5>Análisis Físico</h5>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Cáscara</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="cascaraCafe"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Rendimiento</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="rendimientoCafe"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Humedad</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator=","  v-model="humedadCafe"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text">Precio x QQ</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="precioCafe"></vue-numeric>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="text-danger">
                                                Total : {{quintalesCafe}} X {{precioCafe}} = {{convert(Math.round((precioCafe * quintalesCafe) * 100) / 100 )}}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    import VueNumeric from 'vue-numeric';
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import 'vue2-datepicker/locale/es';
    import moment from 'moment';
    export default {
        components:{
            vSelect,
            VueNumeric,
            DatePicker
        },
        data (){
            return {
                /* Variables Café */

                /* Inicio de Paginación */
                textoBuscar : '',
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                /* fin de Paginación */
                sacosCafe : 0,
                kilosBrutosCafe : 0,
                taraCafe : 0,
                kilosNetosCafe : 0,
                quintalesCafe : 0, 
                cascaraCafe : 0,
                rendimientoCafe : 0,
                humedadCafe : 0,
                precioCafe : 0,
                mostrarMaterias : false,
                errors : [],
                nombreRecepcion : '',
                arrayRecepcion : [],
                titleModal : '',
                cantModal : '',
                totalModal : 0,
                totalPosible : 0,
                idRecepcion : 0,
                arrayDetalle : [],
                detalle: 0,
                proveedor : '',
                arrayProveedor : [],
                sacosTotales : 0,
                /* Fin de Variables Café */
                listaKit : [],
                totalNeto : 0,
                totalParcial : 0,
                totalOtros : 0,
                totalDescuento : 0,
                arrayMateria : [],
                /* Otras Materias */
                sacosCoco : 0,
                kilosBrutosCoco : 0,
                kilosNetosCoco : 0,
                taraCoco : 0,
                precioCoco : 0,
                librasCoco : 0,
                sacosCacao : 0,
                kilosBrutosCacao : 0,
                kilosNetosCacao : 0,
                taraCacao : 0,
                precioCacao : 0,
                librasCacao : 0,
                sacosCashapa : 0,
                kilosBrutosCashapa : 0,
                kilosNetosCashapa : 0,
                taraCashapa : 0,
                precioCashapa : 0,
                librasCashapa : 0,
                /* Fin de Materias */
                num_documento : '',
                montoPagado : 0,
                observacion : '',
                guia : '',
                idProveedor : 0,
                /* Corriente */
                precioCorriente : 0,
                quintalesCorriente : 0,
                kilosNetosCorriente : 0,
                taraCorriente : 0,
                kilosBrutosCorriente : 0,
                sacosCorriente : 0,
                denominacion : '',
                /* Envío a lotes */
                idDetalleRecepcion : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }  
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  
                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             
            }
        },
        methods : {
            /* Nuevas Weas Para Copiar*/
            setIdDetalle(data){
                this.idDetalleRecepcion = data['idDetalleRecepcion'];
            },
            enviarMateria(texto, modal){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn ml-2 btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: '¿Enviar Materia Prima?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        axios.put("/Distribucion/materiaPrima", {
                            'idRecepcion' : this.idRecepcion,
                            'idDetalleRecepcion' : this.idDetalleRecepcion,
                            'nombre': texto
                        }).then(function(response){
                            $(modal).modal('hide');
                            if(response.data.respuesta){
                                $('#nuevo').modal('hide');
                                me.mostrarRecepcion(1, '');
                            }else{
                                me.listaDetalle(me.idRecepcion);
                            }
                        }).catch(function(error){
                            console.log(error);
                        })
                        swalWithBootstrapButtons.fire(
                        'Se Almacenó el Café',
                        'El Café fue puesto en el Almacén.',
                        'success')
                    }else if ( result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
            moneyConvert(number){
                return this.convert(parseFloat(parseFloat(number).toFixed(1)).toFixed(2));
            },
            verificarVacio(){
                if (this.textoBuscar == '') {
                    this.mostrarRecepcion(1, this.textoBuscar);
                }
            },
            cambiarPagina(page){
                let me = this;
                me.pagination.current_page = page;
                me.mostrarRecepcion(page, me.textoBuscar);
            },
            obtenerDato(number){
                var num = number.toString();
                var aux = parseFloat(num.replace(/,/gi, ''));
                return aux;
            },
            getModal(data){
                switch(data['tipo']){
                    case 'Cacao':
                        return '#guardarCacao';
                        break;
                    case 'Café Orgánico':
                        return '#guardarOrganico';
                        break;
                    case 'Café Coco':
                        return '#guardarCoco';
                        break;
                    case 'Café Cashapa':
                        return '#guardarCashapa'
                        break;
                    case 'Café Comercial':
                        return '#guardarComercial'
                        break;
                    case 'Café Corriente':
                        return '#guardarCorriente'
                        break;
                    default:
                        break;
                }
            },
            llenarDatosDetalle(data, nombre){
                switch (nombre) {
                    case 'Corriente':
                        this.precioCorriente = data['precioQQ'];
                        this.quintalesCorriente = data['QQ'];
                        this.kilosNetosCorriente = data['kiloNeto'];
                        this.taraCorriente = data['tara'];
                        this.kilosBrutosCorriente = data['kilo'];
                        this.sacosCorriente = data['saco'];
                        break;
                    case 'Café':
                        this.sacosCafe = data['saco'];
                        this.kilosBrutosCafe = data['kilo'];
                        this.taraCafe = data['tara'];
                        this.kilosNetosCafe = data['kiloNeto'];
                        this.quintalesCafe = data['QQ'];
                        this.cascaraCafe = data['c'];
                        this.rendimientoCafe = data['r'];
                        this.humedadCafe = data['h'];
                        this.precioCafe = data['precioQQ'];
                        break;
                    case 'Coco' :
                        this.sacosCoco = data['saco'];
                        this.kilosBrutosCoco = data['kilo'];
                        this.kilosNetosCoco = data['kiloNeto'];
                        this.taraCoco = data['tara'];
                        this.precioCoco = data['precioQQ'];
                        this.librasCoco = data['QQ'];
                        break;
                    case 'Cacao' :
                        this.sacosCacao = data['saco'];
                        this.kilosBrutosCacao = data['kilo'];
                        this.kilosNetosCacao = data['kiloNeto'];
                        this.taraCacao = data['tara'];
                        this.precioCacao = data['precioQQ'];
                        this.librasCacao = data['QQ'];
                        break;
                    case 'Cashapa' :
                        this.sacosCashapa = data['saco'];
                        this.kilosBrutosCashapa = data['kilo'];
                        this.kilosNetosCashapa = data['kiloNeto'];
                        this.taraCashapa = data['tara'];
                        this.precioCashapa = data['precioQQ'];
                        this.librasCashapa = data['QQ'];
                        break;
                    default:
                        break;
                }
            },
            mandarRevision(idRecepcion){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: '¿Desea revisar nuevamente el  detalle de la Guía?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        axios.put("/Recepcion/cambioEstado/revision", {
                            'idRecepcion' : this.idRecepcion
                        }).then(function(response){
                            me.mostrarRecepcion(1, '');
                            $('#nuevo').modal('hide');
                            me.arrayDetalle = [];
                        }).catch(function(error){
                            console.log(error);
                        })
                        swalWithBootstrapButtons.fire(
                        'Puesto en Revisión',
                        'La guía fue puesta en Revisión.',
                        'success')
                    }else if ( result.dismiss === Swal.DismissReason.cancel) {}
                })
            },
            enviarProveedor(){
                //acá debemos de cambiar el estado de la Recepción
                if(this.proveedor != '' && this.sacosTotales >= 0){
                    let me = this;
                    axios.put('/Recepcion/cambioEstado',{
                        'idRecepcion' : this.idRecepcion,
                        'id' : this.proveedor.id,
                        'numSacos' : this.sacosTotales
                    }).then((response)=>{
                        toastr.success('Enviado con éxito al módulo de compras.');
                        me.idRecepcion = 0;
                        me.proveedor = '';
                        me.sacosTotales = 0;
                        $("#persona").modal("hide");
                        $("#nuevo").modal("hide");
                        me.mostrarRecepcion(1, '');
                        //cerrar los modales, y mostrar todo, dejar el id en 0
                        //modificar el mostrar, todos los que estén en revisión
                        //listar todo xd 
                    }).catch((error)=>{
                        console.log(error);
                    })
                }
            },
            pasarCompra(){
                if(this.arrayDetalle.length){
                    this.montoPagado = 0;
                    this.observacion = '';
                    $("#persona").modal("show");
                }else{
                    toastr.info('Por Favor Espere a que carguen los datos.');
                }
            },
            listaDetalle(idRecepcion){
                let me = this;
                var url = '/Recepcion/store/coffe?idRecepcion=' + idRecepcion;
                axios.get(url).then((response)=>{
                    var aux = '';
                    var respuesta = response.data;
                    this.arrayDetalle = respuesta.detalle;
                    this.cantModal = respuesta.recepcion[0].cantidad;
                    aux = respuesta.recepcion[0].total;
                    this.totalModal = this.moneyConvert(aux);
                    this.totalPosible = parseFloat((this.totalModal).replace(/,/gi, ''));
                    me.mostrarRecepcion(1, '');
                }).catch((error)=>{
                    console.log(error);
                })
            },
            mostrarData(data){
                this.idProveedor = data['id'];
                this.guia = data['guia'];
                this.titleModal = data['nombre'];
                this.cantModal = data['cantidad'];
                this.totalModal = this.moneyConvert(data['total']);
                this.num_documento = data['num_documento'];
                this.idRecepcion = data['idRecepcion'];
                this.arrayDetalle = [];
                this.listaDetalle(this.idRecepcion);
            },
            mostrarRecepcion(page, buscar){
                let me = this;
                var url = '/Recepcion/adquirido?page='+page+'&buscar='+buscar
                axios.get(url).then((response)=>{
                    var respuesta = response.data;
                    me.pagination= respuesta.pagination;
                    me.arrayRecepcion = respuesta.recepcion.data;
                }).catch((error)=>{
                    console.log(error);
                })
            },
            convert(number){
                let val = (number/1).toFixed(2).replace(',', '.');
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            /* Fin de Nuevas Huevas Para copiar */
            /* Funciones Café */
            calculateKilosNetos(){
                this.kilosNetosCafe = this.kilosBrutosCafe - this.taraCafe;
                this.quintalesCafe = this.convert(Math.round((this.kilosNetosCafe / 55.2)*100) /100);
            },
            calculateTara(){
                this.taraCafe = this.sacosCafe * 0.25;
                this.calculateKilosNetos();
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
            calculatePrecio(){
                
            },
            /* Fin de funciones Café */
            /*Nuevas Funciones*/
            disableYear(date){
                const year = new Date(date).getFullYear(); (year>2040 || year <2020)
                return(year>2040 || year <2020);
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
        },
        mounted() {
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
            this.mostrarRecepcion(1, '');
        }
    }
</script>
<style>  

</style>

