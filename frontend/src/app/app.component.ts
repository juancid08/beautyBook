import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';

@Component({
  selector: 'app-root',
  standalone: true,              // ← aquí
  imports: [ RouterOutlet ],      // ← ya Angular lo aceptará
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']  // ← corrige el typo
})
export class AppComponent {
  title = 'frontend';
}
