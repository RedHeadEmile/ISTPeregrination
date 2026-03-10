import {AfterViewInit, Component, inject, model, signal} from '@angular/core';
import {MobilityReviewForm} from './mobility-review-form/mobility-review-form';
import {MobilityReviewModel} from '../core/models/mobility-review.model';
import {ApiService} from '../core/services/api.service';
import {Button} from 'primeng/button';
import {RouterLink} from '@angular/router';
import {ProgressSpinner} from 'primeng/progressspinner';

@Component({
  selector: 'app-mobility-review-submit',
  imports: [
    MobilityReviewForm,
    Button,
    RouterLink,
    ProgressSpinner
  ],
  templateUrl: './mobility-review-submit-page.component.html',
  styleUrl: './mobility-review-submit-page.component.less',
})
export class MobilityReviewSubmitPageComponent implements AfterViewInit {
  private readonly _apiService = inject(ApiService);

  loading = signal(true);
  showThankYou = signal(false);
  mobilityReview = model<Partial<MobilityReviewModel>>({});

  ngAfterViewInit() {
    setTimeout(() => this.loading.set(false));
  }

  async submitMobilityReview(): Promise<void> {
    await this._apiService.submitMobilityReview(this.mobilityReview() as MobilityReviewModel);
    this.showThankYou.set(true);
  }
}
