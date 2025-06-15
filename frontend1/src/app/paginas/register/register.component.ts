import { Component, ViewEncapsulation } from "@angular/core";
import { CommonModule } from "@angular/common";
import { FormsModule, NgForm } from "@angular/forms";
import { Router } from "@angular/router";
import { AuthService } from "../../services/auth.service";
import { TranslateModule, TranslateService } from "@ngx-translate/core";

@Component({
  selector: "app-register",
  standalone: true,
  imports: [CommonModule, FormsModule, TranslateModule],
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
  validationErrorKeys: string[] = [];

  constructor(
    private router: Router,
    private authService: AuthService,
    private translate: TranslateService
  ) {}

  onRegister(form: NgForm) {
    this.validationErrorKeys = [];

    if (!this.nombre) {
      this.validationErrorKeys.push("REGISTER.ERROR_NAME_REQUIRED");
    }
    if (!this.apellidos) {
      this.validationErrorKeys.push("REGISTER.ERROR_LASTNAME_REQUIRED");
    }
    if (!this.email) {
      this.validationErrorKeys.push("REGISTER.ERROR_EMAIL_REQUIRED");
    } else if (form.form.controls["email"].errors?.["email"]) {
      this.validationErrorKeys.push("REGISTER.ERROR_EMAIL_INVALID");
    }
    if (!this.password) {
      this.validationErrorKeys.push("REGISTER.ERROR_PASSWORD_REQUIRED");
    } else if (this.password.length < 7) {
      this.validationErrorKeys.push("REGISTER.ERROR_PASSWORD_MINLENGTH");
    }
    if (!this.password_confirmation) {
      this.validationErrorKeys.push("REGISTER.ERROR_CONFIRM_REQUIRED");
    } else if (this.password_confirmation.length < 7) {
      this.validationErrorKeys.push("REGISTER.ERROR_CONFIRM_MINLENGTH");
    }
    if (
      this.password &&
      this.password_confirmation &&
      this.password !== this.password_confirmation
    ) {
      this.validationErrorKeys.push("REGISTER.ERROR_PASSWORD_MISMATCH");
    }

    if (this.validationErrorKeys.length) {
      return;
    }

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
              msgs.forEach((m) => {
                this.validationErrorKeys.push("REGISTER.ERROR_SERVER");
              });
            }
          } else {
            this.validationErrorKeys.push("REGISTER.ERROR_SERVER");
          }
        },
      });
  }

  goBack() {
    this.router.navigate(["/"]);
  }
}
