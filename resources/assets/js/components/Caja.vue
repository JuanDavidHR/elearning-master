<template>
    <main class="main">
        <div class="container-fluid mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between">
                            <h4>Caja Chica</h4>
                            <!-- <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#guardarCorriente">
                                <i style="font-size: 15px;" class="feather icon-file-text"></i>
                            </button> -->
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center" v-if="visible">
                        <div class="col-md-6">
                            <p class="text-p">Apertura de caja</p>
                            <vue-numeric v-bind:minus ="false"  v-bind:precision="0" v-bind:min = "0" v-bind:max = "999999" class="form-control"  currency="" separator="," v-model="dinero"></vue-numeric>
                            <button class="btn mt-1 btn-success" @click="aperturaCaja()">
                                Aperturar
                            </button>
                        </div>
                    </div>
                    <div class="d-flex" v-if="!visible">
                        <div class="col-md-4">
                            {{detalle}}
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
                idCaja : '',
                dinero : 0,
                caja : [],
                detalle : [],
                visible : false
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
            aperturaCaja(){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn ml-1 btn-danger'
                },
                buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: '¿Desea aperturar la Caja con '+ this.dinero + ' ?' ,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        axios.post('/Caja/apertura',{
                            'idCaja' : this.idCaja, 
                            'monto' : this.dinero
                        }).then((response)=>{
                            toastr.success('Se aperturó la Caja con ' + this.dinero)
                            this.mostrarCaja();
                        }).catch((error)=>{
                            console.log(erorr);
                        })
                        swalWithBootstrapButtons.fire(
                        'Éxito',
                        'La Caja se aperturó con éxito.',
                        'success')
                    }else if ( result.dismiss === Swal.DismissReason.cancel) {}
                })
                
            },
            convert(number){
                let val = (number/1).toFixed(2).replace(',', '.');
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            disableYear(date){
                const year = new Date(date).getFullYear(); (year>2040 || year <2020)
                return(year>2040 || year <2020);
            },
            savemoment : function(d){
                if(d == null){  
                    return '';
                }else{
                    return d.split("-").reverse().join("-");
                }
            },
            usemoment: function(date){
                return moment(date).format("DD-MM-YYYY");
            },
            mostrarCaja(){
                let me = this;
                var url = '/Caja'
                axios.get(url).then((response)=>{
                    me.caja = response.data.caja[0];
                    me.idCaja = me.caja.idCaja;
                    response.data.caja.length == 1 ? me.visible = false : me.visible = true;
                    me.mostrarDetalle();
                }).catch((error)=>{
                    console.log(error);
                })
            },
            mostrarDetalle(){
                if(!this.visible){
                    var url = '/Caja/detalle?idCaja='+this.idCaja;
                    axios.get(url).then((response)=>{
                        this.detalle = response.data.movimiento[0];
                    }).catch((error)=>{
                        console.log(error);
                    })  
                }
            }
        },
        mounted() {
            this.mostrarCaja();
            
        },
        created() {
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
        },
    }
</script>
<style>

</style>

