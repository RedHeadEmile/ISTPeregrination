import { Routes } from '@angular/router';
import {HomePageComponent} from './home/home-page.component';
import {NotFoundPageComponent} from './not-found/not-found-page.component';
import {AdminPageContainerComponent} from './admin-page-container/admin-page-container.component';
import {UserLoginPageComponent} from './user-login/user-login-page.component';
import {MobilityReviewSubmitPageComponent} from './mobility-review-submit/mobility-review-submit-page.component';
import {AdminUserListPageComponent} from './admin-user-list-page/admin-user-list-page.component';
import {
  AdminMobilityReviewListPageComponent
} from './admin-mobility-review-list-page/admin-mobility-review-list-page.component';
import {UserResetPasswordPageComponent} from './user-reset-password/user-reset-password-page.component';
import {authenticationGuard} from './core/guards/authentication.guard';

export const routes: Routes = [
  {
    path: '',
    component: HomePageComponent,
    title: 'ISTPeregrination - Accueil'
  },
  {
    path: 'admin',
    component: AdminPageContainerComponent,
    children: [
      {
        path: '',
        redirectTo: 'users',
        pathMatch: 'full'
      },
      {
        path: 'users',
        component: AdminUserListPageComponent,
        title: 'ISTPeregrination - Utilisateurs',
        canActivate: [authenticationGuard],
      },
      {
        path: 'mobility-reviews',
        component: AdminMobilityReviewListPageComponent,
        title: 'ISTPeregrination - Mobilités',
        canActivate: [authenticationGuard],
      }
    ]
  },
  {
    path: 'login',
    component: UserLoginPageComponent,
    title: 'ISTPeregration - Connexion'
  },
  {
    path: 'reset-password',
    component: UserResetPasswordPageComponent,
    title: 'ISTPeregration - Réinitialisation du mot de passe'
  },
  {
    path: 'submit-mobility-review',
    component: MobilityReviewSubmitPageComponent,
    title: 'ISTPeregration - Retour sur mobilité'
  },
  {
    path: '**',
    component: NotFoundPageComponent,
    title: 'ISTPeregration - Error 404'
  }
];
