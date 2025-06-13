// src/app/pages/pagina-principal/pagina-principal.component.ts
import {
  Component,
  OnInit,
  OnDestroy,
  AfterViewInit,
  ViewChild,
  ElementRef,
  CUSTOM_ELEMENTS_SCHEMA,
  Inject,
  PLATFORM_ID,
} from "@angular/core";
import { isPlatformBrowser } from "@angular/common";
import { CommonModule } from "@angular/common";
import { FormsModule } from "@angular/forms";
import { Router } from "@angular/router";
import { FooterComponent } from "../../componentes/footer/footer.component";
import { SalonService, Salon } from "../../services/salon.service";
import { Subject, Subscription, of, forkJoin } from "rxjs";
import {
  debounceTime,
  distinctUntilChanged,
  switchMap,
  map,
} from "rxjs/operators";
import { NavbarSuperiorComponent } from "../../componentes/navbar-superior/navbar-superior.component";
import { AuthService } from "../../services/auth.service";
import { ResenaService } from "../../services/resena.service";
import { TranslateModule, TranslateService } from "@ngx-translate/core";

// Tipo extendido para incluir la media de reseñas
type SalonConMedia = Salon & { mediaResena: number };

@Component({
  selector: "app-pagina-principal",
  standalone: true,
  imports: [
    CommonModule,
    FormsModule,
    NavbarSuperiorComponent,
    FooterComponent,
    TranslateModule,
  ],
  schemas: [CUSTOM_ELEMENTS_SCHEMA],
  templateUrl: "./pagina-principal.component.html",
  styleUrls: ["./pagina-principal.component.scss"],
})
export class PaginaPrincipalComponent
  implements OnInit, OnDestroy, AfterViewInit
{
  @ViewChild("bgVideo") bgVideo!: ElementRef<HTMLVideoElement>;
  @ViewChild("cardsContainer") cardsContainer!: ElementRef<HTMLDivElement>;

  searchTerm = "";

  categories = [
    { value: "Peluquería", labelKey: "CATEGORIES.Peluqueria" },
    { value: "Barbería", labelKey: "CATEGORIES.Barberia" },
    { value: "Salón de uñas", labelKey: "CATEGORIES.SalonDeUnas" },
    { value: "Depilación", labelKey: "CATEGORIES.Depilacion" },
    { value: "Cejas y pestañas", labelKey: "CATEGORIES.CejasYPestanas" },
  ];

  selectedCategory: string | null = null;

  private phrases = ["PAGE.PHRASE1", "PAGE.PHRASE2", "PAGE.PHRASE3"];
  displayedText = "";
  private phraseIndex = 0;
  private charIndex = 0;
  private typingTimer: any;
  private deletingTimer: any;

  salones: SalonConMedia[] = [];
  usuarioActual: any = "";
  tieneSalon: boolean | null = null;

  sugerencias: string[] = [];
  private searchTerm$ = new Subject<string>();
  private sugSub!: Subscription;

  constructor(
    @Inject(PLATFORM_ID) private platformId: any,
    private router: Router,
    private salonService: SalonService,
    private authSvc: AuthService,
    private resenaService: ResenaService,
    private translate: TranslateService
  ) {}

  ngOnInit() {
    if (isPlatformBrowser(this.platformId)) {
      this.startTyping();
    }

    this.authSvc.currentUser$.subscribe((usuario) => {
      this.usuarioActual = usuario;

      if (!usuario) {
        this.tieneSalon = false;
      } else {
        this.salonService.getSalonesPorUsuario(usuario.id_usuario).subscribe({
          next: (salones) => {
            this.tieneSalon = salones.length > 0;
          },
          error: (err) => {
            console.error("Error al comprobar salones del usuario", err);
            this.tieneSalon = false;
          },
        });
      }
      this.translate
        .get(this.phrases) // ['PAGE.PHRASE1', 'PAGE.PHRASE2', ...]
        .subscribe((res: any) => {
          // res es { 'PAGE.PHRASE1': 'Encuentra tu estilista…', … }
          this.phrases = this.phrases.map((key) => res[key]);
          this.startTyping();
        });
    });

    this.fetchSalones();

    this.sugSub = this.searchTerm$
      .pipe(
        debounceTime(300),
        distinctUntilChanged(),
        switchMap((term) => {
          const t = term.trim().toLowerCase();
          return t ? this.salonService.buscarNombresSugeridos(t) : of([]);
        })
      )
      .subscribe((nombres) => {
        this.sugerencias = nombres;
      });
  }

  ngAfterViewInit() {
    if (isPlatformBrowser(this.platformId)) {
      this.cambiarVideoSegunDispositivo();
    }
  }

  private cambiarVideoSegunDispositivo() {
    if (!this.bgVideo) return;

    const videoElement = this.bgVideo.nativeElement;
    const sourceElement = videoElement.querySelector("source");

    if (this.isMobile()) {
      sourceElement?.setAttribute("src", "/assets/video/video_movil.mp4");
    } else {
      sourceElement?.setAttribute("src", "/assets/video/hero_section.mp4");
    }

    videoElement.load();
  }

  private isMobile(): boolean {
    return window.innerWidth <= 768;
  }

  ngOnDestroy() {
    clearTimeout(this.typingTimer);
    clearTimeout(this.deletingTimer);
    if (this.sugSub) this.sugSub.unsubscribe();
  }

  private startTyping() {
    const key = this.phrases[this.phraseIndex];
    const current = this.translate.instant(key);
    if (this.charIndex < current.length) {
      this.displayedText += current[this.charIndex++];
      this.typingTimer = setTimeout(() => this.startTyping(), 80);
    } else {
      this.typingTimer = setTimeout(() => this.startDeleting(), 2000);
    }
  }

  private startDeleting() {
    const key = this.phrases[this.phraseIndex];
    const current = this.translate.instant(key);
    if (this.charIndex > 0) {
      this.displayedText = this.displayedText.slice(0, -1);
      this.charIndex--;
      this.deletingTimer = setTimeout(() => this.startDeleting(), 40);
    } else {
      this.phraseIndex = (this.phraseIndex + 1) % this.phrases.length;
      this.typingTimer = setTimeout(() => this.startTyping(), 500);
    }
  }

  goBarberShopDetails(salon: Salon) {
    this.router.navigate(["/detallesBarberia", salon.id_salon]);
  }

  onSearch() {
    const termino = this.searchTerm.trim().toLowerCase();
    if (!termino) {
      this.fetchSalones();
      return;
    }

    this.salonService.buscarSalonesPorNombre(termino).subscribe((salones) => {
      if (salones.length === 1) {
        this.router.navigate(["/detallesBarberia", salones[0].id_salon]);
      } else {
        this.salones = salones as SalonConMedia[];
        this.selectedCategory = null;
      }
    });
  }

  setSearchOnly(nombre: string) {
    this.searchTerm = nombre;
    this.sugerencias = [];
  }

  onSearchSuggest() {
    this.searchTerm$.next(this.searchTerm);
  }

  selectSugerencia(nombre: string) {
    this.searchTerm = nombre;
    this.sugerencias = [];
    this.salonService
      .buscarSalonesPorNombre(nombre.toLowerCase())
      .subscribe((salones) => {
        if (salones.length > 0) {
          this.router.navigate(["/detallesBarberia", salones[0].id_salon]);
        }
      });
  }
  selectedCategoryLabelKey: string | null = null;

  filterBy(value: string, labelKey: string) {
    if (this.selectedCategory === value) {
      // deseleccionamos
      this.selectedCategory = null;
      this.selectedCategoryLabelKey = null;
      this.fetchSalones();
    } else {
      // seleccionamos
      this.selectedCategory = value;
      this.selectedCategoryLabelKey = labelKey;
      this.fetchSalones(value);
    }
  }

  // y para el título:
  get tituloCategoria(): string {
    if (this.selectedCategoryLabelKey) {
      return this.translate.instant(this.selectedCategoryLabelKey);
    }
    return this.translate.instant("PAGE.RECOMMENDED");
  }

  onLogin() {
    this.router.navigate(["/login"]);
  }

  onRegister() {
    this.router.navigate(["/register"]);
  }

  goPerfil() {
    this.router.navigate(["/perfil"]);
  }

  onRegistrarNegocio() {
    if (!this.usuarioActual) {
      this.router.navigate(["/login"]);
    } else {
      this.router.navigate(["/register-negocio"]);
    }
  }

  logout() {
    this.authSvc.logout();
  }

  toggleLike(salon: Salon) {
    salon.liked = !salon.liked;
  }

  scrollLeft() {
    const container = this.cardsContainer.nativeElement;
    container.scrollBy({
      left: -300,
      behavior: "smooth",
    });
  }

  scrollRight() {
    const container = this.cardsContainer.nativeElement;
    container.scrollBy({
      left: 300,
      behavior: "smooth",
    });
  }

  get mostrarSugerencias(): boolean {
    return (
      this.sugerencias.length > 0 ||
      (!!this.searchTerm && this.sugerencias.length === 0)
    );
  }

  fetchSalones(especializacion?: string): void {
    const obtenerSalones = especializacion
      ? this.salonService.getSalonesFiltrado(especializacion)
      : this.salonService.getSalonesFormateados();

    obtenerSalones.subscribe((salones) => {
      const peticionesConResenas = salones.map((salon) =>
        this.resenaService.getResenasPorSalon(salon.id_salon).pipe(
          map((resenas) => {
            const total = resenas.reduce((sum, r) => sum + r.calificacion, 0);
            const media = resenas.length ? total / resenas.length : 0;

            return {
              ...salon,
              mediaResena: media,
            };
          })
        )
      );

      forkJoin(peticionesConResenas).subscribe((salonesConMedia) => {
        this.salones = salonesConMedia;
      });
    });
  }
}
