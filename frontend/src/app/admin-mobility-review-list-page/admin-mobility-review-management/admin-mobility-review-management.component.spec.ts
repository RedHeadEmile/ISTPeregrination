import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminMobilityReviewManagementComponent } from './admin-mobility-review-management.component';

describe('AdminMobilityReviewManagementComponent', () => {
  let component: AdminMobilityReviewManagementComponent;
  let fixture: ComponentFixture<AdminMobilityReviewManagementComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AdminMobilityReviewManagementComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AdminMobilityReviewManagementComponent);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
