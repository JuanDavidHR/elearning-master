<template>
    <main class="main">
        <div class="mb-4 container-fluid">
            <div class="card">
                <div class="card-header">   
                    <div class="col-md-3 d-flex justify-content-betweend align-items-center">
                        <h5>Almacén Café Pergamino</h5> 
                    </div>
                    <!-- <div class="col-md-4 d-flex">
                        <input type="text" class="form-control" @change="verificarVacio()" @keypress.enter="mostrarRecepcion(1, textoBuscar)" v-model="textoBuscar">
                        <button class="btn mt-0 btn-primary" @click="mostrarRecepcion(1, textoBuscar)">Buscar</button>
                    </div> -->
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mt-2 mb-2">
                            <div class="card d-flex justify-content-center align-items-center" style="background: #eee; cursor: pointer;"  data-toggle="modal" data-target="#corriente">
                                <div class="card-body">
                                    Café Corriente
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-2 mb-2">
                            <div class="card d-flex justify-content-center align-items-center" style="background: #eee; cursor: pointer;" data-toggle="modal" data-target="#loteOrganico" @click="getMateria(1, 'Lote Café Orgánico')">
                                <div class="card-body">
                                    Café Orgánico
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-2 mb-2">
                            <div class="card d-flex justify-content-center align-items-center" style="background: #eee; cursor: pointer;" data-toggle="modal" data-target="#nuevo">
                                <div class="card-body">
                                    Café Comercial
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="nuevo" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
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
                                        <div class="col-md-6 mt-2">
                                            <div class="card d-flex justify-content-center align-items-center" style="background: #eee; cursor: pointer;" data-toggle="modal" data-target="#rumaComercial" @click="getMateria(1, 'Ruma Café Comercial')">
                                                <div class="card-body">
                                                    Rumas   
                                                </div>     
                                            </div>  
                                        </div> 
                                        <div class="col-md-6 mt-2">
                                            <div class="card d-flex justify-content-center align-items-center" style="background: #eee; cursor: pointer;" data-toggle="modal" data-target="#lotesComercial" @click="getMateria(1, 'Lote Café Comercial')">
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
                    <div class="modal fade" tabindex="-1" id="corriente" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
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
                                        <div class="col-md-6 mt-2">
                                            <div class="card d-flex justify-content-center align-items-center" style="background: #eee; cursor: pointer;" data-toggle="modal" data-target="#rumaCorriente" @click="getMateria(1, 'Ruma Café Corriente')">
                                                <div class="card-body">
                                                    Rumas   
                                                </div>     
                                            </div>  
                                        </div> 
                                        <div class="col-md-6 mt-2">
                                            <div class="card d-flex justify-content-center align-items-center" style="background: #eee; cursor: pointer;" data-toggle="modal" data-target="#loteCorriente" @click="getMateria(1, 'Lote Café Corriente')">
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
                    <div class="modal fade" tabindex="-1" id="rumaComercial" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h4 class="mb-0">Ruma Café Comercial</h4>
                                        <button class="btn btn-info ml-2 btn-sm" data-toggle="modal" data-target="#guardarEvaluado">
                                            <i style="font-size: 15px;" class="feather icon-file-text"></i>
                                        </button>
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive mt-2">
                                        <table class="table table-bordered table-striped table-sm mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Opciones</th>
                                                    <th>Código</th>
                                                    <th>Nombre</th>
                                                    <th>Dni</th>
                                                    <th>Sacos</th>
                                                    <th>KB</th>
                                                    <th>Tara</th>
                                                    <th>KN</th>
                                                    <th>KN/QQ</th>
                                                    <th>C</th>
                                                    <th>R</th>
                                                    <th>H</th>
                                                    <th>Precio QQ</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead> 
                                            <tbody>
                                                <tr v-for="detalle in arrayDetalle" :key="detalle.idDetalleRecepcion">
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button type="button" @click="llenarDatosDetalle(detalle)" data-toggle="modal" :data-target="detalle.modal" class="btn btn-info btn-sm" >
                                                                <i style="font-size: 15px;" class="feather icon-eye"></i>
                                                            </button> &nbsp;
                                                        </div>
                                                    </td>
                                                    <td v-text="detalle.codigo"></td>
                                                    <td v-text="detalle.nombre"></td>
                                                    <td v-text="detalle.dni"></td>
                                                    <td v-text="detalle.saco"></td>
                                                    <td v-text="detalle.kilo"></td>
                                                    <td v-text="detalle.tara"></td>
                                                    <td v-text="detalle.kiloNeto"></td>
                                                    <td v-text="detalle.quintales"></td>
                                                    <td v-text="detalle.c"></td>
                                                    <td v-text="detalle.r"></td>
                                                    <td v-text="detalle.h"></td>
                                                    <td v-text="detalle.precioQQ"></td>
                                                    <td v-text="detalle.total"></td>
                                                </tr>                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <nav class="d-flex justify-content-center align-items-center mt-2">   
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
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="rumaCorriente" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h4 class="mb-0">Ruma Café Corriente</h4>
                                        <button class="btn btn-info ml-2 btn-sm" data-toggle="modal" data-target="#guardarCorriente">
                                            <i style="font-size: 15px;" class="feather icon-file-text"></i>
                                        </button>
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive mt-2">
                                        <table class="table table-bordered table-striped table-sm mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Opciones</th>
                                                    <th>Código</th>
                                                    <th>Nombre</th>
                                                    <th>Dni</th>
                                                    <th>Sacos</th>
                                                    <th>KB</th>
                                                    <th>Tara</th>
                                                    <th>KN</th>
                                                    <th>KN/QQ</th>
                                                    <th>Precio QQ</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead> 
                                            <tbody>
                                                <tr v-for="detalle in arrayDetalle" :key="detalle.idDetalleRecepcion">
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button type="button" @click="llenarDatosDetalle(detalle)" data-toggle="modal" :data-target="detalle.modal" class="btn btn-info btn-sm" >
                                                                <i style="font-size: 15px;" class="feather icon-eye"></i>
                                                            </button> &nbsp;
                                                        </div>
                                                    </td>
                                                    <td v-text="detalle.codigo"></td>
                                                    <td v-text="detalle.nombre"></td>
                                                    <td v-text="detalle.dni"></td>
                                                    <td v-text="detalle.saco"></td>
                                                    <td v-text="detalle.kilo"></td>
                                                    <td v-text="detalle.tara"></td>
                                                    <td v-text="detalle.kiloNeto"></td>
                                                    <td v-text="detalle.quintales"></td>
                                                    <td v-text="detalle.precioQQ"></td>
                                                    <td v-text="detalle.total"></td>
                                                </tr>                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <nav class="d-flex justify-content-center align-items-center mt-2">   
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
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="loteCorriente" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h4 class="mb-0">Lotes Café Corriente</h4>
                                        <button class="btn btn-info ml-2 btn-sm" data-toggle="modal" data-target="#guardarCorriente">
                                            <i style="font-size: 15px;" class="feather icon-file-text"></i>
                                        </button>
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive mt-2">
                                        <table class="table table-bordered table-striped table-sm mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Opciones</th>
                                                    <th>Código</th>
                                                    <th>Nombre</th>
                                                    <th>Dni</th>
                                                    <th>Sacos</th>
                                                    <th>KB</th>
                                                    <th>Tara</th>
                                                    <th>KN</th>
                                                    <th>KN/QQ</th>
                                                    <th>Precio QQ</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead> 
                                            <tbody>
                                                <tr v-for="detalle in arrayDetalle" :key="detalle.idDetalleRecepcion">
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button type="button" @click="llenarDatosDetalle(detalle)" data-toggle="modal" :data-target="detalle.modal" class="btn btn-info btn-sm" >
                                                                <i style="font-size: 15px;" class="feather icon-eye"></i>
                                                            </button> &nbsp;
                                                        </div>
                                                    </td>
                                                    <td v-text="detalle.codigo"></td>
                                                    <td v-text="detalle.nombre"></td>
                                                    <td v-text="detalle.dni"></td>
                                                    <td v-text="detalle.saco"></td>
                                                    <td v-text="detalle.kilo"></td>
                                                    <td v-text="detalle.tara"></td>
                                                    <td v-text="detalle.kiloNeto"></td>
                                                    <td v-text="detalle.quintales"></td>
                                                    <td v-text="detalle.precioQQ"></td>
                                                    <td v-text="detalle.total"></td>
                                                </tr>                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <nav class="d-flex justify-content-center align-items-center mt-2">   
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
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="lotesComercial" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h4 class="mb-0">Lotes Café Comercial</h4>
                                        <button class="btn btn-info ml-2 btn-sm" data-toggle="modal" data-target="#guardarEvaluado">
                                            <i style="font-size: 15px;" class="feather icon-file-text"></i>
                                        </button>
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive mt-2">
                                        <table class="table table-bordered table-striped table-sm mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Opciones</th>
                                                    <th>Código</th>
                                                    <th>Nombre</th>
                                                    <th>Dni</th>
                                                    <th>Sacos</th>
                                                    <th>KB</th>
                                                    <th>Tara</th>
                                                    <th>KN</th>
                                                    <th>KN/QQ</th>
                                                    <th>C</th>
                                                    <th>R</th>
                                                    <th>H</th>
                                                    <th>Precio QQ</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead> 
                                            <tbody>
                                                <tr v-for="detalle in arrayDetalle" :key="detalle.idDetalleRecepcion">
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button type="button" @click="llenarDatosDetalle(detalle)" data-toggle="modal" :data-target="detalle.modal" class="btn btn-info btn-sm" >
                                                                <i style="font-size: 15px;" class="feather icon-eye"></i>
                                                            </button> &nbsp;
                                                        </div>
                                                    </td>
                                                    <td v-text="detalle.codigo"></td>
                                                    <td v-text="detalle.nombre"></td>
                                                    <td v-text="detalle.dni"></td>
                                                    <td v-text="detalle.saco"></td>
                                                    <td v-text="detalle.kilo"></td>
                                                    <td v-text="detalle.tara"></td>
                                                    <td v-text="detalle.kiloNeto"></td>
                                                    <td v-text="detalle.quintales"></td>
                                                    <td v-text="detalle.c"></td>
                                                    <td v-text="detalle.r"></td>
                                                    <td v-text="detalle.h"></td>
                                                    <td v-text="detalle.precioQQ"></td>
                                                    <td v-text="detalle.total"></td>
                                                </tr>                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <nav class="d-flex justify-content-center align-items-center mt-2">   
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
                                    <h4 class="mb-0">Descripción Almacén</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-6">
                                            <h5>Código: {{almacen.codigoAlmacen}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Sacos: {{almacen.sacosAlmacen}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Peso Kg: {{almacen.pesoKg}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Tara: {{almacen.taraAlmacen}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Peso Neto Kg: {{almacen.pesoNetoKg}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Peso Neto QQ: {{almacen.pesoNetoQuintal}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Compra: {{almacen.precioCompra}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Inversión: {{almacen.inversion}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="guardarEvaluado" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="mb-0">Descripción Almacén</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-6">
                                            <h5>Código: {{almacen.codigoAlmacen}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Sacos: {{almacen.sacosAlmacen}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Peso Kg: {{almacen.pesoKg}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Tara: {{almacen.taraAlmacen}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Peso Neto Kg: {{almacen.pesoNetoKg}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Peso Neto QQ: {{almacen.pesoNetoQuintal}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Humedad: {{almacen.hAlmacen}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Rendimiento: {{almacen.rAlmacen}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Cascara: {{almacen.cAlmacen}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Compra: {{almacen.precioCompra}}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Inversión: {{almacen.inversion}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="loteOrganico" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h4 class="mb-0">Lotes Café Orgánico</h4>
                                        <button class="btn btn-info ml-2 btn-sm" data-toggle="modal" data-target="#guardarEvaluado">
                                            <i style="font-size: 15px;" class="feather icon-file-text"></i>
                                        </button>
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive mt-2">
                                        <table class="table table-bordered table-striped table-sm mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Opciones</th>
                                                    <th>Código</th>
                                                    <th>Nombre</th>
                                                    <th>Dni</th>
                                                    <th>Sacos</th>
                                                    <th>KB</th>
                                                    <th>Tara</th>
                                                    <th>KN</th>
                                                    <th>KN/QQ</th>
                                                    <th>C</th>
                                                    <th>R</th>
                                                    <th>H</th>
                                                    <th>Precio QQ</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead> 
                                            <tbody>
                                                <tr v-for="detalle in arrayDetalle" :key="detalle.idDetalleRecepcion">
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button type="button" @click="llenarDatosDetalle(detalle)" data-toggle="modal" :data-target="detalle.modal" class="btn btn-info btn-sm" >
                                                                <i style="font-size: 15px;" class="feather icon-eye"></i>
                                                            </button> &nbsp;
                                                        </div>
                                                    </td>
                                                    <td v-text="detalle.codigo"></td>
                                                    <td v-text="detalle.nombre"></td>
                                                    <td v-text="detalle.dni"></td>
                                                    <td v-text="detalle.saco"></td>
                                                    <td v-text="detalle.kilo"></td>
                                                    <td v-text="detalle.tara"></td>
                                                    <td v-text="detalle.kiloNeto"></td>
                                                    <td v-text="detalle.quintales"></td>
                                                    <td v-text="detalle.c"></td>
                                                    <td v-text="detalle.r"></td>
                                                    <td v-text="detalle.h"></td>
                                                    <td v-text="detalle.precioQQ"></td>
                                                    <td v-text="detalle.total"></td>
                                                </tr>                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <nav class="d-flex justify-content-center align-items-center mt-2">   
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
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
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
                errors : [],
                arrayDetalle : [],
                tipo : '',
                almacen : []
                /* fin de Paginación */
                
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
            cambiarPagina(page){
                let me = this;
                me.pagination.current_page = page;
                me.getMateria(page, me.tipo);
            },
            getMateria(page, tipo){
                let me = this;
                me.tipo = tipo;
                var url = '/Distribucion?page='+page+'&tipo='+tipo
                axios.get(url).then((response)=>{
                    var respuesta = response.data;
                    me.pagination= respuesta.pagination;
                    me.arrayDetalle = respuesta.detalle.data;
                    me.almacen = respuesta.almacen[0];
                }).catch((error)=>{
                    console.log(error);
                })
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
        }
    }
</script>
<style>  
    
</style>

