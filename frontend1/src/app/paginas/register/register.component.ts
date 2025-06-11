import { Component, ViewEncapsulation } from "@angular/core";
import { CommonModule } from "@angular/common";
import { FormsModule, NgForm } from "@angular/forms";
import { Router } from "@angular/router";
import { AuthService } from "../../services/auth.service";

@Component({
  selector: "app-register",
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: "./register.component.html",
  styleUrls: ["./register.component.scss"],
  encapsulation: ViewEncapsulation.None,
})
export class RegisterComponent {
  nombre = "";
  apellidos = "";
  email = "";
  password = "";
  password_confirmation = "";
  validationErrors: string[] = []; // Aquí guardamos todos los errores

  constructor(private router: Router, private authService: AuthService) {}

  onRegister(form: NgForm) {
    // Limpiar errores previos
    this.validationErrors = [];

    // Validación cliente
    if (!this.nombre) {
      this.validationErrors.push("El nombre es obligatorio.");
    }
    if (!this.apellidos) {
      this.validationErrors.push("Los apellidos son obligatorios.");
    }
    if (!this.email) {
      this.validationErrors.push("El correo electrónico es obligatorio.");
    } else if (form.form.controls["email"].errors?.["email"]) {
      this.validationErrors.push("Debe ingresar un correo electrónico válido.");
    }
    if (!this.password) {
      this.validationErrors.push("La contraseña es obligatoria.");
    } else if (this.password.length < 7) {
      this.validationErrors.push(
        "La contraseña debe tener al menos 7 caracteres."
      );
    }
    if (!this.password_confirmation) {
      this.validationErrors.push("Debe repetir la contraseña.");
    } else if (this.password_confirmation.length < 7) {
      this.validationErrors.push(
        "La confirmación debe tener al menos 7 caracteres."
      );
    }
    if (
      this.password &&
      this.password_confirmation &&
      this.password !== this.password_confirmation
    ) {
      this.validationErrors.push("Las contraseñas no coinciden.");
    }

    // Si hay errores de cliente, detenerse aquí
    if (this.validationErrors.length) {
      return;
    }

    // Petición al servidor
    this.authService
      .register(
        this.nombre,
        this.apellidos,
        this.email,
        this.password,
        this.password_confirmation
      )
      .subscribe({
        next: () => this.router.navigate(["/"]),
        error: (err) => {
          const errors = err.error?.errors as
            | Record<string, string[]>
            | undefined;
          if (errors) {
            for (const msgs of Object.values(errors)) {
              msgs.forEach((m) => this.validationErrors.push(m));
            }
          } else {
            this.validationErrors.push("Error en el registro.");
          }
        },
      });
  }

  goBack() {
    this.router.navigate(["/"]);
  }
}
