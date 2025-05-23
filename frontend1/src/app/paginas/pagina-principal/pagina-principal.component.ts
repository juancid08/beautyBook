import {
  Component,
  OnInit,
  OnDestroy,
  AfterViewInit,
  Inject,
  PLATFORM_ID,
  ViewChild,
  ElementRef
} from '@angular/core';
import { isPlatformBrowser } from '@angular/common';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { FooterComponent } from "../../componentes/footer/footer.component";
import anime from 'animejs/lib/anime.es.js';
import { AuthService } from '../../services/auth.service';

interface Salon {
  id: number;
  name: string;
  street: string;
  rating: number;
  imageUrl: string;
  liked: boolean;
}

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

  salons: Salon[] = [
    { id: 1, name: 'BeautySalon A', street: 'Calle Mayor 1', rating: 4.5, imageUrl: '/assets/image/salon1.webp', liked: false },
    { id: 2, name: 'Barbería B', street: 'Calle Luna 23', rating: 4.0, imageUrl: '/assets/image/salon2.webp', liked: false },
    { id: 3, name: 'Nails & Spa', street: 'Calle Sol 45', rating: 5.0, imageUrl: '/assets/image/salon3.webp', liked: false },
    { id: 4, name: 'Moreno Stilistas', street: 'Calle Mercurio 9', rating: 5.0, imageUrl: '/assets/image/salon4.webp', liked: true },
    { id: 5, name: 'Rose Skin Barbershop', street: 'Calle Sondalezas 37', rating: 4.65, imageUrl: '/assets/image/salon5.webp', liked: false },
    { id: 6, name: 'Rasec Barbershop', street: 'Calle Montería 20', rating: 4.9, imageUrl: '/assets/image/salon6.webp', liked: false },
    { id: 7, name: 'No Limits Hair Studio', street: 'Calle Vicavaro 37', rating: 4.8, imageUrl: '/assets/image/salon7.webp', liked: false },
    { id: 8, name: 'Jonhy García Barber`S', street: 'Calle Virgen de la montaña 37', rating: 4.2, imageUrl: '/assets/image/salon8.webp', liked: false }
  ];

  usuarioActual: any = "";

  constructor(
    @Inject(PLATFORM_ID) private platformId: any,
    private router: Router,
    private authSvc: AuthService
  ) {}

  ngOnInit() {
    if (isPlatformBrowser(this.platformId)) {
      this.startTyping();
    }

    this.authSvc.currentUser$.subscribe(usuario => {
      this.usuarioActual = usuario;
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

  goBarberShopDetails() {
    this.router.navigate(['/detallesBarberia']);
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

  
  logout(){
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
