import { Component, OnInit } from "@angular/core";
import { NavbarComponent } from "../../componentes/navbar/navbar.component";
import { FooterComponent } from "../../componentes/footer/footer.component";
import { AccordionComponent } from "../../componentes/accordion/accordion.component";

import AOS from "aos";
import "aos/dist/aos.css";

@Component({
  selector: "app-preguntas-frecuentes",
  standalone: true,
  imports: [NavbarComponent, FooterComponent, AccordionComponent],
  templateUrl: "./preguntas-frecuentes.component.html",
  styleUrl: "./preguntas-frecuentes.component.scss",
})
export class PreguntasFrecuentesComponent implements OnInit {
  ngOnInit(): void {
    AOS.init({
      duration: 1000,
      once: true,
    });
  }
}
