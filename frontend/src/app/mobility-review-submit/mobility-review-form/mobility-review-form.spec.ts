import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MobilityReviewForm } from './mobility-review-form';

describe('MobilityReviewForm', () => {
  let component: MobilityReviewForm;
  let fixture: ComponentFixture<MobilityReviewForm>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [MobilityReviewForm]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MobilityReviewForm);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
