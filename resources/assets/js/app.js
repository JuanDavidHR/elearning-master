/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);
Vue.component("cashapa", require("./components/Cashapa.vue").default);
Vue.component("cacao", require("./components/Cacao.vue").default);
Vue.component("coco", require("./components/Coco.vue").default);
Vue.component("pergamino", require("./components/Pergamino.vue").default);
Vue.component("parametros", require("./components/Parametros.vue").default);
Vue.component("precios", require("./components/Precios.vue").default);
Vue.component("lote-01", require("./components/Lote01.vue").default);
Vue.component("compras", require("./components/Compras.vue").default);
Vue.component("recepcion", require("./components/Recepcion.vue").default);
Vue.component("materiap", require("./components/PagoMateria.vue").default);
Vue.component("adquirido", require("./components/Adquirido.vue").default);
Vue.component("caja", require("./components/Caja.vue").default);
Vue.component("proveedor", require("./components/Proveedor.vue").default);
Vue.component("pagar", require("./components/Pagar.vue").default);

Vue.component("categoria", require("./components/Categoria.vue").default);
Vue.component("rol", require("./components/Rol.vue").default);
Vue.component("user", require("./components/User.vue").default);
Vue.component("viatico", require("./components/Viatico.vue").default);
Vue.component("fiel", require("./components/FielCumplimiento.vue").default);
Vue.component("adelanto", require("./components/Adelanto.vue").default);
Vue.component("materiales", require("./components/Materiales.vue").default);
Vue.component("grupos", require("./components/Grupos.vue").default);
Vue.component("curso", require("./components/Curso.vue").default);
Vue.component("lugar", require("./components/Lugar.vue").default);
Vue.component("escuela", require("./components/Escuela.vue").default);
Vue.component("laboratorio", require("./components/Laboratorio.vue").default);
Vue.component("tipomedicamento", require("./components/TipoMedicamento.vue").default);
Vue.component("presentacion", require("./components/Presentacion.vue").default);
Vue.component("medicamento", require("./components/Medicamento.vue").default);
Vue.component("botica", require("./components/Botica.vue").default);
Vue.component("detallepresentacion", require("./components/DetallePresentacion.vue").default)
//--------------------------
Vue.component(
    "categoriamuni",
    require("./components/EncargosMuni.vue").default
);
Vue.component("viaticomuni", require("./components/ViaticoMuni.vue").default);
Vue.component(
    "fielmuni",
    require("./components/FielCumplimientoMuni.vue").default
);
Vue.component("adelantomuni", require("./components/AdelantoMuni.vue").default);
Vue.component(
    "materialesmuni",
    require("./components/MaterialesMuni.vue").default
);

Vue.component("deuda", require("./components/Deuda.vue").default);

const app = new Vue({
    el: "#app",
    data: {
        menu: 0,
    },
});
