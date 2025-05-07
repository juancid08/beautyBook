import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-detalles-barberia',
  standalone: true,
  imports: [],
  templateUrl: './detalles-barberia.component.html',
  styleUrl: './detalles-barberia.component.scss'
})
export class DetallesBarberiaComponent {
  constructor(private router: Router) {}

  goHome() {
    this.router.navigate(['/']);
  }
  
}
