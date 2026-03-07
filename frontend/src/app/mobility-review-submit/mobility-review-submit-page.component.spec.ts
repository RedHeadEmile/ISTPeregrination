import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MobilityReviewSubmitPageComponent } from './mobility-review-submit-page.component';

describe('MobilityReviewSubmit', () => {
  let component: MobilityReviewSubmitPageComponent;
  let fixture: ComponentFixture<MobilityReviewSubmitPageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [MobilityReviewSubmitPageComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MobilityReviewSubmitPageComponent);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
