import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DetallesBarberiaComponent } from './detalles-barberia.component';

describe('DetallesBarberiaComponent', () => {
  let component: DetallesBarberiaComponent;
  let fixture: ComponentFixture<DetallesBarberiaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [DetallesBarberiaComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(DetallesBarberiaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
