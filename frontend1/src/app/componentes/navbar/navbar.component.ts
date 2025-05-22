import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.scss'
})
export class NavbarComponent {
  usuarioActual: any = "";

  constructor(private router: Router, private authSvc: AuthService ){}

  ngOnInit() {
  this.authSvc.currentUser$.subscribe(usuario => {
    this.usuarioActual = usuario;
  });
}

  onLogin() {
    this.router.navigate(['/login']);
  }

  onRegister() {
    this.router.navigate(['/register']);
  }

  logout(){
    this.authSvc.logout();
  }
}
