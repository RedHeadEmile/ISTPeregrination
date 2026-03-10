import {Component, inject, OnInit, signal} from '@angular/core';
import {ButtonDirective} from "primeng/button";
import {TableModule} from "primeng/table";
import {ApiService} from '../core/services/api.service';
import {DialogService} from 'primeng/dynamicdialog';
import {MobilityReviewModel} from '../core/models/mobility-review.model';
import {
  AdminMobilityReviewManagementComponent
} from './admin-mobility-review-management/admin-mobility-review-management.component';
import {App} from '../app';

@Component({
  selector: 'app-admin-mobility-review-list',
  imports: [
    TableModule,
    ButtonDirective
  ],
  templateUrl: './admin-mobility-review-list-page.component.html',
  styleUrl: './admin-mobility-review-list-page.component.less',
})
export class AdminMobilityReviewListPageComponent implements OnInit {
  private readonly _apiService = inject(ApiService);
  private readonly _dialogService = inject(DialogService);

  mobilityReviews = signal<MobilityReviewModel[]>([]);

  private async _pullMobilityReviews(): Promise<void> {
    this.mobilityReviews.set(await this._apiService.getMobilityReviews());
  }

  async ngOnInit(): Promise<void> {
    await this._pullMobilityReviews();
  }

  getCountryName(countryID: string): string {
    return App.countryNames[countryID] ?? countryID;
  }

  see(mobilityReview: MobilityReviewModel): void {
    this._dialogService.open(
      AdminMobilityReviewManagementComponent,
      {
        header: 'Mobilité',
        modal: true,
        draggable: false,
        focusOnShow: false,
        closable: true,
        closeOnEscape: true,
        width: '55rem',
        inputValues: {
          mobilityReview: mobilityReview,
        }
      }
    )?.onClose.subscribe(async (actionDone: boolean) => {
      if (actionDone)
        await this._pullMobilityReviews();
    });
  }
}
