import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { NavbarComponent } from "../../componentes/navbar/navbar.component";
import { FooterComponent } from '../../componentes/footer/footer.component';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-detalles-barberia',
  standalone: true,
  imports: [NavbarComponent, FooterComponent, CommonModule, FormsModule],
  templateUrl: './detalles-barberia.component.html',
  styleUrls: ['./detalles-barberia.component.scss']
})
export class DetallesBarberiaComponent {
  mostrarPopup = false;

  // Generación de fechas próximas
  diasDisponibles: { dia: string, numero: number, mes: string, fecha: Date }[] = [];

  turnoSeleccionado: string | null = null;
  horasDisponibles: string[] = [];
  horaSeleccionada: string | null = null;

  empleados = [
    { nombre: 'Juan Pérez', foto: '/assets/image/empleados/juan.jpg' },
    { nombre: 'Carlos García', foto: '/assets/image/empleados/carlos.jpg' },
    { nombre: 'María López', foto: '/assets/image/empleados/maria.jpg' },
  ];
  empleadoSeleccionado = this.empleados[0];

  diaSeleccionado: any;

  constructor(private router: Router) {
    this.generarFechas();
    this.diaSeleccionado = this.diasDisponibles[0];

  }

  abrirPopup() {
    this.mostrarPopup = true;
  }

  cerrarPopup() {
    this.mostrarPopup = false;
    this.turnoSeleccionado = null;
    this.horaSeleccionada = null;
  }

  generarFechas() {
    const opciones: Intl.DateTimeFormatOptions = { weekday: 'long', day: 'numeric', month: 'long' };
    for (let i = 0; i < 30; i++) { // Cambiado de 7 a 30 días
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
