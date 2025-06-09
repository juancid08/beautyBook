// src/app/componentes/navbar-superior/navbar-superior.component.ts
import {
  Component,
  OnInit,
  OnDestroy,
  AfterViewInit,
  Inject,
  PLATFORM_ID,
  ViewChild,
  ElementRef,
  CUSTOM_ELEMENTS_SCHEMA,
} from "@angular/core";
import { isPlatformBrowser, CommonModule } from "@angular/common";
import { Router } from "@angular/router";
import anime from "animejs/lib/anime.es.js";
import { AuthService } from "../../services/auth.service";
import { Subscription } from "rxjs";

@Component({
  selector: "app-navbar-superior",
  standalone: true,
  imports: [CommonModule],
  schemas: [CUSTOM_ELEMENTS_SCHEMA],
  templateUrl: "./navbar-superior.component.html",
  styleUrls: ["./navbar-superior.component.scss"],
})
export class NavbarSuperiorComponent
  implements OnInit, OnDestroy, AfterViewInit
{
  @ViewChild("logoSvg") logoSvg!: ElementRef<SVGSVGElement>;

  usuarioActual: any = "";
  idiomaActual: "es" | "en" = "es";
  private userSub!: Subscription;

  constructor(
    @Inject(PLATFORM_ID) private platformId: any,
    private router: Router,
    private authSvc: AuthService
  ) {}

  ngOnInit() {
    this.userSub = this.authSvc.currentUser$.subscribe((u) => {
      this.usuarioActual = u;
    });
  }

  ngAfterViewInit() {
    if (isPlatformBrowser(this.platformId) && this.logoSvg) {
      anime
        .timeline({ loop: false })
        .add({
          targets: this.logoSvg.nativeElement.querySelectorAll("text"),
          translateY: [-20, 0],
          opacity: [0, 1],
          easing: "easeOutExpo",
          duration: 1200,
          delay: anime.stagger(300),
        })
        .add({
          targets: this.logoSvg.nativeElement.querySelector("path"),
          strokeDashoffset: [anime.setDashoffset, 0],
          easing: "easeInOutSine",
          duration: 1500,
          delay: 200,
        });
    }
  }

  ngOnDestroy() {
    if (this.userSub) {
      this.userSub.unsubscribe();
    }
  }

  goHome() {
    this.router.navigate(["/"]);
  }

  goPerfil() {
    this.router.navigate(["/perfil"]);
  }

  toggleIdioma(): void {
    this.idiomaActual = this.idiomaActual === "es" ? "en" : "es";
  }

  onLogin() {
    this.router.navigate(["/login"]);
  }

  onRegister() {
    this.router.navigate(["/register"]);
  }

  logout() {
    this.authSvc.logout();
  }
}
