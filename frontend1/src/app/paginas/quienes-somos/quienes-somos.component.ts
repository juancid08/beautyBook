import { Component, OnInit } from "@angular/core";
import { RouterModule } from "@angular/router";
import { NavbarComponent } from "../../componentes/navbar/navbar.component";
import { FooterComponent } from "../../componentes/footer/footer.component";
import { AccordionComponent } from "../../componentes/accordion/accordion.component";

import AOS from "aos";
import "aos/dist/aos.css";

@Component({
  selector: "app-quienes-somos",
  standalone: true,
  imports: [RouterModule, NavbarComponent, FooterComponent, AccordionComponent],
  templateUrl: "./quienes-somos.component.html",
  styleUrls: ["./quienes-somos.component.scss"],
})
export class QuienesSomosComponent implements OnInit {
  ngOnInit(): void {
    AOS.init({
      duration: 1000,
      once: true,
    });
  }
}
