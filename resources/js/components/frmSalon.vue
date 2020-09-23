<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <!--  esto no borres sino se apega el contenido cuidau -->
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Salones
                    <button type="button" @click="abrirModal('salon','guardar')" class="btn btn-secondary" >
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" id="opcion" v-model="criterio">
                                <option value="nombre">Nombre</option>
                                <option value="descripcion">Descripcion</option>
                                </select>
                                <input type="text" v-model="buscar"  class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarSalon(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Foto</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Ubicacion</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="salon in arraySalon" :key="salon.id">
                                <td>
                                    <button type="button" @click="abrirModal('salon','actualizar',salon)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <template >
                                       <button type="button" class="btn-danger btn-sm" @click="eliminarSalon(salon.id)">
                                           <i class="icon-trash"></i>
                                       </button>
                                    </template>
                                </td>
                                <td v-text="salon.foto"></td>
                                <td v-text="salon.nombre"></td>
                                <td v-text="salon.descripcion"></td>
                                <td v-text="salon.ubicacion"></td>
                                <td v-text="salon.estado"></td>
                               
                            </tr>
                            
                        </tbody>
                    </table>
                    
                     <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar': modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Foto</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="foto" class="form-control" placeholder="foto">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="nombre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="descripcion" class="form-control" placeholder="descripcion">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Ubicacion</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="ubicacion" class="form-control" placeholder="ubicacion">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Estado</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="estado" class="form-control" placeholder="estado">
                                </div>
                            </div>
                            <div v-show="errorsalon" class="form-group row div - error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjsalon" :key="error" v-text="error" >
    
                                    </div>
                                </div>   
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="guardarSalon()" >Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarSalon()" >Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
        <!-- Inicio del modal Eliminar -->
    
        <!-- Fin del modal Eliminar -->

    </main>
</template>

<script>
    export default {
        data () {
            return {
                salon_id: 0,
                foto:'',
                nombre:'',
                descripcion: '',
                ubicacion: '',
                estado: '',
                arraySalon: [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorsalon : 0,
                errorMostrarMsjsalon :[],
                pagination :{
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 2,
                criterio : 'nombre',
                buscar : ''
                
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
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
        methods :{
            listarSalon(page,buscar,criterio){
                let me=this;
                var url= '/salon?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraySalon = respuesta.salon.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarSalon(page,buscar,criterio);
            },
            guardarSalon(){
                if (this.validarSalon()){
                    return;
                }
                let me = this;
                axios.post('/salon/guardar',{
                    'foto' : this.foto,
                    'nombre' : this.nombre,
                    'descripcion' : this.descripcion,
                    'ubicacion' : this.ubicacion,
                    'estado' : this.estado

                }) .then(function(response){
                    me.cerrarModal();
                    me.listarSalon(1,'','nombre');

                }).catch(function(error){
                    console.log(error);

                });

            },
            actualizarSalon(){
                 if (this.validarSalon()){
                    return;
                }
                let me = this;
                axios.put('/salon/actualizar',{
                    'foto' : this.foto,
                    'nombre' : this.nombre,
                    'descripcion' : this.descripcion,
                    'ubicacion' : this.ubicacion,
                    'estado' : this.estado,
                    'id': this.salon_id

                }) .then(function(response){
                    me.cerrarModal();
                    me.listarSalon(1,'','nombre');

                }).catch(function(error){
                    console.log(error);

                });
            },eliminarSalon(id){
                 swal({
                title: 'Esta seguro de eliminar este Salon?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.delete('/salon/eliminar_' + id,{
                        'id': id
                    }).then(function (response) {
                        me.listarSalon(1,'','nombre');
                        swal(
                        'Eliminado!',
                        'El registro ha sido eliminado con exito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            validarSalon(){
                this.errorsalon=0;
                this.errorMostrarMsjsalon=[];

                if (!this.nombre) this.errorMostrarMsjsalon.push("el nombre del Salon no puede estar vacio.");

                if (this.errorMostrarMsjsalon.length) this.errorsalon =1;

                return this.errorsalon;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.foto='';
                this.nombre='';
                this.descripcion='';
                this.ubicacion='';
                this.estado='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "salon": 
                    {
                        switch(accion){
                            case 'guardar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registar Salon';
                                this.foto = '';
                                this.nombre = '';
                                this.descripcion = '';
                                this.ubicacion='';
                                this.estado='';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar': 
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Salon';
                                this.tipoAccion=2;
                                this.salon_id=data['id'];
                                this.foto = data ['foto'];
                                this.nombre = data ['nombre'];
                                this.descripcion = data ['descripcion'];
                                this.ubicacion = data ['ubicacion'];
                                this.estado = data ['estado'];
                                break;
                            }
                        }

                    }
                }

            }
        },
        mounted() {
            this.listarSalon(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display :list-item !important;
        opacity : 1 !important;
        position : absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }

</style>>
