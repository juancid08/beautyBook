import { Component } from '@angular/core';
import { NavbarComponent } from "../../componentes/navbar/navbar.component";
import { AccordionComponent } from "../../componentes/accordion/accordion.component";
import { FooterComponent } from "../../componentes/footer/footer.component";

@Component({
  selector: 'app-politica-de-privacidad',
  standalone: true,
  imports: [NavbarComponent, AccordionComponent, FooterComponent],
  templateUrl: './politica-de-privacidad.component.html',
  styleUrl: './politica-de-privacidad.component.scss'
})
export class PoliticaDePrivacidadComponent {

}
