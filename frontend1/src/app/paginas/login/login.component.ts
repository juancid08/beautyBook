// src/app/login/login.component.ts
import { Component, ViewEncapsulation } from '@angular/core';
import { CommonModule }                  from '@angular/common';
import { FormsModule, NgForm }          from '@angular/forms';
import { HttpClientModule }             from '@angular/common/http';
import { Router }                       from '@angular/router';
import { AuthService }                  from '../../services/auth.service';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [
    CommonModule,
    FormsModule,
    HttpClientModule
  ],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
  encapsulation: ViewEncapsulation.None
})
export class LoginComponent {
  email = '';
  password = '';
  errorMsg = '';

  constructor(
    private authService: AuthService,
    private router: Router
  ) {}

  onLogin(form: NgForm) {
    if (!form.valid) return;

    this.authService.login(this.email, this.password)
      .subscribe({
        next: () => this.router.navigate(['/']),
        error: err => this.errorMsg = err.error?.email || 'Error en el inicio de sesión'
      });
  }

  onRegister() {
    this.router.navigate(['/register']);
  }

  goBack() {
    this.router.navigate(['/']);
  }
}
