import {AfterViewInit, Component, inject, model, signal} from '@angular/core';
import {MobilityReviewModel} from '../../core/models/mobility-review.model';
import {MobilityReviewForm} from '../../mobility-review-submit/mobility-review-form/mobility-review-form';
import {ButtonDirective} from 'primeng/button';
import {ApiService} from '../../core/services/api.service';
import {DynamicDialogRef} from 'primeng/dynamicdialog';
import {ConfirmationService} from 'primeng/api';
import {ProgressSpinner} from 'primeng/progressspinner';

@Component({
  selector: 'app-admin-mobility-review-management.component',
  imports: [
    MobilityReviewForm,
    ButtonDirective,
    ProgressSpinner
  ],
  templateUrl: './admin-mobility-review-management.component.html',
  styleUrl: './admin-mobility-review-management.component.less',
})
export class AdminMobilityReviewManagementComponent implements AfterViewInit {

  private readonly _apiService = inject(ApiService);
  private readonly _confirmationService = inject(ConfirmationService);

  ref = inject(DynamicDialogRef);

  mobilityReview = model.required<MobilityReviewModel>();

  loaded = signal(false);

  ngAfterViewInit() {
    setTimeout(() => this.loaded.set(true));
  }

  close(): void {
    this.ref.close();
  }

  async approve(): Promise<void> {
    await this._apiService.approveMobilityReview(this.mobilityReview().id ?? 0)
    this.ref.close(true);
  }

  delete(): void {
    this._confirmationService.confirm({
      message: `Êtes-vous sûr de vouloir supprimer cette mobilité ?`,
      icon: 'pi pi-trash',
      header: 'Suppression',
      rejectLabel: 'Annuler',
      rejectButtonStyleClass: 'p-button-outlined',
      acceptLabel: 'Supprimer',
      acceptButtonStyleClass: 'p-button-danger',
      accept: async () => {
        await this._apiService.deleteMobilityReview(this.mobilityReview().id ?? 0);
        this.ref.close(true);
      }
    })
  }
}
