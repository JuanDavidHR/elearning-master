<template>
    <main class="main">
        <div class="mt-4 mb-4 container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-5 d-flex justify-content-betweend align-items-center">
                            <h5 class="mt-1">Gestión de Compras</h5>
                            <template v-if="visto">
                                <button type="button" @click="nuevaCompra()" class="btn mod ml-auto">
                                    <i class="icon-plus"></i>&nbsp;Nuevo
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
                <template v-if="visto">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="tipoComprobante">Tipo Comprobante</option>
                                        <option value="numComprobante">Número Comprobante</option>
                                        <option value="fecha_compra">Fecha-Hora</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarIngreso(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarIngreso(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Usuario</th>
                                        <th>Proveedor</th>
                                        <th>Tipo Comprobante</th>
                                        <th>Serie Comprobante</th>
                                        <th>Número Comprobante</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Impuesto</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ingreso in arrayIngreso" :key="ingreso.idIngreso">
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" @click="llenarDatosIngreso(ingreso)" class="btn btns btn-warning btn-sm">
                                                    <i class="icon-eye"></i>
                                                </button> &nbsp;
                                                <template v-if="ingreso.estado=='Registrado'">
                                                    <button type="button" class="btn btns btn-danger btn-sm" @click="desactivarIngreso(ingreso.idIngreso)">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </template>
                                                <template v-else>
                                                    <button type="button" class="btn btns btn-info btn-sm" @click="activarIngreso(ingreso.idIngreso)">
                                                        <i class="icon-check"></i>
                                                    </button>
                                                </template>
                                            </div>
                                        </td>
                                        
                                        <td v-text="ingreso.usuario"></td>
                                        <td v-text="ingreso.nombre"></td>
                                        <td v-text="ingreso.tipoComprobante"></td>
                                        <td v-text="ingreso.serieComprobante"></td>
                                        <td v-text="ingreso.numComprobante"></td>
                                        <td v-text="usemoment(ingreso.fechaCompra)"></td>
                                        <td v-text="convert(ingreso.totalNeto)"></td>
                                        <td v-text="ingreso.impuesto"></td>
                                        <td>
                                            <div v-if="ingreso.estado == 'Registrado'">
                                                <span class="badge badge-success">Activo</span>
                                            </div>    
                                            <div v-else>
                                                <span class="badge badge-danger">Desactivado</span>
                                            </div>  
                                        </td>
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </template>
                <template v-else>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Proveedor</label>
                                    <v-select 
                                    label="nombre" 
                                    :options="arrayProveedor" 
                                    style="width:100% !important;" 
                                    v-model="proveedorSelect"
                                    :clearable="false"
                                    placeholder="Buscar Proveedor...">
                                        <span  slot = "no-options" > No se encontró el Proveedor. </span>
                                    </v-select>
                                    <small v-if="errors.idProveedor" class="text-danger" v-text="errors.idProveedor[0]"></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Tipo de Comprobante</label>
                                    <v-select 
                                    label="nombre" 
                                    :options="['Boleta', 'Factura', 'Ticket']" 
                                    style="width:100% !important;" 
                                    v-model="comprobanteSelected"
                                    :clearable="false"
                                    placeholder="Tipo de Comprobante">
                                        <span  slot = "no-options" >No se encontró el Tipo.</span>
                                    </v-select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha de Compra</label>
                                    <date-picker v-model="fechaCompra" :disabled-date="disableYear" :clearable = "false" value-type="format" format="DD-MM-YYYY"></date-picker>
                                    <small v-if="errors.fechaCompra" class="text-danger" v-text="errors.fechaCompra[0]"></small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Serie</label>
                                    <input class="form-control" type="text" @change="validateSerie()" v-model="serieComprobante">
                                    <small v-if="errors.serieComprobante" class="text-danger" v-text="errors.serieComprobante[0]"></small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Correlativo</label>
                                    <input type="text" class="form-control" @change="validateCorrelativo()" v-model="numComprobante">
                                    <small v-if="errors.numComprobante" class="text-danger" v-text="errors.numComprobante[0]"></small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Impuesto</label>
                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "1" class="form-control"  currency="" separator="," v-model="impuestoNew"></vue-numeric>
                                    <small v-if="errors.impuestoNew" class="text-danger" v-text="errors.impuestoNew[0]"></small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group d-flex flex-column">
                                    <label>Agregados</label>
                                    <button class="btn btn-warning" data-toggle="modal" data-target="#otros">Gestionar</button>
                                </div>
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Producto</label>
                                    <!-- :disable="cantKit" -->
                                    <v-select 
                                        label="item_data" 
                                        :options="listaProducto" 
                                        style="width:100% !important;" 
                                        v-model="ProductoKit" 
                                        :clearable="false"
                                        @input="datosProductKit(ProductoKit)"
                                        placeholder="Nombre o Código del Producto">
                                        <template v-slot:option="producto"> 
                                            <template>
                                                {{producto.nombre}} ({{producto.codigoProducto}})
                                                <br>
                                                Precio: {{producto.precioVenta}} - Stock: {{producto.stock}}
                                            </template>
                                        </template>
                                        <span slot="no-options">No se encontró el producto.</span>
                                    </v-select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row" v-if="kitDescription">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre del Producto</label>
                                    <input type="text" class="form-control" v-model="nombreProducto" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Precio</label>
                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "9999999" class="form-control"  currency="S/." separator="," v-model="precioCantKit"></vue-numeric>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="decimalKit" v-bind:min = "0" v-bind:max = "9999999" class="form-control"  currency="" separator="," v-model="cantProductKit"></vue-numeric>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="text-white ocultar">1</label>
                                    <button class="btn btn-success form-control agregar" @click="agregaProductoLista()"><i class="icon-plus"></i> Agregar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Producto</th>
                                        <th>Precio Unitario</th>
                                        <th>Cantidad Producto</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="producto in listaKit" :key="producto.idProducto">
                                        <td>
                                            <button type="button" class="btn btns btn-warning btn-sm" @click="setCantidad(producto.cantidad,  producto.tipoVenta, producto, producto.precio, producto.cantidadSeries)">
                                                <i class="icon-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btns btn-danger btn-sm" @click="desactivarArticuloKit(producto.idProducto, producto)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </td>
                                        <td>
                                            {{producto.nombre}}
                                        </td>
                                        <td>
                                            S/. {{convert(producto.precio)}}
                                        </td>
                                        <td>
                                            {{producto.cantidad}}
                                        </td>
                                        <td>
                                            S/. {{convert(producto.cantidad * producto.precio)}}
                                        </td> 
                                    </tr>
                                    <tr>
                                        <td class="relleno" colspan="3"></td>
                                        <td align="right" class="bg-blue">
                                            <strong>Total Parcial:</strong>
                                        </td>
                                        <td class="bg-blue">S/. {{convert(totalParcial)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="relleno" colspan="3"></td>
                                        <td align="right" class="bg-blue">
                                            <strong>Otros:</strong>
                                        </td>
                                        <td class="bg-blue">S/. {{convert(totalOtros)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="relleno" colspan="3"></td>
                                        <td align="right" class="bg-blue">
                                            <strong>Descuento:</strong>
                                        </td>
                                        <td class="bg-blue">S/. {{convert(totalDescuento)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="relleno" colspan="3"></td>
                                        <td class="bg-blue" align="right">
                                            <strong>Total Impuesto:</strong>
                                        </td>
                                        <td class="bg-blue"> S/. {{convert(calculateImpuesto())}}</td>
                                    </tr>   
                                    <tr>
                                        <td class="relleno" colspan="3"></td>
                                        <td class="bg-blue"  align="right">
                                            <strong>Total Neto:</strong>
                                        </td>
                                        <td class="bg-blue">S/. {{convert(calculateNeto())}}</td>
                                    </tr>    
                                    <tr>
                                        <td class="relleno" colspan="3" style="text-align: center; border-right: 1px solid white !important;"></td>
                                        <td class="relleno" colspan="2" style="text-align: center; border-right: 1px solid white !important;">
                                            <small v-if="errors.totalNeto" class="text-danger" v-text="errors.totalNeto[0]"></small>
                                        </td>
                                    </tr>                               
                                </tbody>
                            </table>
                        </div>
                        <div class="modal fade" tabindex="-1" id="otros" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content mods">
                                    <div class="modal-header modle">
                                        <h4 class="modal-title">Gestionar Agregados</h4>
                                        <button type="button" class="close" @click="cerrarCantidad()" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="row">
                                                <div class="col-md-6 form-group ">
                                                    <label class="form-control-label" for="text-input">Otros</label>
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="S/." separator="," v-model="totalOtros"></vue-numeric>
                                                </div>
                                                <div class="col-md-6 form-group ">
                                                    <label class="form-control-label" for="text-input">Descuento</label>
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="S/." separator="," v-model="totalDescuento"></vue-numeric>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btns btn-secondary" data-dismiss="modal" @click="cerrarCantidad()">Cerrar</button>
                                        <!-- <button type="button" class="btn btns btn-primary" @click="guardarCantidad()">Guardar</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" tabindex="-1" id="cantidad" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content mods">
                                    <div class="modal-header modle">
                                        <h4 class="modal-title">Modificar Producto</h4>
                                        <button type="button" class="close" @click="cerrarCantidad()" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="row">
                                                <div class="col-md-6 form-group ">
                                                    <label class="form-control-label" for="text-input">Cantidad</label>
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="decimalKit" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="" separator="," v-model="cantidadUpdate"></vue-numeric>
                                                </div>
                                                <div class="col-md-6 form-group ">
                                                    <label class="form-control-label" for="text-input">Precio</label>
                                                    <vue-numeric v-bind:minus ="false"  v-bind:precision="2" v-bind:min = "0" v-bind:max = "99999" class="form-control"  currency="S/." separator="," v-model="precioUpdate"></vue-numeric>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btns btn-secondary" data-dismiss="modal" @click="cerrarCantidad()">Cerrar</button>
                                        <button type="button" class="btn btns btn-primary" @click="guardarCantidad()">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                    <div class="card-footer" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <div class="btn-container-card-footer">
                                    <button class="btn btn-secondary" @click="()=>{visto = 1; back()}">Cerrar</button>
                                    <button class="btn btn-success" v-if="!update" @click="registrarIngreso()">Registrar Compra</button>
                                    <button class="btn btn-success" v-if="update" @click="actualizarIngreso()">Actualizar Compra</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="ModalCliente" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg">
                <div class="modal-content mods">
                    <div class="modal-header modle">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btns btn-secondary" data-dismiss="modal" @click="cerrarModal('persona')" value="Cerrar">
                        <input type="submit" v-if="tipoAccion == 1"  class="btn btns btn-primary" @click="registrarPersona()" value="Registrar">
                        <input type="submit" v-if="tipoAccion == 2" class="btn btns btn-primary"  @click="actualizarPersona()" value="Actualizar">
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
                idIngreso: 0,
                idProveedor : 0,
                idArticulo : 0,
                tipoComprobante : 'BOLETA',
                impuesto : 0.18,
                total : 0.0,
                precio : 0.0,
                cantidad : 0,
                arrayDetalle : [],
                tituloModal : '',
                tipoAccion : 0,
                
                /*Nuevas Variables */
                arrayIngreso: [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'numComprobante',
                buscar : '',
                visto : 1,
                arrayProveedor : [],
                proveedorSelect : [],
                comprobanteSelected : 'Boleta',
                impuestoNew : '',
                listaProducto : [],
                ProductoKit : [],
                fechaCompra : '',
                listaKit : [],
                decimalKit : 0,
                serieComprobante : '',
                numComprobante : '',
                ProductoDescriptionKit : [],
                kitDescription : false,
                cantProductKit : 0,
                precioCantKit : 0,
                nombreProducto : '',
                totalParcial : 0,
                totalNeto : 0,
                totalImpuesto : 0,
                cantidadUpdate : 0,
                precioUpdate : 0,
                totalOtros : 0,
                totalDescuento : 0,
                productoElegido: [],
                inicial : '',
                update : false,
                cantidadSeries : '',
                idIngresoSelected : '',
                errors:[]
                /* Variables Viejitas */
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
            convert(number){
                let val = (number/1).toFixed(3).replace(',', '.');
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            guardarCantidad(){
                var idSelected = this.productoElegido.idProducto
                var equal = false
                var id = ''
                var aux = []
                var cont = 0
                if(this.cantidadUpdate > 0.000){
                    if(this.cantidadSeries == 0){
                        for (let index = 0; index < this.listaKit.length; index++) {
                            if(this.listaKit[index].idProducto == idSelected){
                                equal = true;
                                id = index; 
                            }
                        }
                        if(equal){
                            aux = this.listaKit;
                            aux[id].cantidad = String(this.cantidadUpdate);
                            aux[id].precio = String(this.precioUpdate)
                            this.listaKit = [];
                            this.listaKit = aux;
                            for (let index = 0; index < this.listaKit.length; index++) {
                                cont += this.listaKit[index].cantidad * this.listaKit[index].precio
                            }
                            this.totalParcial = cont
                        }
                        this.cerrarCantidad();
                    }else{
                        if(this.cantidadUpdate >= this.cantidadSeries){
                            for (let index = 0; index < this.listaKit.length; index++) {
                            if(this.listaKit[index].idProducto == idSelected){
                                equal = true;
                                id = index; 
                            }
                        }
                        if(equal){
                            aux = this.listaKit;
                            aux[id].cantidad = String(this.cantidadUpdate);
                            aux[id].precio = String(this.precioUpdate)
                            this.listaKit = [];
                            this.listaKit = aux;
                            for (let index = 0; index < this.listaKit.length; index++) {
                                cont += this.listaKit[index].cantidad * this.listaKit[index].precio
                            }
                            this.totalParcial = cont
                        }
                        this.cerrarCantidad();
                        }else{
                            toastr.warning('Tiene ' + this.cantidadSeries+ ' series registradas, elimine las series para poder disminuir el stock')
                        }
                    }
                }else{
                    toastr.error('Ingrese una cantidad')
                }
            },
            cerrarCantidad(){
                $("#cantidad").modal("hide");
            },
            setCantidad(cantidad, tipoVenta, data, precio, cantSerie){
                if(!this.update){
                    $("#cantidad").modal("show");
                }else{
                    if(data['vigencia'] == 'Revisión'){
                        $("#cantidad").modal("show");
                    }else{
                        toastr.warning('El lote no se encuentra en revisión para que proceda el cambio.')
                    }
                }
                this.productoElegido = data;
                this.cantidadSeries = cantSerie;
                if(tipoVenta == "Granel"){
                    this.decimalKit = 3
                }else{
                    this.decimalKit = 0
                }
                this.cantidadUpdate = cantidad;
                this.precioUpdate = precio;
            },
            agregaProductoLista(){
                var aux = []
                var duplicate = true;
                var mayorCero = true;
                var cont = 0;
                var noMore = []
                if(this.cantProductKit > 0.000){
                    mayorCero = true;
                }else{
                    toastr.error('Ingrese una cantidad.')
                    mayorCero = false;
                }
                for (let index = 0; index < this.listaKit.length; index++) {
                    if(this.listaKit[index].idProducto == this.ProductoDescriptionKit.idProducto){
                        toastr.warning('No puedes registrar dos veces el mismo producto, si quieres agregar más puedes modificar su cantidad.')
                        duplicate = false;
                    }
                }
                if(duplicate && mayorCero){
                    aux = this.ProductoDescriptionKit
                    aux.cantidad = String(this.cantProductKit)
                    aux.precio = String(this.precioCantKit)
                    this.listaKit.push(aux)
                    this.kitDescription = false
                    for (let index = 0; index < this.listaKit.length; index++) {
                        cont += this.listaKit[index].cantidad * this.listaKit[index].precio
                    }
                    this.totalParcial = cont;
                }
            },
            desactivarArticuloKit(idProducto, data){
                if(this.update){
                    if(data['vigencia'] == 'Revisión'){
                        if(data['cantidadSeries'] == 0){
                            const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success',
                                cancelButton: 'btn btn-danger'
                            },
                            buttonsStyling: false
                            })
                            swalWithBootstrapButtons.fire({
                            title: '¿Está seguro de eliminar el Articulo de la Compra?',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Aceptar!',
                            cancelButtonText: 'Cancelar',
                            reverseButtons: true
                            }).then((result) => {
                            if (result.value) {
                                var aux = []
                                var cont = 0
                                var noMore = []
                                for (let index = 0; index < this.listaKit.length; index++) {
                                    if(this.listaKit[index].idProducto != idProducto){
                                        aux.push(this.listaKit[index])
                                    }
                                }
                                for (let index = 0; index < aux.length; index++) {
                                    cont += aux[index].cantidad * aux[index].precioCompra
                                }
                                this.listaKit = aux;
                                this.totalParcial = cont
                                swalWithBootstrapButtons.fire(
                                'Descativado',
                                'El Producto ha sido eliminado.',
                                'success')
                            } else if (
                                /* Read more about handling dismissals below */
                                result.dismiss === Swal.DismissReason.cancel
                            ) {}
                            })
                        }else{
                            toastr.warning('No se puede eliminar el producto porque tiene series registradas.')
                        }
                    }else{
                        toastr.warning('El lote no se encuentra en revisión para que proceda la eliminación.')
                    }
                }else{
                    const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })
                    swalWithBootstrapButtons.fire({
                    title: '¿Está seguro de eliminar el Articulo de la Compra?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                        var aux = []
                        var cont = 0
                        var noMore = []
                        for (let index = 0; index < this.listaKit.length; index++) {
                            if(this.listaKit[index].idProducto != idProducto){
                                aux.push(this.listaKit[index])
                            }
                        }
                        for (let index = 0; index < aux.length; index++) {
                            cont += aux[index].cantidad * aux[index].precioCompra
                        }
                        this.listaKit = aux;
                        this.totalParcial = cont
                        swalWithBootstrapButtons.fire(
                        'Descativado',
                        'El Producto ha sido eliminado.',
                        'success')
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {}
                    })
                }
            },
            calculateImpuesto:function(){
                return ( this.totalParcial + this.totalOtros - this.totalDescuento ) * this.impuestoNew;
            },
            calculateNeto:function(){
                return ( this.totalParcial + this.totalOtros - this.totalDescuento ) * (1 + this.impuestoNew);
            },
            checkOutInicial:function(aux){
                switch (aux) {
                    case "Boleta":
                        this.inicial = "B";
                        break;
                    case "Factura":
                        this.inicial = "F";                
                        break;
                    default:
                        this.inicial = "T"
                        break;
                }
            },
            actualizarIngreso(){
                if(this.listaKit.length){
                 let me = this;
                    axios.put('/Ingreso/update',{
                        'idIngreso' : this.idIngresoSelected,
                        'idProveedor' : this.proveedorSelect.id,
                        'tipoComprobante' : this.comprobanteSelected,
                        'inicial' : this.checkOutInicial(this.inicial),
                        'serieComprobante': this.serieComprobante,
                        'numComprobante' : this.numComprobante,
                        'impuesto' : this.impuestoNew,
                        'totalParcial': this.totalParcial,
                        'totalImpuesto': this.calculateImpuesto(),
                        'totalNeto': this.calculateNeto(),
                        'totalOtros': this.totalOtros,
                        'totalDescuento': this.totalDescuento,
                        'fechaCompra' : this.savemoment(this.fechaCompra),
                        'detalleList' : this.listaKit
                    }).then(function (response) {
                        toastr.success('Compra registrada con éxito');
                        this.visto = 1;
                        me.back();
                        me.listarIngreso(1,'','nombre');
                    }).catch(function (error) {
                        console.log(error);
                    });
                }else{
                    toastr.error('Ingrese Productos de la compra')
                }
            },
            numCero:function(lengthCaracter, total){
                var resta = total-lengthCaracter;
                var count = 0;
                var copy = '0';
                var result = '';
                console.log(resta)
                if(resta != 0){
                    while (count!=resta) {
                        result = result + copy;
                        count ++;
                    }
                }
                return result;
            },
            validateCorrelativo(){
                var val = Math.abs(parseInt(this.numComprobante, 10) || 0);
                var cant = val.toString().length;
                if(cant >= 8){
                    this.numComprobante = val > 99999999 ? 99999999 : val;
                }else{
                    this.numComprobante = this.numCero(cant, 8) + val;
                }
            },
            validateSerie(){
                var val = Math.abs(parseInt(this.serieComprobante, 10) || 0);
                var cant = val.toString().length;
                if(cant >= 3){
                    this.serieComprobante = val > 999 ? 999 : val;
                }else{
                    this.serieComprobante = this.numCero(cant, 3) + val;
                }
            },
            registrarIngreso(){
                //enviarle una inicial para poder ponerlo en el comprobante
                if(this.listaKit.length){
                    this.checkOutInicial(this.comprobanteSelected);
                    let me = this;
                    axios.post('/Ingreso/registrar',{
                        'idProveedor' : me.proveedorSelect.id,
                        'tipoComprobante' : me.comprobanteSelected,
                        'inicial' : me.inicial,
                        'serieComprobante': me.serieComprobante,
                        'numComprobante' : me.numComprobante,
                        'impuesto' : me.impuestoNew,
                        'totalParcial': me.totalParcial,
                        'totalImpuesto': me.calculateImpuesto(),
                        'totalNeto': me.calculateNeto(),
                        'totalOtros': me.totalOtros,
                        'totalDescuento': me.totalDescuento,
                        'fechaCompra' : me.savemoment(me.fechaCompra),
                        'detalleList' : me.listaKit
                    }).then(function (response) {
                        toastr.success('Compra registrada con éxito');
                        me.visto = 1;
                        me.back();
                        me.listarIngreso(1,'','nombre');
                    }).catch(function (error) {
                        me.errors = error.response.data.errors;
                    });
                }else{
                    toastr.error('Ingrese Productos de la compra')
                }
            },
            datosProductKit(data){
                this.ProductoDescriptionKit = data;
                this.ProductoKit = [];
                this.kitDescription = true;
                this.cantProductKit = 0;
                this.nombreProducto = this.ProductoDescriptionKit.nombre;
                this.precioCantKit = 0;
                if(this.ProductoDescriptionKit.tipoVenta == "Granel"){
                    this.decimalKit = 3;
                }else{
                    this.decimalKit = 0;
                }
            },
            calculateTotalParcial(){
                var cont = 0;
                for (let index = 0; index < this.listaKit.length; index++) {
                    cont += this.listaKit[index].cantidad * this.listaKit[index].precio
                }
                this.totalParcial = cont;
            },
            llenarDatosIngreso(data){
                let me = this;
                var url = '/Ingreso/getLote?idIngreso='+data['idIngreso'];
                axios.get(url).then((response)=>{
                    let respuesta = response.data;
                    me.listaKit = respuesta.list;
                    me.visto = 0;
                    me.update = true;
                    me.proveedorSelect = {id: data['idProveedor'], nombre : data['nombre']}
                    me.comprobanteSelected = data['tipoComprobante'];
                    me.serieComprobante = data['serieComprobante'];
                    me.numComprobante = data['numComprobante'];
                    me.totalOtros = data['totalOtros'];
                    me.totalDescuento = data['totalDescuento'];
                    me.impuestoNew = data['impuesto'];
                    me.fechaCompra = me.usemoment(data['fechaCompra']);
                    me.idIngresoSelected = data['idIngreso'];
                    me.calculateTotalParcial();
                    
                }).catch((error)=>{
                    console.log(error)
                })
            },
            getProductos(){    
                let me= this;
                var url = '/Producto/obtenerDatos';
                axios.get(url).then(function(response){
                    let respuesta = response.data;
                    me.listaProducto=respuesta.productos;
                    me.listaProducto.map(function (x){
                        return x.item_data = x.nombre + ' - ' + x.codigoProducto 
                    });
                }).catch(function(error){
                    console.log(error);
                })
            },
            seleccionado(){
            },
            getProveedor(){
                let me = this;
                var url = '/Proveedor/getProveedor';
                axios.get(url).then(function(response){
                    var respuesta = response.data;
                    me.arrayProveedor = respuesta.proveedor;
                }).catch(function(error){
                    console.log(error);
                })
            },
            back(){
                this.proveedorSelect = [];
                this.serieComprobante = '';
                this.numComprobante = '';
                this.impuestoNew = '';
                this.tipoComprobante = 'Boleta';
                this.fechaCompra = '';
                this.proveedorSelect = [];
                this.listaKit = [];
                this.totalParcial = 0;
                this.totalOtros = 0;
                this.totalDescuento = 0;
            },
            nuevaCompra(){
                this.visto = 0;
                this.update = false;
                this.back();
                this.errors = [];
            },




















            /* Fin de las Nuevas Funciones */
            listarIngreso (page,buscar,criterio){
                let me=this;
                var url= '/Ingreso?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayIngreso = respuesta.ingresos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarIngreso(page,buscar,criterio);
            },
            registrarPersona(){
                let me = this;
                axios.post('/user/registrar',{
                    'nombre': this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email, 
                    'usuario' : this.usuario,
                    'password' : this.password,
                    'idRoles' : this.idRoles
                    
                }).then(function (response) {
                    toastr.success('Proveedor Registrado Correctamente');
                    me.cerrarModal();
                    me.listarIngreso(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarPersona(){
                let me = this;
                axios.put('/user/actualizar',{
                    'nombre': this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'vigencia' : this.vigencia,
                    'idPersona': this.persona_id,
                    'usuario' : this.usuario,
                    'password' : this.password,
                    'idRoles' : this.idRoles
                    
                }).then(function (response) {
                    console.log(response);
                    toastr.success('Registro Actualizado');
                    me.cerrarModal();
                    me.listarIngreso(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },       
            desactivarPersona(idPersona){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                title: '¿Está seguro de Desactivas este Usuario?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put("/user/desactivar", {
                        'idPersona' : idPersona
                    }).then(function(response){
                        me.listarIngreso(1,'','');
                    })
                    .catch(function(error){
                        console.log(error);
                    })
                    swalWithBootstrapButtons.fire(
                    'Descativado',
                    'El Usuario ha sido Desactivado Exitosamente.',
                    'success')
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                }
                })
            },
            activarPersona(idPersona){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                title: '¿Está seguro de Ativar este Usuario?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put("/user/activar", {
                        'idPersona' : idPersona
                    }).then(function(response){
                        me.listarIngreso(1,'','');                        
                    })
                    .catch(function(error){
                        console.log(error);
                    })
                    swalWithBootstrapButtons.fire(
                    'Activado',
                    'El Registro ha sido Activado Exitosamente.',
                    'success')
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                }
                })
            },
            cerrarModal(){
                $('#ModalCliente').modal('hide');
                this.tituloModal='';
                this.nombre='';
                this.tipo_documento='RUC';
                this.num_documento='';
                this.direccion='';
                this.telefono='';
                this.email='';
                this.vigencia=0;
                this.errorPersona=0;
                
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "persona":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                $('#ModalCliente').modal('show');
                                this.tituloModal = 'Registrar Proveedores';
                                this.nombre= '';
                                this.tipo_documento='DNI';
                                this.num_documento='';
                                this.direccion='';
                                this.telefono='';
                                this.email='';
                                this.usuario='';
                                this.password='';
                                this.idRoles = 0;
                                this.vigencia= 1;
                                this.tipoAccion = 1;

                                break;
                            }
                            case 'actualizar':
                            {
                                $('#ModalCliente').modal('show');
                                this.tituloModal='Actualizar Proveedor';
                                this.tipoAccion=2;
                                this.persona_id=data['id'];
                                this.nombre = data['nombre'];
                                this.tipo_documento = data['tipo_documento'];
                                this.num_documento = data['num_documento'];
                                this.direccion = data['direccion'];
                                this.telefono = data['telefono'];
                                this.email = data['email'];
                                this.vigencia = data['vigencia'];
                                this.usuario=data['usuario'];
                                this.password='';
                                this.idRoles = data['idRoles'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarIngreso(1,this.buscar,this.criterio);
            this.getProveedor();
            this.getProductos();
        }
    }
</script>
<style>
    .relleno{
        background: #fff !important;
        border: white 1px solid !important;
        border-right: 1px solid #c2cfd6 !important;
    }
    .bg-blue{
        background-color: #ceecf5;
    }
    ul#vs3__listbox {
        max-height: 200px !important;
    }
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media(max-width:600px){
        .ocultar{
            display: none;
        }
    }
</style>
