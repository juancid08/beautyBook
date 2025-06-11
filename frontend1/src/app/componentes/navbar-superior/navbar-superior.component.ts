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
import { SalonService, Salon } from "../../services/salon.service";
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

  usuarioActual: any = null;
  tieneSalon = false;
  idiomaActual: "es" | "en" = "es";

  private userSub!: Subscription;
  private salonSub!: Subscription;

  constructor(
    @Inject(PLATFORM_ID) private platformId: any,
    private router: Router,
    private authSvc: AuthService,
    private salonService: SalonService
  ) {}

  ngOnInit(): void {
    this.userSub = this.authSvc.currentUser$.subscribe((u) => {
      this.usuarioActual = u;
      if (u && u.id_usuario) {
        this.salonSub = this.salonService
          .getSalonesPorUsuario(u.id_usuario)
          .subscribe({
            next: (salones: Salon[]) => {
              this.tieneSalon = salones.length > 0;
            },
            error: () => {
              this.tieneSalon = false;
            },
          });
      } else {
        this.tieneSalon = false;
      }
    });
  }

  ngAfterViewInit(): void {
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

  ngOnDestroy(): void {
    this.userSub?.unsubscribe();
    this.salonSub?.unsubscribe();
  }

  goHome(): void {
    this.router.navigate(["/"]);
  }

  goPerfil(): void {
    this.router.navigate(["/perfil"]);
  }

  onLogin(): void {
    this.router.navigate(["/login"]);
  }

  onRegister(): void {
    this.router.navigate(["/register"]);
  }

  onRegistrarNegocio(): void {
    if (!this.usuarioActual) {
      this.router.navigate(["/login"]);
    } else {
      this.router.navigate(["/register-negocio"]);
    }
  }

  // Toggle de idioma
  toggleIdioma(): void {
    this.idiomaActual = this.idiomaActual === "es" ? "en" : "es";
  }
}
