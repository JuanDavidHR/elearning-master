<template>
    <main class="main">
        <div class="container-fluid mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Gestión de Precios</h4>
                            <button class="btn btn-success" data-toggle="modal" data-target="#modalPrecio" @click="initial()">
                                Nuevo Precio
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
                                        <th class="text-center">Cascara</th>
                                        <th class="text-center">Rendimiento</th>
                                        <th class="text-center">Humedad</th>
                                        <th class="text-center">Precio Compra</th>
                                        <th class="text-center">Precio Venta</th>
                                        <th class="text-center">Unidad de Medida</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="precio in arrayPrecio" :key="precio.idPrecio">
                                        <td>
                                            <button type="button" @click="setData(precio)" class="btn btns btn-warning btn-sm" data-toggle="modal" data-target="#modalPrecio">
                                                <i style="font-size: 15px;" class="feather  icon-edit"></i>
                                            </button>
                                        </td>
                                        <td v-text="precio.c"></td>
                                        <td v-text="precio.r"></td>
                                        <td v-text="precio.h"></td>
                                        <td v-text="precio.precioCompra"></td>
                                        <td v-text="precio.precioVenta"></td>
                                        <td v-text="precio.unidad"></td>
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
            <div class="modal fade" tabindex="-1" id="modalPrecio" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                <div class="col-md-12 d-flex justify-content-center">
                                    <small v-if="errors.codigoGenerate" class="text-danger" v-text="errors.codigoGenerate[0]"></small>
                                </div>
                                <div class="col-md-4 mb-1" v-for="cab in arrayCabecera" :key="cab.idParametro">
                                    <p class="p-text" v-text="cab.nombreParametro"></p>
                                    <vue-numeric v-bind:minus ="false" v-bind:precision="0" v-bind:min ="cab.minParametro" v-bind:max="cab.maxParametro" class="form-control"  currency="" separator="," v-model="valores[cab.idParametro]"></vue-numeric>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Precio de Compra</p>
                                    <vue-numeric v-bind:minus ="false" v-bind:precision="2" v-bind:min = "0" v-bind:max = "999999" class="form-control"  currency="" separator="," v-model="precioCompra"></vue-numeric>
                                    <small v-if="errors.precioCompra" class="text-danger" v-text="errors.precioCompra[0]"></small>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Precio de Venta</p>
                                    <vue-numeric v-bind:minus ="false" v-bind:precision="2" v-bind:min = "0" v-bind:max = "999999" class="form-control"  currency="" separator="," v-model="precioVenta"></vue-numeric>
                                    <small v-if="errors.precioVenta" class="text-danger" v-text="errors.precioVenta[0]"></small>
                                </div>
                                
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" v-if="tipoAccion == 1"  class="btn btn-success" @click="registrarPrecio()">Registrar</button>
                            <button type="submit" v-if="tipoAccion == 2" class="btn btn-success"  @click="actualizarPrecio()">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
import VueNumeric from 'vue-numeric';
export default {
    components : {
        VueNumeric
    },
    data(){
        return {
            arrayCabecera : [],
            arrayParametros: [],
            tipoAccion : 1,
            tituloModal : 'Registro de Precios',
            precioCompra : 0,
            precioVenta : 0,
            valores : [], 
            errors : [],
            arrayPrecio : [],
            idPrecio : '',
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
            me.obtenerPrecios(page);
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
        actualizarPrecio(){
            var aux = '';
            var cod = '';
            var arreglo = [];
            this.valores.forEach((element, index )=> {
                arreglo.push({"valor": element, "idParametro": index});
                var aux = element.toString().length;
                cod = cod + this.numCero(aux, 3) + element;
            });
            let me = this;
            axios.put('/Precios/update',{
                'idPrecio' : this.idPrecio,
                'codigoGenerate' : cod,
                'precioCompra' : this.precioCompra,
                'precioVenta' : this.precioVenta,
                'cascara' : arreglo[0].valor,
                'rendimiento' : arreglo[1].valor,
                'humedad' : arreglo[2].valor
            }).then((response)=>{
                me.initial();
                toastr.success('Precio Modificado.');
                me.obtenerPrecios(1);
                me.cerrarModal();
            }).catch((error)=>{
                this.errors = error.response.data.errors;
            })
        },
        obtenerPrecios(page){
            let me = this;
            var url = '/Precios?page=' + page;
            axios.get(url).then(function(response){
                var respuesta = response.data;
                me.arrayPrecio = respuesta.precios.data;
                me.pagination = respuesta.pagination;
            })
            .catch(function(error){
            });
        },
        registrarPrecio(){
            var aux = '';
            var cod = '';
            var arreglo = [];
            this.valores.forEach((element, index )=> {
                arreglo.push({"valor": element, "idParametro": index});
                var aux = element.toString().length;
                cod = cod + this.numCero(aux, 3) + element;
            });
            let me = this;
            axios.post('/Precios/store',{
                'codigoGenerate' : cod,
                'precioCompra' : this.precioCompra,
                'precioVenta' : this.precioVenta,
                'cascara' : arreglo[0].valor,
                'rendimiento' : arreglo[1].valor,
                'humedad' : arreglo[2].valor
            }).then((response)=>{
                me.initial();
                toastr.success('Precio registrado.');
                me.obtenerPrecios(1);
                me.cerrarModal();
            }).catch((error)=>{
                this.errors = error.response.data.errors;
            })
        },
        cerrarModal(){
            $('#modalPrecio').modal('hide');
        },
        initial(){
            this.errors = [];
            this.precioCompra = 0;
            this.precioVenta = 0;
            this.valores = [];
            this.tipoAccion = 1;
            this.arrayCabecera.forEach(element => {
                this.valores[element.idParametro] = element.minParametro
            });
        },
        setData(precio){
            this.errors = [];
            this.precioCompra = precio['precioCompra'];
            this.precioVenta = precio['precioVenta'];
            this.valores = [];
            this.idPrecio = precio['idPrecio'];
            this.tipoAccion = 2;
            this.tituloModal = "Modificar Precio";
            this.arrayCabecera.forEach(element => {
                switch (element.idParametro) {
                    case 1: this.valores[element.idParametro] = precio['c']; break;
                    case 2: this.valores[element.idParametro] = precio['r']; break;
                    case 3: this.valores[element.idParametro] = precio['h']; break;
                }
            });
        },
        obtenerCabecera(){
            let me = this;
            var url = '';
            url = "/parametro";
            axios.get(url).then((response)=>{
                var respuesta = response.data;
                me.arrayCabecera = respuesta.parametros;
            }).catch((error)=>{
                console.log(error);
            })
        }
    },
    mounted() {
        this.obtenerCabecera();
        this.obtenerPrecios(1);
    },
}
</script>
<style >
    .p-text{
        margin-bottom: 0px !important;
    }
</style>