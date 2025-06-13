import {
  AfterViewInit,
  Component,
  ElementRef,
  Renderer2,
  ViewChild,
  Inject,
  PLATFORM_ID,
} from "@angular/core";
import { Router } from "@angular/router";
import { TranslateModule, TranslateService } from "@ngx-translate/core";

@Component({
  selector: "app-footer",
  standalone: true,
  imports: [TranslateModule],
  templateUrl: "./footer.component.html",
  styleUrls: ["./footer.component.scss"],
})
export class FooterComponent implements AfterViewInit {
  @ViewChild("footer") footerElement!: ElementRef;
  currentYear = new Date().getFullYear();

  constructor(
    private router: Router,
    private renderer: Renderer2,
    private translate: TranslateService
  ) {}

  navigateTo(path: string) {
    this.router.navigate(["/" + path]);
  }

  ngAfterViewInit(): void {
    const observer = new IntersectionObserver(
      (entries, obs) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            this.renderer.addClass(this.footerElement.nativeElement, "visible");
            obs.unobserve(entry.target);
          } else {
            this.renderer.removeClass(
              this.footerElement.nativeElement,
              "visible"
            );
          }
        });
      },
      { threshold: 0.2 }
    );
    observer.observe(this.footerElement.nativeElement);
  }

  goHome() {
    this.router.navigate(["/"]);
  }
}
