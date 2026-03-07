import { ComponentFixture, TestBed } from '@angular/core/testing';

import { UserResetPasswordPageComponent } from './user-reset-password-page.component';

describe('UserResetPasswordPage', () => {
  let component: UserResetPasswordPageComponent;
  let fixture: ComponentFixture<UserResetPasswordPageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [UserResetPasswordPageComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(UserResetPasswordPageComponent);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
