import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminPageContainerComponent } from './admin-page-container.component';

describe('AdminPageContainer', () => {
  let component: AdminPageContainerComponent;
  let fixture: ComponentFixture<AdminPageContainerComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AdminPageContainerComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AdminPageContainerComponent);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
