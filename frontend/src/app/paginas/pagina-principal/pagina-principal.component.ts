import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-pagina-principal',
  templateUrl: './pagina-principal.component.html',
  styleUrls: ['./pagina-principal.component.scss'] 
})

export class PaginaPrincipalComponent implements OnInit{
  frases: string[] = [
    "Bienvenido a BeautyBook",
    "Descubre los mejores salones de belleza",
    "Tu belleza está en buenas manos",
    "Haz crecer tu negocio con BeautyBook",
    "Registra tu salón y empieza a recibir clientes"
  ];

  currentFrase: string = '';

  currentIndex: number = 0;

  constructor() { }

  ngOnInit(): void {
    this.cambiarFrase();
    setInterval(() => {
      this.cambiarFrase();
    }, 5000);
  }

  cambiarFrase(): void {
    this.currentFrase = this.frases[this.currentIndex];
    this.currentIndex = (this.currentIndex + 1) % this.frases.length;  
  }
}

