import {Component, inject, model, signal} from '@angular/core';
import {MobilityReviewForm} from './mobility-review-form/mobility-review-form';
import {MobilityReviewModel} from '../core/models/mobility-review.model';
import {ApiService} from '../core/services/api.service';
import {Button} from 'primeng/button';
import {RouterLink} from '@angular/router';

@Component({
  selector: 'app-mobility-review-submit',
  imports: [
    MobilityReviewForm,
    Button,
    RouterLink
  ],
  templateUrl: './mobility-review-submit-page.component.html',
  styleUrl: './mobility-review-submit-page.component.less',
})
export class MobilityReviewSubmitPageComponent {
  private readonly _apiService = inject(ApiService);

  showThankYou = signal(false);
  mobilityReview = model<Partial<MobilityReviewModel>>({});

  async submitMobilityReview(): Promise<void> {
    await this._apiService.submitMobilityReview(this.mobilityReview() as MobilityReviewModel);
    this.showThankYou.set(true);
  }
}
