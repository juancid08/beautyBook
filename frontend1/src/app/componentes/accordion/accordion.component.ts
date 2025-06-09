import { CommonModule } from "@angular/common";
import { Component } from "@angular/core";
import { Router, RouterModule } from "@angular/router";

@Component({
  selector: "app-accordion",
  standalone: true,
  imports: [RouterModule, CommonModule],
  templateUrl: "./accordion.component.html",
  styleUrls: ["./accordion.component.scss"],
})
export class AccordionComponent {
  links = [
    { label: "Quiénes Somos", path: "/quienesSomos" },
    { label: "Política de privacidad", path: "/politicaDePrivacidad" },
    { label: "Contacto", path: "/contacto" },
    { label: "Preguntas frecuentes", path: "/preguntasFrecuentes" },
  ];

  constructor(private router: Router) {}

  isActive(path: string): boolean {
    return this.router.url === path;
  }
}
