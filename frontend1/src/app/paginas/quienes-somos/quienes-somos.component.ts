import { Component } from '@angular/core';
import { Router,RouterModule } from '@angular/router';
import { NavbarComponent } from '../../componentes/navbar/navbar.component';
import { FooterComponent } from '../../componentes/footer/footer.component';
import { AccordionComponent } from "../../componentes/accordion/accordion.component";
@Component({
  selector: 'app-quienes-somos',
  imports: [RouterModule, NavbarComponent, FooterComponent, AccordionComponent],
  standalone: true,
  templateUrl: './quienes-somos.component.html',
  styleUrls: ['./quienes-somos.component.scss']
})
export class QuienesSomosComponent {
  
}
