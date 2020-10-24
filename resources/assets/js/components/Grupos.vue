<template>
    <main class="main">
        &nbsp;
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>Gestión de Grupos
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select
                                    class="form-control col-md-3"
                                    v-model="criterio"
                                >
                                    <option value="nombre">Nombre</option>
                                </select>
                                <input
                                    type="text"
                                    v-model="buscar"
                                    @keyup.enter="
                                        listarGrupo(1, buscar, criterio)
                                    "
                                    class="form-control"
                                    placeholder="Texto a buscar"
                                />
                                <button
                                    type="submit"
                                    @click="listarGrupo(1, buscar, criterio)"
                                    class="btn btn-primary"
                                >
                                    <i class="fa fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table
                            class="table table-bordered table-striped table-sm"
                        >
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="persona in arrayPersona"
                                    :key="persona.id"
                                >
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button
                                                type="button"
                                                @click="
                                                    abrirModal(
                                                        'persona',
                                                        'actualizar',
                                                        persona
                                                    )
                                                "
                                                class="btn btns btn-warning btn-sm"
                                            >
                                                <i class="icon-pencil"></i>
                                            </button>
                                            &nbsp;
                                            <template v-if="persona.vigencia">
                                                <button
                                                    type="button"
                                                    class="btn btns btn-danger btn-sm"
                                                    @click="
                                                        desactivarPersona(
                                                            persona.id
                                                        )
                                                    "
                                                >
                                                    <i class="icon-trash"></i>
                                                </button>
                                            </template>
                                            <template v-else>
                                                <button
                                                    type="button"
                                                    class="btn btns btn-info btn-sm"
                                                    @click="
                                                        activarPersona(
                                                            persona.id
                                                        )
                                                    "
                                                >
                                                    <i class="icon-check"></i>
                                                </button>
                                            </template>
                                        </div>
                                    </td>

                                    <td v-text="persona.nombre"></td>
                                    <td v-text="persona.descripcion"></td>
                                    <td>
                                        <div v-if="persona.vigencia">
                                            <span class="badge badge-success"
                                                >Activo</span
                                            >
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger"
                                                >Desactivado</span
                                            >
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <nav>
                        <ul class="pagination">
                            <li
                                class="page-item"
                                v-if="pagination.current_page > 1"
                            >
                                <a
                                    class="page-link"
                                    href="#"
                                    @click.prevent="
                                        cambiarPagina(
                                            pagination.current_page - 1,
                                            buscar,
                                            criterio
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
                                    @click.prevent="
                                        cambiarPagina(page, buscar, criterio)
                                    "
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
                                            pagination.current_page + 1,
                                            buscar,
                                            criterio
                                        )
                                    "
                                    >Sig</a
                                >
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div
            class="modal fade"
            tabindex="-1"
            id="ModalCliente"
            role="dialog"
            aria-labelledby="myModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-primary modal-lg">
                <div class="modal-content mods">
                    <div class="modal-header modle">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label
                                class="col-md-3 form-control-label"
                                for="text-input"
                                >Nombre Grupo</label
                            >
                            <div class="col-md-9">
                                <input
                                    type="text"
                                    v-model="nombreGrupo"
                                    class="form-control"
                                    placeholder="Nombre Grupo"
                                />
                                <small
                                    v-if="errors.nombre"
                                    class="text-danger"
                                    v-text="errors.nombre[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label
                                class="col-md-3 form-control-label"
                                for="text-input"
                                >Descripcion</label
                            >
                            <div class="col-md-9">
                                <input
                                    type="text"
                                    v-model="descripcionGrupo"
                                    class="form-control"
                                    placeholder="Descripcion"
                                />
                                <small
                                    v-if="errors.num_documento"
                                    class="text-danger"
                                    v-text="errors.num_documento[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label
                                class="col-md-3 form-control-label"
                                for="text-input"
                                >Inicial</label
                            >
                            <div class="col-md-9">
                                <input
                                    type="text"
                                    v-model="descripcionGrupo"
                                    class="form-control"
                                    placeholder="Descripcion"
                                />
                                <small
                                    v-if="errors.num_documento"
                                    class="text-danger"
                                    v-text="errors.num_documento[0]"
                                ></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label
                                class="col-md-3 form-control-label"
                                for="email-input"
                                >Usuario</label
                            >
                            <div class="col-md-9">
                                <input
                                    type="text"
                                    v-model="usuario"
                                    class="form-control"
                                    placeholder="Nombre de Usuario"
                                />
                                <small
                                    v-if="errors.usuario"
                                    class="text-danger"
                                    v-text="errors.usuario[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label
                                class="col-md-3 form-control-label"
                                for="email-input"
                                >Contraseña</label
                            >
                            <div class="col-md-9">
                                <input
                                    type="password"
                                    v-model="password"
                                    class="form-control"
                                    placeholder="password"
                                />
                                <small
                                    v-if="errors.password"
                                    class="text-danger"
                                    v-text="errors.password[0]"
                                ></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label
                                class="col-md-3 form-control-label"
                                for="email-input"
                                >Rol</label
                            >
                            <div class="col-md-9">
                                <select class="form-control" v-model="idRoles">
                                    <option value="0">
                                        Seleccione un Rol
                                    </option>
                                    <option
                                        v-for="rol in arrayRol"
                                        :key="rol.idRoles"
                                        :value="rol.idRoles"
                                        v-text="rol.nombre"
                                    ></option>
                                </select>
                                <small
                                    v-if="errors.idRoles"
                                    class="text-danger"
                                    v-text="errors.idRoles[0]"
                                ></small>
                            </div>
                        </div>
                        <div
                            v-show="errorPersona"
                            class="form-group row div-error"
                        >
                            <div class="text-center text-error">
                                <div
                                    v-for="error in errorMostrarMsjPersona"
                                    :key="error"
                                    v-text="error"
                                ></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input
                            type="submit"
                            class="btn btns btn-secondary"
                            data-dismiss="modal"
                            @click="cerrarModal('persona')"
                            value="Cerrar"
                        />
                        <input
                            type="submit"
                            v-if="tipoAccion == 1"
                            class="btn btns btn-primary"
                            @click="registrarPersona()"
                            value="Registrar"
                        />
                        <input
                            type="submit"
                            v-if="tipoAccion == 2"
                            class="btn btns btn-primary"
                            @click="actualizarPersona()"
                            value="Actualizar"
                        />
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
            persona_id: 0,
            nombre: "",
            tipo_documento: "DNI",
            num_documento: "",
            direccion: "",
            telefono: "",
            email: "",
            usuario: "",
            password: "",
            idRoles: 0,
            vigencia: 0,
            arrayRol: [],
            arrayPersona: [],
            modal: 0,
            tituloModal: "",
            tipoAccion: 0,
            errorPersona: 0,
            errorMostrarMsjPersona: [],
            errors: [],
            pagination: {
                total: 0,
                current_page: 0,
                per_page: 0,
                last_page: 0,
                from: 0,
                to: 0
            },
            offset: 3,
            criterio: "nombre",
            buscar: ""
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
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },
    methods: {
        listarGrupo(page, buscar, criterio) {
            let me = this;
            var url =
                "/grupos?page=" +
                page +
                "&buscar=" +
                buscar +
                "&criterio=" +
                criterio;
            axios
                .get(url)
                .then(function(response) {
                    var respuesta = response.data;
                    me.arrayPersona = respuesta.grupos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        cambiarPagina(page, buscar, criterio) {
            let me = this;
            me.pagination.current_page = page;
            me.listarGrupos(page, buscar, criterio);
        },
        actualizarGrupo() {
            let me = this;
            axios
                .put("/grupos/actualizar", {
                    nombreGrupo: this.nombreGrupo,
                    descripcionGrupo: this.descripcionGrupo,
                    email: this.email,
                    vigencia: this.vigencia
                })
                .then(function(response) {
                    console.log(response);
                    toastr.success("Registro Actualizado");
                    me.cerrarModal();
                    me.listarGrupo(1, "", "nombre");
                })
                .catch(error => (this.errors = error.response.data.errors));
        },
        desactivarGrupo(idGrupo) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons
                .fire({
                    title: "¿Está seguro de Desactivar este Grupo?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Aceptar!",
                    cancelButtonText: "Cancelar",
                    reverseButtons: true
                })
                .then(result => {
                    if (result.value) {
                        let me = this;
                        axios
                            .put("/grupos/desactivar", {
                                idGrupo: idGrupo
                            })
                            .then(function(response) {
                                me.listarPersona(1, "", "");
                            })
                            .catch(function(error) {
                                console.log(error);
                            });
                        swalWithBootstrapButtons.fire(
                            "Descativado",
                            "El Grupo ha sido Desactivado Exitosamente.",
                            "success"
                        );
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                    }
                });
        },
        activarGrupo(idGrupo) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons
                .fire({
                    title: "¿Está seguro de Ativar este Usuario?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Aceptar!",
                    cancelButtonText: "Cancelar",
                    reverseButtons: true
                })
                .then(result => {
                    if (result.value) {
                        let me = this;
                        axios
                            .put("/user/activar", {
                                idPersona: idPersona
                            })
                            .then(function(response) {
                                me.listarGrupo(1, "", "");
                            })
                            .catch(function(error) {
                                console.log(error);
                            });
                        swalWithBootstrapButtons.fire(
                            "Activado",
                            "El Grupo ha sido Activado Exitosamente.",
                            "success"
                        );
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                    }
                });
        },
        cerrarModal() {
            $("#ModalCliente").modal("hide");
            this.tituloModal = "";
            this.nombre = "";
            this.tipo_documento = "RUC";
            this.num_documento = "";
            this.direccion = "";
            this.telefono = "";
            this.email = "";
            this.vigencia = 0;
            this.errorPersona = 0;
        },
        abrirModal(modelo, accion, data = []) {
            switch (modelo) {
                case "grupos": {
                    switch (accion) {
                        case "registrar": {
                            $("#ModalCliente").modal("show");
                            this.errors = [];
                            this.tituloModal = "Registrar Grupo";
                            this.nombreGrupo = "";
                            this.descripcionGrupo = "";
                            this.inicialGrupo = "";
                            this.vigencia = 1;
                            this.tipoAccion = 1;
                            break;
                        }
                        case "actualizar": {
                            $("#ModalCliente").modal("show");
                            this.errors = [];
                            this.tituloModal = "Actualizar Grupo";
                            this.tipoAccion = 2;
                            this.persona_id = data["id"];
                            this.nombre = data["nombre"];
                            this.tipo_documento = data["tipo_documento"];
                            this.num_documento = data["num_documento"];
                            this.direccion = data["direccion"];
                            this.telefono = data["telefono"];
                            this.email = data["email"];
                            this.vigencia = data["vigencia"];
                            this.usuario = data["usuario"];
                            this.password = "";
                            this.idRoles = data["idRoles"];
                            break;
                        }
                    }
                }
            }
        }
    },
    mounted() {
        this.listarPersona(1, this.buscar, this.criterio);
        this.selectRol();
    }
};
</script>
<style>
.modal-content {
    width: 100% !important;
    position: absolute !important;
}
.mostrar {
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297a !important;
}
.div-error {
    display: flex;
    justify-content: center;
}
.text-error {
    color: red !important;
    font-weight: bold;
}
</style>
