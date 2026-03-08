import { ComponentFixture, TestBed } from '@angular/core/testing';

import { HomeMobilityReviewSeeComponent } from './home-mobility-review-see.component';

describe('HomeMobilityReviewSeeComponent', () => {
  let component: HomeMobilityReviewSeeComponent;
  let fixture: ComponentFixture<HomeMobilityReviewSeeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [HomeMobilityReviewSeeComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(HomeMobilityReviewSeeComponent);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
