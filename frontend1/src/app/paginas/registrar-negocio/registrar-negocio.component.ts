import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { NavbarComponent } from "../../componentes/navbar/navbar.component";
import { FooterComponent } from '../../componentes/footer/footer.component';
import { AuthService } from '../../services/auth.service';
import { SalonService } from '../../services/salon.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-registrar-negocio',
  standalone: true,
  templateUrl: './registrar-negocio.component.html',
  styleUrls: ['./registrar-negocio.component.scss'],
  imports: [CommonModule, FormsModule, NavbarComponent, FooterComponent]
})
export class RegistrarNegocioComponent implements OnInit {
  paso = 1;
  usuario: any = null;
  imagenPreview: string | null = null;

  especializaciones = [
    { nombre: 'Salón de uñas', valor: 'Salon de uñas', imagen: 'http://localhost/storage/especializacion_salon/uñas.png' },
    { nombre: 'Peluquería', valor: 'Peluquería', imagen: 'http://localhost/storage/especializacion_salon/peluqueria.png' },
    { nombre: 'Cejas y pestañas', valor: 'Cejas y pestañas', imagen: 'http://localhost/storage/especializacion_salon/cejas_pestañas.png' },
    { nombre: 'Barbería', valor: 'Barbería', imagen: 'http://localhost/storage/especializacion_salon/barberia.png' },
    { nombre: 'Depilacion', valor: 'Depilación', imagen: 'http://localhost/storage/especializacion_salon/depilacion.png' },
  ];

  datosNegocio = {
    tipo: '', // especializacion
    nombre: '',
    direccion: '',
    cif: '',
    telefono: '',
    email: '',
    descripcion: '',
    horario_apertura: '',
    horario_cierre: '',
    foto: null as string | null, // ahora guardamos base64 string
  };

  mensajeExito = '';
  mensajeError = '';
  cargando = false;

  constructor(private authSvc: AuthService, private salonSvc: SalonService, private router: Router) {}

  ngOnInit(): void {
    console.log('RegistrarNegocioComponent initialized');
    this.authSvc.currentUser$.subscribe(usuario => {
      this.usuario = usuario;
      console.log('Usuario cargado:', this.usuario);
    });
  }

  seleccionarTipo(valor: string) {
    console.log('Tipo seleccionado:', valor);
    this.datosNegocio.tipo = valor;
    this.paso = 2;
    this.mensajeError = '';
    this.mensajeExito = '';
  }

  onFileChange(event: any) {
    console.log('onFileChange event:', event);
    const file = event.target.files && event.target.files.length ? event.target.files[0] : null;
    if (file) {
      console.log('Archivo seleccionado:', file);
      const reader = new FileReader();
      reader.onload = () => {
        this.imagenPreview = reader.result as string;
        this.datosNegocio.foto = this.imagenPreview; // guardamos base64 string
        console.log('Imagen cargada y convertida a base64:', this.imagenPreview);
      };
      reader.readAsDataURL(file);
    }
  }

  registrarSalon() {
    this.mensajeError = '';
    this.mensajeExito = '';

    console.log('Intentando registrar salón con datos:', this.datosNegocio);
    console.log('Usuario actual:', this.usuario);

    const {
      nombre, direccion, cif, telefono, email, descripcion, tipo, horario_apertura, horario_cierre, foto,
    } = this.datosNegocio;

    if (!nombre || !direccion || !cif || !telefono || !email || !tipo || !horario_apertura || !horario_cierre || !this.usuario?.id_usuario) {
      this.mensajeError = 'Todos los campos obligatorios deben completarse';
      console.warn('Error: campos obligatorios incompletos o usuario no definido');
      console.log('Campos recibidos:', { nombre, direccion, cif, telefono, email, tipo, horario_apertura, horario_cierre, usuarioId: this.usuario?.id_usuario });
      return;
    }

    if (!foto || typeof foto !== 'string') {
      this.mensajeError = 'Debe subir una imagen válida.';
      console.warn('Error: foto inválida o no cargada');
      return;
    }

    const payload = {
      nombre,
      direccion,
      cif,
      telefono,
      email,
      descripcion,
      especializacion: tipo,
      horario_apertura,
      horario_cierre,
      id_usuario: this.usuario.id_usuario,
      foto,
    };

    console.log('Payload a enviar al servicio:', payload);

    this.cargando = true;
    this.salonSvc.crearSalon(payload).subscribe({
      next: () => {
        this.mensajeExito = 'Negocio registrado con éxito';
        this.cargando = false;
        console.log('Salón registrado correctamente');
        this.router.navigate(['/']);
      },
      error: (error) => {
        console.error('Error al crear salón:', error);
        this.mensajeError = 'Error al registrar el negocio: ' + (error.error?.message || 'Inténtalo de nuevo.');
        this.cargando = false;
      }
    });
  }
}
