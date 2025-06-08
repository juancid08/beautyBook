import {
  AfterViewInit,
  Component,
  ElementRef,
  Renderer2,
  ViewChild,
} from "@angular/core";
import { Router } from "@angular/router";

@Component({
  selector: "app-footer",
  standalone: true,
  imports: [],
  templateUrl: "./footer.component.html",
  styleUrls: ["./footer.component.scss"],
})
export class FooterComponent implements AfterViewInit {
  @ViewChild("footer") footerElement!: ElementRef;

  constructor(private router: Router, private renderer: Renderer2) {}

  navigateTo(path: string) {
    this.router.navigate(["/" + path]);
  }

  ngAfterViewInit(): void {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            this.renderer.addClass(this.footerElement.nativeElement, "visible");
          }
        });
      },
      { threshold: 0.2 }
    );

    observer.observe(this.footerElement.nativeElement);
  }
}
