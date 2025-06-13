import { CommonModule } from "@angular/common";
import { Component } from "@angular/core";
import { Router, RouterModule } from "@angular/router";
import { TranslateModule } from "@ngx-translate/core";

@Component({
  selector: "app-accordion",
  standalone: true,
  imports: [RouterModule, CommonModule, TranslateModule],
  templateUrl: "./accordion.component.html",
  styleUrls: ["./accordion.component.scss"],
})
export class AccordionComponent {
  links = [
    { labelKey: "ACCORDION.QUIENES_SOMOS", path: "/quienesSomos" },
    {
      labelKey: "ACCORDION.POLITICA_PRIVACIDAD",
      path: "/politicaDePrivacidad",
    },
    { labelKey: "ACCORDION.CONTACTO", path: "/contacto" },
    {
      labelKey: "ACCORDION.PREGUNTAS_FRECUENTES",
      path: "/preguntasFrecuentes",
    },
  ];

  constructor(private router: Router) {}

  isActive(path: string): boolean {
    return this.router.url === path;
  }
}
