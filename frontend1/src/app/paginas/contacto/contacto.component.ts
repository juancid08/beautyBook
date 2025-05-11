import { Component } from '@angular/core';
import { NavbarComponent } from "../../componentes/navbar/navbar.component";
import { FooterComponent } from '../../componentes/footer/footer.component';
import { AccordionComponent } from '../../componentes/accordion/accordion.component';
@Component({
  selector: 'app-contacto',
  standalone: true,
  imports: [NavbarComponent,FooterComponent,AccordionComponent],
  templateUrl: './contacto.component.html',
  styleUrl: './contacto.component.scss'
})
export class ContactoComponent {

}
