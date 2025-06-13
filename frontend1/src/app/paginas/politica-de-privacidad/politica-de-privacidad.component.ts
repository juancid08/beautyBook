import { Component, OnInit } from "@angular/core";
import { NavbarComponent } from "../../componentes/navbar/navbar.component";
import { AccordionComponent } from "../../componentes/accordion/accordion.component";
import { FooterComponent } from "../../componentes/footer/footer.component";
import { TranslateModule, TranslateService } from "@ngx-translate/core";
import AOS from "aos";
import "aos/dist/aos.css";
import { CommonModule } from "@angular/common";

@Component({
  selector: "app-politica-de-privacidad",
  standalone: true,
  imports: [
    NavbarComponent,
    AccordionComponent,
    FooterComponent,
    TranslateModule,
    CommonModule,
  ],
  templateUrl: "./politica-de-privacidad.component.html",
  styleUrl: "./politica-de-privacidad.component.scss",
})
export class PoliticaDePrivacidadComponent implements OnInit {
  ngOnInit(): void {
    AOS.init({
      duration: 1000,
      once: true,
    });
  }
}
