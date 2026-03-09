import {AfterViewInit, ChangeDetectorRef, Component, ElementRef, HostListener, inject, viewChild} from '@angular/core';
import svgMap from 'svgmap';
import {ApiService} from '../core/services/api.service';
import {MobilityReviewModel} from '../core/models/mobility-review.model';
import {DrawerModule} from 'primeng/drawer';
import {allCountryIDs, App, countryNames} from '../app';
import {ButtonDirective} from 'primeng/button';
import {TableModule} from 'primeng/table';
import {HomeMobilityReviewSeeComponent} from './home-mobility-review-see/home-mobility-review-see.component';
import {DialogService} from 'primeng/dynamicdialog';

@Component({
  selector: 'app-home',
  imports: [
    DrawerModule,
    ButtonDirective,
    TableModule
  ],
  templateUrl: './home-page.component.html',
  styleUrl: './home-page.component.less',
})
export class HomePageComponent implements AfterViewInit {
  private readonly _apiService = inject(ApiService);
  private readonly _dialogService = inject(DialogService);
  private readonly _cdr = inject(ChangeDetectorRef);

  mapContainer = viewChild<ElementRef<HTMLDivElement>>('theWorld');

  drawerVisible: boolean = false;
  drawerHeader: string = "";
  mobilityReviewsToShow: MobilityReviewModel[] = [];

  private _map?: svgMap;
  private _mobilityReviews: { [countryID: string]: MobilityReviewModel[]} = {};

  async ngAfterViewInit(): Promise<void> {
    allCountryIDs.forEach(countryID => this._mobilityReviews[countryID] = []);
    (await this._apiService.getMobilityReviews()).forEach(mobilityReview =>
      this._mobilityReviews[mobilityReview.countryCode].push(mobilityReview)
    );

    const targetElementId = this.mapContainer()?.nativeElement.id;
    if (!targetElementId)
      throw new Error('Map container element not found');

    const mobilityData: { [countryID: string]: { mobility: number } } = {};
    allCountryIDs
      .filter(countryID => this._mobilityReviews[countryID].length > 0)
      .forEach(countryID => mobilityData[countryID] = { mobility: this._mobilityReviews[countryID].length });

    this._map = new svgMap({
      targetElementID: targetElementId,
      allowInteraction: true,
      flagType: 'emoji',
      initialZoom: 1,
      data: {
        data: {
          mobility: {
            name: 'Nombre de mobilités',
            format: '{0}',
          }
        },
        applyData: 'mobility',
        values: mobilityData
      },
      colorMin: "#d0ffc9",
      colorMax: "#15591e",
      countryNames: countryNames,
      noDataText: "Aucune mobilité n'a été effectuée dans ce pays pour le moment"
    });

    allCountryIDs.forEach(countryId => {
      document.getElementById(targetElementId + '-map-country-' + countryId)?.addEventListener('pointerdown', () => {
        this.mobilityReviewsToShow = this._mobilityReviews[countryId];
        if (this.mobilityReviewsToShow.length > 0) {
          this.drawerHeader = App.countryNames[countryId] ?? countryId;
          this.drawerVisible = true;
          this._cdr.detectChanges();
        }
      });
    });
  }

  see(mobilityReview: MobilityReviewModel): void {
    this._dialogService.open(
      HomeMobilityReviewSeeComponent,
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
    );
  }

  @HostListener('window:resize')
  onResize() {
    (this._map as any)['mapPanZoom'].resize();
    (this._map as any)['mapPanZoom'].fit();
    (this._map as any)['mapPanZoom'].center();
  }
}
