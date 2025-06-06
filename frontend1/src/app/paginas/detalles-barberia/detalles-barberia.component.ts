// src/app/pages/detalles-barberia/detalles-barberia.component.ts
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { NavbarComponent } from "../../componentes/navbar/navbar.component";
import { FooterComponent } from '../../componentes/footer/footer.component';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { Salon, SalonService } from '../../services/salon.service';
import { Servicio, ServicioService } from '../../services/servicio.service';
import { Empleado, EmpleadoService } from '../../services/empleado.service';
import { Cita, CitaService } from '../../services/cita.service';
import { AuthService } from '../../services/auth.service';
import { Resena, ResenaService } from '../../services/resena.service';

import { DomSanitizer, SafeResourceUrl } from '@angular/platform-browser';

@Component({
  selector: 'app-detalles-barberia',
  standalone: true,
  imports: [NavbarComponent, FooterComponent, CommonModule, FormsModule],
  templateUrl: './detalles-barberia.component.html',
  styleUrls: ['./detalles-barberia.component.scss']
})
export class DetallesBarberiaComponent implements OnInit {
  // —–––––––––––––– Variables de control de sesión y datos —––––––––––––––—
  usuarioActual: any = null;               // Rellenado desde AuthService.currentUser$
  salon: Salon | undefined;
  servicios: Servicio[] = [];
  empleados: Empleado[] = [];
  resenas: Resena[] = [];                  // Reseñas cargadas para este salón

  citasDeUsuario: Cita[] = [];             // Todas las citas de este usuario
  citasPasadasSinResenar: Cita[] = [];      // Filtradas: fecha pasada, no cancelada, y sin reseña

  // Helpers de fecha
  todayIso: string = new Date().toISOString().split('T')[0]; // "YYYY-MM-DD"

  // —–––––––––––––– Variables para reserva de cita (ya las tenías) —––––––––––––––—
  mostrarPopup = false;
  diasDisponibles: { dia: string, numero: number, mes: string, fecha: Date }[] = [];
  turnosDisponibles: Array<'Mañana' | 'Tarde' | 'Noche'> = ['Mañana', 'Tarde', 'Noche'];
  diasSemana: Array<{ nombre: string; horario: string }> = [];

  turnoSeleccionado: 'Mañana' | 'Tarde' | 'Noche' | null = null;
  horasDisponibles: string[] = [];
  horaSeleccionada: string | null = null;

  diaSeleccionado: { dia: string, numero: number, mes: string, fecha: Date };

  servicio: Servicio | undefined;
  empleadoSeleccionado: Empleado | undefined;

  mapUrl!: SafeResourceUrl | null;

  constructor(
    private route: ActivatedRoute,
    private authSvc: AuthService,
    private salonService: SalonService,
    private servicioService: ServicioService,
    private empleadoService: EmpleadoService,
    private citaService: CitaService,
    private resenaService: ResenaService,
    private sanitizer: DomSanitizer
  ) {
    // Generamos los próximos 30 días (para el popup de reserva)
    this.generarFechas();
    this.diaSeleccionado = this.diasDisponibles[0];
  }

  ngOnInit(): void {
    // 1) Suscribirnos a cambios del usuario logueado:
    this.authSvc.currentUser$.subscribe(usuario => {
      this.usuarioActual = usuario;
      // Si ya tenemos el salón cargado, recalculemos citas elegibles:
      if (usuario && this.salon) {
        this.fetchCitasUsuarioParaSalon(usuario.id_usuario, this.salon.id_salon);
      }
    });

    // 2) Leer el parámetro 'id' de la ruta para cargar datos del salón:
    this.route.paramMap.subscribe(params => {
      const id = params.get('id');
      if (id) {
        const salonId = +id;
        this.fetchSalon(salonId);
        this.fetchServicios(salonId);
        this.fetchEmpleados(salonId);
        this.fetchResenas(salonId);
        // Las citas del usuario se cargarán cuando se conozca this.usuarioActual
      }
    });
  }

  // —–––––––––––––– Métodos para cargar datos de salón, servicios, empleados y reseñas —––––––––––––––—

  fetchSalon(salonId: number): void {
    this.salonService.getSalon(salonId).subscribe({
      next: salon => {
        this.salon = this.salonService.getSalonFormateado(salon);

        // Generar URL del mapa embebido:
        const direccionEncode = encodeURIComponent(this.salon!.direccion);
        const urlEmbed = `https://www.google.com/maps?q=${direccionEncode}&output=embed`;
        this.mapUrl = this.sanitizer.bypassSecurityTrustResourceUrl(urlEmbed);

        // Construir horario semanal (sidebar):
        this.generarHorarioSemanal();

        // Si ya hay un usuario logueado, recalculemos citas elegibles
        if (this.usuarioActual && this.usuarioActual.id_usuario) {
          this.fetchCitasUsuarioParaSalon(this.usuarioActual.id_usuario, salonId);
        }
      },
      error: err => console.error('Error al cargar el salón', err)
    });
  }

  fetchServicios(salonId: number): void {
    this.servicioService.getServiciosPorSalon(salonId).subscribe({
      next: servicios => {
        this.servicios = servicios;
      },
      error: err => console.error('Error al cargar los servicios', err)
    });
  }

  fetchEmpleados(salonId: number): void {
    this.empleadoService.getEmpleadosPorSalon(salonId).subscribe({
      next: empleados => {
        this.empleados = empleados;
        this.empleadoSeleccionado = empleados[0] || undefined;
      },
      error: err => console.error('Error al cargar los empleados', err)
    });
  }

  fetchResenas(salonId: number): void {
    this.resenaService.getResenasPorSalon(salonId).subscribe({
      next: resenas => {
        this.resenas = resenas;
        // Una vez que cargamos las reseñas existentes, recalculamos las citas pendientes de reseñar
        if (this.usuarioActual && this.usuarioActual.id_usuario && this.salon) {
          this.fetchCitasUsuarioParaSalon(this.usuarioActual.id_usuario, this.salon.id_salon);
        }
      },
      error: err => {
        console.error('Error al cargar las reseñas', err);
        this.resenas = [];
      }
    });
  }

  // —–––––––––––––– Reserva de cita (métodos ya los tenías) —––––––––––––––—

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
      'Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'
    ];
    const apertura = this.salon.horario_apertura;
    const cierre   = this.salon.horario_cierre;
    const textoHorario = apertura && cierre ? `${apertura} - ${cierre}` : 'Cerrado';
    this.diasSemana = nombresDias.map(dia => ({
      nombre: dia,
      horario: textoHorario
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
      console.error('Faltan datos para crear la cita');
      return;
    }

    const nuevaCita: Omit<Cita, 'id_cita'> = {
      id_usuario: this.usuarioActual.id_usuario,
      id_servicio: this.servicio.id_servicio,
      id_empleado: this.empleadoSeleccionado.id_empleado,
      fecha: this.diaSeleccionado.fecha.toISOString().split('T')[0],
      hora: this.horaSeleccionada,
      estado: 'pendiente'
    };

    this.citaService.crearCita(nuevaCita).subscribe({
      next: () => {
        alert('Cita reservada con éxito.');
        this.cerrarPopup();
      },
      error: err => {
        console.error('Error al crear la cita', err);
        alert('Ocurrió un error al reservar la cita.');
      }
    });
  }

  generarFechas() {
    for (let i = 0; i < 30; i++) {
      const fecha = new Date();
      fecha.setDate(fecha.getDate() + i);
      this.diasDisponibles.push({
        dia: fecha.toLocaleDateString('es-ES', { weekday: 'long' }),
        numero: fecha.getDate(),
        mes: fecha.toLocaleDateString('es-ES', { month: 'long' }),
        fecha
      });
    }
  }

  seleccionarDia(dia: { dia: string; numero: number; mes: string; fecha: Date }) {
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
    const [h1, m1] = start.split(':').map(Number);
    const [h2, m2] = end.split(':').map(Number);
    let inicioMin = h1 * 60 + m1;
    const finMin = h2 * 60 + m2;
    if (inicioMin >= finMin) return slots;
    while (inicioMin < finMin) {
      const hh = Math.floor(inicioMin / 60);
      const mm = inicioMin % 60;
      slots.push(`${String(hh).padStart(2, '0')}:${String(mm).padStart(2, '0')}`);
      inicioMin += 30;
    }
    return slots;
  }

  seleccionarTurno(turno: 'Mañana' | 'Tarde' | 'Noche') {
    this.turnoSeleccionado = turno;
    this.horaSeleccionada = null;
    this.horasDisponibles = [];

    if (!this.salon || !this.empleadoSeleccionado) {
      console.error('Falta información de salón o empleado');
      return;
    }

    const apertura = this.salon.horario_apertura;
    const cierre   = this.salon.horario_cierre;

    let inicioTurno: string;
    let finTurno: string;

    if (turno === 'Mañana') {
      inicioTurno = apertura;
      finTurno    = '14:00';
    } else if (turno === 'Tarde') {
      inicioTurno = '14:00';
      finTurno    = cierre < '20:00' ? cierre : '20:00';
    } else {
      inicioTurno = '20:00';
      finTurno    = cierre;
    }

    const todosLosSlots = this.getTimeSlots(inicioTurno, finTurno);
    const fechaISO = this.diaSeleccionado.fecha.toISOString().split('T')[0];

    this.citaService.getCitasPorEmpleadoYFecha(this.empleadoSeleccionado.id_empleado, fechaISO)
      .subscribe({
        next: (citasExistentes: Cita[]) => {
          const filtradas = citasExistentes.filter(c =>
            c.id_empleado === this.empleadoSeleccionado!.id_empleado &&
            c.fecha === fechaISO
          );
          const horasOcupadas = filtradas.map(c => c.hora);
          this.horasDisponibles = todosLosSlots.filter(slot => !horasOcupadas.includes(slot));
          if (this.horasDisponibles.length === 0) {
            console.warn(`No hay horas libres para ${turno} en ${fechaISO}`);
          }
        },
        error: err => {
          console.error('Error al consultar citas existentes:', err);
          this.horasDisponibles = todosLosSlots;
        }
      });
  }

  seleccionarHora(hora: string) {
    this.horaSeleccionada = hora;
  }

  // —–––––––––––––– NUEVOS MÉTODOS PARA RESEÑAS —––––––––––––––—

  /** 
   * 1) Carga todas las citas de este usuario, filtra las de este salón,
   *    luego selecciona solo aquellas con fecha pasada, estado distinto de 'cancelada'
   *    y cuyo servicio aún no tenga reseña hecha por este usuario.
   */
  fetchCitasUsuarioParaSalon(idUsuario: number, idSalon: number) {
    this.citaService.getCitasPorUsuario(idUsuario).subscribe({
      next: (citas: Cita[]) => {
        // 1.1) Obtener todos los servicios de este salón
        this.servicioService.getServiciosPorSalon(idSalon).subscribe({
          next: (servs: Servicio[]) => {
            const idsServiciosSalon = servs.map(s => s.id_servicio);

            // 1.2) Filtrar solo las citas de este usuario cuyo servicio pertenezca a este salón
            this.citasDeUsuario = citas.filter(c =>
              idsServiciosSalon.includes(c.id_servicio)
            );

            // 1.3) Quedarnos solo con las que ya pasaron de fecha y no están canceladas
            const elegibles = this.citasDeUsuario.filter(c =>
              c.estado !== 'cancelada' &&
              c.fecha < this.todayIso
            );

            // 1.4) De las reseñas ya cargadas (this.resenas), ver qué servicios ya tienen reseña de este usuario
            //      (no usamos id_cita, sino id_servicio como clave única).
            const serviciosConResena = this.resenas.map(r => Number(r.id_servicio));

            // 1.5) Finalmente, de “elegibles” quedarnos sólo con aquellos cuyo id_servicio
            //      NO aparezca en serviciosConResena (es decir, aún no hay reseña para ese servicio):
            this.citasPasadasSinResenar = elegibles.filter(c =>
              !serviciosConResena.includes(c.id_servicio)
            );
          },
          error: err => console.error('Error al cargar servicios para filtrar citas:', err)
        });
      },
      error: err => console.error('Error al cargar citas del usuario:', err)
    });
  }

  /**
   * 2) Envía la nueva reseña al backend. Luego recarga las reseñas del salón y recalcula
   *    las citas pendientes de reseñar.
   */
  onSubmitResena(cita: Cita, rating: number, comentario: string) {
    if (!this.usuarioActual) {
      alert('Debes iniciar sesión para dejar una reseña.');
      return;
    }

    // Construir payload según tu ResenaService (sin id_cita, enviamos id_usuario e id_servicio)
    const payload: Partial<Resena> = {
      id_usuario: this.usuarioActual.id_usuario.toString(),
      id_servicio: cita.id_servicio.toString(),
      comentario: comentario,
      calificacion: rating,
      fecha_resena: this.todayIso // o bien usar backend para asignar fecha actual
    };

    this.resenaService.crearResena(payload).subscribe({
      next: nuevaResena => {
        alert('Gracias por tu reseña.');
        // 2.1) Recargar reseñas de este salón
        if (this.salon) {
          this.fetchResenas(this.salon.id_salon);
        }
      },
      error: err => {
        console.error('Error al enviar reseña:', err);
        if (err.status === 403) {
          alert('No puedes crear una reseña si no has asistido a ese servicio.');
        } else if (err.status === 422) {
          alert('Datos inválidos o ya existe reseña para este servicio.');
        } else {
          alert('Ocurrió un error al enviar tu reseña.');
        }
      }
    });
  }

  /** 
   * Devuelve el nombre de un servicio dado su ID, o '—' si no se encuentra 
   */
  getNombreServicioPorId(idServicio: number): string {
    const srv = this.servicios.find(s => s.id_servicio === idServicio);
    return srv ? srv.nombre : '—';
  }
}
