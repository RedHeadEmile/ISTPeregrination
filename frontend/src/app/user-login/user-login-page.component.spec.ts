import { ComponentFixture, TestBed } from '@angular/core/testing';

import { UserLoginPageComponent } from './user-login-page.component';

describe('UserLoginPage', () => {
  let component: UserLoginPageComponent;
  let fixture: ComponentFixture<UserLoginPageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [UserLoginPageComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(UserLoginPageComponent);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
