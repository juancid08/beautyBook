import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { NavbarComponent } from "../../componentes/navbar/navbar.component";

@Component({
  selector: 'app-detalles-barberia',
  standalone: true,
  imports: [NavbarComponent],
  templateUrl: './detalles-barberia.component.html',
  styleUrl: './detalles-barberia.component.scss'
})
export class DetallesBarberiaComponent {
  constructor(private router: Router) {}

  goHome() {
    this.router.navigate(['/']);
  }

}
