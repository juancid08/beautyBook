import {
  Component,
  OnInit,
  OnDestroy,
  AfterViewInit,
  Inject,
  PLATFORM_ID,
  ViewChild,
  ElementRef,
} from "@angular/core";
import { isPlatformBrowser } from "@angular/common";
import { CommonModule } from "@angular/common";
import { FormsModule } from "@angular/forms";
import { Router } from "@angular/router";
import { FooterComponent } from "../../componentes/footer/footer.component";
import anime from "animejs/lib/anime.es.js";
import { AuthService } from "../../services/auth.service";
import { SalonService, Salon } from "../../services/salon.service";

// 👇 Añadido para RxJS autocomplete
import { Subject, Subscription, of } from "rxjs";
import { debounceTime, distinctUntilChanged, switchMap } from "rxjs/operators";

@Component({
  selector: "app-pagina-principal",
  standalone: true,
  imports: [CommonModule, FormsModule, FooterComponent],
  templateUrl: "./pagina-principal.component.html",
  styleUrls: ["./pagina-principal.component.scss"],
})
export class PaginaPrincipalComponent
  implements OnInit, OnDestroy, AfterViewInit
{
  @ViewChild("bgVideo") bgVideo!: ElementRef<HTMLVideoElement>;
  @ViewChild("logoSvg") logoSvg!: ElementRef<SVGSVGElement>;
  @ViewChild("cardsContainer") cardsContainer!: ElementRef<HTMLDivElement>;

  searchTerm = "";
  categories = [
    "Peluquería",
    "Barbería",
    "Salón de uñas",
    "Depilación",
    "Cejas y pestañas",
  ];
  selectedCategory: string | null = null;

  phrases = [
    "Encuentra tu estilista ideal cerca de ti.",
    "Reserva tu cita en un click.",
    "Expertos en belleza y bienestar.",
  ];

  displayedText = "";
  private phraseIndex = 0;
  private charIndex = 0;
  private typingTimer: any;
  private deletingTimer: any;

  salones: Salon[] = [];
  usuarioActual: any = "";

  // 👇 Autocomplete
  sugerencias: string[] = [];
  private searchTerm$ = new Subject<string>();
  private sugSub!: Subscription;

  constructor(
    @Inject(PLATFORM_ID) private platformId: any,
    private router: Router,
    private authSvc: AuthService,
    private salonService: SalonService
  ) {}

  ngOnInit() {
    if (isPlatformBrowser(this.platformId)) {
      this.startTyping();
    }

    this.authSvc.currentUser$.subscribe((usuario) => {
      this.usuarioActual = usuario;
    });

    this.fetchSalones();

    // 👇 Suscripción para autocomplete
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
        console.log("🔍 Sugerencias recibidas del servidor:", nombres);
        this.sugerencias = nombres;
      });
  }

  ngAfterViewInit() {
    if (isPlatformBrowser(this.platformId)) {
      this.animateLogo();
    }
  }

  ngOnDestroy() {
    clearTimeout(this.typingTimer);
    clearTimeout(this.deletingTimer);
    if (this.sugSub) this.sugSub.unsubscribe();
  }

  fetchSalones(especializacion?: string): void {
    if (especializacion) {
      this.salonService
        .getSalonesFiltrado(especializacion)
        .subscribe((salones) => {
          this.salones = salones;
        });
    } else {
      this.salonService.getSalonesFormateados().subscribe((salones) => {
        this.salones = salones;
      });
    }
  }

  private startTyping() {
    const current = this.phrases[this.phraseIndex];
    if (this.charIndex < current.length) {
      this.displayedText += current[this.charIndex++];
      this.typingTimer = setTimeout(() => this.startTyping(), 100);
    } else {
      this.typingTimer = setTimeout(() => this.startDeleting(), 2000);
    }
  }

  private startDeleting() {
    if (this.charIndex > 0) {
      this.displayedText = this.displayedText.slice(0, -1);
      this.charIndex--;
      this.deletingTimer = setTimeout(() => this.startDeleting(), 50);
    } else {
      this.phraseIndex = (this.phraseIndex + 1) % this.phrases.length;
      this.typingTimer = setTimeout(() => this.startTyping(), 500);
    }
  }

  goHome() {
    if (this.bgVideo) {
      this.bgVideo.nativeElement.currentTime = 0;
    }
  }

  goBarberShopDetails(salon: Salon) {
    this.router.navigate(["/detallesBarberia", salon.id_salon]);
  }

  goPerfil() {
    this.router.navigate(["/perfil"]);
  }

  onSearch() {
    const termino = this.searchTerm.trim().toLowerCase();
    if (!termino) {
      this.fetchSalones();
      return;
    }
    this.salonService.buscarSalonesPorNombre(termino).subscribe((salones) => {
      this.salones = salones;
      this.selectedCategory = null;
    });
  }

  onSearchSuggest() {
    this.searchTerm$.next(this.searchTerm);
  }

  selectSugerencia(nombre: string) {
    this.searchTerm = nombre;
    this.sugerencias = [];
    // Llamamos al backend para obtener el objeto Salon completo
    this.salonService
      .buscarSalonesPorNombre(nombre.toLowerCase())
      .subscribe((salones) => {
        if (salones.length > 0) {
          this.router.navigate(["/detallesBarberia", salones[0].id_salon]);
        }
      });
  }

  filterBy(cat: string) {
    if (this.selectedCategory === cat) {
      this.selectedCategory = null;
      this.fetchSalones();
    } else {
      this.selectedCategory = cat;
      this.fetchSalones(cat);
    }
  }

  get tituloCategoria(): string {
    return this.selectedCategory ? this.selectedCategory : "Recomendado";
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

  private animateLogo() {
    if (!this.logoSvg) return;
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
