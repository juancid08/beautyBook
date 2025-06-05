import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { NavbarComponent } from "../../componentes/navbar/navbar.component";
import { FooterComponent } from '../../componentes/footer/footer.component';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Salon, SalonService } from '../../services/salon.service';
import { Servicio, ServicioService } from '../../services/servicio.service';
import { Empleado, EmpleadoService } from '../../services/empleado.service';
import { CitaService, Cita } from '../../services/cita.service';
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
export class DetallesBarberiaComponent {
  // Variables de control
  usuarioActual: any;
  mostrarPopup = false;

  // Generación de fechas próximas
  diasDisponibles: { dia: string, numero: number, mes: string, fecha: Date }[] = [];
  turnosDisponibles: Array<'Mañana' | 'Tarde' | 'Noche'> = ['Mañana', 'Tarde', 'Noche'];
  diasSemana: Array<{ nombre: string; horario: string }> = [];

  turnoSeleccionado: 'Mañana' | 'Tarde' | 'Noche' | null = null;
  horasDisponibles: string[] = [];
  horaSeleccionada: string | null = null;

  diaSeleccionado: { dia: string, numero: number, mes: string, fecha: Date };
  
  salon: Salon | undefined;

  servicio: Servicio | undefined;
  servicios: Servicio[] = [];

  resena: Resena | undefined;
  resenas: Resena[] = [];

  empleadoSeleccionado: Empleado | undefined;
  empleados: Empleado[] = [];

  mapUrl!: SafeResourceUrl | null;

  constructor(
    private route: ActivatedRoute,
    private authSvc: AuthService,
    private salonService: SalonService,
    private servicioService: ServicioService,
    private empleadoService: EmpleadoService,
    private resenaService: ResenaService,
    private citaService: CitaService,
    private sanitizer: DomSanitizer
  ) {
    // Generamos los próximos 30 días
    this.generarFechas();
    // Inicialmente seleccionamos el primer día
    this.diaSeleccionado = this.diasDisponibles[0];
  }

  ngOnInit(): void {
    this.route.paramMap.subscribe(params => {
      const id = params.get('id');
      if (id) {
        const salonId = +id;
        this.fetchSalon(salonId);
        this.fetchServicios(salonId);
        this.fetchResenas(salonId);
        this.fetchEmpleados(salonId);
      }
    });

    this.authSvc.currentUser$.subscribe(usuario => {
      this.usuarioActual = usuario;
    });
  }

  fetchSalon(salonId: number): void {
    this.salonService.getSalon(salonId).subscribe({
      next: salon => {
        this.salon = this.salonService.getSalonFormateado(salon);

        // Montamos el mapa
        const direccionEncode = encodeURIComponent(this.salon!.direccion);
        const urlEmbed = `https://www.google.com/maps?q=${direccionEncode}&output=embed`;
        this.mapUrl = this.sanitizer.bypassSecurityTrustResourceUrl(urlEmbed);

        // Construimos horario semanal para la sidebar
        this.generarHorarioSemanal();
      },
      error: err => {
        console.error('Error al cargar el salón', err);
      }
    });
  }

  fetchServicios(salonId: number): void {
    this.servicioService.getServiciosPorSalon(salonId).subscribe({
      next: servicios => {
        this.servicios = servicios;
      },
      error: err => {
        console.error('Error al cargar los servicios', err);
      }
    });
  }

  fetchEmpleados(salonId: number): void {
    this.empleadoService.getEmpleadosPorSalon(salonId).subscribe({
      next: empleados => {
        this.empleados = empleados;
        // Por defecto seleccionamos el primer empleado
        this.empleadoSeleccionado = empleados[0] || undefined;
      },
      error: err => {
        console.error('Error al cargar los empleados:', err);
      }
    });
  }

  fetchResenas(salonId: number): void {
    this.resenaService.getResenasPorSalon(salonId).subscribe({
      next: resenas => {
        this.resenas = resenas;
      },
      error: err => {
        console.error('Error al cargar las reseñas:', err);
      }
    });
  }

  abrirPopup(servicio: Servicio) {
    this.servicio = servicio;
    this.mostrarPopup = true;

    // Limpiamos selección previa
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

  private generarHorarioSemanal() {
    if (!this.salon) {
      this.diasSemana = [];
      return;
    }
    const nombresDias = [
      'Lunes', 'Martes', 'Miércoles', 'Jueves',
      'Viernes', 'Sábado', 'Domingo'
    ];
    const apertura = this.salon.horario_apertura;
    const cierre   = this.salon.horario_cierre;   
    const textoHorario = apertura && cierre
      ? `${apertura} - ${cierre}`
      : 'Cerrado';

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
      fecha: this.diaSeleccionado.fecha.toISOString().split('T')[0], // "YYYY-MM-DD"
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

  /** —————————————— AQUÍ VA LA CORRECCIÓN —————————————— **/
  seleccionarEmpleado(empleado: Empleado) {
    this.empleadoSeleccionado = empleado;
    this.horaSeleccionada = null;
    this.horasDisponibles = [];

    // Si ya había un turno elegido, lo volvemos a recalcular para el nuevo empleado
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

    // 1) Calculamos el inicio/fin del turno
    const apertura = this.salon.horario_apertura; 
    const cierre   = this.salon.horario_cierre;   

    let inicioTurno: string;
    let finTurno: string;

    if (turno === 'Mañana') {
      inicioTurno = apertura;
      finTurno = '14:00';
    } else if (turno === 'Tarde') {
      inicioTurno = '14:00';
      finTurno = cierre < '20:00' ? cierre : '20:00';
    } else {
      inicioTurno = '20:00';
      finTurno = cierre;
    }

    const todosLosSlots = this.getTimeSlots(inicioTurno, finTurno);
    const fechaISO = this.diaSeleccionado.fecha.toISOString().split('T')[0]; // "YYYY-MM-DD"

    // 2) Llamamos al servicio, que nos devuelve *todas* las citas, pero luego filtraremos aquí mismo:
    this.citaService
      .getCitasPorEmpleadoYFecha(this.empleadoSeleccionado.id_empleado, fechaISO)
      .subscribe({
        next: (citasExistentes: Cita[]) => {
          const filtradas = citasExistentes.filter(c =>
            c.id_empleado === this.empleadoSeleccionado!.id_empleado &&
            c.fecha === fechaISO
          );

          // Ahora extraemos únicamente las horas de esas citas “válidas”
          const horasOcupadas = filtradas.map(c => c.hora);

          // Devolvemos solo los slots que NO estén en horasOcupadas
          this.horasDisponibles = todosLosSlots.filter(
            slot => !horasOcupadas.includes(slot)
          );

          // Si no queda ninguno, podrías avisar al usuario, pero no es obligatorio:
          if (this.horasDisponibles.length === 0) {
            console.warn(`No hay horas libres para ${turno} en ${fechaISO} para el empleado ${this.empleadoSeleccionado!.id_empleado}`);
          }
        },
        error: err => {
          console.error('Error al consultar citas existentes:', err);
          // En caso de error, mostramos todos los slots sin filtrar
          this.horasDisponibles = todosLosSlots;
        }
      });
  }

  seleccionarHora(hora: string) {
    this.horaSeleccionada = hora;
  }
}
