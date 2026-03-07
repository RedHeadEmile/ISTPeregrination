import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminMobilityReviewListPageComponent } from './admin-mobility-review-list-page.component';

describe('AdminMobilityReviewList', () => {
  let component: AdminMobilityReviewListPageComponent;
  let fixture: ComponentFixture<AdminMobilityReviewListPageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AdminMobilityReviewListPageComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AdminMobilityReviewListPageComponent);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
