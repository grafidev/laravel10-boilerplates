import { router } from '@inertiajs/vue3';
import json from 'country-region-data/data.json';

export const slugify = (str, separator = '_') =>
  str
    .toUpperCase()
    .trim()
    .replace(/[^\w\s-]/g, '')
    .replace(/[\s_-]+/g, separator)
    .replace(/^-+|-+$/g, '')

export const openImageDialog = (url, width, height) => {
  const left = (window.screen.width - width) / 2;
  const top = (window.screen.height - height) / 2;
  const options = `width=${width},height=${height},top=${top},left=${left},resizable=yes`;

  const dialog = window.open('', '_blank', options);

  const iframe = dialog.document.createElement('iframe');
  iframe.style.width = '100%';
  iframe.style.height = '100%';
  iframe.src = url;

  dialog.document.body.appendChild(iframe);
}

export const changePerPage = (perpage, url) => {
  router.get(url, { perpage }, {
    preserveState: true,
    onSuccess: () => router.visit(url),
  });
};

export const exportData = (url, options = {}) => {
  const newUrl = new URL(url);
  options.data.forEach(id => {
    newUrl.searchParams.append(options.param + '[]', id);
  });
  window.location = newUrl;
}


export const getCurrencies = () => {
  const currencies = [];
  const currencyCodes = Intl.supportedValuesOf("currency");
  
  for (const code of currencyCodes) {
    currencies.push({
      label: new Intl.DisplayNames(['fr'], { type: 'currency' }).of(code).toUpperCase(),
      value: code,
    });
  }

  return currencies;
}

export const formatNumber = (input) => {
  const first16 = input.substring(0, 16);
  const splitResult = first16.match(/.{1,4}/g);
  return splitResult.join(' ');
}


export const downloadQrCode = (id) => {
  const element = document.getElementById(id);
  const img     = element.querySelector('img');
  const link    = document.createElement('a')
  link.href     = img.src;
  link.setAttribute('download', id);
  document.body.appendChild(link);
  link.click();
};

export const getRegionsFor = (countryCode) => {
  return json.find(item => item.countryShortCode == countryCode).regions;
};

export const parseErrors = errors => {
  return Object.keys(errors).reduce((acc, key) => {
    return {...acc, [key]: errors[key][0] || '' };
  }, {});
};


export const generateRandomDigits = (length = 5) => {
  var digits = "";
  for (var i = 0; i < length; i++) {
    var randomDigit = Math.floor(Math.random() * 10);
    digits += randomDigit;
  }
  return digits;
}

export const isoToEmoji = code => {
  return code
    .split('') 
    .map(letter => letter.charCodeAt(0) % 32 + 0x1F1E5)
    .map(n => String.fromCodePoint(n))
    .join('');
};

export const isImageFile = (url) => {
  return ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp', 'tiff', 'ico'].some(
    extension => url.toLowerCase().endsWith('.' + extension)
  );
}