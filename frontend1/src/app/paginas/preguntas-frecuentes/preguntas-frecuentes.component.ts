import { Component, OnInit } from "@angular/core";
import { NavbarComponent } from "../../componentes/navbar/navbar.component";
import { FooterComponent } from "../../componentes/footer/footer.component";
import { AccordionComponent } from "../../componentes/accordion/accordion.component";
import { TranslateModule, TranslateService } from "@ngx-translate/core";
import AOS from "aos";
import "aos/dist/aos.css";
import { CommonModule } from "@angular/common";

@Component({
  selector: "app-preguntas-frecuentes",
  standalone: true,
  imports: [
    NavbarComponent,
    FooterComponent,
    AccordionComponent,
    TranslateModule,
    CommonModule,
  ],
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
  faqs = [
    { question: "FAQ.Q1_QUESTION", answer: "FAQ.Q1_ANSWER" },
    { question: "FAQ.Q2_QUESTION", answer: "FAQ.Q2_ANSWER" },
    { question: "FAQ.Q3_QUESTION", answer: "FAQ.Q3_ANSWER" },
    { question: "FAQ.Q4_QUESTION", answer: "FAQ.Q4_ANSWER" },
  ];
}
