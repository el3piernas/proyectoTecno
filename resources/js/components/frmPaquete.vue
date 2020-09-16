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
          <i class="fa fa-align-justify"></i> Paquete
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
                    <option value="acontecimiento">Acontecimiento</option>
                  </select>
                  <input
                    type="text"
                    v-model="buscar"
                    class="form-control"
                    placeholder="Texto a buscar"
                  />
                  <button
                    type="submit"
                    @click="listarPaquete(1,buscar,criterio)"
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
                  <th>Nombre del Paquete</th>
                  <th>Acontecimiento</th>
                  <th>Precio</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="paquete in arrayPaquete" :key="paquete.id">
                  <td>
                    <button
                      type="button"
                      @click="abrirModal('paquete','actualizar',paquete)"
                      class="btn btn-warning btn-sm"
                    >
                      <i class="icon-pencil"></i>
                    </button> &nbsp;
                    <template>
                      <button
                        type="button"
                        class="btn-danger btn-sm"
                        @click="eliminarPaquete(paquete.id)"
                      >
                        <i class="icon-trash"></i>
                      </button>
                    </template>
                  </td>
                  <td v-text="paquete.nombre"></td>
                  <td v-text="paquete.acontecimiento"></td>
                  <td v-text="paquete.precio"></td>
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
                    Nombre del Paquete
                    <br />
                  </label>
                  <input
                    type="text"
                    v-model="data.acontecimiento"
                    class="form-control"
                    placeholder="Descripcion"
                  />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tipo Paquete</label>
                  <v-select
                    :options="arrayTipoPaquete"
                    label="nombre"
                    placeholder="Tipo Paquete"
                    :selectedValue="selectedTipo"
                    :getOptionKey="seleccionadoTipo"
                  />
                </div>
              </div>
            </div>
            <div class="form-group row border">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Item</label>
                  <v-select
                    :options="arrayItem"
                    label="nombre"
                    placeholder="Buscar Item"
                    :selectedValue="selectedItem"
                    :getOptionKey="seleccionadoItem"
                  />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for></label>
                  <button
                    @click="abrirModal()"
                    data-toggle="modal"
                    data-target="#ModalLong"
                    class="btn btn-success form-control btnagregar"
                  >
                    <i class="icon-plus"></i>
                    <i class="icon-plus"></i>
                    <i class="icon-plus"></i>
                  </button>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for>Cantidad</label>
                  <input type="number" value="0" min="0" class="form-control" v-model="cantidad" />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for></label>
                  <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar">
                    <i class="icon-plus">Agregar</i>
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
                  <td>{{ detalle.item.nombre }}</td>
                  <td>
                    <input
                      type="number"
                      step="0"
                      min="0"
                      v-model="detalle.precio"
                      class="form-control"
                    />
                  </td>
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
                    <span v-text="(detalle.cantidad*detalle.precio).toFixed(2)"></span>
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
                <button
                  type="button"
                  v-if="tipoAccion==2"
                  class="btn btn-primary"
                  @click="actualizar()"
                >Actualizar</button>
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
import "sweetalert2/src/sweetalert2.scss";
import vSelect from "vue-select";
Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";
export default {
  data() {
    return {
      data: {
        id: 0,
        idTipoPaquete: 0,
        acontecimiento: "",
        precio: 0,
        detalle: [],
      },
      cantidad: 0,
      arrayPaquete: [],
      arrayItem: [],
      arrayTipoPaquete: [],
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
      criterio: "acontecimiento",
      buscar: "",
      selectedItem: {
        id: 0,
        nombre: "",
      },
      selectedTipo: {
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
      this.data.precio = 0;
      if (this.data.detalle.length > 0) {
        this.data.detalle.forEach((x) => {
          this.data.precio = this.data.precio + x.precio * x.cantidad;
        });
      }
      return this.data.precio;
    },
  },
  methods: {
    listarPaquete(page, buscar, criterio) {
      let me = this;
      var url =
        "/paquete?page=" + page + "&buscar=" + buscar + "&criterio=" + criterio;
      axios
        .get(url)
        .then(function (response) {
          var respuesta = response.data;
          me.arrayPaquete = respuesta.paquete.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    seleccionadoItem(e) {
      this.selectedItem = e;
    },
    seleccionadoTipo(e) {
      this.selectedTipo = e;
      this.data.idTipoPaquete=e.id;
    },
    listarItem() {
      let me = this;
      var url = "/item/todos";
      axios
        .get(url)
        .then(function (response) {
          //console.log(response);
          var respuesta = response.data;
          me.arrayItem = respuesta.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    listarTipoPaquete() {
      let me = this;
      var url = "/tipopaquete/todos";
      axios
        .get(url)
        .then(function (response) {
          //console.log(response);
          var respuesta = response.data;
          me.arrayTipoPaquete = respuesta.data;
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
      me.listarPaquete(page, buscar, criterio);
    },
    guardar() {
      //   if (this.validarPaquete()) {
      //     return;
      //   }
      let me = this;
      axios
        .post("/paquete/guardar", me.data)
        .then((res) => {
          me.eventoAlerta("success", "Guardado Exitosamente");
          me.cerrarModal();
          me.listarPaquete(1, "", "acontecimiento");
        })
        .catch((error) => {
          console.log(error);
        });
    },
    limpiar() {
      this.data = {
        id: 0,
        idTipoPaquete: 0,
        acontecimiento: "",
        precio: 0,
        detalle: [],
      };
      this.arrayItem = [];
      this.tipoAccion = 1;
    },
    agregarDetalle() {
      let sw = false;
      this.data.detalle.forEach((x) => {
        if (x.idItem == this.selectedItem.id) {
          sw = true;
          this.eventoAlerta("error", "El Item ya Existe en el Detalle");
        }
      });
      if (!sw) {
        this.data.detalle.push({
          id: 0,
          idItem: this.selectedItem.id,
          item: this.selectedItem,
          cantidad: 0,
          precio: 0,
          subTotal: 0,
        });
      }
    },
    eliminarDetalle(index) {
      this.data.detalle.splice(index, 1);
    },
    abrirDatos(id) {
      this.limpiar();
      this.listarRegistro = this.listarRegistro == true ? false : true;
      this.listarItem();
      this.listarTipoPaquete();
      if (id > 0) {
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
          me.listarPaquete(1, "", "acontecimiento");
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
              me.listarPaquete(1, "", "acontecimiento");
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
    this.listarPaquete(1, this.buscar, this.criterio);
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