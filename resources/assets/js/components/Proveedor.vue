<template>
    <main class="main">
        <div class="container-fluid mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between">
                            <h4>Gestión de Alumnos</h4>
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#proveedor" @click="limpiarProveedor()">
                                <i style="font-size: 15px;" class="feather icon-user-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 table-responsive text-center">
                            <table class="table table-bordered table-striped table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>Dni</th>                                        
                                        <th>Vigencia</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    <tr v-for="detalle in arrayDetalle" :key="detalle.idDetalleRecepcion">
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button"  data-toggle="modal" data-target="#proveedor" @click="llenarDatos(detalle)" class="btn btn-warning btn-sm" >
                                                    <i style="font-size: 15px;" class="feather  icon-edit"></i>
                                                </button> &nbsp;
                                                <button v-if="!detalle.vigencia" type="button" @click="activarEmpresa(detalle.id)" class="btn btn-sm btn-success"><i style="font-size: 15px;" class="feather  icon-check-circle"></i></button>
                                                <button v-else type="button" @click="desactivarEmpresa(detalle.id)" class="btn btn-sm btn-danger"><i style="font-size: 15px;" class="feather icon-x-circle"></i></button>
                                            </div>
                                        </td>
                                        <td v-text="detalle.nombre"></td>
                                        <td v-text="detalle.num_documento"></td>                                        
                                        <td>
                                            <span class="badge badge-pill badge-success" v-if="detalle.vigencia">Habilitado</span>
                                            <span class="badge badge-pill badge-danger" v-else>Deshabilitado</span>
                                        </td>
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
                    <div class="modal fade" tabindex="-1" id="proveedor" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-md" role="document">
                            <div class="modal-content mods">
                                <div class="modal-header header-modal">
                                    <h4 class="mb-0" v-if="register">Registro de Alumnos</h4>
                                    <h4 class="mb-0" v-else>Actualización de Alumnos</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body body-modal">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="p-text">Nombre Alumno</p>
                                            <input type="text" class="form-control" v-model="nombreProveedor">
                                            <small v-if="errors.nombre" class="text-danger"  v-text="errors.nombre[0]"></small>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="p-text">DNI</p>
                                            <input type="text" @change="validateDni()" class="form-control" v-model="dniProveedor">
                                            <small v-if="errors.num_documento" class="text-danger"  v-text="errors.num_documento[0]"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button class="btn  btn-success" v-if="register" @click="registrarProveedor()">Registrar</button>
                                    <button class="btn  btn-success" v-else @click="actualizarProveedor()">Actualizar</button>
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
            almacen : [],
            tipo : '',
            titleModal : 'Registro de Alumno',
            nombreProveedor : '',
            dniProveedor : '',            
            idProveedor : '',
            register : true
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
        getMateria(page){
            let me = this;
            var url = '/Proveedor?page='+page;
            axios.get(url).then((response)=>{
                var respuesta = response.data;
                me.pagination= respuesta.pagination;
                me.arrayDetalle = respuesta.proveedores.data;
            }).catch((error)=>{
                console.log(error);
            })
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
            }).then((response)=>{
                toastr.success('Registrado Correctamente');
                me.getMateria(1);
            }).then((response)=>{
                $("#proveedor").modal("hide");
            }).catch((error)=>{
                me.errors = error.response.data.errors;
            })
        },
        actualizarProveedor(){
            let me = this;
            axios.put('/Proveedor/actualizar',{
                'id' : this.idProveedor,
                'nombre': this.nombreProveedor,
                'num_documento' : this.dniProveedor,                
            }).then((response)=>{
                toastr.success('Actualizado Correctamente');
                me.getMateria(1);
            }).then((response)=>{
                $("#proveedor").modal("hide");
            }).catch((error)=>{
                me.errors = error.response.data.errors;
            })
        },
        limpiarProveedor(){
            this.register = true;
            this.errors = [];
            this.nombreProveedor = '';
            this.dniProveedor = '';
            this.zonaProveedor = '';
        },
        llenarDatos(data){
            this.register = false;
            this.errors = [];
            this.idProveedor =  data['id'];
            this.nombreProveedor = data['nombre'];
            this.dniProveedor = data['num_documento'];            
        },
        desactivarEmpresa(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn ml-1 btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons
            .fire({
                title: "¿Está seguro de dehabilitar el Proveedor?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                reverseButtons: true
            })
            .then(result => {
                if (result.value) {
                    let me = this;
                    axios.put("/Proveedor/disabled", {
                        'id': id
                    }).then(function(response) {
                        me.getMateria(1);
                    }).catch(function(error) {
                        console.log(error);
                    });
                    swalWithBootstrapButtons.fire(
                        "Deshabilitado",
                        "El Proveedor fue deshabilitado exitosamente.",
                        "success"
                    );
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                }
            });
        },
        activarEmpresa(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn ml-1 btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons
            .fire({
                title: "¿Está seguro de habilitar el Proveedor?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                reverseButtons: true
            })
            .then(result => {
                if (result.value) {
                    let me = this;
                    axios.put("/Proveedor/enabled", {
                        'id': id
                    }).then(function(response) {
                        me.getMateria(1);
                    }).catch(function(error) {
                        console.log(error);
                    });
                    swalWithBootstrapButtons.fire(
                        "Habilitado",
                        "El Provedor fue habilitado exitosamente.",
                        "success"
                    );
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                }
            });
        },
    },
    mounted() {
        this.getMateria(1);
    }
}
</script>