import { Component } from '@angular/core';
import { Router,RouterModule } from '@angular/router';
import { NavbarComponent } from '../../componentes/navbar/navbar.component';
import { FooterComponent } from '../../componentes/footer/footer.component';
@Component({
  selector: 'app-quienes-somos',
  imports: [RouterModule, NavbarComponent,FooterComponent],
  standalone: true,
  templateUrl: './quienes-somos.component.html',
  styleUrls: ['./quienes-somos.component.scss']
})
export class QuienesSomosComponent {
  constructor(private router: Router) {}

  isActive(path: string): boolean {
    return this.router.url === path;
  }
}
