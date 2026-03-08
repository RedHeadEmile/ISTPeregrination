import {Component, EventEmitter, input, model, Output} from '@angular/core';
import {MobilityReviewModel} from '../../core/models/mobility-review.model';
import {FormsModule} from '@angular/forms';
import {InputText} from 'primeng/inputtext';
import {RadioButton} from 'primeng/radiobutton';
import {Select} from 'primeng/select';
import {Checkbox} from 'primeng/checkbox';
import {ButtonDirective} from 'primeng/button';
import {Textarea} from 'primeng/textarea';
import {allCountryIDs, countryNames, emojiFlags} from '../../app';

@Component({
  selector: 'app-mobility-review-form',
  imports: [
    FormsModule,
    InputText,
    RadioButton,
    Select,
    Checkbox,
    ButtonDirective,
    Textarea
  ],
  templateUrl: './mobility-review-form.html',
  styleUrl: './mobility-review-form.less',
})
export class MobilityReviewForm {
  mobilityReview = model.required<Partial<MobilityReviewModel>>();
  submitLabel = input<string>('Ajouter ma mobilité');
  readonly = input<boolean>(false);

  @Output() onFormSubmit = new EventEmitter<void>();

  static countries: { name: string, code: string }[] = allCountryIDs.map(countryID => ({ name: (emojiFlags[countryID] ?? '') + ' ' + countryNames[countryID], code: countryID }));

  get countries(): { name: string, code: string }[] {
    return MobilityReviewForm.countries;
  }

  submit(): void {
    this.onFormSubmit.emit();
  }
}
