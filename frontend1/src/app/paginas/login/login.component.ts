import { Component, ViewEncapsulation } from "@angular/core";
import { CommonModule } from "@angular/common";
import { FormsModule, NgForm } from "@angular/forms";
import { Router } from "@angular/router";
import { AuthService } from "../../services/auth.service";
import { TranslateModule, TranslateService } from "@ngx-translate/core";

@Component({
  selector: "app-login",
  standalone: true,
  imports: [CommonModule, FormsModule, TranslateModule],
  templateUrl: "./login.component.html",
  styleUrls: ["./login.component.scss"],
  encapsulation: ViewEncapsulation.None,
})
export class LoginComponent {
  email = "";
  password = "";

  // En lugar de un mensaje literal, guardamos la clave + params
  errorMsgKey = "";
  errorMsgParams: any = {};

  constructor(
    private authService: AuthService,
    private router: Router,
    private translate: TranslateService
  ) {}

  onLogin(form: NgForm) {
    if (!form.valid) return;

    this.authService.login(this.email, this.password).subscribe({
      next: () => this.router.navigate(["/"]),
      error: (err) => {
        if (err.error?.email) {
          this.errorMsgKey = "LOGIN.ERROR_INVALID_EMAIL";
          this.errorMsgParams = { email: err.error.email };
        } else {
          this.errorMsgKey = "LOGIN.ERROR_GENERIC";
          this.errorMsgParams = {};
        }
      },
    });
  }

  onRegister() {
    this.router.navigate(["/register"]);
  }

  goBack() {
    this.router.navigate(["/"]);
  }
}
