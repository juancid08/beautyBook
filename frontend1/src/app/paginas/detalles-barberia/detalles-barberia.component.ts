// src/app/pages/detalles-barberia/detalles-barberia.component.ts
import { Component, OnInit } from "@angular/core";
import { ActivatedRoute, Router } from "@angular/router";
import { NavbarComponent } from "../../componentes/navbar/navbar.component";
import { FooterComponent } from "../../componentes/footer/footer.component";
import { CommonModule } from "@angular/common";
import { FormsModule } from "@angular/forms";

import { Salon, SalonService } from "../../services/salon.service";
import { Servicio, ServicioService } from "../../services/servicio.service";
import { Empleado, EmpleadoService } from "../../services/empleado.service";
import { Cita, CitaService } from "../../services/cita.service";
import { AuthService } from "../../services/auth.service";
import { Resena, ResenaService } from "../../services/resena.service";
import { TranslateModule, TranslateService } from "@ngx-translate/core";
import { DomSanitizer, SafeResourceUrl } from "@angular/platform-browser";
import Swal from "sweetalert2";
interface Turno {
  key: "Mañana" | "Tarde" | "Noche";
  labelKey: string;
}
interface DiaSemanal {
  dayKey: string;
  horario: string;
}
@Component({
  selector: "app-detalles-barberia",
  standalone: true,
  imports: [
    NavbarComponent,
    FooterComponent,
    CommonModule,
    TranslateModule,
    FormsModule,
  ],
  templateUrl: "./detalles-barberia.component.html",
  styleUrls: ["./detalles-barberia.component.scss"],
})
export class DetallesBarberiaComponent implements OnInit {
  usuarioActual: any = null;
  salon: Salon | undefined;
  servicios: Servicio[] = [];
  empleados: Empleado[] = [];
  resenas: Resena[] = [];
  citasDeUsuario: Cita[] = [];
  citasPasadasSinResenar: Cita[] = [];
  readonly estrellas = [1, 2, 3, 4, 5];

  todayIso: string = new Date().toISOString().split("T")[0];

  mostrarPopup = false;
  diasDisponibles: {
    diaKey: string;
    numero: number;
    mesKey: string;
    fecha: Date;
  }[] = [];

  diasSemana: DiaSemanal[] = [];
  turnos: Turno[] = [];

  turnoSeleccionado: "Mañana" | "Tarde" | "Noche" | null = null;
  horasDisponibles: string[] = [];
  horaSeleccionada: string | null = null;
  diaSeleccionado: {
    diaKey: string;
    numero: number;
    mesKey: string;
    fecha: Date;
  };
  servicio: Servicio | undefined;
  empleadoSeleccionado: Empleado | undefined;
  mapUrl!: SafeResourceUrl | null;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private authSvc: AuthService,
    private salonService: SalonService,
    private servicioService: ServicioService,
    private empleadoService: EmpleadoService,
    private citaService: CitaService,
    private resenaService: ResenaService,
    private sanitizer: DomSanitizer,
    private translate: TranslateService
  ) {
    this.turnos = [
      { key: "Mañana", labelKey: "DETAILS.TURNO_MANANA" },
      { key: "Tarde", labelKey: "DETAILS.TURNO_TARDE" },
      { key: "Noche", labelKey: "DETAILS.TURNO_NOCHE" },
    ];
    this.generarFechas();
    this.diaSeleccionado = this.diasDisponibles[0];
  }

  ngOnInit(): void {
    if (this.authSvc.currentUser$) {
      this.authSvc.currentUser$.subscribe((usuario) => {
        this.usuarioActual = usuario;
        if (usuario && this.salon) {
          this.fetchCitasUsuarioParaSalon(
            usuario.id_usuario,
            this.salon.id_salon
          );
        }
      });
    }
    this.route.paramMap.subscribe((params) => {
      const id = params.get("id");
      if (id) {
        const salonId = +id;
        this.fetchSalon(salonId);
        this.fetchServicios(salonId);
        this.fetchEmpleados(salonId);
        this.fetchResenas(salonId);
      }
    });
  }

  fetchSalon(salonId: number): void {
    this.salonService.getSalon(salonId).subscribe({
      next: (salon) => {
        this.salon = this.salonService.getSalonFormateado(salon);
        const direccionEncode = encodeURIComponent(this.salon!.direccion);
        const urlEmbed = `https://www.google.com/maps?q=${direccionEncode}&output=embed`;
        this.mapUrl = this.sanitizer.bypassSecurityTrustResourceUrl(urlEmbed);
        this.generarHorarioSemanal();
        if (this.usuarioActual && this.usuarioActual.id_usuario) {
          this.fetchCitasUsuarioParaSalon(
            this.usuarioActual.id_usuario,
            salonId
          );
        }
      },
      error: (err) =>
        console.error(this.translate.instant("DETAILS.ERROR_LOAD_SALON"), err),
    });
  }

  fetchServicios(salonId: number): void {
    this.servicioService.getServiciosPorSalon(salonId).subscribe({
      next: (servicios) => (this.servicios = servicios),
      error: (err) => console.error("Error al cargar los servicios", err),
    });
  }

  fetchEmpleados(salonId: number): void {
    this.empleadoService.getEmpleadosPorSalon(salonId).subscribe({
      next: (empleados) => {
        this.empleados = empleados;
        this.empleadoSeleccionado = empleados[0] || undefined;
      },
      error: (err) => console.error("Error al cargar los empleados", err),
    });
  }

  fetchResenas(salonId: number): void {
    this.resenaService.getResenasPorSalon(salonId).subscribe({
      next: (resenas) => {
        this.resenas = resenas;
        if (this.usuarioActual && this.usuarioActual.id_usuario && this.salon) {
          this.fetchCitasUsuarioParaSalon(
            this.usuarioActual.id_usuario,
            this.salon.id_salon
          );
        }
      },
      error: (err) => {
        console.error("Error al cargar las reseñas", err);
        this.resenas = [];
      },
    });
  }

  abrirPopup(servicio: Servicio) {
    this.servicio = servicio;
    this.mostrarPopup = true;
    this.turnoSeleccionado = null;
    this.horaSeleccionada = null;
    this.horasDisponibles = [];
  }

  cerrarPopup() {
    this.mostrarPopup = false;
    this.turnoSeleccionado = null;
    this.horaSeleccionada = null;
    this.horasDisponibles = [];
  }

  generarHorarioSemanal() {
    if (!this.salon) {
      this.diasSemana = [];
      return;
    }
    const nombresDias = [
      "DETAILS.DAY_MONDAY",
      "DETAILS.DAY_TUESDAY",
      "DETAILS.DAY_WEDNESDAY",
      "DETAILS.DAY_THURSDAY",
      "DETAILS.DAY_FRIDAY",
      "DETAILS.DAY_SATURDAY",
      "DETAILS.DAY_SUNDAY",
    ];

    const apertura = this.salon.horario_apertura;
    const cierre = this.salon.horario_cierre;
    const textoHorario =
      apertura && cierre
        ? `${apertura} - ${cierre}`
        : this.translate.instant("DETAILS.CLOSED");

    this.diasSemana = nombresDias.map((nombre) => ({
      dayKey: nombre,
      horario: textoHorario,
    }));
  }

  confirmarReserva(): void {
    if (
      !this.servicio ||
      !this.horaSeleccionada ||
      !this.diaSeleccionado ||
      !this.empleadoSeleccionado ||
      !this.usuarioActual
    ) {
      console.error("Faltan datos para crear la cita");
      return;
    }

    const nuevaCita: Omit<Cita, "id_cita"> = {
      id_usuario: this.usuarioActual.id_usuario,
      id_servicio: this.servicio.id_servicio,
      id_empleado: this.empleadoSeleccionado.id_empleado,
      fecha: this.diaSeleccionado.fecha.toISOString().split("T")[0],
      hora: this.horaSeleccionada,
      estado: "pendiente",
    };

    this.citaService.crearCita(nuevaCita).subscribe({
      next: () => {
        Swal.fire({
          icon: "success",
          title: this.translate.instant("DETAILS.SUCCESS_BOOKING_TITLE"),
          text: this.translate.instant("DETAILS.SUCCESS_BOOKING_TEXT"),
        });
        this.cerrarPopup();
      },
      error: (err) => {
        console.error("Error al crear la cita", err);
        Swal.fire({
          icon: "error",
          title: this.translate.instant("DETAILS.ERROR_TITLE"),
          text: this.translate.instant("DETAILS.ERROR_BOOKING"),
        });
      },
    });
  }

  generarFechas() {
    const dayKeys = [
      "DETAILS.DAY_SUNDAY",
      "DETAILS.DAY_MONDAY",
      "DETAILS.DAY_TUESDAY",
      "DETAILS.DAY_WEDNESDAY",
      "DETAILS.DAY_THURSDAY",
      "DETAILS.DAY_FRIDAY",
      "DETAILS.DAY_SATURDAY",
    ];
    const monthKeys = [
      "DETAILS.MONTH_JANUARY",
      "DETAILS.MONTH_FEBRUARY",
      "DETAILS.MONTH_MARCH",
      "DETAILS.MONTH_APRIL",
      "DETAILS.MONTH_MAY",
      "DETAILS.MONTH_JUNE",
      "DETAILS.MONTH_JULY",
      "DETAILS.MONTH_AUGUST",
      "DETAILS.MONTH_SEPTEMBER",
      "DETAILS.MONTH_OCTOBER",
      "DETAILS.MONTH_NOVEMBER",
      "DETAILS.MONTH_DECEMBER",
    ];
    for (let i = 0; i < 30; i++) {
      const fecha = new Date();
      fecha.setDate(fecha.getDate() + i);
      this.diasDisponibles.push({
        diaKey: dayKeys[fecha.getDay()],
        numero: fecha.getDate(),
        mesKey: monthKeys[fecha.getMonth()],
        fecha,
      });
    }
  }

  seleccionarDia(dia: {
    diaKey: string;
    numero: number;
    mesKey: string;
    fecha: Date;
  }) {
    this.diaSeleccionado = dia;
    this.turnoSeleccionado = null;
    this.horasDisponibles = [];
    this.horaSeleccionada = null;
  }

  seleccionarEmpleado(empleado: Empleado) {
    this.empleadoSeleccionado = empleado;
    this.horaSeleccionada = null;
    this.horasDisponibles = [];
    if (this.turnoSeleccionado) {
      this.seleccionarTurno(this.turnoSeleccionado);
    }
  }

  private getTimeSlots(start: string, end: string): string[] {
    const slots: string[] = [];
    const [h1, m1] = start.split(":").map(Number);
    const [h2, m2] = end.split(":").map(Number);
    let inicioMin = h1 * 60 + m1;
    const finMin = h2 * 60 + m2;
    if (inicioMin >= finMin) return slots;
    while (inicioMin < finMin) {
      const hh = Math.floor(inicioMin / 60);
      const mm = inicioMin % 60;
      slots.push(
        `${String(hh).padStart(2, "0")}:${String(mm).padStart(2, "0")}`
      );
      inicioMin += 30;
    }
    return slots;
  }

  seleccionarTurno(turno: "Mañana" | "Tarde" | "Noche") {
    this.turnoSeleccionado = turno;
    this.horaSeleccionada = null;
    this.horasDisponibles = [];

    if (!this.salon || !this.empleadoSeleccionado) {
      console.error("Falta información de salón o empleado");
      return;
    }
    const dayKeys = [
      "DETAILS.DAY_MONDAY",
      "DETAILS.DAY_TUESDAY",
      "DETAILS.DAY_WEDNESDAY",
      "DETAILS.DAY_THURSDAY",
      "DETAILS.DAY_FRIDAY",
      "DETAILS.DAY_SATURDAY",
      "DETAILS.DAY_SUNDAY",
    ];
    const apertura = this.salon.horario_apertura;
    const cierre = this.salon.horario_cierre;
    let inicioTurno: string;
    let finTurno: string;

    if (turno === "Mañana") {
      inicioTurno = apertura;
      finTurno = "14:00";
    } else if (turno === "Tarde") {
      inicioTurno = "14:00";
      finTurno = cierre < "20:00" ? cierre : "20:00";
    } else {
      inicioTurno = "20:00";
      finTurno = cierre;
    }

    const todosLosSlots = this.getTimeSlots(inicioTurno, finTurno);
    const fechaISO = this.diaSeleccionado.fecha.toISOString().split("T")[0];

    this.citaService
      .getCitasPorEmpleadoYFecha(
        this.empleadoSeleccionado.id_empleado,
        fechaISO
      )
      .subscribe({
        next: (citasExistentes: Cita[]) => {
          const filtradas = citasExistentes.filter(
            (c) =>
              c.id_empleado === this.empleadoSeleccionado!.id_empleado &&
              c.fecha === fechaISO
          );
          const horasOcupadas = filtradas.map((c) => c.hora);
          this.horasDisponibles = todosLosSlots.filter(
            (slot) => !horasOcupadas.includes(slot)
          );
        },
        error: (err) => {
          console.error("Error al consultar citas existentes:", err);
          this.horasDisponibles = todosLosSlots;
        },
      });
  }

  seleccionarHora(hora: string) {
    this.horaSeleccionada = hora;
  }

  fetchCitasUsuarioParaSalon(idUsuario: number, idSalon: number) {
    this.citaService.getCitasPorUsuario(idUsuario).subscribe({
      next: (citas: Cita[]) => {
        this.servicioService.getServiciosPorSalon(idSalon).subscribe({
          next: (servs: Servicio[]) => {
            const idsServiciosSalon = servs.map((s) => s.id_servicio);
            this.citasDeUsuario = citas.filter((c) =>
              idsServiciosSalon.includes(c.id_servicio)
            );
            const elegibles = this.citasDeUsuario.filter(
              (c) => c.estado !== "cancelada" && c.fecha < this.todayIso
            );
            const serviciosConResena = this.resenas.map((r) =>
              Number(r.id_servicio)
            );
            this.citasPasadasSinResenar = elegibles.filter(
              (c) => !serviciosConResena.includes(c.id_servicio)
            );
          },
          error: (err) =>
            console.error("Error al cargar servicios para filtrar citas:", err),
        });
      },
      error: (err) => console.error("Error al cargar citas del usuario:", err),
    });
  }

  onSubmitResena(cita: Cita, rating: number, comentario: string) {
    if (!this.usuarioActual) {
      Swal.fire({
        icon: "info",
        title: this.translate.instant("DETAILS.LOGIN_TITLE"),
        text: this.translate.instant("DETAILS.LOGIN_TEXT"),
      });
      return;
    }

    const payload: Partial<Resena> = {
      id_usuario: this.usuarioActual.id_usuario.toString(),
      id_servicio: cita.id_servicio.toString(),
      comentario: comentario,
      calificacion: rating,
      fecha_resena: this.todayIso,
    };

    this.resenaService.crearResena(payload).subscribe({
      next: (nuevaResena) => {
        Swal.fire({
          icon: "success",
          title: this.translate.instant("DETAILS.REVIEW_THANKS_TITLE"),
          text: this.translate.instant("DETAILS.REVIEW_THANKS_TEXT"),
        });
        if (this.salon) {
          this.fetchResenas(this.salon.id_salon);
        }
      },
      error: (err) => {
        console.error("Error al enviar reseña:", err);
        if (err.status === 403) {
          Swal.fire({
            icon: "warning",
            title: this.translate.instant("DETAILS.REVIEW_FORBIDDEN_TITLE"),
            text: this.translate.instant("DETAILS.REVIEW_FORBIDDEN"),
          });
        } else if (err.status === 422) {
          Swal.fire({
            icon: "warning",
            title: this.translate.instant("DETAILS.REVIEW_INVALID_TITLE"),
            text: this.translate.instant("DETAILS.REVIEW_INVALID"),
          });
        } else {
          Swal.fire({
            icon: "error",
            title: this.translate.instant("DETAILS.ERROR_TITLE"),
            text: this.translate.instant("DETAILS.REVIEW_ERROR"),
          });
        }
      },
    });
  }

  getNombreServicioPorId(idServicio: number): string {
    const srv = this.servicios.find((s) => s.id_servicio === idServicio);
    return srv ? srv.nombre : "—";
  }
}
