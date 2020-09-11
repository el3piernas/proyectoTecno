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
                    <i class="fa fa-align-justify"></i> Clientes
                    <button type="button" @click="abrirModal('cliente','guardar')" class="btn btn-secondary" >
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" id="opcion" v-model="criterio">
                                <option value="apellido">Apellido</option>
                                </select>
                                <input type="text" v-model="buscar"  class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarCliente(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Ci</th>
                                <th>Dirección</th>
                                <th>Telefono</th>
                                <th>Usuario</th>
                                <th>Password</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="cliente in arrayCliente" :key="cliente.id">
                                <td>
                                    <button type="button" @click="abrirModal('cliente','actualizar',cliente)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <template >
                                       <button type="button" class="btn-danger btn-sm" @click="eliminarCliente(cliente.id)">
                                           <i class="icon-trash"></i>
                                       </button>
                                    </template>
                                </td>
                                
                                <td v-text="cliente.nombre"></td>
                                <td v-text="cliente.apellido"></td>
                                <td v-text="cliente.ci"></td>
                                <td v-text="cliente.direccion"></td>
                                <td v-text="cliente.telefono"></td>
                                <td v-text="cliente.usuario"></td>
                                <td v-text="cliente.password"></td>
                               
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
                                <label class="col-md-3 form-control-label" for="email-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Apellido</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="apellido" class="form-control" placeholder="Apellido">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Ci</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="ci" class="form-control" placeholder="Ci">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Dirección</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="direccion" class="form-control" placeholder="Dirección">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Telefono</label>
                                <div class="col-md-9">
                                    <input type="number" v-model="telefono" class="form-control" placeholder="Telefono">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Usuario</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="usuario" class="form-control" placeholder="Usuario">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Password</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <div v-show="errorCliente" class="form-group row div - error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjCliente" :key="error" v-text="error" >
    
                                    </div>
                                </div>   
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="guardarCliente()" >Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarCliente()" >Actualizar</button>
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
                cliente_id: 0,
                nombre: '',
                apellido: '',
                ci: '',
                direccion: '',
                telefono: '',
                usuario: '',
                password: '',
                arrayCliente: [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorCliente : 0,
                errorMostrarMsjCliente :[],
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
            listarCliente(page,buscar,criterio){
                let me=this;
                var url= '/cliente?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCliente = respuesta.cliente.data;
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
                me.listarCliente(page,buscar,criterio);
            },
            guardarCliente(){
                if (this.validarCliente()){
                    return;
                }
                let me = this;
                axios.post('/cliente/guardar',{
                 
                    'nombre' : this.nombre,
                    'apellido' : this.apellido,
                    'ci' : this.ci,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'usuario' : this.usuario,
                    'password' : this.password

                }) .then(function(response){
                    me.cerrarModal();
                    me.listarCliente(1,'','nombre');

                }).catch(function(error){
                    console.log(error);

                });

            },
            actualizarCliente(){
                 if (this.validarCliente()){
                    return;
                }
                let me = this;
                axios.put('/cliente/actualizar',{
                    'nombre' : this.nombre,
                    'apellido' : this.apellido,
                    'ci' : this.ci,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'usuario' : this.usuario,
                    'password' : this.password,
                    'id': this.cliente_id,

                }) .then(function(response){
                    me.cerrarModal();
                    me.listarCliente(1,'','nombre');

                }).catch(function(error){
                    console.log(error);

                });
            },eliminarCliente(id){
                 swal({
                title: 'Esta seguro de eliminar este Cliente?',
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

                    axios.delete('/cliente/eliminar_' + id,{
                        'id': id
                    }).then(function (response) {
                        me.listarCliente(1,'','descripcion');
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
            validarCliente(){
                this.errorCliente=0;
                this.errorMostrarMsjCliente =[];

                if (!this.nombre) this.errorMostrarMsjCliente.push("La descripcion del Cliente no puede estar vacio.");

                if (this.errorMostrarMsjCliente.length) this.errorCliente =1;

                return this.errorCliente;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.apellido='';
                this.ci='';
                this.telefono='';
                this.direccion='';
                this.usuario='';
                this.password='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "cliente": 
                    {
                        switch(accion){
                            case 'guardar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registar Cliente';
                                this.nombre = '';
                                this.apellido = '';
                                this.ci = '';
                                this.direccion = '';
                                this.telefono = '';
                                this.usuario = '';
                                this.password = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar': 
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Cliente';
                                this.tipoAccion=2;
                                this.cliente_id=data['id'];
                                this.nombre = data ['nombre'];
                                this.apellido = data ['apellido'];
                                this.ci = data ['ci'];
                                this.direccion = data ['direccion'];
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
            this.listarCliente(1,this.buscar,this.criterio);
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
