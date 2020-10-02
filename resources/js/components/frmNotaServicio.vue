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
          <i class="fa fa-align-justify"></i>Nota de Servicio
          <button type="button" @click="abrirDatos()" class="btn btn-secondary">
            <i class="icon-plus"></i>&nbsp;Nuevo
          </button>
        </div>
        <template v-if="listarRegistro">
          <div class="card-body">
            <div class="form-group row">
              <div class="col-md-6">
                <div class="input-group">
                  <select class="form-control col-md-3" id="opcion" v-model="criterio">
                    <option value="nombre">Nombre Cliente</option>
                  </select>
                  <input
                    type="text"
                    v-model="buscar"
                    class="form-control"
                    placeholder="Texto a buscar"
                  />
                  <button
                    type="submit"
                    @click="listarNotaSevicio(1,buscar,criterio)"
                    class="btn btn-primary"
                  >
                    <i class="fa fa-search"></i> Buscar
                  </button>
                </div>
              </div>
            </div>
            <table class="table table-bordered table-striped table-sm">
              <thead>
                <tr>
                  <th>Opciones</th>
                  <th>Id</th>
                  <th>Fecha</th>
                  <th>Fecha Inicio</th>
                  <th>Fecha Final</th>
                  <th>Monto total</th>
                  <th>Cliente</th>
                  <th>Empleado</th>
                  <th>Salon</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="notaservicio in arrayNotaServicio" :key="notaservicio.id">
                  <td>
                    <button
                      type="button"
                      @click="abrirDatos(notaservicio.id)"
                      class="btn btn-warning btn-sm"
                    >
                      <i class="icon-info"></i>
                    </button> &nbsp;
                    <template>
                      <button
                        type="button"
                        class="btn-danger btn-sm"
                        @click="eliminarPaquete(notaservicio.id)"
                      >
                        <i class="icon-trash"></i>
                      </button>
                    </template>
                  </td>
                  <td v-text="notaservicio.id"></td>
                  <td v-text="notaservicio.fecha"></td>
                  <td v-text="notaservicio.fechaInicio"></td>
                  <td v-text="notaservicio.fechaFin"></td>
                  <td v-text="notaservicio.montoTotal"></td>
                  <td v-text="notaservicio.nombrecli"></td>
                  <td v-text="notaservicio.nombreemp"></td>
                  <td v-text="notaservicio.nombresalon"></td>
                
                </tr>
              </tbody>
            </table>

            <nav>
              <ul class="pagination">
                <li class="page-item" v-if="pagination.current_page > 1">
                  <a
                    class="page-link"
                    href="#"
                    @click.prevent="cambiarPagina(pagination.current_page - 1, buscar,criterio)"
                  >Ant</a>
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
                    @click.prevent="cambiarPagina(page,buscar,criterio)"
                    v-text="page"
                  ></a>
                </li>
                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                  <a
                    class="page-link"
                    href="#"
                    @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)"
                  >Sig</a>
                </li>
              </ul>
            </nav>
          </div>
          <!-- detalle -->
        </template>
        <template v-else>
          <div class="card-body">
            <div class="form-group row border">
              <div class="col-md-6">
                <div class="form-group">
                  <label for>
                    Fecha
                    <br />
                  </label>
                  <input
                    type="date"
                    v-model="data.fecha"
                    class="form-control"
                    placeholder=""
                  />
                </div>

                <div class="form-group">
                  <label for>
                    Fecha Inicio
                    <br />
                  </label>
                  <input
                    type="datetime-local"
                    v-model="data.fechaInicio"
                    class="form-control"
                    placeholder=""
                  />
                </div>

                <div class="form-group">
                  <label for>
                    Fecha Fin
                    <br />
                  </label>
                  <input
                    type="datetime-local"
                    v-model="data.fechaFin"
                    class="form-control"
                    placeholder=""
                  />
                </div>

                <div class="form-group">
                  <label for>
                    Estado
                    <br />
                  </label>
                  <input
                    type="text"
                    v-model="data.estado"
                    class="form-control"
                    placeholder="Estado"
                  />
                </div>

              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Empleado</label>
                  <!-- <v-select
                    :options="arrayEmpleado"
                    label="nombre"
                    placeholder="Empleado"
                    :selectedValue="selectedTipo"
                    :getOptionKey="seleccionadoTipo"
                  /> -->
                  <select class="form-control" v-model="data.idEmpleado">
                      <option value="0" disabled>Seleccione Empleado</option>
                      <option v-for="obj in arrayEmpleado" :key="obj.id" :value="obj.id" >{{ obj.nombre }}</option>
                    </select>  
                </div>

                <div class="form-group">
                  <label>Cliente</label>
                  <!-- <v-select
                    :options="arrayCliente"
                    label="nombre"
                    placeholder="Cliente"
                    :selectedValue="selectedTipo"
                    :getOptionKey="seleccionadoTipo"
                  /> -->
                   <select class="form-control" v-model="data.idCliente">
                      <option value="0" disabled>Seleccione Cliente</option>
                      <option v-for="obj in arrayCliente" :key="obj.id" :value="obj.id" >{{ obj.nombre }}</option>
                    </select>  
                </div>

                <div class="form-group">
                  <label>Salon</label>
                  <!-- <v-select
                    :options="arraySalon"
                    label="nombre"
                    placeholder="Salon"
                    :selectedValue="selectedTipo"
                    :getOptionKey="seleccionadoTipo"
                  /> -->
                  <select class="form-control" v-model="data.idSalon">
                      <option value="0" disabled>Seleccione Salon</option>
                      <option v-for="obj in arraySalon" :key="obj.id" :value="obj.id" >{{ obj.nombre }}</option>
                    </select> 
                </div>

              </div>
            </div>
            <div class="form-group row border">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Paquete</label>
                  <v-select
                    :options="arrayPaquete"
                    label="acontecimiento"
                    placeholder="Buscar Paquete"
                    :selectedValue="selectedPaquete"
                    :getOptionKey="seleccionadoPaquete"
                  />
                  
                </div>
              </div>   
             
              <div class="col-md-2">
                <div class="form-group">
                  <label for></label>
                  <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar">
                    <i class="icon-plus">Seleccionar</i>
                  </button>
                </div>
              </div>
            </div>
            <table class="table table-responsive-sm table-bordered table-striped table-sm">
              <thead>
                <tr>
                  <th>Opciones</th>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Cantidad</th>
                  <th>Precio</th>
                  <th>SubTotal</th>
                </tr>
              </thead>
              <tbody v-if="(data.detalle.length)">
                <tr v-for="(detalle,index) in data.detalle" :key="detalle.id">
                  <td>
                    <button
                      @click="eliminarDetalle(index)"
                      type="button"
                      class="btn btn-danger btn-sm"
                    >
                      <i class="icon-close"></i>
                    </button>
                  </td>
                  <td>{{ detalle.idItem }}</td>
                  <td>{{ detalle.nombre }}</td>
                  <td>
                    <input
                      type="number"
                      step="0"
                      min="0"
                      v-model="detalle.cantidad"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      step="0"
                      min="0"
                      readonly
                      v-model="detalle.precio"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span >{{detalle.subTotal.toFixed(2)}}</span>
                  </td>
                </tr>
                <tr>
                  <td colspan="5" class>Total</td>

                  <td>{{ calcularMonto.toFixed(2) }}</td>
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td colspan="8">No hay Productos Agregados</td>
                </tr>
              </tbody>
            </table>
            <div class="form-group row">
              <div class="col-md-12">
                <button type="button" class="btn btn-secondary" @click="abrirDatos()">Cerrar</button>
                <button
                  type="button"
                  v-if="tipoAccion==1"
                  class="btn btn-primary"
                  @click="guardar()"
                >Guardar</button>
                <!-- <button
                  type="button"
                  v-if="tipoAccion==2"
                  class="btn btn-primary"
                  @click="actualizar()"
                >Actualizar</button> -->
              </div>
            </div>
          </div>
        </template>
        <!-- Fin de Detalle -->
      </div>
      <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div
      class="modal fade"
      tabindex="-1"
      :class="{'mostrar': modal}"
      role="dialog"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-text="tituloModal"></h4>
            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form action method="post" enctype="multipart/form-data" class="form-horizontal">
              <!-- <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Nombre</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="tipopaquete_id">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="tipopaquete in arrayTipoPaquete" :key="tipopaquete.id" :value="tipopaquete.id" v-text="tipopaquete.nombre"></option>
                                        </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Acontecimiento</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="acontecimiento" class="form-control" placeholder="acontecimiento">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Precio</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="precio" class="form-control" placeholder="precio">
                                </div>
              </div>-->
              <div v-show="errorpaquete" class="form-group row div - error">
                <div class="text-center text-error">
                  <div v-for="error in errorMostrarMsjpaquete" :key="error" v-text="error"></div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
            <button
              type="button"
              v-if="tipoAccion==1"
              class="btn btn-primary"
              @click="guardarPaquete()"
            >Guardar</button>
            <button
              type="button"
              v-if="tipoAccion==2"
              class="btn btn-primary"
              @click="actualizarPaquete()"
            >Actualizar</button>
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
import Vue from "vue";

import Swal from "sweetalert2/dist/sweetalert2.js";
import moment from 'moment';
import "sweetalert2/src/sweetalert2.scss";
import vSelect from "vue-select";
Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";
export default {
  data() {
    return {
      arrayLista:[],
      arrayNotaServicio:[],
      data: {
        id: 0,
        idCliente: 0,
        idEmpleado: 0,
        idSalon: 0,
        fecha:'',
        fechaInicio:'',
        fechaFin:'',
        montoTotal:0,
        estado:'',
        detalle: [],
      },
      cantidad: 0,
      arrayPaquete: [],

      arrayEmpleado:[],
      arrayCliente:[],
      arraySalon:[],
      modal: 0,
      tituloModal: "",
      tipoAccion: 0,
      errorpaquete: 0,
      errorMostrarMsjpaquete: [],
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0,
      },
      offset: 2,
      criterio: "nombre",
      buscar: "",
      selectedPaquete: {
        id: 0,
        nombre: "",
      },
      listarRegistro: true,
    };
  },
  computed: {
    isActived: function () {
      return this.pagination.current_page;
    },
    //Calcula los elementos de la paginación
    pagesNumber: function () {
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
    },

    calcularMonto() {
      this.data.montoTotal = 0;
      if (this.data.detalle.length > 0) {
        this.data.detalle.forEach((x) => {
          this.data.montoTotal = this.data.montoTotal + x.precio * x.cantidad;
          x.subTotal=x.precio * x.cantidad;
        });
      }
      return this.data.montoTotal;
    },
  },
  methods: {
    listarNotaSevicio(page, buscar, criterio) {
      let me = this;
      var url =
        "/notaservicio?page=" + page + "&buscar=" + buscar + "&criterio=" + criterio;
      axios
        .get(url)
        .then(function (response) {
          var respuesta = response.data;
          me.arrayNotaServicio = respuesta.notaserv.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function (error) {
          console.log(error);
        });
    },


    seleccionadoPaquete(e) {   
      this.selectedPaquete=e;   
    },
mostrarPaqueteDetalle(id){
      let me = this;
      var url =
        "/paquetedetalle/get_"+id;
      axios
        .get(url)
        .then(res=> {
         me.data.detalle=res.data;          
        })
        .catch(function (error) {
          console.log(error);
        });        
},
    listarPaquete() {
      let me = this;
      var url = "/paquete/todos";
      axios
        .get(url)
        .then(function (response) {
          //console.log(response);
          me.arrayPaquete = response.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    listarEmpleados() {
      let me = this;
      var url = "/empleado/todos";
      axios
        .get(url)
        .then(function (response) {
          //console.log(response);
          var respuesta = response.data;
          me.arrayEmpleado = respuesta.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    listarClientes() {
      let me = this;
      var url = "/cliente/todos";
      axios
        .get(url)
        .then(function (response) {
          //console.log(response);
          var respuesta = response.data;
          me.arrayCliente = respuesta.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    listarSalon() {
      let me = this;
      var url = "/salon/todos";
      axios
        .get(url)
        .then(function (response) {
          //console.log(response);
          var respuesta = response.data;
          me.arraySalon = respuesta.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    cambiarPagina(page, buscar, criterio) {
      let me = this;
      //Actualiza la página actual
      me.pagination.current_page = page;
      //Envia la petición para visualizar la data de esa página
      me.listarNotaSevicio(page, buscar, criterio);
    },
    guardar() {
      //   if (this.validarPaquete()) {
      //     return;
      //   }
      let me = this;
      axios
        .post("/notaservicio/guardar", me.data)
        .then((res) => {
          me.eventoAlerta("success", "Nota Servicio Guardado Exitosamente");
          me.listarNotaSevicio(1,'','nombre');
          this.listarRegistro = this.listarRegistro == true ? false : true;
          //me.listar(1, "", "acontecimiento");
          
        })
        .catch((error) => {
          console.log(error);
        });
    },
    mostrar(id) {
      let me = this;
      var url =
        "/notaservicio/get_"+id;
      axios
        .get(url)
        .then(res=> {
         me.data=res.data;
         me.data.fechaInicio=moment(me.data.fechaInicio).format('YYYY-MM-DDThh:mm');          
         me.data.fechaFin=moment(me.data.fechaFin).format('YYYY-MM-DDThh:mm');
         me.tipoAccion=3;         
        })
        .catch(function (error) {
          console.log(error);
        });        
    },
    limpiar() {
      this.data = {
      id: 0,
        idCliente: 0,
        idEmpleado: 0,
        idSalon: 0,
        fecha:'',
        fechaInicio:'',
        fechaFin:'',
        montoTotal:0,
        estado:'',
        detalle: [],
      };
      this.arrayPaquete = [];
      this.tipoAccion = 1;
    },
    agregarDetalle() {
      // let sw = false;
      // this.data.detalle.forEach((x) => {
      //   if (x.idItem == this.selectedItem.id) {
      //     sw = true;
      //     this.eventoAlerta("error", "El Item ya Existe en el Detalle");
      //   }
      // });
      // if (!sw) {
      //   this.data.detalle.push({
      //     id: 0,
      //     idItem: this.selectedItem.id,
      //     item: this.selectedItem,
      //     cantidad: 0,
      //     precio: 0,
      //     subTotal: 0,
      //   });
        //  }
        let id=this.selectedPaquete.id;
      this.mostrarPaqueteDetalle(id);
   
    },
    eliminarDetalle(index) {
      this.data.detalle.splice(index, 1);
    },
    abrirDatos(id=0) {
      this.limpiar();
      this.listarRegistro = this.listarRegistro == true ? false : true;
      this.listarPaquete();
      this.listarEmpleados();
      this.listarClientes();
      this.listarSalon();
      if (id > 0) {
        this.mostrar(id);
      }
    },
    actualizarPaquete() {
      if (this.validarPaquete()) {
        return;
      }
      let me = this;
      axios
        .put("/paquete/actualizar", {
          idTipoPaquete: this.tipopaquete_id,
          acontecimiento: this.acontecimiento,
          precio: this.precio,
          id: this.paquete_id,
        })
        .then(function (response) {
          me.cerrarModal();
          me.listar(1, "", "acontecimiento");
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    eliminarPaquete(id) {
      swal({
        title: "Esta seguro de eliminar el Paquete?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar!",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true,
      }).then((result) => {
        if (result.value) {
          let me = this;

          axios
            .delete("/paquete/eliminar_" + id, {
              id: id,
            })
            .then(function (response) {
              me.listar(1, "", "acontecimiento");
              swal("Eliminado!", "El  ha sido eliminado con exito.", "success");
            })
            .catch(function (error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
        }
      });
    },
    eventoAlerta(success, mensaje) {
      Swal.fire({
        position: "center",
        icon: success,
        title: mensaje,
        showConfirmButton: false,
        timer: 1500,
      });
    },
    validarPaquete() {
      this.errorpaquete = 0;
      this.errorMostrarMsjpaquete = [];

      if (!this.acontecimiento)
        this.errorMostrarMsjpaquete.push(
          "el acontecimiento del Paquete no puede estar vacio."
        );

      if (this.errorMostrarMsjpaquete.length) this.errorpaquete = 1;

      return this.errorpaquete;
    },
    cerrarModal() {
      this.listarRegistro = false;
      this.modal = 0;
      this.tituloModal = "";
      this.acontecimiento = "";
      this.precio = "";
      this.tipopaquete_id = 0;
      this.errorpaquete = 0;
    },
    abrirModal(modelo, accion, data = []) {
      switch (modelo) {
        case "paquete": {
          switch (accion) {
            case "guardar": {
              this.modal = 1;
              this.tituloModal = "Registar Paquete";
              this.tipopaquete_id = 0;
              this.acontecimiento = "";
              this.precio = "";
              this.tipoAccion = 1;
              break;
            }
            case "actualizar": {
              //console.log(data);
              this.modal = 1;
              this.tituloModal = "Actualizar Paquete";
              this.tipoAccion = 2;
              this.paquete_id = data["id"];
              this.tipopaquete_id = data["idTipoPaquete"];
              this.acontecimiento = data["acontecimiento"];
              this.precio = data["precio"];
              break;
            }
          }
        }
      }
      // this.selectTipoPaquete();
    },
  },
  mounted() {
    this.listarNotaSevicio(1,this.buscar,this.criterio);
  },
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
</style>>