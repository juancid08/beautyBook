import { Component, OnInit } from '@angular/core';
import { NavbarComponent } from "../../componentes/navbar/navbar.component";
import { FooterComponent } from '../../componentes/footer/footer.component';
import { AuthService } from '../../services/auth.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-registrar-negocio',
  standalone: true,
  templateUrl: './registrar-negocio.component.html',
  styleUrls: ['./registrar-negocio.component.scss'],
  imports: [NavbarComponent, FooterComponent, CommonModule, FormsModule]
})
export class RegistrarNegocioComponent implements OnInit {
  // Variables de control
  usuario: any = null;

  constructor(
    private authSvc: AuthService, 
  ) {}

  ngOnInit(): void {
    this.authSvc.currentUser$.subscribe((usuario) => {
      this.usuario = { ...usuario };
    });
  }

}