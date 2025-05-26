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
import { AuthService } from '../../services/auth.service'; // Suponiendo que así se llama tu servicio de auth
import { Resena, ResenaService } from '../../services/resena.service';
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

  turnoSeleccionado: string | null = null;
  horasDisponibles: string[] = [];
  horaSeleccionada: string | null = null;

  diaSeleccionado: any;

  salon: Salon | undefined;

  servicio: Servicio | undefined;
  servicios: Servicio[] = [];

  resena: Resena | undefined;
  resenas: Resena[] = [];

  empleadoSeleccionado: Empleado | undefined;
  empleados: Empleado[] = [];

  constructor(
    private route: ActivatedRoute, 
    private authSvc: AuthService,
    private salonService: SalonService ,
    private servicioService: ServicioService,
    private empleadoService: EmpleadoService,
    private resenaService: ResenaService,
    private citaService: CitaService
  ) {
    this.generarFechas();
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

  fetchSalon(salonId: number): void{
    this.salonService.getSalon(salonId).subscribe({
      next: salon => {
        this.salon = salon;
        console.log('Datos del salón:', this.salon);
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
        console.log('Servicios del salón:', this.servicios);
        this.fetchResenas(salonId);
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
        this.empleadoSeleccionado = empleados[0];
        console.log('Empleados:', this.empleados);
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
        console.log('Reseñas del salón:', this.resenas);
      },
      error: err => {
        console.error('Error al cargar las reseñas:', err);
      }
    });
  }

  abrirPopup(servicio: Servicio) {
    this.servicio = servicio;
    this.mostrarPopup = true;
  }

  cerrarPopup() {
    this.mostrarPopup = false;
    this.turnoSeleccionado = null;
    this.horaSeleccionada = null;
  }

  confirmarReserva(): void {
    
    if (!this.servicio || !this.horaSeleccionada || !this.diaSeleccionado || !this.empleadoSeleccionado || !this.usuarioActual) {
      console.error('Faltan datos para crear la cita');
      return;
    }

    const nuevaCita = {
      id_usuario: this.usuarioActual.id_usuario,
      id_servicio: this.servicio.id_servicio,
      id_empleado: this.empleadoSeleccionado.id_empleado,
      fecha: this.diaSeleccionado.fecha.toISOString().split('T')[0],
      hora: this.horaSeleccionada,
      estado: 'pendiente' as 'pendiente'
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
    const opciones: Intl.DateTimeFormatOptions = { weekday: 'long', day: 'numeric', month: 'long' };
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
  

  seleccionarDia(dia: any) {
    this.diaSeleccionado = dia;
  }

  seleccionarTurno(turno: string) {
    this.turnoSeleccionado = turno;
    this.horaSeleccionada = null;

    if (turno === 'Mañana') {
      this.horasDisponibles = ['9:00', '9:30', '10:00', '10:30'];
    } else if (turno === 'Tarde') {
      this.horasDisponibles = ['16:00', '16:30', '17:00', '17:30'];
    } else if (turno === 'Noche') {
      this.horasDisponibles = ['19:00', '19:30', '20:00'];
    }
  }

  seleccionarHora(hora: string) {
    this.horaSeleccionada = hora;
  }

  seleccionarEmpleado(empleado: any) {
    this.empleadoSeleccionado = empleado;
  }
}
