import { Component, OnInit } from '@angular/core';
import { NavbarComponent } from "../../componentes/navbar/navbar.component";
import { FooterComponent } from '../../componentes/footer/footer.component';
import { AuthService } from '../../services/auth.service';
import { Cita, CitaService } from '../../services/cita.service';
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
  usuario: any = null;
  imagenSeleccionada: File | null = null;
  previewUrl: string | null = null;
  citas: Cita[] = [];
  serviciosMap: Record<number, string> = {};
  empleadosMap: Record<number, string> = {};
  constructor(
    private authSvc: AuthService, 
    private citaService: CitaService
  ) {}

  ngOnInit(): void {
    this.authSvc.currentUser$.subscribe((usuario) => {
      this.usuario = { ...usuario };
      this.previewUrl = usuario?.foto_perfil ?? null;
          
      if (this.usuario?.id_usuario) {
        this.fetchCitas(this.usuario.id_usuario);
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

  fetchCitas(idUsuario: number): void {
    this.citaService.getCitasPorUsuario(idUsuario).subscribe({
      next: (citas) => {
        this.citas = citas;
        console.log('Citas del usuario:', citas);
      },
      error: (err) => {
        console.error('Error al cargar las citas del usuario', err);
      }
    });
  }

  cargarNombresServiciosYEmpleados(): void {
    const idsServicio = [...new Set(this.citas.map(c => c.id_servicio))];
    const idsEmpleado = [...new Set(this.citas.map(c => c.id_empleado))];

    idsServicio.forEach(id => {
      this.citaService.getNombreServicio(id).subscribe(nombre => {
        this.serviciosMap[id] = nombre;
      });
    });

    idsEmpleado.forEach(id => {
      this.citaService.getNombreEmpleado(id).subscribe(nombre => {
        this.empleadosMap[id] = nombre;
      });
    });
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