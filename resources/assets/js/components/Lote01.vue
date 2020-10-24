<template>
    <main class="main">
        <div class="container-fluid mt-3 mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <h4>Gestión de Almacén</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6" v-for="lote in arrayLote" :key="lote.idLote">
                            <div class="card mb-3">
                                <div class="card-header" style="display: flex; justify-content: space-around; align-items: center;">
                                    <h6 style="margin-bottom: 0px;">{{lote.nombreLote}}</h6>
                                    <button class="btn btn-warning" data-toggle="modal" data-target="#modalLote">
                                        Ver más
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-sm text-center">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" colspan="4">Peso Bruto</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center">Sacos</th>
                                                    <th class="text-center">Cantidad QQ</th>
                                                    <th class="text-center">Tara</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        {{lote.sacosLote}}
                                                    </td>
                                                    <td>
                                                        {{lote.quintalesLote}}
                                                    </td>
                                                    <td>
                                                        {{lote.taraLote}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center"><strong>Peso Neto</strong></td>
                                                    <td colspan="2">
                                                        {{lote.pesoNetoQuintal}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-sm text-center">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" colspan="4">Calidad</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center">C</th>
                                                    <th class="text-center">R</th>
                                                    <th class="text-center">H</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        {{lote.cLote}}
                                                    </td>
                                                    <td>
                                                        {{lote.rLote}}
                                                    </td>
                                                    <td>
                                                        {{lote.hLote}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center"><strong>Precio QQ</strong></td>
                                                    <td colspan="2">
                                                        {{lote.precioNetoQuintal}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <nav>
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
                    </nav> -->
                </div>
            </div>
            <div class="modal fade" tabindex="-1" id="modalLote" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-md">
                    <div class="modal-content mods">
                        <div class="modal-header modle">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-success btn-block">
                                        Café Orgánio y Comercial
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-success btn-block">
                                        Café Corriente
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btns btn-secondary" data-dismiss="modal" value="Cerrar">Cerrar</button>
                            <button v-if="tipoAccion == 1"  class="btn btns btn-primary" @click="registrarLote()">Registrar</button>
                            <button v-if="tipoAccion == 2" class="btn btns btn-primary"  @click="actualizarParametro()">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
    export default {
        data() {
            return {
                tituloModal : 'Registro de Lote',
                nombreLote : '',
                codigoLote : '',
                errors : [],
                tipoAccion : 1,
                idLote : '',
                arrayLote : [],
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
                me.mostrarLote(page);
            },
            initial(){
                this.tipoAccion = 1;
                this.tituloModal = 'Registro de Lote';
                this.nombreLote = '';
                this.codigoLote = '';
                this.errors = [];
            },
            cerrarModal(){
                $('#modalLote').modal('hide');
            },
            mostrarLote(page){
                let me = this;
                var url = '/Lotes?page=' + page;
                axios.get(url).then(function(response){
                    var respuesta = response.data;
                    me.arrayLote = respuesta.lote.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function(error){
                });
            },
            registrarLote(){
                let me = this;
                axios.post('/Lotes/store',{
                    'nombreLote' : this.nombreLote,
                    'codigoLote' : this.codigoLote,
                }).then((response)=>{
                    me.mostrarLote(1);
                    toastr.success('Precio registrado.');
                    me.cerrarModal();
                }).catch((error)=>{
                    this.errors = error.response.data.errors;
                })
            }
        },
        mounted() {
            this.mostrarLote(1);
        }
    }
</script>