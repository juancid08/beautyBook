import { Component, ViewEncapsulation } from '@angular/core';
import { CommonModule }                  from '@angular/common';
import { FormsModule, NgForm }           from '@angular/forms';
import { Router }                        from '@angular/router';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [ CommonModule, FormsModule ],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
  encapsulation: ViewEncapsulation.None    
})
export class LoginComponent {
  email: string    = '';
  password: string = '';

  constructor(private router: Router) {}

  onLogin(form: NgForm) {
    if (form.valid) {
      console.log('Login con', this.email, this.password);
      this.router.navigate(['/']);
    }
  }

  onRegister() {
    this.router.navigate(['/register']);
  }

  goBack() {
    this.router.navigate(['/']);
  }
}
