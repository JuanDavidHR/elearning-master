<template>
    <main class="main">
        <div class="container-fluid mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-8 flex-wrap d-flex justify-content-between align-items-center">
                        <h5 class="">Recepción de Materia Prima</h5> 
                        <button @click="nuevoIngreso()" data-toggle="modal" data-target="#registro" class="btn  btn-success mt-0">
                            Agregar
                        </button>
                        <button class="btn  btn-primary" data-toggle="modal"  @click="initialCalculadora()" data-target="#calculadora">Calculadora Parámetros</button>
                    </div>
                    <div class="col-md-4 d-flex">
                        <input type="text" class="form-control" @change="verificarVacio()" @keypress.enter="mostrarRecepcion(1, textoBuscar)" v-model="textoBuscar">
                        <button class="btn btn-primary" @click="mostrarRecepcion(1, textoBuscar)">Buscar</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4" v-for="recepcion in arrayRecepcion" :key="recepcion.idRecepcion">
                            <div class="card mb-3" style="cursor:pointer;" @click="mostrarData(recepcion)" data-toggle="modal" data-target="#nuevo">
                                <div class="card-header header-modal">
                                    <h5 class="mb-0">Guía de Acopio</h5>
                                </div>
                                <div class="card-body body-modal" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                    <h6>Guía: {{recepcion.nombre}}</h6>
                                    <h6>Productos: {{recepcion.cantidad}}</h6>
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
                    <div class="modal fade" tabindex="-1" id="calculadora" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="modal-title">Calculadora de Parámetros</h4>
                                    <button type="button" class="close" @click="cerrarMateria()" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body body-modal">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p class="p-text" for="text-input">Cáscara</p>
                                            <vue-numeric v-bind:minus ="false"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="cascaraCafe"></vue-numeric>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="p-text" for="text-input">Rendimiento</p>
                                            <vue-numeric v-bind:minus ="false"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="rendimientoCafe"></vue-numeric>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="p-text" for="text-input">Humedad</p>
                                            <vue-numeric v-bind:minus ="false"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="humedadCafe"></vue-numeric>
                                        </div>
                                        <div class="col-md-12 d-flex mt-2">
                                            <button class="btn ml-auto  btn-success" @click="buscarAnalisisCalculadora()">Buscar</button>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center">
                                            <p class="p-text" for="text-input">Precio QQ : </p>
                                            <vue-numeric v-bind:minus ="false" v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="precioCafe"></vue-numeric>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal" @click="cerrarMateria()">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="nuevo" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h5 class="mb-0">Detalle Guía de Acopio</h5>
                                    <button type="button" class="close" @click="cerrarMateria()" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body body-modal">
                                    <div class="row">
                                        <div class="col-md-12 d-flex flex-wrap align-items-center">
                                            <h6 class="modal-title">Nombre: {{titleModal}} </h6>
                                            <button class="btn ml-2 btn-warning btn-sm" data-toggle="modal" data-target="#registro" @click="llenadoData()">
                                                <i style="font-size: 15px;" class="feather  icon-edit"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row d-flex align-items-center"> 
                                        <div class="col-md-4">
                                            <p class="p-text">Cantidad: {{cantModal}}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="p-text">Total: {{totalModal}}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn  btn-success" data-toggle="modal" data-target="#materia">Agregar Materia</button>
                                        </div>
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
                                                            <button type="button" @click="llenarDatosDetalle(detalle, detalle.nombre)" data-toggle="modal" :data-target="detalle.modal" class="btn btn-warning btn-sm" >
                                                                <i style="font-size: 15px;" class="feather  icon-edit"></i>
                                                            </button> &nbsp;
                                                            <button type="button" class="btn btn-danger btn-sm" @click="eliminarDatos(detalle.idDetalleRecepcion)">
                                                                <i style="font-size: 15px;" class="feather  icon-trash-2"></i>
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
                                    <button class="btn  btn-secondary" data-dismiss="modal" @click="cerrarMateria()">Cerrar</button>
                                    <button class="btn  btn-success" data-toggle="modal" :data-target="arrayDetalle.length > 0 ? '#persona': ''" @click="pasarCompra()">Comprar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="coco" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="modal-title" v-if="!updateCoco">Registro de Café Coco</h4>
                                    <h4 class="modal-title" v-else>Actualización de Café Coco</h4>
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
                                                    <p class=" p-text " for="text-input">Nº/ Sacos</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateTaraCoco()" v-model="sacosCoco"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" for="text-input">Peso Bruto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetosCoco()" v-model="kilosBrutosCoco"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" for="text-input">Tara</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetosCoco()" v-model="taraCoco"></vue-numeric>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" for="text-input">Peso Neto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-model="kilosNetosCoco"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" for="text-input">Precio x Kg/L</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="precioCoco"></vue-numeric>
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
                                                Total : {{precioCoco}} X {{librasCoco}} = {{convert(Math.round((obtenerDato(precioCoco) * obtenerDato(librasCoco)) * 100) / 100 )}}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn  btn-success" v-if="!updateCoco" @click="guardarCoco()">Guardar</button>
                                    <button type="button" class="btn  btn-success" v-else @click="actualizarCoco()">Actualizar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal fade" tabindex="-1" id="persona" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="modal-title">Seleccione Proveedor</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body body-modal">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="p-text">Socio</p>
                                            <div class="d-flex">
                                                <v-select label="nombre" :options="arrayProveedor" v-model="proveedor" :clearable="false" style="width:100% !important;">
                                                    <span  slot = "no-options" >No se encontró el Proveedor.</span>
                                                </v-select>
                                                <button class="btn btn-success" data-toggle="modal" @click="limpiarProveedor()" data-target="#proveedor">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="p-text">Dni</p>
                                            <input type="text" class="form-control" disabled="disabled" v-model="proveedor.num_documento">
                                        </div>
                                        <div class="col-md-8">
                                            <p class="p-text">Zona</p>
                                            <input type="text" class="form-control" disabled="disabled" v-model="proveedor.zona">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button class="btn  btn-success" @click="enviarProveedor()">Enviar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="proveedor" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="modal-title">Registro de Proveedores</h4>
                                    <button type="button" class="close" @click="cerrarMateria()" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body body-modal">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="p-text">Nombre Proveedor</p>
                                            <input type="text" class="form-control" v-model="nombreProveedor">
                                            <small v-if="errors.nombre" class="text-danger"  v-text="errors.nombre[0]"></small>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="p-text">DNI</p>
                                            <input type="text" @change="validateDni()" class="form-control" v-model="dniProveedor">
                                            <small v-if="errors.num_documento" class="text-danger"  v-text="errors.num_documento[0]"></small>
                                        </div>
                                        <div class="col-md-8">
                                            <p class="p-text">Zona</p>
                                            <input type="text" class="form-control" v-model="zonaProveedor">
                                            <small v-if="errors.zona" class="text-danger"  v-text="errors.zona[0]"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button class="btn  btn-success" @click="registrarProveedor()">Registrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="materia" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="modal-title">Materia Prima</h4>
                                    <button type="button" class="close" @click="cerrarMateria()" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body body-modal">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <span class="bg-red" data-toggle="modal" @click="()=>{this.limpiarCoffe(); this.denominacion='Café Orgánico';}" data-target="#cantidad">Café Orgánico</span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <span class="bg-red" data-toggle="modal" @click="()=>{this.limpiarCoffe(); this.denominacion='Café Comercial';}" data-target="#cantidad">Café Comercial</span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <span class="bg-red" data-toggle="modal" @click="limpiarCorriente()" data-target="#corriente">Café Corriente</span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <span class="bg-red" data-toggle="modal"  @click="limpiarCoco()" data-target="#coco">Café Coco</span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <span class="bg-red" data-toggle="modal"  @click="limpiarCashapa()" data-target="#cashapa">Café Cashapa</span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <span class="bg-red" data-toggle="modal" @click="limpiarCacao()" data-target="#cacao">Cacao</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal" @click="cerrarMateria()">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="modalAgua" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="modal-title">Cálculo de Húmedad</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body body-modal">
                                    <div class="row"> 
                                        <div class="col-md-12 table-responsive mt-2 mb-2">
                                            <table class="table table-bordered table-striped table-sm mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>kg B.</th>
                                                        <th>Sacos</th>
                                                        <th>Tara</th>
                                                        <th>Kg N.</th>
                                                        <th>QQ</th>
                                                        <th>Hº Max</th>
                                                        <th>Hº Min</th>
                                                        <th>Factor %</th>
                                                        <th>Descuento Agua Kg</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{convert(kilosBrutosCafe)}}</td>
                                                        <td>{{convert(sacosCafe)}}</td>
                                                        <td class="text-danger" style="font-weight: bold;">{{convert(taraCafe)}}</td>
                                                        <td class="text-danger" style="font-weight: bold;">{{convert(kilosNetosCafe)}}</td>
                                                        <td class="text-danger" style="font-weight: bold;">{{convert(quintalesCafe)}}</td>
                                                        <td v-text="humedadCafe"></td>
                                                        <td v-text="hmin"></td>
                                                        <td>0.70</td>
                                                        <td class="text-danger" style="font-weight: bold;">{{convert(descuentoAgua)}}</td>
                                                    </tr>                                
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-8 table-responsive mt-2">
                                            <table class="table table-bordered table-striped table-sm mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Total Kg</th>
                                                        <th>QQ Secos</th>
                                                        <th>Precio Seco</th>
                                                        <th>Precio Húmedo</th>
                                                        <th>Total Liquidar</th>
                                                        <th>Dscto Hª en S/</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-danger" style="font-weight: bold;">{{convert(kilosNetosCafe - descuentoAgua)}}</td>
                                                        <td>{{convert(Math.round(((kilosNetosCafe - descuentoAgua)/ 55.2)*100) /100)}}</td>
                                                        <td>{{convert(precioCafeSeco)}}</td>
                                                        <td class="text-danger" style="font-weight: bold;">{{convert(precioCafe)}}</td>
                                                        <td class="text-danger" style="font-weight: bold;">{{convert(precioCafe * quintalesCafe)}}</td>
                                                        <td class="text-danger" style="font-weight: bold;">{{convert(Math.round((obtenerDato(descuentoAgua/ 55.2)*obtenerDato(precioCafeSeco))*100) /100)}}</td>
                                                    </tr>                                
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5>Parámetros Seco</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <p class="p-text">C</p>
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="cagua"></vue-numeric>
                                                </div>
                                                <div class="col-md-4">
                                                    <p class="p-text">R</p>
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="ragua"></vue-numeric>
                                                </div>
                                                <div class="col-md-4">
                                                    <p class="p-text">H</p>
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="hmin"></vue-numeric>
                                                </div>
                                                <div class="col-md-12 d-flex mt-2">
                                                    <button class="btn  btn-success ml-auto" @click="buscarHumedad()">Buscar</button>
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
                    <div class="modal fade" tabindex="-1" id="registro" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="modal-title" v-if="!updateGuia">Registro de Guía</h4>
                                    <h4 class="modal-title" v-else>Actualización de Guía</h4>
                                    <button type="button" class="close" @click="cerrarMateria()" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body body-modal">
                                    <div class="row d-flex align-items-center"> 
                                        <div class="col-md-5">
                                            <p class="p-text">Guía de Acopio</p>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" v-model="nombreRecepcion">
                                            <small v-if="errors.nombre" class="text-danger"  v-text="errors.nombre[0]"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal" @click="cerrarMateria()">Cerrar</button>
                                    <button class="btn  btn-success" v-if="!updateGuia" @click="registrarRecepcion()">Registrar</button>
                                    <button class="btn  btn-success" v-else @click="actualizarRecepcion()">Actualizar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="corriente" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="modal-title" v-if="!updateCorriente">Registro de Café</h4>
                                    <h4 class="modal-title" v-else>Actualización de Café</h4>
                                    <button type="button" class="close" @click="cerrarCantidad()" data-dismiss="modal" aria-label="Close">
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
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateTaraCorriente()" v-model="sacosCorriente"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Peso Bruto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetosCorriente()" v-model="kilosBrutosCorriente"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Tara</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetosCorriente()" v-model="taraCorriente"></vue-numeric>
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
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetos()" v-model="precioCorriente"></vue-numeric>
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
                                    <button type="button" class="btn  btn-success" v-if="!updateCorriente" @click="guardarCorriente()">Guardar</button>
                                    <button type="button" class="btn  btn-success" v-else @click="actualizarCorriente()">Actualizar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="cantidad" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="modal-title" v-if="!updateCoffe">Registro de Café</h4>
                                    <h4 class="modal-title" v-else>Actualización de Café</h4>
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
                                                    <p class="p-text" >Nº/Sacos</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateTara()" v-model="sacosCafe"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Peso Bruto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetos()" v-model="kilosBrutosCafe"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Tara</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetos()" v-model="taraCafe"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Peso Neto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-model="kilosNetosCafe"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Quintales</p>
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
                                                    <p class="p-text" >Cáscara</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="cascaraCafe"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Rendimiento</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="rendimientoCafe"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Humedad</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator=","  v-model="humedadCafe"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6">

                                                </div>
                                                <div class="col-6">
                                                    <button class="btn  btn-success" @click="buscarAnalisis()">Buscar</button>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Precio x QQ</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="precioCafe"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <a href="#" data-toggle="modal" data-target="#modalAgua">Precio Seco</a>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="precioCafeSeco"></vue-numeric>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="text-danger">
                                                Total : {{quintalesCafe}} X {{precioCafe}} = {{convert(Math.round((obtenerDato(precioCafe) * obtenerDato(quintalesCafe)) * 100) / 100 )}}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn  btn-success" v-if="!updateCoffe" @click="guardarCafe()">Guardar</button>
                                    <button type="button" class="btn  btn-success" v-else @click="actualizarCafe()">Actualizar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="cacao" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="modal-title" v-if="!updateCacao">Registro de Cacao</h4>
                                    <h4 class="modal-title" v-else>Actualización de Cacao</h4>
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
                                                    <p class="p-text" >Nº/ Sacos</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateTaraCacao()" v-model="sacosCacao"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Peso Bruto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetosCacao()" v-model="kilosBrutosCacao"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Tara</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetosCacao()" v-model="taraCacao"></vue-numeric>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Peso Neto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-model="kilosNetosCacao"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Precio x Kg/L</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="precioCacao"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Kilos / Libras</p>
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
                                                Total : {{precioCacao}} X {{librasCacao}} = {{convert(Math.round((obtenerDato(precioCacao) * obtenerDato(librasCacao)) * 100) / 100 )}}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn  btn-success" v-if="!updateCacao" @click="guardarCacao()">Guardar</button>
                                    <button type="button" class="btn  btn-success" v-else @click="actualizarCacao()">Actualizar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="cashapa" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="modal-title" v-if="!updateCashapa">Registro de Café Cashapa</h4>
                                    <h4 class="modal-title" v-else>Actualización de Café Cashapa</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body body-modal">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>Pesaje Café Cashapa</h5>
                                        </div>
                                        <div class="col-md-6 form-group ">
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Nº/ Sacos</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateTaraCashapa()" v-model="sacosCashapa"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Peso Bruto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetosCashapa()" v-model="kilosBrutosCashapa"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Tara</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "9999" class="form-control"  currency="" separator="," v-on:change.native="calculateKilosNetosCashapa()" v-model="taraCashapa"></vue-numeric>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Peso Neto</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false" v-bind:readOnly="true" v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-model="kilosNetosCashapa"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Precio x Kg/L</p>
                                                </div>
                                                <div class="col-6">
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "999" class="form-control"  currency="" separator="," v-model="precioCashapa"></vue-numeric>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 d-flex align-items-center">
                                                    <p class="p-text" >Kilos / Libras</p>
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
                                                Total : {{precioCashapa}} X {{librasCashapa}} = {{convert(Math.round((obtenerDato(precioCashapa) * obtenerDato(librasCashapa)) * 100) / 100 )}}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn  btn-success" v-if="!updateCashapa" @click="guardarCashapa()">Guardar</button>
                                    <button type="button" class="btn  btn-success" v-else @click="actualizarCashapa()">Actualizar</button>
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
                hmin: 12,
                ragua : 0,
                cagua : 0, 
                descuentoAgua : 0,
                factor : 0.7,
                precioCafeSeco : 0,

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
                totalModal : '',
                idRecepcion : 0,
                arrayDetalle : [],
                updateCoffe : false,
                updateCoco : false,
                updateCacao : false,
                updateCashapa : false,
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
                /*Coco */
                sacosCoco : 0, 
                kilosBrutosCoco : 0,
                taraCoco : 0,
                kilosNetosCoco : 0, 
                librasCoco : 0,
                precioCoco : 0,
                /* Fin de Coco */
                /* Cacao */
                sacosCacao : 0,
                kilosBrutosCacao : 0,
                taraCacao : 0,
                kilosNetosCacao : 0,
                librasCacao : 0,
                precioCacao : 0,
                /* Fin de Cacao */
                /* Cashapa */
                sacosCashapa : 0,
                kilosBrutosCashapa : 0,
                taraCashapa : 0,
                kilosNetosCashapa : 0,
                librasCashapa : 0,
                precioCashapa : 0,
                /* Fin de Cashapa */
                nombreProveedor : '',
                dniProveedor : '',
                zonaProveedor : '',
                /* Guia Acopio */
                /* Café corriente */
                precioCorriente : 0,
                quintalesCorriente : 0,
                kilosNetosCorriente : 0,
                taraCorriente : 0,
                kilosBrutosCorriente : 0,
                sacosCorriente : 0,
                denominacion : '',
                updateCorriente : false,
                /* fin de Café Corriente */
                updateGuia : false,
                /* Fin Gía Acopio */
                /* Busqueda y Paginación */
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
                idProveedorSeleccionado : ''
                /* Fin de Búsqueda y Paginación */
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
            /* busqueda de Guía */
            cambiarPagina(page){
                let me = this;
                me.pagination.current_page = page;
                me.mostrarRecepcion(page, me.textoBuscar);
            },
            verificarVacio(){
                if (this.textoBuscar == '') {
                    this.mostrarRecepcion(1, this.textoBuscar);
                }
            },
            /* Fin de Búsqueda de guçia */
            /* Proveedor  */
            actualizarRecepcion(){
                let me = this;
                axios.put('/Recepcion/update/guia', {
                    'idRecepcion' : this.idRecepcion,
                    'nombre' : this.nombreRecepcion,
                }).then((response)=>{
                    toastr.success('Actualizado con éxito');
                    me.listaDetalle(this.idRecepcion);
                    $('#registro').modal('hide');
                }).catch((error)=>{
                    me.errors = error.response.data.errors;
                })
            },
            llenadoData(){
                this.updateGuia = true;
                this.nombreRecepcion = this.titleModal;
                this.errors = [];
            },
            validateDni(){
                 var val = Math.abs(parseInt(this.dniProveedor, 10) || 0);
                var cant = val.toString().length;
                if(cant >= 8){
                    this.dniProveedor = val > 99999999 ? 99999999 : val;
                }else{
                    this.dniProveedor = this.numCero(cant, 8) + val;
                }
            },
            registrarProveedor(){
                let me = this;
                axios.post('/Proveedor/store',{
                    'nombre': this.nombreProveedor,
                    'tipo_documento' : 'DNI',
                    'num_documento' : this.dniProveedor,
                    'zona' : this.zonaProveedor
                }).then((response)=>{
                    toastr.success('Registrado Correctamente');
                    me.traerDatosProveedor();
                }).then((response)=>{
                    $("#proveedor").modal("hide");
                }).catch((error)=>{
                    me.errors = error.response.data.errors;
                })
            },
            limpiarProveedor(){
                this.errors = [];
                this.nombreProveedor = '';
                this.dniProveedor = '';
                this.zonaProveedor = '';
            },
            /* Fin de PRoveedor */
            /* Nuevas Weas Para Copiar  */
            actualizarCacao(){
                let me = this;
                if(this.precioCacao!=0 && this.kilosNetosCacao > 0){
                    axios.put('/Recepcion/update/cacao', {
                        'idDetalle' : this.detalle, 
                        'idRecepcion' : this.idRecepcion,
                        'saco' : this.sacosCacao,
                        'kilo' : this.kilosBrutosCacao,
                        'tara' : this.taraCacao,
                        'kiloNeto' : this.obtenerDato(this.kilosNetosCacao),
                        'QQ' : this.obtenerDato(this.librasCacao),
                        'precioQQ' : this.precioCacao,
                        'total' : Math.round((this.obtenerDato(this.precioCacao) * this.obtenerDato(this.librasCacao)) * 100) / 100 ,
                    }).then((response)=>{
                        me.cerrarCacao();
                        toastr.success('Actualizado con éxito');
                        me.listaDetalle(this.idRecepcion);
                    }).catch((error)=>{
                        console.log(error);
                    })
                }else{
                    toastr.warning('Ingrese los datos correspondientes')
                }
            },
            actualizarCoco(){
                let me = this;
                if(this.precioCoco!=0 && this.kilosNetosCoco > 0){
                    axios.put('/Recepcion/update/coco', {
                        'idDetalle' : this.detalle, 
                        'idRecepcion' : this.idRecepcion,
                        'saco' : this.sacosCoco,
                        'kilo' : this.kilosBrutosCoco,
                        'tara' : this.taraCoco,
                        'kiloNeto' : this.obtenerDato(this.kilosNetosCoco),
                        'QQ' : this.obtenerDato(this.librasCoco),
                        'precioQQ' : this.precioCoco,
                        'total' : Math.round((this.obtenerDato(this.precioCoco) * this.obtenerDato(this.librasCoco)) * 100) / 100 ,
                    }).then((response)=>{
                        me.cerrarCoco();
                        toastr.success('Actualizado con éxito');
                        me.listaDetalle(this.idRecepcion);
                    }).catch((error)=>{
                        console.log(error);
                    })
                }else{
                    toastr.warning('Ingrese los datos correspondientes')
                }
            },
            actualizarCashapa(){
                let me = this;
                if(this.precioCashapa!=0 && this.kilosNetosCashapa > 0){
                    axios.put('/Recepcion/update/cashapa', {
                        'idDetalle' : this.detalle, 
                        'idRecepcion' : this.idRecepcion,
                        'saco' : this.sacosCashapa,
                        'kilo' : this.kilosBrutosCashapa,
                        'tara' : this.taraCashapa,
                        'kiloNeto' : this.obtenerDato(this.kilosNetosCashapa),
                        'QQ' : this.obtenerDato(this.librasCashapa),
                        'precioQQ' : this.precioCashapa,
                        'total' : Math.round((this.obtenerDato(this.precioCashapa) * this.obtenerDato(this.librasCashapa)) * 100) / 100 ,
                    }).then((response)=>{
                        me.cerrarCashapa();
                        toastr.success('Actualizado con éxito');
                        me.listaDetalle(this.idRecepcion);
                    }).catch((error)=>{
                        console.log(error);
                    })
                }else{
                    toastr.warning('Ingrese los datos correspondientes')
                }
            },
            cerrarCoco(){
                $("#coco").modal("hide");
            },
            cerrarCacao(){
                $("#cacao").modal("hide");
            },
            cerrarCashapa(){
                $("#cashapa").modal("hide");
            },
            guardarCashapa(){
                let me = this;
                if(this.precioCashapa!=0 && this.kilosNetosCashapa > 0){
                    axios.post('/Recepcion/store/cashapa', {
                        'idRecepcion' : this.idRecepcion,
                        'saco' : this.sacosCashapa,
                        'kilo' : this.kilosBrutosCashapa,
                        'tara' : this.taraCashapa,
                        'kiloNeto' : this.obtenerDato(this.kilosNetosCashapa),
                        'QQ' : this.obtenerDato(this.librasCashapa),
                        'precioQQ' : this.precioCashapa,
                        'total' : Math.round((this.obtenerDato(this.precioCashapa) * this.obtenerDato(this.librasCashapa)) * 100) / 100 ,
                    }).then((response)=>{
                        me.cerrarCashapa();
                        toastr.success('Registrado con éxito');
                        me.listaDetalle(this.idRecepcion);
                    }).catch((error)=>{
                        console.log(error);
                    })
                }else{
                    toastr.warning('Ingrese los datos correspondientes')
                }
            },
            guardarCacao(){
                let me = this;
                if(this.precioCacao!=0 && this.kilosNetosCacao > 0){
                    axios.post('/Recepcion/store/cacao', {
                        'idRecepcion' : this.idRecepcion,
                        'saco' : this.sacosCacao,
                        'kilo' : this.kilosBrutosCacao,
                        'tara' : this.taraCacao,
                        'kiloNeto' : this.obtenerDato(this.kilosNetosCacao),
                        'QQ' : this.obtenerDato(this.librasCacao),
                        'precioQQ' : this.precioCacao,
                        'total' : Math.round((this.obtenerDato(this.precioCacao) * this.obtenerDato(this.librasCacao)) * 100) / 100 ,
                    }).then((response)=>{
                        me.cerrarCacao();
                        toastr.success('Registrado con éxito');
                        me.listaDetalle(this.idRecepcion);
                    }).catch((error)=>{
                        console.log(error);
                    })
                }else{
                    toastr.warning('Ingrese los datos correspondientes')
                }
            },
            guardarCoco(){
                let me = this;
                if(this.precioCoco!=0 && this.kilosNetosCoco > 0){
                    axios.post('/Recepcion/store/coco', {
                        'idRecepcion' : this.idRecepcion,
                        'saco' : this.sacosCoco,
                        'kilo' : this.kilosBrutosCoco,
                        'tara' : this.taraCoco,
                        'kiloNeto' : this.obtenerDato(this.kilosNetosCoco),
                        'QQ' : this.obtenerDato(this.librasCoco),
                        'precioQQ' : this.precioCoco,
                        'total' : Math.round((this.obtenerDato(this.precioCoco) * this.obtenerDato(this.librasCoco)) * 100) / 100 ,
                    }).then((response)=>{
                        me.cerrarCoco();
                        toastr.success('Registrado con éxito');
                        me.listaDetalle(this.idRecepcion);
                    }).catch((error)=>{
                        console.log(error);
                    })
                }else{
                    toastr.warning('Ingrese los datos correspondientes')
                }
            },
            actualizarCorriente(){
                let me = this;
                if(this.precioCorriente!=0 && this.kilosNetosCorriente > 0){
                    axios.put('/Recepcion/update/corriente', {
                        'idDetalle' : this.detalle, 
                        'idRecepcion' : this.idRecepcion,
                        'saco' : this.sacosCorriente,
                        'kilo' : this.kilosNetosCorriente,
                        'tara' : this.taraCorriente,
                        'kiloNeto' : this.kilosNetosCorriente,
                        'QQ' : this.obtenerDato(this.quintalesCorriente),
                        'precioQQ' : this.precioCorriente,
                        'total' : Math.round((this.obtenerDato(this.precioCorriente) * this.obtenerDato(this.quintalesCorriente)) * 100) / 100 
                    }).then((response)=>{
                        me.cerrarCorriente();
                        toastr.success('Actualizado con éxito');
                        me.listaDetalle(this.idRecepcion);
                    }).catch((error)=>{
                        console.log(error);
                    })
                }else{
                    toastr.warning('Ingrese los datos correspondientes')
                }
            },
            guardarCorriente(){
                let me = this;
                if(this.precioCorriente!=0 && this.kilosNetosCorriente > 0){
                    axios.post('/Recepcion/store/corriente', {
                        'idRecepcion' : this.idRecepcion,
                        'saco' : this.sacosCorriente,
                        'kilo' : this.kilosBrutosCorriente,
                        'tara' : this.taraCorriente,
                        'kiloNeto' : this.kilosNetosCorriente,
                        'QQ' : this.obtenerDato(this.quintalesCorriente),
                        'precioQQ' : this.precioCorriente,
                        'total' : Math.round((this.obtenerDato(this.precioCorriente) * this.obtenerDato(this.quintalesCorriente)) * 100) / 100 
                    }).then((response)=>{
                        me.cerrarCorriente();
                        toastr.success('Registrado con éxito');
                        me.listaDetalle(this.idRecepcion);
                    }).catch((error)=>{
                        console.log(error);
                    })
                }else{
                    toastr.warning('Ingrese los datos correspondientes');
                }
            },
            guardarCafe(){
                let me = this;
                if(this.precioCafe!=0 && this.kilosNetosCafe > 0){
                    axios.post('/Recepcion/store/coffe', {
                        'idRecepcion' : this.idRecepcion,
                        'saco' : this.sacosCafe,
                        'denominacion' : this.denominacion,
                        'kilo' : this.kilosBrutosCafe,
                        'tara' : this.taraCafe,
                        'kiloNeto' : this.kilosNetosCafe,
                        'QQ' : this.obtenerDato(this.quintalesCafe),
                        'c' : this.cascaraCafe,
                        'r' : this.rendimientoCafe,
                        'h' : this.humedadCafe,
                        'precioQQ' : this.precioCafe,
                        'total' : Math.round((this.obtenerDato(this.precioCafe) * this.obtenerDato(this.quintalesCafe)) * 100) / 100 ,
                    }).then((response)=>{
                        me.cerrarCantidad();
                        toastr.success('Registrado con éxito');
                        me.listaDetalle(this.idRecepcion);
                    }).catch((error)=>{
                        console.log(error);
                    })
                }else{
                    toastr.warning('Ingrese los datos correspondientes')
                }
            },
            initialCalculadora(){
                this.precioCafe = 0;
                this.rendimientoCafe = 0;
                this.cascaraCafe = 0;
                this.humedadCafe = 0;
            },
            limpiarCorriente(){
                this.updateCorriente = false; 
                this.sacosCorriente = 0;
                this.kilosNetosCorriente = 0;
                this.kilosBrutosCorriente = 0;
                this.precioCorriente = 0;
                this.quintalesCorriente = 0;
                this.taraCorriente = 0;
                this.denominacion = '';
            },
            limpiarCoffe(){
                this.updateCoffe = false; 
                this.sacosCafe = 0;
                this.kilosBrutosCafe = 0;
                this.taraCafe = 0;
                this.kilosNetosCafe = 0;
                this.quintalesCafe = 0;
                this.cascaraCafe = 0;
                this.rendimientoCafe = 0;
                this.humedadCafe = 0;
                this.precioCafe = 0;
            },
            limpiarCoco(){
                this.updateCoco = false;
                this.sacosCoco = 0,
                this.kilosBrutosCoco = 0;
                this.kilosNetosCoco = 0;
                this.taraCoco = 0;
                this.precioCoco = 0;
                this.librasCoco = 0;
            },
            limpiarCacao(){
                this.updateCacao = false;
                this.sacosCacao = 0,
                this.kilosBrutosCacao = 0;
                this.kilosNetosCacao = 0;
                this.taraCacao = 0;
                this.precioCacao = 0;
                this.librasCacao = 0;
            },
            limpiarCashapa(){
                this.updateCashapa = false;
                this.sacosCashapa = 0,
                this.kilosBrutosCashapa = 0;
                this.kilosNetosCashapa = 0;
                this.taraCashapa = 0;
                this.precioCashapa = 0;
                this.librasCashapa = 0;
            },
            obtenerDato(number){
                var num = number.toString();
                var aux = parseFloat(num.replace(/,/gi, ''));
                return aux;
            },
            llenarDatosDetalle(data, nombre){
                switch (nombre) {
                    case 'Corriente':
                        this.updateCorriente = true;
                        this.detalle = data['idDetalleRecepcion'];
                        this.sacosCorriente = data['saco'];
                        this.kilosBrutosCorriente = data['kilo'];
                        this.precioCorriente = data['precioQQ'];
                        this.taraCorriente = data['tara'];
                        this.quintalesCorriente = data['QQ'];
                        this.kilosNetosCorriente = data['kiloNeto'];
                        break;
                    case 'Café':
                        this.updateCoffe = true;
                        this.detalle = data['idDetalleRecepcion'];
                        this.sacosCafe = data['saco'];
                        this.kilosBrutosCafe = data['kilo'];
                        this.taraCafe = data['tara'];
                        this.kilosNetosCafe = data['kiloNeto'];
                        this.quintalesCafe = data['QQ'];
                        this.cascaraCafe = data['c'];
                        this.rendimientoCafe = data['r'];
                        this.humedadCafe = data['h'];
                        this.precioCafe = data['precioQQ'];
                        /* this.calculateAgua(); */
                        break;
                    case 'Coco' :
                        this.updateCoco = true;
                        this.detalle = data['idDetalleRecepcion'];
                        this.sacosCoco = data['saco'];
                        this.kilosBrutosCoco = data['kilo'];
                        this.kilosNetosCoco = data['kiloNeto'];
                        this.taraCoco = data['tara'];
                        this.precioCoco = data['precioQQ'];
                        this.librasCoco = data['QQ'];
                        break;
                    case 'Cacao' :
                        this.updateCacao = true;
                        this.detalle = data['idDetalleRecepcion'];
                        this.sacosCacao = data['saco'];
                        this.kilosBrutosCacao = data['kilo'];
                        this.kilosNetosCacao = data['kiloNeto'];
                        this.taraCacao = data['tara'];
                        this.precioCacao = data['precioQQ'];
                        this.librasCacao = data['QQ'];
                        break;
                    case 'Cashapa' :
                        this.updateCashapa = true;
                        this.detalle = data['idDetalleRecepcion'];
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
            eliminarDatos(idDetalleRecepcion){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn ml-1 btn-danger'
                },
                buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: '¿Desea elimiar el producto seleccionado?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        axios.post("/Recepcion/delete/coffe", {
                            'idDetalle' : idDetalleRecepcion,
                            'idRecepcion' : this.idRecepcion
                        }).then(function(response){
                            me.listaDetalle(me.idRecepcion);
                        }).catch(function(error){
                            console.log(error);
                        })
                        swalWithBootstrapButtons.fire(
                        'Eliminado',
                        'El producto se eliminó.',
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
            traerDatosProveedor(){
                let me = this;
                var url = '/Recepcion/getProveedor'
                axios.get(url).then((response)=>{
                    var respuesta = response.data;
                    this.arrayProveedor = respuesta.proveedor;
                })
                .catch((error)=>{
                    console.log(error);
                })
            },
            pasarCompra(){
                if(this.arrayDetalle.length > 0){  
                    this.traerDatosProveedor();
                }else{
                    toastr.error('Ingrese Materia Prima');
                }
            },
            actualizarCafe(){
                let me = this;
                if(this.precioCafe!=0 && this.kilosNetosCafe > 0){
                    axios.put('/Recepcion/update/coffe', {
                        'idDetalle' : this.detalle, 
                        'idRecepcion' : this.idRecepcion,
                        'saco' : this.sacosCafe,
                        'kilo' : this.kilosBrutosCafe,
                        'tara' : this.taraCafe,
                        'kiloNeto' : this.kilosNetosCafe,
                        'QQ' : this.obtenerDato(this.quintalesCafe),
                        'c' : this.cascaraCafe,
                        'r' : this.rendimientoCafe,
                        'h' : this.humedadCafe,
                        'precioQQ' : this.obtenerDato(this.precioCafe),
                        'total' : Math.round((this.obtenerDato(this.precioCafe) * this.obtenerDato(this.quintalesCafe)) * 100) / 100 ,
                    }).then((response)=>{
                        me.cerrarCantidad();
                        toastr.success('Actualizado con éxito');
                        me.listaDetalle(this.idRecepcion);
                    }).catch((error)=>{
                        console.log(error);
                    })
                }else{
                    toastr.warning('Ingrese los datos correspondientes')
                }
            },
            listaDetalle(idRecepcion){
                let me = this;
                var url = '/Recepcion/store/coffe?idRecepcion=' + idRecepcion;
                var aux = 0;
                axios.get(url).then((response)=>{
                    var respuesta = response.data;
                    this.arrayDetalle = respuesta.detalle;
                    this.titleModal = respuesta.recepcion[0].nombre;
                    this.cantModal = respuesta.recepcion[0].cantidad;
                    aux = respuesta.recepcion[0].total
                    this.totalModal = this.moneyConvert(aux);
                }).catch((error)=>{
                    console.log(error);
                })
                this.mostrarRecepcion(this.pagination.current_page, '');
            },
            moneyConvert(number){
                return this.convert(parseFloat(parseFloat(number).toFixed(1)).toFixed(2));
            },
            nuevoIngreso(){
                this.updateGuia = false;
                this.nombreRecepcion = '';
                this.errors = [];
            }, 
            mostrarData(data){
                this.titleModal = data['nombre'];
                this.cantModal = data['cantidad'];
                this.totalModal = this.moneyConvert(data['total']);
                this.idRecepcion = data['idRecepcion'];
                this.idProveedorSeleccionado = data['id'];
                if(this.idProveedorSeleccionado){
                    this.proveedor = {
                        'id' : data['id'],
                        'nombre' : data['nombrePersona'],
                        'num_documento' : data['num_documento'],
                        'zona' : data['zona']
                    }
                }else{
                    this.proveedor = '';
                }
                this.arrayDetalle = [];
                this.updateGuia = false;
                this.listaDetalle(this.idRecepcion);
            },
            mostrarRecepcion(page, buscar){
                var buscar = this.textoBuscar;
                let me = this;
                var url = '/Recepcion?page='+page+'&buscar='+buscar
                axios.get(url).then((response)=>{
                    var respuesta = response.data;
                    me.pagination= respuesta.pagination;
                    me.arrayRecepcion = respuesta.recepcion.data;
                }).catch((error)=>{
                    console.log(error);
                })
            },
            registrarRecepcion(){
                let me = this;
                axios.post('/Recepcion/store',{
                    'nombre': me.nombreRecepcion 
                }).then((response)=>{
                    $("#registro").modal("hide");
                    toastr.success('Registrado Correctamente');
                    me.mostrarRecepcion(1, '');
                }).catch((error)=>{
                    me.errors = error.response.data.errors;
                })
            },
            convert(number){
                let val = (number/1).toFixed(2).replace(',', '.');
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            buscarAnalisisCalculadora(){
                var aux = false;
                var cod = '';
                var cascara = '';
                var rendimiento = '';
                var humedad = '';
                if(this.cascaraCafe != 0 && this.rendimientoCafe != 0 && this.humedad != 0){
                    aux = true;
                }
                if(aux){
                    cascara = this.cascaraCafe.toString().length;
                    cod = cod + this.numCero(cascara, 3) + this.cascaraCafe;
                    rendimiento = this.rendimientoCafe.toString().length;
                    cod = cod + this.numCero(rendimiento, 3) + this.rendimientoCafe;
                    humedad = this.humedadCafe.toString().length;
                    cod = cod + this.numCero(humedad, 3) + this.humedadCafe;
                    let me = this;
                    var url = '/Precio/buscar?codigo=' + cod ;
                    axios.get(url).then((response)=>{
                        if(response.data.length){
                            me.precioCafe = response.data[0].precioCompra;
                        }else{
                            me.precioCafe = '0';
                            toastr.warning('No se registró un precio con ciertos parámetros');
                        }
                    }).catch((error)=>{
                        console.log(error);
                    })
                }else{
                    toastr.info('Ingrese todos los parámetros por favor')
                }
            },
            buscarHumedad(){
                var cod = '';
                var cascara = '';
                var rendimiento = '';
                var humedad = '';
                cascara = this.cagua.toString().length;
                cod = cod + this.numCero(cascara, 3) + this.cagua;
                rendimiento = this.ragua.toString().length;
                cod = cod + this.numCero(rendimiento, 3) + this.ragua;
                humedad = this.hmin.toString().length;
                cod = cod + this.numCero(humedad, 3) + this.hmin;
                let me = this;
                var url = '/Precio/buscar?codigo=' + cod ;
                axios.get(url).then((response)=>{
                    if(response.data.length){
                        me.precioCafeSeco = response.data[0].precioCompra;
                    }else{
                        me.precioCafeSeco = '0';
                        toastr.warning('Parámetros no encontrados en Precio Seco');
                    }
                }).catch((error)=>{
                    console.log(error);
                })
            },
            calculateAgua(){
                if(this.humedadCafe > 12 && this.kilosNetosCafe != 0 && this.precioCafe != 0){
                    var resta = 0;
                    this.hmin = 12;
                    resta = this.humedadCafe - this.hmin;
                    resta = resta / 100;
                    this.descuentoAgua = this.kilosNetosCafe * resta * this.factor;
                    this.ragua = this.rendimientoCafe + 2;
                    this.cagua = this.cascaraCafe;
                    this.buscarHumedad();
                }else{
                    
                }
            },
            buscarAnalisis(){
                var aux = false;
                var agua  = '';
                var cod = '';
                var cascara = '';
                var rendimiento = '';
                var humedad = '';
                if(this.cascaraCafe != 0 && this.rendimientoCafe != 0 && this.humedadCafe != 0){
                    aux = true;
                }
                if(aux){
                    cascara = this.cascaraCafe.toString().length;
                    cod = cod + this.numCero(cascara, 3) + this.cascaraCafe;
                    rendimiento = this.rendimientoCafe.toString().length;
                    cod = cod + this.numCero(rendimiento, 3) + this.rendimientoCafe;
                    humedad = this.humedadCafe.toString().length;
                    cod = cod + this.numCero(humedad, 3) + this.humedadCafe;
                    let me = this;
                    var url = '/Precio/buscar?codigo=' + cod ;
                    axios.get(url).then((response)=>{
                        if(response.data.length){
                            me.calculateAgua();
                            me.precioCafe = response.data[0].precioCompra;
                        }else{
                            me.precioCafe = '0';
                            toastr.warning('No se registró un precio con ciertos parámetros');
                        }
                    }).catch((error)=>{
                        console.log(error);
                    })
                }else{
                    toastr.info('Ingrese todos los parámetros por favor')
                }
            },
            calculateKilosNetosCorriente(){
                this.kilosNetosCorriente = this.kilosBrutosCorriente - this.taraCorriente;
                this.quintalesCorriente = this.convert(Math.round((this.kilosNetosCorriente / 55.2)*100) /100);
            },
            calculateTaraCorriente(){
                this.taraCorriente = this.sacosCorriente * 0.25;
                this.calculateKilosNetosCorriente();
            },
            calculateKilosNetosCoco(){
                this.kilosNetosCoco = this.kilosBrutosCoco - this.taraCoco;
                this.librasCoco = this.convert(Math.round((this.kilosNetosCoco * 2.174)*100) /100);
            },
            calculateKilosNetos(){
                this.kilosNetosCafe = this.kilosBrutosCafe - this.taraCafe;
                this.quintalesCafe = this.convert(Math.round((this.kilosNetosCafe / 55.2)*100) /100);
            },
            calculateKilosNetosCacao(){
                this.kilosNetosCacao = this.kilosBrutosCacao - this.taraCacao;
                this.librasCacao = this.convert(Math.round((this.kilosNetosCacao * 2.174)*100) /100);
            },
            calculateKilosNetosCashapa(){
                this.kilosNetosCashapa = this.kilosBrutosCashapa - this.taraCashapa;
                this.librasCashapa = this.convert(Math.round((this.kilosNetosCashapa * 2.174)*100) /100);
            },
            calculateTaraCacao(){
                this.taraCacao = this.sacosCacao * 0.25;
                this.calculateKilosNetosCacao();
            },
            calculateTaraCashapa(){
                this.taraCashapa = this.sacosCashapa * 0.25;
                this.calculateKilosNetosCashapa();
            },
            calculateTaraCoco(){
                this.taraCoco = this.sacosCoco * 0.25;
                this.calculateKilosNetosCoco();
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
            cerrarCorriente(){
                $("#corriente").modal("hide");
            },
            cerrarCantidad(){
                $("#cantidad").modal("hide");
            },
            cerrarMateria(){
                $("#otros").modal("hide");
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
        },
    }
</script>
<style>
    ul#vs1__listbox {
        max-height: 100px;
    }
    .bg-red{
        display: flex;
        background: #73a432;
        justify-content: center;
        padding: 27px 0px;
        color: white;
        font-size: 20px;
        font-weight: bold;
        border-radius: 10px;
        cursor: pointer;
    }
</style>

