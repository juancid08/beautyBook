import { Component, ViewEncapsulation } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss'],
  encapsulation: ViewEncapsulation.None
})
export class RegisterComponent {
  nombre = ''; 
  apellidos = ''; 
  email = ''; 
  password = ''; 
  password_confirmation = ''; 
  errorMsg = ''; 

  constructor(
    private router: Router,
    private authService: AuthService
  ) {}

  onRegister(form: NgForm) {
    if (!form.valid) return;

    this.authService
      .register(
        this.nombre,
        this.apellidos,
        this.email,
        this.password,
        this.password_confirmation
      )
      .subscribe({
        next: () => this.router.navigate(['/']), 
        error: err => {
          const errors = err.error?.errors;
          this.errorMsg = errors
            ? Object.values(errors).flat().join(' ')
            : 'Error en el registro';
        }
      });
  }

  goBack() {
    this.router.navigate(['/']); // Método para volver atrás
  }
}
