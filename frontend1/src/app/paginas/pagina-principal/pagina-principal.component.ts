import {
  Component, OnInit, OnDestroy, AfterViewInit, Inject, PLATFORM_ID,
  ViewChild, ElementRef
} from '@angular/core';
import { isPlatformBrowser } from '@angular/common';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { FooterComponent } from "../../componentes/footer/footer.component";
import anime from 'animejs/lib/anime.es.js';
import { AuthService } from '../../services/auth.service';
import { SalonService, Salon } from '../../services/salon.service';

@Component({
  selector: 'app-pagina-principal',
  standalone: true,
  imports: [CommonModule, FormsModule, FooterComponent],
  templateUrl: './pagina-principal.component.html',
  styleUrls: ['./pagina-principal.component.scss']
})
export class PaginaPrincipalComponent implements OnInit, OnDestroy, AfterViewInit {
  @ViewChild('bgVideo') bgVideo!: ElementRef<HTMLVideoElement>;
  @ViewChild('logoSvg') logoSvg!: ElementRef<SVGSVGElement>;
  @ViewChild('cardsContainer') cardsContainer!: ElementRef<HTMLDivElement>;

  searchTerm = '';
  categories = ['Peluquería', 'Barbería', 'Salón de uñas', 'Depilación', 'Cejas y pestañas'];
  selectedCategory: string | null = null;

  phrases = [
    'Encuentra tu estilista ideal cerca de ti.',
    'Reserva tu cita en un click.',
    'Expertos en belleza y bienestar.'
  ];

  displayedText = '';
  private phraseIndex = 0;
  private charIndex = 0;
  private typingTimer: any;
  private deletingTimer: any;

  salons: Salon[] = [];

  usuarioActual: any = "";

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

    this.authSvc.currentUser$.subscribe(usuario => {
      this.usuarioActual = usuario;
    });

    this.fetchSalons();
  }

fetchSalons() {
  this.salonService.getSalones().subscribe(data => {
    this.salons = data.map(salon => {
      let fotoUrl = '/assets/default.webp';

      if (salon.foto) {
          const fileName = salon.foto.split('/').pop() || salon.foto;
          fotoUrl = `http://localhost/storage/salones/${fileName}`;
        }
      
      return {
        ...salon,
        rating: Math.random() * (5 - 3.5) + 3.5,
        foto: fotoUrl,
        liked: false
      };
    });
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
    this.router.navigate(['/detallesBarberia', salon.id_salon]);
  }

  goPerfil() {
    this.router.navigate(['/perfil']);
  }

  onSearch() {
    // lógica de búsqueda si es necesaria
  }

  filterBy(cat: string) {
    this.selectedCategory = cat;
    this.onSearch();
  }

  onLogin() {
    this.router.navigate(['/login']);
  }

  onRegister() {
    this.router.navigate(['/register']);
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
      behavior: 'smooth'
    });
  }

  scrollRight() {
    const container = this.cardsContainer.nativeElement;
    container.scrollBy({
      left: 300,
      behavior: 'smooth'
    });
  }

  private animateLogo() {
    if (!this.logoSvg) return;

    anime.timeline({ loop: false })
      .add({
        targets: this.logoSvg.nativeElement.querySelectorAll('text'),
        translateY: [-20, 0],
        opacity: [0, 1],
        easing: 'easeOutExpo',
        duration: 1200,
        delay: anime.stagger(300)
      })
      .add({
        targets: this.logoSvg.nativeElement.querySelector('path'),
        strokeDashoffset: [anime.setDashoffset, 0],
        easing: 'easeInOutSine',
        duration: 1500,
        delay: 200
      });
  }
}
