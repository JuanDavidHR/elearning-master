<template>
    <main class="main">
        <div class="container-fluid mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between">
                            <h4>Almacén Lote Café Cashapa</h4>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#guardarCorriente">
                                <i style="font-size: 15px;" class="feather icon-file-text"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 table-responsive">
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
                    </div>
                    <div class="modal fade" tabindex="-1" id="guardarCorriente" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="mb-0">Descripción Café Cashapa</h4>
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
                                            <h5>Peso Neto Lb: {{almacen.pesoNetoQuintal}}</h5>
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
                </div>
            </div>
        </div>
    </main>
</template>
<script>
import VueNumeric from 'vue-numeric'
export default {
    components : {
        VueNumeric
    },
    data(){
        return {
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
    methods: {
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
    },
    mounted() {
        this.getMateria(1, 'Lote Café Cashapa');
    }
}
</script>