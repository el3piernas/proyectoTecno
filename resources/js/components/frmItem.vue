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
                    <i class="fa fa-align-justify"></i> Item
                    <button type="button" @click="abrirModal('item','guardar')" class="btn btn-secondary" >
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" id="opcion" v-model="criterio">
                                <option value="nombre">Nombre Item</option>
                                <option value="tabla">Nombre de la Tabla</option>
                                </select>
                                <input type="text" v-model="buscar"  class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarItem(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Foto</th>
                                <th>Descripcion</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                
                                <th>Tipo Item</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in arrayItem" :key="item.id">
                                <td>
                                    <button type="button" @click="abrirModal('item','actualizar',item)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <template >
                                       <button type="button" class="btn-danger btn-sm" @click="eliminarItem(item.id)">
                                           <i class="icon-trash"></i>
                                       </button>
                                    </template>
                                </td>
                                <td v-text="item.nombre"></td>
                                <td v-text="item.foto"></td>
                                <td v-text="item.descripcion"></td>
                                <td v-text="item.precio"></td>
                                <td v-text="item.stock"></td>
                                <td v-text="item.descripTpitem"></td>
                               
                               
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
                                    <input type="text" v-model="nombre" class="form-control" placeholder="nombre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Foto</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="foto" class="form-control" placeholder="foto">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Descripcion</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="descripcion" class="form-control" placeholder="descripcion">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Precio</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="precio" class="form-control" placeholder="precio">
                                </div>    
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Stock</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="stock" class="form-control" placeholder="stock">
                                </div>    
                            </div>
                            <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo Item</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="tipoitem_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="tipoitem in arraytipoitem" :key="tipoitem.id" :value="tipoitem.id" v-text="tipoitem.descripcion"></option>
                                        </select>                                        
                                    </div>
                                </div>
                            <div v-show="errorbitacora" class="form-group row div - error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjbitacora" :key="error" v-text="error" >
    
                                    </div>
                                </div>   
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="guardarItem()" >Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarItem()" >Actualizar</button>
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
                bitacora_id: 0,
                tipoitem_id: 0,
                nombre:'',
                foto: '',
                descripcion: '',
                precio: '',
                stock: '',
               arraytipoitem:[],
               arrayItem:[],
                arrayBitacora: [],
                arrayEmpleado: [],

                


                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorbitacora : 0,
                errorMostrarMsjbitacora :[],
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
            listarItem(page,buscar,criterio){
                let me=this;
                var url= '/item?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayItem = respuesta.item.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectTipoItem(){
                let me=this;
                var url= '/tipoitem/selectTipoItem';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arraytipoitem = respuesta.tipoitem;
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
                me.listarItem(page,buscar,criterio);
            },
            guardarItem(){
                // if (this.validarBitacora()){
                //     return;
                // }
                let me = this;
                axios.post('/item/registrar',{
                    'idTipoItem' : this.tipoitem_id,
                    'nombre' : this.nombre,
                    'foto' : this.foto,
                    'descripcion' : this.descripcion,
                    'precio' : this.precio,
                    'stock' : this.stock

                }) .then(function(response){
                    me.cerrarModal();
                    me.listarItem(1,'','fecha');

                }).catch(function(error){
                    console.log(error);

                });

            },
            actualizarItem(){
                //  if (this.validarBitacora()){
                //     return;
                // }
                let me = this;
                axios.put('/item/actualizar',{
                    'idTipoItem' : this.tipoitem_id,
                    'foto' : this.foto,
                    'nombre' : this.nombre,
                    'descripcion' : this.descripcion,
                    'precio' : this.precio,
                    'stock' : this.stock,
                    'id': this.item_id

                }) .then(function(response){
                    me.cerrarModal();
                    me.listarItem(1,'','fecha');

                }).catch(function(error){
                    console.log(error);

                });
            },eliminarItem(id){
                 swal({
                title: 'Esta seguro de eliminar este Item?',
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

                    axios.delete('/item/eliminar_' + id,{
                        'id': id
                    }).then(function (response) {
                        me.listarItem(1,'','fecha');
                        swal(
                        'Eliminado!',
                        'El registro ha sido eliminado con exito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                        /*CUANDO EL ITEM ESA RELACIONADO CON EL PAQUETE NO SE PUEDE ELIMINAR */
                        swal(
                        'Error!',
                        'No se elimino porque el item esta en un paquete',
                        'error'
                        )
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            validarBitacora(){
                this.errorbitacora=0;
                this.errorMostrarMsjbitacora=[];

                if (!this.fecha) this.errorMostrarMsjbitacora.push("la fecha de la Bitacora no puede estar vacio.");

                if (this.errorMostrarMsjbitacora.length) this.errorbitacora =1;

                return this.errorbitacora;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.fecha='';
                this.hora='';
                this.tabla='';
                this.codigoTabla='';
                this.transaccion='';
                this.empleado_id=0;
                this.errorbitacora=0;

            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "item": 
                    {
                        switch(accion){
                            case 'guardar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registar Item';
                                this.tipoitem_id=0;
                                this.nombre = '';
                                this.foto = '';
                                this.descripcion='';
                                this.precio='';
                                this.stock='';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar': 
                            {
                                //console.log(data);
                                this.modal=1;
                                 this.tituloModal='Actualizar Item';
                                this.tipoAccion=2;
                          // DATOS DEL ITEM A MODIFICAR
                                this.item_id=data ['id'];
                                this.tipoitem_id= data ['idTipoItem'];
                                this.nombre=data ['nombre'];
                                this.foto=data ['foto'];
                                this.descripcion=data ['descripcion'];
                                this.precio=data ['precio'];
                                this.stock=data ['stock'];

                               
                                // this.bitacora_id=data['id'];
                                // this.empleado_id=data['idEmpleado'];
                                // this.fecha = data ['fecha'];
                                // this.hora = data ['hora'];
                                // this.tabla = data ['tabla'];
                                // this.codigoTabla = data ['codigoTabla'];
                                // this.transaccion = data ['transaccion'];
                                break;
                            }
                        }

                    }
                }
                this.selectTipoItem();

            }
        },
        mounted() {
            this.listarItem(1,this.buscar,this.criterio);
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
