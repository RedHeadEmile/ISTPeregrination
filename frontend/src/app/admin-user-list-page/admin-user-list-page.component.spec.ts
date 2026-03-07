import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminUserListPageComponent } from './admin-user-list-page.component';

describe('AdminUserListPage', () => {
  let component: AdminUserListPageComponent;
  let fixture: ComponentFixture<AdminUserListPageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [AdminUserListPageComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AdminUserListPageComponent);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
