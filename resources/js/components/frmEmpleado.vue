<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <!-- coño esto no borres sino se apega el contenido cuidau -->
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Empleado
                    <button type="button" @click="abrirModal('empleado','guardar')" class="btn btn-secondary" >
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" id="opcion" v-model="criterio">
                                <option value="nombre">Nombre</option>
                                </select>
                                <input type="text" v-model="buscar"  class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarEmpleado(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Ci</th>
                                <th>Telefono</th>
                                <th>Usuario</th>
                                <th>Password</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="empleado in arrayEmpleado" :key="empleado.id">
                                <td>
                                    <button type="button" @click="abrirModal('empleado','actualizar',empleado)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <template >
                                       <button type="button" class="btn-danger btn-sm" @click="eliminarEmpleado(empleado.id)">
                                           <i class="icon-trash"></i>
                                       </button>
                                    </template>
                                </td>
                                
                                <td v-text="empleado.nombre"></td>
                                <td v-text="empleado.apellido"></td>
                                <td v-text="empleado.ci"></td>
                                <td v-text="empleado.telefono"></td>
                                <td v-text="empleado.usuario"></td>
                                <td v-text="empleado.password"></td>
                               
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
        <!--Inicio del modal agregar/actualizar/ y Nuevo-->
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
                                <label class="col-md-3 form-control-label" for="email-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="nombre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Apellido</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="apellido" class="form-control" placeholder="apellido">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Ci</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="ci" class="form-control" placeholder="ci">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Telefono</label>
                                <div class="col-md-9">
                                    <input type="number" v-model="telefono" class="form-control" placeholder="telefono">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Usuario</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="usuario" class="form-control" placeholder="usuario">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Password</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="password" class="form-control" placeholder="password">
                                </div>
                            </div>
                            <div v-show="errorempleado" class="form-group row div - error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjempleado" :key="error" v-text="error" >
    
                                    </div>
                                </div>   
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="guardarEmpleado()" >Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarEmpleado()" >Actualizar</button>
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
                empleado_id: 0,
                nombre: '',
                apellido: '',
                ci: '',
                telefono: '',
                usuario: '',
                password: '',
                arrayEmpleado: [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorempleado : 0,
                errorMostrarMsjempleado :[],
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
            listarEmpleado(page,buscar,criterio){
                let me=this;
                var url= '/empleado?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayEmpleado = respuesta.empleado.data;
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
                me.listarEmpleado(page,buscar,criterio);
            },
            guardarEmpleado(){
                if (this.validarEmpleado()){
                    return;
                }
                let me = this;
                axios.post('/empleado/guardar',{
                 
                    'nombre' : this.nombre,
                    'apellido' : this.apellido,
                    'ci' : this.ci,
                    'telefono' : this.telefono,
                    'usuario' : this.usuario,
                    'password' : this.password


                }) .then(function(response){
                    me.cerrarModal();
                    me.listarEmpleado(1,'','nombre');

                }).catch(function(error){
                    console.log(error);

                });

            },
            actualizarEmpleado(){
                 if (this.validarEmpleado()){
                    return;
                }
                let me = this;
                axios.put('/empleado/actualizar',{
                   
                    'nombre' : this.nombre,
                    'apellido' : this.apellido,
                    'ci' : this.ci,
                    'telefono' : this.telefono,
                    'usuario' : this.usuario,
                    'password' : this.password,
                    'id': this.empleado_id

                }) .then(function(response){
                    me.cerrarModal();
                    me.listarEmpleado(1,'','nombre');

                }).catch(function(error){
                    console.log(error);

                });
            },eliminarEmpleado(id){
                 swal({
                title: 'Esta seguro de eliminar este Empleado?',
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

                    axios.delete('/empleado/eliminar_' + id,{
                        'id': id
                    }).then(function (response) {
                        me.listarEmpleado(1,'','nombre');
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
            validarEmpleado(){
                this.errorempleado=0;
                this.errorMostrarMsjempleado =[];

                if (!this.nombre) this.errorMostrarMsjempleado.push("La descripcion del Empleado no puede estar vacio.");

                if (this.errorMostrarMsjempleado.length) this.errorempleado =1;

                return this.errorempleado;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.apellido='';
                this.ci='';
                this.telefono='';
                this.usuario='';
                this.password='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "empleado": 
                    {
                        switch(accion){
                            case 'guardar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Empleado';
                                this.tipoAccion = 1;
                                this.nombre='';
                                this.apellido='';
                                this.ci='';
                                this.telefono='';
                                this.usuario='';
                                this.password='';
                                break;
                            }
                            case 'actualizar': 
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Empleado';
                                this.tipoAccion=2;
                                this.empleado_id=data['id'];
                                this.nombre = data ['nombre'];
                                this.apellido = data ['apellido'];
                                this.ci = data ['ci'];
                                this.telefono = data ['telefono'];
                                this.usuario = data ['usuario'];
                                this.password = data ['password'];
                                break;
                            }
                        }

                    }
                }

            }
        },
        mounted() {
            this.listarEmpleado(1,this.buscar,this.criterio);
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
