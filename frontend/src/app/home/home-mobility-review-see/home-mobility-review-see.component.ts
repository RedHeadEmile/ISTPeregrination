import {Component, inject, model} from '@angular/core';
import {ButtonDirective} from "primeng/button";
import {MobilityReviewForm} from "../../mobility-review-submit/mobility-review-form/mobility-review-form";
import {DynamicDialogRef} from 'primeng/dynamicdialog';
import {MobilityReviewModel} from '../../core/models/mobility-review.model';

@Component({
  selector: 'app-home-mobility-review-see.component',
    imports: [
        ButtonDirective,
        MobilityReviewForm
    ],
  templateUrl: './home-mobility-review-see.component.html',
  styleUrl: './home-mobility-review-see.component.less',
})
export class HomeMobilityReviewSeeComponent {

  ref = inject(DynamicDialogRef);

  mobilityReview = model.required<MobilityReviewModel>();

  close(): void {
    this.ref.close();
  }
}
