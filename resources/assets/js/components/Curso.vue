<template>
    <main class="main">
        <div class="container-fluid mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Gestión de Cursos</h4>
                            <button class="btn btn-success" data-toggle="modal" data-target="#modalCurso" @click="initial()">
                                Nuevo Curso
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
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Horas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="curso in arrayCurso" :key="curso.idCurso">
                                        <td>
                                            <button type="button" @click="llenarDatos(curso)" class="btn btns btn-warning btn-sm" data-toggle="modal" data-target="#modalCurso">
                                                <i style="font-size: 15px;" class="feather  icon-edit"></i>
                                            </button>
                                        </td>
                                        <td v-text="curso.nombreCurso"></td>
                                        <td v-text="curso.fechaCurso"></td>
                                        <td v-text="curso.horasCurso"></td>
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
            <div class="modal fade" tabindex="-1" id="modalCurso" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Nombre Curso</p>
                                    <input type="text" class="form-control" v-model="nombreCurso">
                                </div>
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Fecha</p>
                                    <date-picker v-model="fechaCurso" value-type="format" :clearable = "false" format="DD-MM-YYYY"></date-picker>
                                    <small v-if="errors.fecha_curso" class="text-danger" v-text="errors.fecha_curso[0]"></small>
                                </div>                      
                                <div class="col-md-4 mb-1">
                                    <p class="p-text">Cantidad Horas</p>
                                    <input type="text" class="form-control" v-model="horasCurso">
                                </div>                                                                                     
                            </div>                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" v-if="tipoAccion == 1"  class="btn btn-success" @click="registrarCurso()">Registrar</button>
                            <button type="submit" v-if="tipoAccion == 2" class="btn btn-success"  @click="actualizarCurso()">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
import VueNumeric from 'vue-numeric';
import moment from 'moment';
export default {
    components : {
        VueNumeric
    },
    data(){
        return {
            tipoAccion : 1,
            tituloModal : 'Registro de Curso',
            horasCurso: '',
            nombreCurso : '',
            fechaCurso : '', 
            arrayCurso: [],        
            errors : [],            
            idCurso : '',
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
            me.obtenerCursos(page);
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
        llenarDatos(curso){
            this.tituloModal = 'Actualizar Curso';
            this.idCurso = curso['id'];
            this.tipoAccion = 2;
            this.nombreCurso = curso['nombreCurso'];
            this.fechaCurso = this.usemoment(curso['fechaCurso']);
            this.horasCurso = curso['horasCurso'];
        },
        actualizarCurso() {            
            let me = this;
            axios
                .put("/Curso/update", {
                    id: this.idCurso,
                    nombreCurso: this.nombreCurso,                    
                    fechaCurso : me.savemoment(this.fechaCurso),
                    horasCurso: this.horasCurso,                    
                })
                .then(function(response) {
                    console.log(response);
                    toastr.success("Curso Actualizado");
                    me.cerrarModal();
                    me.obtenerCursos(1);
                })
                .catch(error => (this.errors = error.response.data.errors));
        },
        obtenerCursos(page){
            let me = this;
            var url = '/Curso?page=' + page;
            axios.get(url).then(function(response){
                var respuesta = response.data;
                me.arrayCurso = respuesta.cursos.data;
                me.pagination = respuesta.pagination;
            })
            .catch(function(error){
            });
        },
        limpiar(){
            this.nombreCurso = '';
            this.fechaCurso = '';
            this.horasCurso = '';            
            this.errors = [];
        },
        registrarCurso(){
            var aux = '';
            var cod = '';
            let me = this;
            axios.post('/Curso/store',{                
                'nombreCurso' : this.nombreCurso,                
                'fechaCurso' : this.savemoment(this.fechaCurso),
                'horasCurso' : this.horasCurso
            }).then((response)=>{
                me.initial();
                toastr.success('Curso registrado.');
                me.obtenerCursos(1);
                me.cerrarModal();
                me.limpiar();
            }).catch((error)=>{
                this.errors = error.response.data.errors;
            })
        },
        cerrarModal(){
            $('#modalCurso').modal('hide');
        },
        initial(){
            this.errors = [];
            this.tipoAccion = 1;
            this.tituloModal = 'Registrar Curso';
        },
    },
    mounted() {        
        this.obtenerCursos(1);
    },
}
</script>
<style >
    .p-text{
        margin-bottom: 0px !important;
    }
</style>