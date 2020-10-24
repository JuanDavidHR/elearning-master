<template>
    <main class="main">
        <div class="container-fluid mt-4">
            <div class="card mb-4">
                <template v-if="se_muestra">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-3 btn1">
                                <h6 class="mt-1">
                                    Gestión de Cuentas Por Cobrar
                                </h6>
                            </div>
                            <div class="col-md-4 btn1">
                                <div class="input-group">
                                    <input
                                        type="text"
                                        @keyup.enter="
                                            listarEgreso(1, buscar, mes, anho)
                                        "
                                        v-model="buscar"
                                        class="form-control document-nice"
                                        placeholder="Cuenta a buscar"
                                    />
                                    <button
                                        type="submit"
                                        @click.prevent="
                                            listarEgreso(1, buscar, mes, anho)
                                        "
                                        class="btn btn-primary btn-border"
                                    >
                                        <i class="fa fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 btn1">
                                <date-picker
                                    v-model="mesBuscar"
                                    type="month"
                                    value-type="date"
                                    format="MM-Y"
                                    @change="validateMes()"
                                    placeholder="Seleccionar mes"
                                ></date-picker>
                            </div>
                            <div class="col-md-2 d-flex btn1">
                                <button
                                    class="btn ml-auto nuevo btn-success"
                                    @click="nuevaDeuda()"
                                >
                                    Nueva Cuenta
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <template v-if="arrayViatico.length">
                                <div
                                    class="col-md-6 mb-2"
                                    v-for="viatico in arrayViatico"
                                    :key="viatico.idViatico"
                                >
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-12 d-flex">
                                                    <template>
                                                        <div class="noneBottom">
                                                            Días faltantes:
                                                            <span></span>
                                                        </div>
                                                    </template>
                                                    <template>
                                                        <div class="noneBottom">
                                                            Días excedentes:
                                                            <span> </span>
                                                        </div>
                                                    </template>
                                                    <div
                                                        class="btn-group ml-auto "
                                                        role="group"
                                                    >
                                                        <button
                                                            type="button"
                                                            class="btn btns mr-2 btn-warning btn-sm"
                                                        >
                                                            <i
                                                                class="icon-pencil"
                                                            ></i>
                                                        </button>
                                                        <button
                                                            type="button"
                                                            class="btn btns mr-2 btn-info btn-sm"
                                                        >
                                                            <i
                                                                class="fa fa-print"
                                                            ></i>
                                                        </button>
                                                        <template>
                                                            <button
                                                                type="button"
                                                                class="btn btns btn-success btn-sm"
                                                            >
                                                                <i
                                                                    class="icon-check"
                                                                ></i>
                                                            </button>
                                                        </template>
                                                        <template>
                                                            <button
                                                                type="button"
                                                                class="btn btns btn-danger btn-sm"
                                                            >
                                                                <i
                                                                    class="icon-trash"
                                                                ></i>
                                                            </button>
                                                        </template>
                                                    </div>
                                                </div>
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
                                        <div
                                            class="alert alert-danger"
                                            role="alert"
                                        >
                                            Aún no ha registrado cuentas por
                                            cobrar.
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                        <nav>
                            <ul class="pagination mb-0">
                                <li
                                    class="page-item"
                                    v-if="pagination.current_page > 1"
                                >
                                    <a
                                        class="page-link"
                                        href="#"
                                        @click.prevent="
                                            cambiarPagina(
                                                pagination.current_page - 1
                                            )
                                        "
                                        >Ant</a
                                    >
                                </li>
                                <li
                                    class="page-item"
                                    v-for="page in pagesNumber"
                                    :key="page"
                                    :class="[page == isActived ? 'active' : '']"
                                >
                                    <a
                                        class="page-link"
                                        href="#"
                                        @click.prevent="cambiarPagina(page)"
                                        v-text="page"
                                    ></a>
                                </li>
                                <li
                                    class="page-item"
                                    v-if="
                                        pagination.current_page <
                                            pagination.last_page
                                    "
                                >
                                    <a
                                        class="page-link"
                                        href="#"
                                        @click.prevent="
                                            cambiarPagina(
                                                pagination.current_page + 1
                                            )
                                        "
                                        >Sig</a
                                    >
                                </li>
                            </ul>
                        </nav>
                    </div>
                </template>
                <template v-else>
                    <div
                        class="card-header"
                        style="background-color:#7802E6!important;"
                    >
                        <div class="row justify-content-center mt-1 mb-3">
                            <h4 style="font-weight: bold; color: #fff;  ">
                                Cuentas por Cobrar
                            </h4>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div
                            class="col-md-2 mt-1 ml-auto justify-content-center"
                            style="display:flex;"
                        >
                            <h6>Fecha: {{ obtenerHora }}</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center mt-1 mb-3">
                            <div>
                                <h6 style="font-weight: bold;">
                                    Registrar Nueva Cuenta por Cobrar
                                </h6>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="" class="col-form-label"
                                        >Nombre del Cliente:</label
                                    >
                                </div>
                                <div class="col-md-4">
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="nombreCliente"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="" class="col-form-label"
                                        >N° de Recibo:</label
                                    >
                                </div>
                                <div class="col-md-4">
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="numRecibo"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="" class="col-form-label"
                                        >Fecha:</label
                                    >
                                </div>
                                <div class="col-md-4">
                                    <date-picker
                                        v-model="fechaRegistro"
                                        value-type="format"
                                        :clearable="false"
                                        format="DD-MM-YYYY"
                                    ></date-picker>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="" class="col-form-label"
                                        >Monto:</label
                                    >
                                </div>
                                <div class="col-md-4">
                                    <vue-numeric
                                        v-bind:minus="false"
                                        v-bind:precision="2"
                                        v-bind:min="0"
                                        v-bind:max="99999999.99"
                                        class="form-control"
                                        currency=""
                                        separator=","
                                        v-model="montoTotal"
                                    ></vue-numeric>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="" class="col-form-label"
                                        >Descripción</label
                                    >
                                </div>
                                <div class="col-md-4">
                                    <textarea
                                        name=""
                                        id=""
                                        cols="30"
                                        rows="10"
                                        class="form-control"
                                        v-model="descripcion"
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer mb-0">
                            <button
                                type="button"
                                class="btn regresar btns text-white btn-secondary ml-auto"
                                @click="(se_muestra = true), scrollBehavior"
                            >
                                Regresar
                            </button>
                            <button
                                v-if="tipoAccion == 1"
                                class="btn nuevo btn-success"
                                @click="registrarDeuda()"
                            >
                                Registrar Cuenta
                            </button>
                            <button
                                v-if="tipoAccion == 2"
                                class="btn nuevo btn-success"
                                @click="actualizarDeuda()"
                            >
                                Actualizar Cuenta
                            </button>
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
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import "vue2-datepicker/locale/es";
import vSelect from "vue-select";
import moment from "moment";
import "vue-select/dist/vue-select.css";
import VueNumeric from "vue-numeric";
export default {
    components: {
        DatePicker,
        vSelect,
        VueNumeric
    },
    data() {
        return {
            bord: true,
            mes: "",
            anho: "",
            cargando: false,
            buscar: "",
            mesBuscar: "",
            arrayViatico: [],
            documento_autorizacion: "",
            documento_solicitud: "",
            nombre_responsable: "",
            area: "",
            fechaSolicitud: "",
            fechaAutorizacion: "",
            fechaInicio: "",
            fechaFinal: "",
            fechaMaximo: "",
            tipo_actividad: "",
            validar: "",
            arrayArea: [],
            errors: {},
            resta: "",
            maximo: "",
            fecha: "",
            contador: 0,
            idArea: 0,
            cambia: true,
            descontar: 0,
            se_muestra: true,
            tipoAccion: 1,
            pagination: {
                total: 0,
                current_page: 0,
                per_page: 0,
                last_page: 0,
                from: 0, //desde la página
                to: 0 //hasta la página
            },
            offset: 3,
            nombreCliente: "",
            fechaRegistro: "",
            montTotal: 0,
            descripcion: ""
        };
    },
    computed: {
        isActived: function() {
            return this.pagination.current_page;
        },
        pagesNumber: function() {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + this.offset * 2;
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            var pagesArrays = [];
            while (from <= to) {
                pagesArrays.push(from);
                from++;
            }
            return pagesArrays;
        },
        obtenerHora() {
            return moment().format("DD-MM-YYYY");
        }
    },
    methods: {
        llenarFormulario(data) {
            this.tipoAccion = 2;
            this.idViatico = data["idViatico"];
            this.documento_autorizacion = data["documento_autorizacion"];
            this.documento_solicitud = data["documento_solicitud"];
            this.fechaSolicitud = this.usemoment(data["fecha_solicitud"]);
            this.fechaAutorizacion = this.usemoment(data["fecha_autorizacion"]);
            this.nombre_responsable = data["nombre_responsable"];
            this.idArea = data["idArea"];
            this.area = data["nombreArea"];
            this.fechaInicio = this.usemoment(data["fecha_inicio"]);
            this.fechaFinal = this.usemoment(data["fecha_final"]);
            this.monto_viatico = data["monto_viatico"];
            this.fechaMaximo = this.usemoment(data["fecha_maximo"]);
            this.se_muestra = false;
        },
        validateMes() {
            if (!this.mesBuscar) {
                this.mesBuscar = "";
                this.mes = "";
                this.anho = "";
            } else {
                this.mes = new Date(this.mesBuscar).getMonth() + 1;
                this.anho = new Date(this.mesBuscar).getFullYear();
            }
            this.listarEgreso(1, this.buscar, this.mes, this.anho);
        },
        nuevaDeuda() {
            this.tipoAccion = 1;
            this.se_muestra = false;
            this.interior();
            this.limpiar();
        },
        cambiarPagina(page) {
            let me = this;
            me.pagination.current_page = page;
            me.listarEgreso(page, me.buscar, me.mes, me.anho);
        },
        disableYear(date) {
            const year = new Date(date).getFullYear();
            year > 2040 || year < 2020;
            return year > 2040 || year < 2020;
        },
        usemoment: function(date) {
            return moment(date).format("DD-MM-YYYY");
        },
        savemoment: function(d) {
            if (d == null) {
                return "";
            } else {
                return d
                    .split("-")
                    .reverse()
                    .join("-");
            }
        },
        actualizarDeuda() {
            this.errors = [];
            let me = this;
            axios
                .post("/Viatico/actualizar", {
                    idViatico: this.idViatico,
                    idArea: this.idArea,
                    fecha_solicitud: me.savemoment(this.fechaSolicitud),
                    fecha_autorizacion: me.savemoment(this.fechaAutorizacion),
                    fecha_inicio: me.savemoment(this.fechaInicio),
                    fecha_final: me.savemoment(this.fechaFinal),
                    fecha_maximo: me.savemoment(this.fechaMaximo),
                    documento_solicitud: this.documento_solicitud,
                    tipo_actividad: this.tipo_actividad,
                    documento_autorizacion: this.documento_autorizacion,
                    nombre_responsable: this.nombre_responsable,
                    monto_viatico: this.monto_viatico
                })
                .then(function(response) {
                    me.limpiar();
                    me.buscar = "";
                    me.mesBuscar = "";
                    me.mes = "";
                    me.anho = "";
                    me.listarEgreso(1, me.buscar, me.mes, me.anho);
                    toastr.success("Viatico actualizado.");
                    me.se_muestra = true;
                })
                .catch(error => (this.errors = error.response.data.errors));
        },
        registrarDeuda() {
            this.errors = [];
            let me = this;
            axios
                .post("/Deuda/registrar", {
                    idDeuda: this.idDeuda,
                    nombreCliente: me.savemoment(this.nombreCliente),
                    numRecibo: me.savemoment(this.numRecibo),
                    fechaRegistro: me.savemoment(this.fechaRegistro),
                    montoTotal: this.montoTotal,
                    descripcion: me.savemoment(this.descripcion),
                    monto
                })
                .then(function(response) {
                    me.limpiar();
                    me.buscar = "";
                    me.mesBuscar = "";
                    toastr.success("Cuenta por cobrar registrada.");
                    me.se_muestra = true;
                })
                .catch(error => (this.errors = error.response.data.errors));
        },
        cambioEstado() {
            if (!this.area) {
                this.idArea = 0;
            } else {
                this.idArea = this.area.idArea;
            }
        },
        limpiar() {
            this.area = "";
            this.idArea = 0;
            this.documento_solicitud = "";
            this.documento_autorizacion = "";
            this.nombre_responsable = "";
            this.monto = 0;
            this.fechaSolicitud = "";
            this.fechaAutorizacion = "";
            this.fechaInicio = "";
            this.fechaMaximo = "";
            this.fechaFinal = "";
            this.cambia = true;
            this.errors = [];
        },
        listarEgreso(page, buscar, mes, anho) {
            let me = this;
            var url =
                "/Viatico?page=" +
                page +
                "&buscar=" +
                buscar +
                "&mes=" +
                mes +
                "&anho=" +
                anho;
            axios
                .get(url)
                .then(function(response) {
                    //obteniendo todo lo que envia el url, todo los registros
                    var respuesta = response.data;
                    me.arrayViatico = respuesta.viatico.data;
                    me.pagination = respuesta.pagination;
                    me.cargando = false;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        getProveedor() {
            let me = this;
            var url = "/Proveedor/getProveedor";
            axios
                .get(url)
                .then(function(response) {
                    var respuesta = response.data;
                    me.arrayProveedor = respuesta.proveedor;
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
    },
    mounted() {
        this.getProveedor();
        this.interior();
        this.selectArea();
        this.listarEgreso(1, this.buscar, this.mes, this.anho);
    }
};
</script>
<style>
.mx-datepicker {
    width: 100% !important;
}
.card {
    border-radius: 10px;
    margin-bottom: 0px;
}
.card-header {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    /*background-color: #56E396;*/
}
.fa-align-justify:before {
    color: whitesmoke !important;
}
.mod {
    background-color: #21b2fd;
    border-color: #21b2fd;
    color: black;
    margin-left: 20px;
    border-radius: 20px !important;
}
.mod:hover {
    background-color: #9e80ff;
    border-color: #9e80ff;
    color: white;
    border-radius: 20px;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.05);
}
.mods {
    border-radius: 10px;
}
.modle {
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
    color: #fff;
    background-color: #9e80ff !important;
}
.border {
    border-bottom-left-radius: 10px;
    border-top-left-radius: 10px;
}
.btn-border {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
}
.btns {
    border-radius: 10px !important;
}
.aux {
    white-space: normal !important;
    border-radius: 10px !important;
}
.estilo {
    font-weight: bold;
}
.vigente {
    background-color: #4caf50;
    color: #fff;
}
.nuevo {
    border-radius: 20px !important;
    background-color: #4caf50 !important;
    color: #fff;
}
.regresar {
    border-radius: 20px !important;
}
.pasado {
    background-color: #e53935;
    color: #fff;
}
label {
    margin-bottom: 0 !important;
}
.noneBottom {
    margin-top: 5px;
}
.borde {
    border: #000000 4px solid;
}
@media (max-width: 500px) {
    .asd {
        display: block;
        width: 100%;
        overflow-x: auto;
    }
    .btn1 {
        margin-bottom: 5px;
    }
}
label.col-form-label {
    margin-left: 40px;
}
</style>
