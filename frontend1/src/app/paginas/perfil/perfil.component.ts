import { Component, OnInit } from '@angular/core';
import { NavbarComponent } from "../../componentes/navbar/navbar.component";
import { FooterComponent } from '../../componentes/footer/footer.component';
import { AuthService } from '../../services/auth.service';
import { Cita, CitaService } from '../../services/cita.service';
import { SalonService, Salon } from '../../services/salon.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-perfil',
  standalone: true,
  templateUrl: './perfil.component.html',
  styleUrls: ['./perfil.component.scss'],
  imports: [NavbarComponent, FooterComponent, CommonModule, FormsModule]
})
export class PerfilComponent implements OnInit {
  // Variables de control
  usuario: any = null;
  imagenSeleccionada: File | null = null;
  previewUrl: string | null = null;
  citas: Cita[] = [];
  misSalones: Salon[] = [];
  serviciosMap: Record<number, string> = {};
  empleadosMap: Record<number, string> = {};
  salonEditando: Salon | null = null;
  salonAEliminar: Salon | null = null;
  nombreConfirmacion: string = '';

  constructor(
    private authSvc: AuthService, 
    private citaService: CitaService,
    private salonService: SalonService
  ) {}

  ngOnInit(): void {
    this.authSvc.currentUser$.subscribe((usuario) => {
      this.usuario = { ...usuario };
      this.previewUrl = usuario?.foto_perfil ?? null;
          
      if (this.usuario?.id_usuario) {
        this.fetchCitas(this.usuario.id_usuario);
        this.fetchSalon(this.usuario.id_usuario);
      }
    });
  }

  onFileSelected(event: any): void {
    const file = event.target.files[0];
    if (file) {
      this.imagenSeleccionada = file;

      const reader = new FileReader();
      reader.onload = (e: any) => {
        this.previewUrl = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  }

  guardarCambios(): void {
    const userId = this.usuario.id_usuario;

    if (this.imagenSeleccionada) {
      const formData = new FormData();
      formData.append('nombre', this.usuario.nombre);
      formData.append('email', this.usuario.email);
      formData.append('telefono', this.usuario.telefono);
      formData.append('foto_perfil', this.imagenSeleccionada);

      this.authSvc.actualizarPerfilConImagen(userId, formData).subscribe({
        next: (res) => this.onPerfilActualizado(res),
        error: (err) => this.onError(err)
      });
    } else {
      const body = {
        nombre: this.usuario.nombre,
        email: this.usuario.email,
        telefono: this.usuario.telefono
      };

      this.authSvc.actualizarPerfil(userId, body).subscribe({
        next: (res) => this.onPerfilActualizado(res),
        error: (err) => this.onError(err)
      });
    }
  }

  fetchSalon(idUsuario: number): void {
    this.salonService.getSalonesPorUsuario(idUsuario).subscribe({
      next: salones => {
        this.misSalones = salones;
      },
      error: err => {
        console.error('Error al cargar el salón del usuario', err);
      }
    });
  }

  fetchCitas(idUsuario: number): void {
    this.citaService.getCitasPorUsuario(idUsuario).subscribe({
      next: (citas) => {
        this.citas = citas;
        citas.forEach(cita => {
          this.getNombreServicio(cita.id_servicio);
          this.getNombreEmpleado(cita.id_empleado);
        });
      },
      error: (err) => {
        console.error('Error al cargar las citas del usuario', err);
      }
    });
  }

  getNombreServicio(id: number): void {
    if (!this.serviciosMap[id]) {
      this.citaService.getNombreServicio(id).subscribe({
        next: nombre => this.serviciosMap[id] = nombre,
        error: () => this.serviciosMap[id] = 'Desconocido'
      });
    }
  }

  getNombreEmpleado(id: number): void {
    if (!this.empleadosMap[id]) {
      this.citaService.getNombreEmpleado(id).subscribe({
        next: nombre => this.empleadosMap[id] = nombre,
        error: () => this.empleadosMap[id] = 'Desconocido'
      });
    }
  }

  editarSalon(salon: Salon): void {
    this.salonEditando = { ...salon };
  }


  guardarCambiosSalon(): void {
    if (!this.salonEditando) return;

    const { id_salon, nombre, direccion, telefono, descripcion, especializacion } = this.salonEditando;

    const data = { nombre, direccion, telefono, descripcion, especializacion };

    this.salonService.actualizarSalon(id_salon, data).subscribe({
      next: () => {
        alert('Salón actualizado correctamente');
        this.fetchSalon(this.usuario.id_usuario);
        this.cerrarModal();
      },
      error: (err) => {
        console.error('Error al actualizar el salón', err);
        alert('Hubo un error al actualizar el salón');
      }
    });
  }

  cerrarModal(): void {
    this.salonEditando = null;
  }

  eliminarSalon(salon: Salon): void {
    this.salonAEliminar = salon;
    this.nombreConfirmacion = '';
  }

  confirmarEliminacion(): void {
    if (!this.salonAEliminar) return;

    this.salonService.eliminarSalon(this.salonAEliminar.id_salon).subscribe({
      next: () => {
        alert('Salón eliminado correctamente');
        this.fetchSalon(this.usuario.id_usuario);
        this.cancelarEliminacion();
      },
      error: (err) => {
        console.error('Error al eliminar el salón', err);
        alert('Hubo un error al eliminar el salón');
      }
    });
  }
  
  cancelarEliminacion(): void {
    this.salonAEliminar = null;
    this.nombreConfirmacion = '';
  }

  private onPerfilActualizado(res: any) {
    console.log('Perfil actualizado', res);
    localStorage.setItem('usuario', JSON.stringify(res));
    this.authSvc['currentUserSubject'].next(res);
    this.usuario = { ...res };
    this.previewUrl = res.foto_perfil;
    alert('Cambios guardados correctamente');
  }

  private onError(err: any) {
    console.error('Error al guardar cambios', err);
    console.log('Detalles del error:', err.error);
    alert('Hubo un error al guardar los cambios');
  }
}