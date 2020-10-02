@extends('index')
@section('contenido')
    <template v-if="menu==0">
        <h1>reservas</h1>
    </template>  
    <template v-if="menu==1">
       <frmnotaservicio-component></frmnotaservicio-component>
    </template>
    <template v-if="menu==2">
        <frmpaquete-component></frmpaquete-component>
    </template> 
    <template v-if="menu==3">
        <frmtipopaquete-component></frmtipopaquete-component>
    </template> 
    <template v-if="menu==4">
        <frmsalon-component></frmsalon-component>
    </template> 
    <template v-if="menu==5">
        <frmbitacora-component></frmbitacora-component>
    </template> 
    <template v-if="menu==6">
       <frmitem-component></frmitem-component>
    </template> 
    <template v-if="menu==7">
        <frmtipoitem-component></frmtipoitem-component>
    </template> 
    <template v-if="menu==8">
        <frmempleado-component></frmempleado-component>
        
    </template> 
    <template v-if="menu==9">
        <frmcliente-component></frmcliente-component>
    </template> 
    <template v-if="menu==10">
        <frmreserva-component></frmreserva-component>
    </template>       

@endsection