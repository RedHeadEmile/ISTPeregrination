import {AfterViewInit, Component, inject, input, signal} from '@angular/core';
import {ButtonDirective} from "primeng/button";
import {MobilityReviewForm} from "../../mobility-review-submit/mobility-review-form/mobility-review-form";
import {DynamicDialogRef} from 'primeng/dynamicdialog';
import {MobilityReviewModel} from '../../core/models/mobility-review.model';
import {ProgressSpinner} from 'primeng/progressspinner';

@Component({
  selector: 'app-home-mobility-review-see.component',
  imports: [
    ButtonDirective,
    MobilityReviewForm,
    ProgressSpinner
  ],
  templateUrl: './home-mobility-review-see.component.html',
  styleUrl: './home-mobility-review-see.component.less',
})
export class HomeMobilityReviewSeeComponent implements AfterViewInit {

  ref = inject(DynamicDialogRef);

  mobilityReview = input.required<MobilityReviewModel>();
  loaded = signal(false);

  ngAfterViewInit() {
    setTimeout(() => this.loaded.set(true));
  }

  close(): void {
    this.ref.close();
  }
}
