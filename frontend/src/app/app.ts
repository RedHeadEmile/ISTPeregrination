import {ChangeDetectorRef, Component, inject, OnInit} from '@angular/core';
import {Router, RouterLink, RouterOutlet} from '@angular/router';
import {Toast} from 'primeng/toast';
import {Menu} from 'primeng/menu';
import {Button} from 'primeng/button';
import {ConfirmationService, MenuItem} from 'primeng/api';
import {AuthenticationService} from './core/services/authentication.service';
import {DialogService} from 'primeng/dynamicdialog';
import {ConfirmDialog} from 'primeng/confirmdialog';
import {CountryID} from 'svgmap';

export const allCountryIDs: CountryID[] = ['AF', 'ZA', 'AL', 'DZ', 'DE', 'AD', 'AO', 'AI', 'AQ', 'AG', 'SA', 'AR', 'AM', 'AW', 'AU', 'AT', 'AZ', 'BS', 'BH', 'BD', 'BB', 'BE', 'BZ', 'BJ', 'BM', 'BT', 'BY', 'BO', 'BA', 'BW', 'BR', 'BN', 'BG', 'BF', 'BI', 'KH', 'CM', 'CA', 'CV', 'CL', 'CN', 'CY', 'CO', 'KM', 'CG', 'CD', 'KP', 'KR', 'CR', 'CI', 'HR', 'CU', 'CW', 'DK', 'DJ', 'DM', 'EG', 'AE', 'EC', 'ER', 'ES', 'EE', 'SZ', 'VA', 'FM', 'US', 'ET', 'FJ', 'FI', 'FR', 'GA', 'GM', 'GE', 'GS', 'GH', 'GI', 'GR', 'GD', 'GL', 'GP', 'GU', 'GT', 'GG', 'GN', 'GQ', 'GW', 'GY', 'GF', 'HT', 'HN', 'HU', 'BV', 'CX', 'IM', 'NF', 'AX', 'KY', 'CC', 'CK', 'FO', 'HM', 'FK', 'MP', 'MH', 'UM', 'PN', 'SB', 'TC', 'VG', 'VI', 'IN', 'ID', 'IQ', 'IR', 'IE', 'IS', 'IL', 'IT', 'JM', 'JP', 'JE', 'JO', 'KZ', 'KE', 'KG', 'KI', 'KW', 'RE', 'LA', 'LS', 'LV', 'LB', 'LR', 'LY', 'LI', 'LT', 'LU', 'MK', 'MG', 'MY', 'MW', 'MV', 'ML', 'MT', 'MA', 'MQ', 'MU', 'MR', 'YT', 'MX', 'MD', 'MC', 'MN', 'ME', 'MS', 'MZ', 'MM', 'NA', 'NR', 'NP', 'NI', 'NE', 'NG', 'NU', 'NO', 'NC', 'NZ', 'OM', 'UG', 'UZ', 'PK', 'PW', 'PA', 'PG', 'PY', 'NL', 'BQ', 'PE', 'PH', 'PL', 'PF', 'PR', 'PT', 'QA', 'HK', 'MO', 'CF', 'DO', 'RO', 'GB', 'RU', 'RW', 'EH', 'BL', 'KN', 'SM', 'MF', 'SX', 'PM', 'VC', 'SH', 'LC', 'SV', 'WS', 'AS', 'ST', 'SN', 'RS', 'SC', 'SL', 'SG', 'SK', 'SI', 'SO', 'SD', 'SS', 'LK', 'SE', 'CH', 'SR', 'SJ', 'SY', 'TJ', 'TW', 'TZ', 'TD', 'CZ', 'TF', 'IO', 'PS', 'TH', 'TL', 'TG', 'TK', 'TO', 'TT', 'TN', 'TM', 'TR', 'TV', 'UA', 'UY', 'VU', 'VE', 'VN', 'WF', 'YE', 'ZM', 'ZW'];
export const countryNames: { [ countryID: string ]: string } = {"AF":"Afghanistan","ZA":"Afrique du Sud","AL":"Albanie","DZ":"Alg\u00e9rie","DE":"Allemagne","AD":"Andorre","AO":"Angola","AI":"Anguilla","AQ":"Antarctique","AG":"Antigua-et-Barbuda","SA":"Arabie saoudite","AR":"Argentine","AM":"Arm\u00e9nie","AW":"Aruba","AU":"Australie","AT":"Autriche","AZ":"Azerba\u00efdjan","BS":"Bahamas","BH":"Bahre\u00efn","BD":"Bangladesh","BB":"Barbade","BE":"Belgique","BZ":"Belize","BJ":"B\u00e9nin","BM":"Bermudes","BT":"Bhoutan","BY":"Bi\u00e9lorussie","BO":"Bolivie","BA":"Bosnie-Herz\u00e9govine","BW":"Botswana","BR":"Br\u00e9sil","BN":"Brun\u00e9i Darussalam","BG":"Bulgarie","BF":"Burkina Faso","BI":"Burundi","KH":"Cambodge","CM":"Cameroun","CA":"Canada","CV":"Cap-Vert","CL":"Chili","CN":"Chine","CY":"Chypre","CO":"Colombie","KM":"Comores","CG":"Congo-Brazzaville","CD":"Congo-Kinshasa","KP":"Cor\u00e9e du Nord","KR":"Cor\u00e9e du Sud","CR":"Costa Rica","CI":"C\u00f4te d\u2019Ivoire","HR":"Croatie","CU":"Cuba","CW":"Cura\u00e7ao","DK":"Danemark","DJ":"Djibouti","DM":"Dominique","EG":"\u00c9gypte","AE":"\u00c9mirats arabes unis","EC":"\u00c9quateur","ER":"\u00c9rythr\u00e9e","ES":"Espagne","EE":"Estonie","SZ":"Eswatini","VA":"\u00c9tat de la Cit\u00e9 du Vatican","FM":"\u00c9tats f\u00e9d\u00e9r\u00e9s de Micron\u00e9sie","US":"\u00c9tats-Unis","ET":"\u00c9thiopie","FJ":"Fidji","FI":"Finlande","FR":"France","GA":"Gabon","GM":"Gambie","GE":"G\u00e9orgie","GS":"G\u00e9orgie du Sud et \u00eeles Sandwich du Sud","GH":"Ghana","GI":"Gibraltar","GR":"Gr\u00e8ce","GD":"Grenade","GL":"Groenland","GP":"Guadeloupe","GU":"Guam","GT":"Guatemala","GG":"Guernesey","GN":"Guin\u00e9e","GQ":"Guin\u00e9e \u00e9quatoriale","GW":"Guin\u00e9e-Bissau","GY":"Guyana","GF":"Guyane fran\u00e7aise","HT":"Ha\u00efti","HN":"Honduras","HU":"Hongrie","BV":"\u00cele Bouvet","CX":"\u00cele Christmas","IM":"\u00cele de Man","NF":"\u00cele Norfolk","AX":"\u00celes \u00c5land","KY":"\u00celes Ca\u00efmans","CC":"\u00celes Cocos","CK":"\u00celes Cook","FO":"\u00celes F\u00e9ro\u00e9","HM":"\u00celes Heard et McDonald","FK":"\u00celes Malouines","MP":"\u00celes Mariannes du Nord","MH":"\u00celes Marshall","UM":"\u00celes mineures \u00e9loign\u00e9es des \u00c9tats-Unis","PN":"\u00celes Pitcairn","SB":"\u00celes Salomon","TC":"\u00celes Turques-et-Ca\u00efques","VG":"\u00celes Vierges britanniques","VI":"\u00celes Vierges des \u00c9tats-Unis","IN":"Inde","ID":"Indon\u00e9sie","IQ":"Irak","IR":"Iran","IE":"Irlande","IS":"Islande","IL":"Isra\u00ebl","IT":"Italie","JM":"Jama\u00efque","JP":"Japon","JE":"Jersey","JO":"Jordanie","KZ":"Kazakhstan","KE":"Kenya","KG":"Kirghizistan","KI":"Kiribati","KW":"Kowe\u00eft","RE":"La R\u00e9union","LA":"Laos","LS":"Lesotho","LV":"Lettonie","LB":"Liban","LR":"Lib\u00e9ria","LY":"Libye","LI":"Liechtenstein","LT":"Lituanie","LU":"Luxembourg","MK":"Mac\u00e9doine du Nord","MG":"Madagascar","MY":"Malaisie","MW":"Malawi","MV":"Maldives","ML":"Mali","MT":"Malte","MA":"Maroc","MQ":"Martinique","MU":"Maurice","MR":"Mauritanie","YT":"Mayotte","MX":"Mexique","MD":"Moldavie","MC":"Monaco","MN":"Mongolie","ME":"Mont\u00e9n\u00e9gro","MS":"Montserrat","MZ":"Mozambique","MM":"Myanmar (Birmanie)","NA":"Namibie","NR":"Nauru","NP":"N\u00e9pal","NI":"Nicaragua","NE":"Niger","NG":"Nig\u00e9ria","NU":"Niue","NO":"Norv\u00e8ge","NC":"Nouvelle-Cal\u00e9donie","NZ":"Nouvelle-Z\u00e9lande","OM":"Oman","UG":"Ouganda","UZ":"Ouzb\u00e9kistan","PK":"Pakistan","PW":"Palaos","PA":"Panama","PG":"Papouasie-Nouvelle-Guin\u00e9e","PY":"Paraguay","NL":"Pays-Bas","BQ":"Pays-Bas carib\u00e9ens","PE":"P\u00e9rou","PH":"Philippines","PL":"Pologne","PF":"Polyn\u00e9sie fran\u00e7aise","PR":"Porto Rico","PT":"Portugal","QA":"Qatar","HK":"R.A.S. chinoise de Hong Kong","MO":"R.A.S. chinoise de Macao","CF":"R\u00e9publique centrafricaine","DO":"R\u00e9publique dominicaine","RO":"Roumanie","GB":"Royaume-Uni","RU":"Russie","RW":"Rwanda","EH":"Sahara occidental","BL":"Saint-Barth\u00e9lemy","KN":"Saint-Christophe-et-Ni\u00e9v\u00e8s","SM":"Saint-Marin","MF":"Saint-Martin","SX":"Saint-Martin (partie n\u00e9erlandaise)","PM":"Saint-Pierre-et-Miquelon","VC":"Saint-Vincent-et-les-Grenadines","SH":"Sainte-H\u00e9l\u00e8ne","LC":"Sainte-Lucie","SV":"Salvador","WS":"Samoa","AS":"Samoa am\u00e9ricaines","ST":"Sao Tom\u00e9-et-Principe","SN":"S\u00e9n\u00e9gal","RS":"Serbie","SC":"Seychelles","SL":"Sierra Leone","SG":"Singapour","SK":"Slovaquie","SI":"Slov\u00e9nie","SO":"Somalie","SD":"Soudan","SS":"Soudan du Sud","LK":"Sri Lanka","SE":"Su\u00e8de","CH":"Suisse","SR":"Suriname","SJ":"Svalbard et Jan Mayen","SY":"Syrie","TJ":"Tadjikistan","TW":"Ta\u00efwan","TZ":"Tanzanie","TD":"Tchad","CZ":"Tch\u00e9quie","TF":"Terres australes fran\u00e7aises","IO":"Territoire britannique de l\u2019oc\u00e9an Indien","PS":"Territoires palestiniens","TH":"Tha\u00eflande","TL":"Timor oriental","TG":"Togo","TK":"Tokelau","TO":"Tonga","TT":"Trinit\u00e9-et-Tobago","TN":"Tunisie","TM":"Turkm\u00e9nistan","TR":"Turquie","TV":"Tuvalu","UA":"Ukraine","UY":"Uruguay","VU":"Vanuatu","VE":"Venezuela","VN":"Vietnam","WF":"Wallis-et-Futuna","YE":"Y\u00e9men","ZM":"Zambie","ZW":"Zimbabwe"};
export const emojiFlags: { [countryId: string]: string } = {
  AF: '🇦🇫', AX: '🇦🇽', AL: '🇦🇱', DZ: '🇩🇿', AS: '🇦🇸', AD: '🇦🇩', AO: '🇦🇴', AI: '🇦🇮', AQ: '🇦🇶', AG: '🇦🇬', AR: '🇦🇷', AM: '🇦🇲', AW: '🇦🇼', AU: '🇦🇺', AT: '🇦🇹', AZ: '🇦🇿', BS: '🇧🇸', BH: '🇧🇭', BD: '🇧🇩', BB: '🇧🇧', BY: '🇧🇾', BE: '🇧🇪', BZ: '🇧🇿', BJ: '🇧🇯', BM: '🇧🇲', BT: '🇧🇹', BO: '🇧🇴', BA: '🇧🇦', BW: '🇧🇼', BR: '🇧🇷', IO: '🇮🇴', VG: '🇻🇬', BN: '🇧🇳', BG: '🇧🇬', BF: '🇧🇫', BI: '🇧🇮', KH: '🇰🇭', CM: '🇨🇲', CA: '🇨🇦', CV: '🇨🇻', BQ: '🇧🇶', KY: '🇰🇾', CF: '🇨🇫', TD: '🇹🇩', CL: '🇨🇱', CN: '🇨🇳', CX: '🇨🇽', CC: '🇨🇨', CO: '🇨🇴', KM: '🇰🇲', CG: '🇨🇬', CK: '🇨🇰', CR: '🇨🇷', HR: '🇭🇷', CU: '🇨🇺', CW: '🇨🇼', CY: '🇨🇾', CZ: '🇨🇿', CD: '🇨🇩', DK: '🇩🇰', DJ: '🇩🇯', DM: '🇩🇲', DO: '🇩🇴', EC: '🇪🇨', EG: '🇪🇬', SV: '🇸🇻', GQ: '🇬🇶', ER: '🇪🇷', EE: '🇪🇪', ET: '🇪🇹', FK: '🇫🇰', FO: '🇫🇴', FM: '🇫🇲', FJ: '🇫🇯', FI: '🇫🇮', FR: '🇫🇷', GF: '🇬🇫', PF: '🇵🇫', TF: '🇹🇫', GA: '🇬🇦', GM: '🇬🇲', GE: '🇬🇪', DE: '🇩🇪', GH: '🇬🇭', GI: '🇬🇮', GR: '🇬🇷', GL: '🇬🇱', GD: '🇬🇩', GP: '🇬🇵', GU: '🇬🇺', GT: '🇬🇹', GN: '🇬🇳', GW: '🇬🇼', GY: '🇬🇾', HT: '🇭🇹', HN: '🇭🇳', HK: '🇭🇰', HU: '🇭🇺', IS: '🇮🇸', IN: '🇮🇳', ID: '🇮🇩', IR: '🇮🇷', IQ: '🇮🇶', IE: '🇮🇪', IM: '🇮🇲', IL: '🇮🇱', IT: '🇮🇹', CI: '🇨🇮', JM: '🇯🇲', JP: '🇯🇵', JE: '🇯🇪', JO: '🇯🇴', KZ: '🇰🇿', KE: '🇰🇪', KI: '🇰🇮', XK: '🇽🇰', KW: '🇰🇼', KG: '🇰🇬', LA: '🇱🇦', LV: '🇱🇻', LB: '🇱🇧', LS: '🇱🇸', LR: '🇱🇷', LY: '🇱🇾', LI: '🇱🇮', LT: '🇱🇹', LU: '🇱🇺', MO: '🇲🇴', MK: '🇲🇰', MG: '🇲🇬', MW: '🇲🇼', MY: '🇲🇾', MV: '🇲🇻', ML: '🇲🇱', MT: '🇲🇹', MH: '🇲🇭', MQ: '🇲🇶', MR: '🇲🇷', MU: '🇲🇺', YT: '🇾🇹', MX: '🇲🇽', MD: '🇲🇩', MC: '🇲🇨', MN: '🇲🇳', ME: '🇲🇪', MS: '🇲🇸', MA: '🇲🇦', MZ: '🇲🇿', MM: '🇲🇲', NA: '🇳🇦', NR: '🇳🇷', NP: '🇳🇵', NL: '🇳🇱', NC: '🇳🇨', NZ: '🇳🇿', NI: '🇳🇮', NE: '🇳🇪', NG: '🇳🇬', NU: '🇳🇺', NF: '🇳🇫', KP: '🇰🇵', MP: '🇲🇵', NO: '🇳🇴', OM: '🇴🇲', PK: '🇵🇰', PW: '🇵🇼', PS: '🇵🇸', PA: '🇵🇦', PG: '🇵🇬', PY: '🇵🇾', PE: '🇵🇪', PH: '🇵🇭', PN: '🇵🇳', PL: '🇵🇱', PT: '🇵🇹', PR: '🇵🇷', QA: '🇶🇦', RE: '🇷🇪', RO: '🇷🇴', RU: '🇷🇺', RW: '🇷🇼', SH: '🇸🇭', KN: '🇰🇳', LC: '🇱🇨', PM: '🇵🇲', VC: '🇻🇨', WS: '🇼🇸', SM: '🇸🇲', ST: '🇸🇹', SA: '🇸🇦', SN: '🇸🇳', RS: '🇷🇸', SC: '🇸🇨', SL: '🇸🇱', SG: '🇸🇬', SX: '🇸🇽', SK: '🇸🇰', SI: '🇸🇮', SB: '🇸🇧', SO: '🇸🇴', ZA: '🇿🇦', GS: '🇬🇸', KR: '🇰🇷', SS: '🇸🇸', ES: '🇪🇸', LK: '🇱🇰', SD: '🇸🇩', SR: '🇸🇷', SJ: '🇸🇯', SZ: '🇸🇿', SE: '🇸🇪', CH: '🇨🇭', SY: '🇸🇾', TW: '🇹🇼', TJ: '🇹🇯', TZ: '🇹🇿', TH: '🇹🇭', TL: '🇹🇱', TG: '🇹🇬', TK: '🇹🇰', TO: '🇹🇴', TT: '🇹🇹', TN: '🇹🇳', TR: '🇹🇷', TM: '🇹🇲', TC: '🇹🇨', TV: '🇹🇻', UG: '🇺🇬', UA: '🇺🇦', AE: '🇦🇪', GB: '🇬🇧', US: '🇺🇸', UM: '🇺🇲', VI: '🇻🇮', UY: '🇺🇾', UZ: '🇺🇿', VU: '🇻🇺', VA: '🇻🇦', VE: '🇻🇪', VN: '🇻🇳', WF: '🇼🇫', EH: '🇪🇭', YE: '🇾🇪', ZM: '🇿🇲', ZW: '🇿🇼'
};

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, Toast, RouterLink, Menu, Button, ConfirmDialog],
  templateUrl: './app.html',
  styleUrl: './app.less',
  providers: [DialogService, ConfirmationService]
})
export class App implements OnInit {
  private readonly _authenticationService = inject(AuthenticationService);
  private readonly _changeDetectorRef = inject(ChangeDetectorRef);
  private readonly _router = inject(Router);

  static countryNames: Record<string, string> = {};
  static {
    allCountryIDs.forEach(countryID => {
      App.countryNames[countryID] = (emojiFlags[countryID] ?? '') + ' ' + countryNames[countryID];
    });
  }

  menuItems: MenuItem[] = [
    {
      label: 'Gestion des mobilités',
      icon: 'pi pi-car',
      routerLink: '/admin/mobility-reviews'
    },
    {
      label: 'Gestion des utilisateurs',
      icon: 'pi pi-user',
      routerLink: '/admin/users'
    },
    {
      label: 'Déconnexion',
      icon: 'pi pi-sign-out',
      command: async () => {
        await this._authenticationService.logout();
        await this._router.navigate(['/']);
        this._changeDetectorRef.detectChanges();
      }
    }
  ];

  async ngOnInit(): Promise<void> {
    if (!this._authenticationService.isCurrentUserInitialized())
      await this._authenticationService.pullCurrentUser();
    this._changeDetectorRef.detectChanges();
  }

  get isAuthenticated(): boolean {
    return !!this._authenticationService.getCurrentUser();
  }
}
