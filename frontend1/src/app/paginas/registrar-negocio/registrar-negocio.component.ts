import { Component, OnInit } from "@angular/core";
import { CommonModule } from "@angular/common";
import { FormsModule } from "@angular/forms";
import { NavbarComponent } from "../../componentes/navbar/navbar.component";
import { FooterComponent } from "../../componentes/footer/footer.component";
import { AuthService } from "../../services/auth.service";
import { SalonService } from "../../services/salon.service";
import { Router } from "@angular/router";
import { TranslateModule, TranslateService } from "@ngx-translate/core";
import { NgForm } from "@angular/forms";
interface Especializacion {
  valor: string;
  imagen: string;
  labelKey: string;
}

@Component({
  selector: "app-registrar-negocio",
  standalone: true,
  templateUrl: "./registrar-negocio.component.html",
  styleUrls: ["./registrar-negocio.component.scss"],
  imports: [
    CommonModule,
    FormsModule,
    NavbarComponent,
    FooterComponent,
    TranslateModule,
  ],
})
export class RegistrarNegocioComponent implements OnInit {
  paso = 1;
  usuario: any = null;
  imagenPreview: string | null = null;

  especializaciones: Especializacion[] = [
    {
      valor: "Salón de uñas",
      imagen:
        "https://beautybookadmin.duckdns.org/storage/especializacion_salon/uñas.png",
      labelKey: "REGISTER_BUSINESS.SPEC_SALON_UNAS",
    },
    {
      valor: "Peluquería",
      imagen:
        "https://beautybookadmin.duckdns.org/storage/especializacion_salon/peluqueria.png",
      labelKey: "REGISTER_BUSINESS.SPEC_PELUQUERIA",
    },
    {
      valor: "Cejas y pestañas",
      imagen:
        "https://beautybookadmin.duckdns.org/storage/especializacion_salon/cejas_pestañas.png",
      labelKey: "REGISTER_BUSINESS.SPEC_CEJAS",
    },
    {
      valor: "Barbería",
      imagen:
        "https://beautybookadmin.duckdns.org/storage/especializacion_salon/barberia.png",
      labelKey: "REGISTER_BUSINESS.SPEC_BARBERIA",
    },
    {
      valor: "Depilación",
      imagen:
        "https://beautybookadmin.duckdns.org/storage/especializacion_salon/depilacion.png",
      labelKey: "REGISTER_BUSINESS.SPEC_DEPILACION",
    },
  ];

  datosNegocio = {
    tipo: "", // especializacion
    nombre: "",
    direccion: "",
    cif: "",
    telefono: "",
    email: "",
    descripcion: "",
    horario_apertura: "",
    horario_cierre: "",
    foto: null as string | null,
  };

  mensajeExitoKey = "";
  mensajeErrorKey = "";
  mensajeErrorParams: any[] = [];

  cargando = false;

  constructor(
    private authSvc: AuthService,
    private salonSvc: SalonService,
    private router: Router,
    private translate: TranslateService
  ) {}

  ngOnInit(): void {
    this.authSvc.currentUser$.subscribe((usuario) => {
      this.usuario = usuario;
    });
  }

  seleccionarTipo(valor: string) {
    this.datosNegocio.tipo = valor;
    this.paso = 2;
    this.mensajeErrorKey = "";
    this.mensajeExitoKey = "";
    this.mensajeErrorParams = [];
  }

  onFileChange(event: any) {
    const file =
      event.target.files && event.target.files.length
        ? event.target.files[0]
        : null;
    if (file) {
      const reader = new FileReader();
      reader.onload = () => {
        this.imagenPreview = reader.result as string;
        this.datosNegocio.foto = this.imagenPreview;
      };
      reader.readAsDataURL(file);
    }
  }

  registrarSalon(form: NgForm) {
    if (form.invalid) {
      this.mensajeErrorKey = "REGISTER_BUSINESS.ERROR_REQUIRED";
      return;
    }
    this.mensajeErrorKey = "";
    this.mensajeExitoKey = "";
    this.mensajeErrorParams = [];

    const {
      nombre,
      direccion,
      cif,
      telefono,
      email,
      descripcion,
      tipo,
      horario_apertura,
      horario_cierre,
      foto,
    } = this.datosNegocio;

    if (
      !nombre ||
      !direccion ||
      !cif ||
      !telefono ||
      !email ||
      !tipo ||
      !horario_apertura ||
      !horario_cierre ||
      !this.usuario?.id_usuario
    ) {
      this.mensajeErrorKey = "REGISTER_BUSINESS.ERROR_REQUIRED";
      return;
    }

    if (!foto || typeof foto !== "string") {
      this.mensajeErrorKey = "REGISTER_BUSINESS.ERROR_INVALID_IMAGE";
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

    this.cargando = true;
    this.salonSvc.crearSalon(payload).subscribe({
      next: () => {
        this.mensajeExitoKey = "REGISTER_BUSINESS.SUCCESS_REGISTER";
        this.cargando = false;
        this.router.navigate(["/"]);
      },
      error: (error) => {
        const detalle = error.error?.message || "Try again.";
        this.mensajeErrorKey = "REGISTER_BUSINESS.ERROR_REGISTER";
        this.mensajeErrorParams = [detalle];
        this.cargando = false;
      },
    });
  }
}
