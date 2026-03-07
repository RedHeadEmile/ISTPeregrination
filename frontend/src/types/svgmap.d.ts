declare module 'svgmap' {
  export type CountryID = 'AF' | 'ZA' | 'AL' | 'DZ' | 'DE' | 'AD' | 'AO' | 'AI' | 'AQ' | 'AG' | 'SA' | 'AR' | 'AM' | 'AW' | 'AU' | 'AT' | 'AZ' | 'BS' | 'BH' | 'BD' | 'BB' | 'BE' | 'BZ' | 'BJ' | 'BM' | 'BT' | 'BY' | 'BO' | 'BA' | 'BW' | 'BR' | 'BN' | 'BG' | 'BF' | 'BI' | 'KH' | 'CM' | 'CA' | 'CV' | 'CL' | 'CN' | 'CY' | 'CO' | 'KM' | 'CG' | 'CD' | 'KP' | 'KR' | 'CR' | 'CI' | 'HR' | 'CU' | 'CW' | 'DK' | 'DJ' | 'DM' | 'EG' | 'AE' | 'EC' | 'ER' | 'ES' | 'EE' | 'SZ' | 'VA' | 'FM' | 'US' | 'ET' | 'FJ' | 'FI' | 'FR' | 'GA' | 'GM' | 'GE' | 'GS' | 'GH' | 'GI' | 'GR' | 'GD' | 'GL' | 'GP' | 'GU' | 'GT' | 'GG' | 'GN' | 'GQ' | 'GW' | 'GY' | 'GF' | 'HT' | 'HN' | 'HU' | 'BV' | 'CX' | 'IM' | 'NF' | 'AX' | 'KY' | 'CC' | 'CK' | 'FO' | 'HM' | 'FK' | 'MP' | 'MH' | 'UM' | 'PN' | 'SB' | 'TC' | 'VG' | 'VI' | 'IN' | 'ID' | 'IQ' | 'IR' | 'IE' | 'IS' | 'IL' | 'IT' | 'JM' | 'JP' | 'JE' | 'JO' | 'KZ' | 'KE' | 'KG' | 'KI' | 'KW' | 'RE' | 'LA' | 'LS' | 'LV' | 'LB' | 'LR' | 'LY' | 'LI' | 'LT' | 'LU' | 'MK' | 'MG' | 'MY' | 'MW' | 'MV' | 'ML' | 'MT' | 'MA' | 'MQ' | 'MU' | 'MR' | 'YT' | 'MX' | 'MD' | 'MC' | 'MN' | 'ME' | 'MS' | 'MZ' | 'MM' | 'NA' | 'NR' | 'NP' | 'NI' | 'NE' | 'NG' | 'NU' | 'NO' | 'NC' | 'NZ' | 'OM' | 'UG' | 'UZ' | 'PK' | 'PW' | 'PA' | 'PG' | 'PY' | 'NL' | 'BQ' | 'PE' | 'PH' | 'PL' | 'PF' | 'PR' | 'PT' | 'QA' | 'HK' | 'MO' | 'CF' | 'DO' | 'RO' | 'GB' | 'RU' | 'RW' | 'EH' | 'BL' | 'KN' | 'SM' | 'MF' | 'SX' | 'PM' | 'VC' | 'SH' | 'LC' | 'SV' | 'WS' | 'AS' | 'ST' | 'SN' | 'RS' | 'SC' | 'SL' | 'SG' | 'SK' | 'SI' | 'SO' | 'SD' | 'SS' | 'LK' | 'SE' | 'CH' | 'SR' | 'SJ' | 'SY' | 'TJ' | 'TW' | 'TZ' | 'TD' | 'CZ' | 'TF' | 'IO' | 'PS' | 'TH' | 'TL' | 'TG' | 'TK' | 'TO' | 'TT' | 'TN' | 'TM' | 'TR' | 'TV' | 'UA' | 'UY' | 'VU' | 'VE' | 'VN' | 'WF' | 'YE' | 'ZM' | 'ZW';

  export interface SvgMapOptionsChartData {
    data: { [dataID: string]: {
        name: string;
        format: string;
        thousandSeparator?: string;
        thresholdMax?: number;
        thresholdMin?: number;
      }};
    applyData: string;
    values: { [countryID: CountryID]: {
        color?: string;
        link?: string;
        linkTarget?: string;
      } & { [dataID: string]: number} };
  }

  export interface SvgMapOptions {
    targetElementID: string;
    allowInteraction?: boolean;
    minZoom?: number;
    maxZoom?: number;
    initialZoom?: number;
    initialPan?: { x: number, y: number };
    showContinentSelector?: boolean;
    zoomScaleSensitivity?: number;
    showZoomReset?: boolean;
    resetZoomOnResize?: boolean;
    zoomButtonsPosition?: string;
    mouseWheelZoomEnabled?: boolean;
    mouseWheelZoomWithKey?: boolean;
    mouseWheelKeyMessage?: string;
    mouseWheelKeyMessageMac?: string;
    colorMax?: string;
    colorMin?: string;
    colorNoData?: string;
    flagType?: 'image' | 'emoji';
    ratioType?: 'linear' | 'log' | ((value: number, min: number, max: number) => number);
    flagURL?: string;
    hideFlag?: boolean;
    noDataText?: string;
    touchLink?: boolean;
    onGetTooltip?: (tooltipDiv: HTMLDivElement, countryID: string, countryValues: number[]) => string;
    countries?: { [countryID: CountryID]: any };
    data: SvgMapOptionsChartData;
    countryNames?: { [countryID: CountryID]: string };
  }

  export default class svgMap {
    constructor(options: SvgMapOptions);
  }
}
