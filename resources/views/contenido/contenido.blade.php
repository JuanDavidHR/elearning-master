@extends('principal')
@section('contenido')
    @if(Auth::check())
        @if (Auth::user()->idroles==1)
            <template v-if="menu==0">
            </template>
            <template v-if="menu==100">
                <proveedor/>
            </template>
            <template v-if="menu==1000">
                <laboratorio/>
            </template>
            <template v-if="menu==1001">
                <tipomedicamento/>
            </template>
            <template v-if="menu==1002">
                <presentacion/>
            </template>
            <template v-if="menu==1003">
                <medicamento/>
            </template>
            <template v-if="menu==1004">
                <botica/>
            </template>
            <template v-if="menu==1005">
                <detallepresentacion/>
            </template>
            <template v-if="menu==1006">
                <detallemedicamento/>
            </template>
            <template v-if="menu==200">
                <curso></curso>
            </template>
            <template v-if="menu==300">
                <lugar></lugar>
            </template>
            <template v-if="menu==5">
                <certificado></certificado>
            </template>
            <template v-if="menu==6">
                <parametros></parametros>
            </template>
            <template v-if="menu==7">
                <precios></precios>
            </template>
            <template v-if="menu==10">
                <grupos></grupos>
            </template>
            <template v-if="menu==2000">
                <escuela/>
            </template>
            <template v-if="menu==3000">
                <categoria/>
            </template>
            <template v-if="menu==12">
                <user></user>
            </template>
            <template v-if="menu==90">
                <lote-01></lote-01>
            </template>
            <template v-if="menu==91">
                <h1>Nel</h1>
            </template>
            <template v-if="menu==84">
                <adquirido />
            </template>
            <template v-if="menu==85">
                <caja />
            </template>
            <template v-if="menu==86">
                <materiap />
            </template>
            <template v-if="menu==87">
                <recepcion />
            </template>
            <template v-if="menu==89">
                <compras />
            </template>
            <template v-if="menu==70">
                <pergamino />
            </template>
            <template v-if="menu==71">
                <coco />
            </template>
            <template v-if="menu==72">
                <cashapa />
            </template>
            <template v-if="menu==73">
                <cacao />
            </template>
            <template v-if="menu==60">
                <proveedor />
            </template>
            <template v-if="menu==88">
                <h1>Ventas</h1>
            </template>
            
            
        @elseif (Auth::user()->idroles==2)
        <template v-if="menu==0">
            </template>
            <template v-if="menu==1">
                <categoriaMuni></categoriaMuni>
            </template>
            <template v-if="menu==2">
                <viaticoMuni></viaticoMuni>
            </template>
            <template v-if="menu==3">
                <fielMuni></fielMuni>
            </template>
            <template v-if="menu==4">
                <adelantoMuni></adelantoMuni>
            </template>
            <template v-if="menu==5">
                <materialesMuni></materialesMuni>
            </template>
        @elseif (Auth::user()->idroles==3)
        <template v-if="menu==0">
            </template>
            <template v-if="menu==1">
                <categoria></categoria>
            </template>
            <template v-if="menu==2">
                <viatico></viatico>
            </template>
            <template v-if="menu==3">
                <fiel></fiel>
            </template>
            <template v-if="menu==4">
                <adelanto></adelanto>
            </template>
            <template v-if="menu==5">
                <materiales></materiales>
            </template>
        @else
        @endif
    @endif
@endsection
