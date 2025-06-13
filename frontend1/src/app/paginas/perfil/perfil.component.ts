import { Component, OnInit } from "@angular/core";
import { NavbarComponent } from "../../componentes/navbar/navbar.component";
import { FooterComponent } from "../../componentes/footer/footer.component";
import { AuthService } from "../../services/auth.service";
import { Cita, CitaService } from "../../services/cita.service";
import { SalonService, Salon } from "../../services/salon.service";
import { Servicio, ServicioService } from "../../services/servicio.service";
import { CommonModule } from "@angular/common";
import { FormsModule } from "@angular/forms";
import { Empleado, EmpleadoService } from "../../services/empleado.service";
import Swal from "sweetalert2";
import { TranslateModule, TranslateService } from "@ngx-translate/core";
@Component({
  selector: "app-perfil",
  standalone: true,
  templateUrl: "./perfil.component.html",
  styleUrls: ["./perfil.component.scss"],
  imports: [
    NavbarComponent,
    FooterComponent,
    CommonModule,
    FormsModule,
    TranslateModule,
  ],
})
export class PerfilComponent implements OnInit {
  // --- Perfil de usuario ---
  usuario: any = null;
  imagenPerfilSeleccionada: File | null = null;
  previewUrlPerfil: string | null = null;

  // --- Citas y salones ---
  citas: Cita[] = [];
  misSalones: Salon[] = [];

  salonEditando: Salon | null = null;
  salonAEliminar: Salon | null = null;
  // BOTÓN LOGOUT
  logout(): void {
    Swal.fire({
      title: this.translate.instant("SWAL.LOGOUT_TITLE"),
      text: this.translate.instant("SWAL.LOGOUT_TEXT"),
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: this.translate.instant("SWAL.LOGOUT_CONFIRM"),
      cancelButtonText: this.translate.instant("SWAL.LOGOUT_CANCEL"),
    }).then((result) => {
      if (result.isConfirmed) {
        this.authSvc.logout();
        Swal.fire(this.translate.instant("SWAL.LOGOUT_SUCCESS"), "", "success");
      }
    });
  }
  // Mapa auxiliar para almacenar a qué salón pertenece cada cita
  citaSalonMap: Record<number, number> = {};

  serviciosMap: Record<number, string> = {};
  empleadosMap: Record<number, string> = {};

  nombreConfirmacion: string = "";

  // --- Servicios por salón ---
  serviciosPorSalon: Record<number, Servicio[]> = {};
  servicioNuevo: Partial<Servicio> = {
    id_salon: 0,
    nombre: "",
    descripcion: "",
    precio: 0,
    duracion_minutos: 0,
  };
  servicioEditando: Servicio | null = null;
  showFormCrear: boolean = false;
  showFormEditar: boolean = false;

  // --- Empleados por salón ---
  empleadosPorSalon: Record<number, Empleado[]> = {};
  empleadoNuevo: Partial<Empleado> = {
    id_salon: 0,
    nombre: "",
    telefono: "",
  };
  empleadoEditando: Empleado | null = null;
  showFormCrearEmpleado: boolean = false;
  showFormEditarEmpleado: boolean = false;

  // --- Imagen del salón / empleado ---
  imagenSalonSeleccionada: File | null = null;
  previewUrlSalon: string | null = null;
  imagenEmpleadoSeleccionada: File | null = null;
  previewUrlEmpleado: string | null = null;

  constructor(
    private authSvc: AuthService,
    private citaService: CitaService,
    private salonService: SalonService,
    private servicioService: ServicioService,
    private empleadoService: EmpleadoService,
    private translate: TranslateService
  ) {}

  ngOnInit(): void {
    this.authSvc.currentUser$.subscribe((usuario) => {
      this.usuario = { ...usuario };
      this.previewUrlPerfil = usuario?.foto_perfil ?? null;
      if (this.usuario?.id_usuario) {
        this.fetchCitas(this.usuario.id_usuario);
        this.fetchSalon(this.usuario.id_usuario);
      }
    });
  }

  /**
   * Obtiene los salones del usuario (dueño/administrador).
   * Para cada salón, carga sus servicios y empleados.
   */
  fetchSalon(idUsuario: number): void {
    this.salonService.getSalonesPorUsuario(idUsuario).subscribe({
      next: (salones) => {
        this.misSalones = salones;
        salones.forEach((salon) => {
          this.cargarServiciosDeSalon(salon.id_salon);
          this.cargarEmpleadosDeSalon(salon.id_salon);
        });
      },
      error: (err) => console.error("Error al cargar salones:", err),
    });
  }

  /**
   * Obtiene las citas del usuario (cliente).
   * Para cada cita, obtiene nombre de servicio, nombre de empleado y asigna id_salon en citaSalonMap.
   */
  fetchCitas(idUsuario: number): void {
    this.citaService.getCitasPorUsuario(idUsuario).subscribe({
      next: (citas) => {
        this.citas = citas;
        citas.forEach((cita) => {
          this.getNombreServicio(cita.id_servicio);
          this.getNombreEmpleado(cita.id_empleado);
          // Obtener id_salon a partir del servicio asociado a la cita
          this.servicioService.getServicio(cita.id_servicio).subscribe({
            next: (serv) => {
              this.citaSalonMap[cita.id_cita] = serv.id_salon;
              // Si aún no cargamos los empleados de ese salón, haremos:
              if (!this.empleadosPorSalon[serv.id_salon]) {
                this.cargarEmpleadosDeSalon(serv.id_salon);
              }
            },
            error: () => {
              console.warn(
                `No se pudo obtener id_salon para cita ${cita.id_cita}`
              );
            },
          });
        });
      },
      error: (err) => console.error("Error al cargar citas:", err),
    });
  }

  /**
   * Carga servicios de un salón para editar/agregar.
   */
  cargarServiciosDeSalon(id_salon: number): void {
    this.servicioService.getServiciosPorSalon(id_salon).subscribe({
      next: (servs) => (this.serviciosPorSalon[id_salon] = servs),
      error: (err) => {
        console.error(`Error al cargar servicios de salón ${id_salon}:`, err);
        this.serviciosPorSalon[id_salon] = [];
      },
    });
  }

  /**
   * Carga empleados de un salón para mostrar en el selector de citas.
   */
  cargarEmpleadosDeSalon(id_salon: number): void {
    this.empleadoService.getEmpleadosPorSalon(id_salon).subscribe({
      next: (emps) => (this.empleadosPorSalon[id_salon] = emps),
      error: (err) => {
        console.error(`Error al cargar empleados de salón ${id_salon}:`, err);
        this.empleadosPorSalon[id_salon] = [];
      },
    });
  }

  /**
   * Obtiene el nombre del servicio y lo almacena en serviciosMap.
   */
  getNombreServicio(id: number): void {
    if (!this.serviciosMap[id]) {
      this.servicioService.getServicio(id).subscribe({
        next: (serv) => (this.serviciosMap[id] = serv.nombre),
        error: () => (this.serviciosMap[id] = "Desconocido"),
      });
    }
  }

  /**
   * Obtiene el nombre del empleado y lo almacena en empleadosMap.
   */
  getNombreEmpleado(id: number): void {
    if (!this.empleadosMap[id]) {
      this.empleadoService.getEmpleado(id).subscribe({
        next: (emp) => (this.empleadosMap[id] = emp.nombre),
        error: () => (this.empleadosMap[id] = "Desconocido"),
      });
    }
  }

  /**
   * Maneja la selección de archivos (perfil, salón, empleado).
   */
  onFileSelected(event: any, target: "perfil" | "salon" | "empleado"): void {
    const file: File = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (e: any) => {
      switch (target) {
        case "perfil":
          this.imagenPerfilSeleccionada = file;
          this.previewUrlPerfil = e.target.result;
          break;
        case "salon":
          this.imagenSalonSeleccionada = file;
          this.previewUrlSalon = e.target.result;
          break;
        case "empleado":
          this.imagenEmpleadoSeleccionada = file;
          this.previewUrlEmpleado = e.target.result;
          break;
      }
    };
    reader.readAsDataURL(file);
  }

  guardarCambios(): void {
    const userId = this.usuario.id_usuario;
    if (!userId) return;

    if (this.imagenPerfilSeleccionada) {
      const formData = new FormData();
      formData.append("nombre", this.usuario.nombre);
      formData.append("email", this.usuario.email);
      formData.append("telefono", this.usuario.telefono);
      formData.append("foto_perfil", this.imagenPerfilSeleccionada);
      this.authSvc.actualizarPerfilConImagen(userId, formData).subscribe({
        next: (res) => this.onPerfilActualizado(res),
        error: (err) => this.onError(err),
      });
    } else {
      const body = {
        nombre: this.usuario.nombre,
        email: this.usuario.email,
        telefono: this.usuario.telefono,
      };
      this.authSvc.actualizarPerfil(userId, body).subscribe({
        next: (res) => this.onPerfilActualizado(res),
        error: (err) => this.onError(err),
      });
    }
  }

  // —————————— Métodos para eliminar y editar citas ——————————

  /**
   * Cualquiera (cliente) puede eliminar su propia cita.
   * Hace DELETE al backend y remueve la cita del array local.
   */
  onEliminarCita(cita: Cita): void {
    Swal.fire({
      title: this.translate.instant("SWAL.DELETE_BOOKING_TITLE"),
      text: this.translate.instant("SWAL.DELETE_BOOKING_TEXT"),
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: this.translate.instant("SWAL.DELETE_BOOKING_CONFIRM"),
      cancelButtonText: this.translate.instant("SWAL.DELETE_BOOKING_CANCEL"),
    }).then((result) => {
      if (result.isConfirmed) {
        this.citaService.eliminarCita(cita.id_cita).subscribe({
          next: () => {
            this.citas = this.citas.filter((c) => c.id_cita !== cita.id_cita);
            Swal.fire(
              this.translate.instant("SWAL.DELETE_BOOKING_SUCCESS"),
              "",
              "success"
            );
          },
          error: () => {
            Swal.fire(
              this.translate.instant("SWAL.DELETE_BOOKING_ERROR"),
              "",
              "error"
            );
          },
        });
      }
    });
  }
  /**
   * Solo dueño de salón o administrador: cambia el estado de la cita
   */
  onCambiarEstado(
    cita: Cita,
    nuevoEstado: "pendiente" | "confirmada" | "cancelada"
  ): void {
    this.citaService
      .actualizarCita(cita.id_cita, { estado: nuevoEstado })
      .subscribe({
        next: () => {
          cita.estado = nuevoEstado;
          Swal.fire(
            this.translate.instant("SWAL.UPDATE_STATUS_SUCCESS"),
            "",
            "success"
          );
        },
        error: () => {
          Swal.fire(
            this.translate.instant("SWAL.UPDATE_STATUS_ERROR"),
            "",
            "error"
          );
        },
      });
  }

  /**
   * Solo dueño de salón o administrador: cambia el empleado asignado a la cita.
   */
  onCambiarEmpleado(cita: Cita, nuevoEmpleadoId: number): void {
    this.citaService
      .actualizarCita(cita.id_cita, { id_empleado: nuevoEmpleadoId })
      .subscribe({
        next: () => {
          cita.id_empleado = nuevoEmpleadoId;
          this.getNombreEmpleado(nuevoEmpleadoId);
          Swal.fire(
            this.translate.instant("SWAL.UPDATE_EMPLOYEE_SUCCESS"),
            "",
            "success"
          );
        },
        error: () => {
          Swal.fire(
            this.translate.instant("SWAL.UPDATE_EMPLOYEE_ERROR"),
            "",
            "error"
          );
        },
      });
  }

  /**
   * Devuelve true si el usuario logueado es dueño de ese salón o es administrador.
   */
  esDuenoOSuper(cita: Cita): boolean {
    const idSalon = this.citaSalonMap[cita.id_cita];
    const salon = this.misSalones.find((s) => s.id_salon === idSalon);
    const esDueno = salon && salon.id_usuario === this.usuario.id_usuario;
    const esAdmin = this.usuario.rol === "administrador";
    return Boolean(esDueno || esAdmin);
  }

  // ————— Resto de métodos para CRUD de salón, servicios y empleados —————
  editarSalon(salon: Salon): void {
    this.salonEditando = { ...salon };
  }

  guardarCambiosSalon(): void {
    if (!this.salonEditando) return;
    const {
      id_salon,
      nombre,
      direccion,
      telefono,
      descripcion,
      especializacion,
    } = this.salonEditando;

    if (this.imagenSalonSeleccionada) {
      const formData = new FormData();
      formData.append("nombre", nombre);
      formData.append("direccion", direccion);
      formData.append("telefono", telefono);
      formData.append("descripcion", descripcion);
      formData.append("especializacion", especializacion);
      formData.append("id_usuario", String(this.usuario.id_usuario));
      formData.append("foto", this.imagenSalonSeleccionada);
      formData.append("_method", "PUT");

      this.salonService.actualizarSalonConImagen(id_salon, formData).subscribe({
        next: () => {
          Swal.fire(
            this.translate.instant("SWAL.SALON_UPDATED_SUCCESS"),
            "",
            "success"
          );
          this.fetchSalon(this.usuario.id_usuario);
          this.cerrarModalSalon();
        },
        error: (err) => {
          console.error("Error al actualizar salón con imagen:", err);
          Swal.fire(
            this.translate.instant("SWAL.SALON_UPDATED_ERROR"),
            "",
            "error"
          );
        },
      });
    } else {
      const data = {
        nombre,
        direccion,
        telefono,
        descripcion,
        especializacion,
        id_usuario: this.usuario.id_usuario,
      };

      this.salonService.actualizarSalon(id_salon, data).subscribe({
        next: () => {
          Swal.fire(
            this.translate.instant("SWAL.SALON_UPDATED_SUCCESS"),
            "",
            "success"
          );
          this.fetchSalon(this.usuario.id_usuario);
          this.cerrarModalSalon();
        },
        error: (err) => {
          console.error("Error al actualizar salón sin imagen:", err);
          Swal.fire(
            this.translate.instant("SWAL.SALON_UPDATED_ERROR"),
            "",
            "error"
          );
        },
      });
    }
  }

  borrarSalon(salon: Salon): void {
    Swal.fire({
      title: this.translate.instant("PROFILE.MODAL_CONFIRM_TITULO"),
      text:
        `${this.translate.instant("PROFILE.MODAL_CONFIRM_TEXTO")}: ` +
        `"${salon.nombre}"`,
      input: "text",
      inputPlaceholder: this.translate.instant(
        "PROFILE.MODAL_CONFIRM_PLACEHOLDER"
      ),
      showCancelButton: true,
      confirmButtonText: this.translate.instant("PROFILE.BUTTON_ELIMINAR"),
      cancelButtonText: this.translate.instant("PROFILE.BUTTON_CANCELAR"),
      preConfirm: (valor: string) => {
        if (valor !== salon.nombre) {
          Swal.showValidationMessage(
            this.translate.instant("SWAL.GENERIC_ERROR_TEXT")
          );
          return false;
        }
        return valor;
      },
    }).then((result) => {
      if (result.isConfirmed) {
        this.salonService.eliminarSalon(salon.id_salon).subscribe({
          next: () => {
            Swal.fire(
              this.translate.instant("SWAL.SALON_DELETED_SUCCESS"),
              "",
              "success"
            );
            this.fetchSalon(this.usuario.id_usuario);
          },
          error: () => {
            Swal.fire(
              this.translate.instant("SWAL.SALON_DELETED_ERROR"),
              "",
              "error"
            );
          },
        });
      }
    });
  }

  // Métodos de confirmación de eliminación
  cancelarEliminacion(): void {
    this.salonAEliminar = null;
    this.nombreConfirmacion = "";
  }

  confirmarEliminacion(): void {
    if (!this.salonAEliminar) return;
    this.borrarSalon(this.salonAEliminar);
    this.salonAEliminar = null;
    this.nombreConfirmacion = "";
  }

  cerrarModalSalon(): void {
    this.salonEditando = null;
    this.imagenSalonSeleccionada = null;
    this.previewUrlSalon = null;
  }

  abrirFormularioCrearServicio(id_salon: number): void {
    this.servicioNuevo = {
      id_salon,
      nombre: "",
      descripcion: "",
      precio: 0,
      duracion_minutos: 0,
    };
    this.showFormCrear = true;
  }

  abrirFormularioEditarServicio(serv: Servicio): void {
    this.servicioEditando = { ...serv };
    this.showFormEditar = true;
  }

  cerrarFormularioServicio(): void {
    this.showFormCrear = false;
    this.showFormEditar = false;
    this.servicioEditando = null;
  }

  guardarServicioNuevo(): void {
    if (
      !this.servicioNuevo.nombre ||
      this.servicioNuevo.precio == null ||
      this.servicioNuevo.duracion_minutos == null ||
      this.servicioNuevo.id_salon == null
    ) {
      Swal.fire(
        this.translate.instant("SWAL.INCOMPLETE_FIELDS"),
        this.translate.instant("SWAL.INCOMPLETE_FIELDS_SERVICE"),
        "warning"
      );
      return;
    }
    const payloadCrear = {
      id_salon: this.servicioNuevo.id_salon,
      nombre: this.servicioNuevo.nombre,
      descripcion: this.servicioNuevo.descripcion,
      precio: this.servicioNuevo.precio,
      duracion: this.servicioNuevo.duracion_minutos,
    };
    this.servicioService.crearServicio(payloadCrear).subscribe({
      next: (servCreado) => {
        this.cargarServiciosDeSalon(servCreado.id_salon);
        this.cerrarFormularioServicio();
        Swal.fire(
          this.translate.instant("SWAL.SERVICE_CREATED_SUCCESS"),
          "",
          "success"
        );
      },
      error: (err) => {
        console.error("Error al crear servicio:", err);
        Swal.fire(
          this.translate.instant("SWAL.SERVICE_CREATED_ERROR"),
          "",
          "error"
        );
      },
    });
  }

  guardarCambiosServicio(): void {
    if (!this.servicioEditando) return;
    const {
      id_servicio,
      nombre,
      descripcion,
      precio,
      duracion_minutos,
      id_salon,
    } = this.servicioEditando;
    if (
      !nombre ||
      precio == null ||
      duracion_minutos == null ||
      id_salon == null
    ) {
      Swal.fire(
        this.translate.instant("SWAL.INCOMPLETE_FIELDS"),
        this.translate.instant("SWAL.INCOMPLETE_FIELDS_SERVICE"),
        "warning"
      );
      return;
    }
    const payloadActualizar = {
      nombre,
      descripcion,
      precio,
      duracion: duracion_minutos,
      id_salon,
    };
    this.servicioService
      .actualizarServicio(id_servicio, payloadActualizar)
      .subscribe({
        next: () => {
          this.cargarServiciosDeSalon(id_salon);
          this.cerrarFormularioServicio();
          Swal.fire(
            this.translate.instant("SWAL.SERVICE_UPDATED_SUCCESS"),
            "",
            "success"
          );
        },
        error: (err) => {
          console.error("Error al actualizar servicio:", err);
          Swal.fire(
            this.translate.instant("SWAL.SERVICE_UPDATED_ERROR"),
            "",
            "error"
          );
        },
      });
  }
  borrarServicio(serv: Servicio): void {
    Swal.fire({
      title: this.translate.instant("SWAL.DELETE_BOOKING_TITLE"), // o crea otra clave SWAL.DELETE_SERVICE_TITLE
      text: this.translate.instant("SWAL.DELETE_BOOKING_TEXT"),
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: this.translate.instant("SWAL.DELETE_BOOKING_CONFIRM"),
      cancelButtonText: this.translate.instant("SWAL.DELETE_BOOKING_CANCEL"),
    }).then((result) => {
      if (result.isConfirmed) {
        this.servicioService.eliminarServicio(serv.id_servicio).subscribe({
          next: () => {
            this.cargarServiciosDeSalon(serv.id_salon);
            Swal.fire(
              this.translate.instant("SWAL.SERVICE_DELETED_SUCCESS"),
              "",
              "success"
            );
          },
          error: () => {
            Swal.fire(
              this.translate.instant("SWAL.SERVICE_DELETED_ERROR"),
              "",
              "error"
            );
          },
        });
      }
    });
  }

  abrirFormularioCrearEmpleado(id_salon: number): void {
    this.empleadoNuevo = {
      id_salon,
      nombre: "",
      telefono: "",
    };
    this.showFormCrearEmpleado = true;
  }

  abrirFormularioEditarEmpleado(emp: Empleado): void {
    this.empleadoEditando = { ...emp };
    this.previewUrlEmpleado = emp.foto || null;
    this.showFormEditarEmpleado = true;
  }

  cerrarFormularioEmpleado(): void {
    this.showFormCrearEmpleado = false;
    this.showFormEditarEmpleado = false;
    this.empleadoEditando = null;
    this.imagenEmpleadoSeleccionada = null;
    this.previewUrlEmpleado = null;
  }

  guardarEmpleadoNuevo(): void {
    if (
      !this.empleadoNuevo.nombre ||
      !this.empleadoNuevo.telefono ||
      this.empleadoNuevo.id_salon == null
    ) {
      Swal.fire(
        this.translate.instant("SWAL.INCOMPLETE_FIELDS"),
        this.translate.instant("SWAL.INCOMPLETE_FIELDS_EMPLOYEE"),
        "warning"
      );
      return;
    }
    const payloadCrear: any = {
      id_salon: this.empleadoNuevo.id_salon,
      nombre: this.empleadoNuevo.nombre,
      telefono: this.empleadoNuevo.telefono,
    };
    if (this.imagenEmpleadoSeleccionada) {
      const formData = new FormData();
      formData.append("id_salon", String(payloadCrear.id_salon));
      formData.append("nombre", payloadCrear.nombre);
      formData.append("telefono", payloadCrear.telefono);
      formData.append("foto", this.imagenEmpleadoSeleccionada);
      this.empleadoService.crearEmpleadoConImagen(formData).subscribe({
        next: (empCreado) => {
          this.cargarEmpleadosDeSalon(empCreado.id_salon);
          this.cerrarFormularioEmpleado();
          Swal.fire(
            this.translate.instant("SWAL.EMPLOYEE_CREATED_SUCCESS"),
            "",
            "success"
          );
        },
        error: (err) => {
          console.error("Error al crear empleado con imagen:", err);
          alert("Hubo un error al crear el empleado");
        },
      });
    } else {
      this.empleadoService.crearEmpleado(payloadCrear).subscribe({
        next: (empCreado) => {
          this.cargarEmpleadosDeSalon(empCreado.id_salon);
          this.cerrarFormularioEmpleado();
        },
        error: (err) => {
          console.error("Error al crear empleado:", err);
          alert("Hubo un error al crear el empleado");
        },
      });
    }
  }

  guardarCambiosEmpleado(): void {
    if (!this.empleadoEditando) return;
    const { id_empleado, nombre, telefono, id_salon } = this.empleadoEditando;
    if (!nombre || !telefono || id_salon == null) {
      Swal.fire(
        this.translate.instant("SWAL.INCOMPLETE_FIELDS"),
        this.translate.instant("SWAL.INCOMPLETE_FIELDS_EMPLOYEE"),
        "warning"
      );
      return;
    }
    const payloadActualizar: any = {
      nombre,
      telefono,
      id_salon,
    };
    if (this.imagenEmpleadoSeleccionada) {
      const formData = new FormData();
      formData.append("nombre", nombre);
      formData.append("telefono", telefono);
      formData.append("foto", this.imagenEmpleadoSeleccionada);
      formData.append("_method", "PUT");
      this.empleadoService
        .actualizarEmpleadoConImagen(id_empleado, formData)
        .subscribe({
          next: () => {
            this.cargarEmpleadosDeSalon(id_salon);
            this.cerrarFormularioEmpleado();
            Swal.fire(
              this.translate.instant("SWAL.EMPLOYEE_UPDATED_SUCCESS"),
              "",
              "success"
            );
          },
          error: (err) => {
            console.error("Error al actualizar empleado con imagen:", err);
            alert("Hubo un error al actualizar el empleado");
          },
        });
    } else {
      this.empleadoService
        .actualizarEmpleado(id_empleado, payloadActualizar)
        .subscribe({
          next: () => {
            this.cargarEmpleadosDeSalon(id_salon);
            this.cerrarFormularioEmpleado();
          },
          error: (err) => {
            console.error("Error al actualizar empleado:", err);
            alert("Hubo un error al actualizar el empleado");
          },
        });
    }
  }

  borrarEmpleado(emp: Empleado): void {
    Swal.fire({
      title: `¿Eliminar a "${emp.nombre}"?`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sí, eliminar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        this.empleadoService.eliminarEmpleado(emp.id_empleado).subscribe({
          next: () => this.cargarEmpleadosDeSalon(emp.id_salon),
          error: (err) => {
            console.error("Error al eliminar empleado:", err);
            Swal.fire(
              "Error",
              "Hubo un error al eliminar el empleado",
              "error"
            );
          },
        });
      }
    });
  }
  private onPerfilActualizado(res: any) {
    localStorage.setItem("usuario", JSON.stringify(res));
    (this.authSvc as any).currentUserSubject.next(res);
    this.usuario = { ...res };
    this.previewUrlPerfil = res.foto_perfil;
    Swal.fire(
      this.translate.instant("SWAL.PROFILE_UPDATED_SUCCESS"),
      "",
      "success"
    );
  }
  private onError(err: any) {
    console.error("Error al guardar cambios:", err);
    Swal.fire(
      this.translate.instant("SWAL.GENERIC_ERROR_TITLE"),
      this.translate.instant("SWAL.GENERIC_ERROR_TEXT"),
      "error"
    );
  }
}
